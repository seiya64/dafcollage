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

 $ejercicio_general = new Ejercicios_general();
 $miejercicio=$ejercicio_general->obtener_uno($id_ejercicio);

 $numpreg=$miejercicio->get("numpreg"); 
 
if(optional_param("submitbutton2")){ //boton para añadir a mis ejercicos visible desde la busqueda
     
    global $USER;
   
    //inserto el ejercicio en profesor_actividades
        $ejercicio_profesor = new Ejercicios_prof_actividad(NULL,$USER->id,$id_ejercicio,optional_param("carpeta_ejercicio"));
        $ejercicio_profesor->insertar();
    
    //Muestro mis ejercicios
     redirect('./view.php?id=' . $id_curso . '&opcion=9');
    
}else{
    if(optional_param("submitbutton")){ //boton para guardar los ejercicios visible desde mis ejercicios
     #borro todas las respuestas y preguntas y las vuelvo a insertar
    //comenzamos una transacción para que en todas las tablas se haga seguido
    // en caso de error en algun delete, no se hace ninguno
    begin_sql();
    delete_records('ejercicios_texto_texto', 'id_ejercicio', $id_ejercicio);
    
    
    //leo un ejercicio y lo guardo
    
    for($i=0;$i<$numpreg;$i++){
    //Obtengo el numero de respuestas a cada pregunta
    $j=$i+1;
   
    $preg=required_param('pregunta'.$j,PARAM_TEXT);
  
    $numresp=required_param('num_res_preg'.$j,PARAM_TEXT);
  
    for($k=0;$k<$numresp;$k++){
        $l=$k+1;
        $resp=required_param('respuesta'.$l."_".$j,PARAM_TEXT);
    
        $correcta=required_param('valorcorrecta'.$l."_".$j,PARAM_INT);
       $ejercicio_texto = new Ejercicios_texto_texto(NULL,$id_ejercicio,$j,$preg,$resp,$correcta);

       $ejercicio_texto->insertar();

    }
    commit_sql();
   
  
   
    }
    
    
       redirect('./view.php?id=' . $id_curso . '&opcion=9');
    }
}



    

?>
