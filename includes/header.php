<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SERVICIOS LAGO</title>
	<!-- BOOSTRAP 4 -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

	<!-- FONT AWSOME 5 -->
	<script src="https://kit.fontawesome.com/7c61217b20.js" crossorigin="anonymous"></script>

</head>
<body>

<?php 
    //if (!session_status()){ session_start(); }
    if (isset($_SESSION['ingresado'])){
        //header("location: index.php");
        $usuario=$_SESSION['ingresado'];
    }
    if (isset($usuario)){
      $rutadb = $_SERVER['DOCUMENT_ROOT'] . '/servicios/db.php';
      include ($rutadb); 
      $query = "SELECT Nombre FROM usuarios WHERE User like '$usuario'";
			$result_tasks = mysqli_query($conn,$query);
			while ($row=mysqli_fetch_array($result_tasks)) { 
			  $nombre= $row['Nombre'];
      }
    }
?>

<nav class="navbar navbar-dark bg-dark">

	<div class="container">

		<a href="/servicios/menu.php" class="navbar-brand">SERVICIOS LAGO</a>
    <h5 style="color:green;">Usuario: <?php if (isset($nombre)){ echo ' ' . $nombre;}?> </h5>
    <h5 style="color:green;">Fecha: <?php echo date('l jS \of F Y'); ?> </h5>
    <a href="/servicios/cierre.php" style="color:red;">Cerrar Sesión</a>
	
	</div>

</nav>

<style type="text/css">
  .container{
   text-align: center;
  }
  .table-striped tbody tr:nth-of-type(odd){
   background-color: rgb(237,245,245);
  }
  .table-hover tbody tr:hover{
   background-color: rgba(142,200,80, 0.7);
   color: rgb(0,0,0);
  }
  .thead-cel{
   background-color: rgb(0, 150, 200);
   color: black;
  }
  .thead-dario{
   background-color: rgb(125, 150, 75);
   color: black;
  }
</style>
