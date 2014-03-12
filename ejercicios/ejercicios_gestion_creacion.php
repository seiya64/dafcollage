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
require_once("lib.php");
require_once("ejercicios_clase_general.php");
require_once("ejercicios_form_creacion.php");
require_once('clase_log.php');

$id_curso = optional_param('id_curso', 0, PARAM_INT);
$tipocreacion = optional_param('tipocreacion', 0, PARAM_INT);

$mform = new mod_ejercicios_creando_ejercicio($id_curso);
$mform->pintarformulario($id_curso);

$tipo_pregunta = optional_param('radiopregunta', PARAM_TEXT);
$numeropreguntas = optional_param('numeropreguntas', 0, PARAM_INT);

$log = new Log('log_gestion_creacion.txt');

$error = optional_param('error', PARAM_TEXT);
$log->write('error: ' . $error);

if ($error == '0') { // Solamente si no ha habido errores

    // Se suma uno por los índices
    $numeropreguntas = $numeropreguntas + 1;

    switch($tipocreacion) {
        case 9: //Ordenar Elementos
        case 5: //Texto Hueco. Solo tipo Texto
        case 2: //Multiplechoice solo tipo texto
        case 6: //Identificar elementos
        case 10: //Identificar Elementos mas Respuesta Corta
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
            $IERC_sesion['elemento']= optional_param('elemento', PARAM_TEXT);
            for ($counter = 1; $counter <= $IERC_sesion['numPreguntas']; $counter++){
                $titulo = "titulo".$counter;
                $tituloPregunta = "tituloPregunta".$counter;
                $IERC_sesion[$titulo] = optional_param($tituloPregunta, PARAM_TEXT);
            }
    }
    
    global $CFG, $COURSE, $USER;
    
    
    //Si hemos elegido Texto - Texto
    //echo "tipo_pregunta" . $tipo_pregunta;
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
                //echo "tipo_respuesta audio";
            } else {
                if ($tipo_respuesta == "Video") {

                    $TipoArchivoRespuesta = 3; //3 va a ser Video
                } else {
                    if ($tipo_respuesta == "Foto") {
                        $TipoArchivoRespuesta = 4; //4 va a ser Foto
                        //echo "Texto-Foto";
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

    /* Pasado al segundo paso de creación, revisión de código más adelante -- Javier Castro Fernández
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
    */
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
    $fuentes = "";
    
    /*if ($tipocreacion!=5 && $tipocreacion!=9) {
        $copyrightresp = required_param('copyrightresp', PARAM_INT);
    }
    else {
        $copyrightresp=0;
    }*/
    $copyrightresp=0;
    $foto_asociada = -1;

    //  $descripcion=htmlspecialchars( mysql_real_escape_string($descripcion));

    $carpeta = required_param('carpeta_ejercicio', PARAM_TEXT);
    $_SESSION['cosasProfe'] = serialize($carpeta);
    
    $ejercicio_general = new Ejercicios_general(NULL, $id_curso, $id_creador, $TipoActividad, $TipoArchivoPregunta, $TipoArchivoRespuesta, 0, 0, $carpeta, $CampoTematico, $Destreza, $TemaGramatical, $IntencionComunicativa, $TipologiaTextual, $name, $descripcion, $numeropreguntas, $copyrightpreg, $copyrightresp, $fuentes, $foto_asociada);
    
    $_SESSION['ejercicioGeneral'] = serialize($ejercicio_general);

    // Cosas del profe a session tambien (necesita id_ejercicio)
    
    //Meto en sesion el tipo de orden
    $_SESSION['tipoorden']=$tipoorden;
    
    $_SESSION['IERC']=$IERC_sesion;
	
	//SE CREAN LAS CARPETAS EN MOODLEDATA Y EN MOODLEDATA/TEMP DE LOS PROFESORES PARA GUARDAR LAS IMAGENES DE LOS EJERCICIOS
	$ruta=$CFG->dataroot.'/temp/'.$USER->id.'/';
	mkdir($ruta);
	
	$ruta=$CFG->dataroot.'/'.$USER->id.'/';
	mkdir($ruta);
	
//    foreach ($_FILES as $name => $values) { // Ruta de la imagen asociada
//        $_SESSION['fotoAsociada']=$values['tmp_name'];
//        if (move_uploaded_file($values['tmp_name'], $CFG->dataroot.$values['tmp_name'])) {
//            //echo 'El archivo ha sido subido correctamente.<br/>'; 
//        }
//    }
        
    $log->write($_SESSION);
    
    //La comprobacion de errores esta en Javascript
    redirect('./view.php?id=' . $id_curso . '&opcion=7' . '&p=' . $numeropreguntas . '&tipo_origen=' . $TipoArchivoPregunta . "&tipocreacion=" . $TipoActividad . '&tr=' . $TipoArchivoRespuesta . '&id_ejercicio='.$ejercicio_general->get('id') . '&buscar='. 0);
} else {

    redirect("view.php?id=" . $id_curso . "&opcion=5&tipocreacion=" . $tipocreacion);
}
?>
