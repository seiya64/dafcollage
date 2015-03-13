<?php
<<<<<<< HEAD
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

$id = required_param('id', PARAM_INT);   // course

if (!$course = get_record("course", "id", $id)) {
    error("Course ID is incorrect");
}

require_login($course->id);

add_to_log($course->id, "vocabulario", "view all", "index.php?id=$course->id", "");


/// Get all required stringsvocabulario

$strvocabularios = get_string("modulenameplural", "vocabulario");
$strvocabulario = get_string("modulename", "vocabulario");


/// Print the header

if ($course->category) {
    $navigation = "<a href=\"../../course/view.php?id=$course->id\">$course->shortname</a> ->";
} else {
    $navigation = '';
}

print_header("$course->shortname: $strvocabularios", "$course->fullname", "$navigation $strvocabularios", "", "", true, "", navmenu($course));

/// Get all the appropriate data

if (!$vocabularios = get_all_instances_in_course("vocabulario", $course)) {
    notice("There are no vocabularios", "../../course/view.php?id=$course->id");
    die;
}

/// Print the list of instances (your module will probably extend this)

$timenow = time();
$strname = get_string("name");
$strweek = get_string("week");
$strtopic = get_string("topic");

if ($course->format == "weeks") {
    $table->head = array($strweek, $strname);
    $table->align = array("center", "left");
} else if ($course->format == "topics") {
    $table->head = array($strtopic, $strname);
    $table->align = array("center", "left", "left", "left");
} else {
    $table->head = array($strname);
    $table->align = array("left", "left", "left");
=======

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
 * This is a one-line short description of the file
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_vocabulario
 * @copyright  2011 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/// Replace vocabulario with the name of your module and remove this line

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$id = required_param('id', PARAM_INT);   // course

$course = $DB->get_record('course', array('id' => $id), '*', MUST_EXIST);

require_course_login($course);

add_to_log($course->id, 'vocabulario', 'view all', 'index.php?id='.$course->id, '');

$coursecontext = context_course::instance($course->id);

$PAGE->set_url('/mod/vocabulario/index.php', array('id' => $id));
$PAGE->set_title(format_string($course->fullname));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($coursecontext);

echo $OUTPUT->header();

if (! $vocabularios = get_all_instances_in_course('vocabulario', $course)) {
    notice(get_string('novocabularios', 'vocabulario'), new moodle_url('/course/view.php', array('id' => $course->id)));
}

$table = new html_table();
if ($course->format == 'weeks') {
    $table->head  = array(get_string('week'), get_string('name'));
    $table->align = array('center', 'left');
} else if ($course->format == 'topics') {
    $table->head  = array(get_string('topic'), get_string('name'));
    $table->align = array('center', 'left', 'left', 'left');
} else {
    $table->head  = array(get_string('name'));
    $table->align = array('left', 'left', 'left');
>>>>>>> 7c29cbaffbf1a0efc5907dbf3b3b442f5bb2fd2d
}

foreach ($vocabularios as $vocabulario) {
    if (!$vocabulario->visible) {
<<<<<<< HEAD
        //Show dimmed if the mod is hidden
        $link = "<a class=\"dimmed\" href=\"view.php?id=$vocabulario->coursemodule\">$vocabulario->name</a>";
    } else {
        //Show normal if the mod is visible
        $link = "<a href=\"view.php?id=$vocabulario->coursemodule\">$vocabulario->name</a>";
    }

    if ($course->format == "weeks" or $course->format == "topics") {
=======
        $link = html_writer::link(
            new moodle_url('/mod/vocabulario.php', array('id' => $vocabulario->coursemodule)),
            format_string($vocabulario->name, true),
            array('class' => 'dimmed'));
    } else {
        $link = html_writer::link(
            new moodle_url('/mod/vocabulario.php', array('id' => $vocabulario->coursemodule)),
            format_string($vocabulario->name, true));
    }

    if ($course->format == 'weeks' or $course->format == 'topics') {
>>>>>>> 7c29cbaffbf1a0efc5907dbf3b3b442f5bb2fd2d
        $table->data[] = array($vocabulario->section, $link);
    } else {
        $table->data[] = array($link);
    }
}

<<<<<<< HEAD
echo "<br />";

print_table($table);

/// Finish the page

print_footer($course);
?>
=======
echo $OUTPUT->heading(get_string('modulenameplural', 'vocabulario'), 2);
echo html_writer::table($table);
echo $OUTPUT->footer();
>>>>>>> 7c29cbaffbf1a0efc5907dbf3b3b442f5bb2fd2d
