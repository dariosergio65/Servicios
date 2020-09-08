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
if (isset($_POST['cargavend'])) {
    $mivend = $_POST['vend'];

if (isset($_GET['flag'])) {
    $miflag = $_GET['flag'];
    if ($miflag == 0){
        $vuelta = '/Servicios/abmb/vendedores.php';
    }
    if ($miflag == 1){ //falta completar altaservicio.php
        $vuelta = '/Servicios/Altas/altaservicio.php';
    }
}
    
    $query="INSERT INTO vendedores (Vendedor) VALUES ('$mivend')";
    $result=mysqli_query($conn,$query);
    //$registro = mysqli_num_rows($result); 
    
    if ($result) {    
        $_SESSION['message'] = "Registro cargado con exito";
        $_SESSION['message_type'] = "success";
        header("location: " . $vuelta);
    }

    if(!$result) {
        echo $_POST['vend'];
        die("Algo fallo y no se pudo CARGAR el registro.");
    }
}
?>

<div class="container p-1">
    <div class="row" >
        <div class="col-md-5 ">
                <form action="<?php $_SERVER['PHP_SELF']; ?>"  method="POST">
                    <table class="table table-bordered">
                        <thead class="thead-cel" style="text-align:center">
                            <tr>
                                <th width=50%>VENDEDOR NUEVO: </th>
                            </tr>
                        </thead>
                         <tbody>
                            <tr>
                                <td><input text="vend" name="vend" style="width: 100%" placeholder="Vendedor nuevo"></td>
                            </tr>
                            <tr> 
                                <td>
                                    <button class="btn btn-success" name="cargavend">
                                        CARGAR VENDEDOR
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