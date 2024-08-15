<?php
session_start(); // Iniciar la sesión

// Destruir todas las variables de sesión
$_SESSION = array();

// Si se usa una cookie de sesión, también la destruimos
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}

// Finalmente, destruir la sesión
session_destroy();

// Redirigir con JavaScript
echo '<script> window.location.href = "index.php"; </script>';
exit();
?>