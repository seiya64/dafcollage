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


ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("../../config.php");
require_once("lib.php");
require_once("ejercicios_clase_general.php");
require_once("ejercicios_form_creacion.php");
require_once("clase_log.php");



$log = new Log("log_creacion_IERC.txt");

// Crea ejercicio ahora
$ejercicioGeneral = unserialize($_SESSION['ejercicioGeneral']); 
$carpeta = unserialize($_SESSION['cosasProfe']);
$id_ejercicio = $ejercicioGeneral->insertar();
$log->write("insertar ejercicio: " . mysql_error());

// Y para el profesor tambien
//Tengo que asignarle el ejercicio al profesor 
$ejercicio_profesor = new Ejercicios_prof_actividad($ejercicioGeneral->get('id'),$ejercicioGeneral->get('id_creador'),$id_ejercicio,$carpeta);
$ejercicio_profesor->insertar();
$log->write("insertar profesor: " . mysql_error());

//Recoger parametros que hacen falta
$id_curso = optional_param('id_curso', 0, PARAM_INT);
$p = optional_param('p', 0, PARAM_INT);
$tipocreacion = optional_param('tipocreacion', 0, PARAM_INT);
//$id_ejercicio = optional_param('id_ejercicio', 0, PARAM_INT);
$tipo_origen = optional_param('tipo_origen', 0, PARAM_INT);
$tipo_respuesta = optional_param('tr', 0, PARAM_INT);

$log->write("id_curso: " . $id_curso);
$log->write("p: " . $p);
$log->write("tipocreacion: " . $tipocreacion);
$log->write("tipo origen: " . $tipo_origen);
$log->write("tipo respuesta: " . $tipo_respuesta);

echo "Guardando en base de datos Identificar Elementos";

$log->write("Antes de pintar formulario");
$mform = new mod_ejercicios_creando_ejercicio_ierc($id_curso, $p, $id_ejercicio, $tipo_origen, $tipo_respuesta, $tipocreacion);
$mform->pintarformulario_identificarelementos($id_curso, $p, $id_ejercicio, $tipo_origen, $tipo_respuesta, $tipocreacion);
$log->write("Despues de pintar formulario");


//Obtengo el archivo origen
/*switch($tipo_origen) {
    case 1: //Es un texto
        $texto_origen = optional_param('archivoorigen', NULL, PARAM_TEXT);
        $mitexto = new Ejercicios_textos(NULL, $id_ejercicio, $texto_origen);
        $mitexto->insertar();
        break;
    case 2: // Es un audio
        //comprobamos que esten en la carpeta que nosotros queremos4
        foreach ($_FILES as $name => $values) {

            //tengo que cambiar la ruta donde se guarda
            if (move_uploaded_file($values['tmp_name'], './mediaplayer/audios/audio' . $id_ejercicio . '.mp3')) {

                //  echo 'El archivo ha sido subido correctamente.<br/>';
            }
        }
        break;
    case 3: //Es un video
        echo "estoy creando multiplechoice, con video-texto";
        $auxUrlVideo = optional_param('archivovideo', NULL, PARAM_TEXT);
        $yvh = new YoutubeVideoHelper();
        $id_video = $yvh->getVideoId($auxUrlVideo);
        $mivideo = new Ejercicios_videos(NULL, $id_ejercicio, $id_video);
        $mivideo->insertar();
        break;
        
}*/





//Obtengo el numero de preguntas
$numero_preguntas = optional_param('numeropreguntas', PARAM_INT);
$log->write("Numero preguntas: " . $numero_preguntas);
//echo "El numero de pregutas es:".$numero_preguntas;

//Echo "\n";
for($i=0;$i<$numero_preguntas;$i++){
    $j=$i+1;
    
    //Obtengo la pregunta   
    switch($tipo_origen) {
        case 1: //Es un texto
            $pregunta = optional_param('pregunta'.$j,PARAM_TEXT);
            break;
        case 2: //Es un audio
            //tengo que cambiar la ruta donde se guarda
            $pregunta = 'audio' . $id_ejercicio. '_' . $j . '.mp3';
            $log->write("FILES: " . var_export($_FILES, true));
            if (move_uploaded_file($_FILES['pregunta'.$j]['tmp_name'],'./mediaplayer/audios/'.$pregunta)) {

                //  echo 'El archivo ha sido subido correctamente.<br/>';
		$log->write("El archivo se ha subido correctamente");
            }            
            break;
        case 3: //Es un video
            echo "estoy creando multiplechoice, con video-texto";
            $auxUrlVideo = optional_param('pregunta'.$j, NULL, PARAM_TEXT);
            $yvh = new YoutubeVideoHelper();
            $id_video = $yvh->getVideoId($auxUrlVideo);
            $pregunta = $id_video;
            break;
    }
    $log->write("Pregunta: " . $pregunta);
    
    //Obtener el numero de subrespuestas (numero de columnas de la tabla)
    $num_cols = optional_param('sel_subrespuestas_'.$j,1,PARAM_INT);
    $log->write("Num cols: " . $num_cols);
    
    //Obtener los titulos de las cabeceras
    //IMPORTANTE: NO USAR [..,..,..] EN MAC06 NO SE SOPORTA DEBIDO A LA VERSION DE PHP
    $cabeceras = array("","","","","");
    for ($l=1; $l<=$num_cols; $l++)
        $cabeceras[$l-1]=optional_param('cab_'.$j.'_0_'.$l,"",PARAM_TEXT);
    $log->write("Cabeceras: " . var_export($cabeceras,true));
    

    //Inserto la pregunta
    $mispreguntas= new ejercicios_ierc_preg(NULL, $id_ejercicio, $pregunta, $num_cols, $cabeceras[0], $cabeceras[1], $cabeceras[2], $cabeceras[3], $cabeceras[4]);
    $id_preg=$mispreguntas->insertar();
    $log->write("insertar preguntas: " . mysql_error());
    $log->write("Id Preg: " . $id_preg);

    //Obtengo el numero de respuestas a cada pregunta
    $numero_respuestas = optional_param('numerorespuestas_'.$j,0,PARAM_INT);
    $log->write("Numero respuestas: " . $numero_respuestas);
    
    $respuestas = array("","","","","");   
    //Obtengo la respuesta
    for($k=0;$k<$numero_respuestas;$k++){
        $l=$k+1;
        
        for ($m=1; $m<=$num_cols; $m++) {
            $log->write("Celda: " . 'resp_'.$j.'_'.$l.'_'.$m);
            $respuestas[$m-1] = optional_param('resp_'.$j.'_'.$l.'_'.$m,"",PARAM_TEXT);
        }
        $log->write("Respuesta ".$l." : " . var_export($respuestas, true));
        $mi_respuesta = new ejercicios_ierc_resp(NULL, $id_preg, $respuestas[0], $respuestas[1], $respuestas[2], $respuestas[3], $respuestas[4]);  
        $mi_respuesta->insertar();     
	$log->write("insertar respuestas: " . mysql_error());
    }
   

   // Echo "\n";
}

    $log->close();

    //Muestro el ejercicio
  
     redirect('./view.php?id=' . $id_curso . '&opcion=8' . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . "&tr=" . $tipo_respuesta . "&tipocreacion=" . $tipocreacion);

        
    
 
    



?>
