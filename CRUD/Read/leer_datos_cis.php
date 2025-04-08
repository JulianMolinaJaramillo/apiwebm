<?php
// Incluir el archivo de conexión
include('../../connection.php');

if ($conn->connect_error) {
    die(json_encode(["estado" => "error", "mensaje" => "Conexión fallida: " . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Consultar si hay un registro para hoy sin importar el usuario
    $sql = "SELECT id_lab, id_usuario, preg_frecuentes, turno, turnos_sin_atender 
            FROM lab_cis 
            WHERE DATE(fecha_registro) = CURDATE()";

    // Preparamos la consulta
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die(json_encode(["estado" => "error", "mensaje" => "Error en la consulta: " . $conn->error]));
    }

    $stmt->execute(); // Ejecutamos la consulta
    $result = $stmt->get_result(); //Obtenemos resultados

    $registros = [];

    while ($row = $result->fetch_assoc()) {
        // Si turnos_sin_atender está vacío, devolverlo como un array vacío, sino adiciona el nuevo turno
        $row['turnos_sin_atender'] = !empty($row['turnos_sin_atender']) ? explode('|', $row['turnos_sin_atender']) : [];
        $registros[] = $row;
    }

    if (!empty($registros)) {
        echo json_encode(["estado" => "exitoso", "data" => $registros]);
    } else {
        echo json_encode(["estado" => "vacio", "mensaje" => "No hay registros para hoy."]);
    }

    $stmt->close();
}

$conn->close();
?>