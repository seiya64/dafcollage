<?php

// $Id: lib.php,v 1.4 2006/08/28 16:41:20 mark-nielsen Exp $
/**
 * Library of functions and constants for module vocabulario
 *
 * @author 
 * @version $Id: lib.php,v 1.4 2006/08/28 16:41:20 mark-nielsen Exp $
 * @package vocabulario
 * */
/// (replace vocabulario with the name of your module and delete this line)
//$vocabulario_CONSTANT = 7;     /// for example
require_once("$CFG->libdir/formslib.php");
require_once("vocabulario_formularios.php");

/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod.html) this function
 * will create a new instance and return the id number
 * of the new instance.
 *
 * @param object $instance An object from the form in mod.html
 * @return int The id of the newly inserted vocabulario record
 * */
function vocabulario_add_instance($vocabulario) {

    // temp added for debugging
    echo "ADD INSTANCE CALLED";
    // print_object($vocabulario);

    $vocabulario->timemodified = time();

    # May have to add extra stuff in here #

    return insert_record("vocabulario", $vocabulario);
}

/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod.html) this function
 * will update an existing instance with new data.
 *
 * @param object $instance An object from the form in mod.html
 * @return boolean Success/Fail
 * */
function vocabulario_update_instance($vocabulario) {

    $vocabulario->timemodified = time();
    $vocabulario->id = $vocabulario->instance;

    # May have to add extra stuff in here #

    return update_record("vocabulario", $vocabulario);
}

/**
 * Given an ID of an instance of this module,
 * this function will permanently delete the instance
 * and any data that depends on it.
 *
 * @param int $id Id of the module instance
 * @return boolean Success/Failure
 * */
function vocabulario_delete_instance($id) {

    if (!$vocabulario = get_record("vocabulario", "id", "$id")) {
        return false;
    }

    $result = true;

    # Delete any dependent records here #

    if (!delete_records("vocabulario", "id", "$vocabulario->id")) {
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
 * */
function vocabulario_user_outline($course, $user, $mod, $vocabulario) {
    return $return;
}

/**
 * Print a detailed representation of what a user has done with
 * a given particular instance of this module, for user activity reports.
 *
 * @return boolean
 * @todo Finish documenting this function
 * */
function vocabulario_user_complete($course, $user, $mod, $vocabulario) {
    return true;
}

/**
 * Given a course and a time, this module should find recent activity
 * that has occurred in vocabulario activities and print it out.
 * Return true if there was output, or false is there was none.
 *
 * @uses $CFG
 * @return boolean
 * @todo Finish documenting this function
 * */
function vocabulario_print_recent_activity($course, $isteacher, $timestart) {
    global $CFG;

    return false;  //  True if anything was printed, otherwise false 
}

/**
 * Function to be run periodically according to the moodle cron
 * This function searches for things that need to be done, such
 * as sending out mail, toggling flags etc ...
 *
 * @uses $CFG
 * @return boolean
 * @todo Finish documenting this function
 * */
function vocabulario_cron() {
    global $CFG;

    return true;
}

/**
 * Must return an array of grades for a given instance of this module,
 * indexed by user.  It also returns a maximum allowed grade.
 *
 * Example:
 *    $return->grades = array of grades;
 *    $return->maxgrade = maximum allowed grade;
 *
 *    return $return;
 *
 * @param int $vocabularioid ID of an instance of this module
 * @return mixed Null or object with an array of grades and with the maximum grade
 * */
function vocabulario_grades($vocabularioid) {
    return NULL;
}

/**
 * Must return an array of user records (all data) who are participants
 * for a given instance of vocabulario. Must include every user involved
 * in the instance, independient of his role (student, teacher, admin...)
 * See other modules as example.
 *
 * @param int $vocabularioid ID of an instance of this module
 * @return mixed boolean/array of students
 * */
function vocabulario_get_participants($vocabularioid) {
    return false;
}

/**
 * This function returns if a scale is being used by one vocabulario
 * it it has support for grading and scales. Commented code should be
 * modified if necessary. See forum, glossary or journal modules
 * as reference.
 *
 * @param int $vocabularioid ID of an instance of this module
 * @return mixed
 * @todo Finish documenting this function
 * */
function vocabulario_scale_used($vocabularioid, $scaleid) {
    $return = false;

    //$rec = get_record("vocabulario","id","$vocabularioid","scale","-$scaleid");
    //
    //if (!empty($rec)  && !empty($scaleid)) {
    //    $return = true;
    //}

    return $return;
}

function vocabulario_view($id, $opcion=0, $id_mp=null) {
    global $CFG, $COURSE, $USER;

    $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);

    switch ($opcion) {
        default:
        case 0: //ver las opciones
            $mform = new mod_vocabulario_opciones_form();
            $mform->aniadircosas($id);
            break;
        case 1: //rellenar el formulario
            $mform = new mod_vocabulario_rellenar_form('guardar.php?id_tocho=' . $id);
            break;
        case 2: //ver las palabras
            $mform = new mod_vocabulario_ver_form('ver.php?id_tocho=' . $id);
            break;
        case 3: //guardar campo lexico
            $mform = new mod_vocabulario_nuevo_cl_form('guardar_cl.php?id_tocho=' . $id);
            break;
        case 4: //actualizar el formulario
            $mform = new mod_vocabulario_rellenar_form('guardar.php?id_tocho=' . $id . '&act=1');
            break;
        case 5: //guardar gramatica
            $mform = new mod_vocabulario_nuevo_gr_form('guardar_gr.php?id_tocho=' . $id);
            break;
        case 6: //guardar gramatica particular
            $mform = new mod_vocabulario_gramatica_desc_form('guardar_gr_desc.php?id_tocho=' . $id,'&id_mp='.$id_mp);
            break;
        case 7: //guardar intencion comunicativa
            $mform = new mod_vocabulario_nuevo_ic_form('guardar_ic.php?id_tocho=' . $id);
            break;
        case 8: //guardar intencion comunicativa particular
            $mform = new mod_vocabulario_intencion_desc_form('guardar_ic_desc.php?id_tocho=' . $id,'&id_mp='.$id_mp);
            break;
        case 9: //guardar tipologia textual
            $mform = new mod_vocabulario_nuevo_tipologia_form('guardar_tt.php?id_tocho=' . $id);
            break;
        case 10: //guardar tipologia textual particular
            $mform = new mod_vocabulario_tipologia_desc_form('guardar_tt_desc.php?id_tocho=' . $id,'&id_mp='.$id_mp);
            break;
        case 11: //ver estrategias de aprendizaje
            //$mform = new mod_vocabulario_tipologia_desc_form('guardar_tt_desc.php?id_tocho=' . $id,'&id_mp='.$id_mp);
            break;
        case 12: //ayuda
            //$mform = new mod_vocabulario_tipologia_desc_form('guardar_tt_desc.php?id_tocho=' . $id,'&id_mp='.$id_mp);
            break;
        case 13:
            $mform = new mod_vocabulario_listado_form('listado.php?id_tocho='.$id);
            break;
        case 14: //imprimir apuntes en pdf
            $mform = new mod_vocabulario_pdf_form('pdf.php?id_tocho='.$id);
            break;
    }

    $mform->display();
}

//////////////////////////////////////////////////////////////////////////////////////
/// Any other vocabulario functions go here.  Each of them must have a name that 
/// starts with Vocabulario_

function vocabulario_obtener_alumnos($cursoid) {
    global $CFG;
    $sql = 'SELECT u.id usuario, u.firstname nombre, u.lastname apellidos ';
    $sql .= 'FROM ';
    $sql .= '`' . $CFG->prefix . 'groups_members` gm, ';
    $sql .= '`' . $CFG->prefix . 'groups` g, ';
    $sql .= '`' . $CFG->prefix . 'user` u ';
    $sql .= 'WHERE ';
    $sql .= 'g.id = gm.groupid ';
    $sql .= 'AND u.id = gm.userid ';
    $sql .= 'AND g.courseid = ' . $cursoid;

    $mis_alumnos = get_records_sql($sql);

    return $mis_alumnos;
}

function vocabulario_todas_palabras($usuarioid, $cl=null, $gram=null, $inten=null, $tipo=null, $letra=null){
    global $CFG;
    $sql = '';
    if ($letra){
        $sql .= 'SELECT * FROM (';
    }
    $sql .= 'SELECT DISTINCT todas.pal, cl.campo, gr.gramatica, ic.intencion, tt.tipo, todas.mpid ';
    $sql .= 'FROM (';
    $sql .= '(SELECT mp.id mpid,`sustantivoid` id,`palabra` pal,`campoid` clid,`gramaticaid` grid,`intencionid` icid,`tipologiaid` ttid ';
    $sql .= 'FROM ';
    if ($cl){
	$sql .= 	'(SELECT * FROM `mdl_vocabulario_mis_palabras` WHERE campoid = '.$cl.') mp,';
    }
    else {
        $sql .= 	'`mdl_vocabulario_mis_palabras` mp,';
    }
    if($gram || $inten || $tipo){
        $sql .= '(SELECT * FROM `mdl_vocabulario_sustantivos` WHERE ';
        if ($gram){
            $sql .= 'gramaticaid = '.$gram.' and ';
        }
        if ($inten){
            $sql .= 'intencionid = '.$inten.' and ';
        }
        if ($tipo){
            $sql .= 'tipologiaid = '.$tipo.' and ';
        }
        $sql .= '1) s ';
    }
    else {
	$sql .= '`mdl_vocabulario_sustantivos` s ';
    }
    $sql .= 'WHERE `usuarioid` = '.$usuarioid.' and mp.`sustantivoid` = s.`id`) ';
    $sql .= 'UNION ';
    $sql .= '(SELECT mp.id mpid, `adjetivoid` id, `sin_declinar` pal, `campoid` clid, `gramaticaid` grid, `intencionid` icid, `tipologiaid` ttid ';
    $sql .= 'FROM ';
    if ($cl){
	$sql .= 	'(SELECT * FROM `mdl_vocabulario_mis_palabras` WHERE campoid = '.$cl.') mp,';
    }
    else {
        $sql .= 	'`mdl_vocabulario_mis_palabras` mp,';
    }
    if($gram || $inten || $tipo){
        $sql .= '(SELECT * FROM `mdl_vocabulario_adjetivos` WHERE ';
        if ($gram){
            $sql .= 'gramaticaid = '.$gram.' and ';
        }
        if ($inten){
            $sql .= 'intencionid = '.$inten.' and ';
        }
        if ($tipo){
            $sql .= 'tipologiaid = '.$tipo.' and ';
        }
        $sql .= '1) a ';
    }
    else {
	$sql .= '`mdl_vocabulario_adjetivos` a ';
    }
    $sql .= 'WHERE `usuarioid` = '.$usuarioid.' and mp.`adjetivoid` = a.`id` and a.`id` <> 1) ';
    $sql .= 'UNION ';
    $sql .= '(SELECT mp.id mpid, `verboid` id, `infinitivo` pal, `campoid` clid, `gramaticaid` grid, `intencionid` icid, `tipologiaid` ttid ';
    $sql .= 'FROM ';
    if ($cl){
	$sql .= 	'(SELECT * FROM `mdl_vocabulario_mis_palabras` WHERE campoid = '.$cl.') mp,';
    }
    else {
        $sql .= 	'`mdl_vocabulario_mis_palabras` mp,';
    }
    if($gram || $inten || $tipo){
        $sql .= '(SELECT * FROM `mdl_vocabulario_verbos` WHERE ';
        if ($gram){
            $sql .= 'gramaticaid = '.$gram.' and ';
        }
        if ($inten){
            $sql .= 'intencionid = '.$inten.' and ';
        }
        if ($tipo){
            $sql .= 'tipologiaid = '.$tipo.' and ';
        }
        $sql .= '1) a ';
    }
    else {
	$sql .= '`mdl_vocabulario_verbos` a ';
    }
    $sql .= 'WHERE `usuarioid` = '.$usuarioid.' and mp.`verboid` = a.`id` and a.`id` <> 1) ';
    $sql .= 'UNION ';
    $sql .= '(SELECT mp.id mpid, `otroid` id, `palabra` pal, `campoid` clid, `gramaticaid` grid, `intencionid` icid, `tipologiaid` ttid ';
    $sql .= 'FROM ';
    if ($cl){
	$sql .= 	'(SELECT * FROM `mdl_vocabulario_mis_palabras` WHERE campoid = '.$cl.') mp,';
    }
    else {
        $sql .= 	'`mdl_vocabulario_mis_palabras` mp,';
    }
    if($gram || $inten || $tipo){
        $sql .= '(SELECT * FROM `mdl_vocabulario_otros` WHERE ';
        if ($gram){
            $sql .= 'gramaticaid = '.$gram.' and ';
        }
        if ($inten){
            $sql .= 'intencionid = '.$inten.' and ';
        }
        if ($tipo){
            $sql .= 'tipologiaid = '.$tipo.' and ';
        }
        $sql .= '1) a ';
    }
    else {
	$sql .= '`mdl_vocabulario_otros` a ';
    }
    $sql .= 'WHERE `usuarioid` = '.$usuarioid.' and mp.`otroid` = a.`id` and a.`id` <> 1) ';
    $sql .= 'ORDER BY pal) todas,';
    $sql .= '`mdl_vocabulario_camposlexicos` cl, `mdl_vocabulario_gramatica` gr, `mdl_vocabulario_intenciones` ic, `mdl_vocabulario_tipologias` tt ';
    $sql .= 'WHERE todas.clid = cl.id and todas.grid = gr.id and todas.icid = ic.id and todas.ttid = tt.id';

    if ($letra){
        $sql .= ') p WHERE p.pal like \''.$letra.'%\'';
    }

    $todas = get_records_sql($sql);
    return $todas;
}

function vocabulario_rellenar_alumnos($cursoid) {
    //lectura de los campos lexicos disponibles
    $alumnos = vocabulario_obtener_alumnos($cursoid);
    $alum = array();

    foreach ($alumnos as $cosa) {
        $alum[$cosa->usuario] = $cosa->nombre . ' ' . $cosa->apellidos;
    }

    return $alum;
}
?>
