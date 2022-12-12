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

$pantalla = 'inge0';//ojo al cambiar el nombre del archivo php

$r=comprobar($usuario,$pantalla);
if($r=='disabled'){
    header ("location: " . $rutaindex);
    die();
}

$rutadb = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/db.php';
$rutaheader = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/includes/header.php';
include ($rutadb);
include ($rutaheader); 
$esta = $_SERVER['PHP_SELF'];
//$rutaborrar = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/bajas/borraop.php';

// falta borraop.php modifop.php

?>

<div class="col-md-12 container p-2">
	<div class="row">
		<div class="col-md-11">
			<form action="<?php echo $esta ?>" method="POST">
							
				<table class="table table-bordered">
					<thead class="thead-cel" style="text-align:center">
						<tr>
							<th style="width: 70%">Fechas de entrega de Ingeniería</th>
							<th style="width: 30%" colspan=2>Acciones</th>
						</tr>
					</thead>
					<tbody>
							<tr>
								<td><input text="op" name="op" style="width: 100%" value="<?php	if (isset($_POST['op'])){echo $_POST['op'];} ?>" placeholder="OP a buscar"></td>
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

		<div class="col-md-12">

				<table class="table table-sm table-bordered table-hover">
					<thead class="thead-dario" style="text-align:center">
						<tr>
							<th style="width: 5%">OP</th>
							<th style="width: 5%">OC</th>
							<th style="width: 10%">Cliente</th>
							<th style="width: 10%">Fecha de OC</th>
							<th style="width: 10%">Fecha Tope</th>
							<th style="width: 30%">Material</th>
							<th style="width: 10%">Ing Parcial</th>
							<th style="color:#990033;width: 10% ">Ing Final</th>
							<th style="width: 10%">Observaciones</th>
						<tr>
					</thead>
					<tbody>
						<?php
							if (isset($_POST['Busca'])){
								$miop =  $_POST['op'] ;
								/* if ( is_null($miop) or is_string($miop) ){ 
									$miop=0; 
								} */
								if ( $miop==0 ){ 
									$query = "SELECT op.OP as ope,OC,Cliente,FechaOC,FechaTope,Material,FechaingP,FechaingF,OBS FROM op 
									LEFT JOIN clientes ON op.idCliente=clientes.id
									LEFT JOIN estadosop ON op.OP=estadosop.OP 
									WHERE FechaingF IS NOT NULL AND FechaingF > 0 
									order by ope desc";
								}else{
									$query = "SELECT op.OP as ope,OC,Cliente,FechaOC,FechaTope,Material,FechaingP,FechaingF,OBS FROM op 
									LEFT JOIN clientes ON op.idCliente=clientes.id 
									LEFT JOIN estadosop ON op.OP=estadosop.OP
									WHERE op.OP = $miop ";
								}
							} 
							else{
								$query = "SELECT op.OP as ope,OC,Cliente,FechaOC,FechaTope,Material,FechaingP,FechaingF,OBS FROM op 
									LEFT JOIN clientes ON op.idCliente=clientes.id
									LEFT JOIN estadosop ON op.OP=estadosop.OP
									WHERE FechaingF IS NOT NULL AND FechaingF > 0 
									order by ope desc";
							}
							//unset($_POST['Busca']);
							$result_tasks = mysqli_query($conn,$query);
							

							if (!$result_tasks){
								$query = "SELECT * FROM op";
								$result_tasks = mysqli_query($conn,$query);
								echo 'ALGO SALIO MAL';
							}

							while ($row=mysqli_fetch_array($result_tasks)) { 
						?>
								<tr>
									<td><a href="../Buscar/VerOp.php?id=<?php echo $row['ope'] ?>"><?php echo $row['ope'] ?></a></td>
									<td><?php echo $row['OC'] ?></td>
									<td><?php echo $row['Cliente'] ?></td>
									<td><?php echo $row['FechaOC'] ?></td>
									<td><?php echo $row['FechaTope'] ?></td>
									<td><?php echo $row['Material'] ?></td>
									<td><?php echo $row['FechaingP'] ?></td>
									<td><?php echo $row['FechaingF'] ?></td>
									<td><?php echo $row['OBS'] ?></td>							
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


