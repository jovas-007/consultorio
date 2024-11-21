<?php
/**
 * Horarios Modelo
 */
class HorariosModelo extends Llaves
{
	public $db;
	
	function __construct()
	{
		$this->db = new MySQLdb();
	}

	public function alta($data){
		$sql = "INSERT INTO horarios VALUES(0,";   //1. id
		$sql.= $data['doctor'].", ";               //2. idDoctor    
		$sql.= "'".$data['dia']."', ";             //3. dia
		$sql.= "'".$data['inicio']."', ";          //4. apellidos
		$sql.= "'".$data['fin']."', ";             //5. correo
		$sql.= $data['duracion'].", ";             //6. direccion
		//
		$sql.= "0, ";                              //7. baja
		$sql.= "'', ";                             //8. fecha baja
		$sql.= "'', ";                             //9. fecha modificado 
		$sql.= "NOW())";                          //10. fecha alta-creado
		//print $sql;
		return $this->db->queryNoSelect($sql);
	}
	public function bajaLogica($id){
	    $sql = "UPDATE horarios SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
	    return $this->db->queryNoSelect($sql);
	}

	public function getHorarios(){
		$sql = "SELECT * FROM horarios WHERE baja=0";
	    $data = $this->db->querySelect($sql);
	    return $data;
	}

	public function getTabla(){
	    $sql = "SELECT h.id, h.idDoctor, h.diaSemana, h.inicio, h.fin, ";
	    $sql.= "h.duracion, d.cadena, dr.nombre, dr.apellidos ";
	    $sql.= "FROM horarios as h, llaves as d, doctores as dr ";
	    $sql.= "WHERE h.baja=0 AND d.tipo='diaSemana' AND h.diaSemana=d.indice ";
	    $sql.= "AND h.idDoctor=dr.id";
	    $data = $this->db->querySelect($sql);
	    return $data;
	}

	public function getDoctores(){
	  $sql = "SELECT id, nombre, apellidos, perfil FROM doctores WHERE baja=0";
	  $data = $this->db->querySelect($sql);
	  return $data;
	}

	public function modifica($data){
		$salida = false;
		if (!empty($data["id"])) {
			$sql = "UPDATE horarios SET ";                   //1. id
			$sql.= "idDoctor=".$data['doctor'].", ";           //2. idDoctor    
			$sql.= "diaSemana=".$data['dia'].", ";            //3. dia
			$sql.= "inicio='".$data['inicio']."', ";          //4. inicio
			$sql.= "fin='".$data['fin']."', ";                //5. fin
			$sql.= "duracion=".$data['duracion'].", ";        //6. duracion
			$sql.= "baja=0, ";                                //7. baja
			$sql.= "modificado_dt=(NOW()) ";                  //8. fecha modificado
			$sql.= "WHERE id=".$data['id'];
			//Enviamos a la base de datos
			$salida = $this->db->queryNoSelect($sql);
		} 
		return $salida;
	}

	public function getId($id){
	    $sql = "SELECT * FROM horarios WHERE id=".$id;
	    $data = $this->db->query($sql);
	    return $data;
	 }
}