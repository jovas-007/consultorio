<?php  
/**
 * Controlador login
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require_once __DIR__ . '/../modelos/LoginModelo.php';
class Citas extends Controlador
{
	private $modelo;
  private $admon;
	
	function __construct()
	{
    //Creamos sesion
    $sesion = new Sesion();
    if ($sesion->getLogin()) {
		  $this->modelo = $this->modelo("CitasModelo");
      $this->admon = $sesion->getAdmon();
    } else {
      header("location:".RUTA);
    }
	}

  public function caratula(){

      //Leemos los datos de la tabla
      $data = $this->modelo->getTabla();;

      //Vista caratula
      $datos = [
        "titulo" => "Citas",
        "subtitulo" => "Citas",
        "menu" => true,
        "admon" => $this->admon,
        "activo" => 'citas',
        "data" => $data
      ];
      $this->vista("citasCaratulaVista",$datos);
  }

  public function alta($errores = [],$data = []){
    //Definir los arreglos
    $pacientes_array = $this->modelo->getPacientes();
    $doctores_array = $this->modelo->getDoctores();

    //Vista Alta
    $datos = [
      "titulo" => "Alta de una cita",
      "subtitulo" => "Alta de una cita",
      "menu" => true,
      "admon" => $this->admon,
      "activo" => "citas",
      "errores" => $errores,
      "pacientes" => $pacientes_array,
      "doctores" => $doctores_array,
      "data" => $data
    ];

    $this->vista("citasAltaVista",$datos);
  }

  public function altaCita()
  {
      $idDoctor = trim($_POST['doctor'] ?? "");
      $idPaciente = trim($_POST['paciente'] ?? "");
      $fecha = trim($_POST['fecha'] ?? "");
      $hora = trim($_POST['hora'] ?? "");
      $observacion = Helper::cadena($_POST['observacion']);
      $id = trim($_POST['id'] ?? "");
      $confirma = trim($_POST['confirma'] ?? "");
  
      $edoCita = ($confirma == "on") ? "2" : "1";
  
      $data = [
          "doctor" => $idDoctor,
          "paciente" => $idPaciente,
          "fecha" => $fecha,
          "hora" => $hora,
          "observacion" => $observacion,
          "edoCita" => $edoCita,
          "id" => $id
      ];
  
      if ($id == "") {
          // Alta de nueva cita
          if ($this->modelo->alta($data)) {
              // Enviar correo de notificación
              $this->enviarCorreoNotificacion($idPaciente, $idDoctor, $fecha, $hora, $observacion);
              // Mostrar alerta antes de redirigir
              echo "<script>alert('Cita Registrada');</script>";
              echo "<script>window.location.href='" . RUTA . "citas';</script>";
              exit(); // Asegurarse de detener la ejecución después de redirigir
              header("location:" . RUTA . "citas");
          }
      } else {
          // Modificación de cita existente
          if ($this->modelo->modifica($data)) {
              header("location:" . RUTA . "citas");
          }
      }
  }
  
  private function enviarCorreoNotificacion($idPaciente, $idDoctor, $fecha, $hora, $observacion)
  {
      // Recuperar datos del paciente y doctor
      $paciente = $this->modelo->getPacienteId($idPaciente);
      $doctor = $this->modelo->getDoctorId($idDoctor);
  
      if (!$paciente || !$doctor) {
          error_log("Error: Paciente o doctor no encontrados.");
          return;
      }
  
      $nombrePaciente = $paciente[0]['nombre'] ?? "Paciente no identificado";
      $nombreDoctor = $doctor[0]['nombre'] ?? "Doctor no identificado";
      // Incluye PHPMailer y configura
      require 'PHPMailer/Exception.php';
      require 'PHPMailer/PHPMailer.php';
      require 'PHPMailer/SMTP.php';

      // Crear mensaje
      $msg = "Se ha registrado una nueva cita en el sistema:<br><br>";
      $msg .= "<b>Paciente:</b> $nombrePaciente<br>";
      $msg .= "<b>Doctor:</b> $nombreDoctor<br>";
      $msg .= "<b>Fecha:</b> $fecha<br>";
      $msg .= "<b>Hora:</b> $hora<br>";
      $msg .= "<b>Observación:</b> $observacion<br><br>";
      $msg .= "Por favor, revisa el sistema para más detalles.";
  
      $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
  
      try {
          // Configuración SMTP
          $mail->isSMTP();
          $mail->Host       = 'smtp.hostinger.com'; // Cambia al servidor SMTP que uses
          $mail->SMTPAuth   = true;
          $mail->Username   = 'sqladmin24@estrategasrde.com.mx'; // Cambia al correo configurado
          $mail->Password   = 'AdminSQL#2024'; // Cambia a la contraseña correcta
          $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
          $mail->Port       = 587;
  
          // Configuración del correo
          $mail->setFrom('sqladmin24@estrategasrde.com.mx', 'Consultorio');
          $mail->addAddress('tomasoscarcr7@gmail.com'); // Correo fijo del administrador
          $mail->isHTML(true);
          $mail->Subject = 'Nueva cita registrada';
          $mail->Body    = $msg;
          $mail->AltBody = strip_tags($msg); // Versión en texto plano
  
          // Enviar correo
          $mail->send();
          error_log("Correo de notificación enviado a tomasoscarcr7@gmail.com.");
      } catch (\PHPMailer\PHPMailer\Exception $e) {
          error_log("Error al enviar correo: " . $mail->ErrorInfo);
      }
  }
  




  public function baja($id=""){
    if ($id=="") {
      return false;
    }
    //Leemos los datos del registro del id
    $data = $this->modelo->getId($id);
    $pacientes_array = $this->modelo->getPacientes();
    $doctores_array = $this->modelo->getDoctores();

    //Vista baja
    $datos = [
      "titulo" => "Baja de una cita",
      "subtitulo" => "Baja de una cita",
      "menu" => true,
      "admon" => $this->admon,
      "errores" => [],
      "data" => $data,
      "activo" => "citas",
      "pacientes" => $pacientes_array,
      "doctores" => $doctores_array,
      "baja" => true
    ];
    $this->vista("citasAltaVista",$datos);
  }

  public function bajaLogica($id='')
  {
    if ($id!="") {
      if($this->modelo->bajaLogica($id)){
        header("location:".RUTA."citas");
      }
    }
  }

  public function cambio($id=""){
    if($id=="") return;
    //Leemos los datos del registro del id
    $data = $this->modelo->getId($id);
    $pacientes_array = $this->modelo->getPacientes();
    $doctores_array = $this->modelo->getDoctores();

    //Vista Alta
    $datos = [
      "titulo" => "Modificar una cita",
      "subtitulo" => "Modificar una cita",
      "menu" => true,
      "admon" => $this->admon,
      "errores" => [],
      "activo" => "citas",
      "pacientes" => $pacientes_array,
      "doctores" => $doctores_array,
      "data" => $data
    ];
    $this->vista("citasAltaVista",$datos);
  }

public function verificarHorario(){
    if ($_SERVER['REQUEST_METHOD']=="POST") {
      //
      $data = array();
      $errores = array();
      $edoCita_array = $this->modelo->getLlaves("edoCita");

      $id = $_POST['id'] ?? "";
      $idDoctor = $_POST['doctor'] ?? "";
      $idPaciente = $_POST['paciente'] ?? "";
      $fecha = $_POST['fecha'] ?? "";
      $horario = $_POST['horario'] ?? "";
      $edoCita = $_POST['edoCita'] ?? "";

      if($idDoctor=="void" || $idDoctor==""){
        array_push($errores,"Debes de seleccionar un doctor");
      }

      if($idPaciente=="void" || $idPaciente==""){
        array_push($errores,"Debes de seleccionar un paciente");
      }

      if($fecha==""){
        array_push($errores,"Debes de seleccionar una fecha");
      }
      //
      //Verifica la fecha
      //
      $fecha_cita = strtotime($fecha);
      $fecha_actual = strtotime(date("d-m-Y 00:00:00",time()));
      if ($fecha_cita<$fecha_actual) {
        array_push($errores,"La fecha de la cita no puede ser menor a la actual");
      } else {
        //
        //Calcular el día de la semana
        //
        $fecha_array = explode("-", $fecha);
        $dia = date("N",mktime(0,0,0,$fecha_array[1],$fecha_array[2],$fecha_array[0]));
        $dia--;
        $horario_array = $this->modelo->getHorarioDoctor($idDoctor, $dia);
        if(empty($horario_array)){
          array_push($errores,"El doctor no tiene agenda para ese día");
        }
      }
      //
      if(empty($errores)){
        //
        //Leemos los catálogos
        //
        $pacientes_array = $this->modelo->getPacienteId($idPaciente);
        $doctores_array = $this->modelo->getDoctorId($idDoctor);
        $citas_array = $this->modelo->getCitas($idDoctor, $fecha);
        $diasSemana_array = $this->modelo->getLlaves("diaSemana");
        //
        //Analizamos los horarios de inicio y fin del doctor
        //
        $inicio_array = explode(":",$horario_array[0]["inicio"]);
        $fin_array = explode(":",$horario_array[0]["fin"]);
        $duracion = $horario_array[0]["duracion"];
        //
        //Crea agenda
        //
        $agenda_array = [];
        do {
          array_push($agenda_array,[$inicio_array[0],$inicio_array[1],0]);
          $inicio_array[1]+=$duracion;
          if ($inicio_array[1]>=60) {
            $inicio_array[1]=0;
            $inicio_array[0]++;
          }
          if ($inicio_array[0]>=$fin_array[0] && $inicio_array[1]>=$fin_array[1]) {
            array_push($agenda_array,[$inicio_array[0],$inicio_array[1],0]);
            break;
          }
        } while (true);

        //
        //Cruzamos agenda vs citas
        //
        for ($ii=0; $ii<count($agenda_array); $ii++) {
          for ($i=0; $i < count($citas_array); $i++) { 
            $h = explode(":",$citas_array[$i]["horario"]);
            if ($agenda_array[$ii][0]==$h[0] && $agenda_array[$ii][1]==$h[1]) {
              $agenda_array[$ii][2] = $citas_array[$i]["edoCita"];
            }
          }
        }
        //
        //Vista Alta
        //
        $diaCadena = $diasSemana_array[$dia]["cadena"];
        $datos = [
          "titulo" => "Agenda del día",
          "subtitulo" => "Agenda del día",
          "menu" => true,
          "admon" => $this->admon,
          "activo" => "citas",
          "errores" => $errores,
          "agenda" => $agenda_array,
          "doctor" =>  $doctores_array,
          "paciente" => $pacientes_array,
          "edoCita" => $edoCita_array,
          "data" => [$dia,$idDoctor,$idPaciente,$fecha,$diaCadena,$id,$edoCita]
        ];
        $this->vista("citasAgendaVista",$datos);
      } else {
        $data = [
        "id" => $id,
        "idDoctor" => $idDoctor,
        "idPaciente" => $idPaciente,
        "fecha" => $fecha
        ];
        $this->alta($errores,$data);
      }
    }
  }

  public function verificarCita($dia,$doctor,$paciente,$fecha,$hora,$id,$edoCita="1"){
    //
    $errores = [];
    $paciente_array = $this->modelo->getPacienteId($paciente);
    $doctor_array = $this->modelo->getDoctorId($doctor);
    $edoCita_array = $this->modelo->getLlaves("edoCita");
    //
    //Vista Alta
    //
    $datos = [
    "titulo" => "Confirma cita",
    "subtitulo" => "Confirma cita",
    "activo" => "citas",
    "menu" => true,
    "admon" => $this->admon,
    "errores" => $errores,
    "doctor" =>  $doctor_array,
    "paciente" => $paciente_array,
    "edoCita" => $edoCita_array,
    "data" => [$dia,$doctor,$paciente,$fecha,$hora,$id,$edoCita]
    ];
    $this->vista("citasConfirmarVista",$datos);
  }
}













 


 



