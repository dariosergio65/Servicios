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

$pantalla = 'altaop0';//ojo al cambiar el nombre del archivo php

$r=comprobar($usuario,$pantalla);
if($r=='disabled'){
    header ("location: " . $rutaindex);
    die();
}

include ("../db.php");
include ("../includes/header.php");
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
if (isset($_POST['cargaop'])) {
    $miop = $_POST['op'];
    $micliente = $_POST['cli'];
    $mifechaoc = $_POST['FechaOC']; 
    $mifechatope = $_POST['FechaTope'];
    $mioc = $_POST['oc'];
    $micontacto = $_POST['contacto'];
    $mivendedor = $_POST['vendedor'];
    $mimaterial = $_POST['material'];
    $miobs = $_POST['obs'];
    $mimoneda = $_POST['moneda'];
    $mimonto = $_POST['monto'];
    
    $query="INSERT INTO op (OP,OC,idCliente,FechaOC,FechaTope,ContactoC,idVendedor,Material,OBs,Moneda,Monto) 
    VALUES ($miop,'$mioc',$micliente,STR_TO_DATE('$mifechaoc', '%Y-%m-%d'),STR_TO_DATE('$mifechatope', '%Y-%m-%d'),
            '$micontacto',$mivendedor,'$mimaterial','$miobs','$mimoneda',$mimonto)";
    $result=mysqli_query($conn,$query);
    //$registro = mysqli_num_rows($result); 
    
    if ($result) {    
        $_SESSION['message'] = "Registro cargado con exito";
        $_SESSION['message_type'] = "success";
        header("location: " . $_SERVER['PHP_SELF']);
    }

    if(!$result) {
        echo $_POST['contacto'] . "<br>";
        echo $_POST['vendedor'] . "<br>";
        die("Algo fallo y no se pudo CARGAR el registro.");
    }
}
?>

<div class="container p-1">
    <div class="row">
        <div class="col-md-11 ">
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                    
                <table class="table table-bordered">
                    <thead class="thead-cel" style="text-align:center">
                        <tr>
                            <th colspan=2 width=50%>OP: <input text="op" name="op" value="" style="width: 100%" placeholder="Número de OP" required></th>
                            <th colspan=2>OC: <input text="oc" name="oc" value="" style="width: 100%" placeholder="Número de OC"></th>
                        </tr>
                    </thead>
                        <tbody>
                        <tr>
                            <th style="text-align:left" colspan=4>Cliente: 
                            <select name="cli">
                                <option value="0">Seleccione:</option>
                                <?php
                                $queryclientes="SELECT * FROM clientes";
                                $rclientes=mysqli_query($conn,$queryclientes);
                                while ($valores = mysqli_fetch_array($rclientes)) {
                                    echo '<option value="' . $valores['id'] . '">' . $valores['Cliente'] . '</option>';
                                }
                                ?>
                            </select>
                            </th>
                        </tr>
                        <tr>
                            <th colspan=2 width=50%>Fecha de OC: <input type="date" name="FechaOC" value="" style="width: 100%" ></th>
                            <th colspan=2>Fecha Tope: <input type="date" name="FechaTope" value="" style="width: 100%" ></th>
                        </tr>
                        <tr>
                            <th style="text-align:left" colspan=2>Vendedor Lago: 
                            <select name="vendedor">
                                <option value="0">Seleccione:</option>
                                <?php
                                $queryven="SELECT * FROM vendedores";
                                $rven=mysqli_query($conn,$queryven);
                                while ($valores1 = mysqli_fetch_array($rven)) {
                                    echo '<option value="' . $valores1['id'] . '">' . $valores1['Vendedor'] . '</option>';
                                }
                                ?>
                            </select>
                            </th>

                            <td style="text-align:left" colspan=2>Contacto Cliente: 
                            <input text="contacto" name="contacto" value="" style="width: 100%" placeholder="Nombre y celu"></td>
                        </tr>
                        <tr>
                            <th BGCOLOR="#9b9b9b" style="text-align:left" colspan=4>
                                <div class="form-group">MATERIAL
                                    <textarea name="material" rows="3" value="" style="width: 100%" class="form-control"
                                    placeholder="Productos vendidos"></textarea>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <td style="text-align:left" colspan=4>
                                <div class="form-group">Observaciones
                                    <textarea name="obs" rows="2" value="" style="width: 100%" class="form-control">
                                    </textarea>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:left">Moneda: 
                            <input text="moneda" name="moneda" value="" style="width: 50%" placeholder="U$S o $"></td>
                            <td style="text-align:left">Monto: 
                            <input text="monto" name="monto" value="" style="width: 60%"></td>
                            <td colspan="2">
                                <button class="btn btn-success" name="cargaop">
                                    CARGAR OP
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>


<?php include ("../includes/footer.php") ?>