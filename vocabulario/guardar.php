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
 * ESTE FICHERO SE ENCARGA DEL GUARDADO Y ACTUALIZACIÓN DE LAS PALABRAS, NO DE LAS GRAMATICAS
 */

require_once("../../config.php");
require_once("lib.php");
require_once("vocabulario_classes.php");
require_once("vocabulario_formularios.php");




global $DB;

$mform = new mod_vocabulario_rellenar_form();

$id_tocho = optional_param('id_tocho', 0, PARAM_INT);
$borrar = optional_param('borrar', 0, PARAM_INT);
$act = optional_param('act', 0, PARAM_INT);
$anadiendo= optional_param('anadiendo', 0, PARAM_INT);
$viene= optional_param('viene', 0, PARAM_INT);

if($anadiendo){ //Si estoy anadiendo desde tabla interactiva
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

$leido = optional_param('idleido', 0, PARAM_INT);


if ($borrar > 0) {
    echo "borrando ". $borrar;
    $DB->delete_records('vocabulario_mis_palabras',array('id'=> $borrar));
    redirect('./view.php?id=' . $id_tocho . '&opcion=2');
}
if ($anadiendo || $act == 1) { // añado desde la tabla o actualizo
    //leo un sustantivo y lo guardo
$sustantivo_leido = new Vocabulario_sustantivo(required_param('palabra_sus',  PARAM_TEXT),
                optional_param('genero', 3, PARAM_INT),
                optional_param('plural', ' ', PARAM_TEXT),
                optional_param('significado_sus', ' ', PARAM_TEXT),
                optional_param('observaciones_sus', ' ', PARAM_TEXT),
                optional_param('finalgramatica_sus', 1, PARAM_INT),
                optional_param('intencion_sus', 1, PARAM_INT),
                optional_param('tipologia_sus', 1, PARAM_INT),
                optional_param('ejemplo_sus', " ", PARAM_TEXT));
//leo un verbo y lo guardo
$verbo_leido = new Vocabulario_verbo(optional_param('infinitivo', ' ', PARAM_TEXT),
                optional_param('ter_pers_sing', ' ', PARAM_TEXT),
                optional_param('preterito', ' ', PARAM_TEXT),
                optional_param('participio', ' ', PARAM_TEXT),
                optional_param('significado_vrb', ' ', PARAM_TEXT),
                optional_param('observaciones_vrb', ' ', PARAM_TEXT),
                optional_param('finalgramatica_vrb', 1, PARAM_INT),
                optional_param('intencion_vrb', 1, PARAM_INT),
                optional_param('tipologia_vrb', 1, PARAM_INT));
//leo un adjetivo y lo guardo
$adjetivo_leido = new Vocabulario_adjetivo(optional_param('sindeclinar', '', PARAM_TEXT),
                optional_param('significado_adj', ' ', PARAM_TEXT),
                optional_param('observaciones_adj', ' ', PARAM_TEXT),
                optional_param('finalgramatica_adj', 1, PARAM_INT),
                optional_param('intencion_adj', 1, PARAM_INT),
                optional_param('tipologia_adj', 1, PARAM_INT));
//leo otra palabra y la guardo
$otro_leido = new Vocabulario_otro(optional_param('palabra_otr', '', PARAM_TEXT),
                optional_param('significado_otr', ' ', PARAM_TEXT),
                optional_param('observaciones_otr', ' ', PARAM_TEXT),
                optional_param('finalgramatica_otr', 1, PARAM_INT),
                optional_param('intencion_otr', 1, PARAM_INT),
                optional_param('tipologia_otr', 1, PARAM_INT));
$campo_leido = optional_param('campoid', 1,  PARAM_INT);
}
else {
    //leo un sustantivo y lo guardo
$sustantivo_leido = new Vocabulario_sustantivo(required_param('palabra_sus', PARAM_TEXT),
                optional_param('genero', 3, PARAM_INT),
                optional_param('plural', ' ', PARAM_TEXT),
                optional_param('significado_sus', ' ', PARAM_TEXT),
                optional_param('observaciones_sus', ' ', PARAM_TEXT),
                optional_param('gramatica_sus', 1, PARAM_INT),
                optional_param('intencion_sus', 1, PARAM_INT),
                optional_param('tipologia_sus', 1, PARAM_INT),
                optional_param('ejemplo_sus', " ", PARAM_TEXT));
//leo un verbo y lo guardo
$verbo_leido = new Vocabulario_verbo(optional_param('infinitivo', '', PARAM_TEXT),
                optional_param('ter_pers_sing', ' ', PARAM_TEXT),
                optional_param('preterito', ' ', PARAM_TEXT),
                optional_param('participio', ' ', PARAM_TEXT),
                optional_param('significado_vrb', ' ', PARAM_TEXT),
                optional_param('observaciones_vrb', ' ', PARAM_TEXT),
                optional_param('gramatica_vrb', 1, PARAM_INT),
                optional_param('intencion_vrb', 1, PARAM_INT),
                optional_param('tipologia_vrb', 1, PARAM_INT));
//leo un adjetivo y lo guardo
$adjetivo_leido = new Vocabulario_adjetivo(optional_param('sindeclinar', '', PARAM_TEXT),
                optional_param('significado_adj', ' ', PARAM_TEXT),
                optional_param('observaciones_adj', ' ', PARAM_TEXT),
                optional_param('gramatica_adj', 1, PARAM_INT),
                optional_param('intencion_adj', 1, PARAM_INT),
                optional_param('tipologia_adj', 1, PARAM_INT));
//leo otra palabra y la guardo
$otro_leido = new Vocabulario_otro(optional_param('palabra_otr', '', PARAM_TEXT),
                optional_param('significado_otr', ' ', PARAM_TEXT),
                optional_param('observaciones_otr', ' ', PARAM_TEXT),
                optional_param('gramatica_otr', 1, PARAM_INT),
                optional_param('intencion_otr', 1, PARAM_INT),
                optional_param('tipologia_otr', 1, PARAM_INT));
$campo_leido = optional_param('campoid', 1, PARAM_INT);
}

//compruebo si voy a actualizar o a insertar
if ($act == 1) {
    $id_actualizable = optional_param('idleido', 0, PARAM_INT);
    if ($id_actualizable > 0) {
      echo "actualizando ". $id_actualizable;
      $cosa_leida = new Vocabulario_mis_palabras();
      $cosa_leida->leer($id_actualizable);
      //print_r($cosa_leida);die();  
      $cosa_leida->actualizar($sustantivo_leido, $verbo_leido, $adjetivo_leido, $otro_leido, $campo_leido);
    }
} else {
      echo "insertando ";
      $cosa_leida = new Vocabulario_mis_palabras($USER->id, $sustantivo_leido, $verbo_leido, $adjetivo_leido, $otro_leido, $campo_leido);
      
      $cosa_leida->guardar();
}


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
