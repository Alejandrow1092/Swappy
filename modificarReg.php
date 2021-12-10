<?php
	session_start();
    include("conBD.php");

    $id;
    if(!isset($_SESSION['id'])){
        if(!isset($_POST['id'])){
            header('Location: index.html');
            exit;
        } else{
            $id = $_POST['id'];
            session_destroy();
        }
    } else{
        $id = $_SESSION['id'];
    }

    $consulta = $connection->prepare("UPDATE participantes SET regalo = :regalo WHERE codigo_int = :codigo_int and id_usuario = :id");
    $consulta->bindParam("codigo_int", $_POST['valorCodigo'], PDO::PARAM_STR);
    $consulta->bindParam("id", $id, PDO::PARAM_STR);
    $consulta->bindParam("regalo", $_POST['valorRegalo'], PDO::PARAM_STR);
    
    if($consulta->execute()){
        header("Location: home.php");
    } else{
    	echo 'error';
    }
    /*include("conBD.php");*/
?>