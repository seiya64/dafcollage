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

    //obtengo el texto
     $textos= new Ejercicios_textos();
     $texto=$textos->obtener_uno_id_ejercicio($id_ejercicio);
     //borro el texto
     delete_records('ejercicios_textos', 'id',$texto->get('id'));
     //vuelvo a insertarlo
     $elmodificado=optional_param('texto',PARAM_TEXT);
     $nuevotexto= new Ejercicios_textos(NULL,$id_ejercicio,$elmodificado);
     $nuevotexto->insertar();
    //obtengo los id de las preguntas del ejercicio
    $id_preguntas=array();
    
    $mis_preguntas= new Ejercicios_texto_texto_preg();
   
    $id_preguntas=$mis_preguntas->obtener_todas_preguntas_ejercicicio($id_ejercicio);
    //borro las respuestas
 
    for($s=0;$s<sizeof($id_preguntas);$s++){
            delete_records('ejercicios_texto_texto_resp', 'id_pregunta', $id_preguntas[$s]->get('id'));

    }
  
    //borro las preguntas
    delete_records('ejercicios_texto_texto_preg', 'id_ejercicio', $id_ejercicio);
    
  
    //leo un ejercicio y lo guardo
  
    for($i=0;$i<$numpreg;$i++){
    //Obtengo el numero de respuestas a cada pregunta
    $j=$i+1;

    $preg=required_param('pregunta'.$j,PARAM_TEXT);
  
    $numresp=required_param('num_res_preg'.$j,PARAM_TEXT);
    //Añado la pregunta
    $ejercicio_texto_preg = new Ejercicios_texto_texto_preg(NULL,$id_ejercicio,$preg);
    $id_pregunta= $ejercicio_texto_preg->insertar();

    for($k=0;$k<$numresp;$k++){
        $l=$k+1;
        $resp=required_param('respuesta'.$l."_".$j,PARAM_TEXT);
    
        $correcta=required_param('valorcorrecta'.$l."_".$j,PARAM_INT);

   
       $ejercicio_texto_resp = new Ejercicios_texto_texto_resp(NULL,$id_pregunta,$resp,$correcta);
       $ejercicio_texto_resp->insertar();

    }
    commit_sql();
   
  
   
    }
    
    
       redirect('./view.php?id=' . $id_curso . '&opcion=9');
    }
}



    

?>
