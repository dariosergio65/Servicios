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
                                <td style="text-align:left" colspan=2>Op de Ref.: 
                                <input text="opref" name="opref" value="" style="width: 50%" placeholder="OP de referencia">
                                </td>
                                <td style="text-align:left" colspan=2>Op de Servicio: 
                                <input text="opservicio" name="opservicio" value="" style="width: 50%" placeholder="OP de servicio">
                                </td>
                            </tr>
                            <tr>
                                
                                <td style="text-align:left" colspan=2 >Cliente Ref.: 
                                <select name="idcliente1" style="width: 50%">
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
                                <td style="text-align:left" colspan=2>Cliente de Servicio: 
                                <select name="idcliente2" style="width: 50%">
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
                            </tr>
                            <tr>
                                <th BGCOLOR="#9b9b9b" style="text-align:left" colspan=4>
                                    <div class="form-group">Trabajo Realizado
                                        <textarea name="trabajo" rows="2" value="" style="width: 100%" class="form-control"
                                        placeholder="Detalle del trabajo"></textarea>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th colspan=2>Fecha Inicio del servicio: <input type="date" name="fechaini" value="" style="width: 50%" ></th>
                                <th colspan=2>Fecha de fin del  Servicio: <input type="date" name="fechafin" value="" style="width: 50%" ></th>
                            </tr>
                           <tr>
                                <td style="text-align:left" colspan=4>
                                    <div class="form-group">Observaciones
                                        <textarea name="obs" rows="2" value="" style="width: 100%" class="form-control">
                                        </textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr> 
                                <td colspan="4">
                                    <button class="btn btn-success" name="cargaservi">
                                        CARGAR SERVICIO
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