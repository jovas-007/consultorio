<?php
/**
 * Historial Modelo
 */
class HistorialModelo
{
	public $db;
	
	function __construct()
	{
		$this->db = new MySQLdb();
	}

	public function getNumTabla($idDoctor){
		$data = 0;
		if($idDoctor){
			$sql = "SELECT DISTINCT c.idPaciente, ";
			$sql.= "p.nombre, p.apellidos ";
			$sql.= "FROM citas AS c, pacientes AS p ";
			$sql.= "WHERE c.idDoctor=".$idDoctor." AND c.idPaciente=p.id ";
			$sql.= "AND c.edoCita=".REALIZADA;
			$data = count($this->db->querySelect($sql));
		}
	    return $data;
	}

	public function getTabla($idDoctor,$inicio,$tamano){
		$data = [];
		if($idDoctor){
			$sql = "SELECT DISTINCT c.idPaciente, ";
			$sql.= "p.nombre, p.apellidos ";
			$sql.= "FROM citas AS c, pacientes AS p ";
			$sql.= "WHERE c.idDoctor=".$idDoctor." AND c.idPaciente=p.id ";
			$sql.= "AND c.edoCita=".REALIZADA;
			$sql.= " LIMIT ".$inicio.", ".$tamano;
			$data = $this->db->querySelect($sql);
		}
	    return $data;
	}

	public function getHistorial($idPaciente, $idDoctor){
		$sql = "SELECT c.id, c.idPaciente, c.idDoctor, ";
		$sql.= "c.fecha, c.horario, c.observacion, ";
		$sql.= "p.nombre, p.apellidos, h.costo ";
		$sql.= "FROM citas AS c, pacientes AS p, historial AS h ";
		$sql.= "WHERE c.idDoctor=".$idDoctor." AND c.idPaciente=".$idPaciente." ";
		$sql.= "AND c.idPaciente=p.id AND c.edoCita=".REALIZADA." ";
		$sql.= "AND c.id=h.idCita ";
		$sql.= "ORDER BY c.fecha, c.horario";
		$data = $this->db->querySelect($sql);
		//var_dump($sql);
	    return $data;
	}

	public function getHistorialId($idCita){
		$sql = "SELECT c.id, c.idPaciente, c.idDoctor, ";
		$sql.= "c.fecha, c.horario, c.observacion, ";
		$sql.= "d.nombre AS doctorNombre, d.apellidos AS doctorApellidos, ";
		$sql.= "d.perfil AS doctorPerfil, ";
		$sql.= "p.nombre AS pacienteNombre, p.apellidos AS pacienteApellidos, ";
		$sql.= "h.costo, h.tratamiento ";
		$sql.= "FROM citas AS c, pacientes AS p, historial AS h, doctores AS d ";
		$sql.= "WHERE c.id=".$idCita." ";
		$sql.= "AND c.id=h.idCita ";
		$sql.= "AND c.idPaciente=p.id ";
		$sql.= "AND c.idDoctor=d.id ";
		$data = $this->db->query($sql);
		//var_dump($sql);
	    return $data;
	}

}