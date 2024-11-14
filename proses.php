<?php
include 'koneksi.php';

if (isset($_POST['submit'])) {
    $nama = trim($_POST["nama"]);
    $alamat = trim($_POST["alamat"]);
    $HP = trim($_POST["HP"]);
    $tgl_transaksi = $_POST["tgl_transaksi"];
    $jenis_barang = trim($_POST["jenis_barang"]);
    $nama_barang = trim($_POST["nama_barang"]);
    $jumlah = trim($_POST["jumlah"]);
    $harga = trim($_POST["harga"]);

    $errors = [];

    if (empty($nama)) {
        $errors[] = "Nama tidak boleh kosong!";
    }

    if (empty($alamat)) {
        $errors[] = "Alamat tidak boleh kosong!";
    }
    
    if (empty($HP)) {
        $errors[] = "Nomor HP tidak boleh kosong!";
    } elseif (!preg_match("/^[0-9]{10,13}$/", $HP)) {
        $errors[] = "Format HP tidak valid! (10-13 digit)";
    }

    if (empty($jenis_barang)) {
        $errors[] = "Jenis barang tidak boleh kosong!";
    }

    if (empty($nama_barang)) {
        $errors[] = "Nama barang tidak boleh kosong!";
    }

    if (empty($jumlah)) {
        $errors[] = "Jumlah tidak boleh kosong!";
    } elseif (!is_numeric($jumlah) || $jumlah <= 0) {
        $errors[] = "Jumlah harus berupa angka positif!";
    }

    if (empty($harga)) {
        $errors[] = "Harga tidak boleh kosong!";
    } elseif (!is_numeric($harga) || $harga <= 0) {
        $errors[] = "Harga harus berupa angka positif!";
    }

    // If there are errors
    if (!empty($errors)) {
        echo "<div style='color: red; padding: 10px; border: 1px solid red; margin: 10px;'>";
        echo "<h3>Terjadi kesalahan:</h3>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
        echo "<a href='javascript:history.back()'>Kembali</a>";
        echo "</div>";
    } else {
        // If no errors, proceed with database insertion
        $query = "INSERT INTO pesanan (nama, alamat, hp, tgl_transaksi, jenis_barang, nama_barang, jumlah, harga) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, "ssssssid", 
            $nama, 
            $alamat, 
            $HP, 
            $tgl_transaksi,
            $jenis_barang, 
            $nama_barang, 
            $jumlah, 
            $harga
        );

        if (mysqli_stmt_execute($stmt)) {
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
                    history.back();
                </script>
            ";
        }
        
        mysqli_stmt_close($stmt);
    }
} else {
    // If accessed directly without form submission
    header("Location: tambah.php");
    exit();
}
?>