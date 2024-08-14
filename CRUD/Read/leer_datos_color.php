<?php
// Incluir el archivo de conexión
include('../../connection.php');

// Consulta SQL para obtener todos los datos de la tabla 'personalizacion'
$sql = "SELECT color1, color2, color3, color4, color5 FROM personalizacion WHERE id_usuario = 2";

// Incluimos el archivo para la lectura de la consulta 
include('leer.php');