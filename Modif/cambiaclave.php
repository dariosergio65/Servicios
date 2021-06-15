<?php
session_start();
if (!isset($_SESSION['ingresado'])){
    header("location: index.php");
}
$rutaf = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/includes/funciones.php';
include ($rutaf);
$rutaindex = '/Servicios/index.php';
$usuario=$_SESSION['ingresado']; 

$pantalla = 'cambiaclave0';//ojo al cambiar el nombre del archivo php

$r=comprobar($usuario,$pantalla);
if($r=='disabled'){
    header ("location: " . $rutaindex);
    die();
}
$rutadb = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/db.php';
$rutaheader = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/includes/header.php';
$NuevoServicio = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/Altas/altaservicio.php';
include ($rutadb);
include ($rutaheader); 
$esta = $_SERVER['PHP_SELF'];
$vuelta = '/Servicios/menu.php';
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
if (isset($_POST['cambia'])) {

    $mianterior = $_POST['anterior'];
    $minueva = $_POST['nueva'];
    $miconfirma = $_POST['confirma'];

    if (claveanterior($usuario, $mianterior)){
        //todo bien
    }else{
         echo '<div align="center"><br>';
        echo '<h5 style="color:red;"> CLAVE ANTERIOR INCORRECTA: </h5><br><br>'; ?>
        <a href=" <?php echo $esta ?>" > Volver </a> </div> <?php
        die();
    }

    $error_encontrado="";
    if (clavevalida($minueva, $error_encontrado)){
       //echo "PASSWORD VÁLIDO";
    }else{
        echo '<div align="center"><br>';
       echo '<h5 style="color:red;"> PASSWORD NO VÁLIDO: ' . $error_encontrado . '</h5><br><br>'; ?>
       <a href=" <?php echo $esta ?>" > Volver </a> </div> <?php
       die();
    }
 
    if (!($minueva==$miconfirma)) { // si no son iguales 
        echo '<div align="center"><br>'; 
        echo '<h5 style="color:red;"> La clave nueva y su cofirmacion no son iguales' . '</h5><br>';
        echo '<h5 style="color:red;"> Vuelva a la opción "Cambiar clave"' . '</h5><br>'; ?>
        <a href=" <?php echo $esta ?>" > Volver </a> </div> <?php
        die();
    }

    $minueva = encriptar($minueva);

    $query="UPDATE usuarios SET Clave = '$minueva' WHERE User = '$usuario'";
    $result=mysqli_query($conn,$query);
    
    if ($result) {    
        $_SESSION['message'] = "Clave nueva guardada";
        $_SESSION['message_type'] = "success";
        header("location: " . $vuelta);
        //echo '<meta http-equiv="refresh" content="0;url=' . $vuelta . '" />';
    }

    if(!$result) {
        //echo $_POST['contacto'] . "<br>";
        //echo $_POST['vendedor'];
        die("Algo fallo y no se pudo CAMBIAR la clave.");
    }
}
?>

<div class="container p-1">
    <div class="row" >
        <div class="col-md-7 ">
            
            <form action="<?php $_SERVER['PHP_SELF']; ?>"  method="POST">

                <table class="table table-bordered">
                    <thead class="thead-cel" style="text-align:center"> 
                        <tr>
                            <th>CAMBIO DE CONTRASEÑA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width=30%>Clave actual: 
                                <input type="password" name="anterior" class="form-control"  required>
                            </td>
                        </tr>
                        <tr>
                            <td>Contraseña nueva: 
                                <input type="password" name="nueva"  class="form-control" placeholder="mínimo 6 caracteres" required>
                            </td>
                        </tr>
                        <tr>
                            <td>Confirmación de contraseña: 
                                <input type="password" name="confirma"  class="form-control"  required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="hidden" name="id" value="<?php echo $usuario; ?>">  
                            </td> 
                        </tr>
                        <tr>
                            <td>
                                <button class="btn btn-success" name="cambia">
                                    ACEPTAR
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table> 
                            
            </form>
                    
        </div>
    </div>
</div>


<?php include ("../includes/footer.php"); ?>