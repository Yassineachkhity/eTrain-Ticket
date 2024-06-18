<?php
session_start();
$success = 0;
$error_message = "";

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$conn = new mysqli('localhost', 'root', 'lilvop', 'etrain');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT r.id, r.train_id, r.user_email, r.num_passengers, r.reservation_date, t.train_number, t.departure_station, t.arrival_station
        FROM reservations r
        JOIN trains t ON r.train_id = t.id
        ORDER BY r.reservation_date";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $train_id = $_POST['train_id'];
    $user_email = $_POST['user_email'];
    $num_passengers = $_POST['num_passengers'];
    $reservation_date = $_POST['reservation_date'];
    
    if (isset($_POST['add_reservation'])) {
        $sql = "INSERT INTO reservations (train_id, user_email, num_passengers, reservation_date) 
                VALUES ('$train_id', '$user_email', '$num_passengers', '$reservation_date')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success_message'] = "Réservation ajoutée avec succès";
        } else {
            $_SESSION['error_message'] = "Erreur : " . $sql . "<br>" . $conn->error;
        }
        header('Location: users_management.php');
        exit();
    } elseif (isset($_POST['update_reservation'])) {
        $reservation_id = $_POST['reservation_id'];
        $sql = "UPDATE reservations 
                SET train_id='$train_id', user_email='$user_email', num_passengers='$num_passengers', reservation_date='$reservation_date' 
                WHERE id='$reservation_id'";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success_message'] = "Réservation mise à jour avec succès";
        } else {
            $_SESSION['error_message'] = "Erreur : " . $sql . "<br>" . $conn->error;
        }
        header('Location: users_management.php');
        exit();
    } elseif (isset($_POST['delete_reservation'])) {
        $reservation_id = $_POST['reservation_id'];
        $sql = "DELETE FROM reservations WHERE id='$reservation_id'";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success_message'] = "Réservation supprimée avec succès";
        } else {
            $_SESSION['error_message'] = "Erreur : " . $sql . "<br>" . $conn->error;
        }
        header('Location: users_management.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Gestion des Réservations</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .alert {
            transition: opacity 1s ease-out;
        }
    </style>
        <script>
        function toggleForm() {
            var form = document.getElementById('addReservationForm');
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
        <h2>Admin Dashboard - Gestion des Réservations</h2>
        <?php if (isset($_SESSION['success_message'])): ?>
            <h6 id="success_msg" class="text-green-500 alert"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></h6>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_message'])): ?>
            <h6 id="error_msg" class="text-red-500 alert"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></h6>
        <?php endif; ?>
    </div>

    <div class="mb-4">
        <button id="toggleFormButton" onclick="toggleForm()" class="bg-blue-500 text-white py-2 px-4 rounded">Ajouter une Réservation</button>
    </div>

    <!-- Formulaire pour ajouter une réservation -->
    <div id="addReservationForm" class="hidden p-4 bg-gray-100 rounded shadow-md">
        <form method="POST" action="#">
            <h3 class="text-xl font-semibold mb-4">Ajouter une Réservation</h3>
            <div class="mb-4">
                <label for="train_id" class="block text-gray-700">ID du Train</label>
                <input type="number" id="train_id" name="train_id" class="px-4 py-2 w-full rounded border-2 border-gray-300 focus:outline-none focus:border-blue-500" min="1" required>
            </div>
            <div class="mb-4">
                <label for="user_email" class="block text-gray-700">Email de l'Utilisateur</label>
                <input type="email" id="user_email" name="user_email" class="px-4 py-2 w-full rounded border-2 border-gray-300 focus:outline-none focus:border-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="num_passengers" class="block text-gray-700">Nombre de Passagers</label>
                <input type="number" id="num_passengers" name="num_passengers" class="px-4 py-2 w-full rounded border-2 border-gray-300 focus:outline-none focus:border-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="reservation_date" class="block text-gray-700">Date de Réservation</label>
                <input type="date" id="reservation_date" name="reservation_date" class="px-4 py-2 w-full rounded border-2 border-gray-300 focus:outline-none focus:border-blue-500" required>
            </div>
            <button type="reset" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Reset</button>
            <button type="submit" name="add_reservation" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Ajouter une Réservation</button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b border-gray-200 text-center">ID de Réservation</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-center">Numéro du Train</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-center">Email de l'Utilisateur</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-center">Nombre de Passagers</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-center">Date de Réservation</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='py-2 px-4 border-b border-gray-200 text-center'>" . $row["id"] . "</td>";
                        echo "<td class='py-2 px-4 border-b border-gray-200 text-center'>" . $row["train_number"] . "</td>";
                        echo "<td class='py-2 px-4 border-b border-gray-200 text-center'>" . $row["user_email"] . "</td>";
                        echo "<td class='py-2 px-4 border-b border-gray-200 text-center'>" . $row["num_passengers"] . "</td>";
                        echo "<td class='py-2 px-4 border-b border-gray-200 text-center'>" . $row["reservation_date"] . "</td>";
                        echo "<td class='py-2 px-4 border-b border-gray-200 text-center'>";
                        echo "<form method='POST' action='#' class='inline'>
                                <input type='hidden' name='reservation_id' value='" . $row["id"] . "'>
                                <button type='submit' name='delete_reservation' class='bg-red-500 hover:bg-red-300 text-white py-1 px-2 rounded'>Supprimer</button>
                              </form> ";
                        echo "<a href='update_reservation.php?id=" . $row["id"] . "' class='bg-yellow-500 hover:bg-yellow-300 text-white py-1 px-2 rounded'>Modifier</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='py-2 px-4 text-center border-b border-gray-200'>Aucune réservation trouvée</td></tr>";
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
