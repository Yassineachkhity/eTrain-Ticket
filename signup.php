<?php

$success = 0;
$user = 0;
$pass = 0;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connect.php';

    $firstName = verify($_POST['firstName']);
    $lastName = verify($_POST['lastName']);
    $email = verify($_POST['email']);
    $password = verify($_POST['password']);
    $confirmPassword = verify($_POST['confirmPassword']);

    $sql = "SELECT * FROM `users` WHERE email=? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $num = mysqli_num_rows($result);
        if ($num > 0) {
            $user = 1;
        } else {
            if ($password == $confirmPassword) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `users` (firstname, lastname, email, password) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $firstName, $lastName, $email, $hashedPassword);
                
                if ($stmt->execute()) {
                    $success = 1;
                    header('Location:login.php');
                    exit();
                } else {
                    die("Error during insertion: " . $conn->error);
                }
            } else {
                $pass = 1;
            }
        }
    } else {
        die("Database error: " . $conn->error);
    }
    $stmt->close();
    
}

function verify($data) {
    $data = htmlspecialchars($data);
    $data = trim($data);
    $data = htmlentities($data);
    $data = stripslashes($data);

    return $data;

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body class="h-screen flex flex-col">

 <?php include 'headerLoginSignup.php'; ?>
    <section class="bg-gray-500 flex flex-grow items-center justify-center">
        <!-- login container -->
        <div class="bg-gray-100 flex rounded-2xl shadow-lg max-w-3xl p-5">
            <!-- form -->
            <div class="md:w-1/2 px-16">  
                <h2 class="font-blond text-2xl text-[#388099]">Register</h2>
                <p class="text-sm mt-4 text-[#388099]">Sign up to get your ticket now!</p>
                        <form action="signup.php" method="post" class="flex flex-col gap-4">
                            <input class="p-2 mt-2 rounded-xl border"  type="text" name="firstName" placeholder="First Name" required>
                            <input class="p-2 mt-2 rounded-xl border"  type="text" name="lastName" placeholder="Last Name" required>
                            <input class="p-2 mt-2 rounded-xl border"  type="email" name="email" placeholder="Email" required>
                            <div class="relative">
                            <input  class="p-2 rounded-xl border w-full" type="password" name="password" placeholder="Password" required>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-eye absolute top-1/2 right-3 -translate-y-1/2" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                            </svg>
                            </div>
                            <div class="relative">
                            <input  class="p-2 rounded-xl border w-full" type="password" name="confirmPassword" placeholder="Confirm password" required>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-eye absolute top-1/2 right-3 -translate-y-1/2" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                            </svg>
                            </div>
                            <?php
                                if ($user) {
                                    echo '<div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-1">
                                    User already exist! Try another username or log in
                                </div>';
                                }
                                if ($success) {
                                    echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-1">
                                    Sign Up successfull :)
                                </div>';
                                }

                                if ($pass) {
                                    echo '<div class="bg-green-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-1">
                                    Password didn\'t match
                                </div>';
                                }
                            ?>
                            <button type="submit" class="bg-[#388099] rounded-xl text-white py-2 hover:scale-105 duration-300">Sign Up</button>
                        </form>
                <div>
                    <div class="mt-4 grid grid-cols-3 items-center text-gray-400">
                        <hr class="border-gray-400">
                        <p class="text-center text-sm">OR</p>
                        <hr class="border-gray-400">
                    </div>
                    <div class="text-sm flex justify-between items-center mt-3">
                        <p>you already have an account!</p>
                        <button type="submit" class="py-2 px-5 border border-solid-1 border-[#388099] rounded-xl bg-gray-200 hover:scale-105 duration-300"><a href="login.php">Login</a></button>
                    </div>
                </div>
            </div>

            <div class="w-1/2 flex justify-center">
                <!-- image -->
                <img class="md:block hidden rounded-2xl" src="images/login1-image.jpg" alt="image">
            </div>
        </div>
    </section>

</body>
</html>