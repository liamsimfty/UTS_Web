<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pesanan</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .search-container {
            margin: 20px 0;
        }
        .search-container input[type=text] {
            padding: 10px;
            width: 300px;
            margin-right: 10px;
        }
        .search-container button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .search-container button:hover {
            background-color: #45a049;
        }
        
        /* Styling untuk pagination */
        .pagination {
            margin: 20px 0;
            text-align: center;
        }
        .pagination a, .pagination span {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            background-color: #f1f1f1;
            color: #333;
            margin: 0 4px;
            border-radius: 4px;
        }
        .pagination a:hover {
            background-color: #ddd;
        }
        .pagination .active {
            background-color: #4CAF50;
            color: white;
        }
        .pagination .disabled {
            background-color: #ddd;
            color: #666;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <h1>Data Pesanan</h1>
    
    <!-- Form Pencarian -->
    <div class="search-container">
        <form action="" method="GET">
            <input type="text" name="search"  value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            <button type="submit">Cari</button>
            <?php if(isset($_GET['search'])): ?>
                <a href="index.php" style="margin-left: 10px;">Reset</a>
            <?php endif; ?>
        </form>
    </div>

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
        
        // Konfigurasi pagination
        $limit = 10; // Jumlah data per halaman
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start = ($page - 1) * $limit;
        
        // Query dengan pencarian
        $search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
        
        // Query untuk menghitung total data
        if($search != '') {
            $count_query = "SELECT COUNT(*) as total FROM ismail WHERE nama LIKE '%$search%'";
            $main_query = "SELECT * FROM ismail WHERE nama LIKE '%$search%' LIMIT $start, $limit";
        } else {
            $count_query = "SELECT COUNT(*) as total FROM ismail";
            $main_query = "SELECT * FROM ismail LIMIT $start, $limit";
        }
        
        // Mendapatkan total data
        $count_result = mysqli_query($koneksi, $count_query);
        $total_rows = mysqli_fetch_assoc($count_result)['total'];
        $total_pages = ceil($total_rows / $limit);
        
        // Query utama
        $result = mysqli_query($koneksi, $main_query);
        $i = $start + 1;
        
        // Cek apakah ada hasil
        if(mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $discount = $row['harga'] * 0.05 * $row['jumlah'];
        ?>
        <tr>
            <td><?= $i; ?></td>
            <td><?= htmlspecialchars($row['nama']); ?></td>
            <td><?= htmlspecialchars($row['alamat']); ?></td>
            <td><?= htmlspecialchars($row['hp']); ?></td>
            <td><?= htmlspecialchars($row['tgl_transaksi']); ?></td>
            <td><?= htmlspecialchars($row['jenis_barang']); ?></td>
            <td><?= htmlspecialchars($row['nama_barang']); ?></td>
            <td><?= htmlspecialchars($row['jumlah']); ?></td>
            <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
            <td>
                <button class="discount-btn" onclick="showDiscount(<?= $discount; ?>)">Tunjukkan Diskon</button>
            </td>
            <td class="actions">
                <a href="ubah.php?id=<?= $row['id_pembeli']; ?>" style="background-color: #ff9900;">Ubah</a>
                <a href="hapus.php?id=<?= $row['id_pembeli']; ?>" onclick="return confirm('Yakin ingin menghapus?');" style="background-color: #e74c3c;">Hapus</a>
            </td>
        </tr>
        <?php 
                $i++;
            }
        } else {
            echo "<tr><td colspan='11' style='text-align: center;'>Tidak ada data yang ditemukan</td></tr>";
        }
        ?>
    </table>

    <!-- Pagination -->
    <?php if($total_pages > 1): ?>
    <div class="pagination">
        <?php
        // Previous link
        if($page > 1) {
            echo '<a href="?page='.($page-1).($search ? '&search='.urlencode($search) : '').'">&laquo; Previous</a>';
        } else {
            echo '<span class="disabled">&laquo; Previous</span>';
        }
        
        // Numbered pagination
        for($i = 1; $i <= $total_pages; $i++) {
            if($i == $page) {
                echo '<span class="active">'.$i.'</span>';
            } else {
                echo '<a href="?page='.$i.($search ? '&search='.urlencode($search) : '').'">'.$i.'</a>';
            }
        }
        
        // Next link
        if($page < $total_pages) {
            echo '<a href="?page='.($page+1).($search ? '&search='.urlencode($search) : '').'">Next &raquo;</a>';
        } else {
            echo '<span class="disabled">Next &raquo;</span>';
        }
        ?>
    </div>
    <?php endif; ?>

    <!-- JavaScript to show the discount -->
    <script>
        function showDiscount(discount) {
            alert('Diskon untuk pesanan ini adalah Rp ' + discount.toLocaleString('id-ID'));
        }
    </script>
</body>
</html>