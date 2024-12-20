<?php
include 'koneksi.php';

// Periksa koneksi
if ($koneksi->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $koneksi->connect_error]));
}

// Ambil data dari request
$data = json_decode(file_get_contents('php://input'), true);

// Periksa validitas JSON
if (json_last_error() !== JSON_ERROR_NONE) {
    die(json_encode(["status" => "error", "message" => "Invalid JSON data"]));
}

// Periksa apakah descriptor ada
if (!isset($data['descriptor'])) {
    die(json_encode(["status" => "error", "message" => "Descriptor not found in request"]));
}

// Ambil data descriptor
$descriptor = $data['descriptor'];
error_log("Descriptor: " . json_encode($descriptor));

// Ambil semua deskriptor dari tabel mahasiswa
$sql = "SELECT id, npm, descriptor FROM mahasiswa WHERE descriptor IS NOT NULL";
$result = $koneksi->query($sql);

if ($result->num_rows > 0) {
    $descriptors = [];
    while ($row = $result->fetch_assoc()) {
        $descriptors[] = [
            'id' => $row['id'],
            'npm' => $row['npm'],
            'descriptor' => json_decode($row['descriptor'])
        ];
    }

    // Cari kecocokan deskriptor
    $matched = false;
    foreach ($descriptors as $dbDescriptor) {
        $distance = euclideanDistance($descriptor, $dbDescriptor['descriptor']);
        if ($distance < 0.6) { // Threshold kecocokan
            $matched = true;
            $npm = $dbDescriptor['npm'];
            $mahasiswa_id = $dbDescriptor['id'];
            break;
        }
    }

    if ($matched) {
        $tanggal = date('Y-m-d');

        // Periksa apakah mahasiswa sudah tercatat pada tanggal ini
        $stmt_check = $koneksi->prepare("SELECT * FROM rekapitulasi WHERE mahasiswa_id = ? AND tanggal = ?");
        $stmt_check->bind_param("is", $mahasiswa_id, $tanggal);
        $stmt_check->execute();
        $check_result = $stmt_check->get_result();

        if ($check_result->num_rows > 0) {
            echo json_encode(["status" => "error", "message" => "Mahasiswa sudah tercatat hadir hari ini"]);
        } else {
            // Insert data ke tabel rekapitulasi
            $stmt_insert = $koneksi->prepare("INSERT INTO rekapitulasi (mahasiswa_id, tanggal, status) VALUES (?, ?, 'hadir')");
            $stmt_insert->bind_param("is", $mahasiswa_id, $tanggal);

            if ($stmt_insert->execute()) {
                echo json_encode(["status" => "success", "message" => "Presensi berhasil", "npm" => $npm]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error: " . $stmt_insert->error]);
            }
            $stmt_insert->close();
        }

        $stmt_check->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Wajah tidak cocok"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Tidak ada deskriptor yang ditemukan"]);
}

$koneksi->close();

// Fungsi untuk menghitung jarak Euclidean antara dua deskriptor
function euclideanDistance($d1, $d2) {
    $sum = 0;
    for ($i = 0; $i < count($d1); $i++) {
        $sum += pow($d1[$i] - $d2[$i], 2);
    }
    return sqrt($sum);
}
?>
