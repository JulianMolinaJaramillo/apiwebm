<?php
// Incluir el archivo de conexión a la base de datos
include('../../connection.php');

// Comprobar si se ha hecho una solicitud GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') 
{
    // Preparar la consulta para obtener el campo furtivos
    $sql_select = "SELECT furtivos FROM lad_taller ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql_select);

    // Verificar si hay resultados
    if ($result && $result->num_rows > 0) 
    {
        // Obtener el registro
        $row = $result->fetch_assoc();
        echo $row['furtivos'];
    } 
    else 
    {
        echo "No se encontraron registros.";
    }

    $conn->close(); // Cerrar la conexión a la base de datos
} 
else 
{
    echo "Error: Solicitud no válida.";
}
?>