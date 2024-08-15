<?php
session_start(); // Iniciar la sesión

// Encabezados para evitar el caché de las páginas protegidas
header("Cache-Control: no-cache, must-revalidate"); // HTTP 1.1.
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado
header("Pragma: no-cache"); // HTTP 1.0.

// Verificar si el usuario está logueado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Si no está logueado, redirigir a la página de inicio de sesión
    header("Location: ../index.php");
    exit();
}

?>