<?php include_once("encabezado.php"); ?>
<script src="<?php print RUTA; ?>js/doctoresPerfilVista.js"></script>
<h1 class="text-center">
  <?php
  if (isset($datos["subtitulo"])) {
    print $datos["subtitulo"];
  }
  ?>
</h1>
<div class="card p-4 bg-light">
  <form enctype="multipart/form-data" action="<?php print RUTA; ?>tablero/perfilDoctor/" method="POST">

    <div class="form-group text-left">
      <label for="nombre">* Nombre:</label>
      <input type="text" name="nombre" class="form-control" required
      placeholder="Escribe el nombre del doctor."
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
      <label for="content">* Apellidos:</label>
      <input type="text" name="apellidos" class="form-control" required
      placeholder="Escribe los apellidos del doctor."
      value="<?php 
      print isset($datos['data']['apellidos'])?$datos['data']['apellidos']:''; 
      ?>"
      <?php
      if (isset($datos["baja"])) {
        print "disabled ";
      }
      ?>
      >
    </div>

    <div class="form-group text-left">
      <label for="correo">* Correo electrónico:</label>
      <input type="email" name="correo" class="form-control" required
      placeholder="Escribe el correo electrónico del doctor"
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
      <label for="direccion">Dirección:</label>
      <input type="text" name="direccion" class="form-control" 
      placeholder="Escribe la direccion del doctor"
      value="<?php 
      print isset($datos['data']['direccion'])?$datos['data']['direccion']:''; 
      ?>"
      <?php
      if (isset($datos["baja"])) {
        print " disabled ";
      }
      ?>
      >
    </div>

    <div class="form-group text-left">
      <label for="telefono">* Teléfono:</label>
      <input type="text" name="telefono" class="form-control" required 
      placeholder="Escribe el teléfono del doctor"
      value="<?php 
      print isset($datos['data']['telefono'])?$datos['data']['telefono']:''; 
      ?>"
      <?php
      if (isset($datos["baja"])) {
        print " disabled ";
      }
      ?>
      >
    </div>

    <div class="form-group text-left">
      <label for="perfil">* Perfil:</label>
      <input type="text" name="perfil" class="form-control" required
      placeholder="Escribe el perfil del doctor"
      value="<?php 
      print isset($datos['data']['perfil'])?$datos['data']['perfil']:''; 
      ?>"
      <?php
      if (isset($datos["baja"])) {
        print " disabled ";
      }
      ?>
      >
    </div> 

    <div class="form-group text-left">
      <label for="clave">Clave de acceso actual:</label>
      <input type="password" name="clave" class="form-control" required placeholder="xxxxxxxxxx" value="<?php print str_repeat("x",12); ?>">
    </div> 

    <div class="form-group text-left">
      <label for="clave1">Nueva Clave de acceso:</label>
      <input type="password" name="clave1" class="form-control" placeholder="xxxxxxxxxx">
    </div> 

    <div class="form-group text-left">
      <label for="clave2">Confirmar nueva clave de acceso:</label>
      <input type="password" name="clave2" class="form-control" placeholder="xxxxxxxxxx">
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