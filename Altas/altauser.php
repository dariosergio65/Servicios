<?php
session_start();
if (!isset($_SESSION['ingresado'])){
    header("location: index.php");
}
$usuario=$_SESSION['ingresado'];

include ("../db.php");
include ("../includes/header.php");
include ("../includes/funciones.php");
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
if (isset($_POST['cargauser'])) {
    $miuser = $_POST['user'];
    $minombre = $_POST['nombre'];
    $micat = $_POST['cat'];
    $miclave = encriptar($_POST['clave']);

    if (isset($_GET['flag'])) {
        $miflag = $_GET['flag'];
        if ($miflag == 0){
            $vuelta = '/Servicios/abmb/usuarios.php';
        }
        if ($miflag == 1){ //falta completar altaservicio.php // Aca no se usa
            $vuelta = '/Servicios/Altas/altaservicio.php';
        }
    }
    
    $query="INSERT INTO usuarios (User,Nombre,id_categoria,Clave) VALUES ('$miuser', '$minombre', $micat, '$miclave')";
    $result=mysqli_query($conn,$query);
    //$registro = mysqli_num_rows($result); 
    //echo "llegamos aca";
    
    cargapermisos($miuser,$micat);

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
                                <th width=50%>USUARIO NUEVO: </th>
                            </tr>
                        </thead>
                         <tbody>
                            <tr>
                                <td>User<input text="user" name="user" style="width: 100%" placeholder="Usuario nuevo"></td>
                            </tr>
                            <tr>
                                <td>Nombre: <input text="nombre" name="nombre" style="width: 50%" placeholder="Nombre real"></td>
                            </tr>
                            <tr>
                                <td>Categoria: 
                                    <select name="cat" style="width: 50%">
                                    <option value="0">Seleccione:</option>
                                    <?php
                                    $querycat="SELECT * FROM categorias";
                                    $resultcat=mysqli_query($conn,$querycat);
                                    while ($valores = mysqli_fetch_array($resultcat)) {
                                        echo '<option value="' . $valores['id'] . '">' . $valores['nombre'] . '</option>';
                                    }
                                    ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>Clave: <input type="password" name="clave" style="width: 50%" placeholder="Clave"></td>
                            </tr>
                            <tr> 
                                <td>
                                    <button class="btn btn-success" name="cargauser">
                                        CARGAR USUARIO
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