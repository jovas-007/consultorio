<?php include_once("encabezado.php"); ?>
<h1 class="text-center">
  <?php
  if (isset($datos["subtitulo"])) {
    print $datos["subtitulo"];
  }
  ?>
</h1>
<div class="card p-4 bg-light">
  <form enctype="multipart/form-data" action="<?php print RUTA; ?>tablero/fotoBorrar/" method="POST">
     <?php
      if (isset($datos["baja"])) { ?>
        <a href="<?php print RUTA; ?>tablero/fotoBaja/<?php print $datos['data']['idCita']."/".$datos["data"]['archivo']; ?>" class="btn btn-danger text">Borrar</a>
        <a href="<?php print RUTA; ?>tablero" class="btn btn-info">Regresar</a>
        <p><b>Advertencia: una vez borrado el archivo, no podrá recuperarse el mismo.</b></p>
      <?php } else { ?> 
        <input type="submit" value="Borrar archivo" class="btn btn-danger">
        <a href="<?php print RUTA; ?>tablero" class="btn btn-info">Regresar</a>
    <?php } ?> 

    <div class="form-group text-left mt-3">
      <?php
      print "<img src='".RUTA."public/doc/".$datos['data']["idCita"]."/".$datos["data"]['archivo']."' ";
          print "class='img-responsive' width='100%' ";
          print "alt='".$datos['data']['archivo']."'/>";
      ?>
    </div>

    <div class="form-group text-left">
      <input type="hidden" name="idCita" id="idCita" value="<?php if (isset($datos['data']["idCita"])) { print $datos['data']['idCita']; } else { print "";} ?>">
      <input type="hidden" name="archivo" id="archivo" value="<?php if (isset($datos['data']["archivo"])) { print $datos['data']['archivo']; } else { print "";} ?>">
    </div>
  </form>
</div><!--card-->
<?php include_once("piepagina.php"); ?>