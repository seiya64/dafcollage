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

require_once("../../config.php");
require_once("lib.php");
require_once("ejercicios_clase_general.php");
require_once("ejercicios_form_creacion.php");

$id_curso = optional_param('id_curso', 0, PARAM_INT);
$id_ejercicio = optional_param('id_ejercicio', 0, PARAM_INT);

//Es llamado por ejercicios_form_misejercicios.php
//desde los enlaces

$mform = new  mod_ejercicios_mis_ejercicios($id_curso);
$mform->pintaropciones($id_curso);



//Elimino el ejercicio de profesor_actividad
//puesto que ya no lo estoy usando


if ($mform->is_submitted()) {  //Boton Menu Principal
     redirect('./view.php?id=' . $id_curso );
  
}else{
$ejercicio_profesor_actividad = new Ejercicios_prof_actividad();

  $id_profesor=$USER->id;
 
  $los_ejercicios=$ejercicio_profesor_actividad->obtener_ejercicos_del_profesor($id_profesor);
  
  for($i=0;$i<sizeof($los_ejercicios);$i++){
     
      $id_bd_ej=$los_ejercicios[$i]->get('id_ejercicio');


      //Si estoy usando el ejercicio lo elimino
      
      if($id_bd_ej == $id_ejercicio){
        
          $ejercicio_profesor_actividad->borrar_id_ejercicio($id_ejercicio, $id_profesor);
      }
      
      //Compruebo si hay alguien más usuando el ejercicio
      
       $todos_ejercicios=$ejercicio_profesor_actividad->obtener_todos_idejercicio($id_ejercicio);
       
       if(sizeof($todos_ejercicios)==0){
            echo "no hay gente usandolo";
           //Lo elimino de la tabla de ejercicios correspondiente y de la tabla de ejercicios general
           
            $ejercicio_general=new Ejercicios_general();
            $ejercicio=$ejercicio_general->obtener_uno($id_ejercicio);
            //lo borro
            $ejercicio_general->borrar($ejercicio->get('id'));
            
            switch ($ejercicio->get('tipoactividad')) {
                case 0: //Multiple choice
                    switch ($ejercicio->get('tipoarchivopregunta')) {
                        case 1: //Hay un texto
                            $ej_textos = new Ejercicios_textos();
                            $ej_textos->borrar_id_ejercicio($id_ejercicio);
                            break;
                        case 2: //Hay un audio
                            //Lo borramos directamente de la carpeta de audios
                            if (!unlink('./mediaplayer/audios/audio' . $id_ejercicio . '.mp3')) {
                                echo 'ERROR EN LA ELIMINACION DEL FICHERO DE AUDIO';
                                echo 'RUTA: ' . './mediaplayer/audios/audio' . $id_ejercicio . '.mp3';
                            }

                            break;
                        case 3: //Hay un video
                            $ej_video = new Ejercicios_videos();
                            $ej_video->borrar_id_ejercicio($id_ejercicio);
                            break;
                    }




                    //borro las respuestas
                    $ejercicio_texto_texto_preg = new Ejercicios_texto_texto_preg();
                    $num_preguntas = $ejercicio_texto_texto_preg->obtener_todas_preguntas_ejercicicio($id_ejercicio);
                    echo "el numero de preguntas" . sizeof($num_preguntas);
                    for ($j = 0; $j < sizeof($num_preguntas); $j++) {
                        $ejercicio_texto_texto_resp = new Ejercicios_texto_texto_resp();
                        $id_pregunta = $num_preguntas[$j]->get('id');
                        $ejercicio_texto_texto_resp->borrar_id_pregunta($id_pregunta);
                    }
                    //echo "borrando de texto texto preg"

                    $ejercicio_texto_texto_preg->borrar_id_ejercicio($id_ejercicio);

                    break;
                case 1: //Asociacion simple
                    switch ($ejercicio->get('tipoarchivopregunta')) {
                        case 1: //Hay un texto
                            $ej_textos = new Ejercicios_texto_texto_preg();
                            $ej_textos->borrar_id_ejercicio($id_ejercicio);
                            
                            switch($ejercicio->get('tipoarchivorespuesta')){
                                //No ponemos 1 porque lo vamos a poner de manera general fuera de este switch
                                case 2: //Es un audio
                                    $ej_audio = new Ejercicios_audios_asociados();
                                    $audios_filename = $ej_audio->obtener_todos_id_ejercicio($id_ejercicio);
                                    for ($i = 0; $i < sizeof($audios_filename); $i++) {
                                        unlink('./mediaplayer/audios/' . $audios_filename[$i]);
                                    }
                                    $ej_audio->borrar_id_ejercicio($id_ejercicio);
                                    break;
                                case 3: //Hay un video
                                    $ej_video = new Ejercicios_videos_asociados();
                                    $ej_video->borrar_id_ejercicio($id_ejercicio);
                                    break;
                                case 4:
                                    $ej_img = new Ejercicios_imagenes_asociadas();
                                    $img_filenames = $ej_img->obtener_todos_id_ejercicio($id_ejercicio);
                                    for ($i = 0; $i < sizeof($img_filenames); $i++) {
                                        unlink('./imagenes/' . $img_filenames[$i]);
                                    }
                                    $ej_img->borrar_id_ejercicio($id_ejercicio);
                                    break;
                            }
                            break;
                        case 2: //Hay un audio           
                            $ej_audio = new Ejercicios_audios_asociados();
                            $audios_filename = $ej_audio->obtener_todos_id_ejercicio($id_ejercicio);
                            for($i=0; $i<sizeof($audios_filename); $i++) {
                                unlink('./mediaplayer/audios/'. $audios_filename[$i]);
                            }
                            $ej_audio->borrar_id_ejercicio($id_ejercicio);
                            break;
                        case 3: //Hay un video
                            $ej_video = new Ejercicios_videos_asociados();
                            $ej_video->borrar_id_ejercicio($id_ejercicio);
                            break;
                        case 4:
                            $ej_img = new Ejercicios_imagenes_asociadas();
                            $img_filenames = $ej_img->obtener_todos_id_ejercicio($id_ejercicio);
                            for($i=0; $i<sizeof($img_filenames); $i++) {
                                unlink('./imagenes/' . $img_filenames[$i]);
                            }
                            $ej_img->borrar_id_ejercicio($id_ejercicio);
                            break;
                    }
                    
                    //borro las respuestas
                    $ejercicio_texto_texto_preg = new Ejercicios_texto_texto_preg();
                    $num_preguntas = $ejercicio_texto_texto_preg->obtener_todas_preguntas_ejercicicio($id_ejercicio);
                    echo "el numero de preguntas" . sizeof($num_preguntas);
                    for ($j = 0; $j < sizeof($num_preguntas); $j++) {
                        $ejercicio_texto_texto_resp = new Ejercicios_texto_texto_resp();
                        $id_pregunta = $num_preguntas[$j]->get('id');
                        $ejercicio_texto_texto_resp->borrar_id_pregunta($id_pregunta);
                    }
                    
                    //echo "borrando de texto texto preg"
                    $ejercicio_texto_texto_preg->borrar_id_ejercicio($id_ejercicio);
                    break;
                case 4: //Identificar elementos
                    switch ($ejercicio->get('tipoarchivopregunta')) {
                        case 1: //Hay un texto
                            $ej_textos = new Ejercicios_textos();
                            $ej_textos->borrar_id_ejercicio($id_ejercicio);
                            break;
                        case 2: //Hay un audio
                            //Lo borramos directamente de la carpeta de audios
                            if (!unlink('./mediaplayer/audios/audio' . $id_ejercicio . '.mp3')) {
                                echo 'ERROR EN LA ELIMINACION DEL FICHERO DE AUDIO';
                                echo 'RUTA: ' . './mediaplayer/audios/audio' . $id_ejercicio . '.mp3';
                            }

                            break;
                        case 3: //Hay un video
                            $ej_video = new Ejercicios_videos();
                            $ej_video->borrar_id_ejercicio($id_ejercicio);
                            break;
                    }




                    //borro las respuestas
                    $ejercicio_texto_texto_preg = new Ejercicios_texto_texto_preg();
                    $num_preguntas = $ejercicio_texto_texto_preg->obtener_todas_preguntas_ejercicicio($id_ejercicio);
                    echo "el numero de preguntas" . sizeof($num_preguntas);
                    for ($j = 0; $j < sizeof($num_preguntas); $j++) {
                        $ejercicio_ie_respuestas = new ejercicios_ie_respuestas();
                        $id_pregunta = $num_preguntas[$j]->get('id');
                        $ejercicio_ie_respuestas->borrar_id_pregunta($id_pregunta);
                    }
                    //echo "borrando de texto texto preg"

                    $ejercicio_texto_texto_preg->borrar_id_ejercicio($id_ejercicio);
                    break;
            }
         
           
         
       }
  }


   //Muestro mis ejercicios

     redirect('./view.php?id=' . $id_curso . '&opcion=9'. '&id='.$id_curso);
        
}
    

?>
