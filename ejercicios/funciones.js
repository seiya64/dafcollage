 var j1=1;
 var j2=1;
 var j3=1;
 var j4=1;
 var j5=1;
 var j6=1;
 var j7=1;
 var j8=1;
 var j9=1;

$(document).ready(function(){
    
 


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
    $('.imagen').droppable( {
        drop: handleDropEvent

    } );


    function handleDropEvent( event, ui ) {
        var draggable = ui.draggable;
        // alert( 'The square with ID "' + draggable.attr('id') + '" was dropped onto "'+$(this).attr('id')+ '"!' );
        if( ($( this ).find( ".item" ).length)==0){
            $(this).append($(ui.draggable));
  

 

            var Idimagen = $(ui.draggable).attr('id');
            var Idmarquito = $(this).attr('id')
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
          
            for(i=1;i<=parseInt($numimagen);i++){
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
 
   $('#menuaux li #classa').click(function(){
        alert("pulsado");
    var elem = $(this).next().next();
    alert(elem);
        if(elem.is('ul')){
            event.preventDefault();
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

function botonCrear(id_curso){
   
      
      
        var objeto = document.getElementById('TipoActividadCrear');
 
        if(objeto.selectedIndex!=0){
         var eltxt = objeto.options[objeto.selectedIndex].text;
      
     
        location.href="view.php?id=" + id_curso + "&opcion=5&tipocreacion=" + objeto.selectedIndex ;
        
        }else{ //No hay nada seleccionado en crear
            alert("Debe seleccionar un Tipo de Actividad");
        }
  
}

function botonBuscar(id_curso){
   
      location.href="view.php?id=" + id_curso + "&opcion=6";
  
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
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[0].setAttribute("value",'crespuesta'+j+'_'+numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[0].setAttribute("onclick",'BotonRadio(crespuesta'+j+'_'+numpreg+')');
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[1].setAttribute("id",'respuesta'+j+'_'+numpreg);
        padre.childNodes[i].childNodes[0].childNodes[0].childNodes[1].childNodes[1].setAttribute("name",'respuesta'+j+'_'+numpreg);
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

function anadirRespuesta(respuesta){
  
    var idrespuesta=respuesta.id;
  
    switch(idrespuesta){
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
    }
    
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
            radioInput.value="0";  
            radioInput.setAttribute("onclick","BotonRadio(crespuesta"+numresp+"_"+numpreg+")");  
            var div = document.createElement("textarea");
            div.setAttribute("class","resp");
            div.id="respuesta"+numresp+"_"+numpreg;
            div.name="respuesta"+numresp+"_"+numpreg;
            var text = document.createTextNode("Introduzca su respuesta..");
           
            div.appendChild(text);
            
            var td2 = document.createElement("td");
            td2.style.width="5%"
         
         
            var img= document.createElement("img");
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