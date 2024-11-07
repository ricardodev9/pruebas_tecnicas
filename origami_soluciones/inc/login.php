<?php
    session_start();  // Iniciar la sesión
    ini_set('display_errors', 0);  // No mostrar errores de PHP
    error_reporting(0);            // Deshabilitar el reporte de errores de PHP

    include_once 'functions.php';
    include_once '../Class/User.php';
    /**
     * En este archivo se aplica la lógica para logearse y registrarse
     * Se usa, en esta prueba, el email como referencia para la session del usuario aunque en proyectos reales se deberá emplear una metodología más compleja
     */
    global $conn;
    $conn = connect_db();
    $user = new User($conn);

    //login
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_GET['action'] == 'login') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $login = $user->login($email, $password);        
        if ($login !== true) {
            $_SESSION['login_error'] = $login;
            header("Location: http://localhost/pruebas_tecnicas/origami_soluciones/login.php"); 
        } else {
            // Login exitoso
            $_SESSION['user_email'] = $email; 
            header("Location: http://localhost/pruebas_tecnicas/origami_soluciones/index.php"); 
        }
    }

    //register
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_GET['action'] == 'register') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $register = $user->register($email, $password, $name);        
        if ($register !== true) {   
            $_SESSION['register_error'] = $register; 
            header("Location: http://localhost/pruebas_tecnicas/origami_soluciones/login.php?look=register"); 
        } else {
            // registro exitoso
            $_SESSION['user_email'] = $email; 
            header("Location: http://localhost/pruebas_tecnicas/origami_soluciones/index.php"); 
        }
    }

    //logout
    if ($_GET['action'] == 'logout') {
        // Iniciar sesión si aún no está iniciada
        session_start();
        session_unset();
        session_destroy();
        // Redirigir al usuario a la página de login
        header("Location: http://localhost/pruebas_tecnicas/origami_soluciones/login.php"); 
        exit();
    }
?>