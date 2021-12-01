<?php
	
	session_start();
 
    if(!isset($_SESSION['id'])){
        header('Location: index.html');
        exit;
    }
	include('conBD.php');

    $consulta = $connection->prepare("SELECT B.nombre as nombre, B.apellidos as apellidos FROM ( SELECT id_usuario FROM amigos WHERE id_amigo = :id UNION SELECT id_amigo FROM amigos WHERE id_usuario = :id) A INNER JOIN usuario B USING (id_usuario)");
    $consulta->bindParam("id", $_SESSION['id']);
    $consulta->execute();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/navbar.css">
    <title>Swappy</title>
    <script src="https://kit.fontawesome.com/1e5e5ee2b5.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/home.js"></script>
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
        <ul class="listaNormal">
            <li id="title"><label>Mis amigos</label></li>
            <?php
                while($resultado = $consulta->fetch(PDO::FETCH_ASSOC)):
                    /*$terminado = ($resultado['fecha_fin'] == NULL) ? false : true;*/
                    $nombre = $resultado["nombre"];
                    $apellidos = $resultado["apellidos"];
            ?>
                <li>
                    <label><?=$nombre." ".$apellidos?></label>
                </li>
            <?php
                endwhile;
            ?>
            
        </ul>
    </section>
</body>

</html>