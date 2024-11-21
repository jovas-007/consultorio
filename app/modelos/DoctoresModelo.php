<?php
/**
 * Doctores Modelo
 */
class DoctoresModelo
{
	public $db;
	
	function __construct()
	{
		$this->db = new MySQLdb();
	}

	public function altaDoctor($data){
	   $sql = "INSERT INTO doctores VALUES(0,";   //1. id
	   $sql.= "'".$data['foto']."', ";            //2. foto    
	   $sql.= "'".$data['nombre']."', ";          //3. nombre
	   $sql.= "'".$data['apellidos']."', ";       //4. apellidos
	   $sql.= "'".$data['correo']."', ";          //5. correo
	   $sql.= "'".$data['direccion']."', ";       //6. direccion
	   $sql.= "'".$data['telefono']."', ";        //7. telefono
	   $sql.= "'', ";           				  //8. clave de acceso
	   $sql.= "'".$data['perfil']."', ";          //9. perfil
	   $sql.= "1, ";                              //10. status
	   $sql.= "0, ";                              //11. baja
	   $sql.= "'', ";                             //12. fecha login
	   $sql.= "'', ";                             //13. fecha baja
	   $sql.= "'', ";                             //14. fecha modificado 
	   $sql.= "NOW())";                          //15. fecha alta-creado
	   //print $sql;
	   return $this->db->queryNoSelect($sql);
	 }

	public function bajaLogica($id){
	    $sql = "UPDATE doctores SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
	    return $this->db->queryNoSelect($sql);
	}

	public function getDoctores(){
		$sql = "SELECT * FROM doctores WHERE baja=0";
	    $data = $this->db->querySelect($sql);
	    return $data;
	}

	public function getDoctorId($id){
		$sql = "SELECT * FROM doctores WHERE id=".$id." AND baja=0";
	    $data = $this->db->query($sql);
	    return $data;
	}

	public function getNumCitasDoctores($idDoctor){
		$sql = "SELECT count(*) FROM citas WHERE baja=0 AND idDoctor=".$idDoctor;
	    $data = $this->db->query($sql);
	    return $data;
	}

	public function getNumHorariosDoctores($idDoctor){
		$sql = "SELECT count(*) FROM horarios WHERE baja=0 AND idDoctor=".$idDoctor;
	    $data = $this->db->query($sql);
	    return $data;
	}

	public function modificaDoctor($data){
		$salida = false;
		if (!empty($data["id"])) {
			$sql = "UPDATE  doctores SET ";                   //1. id
			$sql.= "foto='".$data['foto']."', ";              //2. foto
			$sql.= "nombre='".$data['nombre']."', ";          //3. nombre
			$sql.= "apellidos='".$data['apellidos']."', ";    //4. apellidos
			$sql.= "correo='".$data['correo']."', ";          //5. correo
			$sql.= "direccion='".$data['direccion']."', ";    //6. descuento 
			$sql.= "telefono='".$data['telefono']."', ";      //7. envio
			//$sql.= "depto='".$data['depto']."', ";            //8. no actualiza el depto
			$sql.= "perfil='".$data['perfil']."', ";          //9. fecha
			$sql.= "baja=0, ";                                //16. baja
			$sql.= "modificado_dt=(NOW()) ";                  //18. fecha modificado
			$sql.= "WHERE id=".$data['id'];
			//Enviamos a la base de datos
			$salida = $this->db->queryNoSelect($sql);
		}
		return $salida;
	}
}