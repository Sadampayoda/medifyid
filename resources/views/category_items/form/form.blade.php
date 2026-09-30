<form method="POST" action="{{ $method === 'edit' ? route('category-items.update', $item->id) : route('category-items.store') }}" enctype="multipart/form-data">
    @csrf
    @if($method === 'edit')
    @method('PUT')
    <div class="form-group">
        <label>Kode Kategori</label>
        <input type="text" class="form-control" name="code" readonly value="{{$item->code ?? ''}}">
    </div>
    @endif

    <div class="form-group">
        <label>Nama Kategori</label>
        <input type="text" class="form-control" name="name" required  value="{{$item->name ?? ''}}">
    </div>

    <button class="btn btn-primary mt-3">Submit</button>

</form>