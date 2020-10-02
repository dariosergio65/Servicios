<?php
$rutadb = $_SERVER['DOCUMENT_ROOT'] . '/servicios/db.php';
$rutaheader = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/header.php';
include ($rutadb);
include ($rutaheader); 
$vuelve= '/Servicios/abmb/sectores.php';
$esta = $_SERVER['PHP_SELF'];
?>

<?php if (isset($_SESSION['message'])) { ?>

    <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
        <?= $_SESSION['message'] ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

<?php } session_unset(); ?>

<?php

if (isset($_GET['id'])) {
    $id=$_GET['id'];
    $query="SELECT * FROM sectores WHERE id = $id";
    $result=mysqli_query($conn,$query);
    //$registro = mysqli_num_rows($result);
    
    if ($result) {    
        $row = mysqli_fetch_array($result);
        $misector = $row['Sector'];
        $miid = $row['id'];
    }
}

    if (isset($_POST['update'])) {
        $id=$_POST['miid'];
        $misector=$_POST['sector'];

        $query="UPDATE sectores SET Sector = '$misector' WHERE id = $id";
        $result=mysqli_query($conn,$query);

        if(!$result) {
            die("Algo fallo y no se pudo modificar el registro.");
        }

        $_SESSION['message'] = "Sector actualizado con exito";
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
                        <input type="text" name="sector" value="<?php echo $misector; ?>" class="form-control">
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