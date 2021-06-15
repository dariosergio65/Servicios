<?php
    session_start();
    if (!isset($_SESSION['ingresado'])){
        header("location: index.php");
        die();
    }
$rutaf = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/includes/funciones.php';
include ($rutaf);
$rutaindex = '/Servicios/index.php';
$usuario=$_SESSION['ingresado']; 

$pantalla = 'menu0';//ojo al cambiar nombre del archivo php

$r=comprobar($usuario,$pantalla);
if($r=='disabled'){
    header ("location: " . $rutaindex);
    die();
}
?>
<?php
include ("includes/header.php");

for ($i=1; $i<19; $i++){
    $pantalla= 'menu' . $i;
    $r=(comprobar($usuario,$pantalla)=='enabled') ? 'enabled' : 'disabled';

    $btn[$i]=$r;
}
?>
<?php
if (isset($_POST['tablero'])){
    header ("location: Buscar/tablero.php");
}elseif (isset($_POST['cargaop'])){
    header ("location: Altas/altaop.php");
}elseif (isset($_POST['programados'])){
    header ("location: Consultas/programados.php");
}elseif (isset($_POST['cargaservi'])){
    header ("location: Altas/altaservicio.php");
}elseif (isset($_POST['cargatrans'])){
    header ("location: abmb/transporte.php");
}elseif (isset($_POST['abmven'])){
    header ("location: abmb/vendedores.php");
}elseif (isset($_POST['abmest'])){
    header ("location: abmb/estados.php");
}elseif (isset($_POST['abmpers'])){
    header ("location: abmb/agentes.php");
}elseif (isset($_POST['abmop'])){
    header ("location: abmb/abmop.php");    
}elseif (isset($_POST['abmclientes'])){
    header ("location: abmb/clientes.php");
}elseif (isset($_POST['ag-serv'])){
    header ("location: abmb/agente-servicio.php");
}elseif (isset($_POST['cantservi'])){
    header ("location: Consultas/cantservicios.php");
}elseif (isset($_POST['internos'])){
    header ("location: Consultas/internos.php");
}elseif (isset($_POST['admin'])){
    header ("location: menuadmin.php");
}

?>
<div class="container p-4">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                <table class="table table-bordered">
                    <thead class="thead-cel" style="text-align:center"> 
                        <tr>
                            <th>Altas Bajas Modificaciones</th>
                            <th>PRINCIPALES</th>
                            <th>CONSULTAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <button class="btn btn-success" name="cargatrans" <?php echo $btn[1]; ?>>
                                    TRANSPORTE
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <button class="btn btn-success" name="tablero" <?php echo $btn[7]; ?>>
                                    SERVICIOS <i class="fas fa-tools"></i>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                        <button class="btn btn-success" name="programados" <?php echo $btn[13]; ?> >
                                        Servicios Programados
                                        </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <button class="btn btn-success" name="abmven" <?php echo $btn[2]; ?>>
                                    VENDEDORES
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <button class="btn btn-success" name="cargaop" <?php echo $btn[8]; ?>>
                                    CARGAR OP
                                    </button>
                                </div>
                            </td>
                            
                            <td>
                                <div class="form-group">
                                    <button class="btn btn-success" name="cantservi" <?php echo $btn[14]; ?>>
                                        Cantidad de servicios
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                <button class="btn btn-success" name="abmest" <?php echo $btn[3]; ?>>
                                    ESTADOS
                                </button>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <button class="btn btn-success" name="cargaservi" <?php echo $btn[9]; ?>>
                                    CARGAR SERVICIO
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                        <button class="btn btn-success" name="nada" <?php echo $btn[15]; ?> disabled>
                                        HORAS TRABAJADAS <i class="far fa-clock"></i>
                                        </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                <button class="btn btn-success" name="abmpers" <?php echo $btn[4]; ?>>
                                    PERSONAL
                                </button>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                        <button class="btn btn-success" name="abmop" <?php echo $btn[10]; ?>>
                                        ABM OP
                                        </button>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                        <button class="btn btn-dark" name="nada" <?php echo $btn[16]; ?> disabled>
                                        NADA
                                        </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <button class="btn btn-success" name="abmclientes" <?php echo $btn[5]; ?>>
                                        CLIENTES
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <button class="btn btn-dark" name="nada" <?php echo $btn[11]; ?> disabled>
                                    NADA
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                        <button class="btn btn-dark" name="nada" <?php echo $btn[17]; ?> disabled>
                                        NADA
                                        </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <div class="form-group">
                                <button class="btn btn-success" name="ag-serv" <?php echo $btn[6]; ?>>
                                Agente-Servicio
                                </button>
                            </div>
                            
                            </td>
                            <td>
                                <div class="form-group">
                                    <button class="btn btn-danger" name="admin" <?php echo $btn[12]; ?>>
                                    ADMINISTRACION
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <button class="btn btn-success" name="internos" <?php echo $btn[18]; ?>>
                                    INTERNOS LAGO <i class="fas fa-phone"></i>
                                    </button>
                                </div>
                            </td>
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