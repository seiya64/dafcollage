<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once("../../config.php");
require_once("lib.php");
require_once("vocabulario_classes.php");
require_once("vocabulario_formularios.php");

$mform = new mod_vocabulario_buscar_intenciones_form();

$id_tocho = optional_param('id_tocho', 0, PARAM_INT);

if ($mform->is_cancelled()) {
    redirect('./view.php?id=' . $id_tocho);
}else{ //Estoy buscando
    $middle = optional_param('buscarpor', PARAM_TEXT);
    
  /*  $mintencion = new Vocabulario_mis_intenciones();
    $misintenciones=$mintencion->recuperar_middles($USER->id,$middle);
    
    echo "vuelta";
    die;*/
    
}

redirect('./view.php?id=' . $id_tocho . '&opcion=17&middle=' . $middle);
?>
