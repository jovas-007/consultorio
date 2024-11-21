<?php
/**
 * Tablero Modelo
 */
class TableroModelo extends Llaves
{
	public $db;
	
	function __construct()
	{
		$this->db = new MySQLdb();
	}


	public function getUsuarioId($id){
		$sql = "SELECT * FROM admon WHERE id=".$id." AND baja=0";
		$data = $this->db->query($sql);
		return $data;
	}

	public function getUsuarioIdDoctor($id){
		$sql = "SELECT * FROM doctores WHERE id=".$id." AND baja=0";
		$data = $this->db->query($sql);
		return $data;
	}

	public function getCitasProximas($admon=true,$id=""){
		$sql = "SELECT c.id, c.idPaciente, c.idDoctor, c.fecha, c.horario, c.edoCita, ";
		$sql.= "p.nombre as pacienteNombre, p.apellidos as pacienteApellidos, ";
		$sql.= "d.nombre as doctorNombre, d.apellidos as doctorApellidos, ";
		$sql.= "l.cadena as estadoCita ";
		$sql.= "FROM citas as c, pacientes as p, doctores as d, llaves as l ";
		$sql.= "WHERE c.idPaciente = p.id and c.idDoctor=d.id and ";
		$sql.= "c.edoCita = l.indice and l.tipo='edoCita' and c.baja=0 and ";
		if ($admon==false && $id!="") {
			$sql.= "d.id = ".$id." and ";
		}
		$sql.= "c.fecha >= CURRENT_DATE() ";
		$sql.= "ORDER BY c.fecha, c.horario ";
		$sql.= "LIMIT 10 ";
		$data = $this->db->querySelect($sql);
		return $data;
	}

	public function getCitaId($id=""){
		$sql = "SELECT c.id, c.idPaciente, c.idDoctor, c.fecha, c.horario, c.edoCita, ";
		$sql.= "p.nombre as pacienteNombre, p.apellidos as pacienteApellidos, ";
		$sql.= "d.nombre as doctorNombre, d.apellidos as doctorApellidos, ";
		$sql.= "d.perfil as doctorPerfil, p.telefono as telefono, ";
		$sql.= "l.cadena as estadoCita, c.observacion ";
		$sql.= "FROM citas as c, pacientes as p, doctores as d, llaves as l ";
		$sql.= "WHERE c.idPaciente = p.id and c.idDoctor=d.id and ";
		$sql.= "c.edoCita = l.indice and l.tipo='edoCita' and c.baja=0 ";
		$sql.= "and c.id=".$id;
		$data = $this->db->query($sql);
		return $data;
	}

	public function getHistorialId($idCita=""){
		$sql = "SELECT * FROM historial WHERE idCita=".$idCita;
		$data = $this->db->query($sql);
		return $data;
	}

	public function getDepurar($dias=10){
		$sql = "SELECT * FROM citas WHERE ";
		$sql.= "(fecha<DATE_SUB(curdate(), INTERVAL ".$dias." DAY) AND ";
		$sql.= "edoCita <> ".REALIZADA.") OR baja=1";
		$data = $this->db->querySelect($sql);
		//var_dump($sql);
		return $data;
	}

	public function modifica($id,$edoCita,$observacion=""){
		$salida = false;
		if ($id!="") {
			$sql = "UPDATE citas SET edoCita=".$edoCita;
			$sql.= ", observacion='".$observacion."' WHERE id=".$id;
			$salida = $this->db->queryNoSelect($sql);
		}
		return $salida;
	}

	public function setHistorial($id,$tratamiento,$costo){
		$salida = false;
		$sql = "INSERT INTO historial VALUES(0,";   //1. id
		$sql.= $id.", ";            				//2. cita    
		$sql.= "'".$tratamiento."', ";          	//3. tratamiento
		$sql.= "'".$costo."', ";       				//4. costo
		$sql.= "0, ";                              //5. baja
		$sql.= "'', ";                             //6. fecha baja
		$sql.= "'', ";                             //7. fecha modificado 
		$sql.= "NOW())";                          //8. fecha alta-creado
		//print $sql;
		$salida = $this->db->queryNoSelect($sql);
		if ($salida) {
			$sql = "UPDATE citas SET edoCita=".REALIZADA." WHERE id=".$id;
			$salida = $this->db->queryNoSelect($sql);
		}
		return $salida;
	}

	public function setUsuario($id, $nombre, $correo, $clave){
	    $sql = "UPDATE admon SET ";
	    $sql.= "nombre='".$nombre."', ";
	    $sql.= "correo='".$correo."' ";
	    if($clave!=""){
	      $clave = hash_hmac("sha512", $clave, LLAVE);
	      $sql.= ", clave='".$clave."' ";
	    }
	    $sql.= "WHERE id=".$id;
	    return $this->db->queryNoSelect($sql);
	}

	public function setUsuarioDoctor($data){
		$sql = "UPDATE  doctores SET ";                   //1. id
		$sql.= "foto='', ";              				  //2. foto
		$sql.= "nombre='".$data['nombre']."', ";          //3. nombre
		$sql.= "apellidos='".$data['apellidos']."', ";    //4. apellidos
		$sql.= "correo='".$data['correo']."', ";          //5. correo
		$sql.= "direccion='".$data['direccion']."', ";    //6. descuento 
		$sql.= "telefono='".$data['telefono']."', ";      //7. envio
		if($data['clave']!=""){
	      $clave = hash_hmac("sha512", $data['clave'], LLAVE);
	      $sql.= "depto='".$clave."', ";
	    }
		$sql.= "perfil='".$data['perfil']."', ";          //9. fecha
		$sql.= "baja=0, ";                                //16. baja
		$sql.= "modificado_dt=(NOW()) ";                  //18. fecha modificado
		$sql.= "WHERE id=".$data['id'];
	    return $this->db->queryNoSelect($sql);
	}

	public function setInsertarHistorico($data){
		$sql = "INSERT INTO citas_historico VALUES(0,";      //1. id
		$sql.= "'".$data['idPaciente']."', ";        //2. paciente    
		$sql.= "'".$data['idDoctor']."', ";          //3. doctor
		$sql.= "'".$data['fecha']."', ";           //4. fecha
		$sql.= "'".$data['horario']."', ";            //5. horario
		$sql.= "'".$data['observacion']."', ";     //6. observacion
		$sql.= "'".$data['edoCita']."', ";     		//7. estado cita
		$sql.= "'".$data['baja']."', ";     		//8. baja
		$sql.= "'".$data['baja_dt']."', ";     		//9. fecha baja
		$sql.= "'".$data['modificado_dt']."', ";    //10. fecha modificado 
		$sql.= "'".$data['creado_dt']."')";     	//11. fecha alta-creado
		//print $sql;
		return $this->db->queryNoSelect($sql);
	}

	public function setElimitarHistorico($data='')
	{
		if ($data!="") {
		  	$salida = false;
			$sql = "DELETE FROM citas WHERE id=".$data["id"];
			//print $sql;
			$salida = $this->db->queryNoSelect($sql);
			return $salida;
		}
	}

	public function updateHistorial($idCita,$tratamiento,$costo){
		$salida = false;
		$sql = "UPDATE historial SET ";   						 
		$sql.= "tratamiento='".$tratamiento."', ";          	
		$sql.= "costo='".$costo."', ";
		$sql.= "modificado_dt=NOW() "; 
		$sql.= "WHERE idCita=".$idCita;
		//print $sql;
		$salida = $this->db->queryNoSelect($sql);
		if ($salida) {
			$sql = "UPDATE citas SET edoCita=".REALIZADA." WHERE id=".$idCita;
			$salida = $this->db->queryNoSelect($sql);
		}
		return $salida;
	}

	public function verificarDoctor($id, $clave){
	    $salida = true;
	    $sql = "SELECT * FROM doctores WHERE id=".$id;
	    $clave = hash_hmac("sha512", $clave, CLAVE);
	    $clave = substr($clave,0,200);
	    //consulta
	    $data = $this->db->query($sql);
	    //validacion
	    if (empty($data) && $clave!=$data["depto"]){
	      $salida = false;
	    }
	    return $salida;
	}
}