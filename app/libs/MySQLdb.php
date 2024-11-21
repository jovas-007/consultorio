<?php  
/**
 * 
 */
class MySQLdb
{
	private $host="localhost";
	private $usuario = "root";
	private $clave = "";
	private $db = "consultorio";
	private $puerto = "";
	private $conn;
	
	function __construct()
	{
		$this->conn =mysqli_connect($this->host, 
			$this->usuario, 
			$this->clave, 
			$this->db);

		if (mysqli_connect_errno()) {
			print "Error al conectarse a la base de datos.";
			exit();
		} else {
			//print "Conexión exitosa";
		}

		if (mysqli_set_charset($this->conn, "utf8")) {
			//print "El conjunto de caracteres es ".mysqli_character_set_name($this->conn)."<br>";
		} else {
			print "Error en la conversión de caracteres de la base de datos.";
			exit();
		}
	}

	/*
	* Query que regresa un solo registro en un arreglo asociativo
	*/
	public function query($sql='')
	{
		$data = [];
		$r = mysqli_query($this->conn,$sql);
		if ($r) {
			if (mysqli_num_rows($r)>0) {
				$data = mysqli_fetch_assoc($r);
			}
		}
		return $data;
	}

	//Query regresa un valor booleano
	public function queryNoSelect($sql){
		return mysqli_query($this->conn, $sql);
	}

	//Query regresa un arreglo con los registros
	public function querySelect($sql){
	    $data = array();
	    $r = mysqli_query($this->conn, $sql);
	    if($r){
	      while($row = mysqli_fetch_assoc($r)){
	        array_push($data, $row);
	      }
	    }
	    return $data;
	}
}

?>