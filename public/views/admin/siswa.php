<?php
    include '../../../src/function/koneksi.php';

    $sql = $koneksi->prepare("SELECT m.id, m.npm, m.nama, k.nama_kelas
        FROM mahasiswa m 
        INNER JOIN kelas k ON m.kelas_id = k.id");
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        $dataMahasiswa = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $dataMahasiswa = [];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Mahasiswa</title>
    <link rel="stylesheet" href="./../../../src/css/output.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</head>

<body>
    <!-- Sidebar -->
    <?php include "./../../components/global/sidebar.php"?>

    <!-- Content -->
    <div class="p-4 sm:ml-64">
    <h1 class="">Tabel Siswa</h1>
    <!-- Table -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">id</th>
                        <th scope="col" class="px-6 py-3">NPM</th>
                        <th scope="col" class="px-6 py-3">NAMA</th>
                        <th scope="col" class="px-6 py-3">KELAS</th>
                        <th scope="col" class="px-6 py-3">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dataMahasiswa as $mahasiswa): ?>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-3"><?= htmlspecialchars($mahasiswa['id']); ?></td>
                            <td class="px-6 py-3"><?= htmlspecialchars($mahasiswa['npm']); ?></td>
                            <td class="px-6 py-3"><?= htmlspecialchars($mahasiswa['nama']); ?></td>
                            <td class="px-6 py-3"><?= htmlspecialchars($mahasiswa['nama_kelas']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>