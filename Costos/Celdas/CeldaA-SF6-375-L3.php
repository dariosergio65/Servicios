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

$pantalla = 'celdas2';//ojo al cambiar nombre del archivo php

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

.radiomotor {
  position: relative;
  border: 1px solid red;
  padding-left: 2 px;
  margin: 5 px;
  /* width: 100 px; */ 
}
.radios {
  /*position: relative;*/
  /* right: 3 px; */ 
  /*border: 1px solid red;*/
  /*padding-left: 2 px;*/
  /* width: 10 px; */
}

</style>


<table>

  <tr>
    <th style="width: 33%; position: relative;">Celda A SF6 375 mm -- L3</th>
    <th style="width: 33%">Opciones</th>
    <th style="width: 34%">Costos - Precio de Venta</th>
  </tr>
  <tr>
    <td><img src="../../img/CeldaA-L3.bmp"></td>
    <td>
      <h4 id="actualizado" style="position: relative;"> </h4>
      <h6 id="dolar"> </h6>
      <form style="padding: 10px" name="miFormulario" action="" enctype="text/plain"> 
        <div class="boxes">
        <input type="checkbox" name="gabinete" class="boxes" checked> <label for="gabinete">Gabinete</label>
        <br>
        <input type="checkbox" name="seccBC" class="boxes" checked> <label for="seccBC">Seccionador Bajo Carga</label>
        <br>
        <input type="checkbox" name="seccDePat" class="boxes" checked> <label for="seccDePat">Seccionador de PAT</label>
        <br>
        <input type="checkbox" name="divCapacitivo" class="boxes"> <label for="divCapacitivo">Divisor Capacitivo</label>
        <br>
        <input type="checkbox" name="matElectricos" class="boxes" > <label for="matElectricos">Materiales Eléctricos</label>
        <br>
        <div class="radiomotor">
          <input type="radio" name="motor" value="sinMotor" class="radios" checked style="position: relative; left: 3px;"> <label for="opMotor48">Sin Motor</label>
          <br>
          <input type="radio" name="motor" value="opMotor48" class="radios" style="position: relative; left: 3px;"> <label for="opMotor48">Motor 48v</label>
          <br>
          <input type="radio" name="motor" value="opMotor110" class="radios" style="position: relative; left: 3px;"> <label for="opMotor110">Motor 110v</label>
        </div>
          <br>
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
  // Definimos el objeto L3 con los costos de cada parte
  const L3 = {
    gabinete: 744.77,
    seccBC: 1320,
    seccDePat: 917.57,
    divCapacitivo: 101.2,
    matElectricos: 2771.23,
    opMotor48: 174,
    opMotor110: 262,
    sinMotor: 0,
    fecha: '05-01-2023',
    dolar: 185.75
  }

  const fechaAct = 'Actualización: ' + L3.fecha;
  document.getElementById("actualizado").innerHTML = fechaAct;

  const dolarfecha = 'Dolar: $ ' + L3.dolar;
  document.getElementById("dolar").innerHTML = dolarfecha;

  
  const calcular = document.querySelector('.calcular');
  const costod = document.querySelector('.costod');

  const porcentaje = document.querySelector('.porcentaje');
  const costoi = document.querySelector('.costoi');

  const costot = document.querySelector('.costot');

  const beneficio = document.querySelector('.beneficio');
  const precio = document.querySelector('.precio');

  const boxes = document.querySelectorAll('.boxes');
  const radios = document.querySelectorAll('.radios');
  //const motor = document.getElementsByName('motor');

  function calculaPrecio(){
    costod.value = 0;
    let costo=0;
    let indi=0;
    let total=0;
    let pventa=0;
    //const boxes = document.querySelectorAll('.boxes');
    for (let i = 1 ; i < boxes.length ; i++) {
      if (boxes[i].checked){
        costo = L3[boxes[i].name] + costo;
        costod.value = costo.toFixed(2);    
      }
    } 
    let mot="";//alert("kdkdkd");
    for (let j = 1 ; j < radios.length ; j++) {
        if (radios[j].checked){
          mot=radios[j].value;
          costo = L3[mot] + costo;
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
  for (let j = 0 ; j < radios.length ; j++) {
    radios[j].addEventListener('click', calculaPrecio);
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