<?php // error_reporting(1);  //SACAR ESTA LINEA CUANDO ANDE TODO 
?>
<?php
$rutadb = $_SERVER['DOCUMENT_ROOT'] . '/servicios/db.php';
$rutaheader = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/header.php';
include ($rutadb);
include ($rutaheader); 
$esta = $_SERVER['PHP_SELF'];
?>

<div class="col-md-12 container p-2">
	<div class="row">
		<div class="col-md-11">
			<form action="<?php echo $esta; ?>" method="POST">
							
				<table class="table table-bordered">
					<thead class="thead-cel" style="text-align:center">
						<tr>
							<th>OP</th>
							<th>Cliente</th>
							<th>Lugar</th>
							<th>Operario</th>
							<th>Vehículo</th>
							<th colspan=4>Acciones</th>
						</tr>
					</thead>
					<tbody>
							<tr>
								<td ><input text="op1" name="op1" value="" style="width: 100%" placeholder="Número de OP"></td>
								<td><input text="cliente" name="cliente" style="width: 100%" placeholder="Nombre del cliente"></td>
								<td><input text="lugar" name="lugar" style="width: 100%" placeholder="Lugar Donde se realizó el servicio"></td>
								<td><input text="operario" name="operario" style="width: 100%" placeholder="Nombre de nuestro personal"></td>
								<td><input text="vehiculo" name="vehiculo" style="width: 100%" placeholder="Transporte utilizado"></td>
								<td><input type="submit" name="Busca" value="Buscar" class="btn btn-secondary"><td>
								<td><input type="submit" name="Nuevo" value="Nuevo servicio" class="btn btn-primary"><td><!--falta el codigo -->
								
							</tr>		
					</tbody>
				</table>

			</form>
		</div>
	</div>	


	<div class="row">

		<div class="col-md-12">

				<table class="table table-sm table-bordered table-hover">
					<thead class="thead-dario" style="text-align:center">
						<tr>
							<th>OP</th>
							<th>Cliente</th>
							<th>OP Servicio</th>
							<th>Cliente</th>
							<th>Trabajo Realizado</th>
							<th>Lugar</th>
							<th>Fecha ini</th>
							<th>Fecha fin</th>
							<th>Acciones</th>
						<tr>
					</thead>
					<tbody>
						<?php
							if (isset($_POST['Busca'])){
								$op1fin=$_POST['op1'];
								if(($op1fin < 1)) {$op1fin=1;} 
								$clientefin= '%' . $_POST['cliente'] . '%';
								$lugarfin= '%' . $_POST['lugar'] . '%';
								$operariofin= '%' . $_POST['operario'] . '%';
								$vehiculofin= '%' . $_POST['vehiculo'] . '%';
//esto va a salir de varias tablas (OpRef = $op1fin OR OpServicio = $op1fin)
								if ($op1fin == 1){
									$query = "SELECT * FROM servicios WHERE idCliente1 LIKE '$clientefin'
																		AND Lugar LIKE '$lugarfin'";
															// falta operario y Vehiculo
								}
								else{
									$query = "SELECT * FROM servicios WHERE (OpRef = $op1fin)
																		OR (OpServicio = $op1fin)";
								}
									
							} 
							else{
								$query = "SELECT * FROM servicios";
							}
							unset($_POST['Busca']);
							$result_tasks = mysqli_query($conn,$query);

							if (!$result_tasks){
								$query = "SELECT * FROM servicios";
								$result_tasks = mysqli_query($conn,$query);
								echo 'ALGO MAL';
							}

							while ($row=mysqli_fetch_array($result_tasks)) { ?>
								<tr>
									<td><a href="../Buscar/VerOp.php?id=<?php echo $row['OpRef'] ?>"><?php echo $row['OpRef'] ?>
										</a></td>
									<td><?php echo $row['idCliente1'] ?></td>
									<td><a href="../Buscar/VerOp.php?id=<?php echo $row['OpServicio'] ?>"><?php echo $row['OpServicio'] ?>
										</a></td>
									<td><?php echo $row['idCliente2'] ?></td>
									<td><?php echo $row['Trabajo'] ?></td>
									<td><?php echo $row['Lugar'] ?></td>
									<td><?php echo $row['FechaIni'] ?></td>
									<td><?php echo $row['FechaFin'] ?></td>
									<td>
										<a href="../edit.php?id=<?php echo $row['id'] ?>" class= 
										"btn btn-warning btn-sm">
											Detalle </i>
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


