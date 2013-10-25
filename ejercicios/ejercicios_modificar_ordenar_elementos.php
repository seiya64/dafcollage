<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

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

$id_curso = optional_param('id_curso', 0, PARAM_INT);
$id_ejercicio = optional_param('id_ejercicio', 0, PARAM_INT);
$tipo_origen = optional_param('tipo_origen', 0, PARAM_INT);
$tipo_respuesta = optional_param('tr', 0, PARAM_INT);
$tipo_creacion = optional_param('tipocreacion', 0, PARAM_INT);

ECHO "MODIFICANDO";

$mform = new mod_ejercicios_mostrar_ejercicio_ordenar_elementos($id_curso, $id_ejercicio, $tipo_origen, $tipo_respuesta, $tipo_creacion);
$mform->mostrar_ejercicio_ordenar_elementos($id_curso, $id_ejercicio, 0, $tipo_origen, $tipo_respuesta, $tipo_creacion);

$numeropreguntas = optional_param('num_preg', 0, PARAM_INT);

echo "El numero de pregunas es" . $numeropreguntas;


$ejercicio_general = new Ejercicios_general();
     $miejercicio=$ejercicio_general->obtener_uno($id_ejercicio);
     $miejercicio->set_numpregunta($numeropreguntas);
     $fuentes = optional_param('fuentes',PARAM_TEXT);
     $miejercicio->set_fuentes($fuentes);
     $miejercicio->alterar();
     
begin_sql();

if ($tipo_origen == 1) { //la pregunta es un texto
    if ($tipo_respuesta == 1) {//Es un texto
        //obtengo los id de las preguntas del ejercicio
        //$id_preguntas = array();

        $mis_preguntas = new Ejercicios_texto_texto_preg();

        $id_preguntas = $mis_preguntas->obtener_todas_preguntas_ejercicicio($id_ejercicio);
        //borro las respuestas

        for ($s = 0; $s < sizeof($id_preguntas); $s++) {
            delete_records('ejercicios_ordenar_elementos_resp', 'id_pregunta', $id_preguntas[$s]->get('id'));
        }
    } 

    //borro las preguntas
    delete_records('ejercicios_texto_texto_preg', 'id_ejercicio', $id_ejercicio);
    
}

$file_log = @fopen("log_modificarAM.txt","w");
$log = "";
$log.="Numero de preguntas: " . $numeropreguntas . "\n";


//Guardo las nuevas
for ($i = 0; $i < $numeropreguntas; $i++) {
    //Obtengo el numero de respuestas a cada pregunta
    $j = $i + 1;
    $log.="Pregunta numero: " . $j . "\n";

    if ($tipo_origen == 1) { //Si la pregunta es un texto
        $preg = required_param('pregunta' . $j, PARAM_TEXT);
        
        $ejercicio_texto_preg = new Ejercicios_texto_texto_preg(NULL, $id_ejercicio, $preg);
        $id_pregunta = $ejercicio_texto_preg->insertar();


        if ($tipo_respuesta == 1) { //Si la respuesta es un texto
            $num_orden = required_param('num_orden_'.$j,PARAM_INT);
            for ($l=1; $l<=$num_orden; $l++) {
                $num_resp = required_param('num_res_preg'.$j."_".$l,PARAM_INT);

                for ($k=1; $k<=$num_resp; $k++) {
                    $resp = required_param('respuesta'.$k."_".$l.'_'.$j, PARAM_TEXT);
                    $ejercicio_texto_resp = new ejercicios_ordenar_elementos_resp(NULL, $id_pregunta, $l, $k, $resp);
                    $ejercicio_texto_resp->insertar();
                }
            }
        } 
    } 
}
fwrite($file_log,$log,strlen($log));
fclose($file_log);
commit_sql();

redirect('./view.php?id=' . $id_curso . '&opcion=9');
?>
