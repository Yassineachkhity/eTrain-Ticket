<?php
session_start();

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: users_management.php');
    exit();
}

$reservation_id = $_GET['id'];

include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $train_id = $_POST['train_id'];
    $user_email = $_POST['user_email'];
    $num_passengers = $_POST['num_passengers'];
    $reservation_date = $_POST['reservation_date'];

    $sql = "UPDATE reservations 
            SET train_id='$train_id', user_email='$user_email', num_passengers='$num_passengers', reservation_date='$reservation_date' 
            WHERE id='$reservation_id'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = "Réservation mise à jour avec succès";
    } else {
        $_SESSION['error_message'] = "Erreur : " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    header('Location: users_management.php');
    exit();
} else {
    $sql = "SELECT * FROM reservations WHERE id='$reservation_id'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $reservation = $result->fetch_assoc();
    } else {
        $_SESSION['error_message'] = "Réservation non trouvée";
        header('Location: users_management.php');
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Réservation</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col">
<?php include 'adminheader.php'; ?> 
<main class="container mx-auto mt-8 flex-grow">
    <div class="text-3xl font-bold mb-6 mt-4 text-center">
        <h2>Modifier Réservation</h2>
    </div>

    <div class="p-4 bg-gray-100 rounded shadow-md">
        <form method="POST" action="#">
            <div class="mb-4">
                <label for="train_id" class="block text-gray-700">ID du Train</label>
                <input type="number" id="train_id" name="train_id" class="px-4 py-2 w-full rounded border-2 border-gray-300 focus:outline-none focus:border-blue-500" value="<?php echo $reservation['train_id']; ?>" required>
            </div>
            <div class="mb-4">
                <label for="user_email" class="block text-gray-700">Email de l'Utilisateur</label>
                <input type="email" id="user_email" name="user_email" class="px-4 py-2 w-full rounded border-2 border-gray-300 focus:outline-none focus:border-blue-500" value="<?php echo $reservation['user_email']; ?>" required>
            </div>
            <div class="mb-4">
                <label for="num_passengers" class="block text-gray-700">Nombre de Passagers</label>
                <input type="number" id="num_passengers" name="num_passengers" class="px-4 py-2 w-full rounded border-2 border-gray-300 focus:outline-none focus:border-blue-500" value="<?php echo $reservation['num_passengers']; ?>" required>
            </div>
            <div class="mb-4">
                <label for="reservation_date" class="block text-gray-700">Date de Réservation</label>
                <input type="date" id="reservation_date" name="reservation_date" class="px-4 py-2 w-full rounded border-2 border-gray-300 focus:outline-none focus:border-blue-500" value="<?php echo $reservation['reservation_date']; ?>" required>
            </div>
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Mettre à Jour</button>
        </form>
    </div>
</main>
<?php include 'footer.php'; ?>
</body>
</html>

