<?php
    
    session_start();
 
    if(!isset($_SESSION['id'])){
        header('Location: index.html');
        exit;
    }

    include("conBD.php");

    $consulta = $connection->prepare("SELECT solicitud_amistad.id_sol as id_sol, solicitud_amistad.id_amigo as id_amigo, usuario.nombre as nombre, usuario.apellidos as apellidos from usuario INNER JOIN solicitud_amistad ON usuario.id_usuario = solicitud_amistad.id_amigo WHERE solicitud_amistad.id_usuario_dest = :id");
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
    <link rel="stylesheet" href="css/botones.css">
    <title>Swappy</title>
    <script src="https://kit.fontawesome.com/1e5e5ee2b5.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/jQuery.js"></script>
    <script type="text/javascript" src="js/invitaciones.js"></script>
    <script type="text/javascript" src="js/home.js"></script>
</head>
<body>
    <!--  Desde aquí  --------------->
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

    <!--  Hasta aca aquí  --------------->

    <section id="intercambios">
        <ul class="listaNormal">
            <li id="title"><label>Mis invitaciones</label></li>
            <?php
                while($resultado = $consulta->fetch(PDO::FETCH_ASSOC)):
                    /*$terminado = ($resultado['fecha_fin'] == NULL) ? false : true;*/
                    $nombre = $resultado["nombre"];
                    $app = $resultado["apellidos"];
                    $id_sol = $resultado["id_sol"];
                    $id_amigo = $resultado["id_amigo"];
            ?>
                <li class="invitaciones" id="<?='A'.$id_sol?>">
                   <label><?=$nombre." ".$app?></label>
                   <div>
                    <button onclick="responderA(<?=$id_sol?>, <?=$id_amigo?>, 1)"><img src="./img/check.png" alt="A" width="30px" height="30px"></button>
                    <button onclick="responderA(<?=$id_sol?>, <?=$id_amigo?>, 0)"><img src="./img/cross.png" alt="R" width="30px" height="30px"></button>
                   </div>
                   
                </li>
            <?php
                endwhile;

                $consulta = $connection->prepare("SELECT solicitud_int.id_sol as id_sol, intercambio.titulo as titulo, intercambio.codigo_int as codigo_int from intercambio INNER JOIN solicitud_int ON intercambio.codigo_int = solicitud_int.codigo_int WHERE solicitud_int.id_usuario_dest = :id");
                $consulta->bindParam("id", $_SESSION['id']);
                $consulta->execute();
            while($resultado = $consulta->fetch(PDO::FETCH_ASSOC)):
                    /*$terminado = ($resultado['fecha_fin'] == NULL) ? false : true;*/
                    $id_sol = $resultado["id_sol"];
                    $titulo = $resultado["titulo"];
                    $codigo_int = $resultado["codigo_int"];
            ?>

                    <li class="invitaciones" id="<?='I'.$id_sol?>">
                       <label><?=$titulo?></label>
                       <div>
                        <button onclick="responderI(<?=$id_sol?>, <?=$codigo_int?>, 1)"><img src="./img/check.png" alt="A" width="30px" height="30px"></button>
                        <button onclick="responderI(<?=$id_sol?>, <?=$codigo_int?>, 0)"><img src="./img/cross.png" alt="R" width="30px" height="30px"></button>
                       </div>
                    </li>
            <?php
                endwhile;
            ?>
        </ul>
    </section>
    

    <div class="window-notice" id="invitarAmigo">
        <div class="content">
            <div class="content-text"><input type="email" name="correo" id="correo" placeholder="Correo electrónico" required>
                <input type="text" name="estado" id="estado" disabled>
            </div>
            <button class="boton" onclick="invitar();">Invitar</button>
            <button class="boton" onclick="mostrarCuadro(1, 1);">cerrar</button>
        </div>
    </div>

    <div class="window-notice" id="agregarCodigo">
        <div class="content">
            <div class="content-text">Este sitio utiliza cookies para obtener la mejor experiencia en nuestra web. 
            </div>
            <button class="boton" onclick="unirse();">Cerrar</button>
            <button class="boton" onclick="mostrarCuadro(1, 2);">Cerrar</button>
        </div>
    </div>
</body>

</html>