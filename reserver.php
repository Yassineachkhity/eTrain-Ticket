<?php
session_start();

$download = 0;

// Include TCPDF library
require_once('tcpdf/tcpdf.php');

// Create new PDF document
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Eticket Train');
$pdf->SetTitle('Reservation Details');
$pdf->SetSubject('Reservation Details');
$pdf->SetKeywords('Reservation, Train');

// Set default header data
$pdf->SetHeaderData('', 0, 'Reservation Details', '');

// Set font
$pdf->SetFont('helvetica', '', 12);

// Add a page
$pdf->AddPage();

// Configuration de la base de données
$servername = "localhost";
$username = "root";
$password = "lilvop";
$dbname = "etrain";

include 'connect.php';

// Récupérer l'ID du train à partir de l'URL
$train_id = isset($_GET['train_id']) ? intval($_GET['train_id']) : 0;

if ($train_id <= 0) {
    die("Invalid train ID.");
}

// Récupérer le nombre de passagers à partir de l'URL
$num_passengers_from_url = isset($_GET['passengers']) ? intval($_GET['passengers']) : 0;

// Requête SQL pour récupérer les détails du train
$sql = "SELECT * FROM trains WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $train_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Train not found.";
    exit();
}

$train = $result->fetch_assoc();
$num_passengers = 0;

// Vérifier si le formulaire de réservation a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $num_passengers = intval($_POST['num_passengers']);
    $user_email = $_SESSION['email'];

    if ($num_passengers <= 0) {
        echo "Invalid number of passengers.";
        exit();
    }

    if ($num_passengers <= $train['available_seats']) {
        // Insérer la réservation dans la table des réservations
        $sql = "INSERT INTO reservations (train_id, user_email, num_passengers) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isi", $train_id, $user_email, $num_passengers);
        $stmt->execute();

        // Mettre à jour le nombre de places disponibles dans le train
        $new_available_seats = $train['available_seats'] - $num_passengers;
        $sql = "UPDATE trains SET available_seats = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $new_available_seats, $train_id);
        $stmt->execute();

        $download = 1;
    } else {
        echo "Il n'y a pas assez de places disponibles.";
    }
}

if ($download) {

    $html = '<h1>Réservation</h1>';
    $html .= '<p><strong>Numéro du Train:</strong> ' . htmlspecialchars($train['train_number']) . '</p>';
    $html .= '<p><strong>Station de Départ:</strong> ' . htmlspecialchars($train['departure_station']) . '</p>';
    $html .= '<p><strong>Station d\'Arrivée:</strong> ' . htmlspecialchars($train['arrival_station']) . '</p>';
    $html .= '<p><strong>Date:</strong> ' . htmlspecialchars($train['date']) . '</p>';
    $html .= '<p><strong>Heure:</strong> ' . htmlspecialchars($train['time']) . '</p>';
    $html .= '<p><strong>Nombre des voyageurs:</strong> ' . htmlspecialchars($num_passengers) . '</p>';
    $html .= '<p><strong>Prix:</strong> ' . htmlspecialchars((int)$train['price'] * $num_passengers) . ' MAD</p>';
    $pdf->writeHTML($html);

    $pdf->Output('reservation.pdf', 'D');
    header('Location:home.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Réserver un Train</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <div class="mb-4">
            <a href="tickets.php" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Retour</a>
        </div>
        <h1 class="text-3xl font-bold mb-6 text-center">Réserver un Train</h1>
        <div class="bg-white p-6 rounded shadow-md text-center">
            <h2 class="text-2xl font-bold mb-4">Détails du Train</h2>
            <p><strong>Numéro du Train:</strong> <?php echo htmlspecialchars($train['train_number']); ?></p>
            <p><strong>Station de Départ:</strong> <?php echo htmlspecialchars($train['departure_station']); ?></p>
            <p><strong>Station d'Arrivée:</strong> <?php echo htmlspecialchars($train['arrival_station']); ?></p>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($train['date']); ?></p>
            <p><strong>Heure:</strong> <?php echo htmlspecialchars($train['time']); ?></p>
            <p><strong>Prix:</strong> <?php echo htmlspecialchars($train['price']); ?> MAD</p>
            <p><strong>Places Disponibles:</strong> <?php echo htmlspecialchars($train['available_seats']); ?></p>
            
            <h2 class="text-2xl font-bold mt-6 mb-4">Confirmer la Réservation</h2>
            <form action="reserver.php?train_id=<?php echo $train_id; ?>" method="post">
                <div class="mb-4">
                    <label for="num_passengers" class="block text-gray-700 font-bold mb-2">Nombre de Passagers:</label>
                    <input type="number" id="num_passengers" name="num_passengers" class="shadow appearance-none border rounded w-1/4 py-2 px-3 mx-auto text-gray-700 leading-tight focus:outline-none focus:shadow-outline" min="1" max="<?php echo htmlspecialchars($train['available_seats']); ?>" value="<?php echo $num_passengers_from_url ? $num_passengers_from_url : ''; ?>" required>
                </div>
                <a href="home.php" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 mr-3 rounded focus:outline-none focus:shadow-outline">Annuler</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Confirmer</button>
            </form>
        </div>
    </div>
    <?php include 'footer.php' ?>
</body>
</html>
