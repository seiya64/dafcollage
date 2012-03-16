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
  GNU General Public License for more details. */


require_once("../../config.php");
require_once("lib.php");
require_once("vocabulario_classes.php");
require_once("vocabulario_formularios.php");

$id_tocho = optional_param('id_tocho', 0, PARAM_INT);

$mform = new mod_vocabulario_nuevo_ic_form();

if ($mform->is_cancelled()) {
    redirect('./view.php?id=' . $id_tocho);
}

//averiguo quien soy
$user_object = get_record('user', 'id', $USER->id);

$intencion = new Vocabulario_intenciones($user_object->id, required_param('campoic', PARAM_TEXT), optional_param('intencion', PARAM_TEXT));
$desc = optional_param('descripcion', PARAM_TEXT);

$salir = false;
$avance = 4;
for ($i = 1; $salir == false; $i = $i + $avance) {
    if (optional_param('mittel' . $i, null, PARAM_TEXT) ||
            optional_param('wortklase' . $i, null, PARAM_TEXT) ||
            optional_param('beisp' . $i, null, PARAM_TEXT) ||
            optional_param('siehe' . $i, null, PARAM_TEXT)) {

        $desc .= __SEPARADORCAMPOS__ . optional_param('mittel' . $i, null, PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('wortklase' . $i, null, PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('beisp' . $i, null, PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('siehe' . $i, null, PARAM_TEXT);
    } else {
        $salir = true;
    }
}
$desc .= '&&&&';

//if (optional_param('eliminar', 0, PARAM_INT) && $intencion->get('padre') > 145) {
//    delete_records('vocabulario_intenciones', 'id', $intencion->get('padre'));
//    redirect('./view.php?id=' . $id_tocho . '&opcion=7');
//}

if ($mform->no_submit_button_pressed()) {
    if (optional_param('desc_btn')) {
        redirect('./view.php?id=' . $id_tocho . '&opcion=7&icid=' . $intencion->get('padre'));
    }
}

//if ($intencion->get('intencion') != null) {
//    $icidaux = insert_record('vocabulario_intenciones', $intencion, true);
//}
//else{
$icidaux = required_param('campoic', PARAM_TEXT);
//}

if ($desc != null) {
    $mintencion = new Vocabulario_mis_intenciones();
    $mintencion->leer($icidaux, $USER->id);
    $mintencion->set($USER->id, $icidaux, $desc);
    $mintencion->guardar();
}

//volvemos a donde veniamos
//redirect('./view.php?id=' . $id_tocho . '&opcion=7&icid=' . $intencion->get('padre'));
redirect('./view.php?id=' . $id_tocho . '&opcion=7&icid=' . $icidaux);
?>
