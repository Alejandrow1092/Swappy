<?php
	include('conBD.php');
	$mensaje = "";

	if(isset($_GET["respuesta"])){
		
		if($_GET['respuesta'] == 1){
			$consulta = $connection->prepare("INSERT INTO participantes (codigo_int, id_usuario) VALUES (:codigo_int, :id_usuario)");
			$consulta->bindParam("id_usuario", $_GET['id'], PDO::PARAM_STR);
			$consulta->bindParam("codigo_int", $_GET['codigo'], PDO::PARAM_STR);
			$resultado = $consulta->execute();

			if($resultado){
				include('emailInvitacion.php');
				$mail_username = "swappy.intercambio@gmail.com";
		    	$mail_userpassword = "swappypass";
				$mail_addAddress = $_GET['correo'];//correo electronico que recibira el mensaje
				$template="plantilla_emailIntercambioShow.html";//Ruta de la plantilla HTML para enviar nuestro mensaje
				
				/*Inicio captura de datos enviados por $_POST para enviar el correo */
				$mail_setFromEmail = "swappy.intercambio@gmail.com";
				$mail_setFromName = "";
				$txt_message = "";
				$mail_subject = "Ver Intercambio";
				$url = "id=".$_GET['id']."&codigo=".$_GET['codigo'];
				emailInvitacion($mail_username,$mail_userpassword,$mail_setFromEmail,$mail_setFromName,$mail_addAddress,$txt_message,$mail_subject,$template, $url);//Enviar el mensaje
				$mensaje = "Revisa tu correo para ver el intercambio.";
			} else{
				$estado = "error1";
			}
		} else{
			$consulta = $connection->prepare("DELETE FROM usuario WHERE id_usuario = :id");
			$consulta->bindParam("id", $_GET["id"], PDO::PARAM_STR);
			$resultado = $consulta->execute();
			if ($resultado) {
				$mensaje = "No apareceras en la lista de participantes.";
			} else{
				$mensaje = "error2";
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Invitación</title>
</head>
<body>
	<p>
		<?=$mensaje?>
	</p>
</body>
</html>