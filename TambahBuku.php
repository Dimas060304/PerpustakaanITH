<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db = "perpustakaan";

$conn = new mysqli($host, $user, $pass, $db);

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

    // Upload cover buku
    $cover_buku = $_FILES['cover_buku']['name'];
    $target_dir = "uploads/";

    // Pastikan folder uploads ada, jika tidak buat
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Mengganti spasi dengan karakter lain (misalnya '_')
    $cover_buku = str_replace(' ', '_', $cover_buku);
    $target_file = $target_dir . basename($cover_buku);

    // Memindahkan file
    if (move_uploaded_file($_FILES['cover_buku']['tmp_name'], $target_file)) {
        $sql = "INSERT INTO buku (judul_buku, kode_buku, penerbit_buku, penulis_buku, keterangan, isbn_issn, jumlah_buku, tahun_terbit, cover_buku) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssiss", $judul_buku, $kode_buku, $penerbit_buku, $penulis_buku, $keterangan, $isbn_issn, $jumlah_buku, $tahun_terbit, $target_file);

        if ($stmt->execute()) {
            echo "<script>alert('Buku berhasil ditambahkan!'); window.location='DaftarBuku.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Gagal mengupload cover buku.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #65c3a3;
            position: fixed;
            display: flex;
            flex-direction: column;
            padding-top: 20px;
            z-index: 10;
        }
        .sidebar h1 {
            color: white;
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }
        .sidebar .menu-section {
            margin-bottom: 20px;
        }
        .sidebar .menu-section h2 {
            color: white;
            font-size: 14px;
            text-transform: uppercase;
            padding-left: 15px;
            margin-bottom: 10px;
        }
        .sidebar .menu-section a {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .sidebar .menu-section a:hover {
            background-color: #4aa683;
        }
        .sidebar .menu-section a img {
            width: 24px;
            height: 24px;
            margin-right: 10px;
        }
        .topbar {
            margin-left: 250px;
            background-color: #d9f2eb;
            height: 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }
        .topbar .title {
            font-size: 24px;
            font-weight: bold;
            color: #2d5542;
        }
        .topbar .profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .topbar .profile span {
            font-size: 16px;
            color: #2d5542;
        }
        .topbar .profile img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
        }
        .form-container {
            margin-left: 250px;
            padding: 20px;
            max-width: 600px;
            margin-top: 20px;
        }
        .form-header {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }
        .form-row {
            display: flex;
            gap: 10px;
            padding: 10px 20px;
            background-color: #f2f2f2;
            border-bottom: 1px solid #ccc;
            align-items: center;
        }
        .form-row:nth-child(odd) {
            background-color: #e9e9e9;
        }
        .form-row label {
            font-weight: bold;
            min-width: 120px;
        }
        .form-buttons {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }
        .btn {
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn.save {
            background-color: #007bff;
            color: white;
        }
        .btn.save:hover {
            background-color: #0056b3;
        }
        .btn.cancel {
            background-color: #f44336;
            color: white;
        }
        .btn.cancel:hover {
            background-color: #c1351d;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h1>Perpustakaan</h1>
        <div class="menu-section">
            <h2>Menu</h2>
            <a href="Dashboard.html"><img src="DashboardIcon.png" alt="Dashboard Icon"> Dashboard</a>
            <a href="DaftarBuku.php"><img src="BookIcon.png" alt="Books Icon"> Data Buku</a>
            <a href="DaftarAnggota.html"><img src="MemberIcon.png" alt="Members Icon"> Daftar Anggota</a>
            <a href="SejarahPerpustakaan.html"><img src="TentangPerpusIcon.png" alt="Library Icon"> Tentang Perpustakaan</a>
        </div>
        <div class="menu-section">
            <h2>Pengaturan</h2>
            <a href="Administrator.html"><img src="AdministratorIcon.png" alt="Administrator Icon"> Administrator</a>
        </div>
    </div>

    <!-- Topbar -->
    <div class="topbar">
        <div class="title">Tambah Buku</div>
        <div class="profile">
            <span>Admin</span>
            <img src="AdminIcon.png" alt="Admin Icon">
        </div>
    </div>

    <!-- Form Tambah Buku -->
    <div class="form-container">
        <div class="form-header">Form Tambah Buku</div>
        <form action="TambahBuku.php" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <label>Judul Buku</label>
                <input type="text" name="judul_buku" required>
            </div>
            <div class="form-row">
                <label>Kode Buku</label>
                <input type="text" name="kode_buku" required>
            </div>
            <div class="form-row">
                <label>Penerbit Buku</label>
                <input type="text" name="penerbit_buku" required>
            </div>
            <div class="form-row">
                <label>Penulis Buku</label>
                <input type="text" name="penulis_buku" required>
            </div>
            <div class="form-row">
                <label>Keterangan</label>
                <textarea name="keterangan" required></textarea>
            </div>
            <div class="form-row">
                <label>ISBN/ISSN</label>
                <input type="text" name="isbn_issn" required>
            </div>
            <div class="form-row">
                <label>Jumlah Buku</label>
                <input type="number" name="jumlah_buku" required>
            </div>
            <div class="form-row">
                <label>Tahun Terbit</label>
                <input type="number" name="tahun_terbit" required>
            </div>
            <div class="form-row">
                <label>Cover Buku</label>
                <input type="file" name="cover_buku" required>
            </div>
            <div class="form-buttons">
                <button class="btn save" type="submit" name="add">Tambah Buku</button>
                <button class="btn cancel" type="reset" onclick="window.location.href='DaftarBuku.php'">Batal</button>
            </div>
        </form>
    </div>
</body>
</html>
