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
$email = $_POST['email'];
$password = $_POST['password'];

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
            header("location:../index/index.php");
        }
        elseif ($respuesta['Datos']['TipoDeUsuario'] == 'Estudiante') 
        {
            header("location:../index/index.php");
        }
        // Si la respuesta es correcta enviamos al usuario al principal.php
        header("location:../index/index.php");
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

<!doctype html>
<html lang="en">
<head>
    <style>
        body {
            /* Fondo de imagen centrado, sin repetición y fijo */
            background: url('../imagenes/fondo.jpg') no-repeat center center fixed;
            /* Ajuste para que cubra todo el fondo */
            background-size: cover;
        }
        .card-header {
            background-color: #ffffff; /* Fondo para el encabezado de la tarjeta */
        }
        .card {
            color: #29b2c2; /* Fondo para la tarjeta */
        }
        h2 {
            text-align: center; /* Alineación central del título h2 */
            color: #29b2c2;  /* Color del texto del título h2 */
        }
        .form-label strong {
            color: #6a3458; /* Color del texto fuerte (strong) dentro de las etiquetas label */
        }
    </style>
    <title>Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center g-2">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <br/>
                <div class="card text-white bg-primary mb-3" style="max-width: 25rem;">
                    <div class="card">
                        <div class="card-header">
                            <h2>Iniciar Sesión</h2>
                        </div>
                            <div class="card-body">
                                <!-- Redigirimos los datos al archivo login.php en metodo POST -->
                                <form action="index.php" method="post">
                                    <div class="mb-3">
                                        <label for="usuario" class="form-label"><strong>USUARIO:</strong></label>
                                        <input class="form-control" type="text" id="usuario" name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="contrasena" class="form-label"><strong>CONTRASEÑA:</strong></label>
                                        <input class="form-control" type="password" id="contrasena" name="password" required>
                                    </div>
                                    <div class="vh-5 row m-3 text-center align-items-center justify-content-center">
                                        <button class="btn btn-info" type="submit">Ingresar al portafolio</button>
                                    </div>
                                </form>
                            </div>
                        <div class="card-footer text-muted"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>  
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGFEDVi7A5vBPCDNBuPSSZn1w3XtOe9c/vkl0V5HI2z9" crossorigin="anonymous"></script>
</body>

</html>