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
  GNU General Public License for more details. */

require_once("../../config.php");
require_once("lib.php");
require_once("ejercicios_clase_general.php");
require_once("ejercicios_form_creacion.php");
require_once("YoutubeVideoHelper.php");
require_once('clase_log.php');

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

$id_curso = optional_param('id_curso', 0, PARAM_INT);
$id_ejercicio = optional_param('id_ejercicio', 0, PARAM_INT);
$tipo_origen = optional_param('tipo_origen',0, PARAM_INT);
$buscar = optional_param('buscar',0,PARAM_INT);

$log = new Log('log_modificar_IERC.txt');
$log->write('Id ejercicio: ' . $id_ejercicio);
$log->write("Tipo origen: " . $tipo_origen);

//Inicializar sesion
$log->write('antes session start');
session_start();
$log->write('despues session start');

//Es llamado por ejercicios_form_mostrar.php

$mform = new mod_ejercicios_mostrar_ejercicio_ierc($id_curso,$id_ejercicio,$tipo_origen);
$mform->mostrar_ejercicio_ierc($id_curso, $id_ejercicio, $buscar, $tipo_origen);

$num_preg= required_param('num_preg', PARAM_TEXT);
$log->write('num preg: ' . $num_preg);


if(optional_param("submitbutton2")){ //boton para añadir a mis ejercicos visible desde la busqueda
     
    global $USER;
   
    //inserto el ejercicio en profesor_actividades
        $ejercicio_profesor = new Ejercicios_prof_actividad(NULL,$USER->id,$id_ejercicio,optional_param("carpeta_ejercicio"));
        $ejercicio_profesor->insertar();
    
    //Muestro mis ejercicios
     redirect('./view.php?id=' . $id_curso . '&opcion=9');
    
} else {

    if(optional_param("submitbutton")){ //boton para guardar los ejercicios visible desde mis ejercicios
     #borro todas las respuestas y preguntas y las vuelvo a insertar
    //comenzamos una transacción para que en todas las tablas se haga seguido
    // en caso de error en algun delete, no se hace ninguno

     $ejercicio_general = new Ejercicios_general();
     $miejercicio=$ejercicio_general->obtener_uno($id_ejercicio);
     $miejercicio->set_numpregunta($num_preg);
     $miejercicio->alterar();
    
     
     
     
    begin_sql();
    
    //Borro todas las respuestas y preguntas del ejercicio
    $preguntas = new ejercicios_ierc_preg();
    $mis_preguntas = $preguntas->obtener_todos_id_ejercicio($id_ejercicio);
    //Borro todas las respuestas
    foreach ($mis_preguntas as $pregunta) {
        $respuestas = new ejercicios_ierc_resp();
        $respuestas->borrar_id_pregunta($pregunta->get('id'));
    }
    //Borro todas las preguntas
    $preguntas->borrar_id_ejercicio($id_ejercicio);
    
    
    //Para cada pregunta
    for($i=1; $i<=$num_preg; $i++) {
        $num_cols = optional_param('sel_subrespuestas_'.$i,0,PARAM_INT);
        $log->write('num cols: ' . $num_cols);
        
        //Coger el texto de la pregunta
        switch($tipo_origen) {
            case 1: //Es texto
                $pregunta = optional_param('pregunta'.$i,"",PARAM_TEXT);
                break;
            case 2: //Es audio
                $pregunta = 'audio'.$id_ejercicio."_".$i.".mp3";
                break;
            case 3: //Es video
                $pregunta = optional_param('pregunta'.$i,"",PARAM_TEXT);
                break;
        }
        $log->write('pregunta: ' . $pregunta);
        
        //Coger las cabeceras
        $cabs = ["","","","",""];
        for($j=1; $j<=$num_cols; $j++) {
            $cabs[$j-1]=optional_param('cab_'.$i.'_0_'.$j,"",PARAM_TEXT);
        }
        $log->write('cabeceras: ' . var_export($cabs,true));               
        
        //Insertar la pregunta
        $preguntas = new ejercicios_ierc_preg(NULL, $id_ejercicio, $pregunta, $num_cols, $cabs[0], $cabs[1], $cabs[2], $cabs[3], $cabs[4]);
        $id_preg = $preguntas->insertar();
        $log->write("insertar pregunta, error: " . mysql_error());
        $log->write("id_preg: " . $id_preg);
        
        
        //Insertar las respuestas
        $num_resp = optional_param('numerorespuestas_'.$i,0,PARAM_INT);
        for ($k=1; $k<=$num_resp; $k++) {
            $resp = ["","","","",""];
            for ($l=1; $l<=$num_cols; $l++) {
                $resp[$l-1]=optional_param('resp_'.$i.'_'.$k.'_'.$l,"",PARAM_TEXT);
            }
            $log->write("respuestas ".$k." : ".var_export($resp,true));
            $respuestas = new ejercicios_ierc_resp(NULL, $id_preg, $resp[0], $resp[1], $resp[2], $resp[3], $resp[4]);
            $respuestas->insertar();
            $log->write('insertar respuestas: ' . mysql_error());
        }
    }
    
    
    commit_sql();
       redirect('./view.php?id=' . $id_curso . '&opcion=9');
    }
    
}


?>
