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

$id_curso = optional_param('id_curso', 0, PARAM_INT);

//echo "Entra";
$mform = new  mod_ejercicios_puzzle_form('gestion_creacion.php');
$mform->pintarinterfaz($id_curso);

/*código con la acción consecuente de eliminar... */

if ($mform->is_cancelled()) { //Me vuelvo al menu principal
 
    redirect('./view.php?id=' . $id_curso . '&opcion=1');
}else{ //Código de aceptar



//leo un ejercicio y lo guardo
$ejercicio_leido = new Ejercicios_mis_puzzledoble(required_param('nombre_ejercicio', PARAM_TEXT));

$ejercicio_leido->insertar();
//volvemos a la pagina principal
 redirect('./view.php?id=' . $id_curso . '&opcion=1');

}



?>
