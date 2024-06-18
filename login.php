<?php
session_start();
$login = 0;
$invalid = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connect.php';

    $email = verify($_POST['email']);
    $password = verify($_POST['password']);
    $sql = "SELECT * FROM `users` WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result) {
        $num = mysqli_num_rows($result);
        if ($num > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                $login = 1;
                $_SESSION['email'] = $email;
                $_SESSION['firstname'] = $row['firstname'];
                $_SESSION['lastname'] = $row['lastname'];
                $_SESSION['role'] = $row['role'];
                if ($_SESSION['role'] === 'admin') {
                    header('Location:admin.php');
                    exit();
                }else{
                    header('Location:home.php');
                    exit();
                }
            } else {
                $invalid = 1; // invalid password
            }
        } else {
            $invalid = 1; // invalid email
        }
    } else {
        echo "erreur Database: " . $conn->error;
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
                <h2 class="font-blond text-2xl text-[#5D2232]">Login</h2>
                <p class="text-sm mt-4 text-[#5D2232]">If you already a member easily log in</p>
                <form action="login.php" class="flex flex-col gap-4" method="post">
                    <input class="p-2 mt-8 rounded-xl border"  type="email" name="email" placeholder="Email" required>
                    <div class="relative">
                    <input  class="p-2 rounded-xl border w-full" type="password" name="password" placeholder="Password" required>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-eye absolute top-1/2 right-3 -translate-y-1/2" viewBox="0 0 16 16">
                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                    </svg>
                    </div>
                    
                <?php
                    if ($invalid) {
                        echo '<div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-1">
                        Invalid email or password !
                    </div>';
                    }
                    if ($login) {
                        echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-1">
                        Log in successfull :)
                    </div>';
                    }
                ?>
                    <button type="submit" class="bg-[#5D2232] rounded-xl text-white py-2 my-1 hover:scale-105 duration-300">Login</button>
                </form>
                <div>
                    <div class="mt-4 grid grid-cols-3 items-center text-gray-400">
                        <hr class="border-gray-400">
                        <p class="text-center text-sm">OR</p>
                        <hr class="border-gray-400">
                    </div>
                    <button class="bg-white border py-2 w-full rounded-xl mt-3 flex justify-center items-center text-sm hover:scale-105 duration-300"><svg class="mr-3" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25" height="25" viewBox="0 0 48 48">
                        <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path><path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path><path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path><path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
                        </svg>Login with Google
                    </button>
                    <p class="mt-5 text-xs border-b border-gray-400 py-4"><a href="#">Forgot your password?</a></p>
                    <div class="text-sm flex justify-between items-center mt-3">
                        <p>Don't have an account?</p>
                        <button class="py-2 px-5 border border-solid-1 border-[#5D2232] rounded-xl bg-gray-200 hover:scale-105 duration-300"><a href="signup.php">Register</a></button>
                    </div>
                </div>
            </div>

            <div class="w-1/2 flex justify-center">
                <!-- image -->
                <img class="md:block hidden rounded-2xl" src="images/login-image.png" alt="image">
            </div>
        </div>
    </section>
</body>
</html>


