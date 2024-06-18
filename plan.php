<?php
session_start();

$navbar = isset($_SESSION['email']) ? 1 : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Train Tickets</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body class="flex flex-col min-h-screen bg-gray-100">

    <?php include 'header.php'; ?>

    <img class="fixed inset-0 w-full h-full object-cover opacity-20 -z-10" src="images/carte.png" alt="Background Image">
    
    <main class="flex-grow">
        <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-semibold text-center mb-8">
            <span class="text-blue-600 block no-wrap">"Parce que nous ne voyageons pas tous de la même façon ni pour les mêmes raisons,</span>
            <span class="text-gray-800 block">eTicket Train vous propose une offre diversifiée"</span>
        </h1>


            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="card-image bg-cover h-48" style="background-image: url('images/train_nuit.jpg');"></div>
                    <div class="p-4">
                        <h2 class="text-xl font-bold mb-2">Trains de nuit</h2>
                        <p class="text-gray-700">Partez en fin de soirée, dormez confortablement et réveillez-vous à destination au petit matin pour profiter de la journée !</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="card-image bg-cover h-48" style="background-image: url('images/train_route.jpg');"></div>
                    <div class="p-4">
                        <h2 class="text-xl font-bold mb-2">Transport rail-route</h2>
                        <p class="text-gray-700">Qu'à cela ne tienne ! Le train ne desservait pas Agadir, Tanger ou Smara ? Le train y arrive... mais par la route !</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="card-image bg-cover h-48" style="background-image: url('images/train_urbain.jpg');"></div>
                    <div class="p-4">
                        <h2 class="text-xl font-bold mb-2">Transport urbain</h2>
                        <p class="text-gray-700">Naviguez facilement dans les villes grâce à notre réseau de transport urbain pratique et efficient.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

</body>
</html>
