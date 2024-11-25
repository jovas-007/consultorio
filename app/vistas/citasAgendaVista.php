<?php include_once("encabezado.php"); ?>
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
      <p>Paciente: <?php print $datos['paciente'][0]['nombre'].', '.$datos['paciente'][0]['apellidos']; ?></p>
    </div>
    <div class="form-group text-left">
      <p>Doctor: <?php print $datos['doctor'][0]['nombre'].', '.$datos['doctor'][0]['apellidos'].' ('.$datos['doctor'][0]['perfil'].')'; ?></p>
    </div>

    <div class="form-group text-left">
      <p>Fecha de la cita: 
        <?php print $datos['data'][3].', '.$datos['data'][4]; ?>
      </p>
    </div>

    <div class="form-group text-left">
      <table>
      <?php
        $ajuste = count($datos["agenda"])%2;
        $numCitas = count($datos["agenda"])+$ajuste;
        $medio = $numCitas/2;
        for ($i=0; $i < $numCitas/2 ; $i++) {
          print "<tr>";
          $hr = ($datos["agenda"][$i][0]<10)?"0".$datos["agenda"][$i][0]:$datos["agenda"][$i][0];
          $min = ($datos["agenda"][$i][1]<10)?"0".$datos["agenda"][$i][1]:$datos["agenda"][$i][1];
          print "<td>".substr($hr,-2).":".substr($min,-2)."</td>";
          $edo = $datos["agenda"][$i][2];
          print "<td>";
          $p = $datos["data"][0]."/";
          $p.= $datos["data"][1]."/";
          $p.= $datos["data"][2]."/";
          $p.= $datos["data"][3]."/";
          $p.= $hr.":".$min."/";
          $p.= trim($datos["data"][5])."/"; //dia de la semana
          $p.= trim($datos["data"][6]); //estado
          if($edo == 0) {
            // Horario libre: botón interactivo
            print '<a href="'.RUTA.'citas/verificarCita/'.$p.'" class="btn btn-info">Libre</a>';
          } else {
            // Horario ocupado: mostrar texto estático en lugar de botón
            print '<span class="btn btn-warning disabled">'.$datos["edoCita"][$edo]["cadena"].'</span>';
          }
          print "</td>";
          //
          //Segunda columna
          //
          if (isset($datos["agenda"][$medio][0])) {
            $hr = ($datos["agenda"][$medio][0]<10)?"0".$datos["agenda"][$medio][0]:$datos["agenda"][$medio][0];
            $min = ($datos["agenda"][$medio][1]<10)?"0".$datos["agenda"][$medio][1]:$datos["agenda"][$medio][1];
            print "<td>".substr($hr,0,2).":".substr($min,0,2)."</td>";
            $edo = $datos["agenda"][$medio][2];
            print "<td>";
            //
            $p = $datos["data"][0]."/"; //dia de la semana
            $p.= $datos["data"][1]."/"; //doctor
            $p.= $datos["data"][2]."/"; //paciente
            $p.= $datos["data"][3]."/"; //fecha
            $p.= $hr.":".$min."/";
            $p.= trim($datos["data"][5])."/"; //dia de la semana
            $p.= trim($datos["data"][6]); //estado
            //
            if($edo==0){
              print '<a href="'.RUTA.'citas/verificarCita/'.$p.'" class="btn btn-info">Libre</a>';
            } else {
              print '<a href="'.RUTA.'citas/verificarCita/'.$p.'" class="btn btn-warning">'.$datos["edoCita"][$edo]["cadena"].'</a>';
            }
          }
          $medio++;
          print "</td>";
          print "</tr>";
        }
      ?>
      </table>
    </div>
    <a href="<?php print RUTA; ?>citas" class="btn btn-success">Regresar</a>
  </form>
</div><!--card-->
<?php include_once("piepagina.php"); ?>