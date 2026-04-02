<!DOCTYPE html>
<html>
<head>
    <title>Daftar Produk</title>
</head>
<body>
    <h2>Daftar Produk</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Harga</th>
        </tr>
        @foreach($data as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item['nama'] }}</td>
            <td>{{ $item['harga'] }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>