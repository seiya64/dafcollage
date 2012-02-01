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

$mform = new mod_vocabulario_nuevo_gr_form();

if ($mform->is_cancelled()) {
    redirect('./view.php?id=' . $id_tocho);
}

//averiguo quien soy
$user_object = get_record('user', 'id', $USER->id);

$padre = required_param('campogr', PARAM_TEXT);

//$gram = new Vocabulario_gramatica($user_object->id, required_param('campogr', PARAM_TEXT), optional_param('gramatica', PARAM_TEXT));

/*if (optional_param('eliminar', 0, PARAM_INT) && $gram->get('padre') > 72) {
    delete_records('vocabulario_gramatica', 'id', $gram->get('padre'));
    redirect('./view.php?id=' . $id_tocho . '&opcion=5');
}*/

//recogemos todos los datos de la gramatica
switch ($padre) {
    default:
        //$desc = optional_param('descripcion', null, PARAM_TEXT);
        $desc = '';
        break;
    //1.1 Genus
    case 3:
        $desc = optional_param('mascsemantico', null, PARAM_TEXT) . '&' . optional_param('mascformal', null, PARAM_TEXT). '&';
        $desc .= optional_param('femsemantico', null, PARAM_TEXT) . '&' . optional_param('femformal', null, PARAM_TEXT). '&';
        $desc .= optional_param('neutrosemantico', null, PARAM_TEXT) . '&' . optional_param('neutroformal', null, PARAM_TEXT). '&';
        echo $desc;
        break;
    //1.2 Numerus
    case 4:
        $desc = optional_param('endungs', null, PARAM_TEXT) . '&' . optional_param('genero', null, PARAM_TEXT) . '&';
        $desc .= optional_param('endungp', null, PARAM_TEXT) . '&' . optional_param('reinesf', null, PARAM_TEXT) . '&';
        $desc .= optional_param('reinepf', null, PARAM_TEXT) . '&';
        break;
    //5.2.1 Deklination
    case 47:
        $desc = optional_param('NM1', null, PARAM_TEXT) . '&' . optional_param('NN1', null, PARAM_TEXT) . '&' . optional_param('NF1', null, PARAM_TEXT) . '&';
        $desc .= optional_param('NP1', null, PARAM_TEXT) . '&' . optional_param('AM1', null, PARAM_TEXT) . '&' . optional_param('AN1', null, PARAM_TEXT) . '&';
        $desc .= optional_param('AF1', null, PARAM_TEXT) . '&' . optional_param('AP1', null, PARAM_TEXT) . '&' . optional_param('DM1', null, PARAM_TEXT) . '&';
        $desc .= optional_param('DN1', null, PARAM_TEXT) . '&' . optional_param('DF1', null, PARAM_TEXT) . '&' . optional_param('DP1', null, PARAM_TEXT) . '&';
        $desc .= optional_param('GM1', null, PARAM_TEXT) . '&' . optional_param('GN1', null, PARAM_TEXT) . '&' . optional_param('GF1', null, PARAM_TEXT) . '&';
        $desc .= optional_param('GP1', null, PARAM_TEXT) . '&';

        $desc .= optional_param('idea1', null, PARAM_TEXT) . '&' . optional_param('despuesde1', null, PARAM_TEXT) . '&';
        
        
        $desc .= optional_param('NM2', null, PARAM_TEXT) . '&' . optional_param('NN2', null, PARAM_TEXT) . '&';
        $desc .= optional_param('NF2', null, PARAM_TEXT) . '&' . optional_param('NP2', null, PARAM_TEXT) . '&' . optional_param('AM2', null, PARAM_TEXT) . '&';
        $desc .= optional_param('AN2', null, PARAM_TEXT) . '&' . optional_param('AF2', null, PARAM_TEXT) . '&' . optional_param('AP2', null, PARAM_TEXT) . '&';
        $desc .= optional_param('DM2', null, PARAM_TEXT) . '&' . optional_param('DN2', null, PARAM_TEXT) . '&' . optional_param('DF2', null, PARAM_TEXT) . '&';
        $desc .= optional_param('DP2', null, PARAM_TEXT) . '&' . optional_param('GM2', null, PARAM_TEXT) . '&' . optional_param('GN2', null, PARAM_TEXT) . '&';
        $desc .= optional_param('GF2', null, PARAM_TEXT) . '&' . optional_param('GP2', null, PARAM_TEXT) . '&';

        $desc .= optional_param('idea2', null, PARAM_TEXT) . '&' . optional_param('despuesde2', null, PARAM_TEXT) . '&';
        
        $desc .= optional_param('NM3', null, PARAM_TEXT) . '&';
        $desc .= optional_param('NN3', null, PARAM_TEXT) . '&' . optional_param('NF3', null, PARAM_TEXT) . '&' . optional_param('NP3', null, PARAM_TEXT) . '&';
        $desc .= optional_param('AM3', null, PARAM_TEXT) . '&' . optional_param('AN3', null, PARAM_TEXT) . '&' . optional_param('AF3', null, PARAM_TEXT) . '&';
        $desc .= optional_param('AP3', null, PARAM_TEXT) . '&' . optional_param('DM3', null, PARAM_TEXT) . '&' . optional_param('DN3', null, PARAM_TEXT) . '&';
        $desc .= optional_param('DF3', null, PARAM_TEXT) . '&' . optional_param('DP3', null, PARAM_TEXT) . '&' . optional_param('GM3', null, PARAM_TEXT) . '&';
        $desc .= optional_param('GN3', null, PARAM_TEXT) . '&' . optional_param('GF3', null, PARAM_TEXT) . '&' . optional_param('GP3', null, PARAM_TEXT) . '&';
        
        $desc .= optional_param('idea3', null, PARAM_TEXT) . '&' . optional_param('despuesde3', null, PARAM_TEXT) . '&';

        break;
    //tablas verbos
    //3.1.1 Präsens
    case 21:
    //3.1.2 Präteritum
    case 22:
        $tope=20;
        $desc='';
        for ($i=0; $i<$tope; $i++){
            $desc .= optional_param('INFSC'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('S1SC'.$i, null, PARAM_TEXT) . '&' . optional_param('S2SC'.$i, null, PARAM_TEXT) . '&' . optional_param('S3SC'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('P1SC'.$i, null, PARAM_TEXT) . '&' . optional_param('P2SC'.$i, null, PARAM_TEXT) . '&' . optional_param('P3SC'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('INFST'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('S1ST'.$i, null, PARAM_TEXT) . '&' . optional_param('S2ST'.$i, null, PARAM_TEXT) . '&' . optional_param('S3ST'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('P1ST'.$i, null, PARAM_TEXT) . '&' . optional_param('P2ST'.$i, null, PARAM_TEXT) . '&' . optional_param('P3ST'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('INFGE'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('S1GE'.$i, null, PARAM_TEXT) . '&' . optional_param('S2GE'.$i, null, PARAM_TEXT) . '&' . optional_param('S3GE'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('P1GE'.$i, null, PARAM_TEXT) . '&' . optional_param('P2GE'.$i, null, PARAM_TEXT) . '&' . optional_param('P3GE'.$i, null, PARAM_TEXT) . '&';
        }
        break;
    //3.1.5 Futur I
    case 25:
        $desc = optional_param('futuro1', null, PARAM_TEXT) . '&';
        break;
    //3.1.6 Futur II
    case 26:
        $desc = optional_param('futuro2', null, PARAM_TEXT) . '&';
        break;
    //3.7.2 Konjunktiv II
    case 34:
        $desc = optional_param('S1SC'.$i, null, PARAM_TEXT) . '&' . optional_param('S2SC'.$i, null, PARAM_TEXT) . '&' . optional_param('S3SC'.$i, null, PARAM_TEXT) . '&';
        $desc .= optional_param('P1SC'.$i, null, PARAM_TEXT) . '&' . optional_param('P2SC'.$i, null, PARAM_TEXT) . '&' . optional_param('P3SC'.$i, null, PARAM_TEXT) . '&';

        $desc .= optional_param('S1P', null, PARAM_TEXT) . '&' . optional_param('S1K', null, PARAM_TEXT) . '&';
        $desc .= optional_param('S2P', null, PARAM_TEXT) . '&' . optional_param('S2K', null, PARAM_TEXT) . '&';
        $desc .= optional_param('S3P', null, PARAM_TEXT) . '&' . optional_param('S3K', null, PARAM_TEXT) . '&';
        $desc .= optional_param('P1P', null, PARAM_TEXT) . '&' . optional_param('P1K', null, PARAM_TEXT) . '&';
        $desc .= optional_param('P2P', null, PARAM_TEXT) . '&' . optional_param('P2K', null, PARAM_TEXT) . '&';
        $desc .= optional_param('P3P', null, PARAM_TEXT) . '&' . optional_param('P3K', null, PARAM_TEXT) . '&';
        break;
    //3.3 Trennbare Verben
    case 28:
        $desc = optional_param('trennbaren', null, PARAM_TEXT) . '&';
        break;

    //3.2 Modalverben
    case 27:
    //3.4 Besondere Verben
    case 29:
        if ($padre == 27){
            $tope = 6;
        }
        elseif ($padre ==29){
            $tope = 10;
        }
        $desc='';
        for ($i=0; $i<$tope; $i++){
            $desc .= optional_param('INF'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('S1PRA'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('S1PRE'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('S1PER'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('S1PC1'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('S1PC2'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('S2PRA'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('S2PRE'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('S2PER'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('S2PC1'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('S2PC2'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('S3PRA'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('S3PRE'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('S3PER'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('S3PC1'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('S3PC2'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('P1PRA'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('P1PRE'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('P1PER'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('P1PC1'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('P1PC2'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('P2PRA'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('P2PRE'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('P2PER'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('P2PC1'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('P2PC2'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('P3PRA'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('P3PRE'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('P3PER'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('P3PC1'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('P3PC2'.$i, null, PARAM_TEXT) . '&';
        }
        echo $desc;
        break;
    //3.7.1 Konjunktiv I
    case 33:
        $desc = optional_param('S1I', null, PARAM_TEXT) . '&' . optional_param('S1C', null, PARAM_TEXT) . '&';
        $desc .= optional_param('S2I', null, PARAM_TEXT) . '&' . optional_param('S2C', null, PARAM_TEXT) . '&';
        $desc .= optional_param('S3I', null, PARAM_TEXT) . '&' . optional_param('S3C', null, PARAM_TEXT) . '&';
        $desc .= optional_param('P1I', null, PARAM_TEXT) . '&' . optional_param('P1C', null, PARAM_TEXT) . '&';
        $desc .= optional_param('P2I', null, PARAM_TEXT) . '&' . optional_param('P2C', null, PARAM_TEXT) . '&';
        $desc .= optional_param('P3I', null, PARAM_TEXT) . '&' . optional_param('P3C', null, PARAM_TEXT) . '&';
        //$desc .= optional_param('descripcion', null, PARAM_TEXT) . '&' . optional_param('todocontodo', null, PARAM_TEXT);
        break;
    //3.1.3 Perfekt/Partizip II
    case 23:
        $desc = optional_param('irregulares', null, PARAM_TEXT) . '&' . optional_param('participio2', null, PARAM_TEXT) . '&' . optional_param('hilfsverbs', null, PARAM_TEXT) . '&';
        break;
    //3.1.4 Partizip I
    case 24:
        $desc = optional_param('participio1', null, PARAM_TEXT) . '&';
        break;
    //3.6 Passiv
    case 31:
        $desc = optional_param('zustandspassiv', null, PARAM_TEXT) . '&' . optional_param('vorganspassiv', null, PARAM_TEXT) . '&';
        break;
    //2.5 Possessivpronomen
    case 15:
        $tope = 1;
        $desc='';

        for ($i=0; $i<$tope; $i++){

            $desc = optional_param('NS1'.$i, null, PARAM_TEXT) . '&' . optional_param('NS2'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('NS3M'.$i, null, PARAM_TEXT) . '&' . optional_param('NS3N'.$i, null, PARAM_TEXT) . '&' . optional_param('NS3F'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('NP1'.$i, null, PARAM_TEXT) . '&' . optional_param('NP2'.$i, null, PARAM_TEXT) . '&' . optional_param('NP3'.$i, null, PARAM_TEXT) . '&' . optional_param('NSIE'.$i, null, PARAM_TEXT) . '&';

            $desc .= optional_param('NM'.$i, null, PARAM_TEXT) . '&' . optional_param('NN'.$i, null, PARAM_TEXT) . '&' . optional_param('NF'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('NP'.$i, null, PARAM_TEXT) . '&' . optional_param('AM'.$i, null, PARAM_TEXT) . '&' . optional_param('AN'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('AF'.$i, null, PARAM_TEXT) . '&' . optional_param('AP'.$i, null, PARAM_TEXT) . '&' . optional_param('DM'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('DN'.$i, null, PARAM_TEXT) . '&' . optional_param('DF'.$i, null, PARAM_TEXT) . '&' . optional_param('DP'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('GM'.$i, null, PARAM_TEXT) . '&' . optional_param('GN'.$i, null, PARAM_TEXT) . '&' . optional_param('GF'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('GP'.$i, null, PARAM_TEXT) . '&';
            //. '&' . optional_param('descripcion', null, PARAM_TEXT);
        }
        break;
    //4.3 Possessivartikel
    case 39:
        $desc = optional_param('NS1', null, PARAM_TEXT) . '&' . optional_param('NS2', null, PARAM_TEXT) . '&';
        $desc .= optional_param('NS3M', null, PARAM_TEXT) . '&' . optional_param('NS3N', null, PARAM_TEXT) . '&' . optional_param('NS3F', null, PARAM_TEXT) . '&';
        $desc .= optional_param('NP1', null, PARAM_TEXT) . '&' . optional_param('NP2', null, PARAM_TEXT) . '&' . optional_param('NP3', null, PARAM_TEXT) . '&' . optional_param('NSIE', null, PARAM_TEXT) . '&';

        // los de la tabla opcional

        $desc .= optional_param('NM'.$i, null, PARAM_TEXT) . '&' . optional_param('NN'.$i, null, PARAM_TEXT) . '&' . optional_param('NF'.$i, null, PARAM_TEXT) . '&';
        $desc .= optional_param('NP'.$i, null, PARAM_TEXT) . '&' . optional_param('AM'.$i, null, PARAM_TEXT) . '&' . optional_param('AN'.$i, null, PARAM_TEXT) . '&';
        $desc .= optional_param('AF'.$i, null, PARAM_TEXT) . '&' . optional_param('AP'.$i, null, PARAM_TEXT) . '&' . optional_param('DM'.$i, null, PARAM_TEXT) . '&';
        $desc .= optional_param('DN'.$i, null, PARAM_TEXT) . '&' . optional_param('DF'.$i, null, PARAM_TEXT) . '&' . optional_param('DP'.$i, null, PARAM_TEXT) . '&';
        $desc .= optional_param('GM'.$i, null, PARAM_TEXT) . '&' . optional_param('GN'.$i, null, PARAM_TEXT) . '&' . optional_param('GF'.$i, null, PARAM_TEXT) . '&';
        $desc .= optional_param('GP'.$i, null, PARAM_TEXT) . '&';
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
        switch ($padre){
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
        $desc='';
        for ($i=0; $i<$tope; $i++){
            $desc .= optional_param('NM1'.$i, null, PARAM_TEXT) . '&' . optional_param('NN1'.$i, null, PARAM_TEXT) . '&' . optional_param('NF1'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('NP1'.$i, null, PARAM_TEXT) . '&' . optional_param('AM1'.$i, null, PARAM_TEXT) . '&' . optional_param('AN1'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('AF1'.$i, null, PARAM_TEXT) . '&' . optional_param('AP1'.$i, null, PARAM_TEXT) . '&' . optional_param('DM1'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('DN1'.$i, null, PARAM_TEXT) . '&' . optional_param('DF1'.$i, null, PARAM_TEXT) . '&' . optional_param('DP1'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('GM1'.$i, null, PARAM_TEXT) . '&' . optional_param('GN1'.$i, null, PARAM_TEXT) . '&' . optional_param('GF1'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('GP1'.$i, null, PARAM_TEXT) . '&';
            //. '&' . optional_param('descripcion', null, PARAM_TEXT);
        }
        break;
    //4.7 Gebrauch der Artikelwörter
    /*case 42:
        $desc = optional_param('lista', null, PARAM_TEXT) . '&' . optional_param('scheinbare', null, PARAM_TEXT) . '&';
        break;
     */
    //7.1 Beispiele und Funktionen
    case 54:
        $desc = optional_param('beispielsatz', null, PARAM_TEXT) . '&' . optional_param('satzart', null, PARAM_TEXT) . '&';
        $desc .= optional_param('komfun', null, PARAM_TEXT) . '&';
        break;
    //2.2 Interrogativpronomen
    case 8:
        $desc = '';
        for($i = 0; $i < 3; $i++){
        $desc .= optional_param('NP'.$i, null, PARAM_TEXT) . '&' . optional_param('NNP'.$i, null, PARAM_TEXT) . '&';
        $desc .= optional_param('AP'.$i, null, PARAM_TEXT) . '&' . optional_param('ANP'.$i, null, PARAM_TEXT) . '&';
        $desc .= optional_param('DP'.$i, null, PARAM_TEXT) . '&' . optional_param('DNP'.$i, null, PARAM_TEXT) . '&';
        $desc .= optional_param('GP'.$i, null, PARAM_TEXT) . '&' . optional_param('GNP'.$i, null, PARAM_TEXT) . '&';
        }
        break;
    //8.3.1 Ergänzungen
    case 59:
        $desc = optional_param('definido', null, PARAM_TEXT) . '&' . optional_param('indefinido', null, PARAM_TEXT) . '&';
        break;
    //8.3.2 Angaben
    case 60:
        $desc = optional_param('temporal', null, PARAM_TEXT) . '&' . optional_param('causal', null, PARAM_TEXT) . '&';
        $desc .= optional_param('modal', null, PARAM_TEXT) . '&' . optional_param('local', null, PARAM_TEXT) . '&';
        break;
    //8.4.1 Konjunktoren
    case 63:
    //8.4.2 Subjunktoren
    case 64:
    //8.4.3 Konjunktionaladverbien
    case 65:
        $desc = optional_param('func', null, PARAM_TEXT) . '&';
        $desc .= optional_param('siehe', null, PARAM_TEXT) . '&';
        break;
    //8.1 Hauptsatz
    case 56:
    //8.2 Nebensatz
    case 57:
        $salir = false;
        $desc = '';
        $avance = 1;
        if($padre == 56){
            $avance = 4;
        }elseif($padre == 57){
            $avance = 5;
        }
        for ($i = 0; $salir == false; $i = $i+$avance){
            if (optional_param('VORSUB'.$i, null, PARAM_TEXT) ||
                optional_param('KONSUB'.$i, null, PARAM_TEXT) ||
                optional_param('MIT'.$i, null, PARAM_TEXT) ||
                optional_param('VER2'.$i, null, PARAM_TEXT) ||
                optional_param('VER1'.$i, null, PARAM_TEXT)){
                
                $desc .= optional_param('VORSUB'.$i, null, PARAM_TEXT).'&'.optional_param('KONSUB'.$i, null, PARAM_TEXT).'&';
                $desc .= optional_param('MIT'.$i, null, PARAM_TEXT).'&'.optional_param('VER2'.$i, null, PARAM_TEXT).'&';
                if($padre == 57){
                    $desc .= optional_param('VER1'.$i,null,PARAM_TEXT).'&';
                }
            }
            else{
                $salir = true;
            }
        }
        $desc .= '&&&&';
        if($padre==57){
            $desc .= '&';
        }
        break;
    //2.4.2.1 Pronomina, die nur Personen bezeichnen
    case 13:
        $tope = 5;
        $desc='';
        for ($i=0; $i<$tope; $i++){
            $desc .= optional_param('DEFA'.$i, null, PARAM_TEXT).'&';
            $desc .= optional_param('NOM'.$i, null, PARAM_TEXT).'&'.optional_param('AKK'.$i, null, PARAM_TEXT).'&';
            $desc .= optional_param('DAT'.$i, null, PARAM_TEXT).'&'.optional_param('GEN'.$i, null, PARAM_TEXT).'&';
        }
        break;
    //2.1 Personalpronomen
    case 7:
        $desc = optional_param('NS1', null, PARAM_TEXT) . '&' . optional_param('NS2', null, PARAM_TEXT) . '&';
        $desc .= optional_param('NS3M', null, PARAM_TEXT) . '&' . optional_param('NS3N', null, PARAM_TEXT) . '&' . optional_param('NS3F', null, PARAM_TEXT) . '&';
        $desc .= optional_param('NP1', null, PARAM_TEXT) . '&' . optional_param('NP2', null, PARAM_TEXT) . '&' . optional_param('NP3', null, PARAM_TEXT) . '&' . optional_param('NSIE', null, PARAM_TEXT) . '&';

        $desc .= optional_param('AS1', null, PARAM_TEXT) . '&' . optional_param('AS2', null, PARAM_TEXT) . '&';
        $desc .= optional_param('AS3M', null, PARAM_TEXT) . '&' . optional_param('AS3N', null, PARAM_TEXT) . '&' . optional_param('AS3F', null, PARAM_TEXT) . '&';
        $desc .= optional_param('AP1', null, PARAM_TEXT) . '&' . optional_param('AP2', null, PARAM_TEXT) . '&' . optional_param('AP3', null, PARAM_TEXT) . '&' . optional_param('NSIE', null, PARAM_TEXT) . '&';

        $desc .= optional_param('DS1', null, PARAM_TEXT) . '&' . optional_param('DS2', null, PARAM_TEXT) . '&';
        $desc .= optional_param('DS3M', null, PARAM_TEXT) . '&' . optional_param('DS3N', null, PARAM_TEXT) . '&' . optional_param('DS3F', null, PARAM_TEXT) . '&';
        $desc .= optional_param('DP1', null, PARAM_TEXT) . '&' . optional_param('DP2', null, PARAM_TEXT) . '&' . optional_param('DP3', null, PARAM_TEXT) . '&' . optional_param('DSIE', null, PARAM_TEXT) . '&';

        $desc .= optional_param('GS1', null, PARAM_TEXT) . '&' . optional_param('GS2', null, PARAM_TEXT) . '&';
        $desc .= optional_param('GS3M', null, PARAM_TEXT) . '&' . optional_param('GS3N', null, PARAM_TEXT) . '&' . optional_param('GS3F', null, PARAM_TEXT) . '&';
        $desc .= optional_param('GP1', null, PARAM_TEXT) . '&' . optional_param('GP2', null, PARAM_TEXT) . '&' . optional_param('GP3', null, PARAM_TEXT) . '&' . optional_param('GSIE', null, PARAM_TEXT) . '&';
        break;
    //3.8 Imperativ
    case 35:
        $tope = 10;
        $desc='';
        for ($i=0; $i<$tope; $i++){
            $desc .= optional_param('INF'.$i, null, PARAM_TEXT) . '&' . optional_param('S2'.$i, null, PARAM_TEXT) . '&' . optional_param('P2'.$i, null, PARAM_TEXT) . '&' . optional_param('SIE'.$i, null, PARAM_TEXT) . '&';
        }
        break;
    //3.5 Reflexive und reziproke Verben
    case 30:
        $desc = optional_param('AS1', null, PARAM_TEXT) . '&' . optional_param('AS2', null, PARAM_TEXT) . '&' . optional_param('AS3', null, PARAM_TEXT). '&';
        $desc .= optional_param('AP1', null, PARAM_TEXT) . '&' . optional_param('AP2', null, PARAM_TEXT) . '&' . optional_param('AP3', null, PARAM_TEXT). '&';
        $desc .= optional_param('ASIE', null, PARAM_TEXT) . '&';
        $desc .= optional_param('DS1', null, PARAM_TEXT) . '&' . optional_param('DS2', null, PARAM_TEXT) . '&' . optional_param('DS3', null, PARAM_TEXT). '&';
        $desc .= optional_param('DP1', null, PARAM_TEXT) . '&' . optional_param('DP2', null, PARAM_TEXT) . '&' . optional_param('DP3', null, PARAM_TEXT). '&';
        $desc .= optional_param('DSIE', null, PARAM_TEXT) . '&';
        break;
    //4.7 Gebrauch der Artikelwörter
    case 43:
        $tope = 20;
        $tablas = 3;
        $desc = '';
        for($t = 0; $t<$tablas; $t++){
            for($f=0; $f<$tope; $f++){
                $desc .= optional_param('BE'.$t.'_'.$f, null, PARAM_TEXT) . '&' . optional_param('GE'.$t.'_'.$f, null, PARAM_TEXT) . '&';
            }
        }
        break;
    case 48:
        $tope = 10;
        $desc = '';
        for($f=0; $f<$tope; $f++){
            $desc .= optional_param('PO'.$f, null, PARAM_TEXT) . '&' . optional_param('KO'.$f, null, PARAM_TEXT) . '&' . optional_param('SU'.$f, null, PARAM_TEXT) . '&';
        }
        break;
    // 6.1
    case 51:
        $salir = false;
        $desc = '';

        for($f=0; $salir==false; $f++){
            if(optional_param('PRA'.$f, null, PARAM_TEXT) ||
               optional_param('FUN'.$f, null, PARAM_TEXT) ||
               optional_param('KAS'.$f, null, PARAM_TEXT) ||
               optional_param('BEI'.$f, null, PARAM_TEXT)
               ){

            $desc .= optional_param('PRA'.$f, null, PARAM_TEXT) . '&' . optional_param('FUN'.$f, null, PARAM_TEXT) . '&';
            $desc .= optional_param('KAS'.$f, null, PARAM_TEXT) . '&' . optional_param('BEI'.$f, null, PARAM_TEXT) . '&';
               }else{
                   $salir=true;
               }
        }
        break;

        /*
        $tope = 30;
        $desc = '';
        for($f=0; $f<$tope; $f++){
            $desc .= optional_param('PRA'.$f, null, PARAM_TEXT) . '&' . optional_param('FUN'.$f, null, PARAM_TEXT) . '&';
            $desc .= optional_param('KAS'.$f, null, PARAM_TEXT) . '&' . optional_param('BEI'.$f, null, PARAM_TEXT) . '&';
        }
        break;

         */


}

//soluciones varias
$desc .= optional_param('descripcion', null, PARAM_TEXT) . '&' . optional_param('miraren', null, PARAM_TEXT);

//vemos que botón hemos pulsado
if ($mform->no_submit_button_pressed()){

    if(optional_param('desc_btn')){
        //$graux = new Vocabulario_mis_gramaticas($user_object->id,$gram->get('padre'),$desc);
        $graux = new Vocabulario_mis_gramaticas($user_object->id,$padre,$desc);
        $graux->guardar();
    }
}

//volvemos a donde veniamos
redirect('./view.php?id=' . $id_tocho . '&opcion=5&grid=' . $padre);
//echo '<a href="./view.php?id='.$id_tocho.'&opcion=5&grid='.$misgram['gramaticaid'].'">continuar</a>';
?>
