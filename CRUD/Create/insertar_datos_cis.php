<?php
// Incluir el archivo de conexión a la base de datos
include('../../connection.php');

// Obtener la fecha actual en formato YYYY-MM-DD
$fecha_hoy = date("Y-m-d");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir los datos enviados por Unity
    $id_usuario = intval($_POST['id_usuario']);
    $preg_frecuentes = $_POST['preg_frecuentes'];
    $turno = $_POST['turno'];
    $turnos_sin_atender = $_POST['turnos_sin_atender']; // Recibe la cadena directamente

    // Verificar si ya existe un registro para la fecha actual (sin importar el id_usuario)
    $sql = "SELECT id_lab, turnos_sin_atender FROM lab_cis WHERE DATE(fecha_registro) = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $fecha_hoy);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Si existe un registro con la fecha actual, obtener el id del laboratorio y los turnos previos
        $stmt->bind_result($id_lab, $turnos_previos);
        $stmt->fetch();
        $stmt->close();

        // Se sobrescribe con la nueva lista de turnos
        $sql_update = "UPDATE lab_cis SET id_usuario = ?, preg_frecuentes = ?, turno = ?, turnos_sin_atender = ? WHERE id_lab = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("isssi", $id_usuario, $preg_frecuentes, $turno, $turnos_sin_atender, $id_lab);

        if ($stmt_update->execute()) {
            echo json_encode([
                "estado" => "exitoso",
                "mensaje" => "Registro actualizado correctamente.",
                "turnos_sin_atender" => explode('|', $turnos_sin_atender)
            ]);
        } else {
            echo json_encode(["estado" => "error", "mensaje" => "Error al actualizar el registro."]);
        }
        $stmt_update->close();
    } else {
        // Si no existe un registro con la fecha actual, se inserta uno nuevo
        $stmt->close();
        $sql_insert = "INSERT INTO lab_cis (id_usuario, preg_frecuentes, turno, turnos_sin_atender, fecha_registro) VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("issss", $id_usuario, $preg_frecuentes, $turno, $turnos_sin_atender, $fecha_hoy);

        if ($stmt_insert->execute()) {
            echo json_encode(["estado" => "exitoso", "mensaje" => "Registro insertado correctamente.", "turnos_sin_atender" => explode('|', $turnos_sin_atender)]);
        } else {
            echo json_encode(["estado" => "error", "mensaje" => "Error al insertar el registro."]);
        }
        $stmt_insert->close();
    }
} else {
    echo json_encode(["estado" => "error", "mensaje" => "No se recibió una solicitud POST."]);
}

$conn->close();
?>