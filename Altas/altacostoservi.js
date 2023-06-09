
const calcular = document.querySelector('.calc'); //boton que escucha el click
calcular.addEventListener('click', costear);

const traerDolar = document.querySelector('.traeDolar'); //boton que escucha el click
traerDolar.addEventListener('click', dolar);


    let mirep = document.getElementById("rep");
    let mirep1 = document.getElementById("rep1");
    let miequip = document.getElementById("equip");
    let miequip1 = document.getElementById("equip1");
    let miinsumos = document.getElementById("insumos");
    let miinsumos1 = document.getElementById("insumos1");

    let miselect = document.getElementById("miSelect");
    // let miiibb = document.getElementById("iibb");

    const cantpers1 = document.getElementById("pers1");
    const valhotel1 = document.getElementById("hotel1");
    const valcomida1 = document.getElementById("comida1");
    const valtrans1 = document.getElementById("transporte1");

    const totalcd = document.getElementById("costod");
    const totalci = document.getElementById("costoi");
    const costoT = document.getElementById("ct");
    const util = document.getElementById("util");
    const ingb = document.getElementById("ibrut");
    const tsiniva = document.getElementById("siniva");
    const tconiva = document.getElementById("coniva");
    

    function costear(){

        mirep1.value=mirep.value;
        miequip1.value=miequip.value;
        miinsumos1.value=miinsumos.value;
        
        cantpers1.value = horasPers();
        valhotel1.value = hotel();
        valcomida1.value = comida();
        valtrans1.value = transporte();
        
        totalcd.value = costodirecto(); // total de costos directos
        totalci.value = costoindirecto(); // total de costo indirecto
        costoT.value = costototal();
        util.value = mibeneficio();
        ingb.value = iibb(); // iibb de la provincia seleccionada miselect.value
        tsiniva.value = precioSiniva();
        tconiva.value = precioConiva();
    }

    const cantpers = document.getElementById("pers"); //cantida de personas que hacen el servicio
    const tiempo = document.getElementById("tiempo"); //tiempo en dias
    const valhora = document.getElementById("valhora"); //valor de la hora en $

  function horasPers(){//costohoras de las Horas Hombre
    
    let cp = cantpers.value;
    let t = tiempo.value;
    let vh = valhora.value;
    let costohoras=0;
    for (let i = 0 ; i < cp ; i++) {
      if (i==0){
        costohoras = 10 * t * vh;
      }
      if (i==1){
        costohoras = costohoras + (10 * t * vh * 0.86);
      }
      if (i>1){
        costohoras = costohoras + (10 * t * vh * 0.79);
      }
    }
    return costohoras.toFixed(2);
  }

  const valdolar = document.getElementById("dolar"); //valor del dolar
  const valhotel = document.getElementById("hotel"); //valor diario por personal del hotel

  function hotel(){//costoh del hotel para todos
  
    let cp = cantpers.value;
    let t = tiempo.value;
    let dolar = valdolar.value;
    let hot = valhotel.value;
    let costohotel=0;
    
    costohotel = (hot * cp * (t-1)) / dolar;
    return costohotel.toFixed(2);
  }

  const valcomida = document.getElementById("comida");

  function comida(){//costoh de la comida para todos

    let cp = cantpers.value;
    let t = tiempo.value;
    let com = valcomida.value
    let dolar = valdolar.value;
    let costocomida=0;
    
    costocomida = (com * cp * t) / dolar;
    return costocomida.toFixed(2);
  }

  function transporte(){// calcula el costo del transporte

    const kmIdayvuelta = document.getElementById("kmiv");
    const kmCampo = document.getElementById("kmc");

    let kmTotal = kmIdayvuelta.value * 1 + kmCampo.value * 1;
    const factor = 73.2;
    let horasUso = kmTotal/factor;

    const valVehiculo = 35000;
    const constante = 10000;

    let amort = (valVehiculo/constante*horasUso); //amortizacion del vehiculo en base a las horas de uso
    let repRep = amort * 0.8; //reparaciones y repuestos

    const litroKm = 0.1; // litros que se gastan por km
    const usLitro = 1; // costo del litro de combustible en dolares
    let combustible = kmTotal * litroKm * usLitro;
    let lubricantes = combustible * 0.1;
    
    let costotrans = (amort + repRep + combustible + lubricantes);
    return costotrans.toFixed(2);
  }

  function costodirecto(){//costo directo 

    let costd=0;

    costd = ((mirep1.value * 1) + (miequip1.value * 1) + (miinsumos1.value * 1) + (cantpers1.value * 1) + (valhotel1.value * 1) + (valcomida1.value * 1) + (valtrans1.value * 1)); // total de costos directos
    
    return costd.toFixed(2);
  }

  const gg = document.getElementById("gg");

  function costoindirecto(){//costo indirecto 

    let costoi = costodirecto() * gg.value / 100; // total de costos indirectos
    
    return costoi.toFixed(2);
  }

  
  function costototal(){//costo total

    let costototal = costodirecto() * 1 + costoindirecto() * 1;
    
    return costototal.toFixed(2);
  }

  const utilidad = document.getElementById("beneficio");

  function mibeneficio(){//costo directo 

    let ut = costototal() * utilidad.value / 100; // total de costos indirectos
    
    return ut.toFixed(2);
  }

  function iibb(){//Calculo de iibb

    let a = costototal() * 1;
    let b = mibeneficio() * 1;
    
    let ib = (a + b) * (miSelect.value / 100);
    
    return ib.toFixed(2);
  }

  function precioSiniva(){//precio total sin iva

    let c = costototal() * 1;
    let d = mibeneficio() * 1;
    let e = iibb() * 1;
    
    let psin = (c + d + e); // * (miSelect.value / 100);
    
    return psin.toFixed(2);
  }

  function precioConiva(){//precio total con iva

    let c = costototal() * 1;
    let d = mibeneficio() * 1;
    let e = iibb() * 1;
    
    let pcon = (c + d + e) * 1.21; // * (miSelect.value / 100);
    
    return pcon.toFixed(2);
  }

  function dolar(){//me trae el valor del dolar oficial

    fetch('https://www.dolarsi.com/api/api.php?type=dolar')// verificar cada tanto la página
    .then(response => response.json())
    .then(data => {
    const oficial = data.find(casa => casa.casa.nombre === 'Oficial');
    let venta = oficial.casa.venta.replace(',', '.'); // reemplazo la coma decimal por punto
    venta = venta.substring(0, venta.length - 1);// elimino el tercer digito decimal (el último)
    const cotizacionInput = document.getElementById('dolar');
    cotizacionInput.value = venta;  // escribo la cotizacion en el input con id="dolar"
  })
  .catch(error => console.error(error));
  }

var miSelect = document.getElementById("miSelect");

// Realizar solicitud HTTP para obtener el archivo JSON  DE LOS IIBB
var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function() {
  if (xhr.readyState === 4 && xhr.status === 200) {
    // Analizar el contenido JSON de la respuesta
    var provincias = JSON.parse(xhr.responseText).provincias;
    
    // Recorrer el arreglo de provincias y crear nuevos elementos option
    provincias.forEach(function(provincia) {
      var opcion = document.createElement("option");
      opcion.value = provincia.iibb;
      opcion.text = provincia.nombre;
      miSelect.appendChild(opcion);
    });
  }
};
xhr.open("GET", "iibb.json", true);
xhr.send();


function printContent() {
  // Obtenemos el contenido del div a imprimir
  var printContents1 = document.getElementById("imp1").innerHTML;
  var printContents2 = document.getElementById("imp2").innerHTML;
  // var printContents3 = document.getElementById("imp3").innerHTML;
  // var printContents4 = document.getElementById("imp4").innerHTML;
  var printContents = document.getElementById("imp5").innerHTML;
  
  // Obtenemos todos los elementos de formulario en el contenido a imprimir
  var inputs1 = document.getElementById("imp1").querySelectorAll("input, select, textarea");
  var inputs2 = document.getElementById("imp2").querySelectorAll("input, select, textarea");
  // var inputs3 = document.getElementById("imp3").querySelectorAll("input, select, textarea");
  // var inputs4 = document.getElementById("imp4").querySelectorAll("input, select, textarea");
  var inputs = document.getElementById("imp5").querySelectorAll("input, select, textarea");
  
  // Recorremos todos los elementos de formulario y agregamos su valor al contenido a imprimir
  for (var i = 0; i < inputs.length; i++) {
    var input = inputs[i];
    var name = input.getAttribute("name");
    var value = input.value;
    if (name && value) {
      printContents = printContents.replace(new RegExp('name="' + name + '"', 'g'), 'value="' + value + '"');
    }
  }
  for (var j = 0; j < inputs1.length; j++) {
    var input1 = inputs1[j];
    var name1 = input1.getAttribute("name");
    var value1 = input1.value;
    if (name1 && value1) {
      printContents1 = printContents1.replace(new RegExp('name="' + name1 + '"', 'g'), 'value="' + value1 + '"');
    }
  }
  for (var j = 0; j < inputs2.length; j++) {
    var input2 = inputs2[j];
    var name2 = input2.getAttribute("name");
    var value2 = input2.value;
    if (name2 && value2) {
      printContents2 = printContents2.replace(new RegExp('name="' + name2 + '"', 'g'), 'value="' + value2 + '"');
    }
  }
  
    // Este codigo si funciona para obtener los select
    // Obtener los select
    const select1 = document.querySelector("#idcliente");
    const select2 = document.querySelector("#miSelect");
    
    // Obtener las opciones seleccionadas
    const opcionesSelect1 = select1.selectedOptions;
    const opcionesSelect2 = select2.selectedOptions;
    
    // Crear un elemento temporal para imprimir el contenido del div
    const temp = document.createElement("div");
    
    // Agregar los valores seleccionados a la cadena de texto que se imprimirá
    temp.innerHTML += "<p>Cliente: " + opcionesSelect1[0].text + "</p>";
    temp.innerHTML += "<p>Provincia: " + opcionesSelect2[0].text + "</p>";
    //este temp va a la printWindow.document.write
    
  //   for (var j = 0; j < inputs4.length; j++) { //para imprimir el textarea no funcion
  //   var input4 = inputs4[j];
  //   var name4 = input4.getAttribute("name");
  //   var value4 = input4.value;
  //   if (name4 && value4) {
  //     printContents4 = printContents4.replace(new RegExp('name="' + name4 + '"', 'g'), 'value="' + value4 + '"');
  //   }
  // }

  
    // Seleccionar el textarea
    const textarea = document.querySelector("#imp4");
  
    // Obtener el valor del textarea
    const valorTextarea = textarea.value;
    
    // Crear un elemento temporal para imprimir el contenido del textarea
    const temp1 = document.createElement("div");
    temp1.innerHTML += "<p>Servicio a realizar: " + valorTextarea + "</p>";
    // temp1.innerHTML = valorTextarea;
    
    // Abrir una ventana emergente y escribir el contenido del textarea en ella
    // const printWindow = window.open();
    // printWindow.document.write(temp.innerHTML);
    
    // Creamos una ventana de impresión y la imprimimos
    var printWindow = window.open("", "PrintWindow", "height=600,width=800");
    printWindow.document.write("<html><head><title>Imprimir</title>");
    printWindow.document.write("</head><body>");
    printWindow.document.write(printContents1);
    printWindow.document.write("<br><br>");
    printWindow.document.write(printContents2);
    printWindow.document.write("<br><br>");
    // printWindow.document.write(printContents3);
    printWindow.document.write(temp.innerHTML);
    // printWindow.document.write("<br>");
    // printWindow.document.write(printContents4);
    printWindow.document.write(temp1.innerHTML);
  printWindow.document.write(printContents);
  printWindow.document.write("</body></html>");
  printWindow.document.close();
  printWindow.print();
  printWindow.close();
}

function printContent1() {
  // Obtenemos el contenido del div a imprimir
  var printContents1 = document.getElementById("imp1").innerHTML;

  // Obtenemos todos los elementos de formulario en el contenido a imprimir
  var inputs1 = document.getElementById("imp1").querySelectorAll("input, select, textarea");

  // Recorremos todos los elementos de formulario y agregamos su valor al contenido a imprimir
  for (var i = 0; i < inputs1.length; i++) {
    var input1 = inputs1[i];
    var name1 = input1.getAttribute("name");
    var value1 = input1.value;
    if (name1 && value1) {
      printContents1 = printContents1.replace(new RegExp('name="' + name1 + '"', 'g'), 'value="' + value1 + '"');
    }
  }

  // Creamos una ventana de impresión y la imprimimos
  var printWindow = window.open("", "PrintWindow", "height=600,width=800");
  printWindow.document.write("<html><head><title>Imprimir</title>");
  printWindow.document.write("</head><body>");
  printWindow.document.write(printContents1);
  printWindow.document.write("</body></html>");
  printWindow.document.close();
  printWindow.print();
}

