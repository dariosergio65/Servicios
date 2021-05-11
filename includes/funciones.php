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
                if ($idpantalla=='menu12') {
                    $permiso=0;
                    //echo 'idpantalla= ' . $idpantalla . '<br>';
                    //echo 'permiso= ' . $permiso . '<br>';
                    //die ('entró');
                }elseif(strstr($idpantalla,'admin')){
                    $permiso=0;
                }else{
                    $permiso=true;    
                }
            }elseif($categoria==3){//invitado   
                if ($idpantalla=='menu0' or $idpantalla=='menu18') {
                    $permiso=true;
                    //echo 'idpantalla= ' . $idpantalla . '<br>';
                    //echo 'permiso= ' . $permiso . '<br>';
                    //die ('entró');
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
?>