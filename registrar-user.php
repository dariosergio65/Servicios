<?php //include ("db.php"); ?>
<?php include ("includes/header.php"); ?>

<div class="container p-4 col-3">
<form action="user-registrado.php" method="POST">
	<div class="panel panel-primary">
		<div class="panel-heading text-center">
			<h2>REGISTRAR USUARIO</h2>
		</div>

		<?php if (isset($_SESSION['mensaje'])) { ?>

			<div class="alert alert-<?= $_SESSION['tipo_mensaje'] ?> alert-dismissible fade show" role="alert">
				<?= $_SESSION['mensaje'] ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

		<?php } session_unset(); ?>

		<div class="panel-body">
			<h4>Usuario:</h4>
			<input type="text" class="form-control" name="usuario">
			<br><br>
			<h4>Nombre Completo:</h4>
			<input type="text" class="form-control" name="nombre">
			<br><br>
			<h4>Contraseña:</h4>
			<input type="password" class="form-control" name="clave">
		</div>
		<div class="panel-footer">
			<br>
			<!-- <button class="btn btn-primary">Ingresar</button> -->
			<input type="submit" class="btn btn-primary" name="intento" value="Insertar">
		</div>
	</div>
</form>
</div>


<?php include ("includes/footer.php"); ?>


