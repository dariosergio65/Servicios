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

$pantalla = 'modifint0';//ojo al cambiar el nombre del archivo php

$r=comprobar($usuario,$pantalla);
if($r=='disabled'){
    header ("location: " . $rutaindex);
    die();
}

$rutadb = $_SERVER['DOCUMENT_ROOT'] . '/servicios/db.php';
$rutaheader = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/header.php';
include ($rutadb);
include ($rutaheader); 
$vuelve= '/Servicios/Consultas/internos.php';
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
    $query="SELECT * FROM internos WHERE id = $id";
    $result=mysqli_query($conn,$query);
    //$registro = mysqli_num_rows($result);
    
    if ($result) {    
        $row = mysqli_fetch_array($result);
        $miinterno = $row['Interno'];
        $miid = $row['id'];
        $minombre = $row['Nombre'];
        $miapellido = $row['Apellido'];
        $miequipo = $row['Equipo'];
    }
}

if (isset($_POST['update'])) {
    $miinterno = $_POST['int'];
    $miid = $_POST['id'];
    $minombre = $_POST['nom'];
    $miapellido = $_POST['ape'];
    $miequipo = $_POST['equi'];

    $id = $_POST['id'];

    $query="UPDATE internos SET Interno = $miinterno, Nombre = '$minombre', Apellido = '$miapellido', Equipo = '$miequipo' WHERE id = $miid";
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
                    <div class="form-group">Interno: 
                        <input type="text" name="int" value="<?php echo $miinterno; ?>" class="form-control">
                    </div>
                    <div class="form-group">Nombre: 
                        <input type="text" name="nom" value="<?php echo $minombre; ?>" class="form-control">
                    </div>
                    <div class="form-group">Apellido: 
                        <input type="text" name="ape" value="<?php echo $miapellido; ?>" class="form-control">
                    </div>
                   
                    <div class="form-group">Equipo: 
                        <input type="text" name="equi" value="<?php echo $miequipo; ?>" class="form-control">
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