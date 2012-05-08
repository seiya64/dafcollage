<?php  // $Id: lib.php,v 1.7.2.5 2009/04/22 21:30:57 skodak Exp $

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
  Serafina Molina Soto (finamolinasoto@gmail.com)
 
  Original idea and content design:
  Ruth Burbat
  Andrea Bies
  Julia Möller Runge
  Antonio Salmerón Matilla
  Karin Vilar Sánchez
  Inmaculada Almahano Güeto
  Blanca Rodríguez Gómez
  María José Varela Salinas

  This program is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License
  as published by the Free Software Foundation; either version 2
  of the License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details. */

require_once(dirname(__FILE__).'/mod_form.php');
/// (replace ejercicios with the name of your module and delete this line)

$ejercicios_EXAMPLE_CONSTANT = 42;     /// for example


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

    if (! $ejercicios = get_record('ejercicios', 'id', $id)) {
        return false;
    }

    $result = true;

    # Delete any dependent records here #

    if (! delete_records('ejercicios', 'id', $ejercicios->id)) {
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
 **/
function ejercicios_cron () {
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

function vocabulario_view($id, $opcion = 0, $id_mp = null) {
    global $CFG, $COURSE, $USER;

    $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);
    
     
     
      switch ($opcion) {
        default:
        case 0: //ver las opciones
            $mform = new mod_ejercicios_opciones_form();
            $mform->aniadircosas($id);
            break;
        case 1: //primer ejercicio (Puzzle Doble)
            echo "has elegido ejercicio 1";
            $mform = new COSA();
            break;
      
    }


     $mform->display();
}

/**
 * Return a suffix depending on current user language
 *
 * @return string The suffix for tables according to the current language
 * */
function get_sufijo_lenguaje_tabla() {

    $lenguaje = current_language();
    if ($lenguaje == "es_utf8") {
        $sufijotabla = "es";
    } else if ($lenguaje == "en_utf8") {
        $sufijotabla = "en";
    } else if ($lenguaje == "pl_utf8") {
        $sufijotabla = "pl";
    } else if ($lenguaje == "de_utf8") {
        $sufijotabla = "de";
    } else {
        $sufijotabla = "es";
    }

    return $sufijotabla;
}

/**
 * Return all suffix for tables in database that depends on language
 *
 * @return array All suffix for tables in database
 */
function get_todos_sufijos_lenguaje() {
    $sufijos = array('es', 'en', 'pl', 'de');

    return $sufijos;
}

?>
