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

$pantalla = 'vendedores0';//ojo al cambiar nombre del archivo php

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
$rutaborrar = $_SERVER['DOCUMENT_ROOT'] . '/servicios/bajas/borravend.php';
?>

<div class="col-md-12 container p-2">
	<div class="row">
		<div class="col-md-11">
			<form action="<?php echo $esta ?>" method="POST">
							
				<table class="table table-bordered">
					<thead class="thead-cel" style="text-align:center">
						<tr>
							<th style="width: 50%">Vendedor</th>
							<th style="width: 40%" colspan=2>Acciones</th>
						</tr>
					</thead>
					<tbody>
							<tr>
								<td><input text="vend" name="vend" style="width: 100%" placeholder="Vendedor a buscar"></td>
								<td><input type="submit" name="Busca" value="Buscar" class="btn btn-secondary"></td>
								<td><a href="/Servicios/Altas/altavend.php?flag=0" class="btn btn-primary"> Nuevo Vendedor <i class="fa fa-cog fa-spin"></i>
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

	<?php } unset($_SESSION['message']); ?>	


	<div class="row">

		<div class="col-md-8">

				<table class="table table-condensed table-bordered table-hover">
					<thead class="thead-dario" style="text-align:center">
						<tr>
							<th style="width: 70%">Vendedor</th>
							<th style="width: 30%">Acciones</th>
						<tr>
					</thead>
					<tbody>
						<?php
							if (isset($_POST['Busca'])){
								$mivend= '%' . $_POST['vend'] . '%';
								$query = "SELECT * FROM vendedores WHERE Vendedor like '$mivend'";
							} 
							else{
								$query = "SELECT * FROM vendedores";
							}
							unset($_POST['Busca']);
							$result_tasks = mysqli_query($conn,$query);

							if (!$result_tasks){
								$query = "SELECT * FROM vendedores";
								$result_tasks = mysqli_query($conn,$query);
								echo 'ALGO SALIO MAL';
							}

							while ($row=mysqli_fetch_array($result_tasks)) { 
						?>
								<tr>
									<td><?php echo $row['Vendedor'] ?></td>
									<td>
										<a href="/Servicios/Modif/modifvend.php?id=<?php echo $row['id'] ?>" class= 
										"btn btn-primary btn-sm">
											Modificar <i class="fa fa-cog fa-spin"></i>
										</a>
									
										<a href="/Servicios/Bajas/borravend.php?id=<?php echo $row['id'] ?>" class= 
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


