<?php
include 'koneksi.php';

$data = json_decode(file_get_contents('php://input'), true);
$nama = $data['nama'];
$nim = $data['nim'];
$kelas = $data['kelas'];
$descriptor = json_encode($data['descriptor']);
