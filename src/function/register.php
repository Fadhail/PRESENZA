<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $npm = $_POST['npm'];
    $nama = $_POST['nama'];
    $kelas_id = isset($_POST['kelas']) ? intval($_POST['kelas']) : null;

if ($kelas_id === null) {
    die('Kelas belum dipilih.');
}
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $koneksi->autocommit(false);

    try {
        $role = 'mahasiswa';
        $stmt = $koneksi->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashedPassword, $role);
        $stmt->execute();
        $userId = $stmt->insert_id;

        // Insert ke tabel mahasiswa
        $stmt = $koneksi->prepare("INSERT INTO mahasiswa (user_id, email, npm, nama, kelas_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $userId, $email, $npm, $nama, $kelas_id);
        $stmt->execute();
        $koneksi->commit();

        // Redirect ke halaman login
        header("Location: ../../public/views/login.php");
        exit();
    } catch (Exception $e) {
        $koneksi->rollback();
        echo "Registrasi gagal: " . $e->getMessage();
    }

    $koneksi->autocommit(true);
}
?>
