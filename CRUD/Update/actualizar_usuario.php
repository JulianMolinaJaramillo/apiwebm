<?php

// Incluir el archivo de conexión
include('../../connection.php');

// Verificar si se recibieron datos por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['datos_json'])) {
    // Obtener el JSON recibido por POST
    $datos_json = $_POST['datos_json'];
    
    // Decodificar el JSON en un array asociativo
    $data = json_decode($datos_json, true);
    
    // Verificar si el JSON se decodificó correctamente
    if ($data === null) {
        echo json_encode(["error" => "JSON inválido"]);
        exit;
    }

    // Extraer los valores del JSON
    $id_usuario = $data['id_usuario'];
    $personalizacion = $data['personalizacion'];
    $tiempo_uso = $data['tiempo_uso'];
    $num_conexiones = $data['num_conexiones'];
    $nombre = $data['nombre'];
    $tipo_usuario = $data['tipo_usuario'];
    $programa = $data['programa'];
    $facultad = $data['facultad'];

    // Preparar la consulta SQL para actualizar los datos
    $sql = "UPDATE usuarios SET 
            personalizacion = ?, 
            tiempo_uso = ?, 
            num_conexiones = ?, 
            nombre = ?, 
            tipo_usuario = ?, 
            programa = ?, 
            facultad = ? 
            WHERE id_usuario = ?";

    // Preparar la declaración
    if ($stmt = $conn->prepare($sql)) {
        // Vincular los parámetros
        $stmt->bind_param("ssssssss", 
            $personalizacion, 
            $tiempo_uso, 
            $num_conexiones, 
            $nombre, 
            $tipo_usuario, 
            $programa, 
            $facultad, 
            $id_usuario
        );

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo json_encode(["success" => "Datos actualizados correctamente"]);
        } else {
            echo json_encode(["error" => "Error al actualizar los datos"]);
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        echo json_encode(["error" => "Error en la preparación de la consulta"]);
    }
} else {
    echo json_encode(["error" => "No se recibieron datos válidos"]);
}

// Cerrar la conexión
$conn->close();
?>
