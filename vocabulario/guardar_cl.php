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

$mform = new mod_vocabulario_nuevo_cl_form();
if ($mform->is_cancelled()) {
    redirect('./view.php?id=' . $id_tocho);
}

//averiguo quien soy
$user_object = get_record('user', 'id', $USER->id);

$campo = array();
$campo['usuarioid'] = $user_object->id;
$campo['padre'] = required_param('campoid', PARAM_TEXT);
$campo['campo'] = optional_param('campo', PARAM_TEXT);

$sufijos = get_todos_sufijos_lenguaje();

if (optional_param('eliminar', 0, PARAM_INT) && $campo['padre'] > 106) {
    //comenzamos una transacción para que en todas las tablas se haga seguido
    // en caso de error en algun delete, no se hace ninguno
    begin_sql();
    foreach ($sufijos as $sufijo) {
        delete_records('vocabulario_camposlexicos_' . $sufijo, 'id', $campo['padre']);
    }
    //confirmamos la transacción
    commit_sql();
    //echo 'eliminado ' . $campo['padre'];
}

if ($campo['campo'] != null) {
    //comenzamos una transacción para que todos los insert sean seguidos y produzcan el mismo id en todas las tablas
    //en caso de error en uno, no se hace ninguno
    begin_sql();
    foreach ($sufijos as $sufijo) {
        insert_record('vocabulario_camposlexicos_' . $sufijo, $campo, true);
    }
    //confirmamos la transacción
    commit_sql();
}

//volvemos a donde veniamos
redirect('./view.php?id=' . $id_tocho . '&opcion=3');
?>
