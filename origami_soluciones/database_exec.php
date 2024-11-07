<?php
    /**
     * En este archivo se ejecutará la conexión a la bbdd y la creación de las tablas
     * Verificar que la conexión al servidor de la bbdd es exitosa
     * Crear la bbdd que vamos a utlizar y se llamará "origami_solutions"
     * Crear la tabla para los usuarios
     */
    // //valores del archivo ini
    require_once 'config_db.php';

    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, '', $DB_PORT);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $dbname="origami_solutions";
    //verificar si ya existe la bbdd
    $database = $conn->query("CREATE DATABASE IF NOT EXISTS ".$dbname);
    $db_selected = $conn->select_db($dbname);
    if (!$db_selected) {
        if($database === true){
            echo "BBDD creada con éxito. <br>";
        }else{
            die("Hubo un error al crear la BBDD." . $conn->error);
        }
    }

    if(!$conn->select_db($dbname)){
        die("Error al seleccionar la base de datos: " . $db->error);
    }
    //verificar si ya existe la tabla
    $tableExists = $conn->query("SHOW TABLES LIKE 'users'");
    if ($tableExists && $tableExists->num_rows == 0) {
        $sql = "CREATE TABLE users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(300) NOT NULL,
            password VARCHAR(255) NOT NULL,
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        
        if ($conn->query($sql) === true) { 
            echo "Tabla de usuarios creada.<br>";
        } else {
            echo "Hubo un error al crear la tabla: " . $conn->error;
        }
    } else {
        echo "La tabla de usuarios ya existe.<br>";
    }
    
?>