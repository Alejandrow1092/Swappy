<?php
	session_start();
 
    if(!isset($_SESSION['id'])){
        header('Location: index.html');
        exit;
    }
	include('conBD.php');

	if(isset($_POST["codigo"])){
			$consulta = $connection->prepare("INSERT INTO solicitud_int (id_usuario_dest, codigo_int) VALUES (:id_usuario_dest, :codigo_int)");
			$consulta->bindParam("id_usuario_dest", $_POST['id_usuario'], PDO::PARAM_STR);
			$consulta->bindParam("codigo_int", $_POST['codigo'], PDO::PARAM_STR);
			$resultado = $consulta->execute();

			$json = array();

			if($resultado){
				
				array_push($json, array("estado" => "invitacion enviada"));
			} else{
				array_push($json, array("estado" => "error al enviar invitacion"));
			}
			echo json_encode($json);
		
	}
?>