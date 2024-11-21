<?php  
/**
 * Controlador doctores
 */
class Doctores extends Controlador
{
  private $modelo;
  private $admon;
	
	function __construct()
	{
	    //Creamos sesion
	    $sesion = new Sesion();
	    if ($sesion->getLogin()) {
		  $this->modelo = $this->modelo("DoctoresModelo");
	      $this->admon = $sesion->getAdmon();
	    } else {
	      header("location:".RUTA);
	    }
	}

	public function caratula($pagina=1)
	{
		//Leemos los datos de la tabla
		$data = $this->modelo->getDoctores();

		$datos = [
			"titulo" => "Doctores",
			"subtitulo" => "Listado de doctores",
			"menu" => true,
			"admon" =>  $this->admon,
			"activo" => "doctores",
			"data" => $data
		];
		$this->vista("doctoresCaratulaVista",$datos);
	}

	public function alta(){
	    //Definir los arreglos
	    $data = array();
	    $errores = array();

	    if ($_SERVER['REQUEST_METHOD']=="POST") {
	      //si existe id es una modificación, si no existe es una alta
	      $id = $_POST['id'] ?? "";
	      //
	      $nombre = Helper::cadena($_POST['nombre'] ?? "");
	      $apellidos = Helper::cadena($_POST['apellidos'] ?? "");
	      $correo = Helper::cadena($_POST['correo'] ?? "");
	      $direccion = Helper::cadena($_POST['direccion'] ?? "");
	      $telefono = Helper::cadena($_POST['telefono'] ?? "0");
	      //$depto = Helper::cadena($_POST['depto'] ?? "");
	      $perfil = Helper::cadena($_POST['perfil'] ?? "");

	      //Validamos la información
	      if(empty($nombre)){
	        array_push($errores,"El nombre del doctor es requerido");
	      }
	      if(empty($apellidos)){
	        array_push($errores,"Los apellidos del doctor son requeridos");
	      }
	      if(empty($correo)){
	        array_push($errores,"El correo del doctor es requerido.");
	      }
	      if(empty($telefono)){
	        array_push($errores,"El teléfono del doctor es requerido.");
	      }
	      // if(empty($depto)){
	      //   array_push($errores,"El departamento del doctor es requerido.");
	      // }
	      if(empty($perfil)){
	        array_push($errores,"El perfil del doctor es requerido.");
	      }
	      //Crear arreglo de datos
	      $data = [
	        "id" => $id,
	        "foto"=> "",
	        "nombre" => $nombre,
	        "apellidos" => $apellidos,
	        "correo" => $correo,
	        "direccion" => $direccion,
	        "telefono" => $telefono,
	        //"depto" => $depto,
	        "perfil" => $perfil
	      ];

	      if (empty($errores)) {       
	        //Enviamos al modelo
	        if(trim($id)===""){
	          //Alta
	          if ($this->modelo->altaDoctor($data)) {
	            header("location:".RUTA."doctores");
	          }
	        } else {
	          //Modificacion
	          if ($this->modelo->modificaDoctor($data)) {
	            header("location:".RUTA."doctores");
	          }
	        } 
	      }
	  	}

	    //Vista Alta
	    $datos = [
	      "titulo" => "Alta del doctor",
	      "subtitulo" => "Alta del doctor",
	      "menu" => true,
	      "admon" =>  $this->admon,
	      "activo" => 'doctores',
	      "errores" => $errores,
	      "data" => $data
	    ];

	    $this->vista("doctoresAltaVista",$datos);
	}

	public function baja($id=""){
	    //Leemos los datos del registro del id
	    $data = $this->modelo->getDoctorId($id);
	    $numCitas = $this->modelo->getNumCitasDoctores($id);
	    $numHorarios = $this->modelo->getNumHorariosDoctores($id);
	    $numCitas = $numCitas["count(*)"];
	    $numHorarios = $numHorarios["count(*)"];

	    //Vista baja
	    $datos = [
	      "titulo" => "Baja de un doctor",
	      "subtitulo" => "Baja de un doctor",
	      "menu" => true,
	      "admon" =>  $this->admon,
	      "numCitas" => $numCitas,
	      "numHorarios" => $numHorarios,
	      "errores" => [],
	      "activo" => 'doctores',
	      "data" => $data,
	      "baja" => true
	    ];
	    $this->vista("doctoresAltaVista",$datos);
	  }

  	public function bajaLogica($id=''){
	   if (isset($id)) {
	     if($this->modelo->bajaLogica($id)){
	      header("location:".RUTA."doctores");
	     }
	   }
	}

	public function cambio($id=""){
	    //Leemos los datos del registro del id
	    $data = $this->modelo->getDoctorId($id);

	    //Vista Alta
	    $datos = [
	      "titulo" => "Modificar doctores",
	      "subtitulo" => "Modificar doctores",
	      "menu" => true,
	      "admon" =>  $this->admon,
	      "activo" => 'doctores',
	      "errores" => [],
	      "data" => $data
	    ];
	    $this->vista("doctoresAltaVista",$datos);
	}
}