<?php

namespace App\Http\Controllers;

use App\Contracts\CategoryItemServiceInterface;
use App\Http\Requests\CreateCategoryItemRequest;
use App\Models\CategoryItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryItemController extends Controller
{
    public function __construct(
        private CategoryItemServiceInterface $categoryItemService
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('category_items.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;
        $hargamin = $request->hargamin;
        $hargamax = $request->hargamax;

        $data_search = CategoryItem::query();

        if (! empty($kode)) {
            $data_search = $data_search->where('code', $kode);
        }
        if (! empty($nama)) {
            $data_search = $data_search->where('name', 'LIKE', '%'.$nama.'%');
        }

        $data_search = $data_search->select('id', 'code', 'name')->orderBy('id')->get();

        return json_encode([
            'status' => 200,
            'data' => $data_search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($method = 'new', $id = 0)
    {
        $data['item'] = [];
        $data['method'] = $method;

        return view('category_items.form.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(CreateCategoryItemRequest $request)
    {
        $this->categoryItemService->store($request->validated());

        return redirect()->route('category-items.index');
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show(int $id)
    {
        $data['data'] = $this->categoryItemService->findById($id);

        return view('category_items.single.index', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(int $id)
    {
        $data['item'] = $this->categoryItemService->findById($id);
        $data['method'] = 'edit';

        return view('category_items.form.index', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(CreateCategoryItemRequest $request, int $id)
    {
        $this->categoryItemService->update($id, $request->validated());

        return redirect()->route('category-items.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(int $id)
    {
        $this->categoryItemService->delete($id);

        return redirect()->route('category-items.index');
    }

    public function print($id)
    {
        $category = CategoryItem::with('items')->findOrFail($id);

        $pdf = Pdf::loadView('category_items.pdf', [
            'category' => $category,
            'printedAt' => now()->timezone('Asia/Jakarta')->format('d-m-Y H:i:s'),
        ])->setPaper('a4', 'portrait');

        // download langsung
        return $pdf->download('kategori-'.$category->kode.'.pdf');
    }
}
