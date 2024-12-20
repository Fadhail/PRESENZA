<?php
include 'koneksi.php';

if ($koneksi->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $koneksi->connect_error]));
}

$data = json_decode(file_get_contents('php://input'), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die(json_encode(["status" => "error", "message" => "Invalid JSON data"]));
}

if (!isset($data['descriptor']) || !isset($data['npm'])) {
    die(json_encode(["status" => "error", "message" => "Descriptor or NPM not found in request"]));
}

$descriptor = json_encode($data['descriptor']);
error_log("Descriptor: " . $descriptor);
error_log("NPM: " . $npm);

$sql = "SELECT id FROM mahasiswa WHERE npm = '$npm'";
$result = $koneksi->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_id = $row['id'];

    $sql = "UPDATE mahasiswa SET descriptor = '$descriptor' WHERE id = $user_id";
    error_log("SQL Query: " . $sql);

    if ($koneksi->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Face descriptor registered successfully!"]);
    } else {
        error_log("SQL Error: " . $koneksi->error);
        echo json_encode(["status" => "error", "message" => "Error: " . $sql . "<br>" . $koneksi->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "NPM not found"]);
}

$koneksi->close();
?>