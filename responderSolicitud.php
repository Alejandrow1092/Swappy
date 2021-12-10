<?php

	session_start();
 
    if(!isset($_SESSION['id'])){
        header('Location: index.html');
        exit;
    }
	include('conBD.php');

	if(isset($_POST["respuesta"])){
		$json = array();
		$estado = "ok";
		if($_POST['respuesta'] == 1){
			$consulta = $connection->prepare("INSERT INTO amigos VALUES (:id_usuario, :id_amigo)");
			$consulta->bindParam("id_usuario", $_SESSION['id'], PDO::PARAM_STR);
			$consulta->bindParam("id_amigo", $_POST['id_amigo'], PDO::PARAM_STR);
			$resultado = $consulta->execute();

			if($resultado){
				$estado = "aceptado";
			} else{
				$estado = "error1";
			}
		}
		array_push($json, array("estado" => $estado));
		$consulta = $connection->prepare("DELETE FROM solicitud_amistad WHERE id_sol = :id_sol");
		$consulta->bindParam("id_sol", $_POST["id_sol"], PDO::PARAM_STR);
		$consulta->execute();
		echo json_encode($json);
	}
?>