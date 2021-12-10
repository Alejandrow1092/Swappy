<?php
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

?>