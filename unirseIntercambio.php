<?php

	session_start();
 
    if(!isset($_SESSION['id'])){
        header('Location: index.html');
        exit;
    }
	include('conBD.php');

	if(isset($_POST["codigo"])){
		$consulta = $connection->prepare("INSERT INTO participantes VALUES (:codigo_int, :id_usuario)");
		$consulta->bindParam("codigo_int", $_POST['codigo'], PDO::PARAM_STR);
		$consulta->bindParam("id_usuario", $_SESSION['id'], PDO::PARAM_STR);
		$resultado = $consulta->execute();

		$json = array();

		if($resultado){
			array_push($json, array("estado" => "integración exitosa"));
		} else{
			array_push($json, array("estado" => "error al unirse"));
		}
		echo json_encode($json);
	}

?>