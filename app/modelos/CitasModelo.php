<?php
/**
 * Citas Modelo
 */
class CitasModelo extends Llaves
{
	public $db;
	
	function __construct()
	{
		$this->db = new MySQLdb();
	}

	public function alta($data){
		$sql = "INSERT INTO citas VALUES(0,";      //1. id
		$sql.= "'".$data['paciente']."', ";        //2. paciente    
		$sql.= "'".$data['doctor']."', ";          //3. doctor
		$sql.= "'".$data['fecha']."', ";           //4. fecha
		$sql.= "'".$data['hora']."', ";            //5. horario
		$sql.= "'".$data['observacion']."', ";     //6. observacion
		$sql.= "1, ";                              //7. estado cita
		$sql.= "0, ";                              //8. baja
		$sql.= "'', ";                             //9. fecha baja
		$sql.= "'', ";                             //10. fecha modificado 
		$sql.= "NOW())";                          //11. fecha alta-creado
		//print $sql;
		return $this->db->queryNoSelect($sql);
	}

	public function bajaLogica($id){
	    $salida = true;
	    $sql = "UPDATE citas SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
	    var_dump($sql);
	    $salida = $this->db->queryNoSelect($sql);
	    return $salida;
	  }
	public function getTabla(){
	    $sql = "SELECT c.id, c.idPaciente, c.idDoctor, c.fecha, c.horario, c.edoCita, ";
	    $sql.= "p.nombre as pacienteNombre, p.apellidos as pacienteApellidos, ";
	    $sql.= "d.nombre as doctorNombre, d.apellidos as doctorApellidos, ";
	    $sql.= "l.cadena as estadoCita ";
	    $sql.= "FROM citas as c, pacientes as p, doctores as d, llaves as l ";
	    $sql.= "WHERE c.idPaciente = p.id AND c.idDoctor=d.id AND ";
	    $sql.= "c.edoCita = l.indice AND l.tipo='edoCita' AND c.baja=0 ";
	    $sql.= "ORDER BY c.fecha, c.horario ";
	    $data = $this->db->querySelect($sql);
	    return $data;
	 }

	public function getDoctores(){
		$sql = "SELECT id, nombre, apellidos, perfil FROM doctores WHERE baja=0 ";
		$sql.= "ORDER BY nombre, apellidos";
		$data = $this->db->querySelect($sql);
		return $data;
	}

	public function getPacientes(){
		$sql = "SELECT id, nombre, apellidos FROM pacientes WHERE baja=0 ";
		$sql.= "ORDER BY nombre, apellidos";
		$data = $this->db->querySelect($sql);
		return $data;
	}

	public function getCitas($doctor, $fecha){
		$sql = "SELECT * FROM citas WHERE fecha='".$fecha;
		$sql.= "' and idDoctor=".$doctor." and baja=0";
		$data = $this->db->querySelect($sql);
		return $data;
	}

	public function getHorarioDoctor($doctor, $dia){
		$sql = "SELECT * FROM horarios WHERE diaSemana=".$dia;
		$sql.= " and idDoctor=".$doctor." and baja=0";
		$data = $this->db->querySelect($sql);
		return $data;
	}

	public function getDoctorId($idDoctor){
		$sql = "SELECT * FROM doctores WHERE id=".$idDoctor." and baja=0";
		$data = $this->db->querySelect($sql);
		return $data;
	}

	public function getPacienteId($idPaciente){
		$sql = "SELECT * FROM pacientes WHERE id=".$idPaciente." and baja=0";
		$data = $this->db->querySelect($sql);
		return $data;
	}

	public function getId($id=""){
		$data = [];
		if ($id!="") {
			$sql = "SELECT * FROM citas WHERE id=".$id." AND baja=0";
			$data = $this->db->query($sql);
		}
		return $data;
	}

	public function modifica($data){
		$salida = false;
		if (!empty(trim($data["id"]))) {
			$sql = "UPDATE citas SET ";                           //1. id
			$sql.= "idPaciente='".$data['paciente']."', ";        //2. paciente    
			$sql.= "idDoctor='".$data['doctor']."', ";            //3. doctor
			$sql.= "fecha='".$data['fecha']."', ";                //4. fecha
			$sql.= "horario='".$data['hora']."', ";               //5. horario
			$sql.= "observacion='".$data['observacion']."', ";    //6. observacion
			$sql.= "edoCita=".$data['edoCita'].", "; 		      //7. estado cita
			//
			$sql.= "modificado_dt=(NOW()) ";                  //8. fecha modificado
			$sql.= "WHERE id=".$data['id'];
			//Enviamos a la base de datos
			$salida = $this->db->queryNoSelect($sql);
		}
		return $salida;
	}
}