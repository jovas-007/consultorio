<?php 
/**
 * 
 */
class Llaves
{
	
	function __construct(){}

	public function getLLaves($tipo='')
	{
		$sql = "SELECT * FROM llaves WHERE tipo='".$tipo."' ORDER BY indice";
		return $this->db->querySelect($sql);
	}
}