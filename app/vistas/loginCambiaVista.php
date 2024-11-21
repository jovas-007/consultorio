<?php include_once("encabezado.php"); ?>
<h1 class="text-center"><?php print $datos["subtitulo"]; ?></h1>
<div class="card p-4 bg-light">
	<form action="<?php print RUTA; ?>login/cambiarclave/" method="POST">
		<div class="form-group text-left">
			<label for="clave">* Nueva clave de acceso:</label>
			<input type="password" name="clave" class="form-control" placeholder="Escribe tu nueva clave de acceso.">
		</div>
		<div class="form-group text-left">
			<label for="verifica">* Repite tu nueva clave de acceso:</label>
			<input type="password" name="verifica" class="form-control" placeholder="Repite tu nueva clave de acceso">
		</div>
		<div class="form-group text-left">
			<input type="hidden" name="id" value="<?php print $datos['data']; ?>"/>
			<input type="hidden" name="admon" value="<?php print $datos['admon']; ?>"/>
			<input type="submit" value="Enviar" class="btn btn-success">
		</div>
	</form>
</div>
<?php include_once("piepagina.php"); ?>