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
$sql = "SELECT personalizacion FROM usuarios WHERE id_usuario = '$id_usuario'";

// Para identificar en el archivo leer.php la cantidad de datos a mostrar
$id_datos = "furtivo";

// Para identificar en el archivo leer.php los datos a mostrar
$nombre_columnas = ["Carroceria", "Alerón", "Silla", "Volante", "Llantas", "Bateria"];

// Incluimos el archivo para la lectura de la consulta 
include('leer.php');