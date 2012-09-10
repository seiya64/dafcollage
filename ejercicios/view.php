<?php  // $Id: view.php,v 1.6.2.3 2009/04/17 22:06:25 skodak Exp $

/**
 * This page prints a particular instance of ejercicios
 *
 * @author  Your Name <your@email.address>
 * @version $Id: view.php,v 1.6.2.3 2009/04/17 22:06:25 skodak Exp $
 * @package mod/ejercicios
 */

/// (Replace ejercicios with the name of your module and remove this line)

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$id = optional_param('id', 0, PARAM_INT); // course_module ID, or
$a  = optional_param('a', 0, PARAM_INT);  // ejercicios instance ID
$op  = optional_param('opcion', 0, PARAM_INT);  // ejercicios instance ID
$error  = optional_param('error', -1, PARAM_INT);  // ejercicios instance ID
$name_ej  = optional_param('name_ej', -1, PARAM_TEXT);
$tipo  = optional_param('tipo', 1, PARAM_INT);
$tipocreacion  = optional_param('tipocreacion', 0, PARAM_INT);
$p  = optional_param('p', 0, PARAM_INT);
$buscar= optional_param('buscar', 0, PARAM_INT);
$id_ejercicio  = optional_param('id_ejercicio', 0, PARAM_INT);


//Para busqueda

$ccl = optional_param('ccl', -1, PARAM_INT);
$cta = optional_param('cta', -1, PARAM_INT);
$cdc  = optional_param('cdc',-1, PARAM_INT);
$cgr  = optional_param('cgr',-1, PARAM_INT);
$cic  = optional_param('cic',-1, PARAM_INT);
$ctt  = optional_param('ctt',-1, PARAM_INT);

if ($id) {
    if (! $cm = get_coursemodule_from_id('ejercicios', $id)) {
        error('Course Module ID was incorrect');
    }

    if (! $course = get_record('course', 'id', $cm->course)) {
        error('Course is misconfigured');
    }

    if (! $ejercicios = get_record('ejercicios', 'id', $cm->instance)) {
        error('Course module is incorrect');
    }

} else if ($a) {
    if (! $ejercicios = get_record('ejercicios', 'id', $a)) {
        error('Course module is incorrect');
    }
    if (! $course = get_record('course', 'id', $ejercicios->course)) {
        error('Course is misconfigured');
    }
    if (! $cm = get_coursemodule_from_instance('ejercicios', $ejercicios->id, $course->id)) {
        error('Course Module ID was incorrect');
    }

} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);

add_to_log($course->id, "ejercicios", "view", "view.php?id=$cm->id", "$ejercicios->id");

/// Print the page header
$strejercicioss = get_string('modulenameplural', 'ejercicios');
$strejercicios  = get_string('modulename', 'ejercicios');

$navlinks = array();
$navlinks[] = array('name' => $strejercicioss, 'link' => "index.php?id=$course->id", 'type' => 'activity');
$navlinks[] = array('name' => format_string($ejercicios->name), 'link' => '', 'type' => 'activityinstance');

$navigation = build_navigation($navlinks);

print_header_simple(format_string($ejercicios->name), '', $navigation, '', '', true,
              update_module_button($cm->id, $course->id, $strejercicios), navmenu($course, $cm));

/// Print the main part of the page

ejercicios_vista($cm->id,$op,$error,$name_ej,$tipo,$tipocreacion,$p,$id_ejercicio,$ccl,$cta ,$cdc,$cgr,$cic,$ctt,$buscar);


/// Finish the page
print_footer($course);

?>
