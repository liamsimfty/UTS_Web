<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Pesanan</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    include 'koneksi.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $result = mysqli_query($koneksi, "SELECT * FROM ismail WHERE id_pembeli = '$id'");

        if (mysqli_num_rows($result) > 0) {
            $pesanan = mysqli_fetch_assoc($result);
        } else {
            echo "Data tidak ditemukan.";
            exit;
        }
    } else {
        echo "ID pesanan tidak ada.";
        exit;
    }

    if (isset($_POST['submit'])) {
        $id_pembeli = $_POST['id_pembeli'];
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $hp = $_POST['hp'];
        $tgl_transaksi = $_POST['tgl_transaksi'];
        $jenis_barang = $_POST['jenis_barang'];
        $nama_barang = $_POST['nama_barang'];
        $jumlah = $_POST['jumlah'];
        $harga = $_POST['harga'];

        $updateQuery = "UPDATE ismail SET
                        nama = '$nama',
                        alamat = '$alamat',
                        hp = '$hp',
                        tgl_transaksi = '$tgl_transaksi',
                        jenis_barang = '$jenis_barang',
                        nama_barang = '$nama_barang',
                        jumlah = '$jumlah',
                        harga = '$harga'
                        WHERE id_pembeli = '$id_pembeli'";

        if (mysqli_query($koneksi, $updateQuery)) {
            echo "<script>
                    alert('Data berhasil diubah!');
                    document.location.href = 'index.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Data gagal diubah!');
                  </script>";
        }
    }
    ?>
    
    <h1>Ubah Pesanan</h1>
    <form action="" method="post">
        <input type="hidden" name="id_pembeli" value="<?= $pesanan['id_pembeli']; ?>">

        <label for="nama">Nama:</label>
        <input type="text" name="nama" id="nama" required value="<?= $pesanan['nama']; ?>">

        <label for="alamat">Alamat:</label>
        <textarea name="alamat" id="alamat" required><?= $pesanan['alamat']; ?></textarea>

        <label for="hp">HP:</label>
        <input type="text" name="hp" id="hp" required value="<?= $pesanan['hp']; ?>">

        <label for="tgl_transaksi">Tanggal Transaksi:</label>
        <input type="date" name="tgl_transaksi" id="tgl_transaksi" required value="<?= $pesanan['tgl_transaksi']; ?>">

        <label for="jenis_barang">Jenis Barang:</label>
        <input type="text" name="jenis_barang" id="jenis_barang" required value="<?= $pesanan['jenis_barang']; ?>">

        <label for="nama_barang">Nama Barang:</label>
        <input type="text" name="nama_barang" id="nama_barang" required value="<?= $pesanan['nama_barang']; ?>">

        <label for="jumlah">Jumlah:</label>
        <input type="number" name="jumlah" id="jumlah" required value="<?= $pesanan['jumlah']; ?>">

        <label for="harga">Harga:</label>
        <input type="number" name="harga" id="harga" required value="<?= $pesanan['harga']; ?>">

        <button type="submit" name="submit">Ubah Pesanan</button>
    </form>
</body>
</html>
