<?php include_once("encabezado.php"); ?>
<script src="<?php print RUTA; ?>js/doctoresAltaVista.js"></script>
<h1 class="text-center">
  <?php
  if (isset($datos["subtitulo"])) {
    print $datos["subtitulo"];
  }
  ?>
</h1>
<div class="card p-4 bg-light">
  <form enctype="multipart/form-data" action="<?php print RUTA; ?>doctores/alta/" method="POST">

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

<!--
    <div class="form-group text-left">
      <label for="depto">* Departamento:</label>
      <input type="text" name="depto" class="form-control" required
      placeholder="Escribe el departamento"
      value="<?php 
      print isset($datos['data']['depto'])?$datos['data']['depto']:''; 
      ?>"
      <?php
      if (isset($datos["baja"])) {
        print " disabled ";
      }
      ?>
      >
    </div>
-->
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
      <input type="hidden" name="id" id="id" value="
      <?php
        if (isset($datos['data']['id'])) {
          print $datos['data']['id'];
        } else {
          print "";
        }
      ?>
      ">
      <?php
      if (isset($datos["baja"])) { 
        if($datos["numCitas"]>0 || $datos["numHorarios"]>0){
          print '<h4 class="text-center"><b>No puedes borrar el registro porque tiene '.$datos["numCitas"]." citas y ".$datos["numHorarios"]." horarios.</b></h4>";
        } else {
          print '<p class="text-center"><b>Advertencia: una vez borrado el registro, no podrá recuperar la información</b></p>';
          print '<a href="'.RUTA.'doctores/bajaLogica/'.$datos['data']['id'].' class="btn btn-danger">Borrar</a>';
        }
        print '<a href="'.RUTA.'doctores" class="btn btn-danger">Regresar</a>';
        ?>
        
      <?php } else { ?> 
      <input type="submit" value="Enviar" class="btn btn-success">
      <a href="<?php print RUTA; ?>doctores" class="btn btn-info">Regresar</a>
    <?php } ?> 
    </div>
  </form>
</div><!--card-->
<?php include_once("piepagina.php"); ?>