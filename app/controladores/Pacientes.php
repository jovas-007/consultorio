<?php  
/**
 * Controlador pacientes
 */
class Pacientes extends Controlador
{
  private $modelo;
  private $admon;
	
	function __construct()
	{
	    //Creamos sesion
	    $sesion = new Sesion();
	    if ($sesion->getLogin()) {
		  $this->modelo = $this->modelo("PacientesModelo");
	      $this->admon = $sesion->getAdmon();
	    } else {
	      header("location:".RUTA);
	    }
	}


	public function caratula($pagina=1)
	{
		//Leemos los datos de la tabla
		$num = $this->modelo->getNumPacientes();
		$inicio = ($pagina-1)*TAMANO_PAGINA;
		$totalPaginas = ceil($num/TAMANO_PAGINA);
		$data = $this->modelo->getPacientes($inicio,TAMANO_PAGINA);

		$datos = [
			"titulo" => "Pacientes",
			"subtitulo" => "Listado de pacientes",
			"menu" => true,
			"admon" => $this->admon,
			"activo" => "pacientes",
			"pag" => [
				"totalPaginas" => $totalPaginas,
				"regresa" => "pacientes",
				"pagina" => $pagina
			],
			"data" => $data
		];
		$this->vista("pacientesCaratulaVista",$datos);
	}

	public function alta(){
	   //Definir los arreglos
	    $data = array();
	    $errores = array();

	    //Leemos la llaves de tipoSangre
	    $grupoSanguineo_array = $this->modelo->getLlaves("grupoSangre");

	    //Leemos la llaves de genero
	    $genero_array = $this->modelo->getLlaves("genero");

	    //Leemos la llaves de edoCivil
	    $edoCivil_array = $this->modelo->getLlaves("edoCivil");

	    //Recibimos la información de la vista
	    if ($_SERVER['REQUEST_METHOD']=="POST") {
	      //
	      $id = $_POST['id'] ?? "";
	      //
	      $nombre = Helper::cadena($_POST['nombre'] ?? "");
	      $apellidos = Helper::cadena($_POST['apellidos'] ?? "");
	      $correo = Helper::cadena($_POST['correo'] ?? "");
	      $direccion = Helper::cadena($_POST['direccion'] ?? "");
	      $telefono = Helper::cadena($_POST['telefono'] ?? "0");
	      $genero = $_POST['genero'] ?? "";
	      $fechaNacimiento = $_POST['fechaNacimiento'] ?? "";
	      $edad = Helper::calcularEdad($fechaNacimiento);
	      $grupoSanguineo = $_POST['grupoSanguineo'] ?? "";
	      $dni = Helper::cadena($_POST['dni'] ?? "");
	      $edoCivil = $_POST['edoCivil'] ?? "";
	      $ocupacion = Helper::cadena($_POST['ocupacion'] ?? "");
	      $peso = Helper::numero($_POST['peso'] ?? "0");
	      $estatura = Helper::numero($_POST['estatura'] ?? "0");
	      $cardiaco = $_POST['cardiaco'] ?? "off";
	      $diabetico = $_POST['diabetico'] ?? "off";
	      $hemofilia = $_POST['hemofilia'] ?? "off";
	      $otros = Helper::cadena($_POST['otros'] ?? "");
	      $numCalzado = Helper::cadena($_POST['numCalzado'] ?? "");
	      $horma = Helper::cadena($_POST['horma'] ?? "");
	      $tacones = Helper::cadena($_POST['tacones'] ?? "");
	      //
	      //Helpermos la información
	      //
	      if(empty($nombre)){
	        array_push($errores,"El nombre del paciente es requerido");
	      }
	      if(empty($apellidos)){
	        array_push($errores,"Los apellidos del paciente son requeridos");
	      }
	      if(empty($correo)){
	        array_push($errores,"El correo del paciente es requerido.");
	      }
	      if(empty($telefono)){
	        array_push($errores,"El teléfono del paciente es requerido.");
	      }
	      if(empty($dni)){
	        array_push($errores,"El DNI del paciente es requerido.");
	      }
	      if(!Helper::fecha($fechaNacimiento)){
	        array_push($errores,"La fecha de nacimiento del paciente es requerido.");
	      }
	      if($genero=="void"){
	        array_push($errores,"El perfil del paciente es requerido.");
	      }
	      if(trim($id)=="" && $this->modelo->verificaCorreo($correo)==false){
	        array_push($errores,"Ya existe ese correo. El correo debe ser único.");
	      }
	      if(trim($id)=="" && $this->modelo->verificaDNI($dni)==false){
	        array_push($errores,"Ya existe ese DNI. El DNI debe ser único.");
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
	        "genero" => $genero,
	        'fechaNacimiento' => $fechaNacimiento,
	        'edad' => $edad,
	        'grupoSanguineo' => $grupoSanguineo,
	        'dni' => $dni,
	        'edoCivil' => $edoCivil,
	        'ocupacion' => $ocupacion,
	        'peso' => $peso,
	        'estatura' => $estatura,
	        'cardiaco' => $cardiaco,
	        'diabetico' => $diabetico,
	        'hemofilia' => $hemofilia,
	        'otros' => $otros,
	        'numCalzado' => $numCalzado,
	        'horma' => $horma,
	        'tacones' => $tacones
	      ];

	      if (empty($errores)) {       
	        //Enviamos al modelo
	        if(trim($id)===""){
	          //Alta
	          if ($this->modelo->altaPaciente($data)) {
	            header("location:".RUTA."pacientes");
	          }
	        } else {
	          //Modificacion
	          if ($this->modelo->modificaPaciente($data)) {
	            header("location:".RUTA."pacientes");
	          }
	        }
	      }
	    }

	    //Vista Alta
	    $datos = [
	      "titulo" => "Alta del paciente",
	      "subtitulo" => "Alta del paciente",
	      "activo" => "pacientes",
	      "menu" => true,
	      "admon" => $this->admon,
	      "errores" => $errores,
	      "grupoSanguineo" => $grupoSanguineo_array,
	      "genero" => $genero_array,
	      "edoCivil" => $edoCivil_array,
	      "data" => $data
	    ];
	    $this->vista("pacientesAltaVista",$datos);
  	}

	public function baja($id=""){
	    //Leemos los datos del registro del id
	    $data = $this->modelo->getPacienteId($id);
	    $numCitas = $this->modelo->getCitasPaciente($id);
	    $numCitas = $numCitas["count(*)"];

	    //Leemos la llaves de tipoSangre
	    $grupoSanguineo_array = $this->modelo->getLlaves("grupoSangre");

	    //Leemos la llaves de genero
	    $genero_array = $this->modelo->getLlaves("genero");

	    //Leemos la llaves de edoCivil
	    $edoCivil_array = $this->modelo->getLlaves("edoCivil");

	    //Vista baja
	    $datos = [
	      "titulo" => "Baja de un paciente",
	      "subtitulo" => "Baja de un paciente",
	      "menu" => true,
	      "admon" => $this->admon,
	      "errores" => [],
	      "numCitas" => $numCitas,
	      "activo" => 'pacientes',
	      "data" => $data,
	      "grupoSanguineo" => $grupoSanguineo_array,
	      "genero" => $genero_array,
	      "edoCivil" => $edoCivil_array,
	      "baja" => true
	    ];
	    $this->vista("pacientesAltaVista",$datos);
	  }

  	public function bajaLogica($id=''){
	   if (isset($id) && $id!="") {
	     if($this->modelo->bajaLogica($id)){
	      header("location:".RUTA."pacientes");
	     }
	   }
	}

	public function cambio($id=""){
	    //Leemos los datos del registro del id
	    $data = $this->modelo->getPacienteId($id);

	    //Leemos la llaves de tipoSangre
	    $grupoSanguineo_array = $this->modelo->getLlaves("grupoSangre");

	    //Leemos la llaves de genero
	    $genero_array = $this->modelo->getLlaves("genero");

	    //Leemos la llaves de edoCivil
	    $edoCivil_array = $this->modelo->getLlaves("edoCivil");

	    //Vista Alta
	    $datos = [
	      "titulo" => "Modificar Pacientes",
	      "subtitulo" => "Modificar Pacientes",
	      "menu" => true,
	      "admon" => $this->admon,
	      "activo" => "pacientes",
	      "errores" => [],
	      "grupoSanguineo" => $grupoSanguineo_array,
	      "genero" => $genero_array,
	      "edoCivil" => $edoCivil_array,
	      "data" => $data
	    ];
	    $this->vista("pacientesAltaVista",$datos);
	}
}