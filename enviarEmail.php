<?php
	//if (isset($_POST['send'])){
		include("sendemail.php");//Mando a llamar la funcion que se encarga de enviar el correo electronico
		
		/*Configuracion de variables para enviar el correo*/
		$mail_username="swappy.intercambio@gmail.com";//Correo electronico saliente ejemplo: tucorreo@gmail.com
		$mail_userpassword="swappypass";//Tu contraseña de gmail
		$mail_addAddress="sealcaseescuela@gmail.com";//correo electronico que recibira el mensaje
		$template="index.html";//Ruta de la plantilla HTML para enviar nuestro mensaje
		
		/*Inicio captura de datos enviados por $_POST para enviar el correo */
		$mail_setFromEmail="holasetfromemail";//$_POST['customer_email'];
		$mail_setFromName="holasetfromname";//$_POST['customer_name'];
		$txt_message="holamensaje";//$_POST['message'];
		$mail_subject="holaasunto";//$_POST['subject'];
		
		sendemail($mail_username,$mail_userpassword,$mail_setFromEmail,$mail_setFromName,$mail_addAddress,$txt_message,$mail_subject,$template);//Enviar el mensaje
		header("Location: index.php");
	//}
?>