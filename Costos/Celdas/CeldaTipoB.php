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

$pantalla = 'celdas12';//ojo al cambiar nombre del archivo php

$r=comprobar($usuario,$pantalla);
if($r=='disabled'){
    header ("location: " . $rutaindex);
    die();
}
?>
<?php
include ("../../includes/header.php");
?>
<style>
div{ 
   display: block;
   margin: 5px;
   /* border: 1px solid blue; */
   padding: 1px; 
}
table{ 
   margin: 1px;
   border: 1px solid grey;
   padding: 1px; 
   border-collapse: separate;
}
td {
  border: blue 3px solid;
}

</style>


<table>

  <tr>
    <th style="width: 33%" position="center">Celda Tipo B 17kV 400A</th>
    <th style="width: 33%">Opciones</th>
    <th style="width: 34%">Costos - Precio de Venta</th>
  </tr>
  <tr>
    <td><img src="../../img/CeldaTipoB.bmp"></td>
    <td>
      <h4 id="actualizado"> </h4>
      <h6 id="dolar"> </h6>
      <form style="padding: 10px" name="miFormulario" action="" enctype="text/plain"> 
        <div class="boxes">
        <input type="checkbox" name="gabinete" class="boxes" checked> <label for="gabinete">Gabinete</label>
        <br>
        <input type="checkbox" name="seccionador" class="boxes" checked> <label for="seccionador">Seccionador</label>
        <br>
        </div>
      </form>
    </td>
    <td>
      <div style="text-align: center;">
      <span ><b>Costo Calculado U$S</b></span>
      </div>
      <label for="costod">Costo Directo: </label>
      <input type="text" required id="costod" class="costod" style="width : 8em;" disabled>
      <br>
      <div style="display: block;">
      <label for="costod">Indirecto (%): </label>
      <input type="number" min="0" max="100" value=42 required id="porcentaje" class="porcentaje"  style="width : 52px; background-color: yellow;">
      <label for="costoi">Costo Indirecto: </label>
      <input type="text" required id="costoi" class="costoi" style="width : 8em;" disabled>
      </div>
      <br>
      <label for="costot">Costo Total: </label>
      <input type="text" required id="costot" class="costot" style="width : 8em; font-weight:bold;" disabled>
      <br><br>
      <div style="text-align: center;">
      <span ><b>Precio de Venta U$S</b></span>
      </div>
      <div style="display: block;">
      <label for="beneficio">beneficio (%): </label>
      <input type="number" min="0" max="400" value=30 required id="beneficio" class="beneficio"  style="width : 52px; background-color: yellow;">
      <br>
      <label for="precio">Precio: </label>
      <input type="text" required id="precio" class="precio" style="width : 8em; color: red; font-weight:bold;" disabled>
      </div>
      <br><br>
      <div class="form">
      <!-- <label for="guessField">Ingrese un número: </label>
      <input type="number" min="1" max="100" required id="guessField" class="guessField"> -->
      <input type="submit" value="Calcular Precio" class="calcular" >
    </div>
    </td>
  </tr>
</table>

<script>
  // Definimos el objeto PG con los costos de cada parte
  const PG = {
    gabinete: 1362,
    seccionador: 1335,
    fecha: '10-03-2023',
    dolar: 207
  }

  const fechaAct = 'Actualización: ' + PG.fecha;
  document.getElementById("actualizado").innerHTML = fechaAct;

  const dolarfecha = 'Dolar: $ ' + PG.dolar;
  document.getElementById("dolar").innerHTML = dolarfecha;

  
  const calcular = document.querySelector('.calcular');
  const costod = document.querySelector('.costod');

  const porcentaje = document.querySelector('.porcentaje');
  const costoi = document.querySelector('.costoi');

  const costot = document.querySelector('.costot');

  const beneficio = document.querySelector('.beneficio');
  const precio = document.querySelector('.precio');

  const boxes = document.querySelectorAll('.boxes');

  function calculaPrecio(){
    costod.value = 0;
    let costo=0;
    let indi=0;
    let total=0;
    let pventa=0;
    //const boxes = document.querySelectorAll('.boxes');
    for (let i = 1 ; i < boxes.length ; i++) {
      if (boxes[i].checked){
        costo = PG[boxes[i].name] + costo;
        costod.value = costo.toFixed(2);    
      }
    }
    indi = costo.toFixed(2) * (porcentaje.value / 100 );
    costoi.value = indi.toFixed(2);

    total = costo + indi;
    costot.value = total.toFixed(2);

    pventa = total * (beneficio.value / 100 + 1);
    precio.value = pventa.toFixed(2);

    calcular.disabled = true;

  }

  calculaPrecio();

  calcular.addEventListener('click', calculaPrecio);

  for (let i = 1 ; i < boxes.length ; i++) {
    boxes[i].addEventListener('click', calculaPrecio);
  }

  porcentaje.addEventListener('change', function() {
    costoi.value=null;
    costot.value=null;
    precio.value=null;
    calcular.disabled=false;
  });

  beneficio.addEventListener('change', function() {
    precio.value=null;
    calcular.disabled=false;
  });

</script>



<?php
include ("../../includes/footer.php");
?>