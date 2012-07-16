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
$id_ejercicio = optional_param('id_ejercicio', 0, PARAM_INT);

//Es llamado por ejercicios_form_mostrar.php

$mform = new  mod_ejercicios_mostrar_ejercicio($id_curso,$id_ejercicio);
$mform->mostrar_ejercicio($id_curso,$id_ejercicio);

if ($mform->is_submitted()) {  //Boton Guardar
   
    #borro todas las respuestas y preguntas y las vuelvo a insertar
    delete_records('ejercicios_texto_texto', 'id_ejercicio', $id_ejercicio);
    
    
    //leo un ejercicio y lo guardo
    
    for($i=0;$i<1;$i++){
    //Obtengo el numero de respuestas a cada pregunta
    echo required_param('crespuesta1_1',PARAM_INT);
    echo required_param('pregunta1',PARAM_TEXT);
    
    $j=$i+1;
   // $pregunta = required_param('pregunta'.$j,PARAM_TEXT);
     echo "pregunta".$pregunta;
    }
   
    $ejercicio_texto = new Ejercicios_texto_texto();

    $ejercicio_texto->insertar();

}

?>
