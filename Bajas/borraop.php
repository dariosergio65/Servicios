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

$pantalla = 'borraop0';//ojo al cambiar el nombre del archivo php

$r=comprobar($usuario,$pantalla);
if($r=='disabled'){
    header ("location: " . $rutaindex);
    die();
}

$rutadb = $_SERVER['DOCUMENT_ROOT'] . '/servicios/db.php';
$rutaheader = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/header.php';
include ($rutadb);
include ($rutaheader); 
$regreso = $_SERVER['DOCUMENT_ROOT'] . '/servicios/abmb/abmop.php';
?>

<?php

if (isset($_GET['id'])) {
    $id=$_GET['id'];
    $query="DELETE FROM op where OP = $id";
    $result=mysqli_query($conn,$query);

    $queryest="DELETE FROM estadosop where OP = $id";
    $resultest=mysqli_query($conn,$queryest);

    $queryinfo="DELETE FROM infoop where OP = $id";
    $resultinfo=mysqli_query($conn,$queryinfo);

    if((!$result)  || (!$resultest)){
        die("No se pudo borrar el registro");
    }

    $_SESSION['message'] = 'Registro borrado';
    $_SESSION['message_type'] = 'danger';

    header("location: /servicios/abmb/abmop.php");

}
?>

<?php 
$rutafooter = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/footer.php';
include ($rutafooter); 
?>