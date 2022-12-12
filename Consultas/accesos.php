<?php
session_start();
if (!isset($_SESSION['ingresado'])){
	header("location: ../index.php");
	die();
}
$rutaf = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/includes/funciones.php';
include ($rutaf);
$rutaindex = '/Servicios/index.php';
$usuario=$_SESSION['ingresado']; 

$pantalla = 'cantservicios0';//ojo al cambiar el nombre del archivo php

$r=comprobar($usuario,$pantalla);
if($r=='disabled'){
    header ("location: " . $rutaindex);
    die();
}
$rutadb = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/db.php';
$rutaheader = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/includes/header.php';
include ($rutadb);
include ($rutaheader); 
$esta = $_SERVER['PHP_SELF'];
//$rutaborrar = $_SERVER['DOCUMENT_ROOT'] . '/servicios/bajas/borraagen.php'; aca no se borra nada
?>

<div class="col-md-12 container p-2">
	<div class="row">
		<div class="col-md-11">
			<form action="<?php echo $esta ?>" method="POST">
							
				<table class="table table-bordered">
					<thead class="thead-cel" style="text-align:center">
						<tr>
							<th style="width: 80%" >Accesos de Usuarios Lago</th>
							<th style="width: 20%" >Acciones</th>
							
						</tr>
					</thead>
					<tbody>
							<tr>
								<td>
									<input text="est" name="agen" style="width: 100%" placeholder="Usuario a buscar">
								</td>
								<td><input type="submit" name="Busca" value="Buscar" class="btn btn-secondary"></td>
								
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

	<?php } unset($_SESSION['message']); ?>	


	<div class="row">

		<div class="col-md-12">
			<table class="table table-sm table-bordered table-hover">
				<thead class="thead-dario" style="text-align:center">
					<tr>
						<th style="width: 30%">Fecha</th>
						<th style="width: 10%">Usuario</th>
						<th style="width: 20%">Nombre</th>
						<th style="width: 10%">Acción</th>
						<th style="width: 20%">Ip</th>
						<th style="width: 10%">Uri</th>
					<tr>
				</thead>
				<tbody>
					<?php
						if (isset($_POST['Busca'])){
							$miagen= '%' . $_POST['agen'] . '%';
							$query = "SELECT a.fechahora, u.User, u.Nombre, a.accion, a.ip, a.requesturi FROM accesos a
							INNER JOIN usuarios u ON a.idusuario=u.User
							WHERE u.Nombre like '$miagen'
							ORDER BY a.fechahora desc
							";
						} 
						else{
							$query = "SELECT a.fechahora as fecha, u.User as useru, u.Nombre as nombreu, a.accion as acciona, a.ip as ipa, a.requesturi as reqa FROM accesos a
							INNER JOIN usuarios u ON a.idusuario=u.User
							ORDER BY a.fechahora desc
							";
						}

						unset($_POST['Busca']);
						$result_tasks = mysqli_query($conn,$query);

						if (!$result_tasks){
							$query = "SELECT * FROM accesos";
							$result_tasks = mysqli_query($conn,$query);
							echo 'ALGO SALIO MAL';
						}

						while ($row=mysqli_fetch_array($result_tasks)) { 
					?>
							<tr>
								<td><?php echo $row['fecha']; ?></td>
								<td><?php echo $row['useru'] ?></td>
								<td><?php echo $row['nombreu']; ?></td>
								<td><?php echo $row['acciona'] ?></td>
								<td><?php echo $row['ipa']; ?></td>
								<td><?php echo $row['reqa'] ?></td>
							</tr>		
					<?php }
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php 
$rutafooter = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/includes/footer.php';
include ($rutafooter); 
?>


