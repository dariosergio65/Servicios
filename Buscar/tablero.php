<?php // error_reporting(1);  //SACAR ESTA LINEA CUANDO ANDE TODO 
?>
<?php
$rutadb = $_SERVER['DOCUMENT_ROOT'] . '/servicios/db.php';
$rutaheader = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/header.php';
$NuevoServicio = $_SERVER['DOCUMENT_ROOT'] . '/servicios/Altas/altaservicio.php';
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
							<th>Nombre</th>
							<th>OP</th>
							<th>Lugar</th>
							<th colspan=4>Acciones</th>
						</tr>
					</thead>
					<tbody>
							<tr>
								<td><input text="nombre" name="nombre" style="width: 100%" placeholder="Nombre del servicio"></td>
								<td ><input text="op1" id="tdop" name="op1" value="" style="width: 100%" placeholder="Número de OP"></td>
								<script>
								var mitdop = document.getElementById("tdop");
								mitdop.style.background = "yellow";
								</script>
								<td><input text="lugar" name="lugar" style="width: 100%" placeholder="Lugar Donde se realizó el servicio"></td>

								<td><input type="submit" name="Busca" value="Buscar" class="btn btn-secondary"><td>
								<!-- <td><input type="submit" name="Nuevo" value="Nuevo servicio" class="btn btn-primary"><td> Falta el codigo de "Nuevo" -->
								<td>
								<a href="<?php echo '../Altas/altaservicio.php' ?>" class="btn btn-primary ">Nuevo Servicio </i>
								</a>
								</td>
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
							<th>Servicio</th>
							<th>OP</th>
							<th>Cliente OP</th>
							<th>OP Serv.</th>
							<th>Cliente Serv.</th>
							<th style="width: 20%">Trabajo Realizado</th>
							<th>Lugar</th>
							<th>Fecha inicio</th>
							<th>Fecha final</th>
							<th style="width: 9%">Acciones</th>
						<tr>
					</thead>
					<tbody>
						<?php
							if (isset($_POST['Busca'])){
								$op1fin=$_POST['op1'];
								if(($op1fin < 1)) {$op1fin=1;} 
								$nombrefin= '%' . $_POST['nombre'] . '%';
								$lugarfin= '%' . $_POST['lugar'] . '%';
//esto va a salir de varias tablas (OpRef = $op1fin OR OpServicio = $op1fin)
								if ($op1fin == 1){
									//$query = "SELECT * FROM servicios WHERE idCliente1 LIKE '$clientefin' AND Lugar LIKE '$lugarfin'";
															// falta operario y Vehiculo
									$query = "SELECT s.id, s.Nombre, s.OpRef, c.Cliente, s.OpServicio, s.idCliente2, s.Trabajo, s.Lugar, s.FechaIni, s.FechaFin FROM servicios s LEFT JOIN clientes c ON s.idCliente1=c.id WHERE s.nombre LIKE '$nombrefin' AND s.Lugar LIKE '$lugarfin'";
									//$qCliente2 = "SELECT c.Cliente FROM servicios s LEFT JOIN clientes c ON s.idCliente2=c.id WHERE idCliente1 LIKE '$clientefin' AND Lugar LIKE '$lugarfin'";
									$qCliente2 = "SELECT c.Cliente as cli2 FROM servicios s LEFT JOIN clientes c ON s.idCliente2=c.id WHERE s.nombre LIKE '$nombrefin' AND s.Lugar LIKE '$lugarfin'";
								}
								else{
									$query = "SELECT s.id, s.Nombre, s.OpRef, c.Cliente, s.OpServicio, s.idCliente2, s.Trabajo, s.Lugar, s.FechaIni, s.FechaFin FROM servicios s LEFT JOIN clientes c ON s.idCliente1=c.id WHERE (OpRef = $op1fin) OR (OpServicio = $op1fin)";
									$qCliente2 = "SELECT c.Cliente as cli2 FROM servicios s LEFT JOIN clientes c ON s.idCliente2=c.id WHERE (OpRef = $op1fin) OR (OpServicio = $op1fin)";
								}
							}elseif (isset($_GET['id'])) {
									$serviid=$_GET['id'];
									//echo 'nada';
									//echo $serviid;
									$query = "SELECT s.id, s.Nombre, s.OpRef, c.Cliente, s.OpServicio, s.idCliente2, s.Trabajo, s.Lugar, s.FechaIni, s.FechaFin FROM servicios s LEFT JOIN clientes c ON s.idCliente1=c.id WHERE (s.id = $serviid)";
									$qCliente2 = "SELECT c.Cliente as cli2 FROM servicios s LEFT JOIN clientes c ON s.idCliente2=c.id WHERE (s.id = $serviid)";
							} 
							else{
								$query = "SELECT s.id, s.Nombre, s.OpRef, c.Cliente, s.OpServicio, c.Cliente, s.Trabajo, s.Lugar, s.FechaIni, s.FechaFin FROM servicios s LEFT JOIN clientes c ON s.idCliente1=c.id ";
								$qCliente2 = "SELECT c.Cliente as cli2 FROM servicios s LEFT JOIN clientes c ON s.idCliente2=c.id ";
								//$query = "SELECT * FROM servicios"; s.idCliente2
							}
							unset($_POST['Busca']);
							$result_tasks = mysqli_query($conn,$query);
							if (isset($qCliente2)){
								$result_tasks2 = mysqli_query($conn,$qCliente2);
							}

							if (!$result_tasks){
								$query = "SELECT * FROM servicios";
								$result_tasks = mysqli_query($conn,$query);
								echo 'ALGO MAL';
							}

							while ($row=mysqli_fetch_array($result_tasks) and $row2=mysqli_fetch_array($result_tasks2)) { ?>
								<tr>
									<td><?php echo $row['Nombre'] ?></td>
									<td><a href="../Buscar/VerOp.php?id=<?php echo $row['OpRef'] ?>"><?php echo $row['OpRef'] ?>
										</a></td>
									<td><?php echo $row['Cliente'] ?></td>
									<td><a href="../Buscar/VerOp.php?id=<?php echo $row['OpServicio'] ?>"><?php echo $row['OpServicio'] ?>
										</a></td>
									<td><?php echo $row2['cli2'] ?></td>
									<td><?php echo $row['Trabajo'] ?></td>
									<td><?php echo $row['Lugar'] ?></td>
									<td><?php echo $row['FechaIni'] ?></td>
									<td><?php echo $row['FechaFin'] ?></td>
									<td>
										<a href="/Servicios/Buscar/detalle.php?id=<?php echo $row['id'] ?>" class= 
										"btn btn-warning btn-sm">D.</i>
										</a>
										
										<a href="/Servicios/Modif/modifservicio.php?id=<?php echo $row['id'] ?>" class= "btn btn-primary btn-sm"> <i class="fa fa-cog fa-spin"></i>
										</a>
									
										<a href="/Servicios/Bajas/borraservicio.php?id=<?php echo $row['id'] ?>" class="btn btn-danger btn-sm"> <i class="far fa-trash-alt"></i>
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


