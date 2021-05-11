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

$pantalla = 'altaint0';//ojo al cambiar el nombre del archivo php

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
if (isset($_POST['cargaint'])) {
    $miinterno = $_POST['int'];
    $minombre = $_POST['nom'];
    $miapellido = $_POST['ape'];
    $miequipo = $_POST['equi'];

if (isset($_GET['flag'])) {
    $miflag = $_GET['flag'];
    if ($miflag == 0){
        $vuelta = '/Servicios/Consultas/internos.php';
    }
    if ($miflag == 1){ //falta completar altaint.php
        $vuelta = '/Servicios/Consultas/altaint.php';
    }
}
    
    $query="INSERT INTO internos (Interno,Nombre,Apellido,Equipo) VALUES ($miinterno, '$minombre', '$miapellido', '$miequipo')";
    $result=mysqli_query($conn,$query);
    //$registro = mysqli_num_rows($result); 
    
    if ($result) {    
        $_SESSION['message'] = "Registro cargado con exito";
        $_SESSION['message_type'] = "success";
        header("location: " . $vuelta);
    }

    if(!$result) {
        die("Algo fallo y no se pudo CARGAR el registro.");
    }
}
?>

<div class="container p-1">
    <div class="row" >
        <div class="col-md-5 ">
                <form action="<?php $_SERVER['PHP_SELF']; ?>"  method="POST">
                    <table class="table table-bordered">
                        <thead class="thead-cel" style="text-align:center">
                            <tr>
                                <th width=50%>INTERNO NUEVO: </th>
                            </tr>
                        </thead>
                         <tbody>
                            <tr>
                                <td>Número:<br><input text="int" name="int" style="width: 40%" placeholder="Número de interno" required></td>
                            </tr>
                            <tr>
                                <td>Nombre:<br><input text="nom" name="nom" style="width: 60%" placeholder="Nombre"></td>
                            </tr>
                            <tr>
                                <td>Apellido:<br><input text="nom" name="nom" style="width: 60%" placeholder="Apellido"></td>
                            </tr>
                            <tr>
                                <td>Equipo:<br><input text="nom" name="nom" style="width: 60%" placeholder="Equipo instalado"></td>
                            </tr>

                            <tr> 
                                <td>
                                    <button class="btn btn-success" name="cargaint">
                                        CARGAR INTERNO
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