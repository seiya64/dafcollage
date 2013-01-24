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
}

foreach ($vocabularios as $vocabulario) {
    if (!$vocabulario->visible) {
        //Show dimmed if the mod is hidden
        $link = "<a class=\"dimmed\" href=\"view.php?id=$vocabulario->coursemodule\">$vocabulario->name</a>";
    } else {
        //Show normal if the mod is visible
        $link = "<a href=\"view.php?id=$vocabulario->coursemodule\">$vocabulario->name</a>";
    }

    if ($course->format == "weeks" or $course->format == "topics") {
        $table->data[] = array($vocabulario->section, $link);
    } else {
        $table->data[] = array($link);
    }
}

echo "<br />";

print_table($table);

/// Finish the page

print_footer($course);
?>
