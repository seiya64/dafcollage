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
  GNU General Public License for more details. */

require_once("../../config.php");
require_once("lib.php");
require_once("ejercicios_clase_general.php");
require_once("ejercicios_form_creacion.php");

// Crea ejercicio ahora
$ejercicioGeneral = unserialize($_SESSION['ejercicioGeneral']); 
$carpeta = unserialize($_SESSION['cosasProfe']);
$id_ejercicio = $ejercicioGeneral->insertar();

// Y para el profesor tambien
//Tengo que asignarle el ejercicio al profesor 
$ejercicio_profesor = new Ejercicios_prof_actividad($ejercicioGeneral->get('id'),$ejercicioGeneral->get('id_creador'),$id_ejercicio,$carpeta);
$ejercicio_profesor->insertar();

$id_curso = optional_param('id_curso', 0, PARAM_INT);
$p = optional_param('p', 0, PARAM_INT);
$tipocreacion = optional_param('tipocreacion', 0, PARAM_INT);
//$id_ejercicio = optional_param('id_ejercicio', 0, PARAM_INT);
$tipo_origen = optional_param('tipo_origen', 0, PARAM_INT);
$tipo_respuesta = optional_param('tr', 0, PARAM_INT);

$mform = new mod_ejercicios_creando_ejercicio_ordenar_elementos($id_curso, $p, $id_ejercicio, $tipo_origen, $tipo_respuesta, $tipocreacion);
$mform->pintarformularioordenarelementos($id_curso, $p, $id_ejercicio, $tipo_origen, $tipo_respuesta, $tipocreacion);



//De donde vengo
//A donde voy
//A partir de aquí es de Tipocreación 2: Es decir "Asociación Multiple";
//
//Obtengo el archivo origen


switch ($tipo_origen) {
    case 1://Es un texto
        echo "Texto -";
        switch ($tipo_respuesta) {
            case 1: //Respuesta texto
                //echo "inserto en la bd";
                //Obtengo el numero de preguntas
                $numero_preguntas = optional_param('numeropreguntas', PARAM_INT);

                for ($i = 0; $i < $numero_preguntas; $i++) {
                    //Obtengo la pregunta

                    $j = $i + 1;
                    //$pregunta = optional_param('pregunta' . $j, PARAM_TEXT);
                    $pregunta = "";

                    //Inserto la pregunta Archivo asociación
                    $mispreguntas = new Ejercicios_texto_texto_preg(NULL, $id_ejercicio, $pregunta);
                    $id_preg = $mispreguntas->insertar();

                    
                    //Obtengo el numero de ordenes para esta pregunta
                    $num_orden = optional_param('num_orden_'.$j);
                    for ($k=1; $k<=$num_orden; $k++) {
                        //Obtengo el numero de respuestas para este orden
                        $num_resp = optional_param('num_resp_'.$j."_".$k);
                        for ($l=1; $l<=$num_resp; $l++) {
                            $respuesta = optional_param('respuesta'.$l."_".$k."_".$j);
                            $oe_resp = new ejercicios_ordenar_elementos_resp(NULL, $id_preg, $k, $l, $respuesta);
                            $oe_resp->insertar();
                        }
                    }


                    echo "fin insercción";
                }
                break;
        }
        break;

    
}



//Muestro el ejercicio


redirect('./view.php?id=' . $id_curso . '&opcion=8' . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . "&tr=" . $tipo_respuesta . "&tipocreacion=" . $tipocreacion);
?>