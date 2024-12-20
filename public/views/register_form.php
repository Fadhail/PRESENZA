<?php
include '../../src/function/koneksi.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css">
</head>
<body class="bg-gray-50 dark:bg-gray-900">
<?php include '../components/global/navbar.php'; ?>

<div class="min-h-screen flex flex-col items-center justify-center py-6 px-4">
        <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Form Registrasi</h2>
            <form action="../../src/function/register.php" method="POST">
                <div class="mb-4">
                    <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                    <input type="text" name="username" id="username" class="w-full p-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                    <input type="email" name="email" id="email" class="w-full p-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                    <input type="password" name="password" id="password" class="w-full p-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                </div>

                <div class="mb-4">
                    <label for="npm" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NPM</label>
                    <input type="text" name="npm" id="npm" class="w-full p-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                </div>

                <div class="mb-4">
                    <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                    <input type="text" name="nama" id="nama" class="w-full p-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                </div>

                <!-- Kelas Dropdown -->
            <div class="mb-4">
            <label for="kelas">Pilih Kelas:</label>
    <select name="kelas" id="kelas">
        <option value="" disabled selected>Pilih Kelas</option>
        <?php
        $query = "SELECT id, nama_kelas FROM kelas";
        $result = $koneksi->query($query);
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['nama_kelas']}</option>";
        }
        ?>
    </select>
            </div>

                <button type="submit" class="w-full p-2 bg-blue-500 text-white rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Daftar</button>
                <p class="text-sm font-light text-gray-500 dark:text-gray-400 mt-4">
                    Sudah punya akun? <a href="login.php" class="font-medium text-blue-600 hover:underline dark:text-blue-500">Login di sini</a>
                </p>
            </form>
        </div>
    </div>

</body>
</html>
