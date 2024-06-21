<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $url = "https://sicau.pascualbravo.edu.co/SICAU/API/ServicioLogin/LoginAmbientesVirtuales";
    
    // Recibe los datos del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Construye el array de datos para enviar
    $data = array(
        "Email" => $email,
        "Contraseña" => $password
    );
    
    // Llave de autenticación
    $apiKey = "s1c4uc0ntr0ld34cc3s02019*";
    
    // Inicializa cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: ' . $apiKey
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Ejecuta la solicitud
    $response = curl_exec($ch);
    
    // Manejo de errores de cURL
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
    }
    
    curl_close($ch);
    
    // Decodifica la respuesta
    $result = json_decode($response, true);
    
    // Muestra la respuesta completa para depuración
    echo "<pre>";
    echo "Raw Response:\n";
    echo htmlspecialchars($response);
    echo "\n\nParsed Response:\n";
    print_r($result);
    echo "\n\ncURL Error:\n";
    echo isset($error_msg) ? htmlspecialchars($error_msg) : 'No errors';
    echo "</pre>";
    
    // Muestra la respuesta en formato HTML
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Respuesta del Login</title>
    </head>
    <body>
        <h1>Respuesta del Login</h1>
        <?php if (isset($result['Success']) && $result['Success']) : ?>
            <p><strong>Identificación:</strong> <?php echo htmlspecialchars($result['Datos']['Identificacion'] ?? 'N/A'); ?></p>
            <p><strong>Nombre Completo:</strong> <?php echo htmlspecialchars($result['Datos']['NombreCompleto'] ?? 'N/A'); ?></p>
            <p><strong>Tipo de Usuario:</strong> <?php echo htmlspecialchars($result['Datos']['TipoDeUsuario'] ?? 'N/A'); ?></p>
            <p><strong>Programa:</strong> <?php echo htmlspecialchars($result['Datos']['Programa'] ?? 'N/A'); ?></p>
            <p><strong>Facultad:</strong> <?php echo htmlspecialchars($result['Datos']['Facultad'] ?? 'N/A'); ?></p>
        <?php else : ?>
            <p><strong>Error:</strong> <?php echo htmlspecialchars($result['Mensaje'] ?? 'Error desconocido'); ?></p>
        <?php endif; ?>
        <a href="index.html">Volver al formulario</a>
    </body>
    </html>
    <?php
} else {
    echo "Método no permitido.";
}
?>