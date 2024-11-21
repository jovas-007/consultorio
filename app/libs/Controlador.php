<?php  
/**
 * 
 */
class Controlador{
	
	function __construct(){}

	public function modelo($modelo='')
	{
		require_once("../app/modelos/".$modelo.".php");
		return new $modelo();
	}

	public function vista($vista='', $datos=[])
	{
		if (file_exists("../app/vistas/".$vista.".php")) {
			require_once("../app/vistas/".$vista.".php");
		} else {
			die("La vista ".$vista." no existe");
		}
		
	}

	public function mensajeResultado($titulo, $subtitulo, $mensaje, $url, $color)
	{
		if($color=="success"){
			$alertColor = "alert-success";
			$colorBoton = "btn-success";
		} else if($color=="danger"){
			$alertColor = "alert-danger";
			$colorBoton = "btn-danger";
		}
		$datos = [
		"titulo" => $titulo,
		"menu" => false,
		"errores" => [],
		"subtitulo" => $subtitulo,
		"url" => $url,
		"texto" => $mensaje,
		"color" => $alertColor,
		"colorBoton" => $colorBoton,
		"textoBoton" => "Regresar"
		];
		$this->vista("mensajeVista",$datos);
	}

	// public function pagina($pagina=1)
	// {
	// 	if (isset($_GET["p"])) {
	// 		$pagina = $_GET["p"];
	// 	} else {
	// 		$pagina = 1;
	// 	}
	// }
}