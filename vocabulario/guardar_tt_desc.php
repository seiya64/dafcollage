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
require_once("vocabulario_classes.php");
require_once("vocabulario_formularios.php");

<<<<<<< HEAD
=======
global $DB;

>>>>>>> 7c29cbaffbf1a0efc5907dbf3b3b442f5bb2fd2d
$id_tocho = optional_param('id_tocho', 0, PARAM_INT);

$mform = new mod_vocabulario_tipologia_desc_form();

$ttid = optional_param('ttid', 0, PARAM_INT);

$id_mp = optional_param('id_mp', null, PARAM_INT);

//averiguo quien soy
<<<<<<< HEAD
$user_object = get_record('user', 'id', $USER->id);
=======
$user_object = $DB->get_record('user', array('id'=>$USER->id));
>>>>>>> 7c29cbaffbf1a0efc5907dbf3b3b442f5bb2fd2d

$tip = new Vocabulario_tipologias($user_object->id, required_param('campott', PARAM_TEXT), optional_param('tipologia', null, PARAM_TEXT));

if ($mform->is_cancelled()) {
    redirect('./view.php?id=' . $id_tocho);
}


$sufijos = get_todos_sufijos_lenguaje();

if (optional_param('eliminar', 0, PARAM_INT) && $tip->get('padre') > 54) {
    //comenzamos una transacción para que en todas las tablas se haga seguido
    // en caso de error en algun delete, no se hace ninguno
<<<<<<< HEAD
    begin_sql();
    foreach ($sufijos as $sufijo) {
        delete_records('vocabulario_tipologias_' . $sufijo, 'id', $tip->get('padre'));
    }
    //confirmamos la transacción
    commit_sql();
    redirect('./view.php?id=' . $id_tocho . '&opcion=10');
=======
    
    try {
        $transaction = $DB->start_delegated_transaction();
        foreach ($sufijos as $sufijo) {
           $DB->delete_records('vocabulario_tipologias_' . $sufijo, array('id'=>$tip->get('padre')));
        }
 
        // Assumimos que todos los delete (eliminación) han funcionado, y pasamos a la siguiente línea.
        $transaction->allow_commit();
     } 
     catch(Exception $e) {
        $transaction->rollback($e);
     }
     redirect('./view.php?id=' . $id_tocho . '&opcion=10');
>>>>>>> 7c29cbaffbf1a0efc5907dbf3b3b442f5bb2fd2d
}

if ($tip->get('tipo') != null) {
    $tip->set(null, null, '0');
    //comenzamos una transacción para que todos los insert sean seguidos y produzcan el mismo id en todas las tablas
    //en caso de error en uno, no se hace ninguno
<<<<<<< HEAD
    begin_sql();
    foreach ($sufijos as $sufijo) {
        $ttidaux = insert_record('vocabulario_tipologias_' . $sufijo, $tip, true);
    }
    //confirmamos la transacción
    commit_sql();
=======
    
    try {
        $transaction = $DB->start_delegated_transaction();
        foreach ($sufijos as $sufijo) {
            $ttidaux = $DB->insert_record('vocabulario_tipologias_' . $sufijo, $tip, true);
        }
 
        // Assumimos que todos los delete (eliminación) han funcionado, y pasamos a la siguiente línea.
        $transaction->allow_commit();
     } 
     catch(Exception $e) {
        $transaction->rollback($e);
     }
>>>>>>> 7c29cbaffbf1a0efc5907dbf3b3b442f5bb2fd2d
}
redirect('./view.php?id=' . $id_tocho . '&opcion=10&ttid=' . $ttidaux);
?>
