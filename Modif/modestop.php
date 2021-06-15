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

$rutadb = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/db.php';
$rutaheader = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/includes/header.php';
include ($rutadb);
include ($rutaheader); 
$vuelve= '/Servicios/Buscar/VerOp.php?id=';
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
    $secrecibido=$_GET['sector'];

    $queryest="SELECT * FROM estadosop WHERE OP = $id";
    $resultest=mysqli_query($conn,$queryest);

    $querysector="SELECT u.Nombre,s.Sector as sector FROM usuarios u
    LEFT JOIN sectores s ON u.id_sector=s.id
    WHERE u.User LIKE '$usuario'";
    $resultsector=mysqli_query($conn,$querysector);

    if ($resultest) {    
        $rowest = mysqli_fetch_array($resultest);
        $miop = $rowest['OP'];
        $ingparcial = $rowest['ingP'];
        $ingfechap = $rowest['FechaingP'];
        $ingcompleta = $rowest['ingF'];
        $ingfechac = $rowest['FechaingF'];
        $fabparcial = $rowest['fabi'];
        $fabfechap = $rowest['Fechafabi'];
        $fabcompleta = $rowest['fabF'];
        $fabfechac = $rowest['FechaArm'];
        $insparcial = $rowest['insP'];//
        $insfechap = $rowest['FechainsP'];
        $inscompleta = $rowest['insF'];
        $insfechac = $rowest['FechainsF'];
        $desparcial = $rowest['desP'];
        $desfechap = $rowest['FechadesP'];
        $descompleta = $rowest['desF'];
        $desfechac = $rowest['FechadesF'];
    } 
    if ($resultsector) {    
        $rowsector = mysqli_fetch_array($resultsector);
        $misector = $rowsector['sector'];
    }
    
}

if (isset($_POST['cancelar'])) {
    
    $id = $_POST['id'];

    header("location: " . $vuelve . $id);
}

if (isset($_POST['update'])) {
    $miop = $_POST['id'];

    if (isset($_POST['ingp']) && $_POST['ingp'] == '1'){//ingenieria
        $miingp = 1;
    }else{
        $miingp = 0;
    }
    if (isset($_POST['ingf']) && $_POST['ingf'] == '1'){
        $miingf = 1;
    }else{
        $miingf = 0;
    }
    $mifechaingp = $_POST['fechaingp']; 
    $mifechaingf = $_POST['fechaingf'];
    //fin ing

    if (isset($_POST['fabi']) && $_POST['fabi'] == '1'){//fabricacion
        $mifabp = 1;
    }else{
        $mifabp = 0;
    }
    if (isset($_POST['fabf']) && $_POST['fabf'] == '1'){
        $mifabf = 1;
    }else{
        $mifabf = 0;
    }
    $mifechafabp = $_POST['fechafabi']; 
    $mifechafabf = $_POST['fechafabf'];  
    //fin fab.

    if (isset($_POST['insp']) && $_POST['insp'] == '1'){//inspección
        $miinsp = 1;
    }else{
        $miinsp = 0;
    }
    if (isset($_POST['insf']) && $_POST['insf'] == '1'){
        $miinsf = 1;
    }else{
        $miinsf = 0;
    }
    $mifechainsp = $_POST['fechainsp']; 
    $mifechainsf = $_POST['fechainsf'];
    //fin insp.

    if (isset($_POST['desp']) && $_POST['desp'] == '1'){//despacho
        $midesp = 1;
    }else{
        $midesp = 0;
    }
    if (isset($_POST['desf']) && $_POST['desf'] == '1'){
        $midesf = 1;
    }else{
        $midesf = 0;
    }
    $mifechadesp = $_POST['fechadesp']; 
    $mifechadesf = $_POST['fechadesf']; 
    //fin desp. 
    
    $id = $_POST['id'];
    $sectoractual=$_POST['sectoroculto'];

    if ($sectoractual=='inge'){
        $query="UPDATE estadosop SET ingP = $miingp, FechaingP = STR_TO_DATE('$mifechaingp', '%Y-%m-%d'), ingF
        = $miingf, FechaingF = STR_TO_DATE('$mifechaingf', '%Y-%m-%d') 
        WHERE OP = $id";
    }

    if ($sectoractual=='prod'){
        $query="UPDATE estadosop SET fabi = $mifabp, Fechafabi = STR_TO_DATE('$mifechafabp', '%Y-%m-%d'), fabF
        = $mifabf, FechaArm = STR_TO_DATE('$mifechafabf', '%Y-%m-%d') 
        WHERE OP = $id";
    }

    if ($sectoractual=='gest'){
        $query="UPDATE estadosop SET insP = $miinsp, FechainsP = STR_TO_DATE('$mifechainsp', '%Y-%m-%d'), insF
        = $miinsf, FechainsF = STR_TO_DATE('$mifechainsf', '%Y-%m-%d') 
        WHERE OP = $id";
    }

    if ($sectoractual=='desp'){
        $query="UPDATE estadosop SET desP = $midesp, FechadesP = STR_TO_DATE('$mifechadesp', '%Y-%m-%d'), desF
        = $midesf, FechadesF = STR_TO_DATE('$mifechadesf', '%Y-%m-%d') 
        WHERE OP = $id";
    }

    $result=mysqli_query($conn,$query);

    if(!$result) {
        die("Algo fallo y no se pudo modificar el registro.");
    }

    $_SESSION['message'] = "Registro de OP actualizado con exito";
    $_SESSION['message_type'] = "success";
    header("location: " . $vuelve . $id);
}
?>

<div class="container p-4">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card card-body" style="background-color:yellow">
                <form action="<?php echo $esta ?>" method="POST">
                    <div class="form-group" style="text-align:left;color:blue" > <h5>OP:
                        <input type="text" style="width:20%;color:black;background-color:blue" name="op" disabled value="<?php echo $miop; ?> " class="form-group">
                        </h5> 
                    </div>
                    <div class="form-group" style="text-align:left">Sector: 
                        <input type="text" name="sector" value="<?php echo $misector; ?>" class="form-group" disabled>
                        <input type="hidden" name="sectoroculto" value="<?php echo $secrecibido; ?>">
                    </div>

                    <?php if ($secrecibido=='inge') {?>

                        <div class="form-group" style="text-align:center">
                        <?php if ($ingparcial==1){?>
                            <input type="checkbox" class="form-check-input" id="ingp" name="ingp" value="1" checked>
                        <?php }else{?>
                            <input type="checkbox" class="form-check-input" id="ingp" name="ingp" value="1">
                        <?php }?>
                        <label class="form-check-label" style="font-weight:bold" for="ingp">Ing. Parcial</label>
                        Fecha: <input type="date" name="fechaingp" value="<?php echo $ingfechap; ?>" class="form-group">
                        </div>

                        <div class="form-group" style="text-align:center">
                        <?php if ($ingcompleta==1){?>
                            <input type="checkbox" class="form-check-input" id="ingf" name="ingf" value="1" checked>
                        <?php }else{?>
                            <input type="checkbox" class="form-check-input" id="ingf" name="ingf" value="1">
                        <?php }?>
                        <label class="form-check-label" style="font-weight:bold" for="ingf">Ing. Total</label>
                        Fecha: <input type="date" name="fechaingf" value="<?php echo $ingfechac; ?>" class="form-group">
                        </div>

                    <?php }?>

                    <?php if ($secrecibido=='prod') {?>

                        <div class="form-group" style="text-align:center">
                        <?php if ($fabparcial==1){?>
                            <input type="checkbox" class="form-check-input" id="fabi" name="fabi" value="1" checked>
                        <?php }else{?>
                            <input type="checkbox" class="form-check-input" id="fabi" name="fabi" value="1">
                        <?php }?>
                        <label class="form-check-label" style="font-weight:bold" for="fabi">Fab. Parcial</label>
                        Fecha: <input type="date" name="fechafabi" value="<?php echo $fabfechap; ?>" class="form-group">
                        </div>

                        <div class="form-group" style="text-align:center">
                        <?php if ($fabcompleta==1){?>
                            <input type="checkbox" class="form-check-input" id="fabf" name="fabf" value="1" checked>
                        <?php }else{?>
                            <input type="checkbox" class="form-check-input" id="fabf" name="fabf" value="1">
                        <?php }?>
                        <label class="form-check-label" style="font-weight:bold" for="fabf">Fab. Terminada</label>
                        Fecha: <input type="date" name="fechafabf" value="<?php echo $fabfechac; ?>" class="form-group">
                        </div>

                    <?php }?>

                    <?php if ($secrecibido=='gest') {?>

                        <div class="form-group" style="text-align:center">
                        <?php if ($insparcial==1){?>
                            <input type="checkbox" class="form-check-input" id="insp" name="insp" value="1" checked>
                        <?php }else{?>
                            <input type="checkbox" class="form-check-input" id="insp" name="insp" value="1">
                        <?php }?>
                        <label class="form-check-label" style="font-weight:bold" for="insp">Inspección Parcial</label>
                        Fecha: <input type="date" name="fechainsp" value="<?php echo $insfechap; ?>" class="form-group">
                        </div>

                        <div class="form-group" style="text-align:center">
                        <?php if ($inscompleta==1){?>
                            <input type="checkbox" class="form-check-input" id="insf" name="insf" value="1" checked>
                        <?php }else{?>
                            <input type="checkbox" class="form-check-input" id="insf" name="insf" value="1">
                        <?php }?>
                        <label class="form-check-label" style="font-weight:bold" for="insf">Inspección Final</label>
                        Fecha: <input type="date" name="fechainsf" value="<?php echo $insfechac; ?>" class="form-group">
                        </div>

                    <?php }?>
                    <?php if ($secrecibido=='desp') {?>

                        <div class="form-group" style="text-align:center">
                        <?php if ($desparcial==1){?>
                            <input type="checkbox" class="form-check-input" id="desp" name="desp" value="1" checked>
                        <?php }else{?>
                            <input type="checkbox" class="form-check-input" id="desp" name="desp" value="1">
                        <?php }?>
                        <label class="form-check-label" style="font-weight:bold" for="desp">Despacho Parcial</label>
                        Fecha: <input type="date" name="fechadesp" value="<?php echo $desfechap; ?>" class="form-group">
                        </div>

                        <div class="form-group" style="text-align:center">
                        <?php if ($descompleta==1){?>
                            <input type="checkbox" class="form-check-input" id="desf" name="desf" value="1" checked>
                        <?php }else{?>
                            <input type="checkbox" class="form-check-input" id="desf" name="desf" value="1">
                        <?php }?>
                        <label class="form-check-label" style="font-weight:bold" for="desf">Despacho Total</label>
                        Fecha: <input type="date" name="fechadesf" value="<?php echo $desfechac; ?>" class="form-group">
                        </div>

                    <?php }?>

                   
                    <div class="form-group">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">  
                    </div> 
                        <button class="btn btn-success" name="update">MODIFICAR </button>
                        <button class="btn btn-success" name="cancelar">CANCELAR </button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php 
$rutafooter = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/includes/footer.php';
include ($rutafooter); 
?>