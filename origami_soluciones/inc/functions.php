<?php
/**
 * Funciones para la conexión a BBDD y algunas restricciones globales
 */
// ini_set('display_errors', 0);  // No mostrar errores de PHP
// error_reporting(0);            // Deshabilitar el reporte de errores de PHP

require_once __DIR__ . '/../config_db.php';

function connect_db() {
    global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT;
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    return $conn;
}
if (isset($_SESSION['user_email']) && basename($_SERVER['PHP_SELF']) === 'login.php') {
    header("Location: http://localhost/pruebas_tecnicas/origami_soluciones/index.php"); 
}
?>