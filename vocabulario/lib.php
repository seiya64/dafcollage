<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Library of interface functions and constants for module vocabulario
 *
 * All the core Moodle functions, neeeded to allow the module to work
 * integrated in Moodle should be placed here.
 * All the vocabulario specific functions, needed to implement all the module
 * logic, should go to locallib.php. This will help to save some memory when
 * Moodle is performing actions across all modules.
 *
 * @package    mod_vocabulario
 * @copyright  2011 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once ($CFG->libdir.'/formslib.php');
require_once('vocabulario_formularios.php');


defined('MOODLE_INTERNAL') || die();
define('__SEPARADORCAMPOS__', '$FIELD$');
/** example constant */
//define('NEWMODULE_ULTIMATE_ANSWER', 42);

////////////////////////////////////////////////////////////////////////////////
// Moodle core API                                                            //
////////////////////////////////////////////////////////////////////////////////

/**
 * Returns the information on whether the module supports a feature
 *
 * @see plugin_supports() in lib/moodlelib.php
 * @param string $feature FEATURE_xx constant for requested feature
 * @return mixed true if the feature is supported, null if unknown
 */
function vocabulario_supports($feature) {
    switch($feature) {
        case FEATURE_MOD_INTRO:         return true;
        case FEATURE_SHOW_DESCRIPTION:  return true;

        default:                        return null;
    }
}

/**
 * Saves a new instance of the vocabulario into the database
 *
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will create a new instance and return the id number
 * of the new instance.
 *
 * @param object $vocabulario An object from the form in mod_form.php
 * @param mod_vocabulario_mod_form $mform
 * @return int The id of the newly inserted vocabulario record
 */
function vocabulario_add_instance(stdClass $vocabulario, mod_vocabulario_mod_form $mform = null) {
    global $DB;

    $vocabulario->timecreated = time();

    # You may have to add extra stuff in here #

    return $DB->insert_record('vocabulario', $vocabulario);
}

/**
 * Updates an instance of the vocabulario in the database
 *
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will update an existing instance with new data.
 *
 * @param object $vocabulario An object from the form in mod_form.php
 * @param mod_vocabulario_mod_form $mform
 * @return boolean Success/Fail
 */
function vocabulario_update_instance(stdClass $vocabulario, mod_vocabulario_mod_form $mform = null) {
    global $DB;

    $vocabulario->timemodified = time();
    $vocabulario->id = $vocabulario->instance;

    # You may have to add extra stuff in here #

    return $DB->update_record('vocabulario', $vocabulario);
}

/**
 * Removes an instance of the vocabulario from the database
 *
 * Given an ID of an instance of this module,
 * this function will permanently delete the instance
 * and any data that depends on it.
 *
 * @param int $id Id of the module instance
 * @return boolean Success/Failure
 */
function vocabulario_delete_instance($id) {
    global $DB;

    if (! $vocabulario = $DB->get_record('vocabulario', array('id' => $id))) {
        return false;
    }

    # Delete any dependent records here #

    $DB->delete_records('vocabulario', array('id' => $vocabulario->id));

    return true;
}

/**
 * Returns a small object with summary information about what a
 * user has done with a given particular instance of this module
 * Used for user activity reports.
 * $return->time = the time they did it
 * $return->info = a short text description
 *
 * @return stdClass|null
 */
function vocabulario_user_outline($course, $user, $mod, $vocabulario) {

    $return = new stdClass();
    $return->time = 0;
    $return->info = '';
    return $return;
}

/**
 * Prints a detailed representation of what a user has done with
 * a given particular instance of this module, for user activity reports.
 *
 * @param stdClass $course the current course record
 * @param stdClass $user the record of the user we are generating report for
 * @param cm_info $mod course module info
 * @param stdClass $vocabulario the module instance record
 * @return void, is supposed to echp directly
 */
function vocabulario_user_complete($course, $user, $mod, $vocabulario) {
}

/**
 * Given a course and a time, this module should find recent activity
 * that has occurred in vocabulario activities and print it out.
 * Return true if there was output, or false is there was none.
 *
 * @return boolean
 */
function vocabulario_print_recent_activity($course, $viewfullnames, $timestart) {
    return false;  //  True if anything was printed, otherwise false
}

/**
 * Prepares the recent activity data
 *
 * This callback function is supposed to populate the passed array with
 * custom activity records. These records are then rendered into HTML via
 * {@link vocabulario_print_recent_mod_activity()}.
 *
 * @param array $activities sequentially indexed array of objects with the 'cmid' property
 * @param int $index the index in the $activities to use for the next record
 * @param int $timestart append activity since this time
 * @param int $courseid the id of the course we produce the report for
 * @param int $cmid course module id
 * @param int $userid check for a particular user's activity only, defaults to 0 (all users)
 * @param int $groupid check for a particular group's activity only, defaults to 0 (all groups)
 * @return void adds items into $activities and increases $index
 */
function vocabulario_get_recent_mod_activity(&$activities, &$index, $timestart, $courseid, $cmid, $userid=0, $groupid=0) {
}

/**
 * Prints single activity item prepared by {@see vocabulario_get_recent_mod_activity()}

 * @return void
 */
function vocabulario_print_recent_mod_activity($activity, $courseid, $detail, $modnames, $viewfullnames) {
}

/**
 * Function to be run periodically according to the moodle cron
 * This function searches for things that need to be done, such
 * as sending out mail, toggling flags etc ...
 *
 * @return boolean
 * @todo Finish documenting this function
 **/
function vocabulario_cron () {
    return true;
}

/**
 * Returns all other caps used in the module
 *
 * @example return array('moodle/site:accessallgroups');
 * @return array
 */
function vocabulario_get_extra_capabilities() {
    return array();
}

////////////////////////////////////////////////////////////////////////////////
// Gradebook API                                                              //
////////////////////////////////////////////////////////////////////////////////

/**
 * Is a given scale used by the instance of vocabulario?
 *
 * This function returns if a scale is being used by one vocabulario
 * if it has support for grading and scales. Commented code should be
 * modified if necessary. See forum, glossary or journal modules
 * as reference.
 *
 * @param int $vocabularioid ID of an instance of this module
 * @return bool true if the scale is used by the given vocabulario instance
 */
function vocabulario_scale_used($vocabularioid, $scaleid) {
    global $DB;

    /** @example */
    if ($scaleid and $DB->record_exists('vocabulario', array('id' => $vocabularioid, 'grade' => -$scaleid))) {
        return true;
    } else {
        return false;
    }
}

/**
 * Checks if scale is being used by any instance of vocabulario.
 *
 * This is used to find out if scale used anywhere.
 *
 * @param $scaleid int
 * @return boolean true if the scale is used by any vocabulario instance
 */
function vocabulario_scale_used_anywhere($scaleid) {
    global $DB;

    /** @example */
    if ($scaleid and $DB->record_exists('vocabulario', array('grade' => -$scaleid))) {
        return true;
    } else {
        return false;
    }
}

/**
 * Creates or updates grade item for the give vocabulario instance
 *
 * Needed by grade_update_mod_grades() in lib/gradelib.php
 *
 * @param stdClass $vocabulario instance object with extra cmidnumber and modname property
 * @param mixed optional array/object of grade(s); 'reset' means reset grades in gradebook
 * @return void
 */
function vocabulario_grade_item_update(stdClass $vocabulario, $grades=null) {
    global $CFG;
    require_once($CFG->libdir.'/gradelib.php');

    /** @example */
    $item = array();
    $item['itemname'] = clean_param($vocabulario->name, PARAM_NOTAGS);
    $item['gradetype'] = GRADE_TYPE_VALUE;
    $item['grademax']  = $vocabulario->grade;
    $item['grademin']  = 0;

    grade_update('mod/vocabulario', $vocabulario->course, 'mod', 'vocabulario', $vocabulario->id, 0, null, $item);
}

/**
 * Update vocabulario grades in the gradebook
 *
 * Needed by grade_update_mod_grades() in lib/gradelib.php
 *
 * @param stdClass $vocabulario instance object with extra cmidnumber and modname property
 * @param int $userid update grade of specific user only, 0 means all participants
 * @return void
 */
function vocabulario_update_grades(stdClass $vocabulario, $userid = 0) {
    global $CFG, $DB;
    require_once($CFG->libdir.'/gradelib.php');

    /** @example */
    $grades = array(); // populate array of grade objects indexed by userid

    grade_update('mod/vocabulario', $vocabulario->course, 'mod', 'vocabulario', $vocabulario->id, 0, $grades);
}

////////////////////////////////////////////////////////////////////////////////
// File API                                                                   //
////////////////////////////////////////////////////////////////////////////////

/**
 * Returns the lists of all browsable file areas within the given module context
 *
 * The file area 'intro' for the activity introduction field is added automatically
 * by {@link file_browser::get_file_info_context_module()}
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param stdClass $context
 * @return array of [(string)filearea] => (string)description
 */
function vocabulario_get_file_areas($course, $cm, $context) {
    return array();
}

/**
 * File browsing support for vocabulario file areas
 *
 * @package mod_vocabulario
 * @category files
 *
 * @param file_browser $browser
 * @param array $areas
 * @param stdClass $course
 * @param stdClass $cm
 * @param stdClass $context
 * @param string $filearea
 * @param int $itemid
 * @param string $filepath
 * @param string $filename
 * @return file_info instance or null if not found
 */
function vocabulario_get_file_info($browser, $areas, $course, $cm, $context, $filearea, $itemid, $filepath, $filename) {
    return null;
}

/**
 * Serves the files from the vocabulario file areas
 *
 * @package mod_vocabulario
 * @category files
 *
 * @param stdClass $course the course object
 * @param stdClass $cm the course module object
 * @param stdClass $context the vocabulario's context
 * @param string $filearea the name of the file area
 * @param array $args extra arguments (itemid, path)
 * @param bool $forcedownload whether or not force download
 * @param array $options additional options affecting the file serving
 */
function vocabulario_pluginfile($course, $cm, $context, $filearea, array $args, $forcedownload, array $options=array()) {
    global $DB, $CFG;

    if ($context->contextlevel != CONTEXT_MODULE) {
        send_file_not_found();
    }

    require_login($course, true, $cm);

    send_file_not_found();
}

////////////////////////////////////////////////////////////////////////////////
// Navigation API                                                             //
////////////////////////////////////////////////////////////////////////////////

/**
 * Extends the global navigation tree by adding vocabulario nodes if there is a relevant content
 *
 * This can be called by an AJAX request so do not rely on $PAGE as it might not be set up properly.
 *
 * @param navigation_node $navref An object representing the navigation tree node of the vocabulario module instance
 * @param stdClass $course
 * @param stdClass $module
 * @param cm_info $cm
 */
function vocabulario_extend_navigation(navigation_node $navref, stdclass $course, stdclass $module, cm_info $cm) {
}

/**
 * Extends the settings navigation with the vocabulario settings
 *
 * This function is called when the context for the page is a vocabulario module. This is not called by AJAX
 * so it is safe to rely on the $PAGE.
 *
 * @param settings_navigation $settingsnav {@link settings_navigation}
 * @param navigation_node $vocabularionode {@link navigation_node}
 */
function vocabulario_extend_settings_navigation(settings_navigation $settingsnav, navigation_node $vocabularionode=null) {
}


////////////////////////////////////////////////////////////////////////////////
// FUNCIONES PROPIAS                                                          //
////////////////////////////////////////////////////////////////////////////////

/**
 * Return a suffix depending on current user language
 *
 * @return string The suffix for tables according to the current language
 * */
function get_sufijo_lenguaje_tabla() {

    $lenguaje = current_language();
    
    $sufijos = array('es', 'en', 'pl', 'de', 'fr');

    if (in_array($lenguaje, $sufijos)) 
         $sufijotabla = $lenguaje;   
    else 
        $sufijotabla = "es";
    

    return $sufijotabla;
}

/**
 * Return all suffix for tables in database that depends on language
 *
 * @return array All suffix for tables in database
 */
function get_todos_sufijos_lenguaje() {
    $sufijos = array('es', 'en', 'pl', 'de', 'fr');

    return $sufijos;
}


function vocabulario_view($id, $opcion = 0, $id_mp = null,$palabra="",$viene=0) {
    global $CFG, $COURSE, $USER;

   $context = context_course::instance($COURSE->id);

    switch ($opcion) {
        default:
        case 0: //ver las opciones
            $mform = new mod_vocabulario_opciones_form();
            $mform->aniadircosas($id);
            break;
        case 1: //rellenar el formulario
            $mform = new mod_vocabulario_rellenar_form('guardar.php?id_tocho=' . $id.'?'.$palabra);
            break;
        case 2: //ver las palabras            
            $mform = new mod_vocabulario_ver_form('ver.php?id_tocho=' . $id);            
            break;
        case 3: //guardar campo lexico
            $mform = new mod_vocabulario_nuevo_cl_form('guardar_cl.php?id_tocho=' . $id);
            break;
        case 4: //actualizar el formulario
            $mform = new mod_vocabulario_rellenar_form('guardar.php?id_tocho=' . $id . '&act=1&viene='.$viene);
            break;
        case 5: //guardar gramatica
            $mform = new mod_vocabulario_nuevo_gr_form('guardar_gr.php?id_tocho=' . $id);
            break;
        case 6: //guardar gramatica particular
            $mform = new mod_vocabulario_gramatica_desc_form('guardar_gr_desc.php?id_tocho=' . $id, '&id_mp=' . $id_mp);
            break;
        case 7: //guardar intencion comunicativa
            $mform = new mod_vocabulario_nuevo_ic_form('guardar_ic.php?id_tocho=' . $id);
            break;
        case 8: //guardar intencion comunicativa particular
            $mform = new mod_vocabulario_intencion_desc_form('guardar_ic_desc.php?id_tocho=' . $id, '&id_mp=' . $id_mp);
            break;
        case 9: //guardar tipologia textual
            $mform = new mod_vocabulario_nuevo_tipologia_form('guardar_tt.php?id_tocho=' . $id);
            break;
        case 10: //guardar tipologia textual particular
            $mform = new mod_vocabulario_tipologia_desc_form('guardar_tt_desc.php?id_tocho=' . $id, '&id_mp=' . $id_mp);
            break;
        case 11: //ver estrategias de aprendizaje
            $mform = new mod_vocabulario_nuevo_estrategia_form('guardar_ea.php?id_tocho=' . $id);
            break;
        case 12: //guardar estrategia nueva
            $mform = new mod_vocabulario_estrategia_desc_form('guardar_ea_desc.php?id_tocho=' . $id, '&id_mp=' . $id_mp);
            break;
        case 13:
            $mform = new mod_vocabulario_listado_form('listado.php?id_tocho=' . $id);
            break;
        case 14: //imprimir apuntes en pdf
            $mform = new mod_vocabulario_pdf_form('pdf.php?id_tocho=' . $id);
            break;
        case 15: //a�adir gramatica
            $mform = new mod_vocabulario_aniadir_gr_form('guardar_gr_desc.php?id_tocho=' . $id);
            break;
        case 16: // colaboradores
            $mform = new mod_vocabulario_colaboradores_form('listado.php?id_tocho=' . $id);
            break;
        case 17: //Buscar por intenciones comunicativas
            $mform = new mod_vocabulario_buscar_intenciones_form('buscarintenciones.php?id_tocho='.$id);
            break;
        case 18:
            $mform = new mod_vocabulario_entrenador_configuracion_form('entrenador.php?id_tocho='.$id);
            break;
        case 19:
            $mform = new mod_vocabulario_entrenador_form('entrenador.php?id_tocho='.$id);
            break;
    }
    
    $mform->display();
}

//////////////////////////////////////////////////////////////////////////////////////
/// Any other vocabulario functions go here.  Each of them must have a name that 
/// starts with Vocabulario_

function vocabulario_obtener_alumnos($cursoid) {
    global $DB;
    $sql = "SELECT u.id usuario, u.firstname nombre, u.lastname apellidos ";
    $sql .= "FROM {groups_members} gm, {groups} g, {user} u ";
    $sql .= "WHERE g.id = gm.groupid AND u.id = gm.userid AND g.courseid = $cursoid";

    $mis_alumnos = $DB->get_record_sql($sql);

    return $mis_alumnos;
}


//////////////////////////////////////////////////////////////////////////////////////
/// Ejemplo de lo que debería obtener la secuencia sql: Ver al final de la página

function vocabulario_todas_palabras($usuarioid, $cl = null, $gram = null, $inten = null, $tipo = null, $letra = null) {
    global $CFG;
    global $DB;
   
    $sufijotabla = get_sufijo_lenguaje_tabla();

    $params = array('usuarioid' => $usuarioid, 'cl' => $cl, 'gram' => $gram, 'inten' => $inten, 'tipo' => $tipo, 'letra' => $letra, 'sufijotabla' => $sufijotabla);
    
    $sql = "";
    if ($letra) {
        $sql .= "SELECT * FROM (";
    }
   
    $sql .= "SELECT @a:=@a+1, todas.pal, todas.sig, cl.campo, gr.gramatica, ic.intencion, tt.tipo, todas.mpid, todas.icid,gr.id gramaticaid,ic.id intencionid,tt.id tiptexid ";    
    $sql .= "FROM (";
    $sql .= "(SELECT  mp.id mpid,`sustantivoid` sid,`palabra` pal,`campoid` clid,`gramaticaid` grid,`intencionid` icid,`tipologiaid` ttid, `significado` sig ";
    $sql .= "FROM ";
    if ($cl) {
        $sql .= "(SELECT * FROM {vocabulario_mis_palabras} WHERE campoid = $cl) mp,";
    } else {
        $sql .= "{vocabulario_mis_palabras} mp,";
    }
    if ($gram || $inten || $tipo) {
        $sql .= "(SELECT  * FROM {vocabulario_sustantivos} WHERE ";
        if ($gram) {
            $sql .= "gramaticaid = $gram AND ";
        }
        if ($inten) {
            $sql .= "intencionid = $inten AND ";
        }
        if ($tipo) {
            $sql .= "tipologiaid = $tipo AND ";
        }
        $sql .= "1) s ";
    } else {
        $sql .= "{vocabulario_sustantivos} s ";
    }
    $sql .= "WHERE `usuarioid` = $usuarioid AND mp.`sustantivoid` = s.`id`) ";
    $sql .= "UNION ALL ";
    $sql .= "(SELECT mp.id mpid, `adjetivoid` aid, `sin_declinar` pal, `campoid` clid, `gramaticaid` grid, `intencionid` icid, `tipologiaid` ttid, `significado` sig ";
    $sql .= "FROM ";
    if ($cl) {
        $sql .= "(SELECT * FROM {vocabulario_mis_palabras} WHERE campoid = $cl) mp,";
    } else {
        $sql .= "{vocabulario_mis_palabras} mp,";
    }
    if ($gram || $inten || $tipo) {
        $sql .= "(SELECT * FROM {vocabulario_adjetivos} WHERE ";
        if ($gram) {
            $sql .= "gramaticaid = $gram AND ";
        }
        if ($inten) {
            $sql .= "intencionid = $inten AND ";
        }
        if ($tipo) {
            $sql .= "tipologiaid = $tipo AND";
        }
        $sql .= "1) a ";
    } else {
        $sql .= "{vocabulario_adjetivos} a ";
    }
    $sql .= "WHERE `usuarioid` = $usuarioid AND mp.`adjetivoid` = a.`id` and a.`id` <> 1) ";
    $sql .= "UNION ALL ";
    $sql .= "(SELECT mp.id mpid, `verboid` vid, `infinitivo` pal, `campoid` clid, `gramaticaid` grid, `intencionid` icid, `tipologiaid` ttid, `significado` sig ";
    $sql .= "FROM ";
    if ($cl) {
        $sql .= "(SELECT * FROM {vocabulario_mis_palabras} WHERE campoid = $cl ) mp,";
    } else {
        $sql .= "{vocabulario_mis_palabras} mp,";
    }
    if ($gram || $inten || $tipo) {
        $sql .= "(SELECT * FROM {vocabulario_verbos} WHERE ";
        if ($gram) {
            $sql .= "gramaticaid = $gram AND ";
        }
        if ($inten) {
            $sql .= "intencionid = $inten AND ";
        }
        if ($tipo) {
            $sql .= "tipologiaid = $tipo AND ";
        }
        $sql .= "1) a ";
    } else {
        $sql .= "{vocabulario_verbos} a ";
    }
    $sql .= "WHERE `usuarioid` = $usuarioid AND mp.`verboid` = a.`id` and a.`id` <> 1) ";
    $sql .= "UNION ALL ";
    $sql .= "(SELECT mp.id mpid, `otroid` oid, `palabra` pal, `campoid` clid, `gramaticaid` grid, `intencionid` icid, `tipologiaid` ttid, `significado` sig ";
    $sql .= "FROM ";
    if ($cl) {
        $sql .= "(SELECT * FROM {vocabulario_mis_palabras} WHERE campoid = $cl) mp,";
    } else {
        $sql .= "{vocabulario_mis_palabras} mp,";
    }
    if ($gram || $inten || $tipo) {
        $sql .= "(SELECT * FROM {vocabulario_otros} WHERE ";
        if ($gram) {
            $sql .= "gramaticaid = $gram AND ";
        }
        if ($inten) {
            $sql .= "intencionid = $inten AND ";
        }
        if ($tipo) {
            $sql .= "tipologiaid = $tipo AND ";
        }
        $sql .= "1) a ";
    } else {
        $sql .= "{vocabulario_otros} a ";
    }
    
    $sql .= "WHERE `usuarioid` = $usuarioid AND mp.`otroid` = a.`id` and a.`id` <> 1) ";
    $sql .= "ORDER BY pal) todas,";
    $sql .= "{vocabulario_camposlexicos_$sufijotabla} cl, {vocabulario_gramatica} gr, {vocabulario_intenciones_$sufijotabla} ic, {vocabulario_tipologias_$sufijotabla} tt ";
    
    //$sql .= ", {vocabulario_sustantivos} sust, {vocabulario_adjetivos} adj, {vocabulario_verbos} verb, {vocabulario_otros} otros, {vocabulario_mis_palabras} mp ";
    $sql .= ", (SELECT @a:= 0) as xx ";
    $sql .= "WHERE todas.clid = cl.id and todas.grid = gr.id and todas.icid = ic.id and todas.ttid = tt.id";
    
    //$sql .= " and todas.mpid=mp.id and sust.id=mp.`sustantivoid` and adj.id=mp.`adjetivoid` and verb.id=mp.`verboid` and otros.id=mp.`otroid` ";

    if ($letra) {
        $sql .= ") p WHERE p.pal like '$letra%'";
    }
   
    //print_r($sql); die();
    $todas = $DB->get_records_sql($sql);

    $file_log = fopen("log_sql.txt", "w");
    $cad = "SQL: " . $sql . "\n\n\n";
    $cad.= "Error: " . mysql_error() . "\n\n";
    fwrite($file_log, $cad, strlen($cad));
    fclose($file_log);
    return $todas;
}


//Añadido al Select el significado LuisRedondo y RamónRueda.
function todas_palabras_nube($usrid) {
        
    global $DB;
    $sufijotabla = get_sufijo_lenguaje_tabla();
    
    $sql = "SELECT
        frase.id as mpid,
	sus.palabra as sus_lex,
        sus.significado as sus_sig,
	adj.sin_declinar as adj_lex,
        adj.significado as adj_sig,
	ver.infinitivo as ver_lex,
        ver.significado as ver_sig,
	otros.palabra as otros_lex,
	otros.significado as otros_sig,
        campos.campo as campo_lex

        FROM
        {vocabulario_mis_palabras}	as frase ,
	{vocabulario_sustantivos}	as sus,
	{vocabulario_adjetivos}	as adj,
	{vocabulario_verbos}	as ver,
	{vocabulario_otros}		as otros,
        {vocabulario_camposlexicos_$sufijotabla} as campos

        WHERE
            frase.`usuarioid` = $usrid AND 
            frase.`sustantivoid` = sus.`id`
            AND
            frase.`adjetivoid` = adj.`id`
            AND
            frase.`verboid` = ver.`id`
            AND
            frase.`otroid` = otros.`id`
            AND
            frase.`campoid` = campos.`id`
	";

    $file_log = fopen("log_sql.txt", "w");
    $cad = "SQL: " . $sql . "\n\n\n";
    $cad.= "Error: " . mysql_error() . "\n\n";
    fwrite($file_log, $cad, strlen($cad));
    fclose($file_log); 

    $todas = $DB->get_records_sql($sql);
   
       
    return $todas;
}


function todas_palabras_sustantivo($usrid) {
        
    global $DB;
    $sufijotabla = get_sufijo_lenguaje_tabla();
    
    $sql = "SELECT
        frase.id as mpid,
	sus.palabra as sus_lex,
        sus.significado as sus_sig,
        campos.campo as campo_lex

        FROM
        {vocabulario_mis_palabras}	as frase ,
	{vocabulario_sustantivos}	as sus,
        {vocabulario_camposlexicos_$sufijotabla} as campos

        WHERE
            frase.`usuarioid` = $usrid 
            AND 
            frase.`sustantivoid` = sus.`id`    
            AND
            frase.`campoid` = campos.`id`
	";

    $file_log = fopen("log_sql.txt", "w");
    $cad = "SQL: " . $sql . "\n\n\n";
    $cad.= "Error: " . mysql_error() . "\n\n";
    fwrite($file_log, $cad, strlen($cad));
    fclose($file_log); 

    $todas = $DB->get_records_sql($sql);
   
       
    return $todas;
}
function todas_palabras_adjetivo($usrid) {
        
    global $DB;
    $sufijotabla = get_sufijo_lenguaje_tabla();
    
    $sql = "SELECT
        frase.id as mpid,	
	adj.sin_declinar as adj_lex,
        adj.significado as adj_sig,
        campos.campo as campo_lex

        FROM
        {vocabulario_mis_palabras}	as frase ,
	{vocabulario_adjetivos}	as adj,
        {vocabulario_camposlexicos_$sufijotabla} as campos

        WHERE
            frase.`usuarioid` = $usrid 
            AND
            frase.`adjetivoid` = adj.`id`
            AND
            frase.`campoid` = campos.`id`
	";

    $file_log = fopen("log_sql.txt", "w");
    $cad = "SQL: " . $sql . "\n\n\n";
    $cad.= "Error: " . mysql_error() . "\n\n";
    fwrite($file_log, $cad, strlen($cad));
    fclose($file_log); 

    $todas = $DB->get_records_sql($sql);
   
       
    return $todas;
}
function todas_palabras_verbo($usrid) {
        
    global $DB;
    $sufijotabla = get_sufijo_lenguaje_tabla();
    
    $sql = "SELECT
        frase.id as mpid,
	ver.infinitivo as ver_lex,
        ver.significado as ver_sig,
        campos.campo as campo_lex

        FROM
        {vocabulario_mis_palabras}	as frase ,
	{vocabulario_verbos}	as ver,
        {vocabulario_camposlexicos_$sufijotabla} as campos

        WHERE
            frase.`usuarioid` = $usrid 
            AND
            frase.`verboid` = ver.`id`
            AND
            frase.`campoid` = campos.`id`
	";

    $file_log = fopen("log_sql.txt", "w");
    $cad = "SQL: " . $sql . "\n\n\n";
    $cad.= "Error: " . mysql_error() . "\n\n";
    fwrite($file_log, $cad, strlen($cad));
    fclose($file_log); 

    $todas = $DB->get_records_sql($sql);
   
       
    return $todas;
}
function todas_palabras_otras($usrid) {
        
    global $DB;
    $sufijotabla = get_sufijo_lenguaje_tabla();
    
    $sql = "SELECT
        frase.id as mpid,
	otros.palabra as otros_lex,
	otros.significado as otros_sig,
        campos.campo as campo_lex

        FROM
        {vocabulario_mis_palabras}	as frase ,
	{vocabulario_otros}		as otros,
        {vocabulario_camposlexicos_$sufijotabla} as campos

        WHERE
            frase.`usuarioid` = $usrid 
            AND
            frase.`otroid` = otros.`id`
            AND
            frase.`campoid` = campos.`id`
	";

    $file_log = fopen("log_sql.txt", "w");
    $cad = "SQL: " . $sql . "\n\n\n";
    $cad.= "Error: " . mysql_error() . "\n\n";
    fwrite($file_log, $cad, strlen($cad));
    fclose($file_log); 

    $todas = $DB->get_records_sql($sql);
   
       
    return $todas;
}




function todos_campos_lexicos($usrid){
    
    global $DB;
    $sufijotabla = get_sufijo_lenguaje_tabla();
    
     $sql = "
        SELECT
            table_campoLex.campo AS campo_lex,
            table_campoLex.id AS id

        FROM
            {vocabulario_camposlexicos_$sufijotabla} AS table_campoLex

        WHERE
            (table_campoLex.`usuarioid` = $usrid OR table_campoLex.`usuarioid` = 0)
            AND
            table_campoLex.`padre` = 0
	";
     
    $file_log = fopen("log_sql.txt", "w");
    $cad = "SQL: " . $sql . "\n\n\n";
    $cad.= "Error: " . mysql_error() . "\n\n";
    fwrite($file_log, $cad, strlen($cad));
    fclose($file_log); 

    $todos = $DB->get_records_sql($sql);
   
       
    return $todos;
    
}

//función para obtener las palabras de un determinado campo léxico
function campos_lexicos_especifico_sus($usrid, $tematica){
    
    global $DB;
    $sufijotabla = get_sufijo_lenguaje_tabla();
    
    $sql = "SELECT
        table_misPal.id as misPal_id,
	table_sus.palabra as sus_lex,
        table_sus.significado as sus_sig

        FROM
        {vocabulario_mis_palabras} AS table_misPal,
	{vocabulario_sustantivos} AS table_sus,
        {vocabulario_camposlexicos_$sufijotabla} AS table_campoLex

        WHERE
            table_misPal.`usuarioid` = $usrid 
            AND
            table_misPal.`sustantivoid` = table_sus.`id`
            AND
            table_misPal.`campoid` = $tematica
	";
    
     
    $file_log = fopen("log_sql.txt", "w");
    $cad = "SQL: " . $sql . "\n\n\n";
    $cad.= "Error: " . mysql_error() . "\n\n";
    fwrite($file_log, $cad, strlen($cad));
    fclose($file_log); 

    $todos = $DB->get_records_sql($sql);
   
       
    return $todos;
    
}

function campos_lexicos_especifico_adj($usrid, $tematica){
    
    global $DB;
    $sufijotabla = get_sufijo_lenguaje_tabla();
    
    $sql = "SELECT
        table_misPal.id as misPal_id,
	table_adj.sin_declinar as adj_lex,
        table_adj.significado as adj_sig


        FROM
        {vocabulario_mis_palabras} AS table_misPal ,
	{vocabulario_adjetivos} AS table_adj,
        {vocabulario_camposlexicos_$sufijotabla} AS table_campoLex

        WHERE
            table_misPal.`usuarioid` = $usrid
            AND
            table_misPal.`adjetivoid` = table_adj.`id`
            AND
            table_misPal.`campoid` = $tematica
	";
    
     
    $file_log = fopen("log_sql.txt", "w");
    $cad = "SQL: " . $sql . "\n\n\n";
    $cad.= "Error: " . mysql_error() . "\n\n";
    fwrite($file_log, $cad, strlen($cad));
    fclose($file_log); 

    $todos = $DB->get_records_sql($sql);
   
       
    return $todos;
    
}

function campos_lexicos_especifico_ver($usrid, $tematica){
    
    global $DB;
    $sufijotabla = get_sufijo_lenguaje_tabla();
    
    $sql = "SELECT
        table_misPal.id as misPal_id,
	table_ver.infinitivo as ver_lex,
	table_ver.significado as ver_sig

        FROM
        {vocabulario_mis_palabras} AS table_misPal ,
	{vocabulario_verbos} AS table_ver,
        {vocabulario_camposlexicos_$sufijotabla} AS table_campoLex

        WHERE
            table_misPal.`usuarioid` = $usrid 
            AND
            table_misPal.`verboid` = table_ver.`id`
            AND
            table_misPal.`campoid` = $tematica
	";
    
     
    $file_log = fopen("log_sql.txt", "w");
    $cad = "SQL: " . $sql . "\n\n\n";
    $cad.= "Error: " . mysql_error() . "\n\n";
    fwrite($file_log, $cad, strlen($cad));
    fclose($file_log); 

    $todos = $DB->get_records_sql($sql);
   
       
    return $todos;
    
}

function campos_lexicos_especifico_otro($usrid, $tematica){
    
    global $DB;
    $sufijotabla = get_sufijo_lenguaje_tabla();
    
    $sql = "SELECT
        table_misPal.id as misPal_id,
	table_otr.palabra as otros_lex,
	table_otr.significado as otros_sig

        FROM
        {vocabulario_mis_palabras} AS table_misPal ,
	{vocabulario_otros} AS table_otr,
        {vocabulario_camposlexicos_$sufijotabla} AS table_campoLex

        WHERE
            table_misPal.`usuarioid` = $usrid 
            AND
            table_misPal.`otroid` = table_otr.`id`
            AND
            table_misPal.`campoid` = $tematica
	";
    
     
    $file_log = fopen("log_sql.txt", "w");
    $cad = "SQL: " . $sql . "\n\n\n";
    $cad.= "Error: " . mysql_error() . "\n\n";
    fwrite($file_log, $cad, strlen($cad));
    fclose($file_log); 

    $todos = $DB->get_records_sql($sql);
   
       
    return $todos;
    
}



function obtener_superpadre($id){
    global $DB;
    $sufijotabla = get_sufijo_lenguaje_tabla();
    $sql = "SELECT `padre` FROM {vocabulario_intenciones_$sufijotabla} WHERE `id`=$id";
   // $sql .= "WHERE `id`=$id";
   
    $padre = $DB->get_records_sql($sql);
    
    foreach($padre as $papi){
        $numerico = $papi->padre;
    }
    if($numerico==0){
        return -1;          //devuelvo -1 si ya es un superpadre
    }else{
       return obtener_superpadre_bis($numerico); //en caso contrario buscamos el superpadre y devolvemos su nombre
    }
    
    
}

function obtener_superpadre_bis($id){
    global $DB;
    $sufijotabla = get_sufijo_lenguaje_tabla();
    
    $sql = "SELECT `padre`, `intencion` FROM {vocabulario_intenciones_$sufijotabla} ";
    $sql .= "WHERE `id`=$id";
    
    $padre = $DB->get_records_sql($sql);
    
    foreach ($padre as $pad){
        $padreid=$pad->padre;
        $padrenom=$pad->intencion;
    }
    if($padreid>0){
        $padrenom = obtener_superpadre_bis($padreid);
    }
    return $padrenom;
    
}

function vocabulario_rellenar_alumnos($cursoid) {
    //lectura de los campos lexicos disponibles
    $alumnos = vocabulario_obtener_alumnos($cursoid);
    $alum = array();

    foreach ($alumnos as $cosa) {
        $alum[$cosa->usuario] = $cosa->nombre . " " . $cosa->apellidos;
    }

    return $alum;
}

/*


SELECT @a:=@a+1, todas.pal, todas.sig, cl.campo, gr.gramatica, ic.intencion, tt.tipo, todas.mpid, todas.icid,gr.id gramaticaid,ic.id intencionid,tt.id tiptexid FROM ((SELECT mp.id mpid,`sustantivoid` sid,`palabra` pal,`campoid` clid,`gramaticaid` grid,`intencionid` icid,`tipologiaid` ttid, `significado` sig FROM mdl_vocabulario_mis_palabras mp, mdl_vocabulario_sustantivos s WHERE `usuarioid` = 2 AND mp.`sustantivoid` = s.`id`) UNION ALL (SELECT mp.id mpid, `adjetivoid` aid, `sin_declinar` pal, `campoid` clid, `gramaticaid` grid, `intencionid` icid, `tipologiaid` ttid, `significado` sig FROM mdl_vocabulario_mis_palabras mp, mdl_vocabulario_adjetivos a WHERE `usuarioid` = 2 AND mp.`adjetivoid` = a.`id` and a.`id` <> 1) UNION ALL (SELECT mp.id mpid, `verboid` vid, `infinitivo` pal, `campoid` clid, `gramaticaid` grid, `intencionid` icid, `tipologiaid` ttid, `significado` sig FROM mdl_vocabulario_mis_palabras mp, mdl_vocabulario_verbos a WHERE `usuarioid` = 2 AND mp.`verboid` = a.`id` and a.`id` <> 1) UNION ALL (SELECT mp.id mpid, `otroid` oid, `palabra` pal, `campoid` clid, `gramaticaid` grid, `intencionid` icid, `tipologiaid` ttid, `significado` sig FROM mdl_vocabulario_mis_palabras mp, mdl_vocabulario_otros a WHERE `usuarioid` = 2 AND mp.`otroid` = a.`id` and a.`id` <> 1) ORDER BY pal) todas,mdl_vocabulario_camposlexicos_es cl, mdl_vocabulario_gramatica gr,  mdl_vocabulario_intenciones_es ic, mdl_vocabulario_tipologias_es tt, (SELECT @a:= 0) AS a WHERE todas.clid = cl.id and todas.grid = gr.id and todas.icid = ic.id and todas.ttid = tt.id

*/
