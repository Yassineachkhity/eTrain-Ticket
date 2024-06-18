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

// Vérifier s'il y a des réservations associées
$sql = "SELECT * FROM reservations WHERE train_id = $train_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $_SESSION['delete_msg'] = "Vous ne pouvez pas supprimer un train car il est associé à des réservations.";
} else {
    // Supprimer le train
    $sql = "DELETE FROM trains WHERE id = $train_id";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['delete_msg'] = "Le train a été supprimé.";
    } else {
        $_SESSION['delete_msg'] = "Erreur lors de la suppression du train: " . $conn->error;
    }
}

$conn->close();
header('Location: train_management.php');
exit();
?>
