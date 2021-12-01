<?php
	session_start();
 
    if(!isset($_SESSION['id'])){
        header('Location: index.html');
        exit;
    }

    include("conBD.php");

    $json = array();
    $mensaje = "";

	$consulta = $connection->prepare("DELETE FROM intercambio WHERE codigo_int = :codigo_int");
    $consulta->bindParam("codigo_int", $_POST['codigo_int'], PDO::PARAM_STR);
    $resultado = $consulta->execute();
    if($resultado){
        $consulta = $connection->prepare("DELETE FROM participantes WHERE codigo_int = :codigo_int");
        $consulta->bindParam("codigo_int", $_POST['codigo_int'], PDO::PARAM_STR);
        $resultado = $consulta->execute();
        if($resultado){
            $consulta = $connection->prepare("DELETE FROM solicitud_int WHERE codigo_int = :codigo_int");
            $consulta->bindParam("codigo_int", $_POST['codigo_int'], PDO::PARAM_STR);
            $resultado = $consulta->execute();
            if($resultado){
                $mensaje = "ok";
            } else{
                $mensaje = "error solicitud";
            }
        } else{
            $mensaje = "error participantes";
        }
    } else{
        $mensaje = "error intercambio";
    }

    array_push($json, array("mensaje" => $mensaje));
    echo json_encode($json);
?>