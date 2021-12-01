<?php
	
	session_start();
 
    if(!isset($_SESSION['id'])){
        header('Location: index.html');
        exit;
    }
	include('conBD.php');

    $consulta = $connection->prepare("DELETE FROM participantes WHERE codigo_int = :codigo_int and id_usuario = :id_usuario;");
    $consulta->bindParam("id_usuario", $_SESSION['id']);
    $consulta->bindParam("codigo_int", $_POST['codigo_int']);
    $resultado = $consulta->execute();

    if($resultado){        
        array_push($json, array("estado" => "salida exitosa"));
    } else{
        array_push($json, array("estado" => "error al salir"));
    }
    echo json_encode($json);
?>