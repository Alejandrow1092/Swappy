<?php
 
include('conBD.php');
session_start();
 
if (isset($_POST['crear'])) {
    $mensaje = "";
    $nombre = $_POST['nombre'];
    $app = $_POST['app'];
    $genero = $_POST['genero'];
    $correoe = $_POST['correoe'];
    $contrasena = $_POST['pass'];
    $password_hash = password_hash($contrasena, PASSWORD_BCRYPT);
    $consulta = $connection->prepare("SELECT * FROM usuario WHERE correo_e=:email");
    $consulta->bindParam("email", $correoe, PDO::PARAM_STR);
    $consulta->execute();
 
    if ($consulta->rowCount() > 0) {
       $mensaje = 'Este correo ya ha sido registrado.';
    }
 
    if ($consulta->rowCount() == 0) {
        $consulta = $connection->prepare("INSERT INTO usuario (correo_e, contrasena, nombre, apellidos, genero) VALUES (:email,:password_hash,:nombre, :app, :genero)");
        $consulta->bindParam("email", $correoe, PDO::PARAM_STR);
        $consulta->bindParam("nombre", $nombre, PDO::PARAM_STR);
        $consulta->bindParam("app", $app, PDO::PARAM_STR);
        $consulta->bindParam("password_hash", $password_hash, PDO::PARAM_STR);
        $consulta->bindParam("genero", $genero, PDO::PARAM_STR);
        $resultado = $consulta->execute();

        if ($resultado) {
            header("Location: index.html");
        } else {
            $mensaje = 'Error. Vuelva a intentarlo.';
        }
    }
}
 
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/index.css">
        <link rel="stylesheet" href="css/botones.css">
        <title>Swappy</title>
    </head>
    <body>
        <nav>
            
        </nav>
        <h1>Swappy</h1>
        <div id="datosLogin">
            <input type="text" name="estado" id="estado" value="<?=$mensaje?>">
        </div>
            <br>
            <button id="volver" name="volver" class="boton" onclick="location.href='index.html'">Volver</button>
    </body>
</html>