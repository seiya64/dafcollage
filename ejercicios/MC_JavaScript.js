/*
 * Versión específica .ready para Multiple Choice
 * @author Javier Castro Fernandez, Borja Arroba Hernandez, Carlos Aguilar Miguel
 * 
 */

/*
 * Funcion para cargar las fotos en los ejercicios 
 * @author Javier Castro Fernandez, Borja Arroba Hernandez, Carlos Aguilar Miguel
 * 
 */

function botonMasPreguntas(){
    divnumpreguntas = document.getElementById('num_preg');
    numeropreguntas=divnumpreguntas.value;
    anterior=document.getElementById('num_res_preg'+ numeropreguntas);
    numeropreguntas= parseInt(numeropreguntas) +1;
    divnumpreguntas.value=numeropreguntas;
    nuevodiv = document.createElement('div');
    nuevodiv.id= "tabpregunta"+numeropreguntas;
    
    //Creo un nuevo hijo a la tabla general para la pregunta
    var br = document.createElement('br');
    var br1 = document.createElement('br');
    var br2 = document.createElement('br');
    tablapreg = document.createElement('table');
    tablapreg.style.width="100%";

    body= document.createElement('tbody');
    nuevotr=document.createElement('tr');

    body.appendChild(nuevotr);
    nuevotd=document.createElement('td');
    nuevotd.style.width="95%";
    textareapreg=document.createElement('textarea');
    textareapreg.setAttribute('class', 'pregunta');
    textareapreg.name="pregunta"+numeropreguntas;
    textareapreg.id="pregunta"+numeropreguntas;
    textareapreg.value=" Introduzca la pregunta... ";
    
    //Añado el textarea de la prgunta
    nuevotd.appendChild(textareapreg);

    nuevotd1=document.createElement('td');
    nuevotd1.style.width="5%";
    nuevotd1.style.padding="10px";
    imgborrar=document.createElement('img');
    imgborrar.id="imgpregborrar"+numeropreguntas ;
    imgborrar.src="./imagenes/delete.gif";
    imgborrar.alt="eliminar respuesta";
    imgborrar.style.height="10px";
    imgborrar.style.width="10px";
    imgborrar.setAttribute('onclick',"EliminarPregunta(tabpregunta"+numeropreguntas+","+numeropreguntas+")");
    imgborrar.title="Eliminar Pregunta";
    
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
    nuevodiv.appendChild(br1);
    nuevodiv.appendChild(br2);
    nuevodiv.appendChild(tablapreg);

    //div de respuestas
    divrespuesta=document.createElement('div');
    divrespuesta.id="respuestas"+numeropreguntas;
    divrespuesta.setAttribute('class',"respuesta");
    
    nuevodiv.appendChild(divrespuesta);
    
    //lo inserto despues de anterior
    insertAfter(anterior,nuevodiv);
    nuevoinput=document.createElement('input');
    nuevoinput.type="hidden";
    nuevoinput.value="0";
    nuevoinput.id="num_res_preg"+numeropreguntas;
    nuevoinput.name="num_res_preg"+numeropreguntas;

    //añado el numero de respuestas de la nueva pregunta
    insertAfter(nuevodiv,nuevoinput);
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
//                //alert("siiiiii");
//
//                losinput=document.getElementById('id_crespuesta'+k+"_"+j);
//                losinput.id='id_crespuesta'+k+"_"+preg;
//                losinput.name='crespuesta'+k+"_"+preg;
//                losinput.setAttribute("onclick","BotonRadio(crespuesta"+k+"_"+preg+")");


                larespuesta=document.getElementById('respuesta'+k+"_"+j);
                larespuesta.id='respuesta'+k+"_"+preg;
                larespuesta.name='respuesta'+k+"_"+preg;

                //la imagen de eliminar

                laimageneliminar=document.getElementById('eliminarrespuesta'+k+"_"+j);
                laimageneliminar.id='eliminarrespuesta'+k+"_"+preg;
                laimageneliminar.setAttribute("onclick","eliminarRespuesta(tablarespuesta"+k+"_"+preg+","+preg+")");

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


function anadirRespuesta(respuesta,numpreg){
    var numresp=parseInt($("#num_res_preg"+numpreg).attr("value"));
    //sumo uno a las prespuestas de la pregunta
    numresp=numresp+1;
    $("#num_res_preg"+numpreg).attr("value", numresp);
    
    var campos='<table id="tablarespuesta'+numresp+'_'+numpreg+'" style="width:100%;">\n\
                <tbody><tr id="trrespuesta'+numresp+'_'+numpreg+'">\n\
                    <td style="width:95%;">\n\
                        <input value="0" id="res'+numresp+'_'+numpreg+'" name="res'+numresp+'" type="hidden">\n\
                        <textarea class="resp" name="respuesta'+numresp+'_'+numpreg+'" id="respuesta'+numresp+'_'+numpreg+'" value="Introduzca su respuesta...">Introduzca su respuesta...</textarea>\n\
                    </td>\n\
                    <td style="width:5%; padding: 10px;">\n\
                        <img id="eliminarrespuesta'+numresp+'_'+numpreg+'" src="./imagenes/delete.gif" alt="eliminar respuesta" onclick="eliminarRespuestaMC(tablarespuesta'+numresp+'_'+numpreg+','+numpreg+')" title="Eliminar Respuesta" width="10px" height="10px">\n\
                        <img src="./imagenes/incorrecto.png" id="correcta'+numresp+'_'+numpreg+'" alt="respuesta correcta" onclick="InvertirRespuesta(correcta'+numresp+'_'+numpreg+',0)" title="Cambiar a Correcta" width="15px" height="15px">\n\
                        <input value="0" id="valorcorrecta'+numresp+'_'+numpreg+'" name="valorcorrecta'+numresp+'_'+numpreg+'" type="hidden">\n\
                    </td>\n\
                <tr></tbody>\n\
                </table>';
    $("#respuestas"+numpreg).append(campos);
}


function insertAfter(e,i){
    if (e !== null && e.parentNode !== null){
        if(e.nextSibling){
            e.parentNode.insertBefore(i,e.nextSibling);
        } else {
            e.parentNode.appendChild(i);
        }
    }
}


function eliminarRespuestaMC(respuesta, numpreg) {
    $("#"+respuesta.id).remove();
    var numresp=$("#num_res_preg"+numpreg).attr("value");
    
    var respuesta=1;
    for(i=1; i<=numresp; i++) {
        if($("#tablarespuesta"+i+"_"+numpreg).length) {
            $("#tablarespuesta"+i+"_"+numpreg).attr("id", 'tablarespuesta'+respuesta+'_'+numpreg);
            
            $("#trrespuesta"+i+"_"+numpreg).attr("id", 'trrespuesta'+respuesta+'_'+numpreg);
            
            $("#res"+i+"_"+numpreg).attr("name", 'res'+respuesta+'_'+numpreg);
            $("#res"+i+"_"+numpreg).attr("id", 'res'+respuesta+'_'+numpreg);//Para que se usa esta?
            
            $("#respuesta"+i+"_"+numpreg).attr("name", 'respuesta'+respuesta+'_'+numpreg);
            $("#respuesta"+i+"_"+numpreg).attr("id", 'respuesta'+respuesta+'_'+numpreg);
            
            $("#eliminarrespuesta"+i+"_"+numpreg).attr("onclick", 'eliminarRespuestaMC(tablarespuesta'+respuesta+'_'+numpreg+','+numpreg+')');
            $("#eliminarrespuesta"+i+"_"+numpreg).attr("id", 'eliminarrespuesta'+respuesta+'_'+numpreg);
            
            $("#correcta"+i+"_"+numpreg).attr("onclick", 'InvertirRespuesta(correcta'+respuesta+'_'+numpreg+',0)');
            $("#correcta"+i+"_"+numpreg).attr("id", 'correcta'+respuesta+'_'+numpreg);
            
            $("#valorcorrecta"+i+"_"+numpreg).attr("id", 'valorcorrecta'+respuesta+'_'+numpreg);
            
            respuesta=respuesta+1;
        }
    }
    //resto uno a las prespuestas de la pregunta
    numresp--;
    $("#num_res_preg"+numpreg).attr("value", numresp);
}


function InvertirRespuesta(correcta,valor){
    if(valor=="0"){
        correcta.src="./imagenes/correcto.png";
        correcta.setAttribute("onclick",'InvertirRespuesta('+correcta.id+",1)");
        correcta.setAttribute("title", "Cambiar a Incorrecta");
        $("#valor"+correcta.id).attr("value", 1);
    }else{
        correcta.src="./imagenes/incorrecto.png";
        correcta.setAttribute("onclick",'InvertirRespuesta('+correcta.id+",0)");
        correcta.setAttribute("title", "Cambiar a Correcta");
        $("#valor"+correcta.id).attr("value", 0);
    }
}

function botonCorregirMultiChoice(){
    var preg=document.getElementById("num_preg");
    for (i=1; i<=preg.value; i++) {//para cada pregunta
        //obtengo el numero de respuestas de la pregunta
        var nrep_preg=document.getElementById("num_res_preg"+i);
            
        for (j=1; j<=nrep_preg.value; j++){ //Para cada respuesta
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
                imagen.style.cssFloat="right";
                
                midiv.appendChild(imagen);
            }else{
                imagen = document.createElement("img");
                imagen.style.height="15px";
                imagen.style.width="15px";
                imagen.src='./imagenes/incorrecto.png';
                imagen.style.cssFloat="right";
               
                midiv.appendChild(imagen);
            }
        }
    }
}