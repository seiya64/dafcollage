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

//código copiado de Multiple Choice
global $USER;
global $CFG;

/* * ****************************************************************************
 * ******************************************************************************
 *        CARGA DE DATOS DE SESIÓN Y VARIABLES AUXILIARES DEL FORMULARIO       *
 * ******************************************************************************
 * **************************************************************************** */

$buscar = $_SESSION['buscar'];
$id_curso = $_SESSION['id_curso'];
$fuentes = optional_param('fuentes', PARAM_TEXT);
$tipocreacion = optional_param('tipocreacion', 0, PARAM_INT);
$tipo_origen = optional_param('tipo_origen', 0, PARAM_INT);
$numText = optional_param('numText', PARAM_TEXT);

//bucle para recoger campo hidden de numero de palabras ocultadas en cada una de los textos
$numPalabras = array();
for ($i = 1; $i <= $numText; $i++){
    $numPalabras[$i]=optional_param('num_palabras'.$i.'', 0, PARAM_INT);
}

//Se comprueba si se ha subido una foto al ejercicio
$path = $CFG->dataroot.'/'.$USER->id.'/';
$name = substr(md5($USER->id), 0, 10);
$foto=0;
if(file_exists($path.$name)) {
    $foto=1;
}

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

/* * ****************************************************************************
 * ******************************************************************************
 *                            FIN CARGA DE DATOS                               *
 * ******************************************************************************
 * **************************************************************************** */

//SE ESTA CREANDO EL EJERCICIO
if($buscar==0) {
    $ejercicioGeneral = unserialize($_SESSION['ejercicioGeneral']); // Datos generales del ejercicio
    $carpeta = unserialize($_SESSION['cosasProfe']); // Carpeta del profesor
    
    // Se procede a insertar en la base de datos el ejercicio, comenzando por su descripción general
    $ejercicioGeneral->set_fuentes($fuentes);
    $ejercicioGeneral->set_visibilidad($visible);
    $ejercicioGeneral->set_privacidad($privado);
    $ejercicioGeneral->set_foto($foto);

    $idEjercicio = $ejercicioGeneral->insertar();
  
    //la foto no ha sido modificada por lo tanto cargo lo que hubiera
    if($foto == 0) {
        $foto=$ejercicioGeneral->get("foto_asociada");
    } else { //la foto ha sido modificada asi que la guardo con el nuevo nombre
        //el USER->id siempre es el creador de ejercicio, no puede modificarlo nadie mas
        $origen = $CFG->dataroot . '/' . $USER->id . '/' . substr(md5($USER->id), 0, 10);
        $destino = $CFG->dataroot . '/' . $USER->id . '/' . substr(md5($idEjercicio), 0, 10);
        
        // Se renombra la foto con el md5 del id del ejercicio
        rename($origen, $destino);
    }

    // Se asocia al profesor creador
    $ejercicio_profesor = new Ejercicios_prof_actividad($id_curso, $USER->id, $idEjercicio, $carpeta);
    $ejercicio_profesor->insertar();
    //Para guardar los textos y las palabras
    //$i -> referido al texto   $j -> referido a la palabra dentro del texto
    for ($i = 1; $i <= $numText; $i++){
        $texto = optional_param("id_original".$i, PARAM_TEXT);
        $textoHuecos = optional_param("id_pregunta".$i, PARAM_TEXT);
        $nuevotexto = new Ejercicios_textos(NULL, $idEjercicio, $texto, $textoHuecos);
        $idTexto = $nuevotexto->insertar();
        for ($j=1; $j <= $numPalabras[$i]; $j++){
            $palabra = optional_param("palabra".$i.$j, PARAM_TEXT);
            $pista = optional_param("pista".$i.$j, PARAM_INT);
            $longitud = optional_param("longitud".$i.$j, PARAM_INT);
            $solucion = optional_param("solucion".$i.$j, PARAM_INT);
            $campoPista = optional_param("campo".$i.$j, PARAM_INT);
            $start = optional_param("start".$i.$j, PARAM_TEXT);
            $nuevapalabra = new Ejercicios_texto_hueco( NULL, $idEjercicio, $idTexto, $pista, $longitud, $solucion, $palabra, $campoPista, $start);
            $nuevapalabra->insertar(); 
        }
    }
} else {
    // Se obtiene el identificador del ejercicio
    $idEjercicio = $_SESSION['id_ejercicio'];
    $ejercicios_bd = new Ejercicios_general();
    $ejercicios_leido = $ejercicios_bd->obtener_uno($idEjercicio);

    //Se comprueba si ya existia foto asociada
    $path = $CFG->dataroot.'/'.$USER->id.'/';
    $name = substr(md5($idEjercicio), 0, 10);
    if(file_exists($path.$name)) {
        $foto=1;
    }

    $ejercicios_leido->set_fuentes($fuentes);
    $ejercicios_leido->set_visibilidad($visible);
    $ejercicios_leido->set_numpregunta($num_preg);
    $ejercicios_leido->set_privacidad($privado);
    $ejercicios_leido->set_foto($foto);
    $ejercicios_leido->alterar();

    //el USER->id siempre es el creador, no puede modificarlo nadie mas
    $origen = $CFG->dataroot . '/' . $USER->id . '/' . substr(md5($USER->id), 0, 10);
    $destino = $CFG->dataroot . '/' . $USER->id . '/' . substr(md5($idEjercicio), 0, 10);

    // Se copia la imagen definitiva del ejercicio a la carpeta destinada a ello
    rename($origen, $destino);
    
    //Se eliminan tanto los textos como las palabras asociadas al ejercicio para insertarlas de nuevo
    $textos = new Ejercicios_textos();
    $textos->borrar_id_ejercicio($idEjercicio);
    
    $palabras = new Ejercicios_texto_hueco();
    $palabras->borrar_id_ejercicio($idEjercicio);
    
    //Para guardar los textos y las palabras
    //$i -> referido al texto   $j -> referido a la palabra dentro del texto
    for ($i = 1; $i <= $numText; $i++){
        $texto = optional_param("id_original".$i, PARAM_TEXT);
        $textoHuecos = optional_param("id_pregunta".$i, PARAM_TEXT);
        $nuevotexto = new Ejercicios_textos(NULL, $idEjercicio, $texto, $textoHuecos);
        $idTexto = $nuevotexto->insertar();
        for ($j=1; $j <= $numPalabras[$i]; $j++){
            $palabra = optional_param("palabra".$i.$j, PARAM_TEXT);
            $pista = optional_param("pista".$i.$j, PARAM_INT);
            $longitud = optional_param("longitud".$i.$j, PARAM_INT);
            $solucion = optional_param("solucion".$i.$j, PARAM_INT);
            $campoPista = optional_param("campo".$i.$j, PARAM_INT);
            $start = optional_param("start".$i.$j, PARAM_TEXT);
            $nuevapalabra = new Ejercicios_texto_hueco( NULL, $idEjercicio, $idTexto, $pista, $longitud, $solucion, $palabra, $campoPista, $start);
            $nuevapalabra->insertar(); 
        }
    }
}
redirect('./view.php?id=' . $id_curso . '&opcion=9');
?>
