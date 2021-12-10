<?php
    
    session_start();
 
    if(!isset($_SESSION['id'])){
        header('Location: index.html');
        exit;
    }

    include("conBD.php");
    include("sendemail.php");

    class usuario{
        public $correo;
        public $id;
        public $nombre;
        public $apellidos;
        public $genero;
        public $regalo;

        public function __construct($id_usuario, $correoe, $nom, $app, $gen, $reg){
            $this->correo = $correoe;
            $this->id = $id_usuario;
            $this->nombre = $nom;
            $this->apellidos = $app;
            $this->genero = $gen;
            $this->regalo = $reg;
        }

    }

    $consulta = $connection->prepare("SELECT * from intercambio WHERE codigo_int = :codigo_int");
    $consulta->bindParam("codigo_int", $_POST['btn'], PDO::PARAM_STR);
    $consulta->execute();
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    $titulo = $resultado["titulo"];
    $monto = $resultado["monto"];
    $comentarios = $resultado["comentarios"];

    $temas = explode(",", $resultado["temas"]);
    unset($temas[0]);

    $consulta = $connection->prepare("SELECT id_usuario_destino from sorteo_int Where codigo_int = :codigo_int and id_usuario = :id");
    $consulta->bindParam("id", $_SESSION['id']);
    $consulta->bindParam("codigo_int", $_POST['btn']);
    $consulta->execute();
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

    $consulta = $connection->prepare("SELECT usuario.correo_e as correo, usuario.nombre as nombre, usuario.apellidos as apellidos, usuario.genero as genero, participantes.id_usuario as id_usuario, participantes.regalo as regalo from participantes inner join usuario on participantes.id_usuario = usuario.id_usuario WHERE participantes.codigo_int = :codigo_int and participantes.id_usuario = :id");
    $consulta->bindParam("codigo_int", $_POST['btn'], PDO::PARAM_STR);
    $consulta->bindParam("id", $resultado['id_usuario_destino']);
    $consulta->execute();
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    $usuario = new usuario($resultado["id_usuario"], $resultado["correo"], $resultado["nombre"], $resultado["apellidos"], $resultado["genero"], $resultado["regalo"]);
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

    <h1><?=$titulo?></h1>
    <p>Te toco a <?=$usuario->nombre." ".$usuario->apellidos?></p>
    <p>Genero: <?=$usuario->genero?></p>
    <p>Prefiere de regalo: <?=($usuario->regalo == "") ? $usuario->nombre." no indicó qué regalo prefiere" : $usuario->regalo?></p>
    <p>El monto máximo es de $<?=$monto?></p>
    <p>Comentarios adicionales: <?=$comentarios?></p>
</body>
</html>