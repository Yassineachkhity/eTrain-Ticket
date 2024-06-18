<?php
session_start();
$success = 0;
$error_message = "";

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
} 

include 'connect.php';

$sql = "SELECT id, train_number, departure_station, arrival_station, date, time, price, capacity, available_seats FROM trains ORDER BY date, time";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $train_number = $_POST['train_number'];
    $departure_station = $_POST['departure_station'];
    $arrival_station = $_POST['arrival_station'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $price = $_POST['price'];
    $capacity = $_POST['capacity'];
    
    if (isset($_POST['add_train'])) {
        if ($departure_station === $arrival_station) {
            $_SESSION['error_message'] = "La station de départ et la station d'arrivée ne peuvent pas être identiques.";
        } else {
            $check_train_sql = "SELECT * FROM trains WHERE train_number='$train_number'";
            $check_train_result = $conn->query($check_train_sql);

            if ($check_train_result->num_rows > 0) {
                $_SESSION['error_message'] = "Un train avec ce numéro existe déjà.";
            } else {
                $sql = "INSERT INTO trains (train_number, departure_station, arrival_station, date, time, price, capacity, available_seats) 
                        VALUES ('$train_number', '$departure_station', '$arrival_station', '$date', '$time', '$price', '$capacity', '$capacity')";

                if ($conn->query($sql) === TRUE) {
                    $_SESSION['success_message'] = "Train ajouté avec succès";
                } else {
                    $_SESSION['error_message'] = "Erreur : " . $sql . "<br>" . $conn->error;
                }
            }
        }
        header('Location: train_management.php');
        exit();
    }
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
    <style>
        .alert {
            transition: opacity 1s ease-out;
        }
    </style>
        <script>
        function toggleForm() {
            var form = document.getElementById('addTrainForm');
            if (form.style.display === 'block') {
                form.style.display = 'none';
            } else {
                form.style.display = 'block';
            }
        }
    </script>
</head>
<body class="min-h-screen flex flex-col">
<?php include 'adminheader.php'; ?> 
<main class="container mx-auto mt-8 flex-grow">
    <div class="text-3xl font-bold mb-6 mt-4 text-center">
        <h2>Admin Dashboard</h2>
        <?php if (isset($_SESSION['delete_msg'])): ?>
            <h6 id="delete_msg" class="text-red-500 alert"><?php echo $_SESSION['delete_msg']; unset($_SESSION['delete_msg']); ?></h6>
        <?php endif; ?>
        <?php if (isset($_SESSION['update_msg'])): ?>
            <h6 id="update_msg" class="text-yellow-500 alert"><?php echo $_SESSION['update_msg']; unset($_SESSION['update_msg']); ?></h6>
        <?php endif; ?>
        <?php if (isset($_SESSION['success_message'])): ?>
            <h6 id="success_msg" class="text-green-500 alert"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></h6>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_message'])): ?>
            <h6 id="error_msg" class="text-red-500 alert"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></h6>
        <?php endif; ?>
    </div>

    <div class="mb-4">
        <button id="toggleFormButton" onclick="toggleForm()" class="bg-blue-500 text-white py-2 px-4 rounded">Ajouter un Train</button>
    </div>

    <!-- Formulaire pour ajouter un train -->
    <div id="addTrainForm" class="hidden p-4 bg-gray-100 rounded shadow-md">
        <form method="POST" action="#">
            <h3 class="text-xl font-semibold mb-4">Ajouter un Train</h3>
            <div class="mb-4">
                <label for="train_number" class="block text-gray-700">Numéro du Train</label>
                <input type="text" id="train_number" name="train_number" class="px-4 py-2 w-full rounded border-2 border-gray-300 focus:outline-none focus:border-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="departure_station" class="block text-gray-700">Station de Départ</label>
                <select id="departure_station" name="departure_station" class="px-4 py-2 w-full rounded border-2 border-gray-300 focus:outline-none focus:border-blue-500" required>
                    <option value="">Sélectionnez une ville</option>
                    <option value="Rabat">Rabat</option>
                    <option value="Casablanca">Casablanca</option>
                    <option value="Tanger">Tanger</option>
                    <option value="Marrakech">Marrakech</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="arrival_station" class="block text-gray-700">Station d'Arrivée</label>
                <select id="arrival_station" name="arrival_station" class="px-4 py-2 w-full rounded border-2 border-gray-300 focus:outline-none focus:border-blue-500" required>
                    <option value="">Sélectionnez une ville</option>
                    <option value="Rabat">Rabat</option>
                    <option value="Casablanca">Casablanca</option>
                    <option value="Tanger">Tanger</option>
                    <option value="Marrakech">Marrakech</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="date" class="block text-gray-700">Date</label>
                <input type="date" id="date" name="date" class="px-4 py-2 w-full rounded border-2 border-gray-300 focus:outline-none focus:border-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="time" class="block text-gray-700">Heure</label>
                <input type="time" id="time" name="time" class="px-4 py-2 w-full rounded border-2 border-gray-300 focus:outline-none focus:border-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="price" class="block text-gray-700">Prix</label>
                <input type="number" id="price" name="price" class="px-4 py-2 w-full rounded border-2 border-gray-300 focus:outline-none focus:border-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="capacity" class="block text-gray-700">Capacité</label>
                <input type="number" id="capacity" name="capacity" class="px-4 py-2 w-full rounded border-2 border-gray-300 focus:outline-none focus:border-blue-500" min="1" required>
            </div>
            <button type="reset" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Reset</button>
            <button type="submit" name="add_train" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Ajouter un Train</button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b border-gray-200 text-center">Numéro du Train</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-center">Station de Départ</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-center">Station d'Arrivée</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-center">Date</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-center">Heure</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-center">Prix</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-center">Capacité</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-center">Places Disponibles</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='py-2 px-4 border-b border-gray-200 text-center'>" . $row["train_number"] . "</td>";
                        echo "<td class='py-2 px-4 border-b border-gray-200 text-center'>" . $row["departure_station"] . "</td>";
                        echo "<td class='py-2 px-4 border-b border-gray-200 text-center'>" . $row["arrival_station"] . "</td>";
                        echo "<td class='py-2 px-4 border-b border-gray-200 text-center'>" . $row["date"] . "</td>";
                        echo "<td class='py-2 px-4 border-b border-gray-200 text-center'>" . $row["time"] . "</td>";
                        echo "<td class='py-2 px-4 border-b border-gray-200 text-center'>" . $row["price"] . "</td>";
                        echo "<td class='py-2 px-4 border-b border-gray-200 text-center'>" . $row["capacity"] . "</td>";
                        echo "<td class='py-2 px-4 border-b border-gray-200 text-center'>" . $row["available_seats"] . "</td>";
                        echo "<td class='py-2 px-4 border-b border-gray-200 text-center'>";
                        echo "<a href='update_train.php?id=" . $row["id"] . "' class='bg-yellow-500 hover:bg-yellow-300 text-white py-1 px-2 rounded'>Modifier</a> ";
                        echo "<a href='delete_train.php?id=" . $row["id"] . "' class='bg-red-500 hover:bg-red-300 text-white py-1 px-2 rounded'>Supprimer</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' class='py-2 px-4 text-center border-b border-gray-200'>Aucun train trouvé</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</main>
<?php include 'footer.php'; ?>
<script>
    // Fonction pour masquer les messages d'alerte après 5 secondes
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.style.display = 'none';
            }, 1000);
        });
    }, 5000);
</script>
</body>
</html>

<?php $conn->close(); ?>
