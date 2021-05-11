<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SERVICIOS LAGO</title>

</head>
<body>

<?php
    session_start();
    if (!isset($_SESSION['ingresado'])){
        header("location: index.php");
    }
?>

<h1>Hola <?= $_SESSION['ingresado'] ?>, bienvenido a Servicios Lago</h1>
<br><br>

<a href="cierre.php">Cerrar Sesión</a>

</body>
</html>