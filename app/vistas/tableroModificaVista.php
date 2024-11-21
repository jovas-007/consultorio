<?php include_once("encabezado.php"); ?>
<h1 class="text-center">
  <?php
  if (isset($datos["subtitulo"])) {
    print $datos["subtitulo"];
  }
  ?>
</h1>
<div class="card p-4 bg-light">
  <form enctype="multipart/form-data" action="<?php print RUTA; ?>tablero/modificaCita/" method="POST">
    <input type="hidden" name="id" id="id" value="
      <?php print $datos['data']["id"];?>">

    <input type="hidden" name="idDoctor" id="idDoctor" value="
      <?php print $datos['data']["idDoctor"];?>">

    <input type="hidden" name="idPaciente" id="idPaciente" value="
      <?php print $datos['data']["idPaciente"];?>">

    <div class="form-group text-left">
      <h3>Paciente: <?php print $datos['data']['pacienteApellidos'].', '.$datos['data']['pacienteNombre']." (".$datos['data']["telefono"].")"; ?></h3>
    </div>
    <div class="form-group text-left">
      <h3>Doctor: <?php print $datos['data']['doctorNombre'].', '.$datos['data']['doctorApellidos'].' ('.$datos['data']['doctorPerfil'].')'; ?></h3>
    </div>

    <div class="form-group text-left">
      <h3>Fecha de la cita: 
        <?php
        print $datos['data']['fecha'].', '.$datos['data']['horario'];
        ?>
      </h3>
    </div>

    <div class="form-group text-left">
      <h3>Observación: </h3>
      <input type="text" name="observacion" id="observacion" class="form-control" value="<?php
        print $datos['data']['observacion'];
        ?>">
    </div>

    <div class="form-group text-left">
      <h3>Estado de la cita: 
        <select class="form-control" name="edoCita" id="edoCita">
        <?php
          for ($i=0; $i < count($datos["edoCita"]); $i++) { 
            print "<option value='".$datos["edoCita"][$i]["indice"]."'";
              if(isset($datos["data"]["edoCita"]) && $datos["data"]["edoCita"]==$datos["edoCita"][$i]["indice"]){
                print " selected ";
              }
            print ">".$datos["edoCita"][$i]["cadena"]."</option>";
          } 
        ?>
      </select>
      </h3>
    </div>

    <input type="submit" value="Modificar estado de la cita" class="btn btn-success">
    <a href="<?php print RUTA; ?>tablero" class="btn btn-info">Regresar</a>
  </form>
</div><!--card-->
<?php include_once("piepagina.php"); ?>