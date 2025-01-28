<?php
// Incluir el archivo de conexión a la base de datos
include('../../connection.php');

// Comprobar si se ha hecho una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    // Validar que se haya recibido la cadena de texto
    if (!isset($_POST['furtivos'])) {
        echo "Error: No se recibió la cadena furtivos.";
        exit;
    }

    // Obtener la cadena enviada por POST
    $furtivos = $_POST['furtivos'];

    // Preparar la consulta para insertar el campo furtivos en la tabla lab_taller
    $sql_insert = "INSERT INTO lad_taller (furtivos) VALUES (?)";
    $stmt_insert = $conn->prepare($sql_insert);

    if ($stmt_insert) 
    {
        // Bind de parámetros e inserción
        $stmt_insert->bind_param("s", $furtivos);

        // Ejecutar la consulta
        if ($stmt_insert->execute()) 
        {
            echo "Datos actualizados con éxito.";
        } 
        else 
        {
            echo "Error al actualizar los datos: " . $stmt_insert->error;
        }

        $stmt_insert->close(); // Cerrar la consulta
    } 
    else 
    {
        echo "Error al preparar la consulta de actualización: " . $conn->error;
    }

    $conn->close(); // Cerrar la conexión a la base de datos
} 
else 
{
    echo "Error: Solicitud no válida.";
}
?>
