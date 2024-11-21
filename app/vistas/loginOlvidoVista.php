<?php include_once("encabezado.php"); ?>
<h1 class="text-center"><?php print $datos["subtitulo"]; ?></h1>
<div class="card p-4 bg-light">
	<form action="<?php print RUTA; ?>login/olvido/" method="POST">
		<div class="form-group text-left">
			<label for="correo">* Correo electrónico:</label>
			<input type="text" name="correo" class="form-control" placeholder="Escribe el correo electrónico de la cuenta.">
		</div>
		<div class="form-group text-left">
			<input type="submit" value="Enviar" class="btn btn-success">
			<a href="<?php print RUTA; ?>" type="button" class="btn btn-info">Regresar</a>
		</div>
	</form>
</div>
<?php include_once("piepagina.php"); ?>