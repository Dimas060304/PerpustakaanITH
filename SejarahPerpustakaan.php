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

// Ambil data pengaturan
$sql_pengaturan = "SELECT sejarah_perpustakaan, visi_misi_perpustakaan FROM pengaturan LIMIT 1";
$result_pengaturan = $conn->query($sql_pengaturan);

$sejarah_perpustakaan = "";
$visi_misi_perpustakaan = "";

if ($result_pengaturan->num_rows > 0) {
    $row_pengaturan = $result_pengaturan->fetch_assoc();
    $sejarah_perpustakaan = $row_pengaturan['sejarah_perpustakaan'];
    $visi_misi_perpustakaan = $row_pengaturan['visi_misi_perpustakaan'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Perpustakaan</title>
    <link rel="stylesheet" href="SejarahPerpustakaan.css">
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
        <h1>Sejarah Perpustakaan</h1>
        <p><?php echo nl2br(htmlspecialchars($sejarah_perpustakaan)); ?></p>
        <div class="vision-mission">
            <h2>VISI & MISI</h2>
            <p><?php echo nl2br(htmlspecialchars($visi_misi_perpustakaan)); ?></p>
        </div>
    </div>
</body>
</html>
