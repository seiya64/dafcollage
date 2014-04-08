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
function replaceSelectedTextTH(campo) {
    var hueco = '';
    var seleccion = getInputSelection(campo), texto = campo.value;
    for (i = 0; i < seleccion.end - seleccion.start; i++) {
        hueco = hueco + '_';
    }
    campo.value = texto.slice(0, seleccion.start) + hueco + texto.slice(seleccion.end);
}

//Metodo para limpiar los contenidos en los textarea
function limpiarContenidos(id) {
    var identificador = id.substring(12,id.length);
    document.getElementById("id_original" + identificador).value = '';
    document.getElementById("id_pregunta" + identificador).value = '';
    $(".contenedor"+identificador).empty();
//    var ide = parseInt(2);
//    $(".contenedor"+ide).empty();
}
//Reemplaza el hueco ('_____') por la palabra 
function replaceHuecoTH(idContenedor) {
    var identificadorContenedor = idContenedor.substring(13,14); //identificador dentro de la posicion del contenedor
    console.log("identiCont"+identificadorContenedor);
    var identificador = idContenedor.substring(14,idContenedor.length); //identificador de la pregunta en la que estamos
    console.log("identi"+identificador); 
    var inicio = parseInt(document.getElementById("start_"+identificadorContenedor+identificador).value); //obtenemos el valor del comienzo de la palabra en el texto
    var texto = document.getElementById("palabra_"+identificadorContenedor+identificador).value;//obtenemos la palabra
    var final = inicio + texto.length; //hallamos el final de la palabra
    var textarea = document.getElementById("id_pregunta" + identificador); //y el lugar donde colocar de nuevo la palabra en funcion de la pregunta
    textarea.value = textarea.value.substring(0, inicio) + texto + textarea.value.substring(final, textarea.value.length); //hallamos la nueva cadena
    $(".oculta"+identificadorContenedor+identificador).remove(); //y borramos la palabra del contenedor, mediante su posicion en el contenedor y la pregunta
    console.log('lengthBorrar: '+$("#contenedor"+identificador+" div").length);
    if ($("#contenedor"+identificador+" div").length === 0){
        $(".contenedor"+identificador).empty();
    }
    //$( this ).parent('#contador').remove();
//    console.log(this.parent());
    //console.log('borrado');

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
function palabraOculta(texto, start,id) {
    var contador = $("#contenedor"+id+" div").length + 1; //para llevar la cuenta, se va incrementando según insertamos huecos
    console.log("contadorAdd: "+contador);
    if (contador === 1) {
        //ID del contenedor
        $(".contenedor"+id).append('<span class="pistas">Elim   Long    Sol   Pista [máx. 16 caracteres]</span>'); 
    }
    //agregar campo --- todo los campos tiene id=nombre+contador[indica la posicion en el contenedor]+id[numero de la pregunta]
    $(".contenedor"+id).append('<div class="oculta' + contador + id + '"> <input type="text" name="palabra' + contador + '" id="palabra_' + contador + id + '" value="' + texto + '" readonly/> <input type="hidden" name="' + contador + '" id="start_' + contador + id + '" value="' + start + '" /> <img id="borrarOculta_' + contador + id+ '" src="./imagenes/delete.gif" alt="eliminarOculta"  height="10px"  width="10px" onclick="replaceHuecoTH(this.id)" /> <input id="check1" type="checkbox"/> <input id="check2" type="checkbox"/> <input id="check3" type="checkbox"/> <input type="text" name="campo' + contador + '" id="campo_' + contador + id+ '"/> </div>');
    //document.getElementById("start" + start).value = texto;
    //document.getElementById("campo_" + contador).value = texto;
    //contador++; //text box increment
}

//Funcion para ocultar cada quinta palabra del texto original
function ocultarPalabras(id) {
    var identificador = id.substring(10,id.length);
    var seleccion = parseInt(document.getElementById("distanciaHueco" + identificador).value);//variable para saber distancia entre los huecos
    var textarea = document.getElementById("id_original" + identificador).value;
    //console.log(textarea.length);
    var palabra = 0, contador = 0, hueco = ''; //palabra [lleva la cuenta de las palabras], contador [evita que entra en la primera palabra]
    for (i = 0; i < textarea.length; i++) {
        var valor = textarea.charAt(i);
        if (/^\s+$/.test(valor)) { //Vamos buscando los espacios en blanco
            palabra = palabra + 1; //cuando encontramos un espacio incrementamos el valor
            if (palabra === seleccion - 1) { //si palabra es = 4 quiere decir que hemos llegado al comienzo de la quinta palabra
//                console.log(textarea.charAt(i+1));
                var inicio = i + 1; //tomamos el valor de inicio de la palabra
//                console.log('inicio!!: ' + inicio);
                contador = contador + 1;
            }
            if (palabra === seleccion && contador !== 0) { //si palabra es la quinta y no es la primera del texto
//                console.log(textarea.charAt(i));
//                console.log(i);
                var final = i; // tomamos el valor del final de la palabra
//                console.log('final: ' + final);
                for (j = 0; j < final - inicio; j++) { //hacemos el hueco segun la longuitud de la palabra a ocultar
                    hueco = hueco + '_';
                }
                //console.log(hueco);
//                textarea= hueco+'a';
                textarea = textarea.substring(0, inicio) + hueco + textarea.substring(final, textarea.length);
                hueco = '';
                palabra = 0; //hacemos 0 para que empieze a buscar despues de la ultima palabra ocultada
            }
        }
    }
    document.getElementById("id_pregunta" + identificador).value = textarea;
}
//Función para copiar el texto original del textarea al que se puede modificar
function copiaTextoOriginal() { //ACTUALMENTE NO SE USA
    //var textarea = document.getElementById("id_original" + 1);
    //console.log('value:'+id_original1.value);
    //console.log(texto_sel);
    document.getElementById("id_pregunta" + 1).value = id_original1.value;
    //console.log(id_pregunta1.value);
}

//Función para añadir un hueco en el texto
function TH_addHueco(id) {
    var identificador = id.substring(9,id.length);
    console.log(identificador);
    //console.log(numpreg); pasar numero de la pregunta como argumento!!!
    var textarea = document.getElementById("id_pregunta" + identificador); //Cojo el textarea
    //var numresp = parseInt(document.getElementById("numerorespuestas_"+numpreg).value); YA NO UTILIZO ESTE TEXTAREA
    var texto_sel = getSelectedTextTH(textarea);
    //console.log(texto_sel);
    var sel = getInputSelectionTH(textarea);

    //Comprobamos que se ha seleccionado un hueco
    if (texto_sel === null || texto_sel.length === 0) {
        alert("Seleccione para crear un hueco.");
        return;
    }

    //Comprobamos si se ha seleccionado un espacio en blanco
    for (i = 0; i < texto_sel.length; i++) {
        var valor = texto_sel.charAt(i);
        if (/^\s+$/.test(valor)) {
            alert("No se puede selecionar un espacio en blanco");
            return;
        }
    }

    //Comprobamos que no se elija un hueco dentro de otro hueco
    if (/_/.test(texto_sel)) {
        alert("No puede seleccionar un hueco ya existente");
        return;
    }
    //Remplazamos el texto seleccionado por '______'.
    replaceSelectedTextTH(textarea);
    //Introducimos la palabra seleccionada en el campo 'Palabras Ocultas'
    palabraOculta(texto_sel, sel.start, identificador); 
    //palabra(texto_sel);

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


function introducirPreguntas() {
    
}