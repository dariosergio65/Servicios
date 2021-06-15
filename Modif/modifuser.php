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
$vuelve= '/Servicios/abmb/usuarios.php';
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
    $miuser=$_GET['id'];
    $query="SELECT * FROM usuarios WHERE User = '$miuser'";
    $result=mysqli_query($conn,$query);
    //$registro = mysqli_num_rows($result);
    
    if ($result) {    
        $row = mysqli_fetch_array($result);
        $minombre = $row['Nombre'];
        $micat = $row['id_categoria'];
        $misector=$row['id_sector'];
        $miclave = $row['Clave'];
    }
}

if (isset($_POST['update'])) {
    $minombre = $_POST['nombre'];
    $micat = $_POST['cat'];
    $misector=$_POST['sec'];
    $miclave = $_POST['clave'];
    $miuser = $_POST['user'];

    $query="UPDATE usuarios SET Nombre = '$minombre', id_categoria = $micat, id_sector = $misector, Clave = '$miclave' WHERE User = '$miuser'";
    $result=mysqli_query($conn,$query);

    if(!$result) {
        die("Algo fallo y no se pudo modificar el registro.");
    }

    $_SESSION['message'] = "Registro de Usuarios actualizado con exito";
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
                        <input type="text" name="falsouser" style="background-color:yellow;" disabled value="<?php echo $miuser; ?> ">  
                </div>
                <div class="form-group">
                        <input type="hidden" name="user" value="<?php echo $miuser; ?> ">  
                </div> 

                    <div class="form-group">Nombre: 
                        <input type="text" name="nombre"  value="<?php echo $minombre; ?>" class="form-control">
                    </div>
                    <div class="form-group">Categoria: 
                        <select name="cat" style="width: 50%">
                            <option value="0">Seleccione:</option>
                            <?php
                            $querycat="SELECT * FROM categorias";
                            $resultcat=mysqli_query($conn,$querycat);
                            while ($valores = mysqli_fetch_array($resultcat)) {
                                if ($micat==$valores['id']){
                                    echo '<option value="' . $valores['id'] . '" selected>' . $valores['nombre'] . '</option>';
                                }else{
                                    echo '<option value="' . $valores['id'] . '">' . $valores['nombre'] . '</option>';    
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">Sector: 
                        <select name="sec" style="width: 50%">
                            <option value="0">Seleccione:</option>
                            <?php
                            $querysec="SELECT * FROM sectores";
                            $resultsec=mysqli_query($conn,$querysec);
                            while ($sec = mysqli_fetch_array($resultsec)) {
                                if ($micat==$sec['id']){
                                    echo '<option value="' . $sec['id'] . '" selected>' . $sec['Sector'] . '</option>';
                                }else{
                                    echo '<option value="' . $sec['id'] . '">' . $sec['Sector'] . '</option>';    
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">Clave: 
                        <input type="password" name="clave" value="<?php echo $miclave; ?>" class="form-control">
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