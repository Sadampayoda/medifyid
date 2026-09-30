<?php

namespace App\Http\Controllers;

use App\Contracts\ImageServiceInterface;
use App\Models\CategoryItem;
use App\Models\MasterItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterItemsController extends Controller
{
    public function __construct(
        private ImageServiceInterface $imageService,
    ) {}

    public function index()
    {
        return view('master_items.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;
        $hargamin = $request->hargamin;
        $hargamax = $request->hargamax;

        $data_search = MasterItem::query();

        if (! empty($kode)) {
            $data_search = $data_search->where('kode', $kode);
        }
        if (! empty($nama)) {
            $data_search = $data_search->where('nama', 'LIKE', '%'.$nama.'%');
        }
        $data_search = $data_search
            ->when($request->filled('hargamin'), function ($q) use ($request) {
                $q->where('harga_beli', '>=', $request->hargamin);
            })
            ->when($request->filled('hargamax'), function ($q) use ($request) {
                $q->where('harga_beli', '<=', $request->hargamax);
            });

        $data_search = $data_search->select('kode', 'nama', 'jenis', 'harga_beli', 'laba', 'supplier')->orderBy('id')->get();

        return json_encode([
            'status' => 200,
            'data' => $data_search,
        ]);
    }

    public function formView($method, $id = 0)
    {
        $item = $method == 'new'
    ? new MasterItem
    : MasterItem::with('categories')->findOrFail($id);
        $data['item'] = $item;
        $data['method'] = $method;
        $data['categories'] = CategoryItem::orderBy('name')->get();

        return view('master_items.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = MasterItem::where('kode', $kode)->first();

        return view('master_items.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {

        DB::transaction(function () use ($request, $method, $id) {
            if ($method == 'new') {
                $data_item = new MasterItem;
                $kode = MasterItem::count('id');
                $kode = $kode + 1;
                $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
                sleep(3);
            } else {
                $data_item = MasterItem::find($id);
                $kode = $data_item->kode;
            }

            $data_item->image = $this->imageService->upload(
                $request->file('image'),
                'items',
                $data_item->image
            );

            $data_item->nama = $request->nama;
            $data_item->harga_beli = $request->harga_beli;
            $data_item->laba = $request->laba;
            $data_item->kode = $kode;
            $data_item->supplier = $request->supplier;
            $data_item->jenis = $request->jenis;

            $data_item->save();

            $data_item->categories()->sync($request->categories ?? []);
        });

        return redirect('master-items');
    }

    public function delete($id)
    {
        MasterItem::find($id)->delete();

        return redirect('master-items');
    }

    public function updateRandomData()
    {
        $data = MasterItem::get();
        foreach ($data as $item) {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            $item->harga_beli = rand(100, 1000000);
            $item->laba = rand(10, 99);
            $item->kode = $kode;
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();
            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        $array = ['Tokopaedi', 'Bukulapuk', 'TokoBagas', 'E Commurz', 'Blublu'];
        $random = rand(0, 4);

        return $array[$random];
    }

    private function getRandomJenis()
    {
        $array = ['Obat', 'Alkes', 'Matkes', 'Umum', 'ATK'];
        $random = rand(0, 4);

        return $array[$random];
    }

    public function export()
    {
        $items = MasterItem::with('categories')->orderBy('nama')->get();

        $html = view('master_items.export', compact('items'))->render();

        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="master-items.xlsx"',
        ]);
    }
}
