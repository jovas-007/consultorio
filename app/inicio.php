<?php  
/* Clases inciales */
define("RUTA", "/consultorio/");
define("CLAVE","mimamamemima");
define("LLAVE","Enelaguaclaraquebrotaenlafuenteunlindopescadosalederepente");
define('LIBRE',0);
define('PENDIENTE',1);
define('CONFIRMADA',2);
define('REALIZADA',3);
define('CANCELADA',4);
define('TAMANO_PAGINA',6);
define('PAGINAS_MAXIMAS',4);
require_once("libs/Sesion.php");
require_once("libs/Helper.php");
require_once("libs/Config.php");
require_once("libs/MySQLdb.php");
require_once("libs/Controlador.php");
require_once("libs/Control.php");
require_once("libs/Llaves.php");
new Config("development");
?>