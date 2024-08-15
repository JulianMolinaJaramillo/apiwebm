<?php
// Incluir el archivo de conexión a la base de datos
include('../../connection.php');

// Comprobar si se ha hecho una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    // Recibir el id_usuario y verificar que sea un número entero
    if (!isset($_POST['id_usuario']) || !is_numeric($_POST['id_usuario'])) {
        echo "Error: id_usuario es inválido o no está definido";
        exit;
    }
    // Almacenamos el dato id_usuario en variable
    $id_usuario = intval($_POST['id_usuario']);

    // Verificar si el id_usuario existe en la tabla usuarios
    $sql_check = "SELECT id_usuario FROM usuarios WHERE id_usuario = ?";
    $stmt_check = $conn->prepare($sql_check); // Preparamos la consulta
    $stmt_check->bind_param("i", $id_usuario); // Asociar el parámetro $id_usuario a la consulta/sentencia preparada
    $stmt_check->execute(); // Ejecutar la consulta/sentencia preparada 
    $stmt_check->store_result(); // Almacenar el resultado de la consulta/sentencia

    // Verificamos si hay algun registro con ese usuario
    if ($stmt_check->num_rows > 0) {
        echo "El usuario ya existe en el sistema";
        $stmt_check->close();
        exit;
    }
    // Sino exite
    else
    {
        $stmt_check->close(); // Cerramos la consulta para liberar recursos del servidor

        // Recibir los datos enviados por el formulario y convertirlos a enteros intval()
        $personalizacion = $_POST['personalizacion'];
        $tiempo_uso = intval($_POST['tiempo_uso']);
        $num_conexiones = intval($_POST['num_conexiones']);
        $genero = intval($_POST['genero']);
        $tipo_usuario = intval($_POST['tipo_usuario']);

        // Asegúrate de que la cantidad de signos ? coincida con el número de columnas en la tabla e insertamos en la tabla Usuarios
        $sql_insert = "INSERT INTO usuarios (id_usuario, personalizacion, tiempo_uso, num_conexiones, genero, tipo_usuario) VALUES (?,?,?,?,?,?)";
        $stmt_insert = $conn->prepare($sql_insert); // Preparar la consulta/sentencia de inserción

        // Si la consulta/sentencia de inserción se preparó correctamente
        if ($stmt_insert) 
        {
            // Asociar los parámetros a la consulta/sentencia preparada e indicamos que cada parametro asociado a la consulta es entero = i o string = s
            $stmt_insert->bind_param("isiiii", $id_usuario, $personalizacion, $tiempo_uso, $num_conexiones, $genero, $tipo_usuario);
                    
            // Ejecutar la consulta/sentencia de inserción
            if ($stmt_insert->execute()) {
                echo "Usuario creado con exito"; // Mensaje de éxito
            } 
            else 
            {
                echo "Error al crear usuario " . $stmt_insert->error; // Mensaje de error
            }
            // Cerrar la consulta/sentencia de verificación
            $stmt_insert->close();
        } 
        else 
        {
            echo "Error al preparar la consulta de inserción: " . $conn->error; // Mensaje de error si la preparación falla
        }
        // Cerrar la conexión a la base de datos
        $conn->close(); 
    }   
}          
?>