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
GNU General Public License for more details.*/


require_once("../../config.php");
require_once("lib.php");
require_once("vocabulario_classes.php");
require_once("vocabulario_formularios.php");

$id_tocho = optional_param('id_tocho', 0, PARAM_INT);

$mform = new mod_vocabulario_tipologia_desc_form();

$ttid = optional_param('ttid', 0, PARAM_INT);


$id_mp = optional_param('id_mp',null,PARAM_INT);

//averiguo quien soy
$user_object = get_record('user', 'id', $USER->id);
$tipologia = new Vocabulario_mis_tipologias();
$tipologia->leer($ttid);
if ($mform->is_cancelled()) {
    redirect('./view.php?id=' . $id_tocho . '&opcion=9&ttid=' . $tipologia->get('tipoid'));
}

$desc = optional_param('quien', null, PARAM_TEXT) . '&' . optional_param('finalidad', null, PARAM_TEXT) . '&';
$desc .= optional_param('a_quien', null, PARAM_TEXT) . '&' . optional_param('medio', null, PARAM_TEXT). '&';
$desc .= optional_param('donde', null, PARAM_TEXT) . '&' . optional_param('cuando', null, PARAM_TEXT). '&';
$desc .= optional_param('motivo', null, PARAM_TEXT) . '&' . optional_param('funcion', null, PARAM_TEXT). '&';
$desc .= optional_param('sobre_que', null, PARAM_TEXT) . '&' . optional_param('que', null, PARAM_TEXT). '&';
$desc .= optional_param('orden', null, PARAM_TEXT) . '&' . optional_param('medios_nonverbales', null, PARAM_TEXT). '&';
$desc .= optional_param('que_palabras', null, PARAM_TEXT) . '&' . optional_param('que_frases', null, PARAM_TEXT). '&';
$desc .= optional_param('que_tono', null, PARAM_TEXT);

$tipologia->set(null, null, $desc);
$tipologia->actualizar();
$soy = optional_param('id_mp',null,PARAM_INT);
if ($soy != 0){
    redirect('./view.php?id=' . $id_tocho . '&opcion=1&id_mp='.$id_mp);
}
else{
    redirect('./view.php?id=' . $id_tocho . '&opcion=9');
}
?>
