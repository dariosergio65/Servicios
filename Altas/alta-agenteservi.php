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
?>

<?php
if (isset($_POST['cargaagservi'])) {
    $miidagente = $_POST['agente'];//
    $miidservicio = $_POST['servicio'];//
    $mifechaini = $_POST['fechaini'];
    $mifechafin = $_POST['fechafin'];//
    $micanthoras = $_POST['horast'];
    $mivalorhora = $_POST['valhora'];
    $mivalordia = $_POST['valdia'];
    $midolarfecha = $_POST['dolfecha'];


    $query="INSERT INTO agenteservicio (id_agente,id_servicio,FechaIni,FechaFin,Cant_horas,Valor_hora,Valor_dia,Dolarfecha)
    VALUES ('$miidagente',$miidservicio,STR_TO_DATE('$mifechaini', '%Y-%m-%d'),STR_TO_DATE('$mifechafin', '%Y-%m-%d'),$micanthoras,$mivalorhora,$mivalordia,$midolarfecha)";
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
                            <th colspan=2>Agente: 
                                <select name="agente" style="width: 50%">
                                    <option value="0">Seleccione:</option>
                                    <?php
                                    $queryag="SELECT * FROM agentes";
                                    $rag=mysqli_query($conn,$queryag);
                                    while ($valores = mysqli_fetch_array($rag)) {
                                        echo '<option value="' . $valores['dni'] . '">' . $valores['Agente'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </th>
                            <th colspan=2>Servicio: 
                                <select name="servicio" style="width: 50%">
                                    <option value="0">Seleccione:</option>
                                    <?php
                                    $queryserv="SELECT * FROM servicios";
                                    $rserv=mysqli_query($conn,$queryserv);
                                    while ($valores = mysqli_fetch_array($rserv)) {
                                        echo '<option value="' . $valores['id'] . '">' . $valores['Nombre'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td colspan=2>Fecha Inicio del servicio: <input type="date" name="fechaini" value="" style="width: 50%" ></td>
                            <td colspan=2>Fecha de fin del  Servicio: <input type="date" name="fechafin" value="" style="width: 50%" ></td>
                        </tr>
                        <tr>
                            <td style="text-align:left">
                                Horas trabajadas:
                                    <input text="horast" name="horast" rows="2" value="" style="width: 50%" >
                                    </text>
                            </td>
                            <td style="text-align:left" >
                                Valor hora:
                                    <input text="valhora" name="valhora" rows="2" value="" style="width: 50%">
                                    </text>
                            </td>
                            <td style="text-align:left" >
                                Valor día Servicio:
                                    <input text="valdia" name="valdia" rows="2" value="" style="width: 50%">
                                    </text>
                            </td>
                            <td style="text-align:left" >
                                Valor dolar fecha:
                                    <input text="dolfecha" name="dolfecha" rows="2" value="" style="width: 50%">
                                    </text>
                            </td>
                        </tr>
                        <tr>
                            <td colspan=2>
                            </td>
                            <td colspan="2">
                                <button class="btn btn-success" name="cargaagservi">
                                    CARGAR
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