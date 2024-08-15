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
    $sql_check_usuario = "SELECT id_usuario FROM usuarios WHERE id_usuario = ?";
    $stmt_check_usuario = $conn->prepare($sql_check_usuario); // preparar la consulta
    $stmt_check_usuario->bind_param("i", $id_usuario); // Asociar el parámetro $id_usuario a la consulta/sentencia preparada
    $stmt_check_usuario->execute(); // Ejecutar la consulta/sentencia preparada
    $stmt_check_usuario->store_result(); // Almacenar el resultado de la consulta/sentencia

    // Verificamos si hay algun registro con ese usuario
    if ($stmt_check_usuario->num_rows == 0) 
    {
        // Si se encuentra que no hay registros, enviamos mensaje y cerramos consulta
        echo "Usuario no encontrado";
        $stmt_check_usuario->close();
        exit;
    }
    $stmt_check_usuario->close(); // Cerramos la consulta de la tabla usuarios

    // Verificar si el id_usuario ya existe en la tabla personalizacion
    $sql_check_personalizacion = "SELECT id_usuario FROM personalizacion WHERE id_usuario = ?";
    $stmt_check_personalizacion = $conn->prepare($sql_check_personalizacion); // preparar la consulta
    $stmt_check_personalizacion->bind_param("i", $id_usuario); // Asociar el parámetro $id_usuario a la consulta/sentencia preparada
    $stmt_check_personalizacion->execute(); // Ejecutar la consulta/sentencia preparada
    $stmt_check_personalizacion->store_result(); // Almacenar el resultado de la consulta/sentencia

    // Listado de variables esperadas
    $expected_variables = [
        'genero', 'maleta', 'cuerpo', 'cabeza', 'cejas', 'cabello', 'reloj', 
        'sombrero', 'zapatos', 'tamano', 'color1', 'color2', 'color3', 
        'color4', 'color5', 'carroceria', 'aleron', 'silla', 'volante', 
        'llanta', 'bateria'
    ];

    // Validación de todas las variables
    foreach ($expected_variables as $key => $var) 
    {
        if (!isset($_POST["dato$key"]) || !is_numeric($_POST["dato$key"])) {
            echo "Error: La variable dato$key ($var) es inválida o no está definida.";
            exit;
        }
    }

    // Recibir los datos enviados por el formulario y convertirlos a enteros intval()
    $genero = intval($_POST['dato0']);
    $maleta = intval($_POST['dato1']);
    $cuerpo = intval($_POST['dato2']);
    $cabeza = intval($_POST['dato3']);
    $cejas = intval($_POST['dato4']);
    $cabello = intval($_POST['dato5']);
    $reloj = intval($_POST['dato6']);
    $sombrero = intval($_POST['dato7']);
    $zapatos = intval($_POST['dato8']);
    $tamano = intval($_POST['dato9']);
    $color1 = intval($_POST['dato10']);
    $color2 = intval($_POST['dato11']);
    $color3 = intval($_POST['dato12']);
    $color4 = intval($_POST['dato13']);
    $color5 = intval($_POST['dato14']);
    $carroceria = intval($_POST['dato15']);
    $aleron = intval($_POST['dato16']);
    $silla = intval($_POST['dato17']);
    $volante = intval($_POST['dato18']);
    $llanta = intval($_POST['dato19']);
    $bateria = intval($_POST['dato20']);

    // Validamos si ya hay un registro en la tabla personalizacion
    if ($stmt_check_personalizacion->num_rows > 0) 
    {
        // Si existe en la tabla personalizacion, realizar una actualización en lugar de insertar
        $sql_update = "UPDATE personalizacion SET genero = ?, maleta = ?, cuerpo = ?, cabeza = ?, cejas = ?, cabello = ?, reloj = ?, sombrero = ?, zapatos = ?, tamano = ?, color1 = ?, color2 = ?, color3 = ?, color4 = ?, color5 = ?, carroceria = ?, aleron = ?, silla = ?, volante = ?, llanta = ?, bateria = ? WHERE id_usuario = ?";
        $stmt_update = $conn->prepare($sql_update); // preparamos la consulta

        // Si se preparó correctamente
        if ($stmt_update) 
        {
            // Blindamos los parametros como enteros =i e insertamos
            $stmt_update->bind_param("iiiiiiiiiiiiiiiiiiiiii", $genero, $maleta, $cuerpo, $cabeza, $cejas, $cabello, $reloj, $sombrero, $zapatos, $tamano, $color1, $color2, $color3, $color4, $color5, $carroceria, $aleron, $silla, $volante, $llanta, $bateria, $id_usuario);

            // Si se ejecutó correctamente
            if ($stmt_update->execute()) 
            {
                echo "Datos actualizados con éxito."; // Mensaje de éxito
            } 
            else 
            {
                echo "Error al actualizar los datos: " . $stmt_update->error; // Mensaje de error
            }
            $stmt_update->close();// Cerramos la consulta
        } 
        // Sino se preparó correctamente
        else 
        {
            echo "Error al preparar la consulta de actualización: " . $conn->error; // Mensaje de error si la preparación falla
        }
    } 
    else 
    {
        // Si no existe en la tabla personalizacion, proceder con la inserción Asegúrar de que la cantidad de signos ? coincida con el número de columnas en la tabla en la BD
        $sql_insert = "INSERT INTO personalizacion (id_usuario, genero, maleta, cuerpo, cabeza, cejas, cabello, reloj, sombrero, zapatos, tamano, color1, color2, color3, color4, color5, carroceria, aleron, silla, volante, llanta, bateria) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt_insert = $conn->prepare($sql_insert); // preparamos la consulta
            
        // Si se preparó correctamente
        if ($stmt_insert) 
        {
            // Blindamos los parametros como enteros =i e insertamos
            $stmt_insert->bind_param("iiiiiiiiiiiiiiiiiiiiii", $id_usuario, $genero, $maleta, $cuerpo, $cabeza, $cejas, $cabello, $reloj, $sombrero, $zapatos, $tamano, $color1, $color2, $color3, $color4, $color5, $carroceria, $aleron, $silla, $volante, $llanta, $bateria);
                
            // Si se ejecutó correctamente
            if ($stmt_insert->execute()) 
            {
                echo "Datos insertados con éxito."; // Mensaje de éxito
            } 
            else 
            {
                echo "Error al insertar los datos: " . $stmt_insert->error; // Mensaje de error
            }
            $stmt_insert->close();
        } 
        else 
        {
            echo "Error al preparar la consulta de inserción: " . $conn->error; // Mensaje de error si la preparación falla
        }
    }
    $stmt_check_personalizacion->close(); // Cerramos la consulta de verificación en personalizacion para liberar memoria del server
    $conn->close(); // Cerrar la conexión a la base de datos
}
?>