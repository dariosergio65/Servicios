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
$vuelve= '/Servicios/Buscar/verop.php?id=';
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
    $miingp = $_POST['ingp'];
    $mifechaingp = $_POST['fechaingp']; 
    $miingf = $_POST['ingf'];
    $mifechaingf = $_POST['fechaingf'];
    $mifabp = $_POST['fabi'];
    $mifechafabp = $_POST['fechafabp']; 
    $mifabf = $_POST['fabf'];
    $mifechafabf = $_POST['fechababf'];  
    $miinsp = $_POST['insp'];//
    $mifechainsp = $_POST['fechainsp']; 
    $miinsf = $_POST['insf'];
    $mifechainsf = $_POST['fechainsf'];
    $midesp = $_POST['desp'];
    $mifechadesp = $_POST['fechadesp']; 
    $midesf = $_POST['desf'];
    $mifechadesf = $_POST['fechadesf'];  
    
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
        = $midesf, FechaArm = STR_TO_DATE('$mifechadesf', '%Y-%m-%d') 
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
            <div class="card card-body">
                <form action="<?php echo $esta ?>" method="POST">
                    <div class="form-group" style="text-align:left;color:blue" > <h5>OP:
                        <input type="text" style="width:20%;color:yellow;background-color:blue" name="op" disabled value="<?php echo $miop; ?> " class="form-group">
                        </h5> 
                    </div>
                    <div class="form-group" style="text-align:left">Sector: 
                        <input type="text" name="sector" value="<?php echo $misector; ?>" class="form-group" disabled>
                        <input type="hidden" name="sectoroculto" value="<?php echo $secrecibido; ?>">
                    </div>

                    <?php if ($secrecibido=='inge') {?>

                        <div class="form-group" style="text-align:left">Parcial
                        <input type="text" style="width:10%" name="ingp" value="<?php echo $ingparcial; ?>" class="form-group" >
                        Fecha Parcial: <input type="date" name="fechaingp" value="<?php echo $ingfechap; ?>" class="form-group">
                        </div>
                        <div class="form-group" style="text-align:left">Final
                        <input type="text" style="width:10%" name="ingf" value="<?php echo $ingcompleta; ?>" class="form-group" >
                        Fecha Final: <input type="date" name="fechaingf"  value="<?php echo $ingfechac; ?>" class="form-group">
                        </div>

                    <?php }?>
                    <?php if ($secrecibido=='prod') {?>

                        <div class="form-group" style="text-align:left">Parcial
                        <input type="text" style="width:10%" name="fabi" value="<?php echo $fabparcial; ?>" class="form-group" >
                        Fecha Parcial: <input type="date" name="fechafabi" value="<?php echo $fabfechap; ?>" class="form-group">
                        </div>
                        <div class="form-group" style="text-align:left">Final
                        <input type="text" style="width:10%" name="fabf" value="<?php echo $fabcompleta; ?>" class="form-group" >
                        Fecha Final: <input type="date" name="fechafabf"  value="<?php echo $fabfechac; ?>" class="form-group">
                        </div>

                    <?php }?>
                    <?php if ($secrecibido=='gest') {?>

                        <div class="form-group" style="text-align:left">Parcial
                        <input type="text" style="width:10%" name="insp" value="<?php echo $insparcial; ?>" class="form-group" >
                        Fecha Parcial: <input type="date" name="fechainsp" value="<?php echo $insfechap; ?>" class="form-group">
                        </div>
                        <div class="form-group" style="text-align:left">Final
                        <input type="text" style="width:10%" name="insf" value="<?php echo $inscompleta; ?>" class="form-group" >
                        Fecha Final: <input type="date" name="fechainsf"  value="<?php echo $insfechac; ?>" class="form-group">
                        </div>

                    <?php }?>
                    <?php if ($secrecibido=='desp') {?>

                        <div class="form-group" style="text-align:left">Parcial
                        
                        <input type="text" style="width:10%" name="desp" value="<?php echo $desparcial; ?>" class="form-group" >
                        Fecha Parcial: <input type="date" name="fechadesp" value="<?php echo $desfechap; ?>" class="form-group">
                        </div>
                        <div class="form-group" style="text-align:left">Completo
                        <input type="text" style="width:10%" name="desf" value="<?php echo $descompleta; ?>" class="form-group" >
                        Fecha Final: <input type="date" name="fechadesf"  value="<?php echo $desfechac; ?>" class="form-group">
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
$rutafooter = $_SERVER['DOCUMENT_ROOT'] . '/servicios/includes/footer.php';
include ($rutafooter); 
?>