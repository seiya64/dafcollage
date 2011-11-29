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

$mform = new mod_vocabulario_gramatica_desc_form();

$grid = optional_param('grid', 0, PARAM_INT);

$id_mp = optional_param('id_mp',null,PARAM_INT);

//averiguo quien soy
$user_object = get_record('user', 'id', $USER->id);

$gram = new Vocabulario_mis_gramaticas();
$gram->leer($grid);

if ($mform->is_cancelled()) {
    redirect('./view.php?id=' . $id_tocho . '&opcion=5&grid=' . $gram->get('gramaticaid'));
}

switch ($gram->get('gramaticaid')) {
    default:
        $desc = optional_param('descripcion', null, PARAM_TEXT);
        break;
    //allgemaines
    case 2:
    case 7:
    case 21:
    case 34:
    case 44:
    case 52:
    case 56:
    case 59:
    case 72:
        $desc = optional_param('generales', null, PARAM_TEXT) . '&' . optional_param('particulares', null, PARAM_TEXT);
        break;
    //5.3
    case 46:
        $desc = optional_param('NM1', null, PARAM_TEXT) . '&' . optional_param('NN1', null, PARAM_TEXT) . '&' . optional_param('NF1', null, PARAM_TEXT) . '&';
        $desc .= optional_param('NP1', null, PARAM_TEXT) . '&' . optional_param('AM1', null, PARAM_TEXT) . '&' . optional_param('AN1', null, PARAM_TEXT) . '&';
        $desc .= optional_param('AF1', null, PARAM_TEXT) . '&' . optional_param('AP1', null, PARAM_TEXT) . '&' . optional_param('DM1', null, PARAM_TEXT) . '&';
        $desc .= optional_param('DN1', null, PARAM_TEXT) . '&' . optional_param('DF1', null, PARAM_TEXT) . '&' . optional_param('DP1', null, PARAM_TEXT) . '&';
        $desc .= optional_param('GM1', null, PARAM_TEXT) . '&' . optional_param('GN1', null, PARAM_TEXT) . '&' . optional_param('GF1', null, PARAM_TEXT) . '&';
        $desc .= optional_param('GP1', null, PARAM_TEXT) . '&' . optional_param('NM2', null, PARAM_TEXT) . '&' . optional_param('NN2', null, PARAM_TEXT) . '&';
        $desc .= optional_param('NF2', null, PARAM_TEXT) . '&' . optional_param('NP2', null, PARAM_TEXT) . '&' . optional_param('AM2', null, PARAM_TEXT) . '&';
        $desc .= optional_param('AN2', null, PARAM_TEXT) . '&' . optional_param('AF2', null, PARAM_TEXT) . '&' . optional_param('AP2', null, PARAM_TEXT) . '&';
        $desc .= optional_param('DM2', null, PARAM_TEXT) . '&' . optional_param('DN2', null, PARAM_TEXT) . '&' . optional_param('DF2', null, PARAM_TEXT) . '&';
        $desc .= optional_param('DP2', null, PARAM_TEXT) . '&' . optional_param('GM2', null, PARAM_TEXT) . '&' . optional_param('GN2', null, PARAM_TEXT) . '&';
        $desc .= optional_param('GF2', null, PARAM_TEXT) . '&' . optional_param('GP2', null, PARAM_TEXT) . '&' . optional_param('NM3', null, PARAM_TEXT) . '&';
        $desc .= optional_param('NN3', null, PARAM_TEXT) . '&' . optional_param('NF3', null, PARAM_TEXT) . '&' . optional_param('NP3', null, PARAM_TEXT) . '&';
        $desc .= optional_param('AM3', null, PARAM_TEXT) . '&' . optional_param('AN3', null, PARAM_TEXT) . '&' . optional_param('AF3', null, PARAM_TEXT) . '&';
        $desc .= optional_param('AP3', null, PARAM_TEXT) . '&' . optional_param('DM3', null, PARAM_TEXT) . '&' . optional_param('DN3', null, PARAM_TEXT) . '&';
        $desc .= optional_param('DF3', null, PARAM_TEXT) . '&' . optional_param('DP3', null, PARAM_TEXT) . '&' . optional_param('GM3', null, PARAM_TEXT) . '&';
        $desc .= optional_param('GN3', null, PARAM_TEXT) . '&' . optional_param('GF3', null, PARAM_TEXT) . '&' . optional_param('GP3', null, PARAM_TEXT);
        break;
    //tablas verbos
    case 23:
    case 24:
    case 27:
    case 28:
    case 29:
    case 30:
    case 31:
        $desc = optional_param('S1I', null, PARAM_TEXT) . '&' . optional_param('S1C', null, PARAM_TEXT) . '&';
        $desc .= optional_param('S2I', null, PARAM_TEXT) . '&' . optional_param('S2C', null, PARAM_TEXT) . '&';
        $desc .= optional_param('S3I', null, PARAM_TEXT) . '&' . optional_param('S3C', null, PARAM_TEXT) . '&';
        $desc .= optional_param('P1I', null, PARAM_TEXT) . '&' . optional_param('P1C', null, PARAM_TEXT) . '&';
        $desc .= optional_param('P2I', null, PARAM_TEXT) . '&' . optional_param('P2C', null, PARAM_TEXT) . '&';
        $desc .= optional_param('P3I', null, PARAM_TEXT) . '&' . optional_param('P3C', null, PARAM_TEXT) . '&';
        $desc .= optional_param('descripcion', null, PARAM_TEXT);
        break;
    //participio2
    case 25:
        $desc = optional_param('participio2', null, PARAM_TEXT) . '&' . optional_param('hilfsverbs', null, PARAM_TEXT);
        break;
    //participio1
    case 26:
        $desc = optional_param('participio1', null, PARAM_TEXT);
        break;
    //passiv
    case 32:
        $desc = optional_param('zustandspassiv', null, PARAM_TEXT) . '&' . optional_param('vorganspassiv', null, PARAM_TEXT);
        break;
    //articulos
    case 35:
    case 36:
    case 37:
    case 38:
    case 39:
    case 40:
    //pronombres
    case 8:
    case 9:
    case 10:
    case 16:
        $desc = optional_param('NM1', null, PARAM_TEXT) . '&' . optional_param('NN1', null, PARAM_TEXT) . '&' . optional_param('NF1', null, PARAM_TEXT) . '&';
        $desc .= optional_param('NP1', null, PARAM_TEXT) . '&' . optional_param('AM1', null, PARAM_TEXT) . '&' . optional_param('AN1', null, PARAM_TEXT) . '&';
        $desc .= optional_param('AF1', null, PARAM_TEXT) . '&' . optional_param('AP1', null, PARAM_TEXT) . '&' . optional_param('DM1', null, PARAM_TEXT) . '&';
        $desc .= optional_param('DN1', null, PARAM_TEXT) . '&' . optional_param('DF1', null, PARAM_TEXT) . '&' . optional_param('DP1', null, PARAM_TEXT) . '&';
        $desc .= optional_param('GM1', null, PARAM_TEXT) . '&' . optional_param('GN1', null, PARAM_TEXT) . '&' . optional_param('GF1', null, PARAM_TEXT) . '&';
        $desc .= optional_param('GP1', null, PARAM_TEXT) . '&' . optional_param('descripcion', null, PARAM_TEXT);
        break;
    case 41:
        $desc = optional_param('lista', null, PARAM_TEXT) . '&' . optional_param('scheinbare', null, PARAM_TEXT);
        break;
}

$gram->set(null, null, $desc);
$gram->actualizar();

$soy = optional_param('id_mp',null,PARAM_INT);
if ($soy != 0){
    redirect('./view.php?id=' . $id_tocho . '&opcion=1&id_mp='.$id_mp);
}
else{
    redirect('./view.php?id=' . $id_tocho . '&opcion=5');
}
?>
