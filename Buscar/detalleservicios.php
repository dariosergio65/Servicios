<?php
session_start();
if (!isset($_SESSION['ingresado'])){
    header("location: index.php");
}
$usuario=$_SESSION['ingresado'];

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
}  unset ($_SESSION['message']); 
//session_unset(); 

if (isset($_GET['id'])) {
    $id=$_GET['id'];

    $addPersonal = "/Servicios/Altas/alta-agenteservi.php?id=" . $id;
    $borrap = "/Servicios/Bajas/borraagserv.php?flag1=" . $id . "&agservid=";   //mas abajo agrega id de agenteservicio

    $query="SELECT s.id as id1, s.Nombre as snombre, s.OpRef as soperef, c.Cliente as cliref, s.OpServicio as sopserv, cc.Cliente as cliserv, s.Lugar as slugar, s.Trabajo as strab, s.FechaIni as sfechaini, s.FechaFin as sfechafin, s.OBS as sobs, s.Facturado as sfac, e.Estado as eestado, t.Transporte as trans
    FROM servicios s
    LEFT JOIN clientes c ON s.idCliente1=c.id
    LEFT JOIN clientes cc ON s.idCliente2=cc.id
    LEFT JOIN estadoservi e ON s.id_estado=e.id
    LEFT JOIN transportes t ON s.id_transporte=t.id
    WHERE s.id = $id";

    $result=mysqli_query($conn,$query);
    
    if ($result) {    
        $row = mysqli_fetch_array($result);
        $miid = $row['id1'];
        $minombre = $row['snombre'];
        $miopref = $row['soperef'];
        $miclienteref = $row['cliref'];
        $miopservicio = $row['sopserv'];
        $miclienteser = $row['cliserv'];
        $milugar = $row['slugar'];
        $mifechaini = $row['sfechaini'];
        $mifechafin = $row['sfechafin'];
        $mitrabajo = $row['strab'];
        $miobs = $row['sobs'];
        $mitransporte = $row['trans'];
        $miestado = $row['eestado'];
        $mifacturado = $row['sfac'];
        $facform = number_format($mifacturado, 2, '.', ' ');
    }

    if(!$result) {
        //echo $_POST['contacto'] . "<br>";
        //echo $_POST['vendedor'];
        die("Algo fallo y no se pudo CARGAR el registro-.");
    }
}
?>

<div class="container p-0">
    <div class="row">
        <div class="col-md-12 ">
            <h3>DETALLE DE SERVICIO  </h3>      
            <!-- <table class="table table-bordered"> -->
            <table class="table table-sm table-bordered">
                <thead class="thead-cel" style="text-align:center">
                    <tr>
                        <th colspan=2>Nombre: <input text="nombre" name="nombre" value="<?php echo $minombre; ?>" style="width: 80%" disabled></th>
                        <th colspan=2>Lugar: <input text="lugar" name="lugar" value="<?php echo $milugar; ?>" style="width: 80%" disabled></th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="text-align:left">
                        <td  colspan=2 >
                            OP de Referencia: <input text="opref" name="opref" value="<?php echo $miopref; ?>" style="width: 15%" disabled>
                        </td>
                        <td colspan=2>
                            OP de Servicio: <input text="opserv" name="opserv" value="<?php echo $miopservicio; ?>" style="width: 15%" disabled>
                        </td>
                    </tr>

                    <tr style="text-align:left">
                        <td colspan=2>
                            Cliente de Referencia: <input text="cli1" name="cli1" value="<?php echo $miclienteref; ?>" style="width: 70%" disabled>
                        </td>
                        <td colspan=2>
                            Cliente de Servicio: <input text="cli2" name="cli2" value="<?php echo $miclienteser; ?>" style="width: 70%" disabled>
                        </td>
                    </tr>
                    <tr>
                        <th BGCOLOR="#9b9b9b" style="text-align:left" colspan=4>
                            <div class="form-group">Trabajo Realizado
                                <textarea name="trabajo" rows="3" style="width: 100%" class="form-control" disabled> <?php echo $mitrabajo; ?></textarea>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th colspan=2>Fecha Inicio del servicio: <input type="date" name="fechaini" value="<?php echo $mifechaini; ?>" style="width: 30%" disabled></th>
                        <th colspan=2>Fecha de fin del  Servicio: <input type="date" name="fechafin" value="<?php echo $mifechafin; ?>" style="width: 30%" disabled></th>
                    </tr>
                    <tr>
                        <td style="text-align:left" colspan=3>
                            <div class="form-group">Observaciones
                                <textarea name="obs" rows="2"  style="width: 100%" class="form-control" disabled> <?php echo $miobs; ?> </textarea>
                            </div>
                        </td>
                        </td>
                        <td colspan=2>
                            Estado del Servicio: <input text="est" name="est" value="<?php echo $miestado; ?>" style="width: 60%" disabled>
                        </td>
                    </tr>
                    <tr>
                        <td colspan=2>
                            Vehículo: <input text="tra" name="tra" value="<?php echo $mitransporte; ?>" style="width: 80%" disabled>
                        </td>
                        <th colspan=2>
                            Facturado $: <input text="fac" name="fac" value="<?php echo $facform; ?>" style="width: 80%" disabled>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<h5 style="color:blue">PERSONAL LAGO <a href="<?php echo $addPersonal; ?>"> <i class="fas fa-plus-circle"> </i> </a> </h5>

<div class="col-md-12 container p-2">
    <div class="row">
        <div class="col-md-12">

            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">

                <?php
                $query1="SELECT s.id as idp, a.dni as midni, a.Agente as nom, ase.Fechaini as ini, ase.Fechafin as fin, ase.Cant_horas as trabajadas, ase.Valor_hora as valhora, ase.Valor_dia as valdia, ase.Dolarfecha as valdolar,
                (((SELECT DATEDIFF(ase.Fechafin , ase.Fechaini)+1)*ase.Valor_dia)+(ase.Cant_horas*ase.Valor_hora)) as totals,
                ((((SELECT DATEDIFF(ase.Fechafin , ase.Fechaini)+1)*ase.Valor_dia)+(ase.Cant_horas*ase.Valor_hora))/ase.Dolarfecha) as totaluss
                FROM servicios s 
                LEFT JOIN agenteservicio ase ON s.id=ase.id_servicio
                LEFT JOIN agentes a ON ase.id_agente=a.dni
                WHERE s.id = $id";

                $result1=mysqli_query($conn,$query1);
                
                if ($result1) {    
                    //$row1 = mysqli_fetch_array($result1);
                    //$miidp = $row1['idp'];
                    //$minombre = $row1['nom'];
                    //$miini = $row1['ini'];
                    //$mifin = $row1['fin'];
                    //$mitrabajada = $row1['trabajadas'];
                    //$mivalhora = $row1['valhora'];
                    //$mivaldia = $row1['valdia'];
                    //$mivaldolar = $row1['valdolar'];
                    //$mitotals = $row1['totals'];
                    //$mitotaluss = $row1['totaluss'];
                }

                if(!$result1) {
                    die("Algo fallo y no se pudo CARGAR el registro.--");
                }
                ?> 

                <table class="table table-sm table-bordered">
                    <thead class="thead-cel" style="text-align:center">
                        <tr>
                            <th >Nombre </th>
                            <th >Inicio </th>
                            <th >Fin </th>
                            <th >Trabajado (hs) </th>
                            <th >Valor hora </th>
                            <th >Valor dìa </th>
                            <th >Dolar Fecha </th>
                            <th >Total $ </th>
                            <th >Total US$ </th>
                            <th >Baja </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php // totalizadores
                        $sumapesos=0;
                        $sumauss=0; 
                    ?>
                    <?php while ($row1 = mysqli_fetch_array($result1)) { 
                        //formatos fecha y numeros
                        $fechai = new DateTime($row1['ini']);
                        $ini = date_format($fechai, 'd-m-Y');
                        $fechaf = new DateTime($row1['fin']);
                        $fin = date_format($fechaf, 'd-m-Y');
                        $totals=number_format($row1['totals'], 2, '.', ' ');
                        $totaluss=number_format($row1['totaluss'], 2, '.', ' ');
                        // SUMATORIA
                        $sumapesos=$sumapesos+$row1['totals'];
                        $sumauss=$sumauss+$row1['totaluss'];
                        // obener id del agenteservicio
                        $dni=$row1['midni'];
                        if($dni>0) {
                            $q2="SELECT id FROM agenteservicio WHERE id_servicio=$id AND id_agente=$dni";
                            $r2=mysqli_query($conn,$q2);
                            if(!$r2) {
                                die("Algo fallo y no se pudo CARGAR el registro---.");
                            }else{
                                $row2 = mysqli_fetch_array($r2);
                                $idag=$row2['id'];
                            }
                        }
                    ?> 
                        <tr>
                            <td>
                                <?php echo $row1['nom']; ?>
                            </td>
                            <td>
                                <?php echo $ini; ?>
                            </td>
                            <td>
                            <?php echo $fin; ?>
                            </td>
                            <td>
                                <?php echo $row1['trabajadas']; ?>
                            </td>
                            <td>
                                <?php echo $row1['valhora']; ?>
                            </td>
                            <td>
                                <?php echo $row1['valdia']; ?>
                            </td>
                            <td>
                                <?php echo $row1['valdolar']; ?>
                            </td>
                            <td>
                                <?php echo $totals; ?>
                            </td>
                            <td>
                                <?php echo $totaluss; ?>
                            </td>
                            <td>
                                <a href="<?php echo $borrap . $idag; ?>"> <i class="fas fa-minus-circle" style="color:red"> </i> </a>
                            </td>
                        </tr>
                    <?php }
                        // formatos
                        $clonsumapesos=$sumapesos; //para usarlo más adelante
                        $sumapesos=number_format($sumapesos, 2, '.', ' ');
                        $sumauss=number_format($sumauss, 2, '.', ' ');
                    ?>
                        <tr>
                            <th colspan=9 > </th>
                        </tr>
                        <tr>
                            <td colspan=6> </td>
                            <th>
                                SUMATORIA
                            </th>
                            <th>
                                <?php echo $sumapesos; ?>
                            </th>
                            <th>
                                <?php echo $sumauss; ?>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

<div class="container p-6">
    <div class="row">
        <div class="col-md-6 ">
            <h4>SALDO FINAL  </h4>  
            <table class="table table-sm table-bordered" style="text-align:right">
                <?php // total final
                    
                    //$sumapesos=number_format($sumapesos, 2, '.', ' ');
                    $mifacturado = (float) ($mifacturado);
                    $totalpesos =  $mifacturado - $clonsumapesos;
                    $mifacturado=number_format($mifacturado, 2, '.', ' ');
                    $clonsumapesos=number_format($clonsumapesos, 2, '.', ' ');
                    $totalpesos=number_format($totalpesos, 2, '.', ' ');
                ?>

                <tbody>
                    <tr>
                        <td >Total Facturado $ </td>
                        <td > <?php echo $mifacturado; ?> </td>
                    </tr>
                
                
                    <tr>
                        <td>Total Pagado $</td>
                        <td> <?php echo $clonsumapesos; ?>  </td>
                    </tr>
                    <tr>
                        <td>Total Gastos $</td>
                        <td style="color:magenta;"> <?php echo 'Faltan datos' ?>  </td>
                    </tr>
                </tbody>
                <tfoot class="tfoot-cel" style="text-align:right">
                    <tr>
                        <th>Resultado $ </th>
                        <th> <?php echo $totalpesos; ?></th>
                    </tr>
                </tfoot>
                
            </table>
        </div>
    </div>
</div>


<?php include ("../includes/footer.php") ?>