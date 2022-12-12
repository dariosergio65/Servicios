<?php // error_reporting(1);  //SACAR ESTA LINEA CUANDO ANDE TODO 
?>
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

$pantalla = 'internos0';//ojo al cambiar el nombre del archivo php

$r=comprobar($usuario,$pantalla);
if($r=='disabled'){
    header ("location: " . $rutaindex);
    die();
}
$rutadb = $_SERVER['DOCUMENT_ROOT'] . '/servicios/db.php';
$rutaheader = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/header.php';
include ($rutadb);
include ($rutaheader); 
$esta = $_SERVER['PHP_SELF'];
$rutaborrar = $_SERVER['DOCUMENT_ROOT'] . '/servicios/bajas/borraint.php';

// crear borraint.php 

//$btnBuscar= (comprobar($usuario,'internos1')=='enabled') ? 'enabled' : 'disabled';
$btnNuevo= (comprobar($usuario,'internos2')=='enabled') ? '"/Servicios/Altas/altaint.php?flag=0"' : '"#"';
$btnModif= (comprobar($usuario,'internos3')=='enabled') ? '/Servicios/Modif/modifint.php?id=' : '"#"';
$btnBorrar= (comprobar($usuario,'internos4')=='enabled') ? '/Servicios/Bajas/borraint.php?id=' : '"#"';
//echo 'variable btnBuscar: ' . $btnBuscar;

?>

<div class="col-md-12 container p-2">
	<div class="row">
		<div class="col-md-11">
			<form action="<?php echo $esta ?>" method="POST">
							
				<table class="table table-bordered">
					<thead class="thead-cel" style="text-align:center">
						<tr>
							<th style="width: 60%" colspan=2>Personal</th>
							<th style="width: 20%" colspan=2>Acciones</th>
						</tr>
					</thead>
					<tbody>
							<tr>
								<td><input text="est" name="agen" style="width: 100%" placeholder="Nombre del empleado"></td>
								<td><input text="ape" name="ape" style="width: 100%" placeholder="Apellido del empleado"></td>

								<td><input type="submit" name="Busca" value="Buscar" class="btn btn-secondary"></td>
								<td><a href=<?php echo $btnNuevo; ?> class="btn btn-primary" > Nuevo Interno </a></td>
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
							<th style="width: 25%">Nombre</th>
							<th style="width: 20%">Apellido</th>
							<th style="width: 10%">Interno</th>
							<th style="width: 25%">Equipo</th>
							<th style="width: 10%">Acciones</th>
						<tr>
					</thead>
					<tbody>
						<?php
							if (isset($_POST['Busca'])){
								$miagen= '%' . $_POST['agen'] . '%';
								$miape= '%' . $_POST['ape'] . '%';

								$query = "SELECT id,Nombre,Apellido,Interno,Equipo FROM internos WHERE (Nombre like '$miagen' AND Apellido LIKE '$miape')";
							} 
							else{
								$query = "SELECT id,Nombre,Apellido,Interno,Equipo FROM internos  order by Interno";
							}
							unset($_POST['Busca']);
							$result_tasks = mysqli_query($conn,$query);
							

							if (!$result_tasks){
								$query = "SELECT * FROM internos";
								$result_tasks = mysqli_query($conn,$query);
								echo 'ALGO SALIO MAL';
							}

							while ($row=mysqli_fetch_array($result_tasks)) { 
						?>
								<tr>
									<td><?php echo $row['Nombre'] ?></td>
									<td><?php echo $row['Apellido'] ?></td>
									<td><?php echo $row['Interno'] ?></td>
									<td><?php echo $row['Equipo'] ?></td>

									<td>
										<a href="<?php echo $btnModif; echo $row['id']; ?> " class="btn btn-primary btn-sm">
										<i class="far fa-edit"> </i>
										</a>
									
										<a href="<?php echo $btnBorrar; echo $row['id']; ?> " class= 
										"btn btn-danger btn-sm">
											<i class="far fa-trash-alt"></i>
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


