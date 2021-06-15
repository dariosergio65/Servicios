<?php
session_start();
if (!isset($_SESSION['ingresado'])){
    header("location: index.php");
}
$usuario=$_SESSION['ingresado'];

include ("../db.php");
include ("../includes/header.php");
include ("../includes/funciones.php");
//include_once ("funciones.js");
$vuelve= '/Servicios/Buscar/verop.php?id=';
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

if (isset($_POST['cancelar'])) {
    
    $id = $_POST['op'];

    header("location: " . $vuelve . $id);
}

if (isset($_POST['cargainfo'])) {
    $miop = $_POST['op'];//
    //$mifechafin = $_POST['fecha'];//la fecha la tomo del sistema
    $hoy = date("Y-m-d");
    $miinfo = $_POST['info'];
    $miobs = $_POST['obs'];

    if ( ($miinfo=='') or is_null($miinfo) ) { 
        $_SESSION['message'] = "Debe ingresar info de la OP";
        $_SESSION['message_type'] = "warning";
        header("location: " . $_SERVER['PHP_SELF']);
        die();
    }

    $query="INSERT INTO infoop (FechaInfo, OP, Informe, OBS, Informo)
    VALUES (STR_TO_DATE('$hoy', '%Y-%m-%d'),$miop,'$miinfo','$miobs','$usuario')";
    $result=mysqli_query($conn,$query);
    //$registro = mysqli_num_rows($result); 
    
    if ($result) {    
        $_SESSION['message'] = "Registro cargado con exito";
        $_SESSION['message_type'] = "success";
        if (isset($_POST['flag1'])) { 
            header("location: /Servicios/Buscar/VerOp.php?id=" . $miop);
        }else{
            header("location: " . $_SERVER['PHP_SELF']);
        }
    }

    if(!$result) {
        //echo $_POST['contacto'] . "<br>";
        //echo $_POST['vendedor'];
        die("Algo fallo y no se pudo CARGAR el registro.");
    }
}
?>

<div class="container p-1">

    <div class="row">
        <div class="col-md-11 ">
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                    
                <table class="table table-sm table-bordered">
                    <thead class="thead-cel" style="text-align:center">
                        <tr>
                            <?php if (isset($_GET['id'])) { 
                                $actualop=$_GET['id'];
                                }
                            ?>
                            <th colspan=2>
                                Informe de OP:
                                <input text="actual" name="actual" rows="2" value="<?php echo $actualop; ?>" style="width: 10%" disabled >
                                </text>
                                <input type="hidden" name="op" value="<?php echo $actualop; ?>">
                                <input type="hidden" name="flag1" value="nada">
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td style="text-align:left">
                                Informe de OP:
                                    <input text="info" name="info" rows="2" value="" style="width: 100%" >
                                    </text>
                            </td>
                            <td style="text-align:left" >
                                Observaciones:
                                    <input text="obs" name="obs" rows="2" value="" style="width: 100%">
                                    </text>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button class="btn btn-success" name="cargainfo">ACEPTAR </button>
                                <button class="btn btn-success" name="cancelar">CANCELAR </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>

</div>


<?php include ("../includes/footer.php") ?>