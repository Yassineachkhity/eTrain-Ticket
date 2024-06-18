<?php
session_start();

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex flex-col min-h-screen">
<?php include 'adminheader.php' ?> 
<img class="fixed inset-0 w-full h-full object-cover bg-gray-200 -z-10" src="images/banner1.png" alt="Carte image" loading="lazy">
<main class="container mx-auto mt-8 flex-grow">
    <h2 class="text-3xl font-bold mb-6 mt-10 text-center">Admin Dashboard</h2>
    <div class="text-center md:text-xl font-semibold grid grid-cols-1 md:grid-cols-2 gap-6 w-full md:w-1/2 mx-auto mt-12">
    <a href="train_management.php">
        <div class="border-2 border-blue-700 p-6 rounded-lg bg-white hover:bg-blue-700 hover:text-white transition-colors duration-300">
            Management des Trains
        </div>
    </a>
    <a href="users_management.php">
        <div class="border-2 border-blue-700 p-6 rounded-lg bg-white hover:bg-blue-700 hover:text-white transition-colors duration-300">
            Gestion des Utilisateurs
        </div>
    </a>
</div>



</main>

<?php include 'footer.php'; ?>
</body>
</html>

