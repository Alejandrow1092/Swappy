<?php
define('USER', 'root');
define('PASSWORD', '');
define('HOST', '127.0.0.1');
define('DATABASE', 'swappy');
try{
	$connection = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USER, PASSWORD, array(PDO::ATTR_PERSISTENT => true));
} catch(PDOException $exc){
	$connection = null;
	exit($exc -> getMessage());
}
?>
