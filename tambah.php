<?php
include 'koneksi.php';

// Initialize error array
$errors = [];

// Process form submission
if (isset($_POST['submit'])) {
    // Get and sanitize form data
    $nama = trim($_POST["nama"] ?? '');
    $alamat = trim($_POST["alamat"] ?? '');
    $HP = trim($_POST["HP"] ?? '');
    $tgl_transaksi = date('Y-m-d'); // Set current date
    $jenis_barang = trim($_POST["jenis_barang"] ?? '');
    $nama_barang = trim($_POST["nama_barang"] ?? '');
    $jumlah = trim($_POST["jumlah"] ?? '');
    $harga = trim($_POST["harga"] ?? '');

    // Validate Nama (only letters and spaces)
    if (empty($nama)) {
        $errors['nama'] = "Nama tidak boleh kosong!";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $nama)) {
        $errors['nama'] = "Nama hanya boleh berisi huruf dan spasi!";
    }

    // Validate Alamat
    if (empty($alamat)) {
        $errors['alamat'] = "Alamat tidak boleh kosong!";
    } elseif (strlen($alamat) < 10) {
        $errors['alamat'] = "Alamat terlalu pendek (minimal 10 karakter)!";
    }

    // Validate HP
    if (empty($HP)) {
        $errors['hp'] = "Nomor HP tidak boleh kosong!";
    } elseif (!preg_match("/^[0-9]{10,13}$/", $HP)) {
        $errors['hp'] = "Format HP tidak valid! (10-13 digit)";
    }

    // Validate Jenis Barang
    if (empty($jenis_barang)) {
        $errors['jenis_barang'] = "Jenis barang tidak boleh kosong!";
    }

    // Validate Nama Barang
    if (empty($nama_barang)) {
        $errors['nama_barang'] = "Nama barang tidak boleh kosong!";
    }

    // Validate Jumlah
    if (empty($jumlah)) {
        $errors['jumlah'] = "Jumlah tidak boleh kosong!";
    } elseif (!is_numeric($jumlah) || $jumlah <= 0) {
        $errors['jumlah'] = "Jumlah harus berupa angka positif!";
    }

    // Validate Harga
    if (empty($harga)) {
        $errors['harga'] = "Harga tidak boleh kosong!";
    } elseif (!is_numeric($harga) || $harga <= 0) {
        $errors['harga'] = "Harga harus berupa angka positif!";
    }

    // If no errors, process the form
    if (empty($errors)) {
        $query = "INSERT INTO pesanan (nama, alamat, hp, tgl_transaksi, jenis_barang, nama_barang, jumlah, harga) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, "ssssssid", 
            $nama, $alamat, $HP, $tgl_transaksi,
            $jenis_barang, $nama_barang, $jumlah, $harga
        );

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>
                    alert('Data berhasil ditambahkan!');
                    document.location.href = 'index.php';
                  </script>";
        } else {
            $errors['db'] = "Gagal menambahkan data: " . mysqli_error($koneksi);
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pesanan</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .error {
            color: red;
            font-size: 0.8em;
            margin-top: 2px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        input.error-input {
            border: 1px solid red;
        }
    </style>
</head>
<body>
    <h1>Tambah Pesanan</h1>

    <?php if (!empty($errors)): ?>
        <div style="color: red; margin-bottom: 20px;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <pre>
            Nama            : <input type="text" name="nama" 
                             value="<?php echo isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>"
                             class="<?php echo isset($errors['nama']) ? 'error-input' : ''; ?>">
            <?php if (isset($errors['nama'])): ?>
                <span class="error"><?php echo $errors['nama']; ?></span>
            <?php endif; ?>

            Alamat          : <input type="text" name="alamat"
                             value="<?php echo isset($_POST['alamat']) ? htmlspecialchars($_POST['alamat']) : ''; ?>"
                             class="<?php echo isset($errors['alamat']) ? 'error-input' : ''; ?>">
            <?php if (isset($errors['alamat'])): ?>
                <span class="error"><?php echo $errors['alamat']; ?></span>
            <?php endif; ?>

            HP              : <input type="text" name="HP"
                             value="<?php echo isset($_POST['HP']) ? htmlspecialchars($_POST['HP']) : ''; ?>"
                             class="<?php echo isset($errors['hp']) ? 'error-input' : ''; ?>">
            <?php if (isset($errors['hp'])): ?>
                <span class="error"><?php echo $errors['hp']; ?></span>
            <?php endif; ?>

            Tanggal         : <input type="date" name="tgl_transaksi" id="tgl_transaksi" readonly>

            Jenis Barang    : <input type="text" name="jenis_barang"
                             value="<?php echo isset($_POST['jenis_barang']) ? htmlspecialchars($_POST['jenis_barang']) : ''; ?>"
                             class="<?php echo isset($errors['jenis_barang']) ? 'error-input' : ''; ?>">
            <?php if (isset($errors['jenis_barang'])): ?>
                <span class="error"><?php echo $errors['jenis_barang']; ?></span>
            <?php endif; ?>

            Nama Barang     : <input type="text" name="nama_barang"
                             value="<?php echo isset($_POST['nama_barang']) ? htmlspecialchars($_POST['nama_barang']) : ''; ?>"
                             class="<?php echo isset($errors['nama_barang']) ? 'error-input' : ''; ?>">
            <?php if (isset($errors['nama_barang'])): ?>
                <span class="error"><?php echo $errors['nama_barang']; ?></span>
            <?php endif; ?>

            Jumlah          : <input type="number" name="jumlah"
                             value="<?php echo isset($_POST['jumlah']) ? htmlspecialchars($_POST['jumlah']) : ''; ?>"
                             class="<?php echo isset($errors['jumlah']) ? 'error-input' : ''; ?>">
            <?php if (isset($errors['jumlah'])): ?>
                <span class="error"><?php echo $errors['jumlah']; ?></span>
            <?php endif; ?>

            Harga           : <input type="number" name="harga"
                             value="<?php echo isset($_POST['harga']) ? htmlspecialchars($_POST['harga']) : ''; ?>"
                             class="<?php echo isset($errors['harga']) ? 'error-input' : ''; ?>">
            <?php if (isset($errors['harga'])): ?>
                <span class="error"><?php echo $errors['harga']; ?></span>
            <?php endif; ?>
            </pre>
        </div>
        <button type="submit" name="submit">Tambah Pesanan</button>
    </form>

    <div class="back-link">
        <p><a href="index.php">Kembali ke Daftar Pesanan</a></p>
    </div>

    <script>
        // Set current date when page loads
        window.onload = function() {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();
            today = yyyy + '-' + mm + '-' + dd;
            document.getElementById('tgl_transaksi').value = today;
        }
    </script>
</body>
</html>