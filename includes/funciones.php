<?php

function comprobar($usuario,$pantalla){

    include_once ("../db.php");

    $query = "SELECT Permitido FROM permisos WHERE id_usuario=$usuario AND id_pantalla=$pantalla";
    $result_tasks = mysqli_query($conn,$query);
    
    if (!$result_tasks){
        echo 'disabled';
    }else{
        $row=mysqli_fetch_array($result_tasks))

        if($row['Permitido']){
            echo "enabled";
        }else{
            echo "disabled";
        
        }
    }
}
?>