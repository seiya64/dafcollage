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

$id_tocho = optional_param('id_tocho', 0, PARAM_INT);

$mform = new mod_vocabulario_nuevo_tipologia_form();

if ($mform->is_cancelled()) {
    redirect('./view.php?id=' . $id_tocho);
}

//averiguo quien soy
$user_object = get_record('user', 'id', $USER->id);

$tipologia = new Vocabulario_tipologias($user_object->id, required_param('campott', PARAM_TEXT), optional_param('tipologia', PARAM_TEXT));

//print_object($tipologia);
$desc = '';
for ($i = 1; $i < 6; $i++){
    $desc .= optional_param('quien'.$i, null, PARAM_TEXT) . '&' . optional_param('finalidad'.$i, null, PARAM_TEXT) . '&';
    $desc .= optional_param('a_quien'.$i, null, PARAM_TEXT) . '&' . optional_param('medio'.$i, null, PARAM_TEXT). '&';
    $desc .= optional_param('donde'.$i, null, PARAM_TEXT) . '&' . optional_param('cuando'.$i, null, PARAM_TEXT). '&';
    $desc .= optional_param('motivo'.$i, null, PARAM_TEXT) . '&' . optional_param('funcion'.$i, null, PARAM_TEXT). '&';
    $desc .= optional_param('sobre_que'.$i, null, PARAM_TEXT) . '&' . optional_param('que'.$i, null, PARAM_TEXT). '&';
    $desc .= optional_param('orden'.$i, null, PARAM_TEXT) . '&' . optional_param('medios_nonverbales'.$i, null, PARAM_TEXT). '&';
    $desc .= optional_param('que_palabras'.$i, null, PARAM_TEXT) . '&' . optional_param('que_frases'.$i, null, PARAM_TEXT). '&';
    $desc .= optional_param('que_tono'.$i, null, PARAM_TEXT).'&';
}

$desc .=  optional_param('miraren', null, PARAM_TEXT);

//vemos que botón hemos pulsado
if ($mform->no_submit_button_pressed()){
    if(optional_param('desc_btn')){
        $tipologiaaux = new Vocabulario_mis_tipologias();
        $tipologiaaux->leer($tipologia->get('padre'));
        $tipologiaaux->set($USER->id,$tipologia->get('padre'),$desc);
//        print_object($tipologiaaux);
        $tipologiaaux->guardar();
        //$ttidaux = update_record('vocabulario_mis_tipologias', $tipologiaaux, true);
    }
}

//volvemos a donde veniamos
redirect('./view.php?id=' . $id_tocho . '&opcion=9&ttid=' . $tipologia->get('padre'));
?>
