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

// Ambil data anggota berdasarkan ID
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $result = $conn->query("SELECT * FROM anggota WHERE id_anggota = $id");
    $anggota = $result->fetch_assoc();
}

// Proses update data
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama_anggota = htmlspecialchars($_POST['nama_anggota']);
    $nim = htmlspecialchars($_POST['nim']);
    $prodi = htmlspecialchars($_POST['prodi']);
    $telepon = htmlspecialchars($_POST['telepon']);
    $email = htmlspecialchars($_POST['email']);
    $jenis_kelamin = htmlspecialchars($_POST['jenis_kelamin']);
    $alamat = htmlspecialchars($_POST['alamat']);

    // Query update data
    $sql = "UPDATE anggota SET nama_anggota=?, nim=?, prodi=?, telepon=?, email=?, jenis_kelamin=?, alamat=? WHERE id_anggota=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $nama_anggota, $nim, $prodi, $telepon, $email, $jenis_kelamin, $alamat, $id);
    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location.href='DaftarAnggota.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anggota</title>
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
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .content-title {
            font-size: 24px;
            font-weight: bold;
            color: #2d5542;
            margin-bottom: 20px;
        }
        .form-container {
            max-width: 600px;
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 8px;
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
            flex-direction: column;
            gap: 5px;
            margin-bottom: 15px;
        }
        .form-row label span {
            font-weight: bold;
            color: #2d5542;
        }
        .form-row input, .form-row select, .form-row textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        .form-buttons {
            display: flex;
            gap: 10px;
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
    <div class="sidebar">
        <h1>ADMIN</h1>
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

    <div class="topbar">
        <div class="title">EDIT ANGGOTA</div>
        <div class="profile">
            <span>Admin</span>
            <img src="AdminIcon.png" alt="Admin Icon">
        </div>
    </div>

    <div class="content">
        <h2 class="content-title">EDIT DATA ANGGOTA</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?= $anggota['id_anggota']; ?>">
            <div class="form-container">
                <div class="form-header">Edit Anggota</div>
                <div class="form-row">
                    <label for="nama_anggota"><span>Nama Anggota :</span></label>
                    <input type="text" name="nama_anggota" value="<?= $anggota['nama_anggota']; ?>" required>
                </div>
                <div class="form-row">
                    <label for="nim"><span>NIM :</span></label>
                    <input type="text" name="nim" value="<?= $anggota['nim']; ?>" required>
                </div>
                <div class="form-row">
                    <label for="prodi"><span>Prodi :</span></label>
                    <input type="text" name="prodi" value="<?= $anggota['prodi']; ?>" required>
                </div>
                <div class="form-row">
                    <label for="telepon"><span>Telepon :</span></label>
                    <input type="text" name="telepon" value="<?= $anggota['telepon']; ?>" required>
                </div>
                <div class="form-row">
                    <label for="email"><span>Email :</span></label>
                    <input type="email" name="email" value="<?= $anggota['email']; ?>" required>
                </div>
                <div class="form-row">
                    <label for="jenis_kelamin"><span>Jenis Kelamin :</span></label>
                    <input type="text" name="jenis_kelamin" value="<?= $anggota['jenis_kelamin']; ?>" required>
                </div>
                <div class="form-row">
                    <label for="alamat"><span>Alamat :</span></label>
                    <textarea name="alamat" rows="4" required><?= $anggota['alamat']; ?></textarea>
                </div>
                <div class="form-buttons">
                    <button type="submit" class="btn save" name="update">Simpan Perubahan</button>
                    <a href="DaftarAnggota.php" class="btn cancel">Batal</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
