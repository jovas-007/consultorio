<?php  
/**
 * Controlador historial del paciente
 */
class Historial extends Controlador
{
  private $modelo;
  private $admon;
  private $usuario;
	
	function __construct()
	{
	    //Creamos sesion
	    $sesion = new Sesion();
	    if ($sesion->getLogin()) {
		  	$this->modelo = $this->modelo("HistorialModelo");
	      $this->admon = $sesion->getAdmon();
	      $this->usuario = $sesion->getUsuario();
	    } else {
	      header("location:".RUTA);
	    }
	}

	public function caratula($pagina=1)
	{
		//Leemos los datos de la tabla
		$num = $this->modelo->getNumTabla($this->usuario["id"]);
		$inicio = ($pagina-1)*TAMANO_PAGINA;
		$totalPaginas = ceil($num/TAMANO_PAGINA);
		$data = $this->modelo->getTabla($this->usuario["id"],$inicio,TAMANO_PAGINA);

		$datos = [
			"titulo" => "Historial de pacientes",
			"subtitulo" => "Historial de pacientes",
			"menu" => true,
			"admon" =>  $this->admon,
			"activo" => "historial",
			"pag" => [
				"totalPaginas" => $totalPaginas,
				"regresa" => "historial",
				"pagina" => $pagina
			],
			"data" => $data
		];
		$this->vista("historialCaratulaVista",$datos);
	}

	public function historial($idPaciente='')
	{
		if ($idPaciente) {
			$data = $this->modelo->getHistorial($idPaciente,$this->usuario["id"]);
			$datos = [
			"titulo" => "Historial del paciente",
			"subtitulo" => $data[0]["nombre"]." ".$data[0]["apellidos"],
			"menu" => true,
			"admon" =>  $this->admon,
			"activo" => "historial",
			"data" => $data
		];
		$this->vista("historialPacienteVista",$datos);
		}
	}

	public function diagnostico($idCita=null)
	{
		if ($idCita) {
			$data = $this->modelo->getHistorialId($idCita);
			//
			//Leemos los archivos
			//
			$carpeta = 'doc/'.$idCita."/";
			if (file_exists($carpeta)) {
				$archivos_array  = scandir($carpeta);
			} else {
				$archivos_array  = [];
			}
			//
			//Enviamos los archivos
			//
			$datos = [
				"titulo" => "Tratamiento",
				"subtitulo" => "Tratamiento",
				"menu" => true,
				"admon" => $this->admon,
				"archivos" => $archivos_array,
				"activo" => "historial",
				"errores" => [],
				"data" => $data
			];
			$this->vista("historialDiagnosticoVista",$datos);
		}
	}

	public function foto($idCita='', $archivo="")
  {
    if ($idCita=="") return false;
    //Vista archivo
    $datos = [
      "titulo" => "Visualizar un archivo",
      "subtitulo" => "Visualizar un archivo",
      "menu" => true,
      "admon" => $this->admon,
      "errores" => [],
      "data" => [
        "idCita" => $idCita,
        "archivo" => $archivo
      ]
    ];
    $this->vista("historialFotoVista",$datos);
  }
}