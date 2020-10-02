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

<?php
//session_unset();  
}  unset ($_SESSION['message']); 
//session_unset(); 

    if (isset($_POST['agregaag'])){
        //session_start();
        if(!isset($_SESSION['cuenta'])){
            $_SESSION['cuenta'] = 0; // la uso para agregar agentes al servicio
            $_SESSION['ag_nuevo'] = array();
        }
    }

?>

<?php
if (isset($_POST['cargaservi'])) {
    $minombre = $_POST['nombre'];//
    $miopref = $_POST['opref'];//
    $miidcliente1 = $_POST['idcliente1']; //
    $miopservicio = $_POST['opservicio'];//
    $miidcliente2 = $_POST['idcliente2'];//
    $mitrabajo = $_POST['trabajo'];//
    $milugar = $_POST['lugar'];//
    $mifechaini = $_POST['fechaini'];
    $mifechafin = $_POST['fechafin'];//
    $miestado = $_POST['estado'];
    //$miestado = "NADA";
    $miobs = $_POST['obs'];//

    //$query="INSERT INTO servicios (Nombre,OpRef,idCliente1,OpServicio,idCliente2,Trabajo,Lugar,FechaIni,FechaFin,estado,OBS)
    //VALUES ('$minombre',$miopref,$miidcliente1,$miopservicio,$miidcliente2,'$mitrabajo','$milugar', STR_TO_DATE('$mifechaini', '%Y-%m-%d'),STR_TO_DATE('$mifechafin', '%Y-%m-%d'),'$miestado','$miobs')";
    $query="INSERT INTO servicios (Nombre,OpRef,idCliente1,OpServicio,idCliente2,Trabajo,Lugar,FechaIni,FechaFin,Estado,OBS)
    VALUES ('$minombre',$miopref,$miidcliente1,$miopservicio,$miidcliente2,'$mitrabajo','$milugar',STR_TO_DATE('$mifechaini', '%Y-%m-%d'),STR_TO_DATE('$mifechafin', '%Y-%m-%d'),$miestado,'$miobs')";
    $result=mysqli_query($conn,$query);
    //$registro = mysqli_num_rows($result); 
    
    if ($result) {    
        $_SESSION['message'] = "Registro cargado con exito";
        $_SESSION['message_type'] = "success";
        header("location: " . $_SERVER['PHP_SELF']);
    }

    if(!$result) {
        //echo $_POST['contacto'] . "<br>";
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
                                <th colspan=2>Nombre: <input text="nombre" name="nombre" value="" style="width: 80%" placeholder="Identifique al servicio"></th>
                                <th colspan=2>Lugar: <input text="lugar" name="lugar" value="" style="width: 80%" placeholder="ciudad o ET"></th>
                            </tr>
                        </thead>
                         <tbody>
                            <tr>
                                <td style="text-align:left" colspan=2 >Op de Ref.: 
                                <select name="opref" style="width: 50%">
                                    <option value="0">Seleccione:</option>
                                    <?php
                                    $queryop1="SELECT * FROM op";
                                    $rop1=mysqli_query($conn,$queryop1);
                                    while ($valores = mysqli_fetch_array($rop1)) {
                                        echo '<option value="' . $valores['OP'] . '">' . $valores['OP'] . '</option>';
                                    }
                                    ?>
                                </select>
                                </td>
                                <td style="text-align:left" colspan=2 >Op de Servicio: 
                                <select name="opservicio" style="width: 50%">
                                    <option value="0">Seleccione:</option>
                                    <?php
                                    $queryop2="SELECT * FROM op";
                                    $rop2=mysqli_query($conn,$queryop2);
                                    while ($valores2 = mysqli_fetch_array($rop2)) {
                                        echo '<option value="' . $valores2['OP'] . '">' . $valores2['OP'] . '</option>';
                                    }
                                    ?>
                                </select>
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
                                <td style="text-align:left" colspan=3>
                                    <div class="form-group">Observaciones
                                        <textarea name="obs" rows="2" value="" style="width: 100%" class="form-control">
                                        </textarea>
                                    </div>
                                </td>
                                </td>
                                <td style="text-align:left" colspan=1>ESTADO DEL SERVICIO: 
                                <select name="estado" style="width: 60%">
                                    <option value="0">Seleccione:</option>
                                    <?php
                                    $queryestado="SELECT * FROM estados";
                                    $restado=mysqli_query($conn,$queryestado);
                                    while ($valores = mysqli_fetch_array($restado)) {
                                        echo '<option value="' . $valores['id'] . '">' . $valores['Estado'] . '</option>';
                                    }
                                    ?>
                                </select>
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
    <div class="row">
        <div class="col-md-11 ">
                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                        
                    <table class="table table-bordered">
                        <thead class="thead-cel" style="text-align:center">
                            <tr>
                                <th colspan=4>Agentes: </th>
                            </tr>
                        </thead>
                         <tbody>
                            <tr>
                                <td style="text-align:left" rowspan="100" colspan="2">Ag. Asignado:<br> 
                                <select name="agente" style="width: 50%">
                                    <option value="0">Seleccione:</option>
                                    <?php
                                    $queryag="SELECT * FROM agentes";
                                    $resultadoag=mysqli_query($conn,$queryag);
                                    while ($valores = mysqli_fetch_array($resultadoag)) {
                                        echo '<option value="' . $valores['Agente'] . '">' . $valores['Agente'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <button class="btn btn-warning btn-sm" name="agregaag">
                                        AGREGAR
                                </button>
                                </td>
                                <?php
                                    if (isset($_SESSION['cuenta'])){
                                        $indice = $_SESSION['cuenta'];
                                        $actual = 0;
                                        $control = 0;
                                        for ($i = 1; $i <= $indice; $i++){
                                            $num_ag = 'borraag' . $i;
                                            $actual++;
                                            $control++;
                                            $_SESSION['ag_nuevo'][$actual] = $_SESSION['ag_nuevo'][$control];
                                            if (isset($_POST[$num_ag])){
                                                $control++;
                                                $se_va=$_SESSION['cuenta'];
                                                if ($se_va == 1){
                                                    session_destroy();
                                                    break;
                                                }
                                                if ($control == $se_va){
                                                    break;
                                                }
                                                $_SESSION['cuenta']=$_SESSION['cuenta']-1;
                                                $_SESSION['ag_nuevo'][$actual] = $_SESSION['ag_nuevo'][$control];
                                                $i++;
                                                if ($i > $indice){break;}
                                            }
                                            echo '<tr><td style="text-align:left" >' . $_SESSION['ag_nuevo'][$actual] . '</td><td> <button class="btn btn-danger btn-sm" name="borraag' . $actual . '">
                                                BORRAR</button> </td></tr>';
                                        }
                                        if (isset($se_va)){unset ($_SESSION['ag_nuevo'][$se_va]);}
                                    } 
                                    if (isset($_POST['agregaag'])){
                                        //session_start();
                                        if (isset($_SESSION['cuenta'])){
                                            $_SESSION['cuenta']++;
                                            $indice=$_SESSION['cuenta'];
                                            //$_SESSION['ag_nuevo'] = array($indice=>$_POST['agente']);
                                            $_SESSION['ag_nuevo'][$indice] = $_POST['agente'];
                                            //for ($i = 1; $i <= $indice; $i++){
                                                echo '<tr><td style="text-align:left" >' . $_SESSION['ag_nuevo'][$indice] . 'x' . '</td><td> <button class="btn btn-danger btn-sm" name="borraag' . $i . '">
                                                BORRAR</button> </td></tr>';
                                                //echo $_SESSION['cuenta'] . "<br>";
                                            //}
                                        }
                                    }else{
                                        echo '<td></td>';
                                    }
                                ?>
                            </tr>
                            <tr> 
                                <td colspan="4">
                                    <button class="btn btn-success" name="cargaagente">
                                        CARGAR AGENTES
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