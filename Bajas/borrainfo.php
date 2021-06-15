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
$regreso = '/Servicios/Buscar/VerOp.php';
?>

<?php if (isset($_SESSION['message'])) { ?>

<div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
    <?= $_SESSION['message'] ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<?php } unset($_SESSION['message']); ?>	


<?php

if (isset($_GET['infoid'])) {
    $id=$_GET['infoid'];
    $query="DELETE FROM infoop where id = $id";
    $result=mysqli_query($conn,$query);

    if(!$result){
        die("No se pudo borrar el registro");
    }
    $_SESSION['message'] = 'Registro borrado';
    $_SESSION['message_type'] = 'danger';

    $idvuelta=$_GET['flag1'];
    $vuelve = "location: " . $regreso . "?id=" . $idvuelta;
    header($vuelve);
    die();
}
?>

<?php 
$rutafooter = '/Servicios/includes/footer.php';
include ($rutafooter); 
?>