<?php include_once("encabezado.php"); ?>
<h1 class="text-center">
  <?php
  if (isset($datos["subtitulo"])) {
    print $datos["subtitulo"];
  }
  ?>
</h1>
<div class="card p-4 bg-light">
  <form enctype="multipart/form-data" action="" method="POST">

    <div class="form-group text-left">
      <h3>Paciente: <?php print $datos['data']['pacienteApellidos'].', '.$datos['data']['pacienteNombre']; ?></h3>
    </div>
    <div class="form-group text-left">
      <h3>Doctor: <?php print $datos['data']['doctorNombre'].', '.$datos['data']['doctorApellidos'].' ('.$datos['data']['doctorPerfil'].')'; ?></h3>
    </div>

    <div class="form-group text-left">
      <h3>Fecha de la cita: 
        <?php print $datos['data']['fecha'].', '.$datos['data']['horario']; ?>
      </h3>
    </div>

    <div class="form-group text-left">
      <h3>Observación: <?php print $datos['data']['observacion']; ?></h3>
    </div>

    <div class="form-group text-left">
      <h3>Tratamiento/Diagnóstico:</h3>
      <textarea name="tratamiento" class="form-control text-left" disabled><?php if(isset($datos['data']['tratamiento'])){print trim($datos['data']['tratamiento']);}else{print "";}?></textarea>
    </div>

    <div class="form-group text-left">
      <h3>Costo:</h3>
      <input type="text" name="costo" disabled class="form-control text-left" value="<?php if(isset($datos['data']['costo'])){print ltrim($datos['data']['costo']);}else{print "";}?>"/>
    </div>

    <?php
    if (isset($datos["archivos"]) && count($datos["archivos"])>0) {
      print '<table class="table table-striped" width="100%">';
      print '<thead>';
      print '<tr>';
      print '<th>Imagen</th>';
      print '<th>Nombre</th>';
      print '<th>Ancho</th>';
      print '<th>Alto</th>';
      print '<th>Tamaño</th>';
      print '</tr>';
      print '</thead>';
      print '<tbody>';
      for ($i=0; $i < count($datos["archivos"]); $i++) {
        if ($datos['archivos'][$i]!="." && $datos['archivos'][$i]!="..") {
          $archivo = RUTA."public/doc/".$datos['data']["id"]."/".$datos['archivos'][$i];
          $info = getimagesize("doc/".$datos['data']["id"]."/".$datos['archivos'][$i]);
          $size = filesize("doc/".$datos['data']["id"]."/".$datos['archivos'][$i]);
          print "<tr>";
          print "<td>";
          print "<a href='".RUTA."historial/foto/".$datos['data']["id"]."/".$datos['archivos'][$i]."'>";
          print "<img src='".$archivo."' ";
          print "class='img-responsive' style='height:100px;' ";
          print "alt='".$datos['archivos'][$i]."'/>";
          print "</a>";
          print "</td>";
          print "<td>".$datos['archivos'][$i]."</td>";
          print "<td>".$info[0]."</td>";
          print "<td>".$info[1]."</td>";
          print "<td>".Helper::medidaSize($size)."</td>";
          print "<tr>";
        }
      }
      print '</tbody>';
      print "</table>";
    }
    ?>
    <a href="<?php print RUTA; ?>historial" class="btn btn-info">Regresar</a>
  </form>
</div><!--card-->
<?php include_once("piepagina.php"); ?>