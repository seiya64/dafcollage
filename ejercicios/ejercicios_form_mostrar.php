<?php

//$Id: mod_form.php,v 1.2.2.3 2009/03/19 12:23:11 mudrd8mz Exp $

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
  Javier Castro Fernández (havidarou@gmail.com)

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
require_once("../../config.php");
require_once($CFG->dirroot . '/course/moodleform_mod.php');
require_once("ejercicios_clases.php");
require_once("ejercicios_clase_general.php");
require_once("YoutubeVideoHelper.php");


/* Formulario que muestra el tipo de ejercicio MULTIPLE CHOICE
 * @author Serafina Molina Soto; Modificado Javier Castro Fernández
 */

class mod_ejercicios_mostrar_ejercicio extends moodleform_mod {
    /* // Comentarios añadidos por Javier Castro Fernández //
     * Constructor de clase
     * LLama al archivo ejercicios_modificar_texto_texto.php 
     * Se encarga de cargar los datos de sesión del primer paso y de guardar el ejercicio al finalizar su creación
     */

    function mod_ejercicios_mostrar_ejercicio($id, $p, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion) {
        parent::moodleform('ejercicios_modificar_texto_texto.php?id_curso=' . $id . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $trespuesta . '&tipocreacion=' . $tipocreacion);
    }

    function definition() { 
    
    }
    
    function creando_ejercicio (&$mform, $id, $p, $id_ejercicio, $tipo_origen) {
        
		global $CFG;
        $ejercicio_general = unserialize($_SESSION['ejercicioGeneral']);
        $carpeta = unserialize($_SESSION['cosasProfe']);
        
        // Se obtienen los datos del ejercicio a partir de los datos almacenados en sesión
        // Hay que tener en cuenta que parte de los datos del ejercicioGeneral se van a rellenar en este paso
        // debido a añadidos posteriores (las fuentes y la imagen asociada)
        // para la posterior creación (manejada por ejercicio_modificar_texto_texto.php)
        $nombre = $ejercicio_general->get('name');
        $npreg = $ejercicio_general->get('numpreg');
        $creador = $ejercicio_general->get('id_creador');
        $tipo_origen = $ejercicio_general->get('tipoarchivopregunta');
        $licencia = $ejercicio_general->get("copyrightpreg");
        $visible = $ejercicio_general->get("visible");
        $publico = $ejercicio_general->get("publico");
        
        // Identificador del ejercicio para la foto asociada. A la espera de una mejor solución.
		// Mejor solucion?? se le pasa la ruta de destino completa.
        $mform->addElement('html', '<input id="idFoto" type="hidden" value="/temporal'.$creador.'">');
        
        // Se imprime el título del ejercicio
        $titulo = genera_titulos($nombre, get_string('Tipo2', 'ejercicios'), $id);
        $mform->addElement('html', $titulo);
        
        // Se imprime la descripción del ejercicio
        $descripcion = genera_descripcion($ejercicio_general->get('descripcion'));
        $mform->addElement('html', $descripcion);
		
        $tabla_imagenesHTML = '<div id="capa1">';
        $tabla_imagenesHTML.= '<a id="botonFoto" class="up">Cambiar Foto</a>';
        $tabla_imagenesHTML.= '</div>';
        $tabla_imagenesHTML.= '<div id="capa2"> ';
        $tabla_imagenesHTML.= '<img  name="fotoAsociada" id="fotoAsociada" src="./" style="height: 300px;></img>';
        $tabla_imagenesHTML.= '</div>';
        $mform->addElement('html', $tabla_imagenesHTML);
        
        // Cargamos el origen según su tipo 
        switch ($tipo_origen) {

            case 1: // En caso de que sea texto
                $mform->addElement('textarea', 'texto', get_string('textoorigen', 'ejercicios'), 'wrap="virtual" style="width: inherit;"');
                $mform->addRule('texto', "Texto Origen Necesario", 'required', null, 'client');
                break;

            case 2: // En caso de que sea audio
                $mform->addElement('file', 'archivoaudio', "Audio");
                $mform->addRule('archivoaudio', "Archivo Necesario", 'required', null, 'client');
                break;

            case 3: // En caso de que sea un vídeo
                $origen_video = new Ejercicios_videos();
                $vervideo = '<object width="560" height="315" class="video">
                             <param name="movie" value="http://www.youtube.com/v/' . $origen_video->get('video') . '?hl=es_ES&amp;version=3">
                             </param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param>
                             <embed src="http://www.youtube.com/v/' . $origen_video->get('video') . '?hl=es_ES&amp;version=3" type="application/x-shockwave-flash" width="560" height="315" allowscriptaccess="always" allowfullscreen="true">
                             </embed></object>';
                $attributes='size="100"';
                $mform->addElement('text', 'archivovideo',get_string('Video', 'ejercicios') , $attributes);
                $mform->addRule('archivovideo', "Dirección Web Necesaria", 'required', null, 'client');
                break;
        }

        // Se crea una tabla en la que se incluirán los distintos elementos del formulario para añadir las respuestas
        $tabla_imagenes = '<table width="100%">';
        $tabla_imagenes .='<td>';
        $mform->addElement('html', $tabla_imagenes);

        $divpregunta = '<div id="tabpregunta1" >';
        $divpregunta.='<br/><br/>';
        $divpregunta.='<table style="width:100%;">';
        $divpregunta.='<td style="width:80%;">';
        $divpregunta.='<textarea style="width: 900px;" class="pregunta" name="pregunta1" id="pregunta1"> Introduzca la pregunta... </textarea>';
        $divpregunta.='</td>';
        $divpregunta.='<td style="width:5%;">';
        $divpregunta.='<img id="imgpregborrar" src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="EliminarPregunta(tabpregunta1, 1)" title="Eliminar Pregunta"></img>';
        $divpregunta.='</br><img id="imgpreganadir" src="./imagenes/añadir.gif" alt="eliminar respuesta"  height="15px"  width="15px" onClick="anadirRespuesta(respuestas1, 1)" title="Añadir Respuesta"></img>';
        $divpregunta.='</td> ';
        $divpregunta.='</br> ';
        $divpregunta.='</table> ';
        
        // Para cada respuesta...
        $divpregunta.='</br><div id="respuestas1" class=respuesta>';
        $divpregunta.='</div>';
        $divpregunta.='</div>';
        
        $divpregunta.='<input type="hidden" value=0 id="num_res_preg1" name="num_res_preg1" />';
        $mform->addElement('html', $divpregunta);

        // Botón añadir preguntas
        $botones = '<left><input type="button" style="margin-top:20px;" id="id_Añadir" value="Añadir Pregunta" onclick="javascript:botonMasPreguntas()"></left>';
        $mform->addElement('html', $botones);
        
        $divnumpregunta = '<input type="hidden" value=1 id="num_preg" name="num_preg" />';
        $mform->addElement('html', $divnumpregunta);
        
        // Autoría del ejercicio
        $userid = get_record ('user', 'id', $creador);
        $autoria = genera_autoria($userid);
        $mform->addElement('html', $autoria);
        
        $imagenLicencia = genera_licencia($licencia);
        $mform->addElement('html', $imagenLicencia);   
        
        $radioarray = array();
        $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiovisible', '', "Si", "Si", null);
        $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiovisible', '', "No", "No", null);

        $mform->addGroup($radioarray, 'radiovisible', get_string('visible', 'ejercicios'), array(' '), false);
        if ($visible == 1) {
            $mform->setDefault('radiovisible', "Si");
        } else {
            $mform->setDefault('radiovisible', "No");
        }

        $radioarray = array();
        $radioarray[] = &MoodleQuickForm::createElement('radio', 'radioprivado', '', "Si", "Si", null);
        $radioarray[] = &MoodleQuickForm::createElement('radio', 'radioprivado', '', "No", "No", null);

        $mform->addGroup($radioarray, 'radioprivado', get_string('publico', 'ejercicios'), array(' '), false);
        if ($publico == 1) {
            $mform->setDefault('radioprivado', "Si");
        } else {
            $mform->setDefault('radioprivado', "No");
        }
        
        // Se añade el botón guardar y el texto para las fuentes editable si es modificable
        // Text area para reflejar las fuentes empleadas en el ejercicio
        $fuentes_aux = "";
        $fuentes = genera_fuentes($fuentes_aux, "");
        $mform->addElement('html', $fuentes);

        // Botón guardar
        $botones = '<center><input type="submit" style="margin-top:20px;" id="submitbutton" name="submitbutton" value="' . get_string('BotonGuardar', 'ejercicios') . '"></center>';
        $mform->addElement('html', $botones);

        $tabla_imagenes = '</td>';
        $tabla_imagenes .='<td  width="10%">';

        $tabla_imagenes .='</td>';
        $tabla_imagenes .='</table>';
        $mform->addElement('html', $tabla_imagenes);
    }

    // Buscando y con permisos
    function mostrar_con_permisos (&$mform, $id, $p, $id_ejercicio, $tipo_origen, $ejercicios_leido) {

        // Identificador del ejercicio para la foto asociada. A la espera de una mejor solución.
        $mform->addElement('html', '<input id="idFoto" type="hidden" value="' . $id_ejercicio . '">');

        // Y se cargan sus datos en algunas variables
        $nombre = $ejercicios_leido->get('name');
        $npreg = $ejercicios_leido->get('numpreg');
        $creador = $ejercicios_leido->get('id_creador');
        $tipo_origen = $ejercicios_leido->get('tipoarchivopregunta');
        $licencia = $ejercicios_leido->get("copyrightpreg");
        $visible = $ejercicios_leido->get("visible");
        $publico = $ejercicios_leido->get("publico");

        // Se imprime el título del ejercicio
        $titulo = genera_titulos($nombre, get_string('Tipo2', 'ejercicios'), $id);
        $mform->addElement('html', $titulo);

        // Se imprime la descripción del ejercicio
        $descripcion = genera_descripcion($ejercicios_leido->get('descripcion'));
        $mform->addElement('html', $descripcion);

        // Sacamos la imagen de la bd
        $fotoAsociada = $ejercicios_leido->get("fotoAsociada");

        // Cargamos el origen según su tipo 
        switch ($tipo_origen) {

            case 1: // En caso de que sea texto

                $origen_texto = new Ejercicios_textos();
                $origen_texto->obtener_uno_id_ejercicio($id_ejercicio);

                // Buscamos y tenemos permiso de edición
                $divtexto = '<textarea  class="adaptHeightInput" name="texto" id="texto">' . $origen_texto->get('texto') . '</textarea>';
                $mform->addElement('html', $divtexto);
                break;

            case 2: // En caso de que sea audio

                $mform->addElement('html', '<script type="text/javascript" src="./mediaplayer/swfobject.js"></script>');
                $divaudio = '<div class="claseaudio" id="player1"></div>';
                $mform->addElement('html', $divaudio);
                $mform->addElement('html', '<script type="text/javascript"> var so = new SWFObject("./mediaplayer/mediaplayer.swf","mpl","290","20","7");
                        so.addParam("allowfullscreen","true");
                        so.addVariable("file","./mediaplayer/audios/audio' . $id_ejercicio . '.mp3");
                        so.addVariable("height","20");
                        so.addVariable("width","320");
                        so.write("player1");
                        </script>');

                break;

            case 3: // En caso de que sea un vídeo

                $origen_video = new Ejercicios_videos();
                $origen_video->obtener_uno_id_ejercicio($id_ejercicio);
                $vervideo = '<object width="560" height="315" class="video">
                             <param name="movie" value="http://www.youtube.com/v/' . $origen_video->get('video') . '?hl=es_ES&amp;version=3">
                             </param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param>
                             <embed src="http://www.youtube.com/v/' . $origen_video->get('video') . '?hl=es_ES&amp;version=3" type="application/x-shockwave-flash" width="560" height="315" allowscriptaccess="always" allowfullscreen="true">
                             </embed></object>';


                $yvh = YoutubeVideoHelper::generarVideoUrl($origen_video->get('video'));
                $vervideo.= '<textarea class="video" name="archivovideo" id="archivovideo">' . $yvh . '</textarea>';
                $mform->addElement('html', $vervideo);

                break;
        }

            // Se crea una tabla en la que se incluirán los distintos elementos del formulario para añadir las respuestas
            $tabla_imagenes = '<table width="100%">';
            $tabla_imagenes .='<td>';
            $mform->addElement('html', $tabla_imagenes);

            // Obtengo las respuestas
            $mis_preguntas = new Ejercicios_texto_texto_preg();
            $preguntas = $mis_preguntas->obtener_todas_preguntas_ejercicicio($id_ejercicio);

            for ($i = 1; $i <= sizeof($preguntas); $i++) {
                $divpregunta = '<div id="tabpregunta' . $i . '" >';
                $divpregunta.='<br/><br/>';
                $divpregunta.='<table style="width:100%;">';
                $divpregunta.='<td style="width:80%;">';

                $divpregunta.='<textarea style="width: 900px;" class="pregunta" name="pregunta' . $i . '" id="pregunta' . $i . '">' . $preguntas[$i - 1]->get('pregunta') . '</textarea>';

                $divpregunta.=' </td>';

                // Se añaden botones de edición si se tiene permiso
                    $divpregunta.=' <td style="width:5%;">';
                    $divpregunta.='<img id="imgpregborrar' . $i . '" src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="EliminarPregunta(tabpregunta' . $i . ',' . $i . ')" title="Eliminar Pregunta"></img>';
                    $divpregunta.='</br><img id="imgpreganadir' . $i . '" src="./imagenes/añadir.gif" alt="eliminar respuesta"  height="15px"  width="15px" onClick="anadirRespuesta(respuestas' . $i . ',' . $i . ')" title="Añadir Respuesta"></img>';
                    $divpregunta.='</td> ';
                    $divpregunta.='</br> ';

                $divpregunta.='</table> ';

                // Se obtienen las respuestas de la pregunta
                $id_pregunta = $preguntas[$i - 1]->get('id');
                $mis_respuestas = new Ejercicios_texto_texto_resp();
                $respuestas = $mis_respuestas->obtener_todas_respuestas_pregunta($id_pregunta);

                // Para cada respuesta...
                $divpregunta.='</br><div id="respuestas' . $i . '" class=respuesta>';
                for ($p = 0; $p < sizeof($respuestas); $p++) {
                    $q = $p + 1;

                    $divpregunta.='<table  id="tablarespuesta' . $q . '_' . $i . '" style="width:100%;">';
                    $divpregunta.='<tr id="trrespuesta' . $q . "_" . $i . '"> ';
                    $divpregunta.=' <td style="width:80%;">';

                    $correc = $respuestas[$p]->get('correcta');

                    if ($correc) {
                        $divpregunta.='<input type="hidden" value=1 id="res' . $q . "_" . $i . '" name="res' . $i . '" />';
                    } else {
                        $divpregunta.='<input type="hidden" value=0 id="res' . $q . "_" . $i . '" name="res' . $i . '" />';
                    }
                    $divpregunta.='<input class=over type="radio" name="crespuesta' . $q . '_' . $i . '" id="id_crespuesta' . $q . '_' . $i . '" value="0" onclick="BotonRadio(crespuesta' . $q . '_' . $i . ')"/>';

                    //   $divpregunta.='<div class="resp" name="respuesta'.$q."_".$i.'" id="respuesta'.$q."_".$i.'" contentEditable=true>';
                    //   $divpregunta.=$preguntas[$p]->get('Respuesta');
                    //   $divpregunta.='</div>';

                        $divpregunta.='<textarea style="width: 700px;" class="resp" name="respuesta' . $q . "_" . $i . '" id="respuesta' . $q . "_" . $i . '" value="' . $respuestas[$p]->get('respuesta') . '">' . $respuestas[$p]->get('respuesta') . '</textarea>';
                    $divpregunta.=' </td>';
                    $divpregunta.=' <td style="width:5%;">';

                    // Se añaden botones de edición si se tiene permiso
                        // La imagen para eliminar las respuestas
                        $divpregunta.='<img id="eliminarrespuesta' . $q . '_' . $i . '" src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="EliminarRespuesta(tablarespuesta' . $q . '_' . $i . ',' . $i . ')" title="Eliminar Respuesta"></img>';

                        // La imagen para cambiar las respuestas
                        if ($correc) {
                            $divpregunta.='<img src="./imagenes/correcto.png" id="correcta' . $q . '_' . $i . '" alt="respuesta correcta"  height="15px"  width="15px" onClick="InvertirRespuesta(correcta' . $q . '_' . $i . ',1)" title="Cambiar a Incorrecta"></img>';
                            $divpregunta.='<input type="hidden" value="1"  id="valorcorrecta' . $q . '_' . $i . '" name="valorcorrecta' . $q . '_' . $i . '" />';
                        } else {
                            $divpregunta.='<img src="./imagenes/incorrecto.png" id="correcta' . $q . '_' . $i . '" alt="respuesta correcta"  height="15px"  width="15px" onClick="InvertirRespuesta(correcta' . $q . '_' . $i . ',0)" title="Cambiar a Correcta"></img>';
                            $divpregunta.='<input type="hidden" value="0"  id="valorcorrecta' . $q . '_' . $i . '" name="valorcorrecta' . $q . '_' . $i . '" />';
                        }


                    $divpregunta.='</td> ';
                    $divpregunta.='<tr>';

                    $divpregunta.='</table> ';
                }

                $divpregunta.='</div>';
                $divpregunta.='</div>';

                $divpregunta.='<input type="hidden" value=' . sizeof($respuestas) . ' id="num_res_preg' . $i . '" name="num_res_preg' . $i . '" />';
                $mform->addElement('html', $divpregunta);
            }

            // Botón añadir preguntas

                $botones = '<left><input type="button" style="margin-top:20px;" id="id_Añadir" value="Añadir Pregunta" onclick="javascript:botonMasPreguntas()"></left>';
                $mform->addElement('html', $botones);

            $divnumpregunta = '<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
            $mform->addElement('html', $divnumpregunta);

            // Autoría del ejercicio

            $userid = get_record('user', 'id', $creador);
            $autoria = genera_autoria($userid);
            $mform->addElement('html', $autoria);

            $imagenLicencia = genera_licencia($licencia);
            $mform->addElement('html', $imagenLicencia);


                $radioarray = array();
                $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiovisible', '', "Si", "Si", null);
                $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiovisible', '', "No", "No", null);

                $mform->addGroup($radioarray, 'radiovisible', get_string('visible', 'ejercicios'), array(' '), false);
                if ($visible == 1) {
                    $mform->setDefault('radiovisible', "Si");
                } else {
                    $mform->setDefault('radiovisible', "No");
                }

                $radioarray = array();
                $radioarray[] = &MoodleQuickForm::createElement('radio', 'radioprivado', '', "Si", "Si", null);
                $radioarray[] = &MoodleQuickForm::createElement('radio', 'radioprivado', '', "No", "No", null);

                $mform->addGroup($radioarray, 'radioprivado', get_string('publico', 'ejercicios'), array(' '), false);
                if ($publico == 1) {
                    $mform->setDefault('radioprivado', "Si");
                } else {
                    $mform->setDefault('radioprivado', "No");
                }



            // Se añade el botón guardar y el texto para las fuentes editable si es modificable


                // Text area para reflejar las fuentes empleadas en el ejercicio
                $fuentes_aux = $ejercicios_leido->get('fuentes');
                $fuentes = genera_fuentes($fuentes_aux, "");
                $mform->addElement('html', $fuentes);

                // Botón guardar
                $botones = '<center><input type="submit" style="margin-top:20px;" id="submitbutton" name="submitbutton" value="' . get_string('BotonGuardar', 'ejercicios') . '"></center>';
                $mform->addElement('html', $botones);

            $tabla_imagenes = '</td>';
            $tabla_imagenes .='<td  width="10%">';

            $tabla_imagenes .='</td>';
            $tabla_imagenes .='</table>';
            $mform->addElement('html', $tabla_imagenes);
    }
    
    // Buscando y sin permisos
    function mostrar_sin_permisos ($mform, $id, $p, $id_ejercicio, $tipo_origen, $ejercicios_leido) {

            // Identificador del ejercicio para la foto asociada. A la espera de una mejor solución.
            $mform->addElement('html', '<input id="idFoto" type="hidden" value="' . $id_ejercicio . '">');

            // Y se cargan sus datos en algunas variables
            $nombre = $ejercicios_leido->get('name');
            $npreg = $ejercicios_leido->get('numpreg');
            $creador = $ejercicios_leido->get('id_creador');
            $tipo_origen = $ejercicios_leido->get('tipoarchivopregunta');
            $licencia = $ejercicios_leido->get("copyrightpreg");
            $visible = $ejercicios_leido->get("visible");
            $publico = $ejercicios_leido->get("publico");

            // Se imprime el título del ejercicio
            $titulo = genera_titulos($nombre, get_string('Tipo2', 'ejercicios'), $id);
            $mform->addElement('html', $titulo);

            // Se imprime la descripción del ejercicio
            $descripcion = genera_descripcion($ejercicios_leido->get('descripcion'));
            $mform->addElement('html', $descripcion);

                $fotoAsociada = $ejercicios_leido->get("fotoAsociada");

            // Cargamos el origen según su tipo 
            switch ($tipo_origen) {

                case 1: // En caso de que sea texto

                    $origen_texto = new Ejercicios_textos();
                    $origen_texto->obtener_uno_id_ejercicio($id_ejercicio);

                            $divtexto = '<div class="desctexto" name="texto" id="texto"><div class="margenes">' . nl2br((stripslashes($origen_texto->get('texto')))) . '</div></div>';
                        $mform->addElement('html', $divtexto);

                    break;

                case 2: // En caso de que sea audio

                        $mform->addElement('html', '<script type="text/javascript" src="./mediaplayer/swfobject.js"></script>');
                        $divaudio = '<div class="claseaudio" id="player1"></div>';
                        $mform->addElement('html', $divaudio);
                        $mform->addElement('html', '<script type="text/javascript"> var so = new SWFObject("./mediaplayer/mediaplayer.swf","mpl","290","20","7");
                        so.addParam("allowfullscreen","true");
                        so.addVariable("file","./mediaplayer/audios/audio' . $id_ejercicio . '.mp3");
                        so.addVariable("height","20");
                        so.addVariable("width","320");
                        so.write("player1");
                        </script>');

                    break;

                case 3: // En caso de que sea un vídeo

                    $origen_video = new Ejercicios_videos();
                    $origen_video->obtener_uno_id_ejercicio($id_ejercicio);
                    $vervideo = '<object width="560" height="315" class="video">
                             <param name="movie" value="http://www.youtube.com/v/' . $origen_video->get('video') . '?hl=es_ES&amp;version=3">
                             </param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param>
                             <embed src="http://www.youtube.com/v/' . $origen_video->get('video') . '?hl=es_ES&amp;version=3" type="application/x-shockwave-flash" width="560" height="315" allowscriptaccess="always" allowfullscreen="true">
                             </embed></object>';

                            $vervideo .= "";

                        $mform->addElement('html', $vervideo);

                    break;
            }

            // Se crea una tabla en la que se incluirán los distintos elementos del formulario para añadir las respuestas
            $tabla_imagenes = '<table width="100%">';
            $tabla_imagenes .='<td>';
            $mform->addElement('html', $tabla_imagenes);

            // Obtengo las respuestas
            $mis_preguntas = new Ejercicios_texto_texto_preg();
            $preguntas = $mis_preguntas->obtener_todas_preguntas_ejercicicio($id_ejercicio);

            for ($i = 1; $i <= sizeof($preguntas); $i++) {
                $divpregunta = '<div id="tabpregunta' . $i . '" >';
                $divpregunta.='<br/><br/>';
                $divpregunta.='<table style="width:100%;">';
                $divpregunta.='<td style="width:80%;">';

                    $divpregunta.='<div style="width: 900px;" class="pregunta" name="pregunta' . $i . '" id="pregunta' . $i . '">' . $preguntas[$i - 1]->get('pregunta') . '</div>';


                $divpregunta.=' </td>';

                $divpregunta.='</table> ';

                // Se obtienen las respuestas de la pregunta
                $id_pregunta = $preguntas[$i - 1]->get('id');
                $mis_respuestas = new Ejercicios_texto_texto_resp();
                $respuestas = $mis_respuestas->obtener_todas_respuestas_pregunta($id_pregunta);

                // Para cada respuesta...
                $divpregunta.='</br><div id="respuestas' . $i . '" class=respuesta>';
                for ($p = 0; $p < sizeof($respuestas); $p++) {
                    $q = $p + 1;

                    $divpregunta.='<table  id="tablarespuesta' . $q . '_' . $i . '" style="width:100%;">';
                    $divpregunta.='<tr id="trrespuesta' . $q . "_" . $i . '"> ';
                    $divpregunta.=' <td style="width:80%;">';

                    $correc = $respuestas[$p]->get('correcta');

                    if ($correc) {
                        $divpregunta.='<input type="hidden" value=1 id="res' . $q . "_" . $i . '" name="res' . $i . '" />';
                    } else {
                        $divpregunta.='<input type="hidden" value=0 id="res' . $q . "_" . $i . '" name="res' . $i . '" />';
                    }
                    $divpregunta.='<input class=over type="radio" name="crespuesta' . $q . '_' . $i . '" id="id_crespuesta' . $q . '_' . $i . '" value="0" onclick="BotonRadio(crespuesta' . $q . '_' . $i . ')"/>';

                        $divpregunta.='<div style="width: 700px;" class="resp" name="respuesta' . $q . "_" . $i . '" id="respuesta' . $q . "_" . $i . '" value="' . $respuestas[$p]->get('respuesta') . '">' . $respuestas[$p]->get('respuesta') . '</div>';

                    $divpregunta.=' </td>';
                    $divpregunta.=' <td style="width:5%;">';

                    $divpregunta.='</td> ';
                    $divpregunta.='<tr>';

                    $divpregunta.='</table> ';
                }

                $divpregunta.='</div>';
                $divpregunta.='</div>';

                $divpregunta.='<input type="hidden" value=' . sizeof($respuestas) . ' id="num_res_preg' . $i . '" name="num_res_preg' . $i . '" />';
                $mform->addElement('html', $divpregunta);
            }

            $divnumpregunta = '<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
            $mform->addElement('html', $divnumpregunta);

            // Autoría del ejercicio

            $userid = get_record('user', 'id', $creador);
            $autoria = genera_autoria($userid);
            $mform->addElement('html', $autoria);

            $imagenLicencia = genera_licencia($licencia);
            $mform->addElement('html', $imagenLicencia);

            // Se añade el botón guardar y el texto para las fuentes editable si es modificable
                    $ejercicios_prof = new Ejercicios_prof_actividad();
                    $ejercicios_del_prof = $ejercicios_prof->obtener_uno_idejercicio($id_ejercicio);
                    if (sizeof($ejercicios_del_prof) == 0) {
                        $noagregado = true;
                    } else {
                        $noagregado = false;
                    }

                            $fuentes_aux = $ejercicios_leido->get('fuentes');
                            $fuentes = genera_fuentes($fuentes_aux, "readonly");
                            $mform->addElement('html', $fuentes);

                            $tabla_menu = '<center><input type="button" style="margin-top:20px;"  value="Corregir" onClick="javascript:botonCorregirMultiChoice(' . $id . ',' . $npreg . ')"/> <input type="button" style=""  id="id_Menu" value="Menu Principal" onClick="javascript:botonPrincipal(' . $id . ')" /></center>';
                            $mform->addElement('html', $tabla_menu);

            $tabla_imagenes = '</td>';
            $tabla_imagenes .='<td  width="10%">';
            //Para alumnos
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
    
    /**
     * Muestra el ejercicio Multiple Choice con vistas separadas para alumno y profesores
     *
     * @author Serafina Molina Soto; Modificado Javier Castro Fernández
     * @param $id id for the course
     * @param $id_ejercicio id del ejercicio a mostrar
     */
    function mostrar_ejercicio($id, $p, $id_ejercicio, $tipo_origen, $buscar) {

        global $CFG, $COURSE, $USER;
        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);

        //Los iconos están sacados del tema de gnome que viene con ubuntu 11.04
        //Inclusión del javascript para las funciones

        $mform = & $this->_form;
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./style.css">');
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./estilo.css">');
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./mc_style.css">');
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="./funciones.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="./js/jquery.form.js"></script>');
        $mform->addElement('html', '<script src="./js/ajaxupload.js" type="text/javascript"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="./MC_JavaScript.js"></script>');
        
        $id_interno = $id; // Solución ultra cutre ----> buscar nueva en cuanto se pueda
        
        if ($buscar == 0) { // Se está creando el ejercicio
            $this->creando_ejercicio($mform, $id, $p, $id_ejercicio, $tipo_origen);
        } else {
            // Se determina si el usuario es el creador
            $ejercicios_bd = new Ejercicios_general();
            $ejercicios_leido = $ejercicios_bd->obtener_uno($id_ejercicio);
            $creador = $ejercicios_leido->get('id_creador');
            
            if ($creador == $USER->id && has_capability('moodle/legacy:editingteacher', $context, $USER->id, false)) {
                $modificable = true; // En ese caso el ejercicio se puede modificar
            } else { // En caso contrario no se puede
                $modificable = false;
            }
            
            if ($modificable) {
                $this->mostrar_con_permisos($mform, $id, $p, $id_ejercicio, $tipo_origen, $ejercicios_leido);
            } else {
                $this->mostrar_sin_permisos($mform, $id, $p, $id_ejercicio, $tipo_origen, $ejercicios_leido);
            }
        }
    }
}
?>
