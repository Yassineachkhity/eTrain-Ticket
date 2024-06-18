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
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À propos - Train Tickets</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body class="bg-gray-50 text-gray-900">

<?php include 'header.php' ?>

    <main class="w-[92%] mx-auto my-8">
        <section class="text-center my-10">
            <h1 class="text-3xl font-bold text-sky-600 mb-4">Bienvenue à Train Tickets</h1>
            <p class="text-gray-700 text-lg">Votre destination pour des réservations de billets de train simples et rapides. Découvrez nos services et nos offres exceptionnelles.</p>
        </section>

        <section class="my-8">
            <div class="flex justify-between items-center mb-4 ">
                <h2 class="text-3xl font-bold text-sky-600 text-center mx-auto">Nos Stations</h2>
            </div>
            <div class="flex gap-4 overflow-x-auto pb-4">
                <div class="min-w-[300px] flex-shrink-0">
                    <img src="images/rabat.jpeg" alt="Rabat" class="rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-center mt-2">Rabat</h3>
                </div>
                <div class="min-w-[300px] flex-shrink-0">
                    <img src="images/casablanca1.jpeg" alt="Casablanca" class="rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-center mt-2">Casablanca</h3>
                </div>
                <div class="min-w-[300px] flex-shrink-0">
                    <img src="images/tanger.jpeg" alt="Tanger" class="rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-center mt-2">Tanger</h3>
                </div>
                <div class="min-w-[300px] flex-shrink-0">
                    <img src="images/marrakech.jpeg" alt="Marrakech" class="rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-center mt-2">Marrakech</h3>
                </div>
            </div>
        </section>
    <div class="relative h-screen">
        <img class="absolute inset-0 object-cover w-full h-full" src="images/carte2.png" alt="Carte image" loading="lazy">
        <section class="absolute inset-0 flex flex-col justify-center items-center bg-opacity-50">
            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold text-sky-600">Nos Classes</h2>
            </div>
            <div class="grid md:grid-cols-2 gap-20 px-4">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-bold mb-4">Première Classe</h3>
                    <ul class="list-disc list-inside text-gray-700">
                        <li>Sièges spacieux et confortables</li>
                        <li>Wi-Fi gratuit</li>
                        <li>Service de boissons et collations</li>
                        <li>Accès aux salons VIP</li>
                    </ul>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-bold mb-4">Classe Économique</h3>
                    <ul class="list-disc list-inside text-gray-700">
                        <li>Sièges confortables</li>
                        <li>Wi-Fi gratuit</li>
                        <li>Service de boissons et collations à bord</li>
                        <li>Accès facile aux wagons-restaurants</li>
                    </ul>
                </div>
            </div>
        </section>
    </div>


    <section class="my-8">
        <div class="text-center mb-4">
            <h2 class="text-3xl font-bold text-sky-600">Abonnement Mensuel</h2>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <p class="text-lg text-gray-700 mb-4">Voyagez sans limites entre nos stations pour seulement <span class="text-sky-600 font-bold">2000 MAD par mois</span>. Inscrivez-vous dès maintenant pour profiter de nos offres exclusives.</p>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"><a href="<?php echo !$navbar ? 'login.php' : 'subscribe.php'; ?>">Subsribe</a></button>
        </div>
    </section>
</main>

<iframe class="mx-auto justify-center items-center mb-6" width="853" height="480" src="https://www.youtube.com/embed/0zpPGRqPL9w" title="Al Boraq, la transformation en marche" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>

</iframe>


<?php include 'footer.php' ?>

    <script>
        function onToggleMenu(icon) {
            const navLinks = document.querySelector('.nav-links');
            navLinks.classList.toggle('top-[-100%]');
            navLinks.classList.toggle('top-[100%]');
            icon.name = icon.name === 'menu' ? 'close' : 'menu';
        }
    </script>

</body>

</html>
