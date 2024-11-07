<?php
session_start();  // Iniciar la sesión
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link rel="stylesheet" href="resources/css/index.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container container">
            <input type="checkbox" name="" id="">
            <div class="hamburger-lines">
                <span class="line line1"></span>
                <span class="line line2"></span>
                <span class="line line3"></span>
            </div>
            <ul class="menu-items">
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php?view=users">Usuarios</a></li>
                <li><a href="#">About me</a></li>
                <li><a href="#">Contact</a></li>
                <?php
                    echo isset($_SESSION['user_email']) 
                        ? '<li><a href="inc/login.php?action=logout">Logout</a></li>' 
                        : '<li><a href="http://localhost/pruebas_tecnicas/origami_soluciones/login.php">Login</a></li>';
                ?>
       </ul>
            <h1 class="logo">Navbar</h1>
        </div>
    </nav>
</body>
</html>