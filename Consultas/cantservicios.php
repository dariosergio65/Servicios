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
$rutadb = $_SERVER['DOCUMENT_ROOT'] . '/servicios/db.php';
$rutaheader = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/header.php';
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
							<th style="width: 80%" >Servicios realizados por el personal Lago desde 07/12/2019</th>
							<th style="width: 20%" >Acciones</th>
							
						</tr>
					</thead>
					<tbody>
							<tr>
								<td>
									<input text="est" name="agen" style="width: 100%" placeholder="Agente a buscar">
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

		<div class="col-md-6">
			<table class="table table-sm table-bordered table-hover">
				<thead class="thead-dario" style="text-align:center">
					<tr>
						<th style="width: 50%">Nombre Agente</th>
						<th style="width: 30%">Servicios realizados</th>
						<th style="width: 20%">Porcentaje</th>
					<tr>
				</thead>
				<tbody>
					<?php
						if (isset($_POST['Busca'])){
							$miagen= '%' . $_POST['agen'] . '%';
							$query = "SELECT count(id_agente) as canti, Agente FROM agenteservicio
							INNER JOIN agentes ON agenteservicio.id_agente=agentes.dni
							WHERE Agente like '$miagen'
							GROUP BY id_agente
							ORDER BY canti desc
							";
						} 
						else{
							$query = "SELECT count(id_agente) as canti, Agente FROM agenteservicio
							INNER JOIN agentes ON agenteservicio.id_agente=agentes.dni
							GROUP BY id_agente
							ORDER BY canti desc
							";
						}

						$queryservi = "SELECT count(id) as cantservi from servicios";
						$result_servi = mysqli_query($conn,$queryservi);
						$row_servi=mysqli_fetch_array($result_servi);	


						unset($_POST['Busca']);
						$result_tasks = mysqli_query($conn,$query);

						if (!$result_tasks){
							$query = "SELECT * FROM agentes";
							$result_tasks = mysqli_query($conn,$query);
							echo 'ALGO SALIO MAL';
						}

						while ($row=mysqli_fetch_array($result_tasks)) { 
					?>
							<tr>
								<td><?php echo $row['Agente']; ?></td>
								<td><?php echo $row['canti'] ?></td>
								<td><?php echo number_format(($row['canti']/$row_servi['cantservi']*100),2).' %' ?></td>
							</tr>		
					<?php }
					?>
				</tbody>
			</table>
		</div>
		<div class="col-md-4">
			<?php echo 'Total de Servicios: ' . $row_servi['cantservi'] ?>
		
		</div>
	</div>

</div>

<?php 
$rutafooter = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/footer.php';
include ($rutafooter); 
?>


