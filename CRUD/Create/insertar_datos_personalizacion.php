<?php
// Incluir el archivo de conexión a la base de datos
include('../../connection.php');

// Comprobar si se ha hecho una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar que el id_usuario es un número y está definido
    if (!isset($_POST['id_usuario']) || !is_numeric($_POST['id_usuario'])) {
        echo "Error: id_usuario es inválido o no está definido.";
        exit;
    }

    // Validar que el dato de personalización está definido y no está vacío
    if (!isset($_POST['personalizacion']) || empty($_POST['personalizacion'])) {
        echo "Error: La cadena de personalización no está definida o está vacía.";
        exit;
    }

    // Almacenar el id_usuario y el dato de personalización
    $id_usuario = intval($_POST['id_usuario']);
    $personalizacion = $_POST['personalizacion'];

    // Verificar si el id_usuario existe en la tabla usuarios
    $sql_check_usuario = "SELECT id_usuario FROM usuarios WHERE id_usuario = ?";
    $stmt_check_usuario = $conn->prepare($sql_check_usuario);

    if (!$stmt_check_usuario) {
        echo "Error al preparar la consulta de verificación: " . $conn->error;
        exit;
    }

    $stmt_check_usuario->bind_param("i", $id_usuario);
    $stmt_check_usuario->execute();
    $stmt_check_usuario->store_result();

    // Verificar si existe el usuario
    if ($stmt_check_usuario->num_rows == 0) {
        echo "Usuario no encontrado.";
        $stmt_check_usuario->close();
        exit;
    }
    $stmt_check_usuario->close();

    // Actualizar el campo de personalización
    $sql_update = "UPDATE usuarios SET personalizacion = ? WHERE id_usuario = ?";
    $stmt_update = $conn->prepare($sql_update);

    if ($stmt_update) {
        $stmt_update->bind_param("si", $personalizacion, $id_usuario);
        if ($stmt_update->execute()) {
            echo "Datos actualizados con éxito.";
        } else {
            echo "Error al actualizar los datos: " . $stmt_update->error;
        }
        $stmt_update->close();
    } else {
        echo "Error al preparar la consulta de actualización: " . $conn->error;
    }
    $conn->close();
}
?>