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


<style type="text/css">
      .box1 {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        
      }

      .box1 div {
        width: 200px;
        height: 300px;
        border: blue solid 1px;
        margin: 5px;
        
      }
  </style>


            <div class="box1">
                <div> <a href="/Servicios/Costos/Celdas/CeldaA-SF6-375-L3.php"> <img src="../img/CeldaA-L3.bmp" width="190" height="290" /> </a>  </div>
                <div> <a href="/Servicios/Costos/Celdas/CeldaB-SF6-375-F3.php"> <img src="../img/CeldaB-F3.bmp" height="290"> </div> 
                <div> <a href="/Servicios/Costos/Celdas/Celda-PG-Entrada.php"> <img src="../img/PG-Entrada.bmp" width="190" height="290"> </div>
                <div> <a href="/Servicios/Costos/Celdas/PE-SF6-375-RC.php"> <img src="../img/PE-SF6-RC.bmp" width="190" height="290"> </div>
                <div> <a href="/Servicios/Costos/Celdas/CeldaTipoA.php"> <img src="../img/CeldaTipoA.bmp" width="190" height="290" /> </a>  </div>
                <div> <a href="/Servicios/Costos/Celdas/CeldaTipoB.php"> <img src="../img/CeldaTipoB.bmp" width="190" height="290"> </div>
            </div>

            <div class="box1">
                <div> <a href="/Servicios/Costos/Celdas/Metalclad-Ent-17-1250.php"> <img src="../img/Metalclad-Ent-13-1250.bmp" width="190" height="290" /> </a>  </div>
                <div> <a href="/Servicios/Costos/Celdas/Metalclad-Sal-17-1250.php"> <img src="../img/Metalclad-Sal-13-1250.bmp" width="190" height="290" /> </a>  </div>
                <div> <a href="/Servicios/Costos/Celdas/Metalclad-Aco-17-2000.php"> <img src="../img/Metalclad-Aco-13-2000.bmp" width="190" height="290" /> </a>  </div>
                <div> <a href="/Servicios/Costos/Celdas/Metalclad-Ent-33-1250.php"> <img src="../img/Metalclad-Ent-33-1250.bmp" width="190" height="290" /> </a>  </div>
                <div> <a href="/Servicios/Costos/Celdas/Metalclad-Sal-33-1250.php"> <img src="../img/Metalclad-Sal-33-1250.bmp" width="190" height="290" /> </a>  </div>
                <div> <a href="/Servicios/Costos/Celdas/Metalclad-Aco-33-2000.php"> <img src="../img/Metalclad-Aco-33-2000.bmp" width="190" height="290" /> </a>  </div>
            </div>


<?php
include ("../includes/footer.php");
?>