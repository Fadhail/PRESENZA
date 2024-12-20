<?php
session_start();
include '../../../src/function/koneksi.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'mahasiswa') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Mahasiswa</title>
    <link rel="stylesheet" href="../../../src/css/output.css">
    <script defer src="../../../src/js/face-api.min.js"></script>
    <script defer src="../../../src/js/script.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</head>

<body>
    <!-- Sidebar -->
    <?php include "./../../components/global/userSidebar.php"?>

    <!-- Content -->
    <div class="p-4 sm:ml-64">
    <h1 class="">Dashboard <?php echo $_SESSION['username'] ?> </h1>
    <!-- Content -->
    <div class="min-h-screen flex flex-col items-center justify-center py-6 px-4">
        <!-- Presensi Form Section -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-semibold text-center mb-4 text-gray-700">Presensi Mahasiswa</h2>
            <!-- Video Section -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <video id="inputVideo" width="100%" height="auto" autoplay muted class="w-full h-auto"></video>
            </div>
            <button id="presensi"
                class="w-full py-3 px-6 bg-blue-600 text-white font-medium rounded-lg mt-6 hover:bg-blue-700 transition duration-200">
                Presensi
            </button>
        </div>
    </div>
    </div>
</body>

</html>