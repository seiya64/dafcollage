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
  Javier Castro Fernández (havidarou@gmail.com)

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
$fuentes = optional_param('fuentes',PARAM_TEXT);
        
$ejercicioGeneral->set_fuentes($fuentes);
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

//Añadir la configuracion del ejercicio dada por el profesor
$file_log = fopen('log_creacion_th.txt','w');
$mostrar_pistas = optional_param('TH_mostrar_pistas',0,PARAM_INT);
$mostrar_palabras = optional_param('TH_mostrar_palabras',0,PARAM_INT);
$mostrar_solucion = optional_param('TH_mostrar_soluciones',0,PARAM_INT);
$log = "mostrar pistas: " . $mostrar_pistas . "\n";
$log .= "mostrar palabras: " . $mostrar_palabras . "\n";
$log .= "mostrar solucion: " . $mostrar_solucion . "\n";
$log .= "id ejercicio: " . $id_ejercicio . "\n";
$conf_ej = new ejercicios_texto_hueco(NULL,$id_ejercicio,$mostrar_pistas,$mostrar_palabras,$mostrar_solucion);
$conf_ej->insertar();
$log .= "Error mysql: " . mysql_error() . "\n";
fwrite($file_log,$log,strlen($log));
fclose($file_log);

$mform = new mod_ejercicios_creando_ejercicio_texto_hueco($id_curso, $p, $id_ejercicio, $tipo_origen, $tipo_respuesta, $tipocreacion);
$mform->pintarformulariotextohueco($id_curso, $p, $id_ejercicio, $tipo_origen, $tipo_respuesta, $tipocreacion);



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
                    $pregunta = optional_param('pregunta' . $j, PARAM_TEXT);

                    //Inserto la pregunta Archivo asociación
                    $mispreguntas = new Ejercicios_texto_texto_preg(NULL, $id_ejercicio, $pregunta);
                    $id_preg = $mispreguntas->insertar();


                    //Obtengo las respuestas Archivo asociado
                    $num_resp = optional_param('numerorespuestas_'.$j);
                    for ($k=1; $k<=$num_resp; $k++) {
                        $respuesta = optional_param('respuesta' . $k . "_" . $j, PARAM_TEXT);
                        $rcorrecta = $k-1; //Aqui guardamos el orden de la respuesta
                        //Lo inserto en la tabla
                        $mi_respuesta = new Ejercicios_texto_texto_resp(NULL, $id_preg, $respuesta, $rcorrecta);

                        $mi_respuesta->insertar();
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