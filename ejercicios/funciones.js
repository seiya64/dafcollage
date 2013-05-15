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
 * @returns {Elemento XML} Elemento XML creado con la etiqueta y atributos dados
 */
function createElement(etiqueta,atributos) {
    var elm = document.createElement(etiqueta);
    for (key in atributos) {
        elm.setAttribute(key,atributos[key]);
    }
    return elm;
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
  var out = "{";
  for (var v in obj) {
      out += v + " : " + obj[v] + "\n";
  }
  out+="}";
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
    alert("ARRASTRAR AS");
    
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

    }
    
    
    $("#botonResultado").click(function () {

                 
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
    });
}

function arrastrar_AM() {
    alert("ARRASTAR AM");
    
    
    
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
        alert( 'The square with ID "' + draggable.attr('id') + '" was dropped onto "'+$(this).attr('id')+ '" !' );
        //alert("$( this ).find( '.item' ): " + $( this ).find( ".item" ));
        //if( ($( this ).find( ".item" ).length)==0){
            $(this).append($(ui.draggable));
  
           
 

            var Idimagen = $(ui.draggable).attr('id');
            Idimagen = Idimagen.split("_")[1];
            var Idmarquito = $(this).attr('id');
            alert("idmgen"+Idimagen);
            alert("idmarquito"+Idmarquito);
            
            
            
            if (Ejercicio.respuestas[Idimagen].preg==Idmarquito) {
                alert("Correcto");
                Ejercicio.respuestas[Idimagen].correcto=true;
                Ejercicio.respuestas[Idimagen].puesto=true;
            }
            else {
                alert("Incorrecto");
                Ejercicio.respuestas[Idimagen].correcto=false;
                Ejercicio.respuestas[Idimagen].puesto=true;
                
            }
            alert("Ejercicio.respuestas[Idimagen("+Idimagen+")]: " + var_dump(Ejercicio.respuestas[Idimagen]));
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
            alert("k: " + k);
            var preg = document.getElementById(""+k);
            //Si las preguntas son videos o son imagenes, los cuadros de las preguntas debemos hacerlos mas grandes
            if (document.getElementById("movie"+k)==null && document.getElementById("imagen"+k)==null) {
                var altura = 100 + (preg.childNodes.length-1)*100;
            } else {
                var altura = 250 + (preg.childNodes.length-1)*100;
            }            
            alert("altura: " + altura + " y puestos: " + (preg.childNodes.length-1));
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
            alert("puestos todos");
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


$(document).ready(function(){
    
    alert("Funciona lo de ready function");
    
    //$(document).tooltip({track: true,my: "left+15 center", at: "right center"});
    
    
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
    alert("tipo_ej: " + tipo_ej);
    if (tipo_ej=="AM") {
        arrastrar_AM();
    } else if (tipo_ej=="") {
        arrastrar_AS();
    }
    else if (tipo_ej=="TH") {}
    

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
   
    var objeto2 = document.getElementById("id_copyrightresp");
  
    var eltxtresp =objeto2.selectedIndex;
   
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
    alert("añadiendo pregunta");

    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;
    alert("numero actual es"+ numeropreguntas);
    anterior=document.getElementById('num_res_preg'+ numeropreguntas);
    alert(anterior.id);
    numeropreguntas= parseInt(numeropreguntas) +1;
    divnumpreguntas.value=numeropreguntas;
    alert("llega");
    nuevodiv = document.createElement('div');
    alert("aki tb llega");
    nuevodiv.id= "tabpregunta"+numeropreguntas;
    //Creo un nuevo hijo a la tabla general para la pregunta
    alert("si");
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

    alert("fin");

      
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
        alert(siguientepreg);
        preg=parseInt(numpregunta);
        alert("preg"+preg);
        for(j=siguientepreg;j<=numeropreguntas+1;j++){
            alert('tabpregunta'+j);
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
                alert("llega");
                tablarespuestas=document.getElementById("tablarespuesta"+k+"_"+j);
                tablarespuestas.id="tablarespuesta"+k+"_"+preg;
                alert("ki tba");
                //los tr de las tables
                lostr=document.getElementById('trrespuesta'+k+"_"+j);
                lostr.id='trrespuesta'+k+"_"+preg;
                alert("siiiiii");

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

            alert("fin hijos");
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
    
    alert("AAAAAAAA"+i);
    var text='#upload'+i;
    var button = $(text), interval;
    alert(elnombre);
    if(j=='primera'){
        button.text('Pulse aqui');
    }
    // var elnombre="aaa";
    new AjaxUpload(button,{
        action: 'procesa.php?nombre='+elnombre,
        name: 'image',
        autoSubmit: true,
        onSubmit : function(file, ext){
            alert("Cargandoooo");
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
            alert("completado");
            button.text('Cambiar Foto');

            window.clearInterval(interval);

            // Habilitar boton otra vez
            this.enable();
            alert("recargando");
                 
            respuesta = document.getElementById('respuesta'+i);
              
            respuesta.src="./imagenes/"+elnombre;
            respuesta.removeAttribute("src");
            respuesta.setAttribute("src","./imagenes/"+elnombre);
            alert('Fin cambio imagen');
               
        }
    //Tengo que cambiar la foto
    });

        

        
}

function botonASTextoImagen(id_ejercicio){

  
    num_preg=document.getElementById('num_preg');
    
    sig_preg=parseInt(num_preg.value)+1;



    //obtengo la tabla donde lo voy a insertar
    tabla_insertar = document.getElementById('tablarespuestas');
    alert(tabla_insertar);
    tbody_insertar = tabla_insertar.lastChild;
    alert(tbody_insertar);
           
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

    alert("AAAAAAAA"+i);
    var text='#upload'+i;
    var button = $(text), interval;    
    alert("el nombre  "+elnombre);
    if(j=='primera'){
        button.text('Pulse aqui');
    }
    // var elnombre="aaa";
    new AjaxUpload(button,{
        action: 'procesaaudio.php?nombre='+elnombre,
        name: 'image',
        autoSubmit: true,
        onSubmit : function(file, ext){
            alert("Cargandoooo audio");
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
            alert("completado");
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

        alert("AAAAAAAA" + i);
        var text = 'upload' + i + "_" + numresp;
        alert("id: " + text);
        var button = document.getElementById(text);
        alert("el nombre  " + elnombre);
        alert("Button: " + button);
        alert("Button node type: " + button.nodeType);
        alert("!Button: " + !button);
        if (j == 'primera') {
            button.childNodes[0].nodeValue = 'Pulse aqui';
        }
        // var elnombre="aaa";
        new AjaxUpload(button, {
            action: 'procesaaudio.php?nombre=' + elnombre,
            name: 'image',
            autoSubmit: true,
            onSubmit: function(file, ext) {
                alert("Cargandoooo audio");
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
                alert("completado");
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
    alert(tabla_insertar);
    tbody_insertar = tabla_insertar.lastChild;
    alert(tbody_insertar);
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
    alert("sig preg vale"+sig_preg);
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

    alert("Añadiendo texto video");

    num_preg=document.getElementById('num_preg');

    sig_preg=parseInt(num_preg.value)+1;



    //obtengo la tabla donde lo voy a insertar
    tabla_insertar = document.getElementById('tablarespuestas');
    alert(tabla_insertar);
    tbody_insertar = tabla_insertar.lastChild;
    alert(tbody_insertar);
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
    alert("añadiendooooooo asociacion");
        num_preg=document.getElementById('num_preg');
        alert("eL numero de preguntas es"+num_preg.value);
        sig_preg=parseInt(num_preg.value)+1;

        alert("aki llega");

        //obtengo la tabla donde lo voy a insertar
        tabla_insertar = document.getElementById('tablarespuestas');
        alert(tabla_insertar);
        tbody_insertar = tabla_insertar.lastChild;
        alert(tbody_insertar);
        //Para el texto
        tabla_nuevotr = document.createElement('tr');
        tabla_nuevotd = document.createElement('td');
        tabla_nuevotd.id="texto"+sig_preg;
        textarea = document.createElement('textarea');
        textarea.id="pregunta"+sig_preg;
        textarea.name="pregunta"+sig_preg;
        textarea.setAttribute("style","height: 197px; width: 396px;");
        textarea.appendChild(document.createTextNode("Nuevo Texto"));
        alert("insertado el texto");
            
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
        alert(siguientepreg);
        preg=parseInt(numpregunta);
        alert("preg"+preg);
        for(j=siguientepreg;j<=numeropreguntas+1;j++){
            alert('tabpregunta'+j);
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
                alert("llega");
                tablarespuestas=document.getElementById("tablarespuesta"+k+"_"+j);
                tablarespuestas.id="tablarespuesta"+k+"_"+preg;
                alert("ki tba");
                //los tr de las tables
                lostr=document.getElementById('trrespuesta'+k+"_"+j);
                lostr.id='trrespuesta'+k+"_"+preg;
                alert("siiiiii");

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

            alert("fin hijos");
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
    alert("añadiendo pregunta");

    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;
    alert("numero actual es"+ numeropreguntas);
    anterior=document.getElementById('num_res_preg'+ numeropreguntas);
    alert(anterior.id);
    numeropreguntas= parseInt(numeropreguntas) +1;
    divnumpreguntas.value=numeropreguntas;
    alert("llega");
    nuevodiv = document.createElement('div');
    alert("aki tb llega");
    nuevodiv.id= "tabpregunta"+numeropreguntas;
    //Creo un nuevo hijo a la tabla general para la pregunta
    alert("si");
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

    alert("fin");

      
}

function botonCorregirIE(id_curso,preguntas) {
    alert("Boton Corregir");    
    
    //Recoger las respuestas de los alumnos
    var respuestas_alumnos = new Array(preguntas.length);
    for (var i=0; i<preguntas.length; i++) {
        respuestas_alumnos[i] = new Array(preguntas[i].length);
        for (var j=0; j<respuestas_alumnos[i].length; j++) {
            var correcta=false;
            respuestas_alumnos[i][j]=document.getElementById("respuesta"+(j+1)+"_"+(i+1)).value;
            //alert("respuesta " + (j+1) + " de la pregunta " + (i+1) + " es " + respuestas_alumnos[i][j]);
            for (var k=0; k<preguntas[i].length && !correcta; k++) {
                alert("Comparando " + preguntas[i][k] + " con " + respuestas_alumnos[i][j]);
                if (preguntas[i][k]==respuestas_alumnos[i][j]) {
                    alert("Da correcto: " + i + "," + k + " : " + preguntas[i][k]);
                    var midiv = document.getElementById("tdcorregir"+(j+1)+"_"+(i+1));
                    if (midiv.hasChildNodes()) midiv.removeChild(midiv.firstChild);
                    alert("midiv es " + midiv);
                    var imagen = document.createElement("img");
                   
                    imagen.src='./imagenes/correcto.png';
                    imagen.style.height="15px";
                    imagen.style.width="15px";
                    midiv.appendChild(imagen);
                    
                    preguntas[i].splice(k,1);
                    alert("Preguntas queda como: " + preguntas[i].toString());
                    k--;
                    correcta=true;
                }
            }
            if (!correcta) {
                alert("Da incorrecto: " + i + "," + j + " : " + respuestas_alumnos[i][j]);
                var midiv = document.getElementById("tdcorregir"+(j+1)+"_"+(i+1));
                if (midiv.hasChildNodes()) midiv.removeChild(midiv.firstChild);
                alert("midiv es " + midiv);
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
    alert("Pulsado en boton Mas Respuestas Audio AM");
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
    alert("Entra en arreglar_texto_audio");
    
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
    alert("Entra en arreglar_texto_video");
    
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
    alert("Entra en arreglar_texto_foto");
    
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
    alert("Pulsado en boton Mas Respuestas Foto AM");
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
    alert("Pulsado en boton Mas Respuestas Foto AM");
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
    alert("Total Respuestas: " + totalRespuestas);
    //var respuesta = document.getElementById("tablarespuesta" + numresp + "_" + numpreg);
    alert("Respuesta: " + respuesta);
    respuesta.parentNode.removeChild(respuesta);
    
    for (var k=numresp+1; k<=totalRespuestas; k++) {
        var table = document.getElementById('tablarespuesta'+k+'_'+numpreg);
        alert("Iteraccion: " + k);
        alert("Table: " + table);
        if(k==totalRespuestas) {
            alert("Es la ultima respuestas");
            table.style.cssFloat="none";
        }
        else if ((k-1)%2!=0) {
            alert("Entra en el else if");
            table.style.cssFloat="left";
        }
        table.setAttribute("name",'tablarespuesta'+(k-1)+'_'+numpreg);
        table.setAttribute("id",'tablarespuesta'+(k-1)+'_'+numpreg);
        var tr = document.getElementById('trrespuesta'+k+'_'+numpreg);
        alert("Tr: " + tr);
        tr.setAttribute("id",'trrespuesta'+(k-1)+'_'+numpreg);
        //var resp = document.getElementById('respuesta'+k+'_'+numpreg);
        //resp.setAttribute("id",'respuesta'+(k-1)+'_'+numpreg);
        //resp.setAttribute("name",'respuesta'+(k-1)+'_'+numpreg);
        //alert("Resp: " + resp);
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
            alert("Terminada con exito la llamada a borraaudio.php");
        }
    });
    var hidden_resp = document.getElementById("num_res_preg"+numpreg);
    hidden_resp.value = totalRespuestas-1;
}

//Boton de añadir una pregunta para los ejercicios Texto-Audio de Asociacion Multiple
function botonMasPreguntas_TextoAudio_AM(id_ejercicio) {
    alert("añadiendo pregunta");

    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;
    alert("numero actual es"+ numeropreguntas);
    anterior=document.getElementById('num_res_preg'+ numeropreguntas);
    alert(anterior.id);
    numeropreguntas= parseInt(numeropreguntas) +1;
    divnumpreguntas.value=numeropreguntas;
    alert("llega");
    nuevodiv = document.createElement('div');
    alert("aki tb llega");
    nuevodiv.id= "tabpregunta"+numeropreguntas;
    //Creo un nuevo hijo a la tabla general para la pregunta
    alert("si");
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

    alert("fin");

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
        alert(siguientepreg);
        preg=parseInt(numpregunta);
        alert("preg"+preg);
        for(j=siguientepreg;j<=numeropreguntas+1;j++){
            alert('tabpregunta'+j);
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
                alert("llega");
                tablarespuestas=document.getElementById("tablarespuesta"+k+"_"+j);
                tablarespuestas.id="tablarespuesta"+k+"_"+preg;
                alert("ki tba");
                //los tr de las tables
                lostr=document.getElementById('trrespuesta'+k+"_"+j);
                lostr.id='trrespuesta'+k+"_"+preg;
                alert("siiiiii");

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

            alert("fin hijos");
            
            
            
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
                    alert("Terminada con exito la llamada a borraaudio_pregunta.php");
                }
            });
        
    }else{
        alert("El ejercicio debe tener al menos una pregunta");
    }
}


//Boton de Eliminar Respuesta a los ejercicios Texto-Video en Asociacion Multiple
function EliminarRespuesta_TextoVideo_AM(numresp,numpreg){
    
    
    
    var totalRespuestas = parseInt(document.getElementById("num_res_preg"+numpreg).value);
    alert("Total Respuestas: " + totalRespuestas);
    var respuesta = document.getElementById("tablarespuesta" + numresp + "_" + numpreg);
    alert("Respuesta: " + respuesta);
    respuesta.parentNode.removeChild(respuesta);
    
    for (var k=numresp+1; k<=totalRespuestas; k++) {
        var table = document.getElementById('tablarespuesta'+k+'_'+numpreg);
        alert("Iteraccion: " + k);
        alert("Table: " + table);
        if(k==totalRespuestas) {
            alert("Es la ultima respuestas");
            table.style.cssFloat="none";
        }
        else if ((k-1)%2!=0) {
            alert("Entra en el else if");
            table.style.cssFloat="left";
        }
        table.setAttribute("name",'tablarespuesta'+(k-1)+'_'+numpreg);
        table.setAttribute("id",'tablarespuesta'+(k-1)+'_'+numpreg);
        var tr = document.getElementById('trrespuesta'+k+'_'+numpreg);
        alert("Tr: " + tr);
        tr.setAttribute("id",'trrespuesta'+(k-1)+'_'+numpreg);
        var resp = document.getElementById('respuesta'+k+'_'+numpreg);
        resp.setAttribute("id",'respuesta'+(k-1)+'_'+numpreg);
        resp.setAttribute("name",'respuesta'+(k-1)+'_'+numpreg);
        resp.setAttribute("onchange","actualizar_TextoVideo_AM("+(k-1)+","+numpreg+")");
        alert("Resp: " + resp);
        var param = document.getElementById("movie"+k+"_"+numpreg);
        param.setAttribute("id","movie"+(k-1)+'_'+numpreg);
        param.setAttribute("name","movie"+(k-1)+'_'+numpreg);
        var embed = document.getElementById("embed"+k+"_"+numpreg);
        embed.setAttribute("id","embed"+(k-1)+'_'+numpreg);
        embed.setAttribute("name","embed"+(k-1)+'_'+numpreg);
        var img = document.getElementById("eliminarrespuesta"+k+"_"+numpreg);
        img.setAttribute("id","eliminarrespuesta"+(k-1)+"_"+numpreg);
        img.setAttribute("onclick","EliminarRespuesta_TextoVideo_AM("+(k-1)+","+numpreg+")");
        alert("Img: " + img);
        //var tdcorregir = document.getElementById("tdcorregir"+k+"_"+numpreg);
        //tdcorregir.setAttribute("id","tdcorregir"+(k-1)+"_"+numpreg);
    }
    
    var hidden_resp = document.getElementById("num_res_preg"+numpreg);
    hidden_resp.value = totalRespuestas-1;
      
}


//Boton para añadir mas preguntas a los ejercicios de Texto-Video en Asociacion Multiple
function botonMasPreguntas_TextoVideo_AM(id_ejercicio) {
    alert("añadiendo pregunta");

    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;
    alert("numero actual es"+ numeropreguntas);
    anterior=document.getElementById('num_res_preg'+ numeropreguntas);
    alert(anterior.id);
    numeropreguntas= parseInt(numeropreguntas) +1;
    divnumpreguntas.value=numeropreguntas;
    alert("llega");
    nuevodiv = document.createElement('div');
    alert("aki tb llega");
    nuevodiv.id= "tabpregunta"+numeropreguntas;
    //Creo un nuevo hijo a la tabla general para la pregunta
    alert("si");
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

    alert("fin");
}

//Funcion que actualiza los objetos de video cuando se cambia los textarea de los videos
function actualizar_TextoVideo_AM(numresp,numpreg) {
    //Obtenemos las etiquetas a modificar (param y embed) donde se encuentra el origen del video de Youtube
    alert("Actualizando video: " + numresp + "," + numpreg);
    var param = document.getElementById("movie"+numresp+"_"+numpreg);
    alert("Param: " + param);
    var embed = document.getElementById("embed"+numresp+"_"+numpreg);
    alert("Embed: " + embed);
    
    var textarea = document.getElementById("respuesta"+numresp+"_"+numpreg);
    var texto = textarea.value;
    alert("Texto: " + texto);
    
    //Obtenemos la etiqueta object
    var obj = param.parentNode;
    var padre = obj.parentNode;
    
    
    //Con expresiones regulares obtener el codigo del video de youtube
    var regexp = /^http\:\/\/www\.youtube\.com\/watch\?v\=((\w|_|-))*$/;
    if (regexp.test(texto)) {
        alert("Cumple la expresion regular");
        var codigo = texto.replace(/^http\:\/\/www\.youtube\.com\/watch\?v\=/,"");
        alert("Codigo: " + codigo);
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
        alert(siguientepreg);
        preg=parseInt(numpregunta);
        alert("preg"+preg);
        for(j=siguientepreg;j<=numeropreguntas+1;j++){
            alert('tabpregunta'+j);
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
                alert("llega");
                tablarespuestas=document.getElementById("tablarespuesta"+k+"_"+j);
                tablarespuestas.id="tablarespuesta"+k+"_"+preg;
                alert("ki tba");
                //los tr de las tables
                lostr=document.getElementById('trrespuesta'+k+"_"+j);
                lostr.id='trrespuesta'+k+"_"+preg;
                alert("siiiiii");

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

            alert("fin hijos");
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
    alert("Numero respuesta a crear: " + numresp);
          
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
    
        alert("AAAAAAAA" + i);
        var text = 'upload' + numresp + "_" + i;
        alert("id: " + text);
        var button = document.getElementById(text);
        alert("el nombre  " + elnombre);
        alert("Button: " + button);
        if (j == 'primera') {
            button.childNodes[0].nodeValue = 'Pulse aqui';
        }
        // var elnombre="aaa";
        new AjaxUpload(button, {
            action: 'procesa.php?nombre=' + elnombre,
            name: 'image',
            autoSubmit: true,
            onSubmit: function(file, ext) {
                alert("Cargandoooo");
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
                alert("completado");
                button.childNodes[0].nodeValue = 'Cambiar Foto';

                window.clearInterval(interval);

                // Habilitar boton otra vez
                this.enable();
                alert("recargando");

                respuesta = document.getElementById('respuesta' + numresp + "_" + i);
                var padre = respuesta.parentNode;
                padre.removeChild(respuesta);

                respuesta.src = "./imagenes/" + elnombre;
                respuesta.removeAttribute("src");
                respuesta.setAttribute("src", "./imagenes/" + elnombre);
                padre.appendChild(respuesta);
                alert('Fin cambio imagen');

            }
            //Tengo que cambiar la foto
        });

        

    }
}

//Boton para eliminar una respuesta en los ejercicios Texto-Imagen de Asociacion Multiple
function EliminarRespuesta_TextoFoto_AM(respuesta,numpreg,numresp,id_ejercicio){
    var totalRespuestas = parseInt(document.getElementById("num_res_preg"+numpreg).value);
    alert("Total Respuestas: " + totalRespuestas);
    //var respuesta = document.getElementById("tablarespuesta" + numresp + "_" + numpreg);
    alert("Respuesta: " + respuesta);
    respuesta.parentNode.removeChild(respuesta);
    
    for (var k=numresp+1; k<=totalRespuestas; k++) {
        var table = document.getElementById('tablarespuesta'+k+'_'+numpreg);
        alert("Iteraccion: " + k);
        alert("Table: " + table);
        if(k==totalRespuestas) {
            alert("Es la ultima respuestas");
            table.style.cssFloat="none";
        }
        else if ((k-1)%2!=0) {
            alert("Entra en el else if");
            table.style.cssFloat="left";
        }
        table.setAttribute("name",'tablarespuesta'+(k-1)+'_'+numpreg);
        table.setAttribute("id",'tablarespuesta'+(k-1)+'_'+numpreg);
        var tr = document.getElementById('trrespuesta'+k+'_'+numpreg);
        alert("Tr: " + tr);
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
            alert("Terminada con exito la llamada a borrarespuesta.php");
        }
    });
    var hidden_resp = document.getElementById("num_res_preg"+numpreg);
    hidden_resp.value = totalRespuestas-1;
}

//Boton de añadir una pregunta para los ejercicios Texto-Imagen de Asociacion Multiple
function botonMasPreguntas_TextoFoto_AM(id_ejercicio) {
    alert("añadiendo pregunta");

    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;
    alert("numero actual es"+ numeropreguntas);
    anterior=document.getElementById('num_res_preg'+ numeropreguntas);
    alert(anterior.id);
    numeropreguntas= parseInt(numeropreguntas) +1;
    divnumpreguntas.value=numeropreguntas;
    alert("llega");
    nuevodiv = document.createElement('div');
    alert("aki tb llega");
    nuevodiv.id= "tabpregunta"+numeropreguntas;
    //Creo un nuevo hijo a la tabla general para la pregunta
    alert("si");
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

    alert("fin");

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
        alert(siguientepreg);
        preg=parseInt(numpregunta);
        alert("preg"+preg);
        for(j=siguientepreg;j<=numeropreguntas+1;j++){
            alert('tabpregunta'+j);
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
                alert("llega");
                tablarespuestas=document.getElementById("tablarespuesta"+k+"_"+j);
                tablarespuestas.id="tablarespuesta"+k+"_"+preg;
                alert("ki tba");
                //los tr de las tables
                lostr=document.getElementById('trrespuesta'+k+"_"+j);
                lostr.id='trrespuesta'+k+"_"+preg;
                alert("siiiiii");

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

            alert("fin hijos");
            
            
            
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
                    alert("Terminada con exito la llamada a borrapregunta.php");
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
    alert("añadiendo pregunta");

    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;
    alert("numero actual es"+ numeropreguntas);
    anterior=document.getElementById('num_res_preg'+ numeropreguntas);
    alert(anterior.id);
    numeropreguntas= parseInt(numeropreguntas) +1;
    divnumpreguntas.value=numeropreguntas;
    alert("llega");
    nuevodiv = document.createElement('div');
    alert("aki tb llega");
    nuevodiv.id= "tabpregunta"+numeropreguntas;
    //Creo un nuevo hijo a la tabla general para la pregunta
    alert("si");
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

    alert("fin");

}

/**
 * Funcion para subir archivos de audio para los ejercicios Audio-Texto en Asociacion Multiple
 */
function cargaAudios_AudioTexto_AM(elnombre,i,j){
    alert("AAAAAAAA" + i);
    var text = 'upload' + i;
    alert("id: " + text);
    var button = document.getElementById(text);
    alert("el nombre  " + elnombre);
    alert("Button: " + button);
    alert("Button node type: " + button.nodeType);
    alert("!Button: " + !button);
    if (j == 'primera') {
        button.childNodes[0].nodeValue = 'Pulse aqui';
    }
    // var elnombre="aaa";
    new AjaxUpload(button, {
        action: 'procesaaudio.php?nombre=' + elnombre,
        name: 'image',
        autoSubmit: true,
        onSubmit: function(file, ext) {
            alert("Cargandoooo audio");
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
            alert("completado");
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
        alert(siguientepreg);
        preg=parseInt(numpregunta);
        alert("preg"+preg);
        for(j=siguientepreg;j<=numeropreguntas+1;j++){
            alert('tabpregunta'+j);
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
                alert("llega");
                tablarespuestas=document.getElementById("tablarespuesta"+k+"_"+j);
                tablarespuestas.id="tablarespuesta"+k+"_"+preg;
                alert("ki tba");
                //los tr de las tables
                lostr=document.getElementById('trrespuesta'+k+"_"+j);
                lostr.id='trrespuesta'+k+"_"+preg;
                alert("siiiiii");

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

            alert("fin hijos");
            
            
            
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
                    alert("Terminada con exito la llamada a borraaudio_pregunta.php");
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
    alert("Actualizando video: " + id_ejercicio + "," + numpreg);
    var param = document.getElementById("movie"+numpreg);
    alert("Param: " + param);
    var embed = document.getElementById("embed"+numpreg);
    alert("Embed: " + embed);
    
    var textarea = document.getElementById("archivovideo"+numpreg);
    var texto = textarea.value;
    alert("Texto: " + texto);
    
    //Obtenemos la etiqueta object
    var obj = param.parentNode;
    var padre = obj.parentNode;
    
    
    //Con expresiones regulares obtener el codigo del video de youtube
    var regexp = /^http\:\/\/www\.youtube\.com\/watch\?v\=((\w|_|-))*$/;
    if (regexp.test(texto)) {
        alert("Cumple la expresion regular");
        var codigo = texto.replace(/^http\:\/\/www\.youtube\.com\/watch\?v\=/,"");
        alert("Codigo: " + codigo);
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
    alert("añadiendo pregunta");

    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;
    alert("numero actual es"+ numeropreguntas);
    anterior=document.getElementById('num_res_preg'+ numeropreguntas);
    alert(anterior.id);
    numeropreguntas= parseInt(numeropreguntas) +1;
    divnumpreguntas.value=numeropreguntas;
    alert("llega");
    nuevodiv = document.createElement('div');
    alert("aki tb llega");
    nuevodiv.id= "tabpregunta"+numeropreguntas;
    //Creo un nuevo hijo a la tabla general para la pregunta
    alert("si");
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

    alert("fin");

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
        alert(siguientepreg);
        preg=parseInt(numpregunta);
        alert("preg"+preg);
        for(j=siguientepreg;j<=numeropreguntas+1;j++){
            alert('tabpregunta'+j);
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
                alert("llega");
                tablarespuestas=document.getElementById("tablarespuesta"+k+"_"+j);
                tablarespuestas.id="tablarespuesta"+k+"_"+preg;
                alert("ki tba");
                //los tr de las tables
                lostr=document.getElementById('trrespuesta'+k+"_"+j);
                lostr.id='trrespuesta'+k+"_"+preg;
                alert("siiiiii");

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

            alert("fin hijos");
            
            
            
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
    alert("AAAAAAAA" + i);
    var text = 'upload' + i;
    alert("id: " + text);
    var button = document.getElementById(text);
    alert("el nombre  " + elnombre);
    alert("Button: " + button);
    alert("Button node type: " + button.nodeType);
    alert("!Button: " + !button);
    if (j == 'primera') {
        button.childNodes[0].nodeValue = 'Pulse aqui';
    }
    // var elnombre="aaa";
    new AjaxUpload(button, {
        action: 'procesa.php?nombre=' + elnombre,
        name: 'image',
        autoSubmit: true,
        onSubmit: function(file, ext) {
            alert("Cargandoooo foto");
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
            alert("completado");
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
    alert("añadiendo pregunta");

    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;
    alert("numero actual es"+ numeropreguntas);
    anterior=document.getElementById('num_res_preg'+ numeropreguntas);
    alert(anterior.id);
    numeropreguntas= parseInt(numeropreguntas) +1;
    divnumpreguntas.value=numeropreguntas;
    alert("llega");
    nuevodiv = document.createElement('div');
    alert("aki tb llega");
    nuevodiv.id= "tabpregunta"+numeropreguntas;
    //Creo un nuevo hijo a la tabla general para la pregunta
    alert("si");
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

    alert("fin");

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
        alert(siguientepreg);
        preg=parseInt(numpregunta);
        alert("preg"+preg);
        for(j=siguientepreg;j<=numeropreguntas+1;j++){
            alert('tabpregunta'+j);
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
                alert("llega");
                tablarespuestas=document.getElementById("tablarespuesta"+k+"_"+j);
                tablarespuestas.id="tablarespuesta"+k+"_"+preg;
                alert("ki tba");
                //los tr de las tables
                lostr=document.getElementById('trrespuesta'+k+"_"+j);
                lostr.id='trrespuesta'+k+"_"+preg;
                alert("siiiiii");

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

            alert("fin hijos");
            
            
            
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
                    alert("Terminada con exito la llamada a borrapregunta.php");
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
    alert("numero actual es"+ numeropreguntas);
    anterior=document.getElementById('num_res_preg'+ numeropreguntas);
    alert(anterior.id);
    numeropreguntas= parseInt(numeropreguntas) +1;
    divnumpreguntas.value=numeropreguntas;
    alert("llega");
    nuevodiv = document.createElement('div');
    alert("aki tb llega");
    nuevodiv.id= "tabpregunta"+numeropreguntas;
    //Creo un nuevo hijo a la tabla general para la pregunta
    alert("si");
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

    alert("fin");
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
        alert(siguientepreg);
        preg=parseInt(numpreg);
        alert("preg"+preg);
        for(j=siguientepreg;j<=numeropreguntas+1;j++){
            alert('tabpregunta'+j);
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
                alert("llega");
                tablarespuestas=document.getElementById("tablarespuesta"+k+"_"+j);
                tablarespuestas.id="tablarespuesta"+k+"_"+preg;
                alert("ki tba");
                //los tr de las tables
                lostr=document.getElementById('trrespuesta'+k+"_"+j);
                lostr.id='trrespuesta'+k+"_"+preg;
                alert("siiiiii");

                


                larespuesta=document.getElementById('respuesta'+k+"_"+j);
                larespuesta.id='respuesta'+k+"_"+preg;
                larespuesta.name='respuesta'+k+"_"+preg;

                //la imagen de eliminar

                laimageneliminar=document.getElementById('eliminarrespuesta'+k+"_"+j);
                laimageneliminar.id='eliminarrespuesta'+k+"_"+preg;
                laimageneliminar.setAttribute("onclick","TH_EliminarHueco("+id_ejercicio+","+preg+","+k+")");

                

            }

            alert("fin hijos");
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
function OE_AddPalabra_Creacion(id_ejercicio,numpreg,orden) {
    var textarea = document.getElementById("id_pregunta"+numpreg); //Cojo el textarea
    var numresp = parseInt(document.getElementById("num_resp_"+numpreg+"_"+orden).value);
    var texto_sel = getSelectedText(textarea);
    var sel = getInputSelection(textarea);
    
    //Comprobar que no se haya seleccionado una cadena vacia
    if (texto_sel==="") {
        alert("No se puede crear una asociacion de orden vacia. Escriba algo de texto y seleccione para crear una asociacion de orden.");
        return;
    }
    
    
    var tbody = document.getElementById("tbody_"+numpreg+"_"+orden);
    var n_tr = createElement("tr",{});
    
    var td_label = createElement("td",{});
    var label = createElement("label",{for:"respuesta"+(numresp+1)+"_"+orden+"_"+numpreg});
    label.appendChild(document.createTextNode((numresp+1)+"."));
    td_label.appendChild(label);
    n_tr.appendChild(td_label);
    
    var td_resp = createElement("td",{style: "padding-left:130px;"});
    var resp = createElement("textarea",{name: "respuesta"+(numresp+1)+"_"+orden+"_"+numpreg, id: "respuesta"+(numresp+1)+"_"+ orden + "_"+numpreg,
                                         rows:"1", cols:"50",readonly:"yes", value:texto_sel});
    resp.appendChild(document.createTextNode(texto_sel));
    td_resp.appendChild(resp);
    n_tr.appendChild(td_resp);
    
    tbody.appendChild(n_tr);
    
    
    var numero_respuestas = document.getElementById("num_resp_"+numpreg+"_"+orden);
    numero_respuestas.value = (numresp+1);
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