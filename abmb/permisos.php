<?php // error_reporting(1);  //SACAR ESTA LINEA CUANDO ANDE TODO 
?>
<?php
session_start();
if (!isset($_SESSION['ingresado'])){
	header("location: index.php");
}
$usuario=$_SESSION['ingresado'];

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
							<th style="width: 100%" colspan=4>Permisos de Usuario</th>
						</tr>
					</thead>

					<tbody>
						<?php

							if (isset($_POST['sele'])){
								$miuser=$_POST['miuser'];
								unset($_POST['sele']);
								$query = "SELECT User,usuarios.Nombre as nomu,categorias.nombre as nomc FROM usuarios
								INNER JOIN categorias ON usuarios.id_categoria=categorias.id
								WHERE User LIKE '$miuser' ";
								$rus=mysqli_query($conn,$query);
								if ($rus){ 
									$val = mysqli_fetch_array($rus); 
								}else{ 
									echo ' no entro, usuario: ' . $miuser; 
								}
							?>
								<tr>
								<input type="hidden" name="user" value="<?php echo $miuser; ?>" >
								
									<td>Nombre de Usuario: <?php echo $val['User'] . ' ' ?> </td>
									<td>usuario: <?php echo $val['nomu'] . ' ' ?> </td>
									<td>Categoría: <?php echo $val['nomc'] ?> </td>
									<td><input type="submit" name="cambiar" value="Cambiar Usuario" class="btn btn-secondary">
									</td>
								</tr>
							<?php
							}elseif (isset($_POST['cambiar'])){
								//$miuser=$_POST['miuser'];
								unset($_POST['cambiar']);
							?>
								<tr>
									<td>
										<select name="miuser" required style="width: 50%">
											<option value="0">Cambie el usuario:</option>
											<?php
											$queryusu="SELECT * FROM usuarios";
											$rusu=mysqli_query($conn,$queryusu);
											while ($valores = mysqli_fetch_array($rusu)) {
												echo '<option value="' . $valores['User'] . '">' . $valores['Nombre'] . '</option>';
											}
											?>
										</select>
									</td>
									<td><input type="submit" name="sele" value="Seleccionar" class="btn btn-secondary"></td>
								</tr>
							<?php	
							}else{?>
								<tr>
									<td>
										<select name="miuser" required style="width: 50%">
											<option value="0">Elija usuario:</option>
											<?php
											$queryu="SELECT * FROM usuarios";
											$ru=mysqli_query($conn,$queryu);
											while ($valor = mysqli_fetch_array($ru)) {
												echo '<option value="' . $valor['User'] . '">' . $valor['Nombre'] . '</option>';
											}
											?>
										</select>
									</td>
									<td><input type="submit" name="sele" value="Seleccionar" class="btn btn-secondary"></td>
								</tr>
							<?php	
							}
							//unset($_POST['nombreuser']);
							?>
								
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
						<th style="width: 15%">Codigo</th>
						<th style="width: 55%">Descripción</th>
						<th style="width: 15%">Permiso</th>
						<th style="width: 15%">Acciones</th>
					<tr>
				</thead>
				<tbody>
					<?php
						
						if (isset($miuser)){
							$query = "SELECT permisos.id_pantalla,permisos.permitido,pantallas.Descripcion FROM permisos 
							INNER JOIN pantallas ON permisos.id_pantalla=pantallas.id 
							WHERE permisos.id_usuario like '$miuser' ";
							//unset($_POST['Busca']);
							$result_tasks = mysqli_query($conn,$query);
							$totalreg = mysqli_num_rows($result_tasks);
							//echo 'Cantidad = '.$totalreg . '   ' ;
							//echo 'Usuario = '  . '   ';
							//echo 'Categoría = ' . '   ';
						}
						if (!$result_tasks){
							$query = "SELECT * FROM permisos";
							$result_tasks = mysqli_query($conn,$query);
							echo 'ALGO SALIO MAL';
						}

						while ($row=mysqli_fetch_array($result_tasks)) { ?>

							<tr>
								<td><?php echo $row['id_pantalla'] ?></td>
								<td><?php echo $row['Descripcion'] ?></td>

								<td> <input type="checkbox" id="per" name="permi[]" value="chb1" disabled <?php if ($row['permitido']==true){ echo 'checked';} ?> > </td>

								<td>
										<a href="/Servicios/Modif/modifper.php?idu=<?php echo $miuser . '&idp=' . $row['id_pantalla'] ?>" class= 
										"btn btn-primary btn-sm">
											Modificar <i class="fa fa-cog fa-spin"></i>
										</a>
								</td>
								
							</tr>	

						<?php } ?>
					
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php 
$rutafooter = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/footer.php';
include ($rutafooter); 
?>
