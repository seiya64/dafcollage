<?php

// $Id: view.php,v 1.4 2006/08/28 16:41:20 mark-nielsen Exp $
/**
 * This page prints a particular instance of vocabulario
 * 
 * @author 
 * @version $Id: view.php,v 1.4 2006/08/28 16:41:20 mark-nielsen Exp $
 * @package vocabulario
 * */
/// (Replace vocabulario with the name of your module)

require_once("../../config.php");
require_once("lib.php");
require_once("$CFG->libdir/formslib.php");

$id = optional_param('id', 0, PARAM_INT); // Course Module ID, or
$a = optional_param('a', 0, PARAM_INT);  // vocabulario
$opcion = optional_param('opcion', 0, PARAM_INT); //para saber lo que hay que enseñar
$id_mp = optional_param('id_mp', null, PARAM_INT); //para saber de donde vengo
$palabra = optional_param('palabra',"", PARAM_TEXT); //para saber de donde vengo
$viene = optional_param('viene',0, PARAM_INT); //para saber de donde vengo en modificar,añadir,eliminar
if ($id) {
    if (!$cm = get_record("course_modules", "id", $id)) {
        error("Course Module ID was incorrect");
    }

    if (!$course = get_record("course", "id", $cm->course)) {
        error("Course is misconfigured");
    }

    if (!$vocabulario = get_record("vocabulario", "id", $cm->instance)) {
        error("Course module is incorrect");
    }
} else {
    if (!$vocabulario = get_record("vocabulario", "id", $a)) {
        error("Course module is incorrect");
    }
    if (!$course = get_record("course", "id", $vocabulario->course)) {
        error("Course is misconfigured");
    }
    if (!$cm = get_coursemodule_from_instance("vocabulario", $vocabulario->id, $course->id)) {
        error("Course Module ID was incorrect");
    }
}

require_login($course->id);

add_to_log($course->id, "vocabulario", "view", "view.php?id=$cm->id", "$vocabulario->id");

/// Print the page header

if ($course->category) {
    $navigation = "<a href=\"../../course/view.php?id=$course->id\">$course->shortname</a> ->";
} else {
    $navigation = '';
}

$strvocabularios = get_string("modulenameplural", "vocabulario");
$strvocabulario = get_string("modulename", "vocabulario");

print_header("$course->shortname: $vocabulario->name", "$course->fullname", "$navigation <a href=index.php?id=$course->id>$strvocabularios</a> -> $vocabulario->name", "", "", true, update_module_button($cm->id, $course->id, $strvocabulario), navmenu($course, $cm));

/// Print the main part of the page
vocabulario_view($cm->id, $opcion, $id_mp,$palabra,$viene);
/// Finish the page
print_footer($course);
?>
