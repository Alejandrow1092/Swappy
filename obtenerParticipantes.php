<?php
	
	session_start();
    include('conBD.php');
 
   $id;
    if(!isset($_SESSION['id'])){
        if(!isset($_POST['id'])){
            header('Location: index.html');
            exit;
        } else{
            $id = $_POST['id_usuario'];
            session_destroy();
        }
    } else{
        $id = $_SESSION['id'];
    }
	

    $consulta = $connection->prepare("SELECT usuario.nombre as nombre, usuario.apellidos as apellidos, usuario.id_usuario as id FROM usuario INNER JOIN participantes ON usuario.id_usuario = participantes.id_usuario WHERE codigo_int = :codigo_int and usuario.id_usuario != :id");
    $consulta->bindParam("codigo_int", $_POST['codigo_int']);
    $consulta->bindParam("id", $id);
    $consulta->execute();

    $json = array();

    while($resultado = $consulta->fetch(PDO::FETCH_ASSOC)){
    	array_push($json, array("nombre" => $resultado["nombre"], "apellidos" => $resultado["apellidos"], "id" => $resultado["id"]));
    }

    echo json_encode($json);
?>