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

//Es llamado por ejercicios_form_misejercicios.php
//desde los enlaces

$mform = new  mod_ejercicios_mis_ejercicios($id_curso);
$mform->pintaropciones($id_curso);



//Elimino el ejercicio de profesor_actividad
//puesto que ya no lo estoy usando


if ($mform->is_submitted()) {  //Boton Menu Principal
     redirect('./view.php?id=' . $id_curso );
  
}else{
$ejercicio_profesor_actividad = new Ejercicios_prof_actividad();

  $id_profesor=$USER->id;
 
  $los_ejercicios=$ejercicio_profesor_actividad->obtener_ejercicos_del_profesor($id_profesor);
  
  for($i=0;$i<sizeof($los_ejercicios);$i++){
     
      $id_bd_ej=$los_ejercicios[$i]->get('id_ejercicio');


      //Si estoy usando el ejercicio lo elimino
      
      if($id_bd_ej == $id_ejercicio){
        
          $ejercicio_profesor_actividad->borrar_id_ejercicio($id_ejercicio, $id_profesor);
      }
      
      //Compruebo si hay alguien más usuando el ejercicio
      
       $todos_ejercicios=$ejercicio_profesor_actividad->obtener_todos_idejercicio($id_ejercicio);
       
       if(sizeof($todos_ejercicios)==0){
          // echo "no hay gente usandolo";
           //Lo elimino de la tabla de ejercicios correspondiente y de la tabla de ejercicios general
           
            $ejercicio_general=new Ejercicios_general();
            $ejercicio=$ejercicio_general->obtener_uno($id_ejercicio);
            
           if($ejercicio->get('id_creador')==$id_profesor){
                    if($ejercicio->get('TipoActividad')==0){
              

                        $ejercicio_general->borrar($id_ejercicio);
                
                        //echo "borrando de texto texto" 
                        $ejercicio_texto_texto=new Ejercicios_texto_texto();
                        $ejercicio_texto_texto->borrar_id_ejercicio($id_ejercicio);
                   } //Falta añadir el resto de tipos de actividades
          
           }
         
       }
  }


   //Muestro mis ejercicios

     redirect('./view.php?id=' . $id_curso . '&opcion=9'. '&id='.$id_curso);
        
}
    

?>

