<?php
    include 'connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $nama = $_POST['nama'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $tempat_lahir = $_POST['tempat_lahir'];
        $tanggal_lahir = $_POST['tanggal_lahir'];
        $password = password_hash($_POST['password1'], PASSWORD_DEFAULT);
    
        $sql = "INSERT INTO data_user (username, email, nama, jenis_kelamin, tempat_lahir, tanggal_lahir, password)
                VALUES ('$username', '$email', '$nama', '$jenis_kelamin', '$tempat_lahir', '$tanggal_lahir', '$password')";
    
        if ($conn->query($sql) === TRUE) {
            echo "Registrasi berhasil";
            header('location:Halaman_login.html');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
        $conn->close();
    }
?>