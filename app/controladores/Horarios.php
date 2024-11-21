<?php  
/**
 * Controlador Horarios
 */
class Horarios extends Controlador
{
  private $modelo;
  private $admon;
	
	function __construct()
	{
	    //Creamos sesion
	    $sesion = new Sesion();
	    if ($sesion->getLogin()) {
		  $this->modelo = $this->modelo("HorariosModelo");
	      $this->admon = $sesion->getAdmon();
	    } else {
	      header("location:".RUTA);
	    }
	}

	public function caratula()
	{
		//Leemos los datos de la tabla
		$data = $this->modelo->getTabla();

		$datos = [
			"titulo" => "Horarios",
			"subtitulo" => "Listado de Horarios",
			"menu" => true,
			"admon" => $this->admon,
			"activo" => "horarios",
			"data" => $data
		];
		$this->vista("horariosCaratulaVista",$datos);
	}

	public function alta(){
	    //Definir los arreglos
	    $data = array();
	    $errores = array();

	    $dias_array = $this->modelo->getLlaves("diaSemana");
	    $duracion_array = $this->modelo->getLlaves("duracion");
	    $doctores_array = $this->modelo->getDoctores();

	    //Recibimos la información de la vista
	    if ($_SERVER['REQUEST_METHOD']=="POST") {
	      //si existe id es una modificación, si no existe es una alta
	      $id = $_POST['id'] ?? "";
	      //
	      $doctor = $_POST['doctor'] ?? "void";
	      $dia = $_POST['diaSemana'] ?? "void";
	      $inicio = $_POST['inicio'] ?? "";
	      $fin = $_POST['fin'] ?? "";
	      $duracion = $_POST['duracion'] ?? "void";
	      //
	      //Validamos la información
	      if($doctor=="void"){
	        array_push($errores,"El nombre del doctor es requerido");
	      }
	      if(Helper::horario($inicio)==false){
	        array_push($errores,"El formato del horario de inicio es erróneo");
	      }
	      if(Helper::horario($fin)==false){
	        array_push($errores,"El formato del horario final es erróneo");
	      }
	      if($dia=="void"){
	        array_push($errores,"El día de la semana es requerido");
	      }
	      if($duracion=="void"){
	        array_push($errores,"La duración de la consulta del doctor es requerida.");
	      }
	      //Crear arreglo de datos
	      $data = [
	        "id" => $id,
	        "doctor"=> $doctor,
	        "dia" => $dia,
	        "inicio" => $inicio,
	        "fin" => $fin,
	        "duracion" => $duracion
	      ];

	      if (empty($errores)) {       
	        //Enviamos al modelo
	        if(trim($id)===""){
	          //Alta
	          if ($this->modelo->alta($data)) {
	            header("location:".RUTA."horarios");
	          }
	        } else {
	          //Modificacion
	          if ($this->modelo->modifica($data)) {
	            header("location:".RUTA."horarios");
	          }
	        }
	      }
   		}

	    //Vista Alta
	    $datos = [
	      "titulo" => "Alta del horario",
	      "subtitulo" => "Alta del horario",
	      "menu" => true,
	      "admon" => $this->admon,
	      "errores" => $errores,
	      "dias" => $dias_array,
	      "duracion" => $duracion_array,
	      "doctores" => $doctores_array,
	      "data" => $data
	    ];

	    $this->vista("horariosAltaVista",$datos);
  	}

	public function baja($id=""){
	    //Leemos los datos del registro del id
	    $data = $this->modelo->getId($id);
	    $dias_array = $this->modelo->getLlaves("diaSemana");
	    $duracion_array = $this->modelo->getLlaves("duracion");
	    $doctores_array = $this->modelo->getDoctores();

	    //Vista baja
	    $datos = [
	      "titulo" => "Baja de un horario",
	      "subtitulo" => "Baja de un horario",
	      "menu" => true,
	      "admon" => $this->admon,
	      "errores" => [],
	      "dias" => $dias_array,
	      "duracion" => $duracion_array,
	      "doctores" => $doctores_array,
	      "data" => $data,
	      "baja" => true
	    ];
	    $this->vista("horariosAltaVista",$datos);
  	}

  	public function bajaLogica($id=''){
	   if (isset($id) && $id!="") {
	     if($this->modelo->bajaLogica($id)){
	      header("location:".RUTA."horarios");
	     }
	   }
	}

	public function cambio($id=""){
	   //Leemos los datos del registro del id
	    $data = $this->modelo->getId($id);
	    $dias_array = $this->modelo->getLlaves("diaSemana");
	    $duracion_array = $this->modelo->getLlaves("duracion");
	    $doctores_array = $this->modelo->getDoctores();

	    //Vista Alta
	    $datos = [
	      "titulo" => "Modificar horarios",
	      "subtitulo" => "Modificar horarios",
	      "menu" => true,
	      "admon" => $this->admon,
	      "errores" => [],
	      "dias" => $dias_array,
	      "duracion" => $duracion_array,
	      "doctores" => $doctores_array,
	      "data" => $data
	    ];
	    $this->vista("horariosAltaVista",$datos);
	}
}