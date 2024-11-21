<?php
/**
 * Pacientes Modelo
 */
class PacientesModelo extends Llaves
{
	public $db;
	
	function __construct()
	{
		$this->db = new MySQLdb();
	}

	public function altaPaciente($data){
	   $sql = "INSERT INTO pacientes VALUES(0,";   //1. id
	   $sql.= "'".$data['foto']."', ";            //2. foto    
	   $sql.= "'".$data['nombre']."', ";          //3. nombre
	   $sql.= "'".$data['apellidos']."', ";       //4. apellidos
	   $sql.= "'".$data['correo']."', ";          //5. correo
	   $sql.= "'".$data['direccion']."', ";       //6. direccion
	   $sql.= "'".$data['telefono']."', ";        //7. telefono
	   $sql.= "'".$data['genero']."', ";          //8. genero
	   $sql.= "'".$data['fechaNacimiento']."', "; //9. fechaNacimiento
	   $sql.= "'".$data['edad']."', ";            //10. edad
	   $sql.= "'".$data['grupoSanguineo']."', ";     //11. grupoSanguineo
	   $sql.= "'".$data['dni']."', ";             //12. dni
	   $sql.= "'".$data['edoCivil']."', ";        //13. edoCivil
	   $sql.= "'".$data['ocupacion']."', ";        //14. ocupacion
	   $sql.= "'".$data['peso']."', ";            //15. peso
	   $sql.= "'".$data['estatura']."', ";        //16. estatura
	   $sql.= "'".$data['cardiaco']."', ";        //17. cardiaco
	   $sql.= "'".$data['diabetico']."', ";        //18. diabetico
	   $sql.= "'".$data['hemofilia']."', ";        //19. hemofilia
	   $sql.= "'".$data['otros']."', ";           //20. otros
	   $sql.= "'".$data['numCalzado']."', ";      //21. numCalzado
	   $sql.= "'".$data['horma']."', ";           //22. horma
	   $sql.= "'".$data['tacones']."', ";         //23. tacon
	   //
	   $sql.= "0, ";                              //24. baja
	   $sql.= "'', ";                             //25. fecha login
	   $sql.= "'', ";                             //26. fecha baja
	   $sql.= "'', ";                             //27. fecha modificado 
	   $sql.= "NOW())";                          //28. fecha alta-creado
	   //print $sql;
	   return $this->db->queryNoSelect($sql);
	 }

	public function bajaLogica($id){
	    $sql = "UPDATE pacientes SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
	    return $this->db->queryNoSelect($sql);
	}

	public function getPacientes($inicio,$tamanioPagina){
		$sql = "SELECT * FROM pacientes WHERE baja=0 LIMIT ".$inicio.", ".$tamanioPagina;
	    $data = $this->db->querySelect($sql);
	    return $data;
	}

	public function getPacienteId($id){
		$sql = "SELECT * FROM pacientes WHERE id=".$id." AND baja=0";
	    $data = $this->db->query($sql);
	    return $data;
	}

	public function getNumPacientes(){
		$sql = "SELECT count(*) FROM pacientes WHERE baja=0";
	    $data = $this->db->query($sql);
	    if ($data["count(*)"]) {
	    	return $data["count(*)"];
	    }
	    return 0;
	}

	public function getCitasPaciente($id){
		$sql = "SELECT count(*) FROM citas WHERE idPaciente=".$id." AND baja=0";
	    $data = $this->db->query($sql);
	    return $data;
	}

	public function modificaPaciente($data){
	    $salida = false;
	    if (!empty($data["id"])) {
	     $sql = "UPDATE  pacientes SET ";                   //1. id
	     $sql.= "foto='".$data['foto']."', ";              //2. foto
	     $sql.= "nombre='".$data['nombre']."', ";          //3. nombre
	     $sql.= "apellidos='".$data['apellidos']."', ";    //4. apellidos
	     $sql.= "correo='".$data['correo']."', ";          //5. correo
	     $sql.= "direccion='".$data['direccion']."', ";    //6. descuento 
	     $sql.= "telefono='".$data['telefono']."', ";      //7. envio
	     $sql.= "genero='".$data['genero']."', ";          //8. genero
	     $sql.= "fechaNacimiento='".$data['fechaNacimiento']."', "; //9. fechaNacimiento
	     $sql.= "edad='".$data['edad']."', ";            //10. edad
	     $sql.= "grupoSanguineo='".$data['grupoSanguineo']."', ";     //11. grupoSanguineo
	     $sql.= "dni='".$data['dni']."', ";             //12. dni
	     $sql.= "edoCivil='".$data['edoCivil']."', ";        //13. edoCivil
	     $sql.= "ocupacion='".$data['ocupacion']."', ";        //14. ocupacion
	     $sql.= "peso='".$data['peso']."', ";            //15. peso
	     $sql.= "estatura='".$data['estatura']."', ";        //16. estatura
	     $sql.= "cardiaco='".$data['cardiaco']."', ";        //17. cardiaco
	     $sql.= "diabetico='".$data['diabetico']."', ";        //18. diabetico
	     $sql.= "hemofilia='".$data['hemofilia']."', ";        //19. hemofilia
	     $sql.= "otros='".$data['otros']."', ";           //20. otros
	     $sql.= "numCalzado='".$data['numCalzado']."', ";      //21. numCalzado
	     $sql.= "horma='".$data['horma']."', ";           //22. horma
	     $sql.= "tacones='".$data['tacones']."', ";         //23. tacon
	      //
	     $sql.= "baja=0, ";                                //25. baja
	     $sql.= "modificado_dt=(NOW()) ";                  //26. fecha modificado
	     $sql.= "WHERE id=".$data['id'];
	     //Enviamos a la base de datos
	     //print $sql;
	     $salida = $this->db->queryNoSelect($sql);
	    }
	    return $salida;
	}

	public function verificaCorreo($correo){
		$sql = "SELECT * FROM pacientes WHERE correo='".$correo."' AND baja=0";
	    $data = $this->db->query($sql);
	    return ($data==[])?true:false;
	}

	public function verificaDNI($dni){
		$sql = "SELECT * FROM pacientes WHERE dni='".$dni."' AND baja=0";
	    $data = $this->db->query($sql);
	    return ($data==[])?true:false;
	}
}