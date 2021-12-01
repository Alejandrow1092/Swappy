<?php
    
    session_start();
 
    if(!isset($_SESSION['id'])){
        header('Location: index.html');
        exit;
    }

    include("conBD.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/intercambio.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/botones.css">
    <title>Swappy</title>
    <script type="text/javascript" src="js/jQuery.js"></script>
    <script type="text/javascript" src="js/intercambio.js"></script>
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
    <div class="formulario">
    <button id="regresar" name="regresar" class="boton" onclick="location.href = 'home.php'"><img src="./img/back.png" alt="regresar" width="40px" heigth="40px"></button>
        <form action="crearIntercambio.php" method="POST">
            
            <label for="titulo">Título</label>
            <input type="text" name="titulo" id="titulo" required>
            <label for="tema">Temas</label>
            <div id="listaTemas">
                <input type="radio" name="eleccion" id="eleccion1" onclick="seleccionar(1);">
                <input type="text" name="tema[]" id="tema1" placeholder="tema 1" required>
            </div>
            <button type="button" id="agregarTema" name="agregarTema" onclick="agregar();">+</button>
            <label for="monto">Monto</label>
            <input type="number" name="monto" id="monto" required>
            <label for="fecha_int">Fecha de intercambio</label>
            <input type="date" name="fecha_int" id="fecha_int" required>
            <label for="fecha_registro">Fecha límite de registro</label>
            <input type="date" name="fecha_registro" id="fecha_registro" required>
            <label for="comentarios">Comentarios adicionales</label>
            <textarea rows="5" name="comentarios" id="comentarios"></textarea>
            <div>
                <button id="crear" name="crear" class="boton">Crear</button>
            </div>
        </form>
    </div>
</body>
</html>