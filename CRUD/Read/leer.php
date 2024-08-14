<?php
// Ejecutar la consulta, dependiendo de que lectura se realice en el archivo que incluya este documento
$result = $conn->query($sql);

// Obtener los nombres de las columnas
$columns = array();
if ($result->num_rows > 0) {
    // Obtener la primera fila para usar los nombres de columna
    $row = $result->fetch_assoc();
    $columns = array_keys($row);
}

// Volver a posicionar el puntero del resultado al inicio
$result->data_seek(0);

$rows = array();
while($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Personalización</title>
    <style>
        table {   
            width: 100%;
            height: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 10px;
            color: white;
            text-align: center;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #96eff0;
            color: #333;
        }

        table tr:nth-child(even) {
            background-color: #11b5df;
        }
    </style>
</head>
<body>
    <table>
        <tbody>
            <?php
            foreach ($columns as $column) {
                echo '<tr>';
                echo '<td>' . $column . '</td>';
                foreach ($rows as $row) {
                    echo '<td>' . $row[$column] . '</td>';
                }
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</body>
</html>