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

// Hitung jumlah admin
$sql_admin = "SELECT COUNT(*) AS total_admin FROM pengurus";
$result_admin = $conn->query($sql_admin);

$total_admin = 0;
if ($result_admin->num_rows > 0) {
    $row_admin = $result_admin->fetch_assoc();
    $total_admin = $row_admin['total_admin'];
}

// Hitung jumlah buku
$sql_buku = "SELECT COUNT(*) AS total_buku FROM buku";
$result_buku = $conn->query($sql_buku);

$total_buku = 0;
if ($result_buku->num_rows > 0) {
    $row_buku = $result_buku->fetch_assoc();
    $total_buku = $row_buku['total_buku'];
}

// Hitung jumlah anggota
$sql_anggota = "SELECT COUNT(*) AS total_anggota FROM anggota";
$result_anggota = $conn->query($sql_anggota);

$total_anggota = 0;
if ($result_anggota->num_rows > 0) {
    $row_anggota = $result_anggota->fetch_assoc();
    $total_anggota = $row_anggota['total_anggota'];
}

// Ambil data pengaturan
$sql_pengaturan = "SELECT aturan_peminjaman, jam_operasional FROM pengaturan LIMIT 1";
$result_pengaturan = $conn->query($sql_pengaturan);

$aturan_peminjaman = "Data tidak tersedia";
$jam_operasional = "Data tidak tersedia";

if ($result_pengaturan->num_rows > 0) {
    $row_pengaturan = $result_pengaturan->fetch_assoc();
    $aturan_peminjaman = $row_pengaturan['aturan_peminjaman'];
    $jam_operasional = $row_pengaturan['jam_operasional'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="Dashboard.css">
</head>
<body>
    <div class="sidebar">
        <h2>ADMIN</h2>
        <nav>
            <div class="menu-group">
                <p>ADMIN</p>
                <a href="Dashboard.php" class="menu-item">
                    <img src="DashboardIcon.png" alt="Dashboard Icon" class="icon"> Dashboard
                </a>
            </div>
            <div class="menu-group">
                <p>MENU</p>
                <a href="DaftarBuku.php" class="menu-item">
                    <img src="BookIcon.png" alt="Books Icon" class="icon"> Data Buku
                </a>
                <a href="DaftarAnggota.php" class="menu-item">
                    <img src="MemberIcon.png" alt="Members Icon" class="icon"> Daftar Anggota
                </a>
                <a href="SejarahPerpustakaan.php" class="menu-item">
                    <img src="TentangPerpusIcon.png" alt="Library Icon" class="icon"> Tentang Perpustakaan
                </a>
            </div>
            <div class="menu-group">
                <p>SETTING</p>
                <a href="Administrator.php" class="menu-item">
                    <img src="AdministratorIcon.png" alt="Administrator Icon" class="icon"> Administrator
                </a>
            </div>
        </nav>
    </div>

    <div class="content">
        <header>
            <p>Admin</p>
            <img src="AdminIcon.png" alt="Admin Icon">
        </header>
        <div class="cards">
            <div class="card">
                <p>Admin</p>
                <h3><?php echo $total_admin; ?></h3>
                <img src="AdminIcon.png" alt="Admin Icon">
            </div>
            <div class="card">
                <p>Data Buku</p>
                <h3><?php echo $total_buku; ?></h3>
                <img src="BookIcon.png" alt="Books Icon">
            </div>
            <div class="card">
                <p>Data Anggota</p>
                <h3><?php echo $total_anggota; ?></h3>
                <img src="MemberIcon.png" alt="Members Icon">
            </div>
        </div>
        <section class="rules">
            <h3>Aturan Peminjaman Buku</h3>
            <p><?php echo $aturan_peminjaman; ?></p>
        </section>
        <section class="hours">
            <h3>Jam Operasional</h3>
            <p><?php echo $jam_operasional; ?></p>
        </section>
    </div>
</body>
</html>
