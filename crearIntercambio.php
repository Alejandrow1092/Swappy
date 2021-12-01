<?php
	session_start();
 
    if(!isset($_SESSION['id'])){
        header('Location: index.html');
        exit;
    }

    include("conBD.php");

	$consulta = $connection->prepare("INSERT INTO intercambio (id_dueno, titulo, temas, monto, fecha_int, fecha_registro, comentarios) VALUES (:id,:titulo,:tema, :monto, :fecha_int, :fecha_registro, :comentarios)");
    $consulta->bindParam("id", $_SESSION['id'], PDO::PARAM_STR);
    $consulta->bindParam("titulo", $_POST['titulo'], PDO::PARAM_STR);
    $tema = "";
    foreach ($_POST['tema'] as $t) {
        $tema = $tema.",".$t;
    }
    $consulta->bindParam("tema", $tema, PDO::PARAM_STR);
    $consulta->bindParam("monto", $_POST['monto'], PDO::PARAM_STR);
    $consulta->bindParam("fecha_int", $_POST['fecha_int'], PDO::PARAM_STR);
    $consulta->bindParam("fecha_registro", $_POST['fecha_registro'], PDO::PARAM_STR);
    $consulta->bindParam("comentarios", $_POST['comentarios'], PDO::PARAM_STR);
    $resultado = $consulta->execute();
    if($resultado){
    	 $consulta = $connection->prepare("SELECT LAST_INSERT_ID() as codigo");
    	 $consulta->execute();
    	 $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
         $codigo = $resultado['codigo'];
    	$consulta = $connection->prepare("INSERT INTO participantes VALUES (:codigo_int, :id_usuario, :tema)");
    	$consulta->bindParam("codigo_int", $codigo, PDO::PARAM_STR);
    	$consulta->bindParam("id_usuario", $_SESSION['id'], PDO::PARAM_STR);
        $consulta->bindParam("tema", $_POST['eleccion'], PDO::PARAM_STR);
    	 $resultado = $consulta->execute();
    	 if(!$resultado){
            echo 'error2';
    	 } 
    } else{
    	echo 'error';
    }

    $consulta = $connection->prepare("SELECT B.nombre as nombre, B.apellidos as apellidos, B.id_usuario as id FROM ( SELECT id_usuario FROM amigos WHERE id_amigo = :id UNION SELECT id_amigo FROM amigos WHERE id_usuario = :id) A INNER JOIN usuario B USING (id_usuario)");
    $consulta->bindParam("id", $_SESSION['id']);
    $consulta->execute();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" type="text/css" href="css/botones.css">
    <title>Swappy</title>
    <script src="https://kit.fontawesome.com/1e5e5ee2b5.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/crearIntercambio.js"></script>
    <script type="text/javascript" src="js/JQuery.js"></script>
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="btn-menu">
                <label for="btn-menu">☰</label>
            </div>
            <div class="logo">
                <h1>Swappy</h1>
            </div>
        </div>
    </header>
    <!--    --------------->
    <input type="checkbox" id="btn-menu">
    <div class="container-menu">
        <div class="cont-menu">
            <nav>
            <ul id="desplegable">
                    <li> 
                        <img src="./img/perfil.png" alt="----" width="80px">
                        <a href="home.php"><?=$_SESSION['nombre']?></a>
                    </li>
                    <li>
                        <img src="./img/amigos.jpg" alt="----"> 
                        <a href="amigos.php">Amigos</a>
                    </li>
                    <li>
                        <img src="./img/friend.jpg" alt="----">
                        <a href="invitaciones.php">Invitaciones</a>
                    </li>
                    <li>
                        <img src="./img/logout.png" alt="----">
                        <a href="logout.php">Salir</a>
                    </li>
                </ul>
            </nav>
            <label for="btn-menu">✖️</label>
        </div>
    </div>

    <section id="intercambios">
        <input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>">
        <ul>
            <li id="title"><label>Enviar invitaciones</label></li>
            <?php
                while($resultado = $consulta->fetch(PDO::FETCH_ASSOC)):
                    /*$terminado = ($resultado['fecha_fin'] == NULL) ? false : true;*/
                    $nombre = $resultado["nombre"];
                    $apellidos = $resultado["apellidos"];
                    $id = $resultado["id"];
            ?>
                <div class="content-text">
                <li id="<?="A".$id?>">
                    <label><?=$nombre." ".$apellidos?></label>
                    <button onclick="invitarInt(<?=$id?>)">Invitar</button>
                </li>
                </div>
            <?php
                endwhile;
            ?>
           
        </ul>
    </section>
    <button id="guardar" name="guardar" class="boton" onclick="location.href='home.php'">Guardar</button>
</body>
</html>