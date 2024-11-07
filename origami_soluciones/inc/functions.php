<?php
/**
 * Funciones para la conexión a BBDD
 */
ini_set('display_errors', 0);  // No mostrar errores de PHP
error_reporting(0);            // Deshabilitar el reporte de errores de PHP

require_once '../config_db.php';

function connect_db() {
    global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT;
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    return $conn;
}
?>