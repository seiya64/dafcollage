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

global $DB;

$id_tocho = optional_param('id_tocho', 0, PARAM_INT);

$mform = new mod_vocabulario_nuevo_gr_form();

if ($mform->is_cancelled()) {
    redirect('./view.php?id=' . $id_tocho);
}

//averiguo quien soy
$user_object = $DB->get_record('user', array('id'=>$USER->id));

$padre = required_param('campogr', PARAM_TEXT);



//recogemos todos los datos de la gramatica
switch ($padre) {
    default:
        //$desc = optional_param('descripcion', '', PARAM_TEXT);
        $desc = '';
        break;
    //1.1 Genus
    case 3:
        $desc = optional_param('mascsemantico', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('mascformal', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('femsemantico', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('femformal', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('neutrosemantico', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('neutroformal', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        //echo $desc;
        break;
    //1.2 Numerus
    case 4:
        $desc = optional_param('endungs', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('genero', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('endungp', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('reinesf', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('reinepf', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        break;
    //5.2.1 Deklination
    case 47:
        $desc = optional_param('NM1', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NN1', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NF1', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('NP1', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AM1', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AN1', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('AF1', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AP1', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DM1', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('DN1', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DF1', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DP1', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('GM1', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('GN1', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('GF1', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('GP1', '', PARAM_TEXT) . __SEPARADORCAMPOS__;

        $desc .= optional_param('idea1', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('despuesde1', '', PARAM_TEXT) . __SEPARADORCAMPOS__;


        $desc .= optional_param('NM2', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NN2', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('NF2', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NP2', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AM2', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('AN2', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AF2', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AP2', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('DM2', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DN2', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DF2', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('DP2', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('GM2', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('GN2', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('GF2', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('GP2', '', PARAM_TEXT) . __SEPARADORCAMPOS__;

        $desc .= optional_param('idea2', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('despuesde2', '', PARAM_TEXT) . __SEPARADORCAMPOS__;

        $desc .= optional_param('NM3', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('NN3', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NF3', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NP3', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('AM3', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AN3', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AF3', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('AP3', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DM3', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DN3', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('DF3', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DP3', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('GM3', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('GN3', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('GF3', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('GP3', '', PARAM_TEXT) . __SEPARADORCAMPOS__;

        $desc .= optional_param('idea3', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('despuesde3', '', PARAM_TEXT) . __SEPARADORCAMPOS__;

        break;
    //tablas verbos
    //3.1.1 Präsens
    case 21:
    //3.1.2 Präteritum
    case 22:
        $tope = 20;
        $desc = '';
        for ($i = 0; $i < $tope; $i++) {
            $desc .= optional_param('INFSC' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('S1SC' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('S2SC' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('S3SC' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('P1SC' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('P2SC' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('P3SC' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('INFST' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('S1ST' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('S2ST' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('S3ST' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('P1ST' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('P2ST' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('P3ST' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('INFGE' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('S1GE' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('S2GE' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('S3GE' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('P1GE' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('P2GE' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('P3GE' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        }
        break;
    //3.1.5 Futur I
    case 25:
        $desc = optional_param('futuro1', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        break;
    //3.1.6 Futur II
    case 26:
        $desc = optional_param('futuro2', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        break;
    //3.7.2 Konjunktiv II
    case 34:
        $desc = optional_param('S1SC' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('S2SC' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('S3SC' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('P1SC' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('P2SC' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('P3SC' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;

        $desc .= optional_param('S1P', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('S1K', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('S2P', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('S2K', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('S3P', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('S3K', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('P1P', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('P1K', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('P2P', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('P2K', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('P3P', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('P3K', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        break;
    //3.3 Trennbare Verben
    case 28:
        $desc = optional_param('trennbaren', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        break;

    //3.2 Modalverben
    case 27:
    //3.4 Besondere Verben
    case 29:
        if ($padre == 27) {
            $tope = 6;
        } elseif ($padre == 29) {
            $tope = 10;
        }
        $desc = '';
        for ($i = 0; $i < $tope; $i++) {
            $desc .= optional_param('INF' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('S1PRA' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('S1PRE' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('S1PER' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('S1PC1' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('S1PC2' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('S2PRA' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('S2PRE' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('S2PER' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('S2PC1' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('S2PC2' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('S3PRA' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('S3PRE' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('S3PER' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('S3PC1' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('S3PC2' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('P1PRA' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('P1PRE' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('P1PER' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('P1PC1' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('P1PC2' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('P2PRA' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('P2PRE' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('P2PER' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('P2PC1' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('P2PC2' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('P3PRA' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('P3PRE' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('P3PER' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('P3PC1' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('P3PC2' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        }
        //echo $desc;
        break;
    //3.7.1 Konjunktiv I
    case 33:
        $desc = optional_param('S1I', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('S1C', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('S2I', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('S2C', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('S3I', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('S3C', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('P1I', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('P1C', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('P2I', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('P2C', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('P3I', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('P3C', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        //$desc .= optional_param('descripcion', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('todocontodo', '', PARAM_TEXT);
        break;
    //3.1.3 Perfekt/Partizip II
    case 23:
        $desc = optional_param('irregulares', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('participio2', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('hilfsverbs', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        break;
    //3.1.4 Partizip I
    case 24:
        $desc = optional_param('participio1', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        break;
    //3.6 Passiv
    case 31:
        $desc = optional_param('zustandspassiv', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('vorganspassiv', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        break;
    //2.5 Possessivpronomen
    case 15:
        $tope = 1;
        $desc = '';

        for ($i = 0; $i < $tope; $i++) {

            $desc = optional_param('NS1' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NS2' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('NS3M' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NS3N' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NS3F' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('NP1' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NP2' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NP3' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NSIE' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;

            $desc .= optional_param('NM' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NN' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NF' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('NP' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AM' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AN' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('AF' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AP' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DM' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('DN' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DF' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DP' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('GM' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('GN' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('GF' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('GP' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            //. __SEPARADORCAMPOS__ . optional_param('descripcion', '', PARAM_TEXT);
        }
        break;
    //4.3 Possessivartikel
    case 39:
        $desc = optional_param('NS1', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NS2', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('NS3M', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NS3N', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NS3F', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('NP1', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NP2', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NP3', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NSIE', '', PARAM_TEXT) . __SEPARADORCAMPOS__;

        // los de la tabla opcional

        $desc .= optional_param('NM' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NN' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NF' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('NP' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AM' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AN' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('AF' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AP' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DM' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('DN' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DF' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DP' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('GM' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('GN' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('GF' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('GP' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        break;
    //4.1 Bestimmte Artikel
    case 37:
    //4.2 Unbestimmte Artikel
    case 38:
    //4.4 Negationsartikel
    case 40:
    //4.5 Interrogativartikel
    case 41:
    //4.6 Demonstrativartikel
    case 42:
    //2.3 Demonstrativpronomen
    case 9:
    //2.6 Relativpronomen
    case 16:
    //2.4.1 Als Artikelwörter gebrauche Indefinitpronomina
    case 11:
    //1.3 Deklination
    case 5:
        //para restrngir según la categoria
        $tope = 1;
        switch ($padre) {
            default:
                $tope = 1;
                break;
            case 9:
                $tope = 4;
                break;
            case 5:
                $tope = 10;
                break;
        }
        $desc = '';
        for ($i = 0; $i < $tope; $i++) {
            $desc .= optional_param('NM1' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NN1' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NF1' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('NP1' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AM1' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AN1' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('AF1' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AP1' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DM1' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('DN1' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DF1' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DP1' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('GM1' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('GN1' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('GF1' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('GP1' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            //. __SEPARADORCAMPOS__ . optional_param('descripcion', '', PARAM_TEXT);
        }
        break;
    //4.7 Gebrauch der Artikelwörter
    /* case 42:
      $desc = optional_param('lista', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('scheinbare', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
      break;
     */
    //7.1 Beispiele und Funktionen
    case 54:
        $desc = optional_param('beispielsatz', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('satzart', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('komfun', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        break;
    //2.2 Interrogativpronomen
    case 8:
        $desc = '';
        for ($i = 0; $i < 3; $i++) {
            $desc .= optional_param('NP' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NNP' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('AP' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('ANP' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('DP' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DNP' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('GP' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('GNP' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        }
        break;
    //8.3.1 Ergänzungen
    case 59:
        $desc = optional_param('definido', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('indefinido', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        break;
    //8.3.2 Angaben
    case 60:
        $desc = optional_param('temporal', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('causal', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('modal', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('local', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        break;
    //8.4.1 Konjunktoren
    case 63:
    //8.4.2 Subjunktoren
    case 64:
    //8.4.3 Konjunktionaladverbien
    case 65:
        $desc = optional_param('func', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('siehe', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        break;
    //8.1 Hauptsatz
    case 56:

        $salir = false;
        $desc = '';
        $avance = 1;

        $avance = 4;

        for ($i = 0; $salir == false; $i = $i + $avance) {
            if (optional_param('VORSUB' . $i, '', PARAM_TEXT) ||
                    optional_param('KONSUB' . $i, '', PARAM_TEXT) ||
                    optional_param('MIT' . $i, '', PARAM_TEXT) ||
                    optional_param('VER2' . $i, '', PARAM_TEXT) ||
                    optional_param('VER1' . $i, '', PARAM_TEXT)) {

                $desc .= optional_param('VORSUB' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('KONSUB' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
                $desc .= optional_param('MIT' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('VER2' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            } else {
                $salir = true;
            }
        }
        $desc .= __SEPARADORCAMPOS__ . __SEPARADORCAMPOS__ . __SEPARADORCAMPOS__ . __SEPARADORCAMPOS__;

        break;

    //8.2 Nebensatz
    case 57:
        $salir = false;
        $desc = '';

        $avance = 5;

        for ($i = 0; $salir == false; $i = $i + $avance) {
            if (optional_param('VORSUB' . $i, '', PARAM_TEXT) ||
                    optional_param('KONSUB' . $i, '', PARAM_TEXT) ||
                    optional_param('MIT' . $i, '', PARAM_TEXT) ||
                    optional_param('VER2' . $i, '', PARAM_TEXT) ||
                    optional_param('VER1' . $i, '', PARAM_TEXT)) {

                $desc .= optional_param('VORSUB' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('KONSUB' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
                $desc .= optional_param('MIT' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('VER2' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;

                $desc .= optional_param('VER1' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            } else {
                $salir = true;
            }
        }
        $desc .= __SEPARADORCAMPOS__ . __SEPARADORCAMPOS__ . __SEPARADORCAMPOS__ . __SEPARADORCAMPOS__ . __SEPARADORCAMPOS__;
        break;
    //2.4.2.1 Pronomina, die nur Personen bezeichnen
    case 13:
        $tope = 5;
        $desc = '';
        for ($i = 0; $i < $tope; $i++) {
            $desc .= optional_param('DEFA' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('NOM' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AKK' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            $desc .= optional_param('DAT' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('GEN' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        }
        break;
    //2.1 Personalpronomen
    case 7:
        $desc = optional_param('NS1', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NS2', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('NS3M', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NS3N', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NS3F', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('NP1', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NP2', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NP3', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('NSIE', '', PARAM_TEXT) . __SEPARADORCAMPOS__;

        $desc .= optional_param('AS1', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AS2', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('AS3M', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AS3N', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AS3F', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('AP1', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AP2', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AP3', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('ASIE', '', PARAM_TEXT) . __SEPARADORCAMPOS__;

        $desc .= optional_param('DS1', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DS2', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('DS3M', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DS3N', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DS3F', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('DP1', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DP2', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DP3', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DSIE', '', PARAM_TEXT) . __SEPARADORCAMPOS__;

        $desc .= optional_param('GS1', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('GS2', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('GS3M', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('GS3N', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('GS3F', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('GP1', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('GP2', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('GP3', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('GSIE', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        break;
    //3.8 Imperativ
    case 35:
        $tope = 10;
        $desc = '';
        for ($i = 0; $i < $tope; $i++) {
            $desc .= optional_param('INF' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('S2' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('P2' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('SIE' . $i, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        }
        break;
    //3.5 Reflexive und reziproke Verben
    case 30:
        $desc = optional_param('AS1', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AS2', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AS3', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('AP1', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AP2', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('AP3', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('ASIE', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('DS1', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DS2', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DS3', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('DP1', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DP2', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('DP3', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        $desc .= optional_param('DSIE', '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        break;
    //4.7 Gebrauch der Artikelwörter
    case 43:
        $tope = 20;
        $tablas = 3;
        $desc = '';
        for ($t = 0; $t < $tablas; $t++) {
            for ($f = 0; $f < $tope; $f++) {
                $desc .= optional_param('BE' . $t . '_' . $f, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('GE' . $t . '_' . $f, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            }
        }
        break;
    case 48:
        $tope = 10;
        $desc = '';
        for ($f = 0; $f < $tope; $f++) {
            $desc .= optional_param('PO' . $f, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('KO' . $f, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('SU' . $f, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
        }
        break;
    // 6.1
    case 51:
        $salir = false;
        $desc = '';

        for ($f = 0; $salir == false; $f++) {
            if (optional_param('PRA' . $f, '', PARAM_TEXT) ||
                    optional_param('FUN' . $f, '', PARAM_TEXT) ||
                    optional_param('KAS' . $f, '', PARAM_TEXT) ||
                    optional_param('BEI' . $f, '', PARAM_TEXT)
            ) {

                $desc .= optional_param('PRA' . $f, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('FUN' . $f, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
                $desc .= optional_param('KAS' . $f, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('BEI' . $f, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            } else {
                $salir = true;
            }
        }
        break;

    case 68:
        $salir = false;
        $desc = '';

        for ($f = 0; $salir == false; $f++) {
            if (optional_param('PRA' . $f, '', PARAM_TEXT) ||
                    optional_param('SUF' . $f, '', PARAM_TEXT) ||
                    optional_param('BEI' . $f, '', PARAM_TEXT) ||
                    optional_param('BED' . $f, '', PARAM_TEXT)
            ) {

                $desc .= optional_param('PRA' . $f, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('SUF' . $f, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
                $desc .= optional_param('BEI' . $f, '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('BED' . $f, '', PARAM_TEXT) . __SEPARADORCAMPOS__;
            } else {
                $salir = true;
            }
        }
        break;
}

//soluciones varias
$desc .= optional_param('descripcion', '', PARAM_TEXT) . __SEPARADORCAMPOS__ . optional_param('miraren', '', PARAM_TEXT);

//vemos que botón hemos pulsado
if ($mform->no_submit_button_pressed()) {

    if (optional_param('desc_btn', '', PARAM_TEXT)) {
        //$graux = new Vocabulario_mis_gramaticas($user_object->id,$gram->get('padre'),$desc);
        $graux = new Vocabulario_mis_gramaticas($user_object->id, $padre, $desc);
        $graux->guardar();
    }
}

//volvemos a donde veniamos
redirect('./view.php?id=' . $id_tocho . '&opcion=5&grid=' . $padre);
//echo '<a href="./view.php?id='.$id_tocho.'&opcion=5&grid='.$misgram['gramaticaid'].'">continuar</a>';
?>
