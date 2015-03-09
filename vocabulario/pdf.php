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
require_once('lib.php');
require_once('vocabulario_classes.php');
require_once($CFG->libdir.'/tcpdf/tcpdf.php');
require_once($CFG->libdir.'/tcpdf/config/lang/eng.php');

global $USER;

define('MARGIN', 10);
define('MARGIN_L2', 20);
define('MARGIN_L3', 30);
define('MARGIN_L4', 40);
define('MARGIN_L5', 50);
define('TEXT_AUTO', 0);
define('TEXT_WHITE', 255);



$id_tocho = optional_param('id_tocho', 0, PARAM_INT);

$usuario = $USER->id;

//Captamos los campos que queremos imprimir

$impr_vocab_corto = optional_param('impr_vocab_corto', 0, PARAM_INT);
$impr_vocab = optional_param('impr_vocab', 0, PARAM_INT);
$impr_gram = optional_param('impr_gram', 0, PARAM_INT);
$impr_tipol = optional_param('impr_tipol', 0, PARAM_INT);
$impr_inten = optional_param('impr_inten', 0, PARAM_INT);
$impr_estra = optional_param('impr_estra', 0, PARAM_INT);

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, TRUE, 'UTF-8', FALSE);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetTitle(get_string('cuad_digital_min', 'vocabulario'));

$pdf->SetMargins(MARGIN, PDF_MARGIN_TOP, MARGIN);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

//Portada
$pdf->SetFont('freeserif', 'B', '12');
//$pdf->SetFont('helvetica', '', 9);
$pdf->AddPage();

$pdf->writeHTMLCell(0, 0, 20, 5, '<h1>' . get_string('cuad_digital_may', 'vocabulario') . '</h1>', 0, 1, 0);
$pdf->writeHTMLCell(0, 0, 150, 250, $USER->firstname . ' ' . $USER->lastname, 0, 1, 0);
$pdf->writeHTMLCell(0, 0, 150, 255, $USER->email, 0, 1, 0);


if($impr_vocab_corto) {

        $todas = $DB->get_records('vocabulario_mis_palabras',array('usuarioid'=>$usuario));
        

        $mis_palabras = array();

        foreach ($todas as $cosa) {
            $mp = new Vocabulario_mis_palabras();
            $mp->leer($cosa->id);
            $mis_palabras[] = $mp;
        }
        
    
   
    $genero = array("der", "die", "das");
    
    foreach($mis_palabras as $cosa) {
        //Recojo los datos para imprimir de todas mis palabras
        $palabra=$cosa->get('sustantivo')->get('palabra');
        $significadoPalabra=$cosa->get('sustantivo')->get('significado');
        $g=$cosa->get('sustantivo')->get('genero');
        $gen=$genero[$g];
        $plural=$cosa->get('sustantivo')->get('plural');
        $ejemplo=$cosa->get('sustantivo')->get('ejemplo');
        $infinitivo=$cosa->get('verbo')->get('infinitivo');
        $ter_pers_sing=$cosa->get('verbo')->get('ter_pers_sing');
        $participio=$cosa->get('verbo')->get('participio');
        $significadoVerbo=$cosa->get('verbo')->get('significado');
        $campo=$cosa->get('campo')->get('campo');
        //echo $palabra." ".$genero." ".$plural." ".$ejemplo." ".$infinitivo." ".$ter_pers_sing." ".$participio."<br>";
        
        //Creo el array de 4 dimensiones que contendra los datos que se van a imprimir en el pdf
        if(!array_key_exists($palabra, $datos[$campo])) {
            $datos[$campo][$palabra]=array("genero"=>$gen, "plural"=>$plural, "significado"=>$significadoPalabra, "ejemplo"=>$ejemplo);
        }
        $datos[$campo][$palabra][]=array($infinitivo, $ter_pers_sing, $participio, $significadoVerbo);
    }
    
    foreach($datos as $ct=>$palabras) {
        //Campo Tematico
        $pdf->AddPage();
        $pdf->SetFillColor(59, 89, 152); //azul oscuro
        $pdf->SetTextColor(TEXT_WHITE);
        $pdf->SetLineWidth(0.5);
        if((((float)$ct)*10)%10==0) {
            $pdf->SetFont('freeserif', 'B', '14');
        } else {
            $pdf->SetFont('freeserif', 'B', '14');
        }
        
        $pdf->Cell(190, 15, $ct, 1, 1, 'L', 1);
        
        foreach($palabras as $pal=>$atrs) {
            //Sustantivo con el genero
            $pdf->SetLineWidth(0.3);
            $pdf->SetFillColor(255, 255, 255); //blanco
            $pdf->SetTextColor(0,0,0);
            //La fuente 'freeserif' contiene codificación de caracteres especiales "β"
            $pdf->SetFont('freeserif', 'B', '12');
            
            $pdf->Cell(59, 10, $atrs['genero']." ".$pal, "LT", 0, "J", 1);
            $pdf->Cell(2, 10, " ", "T", 0, "J", 1);
            
            //Plural
            $pdf->SetFont('freeserif', 'B', '12');
            $pdf->Cell(59, 10, $atrs['plural'], "TR", 0, "L", 1);
            
            //Significado
            $pdf->SetFont('freeserif', 'B', '12');
            $pdf->Cell(70, 10, $atrs['significado'], "LTR", 1, "J", 1);
                    
                    
            //EJEMPLO
            $pdf->SetFont('freeserif', 'I', '10');
            $pdf->Cell(120, 10, $atrs['ejemplo'], "LBR", 0, "L", 1);
            //$pdf->SetFillColor(255, 255, 255); //blanco
            $pdf->Cell(70, 10, " ", "LBR", 1, "L", 1);
            $color=0;
            
            foreach($atrs as $verbo=>$atrv) {
                //Solo los array asociativos numericos se recorren para imprimir el contenido
                if(is_numeric($verbo)) {
                    //Verbo
                    if($color%2 == 0) {
                        $pdf->SetFillColor(224, 224, 224); //gris claro
                    }else {
                        $pdf->SetFillColor(189, 199, 216); //azul claro
                    }
                    $pdf->SetFont('freeserif', 'B', '12');
                    
                    //Infinitivo
                    $pdf->Cell(59, 6, "$atrv[0]", "L", 0, "R", 1);
                    $pdf->Cell(2, 6, " ", " ", 0, "J", 1);
                    $pdf->Cell(59, 6, " ", " ", 0, "J", 1);
                    
                    $pdf->SetFont('freeserif', 'B', '12');
                    //$pdf->SetFillColor(255, 255, 255); //blanco
                    $pdf->Cell(70, 6, $atrv[3], "LR", 1, "J", 1);
                    
                    if($color%2 == 0) {
                        $pdf->SetFillColor(224, 224, 224); //gris claro
                    }else {
                        $pdf->SetFillColor(189, 199, 216); //azul claro
                    }
                    //Tercera persona
                    $pdf->SetFont('freeserif', 'B', '10');
                    $pdf->Cell(59, 6, " ", "L", 0, "J", 1);
                    $pdf->Cell(2, 6, " ", " ", 0, "J", 1);
                    $pdf->Cell(59, 6, "$atrv[1]", " ", 0, "J", 1);
                    
                    //$pdf->SetFillColor(255, 255, 255); //blanco
                    $pdf->Cell(70, 6, " ", "LR", 1, "J", 1);
                    
                    if($color%2 == 0) {
                        $pdf->SetFillColor(224, 224, 224); //gris claro
                    }else {
                        $pdf->SetFillColor(189, 199, 216); //azul claro
                    }
                    //Participio
                    $pdf->Cell(59, 6, " ", "LB", 0, "J", 1);
                    $pdf->Cell(2, 6, " ", "B", 0, "J", 1);
                    $pdf->Cell(59, 6, $atrv[2], "B", 0, "J", 1);
                    
                    $pdf->SetFont('freeserif', 'B', '10');
                    //$pdf->SetFillColor(255, 255, 255); //blanco
                    $pdf->Cell(70, 6, " ", "LBR", 1, "J", 1);
                    
                    //Espacio para que el alumno pueda escribir mas ejemplos a mano
                    if($color%2 == 0) {
                        $pdf->SetFillColor(224, 224, 224); //gris claro
                    }else {
                        $pdf->SetFillColor(189, 199, 216); //azul claro
                    }
                    $pdf->Cell(120, 8, " ", "LRB", 0, "L", 1);
                    //$pdf->SetFillColor(255, 255, 255); //blanco
                    $pdf->Cell(70, 8, " ", "LRB", 1, "L", 1);
                    $color++;
                }
            }
        }
    }
    
    $pdf->Ln();
}

if ($impr_vocab == 1) {
    //Portada vocabulario
    $pdf->AddPage();
    $pdf->SetFont('freeserif', 'B', '12');
    $pdf->writeHTMLCell(0, 0, 20, 5, '<h1>' . get_string('vocabulario_may', 'vocabulario') . '</h1>', 0, 1, 0);
//    $pdf->AddPage();
    //resto de paginas
    //palabras por campos

    $mis_palabras_aux = new Vocabulario_mis_palabras();
    $mis_palabras = $mis_palabras_aux->obtener_todas($usuario);

    $mi_campo = -1;
    $color = 1;


    $mis_campos = new Vocabulario_campo_lexico();
    $todos_mis_campos = $mis_campos->obtener_todos($usuario);


    $genero = array(get_string('masc', 'vocabulario'), get_string('fem', 'vocabulario'), get_string('neu', 'vocabulario'));

    foreach ($todos_mis_campos as $mic) {
    //    $pdf->writeHTMLCell(0,0,250,0,'aaaa',0,1,0); 
        $primera = true;
        foreach ($mis_palabras as $cosa) {
            if ($cosa->get('campo')->get('campo') == $mic) {
                if ($primera) {
                    //imprimo el campolexico
                    $pdf->AddPage();
                    $mi_campo = $cosa->get('campo')->get('campo');
                    $pdf->SetTextColor(TEXT_AUTO);
                    $pdf->SetFont('freeserif', 'B', '12');
                    //            $pdf->Cell(0, 7, $mi_campo, 0, 1, 'L', 0);
                    $pdf->writeHTMLCell(0,0,50,0,'holaaa',0,1,0);    
                    $pdf->writeHTMLCell(0, 0, 0, 0, '<h2>' . $mi_campo . '</h2>', 0, 1, 0);
                    //titulillos
                    $pdf->SetFillColor(59, 89, 152); //azul oscuro
                    $pdf->SetTextColor(TEXT_WHITE);
                    $pdf->SetLineWidth(0.3);
                    $pdf->SetFont('freeserif', 'B', '12');


                    $pdf->Cell(47, 7, get_string('sust', 'vocabulario'), 1, 0, 'C', 1);
                    $pdf->Cell(47, 7, get_string('adj', 'vocabulario'), 1, 0, 'C', 1);
                    $pdf->Cell(47, 7, get_string('vrb', 'vocabulario'), 1, 0, 'C', 1);
                    $pdf->Cell(47, 7, get_string('otr', 'vocabulario'), 1, 0, 'C', 1);
                    $pdf->Ln();
                    $color = 1;

                    $primera = false;
                }

                //palabras
                if ($color % 2 == 0) {
                    $pdf->SetFillColor(189, 199, 216);  //azul clarito
                } else {
                    $pdf->SetFillColor(255, 255, 255); //blanco
                }

                $sustantivo = $cosa->get('sustantivo');
                $Spal = $sustantivo->get('palabra');            //1 linea
                $Ssig = $sustantivo->get('significado');        //2 linea
                $Sgen = $genero[$sustantivo->get('genero')];    //3 linea
                $Splu = $sustantivo->get('plural');             //4 linea
                $Sgram = $sustantivo->get('gramaticaid');       //6 linea
                $Sic = $sustantivo->get('intencionid');         //7 linea
                $Stip = $sustantivo->get('tipologiaid');        //9 linea
                $Sobs = $sustantivo->get('observaciones');      //10 linea
                $Seje = $sustantivo->get('ejemplo');
                $adjetivo = $cosa->get('adjetivo');
                $Apal = $adjetivo->get('sin_declinar');         //1 linea
                $Asig = $adjetivo->get('significado');          //2 linea
                $Agen = '';                                     //3 linea
                $Aplu = '';                                     //4 linea
                $Agram = $adjetivo->get('gramaticaid');         //6 linea
                $Aic = $adjetivo->get('intencionid');           //7 linea
                $Atip = $adjetivo->get('tipologiaid');          //9 linea
                $Aobs = $adjetivo->get('observaciones');        //10 linea
                $verbo = $cosa->get('verbo');
                $Vpal = $verbo->get('infinitivo');              //1 linea
                $Vsig = $verbo->get('significado');             //2 linea
                $Vter = $verbo->get('ter_pers_sing');           //3 linea
                $Vpret = $verbo->get('preterito');              //4 linea
                $Vpart = $verbo->get('participio');             //4 linea
                $Vgram = $verbo->get('gramaticaid');            //6 linea
                $Vic = $verbo->get('intencionid');              //7 linea
                $Vtip = $verbo->get('tipologiaid');             //9 linea
                $Vobs = $verbo->get('observaciones');           //10 linea
                $otro = $cosa->get('otro');
                $Opal = $otro->get('palabra');                  //1 linea
                $Osig = $otro->get('significado');              //2 linea
                $Ogen = '';                                     //3 linea
                $Oplu = '';                                     //4 linea
                $Ogram = $otro->get('gramaticaid');             //6 linea
                $Oic = $otro->get('intencionid');               //7 linea
                $Otip = $otro->get('tipologiaid');              //9 linea
                $Oobs = $otro->get('observaciones');            //10 linea
                //1 Linea -> Palabra/verbo/adjetivo/otra
                $pdf->SetTextColor(TEXT_AUTO);
                $pdf->SetFont('freeserif', 'B', '12');
                $pdf->Cell(47, 5, $Spal, 'LTR', 0, 'C', 1);
                $pdf->Cell(47, 5, $Apal, 'RT', 0, 'C', 1);
                $pdf->Cell(47, 5, $Vpal, 'TR', 0, 'C', 1);
                $pdf->Cell(47, 5, $Opal, 'RT', 0, 'C', 1);
                $pdf->Ln();

                //2 Linea -> significados
                $pdf->SetFont('freeserif', 'I', '7');
                $pdf->Cell(47, 3, $Ssig, 'LR', 0, 'R', 1);
                $pdf->Cell(47, 3, $Asig, 'R', 0, 'R', 1);
                $pdf->Cell(47, 3, $Vsig, 'R', 0, 'R', 1);
                $pdf->Cell(47, 3, $Osig, 'R', 0, 'R', 1);
                $pdf->Ln();

                //3 Linea -> genero/ter_pers
                $pdf->SetFont('freeserif', 'B', '7');
                $pdf->Cell(47, 4, $Sgen, 'LR', 0, 'L', 1);
                $pdf->Cell(47, 4, $Agen, 'R', 0, 'L', 1);
                $pdf->Cell(47, 4, get_string('3perAv', 'vocabulario') . ': ' . $Vter, 'R', 0, 'L', 1);
                $pdf->Cell(47, 4, $Ogen, 'R', 0, 'L', 1);
                $pdf->Ln();

                //4 Linea -> plural/pret&participio
                $pdf->SetFont('freeserif', 'B', '7');
                $pdf->Cell(23, 4, get_string('plural', 'vocabulario') . ':', 'L', 0, 'R', 1);  //sustantivo
                $pdf->SetFont('freeserif', 'B', '7');
                $pdf->Cell(24, 4, $Splu, 'R', 0, 'L', 1);                                    //sustantivo
                $pdf->Cell(47, 4, $Aplu, 'R', 0, 'L', 1);
                $pdf->SetFont('freeserif', 'B', '6');
                $pdf->Cell(24, 4, get_string('pretAv', 'vocabulario') . ': ' . $Vpret, 0, 0, 'L', 1);      //verbo
                $pdf->Cell(23, 4, get_string('partAv', 'vocabulario') . ': ' . $Vpart, 'R', 0, 'L', 1);     //verbo
                $pdf->SetFont('freeserif', 'B', '7');
                $pdf->Cell(47, 4, $Ogen, 'R', 0, 'L', 1);
                $pdf->Ln();


                //5 Linea -> Referencias:
                $pdf->SetFont('freeserif', 'B', '7');
                $pdf->Cell(47, 4, get_string('referencias', 'vocabulario') . ':', 'LR', 0, 'I', 1);
                $pdf->Cell(47, 4, get_string('referencias', 'vocabulario') . ':', 'R', 0, 'I', 1);
                $pdf->Cell(47, 4, get_string('referencias', 'vocabulario') . ':', 'R', 0, 'I', 1);
                $pdf->Cell(47, 4, get_string('referencias', 'vocabulario') . ':', 'R', 0, 'I', 1);
                $pdf->Ln();

                //6 Linea Referencias gramaticas
                $gram = new Vocabulario_gramatica();
                $gram->leer($Sgram);
                $numRef = explode(' ', $gram->get('gramatica'));
                $pdf->Cell(47, 4, '   -' . get_string('impr_gram', 'vocabulario') . ': ' . $numRef[0], 'LR', 0, 'L', 1);
                $gram->leer($Agram);
                $numRef = explode(' ', $gram->get('gramatica'));
                $pdf->Cell(47, 4, '   -' . get_string('impr_gram', 'vocabulario') . ': ' . $numRef[0], 'R', 0, 'L', 1);
                $gram->leer($Vpal);
                $numRef = explode(' ', $gram->get('gramatica'));
                $pdf->Cell(47, 4, '   -' . get_string('impr_gram', 'vocabulario') . ': ' . $numRef[0], 'R', 0, 'L', 1);
                $gram->leer($Opal);
                $numRef = explode(' ', $gram->get('gramatica'));
                $pdf->Cell(47, 4, '   -' . get_string('impr_gram', 'vocabulario') . ': ' . $numRef[0], 'R', 0, 'L', 1);
                $pdf->Ln();


                //7 Linea -> Referencias intenciones
                $inte = new Vocabulario_intenciones();
                $inte->leer($Sic);
                $numRef = explode(' ', $inte->get('intencion'));
                $pdf->Cell(47, 4, '   -' . get_string('campo_intencion', 'vocabulario') . ': ' . $numRef[0], 'LR', 0, 'L', 1);
                $inte->leer($Aic);
                $numRef = explode(' ', $inte->get('intencion'));
                $pdf->Cell(47, 4, '   -' . get_string('campo_intencion', 'vocabulario') . ': ' . $numRef[0], 'R', 0, 'L', 1);
                $inte->leer($Vic);
                $numRef = explode(' ', $inte->get('intencion'));
                $pdf->Cell(47, 4, '   -' . get_string('campo_intencion', 'vocabulario') . ': ' . $numRef[0], 'R', 0, 'L', 1);
                $inte->leer($Oic);
                $numRef = explode(' ', $inte->get('intencion'));
                $pdf->Cell(47, 4, '   -' . get_string('campo_intencion', 'vocabulario') . ': ' . $numRef[0], 'R', 0, 'L', 1);
                $pdf->Ln();

                //8 Linea -> Tipologia:
                $pdf->SetFont('freeserif', 'B', '7');
                $pdf->Cell(47, 4, '   -' . get_string('campo_tipologia', 'vocabulario') . ': ', 'LR', 0, 'I', 1);
                $pdf->Cell(47, 4, '   -' . get_string('campo_tipologia', 'vocabulario') . ': ', 'R', 0, 'I', 1);
                $pdf->Cell(47, 4, '   -' . get_string('campo_tipologia', 'vocabulario') . ': ', 'R', 0, 'I', 1);
                $pdf->Cell(47, 4, '   -' . get_string('campo_tipologia', 'vocabulario') . ': ', 'R', 0, 'I', 1);
                $pdf->Ln();

                //9 Linea -> Referencias Tipologia:
                $pdf->SetFont('freeserif', 'I', '6');
                $tipo = new Vocabulario_tipologias();
                $tipo->leer($Stip);
                $pdf->Cell(47, 4, '        ' . $tipo->get('tipo'), 'LR', 0, 'I', 1);
                $tipo->leer($Atip);
                $pdf->Cell(47, 4, '        ' . $tipo->get('tipo'), 'R', 0, 'I', 1);
                $tipo->leer($Vtip);
                $pdf->Cell(47, 4, '        ' . $tipo->get('tipo'), 'R', 0, 'I', 1);
                $tipo->leer($Otip);
                $pdf->Cell(47, 4, '        ' . $tipo->get('tipo'), 'R', 0, 'I', 1);
                $pdf->Ln();


                //9 Linea -> observaciones
                $pdf->SetFont('freeserif', 'B', '7');
                $pdf->Cell(47, 4, get_string('vease_pdf', 'vocabulario') . ': ', 'LR', 0, 'L', 1);
                $pdf->Cell(47, 4, get_string('vease_pdf', 'vocabulario') . ': ', 'R', 0, 'L', 1);
                $pdf->Cell(47, 4, get_string('vease_pdf', 'vocabulario') . ': ', 'R', 0, 'L', 1);
                $pdf->Cell(47, 4, get_string('vease_pdf', 'vocabulario') . ': ', 'R', 0, 'L', 1);
                $pdf->Ln();

                //10 Linea -> observaciones
                $pdf->SetFont('freeserif', 'I', '7');
                $pdf->Cell(47, 4, $Sobs, 'LBR', 0, 'L', 1);
                $pdf->Cell(47, 4, $Aobs, 'BR', 0, 'L', 1);
                $pdf->Cell(47, 4, $Vobs, 'BR', 0, 'L', 1);
                $pdf->Cell(47, 4, $Oobs, 'RB', 0, 'L', 1);
                $pdf->Ln();

                //10 Linea -> observaciones
                $pdf->SetFont('', 'I', '6');
                $pdf->Cell(47, 4, get_string('ejem', 'vocabulario'), 'LB', 0, 'L', 1);
                $pdf->Cell(141, 4, $Seje, 'BR', 0, 'RBL', 1);
                $pdf->Ln();

                $color++;
            }
        }
    }



    if ($mi_campo != '0') {
        $pdf->Ln();
    }
}
if ($impr_gram == 1) {
    //gramaticas
    $gramaticas = new Vocabulario_gramatica();
    $gramaticas_usadas = array();
    //sacar un vector en el que cada posicion sean numero y nombre
    $gr_pal = $gramaticas->obtener_todos($usuario);
    $gr_num = $gramaticas->obtener_todos_ids($usuario);


    $pdf->SetTextColor(TEXT_AUTO);


    /*
      for ($i = 0; $i < count($gr_pal); $i++) {
      //Caso especial para las preposiciones:
      //Si es la gramatica 51(añadir preposicion)
      //le cambia el título por el de Consultar preposicion.
      if ($gr_num[$i] == 51) {
      //$gr_pal[$i] = $gr_pal[$i+1];
      $gr_pal[$i] = '6.2 ' . get_string('preposiciones', 'vocabulario');
      }

      $gramaticas_usadas[$i] = array($gr_pal[$i], $gr_num[$i]);
      }
     */
    $i = 0;
    foreach ($gr_pal as $titulico) {
        $gramaticas_usadas[$i] = array($titulico, 0);
        ++$i;
    }

    $i = 0;
    foreach ($gr_num as $numerico) {
        $gramaticas_usadas[$i][1] = $numerico;
        ++$i;
    }
    for ($i = 0; $i < count($gramaticas_usadas); ++$i) {
        if ($gramaticas_usadas[$i][1] == 51) {
            $gramaticas_usadas[$i][0] = '6.2 ' . get_string('preposiciones', 'vocabulario');
        }
    }

    //nueva pagina para las gramaticas
    $pdf->AddPage();
    $pdf->SetFont('freeserif', 'B', '12');
    $pdf->writeHTMLCell(0, 0, 20, 5, '<h1>' . get_string('gramatica_may', 'vocabulario') . '</h1>', 0, 1, 0);

    foreach ($gramaticas_usadas as $cosa) {
        $mgr = new Vocabulario_mis_gramaticas();
        $palabras = $mgr->relacionadas($usuario, $cosa[1]);
        if ($palabras) {
            //asigno el nombre de la gramatica
            $mi_gram = $cosa[0];


            // $pdf->Cell(0, 5, $mi_gram, 0, 1, 'L', 0);
            
            foreach ($palabras as $palabra) {
                $descripcion_troceada = explode(__SEPARADORCAMPOS__, $palabra->descripcion);
                if ($descripcion_troceada) {

                    $pintartochaco = false;
                    for ($p = 0; $p < count($descripcion_troceada) && $pintartochaco == false; $p++) {
                        if ($descripcion_troceada[$p]) {
                            $pintartochaco = true;
                        }
                    }

                    if ($pintartochaco) {
                        $pdf->AddPage();
                        $pdf->SetFont('freeserif', 'B', '12');
                        $pdf->writeHTMLCell(0, 0, 10, 5, '<h2>' . $mi_gram . '</h2>', 0, 1, 0);


                        $grid = $palabra->gramaticaid;
                        switch ($grid) {
                            //normal
                            default:
                                break;
                            //1.1
                            case 3:
                                
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->SetFont('freeserif', 'B', '10');
                                $pdf->SetFillColor(59, 89, 152); //#3B5998
                                //masculino
                                $pdf->SetTextColor(59,89,152);
                                $pdf->writeHTMLCell(0, 0, 10, 20, '<h3>' . get_string('masculino', 'vocabulario') . '</h3>', 0, 1, 0);
                                $pdf->Ln();
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->writeHTMLCell(0, 0, 15, null, '<h4>' . get_string('clasificacionsemantica', 'vocabulario') . '</h4>', 0, 1, 0);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'L', 0);
                                $pdf->writeHTMLCell(0, 0, 15, null, '<h4>' . get_string('clasificacionformal', 'vocabulario') . '</h4>', 0, 1, 0);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[1], 0, 'L', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();

                                //femenino
                                $pdf->SetTextColor(59,89,152);
                                $pdf->writeHTMLCell(0, 0, 10, null, '<h3>' . get_string('femenino', 'vocabulario') . '</h3>', 0, 1, 0);
                                $pdf->Ln();
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->writeHTMLCell(0, 0, 15, null, '<h4>' . get_string('clasificacionsemantica', 'vocabulario') . '</h4>', 0, 1, 0);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[2], 0, 'L', 0);
                                $pdf->Ln();
                                $pdf->writeHTMLCell(0, 0, 15, null, '<h4>' . get_string('clasificacionformal', 'vocabulario') . '</h4>', 0, 1, 0);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[3], 0, 'L', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();

                                //neutro
                                $pdf->SetTextColor(59,89,152);
                                $pdf->writeHTMLCell(0, 0, 10, null, '<h3>' . get_string('neutro', 'vocabulario') . '</h3>', 0, 1, 0);
                                $pdf->Ln();
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->writeHTMLCell(0, 0, 15, null, '<h4>' . get_string('clasificacionsemantica', 'vocabulario') . '</h4>', 0, 1, 0);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[4], 0, 'L', 0);
                                $pdf->Ln();
                                $pdf->writeHTMLCell(0, 0, 15, null, '<h4>' . get_string('clasificacionformal', 'vocabulario') . '</h4>', 0, 1, 0);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[5], 0, 'L', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();
                                
                                break;
                            //1.2
                            case 4:

                                $pdf->setLeftMargin(MARGIN);
                                $pdf->SetTextColor(59,89,152);
                                $pdf->SetFont('freeserif', 'B', '10');
                                $pdf->SetFillColor(59, 89, 152); //#3B5998

                                $pdf->writeHTMLCell(0, 0, 10, 20, '<h3>' . get_string('endungs', 'vocabulario') . '</h3>', 0, 1, 0);
                                $pdf->Ln();
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'L', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();
                                $pdf->SetTextColor(59,89,152);
                                $pdf->writeHTMLCell(0, 0, 10, null, '<h3>' . get_string('genero', 'vocabulario') . '</h3>', 0, 1, 0);
                                $pdf->Ln();
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[1], 0, 'L', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();
                                
                                $pdf->SetTextColor(59,89,152);
                                $pdf->writeHTMLCell(0, 0, 10, null, '<h3>' . get_string('endungp', 'vocabulario') . '</h3>', 0, 1, 0);
                                $pdf->Ln();
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[2], 0, 'L', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();
                                
                                $pdf->SetTextColor(59,89,152);
                                $pdf->writeHTMLCell(0, 0, 10, null, '<h3>' . get_string('reinesf', 'vocabulario') . '</h3>', 0, 1, 0);
                                $pdf->Ln();
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[3], 0, 'L', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();
                                
                                $pdf->SetTextColor(59,89,152);
                                $pdf->writeHTMLCell(0, 0, 10, null, '<h3>' . get_string('reinepf', 'vocabulario') . '</h3>', 0, 1, 0, true);
                                $pdf->Ln();
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[4], 0, 'L', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();
                                break;
                            //8.4.1 Konjunktoren
                            case 63:
                            //8.4.2 Subjunktoren
                            case 64:
                            //8.4.3 Konjunktionaladverbien
                            case 65:
                            //3.1.4 Partizip I
                            case 24:
                            //3.3 Trennbare Verben
                            case 28:
                            //3.1.5 Futur I
                            case 25:
                            //3.1.6 Futur II
                            case 26:
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->SetFont('freeserif', 'B', '10');

                                if ($grid == 25) {
                                    $titulo = get_string("futuro1", "vocabulario");
                                } elseif ($grid == 26) {
                                    $titulo = get_string("futuro2", "vocabulario");
                                } elseif ($grid == 28) {
                                    $titulo = get_string('trennbaren', 'vocabulario');
                                } elseif ($grid == 24) {
                                    $titulo = get_string('participio1', 'vocabulario');
                                } elseif ($grid == 63 && $grid == 64 && $grid == 65) {
                                    $titulo = get_string('func', 'vocabulario');
                                }
                                
                                $pdf->Ln();
                                $pdf->SetTextColor(59,89,152);
                                $pdf->writeHTMLCell(0, 0, 10, null, '<h3>' . $titulo . '</h3>', 0, 1, 0);
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'L', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();
                                break;
                            //7.1 Beispiele und Funktionen
                            case 54:
                            //3.1.3 Perfekt/Partizip II
                            case 23:

                                if ($grid == 23) {
                                    $titulo0 = get_string('irregulares', 'vocabulario');
                                    $titulo1 = get_string('participio2', 'vocabulario');
                                    $titulo2 = get_string('hilfsverbs', 'vocabulario');
                                } elseif ($grid == 54) {
                                    $titulo0 = get_string('beispielsatz', 'vocabulario');
                                    $titulo1 = get_string('satzart', 'vocabulario');
                                    $titulo2 = get_string('komfun', 'vocabulario');
                                }

                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->SetFont('freeserif', 'B', '10');
                                $pdf->SetFillColor(59, 89, 152); //#3B5998
                                $pdf->setLeftMargin(MARGIN);

                                $pdf->Ln();
                                $pdf->SetTextColor(59,89,152);
                                $pdf->writeHTMLCell(0, 0, 10, null, '<h3>' . $titulo0 . '</h3>', 0, 1, 0);
                                $pdf->Ln();
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'L', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();

                                $pdf->SetTextColor(59,89,152);
                                $pdf->writeHTMLCell(0, 0, 10, null, '<h3>' . $titulo1 . '</h3>', 0, 1, 0);
                                $pdf->Ln();
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[1], 0, 'L', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();

                                $pdf->SetTextColor(59,89,152);
                                $pdf->writeHTMLCell(0, 0, 10, null, '<h3>' . $titulo2 . '</h3>', 0, 1, 0);
                                $pdf->Ln();
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[2], 0, 'L', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();

                                break;
                            //8.3.1 Ergänzungen
                            case 59:
                            //3.6 Passiv
                            case 31:

                                if ($grid == 31) {
                                    $titulo0 = get_string('zustandspassiv', 'vocabulario');
                                    $titulo1 = get_string('vorganspassiv', 'vocabulario');
                                } elseif ($grid == 59) {
                                    $titulo0 = get_string('definido', 'vocabulario');
                                    $titulo1 = get_string('indefinido', 'vocabulario');
                                }

                                $pdf->Ln();
                                $pdf->SetFont('freeserif', 'B', '10');
                                $pdf->SetFillColor(59, 89, 152); //#3B5998
                                $pdf->setLeftMargin(MARGIN);

                                $pdf->SetTextColor(59,89,152);
                                $pdf->writeHTMLCell(0, 0, 10, null, '<h3>' . $titulo0 . '</h3>', 0, 1, 0);
                                $pdf->Ln();
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'L', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();

                                $pdf->SetTextColor(59,89,152);
                                $pdf->writeHTMLCell(0, 0, 10, null, '<h3>' . $titulo1 . '</h3>', 0, 1, 0);
                                $pdf->Ln();
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[1], 0, 'L', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();

                                break;
                            //8.3.2 Angaben
                            case 60:
                                $titulo0 = get_string('temporal', 'vocabulario');
                                $titulo1 = get_string('causal', 'vocabulario');
                                $titulo2 = get_string('modal', 'vocabulario');
                                $titulo3 = get_string('local', 'vocabulario');

                                $pdf->Ln();
                                $pdf->SetFont('freeserif', 'B', '10');
                                $pdf->SetFillColor(59, 89, 152); //#3B5998
                                $pdf->setLeftMargin(MARGIN);

                                $pdf->SetTextColor(59,89,152);
                                $pdf->writeHTMLCell(0, 0, 10, null, '<h3>' . $titulo0 . '</h3>', 0, 1, 0);
                                $pdf->Ln();
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'L', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();

                                $pdf->SetTextColor(59,89,152);
                                $pdf->writeHTMLCell(0, 0, 10, null, '<h3>' . $titulo1 . '</h3>', 0, 1, 0);
                                $pdf->Ln();
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[1], 0, 'L', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();

                                $pdf->SetTextColor(59,89,152);
                                $pdf->writeHTMLCell(0, 0, 10, null, '<h3>' . $titulo2 . '</h3>', 0, 1, 0);
                                $pdf->Ln();
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[2], 0, 'L', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();

                                $pdf->SetTextColor(59,89,152);
                                $pdf->writeHTMLCell(0, 0, 10, null, '<h3>' . $titulo3 . '</h3>', 0, 1, 0);
                                $pdf->Ln();
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[3], 0, 'L', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();
                                break;
                            //5.2.1
                            case 47:
                                //Tabla 1
                                //primera Cabecera

                                $pdf->setLeftMargin(MARGIN);
                                $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFont('freeserif', 'B', '12');
                                $pdf->SetFillColor(59, 89, 152); //#3B5998
                                $pdf->setLineWidth(0.3);
                                $pdf->Ln();
                                $pdf->Cell(190, 8, get_string('declinacion1', 'vocabulario'), 1, 1, 'C', 1);

                                //Cabeceras

                                $pdf->SetFont('freeserif', 'B', '10');
                                $pdf->Cell(30, 5, '', 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, get_string('masculino', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, get_string('femenino', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, get_string('neutro', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, get_string('pluralAl', 'vocabulario'), 1, 1, 'C', 1);

                                //filas
                                $pdf->setTextColor(TEXT_AUTO);
                                $pdf->SetFont('freeserif', 'B', '10');
                                $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                $pdf->Cell(30, 5, get_string('nominativo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, $descripcion_troceada[0], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[1], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[2], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[3], 1, 1, 'C', 0);

                                $pdf->Cell(30, 5, get_string('acusativo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, $descripcion_troceada[4], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[5], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[6], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[7], 1, 1, 'C', 0);

                                $pdf->Cell(30, 5, get_string('dativo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, $descripcion_troceada[8], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[9], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[10], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[11], 1, 1, 'C', 0);

                                $pdf->Cell(30, 5, get_string('genitivo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, $descripcion_troceada[12], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[13], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[14], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[15], 1, 1, 'C', 0);

                                $pdf->Ln();
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->SetTextColor(59,89,152);
                                $pdf->writeHTMLCell(0, 0, 10, null, '<h4>' . get_string('particular', 'vocabulario') . '</h4>', 0, 1, 0);
                                $pdf->Ln();
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->MultiCell(170, 5, $descripcion_troceada[16], 0, 'L', 0);
                                $pdf->Ln();
                                $pdf->SetTextColor(59,89,152);
                                $pdf->writeHTMLCell(0, 0, 10, null, '<h4>' . get_string('despuesde', 'vocabulario') . '</h4>', 0, 1, 0);
                                $pdf->Ln();
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->MultiCell(170, 5, $descripcion_troceada[17], 0, 'L', 0);

                                $pdf->setLeftMargin(MARGIN);

                                $pdf->Ln();

                                //Tabla 2
                                //primera Cabecera
                                $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFont('freeserif', 'B', '12');
                                $pdf->SetFillColor(59, 89, 152); //#3B5998
                                $pdf->setLineWidth(0.3);

                                $pdf->Cell(190, 8, get_string('declinacion2', 'vocabulario'), 1, 1, 'C', 1);

                                //Cabeceras

                                $pdf->SetFont('freeserif', 'B', '10');

                                $pdf->Cell(30, 5, '', 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, get_string('masculino', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, get_string('femenino', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, get_string('neutro', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, get_string('pluralAl', 'vocabulario'), 1, 1, 'C', 1);

                                //filas
                                $pdf->setTextColor(TEXT_AUTO);
                                $pdf->SetFont('freeserif', 'B', '10');
                                $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                $pdf->Cell(30, 5, get_string('nominativo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, $descripcion_troceada[18], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[19], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[20], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[21], 1, 1, 'C', 0);

                                $pdf->Cell(30, 5, get_string('acusativo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, $descripcion_troceada[22], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[23], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[24], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[25], 1, 1, 'C', 0);

                                $pdf->Cell(30, 5, get_string('dativo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, $descripcion_troceada[26], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[27], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[28], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[29], 1, 1, 'C', 0);

                                $pdf->Cell(30, 5, get_string('genitivo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, $descripcion_troceada[30], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[31], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[32], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[33], 1, 1, 'C', 0);

                                $pdf->Ln();
                                $pdf->setLeftMargin(MARGIN_L2);
                                
                                $pdf->SetTextColor(59,89,152);
                                $pdf->writeHTMLCell(0, 0, 10, null, '<h4>' . get_string('particular', 'vocabulario') . '</h4>', 0, 1, 0);
                                $pdf->Ln();
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->MultiCell(170, 5, $descripcion_troceada[34], 0, 'L', 0);
                                $pdf->Ln();
                                $pdf->SetTextColor(59,89,152);
                                $pdf->writeHTMLCell(0, 0, 10, null, '<h4>' . get_string('despuesde', 'vocabulario') . '</h4>', 0, 1, 0);
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->MultiCell(170, 5, $descripcion_troceada[35], 0, 'L', 0);

                                $pdf->setLeftMargin(MARGIN);

                                $pdf->Ln();

                                //Tabla 3
                                //primera Cabecera
                                $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFont('freeserif', 'B', '12');
                                $pdf->SetFillColor(59, 89, 152); //#3B5998
                                $pdf->setLineWidth(0.3);

                                $pdf->Cell(190, 8, get_string('declinacion3', 'vocabulario'), 1, 1, 'C', 1);

                                //Cabeceras

                                $pdf->SetFont('freeserif', 'B', '10');

                                $pdf->Cell(30, 5, '', 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, get_string('masculino', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, get_string('femenino', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, get_string('neutro', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, get_string('pluralAl', 'vocabulario'), 1, 1, 'C', 1);

                                //filas
                                $pdf->setTextColor(TEXT_AUTO);
                                $pdf->SetFont('freeserif', 'B', '10');
                                $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                $pdf->Cell(30, 5, get_string('nominativo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, $descripcion_troceada[36], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[37], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[38], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[39], 1, 1, 'C', 0);

                                $pdf->Cell(30, 5, get_string('acusativo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, $descripcion_troceada[40], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[41], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[42], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[43], 1, 1, 'C', 0);

                                $pdf->Cell(30, 5, get_string('dativo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, $descripcion_troceada[44], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[45], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[46], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[47], 1, 1, 'C', 0);

                                $pdf->Cell(30, 5, get_string('genitivo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, $descripcion_troceada[48], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[49], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[50], 1, 0, 'C', 0);
                                $pdf->Cell(40, 5, $descripcion_troceada[51], 1, 1, 'C', 0);

                                $pdf->Ln();
                                $pdf->setLeftMargin(MARGIN_L2); 
                                $pdf->SetTextColor(59,89,152);
                                $pdf->writeHTMLCell(0, 0, 10, null, '<h4>' . get_string('particular', 'vocabulario') . '</h4>', 0, 1, 0);
                                $pdf->Ln();
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->MultiCell(170, 5, $descripcion_troceada[52], 0, 'L', 0);
                                $pdf->Ln();
                                $pdf->SetTextColor(59,89,152);
                                $pdf->writeHTMLCell(0, 0, 10, null, '<h4>' . get_string('despuesde', 'vocabulario') . '</h4>', 0, 1, 0);
                                $pdf->Ln();
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->MultiCell(170, 5, $descripcion_troceada[53], 0, 'L', 0);

                                $pdf->setLeftMargin(MARGIN);

                                $pdf->Ln();

                                break;
                            //3.1.1 Präsens
                            case 21:
                            //3.1.2 Präteritum
                            case 22:

                                //$pintadoAst = false;
                                $numtablas = (count($descripcion_troceada) - 2) / 21;
                                $pintarChuleta = false;
                                $todovacio = true;

                                for ($i = 0; $i < $numtablas; $i++) {
                                    $pintar = false;

                                    if ($i == $numtablas - 1 && $todovacio) {
                                        $pintar = true;
                                        $pintarChuleta = true;
                                    }

                                    for ($j = 0; $j < 21 && $pintar == false; $j++) {
                                        if ($descripcion_troceada[(21 * $i) + $j]) {
                                            $pintar = true;
                                            $pintarChuleta = true;
                                            $todovacio = false;
                                        }
                                    }

                                    if ($pintar) {

                                        $pdf->setLeftMargin(MARGIN);
                                        $pdf->SetTextColor(TEXT_WHITE);
                                        $pdf->SetFont('freeserif', 'B', '10');
                                        $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                        $pdf->setLineWidth(0.3);

                                        //cabeceras
                                        $pdf->Ln();
                                        $pdf->Cell(22, 5, '', 'TLB', 0, 'C', 1);
                                        $pdf->Cell(56, 5, get_string('schwache', 'vocabulario') . '*', 'TRB', 0, 'C', 1);
                                        $pdf->Cell(56, 5, get_string('starke', 'vocabulario') . '**', 1, 0, 'C', 1);
                                        $pdf->Cell(56, 5, get_string('gemischte', 'vocabulario') . '***', 1, 1, 'C', 1);

                                        $pdf->SetTextColor(TEXT_AUTO);
                                        $pdf->SetFont('freeserif', 'B', '10');
                                        $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito
                                        //la tabla
                                        $pdf->Cell(22, 5, get_string('infinitivo', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21 * $i) + 0], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21 * $i) + 7], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21 * $i) + 14], 1, 1, 'C', 0);

                                        $pdf->Cell(190, 5, '', 1, 1, 'C', 0);

                                        $pdf->Cell(22, 5, get_string('S1', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21 * $i) + 1], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21 * $i) + 8], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21 * $i) + 15], 1, 1, 'C', 0);

                                        $pdf->Cell(22, 5, get_string('S2', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21 * $i) + 2], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21 * $i) + 9], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21 * $i) + 16], 1, 1, 'C', 0);

                                        $pdf->Cell(22, 5, get_string('S3', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21 * $i) + 3], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21 * $i) + 10], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21 * $i) + 17], 1, 1, 'C', 0);

                                        $pdf->Cell(22, 5, get_string('P1', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21 * $i) + 4], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21 * $i) + 11], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21 * $i) + 18], 1, 1, 'C', 0);

                                        $pdf->Cell(22, 5, get_string('P2', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21 * $i) + 5], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21 * $i) + 12], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21 * $i) + 19], 1, 1, 'C', 0);

                                        $pdf->Cell(22, 5, get_string('P3', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21 * $i) + 6], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21 * $i) + 13], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21 * $i) + 20], 1, 1, 'C', 0);

                                        $pdf->Ln();
                                    }
                                }

                                if ($pintarChuleta == true) {
                                    $pdf->SetTextColor(TEXT_AUTO);

                                    $pdf->SetFont('freeserif', '', '10');
                                    $pdf->Cell(5, 5, '*', 0, 0, 'L', 0);
                                    $pdf->Cell(0, 5, get_string('par_schwac', 'vocabulario'), 0, 1, 'L', 0);
                                    $pdf->Cell(5, 5, '**', 0, 0, 'L', 0);
                                    $pdf->Cell(0, 5, get_string('par_star', 'vocabulario'), 0, 1, 'L', 0);
                                    $pdf->Cell(5, 5, '***', 0, 0, 'L', 0);
                                    $pdf->Cell(0, 5, get_string('par_gemis', 'vocabulario'), 0, 1, 'L', 0);

                                    $pdf->Ln();
                                }


                                break;
                            //3.7.2 Konjunktiv II
                            case 34:
                                $pdf->setLeftMargin(MARGIN_L5);
                                $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFont('freeserif', 'B', 10);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                $pdf->setLineWidth(0.3);
                                //tabla 1
                                //cabecera
                                $pdf->Ln();
                                $pdf->Cell(110, 5, get_string('schwache_siehe', 'vocabulario'), 1, 1, 'C', 1);

                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->SetFont('freeserif', '', 10);
                                $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito
                                //filas
                                $pdf->Cell(24, 5, get_string('S1', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(86, 5, $descripcion_troceada[0], 1, 1, 'C', 0);

                                $pdf->Cell(24, 5, get_string('S2', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(86, 5, $descripcion_troceada[1], 1, 1, 'C', 0);

                                $pdf->Cell(24, 5, get_string('S3', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(86, 5, $descripcion_troceada[2], 1, 1, 'C', 0);

                                $pdf->Cell(24, 5, get_string('P1', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(86, 5, $descripcion_troceada[3], 1, 1, 'C', 0);

                                $pdf->Cell(24, 5, get_string('P2', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(86, 5, $descripcion_troceada[4], 1, 1, 'C', 0);

                                $pdf->Cell(24, 5, get_string('P3', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(86, 5, $descripcion_troceada[5], 1, 1, 'C', 0);

                                $pdf->SetLeftMargin(MARGIN);

                                $pdf->Ln();

                                //tabla 2
                                $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFont('freeserif', 'B', 10);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                //cabecera
                                $pdf->Cell(24, 5, '', 'TLB', 0, 'C', 1);
                                $pdf->Cell(166, 5, get_string('starke', 'vocabulario'), 'TRB', 1, 'C', 1);
                                $pdf->Cell(24, 5, '', 1, 0, 'C', 1);
                                $pdf->Cell(83, 5, get_string('preterito', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(83, 5, get_string('conjuntivo2', 'vocabulario'), 1, 1, 'C', 1);

                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->SetFont('freeserif', '', 10);
                                $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul cla
                                //filas
                                $pdf->Cell(24, 5, get_string('S1', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(83, 5, $descripcion_troceada[6], 1, 0, 'C', 0);
                                $pdf->Cell(83, 5, $descripcion_troceada[7], 1, 1, 'C', 0);

                                $pdf->Cell(24, 5, get_string('S2', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(83, 5, $descripcion_troceada[8], 1, 0, 'C', 0);
                                $pdf->Cell(83, 5, $descripcion_troceada[9], 1, 1, 'C', 0);

                                $pdf->Cell(24, 5, get_string('S3', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(83, 5, $descripcion_troceada[10], 1, 0, 'C', 0);
                                $pdf->Cell(83, 5, $descripcion_troceada[11], 1, 1, 'C', 0);

                                $pdf->Cell(24, 5, get_string('P1', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(83, 5, $descripcion_troceada[12], 1, 0, 'C', 0);
                                $pdf->Cell(83, 5, $descripcion_troceada[13], 1, 1, 'C', 0);

                                $pdf->Cell(24, 5, get_string('P2', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(83, 5, $descripcion_troceada[14], 1, 0, 'C', 0);
                                $pdf->Cell(83, 5, $descripcion_troceada[15], 1, 1, 'C', 0);

                                $pdf->Cell(24, 5, get_string('P3', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(83, 5, $descripcion_troceada[16], 1, 0, 'C', 0);
                                $pdf->Cell(83, 5, $descripcion_troceada[17], 1, 1, 'C', 0);

                                $pdf->Ln();

                                break;
                            //3.2 Modalverben
                            case 27:
                            //3.4 Besondere Verben
                            case 29:
                                //tabla
                                $numtablas = (count($descripcion_troceada) - 2) / 31;
                                $todovacio = true;
                                for ($i = 0; $i < $numtablas; $i++) {
                                    $pintar = false;

                                    if ($i == $numtablas - 1 && $todovacio) {
                                        $pintar = true;
                                    }

                                    for ($j = 0; $j < 31 && $pintar == false; $j++) {
                                        if ($descripcion_troceada[(31 * $i) + $j]) {
                                            $pintar = true;
                                            $todovacio = false;
                                        }
                                    }

                                    if ($pintar) {
                                        $pdf->setLeftMargin(MARGIN);
                                        $pdf->SetTextColor(TEXT_WHITE);
                                        $pdf->SetFont('freeserif', 'B', 10);
                                        $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                        $pdf->setLineWidth(0.3);

                                        //cabecera infinitiva
                                        $pdf->Ln();
                                        $pdf->Cell(20, 5, get_string('infinitivo', 'vocabulario'), 1, 0, 'C', 1);

                                        $pdf->SetTextColor(TEXT_AUTO);
                                        $pdf->SetFont('freeserif', '', 10);

                                        $pdf->Cell(170, 5, $descripcion_troceada[(31 * $i) + 0], 1, 1, 'C', 0);


                                        //cabeceras indicativo / conjuntivo

                                        $pdf->SetTextColor(TEXT_WHITE);
                                        $pdf->SetFont('freeserif', 'B', 10);

                                        $pdf->Cell(20, 5, '', 'TLB', 0, 'C', 1);
                                        $pdf->Cell(102, 5, get_string('indicativo', 'vocabulario'), 'TRB', 0, 'C', 1);
                                        $pdf->Cell(68, 5, get_string('conjuntivo', 'vocabulario'), 1, 1, 'C', 1);

                                        //cabeceras
                                        $pdf->Cell(20, 5, '', 'TLB', 0, 'C', 1);
                                        $pdf->Cell(34, 5, get_string('prasens', 'vocabulario'), 'TRB', 0, 'C', 1);
                                        $pdf->Cell(34, 5, get_string('preterito', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(34, 5, get_string('perfecto', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(34, 5, get_string('conjuntivo1', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(34, 5, get_string('conjuntivo2', 'vocabulario'), 1, 1, 'C', 1);

                                        $pdf->SetTextColor(TEXT_AUTO);
                                        $pdf->SetFont('freeserif', '', 10);
                                        $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito
                                        //la tabla

                                        $pdf->Cell(20, 5, get_string('S1', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 1], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 2], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 3], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 4], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 5], 1, 1, 'C', 0);

                                        $pdf->Cell(20, 5, get_string('S2', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 6], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 7], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 8], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 9], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 10], 1, 1, 'C', 0);

                                        $pdf->Cell(20, 5, get_string('S3', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 11], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 12], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 13], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 14], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 15], 1, 1, 'C', 0);

                                        $pdf->Cell(20, 5, get_string('P1', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 16], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 17], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 18], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 19], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 20], 1, 1, 'C', 0);

                                        $pdf->Cell(20, 5, get_string('P2', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 21], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 22], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 23], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 24], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 25], 1, 1, 'C', 0);

                                        $pdf->Cell(20, 5, get_string('P3', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 26], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 27], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 28], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 29], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31 * $i) + 30], 1, 1, 'C', 0);

                                        $pdf->Ln();
                                    }
                                }

                                break;
                            //3.7.1 Konjunktiv I
                            case 33:
                                $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFont('freeserif', 'B', 10);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                $pdf->setLeftMargin(MARGIN);

                                //cabecera
                                $pdf->Ln();
                                $pdf->Cell(24, 5, '', 1, 0, 'C', 1);
                                $pdf->Cell(83, 5, get_string('sein', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(83, 5, get_string('andere', 'vocabulario'), 1, 1, 'C', 1);

                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->SetFont('freeserif', '', 10);
                                $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul claro
                                //filas
                                $pdf->Cell(24, 5, get_string('S1', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(83, 5, $descripcion_troceada[0], 1, 0, 'C', 0);
                                $pdf->Cell(83, 5, $descripcion_troceada[1], 1, 1, 'C', 0);

                                $pdf->Cell(24, 5, get_string('S2', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(83, 5, $descripcion_troceada[2], 1, 0, 'C', 0);
                                $pdf->Cell(83, 5, $descripcion_troceada[3], 1, 1, 'C', 0);

                                $pdf->Cell(24, 5, get_string('S3', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(83, 5, $descripcion_troceada[4], 1, 0, 'C', 0);
                                $pdf->Cell(83, 5, $descripcion_troceada[5], 1, 1, 'C', 0);

                                $pdf->Cell(24, 5, get_string('P1', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(83, 5, $descripcion_troceada[6], 1, 0, 'C', 0);
                                $pdf->Cell(83, 5, $descripcion_troceada[7], 1, 1, 'C', 0);

                                $pdf->Cell(24, 5, get_string('P2', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(83, 5, $descripcion_troceada[8], 1, 0, 'C', 0);
                                $pdf->Cell(83, 5, $descripcion_troceada[9], 1, 1, 'C', 0);

                                $pdf->Cell(24, 5, get_string('P3', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(83, 5, $descripcion_troceada[10], 1, 0, 'C', 0);
                                $pdf->Cell(83, 5, $descripcion_troceada[11], 1, 1, 'C', 0);

                                $pdf->Ln();

                                break;
                            //2.5 Possessivpronomen
                            case 15:

                                $numtablas = (count($descripcion_troceada) - 2) / 25;
                                $todovacio = true;
                                for ($i = 0; $i < $numtablas; $i++) {
                                    $pintar = false;

                                    if ($i == $numtablas - 1 && $todovacio) {
                                        $pintar = true;
                                    }

                                    for ($j = 0; $j < 25 && $pintar == false; $j++) {
                                        if ($descripcion_troceada[(25 * $i) + $j]) {
                                            $todovacio = false;
                                            $pintar = true;
                                        }
                                    }

                                    if ($pintar) {

                                        $pdf->SetTextColor(TEXT_WHITE);

                                        $pdf->SetFillColor(59, 89, 152); //#3B5998
                                        $pdf->setLeftMargin(MARGIN);

                                        $pdf->SetFont('freeserif', 'B', 12);
                                        //cabecera grande
                                        $pdf->Ln();
                                        $pdf->Cell(190, 6, get_string('possessiv1', 'vocabulario'), 1, 1, 'C', 1);
                                        //separador
                                        $pdf->Cell(190, 3, '', 0, 1, 'C', 0);

                                        //cabeceras chicas tabla 1.1

                                        $pdf->SetFont('freeserif', 'B', 10);

                                        $pdf->Cell(20, 5, '', 'LTB', 0, 'C', 1);
                                        $pdf->Cell(170, 5, get_string('singAl', 'vocabulario'), 'TRB', 1, 'C', 1);
                                        $pdf->Cell(20, 5, '', 'LT', 0, 'C', 1);
                                        $pdf->Cell(34, 5, '1', 'TR', 0, 'C', 1);
                                        $pdf->Cell(34, 5, '2', 'LTR', 0, 'C', 1);
                                        $pdf->Cell(102, 5, '3', 'LTR', 1, 'C', 1);

                                        $pdf->Cell(20, 5, '', 'LB', 0, 'C', 1);
                                        $pdf->Cell(34, 5, '', 'BR', 0, 'C', 1);
                                        $pdf->Cell(34, 5, '', 'LBR', 0, 'C', 1);
                                        $pdf->Cell(34, 5, 'm', 'LB', 0, 'C', 1);
                                        $pdf->Cell(34, 5, 'n', 'B', 0, 'C', 1);
                                        $pdf->Cell(34, 5, 'f', 'BR', 1, 'C', 1);

                                        //celdas tabla 1.1

                                        $pdf->setTextColor(TEXT_AUTO);
                                        $pdf->SetFont('freeserif', '', 10);
                                        $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                        $pdf->Cell(20, 5, get_string('nominativo', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(25 * $i) + 0], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(25 * $i) + 1], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(25 * $i) + 2], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(25 * $i) + 3], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(25 * $i) + 4], 1, 1, 'C', 0);

                                        $pdf->Ln();

                                        //cabeceras chicas tabla 1.2
                                        $pdf->SetTextColor(TEXT_WHITE);
                                        $pdf->SetFont('freeserif', 'B', 10);
                                        $pdf->SetFillColor(59, 89, 152); //#3B5998

                                        $pdf->Cell(20, 5, '', 'LTB', 0, 'C', 1);
                                        $pdf->Cell(126, 5, get_string('pluralAl', 'vocabulario'), 'TRB', 0, 'C', 1);
                                        $pdf->Cell(44, 5, '', 'LTR', 1, 'C', 1);

                                        $pdf->Cell(20, 5, '', 'LT', 0, 'C', 1);
                                        $pdf->Cell(42, 5, '1', 'TR', 0, 'C', 1);
                                        $pdf->Cell(42, 5, '2', 'LTR', 0, 'C', 1);
                                        $pdf->Cell(42, 5, '3', 'LTR', 0, 'C', 1);
                                        $pdf->Cell(44, 5, get_string('sie', 'vocabulario'), 'LR', 1, 'C', 1);

                                        //celdas tabla 1.2

                                        $pdf->setTextColor(TEXT_AUTO);
                                        $pdf->SetFont('freeserif', '', 10);
                                        $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                        $pdf->Cell(20, 5, get_string('nominativo', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(25 * $i) + 5], 1, 0, 'C', 0);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(25 * $i) + 6], 1, 0, 'C', 0);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(25 * $i) + 7], 1, 0, 'C', 0);
                                        $pdf->Cell(44, 5, $descripcion_troceada[(25 * $i) + 8], 1, 1, 'C', 0);

                                        $pdf->Ln();
                                        $pdf->Ln();

                                        //cabecera grande

                                        $pdf->SetTextColor(TEXT_WHITE);
                                        $pdf->SetFillColor(59, 89, 152); //#3B5998
                                        $pdf->SetFont('freeserif', 'B', 12);

                                        $pdf->Cell(190, 6, get_string('declinacion_siehe', 'vocabulario'), 1, 1, 'C', 1);

                                        //cabeceras chicas tabla 2
                                        $pdf->SetFont('freeserif', 'B', 10);

                                        $pdf->Cell(22, 5, '', 'LTB', 0, 'C', 1);
                                        $pdf->Cell(42, 5, get_string('masculino', 'vocabulario'), 'TRB', 0, 'C', 1);
                                        $pdf->Cell(42, 5, get_string('neutro', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(42, 5, get_string('femenino', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(42, 5, get_string('pluralAl', 'vocabulario'), 1, 1, 'C', 1);

                                        //celdas tabla 2

                                        $pdf->setTextColor(TEXT_AUTO);
                                        $pdf->SetFont('freeserif', '', 10);
                                        $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                        $pdf->Cell(22, 5, get_string('nominativo', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(25 * $i) + 9], 1, 0, 'C', 0);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(25 * $i) + 10], 1, 0, 'C', 0);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(25 * $i) + 11], 1, 0, 'C', 0);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(25 * $i) + 12], 1, 1, 'C', 0);
                                        $pdf->Cell(22, 5, get_string('acusativo', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(25 * $i) + 13], 1, 0, 'C', 0);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(25 * $i) + 14], 1, 0, 'C', 0);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(25 * $i) + 15], 1, 0, 'C', 0);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(25 * $i) + 16], 1, 1, 'C', 0);
                                        $pdf->Cell(22, 5, get_string('dativo', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(25 * $i) + 17], 1, 0, 'C', 0);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(25 * $i) + 18], 1, 0, 'C', 0);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(25 * $i) + 19], 1, 0, 'C', 0);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(25 * $i) + 20], 1, 1, 'C', 0);
                                        $pdf->Cell(22, 5, get_string('genitivo', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(25 * $i) + 21], 1, 0, 'C', 0);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(25 * $i) + 22], 1, 0, 'C', 0);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(25 * $i) + 23], 1, 0, 'C', 0);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(25 * $i) + 24], 1, 1, 'C', 0);

                                        $pdf->Ln();
                                    }
                                }

                                break;

                            //4.3 Possessivartikel
                            case 39:

                                $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->SetFont('freeserif', 'B', 12);

                                //cabecera grande
                                $pdf->Ln();
                                $pdf->Cell(190, 6, get_string('possessiv2', 'vocabulario'), 1, 1, 'C', 1);
                                //separador
                                $pdf->Cell(190, 3, '', 0, 1, 'C', 0);

                                //cabeceras chicas tabla 1.1
                                $pdf->SetFont('freeserif', 'B', 10);

                                $pdf->Cell(20, 5, '', 'LTB', 0, 'C', 1);
                                $pdf->Cell(170, 5, get_string('singAl', 'vocabulario'), 'TRB', 1, 'C', 1);
                                $pdf->Cell(20, 5, '', 'LT', 0, 'C', 1);
                                $pdf->Cell(34, 5, '1', 'TR', 0, 'C', 1);
                                $pdf->Cell(34, 5, '2', 'LTR', 0, 'C', 1);
                                $pdf->Cell(102, 5, '3', 'LTR', 1, 'C', 1);

                                $pdf->Cell(20, 5, '', 'LB', 0, 'C', 1);
                                $pdf->Cell(34, 5, '', 'BR', 0, 'C', 1);
                                $pdf->Cell(34, 5, '', 'LBR', 0, 'C', 1);
                                $pdf->Cell(34, 5, 'm', 'LB', 0, 'C', 1);
                                $pdf->Cell(34, 5, 'n', 'B', 0, 'C', 1);
                                $pdf->Cell(34, 5, 'f', 'BR', 1, 'C', 1);

                                //celdas tabla 1.1

                                $pdf->setTextColor(TEXT_AUTO);
                                $pdf->SetFont('freeserif', '', 10);
                                $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                $pdf->Cell(20, 5, get_string('nominativo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(34, 5, $descripcion_troceada[0], 1, 0, 'C', 0);
                                $pdf->Cell(34, 5, $descripcion_troceada[1], 1, 0, 'C', 0);
                                $pdf->Cell(34, 5, $descripcion_troceada[2], 1, 0, 'C', 0);
                                $pdf->Cell(34, 5, $descripcion_troceada[3], 1, 0, 'C', 0);
                                $pdf->Cell(34, 5, $descripcion_troceada[4], 1, 1, 'C', 0);

                                $pdf->Ln();

                                //cabeceras chicas tabla 1.2
                                $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFont('freeserif', 'B', 10);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998

                                $pdf->Cell(20, 5, '', 'LTB', 0, 'C', 1);
                                $pdf->Cell(126, 5, get_string('pluralAl', 'vocabulario'), 'TRB', 0, 'C', 1);
                                $pdf->Cell(44, 5, '', 'LTR', 1, 'C', 1);

                                $pdf->Cell(20, 5, '', 'LT', 0, 'C', 1);
                                $pdf->Cell(42, 5, '1', 'TR', 0, 'C', 1);
                                $pdf->Cell(42, 5, '2', 'LTR', 0, 'C', 1);
                                $pdf->Cell(42, 5, '3', 'LTR', 0, 'C', 1);
                                $pdf->Cell(44, 5, get_string('sie', 'vocabulario'), 'LR', 1, 'C', 1);

                                //celdas tabla 1.2

                                $pdf->setTextColor(TEXT_AUTO);
                                $pdf->SetFont('freeserif', '', 10);
                                $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                $pdf->Cell(20, 5, get_string('nominativo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(42, 5, $descripcion_troceada[5], 1, 0, 'C', 0);
                                $pdf->Cell(42, 5, $descripcion_troceada[6], 1, 0, 'C', 0);
                                $pdf->Cell(42, 5, $descripcion_troceada[7], 1, 0, 'C', 0);
                                $pdf->Cell(44, 5, $descripcion_troceada[8], 1, 1, 'C', 0);

                                $pdf->Ln();
                                $pdf->Ln();

                                $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFont('freeserif', 'B', 12);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                $pdf->setLineWidth(0.3);

                                //cabecera grande
                                $pdf->Cell(190, 6, get_string('endungen_siehe4', 'vocabulario'), 1, 1, 'C', 1);

                                $pdf->Ln();

                                $pintar = false;

                                for ($j = 9; $j < (count($descripcion_troceada) - 2) && $pintar == false; $j++) {
                                    if ($descripcion_troceada[$j]) {
                                        $pintar = true;
                                    }
                                }

                                if ($pintar) {
                                    $pdf->SetTextColor(TEXT_WHITE);
                                    //                                $pdf->SetFont('','B',12);
                                    $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                    $pdf->setLineWidth(0.3);

                                    //cabeceras
                                    $pdf->SetFont('freeserif', 'B', 10);

                                    $pdf->Cell(22, 5, '', 'TLB', 0, 'C', 1);
                                    $pdf->Cell(168, 5, get_string('declinacion4', 'vocabulario'), 'TRB', 1, 'C', 1);

                                    $pdf->Cell(22, 5, '', 'LTB', 0, 'C', 1);
                                    $pdf->Cell(42, 5, get_string('masculino', 'vocabulario'), 'TRB', 0, 'C', 1);
                                    $pdf->Cell(42, 5, get_string('neutro', 'vocabulario'), 1, 0, 'C', 1);
                                    $pdf->Cell(42, 5, get_string('femenino', 'vocabulario'), 1, 0, 'C', 1);
                                    $pdf->Cell(42, 5, get_string('pluralAl', 'vocabulario'), 1, 1, 'C', 1);

                                    //celdas

                                    $pdf->setTextColor(TEXT_AUTO);
                                    $pdf->SetFont('freeserif', '', 10);
                                    $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                    $pdf->Cell(22, 5, get_string('nominativo', 'vocabulario'), 1, 0, 'C', 1);
                                    $pdf->Cell(42, 5, $descripcion_troceada[9], 1, 0, 'C', 0);
                                    $pdf->Cell(42, 5, $descripcion_troceada[10], 1, 0, 'C', 0);
                                    $pdf->Cell(42, 5, $descripcion_troceada[11], 1, 0, 'C', 0);
                                    $pdf->Cell(42, 5, $descripcion_troceada[12], 1, 1, 'C', 0);
                                    $pdf->Cell(22, 5, get_string('acusativo', 'vocabulario'), 1, 0, 'C', 1);
                                    $pdf->Cell(42, 5, $descripcion_troceada[13], 1, 0, 'C', 0);
                                    $pdf->Cell(42, 5, $descripcion_troceada[14], 1, 0, 'C', 0);
                                    $pdf->Cell(42, 5, $descripcion_troceada[15], 1, 0, 'C', 0);
                                    $pdf->Cell(42, 5, $descripcion_troceada[16], 1, 1, 'C', 0);
                                    $pdf->Cell(22, 5, get_string('dativo', 'vocabulario'), 1, 0, 'C', 1);
                                    $pdf->Cell(42, 5, $descripcion_troceada[17], 1, 0, 'C', 0);
                                    $pdf->Cell(42, 5, $descripcion_troceada[18], 1, 0, 'C', 0);
                                    $pdf->Cell(42, 5, $descripcion_troceada[19], 1, 0, 'C', 0);
                                    $pdf->Cell(42, 5, $descripcion_troceada[20], 1, 1, 'C', 0);
                                    $pdf->Cell(22, 5, get_string('genitivo', 'vocabulario'), 1, 0, 'C', 1);
                                    $pdf->Cell(42, 5, $descripcion_troceada[21], 1, 0, 'C', 0);
                                    $pdf->Cell(42, 5, $descripcion_troceada[22], 1, 0, 'C', 0);
                                    $pdf->Cell(42, 5, $descripcion_troceada[23], 1, 0, 'C', 0);
                                    $pdf->Cell(42, 5, $descripcion_troceada[24], 1, 1, 'C', 0);

                                    $pdf->Ln();
                                }

                                break;

                            //4.1 Definitartikel
                            case 37:
                            //4.2 Indefinitartikel
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

                                //para decidir si la tabla es opcional o se debe mostrar una directamente
                                $tablasiempre = true;
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                $pdf->setLineWidth(0.3);
                                $pdf->SetFont('freeserif', 'B', 12);

                                switch ($grid) {
                                    case 40:
                                        $pdf->Cell(190, 6, get_string('endungen_siehe1', 'vocabulario'), 1, 1, 'C', 1);
                                        $pdf->Ln();
                                        $tablasiempre = false;
                                        break;
                                    case 42:
                                        $pdf->Cell(190, 6, get_string('endungen_siehe3', 'vocabulario'), 1, 1, 'C', 1);
                                        $pdf->Ln();
                                        $tablasiempre = false;
                                        break;
                                }

                                $numtablas = (count($descripcion_troceada) - 2) / 16;
                                $todovacio = true;

                                for ($i = 0; $i < $numtablas; $i++) {
                                    $pintar = false;

                                    if ($i == $numtablas - 1 && $todovacio && $tablasiempre) {
                                        $pintar = true;
                                    }

                                    for ($j = 0; $j < 16 && $pintar == false; $j++) {
                                        if ($descripcion_troceada[(16 * $i) + $j]) {
                                            $todovacio = false;
                                            $pintar = true;
                                        }
                                    }

                                    if ($pintar) {

                                        $pdf->SetTextColor(TEXT_WHITE);
                                        $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                        //cabeceras
                                        $pdf->SetFont('freeserif', 'B', 10);

                                        $pdf->Cell(22, 5, '', 'LTB', 0, 'C', 1);
                                        $pdf->Cell(42, 5, get_string('masculino', 'vocabulario'), 'TRB', 0, 'C', 1);
                                        $pdf->Cell(42, 5, get_string('neutro', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(42, 5, get_string('femenino', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(42, 5, get_string('pluralAl', 'vocabulario'), 1, 1, 'C', 1);

                                        //celdas

                                        $pdf->setTextColor(TEXT_AUTO);
                                        $pdf->SetFont('freeserif', '', 10);
                                        $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                        $pdf->Cell(22, 5, get_string('nominativo', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(16 * $i) + 0], 1, 0, 'C', 0);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(16 * $i) + 1], 1, 0, 'C', 0);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(16 * $i) + 2], 1, 0, 'C', 0);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(16 * $i) + 3], 1, 1, 'C', 0);
                                        $pdf->Cell(22, 5, get_string('acusativo', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(16 * $i) + 4], 1, 0, 'C', 0);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(16 * $i) + 5], 1, 0, 'C', 0);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(16 * $i) + 6], 1, 0, 'C', 0);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(16 * $i) + 7], 1, 1, 'C', 0);
                                        $pdf->Cell(22, 5, get_string('dativo', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(16 * $i) + 8], 1, 0, 'C', 0);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(16 * $i) + 9], 1, 0, 'C', 0);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(16 * $i) + 10], 1, 0, 'C', 0);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(16 * $i) + 11], 1, 1, 'C', 0);
                                        $pdf->Cell(22, 5, get_string('genitivo', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(16 * $i) + 12], 1, 0, 'C', 0);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(16 * $i) + 13], 1, 0, 'C', 0);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(16 * $i) + 14], 1, 0, 'C', 0);
                                        $pdf->Cell(42, 5, $descripcion_troceada[(16 * $i) + 15], 1, 1, 'C', 0);

                                        $pdf->Ln();
                                    }
                                }

                                break;

                            //2.2 Interrogativpronomen
                            case 8:

                                $numtablas = (count($descripcion_troceada) - 2) / 8;
                                $todovacio = true;

                                for ($i = 0; $i < $numtablas; $i++) {
                                    $pintar = false;

                                    if ($i == $numtablas - 1 && $todovacio) {
                                        $pintar = true;
                                    }

                                    for ($j = 0; $j < 8 && $pintar == false; $j++) {
                                        if ($descripcion_troceada[(8 * $i) + $j]) {
                                            $todovacio = false;
                                            $pintar = true;
                                        }
                                    }

                                    if ($pintar) {
                                        $pdf->setLeftMargin(MARGIN);
                                        $pdf->SetTextColor(TEXT_WHITE);
                                        $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                        $pdf->setLineWidth(0.3);
                                        //cabeceras
                                        $pdf->SetFont('freeserif', 'B', 10);

                                        $pdf->Ln();
                                        $pdf->Cell(24, 5, '', 'LTB', 0, 'C', 1);
                                        $pdf->Cell(83, 5, get_string('person', 'vocabulario'), 'TRB', 0, 'C', 1);
                                        $pdf->Cell(83, 5, get_string('nichtperson', 'vocabulario'), 1, 1, 'C', 1);

                                        //celdas

                                        $pdf->setTextColor(TEXT_AUTO);
                                        $pdf->SetFont('freeserif', '', 10);
                                        $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                        $pdf->Cell(24, 5, get_string('nominativo', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(83, 5, $descripcion_troceada[(8 * $i) + 0], 1, 0, 'C', 0);
                                        $pdf->Cell(83, 5, $descripcion_troceada[(8 * $i) + 1], 1, 1, 'C', 0);
                                        $pdf->Cell(24, 5, get_string('acusativo', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(83, 5, $descripcion_troceada[(8 * $i) + 2], 1, 0, 'C', 0);
                                        $pdf->Cell(83, 5, $descripcion_troceada[(8 * $i) + 3], 1, 1, 'C', 0);
                                        $pdf->Cell(24, 5, get_string('dativo', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(83, 5, $descripcion_troceada[(8 * $i) + 4], 1, 0, 'C', 0);
                                        $pdf->Cell(83, 5, $descripcion_troceada[(8 * $i) + 5], 1, 1, 'C', 0);
                                        $pdf->Cell(24, 5, get_string('genitivo', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(83, 5, $descripcion_troceada[(8 * $i) + 6], 1, 0, 'C', 0);
                                        $pdf->Cell(83, 5, $descripcion_troceada[(8 * $i) + 7], 1, 1, 'C', 0);

                                        $pdf->Ln();
                                    }
                                }
                                break;

                            //8.1 Hauptsatz
                            case 56:
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                $pdf->setLineWidth(0.3);
                                //cabeceras
                                $pdf->SetFont('freeserif', 'B', 10);

                                $pdf->Ln();
                                $pdf->Cell(40, 5, get_string('vorfeld', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(30, 5, get_string('konjugier_resumen', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(90, 5, get_string('mittelfeld', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(37, 5, get_string('verb2', 'vocabulario'), 1, 1, 'C', 1);

                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito
                                $pdf->SetFont('freeserif', '', 10);

                                //se calcula el nº de filas totales
                                $totalfilas = ((count($descripcion_troceada) - 2) / 4);

                                $todovacio = true;

                                for ($f = 0; $f < $totalfilas; $f++) {
                                    $pintar = false;

                                    if ($f == $totalfilas - 1 && $todovacio) {
                                        $pintar = true;
                                    }

                                    for ($j = 0; $j < 4 && $pintar == false; $j++) {
                                        if ($descripcion_troceada[(4 * $f) + $j]) {
                                            $todovacio = false;
                                            $pintar = true;
                                        }
                                    }

                                    if ($pintar) {

                                        $pdf->Cell(40, 5, $descripcion_troceada[($f * 4)], 1, 0, 'C', 0);
                                        $pdf->Cell(30, 5, $descripcion_troceada[($f * 4) + 1], 1, 0, 'C', 1);
                                        $pdf->Cell(90, 5, $descripcion_troceada[($f * 4) + 2], 1, 0, 'C', 0);
                                        $pdf->Cell(37, 5, $descripcion_troceada[($f * 4) + 3], 1, 1, 'C', 1);
                                    }
                                }
                                $pdf->Ln();
                                break;
                            //8.2 Nebensatz
                            case 57:
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                $pdf->setLineWidth(0.3);
                                //cabeceras
                                $pdf->SetFont('freeserif', 'B', 10);

                                $pdf->Ln();
                                $pdf->Cell(20, 5, get_string('subjunktor', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(20, 5, get_string('subjekt', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(90, 5, get_string('mittelfeld', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(30, 5, get_string('verb2', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(25, 5, get_string('konjugier_resumen', 'vocabulario'), 1, 1, 'C', 1);
                               
                                
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito
                                $pdf->SetFont('freeserif', '', 10);

                                //se calcula el nº de filas totales
                                $totalfilas = ((count($descripcion_troceada) - 2) / 5);

                                $todovacio = true;

                                for ($f = 0; $f < $totalfilas; $f++) {
                                    $pintar = false;

                                    if ($f == $totalfilas - 1 && $todovacio) {
                                        $pintar = true;
                                    }

                                    for ($j = 0; $j < 5 && $pintar == false; $j++) {
                                        if ($descripcion_troceada[(5 * $f) + $j]) {
                                            $todovacio = false;
                                            $pintar = true;
                                        }
                                    }

                                    if ($pintar) {

                                        $pdf->Cell(20, 5, $descripcion_troceada[($f * 5)], 1, 0, 'C', 0);
                                        $pdf->Cell(20, 5, $descripcion_troceada[($f * 5) + 4], 1, 0, 'C', 0);
                                        $pdf->Cell(90, 5, $descripcion_troceada[($f * 5) + 2], 1, 0, 'C', 0);
                                        $pdf->Cell(30, 5, $descripcion_troceada[($f * 5) + 3], 1, 0, 'C', 1);
                                        $pdf->Cell(25, 5, $descripcion_troceada[($f * 5) + 1], 1, 1, 'C', 1);
                                        
                                    }
                                }
                                

                  

                                break;
                            //2.4.2.1 Pronomina, die nur Personen bezeichnen
                            case 13:
                                $numtablas = (count($descripcion_troceada) - 2) / 5;
                                $todovacio = true;

                                for ($i = 0; $i < $numtablas; $i++) {
                                    $pintar = false;

                                    if ($i == $numtablas - 1 && $todovacio) {
                                        $pintar = true;
                                    }

                                    for ($j = 0; $j < 5 && $pintar == false; $j++) {
                                        if ($descripcion_troceada[(5 * $i) + $j]) {
                                            $todovacio = false;
                                            $pintar = true;
                                        }
                                    }

                                    if ($pintar) {
                                        $pdf->setLeftMargin(MARGIN_L5);
                                        $pdf->SetTextColor(TEXT_AUTO);
                                        $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                        $pdf->setLineWidth(0.3);
                                        //cabeceras
                                        $pdf->SetFont('freeserif', '', 10);

                                        $pdf->Ln();
                                        $pdf->Cell(110, 4, '', 1, 1, 'C', 1);
                                        $pdf->Cell(110, 5, $descripcion_troceada[(5 * $i)], 1, 1, 'C', 0);

                                        //celdas
                                        $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                        $pdf->Cell(24, 5, get_string('nominativo', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(86, 5, $descripcion_troceada[(5 * $i) + 1], 1, 1, 'C', 0);
                                        $pdf->Cell(24, 5, get_string('acusativo', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(86, 5, $descripcion_troceada[(5 * $i) + 2], 1, 1, 'C', 0);
                                        $pdf->Cell(24, 5, get_string('dativo', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(86, 5, $descripcion_troceada[(5 * $i) + 3], 1, 1, 'C', 0);
                                        $pdf->Cell(24, 5, get_string('genitivo', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(86, 5, $descripcion_troceada[(5 * $i) + 4], 1, 1, 'C', 0);

                                        $pdf->setLeftMargin(MARGIN);
                                        $pdf->Ln();
                                    }
                                }
                                break;
                            //2.1 Personalpronomen 
                            case 7:
                                $pdf->SetTextColor(TEXT_WHITE);

                                $pdf->SetFillColor(59, 89, 152); //#3B5998
                                $pdf->setLeftMargin(MARGIN);

                                //cabeceras chicas tabla 1.1

                                $pdf->SetFont('freeserif', 'B', 10);

                                $pdf->Ln();
                                $pdf->Cell(20, 5, '', 'LTB', 0, 'C', 1);
                                $pdf->Cell(170, 5, get_string('singAl', 'vocabulario'), 'TRB', 1, 'C', 1);
                                $pdf->Cell(20, 5, '', 'LT', 0, 'C', 1);
                                $pdf->Cell(34, 5, '1', 'TR', 0, 'C', 1);
                                $pdf->Cell(34, 5, '2', 'LTR', 0, 'C', 1);
                                $pdf->Cell(102, 5, '3', 'LTR', 1, 'C', 1);

                                $pdf->Cell(20, 5, '', 'LB', 0, 'C', 1);
                                $pdf->Cell(34, 5, '', 'BR', 0, 'C', 1);
                                $pdf->Cell(34, 5, '', 'LBR', 0, 'C', 1);
                                $pdf->Cell(34, 5, 'm', 'LB', 0, 'C', 1);
                                $pdf->Cell(34, 5, 'n', 'B', 0, 'C', 1);
                                $pdf->Cell(34, 5, 'f', 'BR', 1, 'C', 1);

                                //celdas tabla 1.1

                                $pdf->setTextColor(TEXT_AUTO);
                                $pdf->SetFont('freeserif', '', 10);
                                $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                $pdf->Cell(20, 5, get_string('nominativo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(34, 5, $descripcion_troceada[0], 1, 0, 'C', 0);
                                $pdf->Cell(34, 5, $descripcion_troceada[1], 1, 0, 'C', 0);
                                $pdf->Cell(34, 5, $descripcion_troceada[2], 1, 0, 'C', 0);
                                $pdf->Cell(34, 5, $descripcion_troceada[3], 1, 0, 'C', 0);
                                $pdf->Cell(34, 5, $descripcion_troceada[4], 1, 1, 'C', 0);

                                $pdf->Cell(20, 5, get_string('acusativo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(34, 5, $descripcion_troceada[9], 1, 0, 'C', 0);
                                $pdf->Cell(34, 5, $descripcion_troceada[10], 1, 0, 'C', 0);
                                $pdf->Cell(34, 5, $descripcion_troceada[11], 1, 0, 'C', 0);
                                $pdf->Cell(34, 5, $descripcion_troceada[12], 1, 0, 'C', 0);
                                $pdf->Cell(34, 5, $descripcion_troceada[13], 1, 1, 'C', 0);

                                $pdf->Cell(20, 5, get_string('dativo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(34, 5, $descripcion_troceada[18], 1, 0, 'C', 0);
                                $pdf->Cell(34, 5, $descripcion_troceada[19], 1, 0, 'C', 0);
                                $pdf->Cell(34, 5, $descripcion_troceada[20], 1, 0, 'C', 0);
                                $pdf->Cell(34, 5, $descripcion_troceada[21], 1, 0, 'C', 0);
                                $pdf->Cell(34, 5, $descripcion_troceada[22], 1, 1, 'C', 0);

                                $pdf->Cell(20, 5, get_string('genitivo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(34, 5, $descripcion_troceada[27], 1, 0, 'C', 0);
                                $pdf->Cell(34, 5, $descripcion_troceada[28], 1, 0, 'C', 0);
                                $pdf->Cell(34, 5, $descripcion_troceada[29], 1, 0, 'C', 0);
                                $pdf->Cell(34, 5, $descripcion_troceada[30], 1, 0, 'C', 0);
                                $pdf->Cell(34, 5, $descripcion_troceada[31], 1, 1, 'C', 0);

                                $pdf->Ln();

                                //cabeceras chicas tabla 1.2
                                $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFont('freeserif', 'B', 10);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998

                                $pdf->Cell(20, 5, '', 'LTB', 0, 'C', 1);
                                $pdf->Cell(126, 5, get_string('pluralAl', 'vocabulario'), 'TRB', 0, 'C', 1);
                                $pdf->Cell(44, 5, '', 'LTR', 1, 'C', 1);

                                $pdf->Cell(20, 5, '', 'LT', 0, 'C', 1);
                                $pdf->Cell(42, 5, '1', 'TR', 0, 'C', 1);
                                $pdf->Cell(42, 5, '2', 'LTR', 0, 'C', 1);
                                $pdf->Cell(42, 5, '3', 'LTR', 0, 'C', 1);
                                $pdf->Cell(44, 5, get_string('sie', 'vocabulario'), 'LR', 1, 'C', 1);

                                //celdas tabla 1.2

                                $pdf->setTextColor(TEXT_AUTO);
                                $pdf->SetFont('freeserif', '', 10);
                                $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                $pdf->Cell(20, 5, get_string('nominativo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(42, 5, $descripcion_troceada[5], 1, 0, 'C', 0);
                                $pdf->Cell(42, 5, $descripcion_troceada[6], 1, 0, 'C', 0);
                                $pdf->Cell(42, 5, $descripcion_troceada[7], 1, 0, 'C', 0);
                                $pdf->Cell(44, 5, $descripcion_troceada[8], 1, 1, 'C', 0);

                                $pdf->Cell(20, 5, get_string('acusativo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(42, 5, $descripcion_troceada[14], 1, 0, 'C', 0);
                                $pdf->Cell(42, 5, $descripcion_troceada[15], 1, 0, 'C', 0);
                                $pdf->Cell(42, 5, $descripcion_troceada[16], 1, 0, 'C', 0);
                                $pdf->Cell(44, 5, $descripcion_troceada[17], 1, 1, 'C', 0);

                                $pdf->Cell(20, 5, get_string('dativo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(42, 5, $descripcion_troceada[23], 1, 0, 'C', 0);
                                $pdf->Cell(42, 5, $descripcion_troceada[24], 1, 0, 'C', 0);
                                $pdf->Cell(42, 5, $descripcion_troceada[25], 1, 0, 'C', 0);
                                $pdf->Cell(44, 5, $descripcion_troceada[26], 1, 1, 'C', 0);

                                $pdf->Cell(20, 5, get_string('genitivo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(42, 5, $descripcion_troceada[32], 1, 0, 'C', 0);
                                $pdf->Cell(42, 5, $descripcion_troceada[33], 1, 0, 'C', 0);
                                $pdf->Cell(42, 5, $descripcion_troceada[34], 1, 0, 'C', 0);
                                $pdf->Cell(44, 5, $descripcion_troceada[35], 1, 1, 'C', 0);

                                $pdf->Ln();
                                break;
                            //3.8 Imperativ
                            case 35:

                                $numtablas = (count($descripcion_troceada) - 2) / 4;
                                $todovacio = true;

                                for ($i = 0; $i < $numtablas; $i++) {
                                    $pintar = false;

                                    if ($i == $numtablas - 1 && $todovacio) {
                                        $pintar = true;
                                    }

                                    for ($j = 0; $j < 4 && $pintar == false; $j++) {
                                        if ($descripcion_troceada[(4 * $i) + $j]) {
                                            $todovacio = false;
                                            $pintar = true;
                                        }
                                    }

                                    if ($pintar) {
                                        $pdf->setLeftMargin(MARGIN_L5);
                                        $pdf->SetTextColor(TEXT_WHITE);
                                        $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                        $pdf->setLineWidth(0.3);

                                        //cabeceras
                                        $pdf->SetFont('freeserif', 'B', 10);

                                        $pdf->Ln();
                                        $pdf->Cell(24, 5, get_string('infinitivo', 'vocabulario'), 1, 0, 'C', 1);

                                        $pdf->SetTextColor(TEXT_AUTO);

                                        $pdf->Cell(86, 5, $descripcion_troceada[(4 * $i)], 1, 1, 'C', 0);

                                        //celdas
                                        $pdf->SetFont('freeserif', '', 10);
                                        $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                        $pdf->Cell(24, 5, get_string('S2', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(86, 5, $descripcion_troceada[(4 * $i) + 1], 1, 1, 'C', 0);
                                        $pdf->Cell(24, 5, get_string('P2', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(86, 5, $descripcion_troceada[(4 * $i) + 2], 1, 1, 'C', 0);
                                        $pdf->Cell(24, 5, get_string('sie', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(86, 5, $descripcion_troceada[(4 * $i) + 3], 1, 1, 'C', 0);

                                        $pdf->setLeftMargin(MARGIN);
                                        $pdf->Ln();
                                    }
                                }

                                break;
                            //3.5 Reflexive und reziproke Verben
                            case 30:
                                $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->SetFont('freeserif', 'B', 12);

                                //cabecera grande
                                $pdf->Ln();
                                $pdf->Cell(190, 6, get_string('reflexivo', 'vocabulario'), 1, 1, 'C', 1);
                                //separador
                                $pdf->Cell(190, 3, '', 0, 1, 'C', 0);

                                //cabeceras chicas tabla 1.1
                                $pdf->SetFont('freeserif', 'B', 10);

                                $pdf->Cell(22, 5, '', 'LTB', 0, 'C', 1);
                                $pdf->Cell(168, 5, get_string('singAl', 'vocabulario'), 'TRB', 1, 'C', 1);
                                $pdf->Cell(22, 5, '', 'LT', 0, 'C', 1);
                                $pdf->Cell(56, 5, '1', 'TR', 0, 'C', 1);
                                $pdf->Cell(56, 5, '2', 'LTR', 0, 'C', 1);
                                $pdf->Cell(56, 5, '3', 'LTR', 1, 'C', 1);

                                //celdas tabla 1.1

                                $pdf->setTextColor(TEXT_AUTO);
                                $pdf->SetFont('freeserif', '', 10);
                                $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                $pdf->Cell(22, 5, get_string('acusativo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(56, 5, $descripcion_troceada[0], 1, 0, 'C', 0);
                                $pdf->Cell(56, 5, $descripcion_troceada[1], 1, 0, 'C', 0);
                                $pdf->Cell(56, 5, $descripcion_troceada[2], 1, 1, 'C', 0);

                                $pdf->Cell(22, 5, get_string('dativo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(56, 5, $descripcion_troceada[7], 1, 0, 'C', 0);
                                $pdf->Cell(56, 5, $descripcion_troceada[8], 1, 0, 'C', 0);
                                $pdf->Cell(56, 5, $descripcion_troceada[9], 1, 1, 'C', 0);

                                $pdf->Ln();

                                //cabeceras chicas tabla 1.2
                                $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFont('freeserif', 'B', 10);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro

                                $pdf->Cell(22, 5, '', 'LTB', 0, 'C', 1);
                                $pdf->Cell(126, 5, get_string('pluralAl', 'vocabulario'), 'TRB', 0, 'C', 1);
                                $pdf->Cell(42, 5, '', 'LTR', 1, 'C', 1);

                                $pdf->Cell(22, 5, '', 'LT', 0, 'C', 1);
                                $pdf->Cell(42, 5, '1', 'TR', 0, 'C', 1);
                                $pdf->Cell(42, 5, '2', 'LTR', 0, 'C', 1);
                                $pdf->Cell(42, 5, '3', 'LTR', 0, 'C', 1);
                                $pdf->Cell(42, 5, get_string('sie', 'vocabulario'), 'LR', 1, 'C', 1);

                                //celdas tabla 1.2

                                $pdf->setTextColor(TEXT_AUTO);
                                $pdf->SetFont('freeserif', '', 10);
                                $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                $pdf->Cell(22, 5, get_string('acusativo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(42, 5, $descripcion_troceada[3], 1, 0, 'C', 0);
                                $pdf->Cell(42, 5, $descripcion_troceada[4], 1, 0, 'C', 0);
                                $pdf->Cell(42, 5, $descripcion_troceada[5], 1, 0, 'C', 0);
                                $pdf->Cell(42, 5, $descripcion_troceada[6], 1, 1, 'C', 0);

                                $pdf->Cell(22, 5, get_string('dativo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(42, 5, $descripcion_troceada[10], 1, 0, 'C', 0);
                                $pdf->Cell(42, 5, $descripcion_troceada[11], 1, 0, 'C', 0);
                                $pdf->Cell(42, 5, $descripcion_troceada[12], 1, 0, 'C', 0);
                                $pdf->Cell(42, 5, $descripcion_troceada[13], 1, 1, 'C', 0);

                                $pdf->Ln();
                                break;
                            //4.7 Gebrauch der Artikelwörter
                            case 43:
                                $titulo = '';
                                $tope = 20;

                                for ($tabla = 0; $tabla < 3; ++$tabla) {

                                    //Según la tabla pongo un indice u otro
                                    switch ($tabla) {
                                        case 0:
                                            $titulo = get_string('beispiele_def', 'vocabulario');
                                            break;
                                        case 1:
                                            $titulo = get_string('beispiele_indef', 'vocabulario');
                                            break;
                                        case 2:
                                            $titulo = get_string('beispiele_null', 'vocabulario');
                                            break;
                                    }


                                    //titulillos de la tabla

                                    $pdf->Ln();
                                    $pdf->SetTextColor(TEXT_WHITE);
                                    $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                    $pdf->setLeftMargin(MARGIN_L3);
                                    $pdf->SetFont('freeserif', 'B', 10);

                                    $pdf->Cell(75, 5, $titulo, 1, 0, 'C', 1);
                                    $pdf->Cell(75, 5, get_string('gebrauch', 'vocabulario'), 1, 1, 'C', 1);

                                    //A partir de aqui pinto filas según se van necesitando
                                    $pdf->SetTextColor(TEXT_AUTO);
                                    $pdf->SetFont('freeserif', '', 10);


                                    $todovacio = true;
                                    for ($fila = 0; $fila < $tope; $fila++) {

                                        $pintar = false;

                                        if ($fila == $tope - 1 && $todovacio) {
                                            $pintar = true;
                                        }

                                        for ($j = 0; $j < 2 && $pintar == false; $j++) {
                                            if ($descripcion_troceada[($tabla * $tope * 2) + ((2 * $fila) + $j)]) {
                                                $todovacio = false;
                                                $pintar = true;
                                            }
                                        }

                                        if ($pintar) {

                                            $pdf->Cell(75, 5, $descripcion_troceada[($tabla * $tope * 2) + ((2 * $fila) + 0)], 1, 0, 'C', 0);
                                            $pdf->Cell(75, 5, $descripcion_troceada[($tabla * $tope * 2) + ((2 * $fila) + 1)], 1, 1, 'C', 0);
                                        }
                                    }
                                    $pdf->setLeftMargin(MARGIN);
                                    $pdf->Ln();
                                }

                                break;

                            //5.2.2
                            case 48:

                                $pdf->setLeftMargin(MARGIN);
                                $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                $pdf->setLineWidth(0.3);
                                //cabeceras
                                $pdf->SetFont('freeserif', 'B', 10);

                                $pdf->Ln();
                                $pdf->Cell(63, 5, get_string('positivo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(64, 5, get_string('comparativo', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(63, 5, get_string('superlativo', 'vocabulario'), 1, 1, 'C', 1);

                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->SetFont('freeserif', '', 10);

                                //se calcula el nº de filas totales
                                $totalfilas = ((count($descripcion_troceada) - 2) / 3);

                                $todovacio = true;

                                for ($f = 0; $f < $totalfilas; $f++) {
                                    $pintar = false;

                                    if ($f == $totalfilas - 1 && $todovacio) {
                                        $pintar = true;
                                    }

                                    for ($j = 0; $j < 3 && $pintar == false; $j++) {
                                        if ($descripcion_troceada[(3 * $f) + $j]) {
                                            $todovacio = false;
                                            $pintar = true;
                                        }
                                    }

                                    if ($pintar) {

                                        $pdf->Cell(63, 5, $descripcion_troceada[($f * 3)], 1, 0, 'C', 0);
                                        $pdf->Cell(64, 5, $descripcion_troceada[($f * 3) + 1], 1, 0, 'C', 0);
                                        $pdf->Cell(63, 5, $descripcion_troceada[($f * 3) + 2], 1, 1, 'C', 0);
                                    }
                                }
                                $pdf->Ln();
                                break;
                            //6.1
                            //6.2 Preposiciones
                            case 51:

                                //array para traducir el campo de caso, que al ser un entero se tiene que corresponder con un string
                                $kasus = array(get_string('acusativo', 'vocabulario'), get_string('dativo', 'vocabulario'), get_string('acudat', 'vocabulario'), get_string('genitivo', 'vocabulario'));

                                $arrayAux1 = array();
                                for ($ind = 0; $ind < count($descripcion_troceada) - 2; $ind+=4) {
                                    $arrayAux1[] = $descripcion_troceada[$ind] . __SEPARADORCAMPOS__ . $descripcion_troceada[$ind + 1] . __SEPARADORCAMPOS__ . $descripcion_troceada[$ind + 2] . __SEPARADORCAMPOS__ . $descripcion_troceada[$ind + 3];
                                }

                                //se ordena el array
                                sort($arrayAux1);

                                $arrayAux = array();
                                foreach ($arrayAux1 as $cosa) {
                                    if ($cosa[0] != __SEPARADORCAMPOS__) {
                                        $arrayAux[] = $cosa;
                                    }
                                }



//                                    $titulillos .='<th>'.get_string('beisp','vocabulario').'</th>';
                                //si hay filas que mostrar las pinamos, en caso contrario solo se verá la cabecera de la tabla.
                                $salidor = false;
                                $anterior = '';
                                for ($j = 0; $j < count($arrayAux) && $salidor == false; $j++) {
                                    $desc_aux = explode(__SEPARADORCAMPOS__, $arrayAux[$j]);
                                    if (!$desc_aux[0]) {
                                        $salidor = true;
                                    } else {

                                        $pdf->setLeftMargin(MARGIN);
                                        $pdf->SetTextColor(TEXT_WHITE);
                                        $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                        $pdf->setLineWidth(0.3);
                                        //cabeceras
                                        $pdf->SetFont('freeserif', 'B', 10);

                                        $pdf->Ln();
                                        //titulillos de la tabla

                                        if ($desc_aux[0] != $anterior) {
                                            if ($anterior != '') {
                                                $pdf->Ln();
                                                $pdf->Ln();
                                            }

                                            $pdf->Cell(25, 5, get_string('praposit', 'vocabulario'), 0, 0, 'C', 1);
                                            $pdf->SetTextColor(TEXT_AUTO);
                                            $pdf->Cell(25, 5, $desc_aux[0], 0, 1, 'C', 0);
                                            $anterior = $desc_aux[0];
                                        }

                                        $pdf->Cell(25, 3, '', 0, 1, 'C', 0);

                                        $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito
                                        $pdf->SetTextColor(TEXT_AUTO);


//                                            $pdf->SetTextColor(TEXT_WHITE);
                                        $pdf->SetFont('freeserif', 'B', 10);
                                        $pdf->Cell(18, 5, get_string('func', 'vocabulario'), 'LT', 0, 'L', 1);
                                        $pdf->SetTextColor(TEXT_AUTO);
                                        $pdf->SetFont('freeserif', '', 10);
                                        $pdf->Cell(172, 5, $desc_aux[1], 'TR', 1, 'L', 0);

//                                            $pdf->SetTextColor(TEXT_WHITE);
                                        $pdf->SetFont('freeserif', 'B', 10);
                                        $pdf->Cell(18, 5, get_string('kas', 'vocabulario'), 'L', 0, 'L', 1);
                                        $pdf->SetTextColor(TEXT_AUTO);
                                        $pdf->SetFont('freeserif', '', 10);
                                        $pdf->Cell(172, 5, $kasus[$desc_aux[2]], 'R', 1, 'L', 0);

//                                            $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito
//                                            $pdf->SetTextColor(TEXT_WHITE);
                                        $pdf->SetFont('freeserif', 'B', 10);
                                        $pdf->Cell(18, 5, get_string('beisp', 'vocabulario'), 'LB', 0, 'L', 1);
                                        $pdf->SetTextColor(TEXT_AUTO);
                                        $pdf->SetFont('freeserif', '', 10);
                                        $pdf->MultiCell(172, 5, $desc_aux[3], 'BR', 'L', 0);
                                    }
                                }
                                $pdf->Ln();
                                break;

                            case 69:
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                $pdf->setLineWidth(0.3);
                                //cabeceras
                                $pdf->SetFont('freeserif', 'B', 10);

                                $pdf->Ln();
                                $pdf->Cell(33, 5, get_string('prafix', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(33, 5, get_string('suffix', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(62, 5, get_string('beisp', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(62, 5, get_string('bedeutung', 'vocabulario'), 1, 1, 'C', 1);

                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->SetFont('freeserif', '', 9);

                                //se calcula el nº de filas totales
                                $totalfilas = ((count($descripcion_troceada) - 2) / 4);

                                $todovacio = true;

                                for ($f = 0; $f < $totalfilas; $f++) {
                                    $pintar = false;

                                    if ($f == $totalfilas - 1 && $todovacio) {
                                        $pintar = true;
                                    }

                                    for ($j = 0; $j < 5 && $pintar == false; $j++) {
                                        if ($descripcion_troceada[(5 * $f) + $j]) {
                                            $todovacio = false;
                                            $pintar = true;
                                        }
                                    }

                                    if ($pintar) {

                                        $pdf->Cell(33, 5, $descripcion_troceada[($f * 4) + 0], 1, 0, 'C', 0);
                                        $pdf->Cell(33, 5, $descripcion_troceada[($f * 4) + 1], 1, 0, 'C', 0);
                                        $pdf->Cell(62, 5, $descripcion_troceada[($f * 4) + 2], 1, 0, 'C', 0);
                                        $pdf->Cell(62, 5, $descripcion_troceada[($f * 4) + 3], 1, 1, 'C', 0);
                                    }
                                }
                                $pdf->Ln();
                                break;
                        }


                        $pdf->Ln();
                        $pdf->setLeftMargin(MARGIN_L2);

                        $pdf->SetFillColor(59, 89, 152); //#3B5998
                        $pdf->SetTextColor(TEXT_WHITE);
                        $pdf->SetLineWidth(0.3);
                        $pdf->SetFont('freeserif', 'B', '12');
                        $pdf->Cell(47, 5, get_string('atencion_may', 'vocabulario'), 1, 1, 'C', 1);
                        $pdf->SetTextColor(TEXT_AUTO);
                        $pdf->SetFont('freeserif', '', '10');
                        $pdf->MultiCell(170, 5, $descripcion_troceada[count($descripcion_troceada) - 2], 1, 'L', 0);
                        $pdf->Ln();
                        $pdf->SetTextColor(TEXT_WHITE);
                        $pdf->SetFont('freeserif', 'B', '12');
                        $pdf->Cell(47, 5, get_string('miraren', 'vocabulario'), 1, 1, 'C', 1);
                        $pdf->SetTextColor(TEXT_AUTO);
                        $pdf->SetFont('freeserif', '', '10');
                        $pdf->MultiCell(170, 5, $descripcion_troceada[count($descripcion_troceada) - 1], 1, 'L', 0);

                        $pdf->setLeftMargin(MARGIN);

                        $pdf->Ln();
                    }
                }
            }
        }
    }
}


if ($impr_tipol == 1) {
    //tipologías textuales
    $tipologias = new Vocabulario_mis_tipologias();
    $todas = $tipologias->obtener_todas($usuario);
    //nueva pagina para las tipologias
    $pdf->AddPage();
    $pdf->SetFont('freeserif', 'B', '12');
    $pdf->writeHTMLCell(0, 0, 50, 100, '<h1>' . get_string('tipologias_may', 'vocabulario') . '</h1>', 0, 1, 0);

    foreach ($todas as $cosa) {
        $descripcion_troceada = explode(__SEPARADORCAMPOS__, $cosa->descripcion);

        if ($descripcion_troceada) {
            $pintartochaco = false;

            for ($p = 0; $p < count($descripcion_troceada) && $pintartochaco == false; $p++) {
                if ($descripcion_troceada[$p]) {
                    $pintartochaco = true;
                }
            }

            if ($pintartochaco) {

                //imprimo el nombre de tipología
                $pdf->AddPage();
                $tt = new Vocabulario_tipologias();
                $tt->leer($cosa->tipoid, $usuario);
                $mtt = $tt->get('palabra');

                $pdf->SetTextColor(TEXT_AUTO);
                $pdf->SetFont('freeserif', 'B', '12');
//                $pdf->Cell(0, 5, $mtt, 0, 1, 'L', 0);
                $pdf->setLeftMargin(MARGIN);
                $pdf->writeHTMLCell(0, 0, 0, 0, '<h2>' . $mtt . '</h2>', 0, 1, 0);


                $numplantillas = (count($descripcion_troceada) - 1) / 15;

                $todovacio = true;
                $ind_ejemplo = 1;
                for ($i = 0; $i < $numplantillas; $i++) {
                    $pintar = false;

                    if ($i == $numplantillas - 1 && $todovacio) {
                        $pintar = true;
                    }

                    for ($j = 0; $j < 15 && $pintar == false; $j++) {
                        if ($descripcion_troceada[(15 * $i) + $j]) {
                            $todovacio = false;
                            $pintar = true;
                        }
                    }




                    if ($pintar) {


                        $pdf->setLeftMargin(MARGIN);
                        $pdf->SetTextColor(TEXT_WHITE);
                        $pdf->SetFont('freeserif', 'B', '12');
                        $pdf->SetLineWidth(0.3);
                        $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro



                        $pdf->Cell(190, 5, get_string('ejem', 'vocabulario') . ' ' . $ind_ejemplo, 0, 1, 'L', 1);
                        $ind_ejemplo++;     //para que el nombre de ejemplo sea siempre consecutivo
                        $pdf->Ln();

                        $pdf->SetTextColor(TEXT_AUTO);

                        $pdf->SetFont('freeserif', '', '10');
                        $pdf->setLeftMargin(MARGIN_L2);

                        $pdf->writeHTMLCell(0, 0, 0, 0, '<h4>' . get_string('quien', 'vocabulario') . '</h4>', 0, 1, 0);
                        $pdf->MultiCell(0, 5, $descripcion_troceada[(15 * $i) + 0], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                        $pdf->Ln();

                        $pdf->writeHTMLCell(0, 0, 0, 0, '<h4>' . get_string('finalidad', 'vocabulario') . '</h4>', 0, 1, 0);
                        $pdf->MultiCell(0, 5, $descripcion_troceada[(15 * $i) + 1], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                        $pdf->Ln();

                        $pdf->writeHTMLCell(0, 0, 0, 0, '<h4>' . get_string('a_quien', 'vocabulario') . '</h4>', 0, 1, 0);
                        $pdf->MultiCell(0, 5, $descripcion_troceada[(15 * $i) + 2], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                        $pdf->Ln();

                        $pdf->writeHTMLCell(0, 0, 0, 0, '<h4>' . get_string('medio', 'vocabulario') . '</h4>', 0, 1, 0);
                        $pdf->MultiCell(0, 5, $descripcion_troceada[(15 * $i) + 3], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                        $pdf->Ln();

                        $pdf->writeHTMLCell(0, 0, 0, 0, '<h4>' . get_string('donde', 'vocabulario') . '</h4>', 0, 1, 0);
                        $pdf->MultiCell(0, 5, $descripcion_troceada[(15 * $i) + 4], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                        $pdf->Ln();

                        $pdf->writeHTMLCell(0, 0, 0, 0, '<h4>' . get_string('cuando', 'vocabulario') . '</h4>', 0, 1, 0);
                        $pdf->MultiCell(0, 5, $descripcion_troceada[(15 * $i) + 5], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                        $pdf->Ln();

                        $pdf->writeHTMLCell(0, 0, 0, 0, '<h4>' . get_string('motivo', 'vocabulario') . '</h4>', 0, 1, 0);
                        $pdf->MultiCell(0, 5, $descripcion_troceada[(15 * $i) + 6], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                        $pdf->Ln();

                        $pdf->writeHTMLCell(0, 0, 0, 0, '<h4>' . get_string('funcion', 'vocabulario') . '</h4>', 0, 1, 0);
                        $pdf->MultiCell(0, 5, $descripcion_troceada[(15 * $i) + 7], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                        $pdf->Ln();

                        $pdf->writeHTMLCell(0, 0, 0, 0, '<h4>' . get_string('sobre_que', 'vocabulario') . '</h4>', 0, 1, 0);
                        $pdf->MultiCell(0, 5, $descripcion_troceada[(15 * $i) + 8], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                        $pdf->Ln();

                        $pdf->writeHTMLCell(0, 0, 0, 0, '<h4>' . get_string('que', 'vocabulario') . '</h4>', 0, 1, 0);
                        $pdf->MultiCell(0, 5, $descripcion_troceada[(15 * $i) + 9], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                        $pdf->Ln();

                        $pdf->writeHTMLCell(0, 0, 0, 0, '<h4>' . get_string('orden', 'vocabulario') . '</h4>', 0, 1, 0);
                        $pdf->MultiCell(0, 5, $descripcion_troceada[(15 * $i) + 10], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                        $pdf->Ln();

                        $pdf->writeHTMLCell(0, 0, 0, 0, '<h4>' . get_string('medios_nonverbales', 'vocabulario') . '</h4>', 0, 1, 0);
                        $pdf->MultiCell(0, 5, $descripcion_troceada[(15 * $i) + 11], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                        $pdf->Ln();

                        $pdf->writeHTMLCell(0, 0, 0, 0, '<h4>' . get_string('que_palabras', 'vocabulario') . '</h4>', 0, 1, 0);
                        $pdf->MultiCell(0, 5, $descripcion_troceada[(15 * $i) + 12], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                        $pdf->Ln();

                        $pdf->writeHTMLCell(0, 0, 0, 0, '<h4>' . get_string('que_frases', 'vocabulario') . '</h4>', 0, 1, 0);
                        $pdf->MultiCell(0, 5, $descripcion_troceada[(15 * $i) + 13], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                        $pdf->Ln();

                        $pdf->writeHTMLCell(0, 0, 0, 0, '<h4>' . get_string('que_tono', 'vocabulario') . '</h4>', 0, 1, 0);
                        $pdf->MultiCell(0, 5, $descripcion_troceada[(15 * $i) + 14], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                        $pdf->Ln();

                        $pdf->setLeftMargin(MARGIN);
                        $pdf->Ln();
                        $pdf->Ln();
                    }
                }

                $pdf->Ln();
                $pdf->setLeftMargin(MARGIN_L2);

                $pdf->SetFillColor(59, 89, 152); //#3B5998
                $pdf->SetTextColor(TEXT_WHITE);
                $pdf->SetLineWidth(0.3);
                $pdf->SetFont('freeserif', 'B', '12');
                $pdf->Cell(47, 5, get_string('miraren', 'vocabulario'), 1, 1, 'C', 1);
                $pdf->SetTextColor(TEXT_AUTO);
                $pdf->SetFont('freeserif', '', '10');
                $pdf->MultiCell(170, 5, $descripcion_troceada[count($descripcion_troceada) - 1], 1, 'L', 0);

                $pdf->setLeftMargin(MARGIN);

                $pdf->Ln();
            }
        }
    }
}





if ($impr_inten == 1) {


    //Aquí se extraen todas las intenciones que puede tener el usuario(solo las inenciones (los ids))
    $Vintenciones = new Vocabulario_intenciones();
    $todas = $Vintenciones->obtener_todos_ids($usuario);

    $mintenciones = new Vocabulario_mis_intenciones();
    $todas_mis_intenciones = $mintenciones->obtener_todas($usuario);
    //nueva pagina para las estrategias
    $pdf->AddPage();
    $pdf->SetFont('freeserif', 'B', '12');
    $pdf->writeHTMLCell(0, 0, 50, 100, '<h1>' . get_string('intenciones_may', 'vocabulario') . '</h1>', 0, 1, 0);
    
    foreach ($todas as $intencion) {
        foreach ($todas_mis_intenciones as $cosa) {
            if ($cosa->intencionesid == $intencion) {
                $descripcion_troceada = explode(__SEPARADORCAMPOS__, $cosa->descripcion);
                $descripcion = $cosa->descripcion;

                if ($descripcion_troceada) {
                    $pintartochaco = false;

                    for ($p = 0; $p < count($descripcion_troceada) && $pintartochaco == false; $p++) {
                        if ($descripcion_troceada[$p]) {
                            $pintartochaco = true;
                        }
                    }

                    if ($pintartochaco) {
                        $pdf->AddPage();
                        //imprimo el nombre de intencion
                        $ic = new Vocabulario_intenciones();
                        $ic->leer($cosa->intencionesid, $usuario);
                        $mic = $ic->get('palabra');
                        $icid = $cosa->intencionesid;
                        $pdf->SetTextColor(TEXT_AUTO);
                        $pdf->setLeftMargin(MARGIN);
                        $pdf->SetFillColor(59, 89, 152); //#3B5998
                        $pdf->SetLineWidth(0.3);
                        $pdf->SetFont('freeserif', 'B', 12);
                        $pdf->writeHTMLCell(0, 0, 0, 0, '<h2>' . $mic . '</h2>', 0, 1, 0);


                        //Primer cuadro, el de la descripcion
                        $pdf->writeHTMLCell(0, 0, 0, 0, '<h3>' . get_string('desc', 'vocabulario') . '</h3>', 0, 1, 0);

                        $pdf->setLeftMargin(MARGIN_L2);
                        $pdf->SetFont('freeserif', 'B', 10);

                        //ponemos la descripcion por defecto en caso de que sea necesario
                        switch ($icid) {
                            case 28:
                                $pdf->MultiCell(0, 5, get_string('desc_inten3.2', 'vocabulario'), 0, 'J', 0);
                                $pdf->Ln();
                                break;
                            case 37:
                                $pdf->MultiCell(0, 5, get_string('desc_inten3.3', 'vocabulario'), 0, 'J', 0);
                                $pdf->Ln();
                                break;
                            case 47:
                                $pdf->MultiCell(0, 5, get_string('desc_inten4.1', 'vocabulario'), 0, 'J', 0);
                                $pdf->Ln();
                                break;
                            case 56:
                                $pdf->MultiCell(0, 5, get_string('desc_inten4.2', 'vocabulario'), 0, 'J', 0);
                                $pdf->Ln();
                                break;
                            case 66:
                                $pdf->MultiCell(0, 5, get_string('desc_inten5.1', 'vocabulario'), 0, 'J', 0);
                                $pdf->Ln();
                                break;
                            case 75:
                                $pdf->MultiCell(0, 5, get_string('desc_inten5.2', 'vocabulario'), 0, 'J', 0);
                                $pdf->Ln();
                                break;
                        }


                        $pdf->SetFont('freeserif', '', 10);
                        $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', 0);
                        $pdf->setLeftMargin(MARGIN);
                        $pdf->Ln();


                        $totalfilas = ((count($descripcion_troceada) - 1) / 4);

                        $todovacio = true;

                        for ($f = 0; $f < $totalfilas; $f++) {
                            $pintar = false;

                            if ($f == $totalfilas - 1 && $todovacio) {

                                $pintar = true;
                            }

                            for ($j = 0; $j < 4 && $pintar == false; $j++) {
                                if ($descripcion_troceada[1 + (4 * $f) + $j]) {
                                    $todovacio = false;
                                    $pintar = true;
                                }
                            }

                            if ($pintar) {


                                $pdf->Cell(25, 3, '', 0, 1, 'C', 0);

                                $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito
                                $pdf->SetTextColor(TEXT_AUTO);


//                                            $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFont('freeserif', 'B', 10);
                                $pdf->Cell(50, 5, get_string('mittel', 'vocabulario'), 'LT', 0, 'L', 1);
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->SetFont('freeserif', '', 9);
                                $pdf->Cell(140, 5, $descripcion_troceada[1 + ($f * 4) + 0], 'TR', 1, 'L', 0);

//                                            $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFont('freeserif', 'B', 10);
                                $pdf->Cell(50, 5, get_string('wortklase', 'vocabulario'), 'L', 0, 'L', 1);
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->SetFont('freeserif', '', 9);
                                $pdf->Cell(140, 5, $descripcion_troceada[1 + ($f * 4) + 1], 'R', 1, 'L', 0);

//                                            $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito
//                                            $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFont('freeserif', 'B', 10);
                                $pdf->Cell(50, 5, get_string('beisp', 'vocabulario'), 'L', 0, 'L', 1);
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->SetFont('freeserif', 'I', 7);
                                $pdf->MultiCell(140, 5, $descripcion_troceada[1 + ($f * 4) + 2], 'R', 'L', 0);


                                $pdf->SetFont('freeserif', 'B', 10);
                                $pdf->Cell(50, 5, get_string('siehe', 'vocabulario'), 'BL', 0, 'L', 1);
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->SetFont('freeserif', '', 9);
                                $pdf->Cell(140, 5, $descripcion_troceada[1 + ($f * 4) + 3], 'BR', 1, 'L', 0);
                            }
                        }
                        $pdf->Ln();
                    }
                }
            }
        }
    }
}






if ($impr_estra == 1) {
    //estrategias de aprendizaje
    $estrategias = new Vocabulario_mis_estrategias();
    $todas = $estrategias->obtener_todas($usuario);
    //nueva pagina para las estrategias
    $pdf->AddPage();
    $pdf->SetFont('freeserif', 'B', '12');
    $pdf->writeHTMLCell(0, 0, 50, 100, '<h1>' . get_string('estrategias_may', 'vocabulario') . '</h1>', 0, 1, 0);



    foreach ($todas as $cosa) {
        $descripcion = explode(__SEPARADORCAMPOS__, $cosa->descripcion);
//        $descripcion = $cosa->descripcion;

        if ($descripcion) {
            $pintartochaco = false;

            for ($p = 0; $p < count($descripcion) && $pintartochaco == false; $p++) {
                if ($descripcion[$p]) {
                    $pintartochaco = true;
                }
            }

            if ($pintartochaco) {
                $pdf->AddPage();
                //imprimo el nombre de estrategia
                $ea = new Vocabulario_estrategias();
                $ea->leer($cosa->estrategiaid, $usuario);
                $mea = $ea->get('palabra');

                $pdf->SetTextColor(TEXT_AUTO);
                $pdf->setLeftMargin(MARGIN);
                $pdf->SetFillColor(59, 89, 152); //#3B5998
                $pdf->SetLineWidth(0.3);
                $pdf->SetFont('freeserif', 'B', '12');
                $pdf->writeHTMLCell(0, 0, 0, 0, '<h2>' . $mea . '</h2>', 0, 1, 0);

                $pdf->setLeftMargin(MARGIN_L2);
                $pdf->SetFont('freeserif', '', '10');
                $pdf->MultiCell(170, 5, $descripcion[1], 0, 'L', 0);

                $pdf->setLeftMargin(MARGIN);

                $pdf->Ln();
            }
        }
    }
}


$pdf->lastPage();
$pdf->Output($USER->firstname . ' ' . $USER->lastname . '.pdf', 'D');
?>
