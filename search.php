<?php
session_start();

$navbar = 1;
if (!isset($_SESSION['email'])) {
    $navbar = 0;
} else {
    $navbar = 1;
}



$departureStation = $_GET['departure_station'];
$arrivalStation = $_GET['arrival_station'];
$date = $_GET['date'];
$passengers = $_GET['passengers'];


include 'connect.php';

$sql = "SELECT * FROM trains WHERE departure_station='$departureStation' AND arrival_station='$arrivalStation' AND date='$date'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Tickets</title>  
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">

</head>
<body class="flex flex-col min-h-screen">
<?php include 'header.php'?>
<img class="fixed inset-0 w-full h-full object-cover opacity-20 -z-10" src="images/carte.png" alt="Carte image" loading="lazy">
<main class="container mx-auto mt-8 flex-grow content">
    <h2 class="text-2xl font-bold mb-4">Trains Disponibles</h2>
    <?php if ($result->num_rows > 0) { ?>
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">Numéro Train</th>
                    <th class="px-4 py-2">Gare de départ</th>
                    <th class="px-4 py-2">Gare d'arrivée</th>
                    <th class="px-4 py-2">Date</th>
                    <th class="px-4 py-2">Heure</th>
                    <th class="px-4 py-2">Prix</th>
                    <th class="px-4 py-2">Place disponible</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td class="border px-4 py-2 text-center"><?php echo $row['train_number']; ?></td>
                        <td class="border px-4 py-2 text-center"><?php echo $row['departure_station']; ?></td>
                        <td class="border px-4 py-2 text-center"><?php echo $row['arrival_station']; ?></td>
                        <td class="border px-4 py-2 text-center"><?php echo $row['date']; ?></td>
                        <td class="border px-4 py-2 text-center"><?php echo $row['time']; ?></td>
                        <td class="border px-4 py-2 text-center"><?php echo $row['price']; ?> MAD</td>
                        <td class="border px-4 py-2 text-center"><?php echo $row['available_seats']; ?></td>
                        <td class="border px-4 py-2 text-center">
                            <?php if ($row['available_seats'] >= $passengers) {
                                if (isset($_SESSION['email'])) {?>
                                    <a href="reserver.php?train_id=<?php echo $row['id']; ?>&passengers=<?php echo $passengers; ?>" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded text-center">Reserve</a>
                                <?php  } else { ?>
                                    <a href='login.php' class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'>Reserver</a>
                                 <?php } ?>
                            <?php } else { ?>
                                <span class="text-red-500">Pas assez de places.</span>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-3xl text-red-500 font-semibold text-center">Aucun train disponible pour les critères sélectionnés.</p>
    <?php } ?>
    </main>

<?php include 'footer.php' ?>
</body>
</html>

<?php $conn->close(); ?>
