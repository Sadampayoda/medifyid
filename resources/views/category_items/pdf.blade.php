<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Kategori {{ $category->nama }}</title>
        <style>
            @page {
                margin: 30px 40px 60px 40px;
            }
            body {
                font-family:
                    DejaVu Sans,
                    sans-serif;
                font-size: 12px;
            }
            h2 {
                text-align: center;
                margin-bottom: 20px;
            }
            .info td {
                padding: 3px 6px;
            }
            table.data {
                width: 100%;
                border-collapse: collapse;
                margin-top: 15px;
            }
            table.data th,
            table.data td {
                border: 1px solid #000;
                padding: 6px;
            }
            table.data th {
                background: #eee;
            }
            footer {
                position: fixed;
                bottom: -40px;
                left: 0;
                right: 0;
                font-size: 10px;
                text-align: right;
            }
        </style>
    </head>
    <body>
        <h2>Detail Kategori</h2>

        <table class="info">
            <tr>
                <td>Nama Kategori</td>
                <td>:</td>
                <td>{{ $category->nama }}</td>
            </tr>
            <tr>
                <td>Kode Kategori</td>
                <td>:</td>
                <td>{{ $category->kode }}</td>
            </tr>
        </table>

        <table class="data">
            <thead>
                <tr>
                    <th style="width: 30px">No</th>
                    <th>Kode</th>
                    <th>Nama Item</th>
                    <th>Supplier</th>
                    <th>Harga Beli</th>
                </tr>
            </thead>
            <tbody>
                @forelse($category->items as $i => $item)
                <tr>
                    <td style="text-align: center">{{ $i + 1 }}</td>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->supplier }}</td>
                    <td style="text-align: right">
                        {{ number_format($item->harga_beli, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center">
                        Belum ada item
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <footer>Dicetak pada: {{ $printedAt }}</footer>
    </body>
</html>
