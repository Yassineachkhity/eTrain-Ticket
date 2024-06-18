<?php
session_start();

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'connect.php';

if (!isset($_GET['id'])) {
    header('Location: train_management.php');
    exit();
}

$train_id = $_GET['id'];
$sql = "SELECT * FROM trains WHERE id = $train_id";
$result = $conn->query($sql);

if ($result->num_rows != 1) {
    header('Location: train_management.php');
    exit();
}

$train = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $train_number = $_POST['train_number'];
    $departure_station = $_POST['departure_station'];
    $arrival_station = $_POST['arrival_station'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $price = $_POST['price'];
    $capacity = $_POST['capacity'];
    $available_seats = $_POST['available_seats'];
    
    $sql = "UPDATE trains SET train_number = '$train_number', departure_station = '$departure_station', arrival_station = '$arrival_station', date = '$date', time = '$time', price = '$price', capacity = '$capacity', available_seats = '$available_seats' WHERE id = $train_id";
    
    if ($conn->query($sql) === TRUE) {
        header('Location: train_management.php?update_msg=Train ' .$train_number. ' modifié en succés');
    } else {
        echo "erreur pendant la modification: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Train</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col">
<?php include 'adminheader.php'; ?> 
<main class="container mx-auto mt-8 flex-grow">
    <h2 class="text-3xl font-bold mb-6 mt-4 text-center">Modifier le Train</h2>
    
    <form method="post" action="#" class="max-w-lg mx-auto bg-white p-8 shadow-md rounded-lg">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Numéro du Train:</label>
            <input type="text" name="train_number" value="<?php echo $train['train_number']; ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Station de Départ:</label>
            <input type="text" name="departure_station" value="<?php echo $train['departure_station']; ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Station d'Arrivée:</label>
            <input type="text" name="arrival_station" value="<?php echo $train['arrival_station']; ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Date:</label>
            <input type="date" name="date" value="<?php echo $train['date']; ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Heure:</label>
            <input type="time" name="time" value="<?php echo $train['time']; ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Prix:</label>
            <input type="number" name="price" value="<?php echo $train['price']; ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Capacité:</label>
            <input type="number" name="capacity" value="<?php echo $train['capacity']; ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" min="1">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Places Disponibles:</label>
            <input type="number" name="available_seats" value="<?php echo $train['available_seats']; ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" max="<?=$train['capacity'];?>" min="1">
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Mettre à jour</button>
        </div>
    </form>
</main>

<?php include 'footer.php' ?>
</body>
</html>

<?php $conn->close(); ?>
