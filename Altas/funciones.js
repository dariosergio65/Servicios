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
 
        /** Asignamos el valor-texto seleccionado */
        $("#agente").change(function(){
            //texto=$("#agente option:selected").text();
            //asignados.push(texto);
            cuenta = cuenta + 1;
            asignados[cuenta]=$("#agente option:selected").text();
            valor=$("#agente").val();
            contador();
        });

        /** Borrar un agente */
        $("#borrar1").click(function(){
            alert("click en el radio");
        });
        
    });
        function contador() {
            if(cuenta>0){
                var aqui = document.getElementById("aquiagentes");
                var fila = document.createElement("tr");
                    //aa[i]= '<a href="../edit.php" class= "btn btn-warning btn-sm">Detalle </i></a>';
                var celda = document.createElement("td");
                var celda1 = document.createElement("td");
                var textoCelda = document.createTextNode(asignados[cuenta]);
                //var boton = document.createElement("button");
                var miradio = document.createElement("input");
                //boton.innerText = 'Borrar'; 
                //boton.setAttribute("class", "btn btn-danger btn-sm");
                //boton.setAttribute= ("name", "borrar1");
                miradio.type = ("radio");
                miradio.id = "borrar1";
                var textoradio = document.createTextNode("Borrar ");

                celda.appendChild(textoCelda);
                celda1.appendChild(textoradio); 
                celda1.appendChild(miradio); 
                fila.appendChild(celda);
                fila.appendChild(celda1);
                aqui.appendChild(fila);

                //boton.setAttribute("onclick", borraAgente());
                //miradio.setAttribute("id", "borrar1");

            }else{
                alert(cuenta);
            }
        }
        

        function borraAgente(){
            //dd
            alert("funciona ok");
        }
    </script>