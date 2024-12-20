<?php
session_start();
include '../../../src/function/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'mahasiswa') {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['user_id'])) {
    die("User ID is not set in session.");
}
$user_id = $_SESSION['user_id'];

$sql = $koneksi->prepare("SELECT m.npm, m.nama, k.nama_kelas, r.tanggal, s.nama_status
                          FROM mahasiswa m 
                          INNER JOIN rekapitulasi r ON m.id = r.mahasiswa_id
                          INNER JOIN kelas k ON m.kelas_id = k.id
                          INNER JOIN status s ON r.status_id = s.id
                          WHERE m.user_id = ?");

if (!$sql) {
    die("Error preparing statement: " . $koneksi->error);
}

$sql->bind_param("i", $user_id);

if (!$sql->execute()) {
    die("Query execution failed: " . $sql->error);
}

$result = $sql->get_result();
if ($result->num_rows > 0) {
    $dataHistory = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $dataHistory = [];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Presensi <?php echo htmlspecialchars($_SESSION['username']); ?></title>
    <link rel="stylesheet" href="./../../../src/css/output.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</head>

<body>
    <!-- Sidebar -->
    <?php include "./../../components/global/usersidebar.php" ?>

    <!-- Content -->
    <div class="p-4 sm:ml-64">
        <h1 class="text-2xl font-bold mb-4">Riwayat Presensi</h1>
        <!-- Table -->
        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6">NPM</th>
                        <th scope="col" class="py-3 px-6">Nama</th>
                        <th scope="col" class="py-3 px-6">Kelas</th>
                        <th scope="col" class="py-3 px-6">Tanggal</th>
                        <th scope="col" class="py-3 px-6">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dataHistory)): ?>
                        <?php foreach ($dataHistory as $row): ?>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="py-4 px-6"><?php echo htmlspecialchars($row['npm']); ?></td>
                                <td class="py-4 px-6"><?php echo htmlspecialchars($row['nama']); ?></td>
                                <td class="py-4 px-6"><?php echo htmlspecialchars($row['nama_kelas']); ?></td>
                                <td class="py-4 px-6"><?php echo htmlspecialchars($row['tanggal']); ?></td>
                                <td class="py-4 px-6"><?php echo htmlspecialchars($row['nama_status']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td colspan="5" class="py-4 px-6 text-center">Tidak ada data</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
