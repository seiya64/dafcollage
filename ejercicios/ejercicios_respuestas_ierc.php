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
  GNU General Public License for more details. 
 */

/**
 * @author Angel Biedma Mesa
 * Este script responde a una peticion AJAX para recuperar las soluciones de un ejercicio IE mas RC
 */

require_once("../../config.php");
require_once("lib.php");
require_once("clase_log.php");

header('Content-type: application/json');

$log = new Log("log_respuestas_ierc.txt", "w");

//Coger informacion del POST
$id_ejercicio = $_POST['id_ejercicio'];
$log->write('id ejercicio: ' . $id_ejercicio);

//En esta variable se almacenara el resultado del objeto
$resultado=array();

//Obtener las preguntas y respuestas del ejercicio
$obj_pregs = new ejercicios_ierc_preg();
$preguntas = $obj_pregs->obtener_todos_id_ejercicio($id_ejercicio);
$log->write('preguntas: ' . var_export($preguntas,true));
$resultado['num_pregs']=sizeof($preguntas);
$resultado['preguntas']=array();


//Para cada pregunta se cogera sus respuestas
for ($i=0; $i<sizeof($preguntas); $i++) {
    $num_cabs = $preguntas[$i]->get('num_cabs'); //Obtener el numero de subrespuestas
    $resultado['preguntas'][$i]=array();
    $resultado['preguntas'][$i]['num_cabs']=$num_cabs;
    
    $obj_resp = new ejercicios_ierc_resp();
    $respuestas = $obj_resp->obtener_todos_id_pregunta($preguntas[$i]->get('id'));
    $log->write("respuestas: " . var_export($respuestas,true));    
    $resultado['preguntas'][$i]['num_resp']=sizeof($respuestas);
    for ($j=0; $j<sizeof($respuestas); $j++) {
        $resultado['preguntas'][$i][$j]=array();
        for ($k=1; $k<=$num_cabs; $k++)  $resultado['preguntas'][$i][$j][$k]=$respuestas[$j]->get('resp'.$k);
    }
}

$log->write('resultado: ' . var_export($resultado,true));
$log->write('json resultado: ' . json_encode($resultado));
echo json_encode(json_encode($resultado));

?>
