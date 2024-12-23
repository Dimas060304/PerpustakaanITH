<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db = "perpustakaan";

$conn = new mysqli($host, $user, $pass, $db);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tambah data buku
if (isset($_POST['add'])) {
    $judul_buku = htmlspecialchars($_POST['judul_buku']);
    $kode_buku = htmlspecialchars($_POST['kode_buku']);
    $penerbit_buku = htmlspecialchars($_POST['penerbit_buku']);
    $penulis_buku = htmlspecialchars($_POST['penulis_buku']);
    $keterangan = htmlspecialchars($_POST['keterangan']);
    $isbn_issn = htmlspecialchars($_POST['isbn_issn']);
    $jumlah_buku = (int)$_POST['jumlah_buku'];
    $tahun_terbit = htmlspecialchars($_POST['tahun_terbit']);

    // Proses upload gambar
    $cover_buku = $_FILES['cover_buku']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($cover_buku);

    if (move_uploaded_file($_FILES['cover_buku']['tmp_name'], $target_file)) {
        $sql = "INSERT INTO buku (judul_buku, kode_buku, penerbit_buku, penulis_buku, keterangan, isbn_issn, jumlah_buku, tahun_terbit, cover_buku) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssis", $judul_buku, $kode_buku, $penerbit_buku, $penulis_buku, $keterangan, $isbn_issn, $jumlah_buku, $tahun_terbit, $target_file);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "<script>alert('Gagal mengupload gambar!');</script>";
    }
}

// Hapus data buku
if (isset($_GET['delete'])) {
    $id_buku = (int)$_GET['delete'];
    $sql = "DELETE FROM buku WHERE id_buku=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_buku);
    $stmt->execute();
    $stmt->close();
}

// Ambil nilai pencarian jika ada
$search_query = "";
if (isset($_POST['search_value']) && !empty($_POST['search_value'])) {
    $search_value = htmlspecialchars($_POST['search_value']);
    $search_query = "WHERE kode_buku LIKE '%$search_value%' OR judul_buku LIKE '%$search_value%'";
}

// Ambil data buku berdasarkan pencarian
$sql = "SELECT * FROM buku $search_query";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku Perpustakaan</title>
    <link rel="stylesheet" href="DaftarBuku.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div>
            <h2>ADMIN</h2>
            <ul>
                <li><a href="Dashboard.php"><img src="DashboardIcon.png" alt="Dashboard Icon" class="icon"> Dashboard</a></li>
                <li><a href="DaftarBuku.php"><img src="BookIcon.png" alt="Books Icon" class="icon"> Data Buku</a></li>
                <li><a href="DaftarAnggota.php"><img src="MemberIcon.png" alt="Members Icon" class="icon"> Daftar Anggota</a></li>
                <li><a href="SejarahPerpustakaan.php"><img src="TentangPerpusIcon.png" alt="Library Icon" class="icon"> Tentang Perpustakaan</a></li>
            </ul>
        </div>
        <div>
            <h3>SETTING</h3>
            <ul>
                <li><a href="Administrator.php"><img src="AdministratorIcon.png" alt="Administrator Icon" class="icon"> Administrator</a></li>
            </ul>
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="content">
        <h1>Daftar Buku Perpustakaan</h1>
        <div class="actions">
            <a href="TambahBuku.php"><button class="btn-add">+ Tambah Buku</button></a>
            <!-- Form pencarian -->
            <div class="search-bar" style="display: flex; align-items: center; gap: 8px;">
                <form method="POST" action="DaftarBuku.php" style="display: flex; align-items: center;">
                    <input type="text" id="searchInput" name="search_value" placeholder="Cari berdasarkan kode atau judul" 
                           value="<?= isset($_POST['search_value']) ? htmlspecialchars($_POST['search_value']) : ''; ?>" 
                           style="flex: 1; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    <!-- Tombol silang untuk menghapus pencarian -->
                    <button type="button" id="clearSearch" 
                            style="background: none; border: none; cursor: pointer;">
                        <img src="Silang.png" alt="Clear Icon" style="width: 15px; height: 15px;">
                    </button>
                    <button type="submit" name="search" class="btn-search" 
                            style="background: none; border: none; cursor: pointer;">
                        <img src="SearchIcon.png" alt="Search Icon" style="width: 24px; height: 24px;">
                    </button>
                </form>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Kode Buku</th>
                    <th>Penerbit</th>
                    <th>Penulis</th>
                    <th>Keterangan</th>
                    <th>ISBN/ISSN</th>
                    <th>Jumlah Buku</th>
                    <th>Tahun Terbit</th>
                    <th>Cover</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
    <?php
    $no = 1;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$no}</td>
                <td>{$row['judul_buku']}</td>
                <td>{$row['kode_buku']}</td>
                <td>{$row['penerbit_buku']}</td>
                <td>{$row['penulis_buku']}</td>
                <td>{$row['Keterangan']}</td>
                <td>{$row['isbn_issn']}</td>
                <td>{$row['Jumlah_Buku']}</td>
                <td>{$row['tahun_terbit']}</td>
                <td><img src='{$row['Cover_Buku']}' alt='Cover Buku' style='width:50px; height:75px;'></td>
                <td>
                    <!-- Ikon Edit dengan Background Kuning -->
                    <a href='edit_buku.php?id={$row['id_buku']}'>
                        <span style='display:inline-block; background-color:yellow; border-radius:4px; padding:4px;'>
                            <img src='EditIcon.png' alt='Edit' style='width:20px; height:20px; cursor:pointer;' />
                        </span>
                    </a>
                    
                    <!-- Ikon Delete dengan Background Merah -->
                    <a href='?delete={$row['id_buku']}' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>
                        <span style='display:inline-block; background-color:red; border-radius:4px; padding:4px;'>
                            <img src='HapusIcon.png' alt='Delete' style='width:20px; height:20px; cursor:pointer;' />
                        </span>
                    </a>
                </td>
            </tr>";
            $no++;
        }
    } else {
        echo "<tr><td colspan='11'>Tidak ada data buku yang ditemukan.</td></tr>";
    }
    ?>
</tbody>
        </table>
        <script>
    // Tombol untuk menghapus teks pada input pencarian dan kirimkan form dengan pencarian kosong
    document.getElementById('clearSearch').addEventListener('click', function () {
        const searchInput = document.getElementById('searchInput');
        searchInput.value = ''; // Menghapus teks input
        searchInput.form.submit(); // Submit form dengan input kosong
    });
</script>

    </div>
</body>
</html>
