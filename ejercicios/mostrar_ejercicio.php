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

$id_curso = optional_param('id_curso', 0, PARAM_INT);
$name_ej = optional_param('name', 0, PARAM_TEXT);
$tipo = optional_param('tipo', 0, PARAM_INT);

global $CFG;
$mform = new  mod_ejercicios_hacer_puzzle_form($id_curso,$name_ej);
$mform->pintarejercicio($id_curso,$name_ej);



if ($mform->is_submitted()) { //Boton aceptar
   
            //mostramos el ejercicio creado
       
         if($tipo==1){
           redirect('./view.php?id=' . $id_curso . '&opcion=2&name_ej='.$name_ej.'&tipo=1');
       }else{
           if($tipo==2){
           redirect('./view.php?id=' . $id_curso . '&opcion=2&name_ej='.$name_ej.'&tipo=2');
           }else{
             redirect('./view.php?id=' . $id_curso . '&opcion=2&name_ej='.$name_ej.'&tipo=3');
              
           }
       }
     
     


}
?>
