<?php
//include ("header.php");
//include ("db.php");
?>

<?php

session_start();
$rutaf = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/includes/funciones.php';
include ($rutaf);
$cuenta=0;
if(isset($_POST['usuario'])){
    $miuser=htmlentities(addslashes($_POST['usuario']));
    $miclave=htmlentities(addslashes($_POST['clave']));
}else{
    die("Algo raro pasó :(");
}

try{
    $base= new PDO("mysql:host=localhost:3306; dbname=task", "root", "");
    //$base= new PDO("mysql:host=localhost; dbname=c1600506_task", "c1600506", "pegi45soVA");
    $base->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $base->exec("SET CHARACTER SET utf8");
    $sql="SELECT * FROM usuarios WHERE User= :miuser";
    $resultado=$base->prepare($sql);

    $resultado->bindValue(":miuser", $miuser); 

    $resultado->execute();

    while($registro = $resultado->fetch(PDO::FETCH_ASSOC)){
        if(password_verify($miclave, $registro['Clave'])){
            $categoria=$registro['id_categoria'];
            $cuenta++;
        }
    }

    $filas=$cuenta;
    if($filas != 0){
        $_SESSION['ingresado']=$_POST['usuario'];
        useracceso($_SESSION['ingresado'],'ingreso');
        //header("location: autenticado.php");
        if($categoria==1){// admin 
            header("location: menuadmin.php");
        }else{ // categorias personal e invitado
            header("location: menu.php");
        }
    }
    else{
        $_SESSION['mensaje'] = "Debe ingresar un usuario y contraseña válidos.";
        $_SESSION['tipo_mensaje'] = "danger";
        header("location: login.php");
    }
}
catch(Exception $e){
    die("Error Servicios: " . $e->getMessage());
}

$resultado->closeCursor();

?>

<?php
//nclude ("footer.php")
?>