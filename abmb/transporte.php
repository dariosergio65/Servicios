<?php // error_reporting(1);  //SACAR ESTA LINEA CUANDO ANDE TODO 
?>
<?php
session_start();
if (!isset($_SESSION['ingresado'])){
	header("location: index.php");
}
$rutaf = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/includes/funciones.php';
include ($rutaf);
$rutaindex = '/Servicios/index.php';
$usuario=$_SESSION['ingresado']; 

$pantalla = 'transporte0'; //ojo al cambiar nombre del archivo php

$r=comprobar($usuario,$pantalla); 
if($r=='disabled'){
    header ("location: " . $rutaindex);
    die();
}

$rutadb = $_SERVER['DOCUMENT_ROOT'] . '/servicios/db.php';
$rutaheader = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/header.php';
//include ($funciones);
include ($rutadb);
include ($rutaheader); 
$esta = $_SERVER['PHP_SELF'];
$rutaborrar = $_SERVER['DOCUMENT_ROOT'] . '/servicios/bajas/borratrans.php';
//if ternario (permisos)
$btnBuscar= (comprobar($usuario,'transporte1')=='enabled') ? 'enabled' : 'disabled';
$btnNuevo= (comprobar($usuario,'transporte2')=='enabled') ? '"/Servicios/Altas/altatrans.php?flag=0"' : '"#"';
$btnModif= (comprobar($usuario,'transporte3')=='enabled') ? '/Servicios/Modif/modiftrans.php?id=' : '"#"';
$btnBorrar= (comprobar($usuario,'transporte4')=='enabled') ? '/Servicios/Bajas/borratrans.php?id=' : '"#"';
//echo 'variable btnBuscar: ' . $btnBuscar;
?>

<div class="col-md-12 container p-2">
	<div class="row">
		<div class="col-md-11">
			<form action="<?php echo $esta ?>" method="POST">
							
				<table class="table table-bordered">
					<thead class="thead-cel" style="text-align:center">
						<tr>
							<th style="width: 50%">Transporte</th>
							<th style="width: 40%" colspan=2>Acciones</th>
						</tr>
					</thead>
					<tbody>
							<tr>
								<td><input text="trans" name="trans" style="width: 100%" placeholder="Transporte a buscar"></td>
								<td><input type="submit" name="Busca" value="Buscar" class="btn btn-secondary" <?php echo $btnBuscar; ?>></td>
								<td><a href=<?php echo $btnNuevo; ?> class="btn btn-primary" > Nuevo Transporte </a></td>
								<!-- <td><input type="submit" name="Nuevo" value="Nuevo Transporte" class="btn btn-primary"><td> -->
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

		<div class="col-md-8">

				<table class="table table-condensed table-bordered table-hover">
					<thead class="thead-dario" style="text-align:center">
						<tr>
							<th style="width: 70%">Transporte</th>
							<th style="width: 30%">Acciones</th>
						<tr>
					</thead>
					<tbody>
						<?php
							if (isset($_POST['Busca'])){
								$mitrans= '%' . $_POST['trans'] . '%';
								$query = "SELECT * FROM transportes WHERE Transporte like '$mitrans'";
							} 
							else{
								$query = "SELECT * FROM transportes";
							}
							unset($_POST['Busca']);
							$result_tasks = mysqli_query($conn,$query);

							if (!$result_tasks){
								$query = "SELECT * FROM transportes";
								$result_tasks = mysqli_query($conn,$query);
								echo 'ALGO SALIO MAL';
							}

							while ($row=mysqli_fetch_array($result_tasks)) {
						?>
								<tr>
									<td><?php echo $row['Transporte'] ?></td>
									<td>
										<a href="<?php echo $btnModif; echo $row['id']; ?> " class="btn btn-primary btn-sm">
											Modificar <i class="fa fa-cog fa-spin"></i>
										</a>
									
										<a href="<?php echo $btnBorrar; echo $row['id']; ?> " class= 
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


