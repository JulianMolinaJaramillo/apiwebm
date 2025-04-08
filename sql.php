<?php
require 'connection.php'; // Incluye la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query = trim($_POST['sql_query']);

    if (!empty($query)) {
        $result = $conn->query($query);
        if ($result) {
            echo "Consulta ejecutada con éxito.<br>";

            // Si la consulta es un SELECT, mostramos los resultados en tabla
            if (stripos($query, 'SELECT') === 0) {
                if ($result->num_rows > 0) {
                    echo "<table border='1'><tr>";
                    
                    // Obtener nombres de las columnas
                    $fields = $result->fetch_fields();
                    foreach ($fields as $field) {
                        echo "<th>{$field->name}</th>";
                    }
                    echo "</tr>";

                    // Obtener filas de resultados
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        foreach ($row as $value) {
                            echo "<td>{$value}</td>";
                        }
                        echo "</tr>";
                    }

                    echo "</table>";
                } else {
                    echo "La consulta no devolvió resultados.";
                }
            }
        } else {
            echo "Error en la consulta: " . $conn->error;
        }
    } else {
        echo "Por favor, ingrese una consulta SQL.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejecutar SQL</title>
</head>
<body>
    <h2>Ejecutar Sentencia SQL</h2>
    <form method="POST">
        <textarea name="sql_query" rows="5" cols="50" placeholder="Escribe tu consulta SQL aquí..."></textarea><br>
        <button type="submit">Ejecutar</button>
    </form>
</body>
</html>
