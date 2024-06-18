<?php
session_start();
$success = 0;
$navbar = 1;
if (!isset($_SESSION['email'])) {
    $navbar = 0;
    header("Location: login.php");
    exit();
}

include '../connect.php';
$user_email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    function validate($data) {
      $data = htmlentities($data);
      $data = trim($data);
      return $data;
    }
    $object_name = validate($_POST['object_name']);
    $description = validate($_POST['description']);
    $location = validate($_POST['location']);
    $date_lost = validate($_POST['date_lost']);

    // Récupérer l'ID de l'utilisateur basé sur l'email de session
    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();

    // Insérer les informations dans la table lost_objects
    $sql = "INSERT INTO lost_objects (user_id, object_name, description, location, date_lost) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $user_id, $object_name, $description, $location, $date_lost);
    if ($stmt->execute()) {
        $success = 1;
    } else {
        echo "Erreur : " . $stmt->error;
    }
    $stmt->close();


}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signaler un objet perdu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col">
<header class="bg-white border-b-2 border-b-zinc-600 md:z-50 z-200">
    <nav class="flex justify-between items-center w-[92%] mx-auto">
        <div>
            <a href="../home.php"><img src="../images/logo1.png" alt="logo" class="w-16"></a>
        </div>
        <div class="flex items-center gap-6">
            <button class="bg-slate-100 border-2 border-blue-500 hover:bg-blue-500 font-bold hover:text-white hover:border-transparent py-2 px-4 rounded"><a href="logout.php">Logout</a></button>
        </div>
    </nav>
</header>
    <img class="fixed inset-0 w-full h-full object-cover opacity-70 -z-10" src="../images/trainvalise.jpg" alt="perdu" loading="lazy">
    <main class="container mx-auto py-8 flex-grow">
        <h1 class="text-3xl font-bold mb-6 text-center">Signaler un objet perdu</h1>
        <form action="contact.php" method="post" class="max-w-lg mx-auto bg-orange-100  rounded-2xl p-8 shadow-lg">
            <div class="mb-4">
                <label for="object_name" class="block text-gray-700">Nom de l'objet</label>
                <input type="text" name="object_name" id="object_name" class="mt-1 block w-full border-gray-700 border-2 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Description</label>
                <textarea name="description" id="description" class="mt-1 block w-full border-gray-700 border-2 rounded-md shadow-sm" required></textarea>
            </div>
            <div class="mb-4">
                <label for="location" class="block text-gray-700">Lieu</label>
                <input type="text" name="location" id="location" class="mt-1 block w-full border-gray-700  border-2 rounded-md shadow-sm">
            </div>
            <div class="mb-4">
                <label for="date_lost" class="block text-gray-700">Date de perte</label>
                <input type="date" name="date_lost" id="date_lost" class="mt-1 block w-full border-gray-700 border-2 rounded-md shadow-sm">
            </div>
            <?php
              if ($success) {
                echo "<div class='text-green-600 font-smeibold text-center text-lg'>L'objet perdu a été signalé avec succès.</div>";
              }
            ?>
            <div class="mt-4 mx-auto text-center flex justify-evenly">
                <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"><a href="../contact.php">Retour</a></button>
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Signaler</button>
            </div>
        </form>
</main>
    <?php include '../footer.php'; ?>
</body>
</html>
