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
    <th>Nombre</th>
    <th>Apellidos</th>
    <th>Historial</th>
  </tr>
  </thead>
  <tbody>
    <?php
    for($i=0; $i<count($datos['data']); $i++){
      print "<tr>";
      print "<td>".$datos["data"][$i]["idPaciente"]."</td>";
      print "<td class='text-left'>".$datos["data"][$i]["nombre"]."</td>";
      print "<td class='text-left'>".$datos["data"][$i]["apellidos"]."</td>";
      //
      print "<td><a href='".RUTA."historial/historial/".$datos["data"][$i]["idPaciente"]."' class='btn btn-info'>Historial clínico</a></td>";
      //
    }
    ?>
  </tbody>
  </table>
    <?php include_once("paginacion.php"); ?>
</div><!--card-->

<?php include_once("piepagina.php"); ?>