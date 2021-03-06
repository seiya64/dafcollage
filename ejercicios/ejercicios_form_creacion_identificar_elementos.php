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

//Recoger parametros que hacen falta
$id_curso = optional_param('id_curso', 0, PARAM_INT);
$p = optional_param('p', 0, PARAM_INT);
$tipocreacion = optional_param('tipocreacion', 0, PARAM_INT);
//$id_ejercicio = optional_param('id_ejercicio', 0, PARAM_INT);
$tipo_origen = optional_param('tipo_origen', 0, PARAM_INT);
$tipo_respuesta = optional_param('tr', 0, PARAM_INT);

echo "Guardando en base de datos Identificar Elementos";

$mform = new mod_ejercicios_creando_ejercicio_identificar_elementos($id_curso, $p, $id_ejercicio, $tipo_origen, $tipo_respuesta, $tipocreacion);
$mform->pintarformulario_identificarelementos($id_curso, $p, $id_ejercicio, $tipo_origen, $tipo_respuesta, $tipocreacion);



//Obtengo el archivo origen
switch($tipo_origen) {
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
        
}



//Obtengo el numero de preguntas
$numero_preguntas = optional_param('numeropreguntas', PARAM_INT);
//echo "El numero de pregutas es:".$numero_preguntas;

//Echo "\n";
for($i=0;$i<$numero_preguntas;$i++){
    //Obtengo la pregunta
    
    $j=$i+1;
    $pregunta = optional_param('pregunta'.$j,PARAM_TEXT);

    //Inserto la pregunta
    $mispreguntas= new Ejercicios_texto_texto_preg(NULL,$id_ejercicio,$pregunta);
    $id_preg=$mispreguntas->insertar();

    //Obtengo el numero de respuestas a cada pregunta

    $numero_respuestas = optional_param('numerorespuestas_'.$j,0,PARAM_INT);
   
    //Obtengo la respuesta
    for($k=0;$k<$numero_respuestas;$k++){
        $l=$k+1;
        $respuesta = optional_param('respuesta'.$l.'_'.$j,PARAM_TEXT);
       // echo 'respuesta'.$l.'_'.$j." de la pregunta ".$j." es:".$respuesta;
       
        
      
        $mi_respuesta = new ejercicios_ie_respuestas(NULL, $id_ejercicio, $id_preg, $respuesta);
   
        $mi_respuesta->insertar();
    
     
    }
   

   // Echo "\n";
}

    //Muestro el ejercicio
  
     redirect('./view.php?id=' . $id_curso . '&opcion=8' . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . "&tr=" . $tipo_respuesta . "&tipocreacion=" . $tipocreacion);

        
    
 
    



?>
