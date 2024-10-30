<?php   
$koneksi = mysqli_connect("localhost","root","","muhammad"); 
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Membuat database
$sql = "CREATE DATABASE IF NOT EXISTS muhammad";
if (mysqli_query($koneksi, $sql)) {
    echo "Database berhasil dibuat";
} else {
    echo "Error creating database: " . mysqli_error($koneksi);
}

// Membuat tabel ismail
$sql = "CREATE TABLE IF NOT EXISTS ismail (
    id_pembeli INT(10) AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(30) NOT NULL,
    alamat VARCHAR(50) NOT NULL,
    hp VARCHAR(20) NOT NULL,
    tgl_transaksi DATE NOT NULL,
    jenis_barang VARCHAR(25) NOT NULL,
    nama_barang VARCHAR(50) NOT NULL,
    jumlah INT(20) NOT NULL,
    harga int(25) NOT NULL
)";

if (mysqli_query($koneksi, $sql)) {
    echo "Tabel ismail berhasil dibuat";
} else {
    echo "Error creating table: " . mysqli_error($koneksi);
}

function tambahPesanan($data) {
    global $koneksi;
    
    $nama = htmlspecialchars($data['nama']);
    $alamat = htmlspecialchars($data['alamat']);
    $hp = htmlspecialchars($data['hp']);
    $tgl_transaksi = $data['tgl_transaksi'];
    $jenis_barang = htmlspecialchars($data['jenis_barang']);
    $nama_barang = htmlspecialchars($data['nama_barang']);
    $jumlah = (int)$data['jumlah'];
    $harga = (float)$data['harga'];

    $query = "INSERT INTO ismail VALUES 
            (NULL, '$nama', '$alamat', '$hp', '$tgl_transaksi', 
             '$jenis_barang', '$nama_barang', $jumlah, $harga)";
             
    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}

function hapusPesanan($id) {
    global $koneksi;
    mysqli_query($koneksi, "DELETE FROM ismail WHERE id_pembeli = $id");
    return mysqli_affected_rows($koneksi);
}

function ubahPesanan($data) {
    global $koneksi;
    
    $id = $data['id_pembeli'];
    $nama = htmlspecialchars($data['nama']);
    $alamat = htmlspecialchars($data['alamat']);
    $hp = htmlspecialchars($data['hp']);
    $tgl_transaksi = $data['tgl_transaksi'];
    $jenis_barang = htmlspecialchars($data['jenis_barang']);
    $nama_barang = htmlspecialchars($data['nama_barang']);
    $jumlah = (int)$data['jumlah'];
    $harga = (float)$data['harga'];

    $query = "UPDATE ismail SET
            nama = '$nama',
            alamat = '$alamat',
            hp = '$hp',
            tgl_transaksi = '$tgl_transaksi',
            jenis_barang = '$jenis_barang',
            nama_barang = '$nama_barang',
            jumlah = $jumlah,
            harga = $harga
            WHERE id_pembeli = $id";
            
    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}
?>