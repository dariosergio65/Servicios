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

$pantalla = 'tablero0';//ojo al cambiar el nombre del archivo php

$r=comprobar($usuario,$pantalla);
if($r=='disabled'){
    header ("location: " . $rutaindex);
    die();
}
$rutadb = $_SERVER['DOCUMENT_ROOT'] . '/servicios/db.php';
$rutaheader = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/header.php';
$NuevoServicio = $_SERVER['DOCUMENT_ROOT'] . '/servicios/Altas/altaservicio.php';
include ($rutadb);
include ($rutaheader); 
$esta = $_SERVER['PHP_SELF'];

$btnBuscar= (comprobar($usuario,'tablero1')=='enabled') ? 'enabled' : 'disabled';
$btnNuevo= (comprobar($usuario,'tablero2')=='enabled') ? '/Servicios/Altas/altaservicio.php?flag=0' : '"#"';
$btnDetalle= (comprobar($usuario,'tablero3')=='enabled') ? '/Servicios/Buscar/detalleservicios.php?id=' : '"#"';
$btnModif= (comprobar($usuario,'tablero4')=='enabled') ? '/Servicios/Modif/modifservicio.php?id=' : '"#"';
$btnBorrar= (comprobar($usuario,'tablero5')=='enabled') ? '/Servicios/Bajas/borraservicio.php?id=' : '"#"';
?>

<div class="col-md-12 container p-2">
	<div class="row">
		<div class="col-md-11">
			<form action="<?php echo $esta; ?>" method="POST">
							
				<table class="table table-sm table-bordered">
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
								<td>
									<input text="nombre" name="nombre" style="width: 100%" value="<?php	if (isset($_POST['nombre'])){echo $_POST['nombre'];} ?>" placeholder="Nombre del servicio">
								</td>
								<td >
									<input text="op1" id="tdop" name="op1" style="width: 100%" value="<?php	if (isset($_POST['op1'])){echo $_POST['op1'];} ?>" placeholder="Número de OP">
								</td>
								<script>
								var mitdop = document.getElementById("tdop");
								mitdop.style.background = "yellow";
								</script>
								<td>
									<input text="lugar" name="lugar" style="width: 100%" value="<?php	if (isset($_POST['lugar'])){echo $_POST['lugar'];} ?>" placeholder="Lugar donde se realizó el servicio">
								</td>

								<td><input type="submit" name="Busca" value="Buscar" class="btn btn-secondary" <?php echo $btnBuscar; ?> > <td>
								<!-- <td><input type="submit" name="Nuevo" value="Nuevo servicio" class="btn btn-primary"><td> Falta el codigo de "Nuevo" -->
								<td>
								<a href="<?php echo $btnNuevo; ?>" class="btn btn-primary ">Nuevo Servicio </i>
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

	<?php } unset($_SESSION['message']); ?>	


	<div class="row">

		<div class="col-md-12">

			<table class="table table-sm table-bordered table-hover">
				<thead class="thead-dario" style="text-align:center">
					<tr>
						<th>Servicio</th>
						<th>OP Ref.</th>
						<th>Cliente Ref.</th>
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
							if ($op1fin == 1){
									// falta operario y Vehiculo
								$query = "SELECT s.id as misid, s.Nombre  as snombre, s.OpRef as sopref, c.Cliente as cliente1, s.OpServicio as sopserv, cc.Cliente as cliente2, s.Trabajo as strabajo, s.Lugar as slugar, s.FechaIni as sini, s.FechaFin as sfin FROM servicios s 
								LEFT JOIN clientes c ON s.idCliente1=c.id 
								LEFT JOIN clientes cc ON s.idCliente2=cc.id
								WHERE s.nombre LIKE '$nombrefin' AND s.Lugar LIKE '$lugarfin' ORDER BY s.FechaFin DESC";
							}
							else{
								$query = "SELECT s.id as misid, s.Nombre as snombre, s.OpRef as sopref, c.Cliente as cliente1, s.OpServicio as sopserv, cc.Cliente as cliente2, s.Trabajo as strabajo, s.Lugar as slugar, s.FechaIni as sini, s.FechaFin as sfin FROM servicios s 
								LEFT JOIN clientes c ON s.idCliente1=c.id
								LEFT JOIN clientes cc ON s.idCliente2=cc.id 
								WHERE (OpRef = $op1fin) OR (OpServicio = $op1fin) ORDER BY s.FechaFin DESC";
							}
						}elseif (isset($_GET['id'])) {
								$serviid=$_GET['id'];
								$query = "SELECT s.id as misid, s.Nombre as snombre, s.OpRef as sopref, c.Cliente as cliente1, s.OpServicio as sopserv, cc.Cliente as cliente2, s.Trabajo as strabajo, s.Lugar as slugar, s.FechaIni as sini, s.FechaFin as sfin FROM servicios s 
								LEFT JOIN clientes c ON s.idCliente1=c.id 
								LEFT JOIN clientes cc ON s.idCliente2=cc.id
								WHERE (s.id = $serviid) ORDER BY s.FechaFin DESC";
						} 
						else{
							$query = "SELECT s.id as misid, s.Nombre as snombre, s.OpRef as sopref, c.Cliente as cliente1, s.OpServicio as sopserv, cc.Cliente as cliente2, s.Trabajo as strabajo, s.Lugar as slugar, s.FechaIni as sini, s.FechaFin as sfin FROM servicios s
							LEFT JOIN clientes c ON s.idCliente1=c.id 
							LEFT JOIN clientes cc ON s.idCliente2=cc.id
							ORDER BY s.FechaFin DESC";
						}
						unset($_POST['Busca']);
						$result_tasks = mysqli_query($conn,$query);
						$totalreg = mysqli_num_rows($result_tasks);
						echo 'TOTAL = '.$totalreg ;
						
						if (!$result_tasks){
							$query = "SELECT * FROM servicios order by FechaFin desc";
							$result_tasks = mysqli_query($conn,$query);
							echo 'ALGO MAL';
						}

						while ($row=mysqli_fetch_array($result_tasks)) { ?>
							<tr>
								<td><?php echo $row['snombre'] ?></td>
								<td><a href="../Buscar/VerOp.php?id=<?php echo $row['sopref'] ?>"><?php echo $row['sopref'] ?>
									</a></td>
								<td><?php echo $row['cliente1'] ?></td>
								<td><a href="../Buscar/VerOp.php?id=<?php echo $row['sopserv'] ?>"><?php echo $row['sopserv'] ?>
									</a></td>
								<td><?php echo $row['cliente2'] ?></td>
								<td><?php echo $row['strabajo'] ?></td>
								<td><?php echo $row['slugar'] ?></td>
								<td><?php echo $row['sini'] ?></td>
								<td><?php echo $row['sfin'] ?></td>
								<td>
									<a href="<?php echo $btnDetalle; echo $row['misid']; ?>" class= 
									"btn btn-success btn-sm"> <i class="fa fa-info-circle" aria-hidden="true"></i>
									</a>
									
									<a href="<?php echo $btnModif; echo $row['misid']; ?>" class= "btn btn-primary btn-sm"> <i class="far fa-edit	"></i>
									</a>
								
									<a href="<?php echo $btnBorrar; echo $row['misid']; ?>" class="btn btn-danger btn-sm"> <i class="far fa-trash-alt"></i>
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


