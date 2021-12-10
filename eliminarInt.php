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
        $consulta = $connection->prepare("SELECT usuario.id_usuario as id from usuario inner join participantes on usuario.id_usuario = participantes.id_usuario where usuario.contrasena is null and codigo_int = :codigo_int");
         $consulta->bindParam("codigo_int", $_POST['codigo_int']);
        $consulta->execute();

        while($resultado = $consulta->fetch(PDO::FETCH_ASSOC)){
             $consulta = $connection->prepare("DELETE FROM usuario WHERE id_usuario = :id");
             $consulta->bindParam("id", $resultado['id'], PDO::PARAM_STR);
            $consulta->execute();             
        }

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