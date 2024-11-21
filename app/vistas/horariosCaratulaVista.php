<?php include_once("encabezado.php"); ?>
<h1 class="text-center"><?php
  if (isset($datos["subtitulo"])) {
    print $datos["subtitulo"];
  }
  ?>
</h1>
<div class="card p-4 bg-light">
  <table class="table table-striped" width="100%">
  <thead>
    <tr>
    <th>Doctor</th>
    <th>Día</th>
    <th>Hora inicio</th>
    <th>Hora final</th>
    <th>Duración</th>
    <th>Modificar</th>
    <th>Borrar</th>
  </tr>
  </thead>
  <tbody>
    <?php
    for($i=0; $i<count($datos['data']); $i++){
      $id = $datos["data"][$i]["id"];
      $dr = $datos["data"][$i]["apellidos"].", ".$datos["data"][$i]["nombre"];
      print "<tr>";
      print "<td>".substr($dr,0,40)."</td>";
      print "<td class='text-left'>".$datos["data"][$i]['cadena']."</td>";
      print "<td class='text-left'>".$datos["data"][$i]["inicio"]."</td>";
      print "<td class='text-left'>".$datos["data"][$i]["fin"]."</td>";
      print "<td class='text-left'>".$datos["data"][$i]["duracion"]." min.</td>";
      //
      print "<td><a href='".RUTA."horarios/cambio/".$id."' class='btn btn-info'>Modificar</a></td>";
      //
      print "<td><a href='".RUTA."horarios/baja/".$id."' class='btn btn-danger'>Borrar</a></td>";
      print "</tr>";
    }
    ?>
  </tbody>
  </table>
</div><!--card-->
<a href="<?php print RUTA; ?>horarios/alta" class="btn btn-success">
  Dar de alta un horario</a>
<?php include_once("piepagina.php"); ?>