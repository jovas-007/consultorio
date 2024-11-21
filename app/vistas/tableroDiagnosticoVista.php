<?php include_once("encabezado.php"); ?>
<script src="<?php print RUTA; ?>js/tableroDiagnosticoVista.js"></script>
<h1 class="text-center">
  <?php
  if (isset($datos["subtitulo"])) {
    print $datos["subtitulo"];
  }
  ?>
</h1>
<div class="card p-4 bg-light">
  <form enctype="multipart/form-data" action="<?php print RUTA; ?>tablero/modificaTratamiento/" method="POST">
    <input type="hidden" name="id" id="id" value="<?php print $datos['data']["id"];?>">

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
      <h3>Observación: <?php
        print $datos['data']['observacion'];
        ?></h3>
    </div>

    <div class="form-group text-left">
      <h3>Tratamiento/Diagnóstico:</h3>
      <textarea name="tratamiento" class="form-control text-left"><?php if(isset($datos['historial']['tratamiento'])){print trim($datos['historial']['tratamiento']);}else{print "";}?></textarea>
    </div>

     <div class="form-group text-left">
      <h3>Costo:</h3>
      <input type="text" name="costo" class="form-control text-left" value="<?php if(isset($datos['historial']['costo'])){print ltrim($datos['historial']['costo']);}else{print "";}?>"/>
    </div>

    <div class="form-group text-left">
      <h3>Fotos:</h3>
      <input type="file" name="archivos[]" id="archivos" class="form-control" multiple accept=".jpg, .jpeg, .gif, .png" />
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
          print "<a href='".RUTA."tablero/foto/".$datos['data']["id"]."/".$datos['archivos'][$i]."'>";
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

    <input type="submit" value="Modificar estado de la cita" class="btn btn-success">
    <a href="<?php print RUTA; ?>tablero" class="btn btn-info">Regresar</a>
  </form>
</div><!--card-->
<?php include_once("piepagina.php"); ?>