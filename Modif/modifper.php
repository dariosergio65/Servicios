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
$vuelve= '/Servicios/abmb/permisos.php';
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

if (isset($_GET['idu'])) {
    $iduser=$_GET['idu'];
    $idpantalla=$_GET['idp'];
    $query="SELECT * FROM permisos WHERE id_usuario = '$iduser' AND id_pantalla = '$idpantalla'";
    $result=mysqli_query($conn,$query);
    //$registro = mysqli_num_rows($result);
    
    if ($result) {    
        $row = mysqli_fetch_array($result);
        $miperm = $row['permitido'];
        
    }
}

if (isset($_POST['update'])) {
    $miiduser = $_POST['usu'];
    $miidpantalla = $_POST['pant'];
    $miperm = $_POST['perm'];

    $query="UPDATE permisos SET permitido = $miperm WHERE id_usuario = '$miiduser' AND id_pantalla = '$miidpantalla'";
    $result=mysqli_query($conn,$query);

    if(!$result) {
        die("Algo fallo y no se pudo modificar el registro.");
    }

    $_SESSION['message'] = "Permiso de usuario actualizado con exito";
    $_SESSION['message_type'] = "success";
    header("location: " . $vuelve);
}
?>

<div class="container p-4">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card card-body">
                <form action="<?php echo $esta ?>" method="POST">
                    <div class="form-group">Usuario: 
                        <input type="text" name="usu" value="<?php echo $iduser; ?>" class="form-control">
                    </div>
                    <div class="form-group">Pantalla: 
                        <input type="text" name="pant" value="<?php echo $idpantalla; ?>" class="form-control">
                    </div>

                    <div class="form-group">Permitido: 
                        <select name="perm" style="width: 50%">
                            <option value="0">Seleccione:</option>
                            <?php $r = $miperm ? true : false ; ?>
                            <option value="0" <?php if (!$r){echo 'selected'; }; ?>>No autorizar</option>
                            <option value="1" <?php if ($r){echo 'selected'; }; ?>>Autorizar</option>
                            
                        </select>
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