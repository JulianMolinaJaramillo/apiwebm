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
    $stmt_check = $conn->prepare($sql_check);
    // Asociar el parámetro $id_usuario a la consulta/sentencia preparada
    $stmt_check->bind_param("i", $id_usuario);
    // Ejecutar la consulta/sentencia preparada
    $stmt_check->execute();
    // Almacenar el resultado de la consulta/sentencia
    $stmt_check->store_result();

    // Verificamos si hay algun registro con ese usuario
    if ($stmt_check->num_rows == 0) {
        echo "Usuario no encontrado";
        $stmt_check->close();
        exit;
    }
    $stmt_check->close(); // Cerramos la consulta

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

    // Si el id_usuario existe, proceder con la inserción en la tabla personalizacion
    // Asegúrate de que la cantidad de signos ? coincida con el número de columnas en la tabla
    $sql_insert = "INSERT INTO personalizacion (id_usuario, genero, maleta, cuerpo, cabeza, cejas, cabello, reloj, sombrero, zapatos, tamano, color1, color2, color3, color4, color5, carroceria, aleron, silla, volante, llanta, bateria) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    // Preparar la consulta/sentencia de inserción
    $stmt_insert = $conn->prepare($sql_insert);
       
    // Si la consulta/sentencia de inserción se preparó correctamente
    if ($stmt_insert) 
    {
        // Asociar los parámetros a la consulta/sentencia preparada e indicamos que cada parametro asociado a la consulta es entero = i
        $stmt_insert->bind_param("iiiiiiiiiiiiiiiiiiiiii", $id_usuario, $genero, $maleta, $cuerpo, $cabeza, $cejas, $cabello, $reloj, $sombrero, $zapatos, $tamano, $color1, $color2, $color3, $color4, $color5, $carroceria, $aleron, $silla, $volante, $llanta, $bateria);
                
        // Ejecutar la consulta/sentencia de inserción
        if ($stmt_insert->execute()) {
            echo "Datos insertados con éxito."; // Mensaje de éxito
        } 
        else 
        {
            echo "Error al insertar los datos: " . $stmt_insert->error; // Mensaje de error
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
?>