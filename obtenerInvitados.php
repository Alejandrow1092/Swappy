<?php
	
	session_start();
 
    if(!isset($_SESSION['id'])){
        header('Location: index.html');
        exit;
    }
	include('conBD.php');

    $consulta = $connection->prepare("SELECT usuario.nombre as nombre, usuario.apellidos as apellidos, usuario.id_usuario as id FROM usuario INNER JOIN solicitud_int ON usuario.id_usuario = solicitud_int.id_usuario_dest WHERE codigo_int = :codigo_int");
    $consulta->bindParam("codigo_int", $_POST['codigo_int']);
    $consulta->execute();

    $json = array();

    while($resultado = $consulta->fetch(PDO::FETCH_ASSOC)){
    	array_push($json, array("nombre" => $resultado["nombre"], "apellidos" => $resultado["apellidos"], "id" => $resultado["id"]));
    }

    echo json_encode($json);
?>