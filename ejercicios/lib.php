<?php  // $Id: lib.php,v 1.7.2.5 2009/04/22 21:30:57 skodak Exp $

/**
 * Library of functions and constants for module ejercicios
 * This file should have two well differenced parts:
 *   - All the core Moodle functions, neeeded to allow
 *     the module to work integrated in Moodle.
 *   - All the ejercicios specific functions, needed
 *     to implement all the module logic. Please, note
 *     that, if the module become complex and this lib
 *     grows a lot, it's HIGHLY recommended to move all
 *     these module specific functions to a new php file,
 *     called "locallib.php" (see forum, quiz...). This will
 *     help to save some memory when Moodle is performing
 *     actions across all modules.
 */

/// (replace ejercicios with the name of your module and delete this line)

$ejercicios_EXAMPLE_CONSTANT = 42;     /// for example

require_once('ejercicios_form.php');
require_once('ejercicios_form_creacion.php');
require_once('ejercicios_form_mostrar.php');
require_once('ejercicios_form_misejercicios.php');
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
function ejercicios_vista($id, $op = 0,$error=-1,$name_ej,$tipo,$tipocreacion,$p=1,$id_ejercicio=0) {
    global $CFG, $COURSE, $USER;

    $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);
    
      switch ($op) {
        default:
        case 0: //ver las opciones
            $mform = new mod_ejercicios_mod_form($id);
            $mform->pintaropciones($id);
            break;
        case 1: //primer ejercicio (Puzzle Doble)
            $mform= new mod_ejercicios_puzzle_form($id);//llama a gestion_asociacion1.php
            $mform->pintarinterfaz($id,$error);
             break;
        case 2: //mostrar ejercicio creado(Puzzle Doble)
           
            $mform= new mod_ejercicios_hacer_puzzle_form($id,$name_ej,$tipo);//llama a gestion.php
            $mform->pintarejercicio($id,$name_ej,$tipo);
            break;
       case 3: //segundo paso del formulario
       
            $mform= new mod_ejercicios_puzzle_form_paso2($id,$name_ej);//llama a gestion.php
            $mform->pintarinterfaz2($id,$name_ej);
            break;
        case 4: //creando ejercicio por tema gramatica
            $mform= new  mod_vocabulario_creando_tema_palabras($id);
            break;
        case 5:// Pulsado botón crear por profesor 
            $mform= new  mod_ejercicios_creando_ejercicio($id);
            $mform->pintarformulario($id,$tipocreacion);
            break;
        case 6:// Pulsado botón Buscar tanto por alumno como por profesor
            echo "hola boton buscar";
            break;
        case 7:// Segundo paso del formulario caso texto-texto
           /* echo "segundo paso";
            echo "preguntas".$p;
            echo "resputestas".$r;
            echo "correctas".$c;
            echo "id_ejercicio".$id_ejercicio;*/
            $mform= new mod_ejercicios_creando_ejercicio_texto($id,$p,$id_ejercicio);
            $mform->pintarformulariotexto($id,$p,$id_ejercicio);
           
            break;
        
         case 8:// Mostrando ejercicio Multichoice texto-texto
               
             $mform= new mod_ejercicios_mostrar_ejercicio($id,$id_ejercicio);
             $mform->mostrar_ejercicio($id,$id_ejercicio);
           
            break;
        
         case 9:// Mostrando mis ejercicios (ejercicios profesor)
             
             $mform= new mod_ejercicios_mis_ejercicios($id);
             $mform->pintaropciones($id);
             
           
            break;
        
      }
    
    
         $mform->display();
    return true;
}


?>
