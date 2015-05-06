/*
  Daf-collage is made up of two Moodle modules which help in the process of
  German language learning. It facilitates the content organization like
  vocabulary or the main grammar features and gives the chance to create
  exercises in order to consolidate knowledge.

  Copyright (C) 2011

  Coordination:
  Ruth Burbat

  Source code:
  Francisco Javier Rodríguez López (seiyadesagitario@gmail.com)
  Simeón Ruiz Romero (simeonruiz@gmail.com)
  Serafina Molina Soto(finamolinasoto@gmail.com)

  Original idea:
  Ruth Burbat

  Content design:
  Ruth Burbat
  AInmaculada Almahano Güeto
  Andrea Bies
  Julia Möller Runge
  Blanca Rodríguez Gómez
  Antonio Salmerón Matilla
  María José Varela Salinas
  Karin Vilar Sánchez

  This program is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License
  as published by the Free Software Foundation; either version 2
  of the License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details. */

/**
 * Busca una palabra en el diccionario online seleccionado
 *
 * @param elemento Indice para seleccionar el elemento del que obtener la palabra
 */

function traducir(elemento) {
    var palabra;
    switch (elemento) {
        case 1:
            palabra = document.getElementById("id_palabra_sus").value;
            break;
        case 2:
            palabra = document.getElementById("id_infinitivo").value;
            break;
        case 3:
            palabra = document.getElementById("id_sindeclinar").value;
            break;
        case 4:
            palabra = document.getElementById("id_palabra_otr").value;
            break;
        default:
            break;
    }
    var url;
    var dic = document.getElementById("id_diccionario").value;
    if(dic == 1) {
        url = "http://dict.leo.org/esde?lp=esde&lang=de&search=" + palabra;
    } else if(dic == 0) {
        url = "http://www.dwds.de/?qu=" + palabra + "&view=1";
    } else if(dic == 2) {
        url = "http://de.pons.eu/dict/search/results/?q=" + palabra + "&l=dees";
    } else if(dic == 3) {
        url = "http://www.openthesaurus.de/synonyme/" + palabra;
    } else if(dic == 4) {
        url = "http://www.duden.de/suchen/dudenonline/" + palabra;
    }
    window.open(url, 'diccionario');
}

function eliminandonube(idtocho,idpalabra){
    if(confirm('Está seguro que desea eliminar?')){
        document.location='./guardar.php?id_tocho=' + idtocho +'&viene=0&borrar='+idpalabra;
    }else{ alert('Operacion Cancelada');}
   //location.href="./guardar.php?id_tocho=" + idtocho +"&viene=0&borrar="+idpalabra;
}
/**
 * Carga el contenido de un fichero php
 * @param miselect
 * @param otroselect
 * @param tipo
 */

function cargaContenido(miselect, otroselect, tipo, aux) {

    var objeto = document.getElementById(miselect);
    var elselect = objeto.value;
    var nombre = objeto.name;
    var eltxt = objeto.options[objeto.selectedIndex].text;

    var finalgramatica = $('input[name='+aux+']');
    finalgramatica.val(elselect);

    oculto = document.getElementById('id_desc_btn'); // Ocultar
    if (oculto) oculto.disabled = true;

    if(elselect == 0 || elselect == 1 || eltxt == "Seleccionar") {
        document.getElementById(otroselect).innerHTML = "";
    } else {
        document.getElementById(otroselect).innerHTML = '<p style="text-align: center;"><img src="./imagenes/loading.gif"/></p>';
        if(window.XMLHttpRequest) {//para que se vea en IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {//para que se vea en IE6, IE5 y otros
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById(otroselect).innerHTML = xmlhttp.responseText;
                $('#'+otroselect+' select').chosen();
            }
        }
       
        if(tipo == 0) {//campos lexicos
            xmlhttp.open("GET", "subcampos.php?id=" + elselect + "&nombre=" + nombre, true);
        } else if(tipo == 1 && eltxt != "Seleccionar") {//gramaticas
            xmlhttp.open("GET", "subgramaticas.php?id=" + elselect + "&nombre=" + nombre + "&aux="+ finalgramatica.attr("name"), true);
        } else if(tipo == 2 && eltxt != "Seleccionar") {//intenciones comunicativas
            xmlhttp.open("GET", "subintenciones.php?id=" + elselect + "&nombre=" + nombre, true);
        }
        xmlhttp.send();
    }
}

/**
 * Establece al valor "none" el atributo de estilo 'display' de todos aquellos
 * elementos que estén marcados en su id con el prefijo "ocultador_".
 *
 * @param seccion Id de los elementos a ocultar (sin incluir el prefijo 'ocultador_')
 */

function ocultar(seccion) {
    ocu = document.getElementById("ocultador_" + seccion);
    ocu.style.display = "none";
    enlace = document.getElementById("mc" + seccion);
    enlace.href = "javascript:desocultar('" + seccion + "')";
}

/**
 * Elimina el contenido del atributo de estilo 'display' de todos aquellos
 * elementos que estén marcados en su id con el prefijo "ocultador_" para usar
 * el valor por defecto de este atributo.
 *
 * @param seccion Id de los elementos a ocultar (sin incluir el prefijo 'ocultador_')
 */

function desocultar(seccion) {
    ocu = document.getElementById("ocultador_" + seccion);
    ocu.style.display = "";
    enlace = document.getElementById("mc" + seccion);
    enlace.href = "javascript:ocultar('" + seccion + "')";
}

/**
 * Establece a "true" el valor del atributo 'disabled' de todos los elementos
 * de un formulario con id "mform1" desde un cierto índice hasta el final.
 *
 * @param ini Índice a partir del cual se comienzan a deshabilitar elementos.
 */

function desactivar_todo(ini) {
    for( i = ini; i < document.getElementById("mform1").elements.length - 3; i++)
        document.getElementById("mform1").elements[i].disabled = true;
}

/**
 * Establece a "false" el valor del atributo 'disabled' de todos los elementos
 * de un formulario con id "mform1".
 */

function activar_todo() {
    for( i = 0; i < document.getElementById("mform1").elements.length; i++)
        document.getElementById("mform1").elements[i].disabled = false;
}

/**
 * Comprueba si tienes las cookies habilitadas, y en caso contrario te manda a un tutorial
 */

function comprobar_cookies(){
    if (navigator.cookieEnabled == 0) {
        alert("Este sitio necesita tener habilitadas cookies. Pulse aceptar para saber cómo puede habilitarlas");
        window.open('./habilitar_cookies.html','','location=no,directories=no, status=no,menubar=no,resizable=no');
    }
}

/**
 * @author Antonio Fernández Ares
 */

function la_tabla_nube() {
    var oTable = $('#palabras').dataTable({
        "bJQueryUI": true,
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ entradas por página",
            "sZeroRecords": "No se encontró nada",
            "sInfo": "Mostrando _START_ de _END_ de un total de _TOTAL_ entradas",
            "sInfoEmpty": "Mostrando 0 de 0 de un total de 0 entradas",
            "sInfoFiltered": "(Filtrado de _MAX_ entradas)"
        },
        "aLengthMenu": [[50,30,20,10,-1], [50,30,20,10,"All"]],
        "iDisplayLength": 50
    });


    $('#palabras tbody tr td').live('click', function (){
        var nTds = $(this);
        //alert (nTds.html());
        if (nTds.html().search("<a") == -1){
            oTable.fnFilter(nTds.html());
        }
        
    });
}

$(document).ready(function(){
    $('#content select').each(function(){
        $(this).chosen();
    });
    
    //Expandir funcionalidad JQuery
    (function($){
	$.fn.styleddropdown = function(){
		return this.each(function(){
			var obj = $(this)
			obj.find('.field').click(function() { //onclick event, 'list' fadein
			obj.find('.list').fadeIn(400);
			
			$(document).keyup(function(event) { //keypress event, fadeout on 'escape'
				if(event.keyCode == 27) {
				obj.find('.list').fadeOut(400);
				}
			});
			
			obj.find('.list').hover(function(){ },
				function(){
					$(this).fadeOut(400);
				});
			});
			
			obj.find('.list li').click(function() { //onclick event, change field value with selected 'list' item and fadeout 'list'
			obj.find('.field')
				.val($(this).html())
				.css({
					'background':'#fff',
					'color':'#333'
				});
			obj.find('.list').fadeOut(400);
			});
		});
	};
    })(jQuery);
    
    //Activar
    $(function(){
	$('.size').styleddropdown();
    });
});

function mi_alerta(){
confirmar=confirm("Seleccione de las siguientes opciones");

if (confirmar)
alert('Seleccionaste aceptar')
else
alert('Seleccionaste cancelar')
}


function mis_gramaticas_addFila57() {
    var i = parseInt($('#avance').val());
    var avance = 5;
    var tabla = $('#tabla');
    var tbody = $(tabla.children());
    
    var tr = '<tr class="cell">';
    tr += '<td style="width: 80px;"><input style="width: 80px;" type="text" id="id_VORSUB' + i + '" name="VORSUB' + i + '" value=""></td>';
    tr += '<td><input type="text" id="id_VER1' + i + '" name="VER1' + i + '" value=""></td>';
    tr += '<td style="width: 500px;"><input style="width: 500px;" type="text" id="id_MIT' + i + '" name="MIT' + i + '" value=""></td>';
    tr += '<td style="background: #BDC7D8;"><input type="text" style="background: #BDC7D8;" id="id_VER2' +i+  '" name="VER2' + i + '" value=""></td>';
    tr += '<td style="background: #BDC7D8;"><input type="text" style="background: #BDC7D8;" id="id_KONSUB' + i + '" name="KONSUB' +i + '" value=""></td>';
    tr += '</tr>';
    
    $(tr).appendTo(tbody);
    $('#avance').val(i+avance);
}

function mis_gramaticas_addFila56() {
    var $i = parseInt($('#avance').val());
    var avance = 4;
    var tabla = $('#tabla');
    var tbody = $(tabla.children());
    
    var $titulillos = '<tr class="cell">';
    $titulillos += '<td><input type="text" id="id_VORSUB' + $i + '" name="VORSUB' + $i + '" value=""></td>';
    $titulillos += '<td style="background: #BDC7D8;"><input type="text" style="background: #BDC7D8;" id="id_KONSUB' + $i + '" name="KONSUB' + $i + '" value=""></td>';
    $titulillos += '<td style="width: 500 px;"><input style="width:495px;" type="text" id="id_MIT' + $i + '" name="MIT' + $i +'" value=""></td>';
    $titulillos += '<td style="background: #BDC7D8;"><input type="text" style="background: #BDC7D8;" id="id_VER2' + $i + '" name="VER2' + $i + '" value=""></td>';
    $titulillos += '</tr>';
    
    $($titulillos).appendTo(tbody);
    $('#avance').val($i+avance);
}

/*******************************************/

function EV_Validation(tam){
    
    //alert("Entro");
    //alert(document.getElementById("traduccion0").value);
    
    var valores = new Array();
    //valor = document.getElementById("traduccion0").value;
    
    for(i=0; i<tam; i++){
        //alert(document.getElementById("traduccion_usuario" + i).value);
        valores.push(document.getElementById("traduccion_usuario" + i).value);
        if(document.getElementById("traduccion_usuario" + i).value == document.getElementById("traduccion" + i).value){
            alert('[Bien] Eres un crack!');
        }else{
            alert('[Mal] Salte de la carrera...');
        }
        
    }
    
    
    if(valor == "a"){
        alert('[ERROR] El campo debe tener un valor de...');
    }else{
        alert('[ERROR] El campo debe tener un valor de...');
    }
}