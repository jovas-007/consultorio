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
    <th>id</th>
    <th>Fecha</th>
    <th>Horario</th>
    <th>Costo</th>
    <th>Observación</th>
    <th>Diagnóstico</th>
  </tr>
  </thead>
  <tbody>
    <?php
    $total = 0;
    for($i=0; $i<count($datos['data']); $i++){
      print "<tr>";
      print "<td>".$datos["data"][$i]["id"]."</td>";
      print "<td class='text-left'>".$datos["data"][$i]["fecha"]."</td>";
      print "<td class='text-left'>".$datos["data"][$i]["horario"]."</td>";
      print "<td class='text-right'>$".number_format($datos["data"][$i]["costo"],2)."</td>";
      print "<td class='text-left'>".$datos["data"][$i]["observacion"]."</td>";
      //
      print "<td><a href='".RUTA."historial/diagnostico/".$datos["data"][$i]["id"]."' class='btn btn-warning'>Diagnóstico</a></td>";
      //
      $total+=$datos["data"][$i]["costo"];
    }
    print "<tr>";
    print "<td></td>";
    print "<td class='text-left'>Total:</td>";
    print "<td class='text-left'></td>";
    print "<td class='text-right'>$".number_format($total,2)."</td>";
    print "<td class='text-left'></td>";
    //
    print "<td></td>";
    ?>
  </tbody>
  </table>
    <!--?php include_once("paginacion.php"); ?-->
</div><!--card-->

<?php include_once("piepagina.php"); ?>