<?php
session_start();
$navbar = 1;

if(!isset($_SESSION['email'])) {
    $navbar = 0;
} else {
    $navbar = 1;
}
$servername = "localhost";
$username = "root";
$password = "lilvop";
$dbname = "etrain";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "DELETE FROM trains WHERE CURDATE() > date";
$result = $conn->query($sql);
$sql = "SELECT id, train_number, departure_station, arrival_station, date, time, price, capacity, available_seats FROM trains WHERE available_seats != 0 ORDER BY date, time";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Liste des Trains</title>
    <script src="https://cdn.tailwindcss.com"></script>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body class="bg-gray-100">
<?php include 'header.php' ?>
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6 text-center">Liste des Trains</h1>
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
                            if (isset($_SESSION['email'])) {
                                echo "<a href='reserver.php?train_id=" . $row["id"] . "' class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'>Reserver</a>";
                            } else {
                                echo "<a href='login.php' class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'>Reserver</a>";
                            }
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
    </div>
    <?php include 'footer.php' ?>
</body>
</html>

<?php
$conn->close();
?>
