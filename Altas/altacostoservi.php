<?php
// if (!session_status()){ session_start(); }
session_start();
if (!isset($_SESSION['ingresado'])){
	header("location: ../index.php");
	die();
}
$rutaf = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/includes/funciones.php';
include ($rutaf);
$rutaindex = '/Servicios/index.php';
$usuario=$_SESSION['ingresado']; 

$pantalla = 'costoservi0';//ojo al cambiar el nombre del archivo php

$r=comprobar($usuario,$pantalla);
if($r=='disabled'){
    header ("location: " . $rutaindex);
    die();
}
//if (!isset($_SESSION['ingresado'])){
//    header("location: /Servicios/index.php");
//}

include ("../db.php");
include ("../includes/header.php");
//include_once ("funciones.js");
?>

<?php if (isset($_SESSION['message'])) { ?>

    <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
        <?= $_SESSION['message'] ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

<?php
//session_unset();  

} unset ($_SESSION['message']);  // unset ($_SESSION['message']); 
//session_unset(); 

?>



<?php
if (isset($_POST['cargaservi'])) {
    $minombre = $_POST['nombre'];//
    $mifecha = $_POST['fecha'];
    $midolar = $_POST['dolar'];//
    $miidcliente = $_POST['idcliente']; //
    $mitrabajo = $_POST['trabajo'];//
    $milugar = $_POST['lugar'];//
    $mitiempo = $_POST['tiempo'];//
    $mipers = $_POST['pers'];//
    $mivalorhora = $_POST['valorhora'];// 
    $mibeneficio = $_POST['beneficio'];//
    $migg = $_POST['gg'];//
    $mihotel = $_POST['hotel'];
    $micomida = $_POST['comida'];//
    $mikmiv = $_POST['kmiv'];
    $mihorasv = $_POST['horasv'];
    $mikmc = $_POST['kmc'];//
    $mirps = $_POST['rps'];
    $miequip = $_POST['equip'];
    $miinsumos = $_POST['insumos'];

//////
}
?>





<?php

    // if ( is_null($mifac) or (!isset($mifac)) or is_string($mifac) ){ 
    //     $mifac=0; 
    // }

    //$query="INSERT INTO servicios (Nombre,OpRef,idCliente1,OpServicio,idCliente2,Trabajo,Lugar,FechaIni,FechaFin,id_estado,OBS,Facturado)
    //VALUES ('$minombre',$miopref,$miidcliente1,$miopservicio,$miidcliente2,'$mitrabajo','$milugar',STR_TO_DATE('$mifechaini', '%Y-%m-%d'),STR_TO_DATE('$mifechafin', '%Y-%m-%d'),$miestado,'$miobs',$mifac)";

    // $query="INSERT INTO servicios (Nombre,OpRef,idCliente1,OpServicio,idCliente2,Trabajo,Lugar,FechaIni,FechaFin,id_estado,id_transporte,OBS,Facturado) VALUES ('$minombre',$miopref,$miidcliente1,$miopservicio,$miidcliente2,'$mitrabajo','$milugar',STR_TO_DATE('$mifechaini', '%Y-%m-%d'),STR_TO_DATE('$mifechafin', '%Y-%m-%d'),$miestado,$mitranspo,'$miobs',$mifac)";

    // $result=mysqli_query($conn,$query);
    
    // if ($result) {    
    //     $_SESSION['message'] = "Registro cargado con exito";
    //     $_SESSION['message_type'] = "success";
    //     header("location: " . $_SERVER['PHP_SELF']);
    // }

    // if(!$result) {
    //     //echo $_POST['contacto'] . "<br>";
    //     //echo $_POST['vendedor'];
    //     die("Algo fallo y no se pudo CARGAR el registro.");
    // }
// }
//////


?>

<link rel="stylesheet" href="altacostoservi.css">

<!-- <div class="container p-1"> -->
<div class="col-md-12 container p-2">
    <div class="row">
        <div class="col-md-6 ">
            <!-- <form action="<?php //$_SERVER['PHP_SELF']; ?>" method="POST"> -->
            <form name="serv">
                    
                <table class="table table-bordered">
                    <thead class="thead-cel" id="imp1">
                        <tr>
                            <th colspan=4>Nombre del Servicio: <input text="nombre" name="nombre" value="" style="width: 70%" placeholder="Identificacion del servicio" required></th>
                        </tr>
                    </thead>
                    <tbody id="parte1">
                        <tr id="imp2">
                            <td colspan=2>Fecha: <input type="date" name="fecha" value="<?php echo date("Y-m-d");?>"  ></td>
                            <td colspan=2>
                            <input type="button" value="Dólar" class="traeDolar btn btn-success" ></div>
                                <input text="dolar" name="dolar" id="dolar" value=""  placeholder="Para decimales usar punto" style="width: 8em"></td>
                        </tr>
                        <tr id="imp3">
                            <td colspan=2 style="text-align:left" >Cliente: 
                            <select name="idcliente" id="idcliente" style="width: 70%">
                                <option value="0">Seleccione:</option>
                                <?php
                                $queryclientes="SELECT * FROM clientes";
                                $rclientes=mysqli_query($conn,$queryclientes);
                                while ($valores = mysqli_fetch_array($rclientes)) {
                                    echo '<option value="' . $valores['id'] . '">' . $valores['Cliente'] . '</option>';
                                }
                                ?>
                            </select>
                            </td>
                            <td colspan=2>Prov: 
                                <select id="miSelect" name="prov"></select>
                            </td>
                        </tr>
                        <tr >
                            <td BGCOLOR="#9b9b9b" style="text-align:left" colspan=4>
                                <div >Servicio a Realizar
                                    <textarea name="trabajo" id="imp4" rows="2" value="" style="width: 100%" class="form-control"
                                    >Trabajo a realizar</textarea>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan=1>Utilidad: <input type="number" id="beneficio" name="beneficio" min="0" max="400" value=35   style="width : 52px; background-color: yellow;"></td>
                            <td colspan=1>Gastos Generales: <input type="number" id="gg" name="gg" min="0" max="400" value=42  id="gg" style="width : 52px; background-color: yellow;"></td>
                            <td colspan=1>Costo hora U$S: <input text="valorhora" name="valorhora" id="valhora" value="14"  placeholder="punto para decimales" style="width: 30%"></td>
                        </tr>
                        <tr>
                            <td colspan=1>Personal: <input text="pers" name="pers" id="pers" value=""  placeholder="Cant empleades" style="width: 8em" required></td>
                            <td colspan=1>Tiempo: <input text="tiempo" name="tiempo" id="tiempo" value=""  placeholder="en días" style="width: 8em"> </td>
                            <td colspan=1>Rps $: <input text="rps" name="rps" id="rep" value="" placeholder="Punto para decimales"   style="width : 8em;"></td>
                        </tr>
                        <tr>
                            <td colspan=1>Alojamiento $: <input text="hotel" name="hotel" id="hotel" value="" placeholder="Costo diario de hotel"  style="width : 9em;"></td>
                            <td colspan=1>Comida $: <input text="comida" name="comida" id="comida" value="" placeholder="Costo diario de la comida"   style="width : 11em;"></td>
                            <td colspan=1>Equipamiento $: <input text="equip" name="equip" id="equip" value="" placeholder="Para decimales usar punto"   style="width : 10em;"></td>
                        </tr>
                        <tr>
                            <td colspan=1>Kilometros a destino: <input text="kmiv" name="kmiv" id="kmiv" value="" placeholder="Ida y vuelta"  style="width : 10em;"></td>
                            <td colspan=1>Km en campo: <input text="kmc" name="kmc" id="kmc" value="" placeholder="Estimados en campo"  style="width : 10em;"></td>
                            <td colspan=1>Insumos a proveer $: <input text="insumos" name="insumos" id="insumos" value="" placeholder="Para decimales usar punto"   style="width : 10em;"></td>
                        </tr>
                        <tr>
                            
                            
                            
                        </tr>
                    </tbody>
                </table>
                <div id="parte2">
                <input type="button" value="Calcular" onclick="javascript:costear()" class="calc btn btn-success" >
                    <!-- <button class="btn btn-success" name="cargaservi" id="calc">
                                    Calcular
                    </button> -->
                </div>
                
            </form>
        </div>

        <div class="col-md-5 div1 ">
        <div id="imp5">    
            <h4>Costos Directos</h4>
            <div class="cosdir">
                <div>
                    <label for="pers1">Personal: </label>
                    <input type="text" name="pers1" id="pers1" class="pers1" style="width : 6em;" disabled>
                </div>
                <div>
                    <label for="hotel1">Alojamiento: </label>
                    <input type="text" name="hotel1" id="hotel1" class="hotel1" style="width : 6em;" disabled>
                    </div>
                <div>
                    <label for="comida1">Comidas: </label>
                    <input type="text" name="comida1" id="comida1" class="comida1" style="width : 6em;" disabled>
                </div>
                <div>
                    <label for="transporte1">Transporte: </label>
                    <input type="text" name="transporte1" id="transporte1" class="transporte1" style="width : 6em;" disabled>
                </div>
                <div>
                    <label for="rep1" >Repuestos: </label>
                    <input type="text" name="rep1" id="rep1" class="r" value=""  style="width : 6em;" disabled>
                </div>
                <div>
                    <label for="equip1">Equipamiento: </label>
                    <input type="text" name="equip1" id="equip1" class="equip1" style="width : 6em;" disabled>
                </div>
                <div>
                    <label for="insumos1">Insumos: </label>
                    <input type="text" name="insumos1" id="insumos1" class="insumos1" style="width : 6em;" disabled>
                </div>

                <br>
                <div>
                    <b><label for="costod"> Total de Costos Directos U$S: </label>
                    <input type="text" name="costod" id="costod" class="costod" style="width : 6em;" disabled></b>
                </div>
            </div>
            <hr>
            <div class="costoi">
                <label for="costoi"> <h4>Total de Costos Indirectos: </h4> </label>
                <input type="text" name="costoi" id="costoi" class="costoi" style="width : 8em;" disabled>
            </div>
            <hr>
            <div class="total">
                <div class="ct">
                    <label for="ct"><h4>Costo Total: </h4> </label>
                    <input type="text" name="ct" id="ct" class="ct" style="width : 8em;" disabled>
                </div>
            </div>
            <hr>
            <div class="util-ib">
                <div class="ut-ib">
                    <div >
                        <label for="util"><h4>Utilidad: </h4> </label>
                        <input type="text" name="util" id="util" class="util"  disabled>
                    </div>
                    <div>
                        <label for="ibrut"><h4>IIBB: </h4> </label>
                        <input type="text" name="ibrut" id="ibrut" class="ibrut" style="width:5em;" disabled>
                    </div>
                </div>
            </div>
            <hr>
            <div class="precioFinal">
                <div class="final">
                    <div>
                        <label for="siniva"><h4>   Precio Final sin IVA:  </h4> </label>
                        
                        <input type="text" name="siniva" id="siniva" class="siniva" style="width : 8em;" disabled>
                        
                    </div>
                    <div>
                        <label for="coniva"><h4>Precio Final con IVA: </h4> </label>
                        <input type="text" name="coniva" id="coniva" class="coniva" style="width : 8em;" disabled>
                    </div>
                </div>
            </div>
        </div>
            <hr>
            <div class="imprimir">
                <button type="button" class="btn btn-success" onclick="javascript:printContent();">Imprimir</button>
                <a href="">Guardar</a>
            </div>
        </div>
    </div>
</div>

<script src="../Altas/altacostoservi.js"></script>

<?php include ("../includes/footer.php") ?>