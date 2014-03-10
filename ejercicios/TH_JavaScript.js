/*
 * Funciones javaScript especificas para el ejercicio Texto Hueco
 * @author Borja Arroba Hernandez, Carlos Aguilar Miguel
 * 
 */


//Boton para corregir un ejercicio de Texto Hueco
function TH_Corregirtemporal(id_ejercicio,mostrar_soluciones) {
    alert("TH CORREGIR ENTRA AQUI");
    
    var numpreg = parseInt(document.getElementById("num_preg").value);
    for (var i=1; i<=numpreg; i++) {
        var numresp = parseInt(document.getElementById("num_resp_preg"+i).value);
        for (var j=1; j<=numresp; j++) {
            var resp = document.getElementById("resp"+j+"_"+i);
            if (resp.value===respuestas[i-1][j-1]) {
                var img = document.getElementById("img_resp"+j+"_"+i);
                img.setAttribute("src","./imagenes/correcto.png");
            }
            else {
                var img = document.getElementById("img_resp"+j+"_"+i);
                img.setAttribute("src","./imagenes/incorrecto.png");
                if (mostrar_soluciones) {
                    resp.value = respuestas[i-1][j-1];
                }
            }
        }
    }
}

function TH_addHueco_Creaciontemporal(id_ejercicio,numpreg) {
    var textarea = document.getElementById("id_pregunta"+numpreg); //Cojo el textarea
    var numresp = parseInt(document.getElementById("numerorespuestas_"+numpreg).value);
    var texto_sel = getSelectedText(textarea);
    var sel = getInputSelection(textarea);
    
    //Comprobar que no haya un hueco en el texto seleccionado. O que no haya un $ atras o adelante
    var regexp = /(\[|\])/g;
    if (texto_sel.match(regexp)) {
        alert("No se puede crear un hueco que contenga a otro hueco. Revise el texto seleccionado.");
        return;
    }
    //Comprobar que no se haya seleccionado una cadena vacia
    if (texto_sel==="") {
        alert("No se puede crear un hueco vacio. Escriba algo de texto y seleccione para crear un hueco.");
        return;
    }
    //Esto impide que se cree un hueco con los digitos que identifica un hueco
    var inicio = (sel.start>=1) ? sel.start-1 : sel.start;
    var fin = (sel.end==textarea.value.length-1) ? sel.end : sel.end+1;
    var t = textarea.value.slice(inicio,fin);
    if (t.match(regexp)) {
        alert("No se puede crear un hueco que contenga a otro hueco. Revise el texto seleccionado.");
        return;
    }
    
    
    var div_respuestas = document.getElementById("respuestas_pregunta"+numpreg);
    var resp = createElement("textarea",{name: "respuesta"+(numresp+1)+"_"+numpreg, id: "respuesta"+(numresp+1)+"_"+numpreg,
                                         rows:"1", cols:"50",readonly:"yes", value:texto_sel});
    resp.appendChild(document.createTextNode(texto_sel));
    div_respuestas.appendChild(resp);
    
    replaceSelectedText(textarea,"[["+numresp+"]]");
    var numero_respuestas = document.getElementById("numerorespuestas_"+numpreg);
    numero_respuestas.value = (numresp+1);
}

function introducirRespuesta ()  {
    
}