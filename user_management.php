<?php
session_start();
    include 'connection.php';

// Ambil data pengguna dari database
$sql = "SELECT id_anggota, nama_anggota, nim, prodi, jenis_kelamin, telepon, email, alamat  FROM anggota";
$result = $conn->query($sql);

$users = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Tutup koneksi
$conn->close();

// Keluarkan data pengguna sebagai JSON
header('Content-Type: application/json');
echo json_encode($users);
?>