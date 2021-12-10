<?php
	
	session_start();
    include('conBD.php');
    $id;
    if(!isset($_SESSION['id'])){
        if(!isset($_POST['id_usuario'])){
            header('Location: index.html');
            exit;
        } else{
            $id = $_POST['id_usuario'];
            session_destroy();
            $consulta = $connection->prepare("DELETE FROM participantes WHERE codigo_int = :codigo_int and id_usuario = :id_usuario;");
            $consulta->bindParam("id_usuario", $id);
            $consulta->bindParam("codigo_int", $_POST['codigo_int']);
            $consulta->execute();
            $consulta = $connection->prepare("DELETE FROM usuario WHERE id_usuario = :id_usuario;");
            $consulta->bindParam("id_usuario", $id);
            $resultado = $consulta->execute();
        }
    } else{
        $id = $_SESSION['id'];
         $consulta = $connection->prepare("DELETE FROM participantes WHERE codigo_int = :codigo_int and id_usuario = :id_usuario;");
        $consulta->bindParam("id_usuario", $id);
        $consulta->bindParam("codigo_int", $_POST['codigo_int']);
        $resultado = $consulta->execute();
    }
	
    $json = array();
    if($resultado){        
        array_push($json, array("estado" => "salida exitosa"));
    } else{
        array_push($json, array("estado" => "error al salir"));
    }
    echo json_encode($json);
?>