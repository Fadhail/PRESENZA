<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash password
    $hashedPassword = md5($password);
    $conn->autocommit(false);

    try {
        $role = 'mahasiswa'; 
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        
        $stmt->bind_param("sss", $username, $hashedPassword, $role);
        $stmt->execute();
        $userId = $stmt->insert_id;

        $email = $_POST['email'];
        $npm = $_POST['npm'];
        $nama = $_POST['nama'];
        $kelas = $_POST['kelas'];

        $stmt = $conn->prepare("INSERT INTO mahasiswa (user_id, email, npm, nama, kelas) VALUES (?, ?, ?, ?, ?)");
        
        $stmt->bind_param("issss", $userId, $email, $npm, $nama, $kelas);
        $stmt->execute();

        $conn->commit();

        header("Location: ../../public/views/login.php");
    } catch (Exception $e) {
        $conn->rollback();
        echo "Registrasi gagal: " . $e->getMessage();
    }

    $conn->autocommit(true);
}
?>
