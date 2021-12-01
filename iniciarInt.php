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
    $consulta->bindParam("codigo_int", $_POST['codigoInt'], PDO::PARAM_STR);
    $consulta->execute();
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    $titulo = $resultado["titulo"];
    $monto = $resultado["monto"];
    $comentarios = $resultado["comentarios"];

    $temas = explode(",", $resultado["temas"]);
    unset($temas[0]);

	$consulta = $connection->prepare("SELECT usuario.correo_e as correo, usuario.nombre as nombre, usuario.apellidos as apellidos, usuario.genero as genero, participantes.id_usuario as id_usuario, participantes.regalo as regalo from participantes inner join usuario on participantes.id_usuario = usuario.id_usuario WHERE participantes.codigo_int = :codigo_int");
    $consulta->bindParam("codigo_int", $_POST['codigoInt'], PDO::PARAM_STR);
    $consulta->execute();
    $lista_participantes = array();
    $lista_ids = array();
    $lista_ids_mezclada = array();

    while($resultado = $consulta->fetch(PDO::FETCH_ASSOC)){
        $usuario = new usuario($resultado["id_usuario"], $resultado["correo"], $resultado["nombre"], $resultado["apellidos"], $resultado["genero"], $resultado["regalo"]);

        array_push($lista_participantes, $usuario);
        array_push($lista_ids, $resultado["id_usuario"]);
        array_push($lista_ids_mezclada, $resultado["id_usuario"]);
    }

    

    $cont = 0;
    shuffle($lista_ids_mezclada);
     while($cont < count($lista_ids_mezclada)){
        foreach($lista_ids as $id){
            if($id == $lista_ids_mezclada[$cont]){
                $cont = 0;
                shuffle($lista_ids_mezclada);
            } else{
                $cont++;
            }
        }
    }

    $mail_username="swappy.intercambio@gmail.com";
    $mail_userpassword="swappypass";
    $mail_setFromEmail="Swappy";//$_POST['customer_email'];
    $mail_setFromName="Intercambios";//

    foreach ($lista_ids as $id) {
        $consulta = $connection->prepare("INSERT INTO sorteo_int VALUES (:codigo_int, :id, :id_dest)");
        $consulta->bindParam("codigo_int", $_POST['codigoInt'], PDO::PARAM_STR);
        $consulta->bindParam("id", $id, PDO::PARAM_STR);
        $consulta->bindParam("id_dest", $lista_ids_mezclada[($id-1)], PDO::PARAM_STR);
        $consulta->execute();
    }
    $cont = 0;
    foreach ($lista_participantes as $participante) {

        $mail_addAddress = $participante->correo;//correo
        $txt_message = "Te toco a: ".$lista_participantes[$lista_ids_mezclada[$cont]-1]->nombre." ".$lista_participantes[$lista_ids_mezclada[$cont]-1]->apellidos."\nGenero: ".$lista_participantes[$lista_ids_mezclada[$cont]-1]->genero."\nPrefiere: ".$temas[$lista_participantes[$lista_ids_mezclada[$cont]-1]->regalo]."\nMonto máximo: ".$monto."\nComentarios: ".$comentarios;//$_POST['message'];
        $mail_subject = "Intercambio ".$titulo;//$_POST['subject'];
        sendemail($mail_username,$mail_userpassword,$mail_setFromEmail,$mail_setFromName,$mail_addAddress,$txt_message,$mail_subject);
        $cont++;
    }



   $consulta = $connection->prepare("DELETE FROM intercambio WHERE codigo_int = :codigo_int");
    $consulta->bindParam("codigo_int", $_POST['codigoInt'], PDO::PARAM_STR);
    $resultado = $consulta->execute();
    if($resultado){
        $consulta = $connection->prepare("DELETE FROM participantes WHERE codigo_int = :codigo_int");
        $consulta->bindParam("codigo_int", $_POST['codigoInt'], PDO::PARAM_STR);
        $resultado = $consulta->execute();
        if($resultado){
            $consulta = $connection->prepare("DELETE FROM solicitud_int WHERE codigo_int = :codigo_int");
            $consulta->bindParam("codigo_int", $_POST['codigoInt'], PDO::PARAM_STR);
            $resultado = $consulta->execute();
            if($resultado){
                $consulta = $connection->prepare("DELETE FROM sorteo_int WHERE codigo_int = :codigo_int");
            $consulta->bindParam("codigo_int", $_POST['codigoInt'], PDO::PARAM_STR);
            $resultado = $consulta->execute();
            header("Location: home.php");
            } else{
                $mensaje = "error solicitud";
            }
        } else{
            $mensaje = "error participantes";
        }
    } else{
        $mensaje = "error intercambio";
    }
    

    
    //$template="index.html";//Ruta de la plantilla HTML para enviar nuestro mensaje
    
    /*Inicio captura de datos enviados por $_POST para enviar el correo */
    /*$mail_setFromEmail="holasetfromemail";//$_POST['customer_email'];
    $mail_setFromName="holasetfromname";//$_POST['customer_name'];
    $txt_message="holamensaje";//$_POST['message'];
    $mail_subject="holaasunto";//$_POST['subject'];
    
    sendemail($mail_username,$mail_userpassword,$mail_setFromEmail,$mail_setFromName,$mail_addAddress,$txt_message,$mail_subject,$template);//Enviar el mensaje
    header("Location: index.php");*/





?>