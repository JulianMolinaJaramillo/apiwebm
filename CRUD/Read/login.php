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
    // Recibir los datos enviados por el formulario y convertirlos a enteros intval()

    // Asegúrate de que la cantidad de signos ? coincida con el número de columnas en la tabla e insertamos en la tabla Usuarios
    $sql_insert = "INSERT INTO usuarios (id_usuario, personalizacion, tiempo_uso, num_conexiones, nombre, tipo_usuario,programa,facultad) VALUES ($id_usuario,'personalizacion',0,0,'NN',0,'0','0')";

    // Ejecutar la consulta
    $result2 = $conn->query($sql);
    // Ejecutar la consulta
    $sql = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Obtener la fila de resultados como un array asociativo
        $row = $result->fetch_assoc();
        
        // Imprimir el resultado como JSON
        echo json_encode($row);
    }
}

$conn->close();
?>