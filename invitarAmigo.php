<?php

	session_start();
 
    if(!isset($_SESSION['id'])){
        header('Location: index.html');
        exit;
    }
	include('conBD.php');

	if(isset($_POST["correo"])){
		$consulta = $connection->prepare("SELECT id_usuario FROM usuario WHERE correo_e = :correo");
		$consulta->bindParam("correo", $_POST["correo"], PDO::PARAM_STR);
		$consulta->execute();
		if($consulta->rowCount() != 0){

			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);

			$consulta = $connection->prepare("INSERT INTO solicitud_amistad (id_usuario_dest, id_amigo) VALUES (:id_usuario_dest, :id_amigo)");
			$consulta->bindParam("id_usuario_dest", $resultado['id_usuario'], PDO::PARAM_STR);
			$consulta->bindParam("id_amigo", $_SESSION['id'], PDO::PARAM_STR);
			$resultado = $consulta->execute();

			$json = array();

			if($resultado){
				array_push($json, array("estado" => "invitacion enviada"));
			} else{
				array_push($json, array("estado" => "error al enviar invitacion"));
			}
			echo json_encode($json);
		}
	}

?>