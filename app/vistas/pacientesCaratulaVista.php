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
    <th>Modificar</th>
    <th>Borrar</th>
  </tr>
  </thead>
  <tbody>
    <?php
    for($i=0; $i<count($datos['data']); $i++){
      print "<tr>";
      print "<td>".$datos["data"][$i]["id"]."</td>";
      print "<td class='text-left'>".$datos["data"][$i]["nombre"]."</td>";
      print "<td class='text-left'>".$datos["data"][$i]["apellidos"]."</td>";
      //
      print "<td><a href='".RUTA."pacientes/cambio/".$datos["data"][$i]["id"]."' class='btn btn-info'>Modificar</a></td>";
      //
      print "<td><a href='".RUTA."pacientes/baja/".$datos["data"][$i]["id"]."' class='btn btn-danger'>Borrar</a></td>";
      print "</tr>";
    }
    ?>
  </tbody>
  </table>
    <?php include_once("paginacion.php"); ?>
</div><!--card-->
<a href="<?php print RUTA; ?>pacientes/alta" class="btn btn-success">
  Dar de alta un paciente</a>

<?php include_once("piepagina.php"); ?>