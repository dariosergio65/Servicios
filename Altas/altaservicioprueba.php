<?php
session_start();
if (!isset($_SESSION['ingresado'])){
    header("location: index.php");
}
$usuario=$_SESSION['ingresado'];

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
if (isset($_POST['cargaservi'])) {
    $minombre = $_POST['nombre'];
    $miopref = $_POST['opref'];
    $miidcliente1 = $_POST['idcliente1']; 
    $miopservicio = $_POST['opservicio'];
    $miidcliente2 = $_POST['idcliente2'];
    $mitrabajo = $_POST['trabajo'];
    $milugar = $_POST['lugar'];
    $mifechaini = $_POST['fechaini'];
    $mifechafin = $_POST['fechafin'];
    $miestado = $_POST['estado'];
    $miobs = $_POST['obs'];

    $query="INSERT INTO servicios (Nombre,OpRef,idCliente1,OpServicio,Cliente2,Trabajo,Lugar,FechaIni,FechaFin,estado,OBS)
    VALUES ('$minombre',$miopref,'$miidcliente1',$miopservicio,'$miidcliente2','$mitrabajo','$milugar',
            STR_TO_DATE('$mifechaini', '%Y-%m-%d'),STR_TO_DATE('$mifechafin', '%Y-%m-%d'),'$miestado','$miobs')";
    $result=mysqli_query($conn,$query);
    //$registro = mysqli_num_rows($result); 
    
    if ($result) {    
        $_SESSION['message'] = "Registro cargado con exito";
        $_SESSION['message_type'] = "success";
        header("location: " . $_SERVER['PHP_SELF']);
    }

    if(!$result) {
        echo $_POST['contacto'] . "<br>";
        echo $_POST['vendedor'];
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
                                <th colspan=2>Nombre: <input text="nombre" name="nombre" value="" style="width: 80%" placeholder="Identifique al servicio"></th>
                                <th colspan=2>Lugar: <input text="lugar" name="lugar" value="" style="width: 80%" placeholder="ciudad o ET"></th>
                            </tr> 
                        </thead>
                         <tbody>
                            <tr>
                                <td style="text-align:center" colspan=2>Op de Ref.: 
                                    <input text="opref" name="opref" value="" style="width: 25%" placeholder="OP de referencia">
                                </td>
                                <th style="text-align:left" colspan=2>: 
                                    <select name="idcliente1" style="width: 25%">
                                        <option value="0">Seleccione:</option>
                                        <?php
                                        $query1="SELECT * FROM clientes";
                                        $rcli1=mysqli_query($conn,$query1);
                                        while ($valores1 = mysqli_fetch_array($rcli1)) {
                                            echo '<option value="' . $valores1['id'] . '">' . $valores1['Cliente'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </th>
                                
                            </tr>

                        </tbody>
                        
                    </table>
                        
                </form>
        </div>
    </div>
</div>


<?php include ("../includes/footer.php") ?>