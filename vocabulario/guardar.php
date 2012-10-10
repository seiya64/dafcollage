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

$mform = new mod_vocabulario_rellenar_form();

$id_tocho = optional_param('id_tocho', 0, PARAM_INT);
$borrar = optional_param('borrar', 0, PARAM_INT);
$act = optional_param('act', 0, PARAM_INT);
$añadiendo= optional_param('añadiendo', 0, PARAM_INT);
$viene= optional_param('viene', 0, PARAM_INT);

if($añadiendo){ //Si estoy añadiendo desde tabla interactiva
    $act=2; //quiero añadir no actualizar
}
if ($mform->is_cancelled()) {
    redirect('./view.php?id=' . $id_tocho);
}

$datos = $mform->get_data();
//print_object($datos);

$id_sustantivo;
$id_adjetivo = 1;
$id_verbo = 1;
$id_otro = 1;

$id_actualizable = 0;

$leido = optional_param('idleido', PARAM_INT);

if ($borrar > 0) {
    delete_records('vocabulario_mis_palabras', 'id', $borrar);
    redirect('./view.php?id=' . $id_tocho . '&opcion=2');
}

//leo un sustantivo y lo guardo
$sustantivo_leido = new Vocabulario_sustantivo(required_param('palabra_sus', PARAM_TEXT),
                optional_param('genero', PARAM_INT),
                optional_param('plural', PARAM_TEXT),
                optional_param('significado_sus', PARAM_TEXT),
                optional_param('observaciones_sus', PARAM_TEXT),
                optional_param('gramatica_sus', PARAM_INT),
                optional_param('intencion_sus', PARAM_INT),
                optional_param('tipologia_sus', PARAM_INT),
                optional_param('ejemplo_sus', PARAM_INT));
//leo un verbo y lo guardo
$verbo_leido = new Vocabulario_verbo(optional_param('infinitivo', PARAM_TEXT),
                optional_param('ter_pers_sing', PARAM_TEXT),
                optional_param('preterito', PARAM_TEXT),
                optional_param('participio', PARAM_TEXT),
                optional_param('significado_vrb', PARAM_TEXT),
                optional_param('observaciones_vrb', PARAM_TEXT),
                optional_param('gramatica_vrb', PARAM_INT),
                optional_param('intencion_vrb', PARAM_INT),
                optional_param('tipologia_vrb', PARAM_INT));
//leo un adjetivo y lo guardo
$adjetivo_leido = new Vocabulario_adjetivo(optional_param('sindeclinar', PARAM_TEXT),
                optional_param('significado_adj', PARAM_TEXT),
                optional_param('observaciones_adj', PARAM_TEXT),
                optional_param('gramatica_adj', PARAM_INT),
                optional_param('intencion_adj', PARAM_INT),
                optional_param('tipologia_adj', PARAM_INT));
//leo otra palabra y la guardo
$otro_leido = new Vocabulario_otro(optional_param('palabra_otr', PARAM_TEXT),
                optional_param('significado_otr', PARAM_TEXT),
                optional_param('observaciones_otr', PARAM_TEXT),
                optional_param('gramatica_otr', PARAM_INT),
                optional_param('intencion_otr', PARAM_INT),
                optional_param('tipologia_otr', PARAM_INT));
$campo_leido = optional_param('campoid', PARAM_INT);

//compruebo si voy a actualizar o a insertar
if ($act == 1) {
    $id_actualizable = optional_param('idleido', PARAM_INT);
    if ($id_actualizable > 0) {
        $cosa_leida = new Vocabulario_mis_palabras($USER->id, $sustantivo_leido, $verbo_leido, $adjetivo_leido, $otro_leido, $campo_leido, $id_actualizable);
        $cosa_leida->actualizar();
    }
} else {
    $cosa_leida = new Vocabulario_mis_palabras($USER->id, $sustantivo_leido, $verbo_leido, $adjetivo_leido, $otro_leido, $campo_leido);
    $cosa_leida->guardar();
}

if ($mform->no_submit_button_pressed()) {
    $actgram = false;
    $actinten = false;
    $actipo = false;

    //voy a especificar la gramatica
    if (optional_param('gram_sus_boton')) {
        $mg = new Vocabulario_mis_gramaticas($USER->id, optional_param('gramatica_sus', PARAM_INT), null, 'sustantivo', $cosa_leida->get('sustantivo')->get('id'));
        $mg->guardar();
        $actgram = true;
    }
    if (optional_param('gram_vrb_boton')) {
        $mg = new Vocabulario_mis_gramaticas($USER->id, optional_param('gramatica_vrb', PARAM_INT), null, 'verbo', $cosa_leida->get('verbo')->get('id'));
        $mg->guardar();
        $actgram = true;
    }
    if (optional_param('gram_adj_boton')) {
        $mg = new Vocabulario_mis_gramaticas($USER->id, optional_param('gramatica_adj', PARAM_INT), null, 'adjetivo', $cosa_leida->get('adjetivo')->get('id'));
        $mg->guardar();
        $actgram = true;
    }
    if (optional_param('gram_otr_boton')) {
        $mg = new Vocabulario_mis_gramaticas($USER->id, optional_param('gramatica_otr', PARAM_INT), null, 'otro', $cosa_leida->get('otro')->get('id'));
        $mg->guardar();
        $actgram = true;
    }
    if ($actgram) {
        redirect('./view.php?id=' . $id_tocho . '&opcion=6&grid=' . $mg->get('id') . '&id_mp=' . $cosa_leida->get('id'));
    }

    //voy a especificar le intencion comunicativa
    if (optional_param('inten_sus_boton')) {
        $mg = new Vocabulario_mis_intenciones($USER->id, optional_param('intencion_sus', PARAM_INT), null, 'sustantivo', $cosa_leida->get('sustantivo')->get('id'));
        $mg->guardar();
        $actinten = true;
    }
    if (optional_param('inten_vrb_boton')) {
        $mg = new Vocabulario_mis_intenciones($USER->id, optional_param('intencion_vrb', PARAM_INT), null, 'verbo', $cosa_leida->get('verbo')->get('id'));
        $mg->guardar();
        $actinten = true;
    }
    if (optional_param('inten_adj_boton')) {
        $mg = new Vocabulario_mis_intenciones($USER->id, optional_param('intencion_adj', PARAM_INT), null, 'adjetivo', $cosa_leida->get('adjetivo')->get('id'));
        $mg->guardar();
        $actinten = true;
    }
    if (optional_param('inten_otr_boton')) {
        $mg = new Vocabulario_mis_intenciones($USER->id, optional_param('intencion_otr', PARAM_INT), null, 'otro', $cosa_leida->get('otro')->get('id'));
        $mg->guardar();
        $actinten = true;
    }
    if ($actinten) {
        //echo "estoy guardando";
        redirect('./view.php?id=' . $id_tocho . '&opcion=8&icid=' . $mg->get('id') . '&id_mp=' . $cosa_leida->get('id'));
    }

    //voy a especificar le tipologia textual
    if (optional_param('tipo_sus_boton')) {
        $mg = new Vocabulario_mis_tipologias($USER->id, optional_param('tipologia_sus', PARAM_INT), null, 'sustantivo', $cosa_leida->get('sustantivo')->get('id'));
        $mg->guardar();
        $actipo = true;
    }
    if (optional_param('tipo_vrb_boton')) {
        $mg = new Vocabulario_mis_tipologias($USER->id, optional_param('tipologia_vrb', PARAM_INT), null, 'verbo', $cosa_leida->get('verbo')->get('id'));
        $mg->guardar();
        $actipo = true;
    }
    if (optional_param('tipo_adj_boton')) {
        $mg = new Vocabulario_mis_tipologias($USER->id, optional_param('tipologia_adj', PARAM_INT), null, 'adjetivo', $cosa_leida->get('adjetivo')->get('id'));
        $mg->guardar();
        $actipo = true;
    }
    if (optional_param('tipo_otr_boton')) {
        $mg = new Vocabulario_mis_tipologias($USER->id, optional_param('tipologia_otr', PARAM_INT), null, 'otro', $cosa_leida->get('otro')->get('id'));
        $mg->guardar();
        $actipo = true;
    }
    if ($actipo) {
        //echo "estoy guardando";
        redirect('./view.php?id=' . $id_tocho . '&opcion=10&ttid=' . $mg->get('id') . '&id_mp=' . $cosa_leida->get('id'));
    }
}

//volvemos a donde veniamos

/*Quitado por mi fina
if ($act == 1) { //vamos a la tabla interactiva
    redirect('./view.php?id=' . $id_tocho . '&opcion=2');
   
} else if ($act == 2) { //vamos a la tabla interactiva
  redirect('./view.php?id=' . $id_tocho . '&opcion=1&act=2&id_mp=' . $leido . '&add=' . optional_param('add', PARAM_TEXT));
} else {
     redirect('./view.php?id=' . $id_tocho . '&opcion=2');
}*/
switch($viene){
  case 0:    //por defecto me voy a la tabla nube
       redirect('./view.php?id=' . $id_tocho . '&opcion=2');
       break;
  case 1: //Relacion con otros campos
      redirect('./view.php?id=' . $id_tocho . '&opcion=2&todasp=1');
       break;
  case 2: //Por orden alfabetico
      redirect('./view.php?id=' . $id_tocho . '&opcion=2&alfa=1');
      break;
  case 3: //Por gramatica
       redirect('./view.php?id=' . $id_tocho . '&opcion=2&gr=1&campo='.$campo);
       break;
  case 4: //Por Intencioncomunicativa
       redirect('./view.php?id=' . $id_tocho . '&opcion=2&ic=1&campo='.$campo);
       break;
  case 5: //Por tipologia textual
       redirect('./view.php?id=' . $id_tocho . '&opcion=2&tt=1&campo='.$campo);
       break;
}

?>
