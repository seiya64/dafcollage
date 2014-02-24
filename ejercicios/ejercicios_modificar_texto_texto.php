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
require_once("YoutubeVideoHelper.php");
//PRUEBAS
//require_once('clase_log.php');
//
//global $USER;
//global $CFG;

 /******************************************************************************
 *******************************************************************************
 *        CARGA DE DATOS DE SESIÓN Y VARIABLES AUXILIARES DEL FORMULARIO       *
 *******************************************************************************
 ******************************************************************************/

$buscar = optional_param ('buscar', 0, PARAM_BOOL); // Esta opción de carga y la de abajo son muy cutres

$id = optional_param ('id_curso', 0, PARAM_INT); // Quizá se pueda acceder de otra forma
$fuentes = optional_param('fuentes',PARAM_TEXT);
$tipocreacion = optional_param('tipocreacion', 0, PARAM_INT);
$tipo_origen = optional_param('tipo_origen', 0, PARAM_INT);      
$num_preg = optional_param('num_preg', PARAM_TEXT);
$id_curso = optional_param ('id_curso', 0, PARAM_INT);
//PRUEBAS
//$nombreUnico = optional_param('idFoto', 0, PARAM_TEXT);
//$foto=0;
//if(nombreUnico != "/temporal".$USER->id) {
//	$foto=1;
//}

if (optional_param('radiovisible', PARAM_TEXT) == "Si") {
    $visible = 1;
} else {
    $visible = 0;
}
if (optional_param('radioprivado', PARAM_TEXT) == "Si") {
    $privado = 1;
} else {
    $privado = 0;
}

 /******************************************************************************
 *******************************************************************************
 *                            FIN CARGA DE DATOS                               *
 *******************************************************************************
 ******************************************************************************/


if (!$buscar) { // Se está creando el ejercicio *********************************
    // Obtener la foto ---> pendiente

    // Carga de datos de sesión
    $ejercicioGeneral = unserialize($_SESSION['ejercicioGeneral']); // Datos generales del ejercicio
    $carpeta = unserialize($_SESSION['cosasProfe']); // Carpeta del profesor

    // Se procede a insertar en la base de datos el ejercicio, comenzando por su descripción general
    $ejercicioGeneral->set_fuentes($fuentes);
    $ejercicioGeneral->set_visibilidad($visible);
    $ejercicioGeneral->set_privacidad($privado);
	$ejercicioGeneral->set_foto($foto);
    $id_ejercicio=$ejercicioGeneral->insertar();
	
	//PRUEBAS
//	$origen=$CFG->dataroot."/temp/".$nombreUnico;
//	$destino=$CFG->dataroot."/user/0/".$USER->id."/".$id_ejercicio;
//    
//	echo "Nombre Antiguo: /temporal".$USER->id."<br/>";
//	echo "Foto: ".$_POST['idFoto']."<br/>";
//	echo "nombre unico: ".$nombreUnico."<br/>";
//	echo "Origen: ".$origen."<br/>";
//	echo "Destino: ".$destino."<br/>";
////	die();
//	// Se mueve la foto a su ubicacion final
//	copy($origen, $destino);
	
    // Se asocia al profesor creador
    $ejercicio_profesor = new Ejercicios_prof_actividad($id,$USER->id,$id_ejercicio,$carpeta);
    $ejercicio_profesor->insertar();
    
} else { // Se está modificando el ejercicio ***********************************
    $modificable = optional_param('modificable', false, PARAM_BOOL);
    if ($modificable) { // Esta comprobación es, hasta mi conocimiento de la arquitectura del sistema, innecesaria, pero aún así prefiero hacerla
        // Se obtiene el identificador del ejercicio
        $id_ejercicio = optional_param('id_ejercicio', 0, PARAM_INT);
    }
}

// Es llamado por ejercicios_form_mostrar.php
$mform = new mod_ejercicios_mostrar_ejercicio($id, $p, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion);
$mform->mostrar_ejercicio($id, $p, $id_ejercicio, $tipo_origen, $buscar);

if (optional_param("submitbutton2")) { // Botón para añadir a mis ejercicos visible desde la búsqueda ---> Creo que esto ahora mismo no está funcionando
    global $USER;

    // Se inserta el ejercicio en profesor_actividades
    $ejercicio_profesor = new Ejercicios_prof_actividad(NULL, $USER->id, $id_ejercicio, optional_param("carpeta_ejercicio"));
    $ejercicio_profesor->insertar();

    // Muestro mis ejercicios
    redirect('./view.php?id=' . $id_curso . '&opcion=9');
} else {
    if (optional_param("submitbutton")) { // Botón para guardar el ejercicio
   
        // Se borran todas las preguntas para volver a insertarlo
        // Para ello, se comienza una transacción que hace que las tablas se modifiquen una detrás de otra
        // Si hay algún fallo, se revierten todos los cambios
        $ejercicio_general = new Ejercicios_general();
        $miejercicio = $ejercicio_general->obtener_uno($id_ejercicio);
        $miejercicio->set_numpregunta($num_preg);

        $miejercicio->set_visibilidad($visible);
        $miejercicio->set_privacidad($privado);
        $miejercicio->set_fuentes($fuentes);
        $miejercicio->alterar();
        
        

        begin_sql();

        if ($tipo_origen == 1) {//Es texto-texto
            //obtengo el texto
            $textos = new Ejercicios_textos();
            $texto = $textos->obtener_uno_id_ejercicio($id_ejercicio);
            //borro el texto
            delete_records('ejercicios_textos', 'id', $texto->get('id'));
            //vuelvo a insertarlo
            $elmodificado = optional_param('texto', PARAM_TEXT);
            $nuevotexto = new Ejercicios_textos(NULL, $id_ejercicio, $elmodificado);
            $nuevotexto->insertar();
        } else {
            if ($tipo_origen == 3) { //Es con video       
                //obtengo el texto
                $videos = new Ejercicios_videos();
                $video = $videos->obtener_uno_id_ejercicio($id_ejercicio);
                //borro el texto
                delete_records('ejercicios_videos', 'id', $video->get('id'));
                //vuelvo a insertarlo
                $elmodificado = optional_param('archivovideo', NULL, PARAM_TEXT);
                $modyvh = new YoutubeVideoHelper();
                $id_video = $modyvh->getVideoId($elmodificado);
                $mivideo = new Ejercicios_videos(NULL, $id_ejercicio, $id_video);
                $mivideo->insertar();
            }
        }
        //obtengo los id de las preguntas del ejercicio
        $id_preguntas = array();

        $mis_preguntas = new Ejercicios_texto_texto_preg();

        $id_preguntas = $mis_preguntas->obtener_todas_preguntas_ejercicicio($id_ejercicio);
        //borro las respuestas

        for ($s = 0; $s < sizeof($id_preguntas); $s++) {
            delete_records('ejercicios_texto_texto_resp', 'id_pregunta', $id_preguntas[$s]->get('id'));
        }

        //borro las preguntas
        delete_records('ejercicios_texto_texto_preg', 'id_ejercicio', $id_ejercicio);

        //leo un ejercicio y lo guardo
        for ($i = 0; $i < $num_preg; $i++) {
            //Obtengo el numero de respuestas a cada pregunta
            $j = $i + 1;

            $preg = required_param('pregunta' . $j, PARAM_TEXT);

            $numresp = required_param('num_res_preg' . $j, PARAM_TEXT);
            //Añado la pregunta
            $ejercicio_texto_preg = new Ejercicios_texto_texto_preg(NULL, $id_ejercicio, $preg);
            $id_pregunta = $ejercicio_texto_preg->insertar();

            for ($k = 0; $k < $numresp; $k++) {
                $l = $k + 1;
                $resp = required_param('respuesta' . $l . "_" . $j, PARAM_TEXT);

                $correcta = required_param('valorcorrecta' . $l . "_" . $j, PARAM_INT);

                $ejercicio_texto_resp = new Ejercicios_texto_texto_resp(NULL, $id_pregunta, $resp, $correcta);
                $ejercicio_texto_resp->insertar();
            }
            commit_sql();
        }
        redirect('./view.php?id=' . $id_curso . '&opcion=9');
    }
}
?>
