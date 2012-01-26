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

Original idea and content design:
    Ruth Burbat
    Inmaculada Almahano Güeto
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
GNU General Public License for more details.*/

require_once("../../config.php");
require_once("lib.php");
require_once("vocabulario_classes.php");
require_once("vocabulario_formularios.php");

global $CFG, $COURSE, $USER;
$context = get_context_instance(CONTEXT_COURSE, $COURSE->id);


$campo = optional_param('campoid', 0, PARAM_INT);
$id_tocho = optional_param('id_tocho', 0, PARAM_INT);
$tipo = optional_param('tipo', 'cl', PARAM_ALPHA);

$cancel = optional_param('cancelbutton','',PARAM_ALPHA);

if($cancel){
    redirect('./view.php?id=' . $id_tocho);
}

if (has_capability('moodle/legacy:editingteacher', $context, $USER->id, false)) {
    $alumno = optional_param('alumnoid', 0, PARAM_INT);
    redirect('view.php?id=' . $id_tocho . '&opcion=2&alid=' . $alumno);
}


redirect('view.php?id=' . $id_tocho . '&opcion=2&'.$tipo.'=1&campo=' . $campo);
?>
