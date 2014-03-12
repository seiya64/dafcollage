/*
 * Funciones javaScript especificas para el ejercicio Texto Hueco
 * @author Borja Arroba Hernandez, Carlos Aguilar Miguel
 * 
 */


//Funcion que devuelve un array asociativo con la posicion de inicio y de fin del texto seleccionado
function getInputSelectionTH(el) {
    var start = 0, end = 0, normalizedValue, range,
            textInputRange, len, endRange;

    if (typeof el.selectionStart == "number" && typeof el.selectionEnd == "number") {
        start = el.selectionStart;
        end = el.selectionEnd;
    } else {
        range = document.selection.createRange();

        if (range && range.parentElement() == el) {
            len = el.value.length;
            normalizedValue = el.value.replace(/\r\n/g, "\n");

            // Create a working TextRange that lives only in the input
            textInputRange = el.createTextRange();
            textInputRange.moveToBookmark(range.getBookmark());

            // Check if the start and end of the selection are at the very end
            // of the input, since moveStart/moveEnd doesn't return what we want
            // in those cases
            endRange = el.createTextRange();
            endRange.collapse(false);

            if (textInputRange.compareEndPoints("StartToEnd", endRange) > -1) {
                start = end = len;
            } else {
                start = -textInputRange.moveStart("character", -len);
                start += normalizedValue.slice(0, start).split("\n").length - 1;

                if (textInputRange.compareEndPoints("EndToEnd", endRange) > -1) {
                    end = len;
                } else {
                    end = -textInputRange.moveEnd("character", -len);
                    end += normalizedValue.slice(0, end).split("\n").length - 1;
                }
            }
        }
    }

    return {
        start: start,
        end: end
    };
}

//Devuelve el texto seleccionado del elemento el
function getSelectedTextTH(el) {
    var sel = getInputSelection(el);
    return el.value.slice(sel.start, sel.end);
}

//Reemplaza el texto seleccionado del elemento el por el texto dado en text
function replaceSelectedTextTH(el) {
    var sel = getInputSelection(el), val = el.value;
    el.value = val.slice(0, sel.start) + '_________' + val.slice(sel.end);
}

//Boton para corregir un ejercicio de Texto Hueco
function TH_Corregirtemporal(id_ejercicio, mostrar_soluciones) {
    alert("TH CORREGIR ENTRA AQUI");

    var numpreg = parseInt(document.getElementById("num_preg").value);
    for (var i = 1; i <= numpreg; i++) {
        var numresp = parseInt(document.getElementById("num_resp_preg" + i).value);
        for (var j = 1; j <= numresp; j++) {
            var resp = document.getElementById("resp" + j + "_" + i);
            if (resp.value === respuestas[i - 1][j - 1]) {
                var img = document.getElementById("img_resp" + j + "_" + i);
                img.setAttribute("src", "./imagenes/correcto.png");
            }
            else {
                var img = document.getElementById("img_resp" + j + "_" + i);
                img.setAttribute("src", "./imagenes/incorrecto.png");
                if (mostrar_soluciones) {
                    resp.value = respuestas[i - 1][j - 1];
                }
            }
        }
    }
}

//Metodo para que aparezca en el campo 'palabras ocultas' del formulario las palabras que hayan sido sustituidas por huecos
function palabraOculta(texto){
    document.getElementById("respuesta1_1").value=texto;
    //console.log(respuesta1_1);
    //$('#respuesta1_1').attr('value',texto);
    console.log(respuesta1_1);
}
function TH_addHueco() {
    //console.log(numpreg); pasar numero de la pregunta como argumento
    var textarea = document.getElementById("id_pregunta" + 1); //Cojo el textarea
    console.log(textarea);
    //var numresp = parseInt(document.getElementById("numerorespuestas_"+numpreg).value); YA NO UTILIZO ESTE TEXTAREA
    var texto_sel = getSelectedTextTH(textarea);
    //console.log(texto_sel);
    var sel = getInputSelectionTH(textarea);
    
    //Comprobamos que se ha seleccionado un hueco
    if ( texto_sel == null || texto_sel.length == 0 ) {
        alert("Seleccione para crear un hueco.");
        return;
    }
 
    //Comprobamos si se ha seleccionado un espacio en blanco
    for ( i = 0; i < texto_sel.length; i++){
        var valor = texto_sel.charAt(i);
        if (/^\s+$/.test(valor)){
            alert("No se puede selecionar un espacio en blanco");
            return;
        }    
    }
    
    //Comprobamos que no se elija un hueco dentro de otro hueco
    if (/_/.test(texto_sel)){
        alert("No puede seleccionar un hueco ya existente");
        return;
    }
    //Remplazamos el texto seleccionado por '______'
    replaceSelectedTextTH(textarea);
    //Introducimos la palabra seleccionada en el campo 'Palabras Ocultas'
    palabraOculta(texto_sel);

//    ---no se si he modificado algo de lo comentado, mirar funcion original funciones.js!!---
//    //Comprobar que no haya un hueco en el texto seleccionado. O que no haya un $ atras o adelante
//    var regexp = /(\[|\])/g;
//    if (texto_sel.match(regexp)) {
//        alert("No se puede crear un hueco que contenga a otro hueco. Revise el texto seleccionado.");
//        return;
//    }
//    //Esto impide que se cree un hueco con los digitos que identifica un hueco
//    var inicio = (sel.start>=1) ? sel.start-1 : sel.start;
//    var fin = (sel.end==textarea.value.length-1) ? sel.end : sel.end+1;
//    var t = textarea.value.slice(inicio,fin);
//    if (t.match(regexp)) {
//        alert("No se puede crear un hueco que contenga a otro hueco. Revise el texto seleccionado.");
//        return;
//    }
//    
//    
//    var div_respuestas = document.getElementById("respuestas_pregunta"+numpreg);
//    var resp = createElement("textarea",{name: "respuesta"+(numresp+1)+"_"+numpreg, id: "respuesta"+(numresp+1)+"_"+numpreg,
//                                         rows:"1", cols:"50",readonly:"yes", value:texto_sel});
//    resp.appendChild(document.createTextNode(texto_sel));
//    div_respuestas.appendChild(resp);
//    
//    replaceSelectedText(textarea,"[["+numresp+"]]");
//    var numero_respuestas = document.getElementById("numerorespuestas_"+numpreg);
//    numero_respuestas.value = (numresp+1);
}


function introducirRespuesta() {

}