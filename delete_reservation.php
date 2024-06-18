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

$sql = "DELETE FROM reservations WHERE id='$reservation_id'";

if ($conn->query($sql) === TRUE) {
    $_SESSION['success_message'] = "Réservation supprimée avec succès";
} else {
    $_SESSION['error_message'] = "Erreur : " . $sql . "<br>" . $conn->error;
}

$conn->close();
header('Location: users_management.php');
exit();
?>