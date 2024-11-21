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
    <th>Paciente</th>
    <th>Doctor</th>
    <th>Fecha</th>
    <th>Horario</th>
    <th>Estado</th>
  </tr>
  </thead>
  <tbody>
    <?php
    for($i=0; $i<count($datos['data']); $i++){
      print "<tr>";
      $paciente = substr($datos["data"][$i]['pacienteApellidos'].", ".$datos["data"][$i]['pacienteNombre'],0,30);
      $doctor = substr($datos["data"][$i]['doctorApellidos'].", ".$datos["data"][$i]['doctorNombre'],0,30);
      $horario = substr($datos["data"][$i]["horario"],0,5);
      print "<td class='text-left'>".$paciente."</td>";
      print "<td class='text-left'>".$doctor."</td>";
      print "<td class='text-left'>".$datos["data"][$i]["fecha"]."</td>";
      print "<td class='text-left'>".$horario."</td>";
     
      if ($datos["data"][$i]["edoCita"]==PENDIENTE) {
         //Pendiente de confirmar
        print "<td><a href='".RUTA."tablero/cambio/".$datos["data"][$i]["id"]."' class='btn btn-info'>".$datos["data"][$i]["estadoCita"]."</a></td>";
      } else  if ($datos["data"][$i]["edoCita"]==CONFIRMADA){
        print "<td><a href='".RUTA."tablero/cambio/".$datos["data"][$i]["id"]."' class='btn btn-success'>".$datos["data"][$i]["estadoCita"]."</a></td>";
      } else  if ($datos["data"][$i]["edoCita"]==CANCELADA){
        print "<td><a href='".RUTA."tablero/cambio/".$datos["data"][$i]["id"]."' class='btn btn-danger'>".$datos["data"][$i]["estadoCita"]."</a></td>";
      } else {
        print "<td><a href='".RUTA."tablero/cambio/".$datos["data"][$i]["id"]."' class='btn btn-warning'>".$datos["data"][$i]["estadoCita"]."</a></td>";
      }
      print "</tr>";
    }
    ?>
  </tbody>
  </table>
  
</div><!--card-->
<?php include_once("piepagina.php"); ?>