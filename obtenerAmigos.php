<?php
	
	session_start();
 
    if(!isset($_SESSION['id'])){
        header('Location: index.html');
        exit;
    }
	include('conBD.php');

    $consulta = $connection->prepare("SELECT B.nombre as nombre, B.apellidos as apellidos, B.id_usuario as id FROM ( SELECT id_usuario FROM amigos WHERE id_amigo = :id UNION SELECT id_amigo FROM amigos WHERE id_usuario = :id) A INNER JOIN usuario B USING (id_usuario)");
    $consulta->bindParam("id", $_SESSION['id']);
    $consulta->execute();

    $json = array();

    while($resultado = $consulta->fetch(PDO::FETCH_ASSOC)){
    	array_push($json, array("nombre" => $resultado["nombre"], "apellidos" => $resultado["apellidos"], "id" => $resultado["id"]));
    }

    echo json_encode($json);
?>