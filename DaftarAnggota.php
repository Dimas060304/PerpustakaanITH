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

// Tambah data anggota
if (isset($_POST['add'])) {
    $nama_anggota = htmlspecialchars($_POST['nama_anggota']);
    $nim = htmlspecialchars($_POST['nim']);
    $prodi = htmlspecialchars($_POST['prodi']);
    $jenis_kelamin = htmlspecialchars($_POST['jenis_kelamin']);
    $telepon = htmlspecialchars($_POST['telepon']);
    $email = htmlspecialchars($_POST['email']);
    $alamat = htmlspecialchars($_POST['alamat']);

    $sql = "INSERT INTO anggota (nama_anggota, nim, prodi, jenis_kelamin, telepon, email, alamat) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $nama_anggota, $nim, $prodi, $jenis_kelamin, $telepon, $email, $alamat);
    if ($stmt->execute()) {
        echo "<script>alert('Data anggota berhasil ditambahkan!');</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data anggota: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// Hapus data anggota
if (isset($_GET['delete'])) {
    $id_anggota = (int)$_GET['delete']; // Pastikan hanya angka
    $sql = "DELETE FROM anggota WHERE id_anggota=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_anggota);
    if ($stmt->execute()) {
        echo "<script>alert('Data anggota berhasil dihapus!');</script>";
    } else {
        echo "<script>alert('Gagal menghapus data anggota: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// Edit data anggota
if (isset($_POST['edit'])) {
    $id = (int)$_POST['id'];
    $nama_anggota = htmlspecialchars($_POST['nama_anggota']);
    $nim = htmlspecialchars($_POST['nim']);
    $prodi = htmlspecialchars($_POST['prodi']);
    $jenis_kelamin = htmlspecialchars($_POST['jenis_kelamin']);
    $telepon = htmlspecialchars($_POST['telepon']);
    $email = htmlspecialchars($_POST['email']);
    $alamat = htmlspecialchars($_POST['alamat']);

    $sql = "UPDATE anggota SET nama_anggota=?, nim=?, prodi=?, jenis_kelamin=?, telepon=?, email=?, alamat=? WHERE id_anggota=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $nama_anggota, $nim, $prodi, $jenis_kelamin, $telepon, $email, $alamat, $id);
    if ($stmt->execute()) {
        echo "<script>alert('Data anggota berhasil diperbarui!');</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data anggota: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// Pencarian anggota berdasarkan ID atau nama
$search_query = "";
if (isset($_POST['search'])) {
    $search_value = htmlspecialchars($_POST['search_value']);
    if (!empty($search_value)) {
        $search_query = "WHERE id_anggota LIKE '%$search_value%' OR nama_anggota LIKE '%$search_value%'";
    }
}

// Ambil data anggota sesuai pencarian atau semua anggota
$sql = "SELECT * FROM anggota $search_query";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Daftar Anggota Perpustakaan</title>
    <link rel="stylesheet" href="\PERPUSTAKAANITH\DaftarAnggota.css">
</head>
<body>
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
    <div class="content">
        <h1>Daftar Anggota Perpustakaan</h1>
        <div class="actions">
            <a href="TambahAnggota.php">
                <button class="btn-add">+ Tambah Anggota Perpustakaan</button>
            </a>
            <!-- Form pencarian -->
            <div class="search-bar" style="display: flex; align-items: center; gap: 8px;">
                <form method="POST" action="DaftarAnggota.php" style="display: flex; align-items: center;">
                    <input type="text" id="searchInput" name="search_value" placeholder="Cari berdasarkan ID atau nama" 
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
                    <th>Id Anggota</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Prodi</th>
                    <th>No Telpon</th>
                    <th>Email</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['id_anggota']); ?></td>
                            <td><?= htmlspecialchars($row['nama_anggota']); ?></td>
                            <td><?= htmlspecialchars($row['nim']); ?></td>
                            <td><?= htmlspecialchars($row['prodi']); ?></td>
                            <td><?= htmlspecialchars($row['telepon']); ?></td>
                            <td><?= htmlspecialchars($row['email']); ?></td>
                            <td><?= htmlspecialchars($row['jenis_kelamin']); ?></td>
                            <td><?= htmlspecialchars($row['alamat']); ?></td>
                            <td>
                                <!-- Ikon Edit dengan Background Kuning -->
                                <a href="edit_anggota.php?id=<?= htmlspecialchars($row['id_anggota']); ?>">
                                    <span style="display:inline-block; background-color:yellow; border-radius:4px; padding:4px;">
                                        <img src="EditIcon.png" alt="Edit" style="width:20px; height:20px; cursor:pointer;">
                                    </span>
                                </a>
                                 
                                <!-- Ikon Delete dengan Background Merah -->
                                <a href="?delete=<?= $row['id_anggota']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    <span style="display:inline-block; background-color:red; border-radius:4px; padding:4px;">
                                        <img src="HapusIcon.png" alt="Delete" style="width:20px; height:20px; cursor:pointer;">
                                    </span>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="10">Tidak ada data anggota.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        // Tombol untuk menghapus teks pada input pencarian dan memuat ulang halaman
        document.getElementById('clearSearch').addEventListener('click', function () {
            const searchInput = document.getElementById('searchInput');
            searchInput.value = ''; // Menghapus teks input
            searchInput.focus(); // Fokus kembali ke input
            window.location.href = "DaftarAnggota.php"; // Memuat ulang halaman
        });
    </script>
</body>
</html>
