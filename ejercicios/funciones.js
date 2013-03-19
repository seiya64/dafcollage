var j1=1;
var j2=1;
var j3=1;
var j4=1;
var j5=1;
var j6=1;
var j7=1;
var j8=1;
var j9=1;

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



$(document).ready(function(){
    
    setTextareaHeight($('.adaptHeightInput'));
    try{
        var a = document.getElementsByClassName('adaptHeightInput');
        var b = a.item();
        b.focus();
        b.blur();
    }catch(e){};

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


function cargaImagenes(elnombre,i,j){
    
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




function cargaAudios(elnombre,i,j){

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