<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Consultorio médico | <?php print $datos["titulo"]; ?></title>
	<link rel="shortcut icon" href="<?php print RUTA; ?>public/img/favicon.ico">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
</head>
<body>
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
		<a href="<?php print RUTA.'tablero/'; ?>" class="navbar-brand">Consultorio</a>
		<?php
		if (isset($datos["menu"]) && $datos["menu"]==true) {
			if (isset($datos["admon"]) && $datos["admon"]==true) {
			  print "<ul class='navbar-nav mr-auto mt-2 mt-lg-0'>";
		      print "<li class='nav-item'>";
		      print "<a href='".RUTA."doctores' class='nav-link ";
		      if(isset($datos["activo"]) && $datos["activo"]=="doctores") print "active";
		      print "'>Doctores</a>";
		      print "</li>";
		      //
		      print "<li class='nav-item'>";
		      print "<a href='".RUTA."pacientes' class='nav-link ";
		      if(isset($datos["activo"]) && $datos["activo"]=="pacientes") print "active";
		      print "'>Pacientes</a>";
		      print "</li>";
		      //
		      print "<li class='nav-item'>";
		      print "<a href='".RUTA."citas' class='nav-link ";
		      if(isset($datos["activo"]) && $datos["activo"]=="citas") print "active";
		      print "'>Citas</a>";
		      print "</li>";
		      //
		      print "<li class='nav-item'>";
		      print "<a href='".RUTA."horarios' class='nav-link ";
		      if(isset($datos["activo"]) && $datos["activo"]=="horarios") print "active";
		      print "'>Horarios</a>";
		      print "</li>";
		      print "</ul>";
		  }
		  if (isset($datos["admon"]) && $datos["admon"]==false) {
			  print "<ul class='navbar-nav mr-auto mt-2 mt-lg-0'>";
		      print "<li class='nav-item'>";
		      print "<a href='".RUTA."historial' class='nav-link ";
		      if(isset($datos["activo"]) && $datos["activo"]=="historial") print "active";
		      print "'>Historial de paciente</a>";
		      print "</li>";
		      print "</ul>";

		  }
	      //
	      print "<ul class='nav navbar-nav ms-auto'>";
	      //
	      print "<li class='nav-item'>";
	      print "<a href='".RUTA."tablero/perfil' class='nav-link'>Perfil</a>";
	      print "</li>";
	      print "<li class='nav-item'>";
	      print "<a href='".RUTA."tablero/logout' class='nav-link'>Salida</a>";
	      print "</li>";
	      print "</ul>";
	    }  
	?>
	</nav>
	<div class="container-fluid">
		<div class="row content">
			<div class="col-sm-2"></div>
			<div class="col-sm-8">
				<?php  
				if (isset($datos["errores"])) {
					if (count($datos["errores"])>0) {
						print "<div class='alert alert-danger mt-3'>";
						foreach ($datos["errores"] as $valor) {
							print "<strong>* ".$valor."</strong><br>";
						}
						print "</div>";
					}
				}

				?>