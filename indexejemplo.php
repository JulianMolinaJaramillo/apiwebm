<?php
// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

// Funcion que recibe los parametros de correo y contraseña para validar la autenticación
function loginAmbientesVirtuales($email, $password) 
{
    // url a consumir
    $url = 'https://sicau.pascualbravo.edu.co/SICAU/API/ServicioLogin/LoginAmbientesVirtuales';

    // Cabeceras
    $cabecera = [
        'Content-Type: application/json',
        'Authorization: s1c4uc0ntr0ld34cc3s02019*'
    ];

    // Tomamos el correo y contraseña para codificarlos a formato json
    $postData = json_encode([
        'Email' => $email,
        'Contraseña' => $password
    ]);

    $ch = curl_init($url); // Inicializa una nueva sesión de la biblioteca cURL con la URL proporcionada
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Configura cURL para que devuelva la respuesta como una cadena en lugar de imprimirla directamente
    curl_setopt($ch, CURLOPT_POST, true); // Indica que se realizará una solicitud POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData); // Establece los datos POST que se enviarán con la solicitud
    curl_setopt($ch, CURLOPT_HTTPHEADER, $cabecera); // Establece las cabeceras HTTP para la solicitud

    // Deshabilitar verificación SSL (no recomendado para producción)
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $respuesta = curl_exec($ch); // Ejecuta la solicitud cURL y almacena en $respuesta.

    // Verifica si hubo errores en la ejecución de cURL. Si es así, lanza una excepción con el mensaje de error
    if (curl_errno($ch)) 
    {
        throw new Exception(curl_error($ch));
    }

    // Obtiene el código de estado HTTP de la respuesta. Si no es 200 (OK), lanza una excepción con un mensaje de error
    $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($httpStatusCode != 200) 
    {
        throw new Exception('HTTP Error: ' . $httpStatusCode);
    }

    // Cierra la sesión cURL
    curl_close($ch);

    // Decodifica la respuesta JSON y la convierte en un array PHP, que luego se devuelve
    return json_decode($respuesta, true);
}

// Obtenemos los valores ingresados en el index.html

$email = $_POST['email']."@pascualbravo.edu.co";
$password = $_POST['contrasena'];

// Establece el encabezado de la respuesta para indicar que el contenido es JSON
header('Content-Type: application/json');
try 
{
    // llamar a la función loginAmbientesVirtuales con el email y la contraseña proporcionados
    $respuesta = loginAmbientesVirtuales($email, $password);

    // Si la respuesta de la API es éxitosa, construye un array $resultado con los datos recibidos y lo codifica como JSON con formato legible (JSON_PRETTY_PRINT)
    $resultado = [];

    if ($respuesta['Success']) 
    {
        $resultado = [
            'Success' => true,
            'Mensaje' => null,
            'Datos' => [
                'Identificacion' => $respuesta['Datos']['Identificacion'],
                'NombreCompleto' => $respuesta['Datos']['NombreCompleto'],
                'TipoDeUsuario' => $respuesta['Datos']['TipoDeUsuario'] ?? null,
                'Programa' => $respuesta['Datos']['Programa'] ?? null,
                'Facultad' => $respuesta['Datos']['Facultad'] ?? null
            ]
        ];
        // Validamos si es Docente o Estudiante para saber a donde redireccionar
        if ($respuesta['Datos']['TipoDeUsuario'] == 'Docente') 
        {
            header("location:login/index_login.php");
        }
        elseif ($respuesta['Datos']['TipoDeUsuario'] == 'Estudiante') 
        {
            header("location:login/index_login.php");
        }
        // Si la respuesta es correcta enviamos al usuario al principal.php
        header("location:login/index_login.php");
    } 
    else 
    {  
        // Si la respuesta indica un error, construye un array $resultado con el mensaje de error.
        $resultado = [
            'Success' => false,
            'Mensaje' => $respuesta['Mensaje'],
            'Datos' => null
        ];    
    }
    echo json_encode($resultado, JSON_PRETTY_PRINT);
    // Si ocurre una excepción en el bloque try, captura la excepción y construye un array $errorResultado con el mensaje de error, luego lo codifica como JSON con formato legible
} 
catch (Exception $e) 
{
    $errorResultado = [
        'Success' => false,
        'Mensaje' => 'Error: ' . $e->getMessage(),
        'Datos' => null
    ];
    echo json_encode($errorResultado, JSON_PRETTY_PRINT);
}
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="CSS/style_index.css">
    <style>
        body {
            background-image: url('imagenes/fondo.jpg');
            background-size: cover;
            height: 100vh; /* Asegura que el fondo cubra toda la pantalla */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="avatar">
                <img src="imagenes/profile.png" alt="Avatar">
            </div>
            <h1>Iniciar</h1>
            <form action="indexejemplo.php" method="POST">
                <div class="textbox">
                    <input type="text" style="width: 100px;" placeholder="Usuario" name="email" required>
                    <span>@pascualbravo.edu.co</span>
                </div>
                <div class="textbox">
                    <input type="password" placeholder="Contraseña" name="contrasena" required>
                    <button type="button" onclick="togglePasswordVisibility()">👁️</button>
                </div>
                <input type="submit" class="btn" value="Ingresar">
                <br></br>
                <a href="#">¿Olvidaste tu usuario o contraseña?</a>
            </form>
        </div>
    </div>
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.querySelector('input[name="contrasena"]');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }
    </script>
</body>
</html>