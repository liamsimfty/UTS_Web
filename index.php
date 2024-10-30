<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        a {
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
        }
        a:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .actions a {
            margin: 0 5px;
        }
        .discount-btn {
            background-color: #ff9900;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .discount-btn:hover {
            background-color: #e68a00;
        }
    </style>
</head>
<body>
    <h1>Data Pesanan</h1>
    <a href="tambah.php">Tambah Pesanan Baru</a>
    <table>
        <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>HP</th>
            <th>Tanggal Transaksi</th>
            <th>Jenis Barang</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Tunjukkan Diskon</th>
            <th>Aksi</th>
        </tr>
        <?php
        include 'koneksi.php';
        $result = mysqli_query($koneksi, "SELECT * FROM ismail");
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $discount = $row['harga'] * 0.05 * $row['jumlah'];
        ?>
        <tr>
            <td><?= $i; ?></td>
            <td><?= $row['nama']; ?></td>
            <td><?= $row['alamat']; ?></td>
            <td><?= $row['hp']; ?></td>
            <td><?= $row['tgl_transaksi']; ?></td>
            <td><?= $row['jenis_barang']; ?></td>
            <td><?= $row['nama_barang']; ?></td>
            <td><?= $row['jumlah']; ?></td>
            <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
            <td>
                <button class="discount-btn" onclick="showDiscount(<?= $discount; ?>)">Tunjukkan Diskon</button>
            </td>
            <td class="actions">
                <a href="ubah.php?id=<?= $row['id_pembeli']; ?>" style="background-color: #ff9900;">Ubah</a>
                <a href="hapus.php?id=<?= $row['id_pembeli']; ?>" onclick="return confirm('Yakin ingin menghapus?');" style="background-color: #e74c3c;">Hapus</a>
            </td>
        </tr>
        <?php $i++; } ?>
    </table>

    <!-- JavaScript to show the discount -->
    <script>
        function showDiscount(discount) {
            alert('Diskon untuk pesanan ini adalah Rp ' + discount.toLocaleString('id-ID'));
        }
    </script>
</body>
</html>
