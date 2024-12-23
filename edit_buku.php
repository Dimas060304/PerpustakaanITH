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

// Ambil data buku berdasarkan ID
$id_buku = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sql = "SELECT * FROM buku WHERE id_buku=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_buku);
$stmt->execute();
$result = $stmt->get_result();
$buku = $result->fetch_assoc();
$stmt->close();

// Perbarui data buku
if (isset($_POST['update'])) {
    $judul_buku = htmlspecialchars($_POST['judul_buku']);
    $kode_buku = htmlspecialchars($_POST['kode_buku']);
    $penerbit_buku = htmlspecialchars($_POST['penerbit_buku']);
    $penulis_buku = htmlspecialchars($_POST['penulis_buku']);
    $keterangan = htmlspecialchars($_POST['keterangan']);
    $isbn_issn = htmlspecialchars($_POST['isbn_issn']);
    $jumlah_buku = (int)$_POST['jumlah_buku'];
    $tahun_terbit = htmlspecialchars($_POST['tahun_terbit']);

    // Proses upload gambar baru jika ada
    $cover_buku = $buku['Cover_Buku']; // Gunakan cover lama secara default
    if (!empty($_FILES['cover_buku']['name'])) {
        $cover_buku = "uploads/" . basename($_FILES['cover_buku']['name']);
        move_uploaded_file($_FILES['cover_buku']['tmp_name'], $cover_buku);
    }

    // Update data buku
    $sql = "UPDATE buku SET judul_buku=?, kode_buku=?, penerbit_buku=?, penulis_buku=?, keterangan=?, isbn_issn=?, jumlah_buku=?, tahun_terbit=?, cover_buku=? WHERE id_buku=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssisi", $judul_buku, $kode_buku, $penerbit_buku, $penulis_buku, $keterangan, $isbn_issn, $jumlah_buku, $tahun_terbit, $cover_buku, $id_buku);
    if ($stmt->execute()) {
        echo "<script>alert('Data buku berhasil diperbarui!'); window.location.href='DaftarBuku.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data buku!');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
    <style>
        /* General Reset */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #65c3a3;
            color: white;
            position: fixed;
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding-top: 20px;
        }
        .sidebar h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }
        .sidebar .menu-section {
            margin: 15px 0;
        }
        .sidebar .menu-section h2 {
            font-size: 14px;
            text-transform: uppercase;
            margin-left: 15px;
            margin-bottom: 10px;
        }
        .sidebar a {
            text-decoration: none;
            color: white;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            transition: background 0.3s;
        }
        .sidebar a:hover {
            background-color: #4aa683;
        }
        .sidebar a img {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }

        /* Content Area */
        .content {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
            background-color: #f8f9fa;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #65c3a3;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border: none;
        }
        button:hover {
            background-color: #4aa683;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h1>Library Admin</h1>
    <div class="menu-section">
    <h2>Admin</h2>
            <a href="Dashboard.html"><img src="DashboardIcon.png" alt="Dashboard Icon">Dashboard</a>
        </div>
        <div class="menu-section">
        <h2>Menu</h2>
        <a href="DaftarBuku.html"><img src="BookIcon.png" alt="Books Icon">Data Buku</a>
            <a href="DaftarAnggota.html"><img src="MemberIcon.png" alt="Members Icon">Daftar Anggota</a>
            <a href="SejarahPerpustakaan.html"><img src="TentangPerpusIcon.png" alt="Info Icon">Tentang Perpustakaan</a>
        </div>
        <div class="menu-section">
            <h2>Setting</h2>
            <a href="Administrator.html"><img src="AdministratorIcon.png" alt="Settings Icon">Administrator</a>
        </div>
</div>

<!-- Main Content -->
<div class="content">
    <h1>Edit Buku</h1>
    <form method="POST" enctype="multipart/form-data">
    <label for="judul_buku">Judul Buku:</label>
    <input type="text" name="judul_buku" value="<?= htmlspecialchars($buku['judul_buku']); ?>" required>
    <label for="kode_buku">Kode Buku:</label>
    <input type="text" name="kode_buku" value="<?= htmlspecialchars($buku['kode_buku']); ?>" required>
    <label for="penerbit_buku">Penerbit:</label>
    <input type="text" name="penerbit_buku" value="<?= htmlspecialchars($buku['penerbit_buku']); ?>" required>
    <label for="penulis_buku">Penulis:</label>
    <input type="text" name="penulis_buku" value="<?= htmlspecialchars($buku['penulis_buku']); ?>" required>
    <label for="keterangan">Keterangan:</label>
    <textarea name="keterangan" rows="4" required><?= htmlspecialchars($buku['Keterangan']); ?></textarea>
    <label for="isbn_issn">ISBN/ISSN:</label>
    <input type="text" name="isbn_issn" value="<?= htmlspecialchars($buku['isbn_issn']); ?>" required>
    <label for="jumlah_buku">Jumlah Buku:</label>
    <input type="number" name="jumlah_buku" value="<?= htmlspecialchars($buku['Jumlah_Buku']); ?>" required>
    <label for="tahun_terbit">Tahun Terbit:</label>
    <input type="text" name="tahun_terbit" value="<?= htmlspecialchars($buku['tahun_terbit']); ?>" required>
    <label for="cover_buku">Cover Buku:</label>
    <input type="file" name="cover_buku">
    <img src="<?= $buku['Cover_Buku']; ?>" alt="Cover Buku" width="100">
    <button type="submit" name="update">Perbarui</button>
    <a href="DaftarBuku.php" style="text-decoration: none;">
        <button type="button" style="background-color: #f44336; color: white;">Batal</button>
    </a>
</form>

</div>

</body>
</html>
