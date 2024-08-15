<?php
// Incluimos el archivo que inicia la sesion
include('../../iniciar_sesion.php');

// Incluir el archivo de conexión
include('../../connection.php');

// Verificar si 'Identificacion' está almacenada en la sesión
if (!isset($_SESSION['Identificacion'])) {
    die('No se ha iniciado sesión correctamente.');
}

// Obtener el valor de la identificación del usuario desde la sesión
$id_usuario = $_SESSION['Identificacion'];

// Consulta SQL para obtener todos los datos de la tabla 'personalizacion'
$sql = "SELECT color1, color2, color3, color4, color5 FROM personalizacion WHERE id_usuario = '$id_usuario'";

// Incluimos el archivo para la lectura de la consulta 
include('leer.php');