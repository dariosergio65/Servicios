<?php
session_start();
if (!isset($_SESSION['ingresado'])){
    header("location: index.php");
}
$usuario=$_SESSION['ingresado'];
//include("../includes/header.php"); 

include("../db.php");
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
    $addinfo = "/Servicios/Altas/altainfo.php?id=" . $id;

    $query="SELECT OP, OC, Cliente, FechaOC, FechaTope, Vendedor, ContactoC, Material, OBS, Moneda, Monto
        FROM op INNER JOIN clientes
        INNER JOIN vendedores 
        WHERE op.OP=$id AND op.idCliente = clientes.id AND op.idVendedor = vendedores.id";
    $result=mysqli_query($conn,$query);
    //$registro = mysqli_num_rows($result);
    if ($id == 0) { $result = NULL;}
    
    if (!is_null($result)) {    
        $row = mysqli_fetch_array($result);
        $miop = $row['OP'];
        $mioc = $row['OC'];
        $micliente = $row['Cliente'];
        $mifechaOC = date_format(date_create($row['FechaOC']),'d/m/Y');
        $mifechaT = date_format(date_create($row['FechaTope']),'d/m/Y');
        $mivendedor = $row['Vendedor'];
        $micontacto = $row['ContactoC'];
        $mimaterial = $row['Material'];
        $miobs = $row['OBS'];
        $mimoneda = $row['Moneda'];
        $mimonto = $row['Monto'];
        $e="";
    }else {
        $e="NO se encontró la OP";
    }

    if (!$result){
        $query = "SELECT OP, OC, Cliente, FechaOC, FechaTope, Vendedor, ContactoC, Material, OBS, Moneda, Monto
        FROM op WHERE OP=0";
        $result = mysqli_query($conn,$query);
        echo 'ALGO MAL';
    }

    //Para saber a que sector pertenece el usuario
    $querysector="SELECT u.Nombre,s.Sector as sector FROM usuarios u
    LEFT JOIN sectores s ON u.id_sector=s.id
    WHERE u.User LIKE '$usuario'";
    $resultsector=mysqli_query($conn,$querysector);
    
    if ($resultsector) {    
        $rowsector = mysqli_fetch_array($resultsector);
        $misector = $rowsector['sector']; //esta variable me da el sector
    }

}

?>

<?php include ("../includes/header.php"); ?>

<div class="col-md-12 container p-2">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-sm table-bordered">
                <thead class="thead-cel" style="text-align:center">
                    <tr>
                        <th> <h5 style="color:yellow"> OP:  <?php echo $miop; ?> </h5> </th>
                        <th >OC: <?php echo $mioc; ?></th>
                        <th >Fecha de OC: <?php echo $mifechaOC; ?></th>
                        <th >Fecha Tope: <?php echo $mifechaT; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align:left" colspan=2>Cliente: <?php echo $micliente; ?></td>
                        <td style="text-align:left" colspan=2>Contacto Cliente: <?php echo $micontacto; ?></td>
                    </tr>
                    <tr>
                        <td style="text-align:left" colspan=2 width=50%>Vendedor Lago: <?php echo $mivendedor; ?></td>
                        <td style="text-align:left" colspan=2>Monto total: <?php echo $mimoneda . " " . $mimonto; ?></td>
                    </tr>
                    <tr>
                        <th style="text-align:left" colspan=4>MATERIAL: </th>
                    </tr>
                    <tr>
                        <th BGCOLOR="#9b9b9b" style="text-align:left" colspan=4><?php echo $mimaterial; ?></th>
                    </tr>
                    <tr>
                        <td style="text-align:right" >Observaciones: </td>
                        <td style="text-align:left" colspan=3><?php echo $miobs; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div>
<h5  style="text-align:center;color:blue"  > ESTADOS DE LA OP POR SECTORES </h5>
</div>

<div class="col-md-12 container p-2">
    <div class="row">
        <div class="col-md-12">

            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">

                <?php
                $query1="SELECT * FROM estadosop WHERE OP = $id";

                $result1=mysqli_query($conn,$query1);
                
                if ($result1) {    
                    //$row1 = mysqli_fetch_array($result1);
                    //$miidp = $row1['idp'];
                }

                if(!$result1) {
                    die("Algo fallo y no se pudo CARGAR el registro.--");
                }

                $row1 = mysqli_fetch_array($result1);
                $btnModif= "/Servicios/Modif/modestop.php?id="
                    
                ?> 

                <table class="table table-sm table-bordered">
                    <thead class="thead-cel" style="text-align:center">
                        <tr>
                            <th colspan=2>Ingeniería 
                                <?php if ($misector=='Ingenieria' or $misector=='admin'){
                                    $ira=$btnModif.$row1['OP'].'&sector=inge'
                                ?>
                                    <a href="<?php echo $ira; ?>" style="background:yellow;color:red" class= "btn btn-primary btn-sm"> <i class="far fa-edit"> </i> </a>
                                <?php }  ?>
                            </th>
                            <th colspan=2>Fabricación 
                                <?php if ($misector=='Produccion' or $misector=='admin'){
                                    $ira=$btnModif.$row1['OP'].'&sector=prod'
                                ?>
                                    <a href="<?php echo $ira; ?>" style="background:yellow;color:red" class= "btn btn-primary btn-sm"> <i class="far fa-edit"> </i> </a>
                                <?php }  ?>
                            </th>
                            <th colspan=2>Inspección 
                                <?php if ($misector=='Gestion de Calidad' or $misector=='admin'){
                                    $ira=$btnModif.$row1['OP'].'&sector=gest'
                                ?>
                                    <a href="<?php echo $ira; ?>" style="background:yellow;color:red" class= "btn btn-primary btn-sm"> <i class="far fa-edit"> </i> </a>
                                <?php }  ?>
                            </th>
                            <th colspan=2>Despacho 
                                <?php if ($misector=='Despachos' or $misector=='admin'){
                                    $ira=$btnModif.$row1['OP'].'&sector=desp'
                                ?>
                                    <a href="<?php echo $ira; ?>" style="background:yellow;color:red" class= "btn btn-primary btn-sm"> <i class="far fa-edit"> </i> </a>
                                <?php }  ?>
                            </th>
                        </tr>
                        <tr>
                            <td>Parcial </td>
                            <td>Completa </td>
                            <td>Iniciada </td>
                            <td>Terminada </td>
                            <td>Iniciada </td>
                            <td>Terminada </td>
                            <td>Parcial </td>
                            <td>Completo </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <?php if ((($row1['ingP'])==1)){ ?>
                                        <i class="fa fa-check-square" aria-hidden="true"></i>
                                <?php }else{?>
                                        <i class="fa fa-square-o" aria-hidden="true"></i>
                                <?php }?>
                                <?php echo $row1['FechaingP']; ?>
                            </td>
                            <td>
                                <?php if ((($row1['ingF'])==1)){ ?>
                                        <i class="fa fa-check-square" aria-hidden="true"></i>
                                <?php }else{?>
                                        <i class="fa fa-square-o" aria-hidden="true"></i>
                                <?php }?>
                                <?php echo $row1['FechaingF']; ?>
                            </td>
                            <td>
                                <?php if ((($row1['fabi'])==1)){ ?>
                                        <i class="fa fa-check-square" aria-hidden="true"></i>
                                <?php }else{?>
                                        <i class="fa fa-square-o" aria-hidden="true"></i>
                                <?php }?>
                                <?php echo $row1['Fechafabi']; ?>
                            </td>
                            <td>
                                <?php if ((($row1['fabF'])==1)){ ?>
                                        <i class="fa fa-check-square" aria-hidden="true"></i>
                                <?php }else{?>
                                        <i class="fa fa-square-o" aria-hidden="true"></i>
                                <?php }?>
                                <?php echo $row1['FechaArm']; ?>
                            </td>
                            <td>
                                <?php if ((($row1['insP'])==1)){ ?>
                                        <i class="fa fa-check-square" aria-hidden="true"></i>
                                <?php }else{?>
                                        <i class="fa fa-square-o" aria-hidden="true"></i>
                                <?php }?>
                                <?php echo $row1['FechainsP']; ?>
                            </td>
                            <td>
                                <?php if ((($row1['insF'])==1)){ ?>
                                        <i class="fa fa-check-square" aria-hidden="true"></i>
                                <?php }else{?>
                                        <i class="fa fa-square-o" aria-hidden="true"></i>
                                <?php }?>
                                <?php echo $row1['FechainsF']; ?>
                            </td>
                            <td>
                                <?php if ((($row1['desP'])==1)){ ?>
                                        <i class="fa fa-check-square" aria-hidden="true"></i>
                                <?php }else{?>
                                        <i class="fa fa-square-o" aria-hidden="true"></i>
                                <?php }?>
                                <?php echo $row1['FechadesP']; ?>
                            </td>
                            <td>
                                <?php if ((($row1['desF'])==1)){ ?>
                                        <i class="fa fa-check-square" aria-hidden="true"></i>
                                <?php }else{?>
                                        <i class="fa fa-square-o" aria-hidden="true"></i>
                                <?php }?>
                                <?php echo $row1['FechadesF']; ?>
                            </td>

                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>


<h5 style="text-align:center;color:blue">EVOLUCIÓN HISTÓRICA DE LA OP <a href="<?php echo $addinfo; ?>"> <i class="fas fa-plus-circle"> </i> </a> </h5>

<div class="col-md-12 container p-2">
    <div class="row">
        <div class="col-md-12">

            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">

                <?php
                $query2="SELECT i.id as idi, i.FechaInfo as fechai, i.Informe as infoi, i.OBS as obsi, u.Nombre as nombreu, u.User as useru
                FROM op o
                LEFT JOIN infoop i ON o.OP=i.OP
                LEFT JOIN usuarios u ON i.Informo=u.User
                WHERE o.OP=$id ORDER BY i.FechaInfo DESC";

                $result2=mysqli_query($conn,$query2);
                
                if ($result2) {    
                    //$row1 = mysqli_fetch_array($result1);
                    //$miidp = $row1['idp'];
                }

                if(!$result2) {
                    die("Algo fallo y no se pudo CARGAR el registro.---");
                }
                ?> 

                <table class="table table-sm table-bordered">
                    <thead class="thead-cel" style="text-align:center">
                        <tr>
                            <th style="width: 10%">Fecha </th>
                            <th style="width: 55%">Informe </th>
                            <th style="width: 20%">Comentarios </th>
                            <th style="width: 10%">Usuario </th>
                            <th style="width: 5%">Acciones </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $borrap = "/Servicios/Bajas/borrainfo.php?flag1=" . $id . "&infoid=";
                    while ($row2=mysqli_fetch_array($result2)) {
                        $rmi=$row2['idi']; ?> 
                         
                        <tr>
                            <td>
                                <?php echo $row2['fechai']; ?>
                            </td>
                            <td>
                                <?php echo $row2['infoi']; ?>
                            </td>
                            <td>
                                <?php echo $row2['obsi']; ?>
                            </td>
                            <td>
                                <?php echo $row2['nombreu']; ?>
                            </td>
                            <td>
                                <?php if ($usuario==$row2['useru']){ ?>
                                    <a href="<?php echo $borrap . $rmi; ?>"> <i class="fas fa-minus-circle" style="color:red"> </i> </a>
                                <?php } ?>
                            </td>
                        </tr>

                    <?php }
                     ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

<?php include ("../includes/footer.php"); ?>