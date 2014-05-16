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

//Metodo para limpiar divPregunta si le damos al boton 'Limpiar texto original'
function limpiarContenidosBoton(id) { //le pasamos como argumento el id del TEXTO 
    var identificador = id.substring(12,id.length);
    console.log(identificador);
    document.getElementById("id_original" + identificador).value = '';
    document.getElementById("id_pregunta" + identificador).value = '';
    $("#divDerecha"+identificador).empty();
    $("#divDerecha"+id).empty();

    document.getElementById("num_palabras" + identificador).value ='0';
}
//metodo para limpiar el divPregunta si 'añadimos pregunta'
function limpiarContenidos(id) { //le pasamos como argumento el npreg del nuevo TEXTO
        console.log(id);

    document.getElementById("id_original" + id).value = '';
    document.getElementById("id_pregunta" + id).value = '';
    $("#divDerecha"+id).empty();
    $("#divDerecha"+id).empty();

}

//Reemplaza el hueco ('_____') por la palabra 
function replaceHuecoTH(idContenedor) {
//    console.log("---------"+idContenedor);
    var idTexto = idContenedor.substring(12,13); //identificador del Texto en la que estamos
//    console.log("idTEXTO: "+idTexto);
    var idPalabra = idContenedor.substring(13,idContenedor.length); //identificador dentro de la posicion del contenedor
//    console.log("idPALABRA: "+idPalabra); 
    var inicio = parseInt(document.getElementById("start"+idTexto+idPalabra).value); //obtenemos el valor del comienzo de la palabra en el texto
    var texto = document.getElementById("palabra"+idTexto+idPalabra).value;//obtenemos la palabra
    var final = inicio + texto.length; //hallamos el final de la palabra
    
    var textarea = document.getElementById("id_pregunta" + idTexto); //y el lugar donde colocar de nuevo la palabra en funcion del Texto
    textarea.value = textarea.value.substring(0, inicio) + texto + textarea.value.substring(final, textarea.value.length); //hallamos la nueva cadena
    
    $("#oculta"+idTexto+idPalabra).remove(); //y borramos la palabra del contenedor, mediante su posicion en el contenedor y la pregunta
    var num_palabras = parseInt(document.getElementById("num_palabras"+idTexto).value); //obtenemos el valor del contador que lleva la cuenta de las palabras dentro de divDerecha
    document.getElementById("num_palabras"+idTexto).value=num_palabras-1; //y lo decrementamos
    
    var children=document.getElementById("divDerecha"+idTexto).getElementsByTagName('*');
    console.log(idPalabra);

    //despues de nombrar renombramos las palabras del contenedor
    for(var i=idPalabra;i<num_palabras;i++){ 
//        console.log("i: "+i); 
        var palabraSiguiente=parseInt(i)+1;
        console.log("num: "+num_palabras);
        $(children['oculta'+idTexto+palabraSiguiente]).attr('name', "oculta"+idTexto+i).attr('id', "oculta"+idTexto+i);
        $(children['palabra'+idTexto+palabraSiguiente]).attr('name', "palabra"+idTexto+i).attr('id', "palabra"+idTexto+i);
        $(children['start'+idTexto+palabraSiguiente]).attr('name', "start"+idTexto+i).attr('id', "start"+idTexto+i);
        $(children['borrarOculta'+idTexto+palabraSiguiente]).attr('id', "borrarOculta"+idTexto+i);
        $(children['longitud'+idTexto+palabraSiguiente]).attr('name', "longitud"+idTexto+i).attr('id', "longitud"+idTexto+i);
        $(children['solucion'+idTexto+palabraSiguiente]).attr('name', "solucion"+idTexto+i).attr('id', "solucion"+idTexto+i);
        $(children['pista'+idTexto+palabraSiguiente]).attr('name', "pista"+idTexto+i).attr('id', "pista"+idTexto+i);
        $(children['campo'+idTexto+palabraSiguiente]).attr('name', "campo"+idTexto+i).attr('id', "campo"+idTexto+i);
    }
    
    
//    console.log('lengthBorrar: '+$("#contenedor"+identificador+" div").length);
    if (num_palabras === 1){
        $("#divDerecha"+idTexto).empty();
    }
    //$( this ).parent('#contador').remove();
//    console.log(this.parent());
    //console.log('borrado');

}

//?????
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
function palabraOculta(texto, start, id) {
//    var divDerecha=document.getElementById("divDerecha"+id);
//    var contador = $("#contenedor"+id+" div").length + 1; //para llevar la cuenta, se va incrementando según insertamos huecos
//    $("#divDerecha"+id).empty();
    var contador = parseInt(document.getElementById("num_palabras"+id).value)+1;//variable para saber el numero de palabras
    console.log("contadorDIVDERECHA: "+contador);

    if (contador === 1) {
        //class del contenedor (estas funciones trabajan con el atributo class, no con el id)
        $("#divDerecha"+id).append('<span class="pistas">Elim   Long     Sol    Pista [máx. 16 caracteres]</span>'); 
//        var span = document.createElement("span");
//        span.setAttribute('class','pistas');
//        span.innerHTML='Elim   Long    Sol   Pista [máx. 16 caracteres]';
//        divDerecha.appendChild(span);
    }
    //agregar campo --- todo los campos tiene id=nombre+id[numero de la pregunta]+contador[indica la posicion en el contenedor]
    $("#divDerecha"+id).append('<div id="oculta' + id + contador + '"> <input type="text" name="palabra' + id + contador + '" id="palabra' + id + contador + '" value="' + texto + '" readonly/> <input type="hidden" name="start' + id + contador + '" id="start' + id + contador + '" value="' + start + '" /> <img id="borrarOculta' + id + contador + '" src="./imagenes/delete.gif" alt="eliminarOculta"  height="10px"  width="10px" onclick="replaceHuecoTH(this.id)" /> <input name="longitud' + id + contador + '" id="longitud' + id + contador + '" type="checkbox"/> <input name="solucion' + id + contador + '" id="solucion' + id + contador + '" type="checkbox"/> <input name="pista' + id + contador + '" id="pista' + id + contador + '" type="checkbox"/> <input type="text" name="campo' + id + contador + '" id="campo' + id + contador + '"/> </div>');
    document.getElementById("num_palabras"+id).value = contador;
//    }
//document.getElementById("start" + start).value = texto;
    //document.getElementById("campo_" + contador).value = texto;
    //contador++; //text box increment
}

//Funcion para ocultar cada N palabra del texto original
function ocultarPalabras(id) {
//    limpiarContenidosBoton(id);
    var arrayPalabrasN=[]; 
    var idTexto = id.substring(10,id.length);
    $("#divPalabrasN"+idTexto).empty();
    $("#divDerecha"+idTexto).empty();
    $("#num_palabras"+idTexto).attr('value', "0");
    var seleccion = parseInt(document.getElementById("distanciaHueco" + idTexto).value);//variable para saber distancia entre los huecos [N]
    var textarea = document.getElementById("id_original" + idTexto).value;
    //console.log(textarea.length);
    var posArray = 0, palabra = 0, contador = 0, hueco = ''; //posArray[lleva la cuenta de la posicion a guardar en el array], palabra [lleva la cuenta de las palabras], contador [evita que entra en la primera palabra]
    for (i = 0; i < textarea.length; i++) {
        var valor = textarea.charAt(i);
        if (/^\s+$/.test(valor)) { //Vamos buscando los espacios en blanco
            palabra = palabra + 1; //cuando encontramos un espacio incrementamos el valor
            if (palabra === seleccion - 1) { //si palabra es = N-1 quiere decir que hemos llegado al comienzo de la N palabra
//                console.log(textarea.charAt(i+1));
                var inicio = i + 1; //tomamos el valor de inicio de la palabra
//                console.log('inicio!!: ' + inicio);
                contador = contador + 1;
            }
            if (palabra === seleccion && contador !== 0) { //si palabra es la quinta y no es la primera del texto
//                console.log(textarea.charAt(i));
//                console.log(i);
                var final = i; // tomamos el valor del final de la palabra
                var palabraN=textarea.substring(inicio,final);
                palabraOculta(palabraN,inicio,idTexto);//le pasamos como argumento 'procedencia=1' ya que llamamos a la función a través de ocultarPalabras()
                
                
                arrayPalabrasN [posArray]=[palabraN];
//                console.log(arrayPalabrasN);
                posArray++;
                
                
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
    $("#divPalabrasN"+idTexto).append('<input type="hidden" name="palabrasN' + idTexto +'" id="palabrasN' + idTexto + '" value="' + arrayPalabrasN + '" />'); 
    document.getElementById("id_pregunta" + idTexto).value = textarea;
}

//Función para añadir un hueco en el texto
function TH_addHueco(id) {
    var identificador = id.substring(9,id.length);
    console.log("TEXTO: "+identificador);
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

}

//funcion para crear mas preguntas
function clonar(){
    var npreg = parseInt(document.getElementById("num_preg").value)+1;
//    console.log(npreg);
//    var contador=($("#divGeneral div").length/10)+1;
//    console.log(contador);
    $( "#divPregunta1" ).clone().attr('name', "divPregunta"+npreg).attr('class', "divPregunta"+npreg).attr('id',"divPregunta"+npreg).appendTo( ".divGeneral" );
    document.getElementById("num_preg").value = npreg;
            
    var children=document.getElementById("divPregunta"+npreg).getElementsByTagName('*');
//    console.log(children);
    //console.log(children['add_hueco1']);
//    $(children['h3']).attr('innerText', "Texto "+npreg);
    $(children['borrarTextos1']).attr('name', "borrarTextos"+npreg).attr('id', "borrarTextos"+npreg);
    $(children['distanciaHueco1']).attr('name', "distanciaHueco"+npreg).attr('id', "distanciaHueco"+npreg);
    $(children['id_original1']).attr('name', "id_original"+npreg).attr('id', "id_original"+npreg);
    $(children['add_hueco1']).attr('name', "add_hueco"+npreg).attr('id', "add_hueco"+npreg);
    $(children['divDerecha1']).attr('name', "divDerecha"+npreg).attr('id', "divDerecha"+npreg);
    $(children['textoHueco1']).attr('name', "textoHueco"+npreg).attr('id', "textoHueco"+npreg);
    $(children['id_pregunta1']).attr('name', "id_pregunta"+npreg).attr('id', "id_pregunta"+npreg);
    $(children['num_palabras1']).attr('name', "num_palabras"+npreg).attr('id', "num_palabras"+npreg).attr('value', "0");

    
    limpiarContenidos(npreg);  



    
}
