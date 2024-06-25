<?php
/**Codigo Fuente:
 * Autor: Julian David Molina Jaramillo
 * CC: 1152687834
 * Fecha: 21/06/2024
 */
//Incluimos el archivo connection
include('connection.php');

//Ejecutamos la conexion
$conect = connection();
//Definimos Query SQL
$sql = "SELECT * FROM personaje";
//Ejecutamos el Query
$query = mysqli_query($conect , $sql);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Index Pascual Bravo</title>
</head>
<body>
    <!-- Formulario de personalización -->
    <div class="users-form">
        <form action="insert_producto.php" method ="POST">
            <h1> Tu Perfil De Personalización </h1>
            <label for="opciones">Género</label>
                <select id="opciones" name="genero" multiple>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
            <input type="text" name="cuerpo" placeholder="Cuerpo">
            <input type="text" name="cabeza" placeholder="Cabeza">
            <input type="text" name="cejas" placeholder="Cejas">
            <input type="text" name="cabello" placeholder="Cabellos">
            <input type="text" name="reloj" placeholder="Relojes">
            <input type="text" name="sombrero" placeholder="Sombrero">
            <input type="text" name="zapatos" placeholder="Zapatos">
            <input type="text" name="ojos" placeholder="Ojos">
            <input type="text" name="maleta" placeholder="Maleta">
            <input type="submit" value="Personalizar">
        </form>
    </div>
    <div class="users-table">
        <h2>Personajes Registrados</h2>
        <!-- Tabla con los datos de los personajes ingresados -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Género</th>
                    <th>Cuerpo</th>
                    <th>Cabeza</th>
                    <th>Cejas</th>
                    <th>Cabellos</th>
                    <th>Relojes</th>
                    <th>Sombrero</th>
                    <th>Zapatos</th>
                    <th>Ojos</th>
                    <th>Maleta</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php 
                //Por cada personaje nuevo que se encuentre en la base de datos imprime la infomracion
                while($row = mysqli_fetch_array($query)): 
                ?>
                <tr>
                <th><?= $row['id'] ?></th>
                <th><?= $row['genero'] ?></th>
                <th><?= $row['cuerpo'] ?></th>
                <th><?= $row['cabeza'] ?></th>
                <th><?= $row['cejas'] ?></th>
                <th><?= $row['cabello'] ?></th>
                <th><?= $row['reloj'] ?></th>
                <th><?= $row['sombrero'] ?></th>
                <th><?= $row['zapatos'] ?></th>
                <th><?= $row['ojos'] ?></th>
                <th><?= $row['maleta'] ?></th>

                <th><a href="update.php?id=<?= $row['id'] ?>" class="users-table--edit">Editar</a></th>
                <th><a href="delete_personaje.php?id=<?= $row['id'] ?>" class="users-table--edit">Eliminar</a></th>             
                </tr>  
                <?php 
                //Finalizamos el ciclo While
                endwhile;
                ?>                          
            </tbody>
        </table>
        <br>
    </div>
    <br/>
</body>
</html>