<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personalizacion</title>
    <link rel="stylesheet" href="../CSS/style_personalizacion.css">
</head>
<body>
    <section class="imagenes">
        <h2>Personalizacion</h2>
        <div class="imagenes-container">
            <div class="imagen">
            <h1>Personaje</h1>
                <div class="tabla-container">
                    <iframe src="../CRUD/Read/leer_datos_personaje.php" frameborder="0"></iframe>
                </div>
                <img src="../imagenes/a.png" >
            </div>
            <div class="imagen">
            <h1>Colores</h1>
                <div class="tabla-container2">
                    <iframe src="../CRUD/Read/leer_datos_color.php" frameborder="0"></iframe>
                </div>
                <img src="../imagenes/a.png">
            </div>
            <div class="imagen">
            <h1>Furtivo</h1>
                <div class="tabla-container2">
                    <iframe src="../CRUD/Read/leer_datos_furtivo.php" frameborder="0"></iframe>
                </div>
                <img src="../imagenes/a.png">
            </div>
        </div>
    </section>
    <section class="footer">
        <button onclick="window.location.href='../login/index_login.php';">Regresar</button>
    </section>
</body>
</html>