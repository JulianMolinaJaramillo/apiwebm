<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<p>Solicitud POST recibida.</p><pre>";
    print_r($_POST);
    echo "</pre>";

    echo "Datos Recibidos";
    echo "<form>";

    // Iterar sobre los datos recibidos y mostrarlos en un formulario
    foreach ($_POST as $key => $value) {
        echo "<label for='{$key}'>" . ucfirst($key) . ":</label>";
        echo "<input type='text' id='{$key}' name='{$key}' value='{$value}' readonly><br><br>";
    }

    echo "</form>";
} else {
    echo "No se ha hecho un envío POST";
}

?>