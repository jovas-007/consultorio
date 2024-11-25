<?php
/**
 * Login Modelo
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class LoginModelo
{
	public $db;
	
	function __construct()
	{
		$this->db = new MySQLdb();
	}

	public function cambiarClaveAcceso($id, $clave, $admon){
	    $r = false;
	    $clave = hash_hmac("sha512", $clave, CLAVE);
	    if ($admon=="admon") {
	    	$sql = "UPDATE admon SET ";
		    $sql.= "clave='".$clave."' ";
		    $sql.= "WHERE id=".$id;
	    } else {
	    	$sql = "UPDATE doctores SET ";
		    $sql.= "depto='".$clave."' ";
		    $sql.= "WHERE correo='".$id."'";
	    }
	    $r = $this->db->queryNoSelect($sql);
	    return $r;
	}

	public function enviarCorreo($email = '')
	{
		if ($email == "") {
			return false;
		}
	
		$data = $this->getUsuarioCorreo($email);
		if (empty($data)) {
			return false;
		}
	
		$id = Helper::encriptar($data["id"]);
		$nombre = $data["nombre"];
		$msg = $nombre . ", entra a la siguiente liga para cambiar tu clave de acceso al consultorio...<br>";
		$msg .= "<a href='" . RUTA . "login/cambiarclave/" . $id . "'>Cambiar tu clave de acceso</a>";
	
		// Incluye PHPMailer y configura
		require 'PHPMailer/Exception.php';
		require 'PHPMailer/PHPMailer.php';
		require 'PHPMailer/SMTP.php';
	
		$mail = new PHPMailer(true);
	
		try {
			// Configuración del servidor SMTP
			$mail->isSMTP();
			$mail->Host       = 'smtp.hostinger.com'; // Cambia a tu servidor SMTP
			$mail->SMTPAuth   = true;
			$mail->Username   = 'sqladmin24@estrategasrde.com.mx'; // Cambia al usuario SMTP
			$mail->Password   = 'AdminSQL#2024'; // Cambia a la contraseña SMTP
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Usa `ENCRYPTION_SMTPS` si usas SSL
			$mail->Port       = 587;
	
			// Configuración de destinatarios
			$mail->setFrom('sqladmin24@estrategasrde.com.mx', 'Sistema de citas');
			$mail->addAddress($email); // Destinatario principal
	
			// Contenido del correo
			$mail->isHTML(true);
			$mail->Subject = 'Cambio de clave de acceso';
			$mail->Body    = $msg;
			$mail->AltBody = strip_tags($msg); // Versión alternativa en texto plano
	
			// Enviar el correo
			$mail->send();
			return true;
		} catch (Exception $e) {
			// Manejar errores
			error_log("Error al enviar correo: " . $mail->ErrorInfo);
			return false;
		}
	}
	

	public function getUsuarioCorreo($email='',$admon=true)
	{
		if($admon){
			$sql = "SELECT * FROM admon WHERE correo='".$email."' and baja=0";	
		} else {
			$sql = "SELECT * FROM doctores WHERE correo='".$email."' and baja=0";
		}
		$data = $this->db->query($sql);
		return $data;
	}

	public function validarCorreo($email)
	{
		$sql ="SELECT * FROM admon WHERE correo='".$email."'";
		$data = $this->db->query($sql);
		return (count($data)==0)?false:true;
	}

	public function verificar($usuario, $clave){
	    $errores = array();
	    $sql = "SELECT * FROM admon WHERE correo='".$usuario."'";
	    $clave = hash_hmac("sha512", $clave, CLAVE);
	    $clave = substr($clave,0,200);
	    //consulta
	    $data = $this->db->query($sql);
	    //validacion
	    if (empty($data)) {
	      array_push($errores,"No existe ese usuario, favor de verificarlo.");
	    } else if($clave!=$data["clave"]){
	      array_push($errores,"Clave de acceso erronea, favor de verificar.");
	    }
	    return $errores;
	}

	public function verificarDoctor($usuario, $clave){
	    $errores = array();
	    $sql = "SELECT * FROM doctores WHERE correo='".$usuario."'";
	    if($clave!=""){
	    	$clave = hash_hmac("sha512", $clave, CLAVE);
	   	    $clave = substr($clave,0,200);
	    }
	    //consulta
	    $data = $this->db->query($sql);
	    //validacion
	    if (empty($data)) {
	      array_push($errores,"No existe ese usuario, favor de verificarlo.");
	    } else if($clave!="" && $clave!=$data["depto"]){
	      array_push($errores,"Clave de acceso erronea, favor de verificar.");
	    }
	    return $errores;
	}
}