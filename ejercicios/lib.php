<?php

// $Id: lib.php,v 1.7.2.5 2009/04/22 21:30:57 skodak Exp $

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
  Ángel Biedma Mesa (tekeiro@gmail.com)
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

$ejercicios_EXAMPLE_CONSTANT = 42;     /// for example

require_once('mod_form.php');
require_once('ejercicios_form_creacion.php');
require_once('ejercicios_form_misejercicios.php');
require_once('ejercicios_form_buscar.php');
require_once('ejercicios_form_mostrar.php');
require_once('ejercicios_form_curso.php');
require_once('ejercicios_mostrar_asociacion_simple.php');
require_once('ejercicios_mostrar_asociacion_multiple.php');
require_once('ejercicios_mostrar_identificar_elementos.php');
require_once('ejercicios_mostrar_texto_hueco.php');
require_once('ejercicios_mostrar_ordenar_elementos.php');
require_once('ejercicios_mostrar_ierc.php');

/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will create a new instance and return the id number
 * of the new instance.
 *
 * @param object $ejercicios An object from the form in mod_form.php
 * @return int The id of the newly inserted ejercicios record
 */
function ejercicios_add_instance($ejercicios) {

    $ejercicios->timecreated = time();

    # You may have to add extra stuff in here #

    return insert_record('ejercicios', $ejercicios);
}

/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will update an existing instance with new data.
 *
 * @param object $ejercicios An object from the form in mod_form.php
 * @return boolean Success/Fail
 */
function ejercicios_update_instance($ejercicios) {

    $ejercicios->timemodified = time();
    $ejercicios->id = $ejercicios->instance;

    # You may have to add extra stuff in here #

    return update_record('ejercicios', $ejercicios);
}

/**
 * Given an ID of an instance of this module,
 * this function will permanently delete the instance
 * and any data that depends on it.
 *
 * @param int $id Id of the module instance
 * @return boolean Success/Failure
 */
function ejercicios_delete_instance($id) {

    if (!$ejercicios = get_record('ejercicios', 'id', $id)) {
        return false;
    }

    $result = true;

    # Delete any dependent records here #

    if (!delete_records('ejercicios', 'id', $ejercicios->id)) {
        $result = false;
    }

    return $result;
}

/**
 * Return a small object with summary information about what a
 * user has done with a given particular instance of this module
 * Used for user activity reports.
 * $return->time = the time they did it
 * $return->info = a short text description
 *
 * @return null
 * @todo Finish documenting this function
 */
function ejercicios_user_outline($course, $user, $mod, $ejercicios) {
    return $return;
}

/**
 * Print a detailed representation of what a user has done with
 * a given particular instance of this module, for user activity reports.
 *
 * @return boolean
 * @todo Finish documenting this function
 */
function ejercicios_user_complete($course, $user, $mod, $ejercicios) {
    return true;
}

/**
 * Given a course and a time, this module should find recent activity
 * that has occurred in ejercicios activities and print it out.
 * Return true if there was output, or false is there was none.
 *
 * @return boolean
 * @todo Finish documenting this function
 */
function ejercicios_print_recent_activity($course, $isteacher, $timestart) {
    return false;  //  True if anything was printed, otherwise false
}

/**
 * Function to be run periodically according to the moodle cron
 * This function searches for things that need to be done, such
 * as sending out mail, toggling flags etc ...
 *
 * @return boolean
 * @todo Finish documenting this function
 * */
function ejercicios_cron() {
    return true;
}

/**
 * Must return an array of user records (all data) who are participants
 * for a given instance of ejercicios. Must include every user involved
 * in the instance, independient of his role (student, teacher, admin...)
 * See other modules as example.
 *
 * @param int $ejerciciosid ID of an instance of this module
 * @return mixed boolean/array of students
 */
function ejercicios_get_participants($ejerciciosid) {
    return false;
}

/**
 * This function returns if a scale is being used by one ejercicios
 * if it has support for grading and scales. Commented code should be
 * modified if necessary. See forum, glossary or journal modules
 * as reference.
 *
 * @param int $ejerciciosid ID of an instance of this module
 * @return mixed
 * @todo Finish documenting this function
 */
function ejercicios_scale_used($ejerciciosid, $scaleid) {
    $return = false;

    //$rec = get_record("ejercicios","id","$ejerciciosid","scale","-$scaleid");
    //
    //if (!empty($rec) && !empty($scaleid)) {
    //    $return = true;
    //}

    return $return;
}

/**
 * Checks if scale is being used by any instance of ejercicios.
 * This function was added in 1.9
 *
 * This is used to find out if scale used anywhere
 * @param $scaleid int
 * @return boolean True if the scale is used by any ejercicios
 */
function ejercicios_scale_used_anywhere($scaleid) {
    if ($scaleid and record_exists('ejercicios', 'grade', -$scaleid)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Execute post-install custom actions for the module
 * This function was added in 1.9
 *
 * @return boolean true if success, false on error
 */
function ejercicios_install() {
    return true;
}

/**
 * Execute post-uninstall custom actions for the module
 * This function was added in 1.9
 *
 * @return boolean true if success, false on error
 */
function ejercicios_uninstall() {
    return true;
}

//////////////////////////////////////////////////////////////////////////////////////
/// Any other ejercicios functions go here.  Each of them must have a name that
/// starts with ejercicios_
/// Remember (see note in first lines) that, if this section grows, it's HIGHLY
/// recommended to move all funcions below to a new "localib.php" file.

function ejercicios_vista($id, $op = 0, $error = -1, $name_ej, $tipo, $tipocreacion, $p = 1, $id_ejercicio, $ccl, $cta, $cdc, $cgr, $cic, $ctt, $buscar, $tipo_origen = null, $trespuesta = null) {
    global $CFG, $COURSE, $USER;
    $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);

    switch ($op) {
        default:
        case 0: //Interfaz principal de ejercicios tanto para alumno como para profesor
            $mform = new mod_ejercicios_mod_formulario($id);
            $mform->pintaropciones($id);
            break;

        case 5:// Pulsado botón crear por profesor en la Interfaz Principal
            $mform = new mod_ejercicios_creando_ejercicio($id);
            //Tipo creación indica el tipo, si es multiple choice (0), asociación simple (1), etc
            $mform->pintarformulario($id, $tipocreacion);
            break;

        case 7:// Segundo paso de creación de los ejercicios
            switch ($tipocreacion) {
                case 0: // Multiple Choice
                    $mform = new mod_ejercicios_mostrar_ejercicio($id, $p, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion);
                    $mform->mostrar_ejercicio($id, $p, $id_ejercicio, $tipo_origen, 0);
                    break;

                case 1: // Asociación Simple
                    $mform = new mod_ejercicios_creando_ejercicio_asociacion_simple($id, $p, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion);
                    $mform->pintarformularioasociacionsimple($id, $p, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion);
                    break;

                case 2: // Asociación Múltiple
                    $mform = new mod_ejercicios_creando_ejercicio_asociacion_multiple($id, $p, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion);
                    $mform->pintarformularioasociacionmultiple($id, $p, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion);
                    break;

                case 4: //Identificar elementos
                    //echo "Identificar elementos";
                    $mform = new mod_ejercicios_creando_ejercicio_identificar_elementos($id, $p, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion);
                    $mform->pintarformulario_identificarelementos($id, $p, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion);
                    break;
                case 3: //Texto Hueco 
                    //echo "Texto Hueco";
                    $mform = new mod_ejercicios_mostrar_ejercicio_texto_hueco($id, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion);
                    $mform->mostrar_ejercicio($id, $id_ejercicio, $tipo_origen, 0);
                    break;
                case 7: //Ordenar Elementos 
                    //echo "Ordenar Elementos";
//                    $mform = new mod_ejercicios_creando_ejercicio_identificar_elementos($id, $p, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion);
                    $mform = new mod_ejercicios_mostrar_ejercicio_ordenar_elementos($id, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion);
                    $mform->mostrar_ejercicio($id, $id_ejercicio, $tipo_origen, 0);
//                    $mform->pintarformulario_ordenarelementos($id, $p, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion);
                    break;
                case 8: //Identificar Elementos mas Respuesta Corta
                    $mform = new mod_ejercicios_creando_ejercicio_ierc($id, $p, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion);
                    $mform->pintarformulario_identificarelementos($id, $p, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion);
                    break;
            }
            break;

        case 6:// Pulsado botón Buscar tanto por alumno como por profesor
            $mform = new mod_ejercicios_mostrar_ejercicios_buscados($id);
            $mform->mostrar_ejercicios_buscados($id, $ccl, $cta, $cdc, $cgr, $cic, $ctt);
            break;

        case 8:// Mostrando ejercicios a profesores o a alumnos ejercicio ya creado
            $ejercicios_bd = new Ejercicios_general();
            $ejercicios_leido = $ejercicios_bd->obtener_uno($id_ejercicio);
            $tipocreacion = $ejercicios_leido->get('tipoactividad');

            switch ($tipocreacion) {
                case 0: //Multichoice texto-texto a profesores o a alumnos          
                    $mform = new mod_ejercicios_mostrar_ejercicio($id, $p, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion);
                    $mform->mostrar_ejercicio($id, $p, $id_ejercicio, $tipo_origen, 1);

                    break;
                case 1: // si es asociacion simple
                    //echo "mostrando ejercicio asociacion simple";
                    $mform = new mod_ejercicios_mostrar_ejercicio_asociacion_simple($id, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion);
                    $mform->mostrar_ejercicio_asociacion_simple($id, $id_ejercicio, $buscar, $tipo_origen, $trespuesta, $tipocreacion);
                    break;
                case 2: // si es asociacion multiple 
                    //echo "mostrando ejercicio asociacion multiple";
                    $mform = new mod_ejercicios_mostrar_ejercicio_asociacion_multiple($id, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion);
                    $mform->mostrar_ejercicio_asociacion_multiple($id, $id_ejercicio, $buscar, $tipo_origen, $trespuesta, $tipocreacion);
                    break;
                case 3: //si es Texto Hueco
                    //echo "mostrando ejercicio texto hueco";
                    $mform = new mod_ejercicios_mostrar_ejercicio_texto_hueco($id, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion);
                    $mform->mostrar_ejercicio($id, $id_ejercicio, $tipo_origen, 1);
                    break;
                case 4: // si es identificar elementos
                    //echo "mostrando ejercicio identificar elementos";
                    //echo "<br/>";
                    $mform = new mod_ejercicios_mostrar_identificar_elementos($id, $id_ejercicio, $tipo_origen);
                    //echo "CREADO IE";
                    $mform->mostrar_ejercicio_identificar_elementos($id, $id_ejercicio, $buscar, $tipo_origen);

                    break;
                case 7: //si es ordenar elementos
                    //echo "mostrando ejercicio texto hueco";
                    $mform = new mod_ejercicios_mostrar_ejercicio_ordenar_elementos($id, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion);
                    $mform->mostrar_ejercicio_ordenar_elementos($id, $id_ejercicio, $buscar, $tipo_origen, $trespuesta, $tipocreacion);
                    break;
                case 8: //si es IE mas RC
                    //echo "mostrando ejercicio IE+RC";
                    $mform = new mod_ejercicios_mostrar_ejercicio_ierc($id, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion);
                    $mform->mostrar_ejercicio_ierc($id, $id_ejercicio, $buscar, $tipo_origen, $trespuesta, $tipocreacion);
                    break;
            }
            break;

        case 9:// Mostrando mis ejercicios (ejercicios profesor) 
            $mform = new mod_ejercicios_mostrar_ejercicios_buscados($id);
            $mform->mostrar_ejercicios_profesor($id);
            break;
        
        case 10://  Mostrando los ejercicios del curso (INTERFAZ DEL ALUMNO)
            $mform = new mod_ejercicios_mostrar_ejercicios_buscados($id);
            $mform->mostrar_ejercicios_alumno($id);
            break;
    }
    
    $mform->display();
    return true;
}

?>
