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
$regreso = $_SERVER['DOCUMENT_ROOT'] . '/servicios/abmb/agentes.php';
?>

<?php

if (isset($_GET['id'])) {
    $id=$_GET['id'];
    //$query="DELETE FROM agentes where dni = $id";
    $query="UPDATE agentes SET activo=0 where dni = $id";
    $result=mysqli_query($conn,$query);

    if(!$result){
        die("No se pudo borrar el registro");
    }

    $_SESSION['message'] = 'Registro borrado';
    $_SESSION['message_type'] = 'danger';

    header("location: /servicios/abmb/agentes.php");

}
?>

<?php 
$rutafooter = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/footer.php';
include ($rutafooter); 
?>