<?php
header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start output buffering
ob_start();

$response = ['status' => 'error', 'message' => 'Unknown error occurred'];

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    // Baca input JSON dari request body
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['id'])) {
        $userId = $input['id'];

        // Ganti detail koneksi di bawah dengan yang sesuai
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "projek_web";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            $response['message'] = 'Connection failed: ' . $conn->connect_error;
            echo json_encode($response);
            // Clean output buffer and exit
            ob_end_clean();
            exit();
        }

        $stmt = $conn->prepare("DELETE FROM data_user WHERE id = ?");
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'User deleted successfully';
        } else {
            $response['message'] = 'Failed to delete user';
        }

        $stmt->close();
        $conn->close();
    } else {
        $response['message'] = 'User ID is required';
    }
} else {
    $response['message'] = 'Invalid request method';
}

// Clean (erase) the output buffer and turn off output buffering
ob_end_clean();
echo json_encode($response);
?>