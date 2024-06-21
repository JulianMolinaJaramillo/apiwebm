<?php
//iniciamos la sesion
//session_start();
include('connection.php');

if ($_POST) 
{
    //validamos si el usuario y contraseña estan correctos
    if (($_POST['usuario'] == "prueba") && ($_POST['contrasena']=="123")) 
    {
        //creamos variable de sesion
        //$_SESSION['usuario']="prueba";

        //Funcion header nos permite enviar al usuario a una locación o direccion especifica
        header("location:index.php");
    }else 
    {
        echo '<script> alert("Usuario o contraseña incorrecta"); </script>';
    }
}

?>

<!doctype html>
<html lang="en">

<head>
<style>
    h2 {text-align: center;}
</style>
  <title>Login</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>
<!-- bs5-grid-container -->
<div class="container">
    <!-- bs5-grid-row -->
    <div class="row justify-content-center align-items-center g-2">
        <!-- bs5-grid-col -->
        <div class="col-md-4">
            </div>
                <div class="col-md-4">
                <!-- bs5-grid-card-head-foot -->
                <br/>
                    <div class="card">
                        <div class="card-header">
                            <h2>Iniciar Sesión</h2>
                        </div>
                        <div class="card-body">
                        <form action="login.php" method="post">
                            <strong>USUARIO:</strong>                        
                            <input class="form-control" type="text" name="usuario">
                            <br/>
                            <strong>CONTRASEÑA:</strong>                         
                            <input class="form-control" type="password" name="contrasena">
                            <br/>
                            <!-- clase para centrar un texto e items -->
                            <div class="vh-5 row m-3 text-center align-items-center justify-content-center"><button class="btn btn-outline-dark" type="submit">Ingresar al portafolio</button></div>      
                         </form>
                        </div>
                        <div class="card-footer text-muted">
                        </div>
                    </div>
                </div>
            <div class="col-md-4">
        </div>
    </div>
</div>
</body>

</html>