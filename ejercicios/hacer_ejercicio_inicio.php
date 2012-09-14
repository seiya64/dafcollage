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
require_once("ejercicios_clases.php");
require_once("ejercicios_form.php");

global $CFG;
$id_curso = optional_param('id_curso', 0, PARAM_INT);
$mform = new   mod_ejercicios_mod_form($id_curso);
$mform->pintaropciones($id_curso);




$id_ej = optional_param('oculto1',PARAM_TEXT);


$tipo= new Ejercicios_general();
#selecciono los ejercicios para generar uno aleatorio a mostrar
$ejercicio= $tipo1->obtener_uno($id_ej);
$nomtipo= $ejercicio->get('tipoactividad');

if ($mform->is_submitted()) { //Boton realizar (el boton buscar y crear estan en el javascript)
   
      
       if($tipo==0){ // Ejercicio tipo multichoice
           redirect('./view.php?id=' . $id_curso . '&opcion=2&name_ej='.$name_ej.'&tipo=1');
       }
     
}

?>
