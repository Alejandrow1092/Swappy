<?php

include('conBD.php');

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
<?php
$mensaje = "";
if(isset($_POST["email"], $_POST["pass"])):
	try{
	$consulta = $connection->prepare("SELECT * FROM usuario WHERE correo_e = :user");
	$consulta->bindParam("user", $_POST["email"], PDO::PARAM_STR);
	$consulta->execute();
	} catch(PDOException $exc){
		die($exc -> getMessage());
	}
	
	if($consulta->rowCount() != 0):
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		
		if (password_verify($_POST["pass"], $resultado["contrasena"])):
			session_start();
			$_SESSION['id'] = $resultado["id_usuario"];
			$_SESSION['nombre'] = $resultado["nombre"];
			$_SESSION['user'] = $resultado["correoe"];
			header("Location: home.php");
		else:
			$mensaje = "Error. Contraseña Incorrecta.";
		endif;
	else:
		$mensaje = "Error. No existe la cuenta de correo a la que intenta acceder.";
	endif;
endif;
?>
		<div id="datosLogin">
            <input type="text" name="estado" id="estado" value="<?=$mensaje?>">
        </div>
            <br>
            <button id="volver" name="volver" class="boton" onclick="location.href='index.html'">Volver</button>
	</body>
</html>