@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{url('category-items')}}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>
            </div>
            <div class="card">
                <div class="card-header">Kategori</div>

                <div class="card-body">
                    <table>
                        <tr>
                            <th>Kode</th>
                            <td>:</td>
                            <td>{{$data->code}}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>:</td>
                            <td>{{$data->name}}</td>
                        </tr>
                    </table>
                    <a class="btn btn-info" href="{{ url('category-items/' . $data->id . '/edit') }}">Edit</a>

                    <form action="{{ url('category-items/' . $data->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Are you sure you want to delete this item?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <a class="btn btn-success" href="{{ route('category-items.print', $data->id) }}">Print</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
@endsection