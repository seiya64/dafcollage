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
require_once('clase_log.php');

$id_curso = optional_param('id_curso', 0, PARAM_INT);
$tipocreacion = optional_param('tipocreacion', 0, PARAM_INT);

echo "tipocreacion" . $tipocreacion;

$mform = new mod_ejercicios_creando_ejercicio($id_curso);
$mform->pintarformulario($id_curso);



$tipo_pregunta = optional_param('radiopregunta', PARAM_TEXT);
$numeropreguntas = optional_param('numeropreguntas', 0, PARAM_INT);


$error = optional_param('error', PARAM_TEXT);

if ($error == '0') {


//Le sumo uno porque me coge los indices
    $numeropreguntas = $numeropreguntas + 1;

    switch($tipocreacion) {
        case 5:
        case 9:
            $tipo_respuesta = "Texto";
            $numerorespuestas=1;
            $numerorespuestascorrectas=1;
            break;
            
        default:
            $tipo_respuesta = optional_param('radiorespuesta', PARAM_TEXT);
            $numerorespuestas = optional_param('numerorespuestas', PARAM_INT);

            $numerorespuestas = $numerorespuestas + 1;

            $numerorespuestascorrectas = optional_param('numerorespuestascorrectas', PARAM_INT);

            $numerorespuestascorrectas = $numerorespuestascorrectas + 1;
            break;
    }
    if($tipocreacion==9) {
        $tipoorden = optional_param('radiotipoorden',PARAM_TEXT);
    }
    
    switch ($tipocreacion) {
        case 10:
            $IERC_sesion = array("numPreguntas"=>optional_param('IERC_aux', PARAM_INT));
            $log2 = new Log("titulo.txt");
            $log2->write($IERC_sesion['numPreguntas']);
            $IERC_sesion['elemento']= optional_param('elemento', PARAM_TEXT);
            for ($counter = 1; $counter <= $IERC_sesion['numPreguntas']; $counter++){
                $titulo = "titulo".$counter;
                $tituloPregunta = "tituloPregunta".$counter;
                $IERC_sesion[$titulo] = optional_param($tituloPregunta, PARAM_TEXT);
            }
    }
    
    global $CFG, $COURSE, $USER;
    
    
    //Si hemos elegido Texto - Texto
    echo "tipo_pregunta" . $tipo_pregunta;
    if ($tipo_pregunta == "Texto") {

        //Guardar el ejercicio en la BD
        //leo un ejercicio y lo guardo

        $id = NULL;
        $id_creador = $USER->id;
        $TipoActividad = $tipocreacion - 2; //Comienza en 2
        $TipoArchivoPregunta = 1; // 1 va a ser texto


        if ($tipo_respuesta == "Texto") {
            $TipoArchivoRespuesta = 1; //1 va a ser texto
        } else {
            if ($tipo_respuesta == "Audio") {

                $TipoArchivoRespuesta = 2; //2 va a ser Audio
                echo "tipo_respuesta audio";
            } else {
                if ($tipo_respuesta == "Video") {

                    $TipoArchivoRespuesta = 3; //3 va a ser Video
                } else {
                    if ($tipo_respuesta == "Foto") {
                        $TipoArchivoRespuesta = 4; //4 va a ser Foto
                        echo "Texto-Foto";
                    }
                }
            }
        }
    } else {
        $id = NULL;
        $id_creador = $USER->id;
        $TipoActividad = $tipocreacion - 2; //Comienza en 0. Porque el primer y segundo elemento no son nada.
        if ($tipo_pregunta == "Audio" && $tipo_respuesta == "Texto") {
            
            $TipoArchivoPregunta = 2; // 2 va a ser audio
            $TipoArchivoRespuesta = 1; //1 va a ser texto
        } else {
            if ($tipo_pregunta == "Video" && $tipo_respuesta == "Texto") {
                
                $TipoArchivoPregunta = 3; // 3 va a ser audio
                $TipoArchivoRespuesta = 1; //1 va a ser texto
            }
            if ($tipo_pregunta == "Foto" && $tipo_respuesta == "Texto") {
                
                $TipoArchivoPregunta = 4; // 4 va a ser una foto
                $TipoArchivoRespuesta = 1; //1 va a ser texto
            }
        }
    }


    if (optional_param('radiovisible', PARAM_TEXT) == "Si") {
        $visible = 1;
    } else {
        $visible = 0;
    }
    if (optional_param('radioprivado', PARAM_TEXT) == "Si") {
        $privado = 1;
    } else {
        $privado = 0;
    }

    $CampoTematico = optional_param('campoid', PARAM_INT);

    $Destreza = optional_param('DestrezaComunicativa', PARAM_INT);
    $Destreza = $Destreza - 2; //Hago esto porque la clasificación la voy a comenzar en 1 y los de antes son select y --
    if ($Destreza < 0) {
        $Destreza = null;
    }
    $TemaGramatical = required_param('campogr', PARAM_INT);
    $IntencionComunicativa = required_param('campoic', PARAM_INT);
    $TipologiaTextual = required_param('campott', PARAM_INT);
    $name = required_param('nombre_ejercicio', PARAM_TEXT);
    $descripcion = required_param('descripcion', PARAM_TEXT);
    $copyrightpreg = required_param('copyright', PARAM_INT);
    
    if ($tipocreacion!=5 && $tipocreacion!=9) {
        $copyrightresp = required_param('copyrightresp', PARAM_INT);
    }
    else {
        $copyrightresp=0;
    }

    //  $descripcion=htmlspecialchars( mysql_real_escape_string($descripcion));

    $ejercicio_general = new Ejercicios_general(NULL, $id_curso, $id_creador, $TipoActividad, $TipoArchivoPregunta, $TipoArchivoRespuesta, $visible, $privado, $carpeta, $CampoTematico, $Destreza, $TemaGramatical, $IntencionComunicativa, $TipologiaTextual, $name, $descripcion, $numeropreguntas, $copyrightpreg, $copyrightresp);

    /* $id_ejercicio=$ejercicio_general->insertar();   

      //Tengo que asignarle el ejercico al profesor
      $carpeta=required_param('carpeta_ejercicio', PARAM_TEXT);
      $ejercicio_profesor = new Ejercicios_prof_actividad($id,$id_creador,$id_ejercicio,$carpeta);

      $ejercicio_profesor->insertar(); */
    // $id_ejercicio=$ejercicio_general->insertar(); Sustituido por la linea de abajo
    $_SESSION['ejercicioGeneral'] = serialize($ejercicio_general);

    // Cosas del profe a session tambien (necesita id_ejercicio)
    $carpeta = required_param('carpeta_ejercicio', PARAM_TEXT);
    $_SESSION['cosasProfe'] = serialize($carpeta);
    
    //Meto en sesion el tipo de orden
    $_SESSION['tipoorden']=$tipoorden;
    
    $_SESSION['IERC']=$IERC_sesion;


    //La comprobacion de errores esta en el javascript
    //redirect('./view.php?id=' . $id_curso . '&opcion=7'. '&p='.$numeropreguntas. '&id_ejercicio=' .$id_ejercicio.'&tipo_origen='.$TipoArchivoPregunta."&tipocreacion=".$TipoActividad.'&tr='.$TipoArchivoRespuesta);
    //La comprobacion de errores esta en el javascript
    redirect('./view.php?id=' . $id_curso . '&opcion=7' . '&p=' . $numeropreguntas . '&tipo_origen=' . $TipoArchivoPregunta . "&tipocreacion=" . $TipoActividad . '&tr=' . $TipoArchivoRespuesta);
} else {

    redirect("view.php?id=" . $id_curso . "&opcion=5&tipocreacion=" . $tipocreacion);
}
?>
