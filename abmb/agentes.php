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

$pantalla = 'agentes0';//ojo al cambiar el nombre del archivo php

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
$rutaborrar = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/bajas/borraagen.php';
?>

<div class="col-md-12 container p-2">
	<div class="row">
		<div class="col-md-11">
			<form action="<?php echo $esta ?>" method="POST">
							
				<table class="table table-bordered">
					<thead class="thead-cel" style="text-align:center">
						<tr>
							<th style="width: 50%">Personal</th>
							<th style="width: 40%" colspan=2>Acciones</th>
						</tr>
					</thead>
					<tbody>
							<tr>
								<td><input text="est" name="agen" style="width: 100%" placeholder="Agente a buscar"></td>
								<td><input type="submit" name="Busca" value="Buscar" class="btn btn-secondary"></td>
								<td><a href="/Servicios/Altas/altaagen.php?flag=0" class="btn btn-primary"> Nuevo Agente <i class="fa fa-cog fa-spin"></i>
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
							<th style="width: 10%">DNI</th>
							<th style="width: 25%">Nombre</th>
							<th style="width: 10%">Celular</th>
							<th style="width: 10%">Apto Medico</th>
							<th style="width: 10%">Vence</th>
							<th style="width: 15%">Comm</th>
							<th style="width: 20%">Acciones</th>
						<tr>
					</thead>
					<tbody>
						<?php
							if (isset($_POST['Busca'])){
								$miagen= '%' . $_POST['agen'] . '%';
								$query = "SELECT dni,Agente,Celular,Estado,Vence,OBS FROM agentes LEFT JOIN estados ON agentes.id_estado=estados.id WHERE Agente like '$miagen' AND Activo=1";
							} 
							else{
								$query = "SELECT dni,Agente,Celular,Estado,Vence,OBS FROM agentes LEFT JOIN estados ON agentes.id_estado=estados.id WHERE Activo=1 order by Estado,Vence";
							}
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
									<td><?php echo $row['dni'] ?></td>
									<td><?php echo $row['Agente'] ?></td>
									<td><?php echo $row['Celular'] ?></td>

									<?php
										if ($row['Estado']=='Apto'){ ?>
											<td bgcolor="lightgreen"><?php echo $row['Estado'] ?></td>
										<?php
										}else{
										?>
											<td><?php echo $row['Estado'] ?></td>
										<?php
										}
									?>	

									<td><?php echo $row['Vence'] ?></td>
									<td><?php echo $row['OBS'] ?></td>							

									<td>
										<a href="/Servicios/Modif/modifagen.php?id=<?php echo $row['dni'] ?>" class= 
										"btn btn-primary btn-sm">
											Modificar <i class="fa fa-cog fa-spin"></i>
										</a>
									
										<a href="/Servicios/Bajas/borraagen.php?id=<?php echo $row['dni'] ?>" class= 
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


