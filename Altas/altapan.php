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
if (isset($_POST['cargapan'])) {
    $miid = $_POST['id'];
    $midesc = $_POST['desc'];

    if (isset($_GET['flag'])) {
        $miflag = $_GET['flag'];
        if ($miflag == 0){
            $vuelta = '/Servicios/abmb/pantallas.php';
        }
        if ($miflag == 1){ //falta completar altapan.php
            $vuelta = '/Servicios/Altas/altapan.php';
        }
    }
    
    $query="INSERT INTO pantallas (id,Descripcion) VALUES ('$miid', '$midesc')";
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
                                <th width=50%>Pantalla nueva: </th>
                            </tr>
                        </thead>
                         <tbody>
                            <tr>
                                <td>id: <input text="id" name="id" style="width: 50%" placeholder="id de la pantalla"></td>
                            </tr>

                            <tr>
                                <td>Descripción<input text="desc" name="desc" style="width: 100%" placeholder="Descripción"></td>
                            </tr>
                            <tr> 
                                <td>
                                    <button class="btn btn-success" name="cargapan">
                                        CARGAR PANTALLA
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