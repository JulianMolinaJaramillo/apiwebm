<?php

// Incluir el archivo de conexión
include('../../connection.php');

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar y obtener el id_usuario
    if (!isset($_POST['id_usuario']) || !is_numeric($_POST['id_usuario'])) {
        echo "Error: id_usuario no válido o no definido";
        exit;
    }

    $id_usuario = intval($_POST['id_usuario']);

    // Preparar la consulta para obtener el campo personalizacion
    $sql = "SELECT personalizacion FROM usuarios WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Obtener el valor del campo 'personalizacion'
            $data = $result->fetch_assoc();
            $personalizacion_string = $data['personalizacion'];

            // Eliminar los caracteres "|"
            $personalizacion_sin_barras = str_replace("|", "", $personalizacion_string);

            // Devolver la cadena sin "|"
            echo $personalizacion_sin_barras;
        } else {
            echo "Error: Usuario no encontrado";
        }

        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }
} else {
    echo "Error: Solicitud no válida";
}

// Cerrar la conexión
$conn->close();
?>