<?php
include ("includes/header.php");
?>
<?php
if (isset($_POST['tablero'])){
    header ("location: Buscar/tablero.php");
}elseif (isset($_POST['cargaop'])){
    header ("location: Altas/altaop.php");
}elseif (isset($_POST['cargaservi'])){
    header ("location: Altas/altaservicio.php");
}elseif (isset($_POST['cargatrans'])){
    header ("location: abmb/transporte.php");
}elseif (isset($_POST['abmven'])){
    header ("location: abmb/vendedores.php");
}elseif (isset($_POST['abmest'])){
    header ("location: abmb/estados.php");
}
?>
<div class="container p-4">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                <table class="table table-bordered">
                    <thead class="thead-cel" style="text-align:center"> 
                        <tr>
                            <th>AMB</th>
                            <th>PRINCIPALES</th>
                            <th>CONSULTAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <button class="btn btn-success" name="cargatrans">
                                    ABM TRANSPORTE
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <button class="btn btn-success" name="tablero">
                                    TABLERO
                                    </button>
                                </div>
                            <td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <button class="btn btn-success" name="abmven">
                                    ABM VENDEDORES
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <button class="btn btn-success" name="cargaop">
                                    CARGAR OP
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                <button class="btn btn-success" name="abmest">
                                    ABM ESTADOS
                                </button>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <button class="btn btn-success" name="cargaservi">
                                    CARGAR SERVICIO
                                    </button>
                                </div>
                            <td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

<?php
include ("includes/footer.php");
?>