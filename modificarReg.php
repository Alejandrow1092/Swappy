<?php
	session_start();
 
    if(!isset($_SESSION['id'])){
        header('Location: index.html');
        exit;
    }

    include("conBD.php");

    $consulta = $connection->prepare("UPDATE participantes SET regalo = :regalo WHERE codigo_int = :codigo_int and id_usuario = :id");
    $consulta->bindParam("codigo_int", $_POST['valorCodigo'], PDO::PARAM_STR);
    $consulta->bindParam("id", $_SESSION['id'], PDO::PARAM_STR);
    $consulta->bindParam("regalo", $_POST['valorRegalo'], PDO::PARAM_STR);
    if($consulta->execute()){
        header("Location: home.php");
    } else{
    	echo 'error';
    }
    /*include("conBD.php");*/

?>