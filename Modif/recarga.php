<?php
session_start();
if (!isset($_SESSION['ingresado'])){
    header("location: index.php");
}
$usuario=$_SESSION['ingresado'];
$rutafunciones = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/funciones.php';
include ($rutafunciones); 

$rutadb = $_SERVER['DOCUMENT_ROOT'] . '/servicios/db.php';
$rutaheader = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/header.php';
include ($rutadb);
include ($rutaheader); 
$esta = $_SERVER['PHP_SELF'];
$vuelta = $_SERVER['DOCUMENT_ROOT'] . '/servicios/menuadmin.php';
?>

<?php if (isset($_SESSION['message'])) { ?>

<div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
	<?= $_SESSION['message'] ?>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<?php } unset($_SESSION['message']); ?>	

<?php
if(isset($_POST['recarga'])){
	$rec=recargartodos();
	if($rec){
		$_SESSION['message'] = "Permisos agregados con exito";
		$_SESSION['message_type'] = "success";
	}else{
		$_SESSION['message'] = "Falló la carga de permisos";
		$_SESSION['message_type'] = "danger";
	}
	header("location: " . $esta);
}
?>

<div class="col-md-12 container p-2">
	<div class="row">
		<div class="col-md-7">
			<form action="<?php echo $esta ?>" method="POST">
							
				<table class="table table-bordered">
					<thead class="thead-cel" style="text-align:center">
						<tr>
							<th style="width: 40%" colspan=2><h2>Se agregaran los permisos para las funciones nuevas.</h2></th>
						</tr>
					</thead>
					<tbody>
							<tr>
								<td><input type="submit" name="recarga" value="Aceptar" class="btn btn-success"></td>
								<td><a href="/Servicios/menuadmin.php" class="btn btn-primary"> Volver </a></td>
							</tr>		
					</tbody>
				</table>

			</form>
		</div>
	</div>
</div>

<?php 
$rutafooter = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/footer.php';
include ($rutafooter); 
?>
