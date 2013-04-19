<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

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
require_once("YoutubeVideoHelper.php");

$id_curso = optional_param('id_curso', 0, PARAM_INT);
$id_ejercicio = optional_param('id_ejercicio', 0, PARAM_INT);
$tipo_origen = optional_param('tipo_origen', 0, PARAM_INT);
$tipo_respuesta = optional_param('tr', 0, PARAM_INT);
$tipo_creacion = optional_param('tipocreacion', 0, PARAM_INT);

ECHO "MODIFICANDO";

$mform = new mod_ejercicios_mostrar_ejercicio_asociacion_multiple($id_curso, $id_ejercicio, $tipo_origen, $tipo_respuesta, $tipo_creacion);
$mform->mostrar_ejercicio_asociacion_multiple($id_curso, $id_ejercicio, 0, $tipo_origen, $tipo_respuesta, $tipo_creacion);

$numeropreguntas = optional_param('num_preg', 0, PARAM_INT);

echo "El numero de pregunas es" . $numeropreguntas;


begin_sql();

if ($tipo_origen == 1) { //la pregunta es un texto
    if ($tipo_respuesta == 1) {//Es un texto
        //obtengo los id de las preguntas del ejercicio
        //$id_preguntas = array();

        $mis_preguntas = new Ejercicios_texto_texto_preg();

        $id_preguntas = $mis_preguntas->obtener_todas_preguntas_ejercicicio($id_ejercicio);
        //borro las respuestas

        for ($s = 0; $s < sizeof($id_preguntas); $s++) {
            delete_records('ejercicios_texto_texto_resp', 'id_pregunta', $id_preguntas[$s]->get('id'));
        }
    } else {

        if ($tipo_respuesta == 2) { //la respuesta es un audio
            echo "actualizando audio";
            //obtengo los id de las preguntas del ejercicio
            //$id_preguntas = array();

            $mis_preguntas = new Ejercicios_texto_texto_preg();

            $id_preguntas = $mis_preguntas->obtener_todas_preguntas_ejercicicio($id_ejercicio);
            //borro las respuestas            
            for ($s = 0; $s < sizeof($id_preguntas); $s++) {
                //borrar los archivos de audio
                /*$dir = './mediaplayer/audios/';
                $resps = new Ejercicios_audios_asociados();
                $mis_respuestas = $resps->obtener_todas_respuestas_pregunta($id_preguntas[$s]);
                for ($k=0; $k<sizeof($mis_respuestas); $k++) {
                    unlink($dir.$mis_respuestas[$k]->get('nombre_audio'));
                }*/
                delete_records('ejercicios_audios_asociados', 'id_ejercicio', $id_ejercicio);
            }
        } else {

            if ($tipo_respuesta == 3) {//video
                echo "actualizando video";
                //obtengo los id de las preguntas del ejercicio
                $id_preguntas = array();

                $mis_preguntas = new Ejercicios_texto_texto_preg();

                $id_preguntas = $mis_preguntas->obtener_todas_preguntas_ejercicicio($id_ejercicio);
                //borro las respuestas

                for ($s = 0; $s < sizeof($id_preguntas); $s++) {
                    delete_records('ejercicios_videos_asociados', 'id_ejercicio', $id_ejercicio);
                }
            } else {

                if ($tipo_respuesta == 4) {
                    echo "actualizando imagen";
                    //obtengo los id de las preguntas del ejercicio
                    //$id_preguntas = array();

                    $mis_preguntas = new Ejercicios_texto_texto_preg();

                    $id_preguntas = $mis_preguntas->obtener_todas_preguntas_ejercicicio($id_ejercicio);
                    //borro las respuestas

                    for ($s = 0; $s < sizeof($id_preguntas); $s++) {
                        delete_records('ejercicios_imagenes_asociadas', 'id_ejercicio', $id_ejercicio);
                    }
                }
            }
        }
    }

    //borro las preguntas
    delete_records('ejercicios_texto_texto_preg', 'id_ejercicio', $id_ejercicio);
} else {
    if ($tipo_origen == 2) { //Pregunta es un Audio
        //borro las preguntas
        //$id_preguntas = array();

        $mis_preguntas = new Ejercicios_texto_texto_preg();

        $id_preguntas = $mis_preguntas->obtener_todas_preguntas_ejercicicio($id_ejercicio);
        //borro las respuestas

        for ($s = 0; $s < sizeof($id_preguntas); $s++) {
            delete_records('ejercicios_audios_asociados', 'id_ejercicio', $id_ejercicio);
        }

        if ($tipo_respuesta == 1) { //Borrar las preguntas
            //borro las respuestas
            delete_records('ejercicios_texto_texto_preg', 'id_ejercicio', $id_ejercicio);
        }
        
        //Borrar las respuestas del texto
        foreach ($id_preguntas as $pregunta) {
            delete_records('ejercicios_texto_texto_resp','id_pregunta',$pregunta->get('id'));
        }
        
    } else {

        if ($tipo_origen == 3) {//video
            echo "actualizando video";
            //obtengo los id de las preguntas del ejercicio
            //$id_preguntas = array();

            $mis_preguntas = new Ejercicios_texto_texto_preg();

            $id_preguntas = $mis_preguntas->obtener_todas_preguntas_ejercicicio($id_ejercicio);
            //borro las respuestas

            for ($s = 0; $s < sizeof($id_preguntas); $s++) {
                delete_records('ejercicios_videos_asociados', 'id_ejercicio', $id_ejercicio);
            }
            
              if ($tipo_respuesta == 1) { //La respuesta es un texto
                    //borro las preguntas
                    delete_records('ejercicios_texto_texto_preg', 'id_ejercicio', $id_ejercicio);
              }
              
           //Borrar las respuestas del texto
            foreach ($id_preguntas as $pregunta) {
                delete_records('ejercicios_texto_texto_resp','id_pregunta',$pregunta->get('id'));
            }
        }
        else if ($tipo_origen==4) //La pregunta es una imagen
        {
               if ($tipo_respuesta == 1) {  //La respuesta es un texto
                    echo "actualizando imagen";
                    
                    //obtengo los id de las preguntas del ejercicio
                    //$id_preguntas = array();

                    $mis_preguntas = new Ejercicios_texto_texto_preg();

                    $id_preguntas = $mis_preguntas->obtener_todas_preguntas_ejercicicio($id_ejercicio);
                    //borro las respuestas

                    for ($s = 0; $s < sizeof($id_preguntas); $s++) {
                        delete_records('ejercicios_imagenes_asociadas', 'id_ejercicio', $id_ejercicio);
                    }
                    delete_records('ejercicios_texto_texto_preg', 'id_ejercicio', $id_ejercicio);
                    
                    //Borrar las respuestas del texto
                    foreach ($id_preguntas as $pregunta) {
                        delete_records('ejercicios_texto_texto_resp','id_pregunta',$pregunta->get('id'));
                    }
                    echo 'Borradas imagenes';
                }
        }

      
    }
}

//Guardo las nuevas

for ($i = 0; $i < $numeropreguntas; $i++) {
    //Obtengo el numero de respuestas a cada pregunta
    $j = $i + 1;


    if ($tipo_origen == 1) { //Si la pregunta es un texto
        $preg = required_param('pregunta' . $j, PARAM_TEXT);
        $ejercicio_texto_preg = new Ejercicios_texto_texto_preg(NULL, $id_ejercicio, $preg);
        $id_pregunta = $ejercicio_texto_preg->insertar();


        if ($tipo_respuesta == 1) { //Si la respuesta es un texto
            $num_resp = required_param('num_res_preg'.$j,PARAM_INT);
            
            for ($k=1; $k<=$num_resp; $k++) {
                $resp = required_param('respuesta'.$k.'_'.$j, PARAM_TEXT);

                $correcta = 0;

                $ejercicio_texto_resp = new Ejercicios_texto_texto_resp(NULL, $id_pregunta, $resp, $correcta);
                $ejercicio_texto_resp->insertar();
            }
        } else {

            if ($tipo_respuesta == 2) { //es un audio
                $num_resp = required_param('num_res_preg'.$j,PARAM_INT);
                for ($k=1; $k<=$num_resp; $k++) {
                    $ejercicio_texto_audio = new Ejercicios_audios_asociados($NULL, $id_ejercicio, $id_pregunta, 'audio_' . $id_ejercicio . "_" . $j. "_" . $k . ".mp3");
                    $ejercicio_texto_audio->insertar();
                }
            } else {

                if ($tipo_respuesta == 3) { //ES UN VIDEO
                    $num_resp = required_param('num_res_preg'.$j,PARAM_INT);
                    for ($k=1; $k<=$num_resp; $k++) {
                        $resp = YoutubeVideoHelper::getVideoId(required_param('respuesta'.$k.'_'.$j, PARAM_TEXT));

                        echo "archivo video" . $resp;

                        $ejercicio_texto_video = new Ejercicios_videos_asociados(NULL, $id_ejercicio, $id_pregunta, $resp);
                        $ejercicio_texto_video->insertar();
                    }
                } else {

                    if ($tipo_respuesta == 4) { //eS UNA IMAGEN
                        $num_resp = required_param('num_res_preg'.$j,PARAM_INT);
                        for ($k=1; $k<=$num_resp; $k++) {
                            $ejercicio_texto_img = new Ejercicios_imagenes_asociadas($NULL, $id_ejercicio, $id_pregunta, 'foto_' . $id_ejercicio . "_" . $j . "_" . $k . ".jpg");
                            $ejercicio_texto_img->insertar();
                        }
                    }
                }
            }
        }
    } else {
        if ($tipo_origen == 2) { //la pregunta es un audio
            //     echo "entra";
            //$preg = required_param('pregunta' . $j, PARAM_TEXT);
            $preg = "audio_" . $id_ejercicio . "_" . $j . ".mp3";
            $ejercicio_texto_preg = new Ejercicios_texto_texto_preg(NULL, $id_ejercicio, $preg);
            $id_pregunta = $ejercicio_texto_preg->insertar();
            $ejercicio_texto_audio = new Ejercicios_audios_asociados(NULL, $id_ejercicio, $id_pregunta, $preg);
            $ejercicio_texto_audio->insertar();

            if ($tipo_respuesta == 1) { //la respuesta es un texto
                //            echo "entra 2";
                $num_resp = required_param('num_res_preg'.$j,PARAM_INT);
                for ($k=1; $k<=$num_resp; $k++) {
                    $resp_textarea = required_param("respuesta".$k."_".$j,PARAM_TEXT);
                    $resp_txt = new Ejercicios_texto_texto_resp(NULL, $id_pregunta, $resp_textarea, 0);
                    $resp_txt->insertar();
                }
            }
        } else {

            if ($tipo_origen == 3) { //ES UN VIDEO
                if (YoutubeVideoHelper::getVideoId(required_param('archivovideo' . $j, PARAM_TEXT)) != null){
                    //$preg = required_param('pregunta' . $j, PARAM_TEXT);
                    $preg = YoutubeVideoHelper::getVideoId(required_param('archivovideo' . $j, PARAM_TEXT));
                    $ejercicio_texto_preg = new Ejercicios_texto_texto_preg(NULL, $id_ejercicio, $preg);
                    $id_pregunta = $ejercicio_texto_preg->insertar();
                    $ejercicio_texto_video = new Ejercicios_videos_asociados(NULL, $id_ejercicio, $id_pregunta, $preg);
                    $ejercicio_texto_video->insertar();

                    //$resp = YoutubeVideoHelper::getVideoId(required_param('archivovideo' . $j, PARAM_TEXT));
                    //echo "archivo video" . $resp;
                    
                    if ($tipo_respuesta == 1) { //La respuesta es un texto
                        $num_resp = required_param('num_res_preg'.$j,PARAM_INT);
                        for ($k=1; $k<=$num_resp; $k++) {
                            $resp_textarea = required_param("respuesta".$k."_".$j,PARAM_TEXT);
                            $resp_txt = new Ejercicios_texto_texto_resp(NULL, $id_pregunta, $resp_textarea, 0);
                            $resp_txt->insertar();
                        }
                    }

                    
                    echo "insertado";
                }
            }
            
            else if ($tipo_origen == 4) { // ES UNA IMAGEN
                
                    if ($tipo_respuesta == 1) { //La respuesta es un texto
                        
                         //$preg = required_param('pregunta' . $j, PARAM_TEXT);
                        $preg = "foto_" . $id_ejercicio . "_" . $j . ".jpg";
                        $ejercicio_texto_preg = new Ejercicios_texto_texto_preg(NULL, $id_ejercicio, $preg);
                        $id_pregunta = $ejercicio_texto_preg->insertar();                    
                        $ejercicio_texto_img = new Ejercicios_imagenes_asociadas($NULL, $id_ejercicio, $id_pregunta, $preg);
                        $ejercicio_texto_img->insertar();
                        
                        $num_resp = required_param('num_res_preg'.$j,PARAM_INT);
                        for ($k=1; $k<=$num_resp; $k++) {
                            $resp_textarea = required_param("respuesta".$k."_".$j,PARAM_TEXT);
                            $resp_txt = new Ejercicios_texto_texto_resp(NULL, $id_pregunta, $resp_textarea, 0);
                            $resp_txt->insertar();
                        }
                    }
            }
        }
    }
}
commit_sql();

redirect('./view.php?id=' . $id_curso . '&opcion=9');
?>
