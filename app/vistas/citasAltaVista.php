<?php include_once("encabezado.php"); ?>
<script src="<?php print RUTA; ?>js/citasAltaVista.js"></script>
<h1 class="text-center">
  <?php
  if (isset($datos["subtitulo"])) {
    print $datos["subtitulo"];
  }
  ?>
</h1>
<div class="card p-4 bg-light">
  <form enctype="multipart/form-data" action="<?php print RUTA; ?>citas/verificarHorario/" method="POST">

    <div class="form-group text-left">
      <label for="doctor">* Doctor:</label>
      <select class="form-control" name="doctor" id="doctor" 
      <?php
      if (isset($datos["baja"])) {
        print " disabled ";
      }
      ?>
      >
        <option value="void">---Selecciona un doctor---</option>
        <?php
          for ($i=0; $i < count($datos["doctores"]); $i++) { 
            print "<option value='".$datos["doctores"][$i]["id"]."'";
              if(isset($datos["data"]["idDoctor"]) && $datos["data"]["idDoctor"]==$datos["doctores"][$i]["id"]){
                print " selected ";
              }
            print ">".$datos["doctores"][$i]["apellidos"].", ".$datos["doctores"][$i]["nombre"]." (".$datos["doctores"][$i]["perfil"].")</option>";
          } 
        ?>
      </select>
    </div>

    <div class="form-group text-left">
      <label for="pacientes">* Paciente:</label>
      <select class="form-control" name="paciente" id="paciente" 
      <?php
      if (isset($datos["baja"])) {
        print " disabled ";
      }
      ?>
      >
        <option value="void">---Selecciona un paciente---</option>
        <?php
          for ($i=0; $i < count($datos["pacientes"]); $i++) { 
            print "<option value='".$datos["pacientes"][$i]["id"]."'";
              if(isset($datos["data"]["idPaciente"]) && $datos["data"]["idPaciente"]==$datos["pacientes"][$i]["id"]){
                print " selected ";
              }
            print ">".$datos["pacientes"][$i]["apellidos"].", ".$datos["pacientes"][$i]["nombre"]."</option>";
          } 
        ?>
      </select>
    </div> 

    <div class="form-group text-left">
      <label for="fecha">* Fecha de la cita:</label>
      <input type="date" name="fecha" id="fecha" class="form-control"
      placeholder="Escribe la fecha de la cita." required style="width:10rem;"
      value="<?php 
      print isset($datos['data']['fecha'])?$datos['data']['fecha']:''; 
      ?>"
      <?php
      if (isset($datos["baja"])) {
        print " disabled ";
      }
      ?>
      >
    </div>
    


    <div class="form-group text-left">
      <input type="hidden" name="id" id="id" value="
      <?php
        if (isset($datos['data']['id'])) {
          print $datos['data']['id'];
        } else {
          print "";
        }
      ?>
      ">
      <input type="hidden" name="edoCita" id="edoCita" value="
      <?php
        if (isset($datos['data']['edoCita'])) {
          print $datos['data']['edoCita'];
        } else {
          print "";
        }
      ?>
      ">
      <?php
      if (isset($datos["baja"])) { ?>
        <a href="<?php print RUTA; ?>citas/bajaLogica/<?php print $datos['data']['id']; ?>" class="btn btn-danger">Borrar</a>
        <a href="<?php print RUTA; ?>citas" class="btn btn-danger">Regresar</a>
        <p><b>Advertencia: una vez borrado el registro, no podrá recuperar la información</b></p>
      <?php } else { ?> 
      <input type="submit" value="Enviar" class="btn btn-success">
      <a href="<?php print RUTA; ?>citas" class="btn btn-info">Regresar</a>
    <?php } ?> 
    </div>
  </form>
</div><!--card-->
<?php include_once("piepagina.php"); ?>