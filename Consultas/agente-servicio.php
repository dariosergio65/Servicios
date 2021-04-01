<?php // error_reporting(1);  //SACAR ESTA LINEA CUANDO ANDE TODO 
?>
<?php
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
							<th style="width: 80%" colspan=3>Personal -- Servicios</th>
							<th style="width: 20%" >Acciones</th>
							
						</tr>
					</thead>
					<tbody>
							<tr>
								<td>
									<input text="est" name="agen" style="width: 100%" placeholder="Agente a buscar">
								</td>
								<td>
									<input text="est1" name="nomserv" style="width: 100%" placeholder="Nombre del Servicio">
								</td>
								<td>	
									<input text="est2" name="lugar" style="width: 100%" placeholder="Lugar a buscar">
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

	<?php } session_unset(); ?>	


	<div class="row">

		<div class="col-md-12">

				<table class="table table-sm table-bordered table-hover">
					<thead class="thead-dario" style="text-align:center">
						<tr>
							<th style="width: 15%">Nombre Agente</th>
							<th style="width: 15%">Nombre Servicio</th>
							<th style="width: 15%">Lugar</th>
							<th style="width: 10%">Inicio</th>
							<th style="width: 10%">Final</th>
							<th style="width: 10%">Transporte</th>
							<th style="width: 25%">Tarea</th>
						<tr>
					</thead>
					<tbody>
						<?php
							if (isset($_POST['Busca'])){
								$miagen= '%' . $_POST['agen'] . '%';
								$minom= '%' . $_POST['nomserv'] . '%';
								$milugar= '%' . $_POST['lugar'] . '%';
								$query = "SELECT Agente, agenteservicio.Fechaini as inicio, agenteservicio.Fechafin as final, Nombre, Lugar, Trabajo, Transporte FROM agentes 
								INNER JOIN agenteservicio ON agentes.dni=agenteservicio.id_agente 
								INNER JOIN servicios ON agenteservicio.id_servicio=servicios.id
								INNER JOIN transportes ON servicios.id_transporte=transportes.id 
								WHERE Agente like '$miagen' AND Nombre like '$minom' AND Lugar like '$milugar'
								ORDER BY agenteservicio.Fechaini desc";
							} 
							else{
								$query = "SELECT Agente, agenteservicio.Fechaini as inicio, agenteservicio.Fechafin as final, Nombre, Lugar, Trabajo, Transporte FROM agentes 
								INNER JOIN agenteservicio ON agentes.dni=agenteservicio.id_agente 
								INNER JOIN servicios ON agenteservicio.id_servicio=servicios.id
								INNER JOIN transportes ON servicios.id_transporte=transportes.id
								";
							}
							unset($_POST['Busca']);
							$result_tasks = mysqli_query($conn,$query);
							$totalreg = mysqli_num_rows($result_tasks);
							echo 'Cantidad = '.$totalreg ;

							if (!$result_tasks){
								$query = "SELECT * FROM agentes";
								$result_tasks = mysqli_query($conn,$query);
								echo 'ALGO SALIO MAL';
							}

							while ($row=mysqli_fetch_array($result_tasks)) { 
						?>
								<tr>
									<td><?php echo $row['Agente']; ?></td>
									<td><?php echo $row['Nombre'] ?></td>
									<td><?php echo $row['Lugar'] ?></td>
									<td><?php echo $row['inicio'] ?></td>
									<td><?php echo $row['final'] ?></td>
									<td><?php echo $row['Transporte'] ?></td>
									<td><?php echo $row['Trabajo'] ?></td>							

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


