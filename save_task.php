<?php

//error_reporting(1);

include "db.php";

if (isset($_POST['save_task'])){

    $title = $_POST['title'];
    $description = $_POST['description'];

    $query = "INSERT INTO tareas(title, description) VALUES ('$title','$description')";
    $result = mysqli_query($conn,$query);

    if (!$result){

        die("Algo falló en la carga de datos.");

    }

    $_SESSION['message'] = 'Tarea Guardada';
    $_SESSION['message_type'] = 'success';
            
    header ("location: index.php");
}

    


?>