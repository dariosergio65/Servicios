<?php
session_start();
if (!isset($_SESSION['ingresado'])){
    header("location: index.php");
}
$usuario=$_SESSION['ingresado'];

$rutadb = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/db.php';
$rutaheader = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/includes/header.php';
include ($rutadb);
include ($rutaheader); 
$regreso = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/abmb/agente-servicio.php';
$regreso1 = '/Servicios/Buscar/detalleservicios.php';
?>

<?php

if (isset($_GET['agservid'])) {
    $id=$_GET['agservid'];
    $query="DELETE FROM agenteservicio where id = $id";
    $result=mysqli_query($conn,$query);

    if(!$result){
        die("No se pudo borrar el registro");
    }
    $_SESSION['message'] = 'Registro borrado';
    $_SESSION['message_type'] = 'danger';

    if (isset($_GET['flag1'])) {
        $idvuelta=$_GET['flag1'];
        $vuelve = "location: " . $regreso1 . "?id=" . $idvuelta;
        header($vuelve);
        die();
    }else{
        header("location: /Servicios/abmb/agente-servicio.php");
        die();
    }
}
?>

<?php 
$rutafooter = '/Servicios/includes/footer.php';
include ($rutafooter); 
?>