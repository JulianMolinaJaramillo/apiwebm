<?php

// Incluir el archivo de conexión
include('../../connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = intval($_POST['id_usuario']);

    // Preparar y ejecutar la consulta
    $sql = "SELECT * FROM personalizacion WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Convertir el resultado en un array asociativo
        $data = $result->fetch_assoc();
        // Devolver los datos en formato JSON
        echo json_encode($data);
    } else {
        echo json_encode(array("error" => "No se encontraron datos"));
    }

    $stmt->close();
} else {
    echo json_encode(array("error" => "Solicitud no válida"));
}

// Cerrar la conexión
$conn->close();
?>