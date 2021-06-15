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

$pantalla = 'programados0';//ojo al cambiar el nombre del archivo php

$r=comprobar($usuario,$pantalla);
if($r=='disabled'){
    header ("location: " . $rutaindex);
    die();
}

include ("../db.php");
include ("../includes/header.php");
/* $rutadb = $_SERVER['DOCUMENT_ROOT'] . '/servicios/db.php';
$rutaheader = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/header.php';
include ($rutadb);
include ($rutaheader); 
$esta = $_SERVER['PHP_SELF'];
*/
?>

<div class="col-md-12 container p-2">
	<div class="row">
		<div class="col-md-11">
			<form action="<?php echo $esta; ?>" method="POST">
							
				<table class="table table-bordered">
					<thead class="thead-cel" style="text-align:center">
						<tr>
							<th colspan=3><h3>Servicios Programados</h3></th>
							<th colspan=4>Acciones</th>
						</tr>
					</thead>
					<tbody>
							<tr>
								<td><input text="nombre" name="nombre" style="width: 100%" placeholder="Nombre del servicio"></td>
								<td ><input text="op1" id="tdop" name="op1" value="" style="width: 100%" placeholder="Número de OP"></td>
								<script> // javascript para pintar el fondo del input text de la op
								var mitdop = document.getElementById("tdop");
								mitdop.style.background = "yellow";
								</script>
								<td><input text="lugar" name="lugar" style="width: 100%" placeholder="Lugar Donde se realizará el servicio"></td>

								<td><input type="submit" name="Busca" value="Buscar" class="btn btn-secondary"><td>
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
							<th style="width: 10%">Cliente Ref.</th>
							<th>OP Serv.</th>
							<th style="width: 10%">Cliente Serv.</th>
							<th style="width: 20%">Tarea a Realizar</th>
							<th>Lugar</th>
							<th>Fecha inicio</th>
							<th>Personal Designado</th>
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
									$query="SELECT s.id as id1, s.Nombre as snombre, s.OpRef as soperef, c.Cliente as cliref, s.OpServicio as sopserv, cc.Cliente as cliserv, s.Lugar as slugar, s.Trabajo as strab, s.FechaIni as sfechaini, e.Estado as eestado
									FROM servicios s
									LEFT JOIN clientes c ON s.idCliente1=c.id
									LEFT JOIN clientes cc ON s.idCliente2=cc.id
									LEFT JOIN estadoservi e ON s.id_estado=e.id
									WHERE (s.id_estado = 7) AND (s.Nombre LIKE '$nombrefin') AND (s.Lugar LIKE '$lugarfin')";
								}
								else{
									$query="SELECT s.id as id1, s.Nombre as snombre, s.OpRef as soperef, c.Cliente as cliref, s.OpServicio as sopserv, cc.Cliente as cliserv, s.Lugar as slugar, s.Trabajo as strab, s.FechaIni as sfechaini, e.Estado as eestado
									FROM servicios s
									LEFT JOIN clientes c ON s.idCliente1=c.id
									LEFT JOIN clientes cc ON s.idCliente2=cc.id
									LEFT JOIN estadoservi e ON s.id_estado=e.id
									WHERE (s.id_estado = 7) AND (s.OpRef = $op1fin or s.OpServicio = $op1fin)";
								}

							} 
							else{
								$query="SELECT s.id as id1, s.Nombre as snombre, s.OpRef as soperef, c.Cliente as cliref, s.OpServicio as sopserv, cc.Cliente as cliserv, s.Lugar as slugar, s.Trabajo as strab, s.FechaIni as sfechaini, e.Estado as eestado
								FROM servicios s
								LEFT JOIN clientes c ON s.idCliente1=c.id
								LEFT JOIN clientes cc ON s.idCliente2=cc.id
								LEFT JOIN estadoservi e ON s.id_estado=e.id
								WHERE s.id_estado = 7";
							}
							unset($_POST['Busca']);
							$result_tasks = mysqli_query($conn,$query);

							if (!$result_tasks){
								$query = "SELECT * FROM servicios order by FechaFin desc";
								$result_tasks = mysqli_query($conn,$query);
								echo 'ALGO MAL';
							}

							while ($row=mysqli_fetch_array($result_tasks)) { ?>
								<tr>
									<td><?php echo $row['snombre'] ?></td>
									<td><a href="../Buscar/VerOp.php?id=<?php echo $row['soperef'] ?>"><?php echo $row['soperef'] ?>
										</a></td>
									<td><?php echo $row['cliref'] ?></td>
									<td><a href="../Buscar/VerOp.php?id=<?php echo $row['sopserv'] ?>"><?php echo $row['sopserv'] ?>
										</a></td>
									<td><?php echo $row['cliserv'] ?></td>
									<td><?php echo $row['strab'] ?></td>
									<td><?php echo $row['slugar'] ?></td>
									<td><?php echo $row['sfechaini'] ?></td>
									<th style="color:magenta"> 
									<?php $idserv=$row['id1'];
										$query1="SELECT ag.dni as agdni, ag.Agente as agnombre
										FROM agentes ag
										LEFT JOIN agenteservicio agse ON ag.dni=agse.id_agente
										WHERE agse.id_servicio=$idserv"; 
										$rag = mysqli_query($conn,$query1);
										while ($row1=mysqli_fetch_array($rag)) {
											echo $row1['agnombre'] . '<br>';
										} 
									?>
									</th>
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


