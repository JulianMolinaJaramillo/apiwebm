<?php

// Incluir el archivo de conexión
include('../../connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = intval($_POST['id_usuario']);

    // Preparar y ejecutar la consulta
    $sql = "SELECT personalizacion FROM usuarios WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Obtener el valor de la columna 'personalizacion'
        $data = $result->fetch_assoc();
        $personalizacion_string = $data['personalizacion'];

        // Convertir la cadena en un array
        $personalizacion_array = explode("|", $personalizacion_string);

        // Nombres de las variables de personalización
        $keys = [
            'genero', 'maleta', 'cuerpo', 'cabeza', 'cejas', 'cabello', 'reloj', 
            'sombrero', 'zapatos', 'tamano', 'color1', 'color2', 'color3', 
            'color4', 'color5', 'carroceria', 'aleron', 'silla', 'volante', 
            'llanta', 'bateria'
        ];

        // Combinar los nombres de las variables con los valores del array
        $personalizacion_asociativo = array_combine($keys, $personalizacion_array);

        // Devolver los datos en formato JSON
        echo json_encode($personalizacion_asociativo);
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