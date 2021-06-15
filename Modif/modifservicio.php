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
$vuelve= '/Servicios/buscar/tablero.php';
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
    $query="SELECT * FROM servicios WHERE id = $id";
    $result=mysqli_query($conn,$query);
    //$registro = mysqli_num_rows($result);
    
    if ($result) {    
        $row = mysqli_fetch_array($result);
        $minombre = $row['Nombre'];
        $miid = $row['id'];
        $miopref = $row['OpRef'];
        $micliente1 = $row['idCliente1'];
        $miopservicio = $row['OpServicio'];
        $micliente2 = $row['idCliente2'];
        $mitrabajo = $row['Trabajo'];
        $milugar = $row['Lugar'];
        $mifechaini = $row['FechaIni'];
        $mifechafin = $row['FechaFin'];
        $miestado = $row['id_estado'];
        $mitranspo = $row['id_transporte'];
        $miobs = $row['OBS'];
        $mifacturado = $row['Facturado'];
    }
}

if (isset($_POST['update'])) {

    $nunombre = $_POST['nombre'];
    $nuopref = $_POST['opref'];
    $nucliente1 = $_POST['idcliente1'];
    $nuopservicio = $_POST['opservicio'];
    $nucliente2 = $_POST['idcliente2'];
    $nutrabajo = $_POST['trabajo'];
    $nulugar = $_POST['lugar'];
    $nufechaini = $_POST['fechaini'];
    $nufechafin = $_POST['fechafin'];
    $nuestado = $_POST['estado'];
    $nutranspo = $_POST['transpo'];
    $nuobs = $_POST['obs'];
    $nufacturado = $_POST['fac'];

    $id = $_POST['id'];

    $query="UPDATE servicios SET Nombre = '$nunombre', OpRef = $nuopref, idCliente1 = $nucliente1, OpServicio = $nuopservicio, idCliente2 = $nucliente2, Trabajo = '$nutrabajo', Lugar = '$nulugar', FechaIni = '$nufechaini', FechaFin = '$nufechafin', id_estado = $nuestado, id_transporte = $nutranspo, OBS = '$nuobs', Facturado = '$nufacturado' WHERE id = $id";

    $result=mysqli_query($conn,$query);

    if(!$result) {
        die("Algo fallo y no se pudo modificar el registro.");
    }

    $_SESSION['message'] = "Registro de servicio actualizado con exito";
    $_SESSION['message_type'] = "success";
    header("location: " . $vuelve);
}
?>

<div class="container p-4">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body">
                <form action="<?php echo $esta ?>" method="POST">
                    <div class="form-group"><b>Nombre del Servicio: </b>
                        <b><input type="text" name="nombre" id="nombreservi" value="<?php echo $minombre; ?>" class="form-control"></b>
                    </div>
                    <div class="form-group"><b>Op Referencia: 
                        <select name="opref" style="width: 50%">
                                <option value="0">Seleccione:</option>
                                <?php
                                $queryop1="SELECT * FROM op";
                                $rop1=mysqli_query($conn,$queryop1);
                                while ($valores = mysqli_fetch_array($rop1)) {
                                    if ($miopref==$valores['OP']){
                                        echo '<option value="' . $valores['OP'] . '" selected>' . $valores['OP'] . '</option>';
                                    }else{
                                        echo '<option value="' . $valores['OP'] . '">' . $valores['OP'] . '</option>';
                                    }
                                }
                                ?>
                        </select>
                    </div>
                    <div class="form-group">Cliente Referencia: 
                        <select name="idcliente1" style="width: 50%">
                                <option value="0">Seleccione:</option>
                                <?php
                                $queryclientes="SELECT * FROM clientes";
                                $rclientes=mysqli_query($conn,$queryclientes);
                                while ($valores = mysqli_fetch_array($rclientes)) {
                                    if ($micliente1==$valores['id']){
                                        echo '<option value="' . $valores['id'] . '" selected>' . $valores['Cliente'] . '</option>';
                                    }else{
                                        echo '<option value="' . $valores['id'] . '">' . $valores['Cliente'] . '</option>';
                                    }
                                }
                                ?>
                        </select>
                    </div>
                    <div class="form-group">OP de Servicio: 
                        <select name="opservicio" style="width: 50%">
                                <option value="0">Seleccione:</option>
                                <?php
                                $queryop2="SELECT * FROM op";
                                $rop2=mysqli_query($conn,$queryop2);
                                while ($valores2 = mysqli_fetch_array($rop2)) {
                                    if ($miopservicio==$valores2['OP']){
                                        echo '<option value="' . $valores2['OP'] . '" selected>' . $valores2['OP'] . '</option>';
                                    }else{
                                        echo '<option value="' . $valores2['OP'] . '">' . $valores2['OP'] . '</option>';
                                    }
                                }
                                ?>
                        </select>
                    </div>
                    <div class="form-group">Cliente de Servicio: 
                        <select name="idcliente2" style="width: 50%">
                                <option value="0">Seleccione:</option>
                                <?php
                                $queryclientes="SELECT * FROM clientes";
                                $rclientes=mysqli_query($conn,$queryclientes);
                                while ($valores = mysqli_fetch_array($rclientes)) {
                                    if ($micliente2==$valores['id']){
                                        echo '<option value="' . $valores['id'] . '" selected>' . $valores['Cliente'] . '</option>';
                                    }else{
                                        echo '<option value="' . $valores['id'] . '">' . $valores['Cliente'] . '</option>';
                                    }
                                }
                                ?>
                        </select>
                    </div>

                    <div class="form-group">Lugar: 
                        <input type="text" name="lugar" value="<?php echo $milugar; ?>" class="form-control">
                    </div>
                    <div class="form-group">Trabajo Realizado:
                                    <textarea name="trabajo" value="" style="width: 100%" class="form-control"><?php echo $mitrabajo; ?></textarea>
                    </div>

                    <div class="form-group">Fecha Inicio del servicio: <input type="date" name="fechaini" value="<?php echo $mifechaini; ?>" >
                    </div>
                    <div class="form-group">Fecha de Fin del servicio: <input type="date" name="fechafin" value="<?php echo $mifechafin; ?>" >
                    </div>
                    <div class="form-group">Observaciones:
                        <textarea name="obs" rows="2" style="width: 100%" class="form-control"><?php echo $miobs; ?> </textarea>
                    </div>
                    <div class="form-group">Estado:
                        <select name="estado" style="width: 60%">
                            <option value="0">Seleccione:</option>
                            <?php $queryestado="SELECT * FROM estadoservi";
                            $restado=mysqli_query($conn,$queryestado);
                            while ($valores = mysqli_fetch_array($restado)) {
                                if ($miestado==$valores['id']){
                                    echo '<option value="' . $valores['id'] . '" selected>' . $valores['Estado'] . '</option>';
                                }else{
                                    echo '<option value="' . $valores['id'] . '">' . $valores['Estado'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">Transporte utilizado: 
                        <select name="transpo" style="width: 50%">
                                <option value="0">Seleccione:</option>
                                <?php
                                $querytrans="SELECT * FROM transportes";
                                $rtrans=mysqli_query($conn,$querytrans);
                                while ($valores = mysqli_fetch_array($rtrans)) {
                                    if ($mitranspo==$valores['id']){
                                        echo '<option value="' . $valores['id'] . '" selected>' . $valores['Transporte'] . '</option>';
                                    }else{
                                        echo '<option value="' . $valores['id'] . '">' . $valores['Transporte'] . '</option>';
                                    }
                                }
                                ?>
                        </select>
                    </div>

                    <div class="form-group">Facturado: </b>
                        <input type="text" name="fac" value="<?php echo $mifacturado; ?>" class="form-control">
                    </div>
                    <div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">  
                    </div> 
                    
                    <div>
                        <button class="btn btn-success" name="update"> MODIFICAR </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

var colornombre = document.getElementById("nombreservi");
colornombre.style.background = "yellow";
colornombre.style.color = "red";

</script>



<?php 
$rutafooter = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/footer.php';
include ($rutafooter); 
?>