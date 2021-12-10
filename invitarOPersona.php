<?php
	$json = array();
	$estado = "ok";
	if (isset($_POST['correo'], $_POST['nombre'], $_POST['app'])){
		include('conBD.php');
		include("emailInvitacion.php");//Mando a llamar la funcion que se encarga de enviar el correo electronico
		
		$codigo = $_POST['codigo'];
		$nombre = $_POST['nombre'];
	    $app = $_POST['app'];
	    $genero = $_POST['genero'];
	    $correoe = $_POST['correo'];
	    $consulta = $connection->prepare("SELECT * FROM usuario WHERE correo_e=:email");
	    $consulta->bindParam("email", $correoe, PDO::PARAM_STR);
	    $consulta->execute();
	 
	    if ($consulta->rowCount() > 0) {
	    	$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
	       $consulta = $connection->prepare("INSERT INTO solicitud_int (id_usuario_dest, codigo_int) VALUES (:id_usuario_dest, :codigo_int)");
			$consulta->bindParam("id_usuario_dest", $resultado["id_usuario"], PDO::PARAM_STR);
			$consulta->bindParam("codigo_int", $_POST['codigo'], PDO::PARAM_STR);
			$resultado = $consulta->execute();
			if($resultado){
				$estado = "invitacion enviada";
				array_push($json, array("estado" => $estado));
				echo json_encode($json);
			} else{
				$estado = "Error al invitar";
				array_push($json, array("estado" => $estado));
				echo json_encode($json);
			}
	    } else if ($consulta->rowCount() == 0) {
	        $consulta = $connection->prepare("INSERT INTO usuario (correo_e, nombre, apellidos, genero) VALUES (:email, :nombre, :app, :genero)");
	        $consulta->bindParam("email", $correoe, PDO::PARAM_STR);
	        $consulta->bindParam("nombre", $nombre, PDO::PARAM_STR);
	        $consulta->bindParam("app", $app, PDO::PARAM_STR);
	        $consulta->bindParam("genero", $genero, PDO::PARAM_STR);
	        $resultado = $consulta->execute();

	        if ($resultado) {

	        	$consulta = $connection->prepare("SELECT LAST_INSERT_ID() as id");
		    	 $consulta->execute();
		    	 $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		         $id = $resultado['id'];
	            /*Configuracion de variables para enviar el correo*/
				$mail_username = "swappy.intercambio@gmail.com";
		    	$mail_userpassword = "swappypass";
				$mail_addAddress = $_POST['correo'];//correo electronico que recibira el mensaje
				$template="plantilla_emailInvitacion.html";//Ruta de la plantilla HTML para enviar nuestro mensaje
				
				/*Inicio captura de datos enviados por $_POST para enviar el correo */
				$mail_setFromEmail = "swappy.intercambio@gmail.com";
				$mail_setFromName = $_POST['nombre'];
				$txt_message = "te invito al intercambio";
				$mail_subject = "invitacion";
				$url = "id=".$id."&codigo=".$codigo."&correo=".$_POST["correo"];
				emailInvitacion($mail_username,$mail_userpassword,$mail_setFromEmail,$mail_setFromName,$mail_addAddress,$txt_message,$mail_subject,$template, $url);//Enviar el mensaje
				$estado = "invitacion enviada";
				array_push($json, array("estado" => $estado));
				echo json_encode($json);
	        } else {
	            $estado = "Error al enviar el correo";
				array_push($json, array("estado" => $estado));
				echo json_encode($json);
	        }
	    }
	} else{
		$estado = "Complete los campos";
		array_push($json, array("estado" => $estado));
		echo json_encode($json);
	}
?>