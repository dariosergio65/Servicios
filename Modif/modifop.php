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

$pantalla = 'modifop0';//ojo al cambiar el nombre del archivo php

$r=comprobar($usuario,$pantalla);
if($r=='disabled'){
    header ("location: " . $rutaindex);
    die();
}

$rutadb = $_SERVER['DOCUMENT_ROOT'] . '/servicios/db.php';
$rutaheader = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/header.php';
include ($rutadb);
include ($rutaheader); 
$vuelve= '/Servicios/abmb/abmop.php';
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
    $query="SELECT * FROM op WHERE OP = $id";
    $result=mysqli_query($conn,$query);
    //$registro = mysqli_num_rows($result);
    
    if ($result) {    
        $row = mysqli_fetch_array($result);
        $miop = $row['OP'];
        $micliente = $row['idCliente'];
        $mifechaoc = $row['FechaOC']; 
        $mifechatope = $row['FechaTope'];
        $mioc = $row['OC'];
        $micontacto = $row['ContactoC'];
        $mivendedor = $row['idVendedor'];
        $mimaterial = $row['Material'];
        $miobs = $row['OBS'];
        $mimoneda = $row['Moneda'];
        $mimonto = $row['Monto'];
    }
}

if (isset($_POST['update'])) {
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
    
    $id = $_POST['id']; 

    if ( is_null($mimonto) or (!isset($mimonto)) ){ 
        $mimonto=0; 
    }

    $query="UPDATE op SET OP = $miop, OC = '$mioc', idCliente = $micliente, FechaOC = STR_TO_DATE('$mifechaoc', '%Y-%m-%d'), FechaTope = STR_TO_DATE('$mifechatope', '%Y-%m-%d'), ContactoC = '$micontacto', idVendedor = $mivendedor, Material = '$mimaterial', OBS = '$miobs', Moneda = '$mimoneda', Monto = $mimonto WHERE OP = $id";

    $result=mysqli_query($conn,$query);

    if(!$result) {
        die("Algo fallo y no se pudo modificar el registro.");
    }

    $_SESSION['message'] = "Registro de OP actualizado con exito";
    $_SESSION['message_type'] = "success";
    header("location: " . $vuelve);
}
?>

<div class="container p-4">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card card-body">
                <form action="<?php echo $esta ?>" method="POST">
                    <div class="form-group">OP: 
                        <input type="text" name="op" value="<?php echo $miop; ?>" class="form-control">
                    </div>
                    <div class="form-group">OC: 
                        <input type="text" name="oc" value="<?php echo $mioc; ?>" class="form-control">
                    </div>
                    <div class="form-group">Cliente: 
                        <select name="cli" style="width: 50%">
                            <option value="0">Seleccione:</option>
                            <?php
                            $querycli="SELECT * FROM clientes";
                            $resultcli=mysqli_query($conn,$querycli);
                            while ($valores = mysqli_fetch_array($resultcli)) {
                                if ($micliente==$valores['id']){
                                    echo '<option value="' . $valores['id'] . '" selected>' . $valores['Cliente'] . '</option>';
                                }else{
                                    echo '<option value="' . $valores['id'] . '">' . $valores['Cliente'] . '</option>';    
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">Fecha de OC: 
                        <input type="date" name="FechaOC" value="<?php echo $mifechaoc; ?>" class="form-control">
                    </div>
                    <div class="form-group">Fecha Tope de Entrega: 
                        <input type="date" name="FechaTope" value="<?php echo $mifechatope; ?>" class="form-control">
                    </div>
                    <div class="form-group">Contacto: 
                        <input type="text" name="contacto" value="<?php echo $micontacto; ?>" class="form-control">
                    </div>
                    <div class="form-group">Vendedor: 
                        <select name="vendedor" style="width: 50%">
                            <option value="0">Seleccione:</option>
                            <?php
                            $queryven="SELECT * FROM vendedores";
                            $resultven=mysqli_query($conn,$queryven);
                            while ($val = mysqli_fetch_array($resultven)) {
                                if ($mivendedor==$val['id']){
                                    echo '<option value="' . $val['id'] . '" selected>' . $val['Vendedor'] . '</option>';
                                }else{
                                    echo '<option value="' . $val['id'] . '">' . $val['Vendedor'] . '</option>';    
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">Material: 
                        <textarea name="material" rows="3" class="form-control"> <?php echo $mimaterial; ?> </textarea>
                    </div>
                    <div class="form-group">Observaciones: 
                        <textarea name="obs" rows="3" class="form-control"> <?php echo $miobs; ?> </textarea>
                    </div>
                    <div class="form-group">Moneda: 
                        <input type="text" name="moneda" value="<?php echo $mimoneda; ?>" class="form-control">
                    </div>
                    <div class="form-group">Monto: 
                        <input type="text" name="monto" value="<?php echo $mimonto; ?>" class="form-control">
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