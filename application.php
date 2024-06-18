<?php
session_start();

$navbar = 1;
if (!isset($_SESSION['email'])) {
    $navbar = 0;
    header("Location: login.php");
    exit();
}

include 'connect.php';
$user_email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['cv'])) {

    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["cv"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($_FILES["cv"]["size"] > 5000000) {
        echo "Désolé, votre fichier est trop volumineux.";
        $uploadOk = 0;
    }
    $check = filesize($_FILES["cv"]["tmp_name"]);
    if ($check === false) {
        echo "Le fichier n'est pas valide.";
        $uploadOk = 0;
    }

    if ($fileType != "pdf" && $fileType != "doc" && $fileType != "docx") {
        echo "Désolé, seuls les fichiers PDF, DOC & DOCX sont autorisés.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Désolé, votre fichier n'a pas été téléchargé.";
    } else {
        if (move_uploaded_file($_FILES["cv"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO applications (user_id, cv, date_application) VALUES (?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $user_id, $target_file);
            if ($stmt->execute()) {
                echo "Le fichier " . htmlspecialchars(basename($_FILES["cv"]["name"])) . " a été téléchargé.";
            } else {
                echo "Erreur : " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Désolé, il y a eu une erreur lors du téléchargement de votre fichier.";
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Postuler à un emploi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    <?php include 'header.php'; ?>
    <main class="container flex-grow">
        <div class="container mx-auto py-8">
            <h1 class="text-3xl font-bold mb-6 text-center">Postuler à un emploi</h1>
            <form action="application.php" method="post" enctype="multipart/form-data" class="max-w-lg mx-auto bg-white p-8 shadow-md rounded">
                <div class="mb-4">
                    <label for="cv" class="block text-gray-700">Télécharger votre CV</label>
                    <input type="file" name="cv" id="cv" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mt-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Postuler</button>
                </div>
            </form>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>
