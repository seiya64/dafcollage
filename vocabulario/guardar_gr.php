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
    Andrea Bies
    Julia Möller Runge
    Antonio Salmerón Matilla
    Karin Vilar Sánchez
    Inmaculada Almahano Güeto
    Blanca Rodríguez Gómez
    María José Varela Salinas

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

$gram = new Vocabulario_gramatica($user_object->id, required_param('campogr', PARAM_TEXT), optional_param('gramatica', PARAM_TEXT));

if (optional_param('eliminar', 0, PARAM_INT) && $gram->get('padre') > 72) {
    delete_records('vocabulario_gramatica', 'id', $gram->get('padre'));
    redirect('./view.php?id=' . $id_tocho . '&opcion=5');
}

//recogemos todos los datos de la gramatica
switch ($padre) {
    default:
        //$desc = optional_param('descripcion', null, PARAM_TEXT);
        $desc = '';
        break;
    //allgemeines
    case 2:
    case 7:
    case 21:
    case 39:
    case 49:
    case 57:
    case 61:
    case 64:
    case 76:
        $desc = optional_param('particulares', null, PARAM_TEXT) . '&';
        break;
    //1.2
    case 3:
        $desc = optional_param('mascsementico', null, PARAM_TEXT) . '&' . optional_param('mascformal', null, PARAM_TEXT). '&';
        $desc .= optional_param('femsementico', null, PARAM_TEXT) . '&' . optional_param('femformal', null, PARAM_TEXT). '&';
        $desc .= optional_param('neutrosementico', null, PARAM_TEXT) . '&' . optional_param('neutroformal', null, PARAM_TEXT). '&';
        break;
    //1.3
    case 4:
        $desc = optional_param('endungs', null, PARAM_TEXT) . '&' . optional_param('genero', null, PARAM_TEXT) . '&';
        $desc .= optional_param('endungp', null, PARAM_TEXT) . '&' . optional_param('reinesf', null, PARAM_TEXT) . '&';
        $desc .= optional_param('reinepf', null, PARAM_TEXT) . '&';
        break;
    //5.3.1
    case 52:
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
        $desc .= optional_param('GN3', null, PARAM_TEXT) . '&' . optional_param('GF3', null, PARAM_TEXT) . '&' . optional_param('GP3', null, PARAM_TEXT) . '&';
        break;
    //tablas verbos
    //3.2.1
    case 23:
    //3.2.2
    case 24:
        $tope=20;
        $desc='';
        for ($i=0; $i<$tope; $i++){
            $desc .= optional_param('S1SC'.$i, null, PARAM_TEXT) . '&' . optional_param('S2SC'.$i, null, PARAM_TEXT) . '&' . optional_param('S3SC'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('P1SC'.$i, null, PARAM_TEXT) . '&' . optional_param('P2SC'.$i, null, PARAM_TEXT) . '&' . optional_param('P3SC'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('S1ST'.$i, null, PARAM_TEXT) . '&' . optional_param('S2ST'.$i, null, PARAM_TEXT) . '&' . optional_param('S3ST'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('P1ST'.$i, null, PARAM_TEXT) . '&' . optional_param('P2ST'.$i, null, PARAM_TEXT) . '&' . optional_param('P3ST'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('S1GE'.$i, null, PARAM_TEXT) . '&' . optional_param('S2GE'.$i, null, PARAM_TEXT) . '&' . optional_param('S3GE'.$i, null, PARAM_TEXT) . '&';
            $desc .= optional_param('P1GE'.$i, null, PARAM_TEXT) . '&' . optional_param('P2GE'.$i, null, PARAM_TEXT) . '&' . optional_param('P3GE'.$i, null, PARAM_TEXT) . '&';
        }
        break;
    //3.2.5
    case 27:
        $desc = optional_param('futuro1', null, PARAM_TEXT) . '&';
        break;
    //3.2.6
    case 28:
        $desc = optional_param('futuro2', null, PARAM_TEXT) . '&';
        break;
    //3.8.2
    case 36:
        $desc = optional_param('S1SC'.$i, null, PARAM_TEXT) . '&' . optional_param('S2SC'.$i, null, PARAM_TEXT) . '&' . optional_param('S3SC'.$i, null, PARAM_TEXT) . '&';
        $desc .= optional_param('P1SC'.$i, null, PARAM_TEXT) . '&' . optional_param('P2SC'.$i, null, PARAM_TEXT) . '&' . optional_param('P3SC'.$i, null, PARAM_TEXT) . '&';

        $desc .= optional_param('S1P', null, PARAM_TEXT) . '&' . optional_param('S1K', null, PARAM_TEXT) . '&';
        $desc .= optional_param('S2P', null, PARAM_TEXT) . '&' . optional_param('S2K', null, PARAM_TEXT) . '&';
        $desc .= optional_param('S3P', null, PARAM_TEXT) . '&' . optional_param('S3K', null, PARAM_TEXT) . '&';
        $desc .= optional_param('P1P', null, PARAM_TEXT) . '&' . optional_param('P1K', null, PARAM_TEXT) . '&';
        $desc .= optional_param('P2P', null, PARAM_TEXT) . '&' . optional_param('P2K', null, PARAM_TEXT) . '&';
        $desc .= optional_param('P3P', null, PARAM_TEXT) . '&' . optional_param('P3K', null, PARAM_TEXT) . '&';
        break;
    //3.8.1
    case 35:
    //3.3
    case 29:
    //3.4
    case 30:
    //3.5
    case 31:
        $desc = optional_param('S1I', null, PARAM_TEXT) . '&' . optional_param('S1C', null, PARAM_TEXT) . '&';
        $desc .= optional_param('S2I', null, PARAM_TEXT) . '&' . optional_param('S2C', null, PARAM_TEXT) . '&';
        $desc .= optional_param('S3I', null, PARAM_TEXT) . '&' . optional_param('S3C', null, PARAM_TEXT) . '&';
        $desc .= optional_param('P1I', null, PARAM_TEXT) . '&' . optional_param('P1C', null, PARAM_TEXT) . '&';
        $desc .= optional_param('P2I', null, PARAM_TEXT) . '&' . optional_param('P2C', null, PARAM_TEXT) . '&';
        $desc .= optional_param('P3I', null, PARAM_TEXT) . '&' . optional_param('P3C', null, PARAM_TEXT) . '&';
        //$desc .= optional_param('descripcion', null, PARAM_TEXT) . '&' . optional_param('todocontodo', null, PARAM_TEXT);
        break;
    //participio2
    //3.2.3
    case 25:
        $desc = optional_param('participio2', null, PARAM_TEXT) . '&' . optional_param('hilfsverbs', null, PARAM_TEXT) . '&';
        break;
    //3.2.4
    case 26:
        $desc = optional_param('participio1', null, PARAM_TEXT) . '&';
        break;
    //passiv
    //3.7
    case 33:
        $desc = optional_param('zustandspassiv', null, PARAM_TEXT) . '&' . optional_param('vorganspassiv', null, PARAM_TEXT) . '&';
        break;
    //articulos
    //4.2 4.3 4.4 4.5 4.6 4.7
    case 40:
    case 41:
    case 42:
    case 43:
    case 44:
    case 45:
    //pronombres
    //2.4
    case 10:
    //2.6
    case 16:
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

    //2.7
    case 17:
    //2.5.1
    case 12:
    //y tambien el 1.4
    case 5:
        //para restrngir según la categoria
        $tope = 1;
        switch ($padre){
            default:
                $tope = 1;
                break;
            case 10:
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
    //4.8
    case 46:
        $desc = optional_param('lista', null, PARAM_TEXT) . '&' . optional_param('scheinbare', null, PARAM_TEXT) . '&';
        break;
    //7.2
    case 62:
        $desc = optional_param('beispielsatz', null, PARAM_TEXT) . '&' . optional_param('satzart', null, PARAM_TEXT) . '&';
        $desc .= optional_param('komfun', null, PARAM_TEXT) . '&';
        break;
    //2.3
    case 9:
        $desc = optional_param('NP', null, PARAM_TEXT) . '&' . optional_param('NNP', null, PARAM_TEXT) . '&';
        $desc .= optional_param('AP', null, PARAM_TEXT) . '&' . optional_param('ANP', null, PARAM_TEXT) . '&';
        $desc .= optional_param('DP', null, PARAM_TEXT) . '&' . optional_param('DNP', null, PARAM_TEXT) . '&';
        $desc .= optional_param('GP', null, PARAM_TEXT) . '&' . optional_param('GNP', null, PARAM_TEXT) . '&';
        break;
    //8.4.1
    case 64:
        $desc = optional_param('definido', null, PARAM_TEXT) . '&' . optional_param('indefinido', null, PARAM_TEXT) . '&';
        break;
    //8.4.2
    case 69:
        $desc = optional_param('temporal', null, PARAM_TEXT) . '&' . optional_param('causal', null, PARAM_TEXT) . '&';
        $desc .= optional_param('modal', null, PARAM_TEXT) . '&' . optional_param('local', null, PARAM_TEXT) . '&';
        break;
    //8.5.1, 8.5.2, 8.5.3
    case 72:
    case 73:
    case 74:
        $desc = optional_param('func', null, PARAM_TEXT) . '&';
        $desc .= optional_param('siehe', null, PARAM_TEXT) . '&';
        break;
    //8.2
    case 65:
        $salir = false;
        $desc = '';
        for ($i = 0; $salir == false; $i = $i+4){
            if (optional_param('vor'.$i, null, PARAM_TEXT) ||
                optional_param('kon'.$i, null, PARAM_TEXT) ||
                optional_param('mit'.$i, null, PARAM_TEXT) ||
                optional_param('ver2'.$i, null, PARAM_TEXT)){
                
                $desc .= optional_param('vor'.$i, null, PARAM_TEXT).'&'.optional_param('kon'.$i, null, PARAM_TEXT).'&';
                $desc .= optional_param('mit'.$i, null, PARAM_TEXT).'&'.optional_param('ver2'.$i, null, PARAM_TEXT).'&';
            }
            else{
                $salir = true;
            }
        }
        break;
    //2.5.2.1
    case 14:
        $desc = optional_param('NOM', null, PARAM_TEXT).'&'.optional_param('AKK', null, PARAM_TEXT).'&';
        $desc .= optional_param('DAT', null, PARAM_TEXT).'&'.optional_param('GEN', null, PARAM_TEXT).'&';
        break;
    //2.2
    case 8:
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
}

//soluciones varias
$desc .= optional_param('descripcion', null, PARAM_TEXT) . '&' . optional_param('miraren', null, PARAM_TEXT);

//vemos que botón hemos pulsado
if ($mform->no_submit_button_pressed()){
    if(optional_param('desc_btn')){
        $graux = new Vocabulario_mis_gramaticas($USER->id,$gram->get('padre'),$desc);
        $graux->guardar();
        //print_object($graux);
    }
}

//volvemos a donde veniamos
redirect('./view.php?id=' . $id_tocho . '&opcion=5&grid=' . $padre);
//echo '<a href="./view.php?id='.$id_tocho.'&opcion=5&grid='.$misgram['gramaticaid'].'">continuar</a>';
?>
