<?php
	session_start();
 
    if(!isset($_SESSION['id'])){
        header('Location: index.html');
        exit;
    }

    include("conBD.php");

	$consulta = $connection->prepare("UPDATE intercambio SET temas = :tema, monto = :monto, fecha_int = :fecha_int, fecha_registro = :fecha_registro, comentarios = :comentarios WHERE codigo_int = :codigo_int");
    $consulta->bindParam("tema", $_POST['temas'], PDO::PARAM_STR);
    $consulta->bindParam("monto", $_POST['monto'], PDO::PARAM_STR);
    $consulta->bindParam("fecha_int", $_POST['fecha_int'], PDO::PARAM_STR);
    $consulta->bindParam("fecha_registro", $_POST['fecha_registro'], PDO::PARAM_STR);
    $consulta->bindParam("comentarios", $_POST['comentarios'], PDO::PARAM_STR);
    $consulta->bindParam("codigo_int", $_POST['codigo_int'], PDO::PARAM_STR);

    $consulta = $connection->prepare("UPDATE participantes SET regalo = :regalo WHERE codigo_int = :codigo_int and id_usuario = :id");
    $consulta->bindParam("codigo_int", $_POST['codigo_int'], PDO::PARAM_STR);
    $consulta->bindParam("id", $_SESSION['id'], PDO::PARAM_STR);
    $consulta->bindParam("regalo", $_POST['temas'], PDO::PARAM_STR);
    if($consulta->execute()){
        header("Location: home.php");
    } else{
    	echo 'error';
    }
    /*include("conBD.php");*/

?>