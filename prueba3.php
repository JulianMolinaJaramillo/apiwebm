<?php
function loginAmbientesVirtuales($email, $password) {
    $url = 'https://sicau.pascualbravo.edu.co/SICAU/API/ServicioLogin/LoginAmbientesVirtuales';
    $headers = [
        'Content-Type: application/json',
        'Authorization: s1c4uc0ntr0ld34cc3s02019*'
    ];

    $postData = json_encode([
        'Email' => $email,
        'Contraseña' => $password
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        throw new Exception(curl_error($ch));
    }

    $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($httpStatusCode != 200) {
        throw new Exception('HTTP Error: ' . $httpStatusCode);
    }

    curl_close($ch);

    return json_decode($response, true);
}

try {
    $email = 'julian.molina834@pascualbravo.edu.co';
    $password = 'Miamolina.2015';
    $response = loginAmbientesVirtuales($email, $password);

    if ($response['Success']) {
        echo 'Login successful!' . PHP_EOL;
        echo 'User ID: ' . $response['Datos']['Identificacion'] . PHP_EOL;
        echo 'Name: ' . $response['Datos']['NombreCompleto'] . PHP_EOL;
    } else {
        echo 'Login failed: ' . $response['Mensaje'] . PHP_EOL;
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}