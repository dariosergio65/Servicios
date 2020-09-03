<html>
    <head>
        <title>Probando Clases</title>
    </head>

    <body>
        
<?php 

include "clases/persona.php";

$otro = new empleado("otro","Flores",25666847);
$otro->setcategoria("oficial");


echo 'Nombre: ' . $otro->getnombre() . "<br>" ;
echo "Apellido: " . $otro->getapellido() . "<br>" ; 
echo "dni: " . $otro->getdni() . "<br>" ; 
echo "categoria: " . $otro->getcategoria() . "<br>" ;


?>



    </body>
</html>