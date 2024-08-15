<?php
session_start(); // Iniciar la sesión

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

    // Obtenemos los valores ingresados en el index.php
    $email = $_POST['email'];
    $password = $_POST['contrasena'];

    try 
    {
        // llamar a la función loginAmbientesVirtuales con el email concatenado y la contraseña proporcionada
        $respuesta = loginAmbientesVirtuales($email."@pascualbravo.edu.co", $password);

        // Si la respuesta de la API es éxitosa
        if ($respuesta['Success']) 
        {
            $_SESSION['loggedin'] = true; // <- Establece que el usuario está logueado
            // Almacenar cada dato en una variable de sesión independiente
            $_SESSION['Identificacion'] = $respuesta['Datos']['Identificacion'];
            $_SESSION['NombreCompleto'] = $respuesta['Datos']['NombreCompleto'];
            $_SESSION['TipoDeUsuario'] = $respuesta['Datos']['TipoDeUsuario'];
            $_SESSION['Programa'] = $respuesta['Datos']['Programa'];
            $_SESSION['Facultad'] = $respuesta['Datos']['Facultad'];

            // Redirigir a la página deseada
            //header("location:login/index_login.php");
            // Redirigir con JavaScript
            echo '<script>
                    window.location.href = "login/index_login.php";
                  </script>';
            exit();
        } 
        else 
        {
            $_SESSION['error'] = "Usuario o contraseña inválidos"; //Se almacena un mensaje de error
            $_SESSION['email'] = $email; //Se almacena el correo electrónico ingresado
            header("Location:index.php"); //Redirige al usuario de vuelta a la página index.php para que intente nuevamente, y detiene la ejecución del script.
            exit();
        }
    } 
    // Si ocurre alguna excepción durante el proceso (como un error en la solicitud cURL):
    catch (Exception $e) 
    {
        $_SESSION['error'] = 'Error: ' . $e->getMessage(); // Almacena el mensaje de error en
        $_SESSION['email'] = $email; // Almacena el correo electrónico ingresado
        header("Location:index.php"); // Redirige al usuario de vuelta a la página
        exit();
    }
} 

// Recuperar mensaje de error y datos del usuario, si existen
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

// Limpiar la sesión
unset($_SESSION['error']);
unset($_SESSION['email']);
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
            height: 100vh;
        }
        .error-message {
            color: red;
            font-weight: bold;
            text-align: center;
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
            <?php if (!empty($error)): ?>
                <div class="error-message">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <form action="index.php" method="POST">
                <div class="textbox">
                    <input type="text" style="width: 100px;" placeholder="Usuario" name="email" value="<?= htmlspecialchars($email) ?>" required>
                    <span>@pascualbravo.edu.co</span>
                </div>
                <div class="textbox">
                    <input type="password" placeholder="Contraseña" name="contrasena" required>
                    <button type="button" onclick="togglePasswordVisibility()">👁️</button>
                </div>
                <input type="submit" class="btn" value="Ingresar">
                <br><br>
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