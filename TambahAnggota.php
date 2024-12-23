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

// Cek jika form disubmit
if (isset($_POST['add'])) {
    $nama_anggota = htmlspecialchars($_POST['nama_anggota']);
    $id_anggota = htmlspecialchars($_POST['id_anggota']);
    $nim = htmlspecialchars($_POST['nim']);
    $prodi = htmlspecialchars($_POST['prodi']);
    $telepon = htmlspecialchars($_POST['telepon']);
    $email = htmlspecialchars($_POST['email']);
    $jenis_kelamin = htmlspecialchars($_POST['jenis_kelamin']);
    $alamat = htmlspecialchars($_POST['alamat']);

    // Query untuk insert data
    $sql = "INSERT INTO anggota (id_anggota, nama_anggota, nim, prodi, telepon, email, jenis_kelamin, alamat) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $id_anggota, $nama_anggota, $nim, $prodi, $telepon, $email, $jenis_kelamin, $alamat);

    if ($stmt->execute()) {
        echo "<script>alert('Data anggota berhasil ditambahkan!'); window.location.href='DaftarAnggota.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data anggota: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Anggota</title>
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
        .form-row input, .form-row select {
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
        <div class="title">ADMIN</div>
        <div class="profile">
            <span>Admin</span>
            <img src="AdminIcon.png" alt="Admin Icon">
        </div>
    </div>

    <div class="content">
        <h2 class="content-title">TAMBAH ANGGOTA</h2>
        <form action="TambahAnggota.php" method="POST">
            <div class="form-container">
                <div class="form-header">TAMBAH ANGGOTA</div>
                <div class="form-row">
                    <label for="nama_anggota"><span>Nama :</span></label>
                    <input type="text" id="nama_anggota" name="nama_anggota" placeholder="Masukkan nama" required>
                </div>
                <div class="form-row">
                    <label for="id_anggota"><span>Id Anggota :</span></label>
                    <input type="text" id="id_anggota" name="id_anggota" placeholder="Masukkan id" required>
                </div>
                <div class="form-row">
                    <label for="nim"><span>Nim :</span></label>
                    <input type="text" id="nim" name="nim" placeholder="Masukkan nim" required>
                </div>
                <div class="form-row">
                    <label for="prodi"><span>Prodi :</span></label>
                    <input type="text" id="prodi" name="prodi" placeholder="Masukkan prodi" required>
                </div>
                <div class="form-row">
                    <label for="no_telepon"><span>No Telepon :</span></label>
                    <input type="text" id="no_telepon" name="telepon" placeholder="Masukkan no telepon" required>
                </div>
                <div class="form-row">
                    <label for="email"><span>Email :</span></label>
                    <input type="email" id="email" name="email" placeholder="Masukkan email" required>
                </div>
                <div class="form-row">
                    <label for="jenis_kelamin"><span>Jenis Kelamin :</span></label>
                    <select id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="">Pilih jenis kelamin</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="form-row">
                    <label for="alamat"><span>Alamat :</span></label>
                    <input type="text" id="alamat" name="alamat" placeholder="Masukkan alamat" required>
                </div>
            </div>
            <div class="form-buttons">
                <button type="submit" class="btn save" name="add">Simpan</button>
                <button type="reset" class="btn cancel" onclick="window.location.href='DaftarAnggota.php'">Batal</button>
            </div>
        </form>
    </div>
</body>
</html>
