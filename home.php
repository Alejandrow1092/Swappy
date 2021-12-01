<?php
    
    session_start();
 
    if(!isset($_SESSION['id'])){
        header('Location: index.html');
        exit;
    }

    include("conBD.php");

    $consulta = $connection->prepare("SELECT intercambio.codigo_int as codigo_int, intercambio.titulo as titulo FROM intercambio INNER JOIN participantes ON intercambio.codigo_int = participantes.codigo_int WHERE participantes.id_usuario = :id");
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
    <script type="text/javascript" src="js/home.js"></script>
    <script type="text/javascript" src="js/jQuery.js"></script>
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
        <ul>
            <li id="title"><label>Mis intercambios</label></li>
            <?php
                while($resultado = $consulta->fetch(PDO::FETCH_ASSOC)):
                    /*$terminado = ($resultado['fecha_fin'] == NULL) ? false : true;*/
                    $titulo = $resultado["titulo"];
                    $codigo_int = $resultado["codigo_int"];
            ?>
                <li>
                    <form method="POST" action="intercambioShow.php">
                        <button class="bt-list" name="btn" value="<?=$codigo_int?>"> <?=$titulo?></button>
                    </form>
                </li>
            <?php
                endwhile;
            ?>
        </ul>
    </section>
    <button class="btn-flotante" id="agregarAmigos" onclick="mostrarCuadro(0, 1)">Agregar amigo</button>

    <button class="btn-flotante" id="unirseIntercambio" onclick="mostrarCuadro(0, 2)">Unirse a intercambio</button>

    <button class="btn-flotante" id="crearIntercambio" onclick="location.href='intercambio.php'">Crear intercambio</button>

    <button class="btn-flotante" id="opciones" onclick="mostrar();">+</button>

    <div class="window-notice" id="invitarAmigo">
        <div class="content">
            <div class="content-text">
                <input type="email" name="correo" id="correo" placeholder="Correo electrónico" required>
                <input type="text" name="estado" id="estado" disabled>
            </div>
            <section id="btn-duo">
                <button class="boton" onclick="invitar();">Invitar</button>
                <button class="boton" onclick="mostrarCuadro(1, 1);">Cerrar</button>
            </section>
            
        </div>
    </div>

    <div class="window-notice" id="agregarCodigo">
        <div class="content">
            <div class="content-text">
                <input type="number" name="codigo" id="codigo" placeholder="Código de intercambio" required>
                <input type="text" name="resultado" id="resultado" disabled>
            </div>
            <section>
                <button class="boton" onclick="unirse();">Unirse</button>
                <button class="boton" onclick="mostrarCuadro(1, 2);">Cerrar</button>
            </section>
            
        </div>
    </div>
</body>
</html>