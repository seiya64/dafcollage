<?php

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
  Angel Biedma Mesa (tekeiro@gmail.com)

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

require_once($CFG->dirroot . '/course/moodleform_mod.php');
require_once("ejercicios_clases.php");
require_once("ejercicios_clase_general.php");
require_once("YoutubeVideoHelper.php");

//Funcion para pasar una variable de PHP a Javascript
function php2js ($var) {

    if (is_array($var)) {
        $res = "[";
        $array = array();
        foreach ($var as $a_var) {
            $array[] = php2js($a_var);
        }
        return "[" . join(",", $array) . "]";
    }
    elseif (is_bool($var)) {
        return $var ? "true" : "false";
    }
    elseif (is_int($var) || is_integer($var) || is_double($var) || is_float($var)) {
        return $var;
    }
    elseif (is_string($var)) {
        return "'" . addslashes(stripslashes($var)) . "'";
    }

    return FALSE;
}


/* Formulario generico de ejercicos de cualquier tipo de actidad
 * @author Serafina Molina Soto
 * Multichoice con sus variantes 1
 * Asocicacion simple 2
 * Asociacion complejo 3
 */

class mod_ejercicios_mostrar_identificar_elementos extends moodleform_mod {

    function mod_ejercicios_mostrar_identificar_elementos($id, $id_ejercicio, $tipo_origen) {
        // El fichero que procesa el formulario es gestion.php
        parent::moodleform('ejercicios_modificar_identificar_elementos.php?id_curso=' . $id . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen);
        echo "En el constructor de mostrar IE";
    }

    function definition() {
        
    }

    /**
     * Function that add a table to the forma to show the main menu
     *
     * @author Serafina Molina Soto
     * @param $id id for the course
     * @param $id_ejercicio id del ejercicio a mostrar
     */
    function mostrar_ejercicio_identificar_elementos($id, $id_ejercicio, $buscar, $tipo_origen) {
        echo "INICIO MOSTRAR EJERCICIO IDENTIFICAR ELEMENTOS";
        
        global $CFG, $COURSE, $USER;
        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);


        //Los iconos están sacados del tema de gnome que viene con ubuntu 11.04
        //inclusion del javascript para las funciones

        $mform = & $this->_form;
        echo "COGIDO FORM";
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./style.css">');
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./estilo.css">');
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="./funciones.js"></script>');
        //Cojo el ejercicio  de la bd a partir de su id (id_ejercicio)

        echo "mostrando formulario identificar elementos";
        $ejercicios_bd = new Ejercicios_general();
        $ejercicios_leido = $ejercicios_bd->obtener_uno($id_ejercicio);


        $nombre = $ejercicios_leido->get('name');
        $npreg = $ejercicios_leido->get('numpreg');
        $creador = $ejercicios_leido->get('id_creador');
        $tipo_origen = $ejercicios_leido->get('tipoarchivopregunta');
        
        

        if ($creador == $USER->id && has_capability('moodle/legacy:editingteacher', $context, $USER->id, false)) {
            $modificable = true;
        } else {
            $modificable = false;
        }

        $titulo = '<h1>' . $nombre . '</h1>';
        $mform->addElement('html', $titulo);



        $divdescripcion = '<div class=descover>';



        $divdescripcion.=nl2br((stripslashes($ejercicios_leido->get('descripcion'))));
        $divdescripcion.=$parte . '<br/>';

        $divdescripcion.='</div>';

        $mform->addElement('html', $divdescripcion);
        switch($tipo_origen) {
            case 1: //Si es texto
                //Añado el texto de origen
                $el_texto_origen = new Ejercicios_textos();
                $el_texto_origen->obtener_uno_id_ejercicio($id_ejercicio);
                echo "aki entra";
                echo "por lo que estoy en texto texto";
                if ($buscar == 1 || $modificable == false) { //Para que no pueda editarlo
                    $divtexto = '<div class="desctexto" name="texto" id="texto"><div class="margenes">' . nl2br((stripslashes($el_texto_origen->get('texto')))) . '</div></div>';
                } else {
                    $divtexto = '<textarea class="adaptHeightInput" name="texto" id="texto">' . $el_texto_origen->get('texto') . '</textarea>';
                }

                $mform->addElement('html', $divtexto);
                break;
            case 2: // Es audio
                //Añado el texto de origen
                $mform->addElement('html', '<script type="text/javascript" src="./mediaplayer/swfobject.js"></script>');
                $divaudio = '<div class="claseaudio" id="player1"></div>';
                $mform->addElement('html', $divaudio);
                $mform->addElement('html', '<script type="text/javascript"> var so = new SWFObject("./mediaplayer/mediaplayer.swf","mpl","350","20","7");
                        so.addParam("allowfullscreen","true");
                        so.addVariable("file","./mediaplayer/audios/audio' . $id_ejercicio . '.mp3");
                        so.addVariable("height","20");
                        so.addVariable("width","320");
                        so.write("player1");
                        </script>');
                break;
            case 3: // Es video
                //Añado el video de origen

          
                $el_video_origen = new Ejercicios_videos();
                $el_video_origen->obtener_uno_id_ejercicio($id_ejercicio);
                $vervideo = '<object width="560" height="315" class="video">
                                        <param name="movie" value="http://www.youtube.com/v/' . $el_video_origen->get('video') . '?hl=es_ES&amp;version=3">
                                        </param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param>
                                        <embed src="http://www.youtube.com/v/' . $el_video_origen->get('video') . '?hl=es_ES&amp;version=3" type="application/x-shockwave-flash" width="560" height="315" allowscriptaccess="always" allowfullscreen="true">
                                        </embed></object>';

                if ($buscar == 1 || $modificable == false) { //Para que no pueda editarlo
                    $vervideo .= "";
                } else {
                    $yvh = YoutubeVideoHelper::generarVideoUrl($el_video_origen->get('video'));

                    $vervideo.= '<textarea class="video" name="archivovideo" id="archivovideo">' . $yvh . '</textarea>';
                }
                $mform->addElement('html', $vervideo);
                break;
        }

        
        //El tipo respuesta siempre es texto
        $tabla_imagenes = '<table width="100%">';

        $tabla_imagenes .='<td>'; #columna

        $mform->addElement('html', $tabla_imagenes);

        //Obtengo las preguntas
        $mis_preguntas = new Ejercicios_texto_texto_preg();
        $preguntas = $mis_preguntas->obtener_todas_preguntas_ejercicicio($id_ejercicio);
        
        //Matrix de las preguntas
        $matrix_preguntas=array();
        for ($i = 1; $i <= sizeof($preguntas); $i++) {


            //Pinto la pregunta
            $divpregunta = '<div id="tabpregunta' . $i . '" >';
            $divpregunta.='<br/><br/>';
            $divpregunta.='<table style="width:100%;">';
            $divpregunta.=' <td style="width:80%;">';
            //   $divpregunta.='<div id="id_pregunta1" name="pregunta1">';
            if ($buscar == 1 || $modificable == false) { //Para que no pueda editarlo
                $divpregunta.='<div style="width: 900px;" class="pregunta" name="pregunta' . $i . '" id="pregunta' . $i . '">' . $preguntas[$i - 1]->get('pregunta') . '</div>';
            } else {
                $divpregunta.='<textarea style="width: 900px;" class="pregunta" name="pregunta' . $i . '" id="pregunta' . $i . '">' . $preguntas[$i - 1]->get('pregunta') . '</textarea>';
            }
            // $divpregunta.='<input name="pregunta1" type="text" style="width:80%; height:100%; margin:1%;">ssss</input>';
            //  $divpregunta.=$preguntas[0]->get('Pregunta');
            //$divpregunta.='</div>';

            $divpregunta.=' </td>';

            if ($buscar != 1 && $modificable == true) {
                $divpregunta.=' <td style="width:5%;">';
                $divpregunta.='<img id="imgpregborrar' . $i . '" src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="EliminarPregunta_IE(tabpregunta' . $i . ',' . $i . ')" title="Eliminar Pregunta"></img>';
                $divpregunta.='</br><img id="imgpreganadir' . $i . '" src="./imagenes/añadir.gif" alt="eliminar respuesta"  height="15px"  width="15px" onClick="anadirRespuesta_IE(respuestas' . $i . ',' . $i . ')" title="Añadir Respuesta"></img>';
                $divpregunta.='</td> ';
                $divpregunta.='</br> ';
            }
            $divpregunta.='</table> ';


            //Obtengo las respuestas a la pregunta

            $id_pregunta = $preguntas[$i - 1]->get('id');
            $mis_respuestas = new Ejercicios_ie_respuestas();
            $respuestas = $mis_respuestas->obtener_todos_id_pregunta($id_pregunta);
            
            //Recoger el texto de las respuestas del profesor desde la base de datos
            $respuestas_prof = array();
            for ($p = 0; $p < sizeof($respuestas); $p++) {
                echo "Respuesta del profesor " . ($p+1) . " : " . $respuestas[$p]->get('respuesta') . "<br/>";
                $q = $p + 1;
                $respuestas_prof[] = $respuestas[$p]->get('respuesta'); 
            }
            $matrix_preguntas[] = $respuestas_prof;

            $divpregunta.='</br><div id="respuestas' . $i . '" class=respuesta>';
            for ($p = 0; $p < sizeof($respuestas); $p++) {
                $q = $p + 1;
                
                if ($q%2==0 || $q==sizeof($respuestas)) {
                    $divpregunta.='<table  id="tablarespuesta' . $q . '_' . $i . '" style="width:50%;">';
                }
                else {
                    $divpregunta.='<table  id="tablarespuesta' . $q . '_' . $i . '" style="width:50%;float:left;">';
                }
                $divpregunta.='<tr id="trrespuesta' . $q . "_" . $i . '"> ';
                $divpregunta.=' <td style="width:80%;">';

                
                


                //   $divpregunta.='<div class="resp" name="respuesta'.$q."_".$i.'" id="respuesta'.$q."_".$i.'" contentEditable=true>';
                //   $divpregunta.=$preguntas[$p]->get('Respuesta');
                //   $divpregunta.='</div>';
                if ($buscar == 1 || $modificable == false) {
                    //$divpregunta.='<div style="width: 700px;" class="resp" name="respuesta' . $q . "_" . $i . '" id="respuesta' . $q . "_" . $i . '" value="' . $respuestas[$p]->get('respuesta') . '">' . $respuestas[$p]->get('respuesta') . '</div>';
                    $divpregunta.='<textarea style="width: 300px;" class="resp" name="respuesta' . $q . "_" . $i . '" id="respuesta' . $q . "_" . $i . '"></textarea>';
                } else {
                    $divpregunta.='<textarea style="width: 300px;" class="resp" name="respuesta' . $q . "_" . $i . '" id="respuesta' . $q . "_" . $i . '" value="' . $respuestas[$p]->get('respuesta') . '">' . $respuestas[$p]->get('respuesta') . '</textarea>';
                }
                $divpregunta.=' </td>';
                $divpregunta.=' <td style="width:5%;" id="tdcorregir'. $q . "_" . $i .'">';

                if ($buscar != 1 && $modificable == true) {
                    //La imagen para eliminar las respuestas
                    $divpregunta.='<img id="eliminarrespuesta' . $q . '_' . $i . '" src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="EliminarRespuesta_IE(tablarespuesta' . $q . '_' . $i . ',' . $i . ')" title="Eliminar Respuesta"></img>';


                   

                    
                }

                $divpregunta.='</td> ';
                $divpregunta.='<tr>';

                $divpregunta.='</table> ';
            }


            $divpregunta.='</div>';

            $divpregunta.='</div>';

            $divpregunta.='<input type="hidden" value=' . sizeof($respuestas) . ' id="num_res_preg' . $i . '" name="num_res_preg' . $i . '" />';
            $mform->addElement('html', $divpregunta);
            //Introduzco el número de respuestas de la pregunta
            //$mform->addElement('hidden', 'num_res_preg'.$i,$numero_respuestas);
        }

        $divnumpregunta = '<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
        $mform->addElement('html', $divnumpregunta);



        //Si soy el dueño del ejercicio y no estoy buscando boton guardar
        if ($buscar != 1 && $modificable == true) {
            //Pinto los botones
            //boton añadir pregunta
            $botones = '<input type="button" style="height:30px; width:100px; margin-left:30px; margin-top:20px;" id="id_Añadir" value="Añadir Pregunta" onclick="javascript:botonMasPreguntas_IE()">';
            $botones.='<input type="submit" style="height:30px; width:100px; margin-left:90px; margin-top:20px;" id="submitbutton" name="submitbutton" value="' . get_string('BotonGuardar', 'ejercicios') . '">';
            $mform->addElement('html', $botones);
            /* $buttonarray = array();
              $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('BotonGuardar','ejercicios'));
              $mform->addGroup($buttonarray, 'botones', '', array(' '), false);

             */
        } else {
            if ($buscar == 1) { //Si estoy buscand
                $ejercicios_prof = new Ejercicios_prof_actividad();
                $ejercicios_del_prof = $ejercicios_prof->obtener_uno_idejercicio($id_ejercicio);
                if (sizeof($ejercicios_del_prof) == 0) {
                    $noagregado = true;
                } else {
                    $noagregado = false;
                }

                //compruebo si soy profesor
                if (has_capability('moodle/legacy:editingteacher', $context, $USER->id, false) && ($modificable == false || $noagregado == true)) {
                    //boton añadir a mis ejercicios
                    $attributes = 'size="40"';
                    $mform->addElement('text', 'carpeta_ejercicio', get_string('carpeta', 'ejercicios'), $attributes);
                    $mform->addRule('carpeta_ejercicio', "Carpeta Necesaria", 'required', null, 'client');
                    $buttonarray = array();
                    $buttonarray[] = &$mform->createElement('submit', 'submitbutton2', get_string('BotonAñadir', 'ejercicios'));
                    $mform->addGroup($buttonarray, 'botones2', '', array(' '), false);
                    //boton menu principal
                    $tabla_menu = '<center><input type="button" style="height:30px; width:100px; margin-left:30px; margin-top:20px;"  id="id_Menu" value="Menu Principal" onClick="javascript:botonPrincipal(' . $id . ')" /></center>';

                    $mform->addElement('html', $tabla_menu);
                } else {

                    if ($modificable == true) { // Si el ejercicio era mio y estoy buscando
                        $tabla_menu = '<center><input type="button" style="height:30px; width:100px; margin-left:30px; margin-top:20px;"  id="id_Menu" value="Menu Principal" onClick="javascript:botonPrincipal(' . $id . ')" /></center>';

                        $mform->addElement('html', $tabla_menu);
                    } else {//soy alumno
                        $tabla_menu = '<center><input type="button" name="corregirIE" style="height:30px; width:100px; margin-left:175px;"  value="Corregir" id="id_corregirIE" onClick="javascript:botonCorregirIE('.$id.",".php2js($matrix_preguntas).')"/> <input type="button" style="height:30px; width:100px; margin-left:30px; margin-top:20px;"  id="id_Menu" value="Menu Principal" onClick="javascript:botonPrincipal(' . $id . ')" /></center>';

                        $mform->addElement('html', $tabla_menu);
                    }
                }
            } else { //Estoy buscando o no
                // compruebo si soy profesor
                if (has_capability('moodle/legacy:editingteacher', $context, $USER->id, false)) {

                    $tabla_menu = '<center><input type="button" style="height:30px; width:100px; margin-left:30px; margin-top:20px;"  id="id_Menu" value="Menu Principal" onClick="javascript:botonPrincipal(' . $id . ')" /></center>';

                    $mform->addElement('html', $tabla_menu);
                } else {


                    $tabla_menu = '<center><input type="button" style="height:30px; width:100px; margin-left:175px;"  value="Corregir" id="id_corregirIE" onClick="javascript:botonCorregirIE('.$id.",".php2js($matrix_preguntas).')"/> <input type="button" style="height:30px; width:100px; margin-left:30px; margin-top:20px;"  id="id_Atras" value="Atrás" onClick="javascript:botonAtras(' . $id . ')" /><input type="button" style="height:30px; width:100px; margin-left:30px; margin-top:20px;"  id="id_Menu" value="Menu Principal" onClick="javascript:botonPrincipal(' . $id . ')" /></center>';

                    $mform->addElement('html', $tabla_menu);
                }
            }
        }

        $tabla_imagenes = '</td>';
        $tabla_imagenes .='<td  width="10%">';
        //Mis palabras
        $tabla_imagenes .='<div><a  onclick=JavaScript:sele(' . $id . ')><img src="../vocabulario/imagenes/guardar_palabras.png" id="id_guardar_im" name="guardar_im" title="' . get_string('guardar', 'vocabulario') . '"/></a></div>';
        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=5" target="_blank"><img src="../vocabulario/imagenes/administrar_gramaticas.png" id="id_gram_im" name="gram_im" title="' . get_string('admin_gr', 'vocabulario') . '"/></a></div>';
        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=7" target="_blank"><img src="../vocabulario/imagenes/intenciones_comunicativas.png" id="id_ic_im" name="ic_im" title="' . get_string('admin_ic', 'vocabulario') . '"/></a></div>';
        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=9" target="_blank"><img src="../vocabulario/imagenes/tipologias_textuales.png" id="id_tt_im" name="tt_im" title="' . get_string('admin_tt', 'vocabulario') . '"/> </a></div>';
        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=11" target="_blank"><img src="../vocabulario/imagenes/estrategias_icon.png" id="id_ea_im" name="ea_im" title="' . get_string('admin_ea', 'vocabulario') . '"/> </a></div>';

        $tabla_imagenes .='</td>';

        $tabla_imagenes .='</table>';
        $mform->addElement('html', $tabla_imagenes);
    }

}

?>
