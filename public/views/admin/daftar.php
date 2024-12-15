<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftarkan Mahasiswa</title>
    <link rel="stylesheet" href="./../../../src/css/output.css">
    <script defer src="./../../../src/js/script.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</head>

<body>
    <!-- Sidebar -->
    <?php include "./../../components/global/sidebar.php"?>

    <!-- Content -->
    <div class="p-4 sm:ml-64">
    <h1 class="">Daftarkan Mahasiswa</h1>

    <div class="flex justify-center items-center min-h-screen p-6">

        <div class="flex flex-col gap-8 max-w-lg w-full">

            <!-- Video Section -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <video id="video" width="100%" height="auto" autoplay muted class="w-full h-auto"></video>
            </div>

            <!-- Registration Form Section -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-semibold text-center mb-4 text-gray-700">Register Your Face</h2>

                <input type="text" id="name" placeholder="Enter name for registration"
                    class="rounded-lg py-3 px-4 w-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" /><br>

                <button id="register"
                    class="w-full py-3 px-6 bg-blue-600 text-white font-medium rounded-lg mt-6 hover:bg-blue-700 transition duration-200">
                    Register Face
</button>
        </div>
    </div>
</body>

</html>