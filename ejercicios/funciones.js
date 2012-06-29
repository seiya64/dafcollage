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
 

});


   
     function sele($id) { 
    
        
    alert("seleccionado");
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

      alert(txt);
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
      
        alert(eltxt);
        
        location.href="view.php?id=" + id_curso + "&opcion=5&tipocreacion=" + objeto.selectedIndex ;
        
        }else{ //No hay nada seleccionado en crear
            alert("Debe seleccionar un Tipo de Actividad");
        }
  
}

function botonBuscar(id_curso){
   
      location.href="view.php?id=" + id_curso + "&opcion=6";
  
}

function Comprobacionesform(){
    
       var objeto = document.getElementById('id_numerorespuestas');
      
       
       var objeto1 = document.getElementById('id_numerorespuestascorrectas');
   
       //El número de respuestas correctas es mayor que el de respuestas
       if(objeto.selectedIndex< objeto1.selectedIndex ){
      
             alert("El número de respuesta correctas debe ser menor o igual que el número de respuestas");
            
             
       }
       
        
    
}

function botonMasRespuestas(i){
    alert("boton");
  
    textarea = document.createElement('textarea');
    textarea.rows = 5;
    textarea.cols = 50;
    var radioInput = document.createElement('input');
    radioInput.type="radio";
    radioInput.value="Si";
   // radioInput.checked;
    radioInput.text="Si";
   
    var radioInput2 = document.createElement('input');
    radioInput2.type="radio";
    radioInput2.value="No";
  //  radio = document.createElement("<INPUT TYPE='RADIO' NAME='RADIOTEST' VALUE='Si'>");
  //  radio2 = document.createElement("<INPUT TYPE='RADIO' NAME='RADIOTEST' VALUE='No'>");
    var br = document.createElement('br');
    switch(i){
        case 1:
             alert("llega");
             alert('respuesta'+j1+'_'+i);
            ultimarespuesta = document.getElementById('respuesta'+j1+'_'+i);
            j1=j1+1;
            textarea.id='respuesta'+j1+'_'+i;
            radioInput.id='correcta'+j1+'_'+i;
            radioInput2.id='incorrecta'+j1+'_'+i;
            ultimarespuesta.parentNode.appendChild(textarea);
            ultimarespuesta.parentNode.appendChild(br);
             ultimarespuesta.parentNode.appendChild(document.createTextNode('Correcta: '));
            ultimarespuesta.parentNode.appendChild(radioInput);
           // NodoradioInput = document.getElementById('correcta'+j1+'_'+i);
            ultimarespuesta.parentNode.appendChild(document.createTextNode('Si'));
            ultimarespuesta.parentNode.appendChild(radioInput2);
            //NodoradioInput2 = document.getElementById('incorrecta'+j1+'_'+i);
            ultimarespuesta.parentNode.appendChild(document.createTextNode('No'));
            
        case 2:
        case 3:
        case 4:
        case 5:
        case 6:
        case 7:
        case 8:
        case 9:
    }
 
    
     
     
      
    
      
      alert("fin");
    
}

 
function botonAñadirRespuesta(i){
    alert("añadiendo");
    alert(i);
     j=j+1;
    
    alert("j vale" +j);
    respuesta = document.createElement('text');
    respuesta.appendChild(document.createTextNode('Respuesta'+j));
    
    otro=document.getElementById('id_añadiendo'+i);
    otro.appendChild(respuesta);
    
    elemento1 = document.createElement('textarea');
    elemento1.id = 'id_añadiendo'+j;
    elemento1.rows = 5;
    elemento1.cols = 50;
   
    
    elemento2 = document.getElementById('id_añadiendo'+i);
    elemento2.parentNode.insertBefore(elemento1,elemento2);
   
    alert(j);
}


