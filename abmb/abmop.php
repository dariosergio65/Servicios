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

$pantalla = 'abmop0';//ojo al cambiar el nombre del archivo php

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
$rutaborrar = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/bajas/borraop.php';

// falta borraop.php modifop.php

?>

<div class="col-md-12 container p-2">
	<div class="row">
		<div class="col-md-11">
			<form action="<?php echo $esta ?>" method="POST">
							
				<table class="table table-bordered">
					<thead class="thead-cel" style="text-align:center">
						<tr>
							<th style="width: 50%">Orden de Pedido</th>
							<th style="width: 40%" colspan=2>Acciones</th>
						</tr>
					</thead>
					<tbody>
							<tr>
								<td><input text="op" name="op" style="width: 100%" placeholder="OP a buscar"></td>
								<td><input type="submit" name="Busca" value="Buscar" class="btn btn-secondary"></td>
								<td><a href="/Servicios/Altas/altaop.php?flag=0" class="btn btn-primary"> Nueva OP <i class="fa fa-cog fa-spin"></i>
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

		<div class="col-md-12">

				<table class="table table-sm table-bordered table-hover">
					<thead class="thead-dario" style="text-align:center">
						<tr>
							<th style="width: 5%">OP</th>
							<th style="width: 10%">OC</th>
							<th style="width: 10%">Cliente</th>
							<th style="width: 10%">Fecha de OC</th>
							<th style="width: 10%">Fecha Tope</th>
							<th style="width: 30%">Material</th>
							<th style="width: 15%">Observaciones</th>
							<th style="width: 10%">Acciones</th>
						<tr>
					</thead>
					<tbody>
						<?php
							if (isset($_POST['Busca'])){
								$miop=  $_POST['op'] ;
								//echo $miop;
								$query = "SELECT OP,OC,Cliente,FechaOC,FechaTope,Material,OBS FROM op LEFT JOIN clientes ON op.idCliente=clientes.id WHERE OP = $miop ";
							} 
							else{
								$query = "SELECT OP,OC,Cliente,FechaOC,FechaTope,Material,OBS FROM op LEFT JOIN clientes ON op.idCliente=clientes.id order by FechaOC desc";
							}
							unset($_POST['Busca']);
							$result_tasks = mysqli_query($conn,$query);
							

							if (!$result_tasks){
								$query = "SELECT * FROM op";
								$result_tasks = mysqli_query($conn,$query);
								echo 'ALGO SALIO MAL';
							}

							while ($row=mysqli_fetch_array($result_tasks)) { 
						?>
								<tr>
									<td><a href="../Buscar/VerOp.php?id=<?php echo $row['OP'] ?>"><?php echo $row['OP'] ?></a></td>
									<td><?php echo $row['OC'] ?></td>
									<td><?php echo $row['Cliente'] ?></td>
									<td><?php echo $row['FechaOC'] ?></td>
									<td><?php echo $row['FechaTope'] ?></td>
									<td><?php echo $row['Material'] ?></td>
									<td><?php echo $row['OBS'] ?></td>							

									<td>
										<a href="/Servicios/Modif/modifop.php?id=<?php echo $row['OP'] ?>" class= 
										"btn btn-primary btn-sm">
											Modif. <i class="fa fa-cog fa-spin"></i>
										</a>
									
										<a href="/Servicios/Bajas/borraop.php?id=<?php echo $row['OP'] ?>" class= 
										"btn btn-danger btn-sm"> <i class="far fa-trash-alt"></i>
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


