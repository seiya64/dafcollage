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

/*
 * ESTE FICHERO SE ENCARGA DE GUARDAR EL CONTENIDO DE LAS ESTRATEGIAS DE APRENDIZAJE 
 */

require_once("../../config.php");
require_once("lib.php");
require_once("vocabulario_classes.php");
require_once("vocabulario_formularios.php");

$id_tocho = optional_param('id_tocho', 0, PARAM_INT);

$mform = new mod_vocabulario_nuevo_estrategia_form();

if ($mform->is_cancelled()) {
    redirect('./view.php?id=' . $id_tocho);
}

//averiguo quien soy
$user_object = get_record('user', 'id', $USER->id);

$estrategia = new Vocabulario_estrategias($user_object->id, required_param('campoea', PARAM_TEXT), optional_param('estrategia', PARAM_TEXT));


$desc = __SEPARADORCAMPOS__ . optional_param('miestrategia', null, PARAM_TEXT);


//vemos que botón hemos pulsado
if ($mform->no_submit_button_pressed()) {
    if (optional_param('desc_btn')) {

        $estrategiaaux = new Vocabulario_mis_estrategias();
        $estrategiaaux->leer($estrategia->get('padre'));
        $estrategiaaux->set($USER->id, $estrategia->get('padre'), $desc);
        $estrategiaaux->guardar();
    }
}

//volvemos a donde veniamos
redirect('./view.php?id=' . $id_tocho . '&opcion=11&eaid=' . $estrategia->get('padre'));
?>
