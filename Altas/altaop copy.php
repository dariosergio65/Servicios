<?php
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

<?php } session_unset(); ?>

<?php
if (isset($_POST['cargaop'])) {
    $miop = $_POST['op'];
    $micliente = $_POST['cli'];
    $mifechaoc = $_POST['FechaOC']; 
    $mifechatope = $_POST['FechaTope'];
    $mioc = $_POST['oc'];
    $micontacto = $_POST['contacto'];
    //$mivendedor = $_POST['vendedor'];
    //$mimaterial = $_POST['material'];
    //$miobs = $_POST['obs'];
    
    //$query="INSERT INTO op (OP,Cliente,FechaOC,FechaTope,OC,ContactoC,Vendedor,Material,OBS) 
      //      VALUES ($miop,$micliente,$mifechaOC,$mifechatope,$mioc,$micontacto,$mivendedor,$mimaterial,$miobs)";
    //$query="INSERT INTO op (OP,idCliente,FechaOC,FechaTope) 
    //VALUES ($miop,$micliente,$mifechaoc,$mifechatope)";
    $query="INSERT INTO op (OP,OC,idCliente,FechaOC,FechaTope,ContactoC) 
    VALUES ($miop,$mioc,$micliente,STR_TO_DATE('$mifechaoc', '%Y-%m-%d'),STR_TO_DATE('$mifechatope', '%Y-%m-%d'),$micontacto)";
    $result=mysqli_query($conn,$query);
    //$registro = mysqli_num_rows($result); 
    
    if ($result) {    
        $_SESSION['message'] = "Registro cargado con exito";
        $_SESSION['message_type'] = "success";
        header("location: " . $_SERVER['PHP_SELF']);
    }

    if(!$result) {
        echo $_POST['contacto'] . "<br>";
        //echo $_POST['vendedor'];
        die("Algo fallo y no se pudo CARGAR el registro.");
    }
}
?>

<div class="container p-1">
    <div class="row">
        <div class="col-md-11 ">
                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                        
                    <table class="table table-bordered">
                        <thead class="thead-cel" style="text-align:center">
                            <tr>
                                <th colspan=2 width=50%>OP: <input text="op" name="op" value="" style="width: 100%" placeholder="Número de OP"></th>
                                <th colspan=2>OC: <input text="oc" name="oc" value="" style="width: 100%" placeholder="Número de OC"></th>
                            </tr>
                        </thead>
                         <tbody>
                            <tr>
                                <th style="text-align:left" colspan=4>Cliente: 
                                <select name="cli">
                                    <option value="0">Seleccione:</option>
                                    <?php
                                    $queryclientes="SELECT * FROM clientes";
                                    $rclientes=mysqli_query($conn,$queryclientes);
                                    while ($valores = mysqli_fetch_array($rclientes)) {
                                        echo '<option value="' . $valores['id'] . '">' . $valores['Cliente'] . '</option>';
                                    }
                                    ?>
                                </select>
                                </th>
                            </tr>
                            <tr>
                                <th colspan=2 width=50%>Fecha de OC: <input type="date" name="FechaOC" value="" style="width: 100%" ></th>
                                <th colspan=2>Fecha Tope: <input type="date" name="FechaTope" value="" style="width: 100%" ></th>
                            </tr>
                            <tr>
                                <th style="text-align:left" colspan=2>Vendedor Lago: 
                               
                                </th>

                                <td style="text-align:left" colspan=2>Contacto Cliente: <input text="contacto" name="contacto" value="" style="width: 100%" placeholder="Nombre y celu del contacto "></td>
                            </tr>
                            <!--<tr>
                                <th style="text-align:left" colspan=4>MATERIAL: </th>
                            </tr>
                            <tr>
                                <th BGCOLOR="#9b9b9b" style="text-align:left" colspan=4><?php //echo $mimaterial; ?></th>
                            </tr>
                            <tr>
                                <th style="text-align:left" colspan=4>Observaciones: </th>
                            </tr>
                            <tr>
                                <td style="text-align:left" colspan=4><?php //echo $miobs; ?></th>
                            </tr> -->
                        </tbody> 
                    </table>
                        <button class="btn btn-success" name="cargaop">
                            CARGAR OP
                        </button>
                </form>
        </div>
    </div>
</div>


<?php include ("../includes/footer.php") ?>