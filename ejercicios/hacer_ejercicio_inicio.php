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
require_once("mod_form.php");

global $CFG;



$id_curso = optional_param('id', 0, PARAM_INT);
$mform = new   mod_ejercicios_mod_formulario($id_curso);
$mform->pintaropciones($id_curso);




$id_ej = optional_param('oculto1',PARAM_TEXT);


$tipo1= new Ejercicios_general();
#selecciono los ejercicios para generar uno aleatorio a mostrar
$ejercicio= $tipo1->obtener_uno($id_ej);

$nombre_ejercicio= $ejercicio->get('name');

$id_ejercicio=$ejercicio->get('id');

if ($mform->is_submitted()) { //Boton realizar (el boton buscar y crear estan en el javascript)

    //Miro que tipo de ejercicio es para mostrar el correcto

            if($ejercicio->get('tipoactividad')==0){ //multichoice
             redirect("./view.php?opcion=8&id=".$id_curso.'&id_ejercicio='.$id_ejercicio.'&buscar=1&tipo_origen='.$ejercicio->get('tipoarchivopregunta'));

            }else{
                 if($ejercicio->get('tipoactividad')==1){ //asociacion simple

                     //comprubo que tipo tiene archivorespuesta
                     if($ejercicio->get('tipoarchivopregunta')==1){ //La pregunta es un texto
                          if($ejercicio->get('tipoarchivorespuesta')==1 || $ejercicio->get('tipoarchivorespuesta')==4){ //La respuesta es un texto
                              redirect("./view.php?opcion=8&id=".$id_curso.'&id_ejercicio='.$id_ejercicio.'&buscar=1&tipo_origen='.$ejercicio->get('tipoarchivopregunta').'&tr='.$ejercicio->get('tipoarchivorespuesta').'&tipocreacion='.$ejercicio->get('tipoactividad'));

                          }

                     }
                 }


            }

     
      // if($tipo==0){ // Ejercicio tipo multichoice
           //redirect('./view.php?opcion=8&id='.$id_curso.'&id_ejercicio='.$id_ej.'&buscar=1&tipo_origen='.$tipo_origen);
      // }
     
}

?>
