<?php

function comprobar($miusuario,$pantalla){ 

    $rutadb = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/db.php';
    include ($rutadb);

    $query = "SELECT permitido FROM permisos WHERE id_usuario='$miusuario' AND id_pantalla='$pantalla' ";
    $result_tasks = mysqli_query($conn,$query);

    $en="enabled";
    $dis="disabled";
    
    if (!$result_tasks){
        //echo 'disabled';
        return $dis;
        die("me fui");
    }else{
        $row=mysqli_fetch_array($result_tasks);

        if($row['permitido']){
            //echo "enabled";
            return $en;
        }else{
            //echo "disabled";
            return $dis;
        }
    }
}

function encriptar($miclave){

    //include_once ("../db.php");

    $miclave=htmlentities(addslashes($miclave));
    $encriptada =  password_hash($miclave, PASSWORD_DEFAULT);

    return $encriptada;
}

function cargapermisos($user,$categoria){// se ejecuta cuando creo un usuario nuevo

    include ("../db.php");

    $query = "SELECT id FROM pantallas ";
    $result_pant = mysqli_query($conn,$query);
    
    if (!$result_pant){
        die( 'Algo fallo en cargarpermisos' );
    }else{
        while ($valores = mysqli_fetch_array($result_pant)) {

            $idpantalla=$valores['id'];
            if($categoria==1){//admin 
                $permiso=true;   
                
            }elseif($categoria==2){//personal Lago
                if ($idpantalla=='menu12') {//menu del admin
                    $permiso=0;
                }elseif(strstr($idpantalla,'admin')){
                    $permiso=0;
                }elseif($idpantalla=='menu1' or $idpantalla=='menu2' or $idpantalla=='menu3' or $idpantalla=='menu4' or $idpantalla=='menu5' or $idpantalla=='menu6' or $idpantalla=='menu8' or $idpantalla=='menu9'){
                    $permiso=0;
                }elseif(strstr($idpantalla,'pantallas') or strstr($idpantalla,'permisos') or strstr($idpantalla,'recarga') or strstr($idpantalla,'usuarios') or strstr($idpantalla,'agente-servicio')){
                    $permiso=0;
                }else{
                    $permiso=true;    
                }
            }elseif($categoria==3){//invitado   
                if ($idpantalla=='menu0' or $idpantalla=='menu18' or $idpantalla=='menu13' or $idpantalla=='menu14') {
                    $permiso=true;
                }else{
                    $permiso=0;    
                }
            }
            $query1 = "INSERT INTO permisos (id_usuario,id_pantalla,permitido) VALUES ('$user','$idpantalla',$permiso)";
            $r1= mysqli_query($conn,$query1);
            if (!$r1){
                die( 'Algo fallo en Insertar Permiso' );
            }
        }
    }
    return 1;
}

function recargartodos(){// se usa cuando agrego algun botón o pantalla al proyecto

    include ("../db.php");

    $queryu = "SELECT User,id_categoria FROM usuarios ";
    $result_user = mysqli_query($conn,$queryu);
    
    if (!$result_user){
        die( 'Algo falló en la función recargartodos' );
    }else{
        while ($valuser = mysqli_fetch_array($result_user)) {
            $miuser=$valuser['User'];
            //echo $miuser;
            //die('aca estoy');
            $micategoria=$valuser['id_categoria'];

            $queryp = "SELECT id FROM pantallas ";
            $result_pant = mysqli_query($conn,$queryp);

            while ($valpant = mysqli_fetch_array($result_pant)) {
                $mipant=$valpant['id'];
                $micant=1;
                $querycomp = "SELECT COUNT(id_usuario) as cant FROM permisos WHERE id_usuario LIKE '$miuser' AND id_pantalla LIKE '$mipant' ";
                $result_comp = mysqli_query($conn,$querycomp);
                if (!$result_comp){
                    die( 'Algo falló en la función recargartodos-' );
                }
                $row_comp=mysqli_fetch_array($result_comp);
                $micant=$row_comp['cant'];

                if ($micant==0){//si no existe el permiso
                    if($micategoria==1){//admin 
                        $permiso=true;   
                        
                    }elseif($micategoria==2){//personal Lago
                        if (strstr($mipant,'admin')) {
                            $permiso=0;
                        }elseif($mipant=='menu12'){
                            $permiso=0;
                        }else{
                            $permiso=true;    
                        }
                    }elseif($micategoria==3){//invitado   
                        if ($mipant=='menu0' or $mipant=='menu18') {
                            $permiso=true;
                        }else{
                            $permiso=0;    
                        }
                    }
                    $queryfinal="INSERT INTO permisos (id_usuario,id_pantalla,permitido) VALUES ('$miuser','$mipant',$permiso) ";
                    $rfinal = mysqli_query($conn,$queryfinal);
                    if (!$rfinal){
                        die( 'Algo falló en la función recargartodos--' );
                    } 
                }
            }
        }
    }
    return 1;
}

function clavevalida($clave,&$error_clave){
    if(strlen($clave) < 6){
       $error_clave = "La clave debe tener al menos 6 caracteres";
       return false;
    }
    /* 
    if(strlen($clave) > 16){
       $error_clave = "La clave no puede tener más de 16 caracteres";
       return false;
    }
    if (!preg_match('`[a-z]`',$clave)){
       $error_clave = "La clave debe tener al menos una letra minúscula";
       return false;
    }
    if (!preg_match('`[A-Z]`',$clave)){
       $error_clave = "La clave debe tener al menos una letra mayúscula";
       return false;
    }
    if (!preg_match('`[0-9]`',$clave)){
       $error_clave = "La clave debe tener al menos un caracter numérico";
       return false;
    }
    */
    $error_clave = "";
    return true;
 }

 function claveanterior($usu,$clave){//verifica la clave anterior en los cambios de clave
     
    $clave=htmlentities(addslashes($clave)); //para evitar inyección
    
    try{
        $base= new PDO("mysql:host=localhost:3306; dbname=task", "root", "");
        $base->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $base->exec("SET CHARACTER SET utf8");
        $sql="SELECT * FROM usuarios WHERE User= :miuser";
        $resultado=$base->prepare($sql);
    
        $resultado->bindValue(":miuser", $usu); 
    
        $resultado->execute();
    
        while($registro = $resultado->fetch(PDO::FETCH_ASSOC)){
            if(password_verify($clave, $registro['Clave'])){
                return true;
            }else{
                return false;
            }
        }
    
    }
    catch(Exception $e){
        die("Error Servicios: " . $e->getMessage());
    }
    
    $resultado->closeCursor();
    
 }

 function iniciasivacia(&$variable,$tipo){
    //tipos: int, date, decimal, varchar, tinyint
    if ($tipo=='int'){
        if ( is_null($variable) or (!isset($variable)) or is_string($variable) ){ 
            $variable=0; 
        }
    }
    if ($tipo=='date'){
        if ( ($variable=='') or is_null($variable) or (!isset($variable)) ){ 
            $variable=date('Y-m-d');
            //echo ' x ' . $variable . ' x '; die();
        }
    }
    if ($tipo=='decimal'){
        if ( is_null($variable) or (!isset($variable)) or is_string($variable) ){ 
            $variable=0; 
        }
    }
    if ($tipo=='varchar'){
        if ( is_null($variable) or (!isset($variable)) ){ 
            $variable=''; 
        }
    }
    if ($tipo=='tinyint'){
        if ( is_null($variable) or (!isset($variable)) or is_string($variable) ){ 
            $variable=0; 
        }
    }
 }

function useracceso ($nombreusuario,$accion='ingreso') { // registra los ingresos de usuarios y su salida
    /* acciones:
                ingreso x
                cierre x
    */
    $rutadb = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/db.php';
    include ($rutadb);
    
    $fechahora = date("Y-m-d H:i:s");
    $ipuser =  $_SERVER['REMOTE_ADDR'];
    $requesturi = $_SERVER['REQUEST_URI'];
    
    $queryu="SELECT * FROM usuarios WHERE User = '$nombreusuario'";
    $resultu=mysqli_query($conn,$queryu);
    if ($resultu) {    
        $rowest = mysqli_fetch_array($resultu);
        $miuser = $rowest['User'];
    }
    
    $sqlinsert = "INSERT INTO accesos (fechahora, idusuario, accion, ip, requesturi) VALUES('$fechahora', '$miuser', '$accion', '$ipuser',  '$requesturi' );";
    
    $resulti = mysqli_query($conn,$sqlinsert);
    mysqli_free_result($result); // libero el conjunto de resultados
    
    mysqli_close($conn); // cierro la conexion
        
}// fin de la funcion

?>