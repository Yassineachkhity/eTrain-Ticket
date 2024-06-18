<?php

session_start();

$navbar = 1;

if(!isset($_SESSION['email'])) {
    $navbar = 0;
} else {
    $navbar = 1;
}

$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connect.php';

    
    $username = verify($_POST['username']);
    $email = verify($_POST['email']);
    $message = verify($_POST['message']);

    $sql = "INSERT INTO `contact` (username, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    $stmt->bind_param("sss", $username, $email, $message);
                
    if ($stmt->execute()) {
        $success = true;
        usleep(2000000);
        header("Location:contact.php");
        exit();
    } else {
        die("Error during insertion: " . $conn->error);
    }
    $stmt->close();
}



function verify($data) {
    $data = htmlspecialchars(trim($data));
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="script.js"></script>

    <style>
        @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }
  .fade-in {
    animation: fadeIn 1s ease-in-out;
  }
    </style>

</head>
<body>
<?php include 'header.php' ?>
<div class="relative h-screen">
        
        <img class="absolute inset-0 object-cover w-full h-full" src="images/bg-contact2.jpg" alt="Background Image Contact">    
        <section id="contactpage" class="absolute inset-0 flex justify-center items-center  bg-gray-900 bg-opacity-50">
            <div class="container mx-auto p-4 fade-in">
                <div class=" p-8 rounded-lg shadow-lg max-w-lg mx-auto">
                    <h2 class="text-2xl font-bold mb-6 text-white text-center">Contact Us</h2>
                    <form action="contact.php" method='post'>
                        <div class="mb-4">
                            <label for="username" class="block text-white">Name</label>
                            <input type="text" id="name" name="username" class="w-full px-3 py-2 border bg-gray-600 text-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200" placeholder="Enter your full name" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-white">Email</label>
                            <input type="email" id="email" name="email" class="w-full px-3 py-2 border bg-gray-600 text-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200" placeholder="example@gmail.com" required>
                        </div>
                        <div class="mb-4">
                            <label for="message" class="block text-white">Message</label>
                            <textarea id="message" name="message" rows="4" class="w-full px-3 py-2 border rounded-lg bg-gray-600 text-gray-200  focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="bg-blue-500 text-white px-6 py-2 w-full rounded-lg hover:bg-blue-700 transition duration-200">Send</button>
                        </div>
                        <div class="text-center">
                            <?php
                                if ($success) {
                                    echo '<div id="successMessage" class="bg-green-100 border border-green-400 text-green-700 px-6 py-2 mt-2 rounded relative mb-1">
                                    Your message was sent successfully to support team :)
                                </div>';
                                }
                            ?>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                            //animation contact page
            document.addEventListener('DOMContentLoaded', function () {
                const formElements = document.querySelectorAll('input, textarea, button');
                formElements.forEach(el => {
                    el.classList.add('fade-in');
                });
                });
            </script>
        </section>  
</div>

<section>
    <div class="container mx-auto border-2 border-gray-300 rounded-lg shadow-md p-6 m-10">
    <h2 class="text-2xl font-bold mb-6 text-center">Objets Perdus</h2>
    Vous avez perdu un objet en gare ou à bord du train ? Ne paniquez pas, nous ferons de notre mieux pour vous aider à le retrouver. Voici les étapes à suivre : <br>
    <ol class="list-decimal pl-8">
        <li>Connectez-vous sur eTicket.com </li>
        <li>Remplissez le formulaire des données personnelles et de voyage</li>
        <li>Choisissez la catégorie SAV puis sélectionnez le champ 'Objets Perdus'</li>
        <li>Rédigez un message en décrivant votre objet perdu</li>
        <li>Envoyez votre plainte</li>
    </ol>
<span class="text-gray-500">Nous vous recommandons de <span class="text-red-400">signaler</span> cette perte à notre personnel à bord ou en gare aussitôt que possible en décrivant en détails votre effet personnel, son contenu éventuel et en laissant vos coordonnées pour nous permettre de vous joindre. Grâce à ce signalement, nous déclencherons immédiatement les recherches utiles pour essayer de retrouver votre bien. <br></span>
    </div>
</section>

<div class="text-center">
    <button type="submit" class="text-center text-white font-semibold m-2 p-4 border-none rounded-xl bg-blue-500 hover:bg-blue-700 "><a href="objetPerdus/contact.php">Report lost items</a></button>
</div>
    

<section>
    <div class="container mx-auto border-2 border-gray-500 rounded-lg shadow-md p-6 m-10">
        <h2 class="text-2xl font-bold mb-6 text-center">Que Disent Nos Voyageurs</h2>
        <div class="container mx-auto border-2 border-gray-200 rounded-lg shadow-inner p-6 m-8 ">
            <h4 class="font-semibold">ACHKHITY YASSINE | <span class="text-gray-500">Ingénieur informatique <br></span></h4>
            <br>
            Très bon site web. Je suis content que eTicket ait pris cette initiative pour être à l'écoute de ses clients.
        </div>
        <div class="container mx-auto border-2 border-gray-200 rounded-lg shadow-inner p-6 m-8">
            <h4 class="font-semibold">YASSINE ACHKHITY | <span class="text-gray-500">Fondateur d'agence touristique <br></span></h4>
            <br>
            eTicket donne le moyen aux voyageurs de s'exprimer directement et ça crée le lien de proximité qui manquait.
        </div>

    </div>
</section>

<section>
    <div class="container mx-auto border-2 border-gray-500 rounded-lg shadow-md p-6 m-10">
        <h2 class="text-2xl font-bold mb-6 text-center">Postuler</h2>
        <div class="container mx-auto border-2 border-gray-200 rounded-lg shadow-inner p-6 m-8 ">
            <h4 class="font-semibold">Eticket Train</h4>
            <br>
            On est fier que tu sois parmi nous ne ratter pas la chance et devenir un membre parmis nous.
        </div>
        <div class="text-center">
            <button type="submit" class="text-center text-white font-semibold m-2 p-4 border-none rounded-xl bg-blue-500 hover:bg-blue-700 "><a href="application.php">Apply now</a></button>
        </div>
    </div>
</section>

<div class="flex justify-center mt-10 space-x-6 border-t-2 border-b-2 border-gray-600 mb-10 w-1/2 mx-auto py-6">
        <a href="mailto:yassineachkhity56@gmail.com" class="text-gray-600 hover:text-red-500 transition duration-300">
            <i class="fas fa-envelope fa-3x"></i>
        </a>
        <a href="https://www.linkedin.com/in/yassine-achkhity" class="text-gray-600 hover:text-blue-700 transition duration-300">
            <i class="fab fa-linkedin fa-3x"></i>
        </a>
        <a href="https://github.com/yassineachkhity" class="text-gray-600 hover:text-black transition duration-300">
            <i class="fab fa-github fa-3x"></i>
        </a>
        <a href="https://www.facebook.com/yassine.achkhity.9" class="text-gray-600 hover:text-blue-600 transition duration-300">
            <i class="fab fa-facebook fa-3x"></i>
        </a>
    </div>
</div>

<?php include 'footer.php' ?>
<script>
    
</script>
</body>
</html>