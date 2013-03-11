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
 * ESTE FICHERO SE ENCARGA DE AÑADIR NUEVAS ESTRATEGIAS DE APRENDIZAJE
 */

require_once("../../config.php");
require_once("lib.php");
require_once("vocabulario_classes.php");
require_once("vocabulario_formularios.php");

$id_tocho = optional_param('id_tocho', 0, PARAM_INT);

$mform = new mod_vocabulario_estrategia_desc_form();

$eaid = optional_param('eaid', 0, PARAM_INT);

$id_mp = optional_param('id_mp', null, PARAM_INT);

//averiguo quien soy
$user_object = get_record('user', 'id', $USER->id);

$est = new Vocabulario_estrategias($user_object->id, required_param('campoea', PARAM_TEXT), optional_param('estrategia', null, PARAM_TEXT));

if ($mform->is_cancelled()) {
    redirect('./view.php?id=' . $id_tocho);
}

if (optional_param('eliminar', 0, PARAM_INT) && $est->get('padre') > 1) {
    delete_records('vocabulario_estrategias', 'id', $est->get('padre'));
    redirect('./view.php?id=' . $id_tocho . '&opcion=12');
}

if ($est->get('estrategia') != null) {
    $est->set(null, null, '0');

    $eaidaux = insert_record('vocabulario_estrategias', $est, true);
}
redirect('./view.php?id=' . $id_tocho . '&opcion=12&eaid=' . $eaidaux);
?>
