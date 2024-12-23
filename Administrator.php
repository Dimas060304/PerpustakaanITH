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

// Proses update data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $aturan_peminjaman = $conn->real_escape_string($_POST['aturan_peminjaman']);
    $jam_operasional = $conn->real_escape_string($_POST['jam_operasional']);
    $sejarah_perpustakaan = $conn->real_escape_string($_POST['sejarah_perpustakaan']);
    $visi_misi_perpustakaan = $conn->real_escape_string($_POST['visi_misi_perpustakaan']);

    $sql_update = "UPDATE pengaturan SET aturan_peminjaman='$aturan_peminjaman', jam_operasional='$jam_operasional', sejarah_perpustakaan='$sejarah_perpustakaan', visi_misi_perpustakaan='$visi_misi_perpustakaan' LIMIT 1";

    if ($conn->query($sql_update) === TRUE) {
        echo "<script>alert('Pengaturan berhasil diperbarui!'); window.location.href='Dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui pengaturan: " . $conn->error . "');</script>";
    }
}

// Ambil data pengaturan saat ini
$sql_pengaturan = "SELECT aturan_peminjaman, jam_operasional, sejarah_perpustakaan, visi_misi_perpustakaan FROM pengaturan LIMIT 1";
$result_pengaturan = $conn->query($sql_pengaturan);

$aturan_peminjaman = "";
$jam_operasional = "";
$sejarah_perpustakaan = "";
$visi_misi_perpustakaan = "";

if ($result_pengaturan->num_rows > 0) {
    $row_pengaturan = $result_pengaturan->fetch_assoc();
    $aturan_peminjaman = $row_pengaturan['aturan_peminjaman'];
    $jam_operasional = $row_pengaturan['jam_operasional'];
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
    <title>Pengaturan Administrator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .content {
            width: 60%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 1.1em;
            margin-bottom: 8px;
            color: #333;
        }

        textarea, input[type="text"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
            width: 100%;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        @media (max-width: 768px) {
            .content {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="content">
        <h2>Ubah Pengaturan</h2>
        <form method="POST" action="">
            <label for="aturan_peminjaman">Aturan Peminjaman</label>
            <textarea name="aturan_peminjaman" id="aturan_peminjaman" rows="5" required><?php echo htmlspecialchars($aturan_peminjaman); ?></textarea>

            <label for="jam_operasional">Jam Operasional</label>
            <input type="text" name="jam_operasional" id="jam_operasional" value="<?php echo htmlspecialchars($jam_operasional); ?>" required>

            <label for="sejarah_perpustakaan">Sejarah Perpustakaan</label>
            <textarea name="sejarah_perpustakaan" id="sejarah_perpustakaan" rows="5" required><?php echo htmlspecialchars($sejarah_perpustakaan); ?></textarea>

            <label for="visi_misi_perpustakaan">Visi dan Misi Perpustakaan</label>
            <textarea name="visi_misi_perpustakaan" id="visi_misi_perpustakaan" rows="5" required><?php echo htmlspecialchars($visi_misi_perpustakaan); ?></textarea>

            <button type="submit">Simpan Pengaturan</button>
        </form>
    </div>
</body>
</html>
