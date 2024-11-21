<?php include_once("encabezado.php"); ?>
<h1 class="text-center">
  <?php
  if (isset($datos["subtitulo"])) {
    print $datos["subtitulo"];
  }
  ?>
</h1>
<div class="card p-4 bg-light">
  <form enctype="multipart/form-data" action="<?php print RUTA; ?>citas/altaCita/" method="POST">

    <div class="form-group text-left">
      <h3>Paciente: <?php print $datos['paciente'][0]['apellidos'].", ".$datos['paciente'][0]['nombre']." (".$datos['paciente'][0]['telefono'].")"; ?></h3>
    </div>
    <div class="form-group text-left">
      <h3>Doctor: <?php print $datos['doctor'][0]['apellidos'].", ".$datos['doctor'][0]['nombre']." (".$datos['doctor'][0]['perfil'].")"; ?></h3>
    </div>

    <div class="form-group text-left">
      <p>Fecha de la cita: 
        <?php print $datos['data'][3].', '.$datos['data'][4]; ?>
      </p>
    </div>

    <div class="form-group text-left">
      <label for="observacion">Observación:</label>
      <input type="text" name="observacion" id="observacion" class="form-control"
      placeholder="Observación de la cita." value="">
    </div>

    <input type="hidden" name="doctor" id="doctor" value="
      <?php print ($datos['data'][1])??'';?>
      ">

    <input type="hidden" name="paciente" id="paciente" value="
      <?php print ($datos['data'][2])??'';?>
      ">
      
    <input type="hidden" name="fecha" id="fecha" value="
      <?php print ($datos['data'][3])??'';?>
      ">
    <input type="hidden" name="hora" id="hora" value="
      <?php print ($datos['data'][4])??'';?>
      ">

    <input type="hidden" name="id" id="id" value="
      <?php print ($datos['data'][5])??'';?>
      ">

    <input type="hidden" name="edoCita" id="edoCita" value="
      <?php print ($datos['data'][6])??'';?>
      ">

    <?php
    print '<div class="form-group text-left mt-3">';
    if($datos['data'][5]==""){
      print '<h2>¿Desea crear la cita?</h2>';
      print '<input type="hidden" name="edoCita" id="edoCita" value="1">';
    } else {
      print '<label for="confirma">Confirmada:&nbsp;</label>';
      print '<input type="checkbox" name="confirma" id="confirma" ';
      if (isset($datos["data"][6]) && $datos["data"][6]==2) {
        print " checked ";
      }
      print ">";
    }
    print '</div>';
    ?>
    <input type="submit" value="Confirmar la cita" class="btn btn-success mt-3">
    <a href="<?php print RUTA; ?>citas" class="btn btn-info mt-3">Regresar</a>
  </form>
</div><!--card-->
<?php include_once("piepagina.php"); ?>