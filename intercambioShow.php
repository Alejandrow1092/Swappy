<?php
    session_start();
    $id;
    $sesion = false;
    if(!isset($_SESSION['id'])){
        if(!isset($_GET['id'])){
            header('Location: index.html');
            exit;
        } else{
            $id = $_GET['id'];
            session_destroy();
        }
    } else{
        $id = $_SESSION['id'];
        $sesion = true;
    }

    include("conBD.php");
    $codigo;
    if(isset($_POST["btn"])){
        $codigo = $_POST['btn'];
    } else{
        $codigo = $_GET['codigo'];
    }

        $bandera = false;
        $consulta = $connection->prepare("SELECT * from intercambio WHERE codigo_int = :codigo_int");
        $consulta->bindParam("codigo_int", $codigo, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        if($id == $resultado["id_dueno"]):
            $bandera = true;
        endif;
        $titulo = $resultado["titulo"];
        $temas = $resultado["temas"];
        $monto = $resultado["monto"];
        $fecha_int = $resultado["fecha_int"];
        $fecha_registro = $resultado["fecha_registro"];
        $comentarios = $resultado["comentarios"];
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
    <script type="text/javascript" src="js/intercambioShow.js"></script>
</head>
<body <?php if($sesion): ?>onload="obtenerAmigos(<?=$bandera ? 1 : 0?>); obtenerParticipantes(<?=$codigo?>, <?=$bandera ? 1 : 0?>); obtenerInvitados();"<?php endif;?>>
    <header class="header">
        <div class="container">
            <?php if($sesion):?>
            <div class="btn-menu">
                <label for="btn-menu">☰</label>
            </div>
            <?php endif;?>
            <div class="logo">
                <h1>Swappy</h1>
            </div>
        </div>
    </header>
    <!--    --------------->
    <?php if($sesion):?>
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
<?php endif;?>
    <div class="formulario">
    <?php if($sesion):?>
    <button id="regresar" name="regresar" class="boton" onclick="location.href = 'home.php'"><img src="./img/back.png" alt="regresar" width="40px" heigth="40px"></button>
    <?php
            endif;
            if($bandera):
        ?>
        <button class="agregarA" onclick="mostrarCuadro(0);">
            <img src="./img/add.png" alt="+" width="30px" heigth="30px">
        </button>
        <form action="modificarInt.php" method="POST">
        <?php
            endif;
        ?>
            <section id="showInter">
                <label for="titulo"><?=$titulo?></label>
                
                <label for="tema">Temas: <br>
                    <?php
                    $temas = explode(",", $resultado["temas"]);
                        unset($temas[0]);
                        $cont = 0;
                        $consulta2 = $connection->prepare("SELECT * from participantes WHERE codigo_int = :codigo_int and id_usuario = :id");
                        $consulta2->bindParam("codigo_int", $codigo, PDO::PARAM_STR);
                        $consulta2->bindParam("id", $id, PDO::PARAM_STR);
                        $consulta2->execute();
                        $resultado2 = $consulta2->fetch(PDO::FETCH_ASSOC);
                        foreach ($temas as $t):
                    if($bandera):
                    ?>
                    <input type="radio" name="temas" id="<?="radio".$cont?>" onclick="seleccionar(<?=$cont+1?>);" <?=($resultado2["regalo"] == ($cont+1)) ? "checked value='".($cont+1)."'" : ""?>>
                    <input type="text" id="<?="tema".$cont?>" name="tema" value="<?=$t?>" required>
                    <?php
                    
                    else:
                    ?>
                    <input type="radio" name="temas" id="<?="radio".$cont?>" onclick="seleccionarR(<?=$cont+1?>);" <?=($resultado2["regalo"] == ($cont+1)) ? "checked value='".($cont+1)."'" : ""?>>
                    <li><?=$t?></li>
                    <?php
                    endif;
                    $cont++;
                endforeach;
                    ?>
                </label>

                <label for="monto">Monto: <br>
                    <?php
                    if($bandera):
                    ?>
                    <input type="number" id="monto" name="monto" value="<?=$monto?>" required>
                    <?php
                    else:
                    ?>
                    <li><?='$'.$monto?></li>
                    <?php
                    endif;
                    ?>
                </label>
            
                <label for="fecha_int">Fecha de intercambio: <br>
                    <?php
                    if($bandera):
                    ?>
                    <input type="date" id="fecha_int" name="fecha_int" value="<?=$fecha_int?>" required>
                    <?php
                    else:
                    ?>
                    <li><?=$fecha_int?></li>
                    <?php
                    endif;
                    ?>
                </label>
            
                <label for="fecha_registro">Fecha límite de registro: <br>
                    <?php
                    if($bandera):
                    ?>
                    <input type="date" id="fecha_registro" name="fecha_registro" value="<?=$fecha_registro?>" required>
                    <?php
                    else:
                    ?>
                    <li><?=$fecha_registro?></li>
                    <?php
                    endif;
                    ?>
                </label>
                
                <label for="comentarios">Comentarios adicionales: <br>
                    <?php
                    if($bandera):
                    ?>
                    <textarea rows="5" id="comentarios" name="comentarios" required><?=$comentarios?></textarea>
                    <?php
                    else:
                    ?>
                    <p><?=$comentarios?></p>
                    <?php
                    endif;
                    ?>
                </label>

                <label for="codigo_int">Codigo: <br>
                    <input type="text" id="codigo_int" name="codigo_int" value="<?=$codigo?>" readonly>
                </label>
            </section>
            <?php
                if($bandera):
            ?>
                <div class="botoness">
                    <button id="modificar" name="modificar" class="boton">Modificar</button>
                </div>
            </form>
                <div class="botoness">
                    <button id="eliminar" name="eliminar" class="boton" onclick="eliminar(<?=$codigo?>);">Eliminar</button>
                </div>

                <form method="POST" action="iniciarInt.php">
                    <input type="hidden" name="codigoInt" id="codigoInt" value="<?=$codigo?>">
                    <button id="comenzar" name="comenzar" class="boton">
                        <label>Comenzar</label>
                        <img src="./img/exchange.png" alt="Start">
                    </button>
                </form>
                
            <?php
                else:
            ?>
                <form method="POST" action="modificarReg.php">
                    <input type="hidden" name="valorRegalo" id="valorRegalo">
                    <input type="hidden" name="id" id="id" value="<?=$id?>">
                    <input type="hidden" name="valorCodigo" id="valorCodigo" value="<?=$codigo?>">
                    <div id="botoness">
                    <button id="regalo" name="regalo" class="boton">Confirmar regalo</button>
                    </div>
                    
                </form>
                <button id="salir" name="salir" class="boton" onclick="salir(<?=$codigo?>, <?=$id?>);">Salir del intercambio</button>
                
            <?php
                endif;
            ?>
        
    </div>
    <?php if($sesion):?>
    <div class="window-notice" id="window-notice">
        <div class="content">
            <label><span id="participantes">PARTICIPANTES</span></label>
            <div class="content-text">
                
                <ul id="lista_participantes">
                    
                </ul>
            </div>
            
            <label><span>AMIGOS</span></label>
            <div class="content-text">
                
                <ul id="lista_amigos">
                    
                </ul>
            </div>
        
            <label><span>INVITADOS</span></label>
            <div class="content-text">
                
                <ul id="lista_invitados">
                    
                </ul>
            </div>
            <button id="cerrar" class="boton" onclick="mostrarCuadro(1);">Cerrar</button>
        </div>
    </div>
    <?php endif;?>
    <!--<div class="window-notice" id="window-notice">
        <div class="content">
            <div class="content-text">
                <input type="hidden" name="codigo" id="codigo" value="<?=$resultado['codigo']?>">
                <ul id="lista">
                    
                </ul>
            </div>
            <button class="boton" onclick="mostrarCuadro(1);">Cerrar</button>
        </div>
    </div>-->
</body>
</html>
