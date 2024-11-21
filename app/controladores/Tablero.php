<?php
/**
 * Controlador Login
 */
class Tablero extends Controlador{
  private $modelo;
  private $admon;
  private $usuario;
  private $pagina;

  function __construct()
  {
    $sesion = new Sesion();
    if ($sesion->getLogin()) {
      $this->modelo = $this->modelo("TableroModelo");
      $this->admon = $sesion->getAdmon();
      $this->usuario = $sesion->getUsuario();
      $this->depurar();
    } else {
      header("location:".RUTA);
    }
  }

  function caratula(){
      //Leemos los datos de la tabla
      $dataDia = $this->modelo->getCitasProximas($this->admon,$this->usuario["id"]);

      //
      $datos = [
        "titulo" => "Próximas citas",
        "subtitulo" => "Próximas citas",
        "menu" => true,
        "admon" => $this->admon,
        "data" => $dataDia
      ];
      $this->vista("tableroCaratulaVista",$datos);
  }

  public function cambio($id=""){
    if($id=="") return;
    //Leemos los datos del registro del id
    $data = $this->modelo->getCitaId($id);
    $edoCita_array = $this->modelo->getLlaves("edoCita");
    $historial = $this->modelo->getHistorialId($id);
    //Vista Alta
    $datos = [
      "titulo" => "Modificar una cita",
      "subtitulo" => "Modificar una cita",
      "menu" => true,
      "admon" => $this->admon,
      "errores" => [],
      "historial" => $historial,
      "edoCita" => $edoCita_array,
      "data" => $data
    ];

    if (empty($historial)) {
      $this->vista("tableroModificaVista",$datos);
    } else {
      //
      //Leemos los archivos
      //
      $carpeta = 'doc/'.$id."/";
      if (file_exists($carpeta)) {
        $archivos_array  = scandir($carpeta);
      } else {
        $archivos_array  = [];
      }
      //
      //Enviamos los archivos
      //
      $datos["archivos"] = $archivos_array;
      $datos["titulo"] = "Tratamiento";
      $datos["subtitulo"] = "Tratamiento";
      $this->vista("tableroDiagnosticoVista",$datos);
    }
  }

  public function depurar()
  {
    $data = $this->modelo->getDepurar(3);
    // print "<pre>";
    // var_dump($data);
    // print "</pre>";
    // exit;
    for ($i=0; $i < count($data); $i++) { 
      if ($this->modelo->setInsertarHistorico($data[$i])) {
        if ($this->modelo->setElimitarHistorico($data[$i])==false) {
          $mensaje = "Error al borrar el registro en el histórico.";
          $url = "tablero";
          $this->mensajeResultado($titulo, $subtitulo, $mensaje, $url, "danger");
          break;
        }
      } else {
        $mensaje = "Error al insertar el registro en el histórico.";
        $url = "tablero";
        $this->mensajeResultado($titulo, $subtitulo, $mensaje, $url, "danger");
      }
    }
  }

  public function foto($idCita='', $archivo="")
  {
    if ($idCita=="") return false;
    //Vista archivo
    $datos = [
      "titulo" => "Visualizar un archivo",
      "subtitulo" => "Visualizar un archivo",
      "menu" => true,
      "admon" => $this->admon,
      "errores" => [],
      "data" => [
        "idCita" => $idCita,
        "archivo" => $archivo
      ]
    ];
    $this->vista("tableroFotoVista",$datos);
  }

  public function fotoBorrar()
  {
    if ($_SERVER['REQUEST_METHOD']=="POST") {
      $idCita = trim($_POST['idCita'] ?? "");
      $archivo = trim($_POST['archivo'] ?? "");
      //Vista archivo
      $datos = [
        "titulo" => "Confirmar borrar un archivo",
        "subtitulo" => "Confirmar borrar un archivo",
        "menu" => true,
        "admon" => $this->admon,
        "baja" => true,
        "errores" => [],
        "data" => [
          "idCita" => $idCita,
          "archivo" => $archivo
        ]
      ];
      $this->vista("tableroFotoVista",$datos);
    }
  }

  public function fotoBaja($idCita='', $archivo="")
  {
    if ($idCita=="") return false;
    $archivo = "doc/".$idCita."/".$archivo;
    if (file_exists($archivo)) {
      if(unlink($archivo)){
        $titulo = $subtitulo = "Borrar archivo";
        $mensaje = "El archivo se borró exitosamente.";
        $url = "tablero";
        $this->mensajeResultado($titulo, $subtitulo, $mensaje, $url, "success");
      } else {
        $titulo = $subtitulo = "Error";
        $mensaje = "El archivo no se borró exitosamente.";
        $url = "tablero";
        $this->mensajeResultado($titulo, $subtitulo, $mensaje, $url, "danger");
      }
    } else {
      $titulo = $subtitulo = "Error";
      $mensaje = "El archivo no se borró exitosamente.";
      $url = "tablero";
      $this->mensajeResultado($titulo, $subtitulo, $mensaje, $url, "danger");
    }
  }
  public function logout(){
    session_start();
    if (isset($_SESSION["usuario"])) {
      $sesion = new Sesion();
      $sesion->finalizarLogin();
    }
    header("location:".RUTA);
  }

  public function modificaCita(){
    if ($_SERVER['REQUEST_METHOD']=="POST") {
      //
      $id = trim($_POST['id'] ?? "");
      $edoCita = trim($_POST['edoCita'] ?? "");
      $observacion = Helper::cadena($_POST['observacion'] ?? "");
      //
      if ($id!="") {
        if ($edoCita==REALIZADA) {
          $data = $this->modelo->getCitaId($id);
          //Vista Alta
          $datos = [
            "titulo" => "Diagnóstico",
            "subtitulo" => "Diagnóstico",
            "menu" => true,
            "admon" => $this->admon,
            "errores" => [],
            "data" => $data
          ];
          $this->vista("tableroDiagnosticoVista",$datos);
        } else {
          $this->modelo->modifica($id,$edoCita,$observacion);
          header("location:".RUTA."tablero");
        }
      }
    }
  }

  public function modificaTratamiento()
  {
    $errores = [];
    if ($_SERVER['REQUEST_METHOD']=="POST") {
      //
      $id = trim($_POST['id'] ?? "");
      $costo = trim($_POST['costo'] ?? "");
      $tratamiento = Helper::cadena($_POST['tratamiento'] ?? "");
      $costo=Helper::numero($costo);
      $archivoTipo_array = $this->modelo->getLlaves("archivo");
      $tipos_array = [];
      foreach($archivoTipo_array as $archivo){
        array_push($tipos_array, $archivo["cadena"]);
      }
      //
      if ($tratamiento=="") {
        array_push($errores,"El tratamiento es requerido.");
      }
      //
      // Imagenes
      //
      if($_FILES['archivos']){
        $carpeta = 'doc/'.$id."/";
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }
        //
        $archivos_array = [];
        $archivos_num = count($_FILES['archivos']['name']);
        $archivos_keys = array_keys($_FILES['archivos']);
        $erroresCarga_array = [];

        for ($i=0; $i<$archivos_num; $i++) {
            foreach ($archivos_keys as $key) {
                $archivos_array[$i][$key] = $_FILES['archivos'][$key][$i];
            }
        }
        //
        foreach ($archivos_array as $archivo) {
          $nombre = Helper::archivo($archivo['name']);
          $extension =$archivo['type'];
          if ($archivo['size']<40*1024*1024) {
             if (in_array($extension, $tipos_array)) {
              //Subir el archivo
              if (is_uploaded_file($archivo['tmp_name'])) {
                //copiamos el archivo temporal
                copy($archivo['tmp_name'],$carpeta.$nombre);
              } 
            } else {
              array_push($erroresCarga_array,"No se cargó el archivo ".$nombre."<br>");
            }
          } else {
            array_push($erroresCarga_array,"No se cargó el archivo ".$nombre." por su tamaño<br>");
          }
        }
      }
      if (empty($errores)) {
        if(empty($this->modelo->getHistorialId($id))){
          if($this->modelo->setHistorial($id,$tratamiento,$costo)){
            $titulo = $subtitulo = "Inserción correcta";
            $mensaje = "El tratamiento se insertó exitosamente.";
            $mensaje.= "<br>".implode($erroresCarga_array);
            $url = "tablero";
            $this->mensajeResultado($titulo, $subtitulo, $mensaje, $url, "success");
          } else {
            $titulo = $subtitulo = "Inserción incorrecta";
            $mensaje = "El tratamiento no se insertó exitosamente. Inténtelo más tarde.";
            $mensaje.= "<br>".implode($erroresCarga_array);
            $url = "tablero";
            $this->mensajeResultado($titulo, $subtitulo, $mensaje, $url, "danger");
          }
        } else {
          if($this->modelo->updateHistorial($id,$tratamiento,$costo)){
            $titulo = $subtitulo = "Actualización correcta";
            $mensaje = "El tratamiento se actualizó exitosamente.";
            $mensaje.= "<br>".implode($erroresCarga_array);
            $url = "tablero";
            $this->mensajeResultado($titulo, $subtitulo, $mensaje, $url, "success");
          } else {
            $titulo = $subtitulo = "Actualización incorrecta";
            $mensaje = "El tratamiento no se actualizó exitosamente. Inténtelo más tarde.";
            $mensaje.= "<br>".implode($erroresCarga_array);
            $url = "tablero";
            $this->mensajeResultado($titulo, $subtitulo, $mensaje, $url, "danger");
          }
        }
      } else {
        $data = $this->modelo->getCitaId($id);
        //Vista Alta
        $datos = [
          "titulo" => "Diagnóstico",
          "subtitulo" => "Diagnóstico",
          "menu" => true,
          "admon" => $this->admon,
          "errores" => $errores,
          "data" => $data
        ];
        $this->vista("tableroDiagnosticoVista",$datos);
      }
    }
  }

  public function perfil(){
    $errores = [];
    if ($_SERVER['REQUEST_METHOD']=="POST") {
      //
      $id = $_POST['id'] ?? "";
      $nombre = $_POST['nombre'] ?? "";
      $correo = $_POST['correo'] ?? "";
      $clave = $_POST['clave'] ?? "";
      $clave1 = $_POST['nuevaClave'] ?? "";
      $clave2 = $_POST['confirmacion'] ?? "";

      if($id==""){
        array_push($errores,"Error en el identificador del usuario");
      }

      if($nombre==""){
        array_push($errores,"El nombre es un valor requerido");
      }

      if($correo==""){
        array_push($errores,"El correo electrónico es requerido");
      }

      if($clave=="xxxxxxxxxxxx"){
        $clave1 = $clave2 = "";
      } else {
        if($this->modelo->verificar($id,$clave)){
          if ($clave1=="") {
            array_push($errores, "La nueva clave de acceso es requerida");
          }
          if ($clave2=="") {
            array_push($errores, "La clave de acceso de verificación es requerida");
          }
          if ($clave1!=$clave2) {
            array_push($errores, "Las nuevas claves de acceso no coinciden");
          }
        } else {       
          array_push($errores, "Algún dato es erróneo, favor de verificar.");
        } 
      }
      if (empty($errores)) {
        //Iniciamos sesión
        if($this->modelo->setUsuarioDoctor($id, $nombre, $correo, $clave1)){
          $sesion = new Sesion();
          $data = $this->modelo->getUsuarioId($id);
          $sesion->iniciarLogin($data);
          //
          header("location:".RUTA."tablero");
        } else {
          print "Error al actualizar los datos";
          exit(0);
        }
      }      
    }

    //Vista Alta
    $datos = [
      "titulo" => "Perfil del usuario",
      "subtitulo" => "Perfil del usuario",
      "menu" => true,
      "admon" => $this->admon,
      "activo" => 'perfil',
      "errores" => $errores,
      "data" => $this->usuario
    ];
    if ($this->admon) {
      $this->vista("tableroPerfilVista",$datos);
    } else {
      $this->vista("doctoresPerfilVista",$datos);
    }
  }

  public function perfilDoctor(){
    $errores = [];
    if ($_SERVER['REQUEST_METHOD']=="POST") {
      //
      $id = $_POST['id'] ?? "";
      $nombre = Helper::cadena($_POST['nombre'] ?? "");
      $apellidos = Helper::cadena($_POST['apellidos'] ?? "");
      $correo = $_POST['correo'] ?? "";
      $direccion = Helper::cadena($_POST['direccion'] ?? "");
      $telefono = Helper::cadena($_POST['telefono'] ?? "");
      $perfil = Helper::cadena($_POST['perfil'] ?? "");
      $clave = $_POST['clave'] ?? "";
      $clave1 = $_POST['clave1'] ?? "";
      $clave2 = $_POST['clave2'] ?? "";

      if($id==""){
        array_push($errores,"Error en el identificador del usuario.");
      }

      if($nombre==""){
        array_push($errores,"El nombre es un valor requerido.");
      }

      if($correo==""){
        array_push($errores,"El correo electrónico es requerido.");
      }

      if(Helper::correo($correo)==false){
        array_push($errores,"El correo electrónico no es correcto.");
      }

      if($clave==str_repeat("x",12)){
        $clave1 = $clave2 = "";
      } else {
        if($this->modelo->verificarDoctor($id,$clave)){
          if ($clave1=="") {
            array_push($errores, "La nueva clave de acceso es requerida.");
          }
          if ($clave2=="") {
            array_push($errores, "La clave de acceso de verificación es requerida.");
          }
          if ($clave1!=$clave2) {
            array_push($errores, "Las nuevas claves de acceso no coinciden.");
          }
        } else {       
          array_push($errores, "Algún dato es erróneo, favor de verificar.");
        } 
      }
      if (empty($errores)) {
        $data = [
          "id" => $id,
          "nombre" => $nombre,
          "apellidos" => $apellidos,
          "correo" => $correo,
          "direccion" => $direccion,
          "telefono" => $telefono,
          "perfil" => $perfil,
          "clave" => $clave1
        ];
        //Actualizamos sesión
        if($this->modelo->setUsuarioDoctor($data)){
          $sesion = new Sesion();
          $data = $this->modelo->getUsuarioIdDoctor($id);
          $sesion->iniciarLogin($data,false);
          //
          header("location:".RUTA."tablero");
        } else {
          print "Error al actualizar los datos";
          exit(0);
        }
      }      
    }

    //Vista Alta
    $datos = [
      "titulo" => "Perfil del usuario",
      "subtitulo" => "Perfil del usuario",
      "menu" => true,
      "admon" => $this->admon,
      "activo" => 'perfil',
      "errores" => $errores,
      "data" => $this->usuario
    ];
    if ($this->admon) {
      $this->vista("tableroPerfilVista",$datos);
    } else {
      $this->vista("doctoresPerfilVista",$datos);
    }
  }
}
?>