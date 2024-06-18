<?php
session_start();
$navbar = 1;

if(!isset($_SESSION['email'])) {
    $navbar = 0;
} else {
    $navbar = 1;
}
require 'vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$successMessage = '';
$errorMessage = '';

include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION['email'] ?? '';
    $promoCode = $_POST['promoCode'];

    if ($promoCode === "train2024") {
        // Récupérer l'ID de l'utilisateur
        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $userId = $user['id'];

            $duree_abonnement = '1 mois';
            $sql = "INSERT INTO subscription (id_user, duree_abonnement) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $userId, $duree_abonnement);

            if ($stmt->execute()) {
                $successMessage = "The subscription was successful!";

                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'achkhity.yassine@ensam-casa.ma';
                    $mail->Password = 'ENSAM.ensam2021';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    $mail->setFrom('achkhity.yassine@ensam-casa.ma', 'TrainTickets');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = 'Subscription Confirmation';
                    $mail->Body    = "Your subscription was successful!<br>Date of expiration: " . date('Y-m-d', strtotime('+1 month'));

                    $mail->send();
                } catch (Exception $e) {
                    $errorMessage = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                $errorMessage = "Failed to subscribe. Please try again.";
            }
        } else {
            $errorMessage = "User not found.";
        }

        $stmt->close();
    } else {
        $errorMessage = "Invalid promo code.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription - Train Tickets</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-900 flex flex-col min-h-screen">
<?php include 'header.php' ?>
<img class="fixed inset-0 w-full h-full object-cover -z-10" src="images/carte.png" alt="Carte image" loading="lazy">

    <main class="w-[92%] mx-auto my-8 flex-grow">
        <section class="text-center my-10">
            <h1 class="text-3xl font-bold text-sky-600 mb-4">Subscribe to Train Tickets</h1>
            <p class="text-gray-700 text-lg">Entrer les informations de payment</p>
        </section>

        <section class="my-8">
            <?php if ($successMessage) : ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                    <p><?php echo $successMessage; ?></p>
                </div>
            <?php endif; ?>

            <?php if ($errorMessage) : ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                    <p><?php echo $errorMessage; ?></p>
                </div>
            <?php endif; ?>

            <form action="subscribe.php" method="POST" class="bg-white p-6 rounded-lg shadow-lg">
                <div class="mb-4">
                    <label for="promoCode" class="block text-gray-700 text-sm font-bold mb-2">Promo Code:</label>
                    <input type="text" id="promoCode" name="promoCode" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex justify-around items-center">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"><a href="about.php">Retour</a></button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Subscribe</button>
                </div>
            </form>
        </section>
    </main>

    <?php include 'footer.php' ?>
</body>

</html>
