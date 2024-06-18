<?php
session_start();

$navbar = 1;

if(!isset($_SESSION['email'])) {
    $navbar = 0;
} else {
    $navbar = 1;
}

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
<script>
        function validerStations() {
            var depart = document.getElementById('departure-station').value;
            var arrivee = document.getElementById('arrival-station').value;

            if (depart === arrivee) {
                alert('la station de départ et d\'arrivée ne peuvent pas être les mêmes');
                return false;
            }
            return true;
        }
    </script>
</head>

<body class="">
    
        <?php include 'header.php' ?>
    <div class="relative h-screen">
    <img class="absolute inset-0 object-cover w-full h-full" src="images/bg-train4.jpg" alt="Background Image">
    
    <section id="introduction" class="absolute inset-0 flex flex-col justify-center items-center bg-gray-900 bg-opacity-50">
        <div class="text-center text-white py-2">
        <h2 class="md:text-3xl text-xl font-bold md:mb-4 mb-2">
            Welcome 
            <?php 
            if ($navbar) {  
                echo '<span class="text-blue-300 uppercase">' . $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] . '</span>'; 
            } 
            ?>
            to e-Ticket Train
        </h2>

            <p class="md:text-xl font-sm text-balance">Partez sereinement. Trouvons le billet de train parfait pour votre destination !</p>
            <div id="clock" class="text-gray-300 md:p-2 md:text-2xl m-0 font-semibold  text-sm md:visible invisible"></div>
        </div>
        <section id="search" class="md:py-12 py-4 text-center w-full">
        <div class="container mx-auto border-2 border-gray-200 rounded-3xl shadow-md md:p-6 p-4 bg-opacity-75">
            <h2 class="md:text-2xl text-xl font-bold md:mb-6 mb-4 text-white">Trouvez Vos Billets</h2>
            <form onsubmit="return validerStations()" method="GET" action="search.php" class="flex flex-col md:flex-row justify-center items-center">
                <div class="mb-4 md:mr-4 md:mb-0">
                    <select id="departure-station" name="departure_station" class="px-4 py-2 w-full rounded border-2 border-gray-300 focus:outline-none focus:border-blue-500" required>
                        <option value="" disabled selected>Gare de départ</option>
                        <option value="rabat">Rabat</option>
                        <option value="casablanca">Casablanca</option>
                        <option value="marrakech">Marrakech</option>
                        <option value="tanger">Tanger</option>
                    </select>
                </div>
                <div class="mb-4 md:mr-4 md:mb-0">
                    <select id="arrival-station" name="arrival_station" class="px-4 py-2 w-full rounded border-2 border-gray-300 focus:outline-none focus:border-blue-500" required>
                        <option value="" disabled selected>Gare d'arrivée</option>
                        <option value="rabat">Rabat</option>
                        <option value="casablanca">Casablanca</option>
                        <option value="marrakech">Marrakech</option>
                        <option value="tanger">Tanger</option>
                    </select>
                </div>
                <div class="mb-4 md:mr-4 md:mb-0">
                    <input type="date" name="date" placeholder="Date" class="px-4 py-2 w-full rounded border-2 border-gray-300 focus:outline-none focus:border-blue-500" required>
                </div>
                <div class="mb-4 md:mr-4 md:mb-0">
                    <input type="number" name="passengers" placeholder="Voyageurs" class="px-4 py-2 w-full rounded border-2 border-gray-300 focus:outline-none focus:border-blue-500"  min="1" required>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Chercher</button>
            </form>
        </div>
        <div class="mt-10">
            <button class="text-white bg-blue-500 hover:bg-blue-700 text-center rounded-full p-2">
                <a class="md:text-xl no-underline md:pt-7 md:m-3 pt-4 m-2 text-sm" href="plan.php">Découvrir nos plans</a>
            </button>
        </div>
    </section>
</div>

<?php include 'footer.php' ?>
<script src="script.js"></script>  
</body>
</html>