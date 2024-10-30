<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pesanan</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h1>Tambah Pesanan</h1>

    <form action="" method="post" action='proses.php'>
        <p>
            <label for="nama">Nama:</label>
            <input type="text" name="nama" id="nama" required>
        </p>
        <p>
            <label for="alamat">Alamat:</label>
            <textarea name="alamat" id="alamat" required></textarea>
        </p>
        <p>
            <label for="hp">HP:</label>
            <input type="text" name="hp" id="hp" required>
        </p>
        <p>
            <label for="tgl_transaksi">Tanggal Transaksi:</label>
            <input type="date" name="tgl_transaksi" id="tgl_transaksi" value="<?php echo date('Y-m-d'); ?>" readonly>
        </p>
        <p>
            <label for="jenis_barang">Jenis Barang:</label>
            <input type="text" name="jenis_barang" id="jenis_barang" required>
        </p>
        <p>
            <label for="nama_barang">Nama Barang:</label>
            <input type="text" name="nama_barang" id="nama_barang" required>
        </p>
        <p>
            <label for="jumlah">Jumlah:</label>
            <input type="number" name="jumlah" id="jumlah" required>
        </p>
        <p>
            <label for="harga">Harga:</label>
            <input type="number" name="harga" id="harga" required>
        </p>
        <button type="submit" name="submit">Tambah Pesanan</button>
    </form>

    <div class="back-link">
        <p><a href="index.php">Kembali ke Daftar Pesanan</a></p>
    </div>

    <?php
    include 'koneksi.php';
    if (isset($_POST['submit'])) {
        $_POST['tgl_transaksi'] = date('Y-m-d');
        if (tambahPesanan($_POST) > 0) {
            echo "
                <script>
                    alert('Data berhasil ditambahkan!');
                    document.location.href = 'index.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Data gagal ditambahkan!');
                </script>
            ";
        }
    }
    ?>
</body>
</html>
