<?php include_once("encabezado.php"); ?>
<script src="<?php print RUTA; ?>js/horariosAltaVista.js"></script>
<h1 class="text-center">
  <?php
  if (isset($datos["subtitulo"])) {
    print $datos["subtitulo"];
  }
  ?>
</h1>
<div class="card p-4 bg-light">
  <form enctype="multipart/form-data" action="<?php print RUTA; ?>horarios/alta/" method="POST">


    <div class="form-group text-left">
      <label for="doctor">* Doctor:</label>
      <select class="form-control" name="doctor" id="doctor" 
      <?php
      if (isset($datos["baja"])) {
        print " disabled ";
      }
      ?>
      >
        <option value="void">---Selecciona un doctor---</option>
        <?php
          for ($i=0; $i < count($datos["doctores"]); $i++) { 
            print "<option value='".$datos["doctores"][$i]["id"]."'";
              if(isset($datos["data"]["idDoctor"]) && $datos["data"]["idDoctor"]==$datos["doctores"][$i]["id"]){
                print " selected ";
              }
            print ">".$datos["doctores"][$i]["apellidos"].", ".$datos["doctores"][$i]["nombre"]." (".$datos["doctores"][$i]["perfil"].")</option>";
          } 
        ?>
      </select>
    </div>

    <div class="form-group text-left">
      <label for="diaSemana">* Día de la semana:</label>
      <select class="form-control" name="diaSemana" id="diaSemana" 
      <?php
      if (isset($datos["baja"])) {
        print " disabled ";
      }
      ?>
      >
        <option value="void">---Selecciona un día de la semana---</option>
        <?php
          for ($i=0; $i < count($datos["dias"]); $i++) { 
            print "<option value='".$datos["dias"][$i]["indice"]."'";
              if(isset($datos["data"]["diaSemana"]) && $datos["data"]["diaSemana"]==$datos["dias"][$i]["indice"]){
                print " selected ";
              }
            print ">".$datos["dias"][$i]["cadena"]."</option>";
          } 
        ?>
      </select>
    </div> 

    <div class="form-group text-left">
      <label for="inicio">* Hora de inicio:</label>
      <input type="time" name="inicio" class="form-control" required min="00:00" max="24:00" style="width:10rem;"
      value="<?php 
      print isset($datos['data']['inicio'])?$datos['data']['inicio']:''; 
      ?>"
      <?php
      if (isset($datos["baja"])) {
        print " disabled ";
      }
      ?>
      >      
    </div>  

    <div class="form-group text-left">
      <label for="fin">* Hora de salida:</label>
      <input type="time" name="fin" class="form-control" required min="00:00" max="24:00" style="width:10rem;"
      value="<?php 
      print isset($datos['data']['fin'])?$datos['data']['fin']:''; 
      ?>"
      <?php
      if (isset($datos["baja"])) {
        print " disabled ";
      }
      ?>
      >
    </div>

    <div class="form-group text-left">
      <label for="duracion">* Duración de la consulta:</label>
      <select class="form-control" name="duracion" id="duracion" 
      <?php
      if (isset($datos["baja"])) {
        print " disabled ";
      }
      ?>
      >
        <option value="void">--- Selecciona la duración promedio de la consulta ---</option>
        <?php
          for ($i=0; $i < count($datos["duracion"]); $i++) { 
            print "<option value='".$datos["duracion"][$i]["cadena"]."'";
              if(isset($datos["data"]["duracion"]) && $datos["data"]["duracion"]==$datos["duracion"][$i]["cadena"]){
                print " selected ";
              }
            print ">".$datos["duracion"][$i]["cadena"]."</option>";
          } 
        ?>
      </select>
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
      if (isset($datos["baja"])) { ?>
        <a href="<?php print RUTA; ?>horarios/bajaLogica/<?php print $datos['data']['id']; ?>" class="btn btn-danger">Borrar</a>
        <a href="<?php print RUTA; ?>horarios" class="btn btn-danger">Regresar</a>
        <p><b>Advertencia: una vez borrado el registro, no podrá recuperar la información</b></p>
      <?php } else { ?> 
      <input type="submit" value="Enviar" class="btn btn-success">
      <a href="<?php print RUTA; ?>horarios" class="btn btn-info">Regresar</a>
    <?php } ?> 
    </div>
  </form>
</div><!--card-->
<?php include_once("piepagina.php"); ?>