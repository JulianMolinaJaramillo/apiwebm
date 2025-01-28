<?php

// Incluir el archivo de conexión
include('../../connection.php');

$id_usuario = $_POST['id_usuario'];

// Consulta SQL para obtener todos los datos de la tabla 'usuarios'
$sql = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario' LIMIT 1";

// Ejecutar la consulta
$result = $conn->query($sql);

// Verificar si la consulta devolvió resultados
if ($result->num_rows > 0) {
    // Obtener la fila de resultados como un array asociativo
    $row = $result->fetch_assoc();
    
    // Imprimir el resultado como JSON
    echo json_encode($row);
} else {
    // Si no hay resultados, retornar un JSON vacío
    echo json_encode([]);
}

$conn->close();
?>