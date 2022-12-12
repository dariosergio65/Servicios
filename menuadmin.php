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

$pantalla = 'menuadmin0';//ojo al cambiar nombre del archivo php

$r=comprobar($usuario,$pantalla);
if($r=='disabled'){
    header ("location: " . $rutaindex);
    die();
}

include ("includes/header.php");

for ($i=1; $i<13; $i++){
    $pantalla= 'menuadmin' . $i;
    $r=(comprobar($usuario,$pantalla)=='enabled') ? 'enabled' : 'disabled';

    $btn[$i]=$r;
}

?>
<?php
if (isset($_POST['abmpan'])){
    header ("location: abmb/pantallas.php");
}elseif (isset($_POST['abmusers'])){
    header ("location: abmb/usuarios.php");
}elseif (isset($_POST['accesos'])){
    header ("location: Consultas/accesos.php");
}elseif (isset($_POST['permisos'])){
    header ("location: abmb/permisos.php");
}elseif (isset($_POST['recarga'])){
    header ("location: Modif/recarga.php");
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
                                    <button class="btn btn-success" name="abmusers" <?php echo $btn[1]; ?>>
                                    ABM USUARIOS
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <button class="btn btn-success" name="nada" <?php echo $btn[2]; ?>>
                                    NADA
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                        <button class="btn btn-success" name="accesos" <?php echo $btn[3]; ?>>
                                        ACCESOS
                                        </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <button class="btn btn-success" name="abmpan" <?php echo $btn[4]; ?>>
                                    ABM PANTALLAS
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <button class="btn btn-danger" name="recarga" <?php echo $btn[5]; ?>>
                                    Recarga Permisos
                                    </button>
                                </div>
                            </td>
                            
                            <td>
                                <div class="form-group">
                                    <button class="btn btn-success" name="nada" <?php echo $btn[6]; ?>>
                                        NADA
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                <button class="btn btn-success" name="permisos" <?php echo $btn[7]; ?>>
                                    ABM PERMISOS
                                </button>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <button class="btn btn-success" name="nada" <?php echo $btn[8]; ?> >
                                    NADA
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                        <button class="btn btn-dark" name="nada" <?php echo $btn[9]; ?>>
                                        NADA
                                        </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                <button class="btn btn-success" name="nada" <?php echo $btn[10]; ?>>
                                    NADA
                                </button>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                        <button class="btn btn-dark" name="nada" <?php echo $btn[11]; ?>>
                                        NADA
                                        </button>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                        <button class="btn btn-dark" name="nada" <?php echo $btn[12]; ?>>
                                        NADA
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