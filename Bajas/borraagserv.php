<?php
$rutadb = $_SERVER['DOCUMENT_ROOT'] . '/servicios/db.php';
$rutaheader = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/header.php';
include ($rutadb);
include ($rutaheader); 
$regreso = $_SERVER['DOCUMENT_ROOT'] . '/servicios/abmb/agente-servicio.php';
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

    header("location: /servicios/abmb/agente-servicio.php");

}
?>

<?php 
$rutafooter = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/footer.php';
include ($rutafooter); 
?>