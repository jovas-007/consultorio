<?php include_once("encabezado.php"); ?>
<script src="<?php print RUTA; ?>js/perfilAltaVista.js"></script>
<h1 class="text-center">
  <?php
  if (isset($datos["subtitulo"])) {
    print $datos["subtitulo"];
  }
  ?>
</h1>
<div class="card p-4 bg-light">
  <form enctype="multipart/form-data" action="<?php print RUTA; ?>tablero/perfil/" method="POST">

    <div class="form-group text-left">
      <label for="nombre">* Nombre:</label>
      <input type="text" name="nombre" class="form-control" required
      placeholder="Escribe el nombre del administrador."
      value="<?php 
      print isset($datos['data']['nombre'])?$datos['data']['nombre']:''; 
      ?>"
      <?php
      if (isset($datos["baja"])) {
        print "disabled ";
      }
      ?>
      >
    </div>

    <div class="form-group text-left">
      <label for="autor">* Correo electrónico:</label>
      <input type="email" name="correo" class="form-control"
      placeholder="Escribe el correo electrónico del doctor" required
      value="<?php 
      print isset($datos['data']['correo'])?$datos['data']['correo']:''; 
      ?>"
      <?php
      if (isset($datos["baja"])) {
        print " disabled ";
      }
      ?>
      >
    </div>

    <div class="form-group text-left">
      <label for="clave">* Clave de acceso actual:</label>
      <input type="password" name="clave" class="form-control" 
      placeholder="Escribe la clave de acceso actual" value="xxxxxxxxxxxx">
    </div>

    <div class="form-group text-left">
      <label for="nuevaClave">Nueva clave de acceso:</label>
      <input type="password" name="nuevaClave" class="form-control" 
      placeholder="Escribe la clave de acceso" value="">
    </div>

    <div class="form-group text-left">
      <label for="confirmacion">Confirmar nueva clave de acceso:</label>
      <input type="password" name="confirmacion" class="form-control" 
      placeholder="Confirma tu clave de acceso" value="">
    </div>

    <div class="form-group text-left">
      <input type="hidden" name="id" id="id" value="
      <?php
        if (isset($datos['data']['id'])) {
          print $datos['data']['id'];
        } else {
          print "";
        }
      ?>
      ">
      <input type="submit" value="Enviar" class="btn btn-success">
      <a href="<?php print RUTA; ?>tablero" class="btn btn-info">Regresar</a>
    </div>
  </form>
</div><!--card-->
<?php include_once("piepagina.php"); ?>