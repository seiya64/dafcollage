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
  Serafina Molina Soto(finamolina@gmail.com)
 
  Original idea and content design:
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
$tipocreacion = optional_param('tipocreacion', 0, PARAM_INT);
$id_ejercicio = optional_param('id_ejercicio', 0, PARAM_INT);



$mform = new  mod_ejercicios_creando_ejercicio_texto($id_curso);
$mform->pintarformulariotexto($id_curso);



//Obtengo el numero de preguntas
$numero_preguntas = optional_param('numeropreguntas', PARAM_INT);
//echo "El numero de pregutas es:".$numero_preguntas;

//Echo "\n";
for($i=0;$i<$numero_preguntas;$i++){
    //Obtengo el numero de respuestas a cada pregunta
    
    $j=$i+1;
    $pregunta = optional_param('pregunta'.$j,PARAM_TEXT);
  //  echo "Respuesta 1_1 de la pregunta ".$j." es:".$respuesta;
  //  echo "Pregunta".$j." es:".$pregunta;
  //  echo "\n";   
    //Obtengo el numero de respuestas a cada pregunta
    
    $numero_respuestas = optional_param('numerorespuestas_'.$j,0,PARAM_INT);
   // echo "El numero de respuestas de la pregunta ".$j." es:".$numero_respuestas;
   // echo "\n";
    //Obtengo la respuesta
    for($k=0;$k<$numero_respuestas;$k++){
        $l=$k+1;
        $respuesta = optional_param('respuesta'.$l.'_'.$j,PARAM_TEXT);
       // echo 'respuesta'.$l.'_'.$j." de la pregunta ".$j." es:".$respuesta;
       
        //Obtengo si es correcta o incorrecta
        $correcta = optional_param('correcta'.$l.'_'.$j,PARAM_INT);
        //echo 'respuesta'.$l.'_'.$j." es correcta:".$correcta."\n";
        
        //inserto en la bd
        if($correcta=='Si'){
            $rcorrecta=1;
        }else{
             $rcorrecta=0;
        }
      
        $ejercicio_texto = new Ejercicios_texto_texto(NULL,$id_ejercicio,$j,$pregunta,$respuesta,$rcorrecta);
   
       $ejercicio_texto->insertar();
    
     
    }
   

   // Echo "\n";
}

    
    //Muestro el ejercicio
  
     redirect('./view.php?id=' . $id_curso . '&opcion=8'. '&id_ejercicio='.$id_ejercicio);
        
    
 
    




?>
