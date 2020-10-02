<script src="http://code.jquery.com/jquery-latest.js"></script>
 
    <script type='text/javascript'>

    {
        cuenta = 0;
        asignados=[];
        valor=0;
        texto="";
    }

    $(document).ready(function(){
        /** Seleccionamos el elemento con el id 5 */
        $("#selecciona5").click(function(){
            $("#selector").val(5);
            // ejecutamos el evento change()
            $("#selector").change();
        });
 
        /** Seleccionamos el elemento con el id 1 */
        $("#selecciona1").click(function(){
            $("#selector").val(1);
            // ejecutamos el evento change()
            $("#selector").change();
        });
 
        /** deshabilitamos el valor 3 */
        $("#desactivar3").click(function(){
            $("#selector option[value=3]").attr('disabled','disabled');
        });
 
        /** habilitamos el valor 3 */
        $("#activar3").click(function(){
            $("#selector option[value=3]").removeAttr('disabled');
        });
 
        /** validamos que haya un valor del desplegable seleccionado */
        $("#validar").click(function(){
            if($("#selector").val()==0)
            {
                alert("No hay ninguna opcion seleccionada");
            }else{
                alert("Esta seleccionado el valor: "+$("#selector").val());
            }
        });
 
        /** Mostramos el valor-texto seleccionado */
        $("#agente").change(function(){
            cuenta = cuenta + 1;
            asignados[cuenta]=$("#agente option:selected").text();
            valor=$("#agente").val();
            texto=$("#agente option:selected").text();
            //var valor=$("#agente").val();
            //var texto=$("#agente option:selected").text();
            //$("#valorSeleccionado").html(valor+" - "+texto);
            //$("#contador").html(cuenta);
            //$("#valorSeleccionado").html(valor);
            contador();
            
        });
        
    });
        function contador() {
            //cuenta = cuenta + 1;
            if(cuenta>0){
                var body = document.getElementsByTagName("body")[0];
                var tabla   = document.createElement("table");
                var tblBody = document.createElement("tbody");
                for(let i=1; i<=cuenta; i++) {
                    // en este caso, la variable i sólo existe dentro del bucle for
                    alert(i);
                    //$("#valorSeleccionado").html(valor+" - "+texto);
                    var hilera = document.createElement("tr");
                    //$("#contador").html(cuenta);
                    
                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(asignados[i]);
                }
                celda.appendChild(textoCelda);
                hilera.appendChild(celda);
                tblBody.appendChild(hilera);
                tabla.appendChild(tblBody);
                // appends <table> into <body>
                body.appendChild(tabla);
                tabla.appendChild(tblBody);
                //</body>tabla.setAttribute("border", "1");
                tabla.setAttribute("class", "table table-bordered");
            }else{
                alert(cuenta);
            }
        }
    </script>