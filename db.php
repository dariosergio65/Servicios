<?php

session_start();

$db_host="localhost:3306";
$db_nombre="task";
$db_usuario="root";
$db_contra="";

$conn = mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);


?>