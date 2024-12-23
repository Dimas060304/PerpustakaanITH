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

// Proses login jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // Cek data di tabel pengurus
    $sql = "SELECT * FROM pengurus WHERE nama_pengurus='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Login berhasil
        echo "<script>alert('Login berhasil!'); window.location.href='Dashboard.php';</script>";
    } else {
        // Login gagal
        echo "<script>alert('Username atau password salah!');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Login</title>
    <link rel="stylesheet" href="Login.css">
</head>
<body>
    <div class="login-container">
        <h2>LOGIN</h2>
        <form method="POST" action="">
            <input type="text" placeholder="Username" name="username" required>
            <input type="password" placeholder="Password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
    <div class="footer">
        &copy; 2024 &mdash; Perpustakaan Institut Teknologi Bacharuddin Jusuf Habibie
    </div>
</body>
</html>
