<html>
<head><meta charset="utf-8"></head>
<body>
<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kategori</th>
            <th>Nama Items</th>
            <th>Nama Supplier</th>
            <th>Harga</th>
            <th>Laba</th>
            <th>Harga Jual</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->categories->pluck('nama')->implode(', ') }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->supplier }}</td>
                <td>{{ $item->harga_beli }}</td>
                <td>{{ $item->laba }}%</td>
                <td>{{ round($item->harga_beli + ($item->harga_beli * $item->laba / 100)) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>