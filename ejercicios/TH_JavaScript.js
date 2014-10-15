/*
 * Funciones javaScript especificas para el ejercicio Texto Hueco
 * @author Borja Arroba Hernandez, Carlos Aguilar Miguel
 * 
 */



//Función para añadir un hueco en el texto
function TH_addHueco(id) {
    var identificador = id.substring(9, id.length);
    var textarea = document.getElementById("id_pregunta" + identificador); //Cojo el textarea
    var texto_sel = getSelectedTextTH(textarea);
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
    replaceSelectedTextTH(textarea, identificador);
    //Introducimos la palabra seleccionada en el campo 'Palabras Ocultas'
    palabraOculta(texto_sel, sel.start, identificador, 0);
}

//Funcion que devuelve un array asociativo con la posicion de inicio y de fin del texto seleccionado
function getInputSelectionTH(el) {
    var start = 0, end = 0, normalizedValue, range, textInputRange, len, endRange;

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
function replaceSelectedTextTH(campo, identificador) {
    var hueco = '';
    var contador = parseInt(document.getElementById("num_palabras"+identificador).value)+1;
    var seleccion = getInputSelection(campo), texto = campo.value;
    
    for (i = 0; i < seleccion.end+1 - seleccion.start; i++) {
        if(i===0){
            hueco = hueco + '['+contador+'] ';
        }
        hueco = hueco + '_';
    }
    campo.value = texto.slice(0, seleccion.start) + hueco + texto.slice(seleccion.end);
}

//Metodo para que aparezca en el campo 'palabras ocultas' del formulario las palabras que hayan sido sustituidas por huecos
function palabraOculta(texto, start, id, procedencia) {
    var contador = parseInt(document.getElementById("num_palabras" + id).value) + 1;//variable para saber el numero de palabras
    
    if (contador === 1) {
        $("#divDer"+id).append('<div class="pistas"><img id="pista" src="./imagenes/pista_descripcion.png" title="Seleccionar todo" onclick="selectAll('+id+', id)">\n\
                                <img style="margin-left:6px" id="longitud" src="./imagenes/pista_longitud.png" title="Seleccionar todo" onclick="selectAll('+id+', id)">\n\
                                <img style="margin-left:6px" id="solucion" src="./imagenes/pista_palabra.png" title="Seleccionar todo" onclick="selectAll('+id+', id)"></div>');
    }
    //agregar campo --- todo los campos tiene id=nombre+id[numero de la pregunta]+contador[indica la posicion en el contenedor]
    $("#divDer" + id).append('<div id="oculta'+id+contador+'">\n\
                                <input type="text" name="palabra'+id+contador+'" id="palabra' + id + contador+'" value="'+texto+'" readonly>\n\
                                <input type="hidden" name="start'+id+contador+'" id="start' + id + contador+'" value="'+start+'">\n\
                                <img id="borrarOculta'+id+contador+'" src="./imagenes/delete.gif" alt="eliminarOculta" height="13px" width="13px" onclick="replaceHuecoTH(this.id)">\n\
                                <input value="o" name="pista'+id+contador+'" id="pista'+id+contador+'" type="checkbox">\n\
                                <input value="o" name="longitud'+id+contador + '" id="longitud'+id+contador+'" type="checkbox">\n\
                                <input value="o" name="solucion'+id+contador + '" id="solucion'+id+contador+'" type="checkbox">\n\
                                <input type="text" name="campo'+id+contador + '" id="campo'+id+contador+'">\n\
                            </div>');
    document.getElementById("num_palabras"+id).value = contador;
    
    if (procedencia === 0) { //la procedencia sera 0 si el profesor a pulsado el botón 'Añadir Hueco', sino será 1 y el profesor habrá pulsado 'Crear texto hueco'
        var startNuevaPalabra = parseInt(start);
        for (i = 0; i < contador - 1; i++) {
            var posicion = parseInt(i) + 1;
            var startViejaPalabra = parseInt(document.getElementById("start" + id + posicion).value);
            if (startNuevaPalabra < startViejaPalabra) {
                var children = document.getElementById("divDer" + id).getElementsByTagName('*');
                var valor = parseInt(document.getElementById("start" + id + posicion).value) + 5; //le sumo 5 ya que ha cambiado la posicion de inicio
                $(children['start' + id + posicion]).attr('value', valor);
            }
        }
    }
}

//Funcion para ocultar cada N palabra del texto original
function ocultarPalabras(id) {
    var arrayPalabrasN = [];
    var idTexto = id.substring(10, id.length);
    $("#divPalabrasN" + idTexto).empty();
    $("#divDer" + idTexto).empty();
    $("#num_palabras" + idTexto).attr('value', "0");
    var seleccion = parseInt(document.getElementById("distanciaHueco" + idTexto).value);//variable para saber distancia entre los huecos [N]
    var textarea = document.getElementById("id_original" + idTexto).value;
//    console.log(textarea);
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
                var palabraN = textarea.substring(inicio, final);
                palabraOculta(palabraN, inicio, idTexto, 1);//le pasamos como argumento 'procedencia=1' ya que llamamos a la función a través de ocultarPalabras()


                arrayPalabrasN [posArray] = [palabraN];
//                console.log(arrayPalabrasN);
                posArray++;


//                console.log('final: ' + final);
                for (j = 0; j < final+1 - inicio; j++) { //hacemos el hueco segun la longuitud de la palabra a ocultar
                    if(j===0){
                        hueco = hueco + '['+contador+'] ';
                        console.log(hueco);
                    }else{
                        hueco = hueco + '_';
                        console.log(hueco);

                    }
//                    hueco = hueco + '_';
                }
                //console.log(hueco);
//                textarea= hueco+'a';
                textarea = textarea.substring(0, inicio) + hueco + textarea.substring(final, textarea.length);
                hueco = '';
                palabra = 0; //hacemos 0 para que empieze a buscar despues de la ultima palabra ocultada
            }
        }
    }
    $("#divPalabrasN" + idTexto).append('<input type="hidden" name="palabrasN' + idTexto + '" id="palabrasN' + idTexto + '" value="' + arrayPalabrasN + '" />');
    document.getElementById("id_pregunta" + idTexto).value = textarea;

}

//Metodo para limpiar divPregunta si le damos al boton 'Limpiar'
function limpiarContenidosBoton(id) { //le pasamos como argumento el id del TEXTO 
    var identificador = id.substring(12, id.length);
    
    document.getElementById("id_original" + identificador).value = '';
    document.getElementById("id_pregunta" + identificador).value = '';
    $("#divDer" + identificador).empty();
    document.getElementById("num_palabras" + identificador).value = '0';
}
//metodo para limpiar el divPregunta si 'añadimos pregunta'
function limpiarContenidos(id) { //le pasamos como argumento el npreg del nuevo TEXTO
    document.getElementById("id_original"+id).value = '';
    document.getElementById("id_pregunta"+id).value = '';
    $("#divDer"+id).empty();

}

//Reemplaza el hueco ('_____') por la palabra 
function replaceHuecoTH(idContenedor) {
//    console.log("---------"+idContenedor);
    var idTexto = idContenedor.substring(12, 13); //identificador del Texto en la que estamos
//    console.log("idTEXTO: "+idTexto);
    var idPalabra = idContenedor.substring(13, idContenedor.length); //identificador dentro de la posicion del contenedor
//    console.log("idPALABRA: "+idPalabra); 
    var inicio = parseInt(document.getElementById("start" + idTexto + idPalabra).value); //obtenemos el valor del comienzo de la palabra en el texto
    var texto = document.getElementById("palabra" + idTexto + idPalabra).value;//obtenemos la palabra
    var final = inicio + texto.length +5; //hallamos el final de la palabra

    //cambio los valores start de todas las palabras del contenedor antes de borrar y ...
    var num_palabras = parseInt(document.getElementById("num_palabras" + idTexto).value); //obtenemos el valor del contador que lleva la cuenta de las palabras dentro de divDer
    var startPalabraBorrar = parseInt(document.getElementById("start" + idTexto + idPalabra).value);
    for (j = 0; j < num_palabras; j++) {
            var posicion = parseInt(j) + 1;
            console.log("aqui:"+idTexto+posicion+"palabras:"+num_palabras);
            var startPalabras = parseInt(document.getElementById("start" + idTexto + posicion).value);
            if (startPalabraBorrar < startPalabras) {
                var children = document.getElementById("divDer" + idTexto).getElementsByTagName('*');
                var valor = parseInt(document.getElementById("start" + idTexto + posicion).value) - 5; //le resto 5 ya que ha cambiado la posicion de inicio
                $(children['start' + idTexto + posicion]).attr('value', valor);
            }
    }
    //cambio el numero del hueco (le resto uno) -> [3] ----> [2]
    var textarea = document.getElementById("id_pregunta" + idTexto); //y el lugar donde colocar de nuevo la palabra en funcion del Texto
    
    for (h = 0; h <= textarea.value.lenght; h++){
        console.log(textarea.value);
    }
    
    textarea.value = textarea.value.substring(0, inicio) + texto + textarea.value.substring(final, textarea.value.length); //hallamos la nueva cadena

    $("#oculta" + idTexto + idPalabra).remove(); //y borramos la palabra del contenedor, mediante su posicion en el contenedor y la pregunta
    document.getElementById("num_palabras" + idTexto).value = num_palabras - 1; //y lo decrementamos

    var children = document.getElementById("divDer" + idTexto).getElementsByTagName('*');
    console.log(idPalabra);

    //despues de nombrar renombramos las palabras del contenedor
    for (var i = idPalabra; i < num_palabras; i++) {
//        console.log("i: "+i); 
        var palabraSiguiente = parseInt(i) + 1;
        console.log("num: " + num_palabras);
        $(children['oculta' + idTexto + palabraSiguiente]).attr('name', "oculta" + idTexto + i).attr('id', "oculta" + idTexto + i);
        $(children['palabra' + idTexto + palabraSiguiente]).attr('name', "palabra" + idTexto + i).attr('id', "palabra" + idTexto + i);
        $(children['start' + idTexto + palabraSiguiente]).attr('name', "start" + idTexto + i).attr('id', "start" + idTexto + i);
        $(children['borrarOculta' + idTexto + palabraSiguiente]).attr('id', "borrarOculta" + idTexto + i);
        $(children['longitud' + idTexto + palabraSiguiente]).attr('name', "longitud" + idTexto + i).attr('id', "longitud" + idTexto + i);
        $(children['solucion' + idTexto + palabraSiguiente]).attr('name', "solucion" + idTexto + i).attr('id', "solucion" + idTexto + i);
        $(children['pista' + idTexto + palabraSiguiente]).attr('name', "pista" + idTexto + i).attr('id', "pista" + idTexto + i);
        $(children['campo' + idTexto + palabraSiguiente]).attr('name', "campo" + idTexto + i).attr('id', "campo" + idTexto + i);
    }

    if (num_palabras === 1) {
        $("#divDer" + idTexto).empty();
    }

}

//Boton para corregir un ejercicio de Texto Hueco
function TH_corregir() {
    
}

//funcion para tachar las palabras que el alumno baja introduciendo
function tachar(id) {
    var palabra = parseInt(id.substring(12, 13));
    var posicion = parseInt(id.substring(13, 14));
    var valor = parseInt(id.substring(14, id.lenght));
    var valorA = document.getElementById("respuesta" + posicion).value; //valor de la palabra del input (palabra del alumno)
    var n_palabras = document.getElementById("n_palabras").value;
    for (i=1; i<=n_palabras; i++){
        var palabraLista = document.getElementById("palabras"+palabra+i).innerHTML; //valor de las soluciones
        if (valorA === palabraLista) {
            if (valor === 0) {
                $('#palabras' + palabra + i).attr('style', "text-decoration: line-through; width: 100px;");
                $('#borrarTachar' + palabra + posicion + valor).attr('id', "borrarTachar" + palabra + posicion + 1);
            } else {
                $('#palabras' + palabra + i).attr('style', "width: 100px;");
                $('#borrarTachar' + palabra + posicion + valor).attr('id', "borrarTachar" + palabra + posicion + 0);
            }
        }
    }
}

//funcion para crear mas preguntas
function clonar() {
    var npreg = parseInt(document.getElementById("numText").value) + 1;

    $("#divTexto1").clone().attr('name', "divTexto" + npreg).attr('class', "divTexto").attr('id', "divTexto" + npreg).appendTo(".divEjercicio");
    document.getElementById("numText").value = npreg;

    var children = document.getElementById("divTexto" + npreg).getElementsByTagName('*');

    $(children['divIzq1']).attr('name', "divIzq" + npreg).attr('id', "divIzq" + npreg);
    $(children['distanciaHueco1']).attr('name', "distanciaHueco" + npreg).attr('id', "distanciaHueco" + npreg);
    $(children['textoHueco1']).attr('name', "textoHueco" + npreg).attr('id', "textoHueco" + npreg);
    $(children['borrarTextos1']).attr('name', "borrarTextos" + npreg).attr('id', "borrarTextos" + npreg);
    $(children['id_original1']).attr('name', "id_original" + npreg).attr('id', "id_original" + npreg);
    $(children['id_pregunta1']).attr('name', "id_pregunta" + npreg).attr('id', "id_pregunta" + npreg);
    $(children['num_palabras1']).attr('name', "num_palabras" + npreg).attr('id', "num_palabras" + npreg).attr('value', "0");
    $(children['add_hueco1']).attr('name', "add_hueco" + npreg).attr('id', "add_hueco" + npreg);
    $(children['divPalabrasN1']).attr('name', "divPalabrasN" + npreg).attr('id', "divPalabrasN" + npreg);
    $(children['divDer1']).attr('name', "divDer" + npreg).attr('id', "divDer" + npreg);

    limpiarContenidos(npreg);
}

//Selecciona todos los checkbox de la opcion (op) desde la que se llama de las palabras ocultadas
function selectAll(ntexto, op) {
    console.log("estoooty "+op+"  "+ntexto);
    npalabras=document.getElementById("num_palabras"+ntexto).value;
    var ch=1;
    var val='v';
    if(document.getElementById(op+"11").value==='o') {
        ch=1;
        val='v';
    } else {
        ch=0;
        val='o';
        
    }
    for(i=1; i<=npalabras; i++) {
            document.getElementById(op+ntexto+i).checked=ch;
            document.getElementById(op+ntexto+i).value=val;
    }
}

//Funciones para realizar el ejercicio (modo alumno)

//Selecciona el div de una palabra
function seleccionapalabra(id) {
    //si ya esta seleccionada la deselecciono y limpio el campo hidden
    if($("#"+id).attr("class")=="palabraSel") {
        $("#"+id).attr("class", "palabra");
        $("#guardapalabras").attr("value", "");
        $("#guardapalabras").attr("name", "");
    } else {
        //si no esta seleccionada y no esta marcada como asignada entonces la selecciono y añado los campos al hidden
        if($("#"+id).attr("class")!="palabraMarc") {
            //Deselecciona todas las palabras seleccionadas y marca en la que se acaba de hacer click
//            var elements = document.getElementsByClassName("palabra");
//            for(el in elements) {
//                $("#"+el).attr("class", "palabra");
//            }
            $("#"+id).attr("class", "palabraSel");
            $("#guardapalabras").attr("value", $("#"+id).attr("value"));
            $("#guardapalabras").attr("name", id);
        }
    }
}

//Copia la palabra seleccionada previamente en el input conrrespondiente
function copiarrespuesta(id) {
    //solo copio la respuesta si el campo hidden contiene algo
    if($("#guardapalabras").attr("value")!=="") {
        //marco el campo de la palabra para que sea visible que esta asignada
        $("#"+$("#guardapalabras").attr("name")).attr("class", "palabraMarc");
        //asigno al input los datos de la palabra almacenada en el
        $("#"+id).attr("value", $("#guardapalabras").attr("value"));
        $("#"+id).attr("name", $("#guardapalabras").attr("name"));
        //limpio los campos usados en el hidden guardapalabras
        $("#guardapalabras").attr("value", "");
        $("#guardapalabras").attr("name", "");
        //desactivo los atributos al campo input para que no se pueda modificar
        $("#"+id).attr("readonly", true);
        $("#"+id).prop("onclick", null);
    }
}


//Imagen de borrar para limpiar los campos usados y el input de la respuesta
function borrarpalabra(id) {
    if($("#respuesta"+id).attr("value")!=="") {
        $("#respuesta"+id).attr("value", "");
        $("#"+$("#respuesta"+id).attr("name")).attr("class", "palabra");
        //activo los atributos al campo input
        $("#respuesta"+id).attr("readonly", false);
        $("#respuesta"+id).attr("onclick", "copiarrespuesta(id)");
    } else {
        
    }
}