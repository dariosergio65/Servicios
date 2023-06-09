<?php
    session_start();
    if (!isset($_SESSION['ingresado'])){
        header("location: index.php");
        die();
    }
$rutaf = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/includes/funciones.php';
include ($rutaf);
$rutaindex = '/Servicios/index.php';
$usuario=$_SESSION['ingresado']; 

$pantalla = 'menuequipos';//ojo al cambiar nombre del archivo php

$r=comprobar($usuario,$pantalla);
if($r=='disabled'){
    header ("location: " . $rutaindex);
    die();
}
?>
<?php
include ("../includes/header.php");

for ($i=1; $i<19; $i++){
    $pantalla= 'menu' . $i;
    $r=(comprobar($usuario,$pantalla)=='enabled') ? 'enabled' : 'disabled';

    $btn[$i]=$r;
}
?>

<?php
if (isset($_POST['carga'])) {
    
    $rutacelda1 = '/Servicios/Costos/Celdas/Celda-PG-Entrada.php';
    $rutacelda2 = '/Servicios/Costos/Celdas/CeldaA-SF6-375-L3.php';
    $rutacelda3 = '/Servicios/Costos/Celdas/CeldaB-SF6-375-F3.php';

    $micelda = $_POST['celda'];

    switch ($micelda) {
        case 0:
            //
            //break;
        case 1:
            header("location: " . $rutacelda1);
            // así se pone en el servidor:
            echo '<meta http-equiv="refresh" content="0;url=' . $rutacelda1 . '" />';
            break;
        case 2:
            header("location: " . $rutacelda2);
            break;
        case 3:
            header("location: " . $rutacelda3);
            break;
    }

    // header("location: " . $_SERVER['PHP_SELF']);
    
    

}
?>

<div class="container p-4">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                
                Selecciona el equipo deseado:
                <select name="celda">
                    <!-- Opciones de la lista -->
                    <option value="1">PG-Entrada</option>
                    <!-- <option value="2" selected>Opción 2</option>  Opción por defecto -->
                    <option value="2">CELDA A SF6 375 mm -- L3</option>
                    <option value="3">CELDA B SF6 375 mm -- F3</option>
                </select>
                <div style="margin: 10px;">    
                <button class="btn btn-success" name="carga">Cargar Equipo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include ("../includes/footer.php");
?>