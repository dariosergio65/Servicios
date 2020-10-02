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
if (isset($_POST['cargaagen'])) {
    $miagen = $_POST['agen'];
    $midni = $_POST['dni'];
    $micelu = $_POST['celu'];
    $misector = $_POST['sector'];
    $midire = $_POST['dire'];

    if (isset($_GET['flag'])) {
        $miflag = $_GET['flag'];
        if ($miflag == 0){
            $vuelta = '/Servicios/abmb/agentes.php';
        }
        if ($miflag == 1){ //falta completar altaservicio.php
            $vuelta = '/Servicios/Altas/altaservicio.php';
        }
    }
    
    $query="INSERT INTO agentes (dni,Agente,Celular,id_sector,Direccion) VALUES ($midni, '$miagen', '$micelu', $misector, '$midire')";
    $result=mysqli_query($conn,$query);
    //$registro = mysqli_num_rows($result); 
    //echo "llegamos aca";
    
    if ($result) {    
        $_SESSION['message'] = "Registro cargado con exito";
        $_SESSION['message_type'] = "success";
        header("location: " . $vuelta);
    }

    if(!$result) {
        //echo $_POST['contacto'] . "<br>";
        //echo $_POST['vendedor'];
        die("Algo fallo y no se pudo CARGAR el registro.");
    }
}
?>

<div class="container p-1">
    <div class="row" >
        <div class="col-md-7 ">
                <form action="<?php $_SERVER['PHP_SELF']; ?>"  method="POST">
                    <table class="table table-bordered">
                        <thead class="thead-cel" style="text-align:center">
                            <tr>
                                <th width=50%>PERSONAL NUEVO: </th>
                            </tr>
                        </thead>
                         <tbody>
                            <tr>
                                <td>Nombre<input text="agen" name="agen" style="width: 100%" placeholder="Agente nuevo"></td>
                            </tr>
                            <tr>
                                <td>DNI: <input text="dni" name="dni" style="width: 50%" placeholder="dni sin puntos"></td>
                            </tr>
                            <tr>
                                <td>Celular: <input text="celu" name="celu" style="width: 50%" placeholder="número de celular"></td>
                            </tr>
                            <tr>
                                <td>Sector: 
                                    <select name="sector" style="width: 50%">
                                    <option value="0">Seleccione:</option>
                                    <?php
                                    $querysector="SELECT * FROM sectores";
                                    $resultsector=mysqli_query($conn,$querysector);
                                    while ($valores = mysqli_fetch_array($resultsector)) {
                                        echo '<option value="' . $valores['id'] . '">' . $valores['Sector'] . '</option>';
                                    }
                                    ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Dirección<input text="dire" name="dire" style="width: 100%" placeholder="Dirección particular"></td>
                            </tr>
                            <tr> 
                                <td>
                                    <button class="btn btn-success" name="cargaagen">
                                        CARGAR AGENTE
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
        </div>
    </div>
</div>


<?php include ("../includes/footer.php"); ?>