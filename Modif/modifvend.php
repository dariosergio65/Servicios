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
$vuelve= '/Servicios/abmb/vendedores.php';
$esta = $_SERVER['PHP_SELF'];
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

if (isset($_GET['id'])) {
    $id=$_GET['id'];
    $query="SELECT * FROM vendedores WHERE id = $id";
    $result=mysqli_query($conn,$query);
    //$registro = mysqli_num_rows($result);
    
    if ($result) {    
        $row = mysqli_fetch_array($result);
        $mivend = $row['Vendedor'];
        $miid = $row['id'];
    }
}

    if (isset($_POST['update'])) {
        $id=$_POST['miid'];
        $mivend=$_POST['vend'];

        $query="UPDATE vendedores SET Vendedor = '$mivend' WHERE id = $id";
        $result=mysqli_query($conn,$query);

        if(!$result) {
            die("Algo fallo y no se pudo modificar el registro.");
        }

        $_SESSION['message'] = "Registro de Vendedores actualizado con exito";
        $_SESSION['message_type'] = "success";
        header("location: " . $vuelve);
    }
?>

<div class="container p-4">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card card-body">
                <form action="<?php echo $esta ?>" method="POST">
                    <div class="form-group">
                        <input type="text" name="vend" value="<?php echo $mivend; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="miid" value="<?php echo $miid; ?>">  
                    </div>
                        <button class="btn btn-success" name="update">MODIFICAR
                        </button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php 
$rutafooter = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/footer.php';
include ($rutafooter); 
?>