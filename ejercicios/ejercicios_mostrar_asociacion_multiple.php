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

class mod_ejercicios_mostrar_ejercicio_asociacion_multiple extends moodleform_mod {

    function mod_ejercicios_mostrar_ejercicio_asociacion_multiple($id, $id_ejercicio, $tipo_origen, $tipo_respuesta, $tipocreacion) {
        // El fichero que procesa el formulario es gestion.php
        parent::moodleform('ejercicios_modificar_asociacion_multiple.php?id_curso=' . $id . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $tipo_respuesta . '&tipocreacion=' . $tipocreacion);
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
    function mostrar_ejercicio_asociacion_multiple($id, $id_ejercicio, $buscar, $tipo_origen, $tipo_respuesta, $tipocreacion) {



        global $CFG, $COURSE, $USER;
        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);
        echo "<br/>Directorio de librerias: " . $CFG->libdir . "<br/>";


        //Los iconos están sacados del tema de gnome que viene con ubuntu 11.04
        //inclusion del javascript para las funciones

        $mform = & $this->_form;
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./style.css">');
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./estilo.css">');
        //$mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>');
        //$mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>');
        
        //$mform->addElement('html', '<script type="text/javascript" src="./js/jquery.min.js"></script>');
        
        
          $mform->addElement('html','<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>');
          $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.js"></script>');

          $mform->addElement('html', '<script type="text/javascript" src="./funciones.js"></script>');
        //Cojo el ejercicio  de la bd a partir de su id (id_ejercicio)
        //Obtengo el ejercicio de la bd
        $ejercicios_bd = new Ejercicios_general();
        $ejercicios_leido = $ejercicios_bd->obtener_uno($id_ejercicio);

        $nombre = $ejercicios_leido->get('name');
        $npreg = $ejercicios_leido->get('numpreg');
        $creador = $ejercicios_leido->get('id_creador');

        if ($creador == $USER->id && has_capability('moodle/legacy:editingteacher', $context, $USER->id, false)) {
            $modificable = true;
        } else {
            $modificable = false;
        }

        //Añado el título
        $titulo = '<h1>' . $nombre . '</h1>';
        $mform->addElement('html', $titulo);

        //Añado la descripción

        $divdescripcion = '<div class=descover>';

        $divdescripcion.=nl2br((stripslashes($ejercicios_leido->get('descripcion'))));
        $divdescripcion.=$parte . '<br/>';

        $divdescripcion.='</div>';

        $mform->addElement('html', $divdescripcion);


        $tabla_imagenes = '<table width="100%">';

        $tabla_imagenes .='<td>'; #columna
        
        $mform->addElement('html', $tabla_imagenes);


        echo "tipo origen.$tipo_origen";
        //compruebo de que tipo es el origen
        switch ($tipo_origen) {

            case 1: //Es de tipo texto la pregunta

                echo "tipo respuesta.$tipo_respuesta";
                switch ($tipo_respuesta) {
                    case 1: //Es de tipo texto la respuesta
                        //Obtengo las preguntas
                        $mis_preguntas = new Ejercicios_texto_texto_preg();
                        $preguntas = $mis_preguntas->obtener_todas_preguntas_ejercicicio($id_ejercicio);
                        echo "<br/>Saca las preguntas: buscar=".$buscar." modificable=".($modificable==false);

                        if ($buscar == 1 || $modificable == false) {
                            echo "<br/>Aqui no debe entrar";
                            $tabla_imagenes.='<center><table id="tablapreg" name="tablapreg">';
                            $tabla_imagenes.="<tr>";
                            //Inserto las preguntas con clase "item" es decir dragables(mirar javascript.js)
                            for ($i = 1; $i <= sizeof($preguntas); $i++) {

                                //Obtengo la pregunta
                                $tabla_imagenes.='<td id="texto' . $i . '"> <div class="item" id="' . $i . '">';

                                $tabla_imagenes.='<p style="margin-top: 10%;">' . $preguntas[$i - 1]->get('pregunta') . '</p>';

                                $tabla_imagenes.='</div></div></td>';
                                if ($i % 2 == 0) { //Si es impar lo bajo
                                    $tabla_imagenes.="</tr>";
                                }
                            }
                            $tabla_imagenes.="</tr>";
                            $tabla_imagenes.='</table></center>';
                            $tabla_imagenes.="</br>";
                            $tabla_imagenes.="</br>";
                            $tabla_imagenes.='<table id="tablarespuestas" name="tablarespuestas"><center>';

                            $k = 1;
                            $las_respuestas[sizeof($preguntas) + 1];
                            $aleatorios_generados = array();
                            while ($k <= sizeof($preguntas)) {
                                //Obtengo la respuestas (En este caso sólo habrá 1, ya que es "simple")

                                $id_pregunta = $preguntas[$k - 1]->get('id');
                                $mis_respuestas = new Ejercicios_texto_texto_resp();

                                $respuestas = $mis_respuestas->obtener_todas_respuestas_pregunta($id_pregunta);

                                //Para cada respuesta

                                srand(time());
                                //generamos un número aleatorio entre 1 y el número de pregutnas
                                $numero_aleatorio = rand(1, sizeof($preguntas));

                                //buscamos si aleatorios contine
                                $esta = '0';


                                for ($j = 0; $j < sizeof($aleatorios_generados); $j++) {

                                    if ($aleatorios_generados[$j] == $numero_aleatorio) {

                                        $esta = '1';
                                    }
                                }

                                if ($esta == '0') { //Si no esta lo inserto
                                    $las_respuestas[] = $respuestas[0]->get('respuesta');
                                    $aleatorios_generados[] = $numero_aleatorio;
                                    $k++;
                                }
                            }



                            for ($j = 0; $j < sizeof($aleatorios_generados); $j++) {
                                $tabla_imagenes.='<tr>';

                                $tabla_imagenes.='<td><div class=descripcion>';
                                $tabla_imagenes.=$las_respuestas[$aleatorios_generados[$j] - 1] . '</div></td>';

                                $tabla_imagenes.='<td><div  id="' . $aleatorios_generados[$j] . '" class="marquito"></div></td>';
                                $tabla_imagenes.='<td id="aceptado' . $aleatorios_generados[$j] . '" class="marquitoaceptado"></td>';
                                $tabla_imagenes.='</tr>';
                            }

                            $tabla_imagenes.='</table></center>';
                            $tabla_imagenes.='<p class="numero" id="' . sizeof($preguntas) . '"></p>';

                            //inserto el número de preguntas

                            $tabla_imagenes.='<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
                        } else {
                            echo "akiiiiiiii";
                            //$tabla_imagenes.='<table id="tablarespuestas" name="tablarespuestas"><center>';
                            

                            for ($i = 1; $i <= sizeof($preguntas); $i++) {
                                
                                //Pinto la pregunta
                                $divpregunta = '<div id="tabpregunta' . $i . '" >';
                                $divpregunta.='<br/><br/>';
                                $divpregunta.='<table style="width:100%;">';
                                $divpregunta.=' <td style="width:80%;">';

                                /*$tabla_imagenes.="<tr>";
                                $tabla_imagenes.='<td id="texto' . $i . '">';
                                $tabla_imagenes.='<textarea id="pregunta' . $i . '" name="pregunta' . $i . '" style="height: 197px; width: 396px;">' . $preguntas[$i - 1]->get('pregunta') . '</textarea>';
                                $tabla_imagenes.='</td>';*/
                                $divpregunta.='<textarea style="width: 900px;" class="pregunta" name="pregunta' . $i . '" id="pregunta' . $i . '">' . $preguntas[$i - 1]->get('pregunta') . '</textarea>';
                                $divpregunta.=' </td>';
                                
                                $divpregunta.=' <td style="width:5%;">';
                                $divpregunta.='<img id="imgpregborrar' . $i . '" src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="EliminarPregunta_IE(tabpregunta' . $i . ',' . $i . ')" title="Eliminar Pregunta"></img>';
                                $divpregunta.='</br><img id="imgpreganadir' . $i . '" src="./imagenes/añadir.gif" alt="eliminar respuesta"  height="15px"  width="15px" onClick="anadirRespuesta_IE(respuestas' . $i . ',' . $i . ')" title="Añadir Respuesta"></img>';
                                $divpregunta.='</td> ';
                                $divpregunta.='</br> ';
                                $divpregunta.='</table> ';

                                $id_pregunta = $preguntas[$i - 1]->get('id');
                                $mis_respuestas = new Ejercicios_texto_texto_resp();
                                $respuestas = $mis_respuestas->obtener_todas_respuestas_pregunta($id_pregunta);
                                
                                $divpregunta.='</br><div id="respuestas' . $i . '" class=respuesta>';
                                for ($p = 0; $p < sizeof($respuestas); $p++) {
                                    /*$tabla_imagenes.= '<tr><td/><td><textarea name="respuesta' . $i . "_" . ($j+1) . '" id="respuesta' . $i . "_" . ($j+1) . '" class=descripcion style="height: 192px; width: 401px;" >';
                                    $tabla_imagenes.=$respuestas[$j]->get('respuesta') . '</textarea></td>';
                                    $tabla_imagenes .= '<td><img id="imgpregpborrar' . $i . '" src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="EliminarRespuesta_TextoTexto_AM(tabpregunta' . $i . ',' . $i . ')" title="Eliminar Respuesta"></img></td></tr>';
                                     */                                     
                                    $q = $p + 1;
                
                                    if ($q%2==0 || $q==sizeof($respuestas)) {
                                        $divpregunta.='<table  id="tablarespuesta' . $q . '_' . $i . '" style="width:50%;">';
                                    }
                                    else {
                                        $divpregunta.='<table  id="tablarespuesta' . $q . '_' . $i . '" style="width:50%;float:left;">';
                                    }
                                    $divpregunta.='<tr id="trrespuesta' . $q . "_" . $i . '"> ';
                                    $divpregunta.=' <td style="width:80%;">';
                                    $divpregunta.='<textarea style="width: 300px;" class="resp" name="respuesta' . $q . "_" . $i . '" id="respuesta' . $q . "_" . $i . '" value="' . $respuestas[$p]->get('respuesta') . '">' . $respuestas[$p]->get('respuesta') . '</textarea>';
                                    $divpregunta.=' </td>';
                                    $divpregunta.=' <td style="width:5%;" id="tdcorregir'. $q . "_" . $i .'">';
                                    $divpregunta.='<img id="eliminarrespuesta' . $q . '_' . $i . '" src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="EliminarRespuesta_IE(tablarespuesta' . $q . '_' . $i . ',' . $i . ')" title="Eliminar Respuesta"></img>';
                                    
                                    $divpregunta.='</td> ';
                                    $divpregunta.='<tr>';

                                    $divpregunta.='</table> ';
                                    
                                }
                                
                                
                                //$tabla_imagenes.="</tr>";                                
                                //Inserto el numero de respuestas para cada pregunta
                                //$tabla_imagenes.='<input type="hidden" name="numrespuestas_' . $i . '" id="numrespuestas_' . $i . '" value="' . sizeof($respuestas) . '" />';
                                $divpregunta.='</div>';
                                $divpregunta.='</div>';
                                $divpregunta.='<input type="hidden" value=' . sizeof($respuestas) . ' id="num_res_preg' . $i . '" name="num_res_preg' . $i . '" />';
                                $mform->addElement('html', $divpregunta);
                            }
                            //$tabla_imagenes.='</table></center>';

                            //inserto el número de preguntas
                            $divnumpregunta = '<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
                            $mform->addElement('html', $divnumpregunta);
                            //$tabla_imagenes.='<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
                            
                            
                            
                            
                        }
                            


                        //botones
                        //$mform->addElement('html', $tabla_imagenes);


                        if ($buscar != 1 && $modificable == true) {
                            //Si soy el profesor creadors
                            $tabla_imagenes = '<input type="submit" style="height:40px; width:90px; margin-left:90px; margin-top:20px;" id="submitbutton" name="submitbutton" value="' . get_string('BotonGuardar', 'ejercicios') . '">';
                            $tabla_imagenes.='<input type="button" style="height:40px; width:120px;  margin-top:20px;" id="botonNA" name="botonNA" onclick="botonMasPreguntas_TextoAudio_AM('.$id_ejercicio.')" value="' . get_string('NuevaAso', 'ejercicios') . '">';
                            $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                        } else {
                            if ($buscar == 1) { //Si estoy buscand
                                $ejercicios_prof = new Ejercicios_prof_actividad();
                                $ejercicios_del_prof = $ejercicios_prof->obtener_uno_idejercicio($id_ejercicio);
                                if (sizeof($ejercicios_del_prof) == 0) {
                                    $noagregado = true;
                                } else {
                                    $noagregado = false;
                                }
                                //si el ejercicio no es mio y soy profesor
                                if (has_capability('moodle/legacy:editingteacher', $context, $USER->id, false) && ($modificable == false || $noagregado == true)) {
                                    //boton añadir a mis ejercicios
                                    $attributes = 'size="40"';
                                    $mform->addElement('text', 'carpeta_ejercicio', get_string('carpeta', 'ejercicios'), $attributes);
                                    $mform->addRule('carpeta_ejercicio', "Carpeta Necesaria", 'required', null, 'client');
                                    $buttonarray = array();
                                    $buttonarray[] = &$mform->createElement('submit', 'submitbutton2', get_string('BotonAñadir', 'ejercicios'));
                                    $mform->addGroup($buttonarray, 'botones2', '', array(' '), false);
                                } else {

                                    if ($modificable == true) { // Si el ejercicio era mio y estoy buscando
                                        $tabla_imagenes = '<center><input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                                    } else { //Si soy alumno
                                        $tabla_imagenes = '<center><input type="button" style="height:40px; width:60px;" id="botonResultado" value="Corregir">';
                                        $tabla_imagenes.='<input type="button" style="height:40px; width:60px;" id="botonRehacer" value="Rehacer" onClick="location.href=\'./view.php?id=' . $id . '&opcion=8' . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $tipo_respuesta . '&tipocreacion=' . $tipocreacion . '\'">';
                                        $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                                    }
                                }
                            } else {

                                $tabla_imagenes = '<center><input type="button" style="height:40px; width:60px;" id="botonResultado" value="Corregir">';
                                $tabla_imagenes.='<input type="button" style="height:40px; width:60px;" id="botonRehacer" value="Rehacer" onClick="location.href=\'./view.php?id=' . $id . '&opcion=8' . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $tipo_respuesta . '&tipocreacion=' . $tipocreacion . '\'">';
                                $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                            }
                        }


                        $tabla_imagenes .='</td>';
                        $tabla_imagenes .='<td  width="10%">';
                        //añado la parte de vocabulario para la conexión
                        $tabla_imagenes .='<div><a  onclick=JavaScript:sele(' . $id . ')><img src="../vocabulario/imagenes/guardar_palabras.png" id="id_guardar_im" name="guardar_im" title="' . get_string('guardar', 'vocabulario') . '"/></a></div>';
                        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=5"><img src="../vocabulario/imagenes/administrar_gramaticas.png" id="id_gram_im" name="gram_im" title="' . get_string('admin_gr', 'vocabulario') . '"/></a></div>';
                        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=7"><img src="../vocabulario/imagenes/intenciones_comunicativas.png" id="id_ic_im" name="ic_im" title="' . get_string('admin_ic', 'vocabulario') . '"/></a></div>';
                        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=9"><img src="../vocabulario/imagenes/tipologias_textuales.png" id="id_tt_im" name="tt_im" title="' . get_string('admin_tt', 'vocabulario') . '"/> </a></div>';
                        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=11"><img src="../vocabulario/imagenes/estrategias_icon.png" id="id_ea_im" name="ea_im" title="' . get_string('admin_ea', 'vocabulario') . '"/> </a></div>';

                        $tabla_imagenes .='</td>';

                        $tabla_imagenes .='</table>';

                        $mform->addElement('html', $tabla_imagenes);

                        break;
                    case 2: //Es de tipo audio la respuesta

                        echo "tipo respuesta es audio";

                        $mform->addElement('html', '<script src="./js/ajaxupload.js" type="text/javascript"></script>');


                        //Obtengo las preguntas que son texto
                        $mis_preguntas = new Ejercicios_texto_texto_preg();
                        $preguntas = $mis_preguntas->obtener_todas_preguntas_ejercicicio($id_ejercicio);


                        if ($buscar == 1 || $modificable == false) {
                            $tabla_imagenes.='<center><table id="tablapreg" name="tablapreg">';
                            $tabla_imagenes.="<tr>";
                            //Inserto las preguntas con clase "item" es decir dragables(mirar javascript.js)
                            for ($i = 1; $i <= sizeof($preguntas); $i++) {

                                //Obtengo la pregunta
                                $tabla_imagenes.='<td id="texto' . $i . '"> <div class="item" id="' . $i . '">';

                                $tabla_imagenes.='<p style="margin-top: 10%;">' . $preguntas[$i - 1]->get('pregunta') . '</p>';

                                $tabla_imagenes.='</div></div></td>';
                                if ($i % 2 == 0) { //Si es impar lo bajo
                                    $tabla_imagenes.="</tr>";
                                }
                            }
                            $tabla_imagenes.="</tr>";
                            $tabla_imagenes.='</table></center>';
                            $tabla_imagenes.="</br>";
                            $tabla_imagenes.="</br>";
                            $tabla_imagenes.='<table id="tablarespuestas" name="tablarespuestas"><center>';

                            $k = 1;
                            $las_respuestas[sizeof($preguntas) + 1];
                            $aleatorios_generados = array();
                            while ($k <= sizeof($preguntas)) {
                                //Obtengo la respuestas (En este caso sólo habrá 1, ya que es "simple")

                                $id_pregunta = $preguntas[$k - 1]->get('id');
                                $mis_respuestas = new Ejercicios_audios_asociados();

                                $respuestas = $mis_respuestas->obtener_todas_respuestas_pregunta($id_pregunta);

                                //Para cada respuesta

                                srand(time());
                                //generamos un número aleatorio entre 1 y el número de pregutnas
                                $numero_aleatorio = rand(1, sizeof($preguntas));

                                //buscamos si aleatorios contine
                                $esta = '0';


                                for ($j = 0; $j < sizeof($aleatorios_generados); $j++) {

                                    if ($aleatorios_generados[$j] == $numero_aleatorio) {

                                        $esta = '1';
                                    }
                                }

                                if ($esta == '0') { //Si no esta lo inserto
                                    $nombre_respuestas[] = $respuestas[0]->get('nombre_audio');
                                    echo $respuestas[0]->get('nombre_audio');
                                    $aleatorios_generados[] = $numero_aleatorio;
                                    $k++;
                                }
                            }


                            echo "AAAAAAAAAAAAAAAAAAAAAAAAaa";
                            for ($j = 0; $j < sizeof($aleatorios_generados); $j++) {
                                $i=$j+1;
                                $tabla_imagenes.='<tr>';

                                $tabla_imagenes.='<td><div class=descripcion>';

                                $tabla_imagenes.='<script type="text/javascript" src="./mediaplayer/swfobject.js"></script>';
                                $tabla_imagenes.='<div class="claseaudio1" id="player1" name="respuesta' . $i . '">';
                                $tabla_imagenes.='<embed type="application/x-shockwave-flash" src="./mediaplayer/mediaplayer.swf" width="320" height="20" style="undefined" id="mpl" name="mpl" quality="high" allowfullscreen="true" flashvars="file=./mediaplayer/audios/audio_' . $id_ejercicio . '_' . $i . '.mp3&amp;height=20&amp;width=320">';
                                $tabla_imagenes.='</div>';

                                $tabla_imagenes.='</div></td>';

                                $tabla_imagenes.='<td><div  id="' . $aleatorios_generados[$j] . '" class="marquito"></div></td>';
                                $tabla_imagenes.='<td id="aceptado' . $aleatorios_generados[$j] . '" class="marquitoaceptado"></td>';
                                $tabla_imagenes.='</tr>';
                            }

                            $tabla_imagenes.='</table></center>';
                            $tabla_imagenes.='<p class="numero" id="' . sizeof($preguntas) . '"></p>';

                            //inserto el número de preguntas

                            $tabla_imagenes.='<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
                        } else {
                            echo "akiiiiiiii";
                            //$tabla_imagenes.='<table id="tablarespuestas" name="tablarespuestas"><center>';

                            for ($i = 1; $i <= sizeof($preguntas); $i++) {
                                echo "iteracion" . $i . "aaaa" . sizeof($preguntas);
                                /*$tabla_imagenes.="<tr>";
                                $tabla_imagenes.='<td id="texto' . $i . '">';
                                $tabla_imagenes.='<textarea id="pregunta' . $i . '" name="pregunta' . $i . '" style="height: 197px; width: 396px;">' . $preguntas[$i - 1]->get('pregunta') . '</textarea>';
                                $tabla_imagenes.='</td>';*/
                                //Pinto la pregunta
                                $divpregunta = '<div id="tabpregunta' . $i . '" >';
                                $divpregunta.='<br/><br/>';
                                $divpregunta.='<table style="width:100%;">';
                                $divpregunta.=' <td style="width:80%;">';
                                $divpregunta.='<textarea style="width: 900px;" class="pregunta" name="pregunta' . $i . '" id="pregunta' . $i . '">' . $preguntas[$i - 1]->get('pregunta') . '</textarea>';
                                $divpregunta.=' </td>';
                                
                                $divpregunta.=' <td style="width:5%;">';
                                $divpregunta.='<img id="imgpregborrar' . $i . '" src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="EliminarPregunta_TextoAudio_AM('.$id_ejercicio.',tabpregunta' . $i . ',' . $i . ')" title="Eliminar Pregunta"></img>';
                                $divpregunta.='</br><img id="imgpreganadir' . $i . '" src="./imagenes/añadir.gif" alt="eliminar respuesta"  height="15px"  width="15px" onClick="anadirRespuesta_AudioTexto_AM('.$id_ejercicio.',respuestas' . $i . ',' . $i . ')" title="Añadir Respuesta"></img>';
                                $divpregunta.='</td> ';
                                $divpregunta.='</br> ';
                                $divpregunta.='</table> ';

                                $id_pregunta = $preguntas[$i - 1]->get('id');

                                $mis_respuestas = new Ejercicios_audios_asociados();
                                $respuestas = $mis_respuestas->obtener_todas_respuestas_pregunta($id_pregunta);


                                //$tabla_imagenes.= '<td>';

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
                                    $divpregunta.='<script type="text/javascript" src="./mediaplayer/swfobject.js"></script>';
                                    $divpregunta.='<div class="claseaudio1" id="player'.$q.'_'.$i.'" name="respuesta' . $q . "_" . $i . '">';
                                    $divpregunta.='<embed type="application/x-shockwave-flash" src="./mediaplayer/mediaplayer.swf" width="320" height="20" style="undefined" id="mpl'.$q.'_'.$i.'" name="mpl" quality="high" allowfullscreen="true" flashvars="file=./mediaplayer/audios/audio_' . $id_ejercicio . '_' . $i . "_" . $q . '.mp3&amp;height=20&amp;width=320">';
                                    $divpregunta.='</div>';
                                    $divpregunta.='<a href="javascript:cargaAudios(\'' . $respuestas[$p]->get('nombre_audio') . '\',' . $i . ',\'primera\','.$q.',\'respuesta'.$q.'_'.$i.'\')" id="upload' . $i . "_" . $q . '" class="up">Cambiar Audio</a>';
                                    $divpregunta.=' </td>';
                                    $divpregunta.=' <td style="width:5%;" id="tdcorregir'. $q . "_" . $i .'">';
                                    $divpregunta.='<img id="eliminarrespuesta' . $q . '_' . $i . '" src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="EliminarRespuesta_TextoAudio_AM(tablarespuesta' . $q . '_' . $i . ',' . $i . ','.$q.','.$id_ejercicio.')" title="Eliminar Respuesta"></img>';
                                    
                                    $divpregunta.='</td> ';
                                    $divpregunta.='<tr>';

                                    $divpregunta.='</table> ';
                                    
                                    //$tabla_imagenes.= '<div id="c1">';
                                    
                                    // $tabla_imagenes.='<input name="uploadedfile" type="file" />';
                                    // $tabla_imagenes.='</div>';
                                    //$tabla_imagenes.='</div>';
                                    //$tabla_imagenes.='<div id="capa2"> ';


                                    /*$tabla_imagenes.='<script type="text/javascript" src="./mediaplayer/swfobject.js"></script>';
                                    $tabla_imagenes.='<div class="claseaudio1" id="player1" name="respuesta' . $i . '">';
                                    $tabla_imagenes.='<embed type="application/x-shockwave-flash" src="./mediaplayer/mediaplayer.swf" width="320" height="20" style="undefined" id="mpl" name="mpl" quality="high" allowfullscreen="true" flashvars="file=./mediaplayer/audios/audio_' . $id_ejercicio . '_' . $i . '.mp3&amp;height=20&amp;width=320">';
                                    $tabla_imagenes.='</div>';

                                    $tabla_imagenes.='</div>';

                                    $tabla_imagenes.='</td>';

                                    $tabla_imagenes.='</tr>';*/
                                }
                                
                                $divpregunta.='</div>';
                                $divpregunta.='</div>';
                                $divpregunta.='<input type="hidden" value=' . sizeof($respuestas) . ' id="num_res_preg' . $i . '" name="num_res_preg' . $i . '" />';
                                $mform->addElement('html', $divpregunta);
                            }
                            //$tabla_imagenes.='</table></center>';

                            //inserto el número de preguntas
                            $divnumpregunta = '<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
                            $mform->addElement('html', $divnumpregunta);
                            //$tabla_imagenes.='<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
                        }



                        //botones
                        //$mform->addElement('html', $tabla_imagenes);


                        if ($buscar != 1 && $modificable == true) {
                            //Si soy el profesor creadors
                            $tabla_imagenes = '<input type="submit" style="height:40px; width:90px; margin-left:90px; margin-top:20px;" id="submitbutton" name="submitbutton" value="' . get_string('BotonGuardar', 'ejercicios') . '">';
                            $tabla_imagenes.='<input type="button" style="height:40px; width:120px;  margin-top:20px;" id="botonTextoAudio" name="botonTextoAudio" value="' . get_string('NuevaAso', 'ejercicios') . '" onclick="botonMasPreguntas_TextoAudio_AM('.$id_ejercicio.')">';
                            echo "finnnnnnnnn";
                            $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                        } else {
                            if ($buscar == 1) { //Si estoy buscand
                                $ejercicios_prof = new Ejercicios_prof_actividad();
                                $ejercicios_del_prof = $ejercicios_prof->obtener_uno_idejercicio($id_ejercicio);
                                if (sizeof($ejercicios_del_prof) == 0) {
                                    $noagregado = true;
                                } else {
                                    $noagregado = false;
                                }
                                //si el ejercicio no es mio y soy profesor
                                if (has_capability('moodle/legacy:editingteacher', $context, $USER->id, false) && ($modificable == false || $noagregado == true)) {
                                    //boton añadir a mis ejercicios
                                    $attributes = 'size="40"';
                                    $mform->addElement('text', 'carpeta_ejercicio', get_string('carpeta', 'ejercicios'), $attributes);
                                    $mform->addRule('carpeta_ejercicio', "Carpeta Necesaria", 'required', null, 'client');
                                    $buttonarray = array();
                                    $buttonarray[] = &$mform->createElement('submit', 'submitbutton2', get_string('BotonAñadir', 'ejercicios'));
                                    $mform->addGroup($buttonarray, 'botones2', '', array(' '), false);
                                } else {

                                    if ($modificable == true) { // Si el ejercicio era mio y estoy buscando
                                        $tabla_imagenes = '<center><input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                                    } else { //Si soy alumno
                                        $tabla_imagenes = '<center><input type="button" style="height:40px; width:60px;" id="botonResultado" value="Corregir">';
                                        $tabla_imagenes.='<input type="button" style="height:40px; width:60px;" id="botonRehacer" value="Rehacer" onClick="location.href=\'./view.php?id=' . $id . '&opcion=8' . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $tipo_respuesta . '&tipocreacion=' . $tipocreacion . '\'">';
                                        $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                                    }
                                }
                            } else {

                                $tabla_imagenes = '<center><input type="button" style="height:40px; width:60px;" id="botonResultado" value="Corregir">';
                                $tabla_imagenes.='<input type="button" style="height:40px; width:60px;" id="botonRehacer" value="Rehacer" onClick="location.href=\'./view.php?id=' . $id . '&opcion=8' . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $tipo_respuesta . '&tipocreacion=' . $tipocreacion . '\'">';
                                $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                            }
                        }


                        $tabla_imagenes .='</td>';
                        $tabla_imagenes .='<td  width="10%">';
                        //añado la parte de vocabulario para la conexión
                        $tabla_imagenes .='<div><a  onclick=JavaScript:sele(' . $id . ')><img src="../vocabulario/imagenes/guardar_palabras.png" id="id_guardar_im" name="guardar_im" title="' . get_string('guardar', 'vocabulario') . '"/></a></div>';
                        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=5"><img src="../vocabulario/imagenes/administrar_gramaticas.png" id="id_gram_im" name="gram_im" title="' . get_string('admin_gr', 'vocabulario') . '"/></a></div>';
                        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=7"><img src="../vocabulario/imagenes/intenciones_comunicativas.png" id="id_ic_im" name="ic_im" title="' . get_string('admin_ic', 'vocabulario') . '"/></a></div>';
                        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=9"><img src="../vocabulario/imagenes/tipologias_textuales.png" id="id_tt_im" name="tt_im" title="' . get_string('admin_tt', 'vocabulario') . '"/> </a></div>';
                        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=11"><img src="../vocabulario/imagenes/estrategias_icon.png" id="id_ea_im" name="ea_im" title="' . get_string('admin_ea', 'vocabulario') . '"/> </a></div>';

                        $tabla_imagenes .='</td>';

                        $tabla_imagenes .='</table>';

                        $mform->addElement('html', $tabla_imagenes);

                        break;
                    case 3: //Es de tipo video la respusta

                        $mform->addElement('html', '<script src="./js/ajaxupload.js" type="text/javascript"></script>');


                        //Obtengo las preguntas que son texto
                        $mis_preguntas = new Ejercicios_texto_texto_preg();
                        echo "Ejercicio Id: $id_ejercicio";
                        $preguntas = $mis_preguntas->obtener_todas_preguntas_ejercicicio($id_ejercicio);

                        if ($buscar == 1 || $modificable == false) {
                            echo "buscar vale uno y no es modificable";

                            $tabla_imagenes.='<center><table id="tablapreg" name="tablapreg">';
                            $tabla_imagenes.="<tr>";
                            //Inserto las preguntas con clase "item" es decir dragables(mirar javascript.js)
                            for ($i = 1; $i <= sizeof($preguntas); $i++) {
                                echo "obtengo la pregunta";
                                //Obtengo la pregunta
                                $tabla_imagenes.='<td id="texto' . $i . '"> <div class="item" id="' . $i . '">';

                                $tabla_imagenes.='<p style="margin-top: 10%;">' . $preguntas[$i - 1]->get('pregunta') . '</p>';

                                $tabla_imagenes.='</div></div></td>';
                                if ($i % 2 == 0) { //Si es impar lo bajo
                                    $tabla_imagenes.="</tr>";
                                }
                            }
                            $tabla_imagenes.="</tr>";
                            $tabla_imagenes.='</table></center>';
                            $tabla_imagenes.="</br>";
                            $tabla_imagenes.="</br>";

                            $tabla_imagenes.='<table id="tablarespuestas" name="tablarespuestas"><center>';

                            $k = 1;
                            $las_respuestas[sizeof($preguntas) + 1];
                            $aleatorios_generados = array();
                            while ($k <= sizeof($preguntas)) {
                                //Obtengo la respuestas (En este caso sólo habrá 1, ya que es "simple")

                                $id_pregunta = $preguntas[$k - 1]->get('id');
                                $mis_respuestas = new Ejercicios_videos_asociados();

                                $respuestas = $mis_respuestas->obtener_todas_respuestas_pregunta($id_pregunta);

                                //Para cada respuesta

                                srand(time());
                                //generamos un número aleatorio entre 1 y el número de pregutnas
                                $numero_aleatorio = rand(1, sizeof($preguntas));

                                //buscamos si aleatorios contine
                                $esta = '0';

                                for ($j = 0; $j < sizeof($aleatorios_generados); $j++) {

                                    if ($aleatorios_generados[$j] == $numero_aleatorio) {

                                        $esta = '1';
                                    }
                                }

                                if ($esta == '0') { //Si no esta lo inserto
                                    $nombre_respuestas[] = $respuestas[0]->get('nombre_video');
                                    echo $respuestas[0]->get('nombre_video');
                                    $aleatorios_generados[] = $numero_aleatorio;
                                    $k++;
                                }
                            }


                            echo "AAAAAAAAAAAAAAAAAAAAAAAAaa";

                            for ($j = 0; $j < sizeof($aleatorios_generados); $j++) {
                                
                                $i=$j+1;
                                $tabla_imagenes.='<tr>';

                                $tabla_imagenes.='<td><div class=descripcion>';
                                
                                $tabla_imagenes .= '<object id="video' . $i . ' width="396" height="197">
                                        <param name="movie" value="http://www.youtube.com/v/' .$nombre_respuestas[$j] . '?hl=es_ES&amp;version=3">
                                        </param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param>
                                        <embed src="http://www.youtube.com/v/' . $nombre_respuestas[$j] . '?hl=es_ES&amp;version=3" type="application/x-shockwave-flash" width="396" height="197" allowscriptaccess="always" allowfullscreen="true">
                                        </embed></object>';

             
                                
                                
                              //  $tabla_imagenes.=' <a class="button super yellow" href="' . $respuestas[0]->get('nombre_video') . '" target="_blank" id="video' . $i . '">Ver Video</a>';


                                $tabla_imagenes.='</td>';

                                $tabla_imagenes.='<td><div  id="' . $aleatorios_generados[$j] . '" class="marquito"></div></td>';
                                $tabla_imagenes.='<td id="aceptado' . $aleatorios_generados[$j] . '" class="marquitoaceptado"></td>';
                                $tabla_imagenes.='</tr>';
                            }

                            $tabla_imagenes.='</table></center>';
                            echo"aki llega";
                            $tabla_imagenes.='<p class="numero" id="' . sizeof($preguntas) . '"></p>';

                            //inserto el número de preguntas

                            $tabla_imagenes.='<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
                        } else {
                            echo "akiiiiiiii podemos cambiar";

                            //$tabla_imagenes.='<table id="tablarespuestas" name="tablarespuestas"><center>';
                            echo sizeof($preguntas);
                            for ($i = 1; $i <= sizeof($preguntas); $i++) {
                                echo "iteracion" . $i . "aaaa" . count($preguntas);
                                /*$tabla_imagenes.="<tr>";
                                $tabla_imagenes.='<td id="texto' . $i . '">';
                                $tabla_imagenes.='<textarea id="pregunta' . $i . '" name="pregunta' . $i . '" style="height: 197px; width: 396px;">' . $preguntas[$i - 1]->get('pregunta') . '</textarea>';
                                $tabla_imagenes.='</td>';*/
                                //Pinto la pregunta
                                $divpregunta = '<div id="tabpregunta' . $i . '" >';
                                $divpregunta.='<br/><br/>';
                                $divpregunta.='<table style="width:100%;">';
                                $divpregunta.=' <td style="width:80%;">';
                                $divpregunta.='<textarea style="width: 900px;" class="pregunta" name="pregunta' . $i . '" id="pregunta' . $i . '">' . $preguntas[$i - 1]->get('pregunta') . '</textarea>';
                                $divpregunta.=' </td>';
                                
                                $divpregunta.=' <td style="width:5%;">';
                                $divpregunta.='<img id="imgpregborrar' . $i . '" src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="EliminarPregunta_TextoVideo_AM(tabpregunta' . $i . ',' . $i . ')" title="Eliminar Pregunta"></img>';
                                $divpregunta.='</br><img id="imgpreganadir' . $i . '" src="./imagenes/añadir.gif" alt="eliminar respuesta"  height="15px"  width="15px" onClick="anadirRespuesta_TextoVideo_AM(respuestas' . $i . ',' . $i . ')" title="Añadir Respuesta"></img>';
                                $divpregunta.='</td> ';
                                $divpregunta.='</br> ';
                                $divpregunta.='</table> ';

                                $id_pregunta = $preguntas[$i - 1]->get('id');

                                $mis_respuestas = new Ejercicios_videos_asociados();
                                echo "Mi pregunta:" . $id_pregunta;
                                $respuestas = $mis_respuestas->obtener_todas_respuestas_pregunta($id_pregunta);
                                
                                $divpregunta.='</br><div id="respuestas' . $i . '" class=respuesta>';
                                for ($p = 0; $p < sizeof($respuestas); $p++) {
                                    $q = $p + 1;
                                    //$el_video_origen = new Ejercicios_videos_asociados();
                                    //$el_video_origen->obtener_uno_ejpreg($id_ejercicio, $id_pregunta);
                                    //die;
                                    $el_video_origen = $respuestas[$p];
                                    
                                    if ($q%2==0 || $q==sizeof($respuestas)) {
                                        $divpregunta.='<table  id="tablarespuesta' . $q . '_' . $i . '" style="width:50%;">';
                                    }
                                    else {
                                        $divpregunta.='<table  id="tablarespuesta' . $q . '_' . $i . '" style="width:50%;float:left;">';
                                    }
                                    $divpregunta.='<tr id="trrespuesta' . $q . "_" . $i . '"> ';
                                    $divpregunta.=' <td style="width:80%;">';
                                    $divpregunta.= '<object width="396" height="197">
                                            <param name="movie'.$q."_".$i.'" id="movie'.$q."_".$i.'" value="http://www.youtube.com/v/' . $el_video_origen->get('nombre_video') . '?hl=es_ES&amp;version=3">
                                            </param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param>
                                            <embed name="embed'.$q.'_'.$i.'" id="embed'.$q.'_'.$i.'" src="http://www.youtube.com/v/' . $el_video_origen->get('nombre_video') . '?hl=es_ES&amp;version=3" type="application/x-shockwave-flash" width="396" height="197" allowscriptaccess="always" allowfullscreen="true">
                                            </embed></object>';
                                    $divpregunta.='<textarea class="video1" onchange="actualizar_TextoVideo_AM('.$q.','.$i.')" style="width: 300px;" name="respuesta' . $q . "_" . $i . '" id="respuesta' . $q . "_" . $i . '" value="' . YoutubeVideoHelper::generarVideoUrl($el_video_origen->get('nombre_video')) . '">' . YoutubeVideoHelper::generarVideoUrl($el_video_origen->get('nombre_video')) . '</textarea>';
                                    $divpregunta.=' </td>';
                                    $divpregunta.=' <td style="width:5%;" id="tdcorregir'. $q . "_" . $i .'">';
                                    $divpregunta.='<img id="eliminarrespuesta' . $q . '_' . $i . '" src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="EliminarRespuesta_TextoVideo_AM(' .$q. ',' . $i . ')" title="Eliminar Respuesta"></img>';
                                    
                                    $divpregunta.='</td> ';
                                    $divpregunta.='<tr>';

                                    $divpregunta.='</table> ';

                                    

                                    /*$tabla_imagenes.= '<td>';
                                    //print_r($el_video_origen);
                                    //$tabla_imagenes.=' <a onclick="ObtenerDireccion(' . $i . ')" class="button super yellow centrarvideo" href="' . $respuestas[0]->get('nombre_video') . '" target="_blank" id="video' . $i . '">Ver Video</a>';
                                    $tabla_imagenes .= '<object width="396" height="197">
                                            <param name="movie" value="http://www.youtube.com/v/' . $el_video_origen->get('nombre_video') . '?hl=es_ES&amp;version=3">
                                            </param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param>
                                            <embed src="http://www.youtube.com/v/' . $el_video_origen->get('nombre_video') . '?hl=es_ES&amp;version=3" type="application/x-shockwave-flash" width="396" height="197" allowscriptaccess="always" allowfullscreen="true">
                                            </embed></object>';

                                    $tabla_imagenes.=' <textarea class="video1" name="archivovideo' . $i . '" id="archivovideo' . $i . '">' . YoutubeVideoHelper::generarVideoUrl($respuestas[0]->get('nombre_video')) . '</textarea>';

                                    $tabla_imagenes.='</td>';

                                    $tabla_imagenes.='</tr>';*/
                                }
                                //Inserto el numero de respuestas para cada pregunta
                                $divpregunta.='</div>';
                                $divpregunta.='</div>';
                                $divpregunta.='<input type="hidden" value=' . sizeof($respuestas) . ' id="num_res_preg' . $i . '" name="num_res_preg' . $i . '" />';
                                $mform->addElement('html', $divpregunta);
                            }
                            //$tabla_imagenes.='</table></center>';

                            //inserto el número de preguntas
                            //inserto el número de preguntas
                            $divnumpregunta = '<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
                            $mform->addElement('html', $divnumpregunta);
                            //$tabla_imagenes.='<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
                        }

                        //botones
                        //$mform->addElement('html', $tabla_imagenes);
                        echo "botones";
                        if ($buscar != 1 && $modificable == true) {
                            //Si soy el profesor creadors
                            $tabla_imagenes = '<input type="submit" style="height:40px; width:90px; margin-left:90px; margin-top:20px;" id="submitbutton" name="submitbutton" value="' . get_string('BotonGuardar', 'ejercicios') . '">';
                            $tabla_imagenes.='<input type="button" style="height:40px; width:120px;  margin-top:20px;" id="botonTextoVideo" name="botonTextoVideo" value="' . get_string('NuevaAso', 'ejercicios') . '" onclick="botonMasPreguntas_TextoVideo_AM(' . $id_ejercicio . ')">';
                            echo "finnnnnnnnn";
                            $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                        } else {
                            if ($buscar == 1) { //Si estoy buscand
                                $ejercicios_prof = new Ejercicios_prof_actividad();
                                $ejercicios_del_prof = $ejercicios_prof->obtener_uno_idejercicio($id_ejercicio);
                                if (sizeof($ejercicios_del_prof) == 0) {
                                    $noagregado = true;
                                } else {
                                    $noagregado = false;
                                }
                                //si el ejercicio no es mio y soy profesor
                                if (has_capability('moodle/legacy:editingteacher', $context, $USER->id, false) && ($modificable == false || $noagregado == true)) {
                                    //boton añadir a mis ejercicios
                                    $attributes = 'size="40"';
                                    $mform->addElement('text', 'carpeta_ejercicio', get_string('carpeta', 'ejercicios'), $attributes);
                                    $mform->addRule('carpeta_ejercicio', "Carpeta Necesaria", 'required', null, 'client');
                                    $buttonarray = array();
                                    $buttonarray[] = &$mform->createElement('submit', 'submitbutton2', get_string('BotonAñadir', 'ejercicios'));
                                    $mform->addGroup($buttonarray, 'botones2', '', array(' '), false);
                                } else {

                                    if ($modificable == true) { // Si el ejercicio era mio y estoy buscando
                                        $tabla_imagenes = '<center><input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                                    } else { //Si soy alumno
                                        $tabla_imagenes = '<center><input type="button" style="height:40px; width:60px;" id="botonResultado" value="Corregir">';
                                        $tabla_imagenes.='<input type="button" style="height:40px; width:60px;" id="botonRehacer" value="Rehacer" onClick="location.href=\'./view.php?id=' . $id . '&opcion=8' . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $tipo_respuesta . '&tipocreacion=' . $tipocreacion . '\'">';
                                        $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                                    }
                                }
                            } else {

                                $tabla_imagenes = '<center><input type="button" style="height:40px; width:60px;" id="botonResultado" value="Corregir">';
                                $tabla_imagenes.='<input type="button" style="height:40px; width:60px;" id="botonRehacer" value="Rehacer" onClick="location.href=\'./view.php?id=' . $id . '&opcion=8' . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $tipo_respuesta . '&tipocreacion=' . $tipocreacion . '\'">';
                                $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                            }

                            echo "dentro del bucle infernal";
                        }

                        echo "no muero";
                        $tabla_imagenes .='</td>';
                        $tabla_imagenes .='<td  width="10%">';
                        //añado la parte de vocabulario para la conexión
                        $tabla_imagenes .='<div><a  onclick=JavaScript:sele(' . $id . ')><img src="../vocabulario/imagenes/guardar_palabras.png" id="id_guardar_im" name="guardar_im" title="' . get_string('guardar', 'vocabulario') . '"/></a></div>';
                        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=5"><img src="../vocabulario/imagenes/administrar_gramaticas.png" id="id_gram_im" name="gram_im" title="' . get_string('admin_gr', 'vocabulario') . '"/></a></div>';
                        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=7"><img src="../vocabulario/imagenes/intenciones_comunicativas.png" id="id_ic_im" name="ic_im" title="' . get_string('admin_ic', 'vocabulario') . '"/></a></div>';
                        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=9"><img src="../vocabulario/imagenes/tipologias_textuales.png" id="id_tt_im" name="tt_im" title="' . get_string('admin_tt', 'vocabulario') . '"/> </a></div>';
                        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=11"><img src="../vocabulario/imagenes/estrategias_icon.png" id="id_ea_im" name="ea_im" title="' . get_string('admin_ea', 'vocabulario') . '"/> </a></div>';

                        $tabla_imagenes .='</td>';

                        $tabla_imagenes .='</table>';

                        $mform->addElement('html', $tabla_imagenes);
                        print_r('final');

                        break;
                    case 4: //Es una imagen la respuesta

                        $mform->addElement('html', '<script src="./js/ajaxupload.js" type="text/javascript"></script>');

                        echo "SSSSSSSSSSSSSS";
                        //Obtengo las preguntas que son texto
                        $mis_preguntas = new Ejercicios_texto_texto_preg();
                        $preguntas = $mis_preguntas->obtener_todas_preguntas_ejercicicio($id_ejercicio);


                        if ($buscar == 1 || $modificable == false) {
                            $tabla_imagenes.='<center><table id="tablapreg" name="tablapreg">';
                            $tabla_imagenes.="<tr>";
                            //Inserto las preguntas con clase "item" es decir dragables(mirar javascript.js)
                            for ($i = 1; $i <= sizeof($preguntas); $i++) {

                                //Obtengo la pregunta
                                $tabla_imagenes.='<td id="texto' . $i . '"> <div class="item" id="' . $i . '">';

                                $tabla_imagenes.='<p style="margin-top: 10%;">' . $preguntas[$i - 1]->get('pregunta') . '</p>';

                                $tabla_imagenes.='</div></div></td>';
                                if ($i % 2 == 0) { //Si es impar lo bajo
                                    $tabla_imagenes.="</tr>";
                                }
                            }
                            $tabla_imagenes.="</tr>";
                            $tabla_imagenes.='</table></center>';
                            $tabla_imagenes.="</br>";
                            $tabla_imagenes.="</br>";
                            $tabla_imagenes.='<table id="tablarespuestas" name="tablarespuestas"><center>';

                            $k = 1;
                            $las_respuestas[sizeof($preguntas) + 1];
                            $aleatorios_generados = array();
                            while ($k <= sizeof($preguntas)) {
                                //Obtengo la respuestas (En este caso sólo habrá 1, ya que es "simple")

                                $id_pregunta = $preguntas[$k - 1]->get('id');
                                $mis_respuestas = new Ejercicios_imagenes_asociadas();

                                $respuestas = $mis_respuestas->obtener_todas_respuestas_pregunta($id_pregunta);

                                //Para cada respuesta

                                srand(time());
                                //generamos un número aleatorio entre 1 y el número de pregutnas
                                $numero_aleatorio = rand(1, sizeof($preguntas));

                                //buscamos si aleatorios contine
                                $esta = '0';


                                for ($j = 0; $j < sizeof($aleatorios_generados); $j++) {

                                    if ($aleatorios_generados[$j] == $numero_aleatorio) {

                                        $esta = '1';
                                    }
                                }

                                if ($esta == '0') { //Si no esta lo inserto
                                    $nombre_respuestas[] = $respuestas[0]->get('nombre_imagen');
                                    echo $respuestas[0]->get('nombre_imagen');
                                    $aleatorios_generados[] = $numero_aleatorio;
                                    $k++;
                                }
                            }


                            echo "AAAAAAAAAAAAAAAAAAAAAAAAaa";
                            for ($j = 0; $j < sizeof($aleatorios_generados); $j++) {
                                $tabla_imagenes.='<tr>';

                                $tabla_imagenes.='<td><div class=descripcion>';
                                $tabla_imagenes.= '<img name="respuesta' . $i . '" id="respuesta' . $i . '" src="./imagenes/' . $nombre_respuestas[$aleatorios_generados[$j] - 1] . '"   style="height: 192px; width: 401px;" ></img>';
                                $tabla_imagenes.='</div></td>';

                                $tabla_imagenes.='<td><div  id="' . $aleatorios_generados[$j] . '" class="marquito"></div></td>';
                                $tabla_imagenes.='<td id="aceptado' . $aleatorios_generados[$j] . '" class="marquitoaceptado"></td>';
                                $tabla_imagenes.='</tr>';
                            }

                            $tabla_imagenes.='</table></center>';
                            $tabla_imagenes.='<p class="numero" id="' . sizeof($preguntas) . '"></p>';

                            //inserto el número de preguntas

                            $tabla_imagenes.='<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
                        } else {
                            echo "akiiiiiiii";
                            //$tabla_imagenes.='<table id="tablarespuestas" name="tablarespuestas"><center>';

                            for ($i = 1; $i <= sizeof($preguntas); $i++) {
                                echo "iteracion" . $i . "aaaa" . sizeof($preguntas);
                                /*$tabla_imagenes.="<tr>";
                                $tabla_imagenes.='<td id="texto' . $i . '">';
                                $tabla_imagenes.='<textarea id="pregunta' . $i . '" name="pregunta' . $i . '" style="height: 197px; width: 396px;">' . $preguntas[$i - 1]->get('pregunta') . '</textarea>';
                                $tabla_imagenes.='</td>';*/
                                $divpregunta = '<div id="tabpregunta' . $i . '" >';
                                $divpregunta.='<br/><br/>';
                                $divpregunta.='<table style="width:100%;">';
                                $divpregunta.=' <td style="width:80%;">';
                                $divpregunta.='<textarea style="width: 900px;" class="pregunta" name="pregunta' . $i . '" id="pregunta' . $i . '">' . $preguntas[$i - 1]->get('pregunta') . '</textarea>';
                                $divpregunta.=' </td>';
                                
                                $divpregunta.=' <td style="width:5%;">';
                                $divpregunta.='<img id="imgpregborrar' . $i . '" src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="EliminarPregunta_TextoFoto_AM('.$id_ejercicio.',tabpregunta' . $i . ',' . $i . ')" title="Eliminar Pregunta"></img>';
                                $divpregunta.='</br><img id="imgpreganadir' . $i . '" src="./imagenes/añadir.gif" alt="eliminar respuesta"  height="15px"  width="15px" onClick="anadirRespuesta_TextoFoto_AM('.$id_ejercicio.',respuestas' . $i . ',' . $i . ')" title="Añadir Respuesta"></img>';
                                $divpregunta.='</td> ';
                                $divpregunta.='</br> ';
                                $divpregunta.='</table> ';

                                $id_pregunta = $preguntas[$i - 1]->get('id');

                                $mis_respuestas = new Ejercicios_imagenes_asociadas();
                                $respuestas = $mis_respuestas->obtener_todas_respuestas_pregunta($id_pregunta);
                                
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
                                    $divpregunta.='<div id="capa1">';
                                    $divpregunta.='<a href="javascript:cargaImagenes(\'' . $respuestas[$p]->get('nombre_imagen') . '\',' . $i . ',\'primera\','.$q.')" id="upload' . $q . "_" . $i .'" class="up">Cambiar Foto</a>';
                                    $divpregunta.='</div>';
                                    $divpregunta.='<div id="capa2"> ';
                                    $divpregunta.='<img  name="respuesta' . $q . "_" . $i . '" id="respuesta' . $q . "_" . $i . '" src="./imagenes/' . $respuestas[$p]->get('nombre_imagen') . '"   style="height: 192px; width: 401px;" ></img>';
                                    $divpregunta.='</div>';
                                    $divpregunta.=' </td>';
                                    $divpregunta.=' <td style="width:5%;">';
                                    $divpregunta.='<img id="eliminarrespuesta' . $q . '_' . $i . '" src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="EliminarRespuesta_TextoFoto_AM(tablarespuesta' . $q . '_' . $i . ',' . $i . ','.$q.','.$id_ejercicio.')" title="Eliminar Respuesta"></img>';
                                    
                                    $divpregunta.='</td> ';
                                    $divpregunta.='<tr>';

                                    $divpregunta.='</table> ';
                                }
                                
                                $divpregunta.='</div>';
                                $divpregunta.='</div>';
                                $divpregunta.='<input type="hidden" value=' . sizeof($respuestas) . ' id="num_res_preg' . $i . '" name="num_res_preg' . $i . '" />';
                                $mform->addElement('html', $divpregunta);
                                
                                // echo "tamaño".sizeof($respuestas);
                                //   echo "el nombre es". $respuestas[0]->get('nombre_imagen');
                                /*$tabla_imagenes.= '<td>';
                                $tabla_imagenes.= '<div id="capa1">';
                                $tabla_imagenes.='<a href="javascript:cargaImagenes(\'' . $respuestas[0]->get('nombre_imagen') . '\',' . $i . ',\'primera\')" id="upload' . $i . '" class="up">Cambiar Foto</a>';*/
                                // $tabla_imagenes.='<input name="uploadedfile" type="file" />';
                                // $tabla_imagenes.='</div>';
                                /*$tabla_imagenes.='</div>';
                                $tabla_imagenes.='<div id="capa2"> ';
                                $tabla_imagenes.='<img  name="respuesta' . $i . '" id="respuesta' . $i . '" src="./imagenes/' . $respuestas[0]->get('nombre_imagen') . '"   style="height: 192px; width: 401px;" ></img>';
                                $tabla_imagenes.='</div>';*/



                                //$tabla_imagenes.='</td>';

                                //$tabla_imagenes.='</tr>';
                                // $tabla_imagenes.="<tr>";
                                // $mform->addElement('html',$tabla_imagenes);
                                // $mform->addElement('file', 'archivofoto'.$i,'Cambiar Imagen '.$i);
                                // $tabla_imagenes='</tr>';
                                // $mform->addElement('html',$tabla_imagenes);
                                //    $tabla_imagenes.='</td>';
                                // $tabla_imagenes.='</td>';
                                //  $tabla_imagenes.="</tr>";
                            }
                            
                            //$tabla_imagenes.='</table></center>';

                            //inserto el número de preguntas
                            $divnumpregunta = '<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
                            $mform->addElement('html', $divnumpregunta);
                            //$tabla_imagenes.='<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
                        }



                        //botones
                        //$mform->addElement('html', $tabla_imagenes);


                        if ($buscar != 1 && $modificable == true) {
                            //Si soy el profesor creadors
                            $tabla_imagenes = '<input type="submit" style="height:40px; width:90px; margin-left:90px; margin-top:20px;" id="submitbutton" name="submitbutton" value="' . get_string('BotonGuardar', 'ejercicios') . '">';
                            $tabla_imagenes.='<input type="button" style="height:40px; width:120px;  margin-top:20px;" id="botonTextoImagen" name="botonTextoImagen" value="' . get_string('NuevaAso', 'ejercicios') . '" onclick="botonMasPreguntas_TextoFoto_AM(' . $id_ejercicio . ')">';
                            $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                        } else {
                            if ($buscar == 1) { //Si estoy buscand
                                $ejercicios_prof = new Ejercicios_prof_actividad();
                                $ejercicios_del_prof = $ejercicios_prof->obtener_uno_idejercicio($id_ejercicio);
                                if (sizeof($ejercicios_del_prof) == 0) {
                                    $noagregado = true;
                                } else {
                                    $noagregado = false;
                                }
                                //si el ejercicio no es mio y soy profesor
                                if (has_capability('moodle/legacy:editingteacher', $context, $USER->id, false) && ($modificable == false || $noagregado == true)) {
                                    //boton añadir a mis ejercicios
                                    $attributes = 'size="40"';
                                    $mform->addElement('text', 'carpeta_ejercicio', get_string('carpeta', 'ejercicios'), $attributes);
                                    $mform->addRule('carpeta_ejercicio', "Carpeta Necesaria", 'required', null, 'client');
                                    $buttonarray = array();
                                    $buttonarray[] = &$mform->createElement('submit', 'submitbutton2', get_string('BotonAñadir', 'ejercicios'));
                                    $mform->addGroup($buttonarray, 'botones2', '', array(' '), false);
                                } else {

                                    if ($modificable == true) { // Si el ejercicio era mio y estoy buscando
                                        $tabla_imagenes = '<center><input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                                    } else { //Si soy alumno
                                        $tabla_imagenes = '<center><input type="button" style="height:40px; width:60px;" id="botonResultado" value="Corregir">';
                                        $tabla_imagenes.='<input type="button" style="height:40px; width:60px;" id="botonRehacer" value="Rehacer" onClick="location.href=\'./view.php?id=' . $id . '&opcion=8' . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $tipo_respuesta . '&tipocreacion=' . $tipocreacion . '\'">';
                                        $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                                    }
                                }
                            } else {

                                $tabla_imagenes = '<center><input type="button" style="height:40px; width:60px;" id="botonResultado" value="Corregir">';
                                $tabla_imagenes.='<input type="button" style="height:40px; width:60px;" id="botonRehacer" value="Rehacer" onClick="location.href=\'./view.php?id=' . $id . '&opcion=8' . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $tipo_respuesta . '&tipocreacion=' . $tipocreacion . '\'">';
                                $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                            }
                        }


                        $tabla_imagenes .='</td>';
                        $tabla_imagenes .='<td  width="10%">';
                        //añado la parte de vocabulario para la conexión
                        $tabla_imagenes .='<div><a  onclick=JavaScript:sele(' . $id . ')><img src="../vocabulario/imagenes/guardar_palabras.png" id="id_guardar_im" name="guardar_im" title="' . get_string('guardar', 'vocabulario') . '"/></a></div>';
                        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=5"><img src="../vocabulario/imagenes/administrar_gramaticas.png" id="id_gram_im" name="gram_im" title="' . get_string('admin_gr', 'vocabulario') . '"/></a></div>';
                        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=7"><img src="../vocabulario/imagenes/intenciones_comunicativas.png" id="id_ic_im" name="ic_im" title="' . get_string('admin_ic', 'vocabulario') . '"/></a></div>';
                        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=9"><img src="../vocabulario/imagenes/tipologias_textuales.png" id="id_tt_im" name="tt_im" title="' . get_string('admin_tt', 'vocabulario') . '"/> </a></div>';
                        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=11"><img src="../vocabulario/imagenes/estrategias_icon.png" id="id_ea_im" name="ea_im" title="' . get_string('admin_ea', 'vocabulario') . '"/> </a></div>';

                        $tabla_imagenes .='</td>';

                        $tabla_imagenes .='</table>';

                        $mform->addElement('html', $tabla_imagenes);



                        break;
                }
                break;
            case 2: //Es de tipo audio la pregunta

                echo "tipo pregunta es audio";

                $mform->addElement('html', '<script src="./js/ajaxupload.js" type="text/javascript"></script>');


                //Obtengo las preguntas que son texto
                $mis_preguntas = new Ejercicios_texto_texto_preg();
                $preguntas = $mis_preguntas->obtener_todas_preguntas_ejercicicio($id_ejercicio);


                if ($buscar == 1 || $modificable == false) {
                    $tabla_imagenes.='<center><table id="tablapreg" name="tablapreg">';
                    $tabla_imagenes.="<tr>";
                    //Inserto las preguntas con clase "item" es decir dragables(mirar javascript.js)
                    for ($i = 1; $i <= sizeof($preguntas); $i++) {

                        //Obtengo la pregunta
                        $tabla_imagenes.='<td id="texto' . $i . '"> <div class="item" id="' . $i . '">';

                        $tabla_imagenes.='<p style="margin-top: 10%;">' . $preguntas[$i - 1]->get('pregunta') . '</p>';

                        $tabla_imagenes.='</div></div></td>';
                        if ($i % 2 == 0) { //Si es impar lo bajo
                            $tabla_imagenes.="</tr>";
                        }
                    }
                    $tabla_imagenes.="</tr>";
                    $tabla_imagenes.='</table></center>';
                    $tabla_imagenes.="</br>";
                    $tabla_imagenes.="</br>";
                    $tabla_imagenes.='<table id="tablarespuestas" name="tablarespuestas"><center>';

                    $k = 1;
                    $las_respuestas[sizeof($preguntas) + 1];
                    $aleatorios_generados = array();
                    while ($k <= sizeof($preguntas)) {
                        //Obtengo la respuestas (En este caso sólo habrá 1, ya que es "simple")

                        $id_pregunta = $preguntas[$k - 1]->get('id');
                        $mis_respuestas = new Ejercicios_audios_asociados();

                        $respuestas = $mis_respuestas->obtener_todas_respuestas_pregunta($id_pregunta);

                        //Para cada respuesta

                        srand(time());
                        //generamos un número aleatorio entre 1 y el número de pregutnas
                        $numero_aleatorio = rand(1, sizeof($preguntas));

                        //buscamos si aleatorios contine
                        $esta = '0';


                        for ($j = 0; $j < sizeof($aleatorios_generados); $j++) {

                            if ($aleatorios_generados[$j] == $numero_aleatorio) {

                                $esta = '1';
                            }
                        }

                        if ($esta == '0') { //Si no esta lo inserto
                            $nombre_respuestas[] = $respuestas[0]->get('nombre_audio');
                            echo $respuestas[0]->get('nombre_audio');
                            $aleatorios_generados[] = $numero_aleatorio;
                            $k++;
                        }
                    }


                    echo "AAAAAAAAAAAAAAAAAAAAAAAAaa";
                    for ($j = 0; $j < sizeof($aleatorios_generados); $j++) {
                        
                        $i=$j+1;
                        $tabla_imagenes.='<tr>';

                        $tabla_imagenes.='<td><div class=descripcion>';

                        $tabla_imagenes.='<script type="text/javascript" src="./mediaplayer/swfobject.js"></script>';
                        $tabla_imagenes.='<div class="claseaudio1" id="player1" name="respuesta' . $i . '">';
                        $tabla_imagenes.='<embed type="application/x-shockwave-flash" src="./mediaplayer/mediaplayer.swf" width="320" height="20" style="undefined" id="mpl" name="mpl" quality="high" allowfullscreen="true" flashvars="file=./mediaplayer/audios/audio_' . $id_ejercicio . '_' . $i . '.mp3&amp;height=20&amp;width=320">';
                        $tabla_imagenes.='</div>';

                        $tabla_imagenes.='</div></td>';

                        $tabla_imagenes.='<td><div  id="' . $aleatorios_generados[$j] . '" class="marquito"></div></td>';
                        $tabla_imagenes.='<td id="aceptado' . $aleatorios_generados[$j] . '" class="marquitoaceptado"></td>';
                        $tabla_imagenes.='</tr>';
                    }

                    $tabla_imagenes.='</table></center>';
                    $tabla_imagenes.='<p class="numero" id="' . sizeof($preguntas) . '"></p>';

                    //inserto el número de preguntas

                    $tabla_imagenes.='<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
                } else {
                    echo "akiiiiiiii   3333";
                    //$tabla_imagenes.='<table id="tablarespuestas" name="tablarespuestas"><center>';

                    for ($i = 1; $i <= sizeof($preguntas); $i++) {
                        echo "iteracion" . $i . "aaaa" . sizeof($preguntas);
                        /*$tabla_imagenes.="<tr>";
                        $tabla_imagenes.='<td id="texto' . $i . '">';
                        $tabla_imagenes.='<textarea id="pregunta' . $i . '" name="pregunta' . $i . '" style="height: 197px; width: 396px;">' . $preguntas[$i - 1]->get('pregunta') . '</textarea>';
                        $tabla_imagenes.='</td>';*/
                        $divpregunta = '<div id="tabpregunta' . $i . '" >';
                        $divpregunta.='<br/><br/>';
                        $divpregunta.='<table style="width:100%;">';
                        $divpregunta.=' <td style="width:80%;">';
                        
                        $divpregunta.='<div style="width: 900px;" class="pregunta" name="pregunta' . $i . '" id="pregunta' . $i . '">';
                        $divpregunta.='<script type="text/javascript" src="./mediaplayer/swfobject.js"></script>';
                        $divpregunta.='<div style="margin: 0 auto; margin-left: auto; margin-right: auto; width:320px;">';
                        $divpregunta.='<embed type="application/x-shockwave-flash" src="./mediaplayer/mediaplayer.swf" width="320" height="20" style="undefined" id="mpl'.$i.'" name="mpl'.$i.'" quality="high" allowfullscreen="true" flashvars="file=./mediaplayer/audios/audio_' . $id_ejercicio . '_' . $i . '.mp3&amp;height=20&amp;width=320">';
                        $divpregunta.='</div>';
                        $divpregunta.='<a href="javascript:cargaAudios_AudioTexto_AM(\'' . $preguntas[$i - 1]->get('pregunta') . '\',' . $i . ',\'primera\')" id="upload' . $i . '" class="up">Cambiar Audio</a>';
                        
                        $divpregunta.='</div>';
                        $divpregunta.=' </td>';
                        
                        $divpregunta.='<td style="width:5%;">';
                        $divpregunta.='<img id="imgpregborrar' . $i . '" src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="EliminarPregunta_AudioTexto_AM('.$id_ejercicio.',tabpregunta' . $i . ',' . $i . ')" title="Eliminar Pregunta"></img>';
                        $divpregunta.='</br><img id="imgpreganadir' . $i . '" src="./imagenes/añadir.gif" alt="eliminar respuesta"  height="15px"  width="15px" onClick="anadirRespuesta_IE(respuestas' . $i . ',' . $i . ')" title="Añadir Respuesta"></img>';
                        $divpregunta.='</td> ';
                        $divpregunta.='</br> ';
                        $divpregunta.='</table> ';

                        $id_pregunta = $preguntas[$i - 1]->get('id');

                        $mis_respuestas = new Ejercicios_texto_texto_resp();
                        $respuestas = $mis_respuestas->obtener_todas_respuestas_pregunta($id_pregunta);
                        
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
                            $divpregunta.='<textarea style="width: 300px;" class="resp" name="respuesta' . $q . "_" . $i . '" id="respuesta' . $q . "_" . $i . '" value="' . $respuestas[$p]->get('respuesta') . '">' . $respuestas[$p]->get('respuesta') . '</textarea>';
                            $divpregunta.=' </td>';
                            $divpregunta.=' <td style="width:5%;" id="tdcorregir'. $q . "_" . $i .'">';
                            $divpregunta.='<img id="eliminarrespuesta' . $q . '_' . $i . '" src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="EliminarRespuesta_IE(tablarespuesta' . $q . '_' . $i . ',' . $i . ')" title="Eliminar Respuesta"></img>';

                            $divpregunta.='</td> ';
                            $divpregunta.='<tr>';

                            $divpregunta.='</table> ';
                            
                        }
                        
                        
                        $divpregunta.='</div>';
                        $divpregunta.='</div>';
                        $divpregunta.='<input type="hidden" value=' . sizeof($respuestas) . ' id="num_res_preg' . $i . '" name="num_res_preg' . $i . '" />';
                        $mform->addElement('html', $divpregunta);
                        //$tabla_imagenes.= '<td>';


                        //$tabla_imagenes.= '<div id="c1">';
                        //$tabla_imagenes.='<a href="javascript:cargaAudios(\'' . $respuestas[0]->get('nombre_audio') . '\',' . $i . ',\'primera\')" id="upload' . $i . '" class="up">Cambiar Audio</a>';
                        // $tabla_imagenes.='<input name="uploadedfile" type="file" />';
                        // $tabla_imagenes.='</div>';
                        //$tabla_imagenes.='</div>';
                        //$tabla_imagenes.='<div id="capa2"> ';


                        /*$tabla_imagenes.='<script type="text/javascript" src="./mediaplayer/swfobject.js"></script>';
                        $tabla_imagenes.='<div class="claseaudio1" id="player1" name="respuesta' . $i . '">';
                        $tabla_imagenes.='<embed type="application/x-shockwave-flash" src="./mediaplayer/mediaplayer.swf" width="320" height="20" style="undefined" id="mpl" name="mpl" quality="high" allowfullscreen="true" flashvars="file=./mediaplayer/audios/audio_' . $id_ejercicio . '_' . $i . '.mp3&amp;height=20&amp;width=320">';
                        $tabla_imagenes.='</div>';*/
                        
                        //$tabla_imagenes.='</div>';

                        //$tabla_imagenes.='</td>';

                        //$tabla_imagenes.='</tr>';
                    }
                    //$tabla_imagenes.='</table></center>';

                    //inserto el número de preguntas
                    $divnumpregunta = '<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
                    $mform->addElement('html', $divnumpregunta);
                    //$tabla_imagenes.='<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
                }



                //botones
                //$mform->addElement('html', $tabla_imagenes);


                if ($buscar != 1 && $modificable == true) {
                    //Si soy el profesor creadors
                    $tabla_imagenes = '<input type="submit" style="height:40px; width:90px; margin-left:90px; margin-top:20px;" id="submitbutton" name="submitbutton" value="' . get_string('BotonGuardar', 'ejercicios') . '">';
                    $tabla_imagenes.='<input type="button" style="height:40px; width:120px;  margin-top:20px;" id="botonTextoAudio" name="botonTextoAudio" value="' . get_string('NuevaAso', 'ejercicios') . '" onclick="botonMasPreguntas_AudioTexto_AM(' . $id_ejercicio . ')">';
                    echo "finnnnnnnnn";
                    $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                } else {
                    if ($buscar == 1) { //Si estoy buscand
                        $ejercicios_prof = new Ejercicios_prof_actividad();
                        $ejercicios_del_prof = $ejercicios_prof->obtener_uno_idejercicio($id_ejercicio);
                        if (sizeof($ejercicios_del_prof) == 0) {
                            $noagregado = true;
                        } else {
                            $noagregado = false;
                        }
                        //si el ejercicio no es mio y soy profesor
                        if (has_capability('moodle/legacy:editingteacher', $context, $USER->id, false) && ($modificable == false || $noagregado == true)) {
                            //boton añadir a mis ejercicios
                            $attributes = 'size="40"';
                            $mform->addElement('text', 'carpeta_ejercicio', get_string('carpeta', 'ejercicios'), $attributes);
                            $mform->addRule('carpeta_ejercicio', "Carpeta Necesaria", 'required', null, 'client');
                            $buttonarray = array();
                            $buttonarray[] = &$mform->createElement('submit', 'submitbutton2', get_string('BotonAñadir', 'ejercicios'));
                            $mform->addGroup($buttonarray, 'botones2', '', array(' '), false);
                        } else {

                            if ($modificable == true) { // Si el ejercicio era mio y estoy buscando
                                $tabla_imagenes = '<center><input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                            } else { //Si soy alumno
                                $tabla_imagenes = '<center><input type="button" style="height:40px; width:60px;" id="botonResultado" value="Corregir">';
                                $tabla_imagenes.='<input type="button" style="height:40px; width:60px;" id="botonRehacer" value="Rehacer" onClick="location.href=\'./view.php?id=' . $id . '&opcion=8' . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $tipo_respuesta . '&tipocreacion=' . $tipocreacion . '\'">';
                                $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                            }
                        }
                    } else {

                        $tabla_imagenes = '<center><input type="button" style="height:40px; width:60px;" id="botonResultado" value="Corregir">';
                        $tabla_imagenes.='<input type="button" style="height:40px; width:60px;" id="botonRehacer" value="Rehacer" onClick="location.href=\'./view.php?id=' . $id . '&opcion=8' . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $tipo_respuesta . '&tipocreacion=' . $tipocreacion . '\'">';
                        $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                    }
                }


                $tabla_imagenes .='</td>';
                $tabla_imagenes .='<td  width="10%">';
                //añado la parte de vocabulario para la conexión
                $tabla_imagenes .='<div><a  onclick=JavaScript:sele(' . $id . ')><img src="../vocabulario/imagenes/guardar_palabras.png" id="id_guardar_im" name="guardar_im" title="' . get_string('guardar', 'vocabulario') . '"/></a></div>';
                $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=5"><img src="../vocabulario/imagenes/administrar_gramaticas.png" id="id_gram_im" name="gram_im" title="' . get_string('admin_gr', 'vocabulario') . '"/></a></div>';
                $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=7"><img src="../vocabulario/imagenes/intenciones_comunicativas.png" id="id_ic_im" name="ic_im" title="' . get_string('admin_ic', 'vocabulario') . '"/></a></div>';
                $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=9"><img src="../vocabulario/imagenes/tipologias_textuales.png" id="id_tt_im" name="tt_im" title="' . get_string('admin_tt', 'vocabulario') . '"/> </a></div>';
                $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=11"><img src="../vocabulario/imagenes/estrategias_icon.png" id="id_ea_im" name="ea_im" title="' . get_string('admin_ea', 'vocabulario') . '"/> </a></div>';

                $tabla_imagenes .='</td>';

                $tabla_imagenes .='</table>';

                $mform->addElement('html', $tabla_imagenes);


                break;

            case 3: //Es de tipo video la pregunta

                $mform->addElement('html', '<script src="./js/ajaxupload.js" type="text/javascript"></script>');


                //Obtengo las preguntas que son texto
                $mis_preguntas = new Ejercicios_texto_texto_preg();
                echo "Ejercicio Id: $id_ejercicio";
                $preguntas = $mis_preguntas->obtener_todas_preguntas_ejercicicio($id_ejercicio);

                if ($buscar == 1 || $modificable == false) {
                    echo "buscar vale uno y no es modificable";

                    $tabla_imagenes.='<center><table id="tablapreg" name="tablapreg">';
                    $tabla_imagenes.="<tr>";
                    //Inserto las preguntas con clase "item" es decir dragables(mirar javascript.js)
                    for ($i = 1; $i <= sizeof($preguntas); $i++) {
                        echo "obtengo la pregunta";
                        //Obtengo la pregunta
                        $tabla_imagenes.='<td id="texto' . $i . '"> <div class="item" id="' . $i . '">';

                        $tabla_imagenes.='<p style="margin-top: 10%;">' . $preguntas[$i - 1]->get('pregunta') . '</p>';

                        $tabla_imagenes.='</div></div></td>';
                        if ($i % 2 == 0) { //Si es impar lo bajo
                            $tabla_imagenes.="</tr>";
                        }
                    }
                    $tabla_imagenes.="</tr>";
                    $tabla_imagenes.='</table></center>';
                    $tabla_imagenes.="</br>";
                    $tabla_imagenes.="</br>";

                    $tabla_imagenes.='<table id="tablarespuestas" name="tablarespuestas"><center>';

                    $k = 1;
                    $las_respuestas[sizeof($preguntas) + 1];
                    $aleatorios_generados = array();
                    while ($k <= sizeof($preguntas)) {
                        //Obtengo la respuestas (En este caso sólo habrá 1, ya que es "simple")

                        $id_pregunta = $preguntas[$k - 1]->get('id');
                        $mis_respuestas = new Ejercicios_videos_asociados();

                        $respuestas = $mis_respuestas->obtener_todas_respuestas_pregunta($id_pregunta);

                        //Para cada respuesta

                        srand(time());
                        //generamos un número aleatorio entre 1 y el número de pregutnas
                        $numero_aleatorio = rand(1, sizeof($preguntas));

                        //buscamos si aleatorios contine
                        $esta = '0';

                        for ($j = 0; $j < sizeof($aleatorios_generados); $j++) {

                            if ($aleatorios_generados[$j] == $numero_aleatorio) {

                                $esta = '1';
                            }
                        }

                        if ($esta == '0') { //Si no esta lo inserto
                            $nombre_respuestas[] = $respuestas[0]->get('nombre_video');
                            echo $respuestas[0]->get('nombre_video');
                            $aleatorios_generados[] = $numero_aleatorio;
                            $k++;
                        }
                    }


                    echo "AAAAAAAAAAAAAAAAAAAAAAAAaa";

                    for ($j = 0; $j < sizeof($aleatorios_generados); $j++) {
                        $i=$j+1;
                        $tabla_imagenes.='<tr>';

                        $tabla_imagenes.='<td><div class=descripcion>';

                        
                             
                        $tabla_imagenes .= '<object id="video' . $i . ' width="396" height="197">
                                        <param name="movie" value="http://www.youtube.com/v/' . $nombre_respuestas[$j] . '?hl=es_ES&amp;version=3">
                                        </param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param>
                                        <embed src="http://www.youtube.com/v/' .  $nombre_respuestas[$j] . '?hl=es_ES&amp;version=3" type="application/x-shockwave-flash" width="396" height="197" allowscriptaccess="always" allowfullscreen="true">
                                        </embed></object>';

             
                      //  $tabla_imagenes.=' <a class="button super yellow" href="' . $respuestas[0]->get('nombre_video') . '" target="_blank" id="video' . $i . '">Ver Video</a>';


                        $tabla_imagenes.='</td>';

                        $tabla_imagenes.='<td><div  id="' . $aleatorios_generados[$j] . '" class="marquito"></div></td>';
                        $tabla_imagenes.='<td id="aceptado' . $aleatorios_generados[$j] . '" class="marquitoaceptado"></td>';
                        $tabla_imagenes.='</tr>';
                    }

                    $tabla_imagenes.='</table></center>';
                    echo"aki llega";
                    $tabla_imagenes.='<p class="numero" id="' . sizeof($preguntas) . '"></p>';

                    //inserto el número de preguntas

                    $tabla_imagenes.='<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
                } else {
                    echo "akiiiiiiii podemos cambiar";
                    
                    //$tabla_imagenes.='<table id="tablarespuestas" name="tablarespuestas"><center>';
                    //echo sizeof($preguntas);
                    for ($i = 1; $i <= sizeof($preguntas); $i++) {
                        echo "iteracion" . $i . "aaaa" . count($preguntas);
                        /*$tabla_imagenes.="<tr>";
                        $tabla_imagenes.='<td id="texto' . $i . '">';
                        $tabla_imagenes.='<textarea id="pregunta' . $i . '" name="pregunta' . $i . '" style="height: 197px; width: 396px;">' . $preguntas[$i - 1]->get('pregunta') . '</textarea>';
                        $tabla_imagenes.='</td>';*/
                        
                        $id_pregunta = $preguntas[$i-1]->get('id');
                        $el_video_origen = new Ejercicios_videos_asociados();
                        $el_video_origen->obtener_uno_ejpreg($id_ejercicio,$id_pregunta);
                        
                        $divpregunta = '<div id="tabpregunta' . $i . '" >';
                        $divpregunta.='<br/><br/>';
                        $divpregunta.='<table style="width:100%;">';
                        $divpregunta.=' <td style="width:80%;">';
                        
                        $divpregunta.='<div style="width: 900px;" class="pregunta" name="pregunta' . $i . '" id="pregunta' . $i . '">';
                        $divpregunta.='<div style="margin: 0 auto; margin-left: auto; margin-right: auto; width:396px;">';
                        $divpregunta.='<object width="396" height="197">
                                        <param id="movie'.$i.'" name="movie'.$i.'" value="http://www.youtube.com/v/'.$el_video_origen->get('nombre_video').'?hl=es_ES&amp;version=3">
                                        </param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param>
                                        <embed id="embed'.$i.'" src="http://www.youtube.com/v/'.$el_video_origen->get('nombre_video').'?hl=es_ES&amp;version=3" type="application/x-shockwave-flash" width="396" height="197" allowscriptaccess="always" allowfullscreen="true">
                                        </embed></object>';
                        $divpregunta.='</div>';
                        $divpregunta.='<div style="margin: 0 auto; margin-left: auto; margin-right: auto; width:396px;">';
                        $divpregunta.=' <textarea class="video1" name="archivovideo' . $i . '" id="archivovideo' . $i . '" onchange="actualizar_VideoTexto_AM('.$id_ejercicio.','.$i.')" >' . YoutubeVideoHelper::generarVideoUrl($el_video_origen->get('nombre_video')) . '</textarea>';
                        $divpregunta.='</div>';
                        
                        
                        $divpregunta.='</div>';
                        $divpregunta.=' </td>';
                        
                        $divpregunta.='<td style="width:5%;">';
                        $divpregunta.='<img id="imgpregborrar' . $i . '" src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="EliminarPregunta_VideoTexto_AM('.$id_ejercicio.',tabpregunta' . $i . ',' . $i . ')" title="Eliminar Pregunta"></img>';
                        $divpregunta.='</br><img id="imgpreganadir' . $i . '" src="./imagenes/añadir.gif" alt="eliminar respuesta"  height="15px"  width="15px" onClick="anadirRespuesta_IE(respuestas' . $i . ',' . $i . ')" title="Añadir Respuesta"></img>';
                        $divpregunta.='</td> ';
                        $divpregunta.='</br> ';
                        $divpregunta.='</table> ';

                        

                        $mis_respuestas = new Ejercicios_texto_texto_resp();
                        echo "Mi pregunta:".$id_pregunta;
                        $respuestas = $mis_respuestas->obtener_todas_respuestas_pregunta($id_pregunta);
                        
                        $divpregunta.='</br><div id="respuestas' . $i . '" class=respuesta>';
                        for ($p = 0; $p < sizeof($respuestas); $p++) {
                        //die;
                            $q = $p + 1;
                            if ($q%2==0 || $q==sizeof($respuestas)) {
                                $divpregunta.='<table  id="tablarespuesta' . $q . '_' . $i . '" style="width:50%;">';
                            }
                            else {
                                $divpregunta.='<table  id="tablarespuesta' . $q . '_' . $i . '" style="width:50%;float:left;">';
                            }
                            
                            $divpregunta.='<tr id="trrespuesta' . $q . "_" . $i . '"> ';
                            $divpregunta.=' <td style="width:80%;">';
                            $divpregunta.='<textarea style="width: 300px;" class="resp" name="respuesta' . $q . "_" . $i . '" id="respuesta' . $q . "_" . $i . '" value="' . $respuestas[$p]->get('respuesta') . '">' . $respuestas[$p]->get('respuesta') . '</textarea>';
                            $divpregunta.=' </td>';
                            $divpregunta.=' <td style="width:5%;" id="tdcorregir'. $q . "_" . $i .'">';
                            $divpregunta.='<img id="eliminarrespuesta' . $q . '_' . $i . '" src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="EliminarRespuesta_IE(tablarespuesta' . $q . '_' . $i . ',' . $i . ')" title="Eliminar Respuesta"></img>';

                            $divpregunta.='</td> ';
                            $divpregunta.='<tr>';

                            $divpregunta.='</table> ';
                        }

                        /*$tabla_imagenes.= '<td>';
                        //print_r($el_video_origen);
                        
                        //$tabla_imagenes.=' <a onclick="ObtenerDireccion(' . $i . ')" class="button super yellow centrarvideo" href="' . $respuestas[0]->get('nombre_video') . '" target="_blank" id="video' . $i . '">Ver Video</a>';
                        $tabla_imagenes .= '<object width="396" height="197">
                                        <param name="movie" value="http://www.youtube.com/v/'.$el_video_origen->get('nombre_video').'?hl=es_ES&amp;version=3">
                                        </param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param>
                                        <embed src="http://www.youtube.com/v/'.$el_video_origen->get('nombre_video').'?hl=es_ES&amp;version=3" type="application/x-shockwave-flash" width="396" height="197" allowscriptaccess="always" allowfullscreen="true">
                                        </embed></object>';
                        
                        $tabla_imagenes.=' <textarea class="video1" name="archivovideo' . $i . '" id="archivovideo' . $i . '">' . YoutubeVideoHelper::generarVideoUrl($respuestas[0]->get('nombre_video')) . '</textarea>';

                        $tabla_imagenes.='</td>';

                        $tabla_imagenes.='</tr>';*/
                        $divpregunta.='</div>';
                        $divpregunta.='</div>';
                        $divpregunta.='<input type="hidden" value=' . sizeof($respuestas) . ' id="num_res_preg' . $i . '" name="num_res_preg' . $i . '" />';
                        $mform->addElement('html', $divpregunta);
                     
                    }
                    //$tabla_imagenes.='</table></center>';
              
                    //inserto el número de preguntas
                    $divnumpregunta = '<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
                    $mform->addElement('html', $divnumpregunta);

                    //$tabla_imagenes.='<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
                }

                //botones
                //$mform->addElement('html', $tabla_imagenes);
                
                
                echo "botones";
                if ($buscar != 1 && $modificable == true) {
                    //Si soy el profesor creadors
                    $tabla_imagenes = '<input type="submit" style="height:40px; width:90px; margin-left:90px; margin-top:20px;" id="submitbutton" name="submitbutton" value="' . get_string('BotonGuardar', 'ejercicios') . '">';
                    $tabla_imagenes.='<input type="button" style="height:40px; width:120px;  margin-top:20px;" id="botonTextoVideo" name="botonTextoVideo" value="' . get_string('NuevaAso', 'ejercicios') . '" onclick="botonMasPreguntas_VideoTexto_AM(' . $id_ejercicio . ')">';
                    echo "finnnnnnnnn";
                    $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                } else {
                    if ($buscar == 1) { //Si estoy buscand
                        $ejercicios_prof = new Ejercicios_prof_actividad();
                        $ejercicios_del_prof = $ejercicios_prof->obtener_uno_idejercicio($id_ejercicio);
                        if (sizeof($ejercicios_del_prof) == 0) {
                            $noagregado = true;
                        } else {
                            $noagregado = false;
                        }
                        //si el ejercicio no es mio y soy profesor
                        if (has_capability('moodle/legacy:editingteacher', $context, $USER->id, false) && ($modificable == false || $noagregado == true)) {
                            //boton añadir a mis ejercicios
                            $attributes = 'size="40"';
                            $mform->addElement('text', 'carpeta_ejercicio', get_string('carpeta', 'ejercicios'), $attributes);
                            $mform->addRule('carpeta_ejercicio', "Carpeta Necesaria", 'required', null, 'client');
                            $buttonarray = array();
                            $buttonarray[] = &$mform->createElement('submit', 'submitbutton2', get_string('BotonAñadir', 'ejercicios'));
                            $mform->addGroup($buttonarray, 'botones2', '', array(' '), false);
                        } else {

                            if ($modificable == true) { // Si el ejercicio era mio y estoy buscando
                                $tabla_imagenes = '<center><input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                            } else { //Si soy alumno
                                $tabla_imagenes = '<center><input type="button" style="height:40px; width:60px;" id="botonResultado" value="Corregir">';
                                $tabla_imagenes.='<input type="button" style="height:40px; width:60px;" id="botonRehacer" value="Rehacer" onClick="location.href=\'./view.php?id=' . $id . '&opcion=8' . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $tipo_respuesta . '&tipocreacion=' . $tipocreacion . '\'">';
                                $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                            }
                        }
                    } else {

                        $tabla_imagenes = '<center><input type="button" style="height:40px; width:60px;" id="botonResultado" value="Corregir">';
                        $tabla_imagenes.='<input type="button" style="height:40px; width:60px;" id="botonRehacer" value="Rehacer" onClick="location.href=\'./view.php?id=' . $id . '&opcion=8' . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $tipo_respuesta . '&tipocreacion=' . $tipocreacion . '\'">';
                        $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                    }
                    
                    echo "dentro del bucle infernal";
                }

                echo "no muero";
                $tabla_imagenes .='</td>';
                $tabla_imagenes .='<td  width="10%">';
                //añado la parte de vocabulario para la conexión
                $tabla_imagenes .='<div><a  onclick=JavaScript:sele(' . $id . ')><img src="../vocabulario/imagenes/guardar_palabras.png" id="id_guardar_im" name="guardar_im" title="' . get_string('guardar', 'vocabulario') . '"/></a></div>';
                $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=5"><img src="../vocabulario/imagenes/administrar_gramaticas.png" id="id_gram_im" name="gram_im" title="' . get_string('admin_gr', 'vocabulario') . '"/></a></div>';
                $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=7"><img src="../vocabulario/imagenes/intenciones_comunicativas.png" id="id_ic_im" name="ic_im" title="' . get_string('admin_ic', 'vocabulario') . '"/></a></div>';
                $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=9"><img src="../vocabulario/imagenes/tipologias_textuales.png" id="id_tt_im" name="tt_im" title="' . get_string('admin_tt', 'vocabulario') . '"/> </a></div>';
                $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=11"><img src="../vocabulario/imagenes/estrategias_icon.png" id="id_ea_im" name="ea_im" title="' . get_string('admin_ea', 'vocabulario') . '"/> </a></div>';

                $tabla_imagenes .='</td>';

                $tabla_imagenes .='</table>';

                $mform->addElement('html', $tabla_imagenes);
                print_r('final');
                break;
            case 4: //Es una imagen la pregunta
                      $mform->addElement('html', '<script src="./js/ajaxupload.js" type="text/javascript"></script>');

                        echo "SSSSSSSSSSSSSS";
                        //Obtengo las preguntas que son texto
                        $mis_preguntas = new Ejercicios_texto_texto_preg();
                        $preguntas = $mis_preguntas->obtener_todas_preguntas_ejercicicio($id_ejercicio);


                        if ($buscar == 1 || $modificable == false) {
                            $tabla_imagenes.='<center><table id="tablapreg" name="tablapreg">';
                            $tabla_imagenes.="<tr>";
                            //Inserto las preguntas con clase "item" es decir dragables(mirar javascript.js)
                            for ($i = 1; $i <= sizeof($preguntas); $i++) {

                                //Obtengo la pregunta
                                $tabla_imagenes.='<td id="texto' . $i . '"> <div class="item" id="' . $i . '">';

                                $tabla_imagenes.='<p style="margin-top: 10%;">' . $preguntas[$i - 1]->get('pregunta') . '</p>';

                                $tabla_imagenes.='</div></div></td>';
                                if ($i % 2 == 0) { //Si es impar lo bajo
                                    $tabla_imagenes.="</tr>";
                                }
                            }
                            $tabla_imagenes.="</tr>";
                            $tabla_imagenes.='</table></center>';
                            $tabla_imagenes.="</br>";
                            $tabla_imagenes.="</br>";
                            $tabla_imagenes.='<table id="tablarespuestas" name="tablarespuestas"><center>';

                            $k = 1;
                            $las_respuestas[sizeof($preguntas) + 1];
                            $aleatorios_generados = array();
                            while ($k <= sizeof($preguntas)) {
                                //Obtengo la respuestas (En este caso sÃ³lo habrÃ¡ 1, ya que es "simple")

                                $id_pregunta = $preguntas[$k - 1]->get('id');
                                $mis_respuestas = new Ejercicios_imagenes_asociadas();

                                $respuestas = $mis_respuestas->obtener_todas_respuestas_pregunta($id_pregunta);

                                //Para cada respuesta

                                srand(time());
                                //generamos un nÃºmero aleatorio entre 1 y el nÃºmero de pregutnas
                                $numero_aleatorio = rand(1, sizeof($preguntas));

                                //buscamos si aleatorios contine
                                $esta = '0';


                                for ($j = 0; $j < sizeof($aleatorios_generados); $j++) {

                                    if ($aleatorios_generados[$j] == $numero_aleatorio) {

                                        $esta = '1';
                                    }
                                }

                                if ($esta == '0') { //Si no esta lo inserto
                                    $nombre_respuestas[] = $respuestas[0]->get('nombre_imagen');
                                    echo $respuestas[0]->get('nombre_imagen');
                                    $aleatorios_generados[] = $numero_aleatorio;
                                    $k++;
                                }
                            }


                            echo "AAAAAAAAAAAAAAAAAAAAAAAAaa";
                            for ($j = 0; $j < sizeof($aleatorios_generados); $j++) {
                                $tabla_imagenes.='<tr>';

                                $tabla_imagenes.='<td><div class=descripcion>';
                                $tabla_imagenes.= '<img name="respuesta' . $i . '" id="respuesta' . $i . '" src="./imagenes/' . $nombre_respuestas[$aleatorios_generados[$j] - 1] . '"   style="height: 192px; width: 401px;" ></img>';
                                $tabla_imagenes.='</div></td>';

                                $tabla_imagenes.='<td><div  id="' . $aleatorios_generados[$j] . '" class="marquito"></div></td>';
                                $tabla_imagenes.='<td id="aceptado' . $aleatorios_generados[$j] . '" class="marquitoaceptado"></td>';
                                $tabla_imagenes.='</tr>';
                            }

                            $tabla_imagenes.='</table></center>';
                            $tabla_imagenes.='<p class="numero" id="' . sizeof($preguntas) . '"></p>';

                            //inserto el nÃºmero de preguntas

                            $tabla_imagenes.='<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
                        } else {
                            echo "akiiiiiiii";
                            $tabla_imagenes.='<table id="tablarespuestas" name="tablarespuestas"><center>';

                            for ($i = 1; $i <= sizeof($preguntas); $i++) {
                                echo "iteracion" . $i . "aaaa" . sizeof($preguntas);
                                $tabla_imagenes.="<tr>";
                                $tabla_imagenes.='<td id="texto' . $i . '">';
                                $tabla_imagenes.='<textarea id="pregunta' . $i . '" name="pregunta' . $i . '" style="height: 197px; width: 396px;">' . $preguntas[$i - 1]->get('pregunta') . '</textarea>';
                                $tabla_imagenes.='</td>';

                                $id_pregunta = $preguntas[$i - 1]->get('id');
                                echo 'id pregunta vale: ' . $id_pregunta;
                                $mis_respuestas = new Ejercicios_imagenes_asociadas();
                                $respuestas = $mis_respuestas->obtener_todas_respuestas_pregunta($id_pregunta);
                                 echo "tamaÃ±o".sizeof($respuestas);
                                   echo "el nombre es". $respuestas[0]->get('nombre_imagen');
                                $tabla_imagenes.= '<td>';
                                $tabla_imagenes.= '<div id="capa1">';
                                $tabla_imagenes.='<a href="javascript:cargaImagenes(\'' . $respuestas[0]->get('nombre_imagen') . '\',' . $i . ',\'primera\')" id="upload' . $i . '" class="up">Cambiar Foto</a>';
                                // $tabla_imagenes.='<input name="uploadedfile" type="file" />';
                                // $tabla_imagenes.='</div>';
                                $tabla_imagenes.='</div>';
                                $tabla_imagenes.='<div id="capa2"> ';
                                $tabla_imagenes.='<img  name="respuesta' . $i . '" id="respuesta' . $i . '" src="./imagenes/' . $respuestas[0]->get('nombre_imagen') . '"   style="height: 192px; width: 401px;" ></img>';
                                $tabla_imagenes.='</div>';
                                echo 'aki tambien llega';



                                $tabla_imagenes.='</td>';

                                $tabla_imagenes.='</tr>';
                                // $tabla_imagenes.="<tr>";
                                // $mform->addElement('html',$tabla_imagenes);
                                // $mform->addElement('file', 'archivofoto'.$i,'Cambiar Imagen '.$i);
                                // $tabla_imagenes='</tr>';
                                // $mform->addElement('html',$tabla_imagenes);
                                //    $tabla_imagenes.='</td>';
                                // $tabla_imagenes.='</td>';
                                //  $tabla_imagenes.="</tr>";
                            }
                            $tabla_imagenes.='</table></center>';

                            //inserto el nÃºmero de preguntas

                            $tabla_imagenes.='<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
                        }



                        //botones
                        $mform->addElement('html', $tabla_imagenes);


                        if ($buscar != 1 && $modificable == true) {
                            //Si soy el profesor creadors
                            $tabla_imagenes = '<input type="submit" style="height:40px; width:90px; margin-left:90px; margin-top:20px;" id="submitbutton" name="submitbutton" value="' . get_string('BotonGuardar', 'ejercicios') . '">';
                            $tabla_imagenes.='<input type="button" style="height:40px; width:120px;  margin-top:20px;" id="botonTextoImagen" name="botonTextoImagen" value="' . get_string('NuevaAso', 'ejercicios') . '" onclick="botonASTextoImagen(' . $id_ejercicio . ')">';
                            $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                        } else {
                            if ($buscar == 1) { //Si estoy buscand
                                $ejercicios_prof = new Ejercicios_prof_actividad();
                                $ejercicios_del_prof = $ejercicios_prof->obtener_uno_idejercicio($id_ejercicio);
                                if (sizeof($ejercicios_del_prof) == 0) {
                                    $noagregado = true;
                                } else {
                                    $noagregado = false;
                                }
                                //si el ejercicio no es mio y soy profesor
                                if (has_capability('moodle/legacy:editingteacher', $context, $USER->id, false) && ($modificable == false || $noagregado == true)) {
                                    //boton aÃ±adir a mis ejercicios
                                    $attributes = 'size="40"';
                                    $mform->addElement('text', 'carpeta_ejercicio', get_string('carpeta', 'ejercicios'), $attributes);
                                    $mform->addRule('carpeta_ejercicio', "Carpeta Necesaria", 'required', null, 'client');
                                    $buttonarray = array();
                                    $buttonarray[] = &$mform->createElement('submit', 'submitbutton2', get_string('BotonAÃ±adir', 'ejercicios'));
                                    $mform->addGroup($buttonarray, 'botones2', '', array(' '), false);
                                } else {

                                    if ($modificable == true) { // Si el ejercicio era mio y estoy buscando
                                        $tabla_imagenes = '<center><input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                                    } else { //Si soy alumno
                                        $tabla_imagenes = '<center><input type="button" style="height:40px; width:60px;" id="botonResultado" value="Corregir">';
                                        $tabla_imagenes.='<input type="button" style="height:40px; width:60px;" id="botonRehacer" value="Rehacer" onClick="location.href=\'./view.php?id=' . $id . '&opcion=8' . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $tipo_respuesta . '&tipocreacion=' . $tipocreacion . '\'">';
                                        $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                                    }
                                }
                            } else {

                                $tabla_imagenes = '<center><input type="button" style="height:40px; width:60px;" id="botonResultado" value="Corregir">';
                                $tabla_imagenes.='<input type="button" style="height:40px; width:60px;" id="botonRehacer" value="Rehacer" onClick="location.href=\'./view.php?id=' . $id . '&opcion=8' . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $tipo_respuesta . '&tipocreacion=' . $tipocreacion . '\'">';
                                $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                            }
                        }


                        $tabla_imagenes .='</td>';
                        $tabla_imagenes .='<td  width="10%">';
                        //aÃ±ado la parte de vocabulario para la conexiÃ³n
                        $tabla_imagenes .='<div><a  onclick=JavaScript:sele(' . $id . ')><img src="../vocabulario/imagenes/guardar_palabras.png" id="id_guardar_im" name="guardar_im" title="' . get_string('guardar', 'vocabulario') . '"/></a></div>';
                        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=5"><img src="../vocabulario/imagenes/administrar_gramaticas.png" id="id_gram_im" name="gram_im" title="' . get_string('admin_gr', 'vocabulario') . '"/></a></div>';
                        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=7"><img src="../vocabulario/imagenes/intenciones_comunicativas.png" id="id_ic_im" name="ic_im" title="' . get_string('admin_ic', 'vocabulario') . '"/></a></div>';
                        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=9"><img src="../vocabulario/imagenes/tipologias_textuales.png" id="id_tt_im" name="tt_im" title="' . get_string('admin_tt', 'vocabulario') . '"/> </a></div>';
                        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=11"><img src="../vocabulario/imagenes/estrategias_icon.png" id="id_ea_im" name="ea_im" title="' . get_string('admin_ea', 'vocabulario') . '"/> </a></div>';

                        $tabla_imagenes .='</td>';

                        $tabla_imagenes .='</table>';

                        $mform->addElement('html', $tabla_imagenes);



                break;
        }
        
        echo "termino del todo";
    }

}

?>
