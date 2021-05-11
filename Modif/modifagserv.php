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
$vuelve= '/Servicios/abmb/agente-servicio.php';
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

if (isset($_GET['agservid'])) {
    $id=$_GET['agservid'];
    $query="SELECT * FROM agenteservicio WHERE id = $id";
    $result=mysqli_query($conn,$query);
    //$registro = mysqli_num_rows($result);
    
    if ($result) {    
        $row = mysqli_fetch_array($result);
        $miagente = $row['id_agente'];
        $miid = $row['id'];
        $miservicio = $row['id_servicio'];
        $mifechaini = $row['Fechaini'];
        $mifechafin = $row['Fechafin'];
        $mihoras = $row['Cant_horas'];
        $mivalhora = $row['Valor_hora'];
        $mivaldia = $row['Valor_dia'];
        $midolar = $row['Dolarfecha'];
    }
}

if (isset($_POST['update'])) {

    $nuagente = $_POST['agente'];
    $nuservicio = $_POST['servi'];
    $nufechaini = $_POST['fechaini'];
    $nufechafin = $_POST['fechafin'];
    $nuhoras = $_POST['horas'];
    $nuvalhora = $_POST['valhora'];
    $nuvaldia = $_POST['valdia'];
    $nudolar = $_POST['dolar'];

    $id = $_POST['id'];

    $query="UPDATE agenteservicio SET id_agente = $nuagente, id_servicio = $nuservicio, Fechaini = '$nufechaini', Fechafin = '$nufechafin', Cant_horas = $nuhoras, Valor_hora = $nuvalhora, Valor_dia = $nuvaldia, Dolarfecha = $nudolar WHERE id = $id";

    $result=mysqli_query($conn,$query);

    if(!$result) {
        die("Algo fallo y no se pudo modificar el registro.");
    }

    $_SESSION['message'] = "Registro de relación agente-servicio actualizado con exito";
    $_SESSION['message_type'] = "success";
    header("location: " . $vuelve);
}
?>

<div class="container p-4">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body">
                <form action="<?php echo $esta ?>" method="POST">
                    <div class="form-group"><b>Nombre Agente: 
                        <select name="agente" id="nombreagente" style="width: 50%">
                                <option value="0">Seleccione:</option>
                                <?php
                                $queryag="SELECT dni,Agente FROM agentes";
                                $rag=mysqli_query($conn,$queryag);
                                while ($valores = mysqli_fetch_array($rag)) {
                                    if ($miagente==$valores['dni']){
                                        echo '<option value="' . $valores['dni'] . '" selected>' . $valores['Agente'] . '</option>';
                                    }else{
                                        echo '<option value="' . $valores['dni'] . '">' . $valores['Agente'] . '</option>';
                                    }
                                }
                                ?>
                        </select>
                    </div>
                    <div class="form-group"><b>Nombre Servicio: 
                        <select name="servi" id="nombreservi" style="width: 50%">
                                <option value="0">Seleccione:</option>
                                <?php
                                $queryservi="SELECT id,Nombre,FechaIni FROM servicios";
                                $rservi=mysqli_query($conn,$queryservi);
                                while ($valores = mysqli_fetch_array($rservi)) {
                                    if ($miservicio==$valores['id']){
                                        echo '<option value="' . $valores['id'] . '" selected>' . $valores['Nombre'] . '--Fecha: ' . $valores['FechaIni'] . '</option>';
                                    }else{
                                        echo '<option value="' . $valores['id'] . '">' . $valores['Nombre'] . '--Fecha: ' . $valores['FechaIni'] . '</option>';
                                    }
                                }
                                ?>
                        </select>
                    </div>

                    <div class="form-group">Fecha Inicio del servicio: <input type="date" name="fechaini" value="<?php echo $mifechaini; ?>" >
                    </div>
                    <div class="form-group">Fecha de Fin del servicio: <input type="date" name="fechafin" value="<?php echo $mifechafin; ?>" >
                    </div>
 
                    <div class="form-group">Horas Trabajadas: 
                        <input type="text" name="horas" value="<?php echo $mihoras; ?>" class="form-control">
                    </div>
                    <div class="form-group">Valor hora: 
                        <input type="text" name="valhora" value="<?php echo $mivalhora; ?>" class="form-control">
                    </div>
                    <div class="form-group">Valor día de servicio: 
                        <input type="text" name="valdia" value="<?php echo $mivaldia; ?>" class="form-control">
                    </div>
                    <div class="form-group">Valor Dolar fecha: 
                        <input type="text" name="dolar" value="<?php echo $midolar; ?>" class="form-control">
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

<script> //Codigo javascript

var colornombre = document.getElementById("nombreagente");
colornombre.style.background = "yellow";
//colornombre.style.color = "red";

var colorservi = document.getElementById("nombreservi");
colorservi.style.background = "yellow";
//colorservi.style.color = "red";

</script>



<?php 
$rutafooter = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/footer.php';
include ($rutafooter); 
?>