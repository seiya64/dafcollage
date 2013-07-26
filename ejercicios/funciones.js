var j1=1;
var j2=1;
var j3=1;
var j4=1;
var j5=1;
var j6=1;
var j7=1;
var j8=1;
var j9=1;

/**
 * Funcion que crea un elemento XML con la etiqueta y atributos pasados
 * @author Angel Biedma Mesa
 * @param {String} etiqueta Cadena con el tipo de etiqueta. P.ej: input, textarea, etc...
 * @param {Object} atributos Diccionario con los atributos de la etiqueta. P. ej: {name:"nombre",id:"id1",width:"300"}
 * @param {Node} padre Nodo que contendra el elemento recien creado
 * @returns {Elemento XML} Elemento XML creado con la etiqueta y atributos dados
 */
function createElement(etiqueta,atributos,padre) {
    var elm = document.createElement(etiqueta);
    for (key in atributos) {
        elm.setAttribute(key,atributos[key]);
    }
    if(createElement.arguments.length==3) {
        if(typeof padre.appendChild == "function") //Javascript DOM
            padre.appendChild(elm);
        else if (typeof padre.append == "function") //JQuery
            padre.append(elm);
    }
    return elm;
}

/**
 * Interfaz con dict.php. Pide una lista de cadenas de idiomas pasandole los codigos en un array.
 * Cuando se reciba la respuesta se ejecutara el manejador pasandole la informacion recibida del servidor.
 * @param {Array} lista Lista de codigos de cadenas de idioma. 
 * @param {function} manejador Funcion que se ejecutara una vez que se reciba del servidor la informacion solicitada. Como argumento recibe
 * la informacion recibida del servidor. Esta informacion se pasara como un diccionario de Javascript en la que en cada clave estara un codigo 
 * de idioma y como valor la cadena de idioma.
 * @author Angel Biedma Mesa
 */
function getCadLang(lista,manejador) {
    /**
     * Parametros a pasar a dict
     * num (Entero) Indica el numero de ids a pasar
     * id<N> (Cadena) Son los distintos codigos de cadena de idioma
     */
    
    /**
     * Lo que se recibe de dict es un objeto JSON con el siguiente formato
     * codigoIdioma => (Cadena) cadenaIdioma
     * donde codigoIdioma es el codigo de la cadena de idioma y 
     * la cadenaIdioma es la cadena de idioma
     */
    
    var num = 0;
    var data;
    if(typeof lista == "string") {
        data="num=1&id1="+lista;
    }
    else {
        data="num="+lista.length+"&";
        for (i=0;i<lista.length;i++) {
            data+="id"+(i+1)+"="+lista[i];
            if(i!=lista.length-1) data+="&";
        }
    }
    console.log("data: " + data);
    
    $.ajax({
        type:"POST",
        dataType:"json",
        url:"dict.php",
        data:data,
        success:function(data) {            
            var json = $.parseJSON(data);
            manejador(json);
        },
        error:function(error) {
            console.log("Error getCadLang con " + codcadena + " : " + error);
        }
    });
}


/**
 * Interfaz con dict.php. Pide una lista de cadenas de idiomas pasandole los codigos en un array.
 * La peticion se realiza de forma sincrona, asi que la funcion espera a que el servidor responda, por lo que la funcion
 * devuelve las cadenas de idiomas.
 * @param {Array} lista Lista de codigos de cadenas de idioma. 
 * @returns {JSON} Diccionario JSON cuyas claves son los codigos de las cadenas de idiomas y los valores son
 * las cadenas de idiomas devueltas por el servidor
 * @author Angel Biedma Mesa
 */
function getCadLangSync(lista,manejador) {
    /**
     * Parametros a pasar a dict
     * num (Entero) Indica el numero de ids a pasar
     * id<N> (Cadena) Son los distintos codigos de cadena de idioma
     */
    
    /**
     * Lo que se recibe de dict es un objeto JSON con el siguiente formato
     * codigoIdioma => (Cadena) cadenaIdioma
     * donde codigoIdioma es el codigo de la cadena de idioma y 
     * la cadenaIdioma es la cadena de idioma
     */
    
    var num = 0;
    var data;
    if(typeof lista == "string") {
        data="num=1&id1="+lista;
    }
    else {
        data="num="+lista.length+"&";
        for (i=0;i<lista.length;i++) {
            data+="id"+(i+1)+"="+lista[i];
            if(i!=lista.length-1) data+="&";
        }
    }
    console.log("data: " + data);
    
    var res;
    $.ajax({
        type:"POST",
        dataType:"json",
        async:false,
        url:"dict.php",
        data:data,
        success:function(data) {            
            res = $.parseJSON(data);
        },
        error:function(error) {
            console.log("Error getCadLang con " + codcadena + " : " + error);
        }
    });
    return res;
}


/**
 * Funciones para trabajar con cookies
 */
var Cookies = {
    /**
     * Lee una cookie por su nombre
     * @param {String} c_name Nombre de la cookie
     * @returns Devuelve el valor de la cookie o null si no se encuentra
     */
  read: function(c_name) {
        var c_value = document.cookie;
        var c_start = c_value.indexOf(" " + c_name + "=");
        if (c_start == -1)
        {
            c_start = c_value.indexOf(c_name + "=");
        }
        if (c_start == -1)
        {
            c_value = null;
        }
        else
        {
            c_start = c_value.indexOf("=", c_start) + 1;
            var c_end = c_value.indexOf(";", c_start);
            if (c_end == -1)
            {
                c_end = c_value.length;
            }
            c_value = unescape(c_value.substring(c_start, c_end));
        }
        return c_value;
  },
  /**
   * Crea una nueva cookie
   * @param {String} c_name Nombre de la cookie
   * @param {String} value Valor que le damos a la cookie
   * @param {Integer} exdays Dias en los que expirara o null para que expire al cerrar sesion
   */
  create: function(c_name, value, exdays) {
      var exdate=new Date();
      exdate.setDate(exdate.getDate() + exdays);
      var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
      document.cookie=c_name + "=" + c_value;
  },
  
  /**
   * Elimina la cookie dada
   * @param {String} c_name Nombre de la cookie
   */
  erase: function(c_name) {
      var exdate=new Date();
      var value="";
      exdate.setDate(exdate.getDate() - 1);
      var c_value=escape(value) +  "; expires="+exdate.toUTCString();
      document.cookie=c_name + "=" + c_value;
  }
};

/**
 * Devuelve una cadena con el contenido del objeto 
 * @param {Object} obj Objeto a analizar
 * @returns {String} Cadena con el contenido del objeto
 */
function var_dump(obj) {
  var tipo = typeof obj;
  if (tipo == "object") {
    var out = "{";
    for (var v in obj) {
        out += v + " : " + var_dump(obj[v]) + "\n";
    }
    out+="}";
  }
  else {
      out = obj;
  }
  return out;
}


function setTextareaHeight(textarea) {
    textarea.bind('blur focus', function() {
        var t = $(this),
        padding = parseInt(t.css('padding-top')) + parseInt(t.css('padding-bottom')); // to set total height - padding size

        t.css('overflow-y','auto');

        var newHeight = textarea.get(0).scrollHeight;
        if (newHeight > t.height() + 20) {  // only change height if content is bigger than current height
            if ($.browser.webkit) {
                newHeight = textarea.get(0).scrollHeight - padding; // because chrome set scrollHeight in a different way
            }
            t.css('overflow-y','hidden') // hide againg textarea scroll
            .height(newHeight + 'px'); // set textarea height to content height
        }
    });

}

function arrastrar_AS() {
    //alert("ARRASTRAR AS");
    
    var correcto=new Array();
    var puesto=new Array();
    
    $numimagen = $(".numero").attr('id');
    
    for(i=0;i<=parseInt($numimagen);i++){
        correcto[i]=false;
        puesto[i]=false;
    }
     

    $('.item').draggable({
        helper: 'clone'
    });
    $('.marquito').droppable( {
        drop: handleDropEvent
    } );
  


    function handleDropEvent( event, ui ) {
        var draggable = ui.draggable;
        //alert( 'The square with ID "' + draggable.attr('id') + '" was dropped onto "'+$(this).attr('id')+ '"!' );
        if( ($( this ).find( ".item" ).length)==0){
            $(this).append($(ui.draggable));
  
           
 

            var Idimagen = $(ui.draggable).attr('id');
            var Idmarquito = $(this).attr('id');
            //alert("idmgen"+Idimagen);
            //alert("idmarquito"+Idmarquito);
            if(Idimagen == Idmarquito){
                correcto[Idimagen]=true;
                puesto[Idimagen]=true;

            }else{
                correcto[Idimagen]=false;
                puesto[Idimagen]=true;
            }

        
        }

    }
    
    
    $("#botonResultado").click(function () {

                 
        $puestos=0;
        for(i=1;i<=parseInt($numimagen);i++){
            if (puesto[i]==true){
                $puestos++;
            }
        }
      
        if ($puestos==$numimagen) {
            //alert("puestos todos");
            for(i=1;i<=parseInt($numimagen);i++){
                //alert(correcto[i]);
                if (correcto[i]==true){
                    
                    variable="#aceptado"+i;
                    $(variable).html( '<img style="margin-top: 20px; margin-left: 20px;" src="./imagenes/correcto.png"/>');
                }else{
                    variable="#aceptado"+i;
                    $(variable).html( '<img style="margin-top: 20px; margin-left: 20px;" src="./imagenes/incorrecto.png"/>');
                }
            }


        }else{
            alert("Debe rellenar todos los campos");
                       
        }

    });
 
    $('#menuaux li #classa').click(function(event){
       
        var elem = $(this).next().next();
   
        if(elem.is('ul')){
           
            event.preventDefault(event);
         
            $('#menuaux ul:visible').not(elem).slideUp();
           
            elem.slideToggle();
        }
    });
}

function arrastrar_AM() {
    //alert("ARRASTAR AM");
    
    
    
    var Ejercicio = {
        num_pregs: parseInt(document.getElementById("num_preg").value),
        total_respuestas: parseInt($(".numero").attr('id')),
        num_resp: new Array(),
        respuestas: new Array()
    }
    
    //var numpreg = parseInt(document.getElementById("num_preg").value);
    //var numresp = new Array();
    var k = 1;
    for (var i=0; i<Ejercicio.num_pregs; i++) {
        Ejercicio.num_resp[i]=parseInt(document.getElementById("num_resp_preg"+(i+1)).value);
        
        for (var j=0; j<Ejercicio.num_resp[i]; j++) {
            Ejercicio.respuestas[k] = {preg:i+1, resp:j+1,correcto:false,puesto:false};
            //alert("Ejercicio.respuestas["+k+"]: " + var_dump(Ejercicio.respuestas[k]));
            k++;            
        }
    }
    
    
    //$numimagen = $(".numero").attr('id');
    
    /*for(i=0;i<=numpreg;i++){
        correcto[i]=0;
        puesto[i]=0;
    }*/
     

    $('.item').draggable({
        helper: 'clone'
    });
    $('.marquito').droppable( {
        drop: handleDropEvent
    } );
  


    function handleDropEvent( event, ui ) {
        var draggable = ui.draggable;
        //alert( 'The square with ID "' + draggable.attr('id') + '" was dropped onto "'+$(this).attr('id')+ '" !' );
        //alert("$( this ).find( '.item' ): " + $( this ).find( ".item" ));
        //if( ($( this ).find( ".item" ).length)==0){
            $(this).append($(ui.draggable));
  
           
 

            var Idimagen = $(ui.draggable).attr('id');
            Idimagen = Idimagen.split("_")[1];
            var Idmarquito = $(this).attr('id');
            //alert("idmgen"+Idimagen);
            //alert("idmarquito"+Idmarquito);
            
            
            
            if (Ejercicio.respuestas[Idimagen].preg==Idmarquito) {
                //alert("Correcto");
                Ejercicio.respuestas[Idimagen].correcto=true;
                Ejercicio.respuestas[Idimagen].puesto=true;
            }
            else {
                //alert("Incorrecto");
                Ejercicio.respuestas[Idimagen].correcto=false;
                Ejercicio.respuestas[Idimagen].puesto=true;
                
            }
            //alert("Ejercicio.respuestas[Idimagen("+Idimagen+")]: " + var_dump(Ejercicio.respuestas[Idimagen]));
            /*if(Idimagen == Idmarquito){
                correcto[Idimagen-1]+=1;
                puesto[Idimagen-1]+=1;

            }else{
                correcto[Idimagen-1]-=1;
                puesto[Idimagen-1]+=1;
            }*/
            
            
            //Imprimir lo correcto y lo puesto
            /*var cad = "";
            for (var i=0; i<correcto.length; i++){
                cad += i + ": correcto=" + correcto[i] + ",puesto=" + puesto[i] + "\n";
            }
            alert(cad);*/
        
        //}
        
        //Se ajusta el tamaño de las preguntas
        for (var k=1; k<=Ejercicio.num_pregs; k++) {
            //alert("k: " + k);
            var preg = document.getElementById(""+k);
            //Si las preguntas son videos o son imagenes, los cuadros de las preguntas debemos hacerlos mas grandes
            if (document.getElementById("movie"+k)==null && document.getElementById("imagen"+k)==null) {
                var altura = 100 + (preg.childNodes.length-1)*100;
            } else {
                var altura = 250 + (preg.childNodes.length-1)*100;
            }            
            //alert("altura: " + altura + " y puestos: " + (preg.childNodes.length-1));
            preg.setAttribute("style","height:"+altura+"px;");
        }

    }
    
    
    $("#botonResultado").click(function () {

                 
        var puestos=0;
        for(i=1;i<=Ejercicio.total_respuestas;i++){
            if (Ejercicio.respuestas[i].puesto==true){
                puestos++;
            }
        }
      
        if (puestos==Ejercicio.total_respuestas) {
            //alert("puestos todos");
            for(i=1;i<=Ejercicio.total_respuestas;i++){
                //alert(correcto[i]);
                if (Ejercicio.respuestas[i].correcto==true){                    
                    //variable="#aceptado"+i;
                    //$(variable).html( '<img style="margin-top: 20px; margin-left: 20px;" src="./imagenes/correcto.png"/>');
                    var div = document.getElementById("resp_"+i);
                    var img = createElement("img",{style:"margin-top: 20px; margin-left: 20px;",src:"./imagenes/correcto.png"});
                    //Borrar las anteriores respuestas
                    //alert("div.childNodes.length="+div.childNodes.length);
                    for (var j=1; j<div.childNodes.length; j++) { div.removeChild(div.childNodes[j]); }
                    div.appendChild(img);
                }else{
                    //variable="#aceptado"+i;
                    //$(variable).html( '<img style="margin-top: 20px; margin-left: 20px;" src="./imagenes/incorrecto.png"/>');
                    var div = document.getElementById("resp_"+i);
                    var img = createElement("img",{style:"margin-top: 20px; margin-left: 20px;",src:"./imagenes/incorrecto.png"});
                    //Borrar las anteriores respuestas
                    for (var j=1; j<div.childNodes.length; j++) { div.removeChild(div.childNodes[j]); }
                    div.appendChild(img);
                }
            }


        }else{
            alert("Debe rellenar todos los campos");
                       
        }

    });
 
    $('#menuaux li #classa').click(function(event){
       
        var elem = $(this).next().next();
   
        if(elem.is('ul')){
           
            event.preventDefault(event);
         
            $('#menuaux ul:visible').not(elem).slideUp();
           
            elem.slideToggle();
        }
    });
}

function arrastrar_OE() {
    //alert("ARRASTAR OE");
    
    
    //var numpreg = parseInt(document.getElementById("num_preg").value);
    //var numresp = new Array();
    
    
    
    //$numimagen = $(".numero").attr('id');
    
    /*for(i=0;i<=numpreg;i++){
        correcto[i]=0;
        puesto[i]=0;
    }*/
     

    $('.item').draggable({
        helper: 'clone'
    });
    $('.marquito').droppable( {
        drop: handleDropEvent
    } );
    
    //Arreglar que se vean los cuadros de texto de las respuestas
    try {
        var numpreg = parseInt($("#num_preg").attr("value"));
        for (var k=1; k<=numpreg; k++) {
            var numresp = parseInt($("#num_res_preg"+k).attr("value"));
            for (var l=1; l<=numresp; l++) {
                var t = $("#resp_"+l+"_"+k);
                var tamTexto = medirCadena(t.text());
                console.log("Tam Texto{ w:" + tamTexto.width + ",h: " + tamTexto.height);
                var tamDiv = {width: t.width(), height: t.height()};
                console.log("Tam Div{ w:" + tamDiv.width + ",h:" + tamDiv.height);
                var ancho = tamTexto.width*Math.round(tamTexto.height/16);
                console.log("Ancho: " + ancho);
                var filas = parseInt(Math.round(ancho/tamDiv.width)+1);
                console.log("Numero de filas: " + filas);
                t.css("height",(filas*20)+"px");
            }
        }
    }
    catch(e){}
  


    function handleDropEvent( event, ui ) {
        var draggable = ui.draggable;
        //alert( 'The square with ID "' + draggable.attr('id') + '" was dropped onto "'+$(this).attr('id')+ '" !' );
        //alert("$( this ).find( '.item' ): " + $( this ).find( ".item" ));
        if( ($( this ).find( ".item" ).length)==0){
            if($(this).attr('preg')==draggable.attr('preg')) {
                $(this).append($(ui.draggable));
                $(this).css('width',$(ui.draggable).css('width'));
                $(this).css('height',$(ui.draggable).css('height'));
            }
            else {
                alert("No se puede colocar una palabra de una pregunta en un hueco de otra pregunta distinta.");
            }
        }
        else {
            alert("No se pueden poner dos palabras en un mismo hueco.");
        }
        

    }
    
 
    $('#menuaux li #classa').click(function(event){
       
        var elem = $(this).next().next();
   
        if(elem.is('ul')){
           
            event.preventDefault(event);
         
            $('#menuaux ul:visible').not(elem).slideUp();
           
            elem.slideToggle();
        }
    });
}



$(document).ready(function(){
    
    //alert("Funciona lo de ready function");
    
    //$(document).tooltip({track: true,my: "left+15 center", at: "right center"});
    
    //Poner valores por defecto para las tablas
    if (typeof $.fn.dataTable != "undefined") {
        $.extend($.fn.dataTable.defaults,{
            "bPaginate":false,
            "bLengthChange":false,
            "bFilter":false,
            "bSort":false,
            "bInfo":false
        });
    }
    
    setTextareaHeight($('.adaptHeightInput'));
    try{
        var a = document.getElementsByClassName('adaptHeightInput');
        var b = a.item();
        b.focus();
        b.blur();
    }catch(e){};
    
    
    var tipo_ej = "";
    try {
        tipo_ej = document.getElementById("tipo_ej").value;
    }
    catch(e) {};
    //alert("tipo_ej: " + tipo_ej);
    if (tipo_ej=="AM") {
        arrastrar_AM();
    } else if (tipo_ej=="") {
        arrastrar_AS();
    }
    else if (tipo_ej=="OE") {
        arrastrar_OE();
    }
    else if (tipo_ej=="TH") {}
    else if (tipo_ej=="IERC") {
        
    }
    

    /*var correcto=new Array();
    var puesto=new Array();
    
    $numimagen = $(".numero").attr('id');
    
    for(i=0;i<=parseInt($numimagen);i++){
        correcto[i]=false;
        puesto[i]=false;
    }
     

    $('.item').draggable({
        helper: 'clone'
    });
    $('.marquito').droppable( {
        drop: handleDropEvent
    } );
  


    function handleDropEvent( event, ui ) {
        var draggable = ui.draggable;
        alert( 'The square with ID "' + draggable.attr('id') + '" was dropped onto "'+$(this).attr('id')+ '"!' );
        if( ($( this ).find( ".item" ).length)==0){
            $(this).append($(ui.draggable));
  
           
 

            var Idimagen = $(ui.draggable).attr('id');
            var Idmarquito = $(this).attr('id');
            alert("idmgen"+Idimagen);
            alert("idmarquito"+Idmarquito);
            if(Idimagen == Idmarquito){
                correcto[Idimagen]=true;
                puesto[Idimagen]=true;

            }else{
                correcto[Idimagen]=false;
                puesto[Idimagen]=true;
            }

        
        }

    }*/

//
//   
//
//    $("#botonNA").click(function () {
//        alert("añadiendooooooo asociacion");
//        num_preg=document.getElementById('num_preg');
//        alert("eL numero de preguntas es"+num_preg.value);
//        sig_preg=parseInt(num_preg.value)+1;
//
//        alert("aki llega");
//
//        //obtengo la tabla donde lo voy a insertar
//        tabla_insertar = document.getElementById('tablarespuestas');
//        alert(tabla_insertar);
//        tbody_insertar = tabla_insertar.lastChild;
//        alert(tbody_insertar);
//        //Para el texto
//        tabla_nuevotr = document.createElement('tr');
//        tabla_nuevotd = document.createElement('td');
//        tabla_nuevotd.id="texto"+sig_preg;
//        textarea = document.createElement('textarea');
//        textarea.id="pregunta"+sig_preg;
//        textarea.name="pregunta"+sig_preg;
//        textarea.setAttribute("style","height: 197px; width: 396px;");
//        textarea.appendChild(document.createTextNode("Nuevo Texto"));
//        alert("insertado el texto");
//
//        //Para el texto asociado
//
//
//        tabla_nuevotd1 = document.createElement('td');
//
//        textarea1 = document.createElement('textarea');
//        textarea1.id="respuesta"+sig_preg;
//        textarea1.name="respuesta"+sig_preg;
//        textarea1.setAttribute("class","descripcion");
//        textarea1.setAttribute("style","height: 192px; width: 401px;");
//        textarea1.appendChild(document.createTextNode("Nuevo Texto Asociado"));
//
//
//        tabla_nuevotd.appendChild(textarea);
//        tabla_nuevotd1.appendChild(textarea1);
//        tabla_nuevotr.appendChild(tabla_nuevotd);
//        tabla_nuevotr.appendChild(tabla_nuevotd1);
//        tbody_insertar.appendChild(tabla_nuevotr);
//
//
//        //Actualizo el número de preguntas a 1 mas
//
//        num_preg.value=sig_preg;
//    });



//    $("#botonNA").click(function () {
//        alert("añadiendooooooo asociacion");
//        num_preg=document.getElementById('num_preg');
//        alert("eL numero de preguntas es"+num_preg.value);
//        sig_preg=parseInt(num_preg.value)+1;
//
//        alert("aki llega");
//
//        //obtengo la tabla donde lo voy a insertar
//        tabla_insertar = document.getElementById('tablarespuestas');
//        alert(tabla_insertar);
//        tbody_insertar = tabla_insertar.lastChild;
//        alert(tbody_insertar);
//        //Para el texto
//        tabla_nuevotr = document.createElement('tr');
//        tabla_nuevotd = document.createElement('td');
//        tabla_nuevotd.id="texto"+sig_preg;
//        textarea = document.createElement('textarea');
//        textarea.id="pregunta"+sig_preg;
//        textarea.name="pregunta"+sig_preg;
//        textarea.setAttribute("style","height: 197px; width: 396px;");
//        textarea.appendChild(document.createTextNode("Nuevo Texto"));
//        alert("insertado el texto");
//            
//        //Para el texto asociado
//
//         
//        tabla_nuevotd1 = document.createElement('td');
//            
//        textarea1 = document.createElement('textarea');
//        textarea1.id="respuesta"+sig_preg;
//        textarea1.name="respuesta"+sig_preg;
//        textarea1.setAttribute("class","descripcion");
//        textarea1.setAttribute("style","height: 192px; width: 401px;");
//        textarea1.appendChild(document.createTextNode("Nuevo Texto Asociado"));
//
//            
//        tabla_nuevotd.appendChild(textarea);
//        tabla_nuevotd1.appendChild(textarea1);
//        tabla_nuevotr.appendChild(tabla_nuevotd);
//        tabla_nuevotr.appendChild(tabla_nuevotd1);
//        tbody_insertar.appendChild(tabla_nuevotr);
//
//
//        //Actualizo el número de preguntas a 1 mas
//
//        num_preg.value=sig_preg;
//    });

    
    /*$("#botonResultado").click(function () {

                 
        $puestos=0;
        for(i=1;i<=parseInt($numimagen);i++){
            if (puesto[i]==true){
                $puestos++;
            }
        }
      
        if ($puestos==$numimagen) {
            alert("puestos todos");
            for(i=1;i<=parseInt($numimagen);i++){
                alert(correcto[i]);
                if (correcto[i]==true){
                    
                    variable="#aceptado"+i;
                    $(variable).html( '<img style="margin-top: 20px; margin-left: 20px;" src="./imagenes/correcto.png"/>');
                }else{
                    variable="#aceptado"+i;
                    $(variable).html( '<img style="margin-top: 20px; margin-left: 20px;" src="./imagenes/incorrecto.png"/>');
                }
            }


        }else{
            alert("Debe rellenar todos los campos");
                       
        }

    });
 
    $('#menuaux li #classa').click(function(event){
       
        var elem = $(this).next().next();
   
        if(elem.is('ul')){
           
            event.preventDefault(event);
         
            $('#menuaux ul:visible').not(elem).slideUp();
           
            elem.slideToggle();
        }
    });*/


});
  



 

   
function sele($id) { 
    
 
    var txt =''; 
 
    if (window.getSelection) 
    { 
        txt = window.getSelection(); 
    } 
    else if (document.getSelection) // Complemento 
    { 
        txt = document.getSelection(); 
    } 
    else if (document.selection) // IE 6/7 
    { 
        txt = document.selection.createRange (); 
    } 
    else return; 

    window.open("../vocabulario/view.php?id=" + $id + "&opcion=1&palabra="+txt,'popup','width=600,height=600');
}
   
   
/**
 * Carga el contenido de un fichero php
 * @param miselect
 * @param otroselect
 * @param tipo
 */

function cargaContenido(miselect, otroselect, tipo) {

    var objeto = document.getElementById(miselect);
    var elselect = objeto.value;
    var nombre = objeto.name;
    var eltxt = objeto.options[objeto.selectedIndex].text;

    oculto = document.getElementById('id_desc_btn'); // Ocultar
    if (oculto) oculto.disabled = true;

    if(elselect == 0 || elselect == 1 || eltxt == "Seleccionar") {
        document.getElementById(otroselect).innerHTML = "";
    } else {
        document.getElementById(otroselect).innerHTML = '<p style="text-align: center;"><img src="../vocabulario/imagenes/loading.gif"/></p>';
        if(window.XMLHttpRequest) {//para que se vea en IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {//para que se vea en IE6, IE5 y otros
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById(otroselect).innerHTML = xmlhttp.responseText;
            }
        }
       
        if(tipo == 0) {//campos lexicos
            xmlhttp.open("GET", "../vocabulario/subcampos.php?id=" + elselect + "&nombre=" + nombre, true);
        } else if(tipo == 1 && eltxt != "Seleccionar") {//gramaticas
            xmlhttp.open("GET", "../vocabulario/subgramaticas.php?id=" + elselect + "&nombre=" + nombre, true);
        } else if(tipo == 2 && eltxt != "Seleccionar") {//intenciones comunicativas
            xmlhttp.open("GET", "../vocabulario/subintenciones.php?id=" + elselect + "&nombre=" + nombre, true);
        }
        xmlhttp.send();
    }
}


function compruebaCopyright(id_curso,tipocreacion){
   
    var objeto = document.getElementById("id_copyright");
  
    var eltxt =objeto.selectedIndex;
    if(tipocreacion!=5 && tipocreacion!=9) {
    var objeto2 = document.getElementById("id_copyrightresp");
  
    var eltxtresp =objeto2.selectedIndex;
    }
    else {
        eltxtresp=-1;
    }
   
    var campotematico = document.getElementById("id_campoid");
  
    var valorct =campotematico.selectedIndex;
   
    var temagramatical = document.getElementById("id_campogr");
  
    var valorgr =temagramatical.selectedIndex;
    
    if(eltxt==0 || eltxtresp==0 || (valorct==0 && valorgr==0 )){
        
        if(eltxt==0 || eltxtresp==0){
            alert("Error: Debe seleccionar un tipo de copyright");
        }else{
            alert("Error: Debe realizar una clasificación al menos por Campo Temático o Por Tema Gramatical");
        }
        var hidden= document.createElement("input");
        hidden.type="hidden";
        hidden.value="1";
        hidden.id="id_error";
        hidden.name="error";
        objeto = document.getElementById("id_submitbutton");
        objeto.appendChild(hidden);
           
            
    //location.href="view.php?id=" + id_curso + "&opcion=5&tipocreacion=" + tipocreacion ;
    }else{
         
        var hidden= document.createElement("input");
        hidden.type="hidden";
        hidden.value="0";
        hidden.id="id_error";
        hidden.name="error";
        objeto = document.getElementById("id_submitbutton");
        objeto.appendChild(hidden);
        
    }
}

/**
 * Carga la descripcion de un copyright
 */

function cargaDescripcion(i) {

    if(i==1){
        objeto = document.getElementById("id_copyright");
        descrip="descrip";
    }else{
        objeto = document.getElementById("id_copyrightresp");
        descrip="descripresp"
    }
    var eltxt =objeto.selectedIndex;
    
    
   
    switch(eltxt){
         
        case 0:
            descripcion = document.getElementById(descrip);
            descripcion.parentNode.removeChild(descripcion);
 
            //objeto.parentNode.removeChild();
            break;
            
        case 1: //Reconocimiento (CC-BY)
             
            descripcion = document.getElementById(descrip);
            
            if(descripcion!=null){
                descripcion.parentNode.removeChild(descripcion);
            }
            textarea = document.createElement('textarea');
            textarea.rows = 5;
            textarea.cols = 70;
            textarea.id=descrip;
            textarea.readOnly=true;
            textarea.setAttribute("style","resize:none; border:none");
            // textarea.setAttribute("style","border:none");
            
            textarea.appendChild(document.createTextNode("Esta licencia permite a otros distribuir, remezclar, retocar, y crear a partir de tu obra, incluso con fines comerciales, siempre y cuando te den crédito por la creación original. Esta es la más flexible de las licencias ofrecidas. Se recomienda para la máxima difusión y utilización de los materiales licenciados."));
         
            objeto.parentNode.appendChild(textarea);
      
             
            break;
        case 2: //Reconocimiento-CompartirIgual (CC-BY-SA)"
            descripcion = document.getElementById(descrip);
            if(descripcion!=null){
               
                descripcion.parentNode.removeChild(descripcion);
            }
           
           
            textarea = document.createElement('textarea');
            textarea.rows = 9;
            textarea.cols = 70;
            textarea.id=descrip;
            textarea.readOnly=true;
            textarea.setAttribute("style","resize:none; border:none");
          
            textarea.appendChild(document.createTextNode("Esta licencia permite a otros remezclar, retocar, y crear a partir de tu obra, incluso con fines comerciales, siempre y cuando te den crédito y licencien sus nuevas creaciones bajo condiciones idénticas. Esta licencia suele ser comparada con las licencias copyleft de software libre y de código abierto. Todas las nuevas obras basadas en la tuya portarán la misma licencia, así que cualesquiera obras derivadas permitirán también uso comercial. Esa es la licencia que usa Wikipedia, y se recomienda para materiales que se beneficiarían de incorporar contenido de Wikipedia y proyectos con licencias similares."));
         
            objeto.parentNode.appendChild(textarea);
            break;
        case 3: //Reconocimiento-NoDerivadas (CC-BY-ND)
            
            descripcion = document.getElementById(descrip);
            if(descripcion!=null){
                descripcion.parentNode.removeChild(descripcion);
            }
           
           
            textarea = document.createElement('textarea');
            textarea.rows = 4;
            textarea.cols = 70;
            textarea.id=descrip;
            textarea.readOnly=true;
            textarea.setAttribute("style","resize:none; border:none");
          
            textarea.appendChild(document.createTextNode("Esta licencia permite la redistribución, comercial o no comercial, siempre y cuando la obra circule íntegra y sin cambios, dándote crédito."));
         
            objeto.parentNode.appendChild(textarea);
            break;
            
        case 4: //Reconocimiento-NoComercial (CC-BY-NC)
            
            descripcion = document.getElementById(descrip);
            if(descripcion!=null){
                descripcion.parentNode.removeChild(descripcion);
            }
           
           
            textarea = document.createElement('textarea');
            textarea.rows = 5;
            textarea.cols = 70;
            textarea.id=descrip;
            textarea.readOnly=true;
            textarea.setAttribute("style","resize:none; border:none");
          
            textarea.appendChild(document.createTextNode("Esta licencia permite a otros distribuir, remezclar, retocar, y crear a partir de tu obra de modo no comercial, y a pesar de que sus nuevas obras deben siempre mencionarte y mantenerse sin fines comerciales, no están obligados a licenciar sus obras derivadas bajo las mismas condiciones."));
         
            objeto.parentNode.appendChild(textarea);
            break;
            
                  
        case 5: //Reconocimiento-NoComercial-CompartirIgual (CC-BY-NC-SA)
            
            descripcion = document.getElementById(descrip);
            if(descripcion!=null){
                descripcion.parentNode.removeChild(descripcion);
            }
           
           
            textarea = document.createElement('textarea');
            textarea.rows = 5;
            textarea.cols = 70;
            textarea.id=descrip;
            textarea.readOnly=true;
            textarea.setAttribute("style","resize:none; border:none");
          
            textarea.appendChild(document.createTextNode("Esta licencia permite a otros distribuir, remezclar, retocar, y crear a partir de tu obra de modo no comercial, siempre y cuando te den crédito y licencien sus nuevas creaciones bajo condiciones idénticas."));
         
            objeto.parentNode.appendChild(textarea);
            break;
            
        case 6: //Reconocimiento-NoComercial-NoDerivadas (CC-BY-NC-ND)
            
            descripcion = document.getElementById(descrip);
            if(descripcion!=null){
                descripcion.parentNode.removeChild(descripcion);
            }
           
           
            textarea = document.createElement('textarea');
            textarea.rows = 5;
            textarea.cols = 70;
            textarea.id=descrip;
            textarea.readOnly=true;
            textarea.setAttribute("style","resize:none; border:none");
          
            textarea.appendChild(document.createTextNode("Esta licencia es la más restrictiva de nuestras seis licencias principales, permitiendo a otros descargar tus obras y compartirlas con otros siempre y cuando te den crédito, pero no permiten cambiarlas de forma alguna ni usarlas comercialmente."));
         
            objeto.parentNode.appendChild(textarea);
            break;
          
    }
 
    
    

}

function botonCrear(id_curso){
   
      
      
    var objeto = document.getElementById('TipoActividadCrear');
 
    if(objeto.selectedIndex!=0 && objeto.selectedIndex!=1){
        var eltxt = objeto.options[objeto.selectedIndex].text;
     
     
        location.href="view.php?id=" + id_curso + "&opcion=5&tipocreacion=" + objeto.selectedIndex ;
        
    }else{ //No hay nada seleccionado en crear
        alert("Debe seleccionar un Tipo de Actividad");
    }
  
}

function botonBuscar(id_curso){
    //cojo el indice de campolexico
    var campolexico=document.getElementsByName("campoid");
    
    var clascampolexico=campolexico.item(campolexico.length-1).value;
    //cojo el indice de tipoActividad
    var tipoActividad=document.getElementById("TipoActividad");
    var clastipoActividad=tipoActividad.selectedIndex;
    //cojo el indice de destreza comunicativa
    var dc=document.getElementById("DestrezaComunicativa");
    var clasdc=dc.selectedIndex;
    //cojo el indice de tema gramatical
    var gr=document.getElementsByName("campogr");
    var clasgr=gr.item(gr.length-1).value;
    //cojo el indice de intencion comunicativa
    var ic=document.getElementsByName("campoic");
    var clasic=ic.item(ic.length-1).value;
    //cojo el indice de tipologiatextual
    var tt=document.getElementById("id_campott");
    var clastt=tt.selectedIndex;
  
    if(clastipoActividad>=2 || clascampolexico>1 ||clasdc>=2 || clasgr>1 || clasic >0 || clastt>0){
        location.href="view.php?id=" + id_curso + "&opcion=6"+ "&ccl="+clascampolexico+ "&cta="+clastipoActividad+"&cdc="+clasdc+"&cgr="+clasgr+"&cic="+clasic+"&ctt="+clastt;
    }else{
        alert("Debe seleccionar al menos un Tipo de Actividad")
    }
    
     
  
}


function botonMenuPrincipal(id_curso){

      
    location.href="view.php?id=" + id_curso + "&opcion=9";
 
  
}

function botonAtras(id_curso){

      
    location.href="view.php?id=" + id_curso + "&opcion=10";
 
  
}

function botonPrincipal(id_curso){

      
    location.href="view.php?id=" + id_curso;
 
  
}



function botonCorregirMultiChoice(id_curso,npreg){


    //alert("Corrigiendo");
    var rep1_1=document.getElementById("id_crespuesta1_1");
    
    //location.href="ejercicios_corregir_ejercicio.php";
    //  location.href="view.php?id=" + id_curso;
    var nrep_preg=document.getElementById("num_res_preg1");
    
    var resp1_1=document.getElementById("res1_1");
     
    var resp2_1=document.getElementById("res2_1");
        
        
    for (i=1; i<=npreg; i++) //para cada pregunta
    {
            
        var nombre="num_res_preg"+i;
           
        //obtengo el numero de respuestas de la pregunta
        var nrep_preg=document.getElementById(nombre);
            
        for (j=1; j<=nrep_preg.value; j++){ //Para cad respuesta
            //obtengo el valor correcto
                 
            var respcorrecta=document.getElementById("res"+j+"_"+i);
                 
            //obtengo el valor marcado
            var miresp=document.getElementById("id_crespuesta"+j+"_"+i);
                   
            //obtengo el div donde voy a insertar la imagen
                   
            var midiv=document.getElementById("respuesta"+j+"_"+i);
                   
            if(respcorrecta.value==miresp.value){
                    
                imagen = document.createElement("img");
                   
                imagen.src='./imagenes/correcto.png';
                imagen.style.height="15px";
                imagen.style.width="15px";
                midiv.appendChild(imagen);
            }else{
                     
                imagen = document.createElement("img");
                imagen.style.height="15px";
                imagen.style.width="15px";
                imagen.src='./imagenes/incorrecto.png';
               
                midiv.appendChild(imagen);
            }
                   
        }
    }



}


function insertAfter(e,i){
    if(e.nextSibling){
        e.parentNode.insertBefore(i,e.nextSibling);
    } else {
        e.parentNode.appendChild(i);
    }
}

function botonMasPreguntas(){
    //alert("añadiendo pregunta");

    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;
    //alert("numero actual es"+ numeropreguntas);
    anterior=document.getElementById('num_res_preg'+ numeropreguntas);
    //alert(anterior.id);
    numeropreguntas= parseInt(numeropreguntas) +1;
    divnumpreguntas.value=numeropreguntas;
    //alert("llega");
    nuevodiv = document.createElement('div');
    //alert("aki tb llega");
    nuevodiv.id= "tabpregunta"+numeropreguntas;
    //Creo un nuevo hijo a la tabla general para la pregunta
    //alert("si");
    var br = document.createElement('br');
    var br1 = document.createElement('br');
    var br2 = document.createElement('br');
    tablapreg = document.createElement('table');
    tablapreg.style.width="100%";

    body= document.createElement('tbody');
    nuevotr=document.createElement('tr');

    body.appendChild(nuevotr);
    nuevotd=document.createElement('td');
    nuevotd.style.width="80%";
    textareapreg=document.createElement('textarea');
    textareapreg.style.width="900px";
    textareapreg.setAttribute('class', 'pregunta');
    textareapreg.name="pregunta"+numeropreguntas;
    textareapreg.id="pregunta"+numeropreguntas;
    //Añado el textarea de la prgunta
    nuevotd.appendChild(textareapreg);

    nuevotd1=document.createElement('td');
    nuevotd1.style.width="5%";
    imgborrar=document.createElement('img');
    imgborrar.id="imgpregborrar"+numeropreguntas ;
    imgborrar.src="./imagenes/delete.gif";
    imgborrar.alt="eliminar respuesta";
    imgborrar.style.height="10px";
    imgborrar.style.width="10px";
    imgborrar.setAttribute('onclick',"EliminarPregunta(tabpregunta"+numeropreguntas+","+numeropreguntas+")");
    imgborrar.title="Eliminar Pregunta";

    //

    //icono de borrar pregunta
    nuevotd1.appendChild(imgborrar);
    nuevotd1.appendChild(br);

    //Creación imagen añadir

    imgañadir=document.createElement('img');
    imgañadir.id="imgpreganadir"+numeropreguntas ;
    imgañadir.src="./imagenes/añadir.gif";
    imgañadir.alt="añadir respuesta";
    imgañadir.style.height="15px";
    imgañadir.style.width="15px";
    imgañadir.setAttribute('onclick',"anadirRespuesta(respuestas"+numeropreguntas+","+numeropreguntas+")");
    imgañadir.title="Añadir Pregunta";

    nuevotd1.appendChild(imgañadir);
    nuevotr.appendChild(nuevotd);
    nuevotr.appendChild(nuevotd1);
    tablapreg.appendChild(body);
    //le añado sus br
    nuevodiv.appendChild(br);
    nuevodiv.appendChild(br1);
    nuevodiv.appendChild(br2);
    nuevodiv.appendChild(tablapreg);
    nuevodiv.appendChild(br);

    //div de respuestas


    divrespuesta=document.createElement('div');
    divrespuesta.id="respuestas"+numeropreguntas;
    divrespuesta.setAttribute('class',"respuesta");

      

    nuevodiv.appendChild(divrespuesta);

         

    //lo inserto despues de anterior
    insertAfter(anterior,nuevodiv);


    //<input type="hidden" value="1" id="num_res_preg3" name="num_res_preg3

    nuevoinput=document.createElement('input');
    nuevoinput.type="hidden";
    nuevoinput.value="0";
    nuevoinput.id="num_res_preg"+numeropreguntas;
    nuevoinput.name="num_res_preg"+numeropreguntas;

    //añado el numero de respuestas de la nueva pregunta
    insertAfter(nuevodiv,nuevoinput)

    //alert("fin");

      
}

function botonMasRespuestas(i){
  
  
    textarea = document.createElement('textarea');
    textarea.rows = 5;
    textarea.cols = 50;
    var radioInput = document.createElement('input');
    radioInput.type="radio";
    radioInput.value="Si";
    radioInput.text="Si";
    radioInput.checked=true;
   
    var radioInput2 = document.createElement('input');
    radioInput2.type="radio";
    radioInput2.value="No";
    radioInput2.text="No";
    
    var br = document.createElement('br');
    var br1 = document.createElement('br');
    switch(i){
        case 1:
          
            ultimarespuesta = document.getElementById('respuesta'+j1+'_'+i);
            j1=j1+1;
            textarea.id='respuesta'+j1+'_'+i;
            textarea.name='respuesta'+j1+'_'+i;
            radioInput.id='correcta'+j1+'_'+i;
            radioInput.name='correcta'+j1+'_'+i;
            radioInput2.id='correcta'+j1+'_'+i;
            radioInput2.name='correcta'+j1+'_'+i;

            ultimarespuesta.parentNode.appendChild(textarea);
            ultimarespuesta.parentNode.appendChild(br1);
            ultimarespuesta.parentNode.appendChild(document.createTextNode('Correcta: '));
            ultimarespuesta.parentNode.appendChild(radioInput);
           
            ultimarespuesta.parentNode.appendChild(document.createTextNode('Si'));
            ultimarespuesta.parentNode.appendChild(radioInput2);

            ultimarespuesta.parentNode.appendChild(document.createTextNode('No'));
            ultimarespuesta.parentNode.appendChild(br);
           
            // replaceChild(numrespuetas1, hijoAntiguo); reemplazamos el hijo hijoAntiguo del nodo por el nodo nuevoHijo
            numrespuesta = document.getElementById('numerorespuestas_'+i);
            numrespuesta.value=j1;
             
            break;
        case 2:
        
           
            ultimarespuesta = document.getElementById('respuesta'+j2+'_'+i);
            j2=j2+1;
            textarea.id='respuesta'+j2+'_'+i;
            textarea.name='respuesta'+j2+'_'+i;
            radioInput.id='correcta'+j2+'_'+i;
            radioInput.name='correcta'+j2+'_'+i;
            radioInput2.id='correcta'+j2+'_'+i;
            radioInput2.name='correcta'+j2+'_'+i;

            ultimarespuesta.parentNode.appendChild(textarea);
            ultimarespuesta.parentNode.appendChild(br1);
            ultimarespuesta.parentNode.appendChild(document.createTextNode('Correcta: '));
            ultimarespuesta.parentNode.appendChild(radioInput);
           
            ultimarespuesta.parentNode.appendChild(document.createTextNode('Si'));
            ultimarespuesta.parentNode.appendChild(radioInput2);

            ultimarespuesta.parentNode.appendChild(document.createTextNode('No'));
            ultimarespuesta.parentNode.appendChild(br);
            
            numrespuesta = document.getElementById('numerorespuestas_'+i);
            numrespuesta.value=j2;
            break;
        case 3:
         
            ultimarespuesta = document.getElementById('respuesta'+j3+'_'+i);
            j3=j3+1;
            textarea.id='respuesta'+j3+'_'+i;
            textarea.name='respuesta'+j3+'_'+i;
            radioInput.id='correcta'+j3+'_'+i;
            radioInput.name='correcta'+j3+'_'+i;
            radioInput2.id='correcta'+j3+'_'+i;
            radioInput2.name='correcta'+j3+'_'+i;

            ultimarespuesta.parentNode.appendChild(textarea);
            ultimarespuesta.parentNode.appendChild(br1);
            ultimarespuesta.parentNode.appendChild(document.createTextNode('Correcta: '));
            ultimarespuesta.parentNode.appendChild(radioInput);
           
            ultimarespuesta.parentNode.appendChild(document.createTextNode('Si'));
            ultimarespuesta.parentNode.appendChild(radioInput2);

            ultimarespuesta.parentNode.appendChild(document.createTextNode('No'));
            ultimarespuesta.parentNode.appendChild(br);
            numrespuesta = document.getElementById('numerorespuestas_'+i);
            numrespuesta.value=j3;
            
            break;
        case 4:
          
            ultimarespuesta = document.getElementById('respuesta'+j4+'_'+i);
            j4=j4+1;
            textarea.id='respuesta'+j4+'_'+i;
            textarea.name='respuesta'+j4+'_'+i;
            radioInput.id='correcta'+j4+'_'+i;
            radioInput.name='correcta'+j4+'_'+i;
            radioInput2.id='correcta'+j4+'_'+i;
            radioInput2.name='correcta'+j4+'_'+i;

            ultimarespuesta.parentNode.appendChild(textarea);
            ultimarespuesta.parentNode.appendChild(br1);
            ultimarespuesta.parentNode.appendChild(document.createTextNode('Correcta: '));
            ultimarespuesta.parentNode.appendChild(radioInput);
           
            ultimarespuesta.parentNode.appendChild(document.createTextNode('Si'));
            ultimarespuesta.parentNode.appendChild(radioInput2);

            ultimarespuesta.parentNode.appendChild(document.createTextNode('No'));
            ultimarespuesta.parentNode.appendChild(br);
            
            numrespuesta = document.getElementById('numerorespuestas_'+i);
            numrespuesta.value=j4;
            
            break;
        case 5:
         
            ultimarespuesta = document.getElementById('respuesta'+j5+'_'+i);
            j5=j5+1;
            textarea.id='respuesta'+j5+'_'+i;
            textarea.name='respuesta'+j5+'_'+i;
            radioInput.id='correcta'+j5+'_'+i;
            radioInput.name='correcta'+j5+'_'+i;
            radioInput2.id='correcta'+j5+'_'+i;
            radioInput2.name='correcta'+j5+'_'+i;

            ultimarespuesta.parentNode.appendChild(textarea);
            ultimarespuesta.parentNode.appendChild(br1);
            ultimarespuesta.parentNode.appendChild(document.createTextNode('Correcta: '));
            ultimarespuesta.parentNode.appendChild(radioInput);
           
            ultimarespuesta.parentNode.appendChild(document.createTextNode('Si'));
            ultimarespuesta.parentNode.appendChild(radioInput2);

            ultimarespuesta.parentNode.appendChild(document.createTextNode('No'));
            ultimarespuesta.parentNode.appendChild(br);
            numrespuesta = document.getElementById('numerorespuestas_'+i);
            numrespuesta.value=j5;
            break;
        case 6:
         
            ultimarespuesta = document.getElementById('respuesta'+j6+'_'+i);
            j6=j6+1;
            textarea.id='respuesta'+j6+'_'+i;
            textarea.name='respuesta'+j6+'_'+i;
            radioInput.id='correcta'+j6+'_'+i;
            radioInput.name='correcta'+j6+'_'+i;
            radioInput2.id='correcta'+j6+'_'+i;
            radioInput2.name='correcta'+j6+'_'+i;

            ultimarespuesta.parentNode.appendChild(textarea);
            ultimarespuesta.parentNode.appendChild(br1);
            ultimarespuesta.parentNode.appendChild(document.createTextNode('Correcta: '));
            ultimarespuesta.parentNode.appendChild(radioInput);
           
            ultimarespuesta.parentNode.appendChild(document.createTextNode('Si'));
            ultimarespuesta.parentNode.appendChild(radioInput2);

            ultimarespuesta.parentNode.appendChild(document.createTextNode('No'));
            ultimarespuesta.parentNode.appendChild(br);
            
            numrespuesta = document.getElementById('numerorespuestas_'+i);
            numrespuesta.value=j6;
            break;
        case 7:
          
            ultimarespuesta = document.getElementById('respuesta'+j7+'_'+i);
            j7=j7+1;
            textarea.id='respuesta'+j7+'_'+i;
            textarea.name='respuesta'+j7+'_'+i;
            radioInput.id='correcta'+j7+'_'+i;
            radioInput.name='correcta'+j7+'_'+i;
            radioInput2.id='correcta'+j7+'_'+i;
            radioInput2.name='correcta'+j7+'_'+i;

            ultimarespuesta.parentNode.appendChild(textarea);
            ultimarespuesta.parentNode.appendChild(br1);
            ultimarespuesta.parentNode.appendChild(document.createTextNode('Correcta: '));
            ultimarespuesta.parentNode.appendChild(radioInput);
           
            ultimarespuesta.parentNode.appendChild(document.createTextNode('Si'));
            ultimarespuesta.parentNode.appendChild(radioInput2);

            ultimarespuesta.parentNode.appendChild(document.createTextNode('No'));
            ultimarespuesta.parentNode.appendChild(br);
            
            numrespuesta = document.getElementById('numerorespuestas_'+i);
            numrespuesta.value=j7;
            break;
        case 8:
         
            ultimarespuesta = document.getElementById('respuesta'+j8+'_'+i);
            j8=j8+1;
            textarea.id='respuesta'+j8+'_'+i;
            textarea.name='respuesta'+j8+'_'+i;
            radioInput.id='correcta'+j8+'_'+i;
            radioInput.name='correcta'+j8+'_'+i;
            radioInput2.id='correcta'+j8+'_'+i;
            radioInput2.name='correcta'+j8+'_'+i;

            ultimarespuesta.parentNode.appendChild(textarea);
            ultimarespuesta.parentNode.appendChild(br1);
            ultimarespuesta.parentNode.appendChild(document.createTextNode('Correcta: '));
            ultimarespuesta.parentNode.appendChild(radioInput);
           
            ultimarespuesta.parentNode.appendChild(document.createTextNode('Si'));
            ultimarespuesta.parentNode.appendChild(radioInput2);

            ultimarespuesta.parentNode.appendChild(document.createTextNode('No'));
            ultimarespuesta.parentNode.appendChild(br);
            
            numrespuesta = document.getElementById('numerorespuestas_'+i);
            numrespuesta.value=j8;
            
            break;
        case 9:
            
            
            ultimarespuesta = document.getElementById('respuesta'+j9+'_'+i);
            j9=j9+1;
            textarea.id='respuesta'+j9+'_'+i;
            textarea.name='respuesta'+j9+'_'+i;
            radioInput.id='correcta'+j9+'_'+i;
            radioInput.name='correcta'+j9+'_'+i;
            radioInput2.id='correcta'+j9+'_'+i;
            radioInput2.name='correcta'+j9+'_'+i;
            
            ultimarespuesta.parentNode.appendChild(textarea);
            ultimarespuesta.parentNode.appendChild(br1);
            ultimarespuesta.parentNode.appendChild(document.createTextNode('Correcta: '));
            ultimarespuesta.parentNode.appendChild(radioInput);
           
            ultimarespuesta.parentNode.appendChild(document.createTextNode('Si'));
            ultimarespuesta.parentNode.appendChild(radioInput2);

            ultimarespuesta.parentNode.appendChild(document.createTextNode('No'));
            ultimarespuesta.parentNode.appendChild(br);
            
            numrespuesta = document.getElementById('numerorespuestas_'+i);
            numrespuesta.value=j9;
            break;
    }
 
    
      
    
    
}


function botonMasRespuestas_IE(i){
  
  
    textarea = document.createElement('textarea');
    textarea.rows = 1;
    textarea.cols = 50;
    var radioInput = document.createElement('input');
    radioInput.type="radio";
    radioInput.value="Si";
    radioInput.text="Si";
    radioInput.checked=true;
   
    var radioInput2 = document.createElement('input');
    radioInput2.type="radio";
    radioInput2.value="No";
    radioInput2.text="No";
    
    var br = document.createElement('br');
    var br1 = document.createElement('br');
    switch(i){
        case 1:
          
            ultimarespuesta = document.getElementById('respuesta'+j1+'_'+i);
            j1=j1+1;
            textarea.id='respuesta'+j1+'_'+i;
            textarea.name='respuesta'+j1+'_'+i;
            /*radioInput.id='correcta'+j1+'_'+i;
            radioInput.name='correcta'+j1+'_'+i;
            radioInput2.id='correcta'+j1+'_'+i;
            radioInput2.name='correcta'+j1+'_'+i;*/

            ultimarespuesta.parentNode.appendChild(textarea);
            ultimarespuesta.parentNode.appendChild(br1);
            //ultimarespuesta.parentNode.appendChild(document.createTextNode('Correcta: '));
            //ultimarespuesta.parentNode.appendChild(radioInput);
           
            //ultimarespuesta.parentNode.appendChild(document.createTextNode('Si'));
            //ultimarespuesta.parentNode.appendChild(radioInput2);

            //ultimarespuesta.parentNode.appendChild(document.createTextNode('No'));
//            ultimarespuesta.parentNode.appendChild(br);
           
            // replaceChild(numrespuetas1, hijoAntiguo); reemplazamos el hijo hijoAntiguo del nodo por el nodo nuevoHijo
            numrespuesta = document.getElementById('numerorespuestas_'+i);
            numrespuesta.value=j1;
             
            break;
        case 2:
        
           
            ultimarespuesta = document.getElementById('respuesta'+j2+'_'+i);
            j2=j2+1;
            textarea.id='respuesta'+j2+'_'+i;
            textarea.name='respuesta'+j2+'_'+i;
            /*radioInput.id='correcta'+j2+'_'+i;
            radioInput.name='correcta'+j2+'_'+i;
            radioInput2.id='correcta'+j2+'_'+i;
            radioInput2.name='correcta'+j2+'_'+i;*/

            ultimarespuesta.parentNode.appendChild(textarea);
            ultimarespuesta.parentNode.appendChild(br1);
//            ultimarespuesta.parentNode.appendChild(document.createTextNode('Correcta: '));
//            ultimarespuesta.parentNode.appendChild(radioInput);
//           
//            ultimarespuesta.parentNode.appendChild(document.createTextNode('Si'));
//            ultimarespuesta.parentNode.appendChild(radioInput2);
//
//            ultimarespuesta.parentNode.appendChild(document.createTextNode('No'));
//            ultimarespuesta.parentNode.appendChild(br);
            
            numrespuesta = document.getElementById('numerorespuestas_'+i);
            numrespuesta.value=j2;
            break;
        case 3:
         
            ultimarespuesta = document.getElementById('respuesta'+j3+'_'+i);
            j3=j3+1;
            textarea.id='respuesta'+j3+'_'+i;
            textarea.name='respuesta'+j3+'_'+i;
            /*radioInput.id='correcta'+j3+'_'+i;
            radioInput.name='correcta'+j3+'_'+i;
            radioInput2.id='correcta'+j3+'_'+i;
            radioInput2.name='correcta'+j3+'_'+i;*/

            ultimarespuesta.parentNode.appendChild(textarea);
            ultimarespuesta.parentNode.appendChild(br1);
//            ultimarespuesta.parentNode.appendChild(document.createTextNode('Correcta: '));
//            ultimarespuesta.parentNode.appendChild(radioInput);
//           
//            ultimarespuesta.parentNode.appendChild(document.createTextNode('Si'));
//            ultimarespuesta.parentNode.appendChild(radioInput2);
//
//            ultimarespuesta.parentNode.appendChild(document.createTextNode('No'));
//            ultimarespuesta.parentNode.appendChild(br);
            numrespuesta = document.getElementById('numerorespuestas_'+i);
            numrespuesta.value=j3;
            
            break;
        case 4:
          
            ultimarespuesta = document.getElementById('respuesta'+j4+'_'+i);
            j4=j4+1;
            textarea.id='respuesta'+j4+'_'+i;
            textarea.name='respuesta'+j4+'_'+i;
            /*radioInput.id='correcta'+j4+'_'+i;
            radioInput.name='correcta'+j4+'_'+i;
            radioInput2.id='correcta'+j4+'_'+i;
            radioInput2.name='correcta'+j4+'_'+i;*/

            ultimarespuesta.parentNode.appendChild(textarea);
            ultimarespuesta.parentNode.appendChild(br1);
//            ultimarespuesta.parentNode.appendChild(document.createTextNode('Correcta: '));
//            ultimarespuesta.parentNode.appendChild(radioInput);
//           
//            ultimarespuesta.parentNode.appendChild(document.createTextNode('Si'));
//            ultimarespuesta.parentNode.appendChild(radioInput2);
//
//            ultimarespuesta.parentNode.appendChild(document.createTextNode('No'));
//            ultimarespuesta.parentNode.appendChild(br);
            
            numrespuesta = document.getElementById('numerorespuestas_'+i);
            numrespuesta.value=j4;
            
            break;
        case 5:
         
            ultimarespuesta = document.getElementById('respuesta'+j5+'_'+i);
            j5=j5+1;
            textarea.id='respuesta'+j5+'_'+i;
            textarea.name='respuesta'+j5+'_'+i;
            /*radioInput.id='correcta'+j5+'_'+i;
            radioInput.name='correcta'+j5+'_'+i;
            radioInput2.id='correcta'+j5+'_'+i;
            radioInput2.name='correcta'+j5+'_'+i;*/

            ultimarespuesta.parentNode.appendChild(textarea);
            ultimarespuesta.parentNode.appendChild(br1);
//            ultimarespuesta.parentNode.appendChild(document.createTextNode('Correcta: '));
//            ultimarespuesta.parentNode.appendChild(radioInput);
//           
//            ultimarespuesta.parentNode.appendChild(document.createTextNode('Si'));
//            ultimarespuesta.parentNode.appendChild(radioInput2);
//
//            ultimarespuesta.parentNode.appendChild(document.createTextNode('No'));
//            ultimarespuesta.parentNode.appendChild(br);
            numrespuesta = document.getElementById('numerorespuestas_'+i);
            numrespuesta.value=j5;
            break;
        case 6:
         
            ultimarespuesta = document.getElementById('respuesta'+j6+'_'+i);
            j6=j6+1;
            textarea.id='respuesta'+j6+'_'+i;
            textarea.name='respuesta'+j6+'_'+i;
            /*radioInput.id='correcta'+j6+'_'+i;
            radioInput.name='correcta'+j6+'_'+i;
            radioInput2.id='correcta'+j6+'_'+i;
            radioInput2.name='correcta'+j6+'_'+i;*/

            ultimarespuesta.parentNode.appendChild(textarea);
            ultimarespuesta.parentNode.appendChild(br1);
//            ultimarespuesta.parentNode.appendChild(document.createTextNode('Correcta: '));
//            ultimarespuesta.parentNode.appendChild(radioInput);
//           
//            ultimarespuesta.parentNode.appendChild(document.createTextNode('Si'));
//            ultimarespuesta.parentNode.appendChild(radioInput2);
//
//            ultimarespuesta.parentNode.appendChild(document.createTextNode('No'));
//            ultimarespuesta.parentNode.appendChild(br);
            
            numrespuesta = document.getElementById('numerorespuestas_'+i);
            numrespuesta.value=j6;
            break;
        case 7:
          
            ultimarespuesta = document.getElementById('respuesta'+j7+'_'+i);
            j7=j7+1;
            textarea.id='respuesta'+j7+'_'+i;
            textarea.name='respuesta'+j7+'_'+i;
            /*radioInput.id='correcta'+j7+'_'+i;
            radioInput.name='correcta'+j7+'_'+i;
            radioInput2.id='correcta'+j7+'_'+i;
            radioInput2.name='correcta'+j7+'_'+i;*/

            ultimarespuesta.parentNode.appendChild(textarea);
            ultimarespuesta.parentNode.appendChild(br1);
//            ultimarespuesta.parentNode.appendChild(document.createTextNode('Correcta: '));
//            ultimarespuesta.parentNode.appendChild(radioInput);
//           
//            ultimarespuesta.parentNode.appendChild(document.createTextNode('Si'));
//            ultimarespuesta.parentNode.appendChild(radioInput2);
//
//            ultimarespuesta.parentNode.appendChild(document.createTextNode('No'));
//            ultimarespuesta.parentNode.appendChild(br);
            
            numrespuesta = document.getElementById('numerorespuestas_'+i);
            numrespuesta.value=j7;
            break;
        case 8:
         
            ultimarespuesta = document.getElementById('respuesta'+j8+'_'+i);
            j8=j8+1;
            textarea.id='respuesta'+j8+'_'+i;
            textarea.name='respuesta'+j8+'_'+i;
            /*radioInput.id='correcta'+j8+'_'+i;
            radioInput.name='correcta'+j8+'_'+i;
            radioInput2.id='correcta'+j8+'_'+i;
            radioInput2.name='correcta'+j8+'_'+i;*/

            ultimarespuesta.parentNode.appendChild(textarea);
            ultimarespuesta.parentNode.appendChild(br1);
//            ultimarespuesta.parentNode.appendChild(document.createTextNode('Correcta: '));
//            ultimarespuesta.parentNode.appendChild(radioInput);
//           
//            ultimarespuesta.parentNode.appendChild(document.createTextNode('Si'));
//            ultimarespuesta.parentNode.appendChild(radioInput2);
//
//            ultimarespuesta.parentNode.appendChild(document.createTextNode('No'));
//            ultimarespuesta.parentNode.appendChild(br);
            
            numrespuesta = document.getElementById('numerorespuestas_'+i);
            numrespuesta.value=j8;
            
            break;
        case 9:
            
            
            ultimarespuesta = document.getElementById('respuesta'+j9+'_'+i);
            j9=j9+1;
            textarea.id='respuesta'+j9+'_'+i;
            textarea.name='respuesta'+j9+'_'+i;
            /*radioInput.id='correcta'+j9+'_'+i;
            radioInput.name='correcta'+j9+'_'+i;
            radioInput2.id='correcta'+j9+'_'+i;
            radioInput2.name='correcta'+j9+'_'+i;*/
            
            ultimarespuesta.parentNode.appendChild(textarea);
            ultimarespuesta.parentNode.appendChild(br1);
//            ultimarespuesta.parentNode.appendChild(document.createTextNode('Correcta: '));
//            ultimarespuesta.parentNode.appendChild(radioInput);
//           
//            ultimarespuesta.parentNode.appendChild(document.createTextNode('Si'));
//            ultimarespuesta.parentNode.appendChild(radioInput2);
//
//            ultimarespuesta.parentNode.appendChild(document.createTextNode('No'));
//            ultimarespuesta.parentNode.appendChild(br);
            
            numrespuesta = document.getElementById('numerorespuestas_'+i);
            numrespuesta.value=j9;
            break;
    }
 
    
      
    
    
}




function BotonRadio(botonradio){
  

  
    if(botonradio.value=="0"){
        botonradio.value="1";
    }else{
        if(botonradio.checked){
            botonradio.checked=false;
            botonradio.value="0";
        }else{
            botonradio.checked=true;
        }
    }
}


function EliminarPregunta(Pregunta,numpregunta){

    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;

    //Compruebo que al menos hay una pregunta

    if(parseInt(numeropreguntas)>1){
        padre=Pregunta.parentNode;
        padre.removeChild(Pregunta.nextSibling);
        padre.removeChild(Pregunta);

        //le quieto uno al número de preguntas


        numeropreguntas= parseInt(numeropreguntas) - 1;
        divnumpreguntas.value=numeropreguntas;

        siguientepreg= parseInt(numpregunta)+1;
        //Actualizo el resto de pregunta
        //alert(siguientepreg);
        preg=parseInt(numpregunta);
        //alert("preg"+preg);
        for(j=siguientepreg;j<=numeropreguntas+1;j++){
            //alert('tabpregunta'+j);
            mitabla=document.getElementById('tabpregunta'+j);
            mitabla.id='tabpregunta'+preg;

            mitextarea=document.getElementById('pregunta'+j);
            mitextarea.id='pregunta'+preg;
            mitextarea.name='pregunta'+preg;

            miimgborrar=document.getElementById('imgpregborrar'+j);
            miimgborrar.setAttribute("onclick","EliminarPregunta(tabpregunta"+preg+","+preg+")");
            miimgborrar.id='imgpregborrar'+preg;

            miimgañadir=document.getElementById('imgpreganadir'+j);
            miimgañadir.setAttribute("onclick","anadirRespuesta(respuestas"+preg+","+preg+")");
            miimgañadir.id='imgpreganadir'+preg;

            //Obtengo el numero de respuestas de la pregunta

            minumeroresp=document.getElementById('num_res_preg'+j);
            numresp=minumeroresp.value;
            //Actualizo las respuestas
            divrespuestas=document.getElementById('respuestas'+j);
            divrespuestas.id='respuestas'+preg;
            for(k=1;k<=parseInt(numresp);k++){

                //Las tables
                //alert("llega");
                tablarespuestas=document.getElementById("tablarespuesta"+k+"_"+j);
                tablarespuestas.id="tablarespuesta"+k+"_"+preg;
                //alert("ki tba");
                //los tr de las tables
                lostr=document.getElementById('trrespuesta'+k+"_"+j);
                lostr.id='trrespuesta'+k+"_"+preg;
                //alert("siiiiii");

                losinput=document.getElementById('id_crespuesta'+k+"_"+j);
                losinput.id='id_crespuesta'+k+"_"+preg;
                losinput.name='crespuesta'+k+"_"+preg;
                losinput.setAttribute("onclick","BotonRadio(crespuesta"+k+"_"+preg+")");


                larespuesta=document.getElementById('respuesta'+k+"_"+j);
                larespuesta.id='respuesta'+k+"_"+preg;
                larespuesta.name='respuesta'+k+"_"+preg;

                //la imagen de eliminar

                laimageneliminar=document.getElementById('eliminarrespuesta'+k+"_"+j);
                laimageneliminar.id='eliminarrespuesta'+k+"_"+preg;
                laimageneliminar.setAttribute("onclick","EliminarRespuesta(tablarespuesta"+k+"_"+preg+","+preg+")");

                //el hidden de correcta
                hiddencorrecta=document.getElementById('valorcorrecta'+k+"_"+j);
                hiddencorrecta.id='valorcorrecta'+k+"_"+preg;
                hiddencorrecta.name='valorcorrecta'+k+"_"+preg;
                //La imagen de correcta
                laimagencorrecta=document.getElementById('correcta'+k+"_"+j);
                laimagencorrecta.id='correcta'+k+"_"+preg;
                laimagencorrecta.setAttribute("onclick","InvertirRespuesta(correcta"+k+"_"+preg+","+hiddencorrecta.value+")");

            }

            //alert("fin hijos");
            //Cambio el número de respuestas
            minumeroresp=document.getElementById('num_res_preg'+j);
            minumeroresp.id='num_res_preg'+preg;
            minumeroresp.name='num_res_preg'+preg;

            preg=preg+1;
        }
        
    }else{
        alert("El ejercicio debe tener al menos una pregunta");
    }
}

function EliminarRespuesta(respuesta,numpreg){
  

    padre=respuesta.parentNode;
    padre.removeChild(respuesta.nextSibling);
    padre.removeChild(respuesta);
   
    var k=padre.childNodes.length;
     
    j=0;
   
    for(i=0;i<k;i=i+2){
        j=j+1;
  
        padre.childNodes[i].setAttribute("id",'tablarespuesta'+j+'_'+numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].setAttribute("id",'trrespuesta'+j+'_'+numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[0].setAttribute("name",'crespuesta'+j+'_'+numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[0].setAttribute("id",'res'+j+'_'+numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[0].setAttribute("value",'crespuesta'+j+'_'+numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[0].setAttribute("onclick",'BotonRadio(crespuesta'+j+'_'+numpreg+')');
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[1].setAttribute("id",'respuesta'+j+'_'+numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[1].setAttribute("name",'respuesta'+j+'_'+numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[1].setAttribute("onclick",'BotonRadio(crespuesta'+j+'_'+numpreg+')');


        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[0].setAttribute("onclick",'EliminarRespuesta(tablarespuesta'+j+'_'+numpreg+','+numpreg+")");
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[1].setAttribute("id",'correcta'+j+'_'+numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[1].setAttribute("onclick",'InvertirRespuesta(correcta'+j+'_'+numpreg+','+numpreg+")");
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[2].setAttribute("id",'valorcorrecta'+j+'_'+numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[2].setAttribute("name",'valorcorrecta'+j+'_'+numpreg);
            
        
    }
    //Tengo una respuesta menos
    numerorespuestas = document.getElementById('num_res_preg'+numpreg);
       
    numerorespuestas.value=parseInt(numerorespuestas.value)-1;
    
    
    
   
}

function anadirRespuesta(respuesta,numpreg){
  
    // var idrespuesta=respuesta.id;
  
    /*  switch(idrespuesta){
        case 'respuestas1':
            
            numpreg="1";
           
            break;
        case 'respuestas2':
            
            numpreg="2";
            
            break;
        case 'respuestas3':
            
            numpreg="3";
           
            break;
        case 'respuestas4':
            
            numpreg="4";
            
            break;
        case 'respuestas5':
            
            numpreg="5";
           
            break;
        case 'respuestas6':
            
            numpreg="6";
            
            break;
            
        case 'respuestas7':
            
            numpreg="7";
           
            break;
        case 'respuestas8':
            
            numpreg="8";
            
            break;
         case 'respuestas9':
            
            numpreg="9";
            
            break;
    }*/
    
    var table = document.createElement("table");
    var tr = document.createElement("tr");
         
            
      
    //-1 por el text del div
    var numresp=(respuesta.childNodes.length/2) +1;
          
    table.width="100%";
    table.id="tablarespuesta"+numresp+"_"+numpreg;
        
    var tbody = document.createElement("tbody");
          
            
           
    tr.id="trrespuesta"+numresp+"_"+numpreg;
    var td = document.createElement("td");
    td.style.width="80%";
    var radioInput = document.createElement("input");
    radioInput.setAttribute("class","over");
    radioInput.type="radio";
    radioInput.name="crespuesta"+numresp+"_"+numpreg;
    radioInput.id="crespuesta"+numresp+"_"+numpreg;
    radioInput.value="0";  
    radioInput.setAttribute("onclick","BotonRadio(crespuesta"+numresp+"_"+numpreg+")");  
    var div = document.createElement("textarea");
    div.style.width="700px";
    div.setAttribute("class","resp");
    div.name="respuesta"+numresp+"_"+numpreg;
    div.id="respuesta"+numresp+"_"+numpreg;
    var text = document.createTextNode("Introduzca su respuesta..");
           
    div.appendChild(text);
            
    var td2 = document.createElement("td");
    td2.style.width="5%"
         
         
    var img= document.createElement("img");
    img.id="eliminarrespuesta"+numresp+"_"+numpreg;
    img.src="./imagenes/delete.gif";
    img.style.height="10px";
    img.style.width="10px";
    img.setAttribute("onclick","EliminarRespuesta(tablarespuesta"+numresp+"_"+numpreg+","+numpreg+")");
    img.title="Eliminar Respuesta";
            
            
    var img2= document.createElement("img");
    img2.src="./imagenes/incorrecto.png";
    img2.style.height="15px";
    img2.style.width="15x";
    img2.id="correcta"+numresp+"_"+numpreg;
    img2.setAttribute("onclick","InvertirRespuesta(correcta"+numresp+"_"+numpreg+",0)");
    img2.title="Cambiar a Correcta";
    var hidden= document.createElement("input");
    hidden.type="hidden";
    hidden.value="0";
    hidden.id="valorcorrecta"+numresp+"_"+numpreg;
    hidden.name="valorcorrecta"+numresp+"_"+numpreg;
    //$divpregunta.='<input type="hidden" value="0"  id="valorcorrecta'.$q.'_'.$i.'" name="valorcorrecta'.$q.'_'.$i.'" />';
    td2.appendChild(img);
    td2.appendChild(img2);
    td2.appendChild(hidden);
    td.appendChild(radioInput);
    td.appendChild(div);
    tr.appendChild(document.createTextNode(""));
    tr.appendChild(td);
    tr.appendChild(document.createTextNode(""));
    tr.appendChild(td2);
    tbody.appendChild(tr);
    table.appendChild(tbody);
            
    respuesta.appendChild(table);
    respuesta.appendChild(document.createTextNode(""));
     
    //Sumo 1 al número de respuesas
    numerorespuestas = document.getElementById('num_res_preg'+numpreg);
       
    numerorespuestas.value=parseInt(numerorespuestas.value)+1;
 
// respuesta.parentNode.addChild(respuesta);
}

function InvertirRespuesta(correcta,valor){
    

    if(valor=="0"){
        correcta.src="./imagenes/correcto.png";
        
        correcta.setAttribute("onclick",'InvertirRespuesta('+correcta.id+",1)");

        correcta.parentNode.childNodes[2].value="1";
    }else{
        correcta.src="./imagenes/incorrecto.png";
        correcta.setAttribute("onclick",'InvertirRespuesta('+correcta.id+",0)");
        correcta.parentNode.childNodes[2].value="0";
    }
}


function cargaImagenes_old(elnombre,i,j){
    
    //alert("AAAAAAAA"+i);
    var text='#upload'+i;
    var button = $(text), interval;
    //alert(elnombre);
    if(j=='primera'){
        button.text('Pulse aqui');
    }
    // var elnombre="aaa";
    new AjaxUpload(button,{
        action: 'procesa.php?nombre='+elnombre,
        name: 'image',
        autoSubmit: true,
        onSubmit : function(file, ext){
            //alert("Cargandoooo");
            // cambiar el texto del boton cuando se selecicione la imagen
            button.text('Subiendo');
            // desabilitar el boton
            this.disable();

            interval = window.setInterval(function(){
                var text = button.text();
                if (text.length < 11){
                    button.text(text + '.');
                } else {
                    button.text('Subiendo');
                }
            }, 200);
        },
        onComplete: function(file, response){
            //alert("completado");
            button.text('Cambiar Foto');

            window.clearInterval(interval);

            // Habilitar boton otra vez
            this.enable();
            //alert("recargando");
                 
            respuesta = document.getElementById('respuesta'+i);
              
            respuesta.src="./imagenes/"+elnombre;
            respuesta.removeAttribute("src");
            respuesta.setAttribute("src","./imagenes/"+elnombre);
            //alert('Fin cambio imagen');
               
        }
    //Tengo que cambiar la foto
    });

        

        
}

function botonASTextoImagen(id_ejercicio){

  
    num_preg=document.getElementById('num_preg');
    
    sig_preg=parseInt(num_preg.value)+1;



    //obtengo la tabla donde lo voy a insertar
    tabla_insertar = document.getElementById('tablarespuestas');
    //alert(tabla_insertar);
    tbody_insertar = tabla_insertar.lastChild;
    //alert(tbody_insertar);
           
    //Para el texto
    tabla_nuevotr = document.createElement('tr');
    tabla_nuevotd = document.createElement('td');
    tabla_nuevotd.id="texto"+sig_preg;
    textarea = document.createElement('textarea');
    textarea.id="pregunta"+sig_preg;
    textarea.name="pregunta"+sig_preg;
    textarea.setAttribute("style","height: 197px; width: 396px;");
    textarea.appendChild(document.createTextNode("Nuevo Texto"));
       

    //Para la imagen exagerada


    tabla_nuevotd1 = document.createElement('td');
   


    divcapa1= document.createElement('div');
    divcapa1.id="capa1";
    enlace= document.createElement('a');
    enlace.setAttribute("href","javascript:cargaImagenes('foto_"+id_ejercicio+"_"+sig_preg+".jpg',"+sig_preg+",'primera')");
    enlace.id=id="upload"+sig_preg;
    enlace.setAttribute("class","up");
    enlace.appendChild(document.createTextNode("Cambiar Foto"));
    divcapa1.appendChild(enlace);

    divcapa2= document.createElement('div');
    divcapa2.id="capa2";


    elemimg=document.createElement('img');
          
    elemimg.setAttribute("name","respuesta"+sig_preg);
         
    elemimg.id="respuesta"+sig_preg;
          

    elemimg.setAttribute("src","./imagenes/actividades/img_"+id_ejercicio+"_"+sig_preg+".jpg");
    elemimg.setAttribute("style","height: 192px; width: 401px;");

    divcapa2.appendChild(elemimg);
       
    tabla_nuevotd.appendChild(textarea);
    tabla_nuevotd1.appendChild(divcapa1);
    tabla_nuevotd1.appendChild(divcapa2);
    tabla_nuevotr.appendChild(tabla_nuevotd);
    tabla_nuevotr.appendChild(tabla_nuevotd1);
    tbody_insertar.appendChild(tabla_nuevotr);


    //Actualizo el número de preguntas a 1 mas

    num_preg.value=sig_preg;
}




function cargaAudios_old(elnombre,i,j){

    //alert("AAAAAAAA"+i);
    var text='#upload'+i;
    var button = $(text), interval;    
    //alert("el nombre  "+elnombre);
    if(j=='primera'){
        button.text('Pulse aqui');
    }
    // var elnombre="aaa";
    new AjaxUpload(button,{
        action: 'procesaaudio.php?nombre='+elnombre,
        name: 'image',
        autoSubmit: true,
        onSubmit : function(file, ext){
            //alert("Cargandoooo audio");
            // cambiar el texto del boton cuando se selecicione la imagen
            button.text('Subiendo');
            // desabilitar el boton
            this.disable();

            interval = window.setInterval(function(){
                var text = button.text();
                if (text.length < 11){
                    button.text(text + '.');
                } else {
                    button.text('Subiendo');
                }
            }, 200);
        },
        onComplete: function(file, response){
            //alert("completado");
            button.text('Cambiar Audio');
               
            window.clearInterval(interval);

            // Habilitar boton otra vez
            this.enable();
          
 
            respuesta = document.getElementsByName('respuesta'+i);
         
            respuesta[0].removeChild(respuesta[0].firstChild);
              
            elememb=document.createElement('embed');
            
            elememb.setAttribute("type","application/x-shockwave-flash");
            elememb.setAttribute("src","./mediaplayer/mediaplayer.swf");
            elememb.setAttribute("width","320");
            elememb.setAttribute("height","20")
            elememb.setAttribute("style","undefined");
            elememb.setAttribute("id","mpl");
           
            elememb.setAttribute("name","mpl");
            elememb.setAttribute("quality","high");
            elememb.setAttribute("allowfullscreen","true");
            elememb.setAttribute("flashvars","file=./mediaplayer/audios/"+elnombre+"&amp;height=20&amp;width=320");
        
            respuesta[0].appendChild(elememb);
               
        }
    //Tengo que cambiar la foto
    });

}


function cargaAudios(elnombre,i,j,numresp,nodo){
    /**
     * Parche debido a que JavaScript no soporta polimorfismo de funciones.
     * Se ha renombrado la antigua funcion cargaAudios a cargaAudios_old
     */
    if (cargaAudios.arguments.length==3) {
        cargaAudios_old(elnombre,i,j);
    }
    else {

        //alert("AAAAAAAA" + i);
        var text = 'upload' + i + "_" + numresp;
        //alert("id: " + text);
        var button = document.getElementById(text);
        //alert("el nombre  " + elnombre);
        //alert("Button: " + button);
        //alert("Button node type: " + button.nodeType);
        //alert("!Button: " + !button);
        if (j == 'primera') {
            button.childNodes[0].nodeValue = 'Pulse aqui';
        }
        // var elnombre="aaa";
        new AjaxUpload(button, {
            action: 'procesaaudio.php?nombre=' + elnombre,
            name: 'image',
            autoSubmit: true,
            onSubmit: function(file, ext) {
                //alert("Cargandoooo audio");
                // cambiar el texto del boton cuando se selecicione la imagen
                button.childNodes[0].nodeValue = 'Subiendo';
                // desabilitar el boton
                this.disable();

                interval = window.setInterval(function() {
                    var text = button.childNodes[0].nodeValue;
                    if (text.length < 11) {
                        button.childNodes[0].nodeValue = text + '.';
                    } else {
                        button.childNodes[0].nodeValue = 'Subiendo';
                    }
                }, 200);
            },
            onComplete: function(file, response) {
                //alert("completado");
                button.childNodes[0].nodeValue = 'Cambiar Audio';

                window.clearInterval(interval);

                // Habilitar boton otra vez
                this.enable();


                respuesta = document.getElementsByName(nodo);

                respuesta[0].removeChild(respuesta[0].firstChild);

                elememb = document.createElement('embed');

                elememb.setAttribute("type", "application/x-shockwave-flash");
                elememb.setAttribute("src", "./mediaplayer/mediaplayer.swf");
                elememb.setAttribute("width", "320");
                elememb.setAttribute("height", "20")
                elememb.setAttribute("style", "undefined");
                elememb.setAttribute("id", "mpl" + numresp + "_" + i);

                elememb.setAttribute("name", "mpl");
                elememb.setAttribute("quality", "high");
                elememb.setAttribute("allowfullscreen", "true");
                elememb.setAttribute("flashvars", "file=./mediaplayer/audios/" + elnombre + "&amp;height=20&amp;width=320");

                respuesta[0].appendChild(elememb);

            }
            //Tengo que cambiar la foto
        });
    }
}




function botonASTextoAudio(id_ejercicio){


    num_preg=document.getElementById('num_preg');

    sig_preg=parseInt(num_preg.value)+1;



    //obtengo la tabla donde lo voy a insertar
    tabla_insertar = document.getElementById('tablarespuestas');
    //alert(tabla_insertar);
    tbody_insertar = tabla_insertar.lastChild;
    //alert(tbody_insertar);
    //Para el texto
    tabla_nuevotr = document.createElement('tr');
    tabla_nuevotd = document.createElement('td');
    tabla_nuevotd.id="texto"+sig_preg;
    textarea = document.createElement('textarea');
    textarea.id="pregunta"+sig_preg;
    textarea.name="pregunta"+sig_preg;
    textarea.setAttribute("style","height: 197px; width: 396px;");
    textarea.appendChild(document.createTextNode("Nuevo Texto"));


    //Para el audio 

    tabla_nuevotd1 = document.createElement('td');

    divcapa1= document.createElement('div');
    divcapa1.id="c1";
    enlace= document.createElement('a');
    enlace.setAttribute("href","javascript:cargaAudios('audio_"+id_ejercicio+"_"+sig_preg+".mp3',"+sig_preg+",'primera')");
    enlace.id=id="upload"+sig_preg;
    enlace.setAttribute("class","up");
    enlace.appendChild(document.createTextNode("Cambiar Audio"));
    divcapa1.appendChild(enlace);

    divcapados= document.createElement('div');
    divcapados.id="capa2";

    //<script type="text/javascript" src="./mediaplayer/swfobject.js"></script>

    elemscript=document.createElement('script');

    elemscript.setAttribute("type","text/javascript");
    elemscript.setAttribute("src","./mediaplayer/swfobject.js");
    divcapados.appendChild(elemscript);

    elemdiv=document.createElement('div');
    // elemdiv.setAttribute("class","claseaudio1");
    elemdiv.setAttribute("id","player1");
    elemdiv.setAttribute("name","respuesta"+sig_preg);


    elememb=document.createElement('embed');

    elememb.setAttribute("type","application/x-shockwave-flash");
    elememb.setAttribute("src","./mediaplayer/mediaplayer.swf");
    elememb.setAttribute("width","320");
    elememb.setAttribute("height","20")
    elememb.setAttribute("style","undefined");
    elememb.setAttribute("id","mpl");

    elememb.setAttribute("name","mpl");
    elememb.setAttribute("quality","high");
    elememb.setAttribute("allowfullscreen","true");
    //alert("sig preg vale"+sig_preg);
    elememb.setAttribute("flashvars","file=./audios/audio_"+id_ejercicio+'_'+sig_preg+".mp3&amp;height=20&amp;width=320");

    elemdiv.appendChild(elememb);
                  
    divcapados.appendChild(elemdiv);

    elemscript2=document.createElement('script');
    elemscript2.setAttribute("type","text/javascript");

    dentroscript2=document.createTextNode("var so"+id_ejercicio+"_"+sig_preg+" = new SWFObject('./mediaplayer/mediaplayer.swf','mpl','320','20','7'); "+" so.addParam('allowfullscreen','true');" + " so.addVariable('file','./audios/audio_"+id_ejercicio+"_"+sig_preg+".mp3'); "+"  so.addVariable('height','20');" + "  so.addVariable('width','320');" + "so.write('player1');");
    elemscript2.appendChild(dentroscript2);
    divcapados.appendChild(elemscript2);


    tabla_nuevotd.appendChild(textarea);
    tabla_nuevotd1.appendChild(divcapa1);
    tabla_nuevotd1.appendChild(divcapados);
    tabla_nuevotr.appendChild(tabla_nuevotd);
    tabla_nuevotr.appendChild(tabla_nuevotd1);
    tbody_insertar.appendChild(tabla_nuevotr);


    //Actualizo el número de preguntas a 1 mas

    num_preg.value=sig_preg;
}






function botonASTextoVideo(id_ejercicio){

    //alert("Añadiendo texto video");

    num_preg=document.getElementById('num_preg');

    sig_preg=parseInt(num_preg.value)+1;



    //obtengo la tabla donde lo voy a insertar
    tabla_insertar = document.getElementById('tablarespuestas');
    //alert(tabla_insertar);
    tbody_insertar = tabla_insertar.lastChild;
    //alert(tbody_insertar);
    //Para el texto
    tabla_nuevotr = document.createElement('tr');
    tabla_nuevotd = document.createElement('td');
    tabla_nuevotd.id="texto"+sig_preg;
    textarea = document.createElement('textarea');
    textarea.id="pregunta"+sig_preg;
    textarea.name="pregunta"+sig_preg;
    textarea.setAttribute("style","height: 197px; width: 396px;");
    textarea.appendChild(document.createTextNode("Nuevo Texto"));


    //Para el audio

    tabla_nuevotd1 = document.createElement('td');


    //<a onclick="ObtenerDireccion(1)" class="button super yellow centrarvideo" href="http://www.youtube.com/" target="_blank" id="video1">Ver Video</a>
    enlace= document.createElement('a');
    enlace.setAttribute("onclick","ObtenerDireccion("+sig_preg+")");
    enlace.setAttribute("class","button super yellow centrarvideo");
    enlace.setAttribute("href","#");
    enlace.setAttribute("target","_blank");



    //  enlace.setAttribute("href","javascript:cargaAudios('audio_"+id_ejercicio+"_"+sig_preg+".mp3',"+sig_preg+",'primera')");
    enlace.id=id="video"+sig_preg;
    enlace.appendChild(document.createTextNode("Ver Video"));
            
    //<textarea class="video1" name="archivovideo1" id="archivovideo1">http://www.youtube.com/watch?v=WYGFNjEL7Jw</textarea>

    textarea2 = document.createElement('textarea');
    textarea2.setAttribute("class","video1");
    textarea2.name="archivovideo"+sig_preg;
    textarea2.id="archivovideo"+sig_preg;
    textarea2.appendChild(document.createTextNode("Introduzca el enlace al video"));

    tabla_nuevotd.appendChild(textarea);
    tabla_nuevotd1.appendChild(enlace);
    tabla_nuevotd1.appendChild(textarea2);
    tabla_nuevotr.appendChild(tabla_nuevotd);
    tabla_nuevotr.appendChild(tabla_nuevotd1);
    tbody_insertar.appendChild(tabla_nuevotr);


    //Actualizo el número de preguntas a 1 mas

    num_preg.value=sig_preg;
}



function ObtenerDireccion(i){
   
    direccion=document.getElementById('archivovideo'+i);
    enlace=document.getElementById('video'+i);
    enlace.href=direccion.value;
}




function oculta(id){
    var elDiv = document.getElementById(id); //se define la variable "elDiv" igual a nuestro div
    elDiv.style.display='none'; //damos un atributo display:none que oculta el div
}

function muestra(id){
    var elDiv = document.getElementById(id); //se define la variable "elDiv" igual a nuestro div
    elDiv.style.display='block';//damos un atributo display:block que  el div
}


function botonTextoTexto() {
    //alert("añadiendooooooo asociacion");
        num_preg=document.getElementById('num_preg');
        //alert("eL numero de preguntas es"+num_preg.value);
        sig_preg=parseInt(num_preg.value)+1;

        //alert("aki llega");

        //obtengo la tabla donde lo voy a insertar
        tabla_insertar = document.getElementById('tablarespuestas');
        //alert(tabla_insertar);
        tbody_insertar = tabla_insertar.lastChild;
        //alert(tbody_insertar);
        //Para el texto
        tabla_nuevotr = document.createElement('tr');
        tabla_nuevotd = document.createElement('td');
        tabla_nuevotd.id="texto"+sig_preg;
        textarea = document.createElement('textarea');
        textarea.id="pregunta"+sig_preg;
        textarea.name="pregunta"+sig_preg;
        textarea.setAttribute("style","height: 197px; width: 396px;");
        textarea.appendChild(document.createTextNode("Nuevo Texto"));
        //alert("insertado el texto");
            
        //Para el texto asociado

         
        tabla_nuevotd1 = document.createElement('td');
            
        textarea1 = document.createElement('textarea');
        textarea1.id="respuesta"+sig_preg;
        textarea1.name="respuesta"+sig_preg;
        textarea1.setAttribute("class","descripcion");
        textarea1.setAttribute("style","height: 192px; width: 401px;");
        textarea1.appendChild(document.createTextNode("Nuevo Texto Asociado"));

            
        tabla_nuevotd.appendChild(textarea);
        tabla_nuevotd1.appendChild(textarea1);
        tabla_nuevotr.appendChild(tabla_nuevotd);
        tabla_nuevotr.appendChild(tabla_nuevotd1);
        tbody_insertar.appendChild(tabla_nuevotr);


        //Actualizo el número de preguntas a 1 mas

        num_preg.value=sig_preg;
}

//---------- Boton de Ejercicios IE ---------------------
function EliminarPregunta_IE(Pregunta,numpregunta){

    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;

    //Compruebo que al menos hay una pregunta

    if(parseInt(numeropreguntas)>1){
        padre=Pregunta.parentNode;
        padre.removeChild(Pregunta.nextSibling);
        padre.removeChild(Pregunta);

        //le quieto uno al número de preguntas


        numeropreguntas= parseInt(numeropreguntas) - 1;
        divnumpreguntas.value=numeropreguntas;

        siguientepreg= parseInt(numpregunta)+1;
        //Actualizo el resto de pregunta
        //alert(siguientepreg);
        preg=parseInt(numpregunta);
        //alert("preg"+preg);
        for(j=siguientepreg;j<=numeropreguntas+1;j++){
            //alert('tabpregunta'+j);
            mitabla=document.getElementById('tabpregunta'+j);
            mitabla.id='tabpregunta'+preg;

            mitextarea=document.getElementById('pregunta'+j);
            mitextarea.id='pregunta'+preg;
            mitextarea.name='pregunta'+preg;

            miimgborrar=document.getElementById('imgpregborrar'+j);
            miimgborrar.setAttribute("onclick","EliminarPregunta_IE(tabpregunta"+preg+","+preg+")");
            miimgborrar.id='imgpregborrar'+preg;

            miimgañadir=document.getElementById('imgpreganadir'+j);
            miimgañadir.setAttribute("onclick","anadirRespuesta_IE(respuestas"+preg+","+preg+")");
            miimgañadir.id='imgpreganadir'+preg;

            //Obtengo el numero de respuestas de la pregunta

            minumeroresp=document.getElementById('num_res_preg'+j);
            numresp=minumeroresp.value;
            //Actualizo las respuestas
            divrespuestas=document.getElementById('respuestas'+j);
            divrespuestas.id='respuestas'+preg;
            for(k=1;k<=parseInt(numresp);k++){

                //Las tables
                //alert("llega");
                tablarespuestas=document.getElementById("tablarespuesta"+k+"_"+j);
                tablarespuestas.id="tablarespuesta"+k+"_"+preg;
                //alert("ki tba");
                //los tr de las tables
                lostr=document.getElementById('trrespuesta'+k+"_"+j);
                lostr.id='trrespuesta'+k+"_"+preg;
                //alert("siiiiii");

                /*losinput=document.getElementById('id_crespuesta'+k+"_"+j);
                losinput.id='id_crespuesta'+k+"_"+preg;
                losinput.name='crespuesta'+k+"_"+preg;
                losinput.setAttribute("onclick","BotonRadio(crespuesta"+k+"_"+preg+")");*/


                larespuesta=document.getElementById('respuesta'+k+"_"+j);
                larespuesta.id='respuesta'+k+"_"+preg;
                larespuesta.name='respuesta'+k+"_"+preg;

                //la imagen de eliminar

                laimageneliminar=document.getElementById('eliminarrespuesta'+k+"_"+j);
                laimageneliminar.id='eliminarrespuesta'+k+"_"+preg;
                laimageneliminar.setAttribute("onclick","EliminarRespuesta_IE(tablarespuesta"+k+"_"+preg+","+preg+")");

                //el hidden de correcta
                /*hiddencorrecta=document.getElementById('valorcorrecta'+k+"_"+j);
                hiddencorrecta.id='valorcorrecta'+k+"_"+preg;
                hiddencorrecta.name='valorcorrecta'+k+"_"+preg;
                //La imagen de correcta
                laimagencorrecta=document.getElementById('correcta'+k+"_"+j);
                laimagencorrecta.id='correcta'+k+"_"+preg;
                laimagencorrecta.setAttribute("onclick","InvertirRespuesta(correcta"+k+"_"+preg+","+hiddencorrecta.value+")");*/

            }

            //alert("fin hijos");
            //Cambio el número de respuestas
            minumeroresp=document.getElementById('num_res_preg'+j);
            minumeroresp.id='num_res_preg'+preg;
            minumeroresp.name='num_res_preg'+preg;

            preg=preg+1;
        }
        
    }else{
        alert("El ejercicio debe tener al menos una pregunta");
    }
}


function anadirRespuesta_IE(respuesta,numpreg){
    
    var table = document.createElement("table");
    var tr = document.createElement("tr");
         
            
      
    //-1 por el text del div
    var numresp=(respuesta.childNodes.length/2) +1;
          
    table.width="50%";
    table.id="tablarespuesta"+numresp+"_"+numpreg;
    if (numresp%2==0) {
        var tablaAnterior = document.getElementById("tablarespuesta"+(numresp-1)+"_"+numpreg);
        tablaAnterior.style.cssFloat="left";
    }
        
    var tbody = document.createElement("tbody");
          
            
           
    tr.id="trrespuesta"+numresp+"_"+numpreg;
    var td = document.createElement("td");
    td.style.width="80%";
    /*var radioInput = document.createElement("input");
    radioInput.setAttribute("class","over");
    radioInput.type="radio";
    radioInput.name="crespuesta"+numresp+"_"+numpreg;
    radioInput.id="crespuesta"+numresp+"_"+numpreg;
    radioInput.value="0";  
    radioInput.setAttribute("onclick","BotonRadio(crespuesta"+numresp+"_"+numpreg+")");  */
    var div = document.createElement("textarea");
    div.style.width="300px";
    div.setAttribute("class","resp");
    div.name="respuesta"+numresp+"_"+numpreg;
    div.id="respuesta"+numresp+"_"+numpreg;
    var text = document.createTextNode("Introduzca su respuesta..");
           
    div.appendChild(text);
            
    var td2 = document.createElement("td");
    td2.style.width="5%"
         
         
    var img= document.createElement("img");
    img.id="eliminarrespuesta"+numresp+"_"+numpreg;
    img.src="./imagenes/delete.gif";
    img.style.height="10px";
    img.style.width="10px";
    img.setAttribute("onclick","EliminarRespuesta_IE(tablarespuesta"+numresp+"_"+numpreg+","+numpreg+")");
    img.title="Eliminar Respuesta";
            
            
    /*var img2= document.createElement("img");
    img2.src="./imagenes/incorrecto.png";
    img2.style.height="15px";
    img2.style.width="15x";
    img2.id="correcta"+numresp+"_"+numpreg;
    img2.setAttribute("onclick","InvertirRespuesta(correcta"+numresp+"_"+numpreg+",0)");
    img2.title="Cambiar a Correcta";
    var hidden= document.createElement("input");
    hidden.type="hidden";
    hidden.value="0";
    hidden.id="valorcorrecta"+numresp+"_"+numpreg;
    hidden.name="valorcorrecta"+numresp+"_"+numpreg;
    //$divpregunta.='<input type="hidden" value="0"  id="valorcorrecta'.$q.'_'.$i.'" name="valorcorrecta'.$q.'_'.$i.'" />';*/
    td2.appendChild(img);
    /*td2.appendChild(img2);
    td2.appendChild(hidden);
    td.appendChild(radioInput);*/
    td.appendChild(div);
    tr.appendChild(document.createTextNode(""));
    tr.appendChild(td);
    tr.appendChild(document.createTextNode(""));
    tr.appendChild(td2);
    tbody.appendChild(tr);
    table.appendChild(tbody);
            
    respuesta.appendChild(table);
    respuesta.appendChild(document.createTextNode(""));
     
    //Sumo 1 al número de respuesas
    numerorespuestas = document.getElementById('num_res_preg'+numpreg);
       
    numerorespuestas.value=parseInt(numerorespuestas.value)+1;
 
// respuesta.parentNode.addChild(respuesta);
}


function EliminarRespuesta_IE(respuesta,numpreg){
  

    padre=respuesta.parentNode;
    padre.removeChild(respuesta.nextSibling);
    padre.removeChild(respuesta);
   
    var k=padre.childNodes.length;
     
    j=0;
    
    //alert("Numero de hijos: " + k);
   
    for(i=0;i<k;i=i+2){
        j=j+1;
        //alert('Iteracion bucle: ' + i);
        //alert("J: " + j);
        padre.childNodes[i].setAttribute("id",'tablarespuesta'+j+'_'+numpreg);
        if (i==k-2) {
            //alert("Entra en i==k-1");
            var tabla = document.getElementById("tablarespuesta"+j+"_"+numpreg);
            tabla.style.cssFloat="none";
        }
        else if (j%2!=0) {
            //alert("Entra en j%2!=0");
            var tabla = document.getElementById("tablarespuesta"+j+"_"+numpreg);
            tabla.style.cssFloat="left";
        }
        
        //alert(   padre.childNodes[i].childNodes[0].childNodes[0]);
        padre.childNodes[i].childNodes[0].childNodes[0].setAttribute("id",'trrespuesta'+j+'_'+numpreg);
        //padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[0].setAttribute("name",'crespuesta'+j+'_'+numpreg);
        //alert( padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[0]);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[0].setAttribute("id",'respuesta'+j+'_'+numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[0].setAttribute("name",'respuesta'+j+'_'+numpreg);
        //alert("3: " + padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3]);
        //alert("3 hijos: " + padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes);
        //alert("3 0: " + padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[0]);
        
        
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[0].setAttribute("id",'eliminarrespuesta'+j+'_'+numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[0].setAttribute("onclick",'EliminarRespuesta_IE(tablarespuesta'+j+'_'+numpreg+','+numpreg+")");
//        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[1].setAttribute("id",'correcta'+j+'_'+numpreg);
//        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[1].setAttribute("onclick",'InvertirRespuesta(correcta'+j+'_'+numpreg+','+numpreg+")");
//        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[2].setAttribute("id",'valorcorrecta'+j+'_'+numpreg);
//        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[2].setAttribute("name",'valorcorrecta'+j+'_'+numpreg);
            
        
    }
    //Tengo una respuesta menos
    numerorespuestas = document.getElementById('num_res_preg'+numpreg);
       
    numerorespuestas.value=parseInt(numerorespuestas.value)-1;
    
    
    
   
}


function botonMasPreguntas_IE(){
    //alert("añadiendo pregunta");

    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;
    //alert("numero actual es"+ numeropreguntas);
    anterior=document.getElementById('num_res_preg'+ numeropreguntas);
    //alert(anterior.id);
    numeropreguntas= parseInt(numeropreguntas) +1;
    divnumpreguntas.value=numeropreguntas;
    //alert("llega");
    nuevodiv = document.createElement('div');
    //alert("aki tb llega");
    nuevodiv.id= "tabpregunta"+numeropreguntas;
    //Creo un nuevo hijo a la tabla general para la pregunta
    //alert("si");
    var br = document.createElement('br');
    var br1 = document.createElement('br');
    var br2 = document.createElement('br');
    tablapreg = document.createElement('table');
    tablapreg.style.width="100%";

    body= document.createElement('tbody');
    nuevotr=document.createElement('tr');

    body.appendChild(nuevotr);
    nuevotd=document.createElement('td');
    nuevotd.style.width="80%";
    textareapreg=document.createElement('textarea');
    textareapreg.style.width="900px";
    textareapreg.setAttribute('class', 'pregunta');
    textareapreg.name="pregunta"+numeropreguntas;
    textareapreg.id="pregunta"+numeropreguntas;
    //Añado el textarea de la prgunta
    nuevotd.appendChild(textareapreg);

    nuevotd1=document.createElement('td');
    nuevotd1.style.width="5%";
    imgborrar=document.createElement('img');
    imgborrar.id="imgpregborrar"+numeropreguntas ;
    imgborrar.src="./imagenes/delete.gif";
    imgborrar.alt="eliminar respuesta";
    imgborrar.style.height="10px";
    imgborrar.style.width="10px";
    imgborrar.setAttribute('onclick',"EliminarPregunta_IE(tabpregunta"+numeropreguntas+","+numeropreguntas+")");
    imgborrar.title="Eliminar Pregunta";

    //

    //icono de borrar pregunta
    nuevotd1.appendChild(imgborrar);
    nuevotd1.appendChild(br);

    //Creación imagen añadir

    imgañadir=document.createElement('img');
    imgañadir.id="imgpreganadir"+numeropreguntas ;
    imgañadir.src="./imagenes/añadir.gif";
    imgañadir.alt="añadir respuesta";
    imgañadir.style.height="15px";
    imgañadir.style.width="15px";
    imgañadir.setAttribute('onclick',"anadirRespuesta_IE(respuestas"+numeropreguntas+","+numeropreguntas+")");
    imgañadir.title="Añadir Pregunta";

    nuevotd1.appendChild(imgañadir);
    nuevotr.appendChild(nuevotd);
    nuevotr.appendChild(nuevotd1);
    tablapreg.appendChild(body);
    //le añado sus br
    nuevodiv.appendChild(br);
    nuevodiv.appendChild(br1);
    nuevodiv.appendChild(br2);
    nuevodiv.appendChild(tablapreg);
    nuevodiv.appendChild(br);

    //div de respuestas


    divrespuesta=document.createElement('div');
    divrespuesta.id="respuestas"+numeropreguntas;
    divrespuesta.setAttribute('class',"respuesta");

      

    nuevodiv.appendChild(divrespuesta);

         

    //lo inserto despues de anterior
    insertAfter(anterior,nuevodiv);


    //<input type="hidden" value="1" id="num_res_preg3" name="num_res_preg3

    nuevoinput=document.createElement('input');
    nuevoinput.type="hidden";
    nuevoinput.value="0";
    nuevoinput.id="num_res_preg"+numeropreguntas;
    nuevoinput.name="num_res_preg"+numeropreguntas;

    //añado el numero de respuestas de la nueva pregunta
    insertAfter(nuevodiv,nuevoinput)

    //alert("fin");

      
}

function botonCorregirIE(id_curso,preguntas) {
    //alert("Boton Corregir");    
    
    //Recoger las respuestas de los alumnos
    var respuestas_alumnos = new Array(preguntas.length);
    for (var i=0; i<preguntas.length; i++) {
        respuestas_alumnos[i] = new Array(preguntas[i].length);
        for (var j=0; j<respuestas_alumnos[i].length; j++) {
            var correcta=false;
            respuestas_alumnos[i][j]=document.getElementById("respuesta"+(j+1)+"_"+(i+1)).value;
            //alert("respuesta " + (j+1) + " de la pregunta " + (i+1) + " es " + respuestas_alumnos[i][j]);
            for (var k=0; k<preguntas[i].length && !correcta; k++) {
                //alert("Comparando " + preguntas[i][k] + " con " + respuestas_alumnos[i][j]);
                if (preguntas[i][k]==respuestas_alumnos[i][j]) {
                    //alert("Da correcto: " + i + "," + k + " : " + preguntas[i][k]);
                    var midiv = document.getElementById("tdcorregir"+(j+1)+"_"+(i+1));
                    if (midiv.hasChildNodes()) midiv.removeChild(midiv.firstChild);
                    //alert("midiv es " + midiv);
                    var imagen = document.createElement("img");
                   
                    imagen.src='./imagenes/correcto.png';
                    imagen.style.height="15px";
                    imagen.style.width="15px";
                    midiv.appendChild(imagen);
                    
                    preguntas[i].splice(k,1);
                    //alert("Preguntas queda como: " + preguntas[i].toString());
                    k--;
                    correcta=true;
                }
            }
            if (!correcta) {
                //alert("Da incorrecto: " + i + "," + j + " : " + respuestas_alumnos[i][j]);
                var midiv = document.getElementById("tdcorregir"+(j+1)+"_"+(i+1));
                if (midiv.hasChildNodes()) midiv.removeChild(midiv.firstChild);
                //alert("midiv es " + midiv);
                var imagen = document.createElement("img");
                imagen = document.createElement("img");
                imagen.style.height="15px";
                imagen.style.width="15px";
                imagen.src='./imagenes/incorrecto.png';
               
                midiv.appendChild(imagen);
            }
        }
    }
    
       
}


//---------------------  Funciones para ejercicios de Asociacion Multiple/Compleja ---------------------------------
//El boton de mas respuestas en la interfaz de ejercicios AM Texto-Audio
function botonMasRespuestasAudio_AM (num_preg) {
    //alert("Pulsado en boton Mas Respuestas Audio AM");
    var totalRespuestas = document.getElementById("numerorespuestas_"+num_preg);
    var divRespuestas = document.getElementById("respuestas_pregunta"+num_preg);
    var num_resp = parseInt(totalRespuestas.value)+1;
    
    //Recuperar varios datos
    var textoLabel = divRespuestas.getElementsByTagName("label")[0];
    
    var etImg = divRespuestas.getElementsByTagName("img")[0];
    /*
     * <div class="fitem required">
        * <div class="fitemtitle">
            * <label for="id_archivoaudio1">Audio (Tamaño máximo: 20Mb)
            * <img class="req" title="Debe suministrar un valor aquí." alt="Debe suministrar un valor aquí." src="http://localhost/moodle/pix/req.gif">
            *  </label>
        *  </div>
        *  <div class="felement ffile">
        *     <input name="archivoaudio1" type="file" onblur="validate_mod_ejercicios_creando_ejercicio_asociacion_multiple_archivoaudio1(this)" onchange="validate_mod_ejercicios_creando_ejercicio_asociacion_multiple_archivoaudio1(this)" id="id_archivoaudio1">
        *  </div>
     *  </div>
     */
    var respuestas = document.getElementById("respuestas_pregunta"+num_preg);
    var div1 = document.createElement("div");
    div1.setAttribute("class","fitem required");
    respuestas.appendChild(div1);
    
    var div2 = document.createElement("div");
    div2.setAttribute("class","fitemtitle");
    div1.appendChild(div2);
    
    var label = document.createElement("label");
    label.setAttribute("for","id_archivoaudio" + num_preg + "_" + num_resp);
    label.setAttribute("id","label_archivoaudio" + num_preg + "_" + num_resp);
    label.innerHTML = textoLabel.childNodes[0].wholeText;
    div2.appendChild(label);
    
    var img = document.createElement("img");
    img.setAttribute("class","req");
    img.title = etImg.title;
    img.alt = etImg.alt;
    img.src = etImg.src;
    label.appendChild(img);
    
    var div3 = document.createElement("div");
    div3.setAttribute("class","felement ffile");
    div1.appendChild(div3);
    
    var input = document.createElement("input");
    input.setAttribute("name","archivoaudio"+num_preg + "_" + num_resp);
    input.setAttribute("type","file");
    input.setAttribute("onblur","validate_mod_ejercicios_creando_ejercicio_asociacion_multiple_archivoaudio"+ num_preg + "(this)");
    input.setAttribute("onchange","validate_mod_ejercicios_creando_ejercicio_asociacion_multiple_archivoaudio"+num_preg+"(this)");
    input.setAttribute("id","id_archivoaudio"+num_preg+"_"+num_resp);
    div3.appendChild(input);  
    
    //Aumentar el numero de respuestas
    totalRespuestas.value = num_resp;
}

//Funcion que se ejecuta automaticamente en la segunda pagina de creacion de ejercicios AM Texto-Audio
function arreglar_texto_audio_AM() {
    //alert("Entra en arreglar_texto_audio");
    
    var numpreg = parseInt(document.getElementsByName("numeropreguntas")[0].value);
    //alert("Numero de preguntas: " + numpreg);
    
    for (var i=0; i<numpreg; i++) {
        var divRespuestas = document.getElementById("respuestas_pregunta"+(i+1));
        //alert("Div Respuestas: " + divRespuestas);
        var labels = divRespuestas.getElementsByTagName("label");
        //alert("Labels: " + labels.toString());
        labels[0].setAttribute("id","label_archivoaudio"+(i+1)+"_"+1);
        labels[0].setAttribute("for","id_archivoaudio"+(i+1)+"_"+1);
        var input = document.getElementById("id_archivoaudio"+(i+1));
        //alert("Input: " + input);
        input.setAttribute("id","id_archivoaudio"+(i+1)+"_"+1);
        input.setAttribute("name","archivoaudio"+(i+1)+"_"+1);
    }
}

//Funcion que se ejecuta automaticamente en la segunda pagina de creacion de ejercicios AM Texto-Video
function arreglar_texto_video_AM() {
    //alert("Entra en arreglar_texto_video");
    
    var numpreg = parseInt(document.getElementsByName("numeropreguntas")[0].value);
    
    for (var i=0; i<numpreg; i++) {
        var divRespuestas = document.getElementById("respuestas_pregunta"+(i+1));
        //alert("Div Respuestas: " + divRespuestas);
        var labels = divRespuestas.getElementsByTagName("label");
        //alert("Labels: " + labels.toString());
        labels[0].setAttribute("id","label_archivovideo"+(i+1)+"_"+1);
        labels[0].setAttribute("for","id_archivovideo"+(i+1)+"_"+1);
        var input = document.getElementById("id_archivovideo"+(i+1));
        //alert("Input: " + input);
        input.setAttribute("id","id_archivovideo"+(i+1)+"_"+1);
        input.setAttribute("name","archivovideo"+(i+1)+"_"+1);
    }
}

//El boton de mas respuestas en la interfaz de ejercicios AM Texto-Video
function botonMasRespuestasVideo_AM (num_preg) {
    var totalRespuestas = document.getElementById("numerorespuestas_"+num_preg);
    var divRespuestas = document.getElementById("respuestas_pregunta"+num_preg);
    var num_resp = parseInt(totalRespuestas.value)+1;
    
    //Recuperar varios datos
    var textoLabel = divRespuestas.getElementsByTagName("label")[0];
    
    var etImg = divRespuestas.getElementsByTagName("img")[0];
    /*
     * <div class="fitem required">
        * <div class="fitemtitle">
            * <label for="id_archivoaudio1">Audio (Tamaño máximo: 20Mb)
            * <img class="req" title="Debe suministrar un valor aquí." alt="Debe suministrar un valor aquí." src="http://localhost/moodle/pix/req.gif">
            *  </label>
        *  </div>
        *  <div class="felement ffile">
        *     <input name="archivoaudio1" type="file" onblur="validate_mod_ejercicios_creando_ejercicio_asociacion_multiple_archivoaudio1(this)" onchange="validate_mod_ejercicios_creando_ejercicio_asociacion_multiple_archivoaudio1(this)" id="id_archivoaudio1">
        *  </div>
     *  </div>
     */
    var respuestas = document.getElementById("respuestas_pregunta"+num_preg);
    var div1 = document.createElement("div");
    div1.setAttribute("class","fitem required");
    respuestas.appendChild(div1);
    
    var div2 = document.createElement("div");
    div2.setAttribute("class","fitemtitle");
    div1.appendChild(div2);
    
    var label = document.createElement("label");
    label.setAttribute("for","id_archivovideo" + num_preg + "_" + num_resp);
    label.setAttribute("id","label_archivovideo" + num_preg + "_" + num_resp);
    label.innerHTML = textoLabel.childNodes[0].wholeText;
    div2.appendChild(label);
    
    var img = document.createElement("img");
    img.setAttribute("class","req");
    img.title = etImg.title;
    img.alt = etImg.alt;
    img.src = etImg.src;
    label.appendChild(img);
    
    var div3 = document.createElement("div");
    div3.setAttribute("class","felement ftext");
    div1.appendChild(div3);
    
    var input = document.createElement("input");
    input.setAttribute("size","100");
    input.setAttribute("name","archivovideo"+num_preg + "_" + num_resp);
    input.setAttribute("type","text");
    input.setAttribute("onblur","validate_mod_ejercicios_creando_ejercicio_asociacion_multiple_archivovideo"+ num_preg + "(this)");
    input.setAttribute("onchange","validate_mod_ejercicios_creando_ejercicio_asociacion_multiple_archivovideo"+num_preg+"(this)");
    input.setAttribute("id","id_archivovideo"+num_preg+"_"+num_resp);
    div3.appendChild(input);  
    
    //Aumentar el numero de respuestas
    totalRespuestas.value = num_resp;
}

//Funcion que se ejecuta automaticamente en la segunda pagina de creacion de ejercicios AM Texto-Foto
function arreglar_texto_foto_AM() {
    //alert("Entra en arreglar_texto_foto");
    
    var numpreg = parseInt(document.getElementsByName("numeropreguntas")[0].value);
    
    for (var i=0; i<numpreg; i++) {
        var divRespuestas = document.getElementById("respuestas_pregunta"+(i+1));
        //alert("Div Respuestas: " + divRespuestas);
        var labels = divRespuestas.getElementsByTagName("label");
        //alert("Labels: " + labels.toString());
        labels[0].setAttribute("id","label_archivofoto"+(i+1)+"_"+1);
        labels[0].setAttribute("for","id_archivofoto"+(i+1)+"_"+1);
        var input = document.getElementById("id_archivofoto"+(i+1));
        //alert("Input: " + input);
        input.setAttribute("id","id_archivofoto"+(i+1)+"_"+1);
        input.setAttribute("name","archivofoto"+(i+1)+"_"+1);
    }
}

//El boton de mas respuestas en la interfaz de ejercicios AM Texto-Foto
function botonMasRespuestasFoto_AM(num_preg) {
    //alert("Pulsado en boton Mas Respuestas Foto AM");
    var totalRespuestas = document.getElementById("numerorespuestas_"+num_preg);
    var divRespuestas = document.getElementById("respuestas_pregunta"+num_preg);
    var num_resp = parseInt(totalRespuestas.value)+1;
    
    //Recuperar varios datos
    var textoLabel = divRespuestas.getElementsByTagName("label")[0];
    
    var etImg = divRespuestas.getElementsByTagName("img")[0];
    /*
     * <div class="fitem required">
        * <div class="fitemtitle">
            * <label for="id_archivoaudio1">Audio (Tamaño máximo: 20Mb)
            * <img class="req" title="Debe suministrar un valor aquí." alt="Debe suministrar un valor aquí." src="http://localhost/moodle/pix/req.gif">
            *  </label>
        *  </div>
        *  <div class="felement ffile">
        *     <input name="archivoaudio1" type="file" onblur="validate_mod_ejercicios_creando_ejercicio_asociacion_multiple_archivoaudio1(this)" onchange="validate_mod_ejercicios_creando_ejercicio_asociacion_multiple_archivoaudio1(this)" id="id_archivoaudio1">
        *  </div>
     *  </div>
     */
    var respuestas = document.getElementById("respuestas_pregunta"+num_preg);
    var div1 = document.createElement("div");
    div1.setAttribute("class","fitem required");
    respuestas.appendChild(div1);
    
    var div2 = document.createElement("div");
    div2.setAttribute("class","fitemtitle");
    div1.appendChild(div2);
    
    var label = document.createElement("label");
    label.setAttribute("for","id_archivofoto" + num_preg + "_" + num_resp);
    label.setAttribute("id","label_archivofoto" + num_preg + "_" + num_resp);
    label.innerHTML = textoLabel.childNodes[0].wholeText;
    div2.appendChild(label);
    
    var img = document.createElement("img");
    img.setAttribute("class","req");
    img.title = etImg.title;
    img.alt = etImg.alt;
    img.src = etImg.src;
    label.appendChild(img);
    
    var div3 = document.createElement("div");
    div3.setAttribute("class","felement ffile");
    div1.appendChild(div3);
    
    var input = document.createElement("input");
    input.setAttribute("name","archivofoto"+num_preg + "_" + num_resp);
    input.setAttribute("type","file");
    input.setAttribute("onblur","validate_mod_ejercicios_creando_ejercicio_asociacion_multiple_archivofoto"+ num_preg + "(this)");
    input.setAttribute("onchange","validate_mod_ejercicios_creando_ejercicio_asociacion_multiple_archivofoto"+num_preg+"(this)");
    input.setAttribute("id","id_archivofoto"+num_preg+"_"+num_resp);
    div3.appendChild(input);  
    
    //Aumentar el numero de respuestas
    totalRespuestas.value = num_resp;
}

//Boton para añadir mas respuestas a ejercicios (Audio|Foto|Video)-Texto de Asociacion Multiple
function botonMasRespuestasAFV_Texto_AM(num_preg) {
    //alert("Pulsado en boton Mas Respuestas Foto AM");
    var totalRespuestas = document.getElementById("numerorespuestas_"+num_preg);
    var divRespuestas = document.getElementById("respuestas_pregunta"+num_preg);
    var num_resp = parseInt(totalRespuestas.value)+1;
    
    //Recuperar varios datos
    var textoLabel = divRespuestas.getElementsByTagName("label")[0];
    
    
    /*
     * <div class="fitem required">
        * <div class="fitemtitle">
            * <label for="id_archivoaudio1">Audio (Tamaño máximo: 20Mb)
            * <img class="req" title="Debe suministrar un valor aquí." alt="Debe suministrar un valor aquí." src="http://localhost/moodle/pix/req.gif">
            *  </label>
        *  </div>
        *  <div class="felement ffile">
        *     <input name="archivoaudio1" type="file" onblur="validate_mod_ejercicios_creando_ejercicio_asociacion_multiple_archivoaudio1(this)" onchange="validate_mod_ejercicios_creando_ejercicio_asociacion_multiple_archivoaudio1(this)" id="id_archivoaudio1">
        *  </div>
     *  </div>
     */
    var respuestas = document.getElementById("respuestas_pregunta"+num_preg);
    var div1 = document.createElement("div");
    div1.setAttribute("class","fitem");
    respuestas.appendChild(div1);
    
    var div2 = document.createElement("div");
    div2.setAttribute("class","fitemtitle");
    div1.appendChild(div2);
    
    var label = document.createElement("label");
    label.setAttribute("for","id_respuesta" + num_preg + "_" + num_resp);
    //label.setAttribute("id","label_archivofoto" + num_preg + "_" + num_resp);
    label.innerHTML = textoLabel.childNodes[0].wholeText;
    div2.appendChild(label);
    
    var div3 = document.createElement("div");
    div3.setAttribute("class","felement ftextarea");
    div1.appendChild(div3);
    
    var ta = document.createElement("textarea");
    ta.setAttribute("wrap","virtual");
    ta.setAttribute("rows","5");
    ta.setAttribute("cols","50");
    ta.setAttribute("name","respuesta"+num_preg+"_"+num_resp);
    ta.setAttribute("id","id_respuesta"+num_preg+"_"+num_resp);
    div3.appendChild(ta);
    //Aumentar el numero de respuestas
    totalRespuestas.value = num_resp;
}


//------------- Mostrando Ejercicios AM ------------
//Boton para añadir una nueva respuesta de los ejercicios Texto-Audio de Asociacion Multiple
function anadirRespuesta_AudioTexto_AM(id_ejercicio,respuesta,numpreg){
    
    var table = document.createElement("table");
    var tr = document.createElement("tr");
         
            
      
    //-1 por el text del div
    var numresp=(respuesta.childNodes.length/2) +1;
          
    table.width="50%";
    table.id="tablarespuesta"+numresp+"_"+numpreg;
    if (numresp%2==0) {
        var tablaAnterior = document.getElementById("tablarespuesta"+(numresp-1)+"_"+numpreg);
        tablaAnterior.style.cssFloat="left";
    }
        
    var tbody = document.createElement("tbody");
          
            
           
    tr.id="trrespuesta"+numresp+"_"+numpreg;
    var td = document.createElement("td");
    td.style.width="80%";
    /*var radioInput = document.createElement("input");
    radioInput.setAttribute("class","over");
    radioInput.type="radio";
    radioInput.name="crespuesta"+numresp+"_"+numpreg;
    radioInput.id="crespuesta"+numresp+"_"+numpreg;
    radioInput.value="0";  
    radioInput.setAttribute("onclick","BotonRadio(crespuesta"+numresp+"_"+numpreg+")");  */
    /*var div = document.createElement("textarea");
    div.style.width="300px";
    div.setAttribute("class","resp");
    div.name="respuesta"+numresp+"_"+numpreg;
    div.id="respuesta"+numresp+"_"+numpreg;
    var text = document.createTextNode("Introduzca su respuesta..");
           
    div.appendChild(text);*/
    
    var script = document.createElement("script");
    script.setAttribute("type","text/javascript");
    script.setAttribute("src","./mediaplayer/swfobject.js");
    td.appendChild(script);
    
    var div2 = document.createElement("div");
    div2.setAttribute("class","claseaudio1");
    div2.setAttribute("id","player"+numresp+"_"+numpreg);
    div2.setAttribute("name","respuesta"+numresp+"_"+numpreg);
    td.appendChild(div2);
    
    var embed = document.createElement("embed");
    embed.setAttribute("type","application/x-schockwave-flash");
    embed.setAttribute("src","./mediaplayer/mediaplayer.swf");
    embed.setAttribute("width","320");
    embed.setAttribute("height","20");
    embed.setAttribute("style","undefined");
    embed.setAttribute("id","mpl"+numresp+"_"+numpreg);
    embed.setAttribute("name","mpl");
    embed.setAttribute("quality","high");
    embed.setAttribute("allowfullscreen","true");
    embed.setAttribute("flashvars","file=./mediaplayer/audios/audio_"+id_ejercicio+"_"+numpreg+"_"+numresp+".mp3&height=20&width=320");
    div2.appendChild(embed);
    
    var a = document.createElement("a");
    a.setAttribute("href","javascript:cargaAudios('audio_"+id_ejercicio+"_"+numpreg+"_"+numresp+".mp3',"+numpreg+",'primera'," + numresp + ",'respuesta"+numresp+"_"+numpreg+"')");
    a.setAttribute("id","upload"+numpreg+"_"+numresp);
    a.setAttribute("class","up");
    var text = document.createTextNode("Cambiar Audio");
    a.appendChild(text);
    td.appendChild(a);
            
    var td2 = document.createElement("td");
    td2.style.width="5%";
         
         
    var img= document.createElement("img");
    img.id="eliminarrespuesta"+numresp+"_"+numpreg;
    img.src="./imagenes/delete.gif";
    img.style.height="10px";
    img.style.width="10px";
    img.setAttribute("onclick","EliminarRespuesta_TextoAudio_AM(tablarespuesta"+numresp+"_"+numpreg+","+numpreg+","+numresp+","+id_ejercicio+")");
    img.title="Eliminar Respuesta";
            
            
    /*var img2= document.createElement("img");
    img2.src="./imagenes/incorrecto.png";
    img2.style.height="15px";
    img2.style.width="15x";
    img2.id="correcta"+numresp+"_"+numpreg;
    img2.setAttribute("onclick","InvertirRespuesta(correcta"+numresp+"_"+numpreg+",0)");
    img2.title="Cambiar a Correcta";
    var hidden= document.createElement("input");
    hidden.type="hidden";
    hidden.value="0";
    hidden.id="valorcorrecta"+numresp+"_"+numpreg;
    hidden.name="valorcorrecta"+numresp+"_"+numpreg;
    //$divpregunta.='<input type="hidden" value="0"  id="valorcorrecta'.$q.'_'.$i.'" name="valorcorrecta'.$q.'_'.$i.'" />';*/
    td2.appendChild(img);
    /*td2.appendChild(img2);
    td2.appendChild(hidden);
    td.appendChild(radioInput);*/
    //td.appendChild(div);
    tr.appendChild(document.createTextNode(""));
    tr.appendChild(td);
    tr.appendChild(document.createTextNode(""));
    tr.appendChild(td2);
    tbody.appendChild(tr);
    table.appendChild(tbody);
            
    respuesta.appendChild(table);
    respuesta.appendChild(document.createTextNode(""));
     
    //Sumo 1 al número de respuesas
    numerorespuestas = document.getElementById('num_res_preg'+numpreg);
       
    numerorespuestas.value=parseInt(numerorespuestas.value)+1;
 
// respuesta.parentNode.addChild(respuesta);
}

//Boton para eliminar una respuesta en los ejercicios Texto-Audio de Asociacion Multiple
function EliminarRespuesta_TextoAudio_AM(respuesta,numpreg,numresp,id_ejercicio){
  

    /*padre=respuesta.parentNode;
    padre.removeChild(respuesta.nextSibling);
    padre.removeChild(respuesta);
   
    var k=padre.childNodes.length;
     
    j=0;
    
    alert("Numero de hijos: " + k);
   
    for(i=0;i<k;i=i+2){
        j=j+1;
        alert('Iteracion bucle: ' + i);
        alert("J: " + j);
        padre.childNodes[i].setAttribute("id",'tablarespuesta'+j+'_'+numpreg);
        if (i==k-2) {
            alert("Entra en i==k-1");
            var tabla = document.getElementById("tablarespuesta"+j+"_"+numpreg);
            tabla.style.cssFloat="none";
        }
        else if (j%2!=0) {
            alert("Entra en j%2!=0");
            var tabla = document.getElementById("tablarespuesta"+j+"_"+numpreg);
            tabla.style.cssFloat="left";
        }
        
        //alert(   padre.childNodes[i].childNodes[0].childNodes[0]);
        padre.childNodes[i].childNodes[0].childNodes[0].setAttribute("id",'trrespuesta'+j+'_'+numpreg);
        //padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[0].setAttribute("name",'crespuesta'+j+'_'+numpreg);
        //alert( padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[0]);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[0].setAttribute("id",'respuesta'+j+'_'+numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[0].setAttribute("name",'respuesta'+j+'_'+numpreg);
        //alert("3: " + padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3]);
        //alert("3 hijos: " + padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes);
        //alert("3 0: " + padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[0]);
        
        
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[0].setAttribute("id",'eliminarrespuesta'+j+'_'+numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[0].setAttribute("onclick",'EliminarRespuesta_TextoAudio_AM(tablarespuesta'+j+'_'+numpreg+','+numpreg+','+j+','+id_ejercicio+")");
//        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[1].setAttribute("id",'correcta'+j+'_'+numpreg);
//        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[1].setAttribute("onclick",'InvertirRespuesta(correcta'+j+'_'+numpreg+','+numpreg+")");
//        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[2].setAttribute("id",'valorcorrecta'+j+'_'+numpreg);
//        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[2].setAttribute("name",'valorcorrecta'+j+'_'+numpreg);
        
        alert("MPL cogido: mpl"+(j)+"_"+numpreg);
        var embed = document.getElementById("mpl"+(j)+"_"+numpreg);
        embed.id="mpl"+(j-1)+"_"+numpreg;
        embed.setAttribute("flashvars","file=./mediaplayer/audios/audio_"+id_ejercicio+"_"+numpreg+"_"+j+".mp3");
        var div = document.getElementById("player"+(j+1)+"_"+numpreg);
        div.setAttribute("id","player"+j+"_"+numpreg);
        div.setAttribute("name","respuesta"+j+"_"+numpreg);
        var a = document.getElementById("upload"+numpreg+"_"+(j+1));
        a.setAttribute("id","upload"+numpreg+"_"+j);
        a.setAttribute("href","javascript:cargaAudios('audio_"+id_ejercicio+"_"+numpreg+"_"+j+".mp3',"+numpreg+",'primera',"+j+",'respuesta"+j+"_"+numpreg+"')");
        
    }
    //Tengo una respuesta menos
    var numerorespuestas = document.getElementById('num_res_preg'+numpreg);
    
    
       
    numerorespuestas.value=parseInt(numerorespuestas.value)-1;*/
    
    var totalRespuestas = parseInt(document.getElementById("num_res_preg"+numpreg).value);
    //alert("Total Respuestas: " + totalRespuestas);
    //var respuesta = document.getElementById("tablarespuesta" + numresp + "_" + numpreg);
    //alert("Respuesta: " + respuesta);
    respuesta.parentNode.removeChild(respuesta);
    
    for (var k=numresp+1; k<=totalRespuestas; k++) {
        var table = document.getElementById('tablarespuesta'+k+'_'+numpreg);
        //alert("Iteraccion: " + k);
        //alert("Table: " + table);
        if(k==totalRespuestas) {
            //alert("Es la ultima respuestas");
            table.style.cssFloat="none";
        }
        else if ((k-1)%2!=0) {
            //alert("Entra en el else if");
            table.style.cssFloat="left";
        }
        table.setAttribute("name",'tablarespuesta'+(k-1)+'_'+numpreg);
        table.setAttribute("id",'tablarespuesta'+(k-1)+'_'+numpreg);
        var tr = document.getElementById('trrespuesta'+k+'_'+numpreg);
        //alert("Tr: " + tr);
        tr.setAttribute("id",'trrespuesta'+(k-1)+'_'+numpreg);
        //var resp = document.getElementById('respuesta'+k+'_'+numpreg);
        //resp.setAttribute("id",'respuesta'+(k-1)+'_'+numpreg);
        //resp.setAttribute("name",'respuesta'+(k-1)+'_'+numpreg);
        ////alert("Resp: " + resp);
        var player = document.getElementById("player"+k+"_"+numpreg);
        player.setAttribute("id","player"+(k-1)+"_"+numpreg);
        player.setAttribute("name","respuesta"+(k-1)+"_"+numpreg);
        var embed = document.getElementById("mpl"+k+"_"+numpreg);
        embed.setAttribute("id","mpl"+(k-1)+"_"+numpreg);
        embed.setAttribute("flashvars","file=./mediaplayer/audios/audio_"+id_ejercicio+"_"+numpreg+"_"+(k-1)+".mp3");
        var a = document.getElementById("upload"+numpreg+"_"+k);
        a.setAttribute("id","upload"+numpreg+"_"+(k-1));
        a.setAttribute("href","javascript:cargaAudios('audio_"+id_ejercicio+"_"+numpreg+"_"+(k-1)+".mp3',"+numpreg+",'primera',"+(k-1)+",'respuesta"+(k-1)+"_"+numpreg+"')");
        var img = document.getElementById("eliminarrespuesta"+k+"_"+numpreg);
        img.setAttribute("id","eliminarrespuesta"+(k-1)+"_"+numpreg);
        img.setAttribute("onclick","EliminarRespuesta_TextoAudio_AM(tablarespuesta"+(k-1)+"_"+numpreg+","+numpreg+","+(k-1)+","+id_ejercicio+")");
    }
    
    //Llamar a un archivo php para cambiar los archivos de audio del disco de la misma forma que se cambian en esta funcion
    $.ajax({
        type: "POST",
        url: "borrarespuesta.php?id_ejercicio=" + id_ejercicio + "&numpreg=" + numpreg + "&numresp=" + numresp + "&totalResp=" + totalRespuestas + "&directorio=./mediaplayer/audios/&archivo=audio_&extension=.mp3",
        cache : false,
        success : function(response) {
            //alert("Terminada con exito la llamada a borraaudio.php");
        }
    });
    var hidden_resp = document.getElementById("num_res_preg"+numpreg);
    hidden_resp.value = totalRespuestas-1;
}

//Boton de añadir una pregunta para los ejercicios Texto-Audio de Asociacion Multiple
function botonMasPreguntas_TextoAudio_AM(id_ejercicio) {
    //alert("añadiendo pregunta");

    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;
    //alert("numero actual es"+ numeropreguntas);
    anterior=document.getElementById('num_res_preg'+ numeropreguntas);
    //alert(anterior.id);
    numeropreguntas= parseInt(numeropreguntas) +1;
    divnumpreguntas.value=numeropreguntas;
    //alert("llega");
    nuevodiv = document.createElement('div');
    //alert("aki tb llega");
    nuevodiv.id= "tabpregunta"+numeropreguntas;
    //Creo un nuevo hijo a la tabla general para la pregunta
    //alert("si");
    var br = document.createElement('br');
    var br1 = document.createElement('br');
    var br2 = document.createElement('br');
    tablapreg = document.createElement('table');
    tablapreg.style.width="100%";

    body= document.createElement('tbody');
    nuevotr=document.createElement('tr');

    body.appendChild(nuevotr);
    nuevotd=document.createElement('td');
    nuevotd.style.width="80%";
    textareapreg=document.createElement('textarea');
    textareapreg.style.width="900px";
    textareapreg.setAttribute('class', 'pregunta');
    textareapreg.name="pregunta"+numeropreguntas;
    textareapreg.id="pregunta"+numeropreguntas;
    //Añado el textarea de la prgunta
    nuevotd.appendChild(textareapreg);

    nuevotd1=document.createElement('td');
    nuevotd1.style.width="5%";
    imgborrar=document.createElement('img');
    imgborrar.id="imgpregborrar"+numeropreguntas ;
    imgborrar.src="./imagenes/delete.gif";
    imgborrar.alt="eliminar respuesta";
    imgborrar.style.height="10px";
    imgborrar.style.width="10px";
    imgborrar.setAttribute('onclick',"EliminarPregunta_TextoAudio_AM("+id_ejercicio+",tabpregunta"+numeropreguntas+","+numeropreguntas+")");
    imgborrar.title="Eliminar Pregunta";

    //

    //icono de borrar pregunta
    nuevotd1.appendChild(imgborrar);
    nuevotd1.appendChild(br);

    //Creación imagen añadir

    imgañadir=document.createElement('img');
    imgañadir.id="imgpreganadir"+numeropreguntas ;
    imgañadir.src="./imagenes/añadir.gif";
    imgañadir.alt="añadir respuesta";
    imgañadir.style.height="15px";
    imgañadir.style.width="15px";
    imgañadir.setAttribute('onclick',"anadirRespuesta_AudioTexto_AM("+id_ejercicio+",respuestas"+numeropreguntas+","+numeropreguntas+")");
    imgañadir.title="Añadir Pregunta";

    nuevotd1.appendChild(imgañadir);
    nuevotr.appendChild(nuevotd);
    nuevotr.appendChild(nuevotd1);
    tablapreg.appendChild(body);
    //le añado sus br
    nuevodiv.appendChild(br);
    nuevodiv.appendChild(br1);
    nuevodiv.appendChild(br2);
    nuevodiv.appendChild(tablapreg);
    nuevodiv.appendChild(br);

    //div de respuestas


    divrespuesta=document.createElement('div');
    divrespuesta.id="respuestas"+numeropreguntas;
    divrespuesta.setAttribute('class',"respuesta");

      

    nuevodiv.appendChild(divrespuesta);

         

    //lo inserto despues de anterior
    insertAfter(anterior,nuevodiv);


    //<input type="hidden" value="1" id="num_res_preg3" name="num_res_preg3

    nuevoinput=document.createElement('input');
    nuevoinput.type="hidden";
    nuevoinput.value="0";
    nuevoinput.id="num_res_preg"+numeropreguntas;
    nuevoinput.name="num_res_preg"+numeropreguntas;

    //añado el numero de respuestas de la nueva pregunta
    insertAfter(nuevodiv,nuevoinput)

    //alert("fin");

}

//Boton para añadir una respuesta 
function anadirRespuesta_TextoVideo_AM(respuesta,numpreg){
    
    var table = document.createElement("table");
    var tr = document.createElement("tr");
         
            
      
    //-1 por el text del div
    var numresp=(respuesta.childNodes.length/2) +1;
          
    table.width="50%";
    table.id="tablarespuesta"+numresp+"_"+numpreg;
    if (numresp%2==0) {
        var tablaAnterior = document.getElementById("tablarespuesta"+(numresp-1)+"_"+numpreg);
        tablaAnterior.style.cssFloat="left";
    }
        
    var tbody = document.createElement("tbody");
          
            
           
    tr.id="trrespuesta"+numresp+"_"+numpreg;
    var td = document.createElement("td");
    td.style.width="80%";
    /*var radioInput = document.createElement("input");
    radioInput.setAttribute("class","over");
    radioInput.type="radio";
    radioInput.name="crespuesta"+numresp+"_"+numpreg;
    radioInput.id="crespuesta"+numresp+"_"+numpreg;
    radioInput.value="0";  
    radioInput.setAttribute("onclick","BotonRadio(crespuesta"+numresp+"_"+numpreg+")");  */
    var obj = document.createElement("object");
    obj.style.width="396";
    obj.style.height="197";
    var param1 = createElement("param",{name:"movie"+numresp+"_"+numpreg,id:"movie"+numresp+"_"+numpreg,value:""});
    var param2 = createElement("param",{name:"allowFullScreen",value:"true"});
    var param3 = createElement("param",{name:"allowscriptaccess",value:"always"});
    var embed = createElement("embed",{name:"embed"+numresp+"_"+numpreg, id:"embed"+numresp+"_"+numpreg, src:"",type:"application/x-shockwave-flash",width:"396",height:"197",allowscriptaccess:"always",allowfullscreen:"true"});
    obj.appendChild(param1);
    obj.appendChild(param2);
    obj.appendChild(param3);
    obj.appendChild(embed);
    td.appendChild(obj);
    
    var div = document.createElement("textarea");
    div.style.width="300px";
    div.setAttribute("class","video1");
    div.setAttribute("onchange","actualizar_TextoVideo_AM("+numresp+","+numpreg+")");
    div.setAttribute("value","Introduzca URL del Video de Youtube...");
    div.name="respuesta"+numresp+"_"+numpreg;
    div.id="respuesta"+numresp+"_"+numpreg;
    var text = document.createTextNode("Introduzca URL del Video de Youtube...");
           
    div.appendChild(text);
            
    var td2 = document.createElement("td");
    td2.style.width="5%"
         
         
    var img= document.createElement("img");
    img.id="eliminarrespuesta"+numresp+"_"+numpreg;
    img.src="./imagenes/delete.gif";
    img.style.height="10px";
    img.style.width="10px";
    img.setAttribute("onclick","EliminarRespuesta_TextoVideo_AM("+numresp+","+numpreg+")");
    img.title="Eliminar Respuesta";
            
            
    /*var img2= document.createElement("img");
    img2.src="./imagenes/incorrecto.png";
    img2.style.height="15px";
    img2.style.width="15x";
    img2.id="correcta"+numresp+"_"+numpreg;
    img2.setAttribute("onclick","InvertirRespuesta(correcta"+numresp+"_"+numpreg+",0)");
    img2.title="Cambiar a Correcta";
    var hidden= document.createElement("input");
    hidden.type="hidden";
    hidden.value="0";
    hidden.id="valorcorrecta"+numresp+"_"+numpreg;
    hidden.name="valorcorrecta"+numresp+"_"+numpreg;
    //$divpregunta.='<input type="hidden" value="0"  id="valorcorrecta'.$q.'_'.$i.'" name="valorcorrecta'.$q.'_'.$i.'" />';*/
    td2.appendChild(img);
    /*td2.appendChild(img2);
    td2.appendChild(hidden);
    td.appendChild(radioInput);*/
    td.appendChild(div);
    tr.appendChild(document.createTextNode(""));
    tr.appendChild(td);
    tr.appendChild(document.createTextNode(""));
    tr.appendChild(td2);
    tbody.appendChild(tr);
    table.appendChild(tbody);
            
    respuesta.appendChild(table);
    respuesta.appendChild(document.createTextNode(""));
     
    //Sumo 1 al número de respuesas
    numerorespuestas = document.getElementById('num_res_preg'+numpreg);
       
    numerorespuestas.value=parseInt(numerorespuestas.value)+1;
 
// respuesta.parentNode.addChild(respuesta);
}

function EliminarPregunta_TextoAudio_AM(id_ejercicio,Pregunta,numpregunta){

    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;

    //Compruebo que al menos hay una pregunta

    if(parseInt(numeropreguntas)>1){
        padre=Pregunta.parentNode;
        padre.removeChild(Pregunta.nextSibling);
        padre.removeChild(Pregunta);

        //le quieto uno al número de preguntas


        numeropreguntas= parseInt(numeropreguntas) - 1;
        divnumpreguntas.value=numeropreguntas;

        siguientepreg= parseInt(numpregunta)+1;
        //Actualizo el resto de pregunta
        //alert(siguientepreg);
        preg=parseInt(numpregunta);
        //alert("preg"+preg);
        for(j=siguientepreg;j<=numeropreguntas+1;j++){
            //alert('tabpregunta'+j);
            mitabla=document.getElementById('tabpregunta'+j);
            mitabla.id='tabpregunta'+preg;

            mitextarea=document.getElementById('pregunta'+j);
            mitextarea.id='pregunta'+preg;
            mitextarea.name='pregunta'+preg;

            miimgborrar=document.getElementById('imgpregborrar'+j);
            miimgborrar.setAttribute("onclick","EliminarPregunta_TextoAudio_AM("+id_ejercicio+",tabpregunta"+preg+","+preg+")");
            miimgborrar.id='imgpregborrar'+preg;

            miimgañadir=document.getElementById('imgpreganadir'+j);
            miimgañadir.setAttribute("onclick","anadirRespuesta_AudioTexto_AM("+id_ejercicio+",respuestas"+preg+","+preg+")");
            miimgañadir.id='imgpreganadir'+preg;

            //Obtengo el numero de respuestas de la pregunta

            minumeroresp=document.getElementById('num_res_preg'+j);
            numresp=minumeroresp.value;
            //Actualizo las respuestas
            divrespuestas=document.getElementById('respuestas'+j);
            divrespuestas.id='respuestas'+preg;
            for(k=1;k<=parseInt(numresp);k++){

                //Las tables
                //alert("llega");
                tablarespuestas=document.getElementById("tablarespuesta"+k+"_"+j);
                tablarespuestas.id="tablarespuesta"+k+"_"+preg;
                //alert("ki tba");
                //los tr de las tables
                lostr=document.getElementById('trrespuesta'+k+"_"+j);
                lostr.id='trrespuesta'+k+"_"+preg;
                //alert("siiiiii");

                /*losinput=document.getElementById('id_crespuesta'+k+"_"+j);
                losinput.id='id_crespuesta'+k+"_"+preg;
                losinput.name='crespuesta'+k+"_"+preg;
                losinput.setAttribute("onclick","BotonRadio(crespuesta"+k+"_"+preg+")");*/


                //larespuesta=document.getElementById('respuesta'+k+"_"+j);
                //larespuesta.id='respuesta'+k+"_"+preg;
                //larespuesta.name='respuesta'+k+"_"+preg;

                //la imagen de eliminar

                laimageneliminar=document.getElementById('eliminarrespuesta'+k+"_"+j);
                laimageneliminar.id='eliminarrespuesta'+k+"_"+preg;
                laimageneliminar.setAttribute("onclick","EliminarRespuesta_TextoAudio_AM(tablarespuesta"+k+"_"+preg+","+preg+","+k+","+id_ejercicio+")");
                
                
                var a = document.getElementById("upload"+j+"_"+k);
                a.setAttribute("id","upload"+preg+"_"+k);
                a.setAttribute("href","javascript:cargaAudios('audio_"+id_ejercicio+"_"+preg+"_"+k+".mp3',"+preg+",'primera',"+k+",'respuesta"+k+"_"+preg+"')");
                var div = document.getElementById("player"+k+"_"+j);
                div.setAttribute("id","player"+k+"_"+preg);
                div.setAttribute("name","respuesta"+k+"_"+preg);
                var embed = document.getElementById("mpl"+k+"_"+j);
                embed.setAttribute("id","mpl"+k+"_"+preg);
                embed.setAttribute("flashvars","file=./mediaplayer/audios/audio_"+id_ejercicio+"_"+preg+"_"+k+".mp3&height=20&width=320");
                //var trcorregir = document.getElementById("tdcorregir"+k+"_"+j);
                //trcorregir.setAttribute("id","tdcorregir"+k+"_"+preg);
                //el hidden de correcta
                /*hiddencorrecta=document.getElementById('valorcorrecta'+k+"_"+j);
                hiddencorrecta.id='valorcorrecta'+k+"_"+preg;
                hiddencorrecta.name='valorcorrecta'+k+"_"+preg;
                //La imagen de correcta
                laimagencorrecta=document.getElementById('correcta'+k+"_"+j);
                laimagencorrecta.id='correcta'+k+"_"+preg;
                laimagencorrecta.setAttribute("onclick","InvertirRespuesta(correcta"+k+"_"+preg+","+hiddencorrecta.value+")");*/

            }

            //alert("fin hijos");
            
            
            
            //Cambio el número de respuestas
            minumeroresp=document.getElementById('num_res_preg'+j);
            minumeroresp.id='num_res_preg'+preg;
            minumeroresp.name='num_res_preg'+preg;

            preg=preg+1;
        }
        //Llamar a un archivo php para cambiar los archivos de audio del disco de la misma forma que se cambian en esta funcion
            $.ajax({
                type: "POST",
                url: "borrapregunta.php?id_ejercicio=" + id_ejercicio + "&numpreg=" + numpregunta + "&totalPregs=" + (preg) + "&directorio=./mediaplayer/audios/&archivo=audio_&extension=.mp3",
                cache : false,
                success : function(response) {
                    //alert("Terminada con exito la llamada a borraaudio_pregunta.php");
                }
            });
        
    }else{
        alert("El ejercicio debe tener al menos una pregunta");
    }
}


//Boton de Eliminar Respuesta a los ejercicios Texto-Video en Asociacion Multiple
function EliminarRespuesta_TextoVideo_AM(numresp,numpreg){
    
    
    
    var totalRespuestas = parseInt(document.getElementById("num_res_preg"+numpreg).value);
    //alert("Total Respuestas: " + totalRespuestas);
    var respuesta = document.getElementById("tablarespuesta" + numresp + "_" + numpreg);
    //alert("Respuesta: " + respuesta);
    respuesta.parentNode.removeChild(respuesta);
    
    for (var k=numresp+1; k<=totalRespuestas; k++) {
        var table = document.getElementById('tablarespuesta'+k+'_'+numpreg);
        //alert("Iteraccion: " + k);
        //alert("Table: " + table);
        if(k==totalRespuestas) {
            //alert("Es la ultima respuestas");
            table.style.cssFloat="none";
        }
        else if ((k-1)%2!=0) {
            //alert("Entra en el else if");
            table.style.cssFloat="left";
        }
        table.setAttribute("name",'tablarespuesta'+(k-1)+'_'+numpreg);
        table.setAttribute("id",'tablarespuesta'+(k-1)+'_'+numpreg);
        var tr = document.getElementById('trrespuesta'+k+'_'+numpreg);
        //alert("Tr: " + tr);
        tr.setAttribute("id",'trrespuesta'+(k-1)+'_'+numpreg);
        var resp = document.getElementById('respuesta'+k+'_'+numpreg);
        resp.setAttribute("id",'respuesta'+(k-1)+'_'+numpreg);
        resp.setAttribute("name",'respuesta'+(k-1)+'_'+numpreg);
        resp.setAttribute("onchange","actualizar_TextoVideo_AM("+(k-1)+","+numpreg+")");
        //alert("Resp: " + resp);
        var param = document.getElementById("movie"+k+"_"+numpreg);
        param.setAttribute("id","movie"+(k-1)+'_'+numpreg);
        param.setAttribute("name","movie"+(k-1)+'_'+numpreg);
        var embed = document.getElementById("embed"+k+"_"+numpreg);
        embed.setAttribute("id","embed"+(k-1)+'_'+numpreg);
        embed.setAttribute("name","embed"+(k-1)+'_'+numpreg);
        var img = document.getElementById("eliminarrespuesta"+k+"_"+numpreg);
        img.setAttribute("id","eliminarrespuesta"+(k-1)+"_"+numpreg);
        img.setAttribute("onclick","EliminarRespuesta_TextoVideo_AM("+(k-1)+","+numpreg+")");
        //alert("Img: " + img);
        //var tdcorregir = document.getElementById("tdcorregir"+k+"_"+numpreg);
        //tdcorregir.setAttribute("id","tdcorregir"+(k-1)+"_"+numpreg);
    }
    
    var hidden_resp = document.getElementById("num_res_preg"+numpreg);
    hidden_resp.value = totalRespuestas-1;
      
}


//Boton para añadir mas preguntas a los ejercicios de Texto-Video en Asociacion Multiple
function botonMasPreguntas_TextoVideo_AM(id_ejercicio) {
    //alert("añadiendo pregunta");

    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;
    //alert("numero actual es"+ numeropreguntas);
    anterior=document.getElementById('num_res_preg'+ numeropreguntas);
    //alert(anterior.id);
    numeropreguntas= parseInt(numeropreguntas) +1;
    divnumpreguntas.value=numeropreguntas;
    //alert("llega");
    nuevodiv = document.createElement('div');
    //alert("aki tb llega");
    nuevodiv.id= "tabpregunta"+numeropreguntas;
    //Creo un nuevo hijo a la tabla general para la pregunta
    //alert("si");
    var br = document.createElement('br');
    var br1 = document.createElement('br');
    var br2 = document.createElement('br');
    tablapreg = document.createElement('table');
    tablapreg.style.width="100%";

    body= document.createElement('tbody');
    nuevotr=document.createElement('tr');

    body.appendChild(nuevotr);
    nuevotd=document.createElement('td');
    nuevotd.style.width="80%";
    textareapreg=document.createElement('textarea');
    textareapreg.style.width="900px";
    textareapreg.setAttribute('class', 'pregunta');
    textareapreg.name="pregunta"+numeropreguntas;
    textareapreg.id="pregunta"+numeropreguntas;
    //Añado el textarea de la prgunta
    nuevotd.appendChild(textareapreg);

    nuevotd1=document.createElement('td');
    nuevotd1.style.width="5%";
    imgborrar=document.createElement('img');
    imgborrar.id="imgpregborrar"+numeropreguntas ;
    imgborrar.src="./imagenes/delete.gif";
    imgborrar.alt="eliminar respuesta";
    imgborrar.style.height="10px";
    imgborrar.style.width="10px";
    imgborrar.setAttribute('onclick',"EliminarPregunta_TextoVideo_AM(tabpregunta"+numeropreguntas+","+numeropreguntas+")");
    imgborrar.title="Eliminar Pregunta";

    //

    //icono de borrar pregunta
    nuevotd1.appendChild(imgborrar);
    nuevotd1.appendChild(br);

    //Creación imagen añadir

    imgañadir=document.createElement('img');
    imgañadir.id="imgpreganadir"+numeropreguntas ;
    imgañadir.src="./imagenes/añadir.gif";
    imgañadir.alt="añadir respuesta";
    imgañadir.style.height="15px";
    imgañadir.style.width="15px";
    imgañadir.setAttribute('onclick',"anadirRespuesta_TextoVideo_AM(respuestas"+numeropreguntas+","+numeropreguntas+")");
    imgañadir.title="Añadir Pregunta";

    nuevotd1.appendChild(imgañadir);
    nuevotr.appendChild(nuevotd);
    nuevotr.appendChild(nuevotd1);
    tablapreg.appendChild(body);
    //le añado sus br
    nuevodiv.appendChild(br);
    nuevodiv.appendChild(br1);
    nuevodiv.appendChild(br2);
    nuevodiv.appendChild(tablapreg);
    nuevodiv.appendChild(br);

    //div de respuestas


    divrespuesta=document.createElement('div');
    divrespuesta.id="respuestas"+numeropreguntas;
    divrespuesta.setAttribute('class',"respuesta");

      

    nuevodiv.appendChild(divrespuesta);

         

    //lo inserto despues de anterior
    insertAfter(anterior,nuevodiv);


    //<input type="hidden" value="1" id="num_res_preg3" name="num_res_preg3

    nuevoinput=document.createElement('input');
    nuevoinput.type="hidden";
    nuevoinput.value="0";
    nuevoinput.id="num_res_preg"+numeropreguntas;
    nuevoinput.name="num_res_preg"+numeropreguntas;

    //añado el numero de respuestas de la nueva pregunta
    insertAfter(nuevodiv,nuevoinput)

    //alert("fin");
}

//Funcion que actualiza los objetos de video cuando se cambia los textarea de los videos
function actualizar_TextoVideo_AM(numresp,numpreg) {
    //Obtenemos las etiquetas a modificar (param y embed) donde se encuentra el origen del video de Youtube
    //alert("Actualizando video: " + numresp + "," + numpreg);
    var param = document.getElementById("movie"+numresp+"_"+numpreg);
    //alert("Param: " + param);
    var embed = document.getElementById("embed"+numresp+"_"+numpreg);
    //alert("Embed: " + embed);
    
    var textarea = document.getElementById("respuesta"+numresp+"_"+numpreg);
    var texto = textarea.value;
    //alert("Texto: " + texto);
    
    //Obtenemos la etiqueta object
    var obj = param.parentNode;
    var padre = obj.parentNode;
    
    
    //Con expresiones regulares obtener el codigo del video de youtube
    var regexp = /^http\:\/\/www\.youtube\.com\/watch\?v\=((\w|_|-))*$/;
    if (regexp.test(texto)) {
        //alert("Cumple la expresion regular");
        var codigo = texto.replace(/^http\:\/\/www\.youtube\.com\/watch\?v\=/,"");
        //alert("Codigo: " + codigo);
        param.setAttribute("value","http://www.youtube.com/v/"+codigo+"?hl=es_ES&version=3");
        embed.setAttribute("src","http://www.youtube.com/v/"+codigo+"?hl=es_ES&version=3");
        //Guardamos todos el codigo de object, incluyendo los hijos (param y embed)
        var htmlbkp = obj.innerHTML;
        
        //Eliminamos y volvemos a insertar para que se vuelva a cargar el video.
        //Esto se debe a que no se carga el video si solo se modifica los parametros, hay que eliminar el nodo y volver a insertarlo.
        
        padre.removeChild(obj);
        obj = document.createElement("object");
        obj.innerHTML=htmlbkp;
        padre.insertBefore(obj,padre.childNodes[0]);        
    }
    else {
        alert("No cumple la expresion regular");
    }
}

//Boton para eliminar pregunta de los ejercicios Texto-Video en Asociacion Multiple
function EliminarPregunta_TextoVideo_AM (Pregunta,numpregunta){

    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;

    //Compruebo que al menos hay una pregunta

    if(parseInt(numeropreguntas)>1){
        padre=Pregunta.parentNode;
        padre.removeChild(Pregunta.nextSibling);
        padre.removeChild(Pregunta);

        //le quieto uno al número de preguntas


        numeropreguntas= parseInt(numeropreguntas) - 1;
        divnumpreguntas.value=numeropreguntas;

        siguientepreg= parseInt(numpregunta)+1;
        //Actualizo el resto de pregunta
        //alert(siguientepreg);
        preg=parseInt(numpregunta);
        //alert("preg"+preg);
        for(j=siguientepreg;j<=numeropreguntas+1;j++){
            //alert('tabpregunta'+j);
            mitabla=document.getElementById('tabpregunta'+j);
            mitabla.id='tabpregunta'+preg;

            mitextarea=document.getElementById('pregunta'+j);
            mitextarea.id='pregunta'+preg;
            mitextarea.name='pregunta'+preg;

            miimgborrar=document.getElementById('imgpregborrar'+j);
            miimgborrar.setAttribute("onclick","EliminarPregunta_TextoVideo_AM(tabpregunta"+preg+","+preg+")");
            miimgborrar.id='imgpregborrar'+preg;

            miimgañadir=document.getElementById('imgpreganadir'+j);
            miimgañadir.setAttribute("onclick","anadirRespuesta_TextoVideo_AM(respuestas"+preg+","+preg+")");
            miimgañadir.id='imgpreganadir'+preg;

            //Obtengo el numero de respuestas de la pregunta

            minumeroresp=document.getElementById('num_res_preg'+j);
            numresp=minumeroresp.value;
            //Actualizo las respuestas
            divrespuestas=document.getElementById('respuestas'+j);
            divrespuestas.id='respuestas'+preg;
            for(k=1;k<=parseInt(numresp);k++){

                //Las tables
                //alert("llega");
                tablarespuestas=document.getElementById("tablarespuesta"+k+"_"+j);
                tablarespuestas.id="tablarespuesta"+k+"_"+preg;
                //alert("ki tba");
                //los tr de las tables
                lostr=document.getElementById('trrespuesta'+k+"_"+j);
                lostr.id='trrespuesta'+k+"_"+preg;
                //alert("siiiiii");

                /*losinput=document.getElementById('id_crespuesta'+k+"_"+j);
                losinput.id='id_crespuesta'+k+"_"+preg;
                losinput.name='crespuesta'+k+"_"+preg;
                losinput.setAttribute("onclick","BotonRadio(crespuesta"+k+"_"+preg+")");*/


                larespuesta=document.getElementById('respuesta'+k+"_"+j);
                larespuesta.id='respuesta'+k+"_"+preg;
                larespuesta.name='respuesta'+k+"_"+preg;
                larespuesta.setAttribute("onchange","actualizar_TextoVideo_AM("+k+","+preg+")");

                //la imagen de eliminar

                laimageneliminar=document.getElementById('eliminarrespuesta'+k+"_"+j);
                laimageneliminar.id='eliminarrespuesta'+k+"_"+preg;
                laimageneliminar.setAttribute("onclick","EliminarRespuesta_TextoVideo_AM("+k+","+preg+")");

                //el hidden de correcta
                /*hiddencorrecta=document.getElementById('valorcorrecta'+k+"_"+j);
                hiddencorrecta.id='valorcorrecta'+k+"_"+preg;
                hiddencorrecta.name='valorcorrecta'+k+"_"+preg;
                //La imagen de correcta
                laimagencorrecta=document.getElementById('correcta'+k+"_"+j);
                laimagencorrecta.id='correcta'+k+"_"+preg;
                laimagencorrecta.setAttribute("onclick","InvertirRespuesta(correcta"+k+"_"+preg+","+hiddencorrecta.value+")");*/
                
                //Cambiar los param y embed
                var param = document.getElementById("movie"+k+"_"+j);
                param.setAttribute("id","movie"+k+"_"+preg);
                param.setAttribute("name","movie"+k+"_"+preg);
                var embed = document.getElementById("embed"+k+"_"+j);
                embed.setAttribute("id","embed"+k+"_"+preg);
                embed.setAttribute("name","embed"+k+"_"+preg);

            }

            //alert("fin hijos");
            //Cambio el número de respuestas
            minumeroresp=document.getElementById('num_res_preg'+j);
            minumeroresp.id='num_res_preg'+preg;
            minumeroresp.name='num_res_preg'+preg;

            preg=preg+1;
        }
        
    }else{
        alert("El ejercicio debe tener al menos una pregunta");
    }
}


/**
 * *****************  FUNCIONES TEXTO - IMAGEN ******************************
 */
//Boton para añadir respuestas en ejercicios Texto-Imagen en Asociacion Multiple
function anadirRespuesta_TextoFoto_AM (id_ejercicio,respuesta,numpreg){
    
    var table = document.createElement("table");
    var tr = document.createElement("tr");
         
            
      
    //-1 por el text del div
    //var numresp=(respuesta.childNodes.length/2) +1;
    var numresp = parseInt(document.getElementById("num_res_preg"+numpreg).value)+1;
    //alert("Numero respuesta a crear: " + numresp);
          
    table.width="50%";
    table.id="tablarespuesta"+numresp+"_"+numpreg;
    if (numresp%2==0) {
        var tablaAnterior = document.getElementById("tablarespuesta"+(numresp-1)+"_"+numpreg);
        tablaAnterior.style.cssFloat="left";
    }
        
    var tbody = document.createElement("tbody");
          
            
           
    tr.id="trrespuesta"+numresp+"_"+numpreg;
    var td = document.createElement("td");
    td.style.width="80%";
    
    
    var div1 = createElement("div",{id:"capa1"});
    td.appendChild(div1);
    
    var a = createElement("a",{href:"javascript:cargaImagenes('foto_"+id_ejercicio+"_"+numpreg+"_"+numresp+".jpg',"+numpreg+",'primera',"+numresp+")",
                                id: "upload"+numresp+"_"+numpreg, 
                                class: "up"});
    a.appendChild(document.createTextNode("Cambiar Foto"));
    div1.appendChild(a);
    
    var div2 = createElement("div",{id:"capa2"});
    td.appendChild(div2);
    
    var img1 = createElement("img",{name:"respuesta"+numresp+"_"+numpreg,
                                    id:"respuesta"+numresp+"_"+numpreg,
                                    src:"./imagenes/foto_"+id_ejercicio+"_"+numpreg+"_"+numresp+".jpg",
                                    style:"height: 192px; width: 401px;"});
    div2.appendChild(img1);
    
    
    
            
    var td2 = document.createElement("td");
    td2.style.width="5%";
         
         
    var img= document.createElement("img");
    img.id="eliminarrespuesta"+numresp+"_"+numpreg;
    img.src="./imagenes/delete.gif";
    img.style.height="10px";
    img.style.width="10px";
    img.setAttribute("onclick","EliminarRespuesta_TextoFoto_AM(tablarespuesta"+numresp+"_"+numpreg+","+numpreg+","+numresp+","+id_ejercicio+")");
    img.title="Eliminar Respuesta";
            
            
    /*var img2= document.createElement("img");
    img2.src="./imagenes/incorrecto.png";
    img2.style.height="15px";
    img2.style.width="15x";
    img2.id="correcta"+numresp+"_"+numpreg;
    img2.setAttribute("onclick","InvertirRespuesta(correcta"+numresp+"_"+numpreg+",0)");
    img2.title="Cambiar a Correcta";
    var hidden= document.createElement("input");
    hidden.type="hidden";
    hidden.value="0";
    hidden.id="valorcorrecta"+numresp+"_"+numpreg;
    hidden.name="valorcorrecta"+numresp+"_"+numpreg;
    //$divpregunta.='<input type="hidden" value="0"  id="valorcorrecta'.$q.'_'.$i.'" name="valorcorrecta'.$q.'_'.$i.'" />';*/
    td2.appendChild(img);
    /*td2.appendChild(img2);
    td2.appendChild(hidden);
    td.appendChild(radioInput);*/
    //td.appendChild(div);
    tr.appendChild(document.createTextNode(""));
    tr.appendChild(td);
    tr.appendChild(document.createTextNode(""));
    tr.appendChild(td2);
    tbody.appendChild(tr);
    table.appendChild(tbody);
            
    respuesta.appendChild(table);
    respuesta.appendChild(document.createTextNode(""));
     
    //Sumo 1 al número de respuesas
    numerorespuestas = document.getElementById('num_res_preg'+numpreg);
       
    numerorespuestas.value=parseInt(numerorespuestas.value)+1;
 
// respuesta.parentNode.addChild(respuesta);
}

//Funcion para cargar imagenes en los ejercicios Texto-Imagen de Asociacion Multiple
function cargaImagenes(elnombre,i,j,numresp){
    /**
     * Parche realizado al darme cuenta de que Javascript no soporta polimorfismo de funciones
     * La antigua cargaImagenes ha sido renombrada a cargaImagenes_old
     */
    if (cargaImagenes.arguments.length==3) {
        cargaImagenes_old(elnombre,i,j);
    } else {
    
        //alert("AAAAAAAA" + i);
        var text = 'upload' + numresp + "_" + i;
        //alert("id: " + text);
        var button = document.getElementById(text);
        //alert("el nombre  " + elnombre);
        //alert("Button: " + button);
        if (j == 'primera') {
            button.childNodes[0].nodeValue = 'Pulse aqui';
        }
        // var elnombre="aaa";
        new AjaxUpload(button, {
            action: 'procesa.php?nombre=' + elnombre,
            name: 'image',
            autoSubmit: true,
            onSubmit: function(file, ext) {
                //alert("Cargandoooo");
                // cambiar el texto del boton cuando se selecicione la imagen
                button.childNodes[0].nodeValue = 'Subiendo';
                // desabilitar el boton
                this.disable();

                interval = window.setInterval(function() {
                    var text = button.childNodes[0].nodeValue;
                    if (text.length < 11) {
                        button.childNodes[0].nodeValue = text + '.';
                    } else {
                        button.childNodes[0].nodeValue = 'Subiendo';
                    }
                }, 200);
            },
            onComplete: function(file, response) {
                //alert("completado");
                button.childNodes[0].nodeValue = 'Cambiar Foto';

                window.clearInterval(interval);

                // Habilitar boton otra vez
                this.enable();
                //alert("recargando");

                respuesta = document.getElementById('respuesta' + numresp + "_" + i);
                var padre = respuesta.parentNode;
                padre.removeChild(respuesta);

                respuesta.src = "./imagenes/" + elnombre;
                respuesta.removeAttribute("src");
                respuesta.setAttribute("src", "./imagenes/" + elnombre);
                padre.appendChild(respuesta);
                //alert('Fin cambio imagen');

            }
            //Tengo que cambiar la foto
        });

        

    }
}

//Boton para eliminar una respuesta en los ejercicios Texto-Imagen de Asociacion Multiple
function EliminarRespuesta_TextoFoto_AM(respuesta,numpreg,numresp,id_ejercicio){
    var totalRespuestas = parseInt(document.getElementById("num_res_preg"+numpreg).value);
    //alert("Total Respuestas: " + totalRespuestas);
    //var respuesta = document.getElementById("tablarespuesta" + numresp + "_" + numpreg);
    //alert("Respuesta: " + respuesta);
    respuesta.parentNode.removeChild(respuesta);
    
    for (var k=numresp+1; k<=totalRespuestas; k++) {
        var table = document.getElementById('tablarespuesta'+k+'_'+numpreg);
        //alert("Iteraccion: " + k);
        //alert("Table: " + table);
        if(k==totalRespuestas) {
            //alert("Es la ultima respuestas");
            table.style.cssFloat="none";
        }
        else if ((k-1)%2!=0) {
            //alert("Entra en el else if");
            table.style.cssFloat="left";
        }
        table.setAttribute("name",'tablarespuesta'+(k-1)+'_'+numpreg);
        table.setAttribute("id",'tablarespuesta'+(k-1)+'_'+numpreg);
        var tr = document.getElementById('trrespuesta'+k+'_'+numpreg);
        //alert("Tr: " + tr);
        tr.setAttribute("id",'trrespuesta'+(k-1)+'_'+numpreg);
        //var resp = document.getElementById('respuesta'+k+'_'+numpreg);
        //resp.setAttribute("id",'respuesta'+(k-1)+'_'+numpreg);
        //resp.setAttribute("name",'respuesta'+(k-1)+'_'+numpreg);
        //alert("Resp: " + resp);
        var a = document.getElementById("upload"+k+"_"+numpreg);
        a.setAttribute("href","javascript:cargaImagenes('foto_"+id_ejercicio+"_"+numpreg+"_"+(k-1)+".jpg',"+numpreg+",'primera',"+(k-1)+")");
        a.setAttribute("id","upload"+(k-1)+"_"+numpreg);
        var img = document.getElementById("respuesta"+k+"_"+numpreg);
        var padre = img.parentNode;
        padre.removeChild(img);
        img.setAttribute("id","respuesta"+(k-1)+"_"+numpreg);
        img.setAttribute("name","respuesta"+(k-1)+"_"+numpreg);
        img.setAttribute("src","./imagenes/foto_"+id_ejercicio+"_"+numpreg+"_"+(k-1)+".jpg");
        padre.appendChild(img);
        var img2 = document.getElementById("eliminarrespuesta"+k+"_"+numpreg);
        img2.setAttribute("id","eliminarrespuesta"+(k-1)+"_"+numpreg);
        img2.setAttribute("name","eliminarrespuesta"+(k-1)+"_"+numpreg);
        img2.setAttribute("onclick","EliminarRespuesta_TextoFoto_AM(tablarespuesta"+(k-1)+"_"+numpreg+","+numpreg+","+(k-1)+","+id_ejercicio+")");
        //location.reload(); //Recarga la pagina para que las imagenes se actualicen bien
    }
    
    //Llamar a un archivo php para cambiar los archivos de audio del disco de la misma forma que se cambian en esta funcion
    $.ajax({
        type: "POST",
        url: "borrarespuesta.php?id_ejercicio=" + id_ejercicio + "&numpreg=" + numpreg + "&numresp=" + numresp + "&totalResp=" + totalRespuestas + "&directorio=./imagenes/&archivo=foto_&extension=.jpg",
        cache : false,
        success : function(response) {
            //alert("Terminada con exito la llamada a borrarespuesta.php");
        }
    });
    var hidden_resp = document.getElementById("num_res_preg"+numpreg);
    hidden_resp.value = totalRespuestas-1;
}

//Boton de añadir una pregunta para los ejercicios Texto-Imagen de Asociacion Multiple
function botonMasPreguntas_TextoFoto_AM(id_ejercicio) {
    //alert("añadiendo pregunta");

    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;
    //alert("numero actual es"+ numeropreguntas);
    anterior=document.getElementById('num_res_preg'+ numeropreguntas);
    //alert(anterior.id);
    numeropreguntas= parseInt(numeropreguntas) +1;
    divnumpreguntas.value=numeropreguntas;
    //alert("llega");
    nuevodiv = document.createElement('div');
    //alert("aki tb llega");
    nuevodiv.id= "tabpregunta"+numeropreguntas;
    //Creo un nuevo hijo a la tabla general para la pregunta
    //alert("si");
    var br = document.createElement('br');
    var br1 = document.createElement('br');
    var br2 = document.createElement('br');
    tablapreg = document.createElement('table');
    tablapreg.style.width="100%";

    body= document.createElement('tbody');
    nuevotr=document.createElement('tr');

    body.appendChild(nuevotr);
    nuevotd=document.createElement('td');
    nuevotd.style.width="80%";
    textareapreg=document.createElement('textarea');
    textareapreg.style.width="900px";
    textareapreg.setAttribute('class', 'pregunta');
    textareapreg.name="pregunta"+numeropreguntas;
    textareapreg.id="pregunta"+numeropreguntas;
    //Añado el textarea de la prgunta
    nuevotd.appendChild(textareapreg);

    nuevotd1=document.createElement('td');
    nuevotd1.style.width="5%";
    imgborrar=document.createElement('img');
    imgborrar.id="imgpregborrar"+numeropreguntas ;
    imgborrar.src="./imagenes/delete.gif";
    imgborrar.alt="eliminar respuesta";
    imgborrar.style.height="10px";
    imgborrar.style.width="10px";
    imgborrar.setAttribute('onclick',"EliminarPregunta_TextoFoto_AM("+id_ejercicio+",tabpregunta"+numeropreguntas+","+numeropreguntas+")");
    imgborrar.title="Eliminar Pregunta";

    //

    //icono de borrar pregunta
    nuevotd1.appendChild(imgborrar);
    nuevotd1.appendChild(br);

    //Creación imagen añadir

    imgañadir=document.createElement('img');
    imgañadir.id="imgpreganadir"+numeropreguntas ;
    imgañadir.src="./imagenes/añadir.gif";
    imgañadir.alt="añadir respuesta";
    imgañadir.style.height="15px";
    imgañadir.style.width="15px";
    imgañadir.setAttribute('onclick',"anadirRespuesta_TextoFoto_AM("+id_ejercicio+",respuestas"+numeropreguntas+","+numeropreguntas+")");
    imgañadir.title="Añadir Pregunta";

    nuevotd1.appendChild(imgañadir);
    nuevotr.appendChild(nuevotd);
    nuevotr.appendChild(nuevotd1);
    tablapreg.appendChild(body);
    //le añado sus br
    nuevodiv.appendChild(br);
    nuevodiv.appendChild(br1);
    nuevodiv.appendChild(br2);
    nuevodiv.appendChild(tablapreg);
    nuevodiv.appendChild(br);

    //div de respuestas


    divrespuesta=document.createElement('div');
    divrespuesta.id="respuestas"+numeropreguntas;
    divrespuesta.setAttribute('class',"respuesta");

      

    nuevodiv.appendChild(divrespuesta);

         

    //lo inserto despues de anterior
    insertAfter(anterior,nuevodiv);


    //<input type="hidden" value="1" id="num_res_preg3" name="num_res_preg3

    nuevoinput=document.createElement('input');
    nuevoinput.type="hidden";
    nuevoinput.value="0";
    nuevoinput.id="num_res_preg"+numeropreguntas;
    nuevoinput.name="num_res_preg"+numeropreguntas;

    //añado el numero de respuestas de la nueva pregunta
    insertAfter(nuevodiv,nuevoinput)

    //alert("fin");

}

//Boton para eliminar una pregunta de los ejercicios Texto-Imagen en Asociacion Multiple
function EliminarPregunta_TextoFoto_AM(id_ejercicio,Pregunta,numpregunta){

    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;

    //Compruebo que al menos hay una pregunta

    if(parseInt(numeropreguntas)>1){
        padre=Pregunta.parentNode;
        padre.removeChild(Pregunta.nextSibling);
        padre.removeChild(Pregunta);

        //le quieto uno al número de preguntas


        numeropreguntas= parseInt(numeropreguntas) - 1;
        divnumpreguntas.value=numeropreguntas;

        siguientepreg= parseInt(numpregunta)+1;
        //Actualizo el resto de pregunta
        //alert(siguientepreg);
        preg=parseInt(numpregunta);
        //alert("preg"+preg);
        for(j=siguientepreg;j<=numeropreguntas+1;j++){
            //alert('tabpregunta'+j);
            mitabla=document.getElementById('tabpregunta'+j);
            mitabla.id='tabpregunta'+preg;

            mitextarea=document.getElementById('pregunta'+j);
            mitextarea.id='pregunta'+preg;
            mitextarea.name='pregunta'+preg;

            miimgborrar=document.getElementById('imgpregborrar'+j);
            miimgborrar.setAttribute("onclick","EliminarPregunta_TextoFoto_AM("+id_ejercicio+",tabpregunta"+preg+","+preg+")");
            miimgborrar.id='imgpregborrar'+preg;

            miimgañadir=document.getElementById('imgpreganadir'+j);
            miimgañadir.setAttribute("onclick","anadirRespuesta_TextoFoto_AM("+id_ejercicio+",respuestas"+preg+","+preg+")");
            miimgañadir.id='imgpreganadir'+preg;

            //Obtengo el numero de respuestas de la pregunta

            minumeroresp=document.getElementById('num_res_preg'+j);
            numresp=minumeroresp.value;
            //Actualizo las respuestas
            divrespuestas=document.getElementById('respuestas'+j);
            divrespuestas.id='respuestas'+preg;
            for(k=1;k<=parseInt(numresp);k++){

                //Las tables
                //alert("llega");
                tablarespuestas=document.getElementById("tablarespuesta"+k+"_"+j);
                tablarespuestas.id="tablarespuesta"+k+"_"+preg;
                //alert("ki tba");
                //los tr de las tables
                lostr=document.getElementById('trrespuesta'+k+"_"+j);
                lostr.id='trrespuesta'+k+"_"+preg;
                //alert("siiiiii");

                /*losinput=document.getElementById('id_crespuesta'+k+"_"+j);
                losinput.id='id_crespuesta'+k+"_"+preg;
                losinput.name='crespuesta'+k+"_"+preg;
                losinput.setAttribute("onclick","BotonRadio(crespuesta"+k+"_"+preg+")");*/


                //larespuesta=document.getElementById('respuesta'+k+"_"+j);
                //larespuesta.id='respuesta'+k+"_"+preg;
                //larespuesta.name='respuesta'+k+"_"+preg;

                //la imagen de eliminar

                laimageneliminar=document.getElementById('eliminarrespuesta'+k+"_"+j);
                laimageneliminar.id='eliminarrespuesta'+k+"_"+preg;
                laimageneliminar.setAttribute("onclick","EliminarRespuesta_TextoFoto_AM(tablarespuesta"+k+"_"+preg+","+preg+","+k+","+id_ejercicio+")");
                
                var a = document.getElementById("upload"+k+"_"+j);
                a.setAttribute("id","upload"+k+"_"+preg);
                a.setAttribute("href","javascript:cargaImagenes('foto_"+id_ejercicio+"_"+preg+"_"+k+".jpg',"+preg+",'primera',"+k+")");
                var img1 = document.getElementById("respuesta"+k+"_"+j);
                img1.setAttribute("id","respuesta"+k+"_"+preg);
                img1.setAttribute("name","respuesta"+k+"_"+preg);
                img1.setAttribute("src","./imagenes/foto_"+id_ejercicio+"_"+preg+"_"+k+".jpg");
                
                
                //var trcorregir = document.getElementById("tdcorregir"+k+"_"+j);
                //trcorregir.setAttribute("id","tdcorregir"+k+"_"+preg);
                //el hidden de correcta
                /*hiddencorrecta=document.getElementById('valorcorrecta'+k+"_"+j);
                hiddencorrecta.id='valorcorrecta'+k+"_"+preg;
                hiddencorrecta.name='valorcorrecta'+k+"_"+preg;
                //La imagen de correcta
                laimagencorrecta=document.getElementById('correcta'+k+"_"+j);
                laimagencorrecta.id='correcta'+k+"_"+preg;
                laimagencorrecta.setAttribute("onclick","InvertirRespuesta(correcta"+k+"_"+preg+","+hiddencorrecta.value+")");*/

            }

            //alert("fin hijos");
            
            
            
            //Cambio el número de respuestas
            minumeroresp=document.getElementById('num_res_preg'+j);
            minumeroresp.id='num_res_preg'+preg;
            minumeroresp.name='num_res_preg'+preg;

            preg=preg+1;
        }
        //Llamar a un archivo php para cambiar los archivos de audio del disco de la misma forma que se cambian en esta funcion
            $.ajax({
                type: "POST",
                url: "borrapregunta.php?id_ejercicio=" + id_ejercicio + "&numpreg=" + numpregunta + "&totalPregs=" + (preg) + "&directorio=./imagenes/&archivo=foto_&extension=.jpg",
                cache : false,
                success : function(response) {
                    //alert("Terminada con exito la llamada a borrapregunta.php");
                }
            });
        
    }else{
        alert("El ejercicio debe tener al menos una pregunta");
    }
}


/**
 * ************************* EJERCICIOS ASOCIACION MULTIPLE  AUDIO-TEXTO ************************************
 */
function botonMasPreguntas_AudioTexto_AM(id_ejercicio) {
    //alert("añadiendo pregunta");

    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;
    //alert("numero actual es"+ numeropreguntas);
    anterior=document.getElementById('num_res_preg'+ numeropreguntas);
    //alert(anterior.id);
    numeropreguntas= parseInt(numeropreguntas) +1;
    divnumpreguntas.value=numeropreguntas;
    //alert("llega");
    nuevodiv = document.createElement('div');
    //alert("aki tb llega");
    nuevodiv.id= "tabpregunta"+numeropreguntas;
    //Creo un nuevo hijo a la tabla general para la pregunta
    //alert("si");
    var br = document.createElement('br');
    var br1 = document.createElement('br');
    var br2 = document.createElement('br');
    tablapreg = document.createElement('table');
    tablapreg.style.width="100%";

    body= document.createElement('tbody');
    nuevotr=document.createElement('tr');

    body.appendChild(nuevotr);
    nuevotd=document.createElement('td');
    nuevotd.style.width="80%";
    
    var divpreg = createElement("div",{style:"width:900px;", class:"pregunta",
                                       name: "pregunta"+numeropreguntas, id:"pregunta"+numeropreguntas});
    nuevotd.appendChild(divpreg);
    var script = createElement("script",{type:"text/javascript",src:"./mediaplayer/swfobject.js"});
    divpreg.appendChild(script);
    
    var div_embed = createElement("div",{style:"margin: 0 auto; margin-left: auto; margin-right: auto; width:320px;"});
    divpreg.appendChild(div_embed);
    var file_audio = "audio_"+id_ejercicio+"_"+numeropreguntas+".mp3";
    var embed = createElement("embed",{type:"application/x-shockwave-flash", src:"./mediaplayer/mediaplayer.swf",
                                       width:"320",height:"20",style:"undefined",id:"mpl"+numeropreguntas,
                                       name:"mpl"+numeropreguntas,quality:"high",allowfullscreen:"true",
                                       flashvars:"file=./mediaplayer/audios/"+file_audio+"&height=20&width=320"});
    div_embed.appendChild(embed);
    
    var a = createElement("a",{href:"javascript:cargaAudios_AudioTexto_AM('audio_"+id_ejercicio+"_"+numeropreguntas+".mp3',"+numeropreguntas+",'primera')",
                               id:"upload"+numeropreguntas,class:"up"});
    a.appendChild(document.createTextNode("Cambiar Audio"));
    divpreg.appendChild(a);
    
    nuevotd1=document.createElement('td');
    nuevotd1.style.width="5%";
    imgborrar=document.createElement('img');
    imgborrar.id="imgpregborrar"+numeropreguntas;
    imgborrar.src="./imagenes/delete.gif";
    imgborrar.alt="eliminar respuesta";
    imgborrar.style.height="10px";
    imgborrar.style.width="10px";
    imgborrar.setAttribute('onclick',"EliminarPregunta_AudioTexto_AM("+id_ejercicio+",tabpregunta"+numeropreguntas+","+numeropreguntas+")");
    imgborrar.title="Eliminar Pregunta";

    //

    //icono de borrar pregunta
    nuevotd1.appendChild(imgborrar);
    nuevotd1.appendChild(br);

    //Creación imagen añadir

    imgañadir=document.createElement('img');
    imgañadir.id="imgpreganadir"+numeropreguntas ;
    imgañadir.src="./imagenes/añadir.gif";
    imgañadir.alt="añadir respuesta";
    imgañadir.style.height="15px";
    imgañadir.style.width="15px";
    imgañadir.setAttribute('onclick',"anadirRespuesta_IE(respuestas"+numeropreguntas+","+numeropreguntas+")");
    imgañadir.title="Añadir Pregunta";

    nuevotd1.appendChild(imgañadir);
    nuevotr.appendChild(nuevotd);
    nuevotr.appendChild(nuevotd1);
    tablapreg.appendChild(body);
    //le añado sus br
    nuevodiv.appendChild(br);
    nuevodiv.appendChild(br1);
    nuevodiv.appendChild(br2);
    nuevodiv.appendChild(tablapreg);
    nuevodiv.appendChild(br);

    //div de respuestas


    divrespuesta=document.createElement('div');
    divrespuesta.id="respuestas"+numeropreguntas;
    divrespuesta.setAttribute('class',"respuesta");

      

    nuevodiv.appendChild(divrespuesta);

         

    //lo inserto despues de anterior
    insertAfter(anterior,nuevodiv);


    //<input type="hidden" value="1" id="num_res_preg3" name="num_res_preg3

    nuevoinput=document.createElement('input');
    nuevoinput.type="hidden";
    nuevoinput.value="0";
    nuevoinput.id="num_res_preg"+numeropreguntas;
    nuevoinput.name="num_res_preg"+numeropreguntas;

    //añado el numero de respuestas de la nueva pregunta
    insertAfter(nuevodiv,nuevoinput)

    //alert("fin");

}

/**
 * Funcion para subir archivos de audio para los ejercicios Audio-Texto en Asociacion Multiple
 */
function cargaAudios_AudioTexto_AM(elnombre,i,j){
    //alert("AAAAAAAA" + i);
    var text = 'upload' + i;
    //alert("id: " + text);
    var button = document.getElementById(text);
    //alert("el nombre  " + elnombre);
    //alert("Button: " + button);
    //alert("Button node type: " + button.nodeType);
    //alert("!Button: " + !button);
    if (j == 'primera') {
        button.childNodes[0].nodeValue = 'Pulse aqui';
    }
    // var elnombre="aaa";
    new AjaxUpload(button, {
        action: 'procesaaudio.php?nombre=' + elnombre,
        name: 'image',
        autoSubmit: true,
        onSubmit: function(file, ext) {
            //alert("Cargandoooo audio");
            // cambiar el texto del boton cuando se selecicione la imagen
            button.childNodes[0].nodeValue = 'Subiendo';
            // desabilitar el boton
            this.disable();

            interval = window.setInterval(function() {
                var text = button.childNodes[0].nodeValue;
                if (text.length < 11) {
                    button.childNodes[0].nodeValue = text + '.';
                } else {
                    button.childNodes[0].nodeValue = 'Subiendo';
                }
            }, 200);
        },
        onComplete: function(file, response) {
            //alert("completado");
            button.childNodes[0].nodeValue = 'Cambiar Audio';

            window.clearInterval(interval);

            // Habilitar boton otra vez
            this.enable();
            
            var embed = document.getElementById("mpl"+i);
            var padre = embed.parentNode;
            padre.removeChild(embed);
            
            
            embed = createElement("embed",{type:"application/x-shockwave-flash",
                                           src:"./mediaplayer/mediaplayer.swf",width:"320",height:"20",
                                           style:"undefined",id:"mpl"+i,name:"mpl"+i,quality:"high",
                                           allowfullscreen:"true",flashvars:"file=./mediaplayer/audios/"+elnombre+"&height=20&width=320"});
            padre.appendChild(embed);

        }
        //Tengo que cambiar la foto
    });
}

//Boton para eliminar una pregunta para los ejercicios Audio-Texto en Asociacion Multiple
function EliminarPregunta_AudioTexto_AM(id_ejercicio,Pregunta,numpregunta){

    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;

    //Compruebo que al menos hay una pregunta

    if(parseInt(numeropreguntas)>1){
        padre=Pregunta.parentNode;
        padre.removeChild(Pregunta.nextSibling);
        padre.removeChild(Pregunta);

        //le quieto uno al número de preguntas


        numeropreguntas= parseInt(numeropreguntas) - 1;
        divnumpreguntas.value=numeropreguntas;

        siguientepreg= parseInt(numpregunta)+1;
        //Actualizo el resto de pregunta
        //alert(siguientepreg);
        preg=parseInt(numpregunta);
        //alert("preg"+preg);
        for(j=siguientepreg;j<=numeropreguntas+1;j++){
            //alert('tabpregunta'+j);
            mitabla=document.getElementById('tabpregunta'+j);
            mitabla.id='tabpregunta'+preg;

            mitextarea=document.getElementById('pregunta'+j);
            mitextarea.id='pregunta'+preg;
            mitextarea.setAttribute("name","pregunta"+preg);

            miimgborrar=document.getElementById('imgpregborrar'+j);
            miimgborrar.setAttribute("onclick","EliminarPregunta_AudioTexto_AM("+id_ejercicio+",tabpregunta"+preg+","+preg+")");
            miimgborrar.id='imgpregborrar'+preg;

            miimgañadir=document.getElementById('imgpreganadir'+j);
            miimgañadir.setAttribute("onclick","anadirRespuesta_IE(respuestas"+preg+","+preg+")");
            miimgañadir.id='imgpreganadir'+preg;
            
            var embed = document.getElementById("mpl"+j);
            embed.setAttribute("id","mpl"+preg);
            embed.setAttribute("name","mpl"+preg);
            embed.setAttribute("flashvars","file=./mediaplayer/audios/audio_"+id_ejercicio+"_"+preg+".mp3&height=20&width=320");
            
            var a = document.getElementById("upload"+j);
            a.setAttribute("id","upload"+preg);
            a.setAttribute("href","javascript:cargaAudios_AudioTexto_AM('audio_"+id_ejercicio+"_"+preg+".mp3',"+preg+",'primera')");

            //Obtengo el numero de respuestas de la pregunta

            minumeroresp=document.getElementById('num_res_preg'+j);
            numresp=minumeroresp.value;
            //Actualizo las respuestas
            divrespuestas=document.getElementById('respuestas'+j);
            divrespuestas.id='respuestas'+preg;
            for(k=1;k<=parseInt(numresp);k++){

                //Las tables
                //alert("llega");
                tablarespuestas=document.getElementById("tablarespuesta"+k+"_"+j);
                tablarespuestas.id="tablarespuesta"+k+"_"+preg;
                //alert("ki tba");
                //los tr de las tables
                lostr=document.getElementById('trrespuesta'+k+"_"+j);
                lostr.id='trrespuesta'+k+"_"+preg;
                //alert("siiiiii");

                /*losinput=document.getElementById('id_crespuesta'+k+"_"+j);
                losinput.id='id_crespuesta'+k+"_"+preg;
                losinput.name='crespuesta'+k+"_"+preg;
                losinput.setAttribute("onclick","BotonRadio(crespuesta"+k+"_"+preg+")");*/


                //larespuesta=document.getElementById('respuesta'+k+"_"+j);
                //larespuesta.id='respuesta'+k+"_"+preg;
                //larespuesta.name='respuesta'+k+"_"+preg;

                //la imagen de eliminar

                laimageneliminar=document.getElementById('eliminarrespuesta'+k+"_"+j);
                laimageneliminar.id='eliminarrespuesta'+k+"_"+preg;
                laimageneliminar.setAttribute("onclick","EliminarRespuesta_IE(tablarespuesta"+k+"_"+preg+","+preg+")");
                
                var textarea = document.getElementById("respuesta"+k+"_"+j);
                textarea.setAttribute("id","respuesta"+k+"_"+preg);
                textarea.setAttribute("name","respuesta"+k+"_"+preg);
                
                //var trcorregir = document.getElementById("tdcorregir"+k+"_"+j);
                //trcorregir.setAttribute("id","tdcorregir"+k+"_"+preg);
                //el hidden de correcta
                /*hiddencorrecta=document.getElementById('valorcorrecta'+k+"_"+j);
                hiddencorrecta.id='valorcorrecta'+k+"_"+preg;
                hiddencorrecta.name='valorcorrecta'+k+"_"+preg;
                //La imagen de correcta
                laimagencorrecta=document.getElementById('correcta'+k+"_"+j);
                laimagencorrecta.id='correcta'+k+"_"+preg;
                laimagencorrecta.setAttribute("onclick","InvertirRespuesta(correcta"+k+"_"+preg+","+hiddencorrecta.value+")");*/

            }

            //alert("fin hijos");
            
            
            
            //Cambio el número de respuestas
            minumeroresp=document.getElementById('num_res_preg'+j);
            minumeroresp.id='num_res_preg'+preg;
            minumeroresp.name='num_res_preg'+preg;

            preg=preg+1;
        }
        //Llamar a un archivo php para cambiar los archivos de audio del disco de la misma forma que se cambian en esta funcion
            $.ajax({
                type: "POST",
                url: "borrapregunta.php?id_ejercicio=" + id_ejercicio + "&numpreg=" + numpregunta + "&totalPregs=" + (preg) + "&directorio=./mediaplayer/audios/&archivo=audio_&extension=.mp3",
                cache : false,
                success : function(response) {
                    //alert("Terminada con exito la llamada a borraaudio_pregunta.php");
                }
            });
        
    }else{
        alert("El ejercicio debe tener al menos una pregunta");
    }
}


/**
 * ************************* EJERCICIOS ASOCIACION MULTIPLE  VIDEO-TEXTO ************************************
 */
//Boton para actualizar los objetos de video de youtube automaticamente cuando se cambia la URL del video en los cuadros de
//texto en los ejercicios Video-Texto en Asociacion Multiple
function actualizar_VideoTexto_AM(id_ejercicio,numpreg) {
    //Obtenemos las etiquetas a modificar (param y embed) donde se encuentra el origen del video de Youtube
    //alert("Actualizando video: " + id_ejercicio + "," + numpreg);
    var param = document.getElementById("movie"+numpreg);
    //alert("Param: " + param);
    var embed = document.getElementById("embed"+numpreg);
    //alert("Embed: " + embed);
    
    var textarea = document.getElementById("archivovideo"+numpreg);
    var texto = textarea.value;
    //alert("Texto: " + texto);
    
    //Obtenemos la etiqueta object
    var obj = param.parentNode;
    var padre = obj.parentNode;
    
    
    //Con expresiones regulares obtener el codigo del video de youtube
    var regexp = /^http\:\/\/www\.youtube\.com\/watch\?v\=((\w|_|-))*$/;
    if (regexp.test(texto)) {
        //alert("Cumple la expresion regular");
        var codigo = texto.replace(/^http\:\/\/www\.youtube\.com\/watch\?v\=/,"");
        //alert("Codigo: " + codigo);
        param.setAttribute("value","http://www.youtube.com/v/"+codigo+"?hl=es_ES&version=3");
        embed.setAttribute("src","http://www.youtube.com/v/"+codigo+"?hl=es_ES&version=3");
        //Guardamos todos el codigo de object, incluyendo los hijos (param y embed)
        var htmlbkp = obj.innerHTML;
        
        //Eliminamos y volvemos a insertar para que se vuelva a cargar el video.
        //Esto se debe a que no se carga el video si solo se modifica los parametros, hay que eliminar el nodo y volver a insertarlo.
        
        padre.removeChild(obj);
        obj = document.createElement("object");
        obj.innerHTML=htmlbkp;
        padre.insertBefore(obj,padre.childNodes[0]);        
    }
    else {
        alert("No cumple la expresion regular");
    }
}

//Boton de añadir una nueva pregunta para ejercicios Video-Texto en Asociacion Multiple
function botonMasPreguntas_VideoTexto_AM(id_ejercicio) {
    //alert("añadiendo pregunta");

    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;
    //alert("numero actual es"+ numeropreguntas);
    anterior=document.getElementById('num_res_preg'+ numeropreguntas);
    //alert(anterior.id);
    numeropreguntas= parseInt(numeropreguntas) +1;
    divnumpreguntas.value=numeropreguntas;
    //alert("llega");
    nuevodiv = document.createElement('div');
    //alert("aki tb llega");
    nuevodiv.id= "tabpregunta"+numeropreguntas;
    //Creo un nuevo hijo a la tabla general para la pregunta
    //alert("si");
    var br = document.createElement('br');
    var br1 = document.createElement('br');
    var br2 = document.createElement('br');
    tablapreg = document.createElement('table');
    tablapreg.style.width="100%";

    body= document.createElement('tbody');
    nuevotr=document.createElement('tr');

    body.appendChild(nuevotr);
    nuevotd=document.createElement('td');
    nuevotd.style.width="80%";
    
    var divpreg = createElement("div",{style:"width:900px;", class:"pregunta",
                                       name: "pregunta"+numeropreguntas, id:"pregunta"+numeropreguntas});
    nuevotd.appendChild(divpreg);
    var div_obj = createElement("div",{style:"margin: 0 auto; margin-left: auto; margin-right: auto; width:396px;"});
    divpreg.appendChild(div_obj);
    
    var obj = createElement("object",{width:"396", height:"197"});
    div_obj.appendChild(obj);
    var param1 = createElement("param",{id:"movie"+numeropreguntas,name:"movie"+numeropreguntas,
                                        value:""});
    obj.appendChild(param1);
    var param2 = createElement("param",{name:"allowFullScreen",value:"true"});
    obj.appendChild(param2);
    var param3 = createElement("param",{name:"allowscriptaccess",value:"always"});
    obj.appendChild(param3);
    var embed = createElement("embed",{id:"embed"+numeropreguntas, src:"", type:"application/x-shockwave-flash",
                                       width:"396",height:"197",allowscriptaccess:"always",allowfullscreen:"true"});
    obj.appendChild(embed);
    
    var div_text = createElement("div",{style:"margin: 0 auto; margin-left: auto; margin-right: auto; width:396px;"});
    divpreg.appendChild(div_text);
    var textarea = createElement("textarea",{class:"video1",name:"archivovideo"+numeropreguntas,
                                             id:"archivovideo"+numeropreguntas, onchange:"actualizar_VideoTexto_AM("+id_ejercicio+","+numeropreguntas+")"});
    textarea.appendChild(document.createTextNode("Introduzca URL de video de Youtube..."));
    div_text.appendChild(textarea);
    
    nuevotd1=document.createElement('td');
    nuevotd1.style.width="5%";
    imgborrar=document.createElement('img');
    imgborrar.id="imgpregborrar"+numeropreguntas;
    imgborrar.src="./imagenes/delete.gif";
    imgborrar.alt="eliminar respuesta";
    imgborrar.style.height="10px";
    imgborrar.style.width="10px";
    imgborrar.setAttribute('onclick',"EliminarPregunta_AudioTexto_AM("+id_ejercicio+",tabpregunta"+numeropreguntas+","+numeropreguntas+")");
    imgborrar.title="Eliminar Pregunta";

    //

    //icono de borrar pregunta
    nuevotd1.appendChild(imgborrar);
    nuevotd1.appendChild(br);

    //Creación imagen añadir

    imgañadir=document.createElement('img');
    imgañadir.id="imgpreganadir"+numeropreguntas ;
    imgañadir.src="./imagenes/añadir.gif";
    imgañadir.alt="añadir respuesta";
    imgañadir.style.height="15px";
    imgañadir.style.width="15px";
    imgañadir.setAttribute('onclick',"anadirRespuesta_IE(respuestas"+numeropreguntas+","+numeropreguntas+")");
    imgañadir.title="Añadir Pregunta";

    nuevotd1.appendChild(imgañadir);
    nuevotr.appendChild(nuevotd);
    nuevotr.appendChild(nuevotd1);
    tablapreg.appendChild(body);
    //le añado sus br
    nuevodiv.appendChild(br);
    nuevodiv.appendChild(br1);
    nuevodiv.appendChild(br2);
    nuevodiv.appendChild(tablapreg);
    nuevodiv.appendChild(br);

    //div de respuestas


    divrespuesta=document.createElement('div');
    divrespuesta.id="respuestas"+numeropreguntas;
    divrespuesta.setAttribute('class',"respuesta");

      

    nuevodiv.appendChild(divrespuesta);

         

    //lo inserto despues de anterior
    insertAfter(anterior,nuevodiv);


    //<input type="hidden" value="1" id="num_res_preg3" name="num_res_preg3

    nuevoinput=document.createElement('input');
    nuevoinput.type="hidden";
    nuevoinput.value="0";
    nuevoinput.id="num_res_preg"+numeropreguntas;
    nuevoinput.name="num_res_preg"+numeropreguntas;

    //añado el numero de respuestas de la nueva pregunta
    insertAfter(nuevodiv,nuevoinput)

    //alert("fin");

}

//Boton de eliminar pregunta para los ejercicios Video-Texto en Asociacion Multiple
function EliminarPregunta_VideoTexto_AM(id_ejercicio,Pregunta,numpregunta){

    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;

    //Compruebo que al menos hay una pregunta

    if(parseInt(numeropreguntas)>1){
        padre=Pregunta.parentNode;
        padre.removeChild(Pregunta.nextSibling);
        padre.removeChild(Pregunta);

        //le quieto uno al número de preguntas


        numeropreguntas= parseInt(numeropreguntas) - 1;
        divnumpreguntas.value=numeropreguntas;

        siguientepreg= parseInt(numpregunta)+1;
        //Actualizo el resto de pregunta
        //alert(siguientepreg);
        preg=parseInt(numpregunta);
        //alert("preg"+preg);
        for(j=siguientepreg;j<=numeropreguntas+1;j++){
            //alert('tabpregunta'+j);
            mitabla=document.getElementById('tabpregunta'+j);
            mitabla.id='tabpregunta'+preg;

            mitextarea=document.getElementById('pregunta'+j);
            mitextarea.id='pregunta'+preg;
            mitextarea.setAttribute("name","pregunta"+preg);

            miimgborrar=document.getElementById('imgpregborrar'+j);
            miimgborrar.setAttribute("onclick","EliminarPregunta_VideoTexto_AM("+id_ejercicio+",tabpregunta"+preg+","+preg+")");
            miimgborrar.id='imgpregborrar'+preg;

            miimgañadir=document.getElementById('imgpreganadir'+j);
            miimgañadir.setAttribute("onclick","anadirRespuesta_IE(respuestas"+preg+","+preg+")");
            miimgañadir.id='imgpreganadir'+preg;
            
            var param1 = document.getElementById("movie"+j);
            param1.setAttribute("id","movie"+preg);
            param1.setAttribute("name","movie"+preg);
            var embed = document.getElementById("embed"+j);
            embed.setAttribute("id","embed"+preg);
            var textarea = document.getElementById("archivovideo"+j);
            textarea.setAttribute("id","archivovideo"+preg);
            textarea.setAttribute("name","archivovideo"+preg);
            textarea.setAttribute("onchange","actualizar_VideoTexto_AM("+id_ejercicio+","+preg+")");

            //Obtengo el numero de respuestas de la pregunta

            minumeroresp=document.getElementById('num_res_preg'+j);
            numresp=minumeroresp.value;
            //Actualizo las respuestas
            divrespuestas=document.getElementById('respuestas'+j);
            divrespuestas.id='respuestas'+preg;
            for(k=1;k<=parseInt(numresp);k++){

                //Las tables
                //alert("llega");
                tablarespuestas=document.getElementById("tablarespuesta"+k+"_"+j);
                tablarespuestas.id="tablarespuesta"+k+"_"+preg;
                //alert("ki tba");
                //los tr de las tables
                lostr=document.getElementById('trrespuesta'+k+"_"+j);
                lostr.id='trrespuesta'+k+"_"+preg;
                //alert("siiiiii");

                /*losinput=document.getElementById('id_crespuesta'+k+"_"+j);
                losinput.id='id_crespuesta'+k+"_"+preg;
                losinput.name='crespuesta'+k+"_"+preg;
                losinput.setAttribute("onclick","BotonRadio(crespuesta"+k+"_"+preg+")");*/


                //larespuesta=document.getElementById('respuesta'+k+"_"+j);
                //larespuesta.id='respuesta'+k+"_"+preg;
                //larespuesta.name='respuesta'+k+"_"+preg;

                //la imagen de eliminar

                laimageneliminar=document.getElementById('eliminarrespuesta'+k+"_"+j);
                laimageneliminar.id='eliminarrespuesta'+k+"_"+preg;
                laimageneliminar.setAttribute("onclick","EliminarRespuesta_IE(tablarespuesta"+k+"_"+preg+","+preg+")");
                
                var textarea = document.getElementById("respuesta"+k+"_"+j);
                textarea.setAttribute("id","respuesta"+k+"_"+preg);
                textarea.setAttribute("name","respuesta"+k+"_"+preg);
                
                //var trcorregir = document.getElementById("tdcorregir"+k+"_"+j);
                //trcorregir.setAttribute("id","tdcorregir"+k+"_"+preg);
                //el hidden de correcta
                /*hiddencorrecta=document.getElementById('valorcorrecta'+k+"_"+j);
                hiddencorrecta.id='valorcorrecta'+k+"_"+preg;
                hiddencorrecta.name='valorcorrecta'+k+"_"+preg;
                //La imagen de correcta
                laimagencorrecta=document.getElementById('correcta'+k+"_"+j);
                laimagencorrecta.id='correcta'+k+"_"+preg;
                laimagencorrecta.setAttribute("onclick","InvertirRespuesta(correcta"+k+"_"+preg+","+hiddencorrecta.value+")");*/

            }

            //alert("fin hijos");
            
            
            
            //Cambio el número de respuestas
            minumeroresp=document.getElementById('num_res_preg'+j);
            minumeroresp.id='num_res_preg'+preg;
            minumeroresp.name='num_res_preg'+preg;

            preg=preg+1;
        }
        
    }else{
        alert("El ejercicio debe tener al menos una pregunta");
    }
}


/**
 * ************************* EJERCICIOS ASOCIACION MULTIPLE  IMAGEN-TEXTO ************************************
 */
//Carga las imagenes de los ejercicios Imagen-Texto en Asociacion Multiple
function cargaImagenes_FotoTexto_AM(elnombre,i,j){
    //alert("AAAAAAAA" + i);
    var text = 'upload' + i;
    //alert("id: " + text);
    var button = document.getElementById(text);
    //alert("el nombre  " + elnombre);
    //alert("Button: " + button);
    //alert("Button node type: " + button.nodeType);
    //alert("!Button: " + !button);
    if (j == 'primera') {
        button.childNodes[0].nodeValue = 'Pulse aqui';
    }
    // var elnombre="aaa";
    new AjaxUpload(button, {
        action: 'procesa.php?nombre=' + elnombre,
        name: 'image',
        autoSubmit: true,
        onSubmit: function(file, ext) {
            //alert("Cargandoooo foto");
            // cambiar el texto del boton cuando se selecicione la imagen
            button.childNodes[0].nodeValue = 'Subiendo';
            // desabilitar el boton
            this.disable();

            interval = window.setInterval(function() {
                var text = button.childNodes[0].nodeValue;
                if (text.length < 11) {
                    button.childNodes[0].nodeValue = text + '.';
                } else {
                    button.childNodes[0].nodeValue = 'Subiendo';
                }
            }, 200);
        },
        onComplete: function(file, response) {
            //alert("completado");
            button.childNodes[0].nodeValue = 'Cambiar Foto';

            window.clearInterval(interval);

            // Habilitar boton otra vez
            this.enable();
            
            var img = document.getElementById("img_pregunta"+i);
            var padre = img.parentNode;
            padre.removeChild(img);
            
            
            img = createElement("img",{style:"height: 192px; width: 401px;",
                                       id:"img_pregunta"+i,name:"img_pregunta"+i,
                                       src:"./imagenes/"+elnombre});
            padre.appendChild(img);

        }
        //Tengo que cambiar la foto
    });
}

//Boton para añadir una pregunta a los ejercicios Imagen-Texto en Asociacion Multiple
function botonMasPreguntas_FotoTexto_AM(id_ejercicio) {
    //alert("añadiendo pregunta");

    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;
    //alert("numero actual es"+ numeropreguntas);
    anterior=document.getElementById('num_res_preg'+ numeropreguntas);
    //alert(anterior.id);
    numeropreguntas= parseInt(numeropreguntas) +1;
    divnumpreguntas.value=numeropreguntas;
    //alert("llega");
    nuevodiv = document.createElement('div');
    //alert("aki tb llega");
    nuevodiv.id= "tabpregunta"+numeropreguntas;
    //Creo un nuevo hijo a la tabla general para la pregunta
    //alert("si");
    var br = document.createElement('br');
    var br1 = document.createElement('br');
    var br2 = document.createElement('br');
    tablapreg = document.createElement('table');
    tablapreg.style.width="100%";

    body= document.createElement('tbody');
    nuevotr=document.createElement('tr');

    body.appendChild(nuevotr);
    nuevotd=document.createElement('td');
    nuevotd.style.width="80%";
    
    var divpreg = createElement("div",{style:"width:900px;", class:"pregunta",
                                       name: "pregunta"+numeropreguntas, id:"pregunta"+numeropreguntas});
    nuevotd.appendChild(divpreg);
    var div_a = createElement("div",{style:"margin: 0 auto; margin-left: auto; margin-right: auto; width:320px;",
                                     id:"capa1"});
    divpreg.appendChild(div_a);
    var a = createElement("a",{href:"javascript:cargaImagenes_FotoTexto_AM('foto_"+id_ejercicio+"_"+numeropreguntas+".jpg',"+numeropreguntas+",'primera')",
                                id:"upload"+numeropreguntas, class:"up"});
    a.appendChild(document.createTextNode("Cambiar Foto"));
    div_a.appendChild(a);
    
    var div_img = createElement("div",{style:"margin: 0 auto; margin-left: auto; margin-right: auto; width:320px;",
                                        id:"capa2"});
    divpreg.appendChild(div_img);
    var img = createElement("img",{style:"height: 192px; width: 401px;",
                                    id:"img_pregunta"+numeropreguntas,name:"img_pregunta"+numeropreguntas,
                                    src:"./imagenes/foto_"+id_ejercicio+"_"+numeropreguntas+".jpg"});
    div_img.appendChild(img);
    
    nuevotd1=document.createElement('td');
    nuevotd1.style.width="5%";
    imgborrar=document.createElement('img');
    imgborrar.id="imgpregborrar"+numeropreguntas;
    imgborrar.src="./imagenes/delete.gif";
    imgborrar.alt="eliminar respuesta";
    imgborrar.style.height="10px";
    imgborrar.style.width="10px";
    imgborrar.setAttribute('onclick',"EliminarPregunta_FotoTexto_AM("+id_ejercicio+",tabpregunta"+numeropreguntas+","+numeropreguntas+")");
    imgborrar.title="Eliminar Pregunta";

    //

    //icono de borrar pregunta
    nuevotd1.appendChild(imgborrar);
    nuevotd1.appendChild(br);

    //Creación imagen añadir

    imgañadir=document.createElement('img');
    imgañadir.id="imgpreganadir"+numeropreguntas ;
    imgañadir.src="./imagenes/añadir.gif";
    imgañadir.alt="añadir respuesta";
    imgañadir.style.height="15px";
    imgañadir.style.width="15px";
    imgañadir.setAttribute('onclick',"anadirRespuesta_IE(respuestas"+numeropreguntas+","+numeropreguntas+")");
    imgañadir.title="Añadir Pregunta";

    nuevotd1.appendChild(imgañadir);
    nuevotr.appendChild(nuevotd);
    nuevotr.appendChild(nuevotd1);
    tablapreg.appendChild(body);
    //le añado sus br
    nuevodiv.appendChild(br);
    nuevodiv.appendChild(br1);
    nuevodiv.appendChild(br2);
    nuevodiv.appendChild(tablapreg);
    nuevodiv.appendChild(br);

    //div de respuestas


    divrespuesta=document.createElement('div');
    divrespuesta.id="respuestas"+numeropreguntas;
    divrespuesta.setAttribute('class',"respuesta");

      

    nuevodiv.appendChild(divrespuesta);

         

    //lo inserto despues de anterior
    insertAfter(anterior,nuevodiv);


    //<input type="hidden" value="1" id="num_res_preg3" name="num_res_preg3

    nuevoinput=document.createElement('input');
    nuevoinput.type="hidden";
    nuevoinput.value="0";
    nuevoinput.id="num_res_preg"+numeropreguntas;
    nuevoinput.name="num_res_preg"+numeropreguntas;

    //añado el numero de respuestas de la nueva pregunta
    insertAfter(nuevodiv,nuevoinput)

    //alert("fin");

}

//Boton para eliminar una pregunta en ejercicios Imagen-Texto en Asociacion Multiple
function EliminarPregunta_FotoTexto_AM(id_ejercicio,Pregunta,numpregunta){

    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;

    //Compruebo que al menos hay una pregunta

    if(parseInt(numeropreguntas)>1){
        padre=Pregunta.parentNode;
        padre.removeChild(Pregunta.nextSibling);
        padre.removeChild(Pregunta);

        //le quieto uno al número de preguntas


        numeropreguntas= parseInt(numeropreguntas) - 1;
        divnumpreguntas.value=numeropreguntas;

        siguientepreg= parseInt(numpregunta)+1;
        //Actualizo el resto de pregunta
        //alert(siguientepreg);
        preg=parseInt(numpregunta);
        //alert("preg"+preg);
        for(j=siguientepreg;j<=numeropreguntas+1;j++){
            //alert('tabpregunta'+j);
            mitabla=document.getElementById('tabpregunta'+j);
            mitabla.id='tabpregunta'+preg;

            mitextarea=document.getElementById('pregunta'+j);
            mitextarea.id='pregunta'+preg;
            mitextarea.setAttribute("name","pregunta"+preg);

            miimgborrar=document.getElementById('imgpregborrar'+j);
            miimgborrar.setAttribute("onclick","EliminarPregunta_FotoTexto_AM("+id_ejercicio+",tabpregunta"+preg+","+preg+")");
            miimgborrar.id='imgpregborrar'+preg;

            miimgañadir=document.getElementById('imgpreganadir'+j);
            miimgañadir.setAttribute("onclick","anadirRespuesta_IE(respuestas"+preg+","+preg+")");
            miimgañadir.id='imgpreganadir'+preg;
            
            var a = document.getElementById("upload"+j);
            a.setAttribute("id","upload"+preg);
            a.setAttribute("href","javascript:cargaImagenes_FotoTexto_AM('foto_"+id_ejercicio+"_"+preg+".jpg',"+preg+",'primera')");
            
            var img = document.getElementById("img_pregunta"+j);
            img.setAttribute("id","img_pregunta"+preg);
            img.setAttribute("name","img_pregunta"+preg);
            img.setAttribute("src","./imagenes/foto_"+id_ejercicio+"_"+preg+".jpg");
            

            //Obtengo el numero de respuestas de la pregunta

            minumeroresp=document.getElementById('num_res_preg'+j);
            numresp=minumeroresp.value;
            //Actualizo las respuestas
            divrespuestas=document.getElementById('respuestas'+j);
            divrespuestas.id='respuestas'+preg;
            for(k=1;k<=parseInt(numresp);k++){

                //Las tables
                //alert("llega");
                tablarespuestas=document.getElementById("tablarespuesta"+k+"_"+j);
                tablarespuestas.id="tablarespuesta"+k+"_"+preg;
                //alert("ki tba");
                //los tr de las tables
                lostr=document.getElementById('trrespuesta'+k+"_"+j);
                lostr.id='trrespuesta'+k+"_"+preg;
                //alert("siiiiii");

                /*losinput=document.getElementById('id_crespuesta'+k+"_"+j);
                losinput.id='id_crespuesta'+k+"_"+preg;
                losinput.name='crespuesta'+k+"_"+preg;
                losinput.setAttribute("onclick","BotonRadio(crespuesta"+k+"_"+preg+")");*/


                //larespuesta=document.getElementById('respuesta'+k+"_"+j);
                //larespuesta.id='respuesta'+k+"_"+preg;
                //larespuesta.name='respuesta'+k+"_"+preg;

                //la imagen de eliminar

                laimageneliminar=document.getElementById('eliminarrespuesta'+k+"_"+j);
                laimageneliminar.id='eliminarrespuesta'+k+"_"+preg;
                laimageneliminar.setAttribute("onclick","EliminarRespuesta_IE(tablarespuesta"+k+"_"+preg+","+preg+")");
                
                var textarea = document.getElementById("respuesta"+k+"_"+j);
                textarea.setAttribute("id","respuesta"+k+"_"+preg);
                textarea.setAttribute("name","respuesta"+k+"_"+preg);
                
                //var trcorregir = document.getElementById("tdcorregir"+k+"_"+j);
                //trcorregir.setAttribute("id","tdcorregir"+k+"_"+preg);
                //el hidden de correcta
                /*hiddencorrecta=document.getElementById('valorcorrecta'+k+"_"+j);
                hiddencorrecta.id='valorcorrecta'+k+"_"+preg;
                hiddencorrecta.name='valorcorrecta'+k+"_"+preg;
                //La imagen de correcta
                laimagencorrecta=document.getElementById('correcta'+k+"_"+j);
                laimagencorrecta.id='correcta'+k+"_"+preg;
                laimagencorrecta.setAttribute("onclick","InvertirRespuesta(correcta"+k+"_"+preg+","+hiddencorrecta.value+")");*/

            }

            //alert("fin hijos");
            
            
            
            //Cambio el número de respuestas
            minumeroresp=document.getElementById('num_res_preg'+j);
            minumeroresp.id='num_res_preg'+preg;
            minumeroresp.name='num_res_preg'+preg;

            preg=preg+1;
        }
        //Llamar a un archivo php para cambiar los archivos de audio del disco de la misma forma que se cambian en esta funcion
            $.ajax({
                type: "POST",
                url: "borrapregunta.php?id_ejercicio=" + id_ejercicio + "&numpreg=" + numpregunta + "&totalPregs=" + (preg) + "&directorio=./imagenes/&archivo=foto_&extension=.jpg",
                cache : false,
                success : function(response) {
                    //alert("Terminada con exito la llamada a borrapregunta.php");
                }
            });
        
    }else{
        alert("El ejercicio debe tener al menos una pregunta");
    }
}


/**
 * **************************  EJERCICIOS --  TEXTO HUECO *********************************
 */


//----------------- PLUGIN PARA REEMPLAZAR TEXTO SELECCIONADO --------------------
//Funcion que devuelve un array asociativo con la posicion de inicio y de fin del texto seleccionado
function getInputSelection(el) {
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

//Reemplaza el texto seleccionado del elemento el por el texto dado en text
function replaceSelectedText(el, text) {
    var sel = getInputSelection(el), val = el.value;
    el.value = val.slice(0, sel.start) + text + val.slice(sel.end);
}

//Devuelve el texto seleccionado del elemento el
function getSelectedText(el) {
    var sel = getInputSelection(el);
    return el.value.slice(sel.start,sel.end);
}
//-------------------------------------------------------------------------------------



//Boton para añadir una palabra hueco de un trozo de palabra seleccionada de un cuadro de texto
function TH_addHueco_Creacion(id_ejercicio,numpreg) {
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

//Boton para añadir una palabra hueco de un trozo de palabra seleccionada de un cuadro de texto
function TH_addHueco_Modificar(id_ejercicio,numpreg) {
    var textarea = document.getElementById("pregunta"+numpreg); //Cojo el textarea
    var numresp = parseInt(document.getElementById("num_res_preg"+numpreg).value)+1;
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
    
    
    var div_respuestas = document.getElementById("respuestas"+numpreg);   
    var table = document.createElement("table");
    var tr = document.createElement("tr");             
    table.width="50%";
    table.id="tablarespuesta"+numresp+"_"+numpreg;
    if (numresp%2==0) {
        var tablaAnterior = document.getElementById("tablarespuesta"+(numresp-1)+"_"+numpreg);
        tablaAnterior.style.cssFloat="left";
    }        
    var tbody = document.createElement("tbody");          
    tr.id="trrespuesta"+numresp+"_"+numpreg;
    var td = document.createElement("td");
    td.style.width="80%";
    var div = document.createElement("textarea");
    div.style.width="300px";
    div.setAttribute("class","resp");
    div.setAttribute("readonly","yes");
    div.name="respuesta"+numresp+"_"+numpreg;
    div.id="respuesta"+numresp+"_"+numpreg;
    var text = document.createTextNode(texto_sel);
           
    div.appendChild(text);
            
    var td2 = document.createElement("td");
    td2.style.width="5%"
         
         
    var img= document.createElement("img");
    img.id="eliminarrespuesta"+numresp+"_"+numpreg;
    img.src="./imagenes/delete.gif";
    img.style.height="10px";
    img.style.width="10px";
    img.setAttribute("onclick","TH_EliminarHueco("+id_ejercicio+","+numpreg+","+numresp+")");
    img.title="Eliminar Hueco";
            
            
    
    td2.appendChild(img);
    td.appendChild(div);
    tr.appendChild(document.createTextNode(""));
    tr.appendChild(td);
    tr.appendChild(document.createTextNode(""));
    tr.appendChild(td2);
    tbody.appendChild(tr);
    table.appendChild(tbody);
            
    div_respuestas.appendChild(table);
    div_respuestas.appendChild(document.createTextNode(""));
    
    
    
    replaceSelectedText(textarea,"[["+(numresp-1)+"]]");
    var numero_respuestas = document.getElementById("num_res_preg"+numpreg);
    numero_respuestas.value = (numresp);
}

//Boton para eliminar un hueco de un ejercicio Texto-Hueco
function TH_EliminarHueco(id_ejercicio,numpreg,numresp) {
    var ta = document.getElementById("respuesta"+numresp+"_"+numpreg);
    var texto_resp = ta.value;
    var hueco = "[["+(numresp-1)+"]]";
    
    var ta_preg = document.getElementById("pregunta"+numpreg);
    ta_preg.value = ta_preg.value.replace(hueco,texto_resp);
    var tabla = document.getElementById("tablarespuesta"+numresp+"_"+numpreg);
    
    var total_resp = parseInt(document.getElementById("num_res_preg"+numpreg).value);
    for (var k=numresp; k<=total_resp; k++) {
        ta_preg.value = ta_preg.value.replace("[["+(k-1)+"]]","[["+(k-2)+"]]");
    }
    
    EliminarRespuesta_IE(tabla,numpreg);
    
    var total_resp = parseInt(document.getElementById("num_res_preg"+numpreg).value);
    for (var k=1; k<=total_resp; k++) {
        var img = document.getElementById("eliminarrespuesta"+k+"_"+numpreg);
        img.setAttribute("onclick","TH_EliminarHueco("+id_ejercicio+","+numpreg+","+k+")");
        
    }
}

//Boton para añadir una pregunta a un ejercicio Texto Hueco
function TH_AddPregunta(id_ejercicio) {
    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;
    //alert("numero actual es"+ numeropreguntas);
    anterior=document.getElementById('num_res_preg'+ numeropreguntas);
    //alert(anterior.id);
    numeropreguntas= parseInt(numeropreguntas) +1;
    divnumpreguntas.value=numeropreguntas;
    //alert("llega");
    nuevodiv = document.createElement('div');
    //alert("aki tb llega");
    nuevodiv.id= "tabpregunta"+numeropreguntas;
    //Creo un nuevo hijo a la tabla general para la pregunta
    //alert("si");
    var br = document.createElement('br');
    var br1 = document.createElement('br');
    var br2 = document.createElement('br');
    tablapreg = document.createElement('table');
    tablapreg.style.width="100%";

    body= document.createElement('tbody');
    nuevotr=document.createElement('tr');

    body.appendChild(nuevotr);
    nuevotd=document.createElement('td');
    nuevotd.style.width="80%";
    textareapreg=document.createElement('textarea');
    textareapreg.style.width="900px";
    textareapreg.setAttribute('class', 'pregunta');
    textareapreg.name="pregunta"+numeropreguntas;
    textareapreg.id="pregunta"+numeropreguntas;
    //Añado el textarea de la prgunta
    nuevotd.appendChild(textareapreg);

    nuevotd1=document.createElement('td');
    nuevotd1.style.width="5%";
    imgborrar=document.createElement('img');
    imgborrar.id="imgpregborrar"+numeropreguntas ;
    imgborrar.src="./imagenes/delete.gif";
    imgborrar.alt="eliminar respuesta";
    imgborrar.style.height="10px";
    imgborrar.style.width="10px";
    imgborrar.setAttribute('onclick',"TH_DelPregunta("+id_ejercicio+","+numeropreguntas+")");
    imgborrar.title="Eliminar Pregunta";

    //

    //icono de borrar pregunta
    nuevotd1.appendChild(imgborrar);
    nuevotd1.appendChild(br);

    //Creación imagen añadir

    imgañadir=document.createElement('img');
    imgañadir.id="imgpreganadir"+numeropreguntas ;
    imgañadir.src="./imagenes/añadir.gif";
    imgañadir.alt="añadir respuesta";
    imgañadir.style.height="15px";
    imgañadir.style.width="15px";
    imgañadir.setAttribute('onclick',"TH_addHueco_Modificar("+id_ejercicio+","+numeropreguntas+")");
    imgañadir.title="Añadir Pregunta";

    nuevotd1.appendChild(imgañadir);
    nuevotr.appendChild(nuevotd);
    nuevotr.appendChild(nuevotd1);
    tablapreg.appendChild(body);
    //le añado sus br
    nuevodiv.appendChild(br);
    nuevodiv.appendChild(br1);
    nuevodiv.appendChild(br2);
    nuevodiv.appendChild(tablapreg);
    nuevodiv.appendChild(br);

    //div de respuestas


    divrespuesta=document.createElement('div');
    divrespuesta.id="respuestas"+numeropreguntas;
    divrespuesta.setAttribute('class',"respuesta");

      

    nuevodiv.appendChild(divrespuesta);

         

    //lo inserto despues de anterior
    insertAfter(anterior,nuevodiv);


    //<input type="hidden" value="1" id="num_res_preg3" name="num_res_preg3

    nuevoinput=document.createElement('input');
    nuevoinput.type="hidden";
    nuevoinput.value="0";
    nuevoinput.id="num_res_preg"+numeropreguntas;
    nuevoinput.name="num_res_preg"+numeropreguntas;

    //añado el numero de respuestas de la nueva pregunta
    insertAfter(nuevodiv,nuevoinput)

    //alert("fin");
}

//Boton para eliminar una pregunta a un ejercicio Texto Hueco
function TH_DelPregunta(id_ejercicio,numpreg) {
    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;
    
    var Pregunta = document.getElementById("tabpregunta"+numpreg);

    //Compruebo que al menos hay una pregunta

    if(parseInt(numeropreguntas)>1){
        padre=Pregunta.parentNode;
        padre.removeChild(Pregunta.nextSibling);
        padre.removeChild(Pregunta);

        //le quieto uno al número de preguntas


        numeropreguntas= parseInt(numeropreguntas) - 1;
        divnumpreguntas.value=numeropreguntas;

        siguientepreg= parseInt(numpreg)+1;
        //Actualizo el resto de pregunta
        //alert(siguientepreg);
        preg=parseInt(numpreg);
        //alert("preg"+preg);
        for(j=siguientepreg;j<=numeropreguntas+1;j++){
            //alert('tabpregunta'+j);
            mitabla=document.getElementById('tabpregunta'+j);
            mitabla.id='tabpregunta'+preg;

            mitextarea=document.getElementById('pregunta'+j);
            mitextarea.id='pregunta'+preg;
            mitextarea.name='pregunta'+preg;

            miimgborrar=document.getElementById('imgpregborrar'+j);
            miimgborrar.setAttribute("onclick","TH_DelPregunta("+id_ejercicio+","+preg+")");
            miimgborrar.id='imgpregborrar'+preg;

            miimgañadir=document.getElementById('imgpreganadir'+j);
            miimgañadir.setAttribute("onclick","TH_addHueco_Modificar("+id_ejercicio+","+preg+")");
            miimgañadir.id='imgpreganadir'+preg;

            //Obtengo el numero de respuestas de la pregunta

            minumeroresp=document.getElementById('num_res_preg'+j);
            numresp=minumeroresp.value;
            //Actualizo las respuestas
            divrespuestas=document.getElementById('respuestas'+j);
            divrespuestas.id='respuestas'+preg;
            for(k=1;k<=parseInt(numresp);k++){

                //Las tables
                //alert("llega");
                tablarespuestas=document.getElementById("tablarespuesta"+k+"_"+j);
                tablarespuestas.id="tablarespuesta"+k+"_"+preg;
                //alert("ki tba");
                //los tr de las tables
                lostr=document.getElementById('trrespuesta'+k+"_"+j);
                lostr.id='trrespuesta'+k+"_"+preg;
                //alert("siiiiii");

                


                larespuesta=document.getElementById('respuesta'+k+"_"+j);
                larespuesta.id='respuesta'+k+"_"+preg;
                larespuesta.name='respuesta'+k+"_"+preg;

                //la imagen de eliminar

                laimageneliminar=document.getElementById('eliminarrespuesta'+k+"_"+j);
                laimageneliminar.id='eliminarrespuesta'+k+"_"+preg;
                laimageneliminar.setAttribute("onclick","TH_EliminarHueco("+id_ejercicio+","+preg+","+k+")");

                

            }

            //alert("fin hijos");
            //Cambio el número de respuestas
            minumeroresp=document.getElementById('num_res_preg'+j);
            minumeroresp.id='num_res_preg'+preg;
            minumeroresp.name='num_res_preg'+preg;

            preg=preg+1;
        }
        
    }else{
        alert("El ejercicio debe tener al menos una pregunta");
    }
}

//Boton para corregir un ejercicio de Texto Hueco
function TH_Corregir(id_ejercicio,mostrar_soluciones) {
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


/**
 *
 * **************************  EJERCICIOS --  ORDENAR ELEMENTOS *********************************
 */
//Boton para añadir una palabra de un ejercicio Ordenar Elementos en el segundo formulario de Creacion
function OE_AddPalabra_Creacion(id_ejercicio,numpreg) {
    var textarea = document.getElementById("id_pregunta"+numpreg); //Cojo el textarea
    var numresp = parseInt(document.getElementById("num_resp_"+numpreg).value);
    var texto_sel = getSelectedText(textarea);
    var sel = getInputSelection(textarea);
    
    //Comprobar que no se haya seleccionado una cadena vacia
    if (texto_sel==="") {
        alert("No se puede crear una asociacion de orden vacia. Escriba algo de texto y seleccione para crear una asociacion de orden.");
        return;
    }
    
    
    var tbody = document.getElementById("tbody_"+numpreg);
    var n_tr = createElement("tr",{});
    
    var td_label = createElement("td",{});
    var label = createElement("label",{id:"label_resp_"+(numresp+1)+"_"+numpreg, for:"respuesta"+(numresp+1)+"_"+numpreg});
    label.appendChild(document.createTextNode((numresp+1)+"."));
    td_label.appendChild(label);
    n_tr.appendChild(td_label);
    
    var td_resp = createElement("td",{style: "padding-left:130px;"});
    
    
    var resp = createElement("textarea",{name: "respuesta"+(numresp+1)+"_"+numpreg, id: "respuesta"+(numresp+1)+"_"+ numpreg,
                                         rows:"1", cols:"50",readonly:"yes", value:texto_sel});
    resp.appendChild(document.createTextNode(texto_sel));
    
    var td3 = createElement("td",{});
    var img_delresp = createElement("img",{id:"del_resp_"+(numresp+1)+"_"+numpreg, name:"del_resp_"+(numresp+1)+"_"+numpreg,
                                           src:"./imagenes/delete.gif", onclick: "OE_delPalabra_Creacion("+id_ejercicio+","+numpreg+","+(numresp+1)+")"});
    td3.appendChild(img_delresp);
                                       
    
    td_resp.appendChild(resp);
    n_tr.appendChild(td_resp);
    n_tr.appendChild(td3);
    
    tbody.appendChild(n_tr);
    
    
    var numero_respuestas = document.getElementById("num_resp_"+numpreg);
    numero_respuestas.value = (numresp+1);
}

//Boton para eliminar una respuesta de un ejercicio de Ordenar Elementos
function OE_delPalabra_Creacion(id_ejercicio, numpreg, numresp) {
    var input_resp = document.getElementById("num_resp_"+numpreg);
    var totalresp = parseInt(input_resp.value);
    
    var texta = document.getElementById("respuesta"+numresp+"_"+numpreg);
    var tr = texta.parentNode.parentNode;
    var tbody = tr.parentNode;
    tbody.removeChild(tr);
    
    for (var k=numresp+1; k<=totalresp; k++) {
        var texta = document.getElementById("respuesta"+k+"_"+numpreg);
        texta.setAttribute("id","respuesta"+(k-1)+"_"+numpreg);
        texta.setAttribute("name","respuesta"+(k-1)+"_"+numpreg);
        var img = document.getElementById("del_resp_"+k+"_"+numpreg);
        img.setAttribute("id","del_resp_"+(k-1)+"_"+numpreg);
        img.setAttribute("name","del_resp_"+(k-1)+"_"+numpreg);
        img.setAttribute("onclick","OE_delPalabra_Creacion("+id_ejercicio+","+numpreg+","+(k-1)+")");
        var label = document.getElementById("label_resp_"+k+"_"+numpreg);
        label.setAttribute("id","label_resp_"+(k-1)+"_"+numpreg);
        label.setAttribute("name","label_resp_"+(k-1)+"_"+numpreg);
        label.removeChild(label.childNodes[0]);
        label.appendChild(document.createTextNode((k-1)+"."));
    }
    
    input_resp.value = totalresp-1;
}

//Boton para añadir un nuevo orden en un ejercicio Ordenar Elementos en el segundo formulario de creacion
function OE_addOrden_Creacion(id_ejercicio,numpreg) {
    var orden = parseInt(document.getElementById("num_orden_"+numpreg).value)+1;
    
    var div_resp = document.getElementById("titulorespuestas_"+numpreg);
    var div_orden = createElement("div",{id:"orden"+numpreg+"_"+orden, style:"margin-left:130px;"});
    div_orden.appendChild(document.createTextNode("Orden "+orden));
    div_resp.appendChild(div_orden);
    
    var center = createElement("center",{});
    var btAddPal = createElement("input",{type:"button",name:"add_palabra",id:"add_palabra",
                                          onclick:"OE_AddPalabra_Creacion("+id_ejercicio+","+numpreg+","+orden+")",
                                          value: "Añadir Palabra"});
    center.appendChild(btAddPal);
    div_orden.appendChild(center);
    
    var hidden = createElement("input",{type:"hidden",name:"num_resp_"+numpreg+"_"+orden,
                                        value:"0", id:"num_resp_"+numpreg+"_"+orden});
    div_orden.appendChild(hidden);
    
    var table = createElement("table",{id:"resp_orden_"+numpreg+"_"+orden});
    var tbody = createElement("tbody",{id:"tbody_"+numpreg+"_"+orden});
    table.appendChild(tbody);
    div_orden.appendChild(table);
    
    var numorden = document.getElementById("num_orden_"+numpreg);
    numorden.value=orden;
    
}

//Boton para añadir una palabra en un ejercicio Ordenar Elementos
function OE_addPalabra_Modificar(id_ejercicio,numpreg,orden,texto) {
    //var textarea = document.getElementById("pregunta"+numpreg); //Cojo el textarea
    var numresp = parseInt(document.getElementById("num_res_preg"+numpreg+"_"+orden).value)+1;
    //var texto_sel = getSelectedText(textarea);
    //var sel = getInputSelection(textarea);
    
    
    //Comprobar que no se haya seleccionado una cadena vacia
    //if (texto_sel==="") {
    //    alert("No se puede crear un hueco vacio. Escriba algo de texto y seleccione para crear un hueco.");
    //    return;
    //}
        
    
    var div_respuestas = document.getElementById("orden"+numpreg+"_"+orden);   
    var table = document.createElement("table");
    var tr = document.createElement("tr");             
    table.width="50%";
    table.id="tablarespuesta"+numresp+"_"+orden+"_"+numpreg;
    if (numresp%2==0) {
        var tablaAnterior = document.getElementById("tablarespuesta"+(numresp-1)+"_"+orden+"_"+numpreg);
        tablaAnterior.style.cssFloat="left";
    }        
    var tbody = document.createElement("tbody");          
    tr.id="trrespuesta"+numresp+"_"+orden+"_"+numpreg;
    var td = document.createElement("td");
    td.style.width="80%";
    var div_resp = createElement("div",{id:"enum_resp_"+numresp+"_"+orden+"_"+numpreg});
    div_resp.appendChild(document.createTextNode(numresp+"."));
    var div = document.createElement("textarea");
    div.style.width="300px";
    //div.style.resize="none";
    div.setAttribute("class","resp");
    div.setAttribute("readonly","yes");
    div.name="respuesta"+numresp+"_"+orden+"_"+numpreg;
    div.id="respuesta"+numresp+"_"+orden+"_"+numpreg;
    var text = document.createTextNode(texto);
           
    div.appendChild(text);
            
    var td2 = document.createElement("td");
    td2.style.width="5%";
         
         
    /*var img= document.createElement("img");
    img.id="eliminarrespuesta"+numresp+"_"+orden+"_"+numpreg;
    img.src="./imagenes/delete.gif";
    img.style.height="10px";
    img.style.width="10px";
    img.setAttribute("onclick","OE_EliminarResp("+id_ejercicio+","+numpreg+","+orden+","+numresp+")");
    img.title="Eliminar Respuesta";*/
    var img1 = document.createElement("img");
    img1.id = "up_"+numresp+"_"+orden+"_"+numpreg;
    img1.src="./imagenes/up.svg";
    img1.style.height="20px";
    img1.style.width="20px";
    img1.setAttribute("alt","Subir Orden");
    img1.title="Subir Orden";
    img1.setAttribute("onclick","OE_BajarOrden("+id_ejercicio+","+numpreg+","+orden+","+numresp+")");
    
    var img2 = document.createElement("img");
    img2.id = "down_"+numresp+"_"+orden+"_"+numpreg;
    img2.src="./imagenes/down.svg";
    img2.style.height="20px";
    img2.style.width="20px";
    img2.setAttribute("alt","Bajar Orden");
    img2.title="Bajar Orden";
    img2.setAttribute("onclick","OE_SubirOrden("+id_ejercicio+","+numpreg+","+orden+","+numresp+")");
            
            
    
    td2.appendChild(img1);
    td2.appendChild(img2);
    td.appendChild(div_resp);
    td.appendChild(div);
    tr.appendChild(document.createTextNode(""));
    tr.appendChild(td);
    tr.appendChild(document.createTextNode(""));
    tr.appendChild(td2);
    tbody.appendChild(tr);
    table.appendChild(tbody);
            
    div_respuestas.appendChild(table);
    div_respuestas.appendChild(document.createTextNode(""));
    
    var numero_respuestas = document.getElementById("num_res_preg"+numpreg+"_"+orden);
    numero_respuestas.value = (numresp);
}

//Boton para eliminar una palabra en los ejercicios Ordenar Elementos
function OE_EliminarResp(id_ejercicio,numpreg,orden,numresp) {
    var respuesta = document.getElementById("tablarespuesta"+numresp+"_"+orden+"_"+numpreg);
    
    padre=respuesta.parentNode;
    padre.removeChild(respuesta.nextSibling);
    padre.removeChild(respuesta);
   
    var k=padre.childNodes.length;
     
    j=0;
    
    //alert("Numero de hijos: " + k);
   
    for(i=0;i<k;i=i+2){
        j=j+1;
        //alert('Iteracion bucle: ' + i);
        //alert("J: " + j);
        padre.childNodes[i].setAttribute("id",'tablarespuesta'+j+"_"+orden+'_'+numpreg);
        if (i==k-2) {
            //alert("Entra en i==k-1");
            var tabla = document.getElementById("tablarespuesta"+j+"_"+orden+"_"+numpreg);
            tabla.style.cssFloat="none";
        }
        else if (j%2!=0) {
            //alert("Entra en j%2!=0");
            var tabla = document.getElementById("tablarespuesta"+j+"_"+orden+"_"+numpreg);
            tabla.style.cssFloat="left";
        }
        
        
        padre.childNodes[i].childNodes[0].childNodes[0].setAttribute("id",'trrespuesta'+j+"_"+orden+'_'+numpreg);
        
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[0].setAttribute("id",'enum_resp_'+j+"_"+orden+'_'+numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[0].removeChild(padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[0].childNodes[0]);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[0].appendChild(document.createTextNode(j+"."));
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[1].setAttribute("id",'respuesta'+j+"_"+orden+'_'+numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[1].setAttribute("name",'respuesta'+j+"_"+orden+'_'+numpreg);
        
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[0].setAttribute("id",'up_'+j+"_"+orden+'_'+numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[0].setAttribute("onclick",'OE_EliminarResp('+id_ejercicio+","+numpreg+","+orden+","+j+")");
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[1].setAttribute("id",'down_'+j+"_"+orden+'_'+numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[3].childNodes[1].setAttribute("onclick",'OE_SubirOrden('+id_ejercicio+","+numpreg+","+orden+","+j+")");
        
        
    }
    //Tengo una respuesta menos
    numerorespuestas = document.getElementById('num_res_preg'+numpreg+"_"+orden);
       
    numerorespuestas.value=parseInt(numerorespuestas.value)-1;
}

//Boton para añadir un nuevo orden a una pregunta de un ejercicio Ordenar Elementos
function OE_addOrden_Modificar(id_ejercicio,numpreg) {
    var div_pregunta = document.getElementById("tabpregunta"+numpreg);
    var input_orden = document.getElementById("num_orden_"+numpreg);
    var orden = parseInt(input_orden.value)+1;
    
    var table = createElement("table",{id:"table_h3_orden_"+numpreg+"_"+orden}); div_pregunta.appendChild(table);
    var tbody = createElement("tbody",{}); table.appendChild(tbody);
    var tr = createElement("tr",{});    tbody.appendChild(tr);
    var td1 = createElement("td",{});   tr.appendChild(td1);
    var h3 = createElement("h3",{id:"h3_orden_"+numpreg+"_"+orden});       td1.appendChild(h3);
    h3.appendChild(document.createTextNode("Orden "+orden+": "));
    
    var td2 = createElement("td",{});  tr.appendChild(td2);
    //var img1 = createElement("img",{id: "add_palabra_"+numpreg+"_"+orden, src: "./imagenes/añadir.gif",
    //                                alt: "añadir palabra", height: "15px", width: "15px", title: "Añadir Palabra",
    //                                onclick: "OE_addPalabra_Modificar("+id_ejercicio+","+numpreg+","+orden+")"});
    
    var img2 = createElement("img",{id: "del_orden_"+numpreg+"_"+orden, src: "./imagenes/delete.gif",
                                    alt: "delete orden", height: "15px", width: "15px", title: "Eliminar Orden",
                                    onclick: "OE_delOrden_Modificar("+id_ejercicio+","+numpreg+","+orden+")"});
    
    //td2.appendChild(img1);
    //td2.appendChild(document.createTextNode("  Añadir Palabra  "));
    td2.appendChild(img2);
    td2.appendChild(document.createTextNode("  Eliminar Orden  "));
    
    var div_respuestas = createElement("div",{id: "orden"+numpreg+"_"+orden, class: "respuesta"});
    div_pregunta.appendChild(div_respuestas);
    var input_resp = createElement("input",{type:"hidden",name:"num_res_preg"+numpreg+"_"+orden,
                                            id:"num_res_preg"+numpreg+"_"+orden, value:"0"});
    div_pregunta.appendChild(input_resp);
    
    input_orden.value = orden;
    
    //Meter las respuestas del orden 1 en el nuevo orden
    var nresp = parseInt(document.getElementById("num_res_preg"+numpreg+"_1").value);
    
    for (var k=1; k<=nresp; k++) {
        var texta = document.getElementById('respuesta'+k+"_"+1+'_'+numpreg);
        OE_addPalabra_Modificar(id_ejercicio,numpreg,orden,texta.value);
    }
}

//Boton para eliminar un orden de un ejercicio Ordenar Elementos
function OE_delOrden_Modificar(id_ejercicio,numpreg,orden ) {
    var input_orden = document.getElementById("num_orden_"+numpreg);
    var numorden = parseInt(input_orden.value);
    
    if(numorden>1) {
        //Eliminar los nodos
        var table = document.getElementById("table_h3_orden_"+numpreg+"_"+orden);
        table.parentNode.removeChild(table);
        var div = document.getElementById("orden"+numpreg+"_"+orden);
        div.parentNode.removeChild(div);
        var input = document.getElementById("num_res_preg"+numpreg+"_"+orden);
        input.parentNode.removeChild(input);

        //Ajustar todo
        for (var i=orden+1; i<=numorden; i++) {
            var q = i-1;
            var table = document.getElementById("table_h3_orden_"+numpreg+"_"+i);
            table.setAttribute("id","table_h3_orden_"+numpreg+"_"+q);
            var h3 = document.getElementById("h3_orden_"+numpreg+"_"+i);
            h3.setAttribute("id","h3_orden_"+numpreg+"_"+q);
            h3.removeChild(h3.childNodes[0]);
            h3.appendChild(document.createTextNode("Orden "+q+" :"));
            //var img1 = document.getElementById("add_palabra_"+numpreg+"_"+i);
            //img1.setAttribute("id","add_palabra_"+numpreg+"_"+q);
            //img1.setAttribute("name","add_palabra_"+numpreg+"_"+q);
            //img1.setAttribute("onclick","OE_addPalabra_Modificar("+id_ejercicio+","+numpreg+","+q+")");
            var img2 = document.getElementById("del_orden_"+numpreg+"_"+i);
            img2.setAttribute("id","del_orden_"+numpreg+"_"+q);
            img2.setAttribute("name","del_orden_"+numpreg+"_"+q);
            img2.setAttribute("onclick","OE_delOrden_Modificar("+id_ejercicio+","+numpreg+","+q+")");
            var div = document.getElementById("orden"+numpreg+"_"+i);
            div.setAttribute("id","orden"+numpreg+"_"+q);
            var resp_i = document.getElementById("num_res_preg"+numpreg+"_"+i);
            resp_i.setAttribute("id","num_res_preg"+numpreg+"_"+q);
            resp_i.setAttribute("name","num_res_preg"+numpreg+"_"+q);
            var numresp = parseInt(resp_i.value);
            for (var j=1; j<=numresp; j++) {
                var tabla_resp = document.getElementById("tablarespuesta"+j+"_"+i+"_"+numpreg);
                tabla_resp.setAttribute("id","tablarespuesta"+j+"_"+q+"_"+numpreg);
                var div_resp = document.getElementById("enum_resp_"+j+"_"+i+"_"+numpreg);
                div_resp.setAttribute("id","enum_resp_"+j+"_"+q+"_"+numpreg);
                div_resp.removeChild(div_resp.childNodes[0]);
                div_resp.appendChild(document.createTextNode(j+"."));
                var tr = document.getElementById("trrespuesta"+j+"_"+i+"_"+numpreg);
                tr.setAttribute("id","trrespuesta"+j+"_"+q+"_"+numpreg);
                var texta = document.getElementById("respuesta"+j+"_"+i+"_"+numpreg);
                texta.setAttribute("id","respuesta"+j+"_"+q+"_"+numpreg);
                texta.setAttribute("name","respuesta"+j+"_"+q+"_"+numpreg);
                //var img = document.getElementById("eliminarrespuesta"+j+"_"+i+"_"+numpreg);
                //img.setAttribute("id","eliminarrespuesta"+j+"_"+q+"_"+numpreg);
                //img.setAttribute("onclick","OE_EliminarResp("+id_ejercicio+","+numpreg+","+q+","+j+")");
                var img_up = document.getElementById("up_"+j+"_"+i+"_"+numpreg);
                img_up.setAttribute("id","up_"+j+"_"+q+"_"+numpreg);
                img_up.setAttribute("onclick","OE_BajarOrden("+id_ejercicio+","+numpreg+","+q+","+j+")");
                var img_down = document.getElementById("down_"+j+"_"+i+"_"+numpreg);
                img_down.setAttribute("id","up_"+j+"_"+q+"_"+numpreg);
                img_down.setAttribute("onclick","OE_SubirOrden("+id_ejercicio+","+numpreg+","+q+","+j+")");
                
            }

        }
        input_orden.value = numorden-1;
    } else {
        alert("Debe haber al menos un orden.");
    }
}

//Boton para eliminar la pregunta de un ejercicio de Ordenar Elementos
function OE_DelPregunta(id_ejercicio,numpreg) {
    var input_preg = document.getElementById("num_preg");
    var numpregs = parseInt(input_preg.value);
    var orden_unico = parseInt(document.getElementById("orden_unico").value)==0;
    
    if ((numpregs-1)>0) {
        var div = document.getElementById("tabpregunta" + numpreg);
        div.parentNode.removeChild(div);
        
        for (var i = numpreg + 1; i <= numpregs; i++) {
            var q = i - 1;
            var div = document.getElementById("tabpregunta" + i);
            div.setAttribute("id", "tabpregunta" + q);
            var table = document.getElementById("table_pregunta" + i);
            table.setAttribute("id", "table_pregunta" + q);
            var h2 = document.getElementById("h2_pregunta" + i);
            h2.setAttribute("id", "h2_pregunta" + q);
            h2.removeChild(h2.childNodes[0]);
            h2.appendChild(document.createTextNode("Oracion " + q + " :"));
            var texta = document.getElementById("pregunta" + i);
            texta.setAttribute("id", "pregunta" + q);
            texta.setAttribute("name", "pregunta" + q);
            var img1 = document.getElementById("imgpregborrar" + i);
            img1.setAttribute("id", "imgpregborrar" + q);
            img1.setAttribute("onclick", "OE_DelPregunta(" + id_ejercicio + "," + q + ")");
            if(!orden_unico) {
                var img2 = document.getElementById("imgpreganadir" + i);
                img2.setAttribute("id", "imgpreganadir" + q);
                img2.setAttribute("onclick", "OE_addOrden_Modificar(" + id_ejercicio + "," + q + ")");
            }
            var input_orden = document.getElementById("num_orden_" + i);
            input_orden.setAttribute("id", "num_orden_" + q);
            input_orden.setAttribute("name", "num_orden_" + q);
            var numorden = parseInt(input_orden.value);
            for (var j = 1; j <= numorden; j++) {
                var table = document.getElementById("table_h3_orden_" + i + "_" + j);
                table.setAttribute("id", "table_h3_orden_" + q + "_" + j);
                var h3 = document.getElementById("h3_orden_" + i + "_" + j);
                h3.setAttribute("id", "h3_orden_" + q + "_" + j);
                //var img1 = document.getElementById("add_palabra_" + i + "_" + j);
                //img1.setAttribute("id", "add_palabra_" + q + "_" + j);
                //img1.setAttribute("onclick", "OE_addPalabra_Modificar(" + id_ejercicio + "," + q + "," + j + ")");
                if (!orden_unico) {
                    var img2 = document.getElementById("del_orden_" + i + "_" + j);
                    img2.setAttribute("id", "del_orden_" + q + "_" + j);
                    img2.setAttribute("onclick", "OE_delOrden_Modificar(" + id_ejercicio + "," + q + "," + j + ")");
                }
                var div = document.getElementById("orden" + i + "_" + j);
                div.setAttribute("id", "orden" + q + "_" + j);
                var input_resp = document.getElementById("num_res_preg" + i + "_" + j);
                input_resp.setAttribute("id", "num_res_preg" + q + "_" + j);
                input_resp.setAttribute("name", "num_res_preg" + q + "_" + j);
                var numresp = parseInt(input_resp.value);
                for (var k = 1; k <= numresp; k++) {
                    var tabla_resp = document.getElementById("tablarespuesta" + k + "_" + j + "_" + i);
                    tabla_resp.setAttribute("id", "tablarespuesta" + k + "_" + j + "_" + q);
                    var div_resp = document.getElementById("enum_resp_"+k+"_"+j+"_"+i);
                    div_resp.setAttribute("id","enum_resp_"+ k + "_" + j + "_" + q);
                    var tr = document.getElementById("trrespuesta" + k + "_" + j + "_" + i);
                    tr.setAttribute("id", "trrespuesta" + k + "_" + j + "_" + q);
                    var texta = document.getElementById("respuesta" + k + "_" + j + "_" + i);
                    texta.setAttribute("id", "respuesta" + k + "_" + j + "_" + q);
                    texta.setAttribute("name", "respuesta" + k + "_" + j + "_" + q);
                    //var img = document.getElementById("eliminarrespuesta" + k + "_" + j + "_" + i);
                    //img.setAttribute("id", "eliminarrespuesta" + k + "_" + j + "_" + q);
                    //img.setAttribute("onclick", "OE_EliminarResp(" + id_ejercicio + "," + q + "," + j + "," + k + ")");
                    if (!orden_unico) {
                        var img_up = document.getElementById("up_" + k + "_" + j + "_" + i);
                        img_up.setAttribute("id", "up_" + k + "_" + j + "_" + q);
                        img_up.setAttribute("name", "up_" + k + "_" + j + "_" + q);
                        img_up.setAttribute("onclick", "OE_BajarOrden(" + id_ejercicio + "," + q + "," + j + "," + k + ")");
                        var img_down = document.getElementById("down_" + k + "_" + j + "_" + i);
                        img_down.setAttribute("id", "down_" + k + "_" + j + "_" + q);
                        img_down.setAttribute("name", "down_" + k + "_" + j + "_" + q);
                        img_down.setAttribute("onclick", "OE_SubirOrden(" + id_ejercicio + "," + q + "," + j + "," + k + ")");
                    }
                }
            }
        }
        
        input_preg.value = numpregs - 1;        
        
    } else {
        alert("Debe haber al menos una pregunta.");
    }
}

//Boton para añadir una pregunta a un ejercicio de Ordenar Elementos
function OE_AddPregunta(id_ejercicio) {
    var frase = prompt("Escriba la frase que quiera desordenar.");
    var input_preg = document.getElementById("num_preg");
    var numpregs = parseInt(input_preg.value);
    var orden_unico = parseInt(document.getElementById("orden_unico").value)==0;
    var npreg = numpregs+1;
    
    if (!orden_unico) frase = frase.toUpperCase();
    
    //Siempre va a haber al menos una pregunta
    var divpregunta1 = document.getElementById("tabpregunta1");
    var padre = divpregunta1.parentNode;
    
    var div = createElement("div",{id:"tabpregunta"+npreg});
    padre.insertBefore(div,input_preg);
    var table = createElement("table",{id:"table_pregunta"+npreg,style:"width:100%;"}); 
    div.appendChild(table);
    var tbody = createElement("tbody",{}); table.appendChild(tbody);
    var tr = createElement("tr",{}); tbody.appendChild(tr);
    var td1 = createElement("td",{style:"width:70%;"}); tr.appendChild(td1);
    var h2 = createElement("h2",{id:"h2_pregunta"+npreg}); td1.appendChild(h2);
    h2.appendChild(document.createTextNode("Oracion "+npreg+" :"));
    var texta = createElement("textarea",{style:" width: 900px;",class:"pregunta",
                                          name:"pregunta"+npreg, id:"pregunta"+npreg});
    texta.appendChild(document.createTextNode(frase));
    td1.appendChild(texta);
    var td2 = createElement("td",{style:"width:5%;"}); tr.appendChild(td2);
    var img1 = createElement("img",{id:"imgpregborrar"+npreg, src:"./imagenes/lock.svg",
                                    alt:"Confirmar Oracion",height:"10px",width:"10px",
                                    onclick:"OE_BloquearPregunta("+id_ejercicio+","+npreg+")",
                                    title:"Confirmar Oracion"});
    
    var img2 = createElement("img",{id:"imgpreganadir"+npreg, src:"./imagenes/añadir.gif",
                                    alt:"añadir hueco",height:"15px",width:"15px", style:"visibility:hidden;",
                                    onclick:"OE_addOrden_Modificar("+id_ejercicio+","+npreg+")",
                                    title:"Añadir Orden Nuevo"});
    
    td1.appendChild(img1);
    td1.appendChild(document.createTextNode("  Confirmar Oracion  "));
    td1.appendChild(img2);
    
    var tr2 = createElement("tr",{});
    tbody.appendChild(tr2);
    var td3 = createElement("td",{});
    tr2.appendChild(td3);
    var h4 = createElement("h4",{});
    h4.appendChild(document.createTextNode("Puede cambiar el orden de los elementos con la ayuda de las flechas a al derecha."));
    td3.appendChild(h4);
    //td1.appendChild(document.createTextNode("  Añadir Orden Nuevo  "));
    var input_orden = createElement("input",{type:"hidden",value:"0",id:"num_orden_"+npreg,
                                             name:"num_orden_"+npreg});
    div.appendChild(input_orden);
    
    input_preg.value=npreg;
    
    
    //Crea el primer orden    
    var input_orden = document.getElementById("num_orden_"+npreg);
    var orden = parseInt(input_orden.value)+1;
    
    var table = createElement("table",{id:"table_h3_orden_"+npreg+"_"+orden}); div.appendChild(table);
    var tbody = createElement("tbody",{}); table.appendChild(tbody);
    var tr = createElement("tr",{});    tbody.appendChild(tr);
    var td1 = createElement("td",{});   tr.appendChild(td1);
    var h3 = createElement("h3",{id:"h3_orden_"+npreg+"_"+orden});       td1.appendChild(h3);
    h3.appendChild(document.createTextNode("Orden "+orden+": "));
    
    var td2 = createElement("td",{});  tr.appendChild(td2);
    var img1 = createElement("img",{id: "add_palabra_"+npreg+"_"+orden, src: "./imagenes/añadir.gif",
                                    alt: "añadir palabra", height: "15px", width: "15px", title: "Añadir Palabra",
                                    onclick: "OE_addPalabra_Seleccion("+id_ejercicio+","+npreg+","+orden+")"});
    var img2 = createElement("img",{id: "del_orden_"+npreg+"_"+orden, src: "./imagenes/delete.gif", style:"visibility:hidden;",
                                    alt: "delete orden", height: "15px", width: "15px", title: "Eliminar Orden",
                                    onclick: "OE_delOrden_Modificar("+id_ejercicio+","+npreg+","+orden+")"});
    
    
    td2.appendChild(img1);
    td2.appendChild(document.createTextNode("  Añadir Palabra  "));
    td2.appendChild(img2);
    //td2.appendChild(document.createTextNode("  Eliminar Orden  "));
    
    var div_respuestas = createElement("div",{id: "orden"+npreg+"_"+orden, class: "respuesta"});
    div.appendChild(div_respuestas);
    var input_resp = createElement("input",{type:"hidden",name:"num_res_preg"+npreg+"_"+orden,
                                            id:"num_res_preg"+npreg+"_"+orden, value:"0"});
    div.appendChild(input_resp);
    
    input_orden.value = orden;
}

//Boton para bloquear una pregunta bloqueada
function OE_BloquearPregunta(id_ejercicio,numpreg) {
    var orden_unico = parseInt(document.getElementById("orden_unico").value)==0;
    var texta = document.getElementById("pregunta"+numpreg);
    texta.setAttribute("readonly","yes");
    
    //Cambiar boton Bloquear Pregunta por Eliminar Pregunta
    var img1 = document.getElementById("imgpregborrar"+numpreg);
    img1.setAttribute("src","./imagenes/delete.gif");
    img1.setAttribute("alt","eliminar respuesta");
    img1.setAttribute("onclick","OE_DelPregunta("+id_ejercicio+","+numpreg+")");
    img1.setAttribute("title","Eliminar Oracion");
    img1.nextSibling.textContent="  Eliminar Oracion  ";
    
    if(orden_unico) {
        //Ocultar boton de Añadir Palabra
        var imgadd = document.getElementById("add_palabra_"+numpreg+"_1");
        imgadd.style.visibility="hidden";
        imgadd.nextSibling.textContent="";
        
        //Ocultar botones de Eliminar Respuesta
        var totalResp = parseInt(document.getElementById("num_res_preg"+numpreg+"_1").value);
        for (var k=1; k<=totalResp; k++) {
            var imgdel = document.getElementById("up_"+k+"_1_"+numpreg);
            imgdel.style.visibility="hidden";
        }
    }
    else {
        //Hacer visible el boton de Añadir Orden Nuevo
        var img2 = document.getElementById("imgpreganadir"+numpreg);
        img2.style.visibility="visible";
        img2.parentNode.appendChild(document.createTextNode("  Añadir Orden Nuevo  "));
        
        //Cambiar el boton Añadir Palabra por Eliminar Orden
        var imgadd = document.getElementById("add_palabra_"+numpreg+"_1");
        imgadd.parentNode.removeChild(imgadd.nextSibling);
        imgadd.parentNode.removeChild(imgadd);
        var imgdel = document.getElementById("del_orden_"+numpreg+"_1");
        imgdel.style.visibility="visible";
        imgdel.parentNode.appendChild(document.createTextNode("  Eliminar Orden  "));
        
        //Poner visibles las flechas para cambiar el orden de las respuestas
        var totalResp = parseInt(document.getElementById("num_res_preg"+numpreg+"_1").value);
        for (var k=1; k<=totalResp; k++) {
            var imgup = document.getElementById("up_"+k+"_1_"+numpreg);
            imgup.setAttribute("src","./imagenes/up.svg");
            imgup.setAttribute("alt","Subir Orden");
            imgup.setAttribute("title","Subir Orden");
            imgup.setAttribute("onclick","OE_BajarOrden("+id_ejercicio+","+numpreg+",1,"+k+")");
            
            var imgdown = document.getElementById("down_"+k+"_1_"+numpreg);
            imgdown.style.visibility="visible";
        }
    }
}

function OE_addPalabra_Seleccion(id_ejercicio, numpreg, orden) {
    var textarea = document.getElementById("pregunta"+numpreg); //Cojo el textarea
    var numresp = parseInt(document.getElementById("num_res_preg"+numpreg+"_"+orden).value)+1;
    var texto_sel = getSelectedText(textarea);
    var sel = getInputSelection(textarea);
    
    var orden_unico = parseInt(document.getElementById("orden_unico").value)==0;
    if(!orden_unico) texto_sel = texto_sel.toUpperCase();
    
    
    //Comprobar que no se haya seleccionado una cadena vacia
    //if (texto_sel==="") {
    //    alert("No se puede crear un hueco vacio. Escriba algo de texto y seleccione para crear un hueco.");
    //    return;
    //}
        
    
    var div_respuestas = document.getElementById("orden"+numpreg+"_"+orden);   
    var table = document.createElement("table");
    var tr = document.createElement("tr");             
    table.width="50%";
    table.id="tablarespuesta"+numresp+"_"+orden+"_"+numpreg;
    if (numresp%2==0) {
        var tablaAnterior = document.getElementById("tablarespuesta"+(numresp-1)+"_"+orden+"_"+numpreg);
        tablaAnterior.style.cssFloat="left";
    }        
    var tbody = document.createElement("tbody");          
    tr.id="trrespuesta"+numresp+"_"+orden+"_"+numpreg;
    var td = document.createElement("td");
    td.style.width="80%";
    var div_resp = createElement("div",{id:"enum_resp_"+numresp+"_"+orden+"_"+numpreg});
    div_resp.appendChild(document.createTextNode(numresp+"."));
    var div = document.createElement("textarea");
    div.style.width="300px";
    //div.style.resize="none";
    div.setAttribute("class","resp");
    div.setAttribute("readonly","yes");
    div.name="respuesta"+numresp+"_"+orden+"_"+numpreg;
    div.id="respuesta"+numresp+"_"+orden+"_"+numpreg;
    var text = document.createTextNode(texto_sel);
           
    div.appendChild(text);
            
    var td2 = document.createElement("td");
    td2.style.width="5%";
         
         
    /*var img= document.createElement("img");
    img.id="eliminarrespuesta"+numresp+"_"+orden+"_"+numpreg;
    img.src="./imagenes/delete.gif";
    img.style.height="10px";
    img.style.width="10px";
    img.setAttribute("onclick","OE_EliminarResp("+id_ejercicio+","+numpreg+","+orden+","+numresp+")");
    img.title="Eliminar Respuesta";*/
    var img1 = document.createElement("img");
    img1.id = "up_"+numresp+"_"+orden+"_"+numpreg;
    img1.src="./imagenes/delete.gif";
    img1.style.height="20px";
    img1.style.width="20px";
    img1.setAttribute("alt","Eliminar Respuesta");
    img1.title="Eliminar Respuesta";
    img1.setAttribute("onclick","OE_EliminarResp("+id_ejercicio+","+numpreg+","+orden+","+numresp+")");
    
    var img2 = document.createElement("img");
    img2.id = "down_"+numresp+"_"+orden+"_"+numpreg;
    img2.src="./imagenes/down.svg";
    img2.setAttribute("style","visibility:hidden;");
    img2.style.height="20px";
    img2.style.width="20px";
    img2.setAttribute("alt","Bajar Orden");
    img2.title="Bajar Orden";
    img2.setAttribute("onclick","OE_SubirOrden("+id_ejercicio+","+numpreg+","+orden+","+numresp+")");
            
            
    
    td2.appendChild(img1);
    td2.appendChild(img2);
    td.appendChild(div_resp);
    td.appendChild(div);
    tr.appendChild(document.createTextNode(""));
    tr.appendChild(td);
    tr.appendChild(document.createTextNode(""));
    tr.appendChild(td2);
    tbody.appendChild(tr);
    table.appendChild(tbody);
            
    div_respuestas.appendChild(table);
    div_respuestas.appendChild(document.createTextNode(""));
    
    var numero_respuestas = document.getElementById("num_res_preg"+numpreg+"_"+orden);
    numero_respuestas.value = (numresp);
}

//Boton para corregir un ejercicio de Ordenar Elementos
function OE_Corregir(id_ejercicio) {
    var numpreg = respuestas.length;
    for (var i=1; i<=numpreg; i++) {
        var numorden = respuestas[i-1].length-1;
        var numresp = respuestas[i-1][1].length-1;
        
        var img = document.getElementById("img_preg"+i);
        img.setAttribute("src","");
        
        var correcta=0;
        var j=1;
        while(j<=numorden && correcta<numresp) {
            correcta=0;
            for(var k=1; k<=numresp; k++) {
                
                var preg = document.getElementById("preg"+i+"_"+k);
                if (preg.childNodes.length==1) {
                    var texta = preg.childNodes[0].childNodes[0];

                    if(respuestas[i-1][j][k]==texta.textContent)
                        correcta++;
                }
                else {
                    alert("No todas los huecos tienen palabras.");
                    return;
                }
                
            }
            j++;
        }
        
        
        if(correcta==numresp) {            
            img.setAttribute("src","./imagenes/correcto.png");
        }
        else {
            img.setAttribute("src","./imagenes/incorrecto.png");
        }
    }
}

//Boton para añadir una frase a un ejercicio de Ordenar Elementos
function OE_Add_Frase(id_ejercicio) {
    var input_preg = document.getElementById("numeropreguntas");
    var npreg = parseInt(input_preg.value)+1;
    var text1 = document.getElementById("id_pregunta1");
    var div_p = text1.parentNode.parentNode.parentNode;
    
    var div = createElement("div",{class:"fitem"});
    div_p.insertBefore(div,input_preg);
    
    var div1 = createElement("div",{class:"fitemtitle"});
    div.appendChild(div1);
    var label = createElement("label",{for:"id_pregunta"+npreg});
    label.appendChild(document.createTextNode("Escriba la frase que quiera desordenar. "));
    div1.appendChild(label);
    
    var div2 = createElement("div",{class:"felement ftextarea"});
    div.appendChild(div2);
    var texta = createElement("textarea",{wrap:"virtual",rows:"5", cols:"50", name:"pregunta"+npreg, id:"id_pregunta"+npreg});
    div2.appendChild(texta);
    
    var div3 = createElement("div",{id:"titulorespuestas_"+npreg, style:"margin-left:130px;"});
    div_p.insertBefore(div3,input_preg);
    
    var div_orden = createElement("div",{id:"orden"+npreg, style:"margin-left:130px;"});
    div3.appendChild(div_orden);
    div_orden.appendChild(document.createTextNode("Elementos a ordenar"));
    var center = createElement("center",{});
    div_orden.appendChild(center);
    var input = createElement("input",{type:"hidden",name:"add_palabra",id:"add_palabra",value:"Añadir Palabra",
                                       onclick:"OE_AddPalabra_Creacion("+id_ejercicio+","+npreg+")"});
    center.appendChild(input);
    
    var table = createElement("table",{id:"resp_orden_"+npreg});
    div_orden.appendChild(table);
    var input2 = createElement("input",{type:"hidden",name:"num_resp_"+npreg,id:"num_resp_"+npreg,value:"0"});
    table.appendChild(input2);
    var tbody = createElement("tbody",{id:"tbody_"+npreg});
    table.appendChild(tbody);
    
    input_preg.value=npreg;
}   

//Funcion para comprobar que se han generado bien los distintos ordenes en los ejercicios de Ordenar Elementos
function OE_Guardar(id_ejercicio) {
    var numpreg = parseInt(document.getElementById("num_preg").value);
    for (var i=1; i<=numpreg; i++) {
        var anterior = -1;
        var numorden = parseInt(document.getElementById("num_orden_"+i).value);
        for (var j=1; j<=numorden; j++) {
            var numresp = parseInt(document.getElementById("num_res_preg"+i+"_"+j).value);
            if(anterior==-1)
                anterior = numresp;
            else {
                if(anterior!=numresp) {
                    alert("No se permite que haya ordenes con distinto numero de respuestas");
                    return false;                    
                }
            }
        }
    }
}

//Boton para subir de orden una respuesta. 
function OE_SubirOrden(id_ejercicio, numpreg, orden, numresp) {
    var input_resp = document.getElementById("num_res_preg"+numpreg+"_"+orden);
    var total_resp = parseInt(input_resp.value);
    
    if (numresp<total_resp) {
        var texta1 = document.getElementById("respuesta"+numresp+"_"+orden+"_"+numpreg);
        var texta2 = document.getElementById("respuesta"+(numresp+1)+"_"+orden+"_"+numpreg);
        
        //Intercambiar
        var tmp1 = texta1.childNodes[0];
        var tmp2 = texta2.childNodes[0];
        texta1.removeChild(tmp1);
        texta2.removeChild(tmp2);
        texta2.appendChild(tmp1);
        texta1.appendChild(tmp2);
    }
    else {
        alert("No se puede subir mas de orden.");
    }
}

//Boton para bajar de orden una respuesta. 
function OE_BajarOrden(id_ejercicio, numpreg, orden, numresp) {
    var input_resp = document.getElementById("num_res_preg"+numpreg+"_"+orden);
    var total_resp = parseInt(input_resp.value);
    
    if (numresp>1) {
        var texta1 = document.getElementById("respuesta"+numresp+"_"+orden+"_"+numpreg);
        var texta2 = document.getElementById("respuesta"+(numresp-1)+"_"+orden+"_"+numpreg);
        
        //Intercambiar
        var tmp1 = texta1.childNodes[0];
        var tmp2 = texta2.childNodes[0];
        texta1.removeChild(tmp1);
        texta2.removeChild(tmp2);
        texta2.appendChild(tmp1);
        texta1.appendChild(tmp2);
    }
    else {
        alert("No se puede bajar mas de orden.");
    }
}

//Oculta la pista H4 en los ejercicios Ordenar Elementos
function ocultarH4() {
    $("#h4_p").css("visibility","hidden");
    $("#h4_p2").css("visibility","hidden");
}
//Muestra la pista H4 en los ejercicios Ordenar Elementos
function mostrarH4() {
    $("#h4_p").css("visibility","visible");
    $("#h4_p2").css("visibility","visible");
}

//Funcion que calcula el ancho y el alto en pixeles de una cadena de texto
function medirCadena(texto) {
    var s = $("#temp");
    s.text(texto);
    var ret = {width:s.width(), height:s.height()};
    s.text("");
    return ret;
}

//Muestra en un textarea una breve explicacion de en que consiste el ejercicio
function cargaResumenEjercicio() {
    var select = document.getElementById("TipoActividadCrear");
    var texta = document.getElementById("desc_TipoActividadCrear");
    
    texta.removeChild(texta.childNodes[0]);
    var opcion = select.selectedIndex;
    console.log("Opcion seleccionada: " + opcion);
    
    texta.appendChild(document.createTextNode(descripciones[opcion]));
    texta.style.visibility="visible";
}


/**
 * *********************** Ejercicios IE mas RC ************************************
 */
//Configuracion inicial de la tabla
function IERC_setupTabla(id_pregunta,editable) {
    var oTable = $('#tbl_resp_'+id_pregunta).dataTable({
        "bPaginate":false,
        "bLengthChange":false,
        "bFilter":false,
        "bSort":false,
        "bInfo":false
        
    }); 
    
    //Oculta inicialmente las columnas
    if(editable)
        IERC_cambiaCols(id_pregunta);
}

//Pone los campos de la tabla Editables de forma dinamica
function IERC_tablaEditable(oTable){
    oTable.$('input').editable(function(value,settings) {
            return value;
            }, {
                "callback": function( sValue, y ) {
                    var aPos = oTable.fnGetPosition( this );
                    oTable.fnUpdate( sValue, aPos[0], aPos[1] );
                },
                "submitdata": function ( value, settings ) {
                    return {
                        "row_id": this.parentNode.getAttribute('id'),
                        "column": oTable.fnGetPosition( this )[2]
                    };
                },
                "height": "14px",
                "width": "100%"
            } );
}

//Oculta varias columnas de la tabla dependiendo de cuantas subrespuestas se hayan seleccionado del select
function IERC_cambiaCols(id_pregunta) {
    var oTable = $('#tbl_resp_'+id_pregunta).dataTable();
    var numCols = parseInt($('#id_sel_subrespuestas_'+id_pregunta).val());
    for (var k=0; k<=4; k++) {
        if(k<numCols) oTable.fnSetColumnVis(k,true);
        else          oTable.fnSetColumnVis(k,false);
    }
}

//Añade una nueva subrespuesta 
function IERC_addFila(id_pregunta) {
    var numresp = parseInt($('#numerorespuestas_'+id_pregunta).val());
    var oTable = $('#tbl_resp_'+id_pregunta).dataTable();
    var frase = $('#IERC_click').val();
    var frase_del = $('#IERC_eliminar').val();
    var aux = numresp+1;
    
    //Añadir la nueva fila
    var celda = function(i){return '<input type="text"  name="resp_'+id_pregunta+'_'+aux+'_'+i+'" value="" />'};
    var img = '<img id="del_resp_'+id_pregunta+"_"+aux+'" name="del_resp_'+id_pregunta+"_"+aux+'" src="./imagenes/delete.gif" onclick="IERC_delFila('+id_pregunta+","+aux+')" >'+frase_del+'</img>';
    oTable.fnAddData([celda(1),celda(2),celda(3),celda(4),celda(5),img]);
    
    //Coger el tr de la ultima fila
    var ultimaFila = oTable.$('tr:last');
    ultimaFila.attr('id','fila_'+aux);
    ultimaFila.attr('class',(aux%2==0)?"odd":"even");
    
    //Mostrar todas las columnas para actualizar los ids
    var old_num_cols = $('#id_sel_subrespuestas_'+id_pregunta).val();
    $('#id_sel_subrespuestas_'+id_pregunta).val(5);
    IERC_cambiaCols(id_pregunta);
        
    //Poner los ids a las celdas de la tabla
    $.each(ultimaFila.children(),function(index,celda){
        if(index<5)
            $(celda).attr('id','celda_'+id_pregunta+"_"+aux+"_"+(index+1));
     else
            $(celda).attr('id','celda_'+id_pregunta+"_"+aux+"_img");
    });
    
    //Volver al valor anterior del numero de columnas
    $('#id_sel_subrespuestas_'+id_pregunta).val(old_num_cols);
    IERC_cambiaCols(id_pregunta);
    
    $('#numerorespuestas_'+id_pregunta).val(aux);
}

//Funcion para eliminar una fila de la tabla
function IERC_delFila(id_pregunta,id_resp) {
    var numresp = parseInt($('#numerorespuestas_'+id_pregunta).val());
    var oTable = $('#tbl_resp_'+id_pregunta).dataTable();
    
    //Controlar que no se eliminen todas las preguntas
    if (numresp<=1) {
        alert("No se pueden eliminar todas las respuestas");
        return;
    }
    
    oTable.fnDeleteRow(id_resp-1);
    
    //Mostrar todas las columnas para actualizar los ids
    var old_num_cols = $('#id_sel_subrespuestas_'+id_pregunta).val();
    $('#id_sel_subrespuestas_'+id_pregunta).val(5);
    IERC_cambiaCols(id_pregunta);
    
    //Ajustar los ids de los campos para cada celda de la tabla
    var filas = oTable.$('tr');
    $.each(filas,function(f,tr){
       $(tr).attr('id','fila_'+(f+1));
       var hijos = $(tr).children();
       $.each(hijos,function(r,td){
          if(r<5) {             
              $(td).attr('id','celda_'+id_pregunta+'_'+(f+1)+'_'+(r+1));
              $($(td).find('input')).attr('name','resp_'+id_pregunta+'_'+(f+1)+'_'+(r+1));
          }
          else {
              console.log("Entra aquiiiii");
              console.log("f: " + f);
              $(td).attr('id','celda_'+id_pregunta+'_'+(f+1)+'_img');
              var img = $(td).find('img');
              $(img).attr('id','del_resp_'+id_pregunta+'_'+(f+1));
              $(img).attr('name','del_resp_'+id_pregunta+'_'+(f+1));
              img[0].setAttribute('onclick','IERC_delFila('+id_pregunta+','+(f+1)+')');
          }
       });
    });
    
    //Volver al valor anterior del numero de columnas
    $('#id_sel_subrespuestas_'+id_pregunta).val(old_num_cols);
    IERC_cambiaCols(id_pregunta);
    
    $('#numerorespuestas_'+id_pregunta).val(numresp-1);
}

//Funcion para cargar el audio
function IERC_cargaAudios(elnombre,id_preg,j) {

          
     var div = $("#pregunta"+id_preg);
     var button = $("#upload"+id_preg);
     
     if (j == 'primera') {
         button.text('Pulse aqui');
     }
     // var elnombre="aaa";
     new AjaxUpload(button, {
         action: 'procesaaudio.php?nombre=' + elnombre,
         name: 'image',
         autoSubmit: true,
         onSubmit: function(file, ext) {
             //alert("Cargandoooo audio");
             // cambiar el texto del boton cuando se selecicione la imagen
             button.text('Subiendo');
             // desabilitar el boton
             this.disable();

             interval = window.setInterval(function() {
                 var text = button.text();
                 if (text.length < 11) {
                     button.text(text + '.');
                 } else {
                     button.text('Subiendo');
                 }
             }, 200);
         },
         onComplete: function(file, response) {
             //alert("completado");
             button.text('Cambiar Audio');

             window.clearInterval(interval);

             // Habilitar boton otra vez
             this.enable();
             
             //Poner el objeto para reproducir el audio
             $(div.children()).remove(); //Quita el embed
             var embed = createElement("embed",{type:"application/x-shockwave-flash", src: "./mediaplayer/mediaplayer.swf", 
                                                width:"320", height:"20",style:"undefined",name:"mpl",quality:"high",
                                                allowfullscreen:"true",flashvars:"file=./mediaplayer/audios/" + elnombre + "&amp;height=20&amp;width=320"});
             div.append(embed);


             /*respuesta = document.getElementsByName(nodo);

             respuesta[0].removeChild(respuesta[0].firstChild);

             elememb = document.createElement('embed');

             elememb.setAttribute("type", "application/x-shockwave-flash");
             elememb.setAttribute("src", "./mediaplayer/mediaplayer.swf");
             elememb.setAttribute("width", "320");
             elememb.setAttribute("height", "20")
             elememb.setAttribute("style", "undefined");
             elememb.setAttribute("id", "mpl" + numresp + "_" + i);

             elememb.setAttribute("name", "mpl");
             elememb.setAttribute("quality", "high");
             elememb.setAttribute("allowfullscreen", "true");
             elememb.setAttribute("flashvars", "file=./mediaplayer/audios/" + elnombre + "&amp;height=20&amp;width=320");

             respuesta[0].appendChild(elememb);*/

         }
         //Tengo que cambiar la foto
     });
}

//Funcion que carga el video cuando se modifica el cuadro de texto
function IERC_cargaVideo(id_preg) {
    var texto = $('#pregunta'+id_preg).val();
    var obj = $('#video_pregunta'+id_preg);
    
    //Con expresiones regulares obtener el codigo del video de youtube
    var regexp = /^http\:\/\/www\.youtube\.com\/watch\?v\=((\w|_|-))*$/;
    if (regexp.test(texto)) {
         var codigo = texto.replace(/^http\:\/\/www\.youtube\.com\/watch\?v\=/,"");
         
         var nobj = createElement('object',{width:"560",height:"315",id:"video_pregunta"+id_preg,
                                            class:"video"});
         var param1 = createElement('param',{name:"movie",value:"http://www.youtube.com/v/"+codigo+"?hl=es_ES&version=3"});
         var param2 = createElement('param',{name:"allowFullScreen",value:"true"});
         var param3 = createElement('param',{name:"allowscriptaccess",value:"always"});
         var embed = createElement('embed',{src:"http://www.youtube.com/v/"+codigo+"?hl=es_ES&version=3",
                                            type:"application/x-shockwave-flash",width:"560",height:"315",
                                            allowscriptaccess:"always",allowfullscreen:"true"});
         nobj.appendChild(param1);
         nobj.appendChild(param2);
         nobj.appendChild(param3);
         nobj.appendChild(embed);
         
         obj.replaceWith(nobj);
    }
    
}

//Boton para añadir una nueva pregunta a un ejercicio IE mas RC
function IERC_AddPregunta(id_ejercicio) {
    //Coger numero de pregunta, tipo de pregunta y el nodo padre donde se insertara la nueva pregunta
    var numpreg = parseInt($('#num_preg').val());
    var npreg = numpreg+1;
    var tipoorigen = parseInt($('#tipoorigen').val());
    var contenedor = $('#tabpregunta1').parent();
    var frase = $('#OE_pregunta').val();
    frase = frase.replace(" :"," "+npreg+" :");
    var frase_sub = $('#IERC_num_subresp').val();
    
    //Crear la nueva pregunta 
    var div = createElement('div',{id:"tabpregunta"+npreg});
    $(div).insertBefore('#num_preg'); //Lo insertamos junto antes del input oculto del numero de preguntas
    createElement('br',{},div);
    createElement('br',{},div);
    var table = createElement('table',{id:"table_pregunta"+npreg, style:"width:100%;"},div);
    var tr = createElement('tr',{},table);
    var td = createElement('td',{style:"width:100%;"},tr);
    $(createElement('h2',{id:"h2_pregunta"+npreg},td)).text(frase);
    
    switch(tipoorigen) {
        case 1: //Es texto
            var textarea = createElement('textarea',{style:"width: 900px;",class:"pregunta",
                                                     name:"pregunta"+npreg,id:"pregunta"+npreg},td);
            break;
        case 2: //Es audio
            var script = createElement('script',{type:"text/javascript",src:"./mediaplayer/swfobject.js"},td);
            var divAudio = createElement('div',{class:"claseaudio",id:"pregunta"+npreg},td);
            var embed = createElement("embed",{type:"application/x-shockwave-flash", src: "./mediaplayer/mediaplayer.swf", 
                                                width:"320", height:"20",style:"undefined",name:"mpl",quality:"high",
                                                allowfullscreen:"true",flashvars:"file=./mediaplayer/audios/audio" + id_ejercicio + "_" + npreg + ".mp3&amp;height=20&amp;width=320"},divAudio);
            var c1 = createElement('div',{id:"c1"},td);
            var a = createElement('a',{href:'javascript:IERC_cargaAudios(\'audio' + id_ejercicio + "_" + npreg + ".mp3" + '\',' + npreg + ',\'primera\')',
                                       id:"upload"+npreg,class:"up"},c1);
            $(a).text('Cambiar Audio');
            break;
        case 3: //Es video
            var nobj = createElement('object',{width:"560",height:"315",id:"video_pregunta"+npreg,
                                            class:"video"},td);
            var param1 = createElement('param',{name:"movie",value:""},nobj);
            var param2 = createElement('param',{name:"allowFullScreen",value:"true"},nobj);
            var param3 = createElement('param',{name:"allowscriptaccess",value:"always"},nobj);
            var embed = createElement('embed',{src:"http://www.youtube.com/v/"+""+"?hl=es_ES&version=3",
                                               type:"application/x-shockwave-flash",width:"560",height:"315",
                                               allowscriptaccess:"always",allowfullscreen:"true"},nobj);
            var textarea = createElement('textarea',{onchange:"IERC_cargaVideo("+npreg+")", class:"video", name:"pregunta"+npreg, id:"pregunta"+npreg},td);
            $(textarea).text("");
            createElement('br',{},td);
            
            break;   
    }
    
    var img2 = createElement('img',{id:"imgpregborrar"+npreg,src:"./imagenes/delete.gif",alt:"Eliminar Pregunta",
                                    height:"10px", width:"10px",onclick:"IERC_DelPregunta("+id_ejercicio+","+npreg+")", title:"Eliminar Pregunta"},td);
    $(td).append(document.createTextNode("  Eliminar Pregunta  "));
    var img = createElement('img',{id:"imgpreganadir"+npreg,src:"./imagenes/añadir.gif", alt:"añadir hueco",
                                   height:"15px",width:"15px",onclick:"IERC_addFila("+npreg+")",title:"Añadir Respuesta"},td);
    $(td).append(document.createTextNode(' Añadir Respuesta '));
    var span = createElement('span',{style:"float:right;"},td);
    var label = createElement('label',{for:"id_sel_subrespuestas_"+npreg},span);
    $(label).text(frase_sub);
    var select = createElement('select',{id:"id_sel_subrespuestas_"+npreg,name:"sel_subrespuestas_"+npreg,onchange:"IERC_cambiaCols("+npreg+")"},span);
    for (i=1; i<=5; i++) {
        var option = createElement('option',{value:""+i},select);
        $(option).text(""+i);
        if(i==5) $(option).attr('selected','selected');
    }
    var td2 = createElement('td',{style:"width:15%;"},tr);
    
    //Pintar las respuestas
    var table = createElement('table',{style:"width:100%; margin-bottom:15px;",id:"tbl_resp_"+npreg,name:"tbl_resp_"+npreg},td);
    var thead = createElement('thead',{},table);
    var tr = createElement('tr',{id:"fila_0"},thead);
    for (i=1; i<=5; i++) {
        var th = createElement('th',{id:"celda_"+npreg+"_0_"+i},tr);
        var input = createElement('input',{type:"text",id:"cab_"+npreg+"_0_"+i,name:"cab_"+npreg+"_0_"+i,value:""},th);
    }
    var th = createElement('th',{},tr); $(th).text('Acciones');
    var tbody = createElement('tbody',{},table);
    //Poner una fila de respuestas
    var tr = createElement('tr',{id:"fila_1"},tbody);
    for (i=1; i<=5; i++) {
        var td2 = createElement('td',{id:"celda_"+npreg+"_1_"+i},tr);
        var input = createElement('input',{type:"text",name:"resp_"+npreg+"_1_"+i,value:""},td2);
    }
    var td2 = createElement('td',{id:"celda_"+npreg+"_1_img"},tr);
    var img = createElement('img',{id:"del_resp_"+npreg+"_1",name:"del_resp_"+npreg+"_1",
                                   src:"./imagenes/delete.gif",onclick:"IERC_delFila("+npreg+",1)"},td2);
    $(td2).append(document.createTextNode('Eliminar'));
    var input = createElement('input',{type:"hidden",name:"numerorespuestas_"+npreg,id:"numerorespuestas_"+npreg,value:"1"},td);
    IERC_setupTabla(npreg,true); //Ponemos la tabla de respuestas dinamica
    
    //Aumentar el numero de preguntas
    $('#num_preg').val(npreg);
}   

//Boton para eliminar una pregunta de un ejercicio IE mas RC
function IERC_DelPregunta(id_ejercicio, id_preg) {
    //Obtiene informacion: numero de preguntas y demas
    var num_pregs = parseInt($('#num_preg').val());
    var tipoorigen = parseInt($('#tipoorigen').val());
    
    //Elimina la pregunta determinada
    $('#tabpregunta'+id_preg).remove();
    
    //Desde la pregunta siguiente hasta la ultima pregunta, se deben ajustar
    //los ids, names y demas, puesto que el numero de preguntas ha bajado
    for (var k=id_preg+1; k<=num_pregs; k++) {
        var j = k-1;
        
        $('#tabpregunta'+k).attr("id","tabpregunta"+j);
        $('#table_pregunta'+k).attr("id","table_pregunta"+j);
        var h2 = $('#h2_pregunta'+k);
        h2.attr("id","h2_pregunta"+j);
        h2.text(h2.text().replace(""+k,""+j));
        
        switch(tipoorigen) {
            case 1: //Es texto
                var preg = $('#pregunta'+k);
                preg.attr("id","pregunta"+j);
                preg.attr("name","pregunta"+j);
                break;
            case 2: //Es audio
                var preg = $('#pregunta'+k);
                preg.attr("id","pregunta"+j);
                var embed = $(preg.children()[0]);
                embed.attr('flashvars','file=./mediaplayer/audios/audio'+id_ejercicio+'_'+j+'.mp3&height=20&width=320');
                var upload = $('#upload'+k);
                upload.attr("id","upload"+j);
                upload.attr("href","javascript:IERC_cargaAudios('audio"+id_ejercicio+"_"+j+".mp3',1,'primera')");
                break;
            case 3: //Es video
                var obj = $('#video_pregunta'+k);
                obj.attr("id","video_pregunta"+j);
                var text = $('#pregunta'+k);
                text.attr("id","pregunta"+j);
                text.attr("name","pregunta"+j);
                text.attr("onchange","IERC_cargaVideo("+j+")");
                break;
        }
        
        var img2 = $('#imgpregborrar'+k);
        img2.attr("id","imgpregborrar"+j);
        img2.attr("onclick","IERC_DelPregunta("+id_ejercicio+","+j+")");
        var img = $('#imgpreganadir'+k);
        img.attr("id","imgpreganadir"+j);
        img.attr("onclick","IERC_addFila("+j+")");
        $('[for=id_sel_subrespuestas_'+k+"]").attr("for","id_sel_subrespuestas_"+j);
        var select = $('#id_sel_subrespuestas_'+k);
        select.attr("id","id_sel_subrespuestas_"+j);
        select.attr("name","sel_subrespuestas_"+j);
        select.attr("onchange","IERC_cambiaCols("+j+")");
        
        //Cambiar los ids y names para todas las respuestas
        $('#tbl_resp_'+k+'_wrapper').attr("id",'tbl_resp_'+j+'_wrapper');
        var table = $('#tbl_resp_'+k);
        table.attr("id","tbl_resp_"+j);
        table.attr("name","tbl_resp_"+j);
        
        var numresp = $('#numerorespuestas_'+k);
        numresp.attr('id','numerorespuestas_'+j);
        numresp.attr('name','numerorespuestas_'+j);
        
        
        //Mostrar todas las columnas para actualizar los ids
        var old_num_cols = $('#id_sel_subrespuestas_'+j).val();
        $('#id_sel_subrespuestas_'+j).val(5);
        IERC_cambiaCols(j);
        
        //Actualizar ids y names de las cabeceras
        $.each(table.find('thead th'),function(ind,val){
            $(val).attr('id','celda_'+j+'_0_'+(ind+1));
            var input = $($(val).children()[0]);
            input.attr('id','cab_'+j+'_0_'+(ind+1));
            input.attr('name','cab_'+j+'_0_'+(ind+1));
        });
        
        //Actualizar ids y names de las filas de respuestas
        $.each(table.find('tbody tr'),function(tr_ind,tr_val){

            $.each($(tr_val).find('td'),function(td_ind,td_val){
                
                if (td_ind<5) {
                    $(td_val).attr('id','celda_'+j+'_'+(tr_ind+1)+'_'+(td_ind+1));
                    var input = $($(td_val).children()[0]);
                    input.attr('name','resp_'+j+'_'+(tr_ind+1)+'_'+(td_ind+1));
                }
                else {
                    $(td_val).attr('id','celda_'+j+'_'+(tr_ind+1)+'_img');
                    var img = $($(td_val).children()[0]);
                    img.attr('id','del_resp_'+j+'_'+(tr_ind+1));
                    img.attr('name','del_resp_'+j+'_'+(tr_ind+1));
                    img.attr('onclick','IERC_delFila('+j+","+(tr_ind+1)+")");
                }
            });
        });
        
        //Volver al valor anterior del numero de columnas
        $('#id_sel_subrespuestas_'+j).val(old_num_cols);
        IERC_cambiaCols(j);
        
        
    }
    
    //Cambia el numero de preguntas
    $('#num_preg').val(num_pregs-1);
}

//Funcion para realizar la peticion AJAX que recupere las soluciones del ejercicio
function IERC_pedirSoluciones(id_ejercicio) {
    var res;
    
    //Peticion AJAX
    $.ajax({
        type:"POST",
        dataType:"json",
        async:false,
        url:"ejercicios_respuestas_ierc.php",
        data:"id_ejercicio="+id_ejercicio,
        success:function(data) {
            console.log("Obtenidas las respuestas correctamente: " + var_dump(data));
            res = $.parseJSON(data);
            //console.log("parseado");
        },
        error:function(error) {
            console.log("Error al pedir las soluciones : " + var_dump(error));
        }
    });
    
    return res;
}

//Funcion para corregir el ejercicio IERC
function IERC_corregir(id_ejercicio) {
    //El objeto soluciones lo puedo usar porque ya lo he recogido con la funcion IERC_pedirSoluciones
    //En ese objeto se guardan las soluciones del ejercicio
    
    var correcto = "./imagenes/correcto.png";
    var incorrecto = "./imagenes/incorrecto.png";
    
    //Para cada pregunta
    for (var i=0; i<soluciones.num_pregs; i++) {
        console.log("pregunta " + (i+1));
        //Numero de subrespuestas para esta pregunta
        var numcabs = soluciones.preguntas[i].num_cabs;
        console.log("numcabs: " + numcabs);
        //Numero de respuestas para esta pregunta
        var numresp = soluciones.preguntas[i].num_resp;
        console.log("num resp: " + numresp);
        
        //Para cada respuesta que no haya sido ya usada, 
        //comprobar si es correcta
        for (var j=0; j<numresp; j++) {
            console.log("respuesta " + (j+1));
            var seguir = true;
            for (var k=0; k<numresp && seguir; k++) {
                if(!("usada" in soluciones.preguntas[i][k])) {
                    var todo = true;
                    for (var l=1; l<=numcabs; l++) {
                        console.log("l: " + l);
                        console.log("input resp: " + $('#resp_'+(i+1)+"_"+(j+1)+"_"+l).val());
                        console.log("sol resp: " + soluciones.preguntas[i][k][l]);
                        if($('#resp_'+(i+1)+"_"+(j+1)+"_"+l).val()==soluciones.preguntas[i][k][l])
                            todo = todo && true;
                        else
                            todo = todo && false;
                    }
                    if(todo) {
                        console.log("todas correctas para la respuesta " + (j+1));
                        seguir=false;
                        soluciones.preguntas[i][k].usada=true;
                        $('#corr_resp_'+(i+1)+"_"+(j+1)).attr("src",correcto);
                    }
                }
            }
            if(seguir) { //No se ha encontrado ninguna respuesta correcta
                console.log("incorrecto para la respuesta " + (j+1));
                $('#corr_resp_'+(i+1)+"_"+(j+1)).attr("src",incorrecto);
            }
        }
    }
}