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
  <a href="<?php print RUTA.'historial/diagnostico/'.$datos['data']["idCita"];?>" class="btn btn-info">Regresar</a>

    <div class="form-group text-left mt-3">
      <?php
      print "<img src='".RUTA."public/doc/".$datos['data']["idCita"]."/".$datos["data"]['archivo']."' ";
          print "class='img-responsive' width='100%' ";
          print "alt='".$datos['data']['archivo']."'/>";
      ?>
    </div>
  </form>
</div><!--card-->
<?php include_once("piepagina.php"); ?>