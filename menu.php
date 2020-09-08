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
        <div class="col-md-5 mx-auto">
            <div class="card card-body">
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                    
                    <div class="form-group">
                        <button class="btn btn-success" name="tablero">
                            TABLERO
                        </button>
                    </div>
                    <div class="form-group">
                    <button class="btn btn-success" name="cargaop">
                            CARGAR OP
                        </button>
                    </div>
                    <div class="form-group">
                    <button class="btn btn-success" name="cargaservi">
                            CARGAR SERVICIO
                        </button>
                    </div>
                    <div class="form-group">
                    <button class="btn btn-success" name="cargatrans">
                            ABM TRANSPORTE
                        </button>
                    </div>
                    <div class="form-group">
                    <button class="btn btn-success" name="abmven">
                            ABM VENDEDORES
                        </button>
                    </div>
                    <div class="form-group">
                    <button class="btn btn-success" name="abmest">
                            ABM ESTADOS
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include ("includes/footer.php");
?>