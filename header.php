<header class="bg-white border-b-2 border-b-zinc-600 md:z-50 z-200">
    <nav class="flex justify-between items-center w-[92%] mx-auto">
        <div>
            <a href="home.php"><img src="images/logo1.png" alt="logo" class="w-16"></a>
        </div>
        <div class="nav-links md:static md:min-h-fit absolute min-h-[30vh] bg-white left-0 top-[-100%] w-full md:w-auto flex items-center px-3 z-50">
            <ul class="flex md:flex-row flex-col md:items-center mx-auto md:gap-[4vw] gap-2 m-0 p-0 text-lg">
                <li><a class="md:hover:text-gray-500 hover:text-sky-500 font-semibold md:border-y-2 md:hover:border-y-sky-600 py-1" href="home.php">Home</a></li>
                <li><a class="md:hover:text-gray-500 hover:text-sky-500 font-semibold md:border-y-2 md:hover:border-y-sky-600 py-1" href="about.php">About</a></li>
                <li><a class="md:hover:text-gray-500 hover:text-sky-500 font-semibold md:border-y-2 md:hover:border-y-sky-600 py-1" href="tickets.php">Tickets</a></li>
                <li><a class="md:hover:text-gray-500 hover:text-sky-500 font-semibold md:border-y-2 md:hover:border-y-sky-600 py-1" href="contact.php">Contact</a></li>
            </ul>
        </div>
        <div class="flex items-center gap-6">
            <!-- sans Login -->
            <?php if (!$navbar) {  ?>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"><a href="signup.php">Sign Up</a></button>
                <button class="bg-slate-100 border-2 border-blue-500 hover:bg-blue-500 font-bold hover:text-white hover:border-transparent py-2 px-4 rounded"><a href="login.php">Login</a></button>
            <?php } ?>
            <!-- Logout -->
            <?php if ($navbar) { ?>
                <button class="bg-slate-100 border-2 border-blue-500 hover:bg-blue-500 font-bold hover:text-white hover:border-transparent py-2 px-4 rounded"><a href="logout.php">Logout</a></button>
            <?php } ?>
            <ion-icon onclick="onToggleMenu(this)" name="menu" class="text-3xl cursor-pointer md:hidden"></ion-icon>
        </div>
    </nav>
</header>
