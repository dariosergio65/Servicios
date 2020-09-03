<?php

include("db.php");

if (isset($_GET['id'])) {
    $id=$_GET['id'];
    $query="DELETE FROM tareas where id = $id";
    $result=mysqli_query($conn,$query);

    if(!$result){
        die("No se pudo borrar el registro");
    }

    $_SESSION['message'] = 'Registro borrado';
    $_SESSION['message_type'] = 'danger';

    header("location: index.php");

}


?>