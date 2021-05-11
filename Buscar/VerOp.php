<?php
session_start();
if (!isset($_SESSION['ingresado'])){
    header("location: index.php");
}
$usuario=$_SESSION['ingresado'];

include("../db.php");

if (isset($_GET['id'])) {
    $id=$_GET['id'];
    //$query="SELECT * FROM op WHERE OP = $id";
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

}

?>

<?php include ("../includes/header.php"); ?>

<div class="col-md-12 container p-2">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead class="thead-cel" style="text-align:center">
                    <tr>
                        <th colspan=2 width=50%>OP: <?php echo $miop; ?></th>
                        <th colspan=2>OC: <?php echo $mioc; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th style="text-align:left" colspan=4>Cliente: <?php echo $micliente; ?></th>
                    </tr>
                    <tr>
                        <th colspan=2 width=50%>Fecha de OC: <?php echo $mifechaOC; ?></th>
                        <th colspan=2>Fecha Tope: <?php echo $mifechaT; ?></th>
                    </tr>
                    <tr>
                        <td style="text-align:left" colspan=2 width=50%>Vendedor Lago: <?php echo $mivendedor; ?></th>
                        <td style="text-align:left" colspan=2>Contacto Cliente: <?php echo $micontacto; ?></th>
                    </tr>
                    <tr>
                        <th style="text-align:left" colspan=4>MATERIAL: </th>
                    </tr>
                    <tr>
                        <th BGCOLOR="#9b9b9b" style="text-align:left" colspan=4><?php echo $mimaterial; ?></th>
                    </tr>
                    <tr>
                        <th style="text-align:left" colspan=4>Observaciones: </th>
                    </tr>
                    <tr>
                        <td style="text-align:left" colspan=4><?php echo $miobs; ?></td>
                    </tr>
                    <tr>
                        <td style="text-align:left" >Monto total: <?php echo $mimoneda . " " . $mimonto; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php include ("../includes/footer.php") ?>