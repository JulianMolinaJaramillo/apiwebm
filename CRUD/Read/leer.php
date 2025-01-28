<?php
// Ejecutar la consulta, dependiendo de que lectura se realice en el archivo que incluya este documento
$result = $conn->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Obtener el valor de la columna 'personalizacion'
    $row = $result->fetch_assoc(); // Extraemos las filas de la consulta y las devolvemos en array
    $personalizacion = $row['personalizacion'];

    // Dividir la cadena de personalización en un array
    $datos_personalizacion = explode('|', $personalizacion);

    // La variable $id_datos se encuentra en cada uno de los archivos  leer_datos_personaje, leer_datos_furtivo y leer_datos_color
    if ($id_datos == "personaje") 
    {
        // Obtener los primeros 10 datos
        $datos_a_leer = array_slice($datos_personalizacion, 0, 10);
    }
    elseif ($id_datos == "color") 
    {
        // Obtener los primeros 5 datos desde la posicion 10 del array
        $datos_a_leer = array_slice($datos_personalizacion, 10, 5);
    }
    elseif ($id_datos == "furtivo") 
    {
        // Obtener los primeros 6 datos desde la posicion 15 del array
        $datos_a_leer = array_slice($datos_personalizacion, 15, 6);
    }
    
} 
else 
{
    // Sino se encuentra ningun datos, dejamos el array vacio
    $datos_a_leer = [];
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
        <thead>
            <tr>
                <th>Dato</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($datos_a_leer)) {
                foreach ($datos_a_leer as $index => $dato) 
                {     
                    //  El índice del array se utiliza para asegurarse de que los nombres y los datos se alineen correctamente en las filas.
                    // La variable $nombre_columna  se encuentra en cada uno de los archivos  leer_datos_personaje, leer_datos_furtivo y leer_datos_color
                    $nombre_columna = isset($nombre_columnas[$index]) ? $nombre_columnas[$index] : "Sin nombre";  // Verificar si existe el nombre de columna correspondiente en el array

                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($nombre_columna) . '</td>'; // Mostrar el nombre de la columna
                    echo '<td>' . htmlspecialchars($dato) . '</td>'; // Mostrar el dato
                    echo '</tr>';
                }
            } 
            else 
            {
                echo '<tr><td>No se encontraron datos.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</body>
</html>