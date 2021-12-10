<?php
	session_start();
 
    if(!isset($_SESSION['id'])){
        header('Location: index.html');
        exit;
    }
	include('conBD.php');

	if(isset($_POST["codigo"])){
			$consulta = $connection->prepare("DELETE FROM participantes WHERE codigo_int = :codigo_int and id_usuario = :id");
			$consulta->bindParam("id", $_POST['id_usuario'], PDO::PARAM_STR);
			$consulta->bindParam("codigo_int", $_POST['codigo'], PDO::PARAM_STR);
			$resultado = $consulta->execute();

			$json = array();

			if($resultado){
				
				array_push($json, array("estado" => "eliminado"));
			} else{
				array_push($json, array("estado" => "error al eliminar"));
			}
			echo json_encode($json);
		
	}
?>