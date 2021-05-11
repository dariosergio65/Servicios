<?php // error_reporting(1);  //SACAR ESTA LINEA CUANDO ANDE TODO 
?>
<?php
session_start();
if (!isset($_SESSION['ingresado'])){
	header("location: index.php");
}
$usuario=$_SESSION['ingresado'];

$rutadb = $_SERVER['DOCUMENT_ROOT'] . '/servicios/db.php';
$rutaheader = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/header.php';
include ($rutadb);
include ($rutaheader); 
$esta = $_SERVER['PHP_SELF'];
$rutaborrar = $_SERVER['DOCUMENT_ROOT'] . '/servicios/bajas/borrauser.php'; 
?>

<div class="col-md-12 container p-2">
	<div class="row">
		<div class="col-md-11">
			<form action="<?php echo $esta ?>" method="POST">
							
				<table class="table table-bordered">
					<thead class="thead-cel" style="text-align:center">
						<tr>
							<th style="width: 50%" colspan=2>Usuarios</th>
							<th style="width: 40%" colspan=2>Acciones</th>
						</tr>
					</thead>
					<tbody>
							<tr>
								<td><input text="est" name="user" style="width: 100%" placeholder="Nombre de usuario"></td>
								<td><input text="est1" name="nombre" style="width: 100%" placeholder="Nombre real"></td>
								<td><input type="submit" name="Busca" value="Buscar" class="btn btn-secondary"></td>
								<td><a href="/Servicios/Altas/altauser.php?flag=0" class="btn btn-primary"> Nuevo Usuario <i class="fa fa-cog fa-spin"></i> 
								</a></td>
							</tr>		
					</tbody>
				</table>

			</form>
		</div>
	</div>

	<?php if (isset($_SESSION['message'])) { ?>

		<div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
			<?= $_SESSION['message'] ?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>

	<?php } unset($_SESSION['message']);//session_unset();  ?>	


	<div class="row">

		<div class="col-md-12">

				<table class="table table-sm table-bordered table-hover">
					<thead class="thead-dario" style="text-align:center">
						<tr>
							<th style="width: 10%">USUARIO</th>
							<th style="width: 25%">Nombre real</th>
							<th style="width: 10%">Categoria</th>
							<th style="width: 40%">Clave</th>
							<th style="width: 15%">Acciones</th>
						<tr>
					</thead>
					<tbody>
						<?php
							if (isset($_POST['Busca'])){
								$miuser= '%' . $_POST['user'] . '%';
								$minombre= '%' . $_POST['nombre'] . '%';
								$query = "SELECT * FROM usuarios 
								INNER JOIN categorias
								ON usuarios.id_categoria=categorias.id 
								WHERE User like '$miuser' AND usuarios.Nombre like '$minombre'"; //  AND Nombre like '$minombre'
							} 
							else{
								$query = "SELECT * FROM usuarios 
								INNER JOIN categorias
								ON usuarios.id_categoria=categorias.id ";
							}
							unset($_POST['Busca']);
							$result_tasks = mysqli_query($conn,$query);

							if (!$result_tasks){
								$query = "SELECT * FROM usuarios 
								INNER JOIN categorias
								ON usuarios.id_categoria=categorias.id ";
								$result_tasks = mysqli_query($conn,$query);
								echo 'ALGO SALIO MAL';
							}

								while ($row=mysqli_fetch_array($result_tasks)) { 
						?>
								<tr>
									<td><?php echo $row['User'] ?></td>
									<td><?php echo $row['Nombre'] ?></td>
									<td><?php echo $row['nombre'] ?></td>
									<td><?php echo $row['Clave'] ?></td>

									<td>
										<a href="/Servicios/Modif/modifuser.php?id=<?php echo $row['User'] ?>" class= 
										"btn btn-primary btn-sm">
											Modificar <i class="fa fa-cog fa-spin"></i>
										</a>
									
										<a href="/Servicios/Bajas/borrauser.php?id=<?php echo $row['User'] ?>" class= 
										"btn btn-danger btn-sm">
											Borrar <i class="far fa-trash-alt"></i>
										</a>
									</td>
								</tr>		
						<?php }
						?>
					</tbody>
				</table>
		</div>
	</div>

</div>

<?php 
$rutafooter = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/footer.php';
include ($rutafooter); 
?>


