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

// Crea ejercicio ahora
$ejercicioGeneral = unserialize($_SESSION['ejercicioGeneral']); 
$carpeta = unserialize($_SESSION['cosasProfe']);
$id_ejercicio = $ejercicioGeneral->insertar();

// Y para el profesor tambien
//Tengo que asignarle el ejercicio al profesor 
$ejercicio_profesor = new Ejercicios_prof_actividad($ejercicioGeneral->get('id'),$ejercicioGeneral->get('id_creador'),$id_ejercicio,$carpeta);
$ejercicio_profesor->insertar();

$id_curso = optional_param('id_curso', 0, PARAM_INT);
$p = optional_param('p', 0, PARAM_INT);
$tipocreacion = optional_param('tipocreacion', 0, PARAM_INT);
//$id_ejercicio = optional_param('id_ejercicio', 0, PARAM_INT);
$tipo_origen = optional_param('tipo_origen', 0, PARAM_INT);
$tipo_respuesta = optional_param('tr', 0, PARAM_INT);


$mform = new mod_ejercicios_creando_ejercicio_asociacion_simple($id_curso, $p, $id_ejercicio, $tipo_origen, $tipo_respuesta, $tipocreacion);
$mform->pintarformularioasociacionsimple($id_curso, $p, $id_ejercicio, $tipo_origen, $tipo_respuesta, $tipocreacion);



//De donde vengo
//A donde voy
//A partir de aquí es de Tipocreación 1: Es decir "Asociación Simple";
//
//Obtengo el archivo origen


switch ($tipo_origen) {
    case 1://Es un texto
        echo "Texto -";
        switch ($tipo_respuesta) {
            case 1: //Respuesta texto
                //echo "inserto en la bd";
                //Obtengo el numero de preguntas
                $numero_preguntas = optional_param('numeropreguntas', PARAM_INT);

                for ($i = 0; $i < $numero_preguntas; $i++) {
                    //Obtengo la pregunta

                    $j = $i + 1;
                    $pregunta = optional_param('pregunta' . $j, PARAM_TEXT);

                    //Inserto la pregunta Archivo asociación
                    $mispreguntas = new Ejercicios_texto_texto_preg(NULL, $id_ejercicio, $pregunta);
                    $id_preg = $mispreguntas->insertar();


                    //Obtengo la respuesta Archivo asociado

                    $respuesta = optional_param('respuesta' . $j, PARAM_TEXT);
                    $rcorrecta = 0; //Me da igual si es correcat o incorrecta
                    //Lo inserto en la tabla
                    $mi_respuesta = new Ejercicios_texto_texto_resp(NULL, $id_preg, $respuesta, $rcorrecta);

                    $mi_respuesta->insertar();


                    echo "fin insercción";
                }
                break;
            case 2://Respuesta es Audio
                echo "es un audio";

                //Guardando las imagenes y los textos
                //SUBO LOS AUDIOS A MOODLE
                $m = 1;
                foreach ($_FILES as $name => $values) {

                    //tengo que cambiar la ruta donde se guarda
                    if (move_uploaded_file($values['tmp_name'], './mediaplayer/audios/audio_' . $id_ejercicio . '_' . $m . '.mp3')) {

                        //  echo 'El archivo ha sido subido correctamente.<br/>';
                        $m++;
                    }
                }
                // echo "m vale".$m;
                //Obtengo el numero de preguntas
                $numero_preguntas = optional_param('numeropreguntas', PARAM_INT);
                echo "numero preguntas" . $numero_preguntas;
                for ($i = 0; $i < $numero_preguntas; $i++) {
                    //Obtengo la pregunta

                    $j = $i + 1;
                    $pregunta = optional_param('pregunta' . $j, PARAM_TEXT);

                    //Inserto la pregunta Archivo asociación
                    $mispreguntas = new Ejercicios_texto_texto_preg(NULL, $id_ejercicio, $pregunta);
                    $id_preg = $mispreguntas->insertar();

                    //Lo inserto en la tabla de imagenes para asociar respuestas y preguntas
                    $nombre_audio = 'audio_' . $id_ejercicio . '_' . $j . '.mp3';
                    $mi_respuesta = new Ejercicios_audios_asociados(NULL, $id_ejercicio, $id_preg, $nombre_audio);

                    $mi_respuesta->insertar();
                }
                echo "fin insercción";
                break;
            case 3://Respuesta es Video
                echo "es un videooooooooo";
                //Guardando las direcciones de los videos y el texto correspondiente
                //Obtengo el numero de preguntas
                $numero_preguntas = optional_param('numeropreguntas', PARAM_INT);
                echo "numero preguntas" . $numero_preguntas;
                for ($i = 0; $i < $numero_preguntas; $i++) {
                    //Obtengo la pregunta

                    $j = $i + 1;
                    $pregunta = optional_param('pregunta' . $j, PARAM_TEXT);

                    //Inserto la pregunta Archivo asociación
                    $mispreguntas = new Ejercicios_texto_texto_preg(NULL, $id_ejercicio, $pregunta);
                    $id_preg = $mispreguntas->insertar();


                    $rcorrecta = 0; //Me da igual si es correcat o incorrecta

                    $auxUrlVideo = optional_param('archivovideo', NULL, PARAM_TEXT);
                    $yvh = new YoutubeVideoHelper();
                    $id_video = $yvh->getVideoId($auxUrlVideo);

                    //Lo inserto en la tabla de videos para asociar respuestas y preguntas

                    $mi_respuesta = new Ejercicios_videos(NULL, $id_ejercicio, $id_preg, $id_video);
                    $mi_respuesta->insertar();
                }
                echo "fin insercción";
                break;
            case 4:// Respuesta es Foto
                //Guardando la foto y el texto
                echo "Foto";

                //SUBO LAS IMAGENES A MOODLE
                $m = 1;
                foreach ($_FILES as $name => $values) {

                    //tengo que cambiar la ruta donde se guarda
                    if (move_uploaded_file($values['tmp_name'], './imagenes/actividades/img_' . $id_ejercicio . '_' . $m . '.jpg')) {

                        //  echo 'El archivo ha sido subido correctamente.<br/>';
                        $m++;
                    }
                }
                // echo "m vale".$m;
                //Obtengo el numero de preguntas
                $numero_preguntas = optional_param('numeropreguntas', PARAM_INT);
                echo "numero preguntas" . $numero_preguntas;
                for ($i = 0; $i < $numero_preguntas; $i++) {
                    //Obtengo la pregunta

                    $j = $i + 1;
                    $pregunta = optional_param('pregunta' . $j, PARAM_TEXT);

                    //Inserto la pregunta Archivo asociación
                    $mispreguntas = new Ejercicios_texto_texto_preg(NULL, $id_ejercicio, $pregunta);
                    $id_preg = $mispreguntas->insertar();

                    //Lo inserto en la tabla de imagenes para asociar respuestas y preguntas
                    $nombre_img = 'img_' . $id_ejercicio . '_' . $j . '.jpg';
                    $mi_respuesta = new Ejercicios_Imagenes_Asociadas(NULL, $id_ejercicio, $id_preg, $nombre_img);

                    $mi_respuesta->insertar();
                }
                echo "fin insercción";

                break;
        }
        break;

    case 2://Es una audio la pregunta


        echo "la pregunta es un audio";
        //Guardando las imagenes y los textos
        //SUBO LOS AUDIOS A MOODLE
        $m = 1;
        foreach ($_FILES as $name => $values) {

            //tengo que cambiar la ruta donde se guarda
            if (move_uploaded_file($values['tmp_name'], './mediaplayer/audios/audio_' . $id_ejercicio . '_' . $m . '.mp3')) {

                //  echo 'El archivo ha sido subido correctamente.<br/>';
                $m++;
            }
        }
        // echo "m vale".$m;
        //Obtengo el numero de preguntas
        $numero_preguntas = optional_param('numeropreguntas', PARAM_INT);
        echo "numero preguntas" . $numero_preguntas;
        for ($i = 0; $i < $numero_preguntas; $i++) {
            //Obtengo la pregunta

            $j = $i + 1;
            $pregunta = optional_param('pregunta' . $j, PARAM_TEXT);

            //Inserto la pregunta Archivo asociación
            $mispreguntas = new Ejercicios_texto_texto_preg(NULL, $id_ejercicio, $pregunta);
            $id_preg = $mispreguntas->insertar();

            //Lo inserto en la tabla de imagenes para asociar respuestas y preguntas
            $nombre_audio = 'audio_' . $id_ejercicio . '_' . $j . '.mp3';
            $mi_respuesta = new Ejercicios_audios_asociados(NULL, $id_ejercicio, $id_preg, $nombre_audio);

            $mi_respuesta->insertar();
        }
        echo "fin insercción";

        echo "es una audio";
        break;
    case 3://Es un video
        echo "es un video la pregunta";

        //Guardando las direcciones de los videos y el texto correspondiente
        //Obtengo el numero de preguntas
        $numero_preguntas = optional_param('numeropreguntas', PARAM_INT);
        echo "numero preguntas" . $numero_preguntas;
        for ($i = 0; $i < $numero_preguntas; $i++) {
            //Obtengo la pregunta

            $j = $i + 1;
            $pregunta = optional_param('pregunta' . $j, PARAM_TEXT);

            //Inserto la pregunta Archivo asociación
            $mispreguntas = new Ejercicios_texto_texto_preg(NULL, $id_ejercicio, $pregunta);
            $id_preg = $mispreguntas->insertar();

            $auxUrlVideo = optional_param('archivovideo' . $j, PARAM_TEXT);
            $yvh=new  YoutubeVideoHelper();
            $idVideo=$yvh->getVideoId($auxUrlVideo);
            print_r($idVideo);

            // $dirvideoasociado = optional_param('archivovideo'.$j,PARAM_TEXT);

            $rcorrecta = 0; //Me da igual si es correcat o incorrecta
            //Lo inserto en la tabla de videos para asociar respuestas y preguntas
            print_r('cosa');
            print_r($idVideo);
            $mi_respuesta = new Ejercicios_videos_asociados(NULL, $id_ejercicio, $id_preg, $idVideo);
            $mi_respuesta->insertar();
        }
        echo "fin insercción";

        break;
    case 4://Es una imagen
        echo "es una imagen";
        break;
}



//Muestro el ejercicio


redirect('./view.php?id=' . $id_curso . '&opcion=8' . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . "&tr=" . $tipo_respuesta . "&tipocreacion=" . $tipocreacion);
?>