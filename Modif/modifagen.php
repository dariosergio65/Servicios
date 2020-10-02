<?php
$rutadb = $_SERVER['DOCUMENT_ROOT'] . '/servicios/db.php';
$rutaheader = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/header.php';
include ($rutadb);
include ($rutaheader); 
$vuelve= '/Servicios/abmb/agentes.php';
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
    $query="SELECT * FROM agentes WHERE dni = $id";
    $result=mysqli_query($conn,$query);
    //$registro = mysqli_num_rows($result);
    
    if ($result) {    
        $row = mysqli_fetch_array($result);
        $miagen = $row['Agente'];
        $miid = $row['dni'];
        $micelu = $row['Celular'];
        $midire = $row['Direccion'];
    }
}

if (isset($_POST['update'])) {
    $miagen = $_POST['agen'];
    $miid = $_POST['dni'];
    $micelu = $_POST['celu'];
    $misector = $_POST['sector'];
    $midire = $_POST['dire'];

    $id = $_POST['id'];

    $query="UPDATE agentes SET Agente = '$miagen', dni = '$miid', Celular = '$micelu', id_sector = $misector, Direccion = '$midire' WHERE dni = $id";
    $result=mysqli_query($conn,$query);

    if(!$result) {
        die("Algo fallo y no se pudo modificar el registro.");
    }

    $_SESSION['message'] = "Registro de Personal actualizado con exito";
    $_SESSION['message_type'] = "success";
    header("location: " . $vuelve);
}
?>

<div class="container p-4">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card card-body">
                <form action="<?php echo $esta ?>" method="POST">
                    <div class="form-group">Nombre: 
                        <input type="text" name="agen" value="<?php echo $miagen; ?>" class="form-control">
                    </div>
                    <div class="form-group">DNI: 
                        <input type="text" name="dni" value="<?php echo $miid; ?>" class="form-control">
                    </div>
                    <div class="form-group">Celular: 
                        <input type="text" name="celu" value="<?php echo $micelu; ?>" class="form-control">
                    </div>
                    <div class="form-group">Sector: 
                        <select name="sector" style="width: 50%">
                            <option value="0">Seleccione:</option>
                            <?php
                            $querysector="SELECT * FROM sectores";
                            $resultsector=mysqli_query($conn,$querysector);
                            while ($valores = mysqli_fetch_array($resultsector)) {
                                echo '<option value="' . $valores['id'] . '">' . $valores['Sector'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">Dirección: 
                        <input type="text" name="dire" value="<?php echo $midire; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">  
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