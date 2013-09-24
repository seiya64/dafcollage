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
  Javier Castro Fernández (havidarou@gmail.com)
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
  GNU General Public License for more details. 
 */



 function genera_titulos($titulo, $tipo_creacion,$id_curso) {
    
    $cabecera = '<h1 id="h1" class="instrucciones"><span style="float:right;"><a style="font-size: 1.1em" id="id_cancellink" href="/moodle/mod/ejercicios/view.php?id='.$id_curso.'">'.get_string('Reset','ejercicios').'</a></span><div style="font-size:0.7em; height: 13px;"><i>'.$tipo_creacion.'</i></div><u style="
                font-size: 0.9em;">'.$titulo.'</u></h1>';
    return $cabecera;
 }
 
 function genera_fuentes($fuentes) {
    $label = '<h4>'.get_string('fuentes', 'ejercicios').'</h4> <textarea style="width:100%;" id="fuentes" name="fuentes" wrap="virtual" rows="5" cols="80">'. $fuentes.'</textarea>';      
 
    return $label;  
 }
?>
