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
require_once("$CFG->libdir/tcpdf/tcpdf.php");
require_once("$CFG->libdir/tcpdf/config/lang/eng.php");
global $USER;

define('MARGIN',10);
define('MARGIN_L2',20);
define('MARGIN_L3',30);
define('MARGIN_L4',40);
define('MARGIN_L5',50);
define('TEXT_AUTO', 0);
define('TEXT_WHITE', 255);

$id_tocho = optional_param('id_tocho', 0, PARAM_INT);

$mform = new mod_vocabulario_pdf_form();

if ($mform->is_cancelled()) {
    redirect('./view.php?id=' . $id_tocho);
}

//$usuario = optional_param('us', $USER->id, PARAM_INT);
$usuario = $USER->id;

//Captamos los campos que queremos imprimir

$impr_vocab = optional_param('impr_vocab',0,PARAM_INT);
$impr_gram = optional_param('impr_gram',0,PARAM_INT);
$impr_tipol = optional_param('impr_tipol',0,PARAM_INT);
$impr_inten = optional_param('impr_inten',0,PARAM_INT);


//se crea el pdf
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$mis_palabras_aux = new Vocabulario_mis_palabras();
$mis_palabras = $mis_palabras_aux->obtener_todas($usuario);

$pdf->SetTitle(get_string('cuad_digital_min','vocabulario'));

//
//
//DESCOMENTAR ESTA LINEA EN UN MOMENTO DADO
//
//
//$pdf->SetSubject('-Todas mis palabras guardadas');



//para que no diga lo del undefined font grrrrr
$pdf->SetMargins(MARGIN, PDF_MARGIN_TOP, MARGIN);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


//Portada
$pdf->AddPage();

$pdf->writeHTMLCell(0, 0, 50, 100, '<h1>'.get_string('cuad_digital_may','vocabulario').'</h1>', 0, 1, 0);
$pdf->writeHTMLCell(0, 0, 20, 200, $USER->firstname . ' ' . $USER->lastname, 0, 1, 0);
$pdf->writeHTMLCell(0, 0, 20, 205, $USER->email, 0, 1, 0);

if($impr_vocab == 1){
    //Portada vocabulario
    $pdf->AddPage();
    $pdf->writeHTMLCell(0, 0, 50, 100, '<h1>'.get_string('vocabulario_may','vocabulario').'</h1>', 0, 1, 0);

    $pdf->AddPage();
    //resto de paginas
    //palabras por campos
    $mi_campo = 0;
    $color = 1;
    foreach ($mis_palabras as $cosa) {
        if ($cosa->get('campo')->get('campo') != $mi_campo) {
            if ($mi_campo != '0') {
                $pdf->Ln();
            }
            //imprimo el capolexico
            $pdf->AddPage();
            $mi_campo = $cosa->get('campo')->get('campo');
            $pdf->SetTextColor(TEXT_AUTO);
            $pdf->SetFont('', 'B', '14');
            $pdf->Cell(0, 7, $mi_campo, 0, 1, 'L', 0);
            $pdf->Ln();

            //titulillos
            $pdf->SetFillColor(59, 89, 152); //#3B5998
            $pdf->SetTextColor(TEXT_WHITE);
            $pdf->SetLineWidth(0.3);
            $pdf->SetFont('', 'B', '12');
            $pdf->Cell(47, 7, get_string('sust', 'vocabulario'), 1, 0, 'C', 1);
            $pdf->Cell(47, 7, get_string('vrb', 'vocabulario'), 1, 0, 'C', 1);
            $pdf->Cell(47, 7, get_string('adj', 'vocabulario'), 1, 0, 'C', 1);
            $pdf->Cell(47, 7, get_string('otr', 'vocabulario'), 1, 0, 'C', 1);
            $pdf->Ln();
            $color = 1;
        }

        //palabras
        if ($color % 2 == 0) {
            $pdf->SetFillColor(189, 199, 216);
        } else {
            $pdf->SetFillColor(255, 255, 255);
        }
        $pdf->SetTextColor(0);
        $pdf->SetFont('', 'B', '10');
        $pdf->Cell(47, 7, $cosa->get('sustantivo')->get('palabra'), 'LTR', 0, 'C', 1);
        $pdf->Cell(47, 7, $cosa->get('verbo')->get('infinitivo'), 'TR', 0, 'C', 1);
        $pdf->Cell(47, 7, $cosa->get('adjetivo')->get('sin_declinar'), 'RT', 0, 'C', 1);
        $pdf->Cell(47, 7, $cosa->get('otro')->get('palabra'), 'RT', 0, 'C', 1);
        $pdf->Ln();
        //significados
        $pdf->SetFont('', '', '7');
        $pdf->Cell(47, 7, $cosa->get('sustantivo')->get('significado'), 'LR', 0, 'R', 1);
        $pdf->Cell(47, 7, $cosa->get('verbo')->get('significado'), 'R', 0, 'R', 1);
        $pdf->Cell(47, 7, $cosa->get('adjetivo')->get('significado'), 'R', 0, 'R', 1);
        $pdf->Cell(47, 7, $cosa->get('otro')->get('significado'), 'R', 0, 'R', 1);
        $pdf->Ln();
        //gramaticas
        $gram = new Vocabulario_gramatica();
        $gram->leer($cosa->get('sustantivo')->get('gramaticaid'));
        $pdf->Cell(47, 7, get_string('referencia', 'vocabulario') . ': ' . $gram->get('gramatica'), 'LR', 0, 'L', 1);
        $gram->leer($cosa->get('verbo')->get('gramaticaid'));
        $pdf->Cell(47, 7, get_string('referencia', 'vocabulario') . ': ' . $gram->get('gramatica'), 'R', 0, 'L', 1);
        $gram->leer($cosa->get('adjetivo')->get('gramaticaid'));
        $pdf->Cell(47, 7, get_string('referencia', 'vocabulario') . ': ' . $gram->get('gramatica'), 'R', 0, 'L', 1);
        $gram->leer($cosa->get('otro')->get('gramaticaid'));
        $pdf->Cell(47, 7, get_string('referencia', 'vocabulario') . ': ' . $gram->get('gramatica'), 'R', 0, 'L', 1);
        $pdf->Ln();
        //observaciones
        $pdf->Cell(47, 7, get_string('vease_pdf', 'vocabulario') . ': ' . $cosa->get('sustantivo')->get('observaciones'), 'LBR', 0, 'L', 1);
        $pdf->Cell(47, 7, get_string('vease_pdf', 'vocabulario') . ': ' . $cosa->get('verbo')->get('observaciones'), 'BR', 0, 'L', 1);
        $pdf->Cell(47, 7, get_string('vease_pdf', 'vocabulario') . ': ' . $cosa->get('adjetivo')->get('observaciones'), 'BR', 0, 'L', 1);
        $pdf->Cell(47, 7, get_string('vease_pdf', 'vocabulario') . ': ' . $cosa->get('otro')->get('observaciones'), 'RB', 0, 'L', 1);
        $pdf->Ln();

        $color++;
    }
    if ($mi_campo != '0') {
        $pdf->Ln();
    }
}
if($impr_gram == 1){
    //gramaticas
    $gramaticas = new Vocabulario_gramatica();
    $gramaticas_usadas = array();
    //sacar un vector en el que cada posicion sean numero y nombre
    $gr_pal = $gramaticas->obtener_todos($usuario);
    $gr_num = $gramaticas->obtener_todos_ids($usuario);


    $pdf->SetTextColor(TEXT_AUTO);

    for ($i = 0; $i < count($gr_pal); $i++) {
        //Caso especial para las preposiciones:
        //Si es la gramatica 51(añadir preposicion)
        //le cambia el título por el de Consultar preposicion.
        if($gr_num[$i] == 51){
            $gr_pal[$i] = $gr_pal[$i+1];
        }

        $gramaticas_usadas[$i] = array($gr_pal[$i], $gr_num[$i]);

    }

    //nueva pagina para las gramaticas
    $pdf->AddPage();
    $pdf->writeHTMLCell(0, 0, 50, 100, '<h1>'.get_string('gramatica_may','vocabulario').'</h1>', 0, 1, 0);

    foreach ($gramaticas_usadas as $cosa) {
        $mgr = new Vocabulario_mis_gramaticas();
        $palabras = $mgr->relacionadas($USER->id, $cosa[1]);
        if ($palabras) {
            //imprimo el nombre de la gramatica
            $mi_gram = $cosa[0];
            //$pdf->SetFont('', 'B', '12');
            
           // $pdf->Cell(0, 5, $mi_gram, 0, 1, 'L', 0);

            
            foreach ($palabras as $palabra) {
                $descripcion_troceada = explode('&', $palabra->descripcion);
                
                if ($descripcion_troceada) {

                    $pintartochaco = false;
                    for($p=0; $p<count($descripcion_troceada) && $pintartochaco==false;$p++){
                        if($descripcion_troceada[$p]){
                            $pintartochaco=true;
                        }
                    }

                    if($pintartochaco){
                        $pdf->AddPage();
                        $pdf->writeHTMLCell(0, 0, 0, 0, '<h2>'.$mi_gram.'</h2>', 0, 1, 0);

                        $grid=$palabra->gramaticaid;
                        switch ($grid) {
                            //normal
                            default:
                                break;
                            //1.1
                            case 3:
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->SetFont('','',10);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998

                                //masculino
                                $pdf->writeHTMLCell(0, 0, 0, 0, '<h3>'.get_string('masculino','vocabulario').'</h3>', 0, 1, 0);
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->writeHTMLCell(0, 0, 0, 0, '<h4>'.get_string('clasificacionsemantica','vocabulario').'</h4>', 0, 1, 0);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J',0);
                                $pdf->Ln();
                                $pdf->writeHTMLCell(0, 0, 0, 0, '<h4>'.get_string('clasificacionformal','vocabulario').'</h4>', 0, 1, 0);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[1], 0, 'J', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();

                                //femenino

                                $pdf->writeHTMLCell(0, 0, 0, 0, '<h3>'.get_string('femenino','vocabulario').'</h3>', 0, 1, 0);
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->writeHTMLCell(0, 0, 0, 0, '<h4>'.get_string('clasificacionsemantica','vocabulario').'</h4>', 0, 1, 0);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[2], 0, 'J', 0);
                                $pdf->Ln();
                                $pdf->writeHTMLCell(0, 0, 0, 0, '<h4>'.get_string('clasificacionformal','vocabulario').'</h4>', 0, 1, 0);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[3], 0, 'J', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();

                                //neutro

                                $pdf->writeHTMLCell(0, 0, 0, 0, '<h3>'.get_string('neutro','vocabulario').'</h3>', 0, 1, 0);
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->writeHTMLCell(0, 0, 0, 0, '<h4>'.get_string('clasificacionsemantica','vocabulario').'</h4>', 0, 1, 0);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[4], 0, 'J', 0);
                                $pdf->Ln();
                                $pdf->writeHTMLCell(0, 0, 0, 0, '<h4>'.get_string('clasificacionformal','vocabulario').'</h4>', 0, 1, 0);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[5], 0, 'J', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();

                                break;
                            //1.2
                            case 4:
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->SetFont('','',10);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998

                                $pdf->writeHTMLCell(0, 0, 0, 0, '<h3>'.get_string('endungs','vocabulario').'</h3>', 0, 1, 0);
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();

                                $pdf->writeHTMLCell(0, 0, 0, 0, '<h3>'.get_string('genero','vocabulario').'</h3>', 0, 1, 0);
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[1], 0, 'J', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();

                                $pdf->writeHTMLCell(0, 0, 0, 0, '<h3>'.get_string('endungp','vocabulario').'</h3>', 0, 1, 0);
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[2], 0, 'J', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();

                                $pdf->Ln();

                                $pdf->writeHTMLCell(0, 0, 0, 0, '<h3>'.get_string('reinesf','vocabulario').'</h3>', 0, 1, 0);
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[3], 0, 'J', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();

                                $pdf->writeHTMLCell(0, 0, 0, 0, '<h3>'.get_string('reinepf','vocabulario').'</h3>', 0, 1, 0, true);
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[4], 0, 'J', 0);
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
                                $pdf->SetFont('','',10);

                                if($grid==25){
                                    $titulo=get_string("futuro1", "vocabulario");
                                }elseif($grid==26){
                                    $titulo=get_string("futuro2", "vocabulario");
                                }elseif($grid==28){
                                    $titulo=get_string('trennbaren','vocabulario');
                                }elseif($grid==24){
                                    $titulo=get_string('participio1','vocabulario');
                                }elseif($grid==63 && $grid==64 && $grid==65){
                                    $titulo=get_string('func','vocabulario');
                                }

                                $pdf->writeHTMLCell(0, 0, 0, 0, '<h3>'.$titulo.'</h3>', 0, 1, 0);
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();
                                break;
                            //7.1 Beispiele und Funktionen
                            case 54:
                            //3.1.3 Perfekt/Partizip II
                            case 23:

                                if($grid == 23){
                                    $titulo0 = get_string('irregulares','vocabulario');
                                    $titulo1 = get_string('participio2','vocabulario');
                                    $titulo2 = get_string('hilfsverbs','vocabulario');
                                }elseif($grid == 54){
                                    $titulo0 = get_string('beispielsatz','vocabulario');
                                    $titulo1 = get_string('satzart','vocabulario');
                                    $titulo2 = get_string('komfun','vocabulario');
                                }

                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->SetFont('','',10);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998
                                $pdf->setLeftMargin(MARGIN);

                                $pdf->writeHTMLCell(0, 0, 0, 0, '<h3>'.$titulo0.'</h3>', 0, 1, 0);
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();

                                $pdf->writeHTMLCell(0, 0, 0, 0, '<h3>'.$titulo1.'</h3>', 0, 1, 0);
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[1], 0, 'J', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();

                                $pdf->writeHTMLCell(0, 0, 0, 0, '<h3>'.$titulo2.'</h3>', 0, 1, 0);
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[2], 0, 'J', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();

                                break;
                            //8.3.1 Ergänzungen
                            case 59:
                            //3.6 Passiv
                            case 31:
                                
                                if($grid == 31){
                                    $titulo0 = get_string('zustandspassiv','vocabulario');
                                    $titulo1 = get_string('vorganspassiv','vocabulario');
                                }elseif($grid == 59){
                                    $titulo0 = get_string('definido','vocabulario');
                                    $titulo1 = get_string('indefinido','vocabulario');
                                }


                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->SetFont('','',10);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998
                                $pdf->setLeftMargin(MARGIN);

                                $pdf->writeHTMLCell(0, 0, 0, 0, '<h3>'.$titulo0.'</h3>', 0, 1, 0);
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();

                                $pdf->writeHTMLCell(0, 0, 0, 0, '<h3>'.$titulo1.'</h3>', 0, 1, 0);
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[1], 0, 'J', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();

                                break;
                            //8.3.2 Angaben
                            case 60:
                                $titulo0 = get_string('temporal','vocabulario');
                                $titulo1 = get_string('causal','vocabulario');
                                $titulo2 = get_string('modal','vocabulario');
                                $titulo3 = get_string('local','vocabulario');
                                
                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->SetFont('','',10);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998
                                $pdf->setLeftMargin(MARGIN);

                                $pdf->writeHTMLCell(0, 0, 0, 0, '<h3>'.$titulo0.'</h3>', 0, 1, 0);
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();

                                $pdf->writeHTMLCell(0, 0, 0, 0, '<h3>'.$titulo1.'</h3>', 0, 1, 0);
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[1], 0, 'J', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();

                                $pdf->writeHTMLCell(0, 0, 0, 0, '<h3>'.$titulo2.'</h3>', 0, 1, 0);
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[2], 0, 'J', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();

                                $pdf->writeHTMLCell(0, 0, 0, 0, '<h3>'.$titulo3.'</h3>', 0, 1, 0);
                                $pdf->setLeftMargin(MARGIN_L2);
                                $pdf->MultiCell(0, 5, $descripcion_troceada[3], 0, 'J', 0);
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->Ln();
                                break;
                            //5.2.1
                            case 47:
                                //Tabla 1
                                //primera Cabecera
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFont('','B',12);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998
                                $pdf->setLineWidth(0.3);

                                $pdf->Cell(190, 8,get_string('declinacion1', 'vocabulario'), 1, 1, 'C', 1);

                                //Cabeceras

                                $pdf->SetFont('','B',10);

                                $pdf->Cell(30, 5, '', 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, get_string('masculino', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, get_string('femenino', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, get_string('neutro', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, get_string('plural', 'vocabulario'), 1, 1, 'C', 1);

                                //filas
                                $pdf->setTextColor(TEXT_AUTO);
                                $pdf->SetFont('','',10);
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

                                $pdf->writeHTMLCell(0, 0, 0, 0,'<h4>'.get_string('particular', 'vocabulario').'</h4>', 0, 1, 0);
                                $pdf->MultiCell(170, 5, $descripcion_troceada[16], 0, 'L', 0);
                                $pdf->Ln();
                                $pdf->writeHTMLCell(0, 0, 0, 0,'<h4>'.get_string('despuesde', 'vocabulario').'</h4>', 0, 1, 0);
                                $pdf->MultiCell(170, 5, $descripcion_troceada[17], 0, 'L',0);

                                $pdf->setLeftMargin(MARGIN);

                                $pdf->Ln();

                                //Tabla 2
                                //primera Cabecera
                                $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFont('','B',12);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998
                                $pdf->setLineWidth(0.3);

                                $pdf->Cell(190, 8,get_string('declinacion2', 'vocabulario'), 1, 1, 'C', 1);

                                //Cabeceras

                                $pdf->SetFont('','B',10);

                                $pdf->Cell(30, 5, '', 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, get_string('masculino', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, get_string('femenino', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, get_string('neutro', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, get_string('plural', 'vocabulario'), 1, 1, 'C', 1);

                                //filas
                                $pdf->setTextColor(TEXT_AUTO);
                                $pdf->SetFont('','',10);
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

                                $pdf->writeHTMLCell(0, 0, 0, 0,'<h4>'.get_string('particular', 'vocabulario').'</h4>', 0, 1, 0);
                                $pdf->MultiCell(170, 5, $descripcion_troceada[34], 0, 'L', 0);
                                $pdf->Ln();
                                $pdf->writeHTMLCell(0, 0, 0, 0,'<h4>'.get_string('despuesde', 'vocabulario').'</h4>', 0, 1, 0);
                                $pdf->MultiCell(170, 5, $descripcion_troceada[35], 0, 'L',0);

                                $pdf->setLeftMargin(MARGIN);

                                $pdf->Ln();

                                //Tabla 3
                                //primera Cabecera
                                $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFont('','B',12);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998
                                $pdf->setLineWidth(0.3);

                                $pdf->Cell(190, 8,get_string('declinacion3', 'vocabulario'), 1, 1, 'C', 1);

                                //Cabeceras

                                $pdf->SetFont('','B',10);

                                $pdf->Cell(30, 5, '', 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, get_string('masculino', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, get_string('femenino', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, get_string('neutro', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(40, 5, get_string('plural', 'vocabulario'), 1, 1, 'C', 1);

                                //filas
                                $pdf->setTextColor(TEXT_AUTO);
                                $pdf->SetFont('','',10);
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

                                $pdf->writeHTMLCell(0, 0, 0, 0,'<h4>'.get_string('particular', 'vocabulario').'</h4>', 0, 1, 0);
                                $pdf->MultiCell(170, 5, $descripcion_troceada[52], 0, 'L', 0);
                                $pdf->Ln();
                                $pdf->writeHTMLCell(0, 0, 0, 0,'<h4>'.get_string('despuesde', 'vocabulario').'</h4>', 0, 1, 0);
                                $pdf->MultiCell(170, 5, $descripcion_troceada[53], 0, 'L',0);

                                $pdf->setLeftMargin(MARGIN);

                                $pdf->Ln();

                                break;
                             //3.1.1 Präsens
                            case 21:
                            //3.1.2 Präteritum
                            case 22:

                                //$pintadoAst = false;
                                $numtablas = (count($descripcion_troceada)-2)/21;
                                $pintarChuleta=false;
                                $todovacio = true;

                                for($i=0; $i<$numtablas; $i++){
                                    $pintar = false;

                                    if($i==$numtablas-1 && $todovacio){
                                        $pintar = true;
                                        $pintarChuleta = true;
                                    }

                                    for ($j=0; $j<21 && $pintar==false;$j++) {
                                        if($descripcion_troceada[(21*$i)+$j]) {
                                            $pintar = true;
                                            $pintarChuleta=true;
                                            $todovacio = false;
                                         }
                                    }

                                    if($pintar){

                                        $pdf->setLeftMargin(MARGIN);
                                        $pdf->SetTextColor(TEXT_WHITE);
                                        $pdf->SetFont('','B',10);
                                        $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                        $pdf->setLineWidth(0.3);



                                        //cabeceras
                                        $pdf->Cell(22, 5, '', 'TLB', 0, 'C', 1);
                                        $pdf->Cell(56, 5, get_string('schwache', 'vocabulario').'*', 'TRB', 0, 'C', 1);
                                        $pdf->Cell(56, 5, get_string('starke', 'vocabulario').'**', 1, 0, 'C', 1);
                                        $pdf->Cell(56, 5, get_string('gemischte', 'vocabulario').'***', 1, 1, 'C', 1);

                                        $pdf->SetTextColor(TEXT_AUTO);
                                        $pdf->SetFont('','',10);
                                        $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                        //la tabla
                                        $pdf->Cell(22, 5, get_string('infinitivo', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21*$i)+0], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21*$i)+7], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21*$i)+14], 1, 1, 'C', 0);

                                        $pdf->Cell(190, 5, '', 1, 1, 'C', 0);

                                        $pdf->Cell(22, 5, get_string('S1', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21*$i)+1], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21*$i)+8], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21*$i)+15], 1, 1, 'C', 0);

                                        $pdf->Cell(22, 5, get_string('S2', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21*$i)+2], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21*$i)+9], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21*$i)+16], 1, 1, 'C', 0);

                                        $pdf->Cell(22, 5, get_string('S3', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21*$i)+3], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21*$i)+10], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21*$i)+17], 1, 1, 'C', 0);

                                        $pdf->Cell(22, 5, get_string('P1', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21*$i)+4], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21*$i)+11], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21*$i)+18], 1, 1, 'C', 0);

                                        $pdf->Cell(22, 5, get_string('P2', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21*$i)+5], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21*$i)+12], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21*$i)+19], 1, 1, 'C', 0);

                                        $pdf->Cell(22, 5, get_string('P3', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21*$i)+6], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21*$i)+13], 1, 0, 'C', 0);
                                        $pdf->Cell(56, 5, $descripcion_troceada[(21*$i)+20], 1, 1, 'C', 0);

                                        $pdf->Ln();

                                    }

                                }

                                if($pintarChuleta == true){
                                    $pdf->SetTextColor(TEXT_AUTO);

                                    $pdf->SetFont('','',10);
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
                                $pdf->SetFont('','B',10);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                $pdf->setLineWidth(0.3);
                                //tabla 1

                                //cabecera
                                $pdf->Cell(110, 5, get_string('schwache_siehe', 'vocabulario'), 1, 1, 'C', 1);

                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->SetFont('','',10);
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
                                $pdf->SetFont('','B',10);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro

                                //cabecera
                                $pdf->Cell(24, 5, '', 'TLB', 0, 'C', 1);
                                $pdf->Cell(166, 5, get_string('starke', 'vocabulario'), 'TRB', 1, 'C', 1);
                                $pdf->Cell(24, 5, '', 1, 0, 'C', 1);
                                $pdf->Cell(83, 5, get_string('preterito', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(83, 5, get_string('conjuntivo2','vocabulario'), 1, 1, 'C', 1);

                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->SetFont('','',10);
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
                                $numtablas = (count($descripcion_troceada)-2)/31;
                                $todovacio = true;
                                for($i=0; $i<$numtablas; $i++){
                                    $pintar = false;

                                    if($i==$numtablas-1 && $todovacio){
                                        $pintar = true;
                                    }

                                    for ($j=0; $j<31 && $pintar==false;$j++) {
                                        if($descripcion_troceada[(31*$i)+$j]) {
                                            $pintar = true;
                                            $todovacio = false;
                                         }
                                    }

                                    if($pintar){
                                        $pdf->setLeftMargin(MARGIN);
                                        $pdf->SetTextColor(TEXT_WHITE);
                                        $pdf->SetFont('','B',10);
                                        $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                        $pdf->setLineWidth(0.3);

                                        //cabecera infinitiva

                                        $pdf->Cell(20, 5, get_string('infinitivo', 'vocabulario'), 1, 0, 'C', 1);

                                        $pdf->SetTextColor(TEXT_AUTO);
                                        $pdf->SetFont('','',10);

                                        $pdf->Cell(170, 5, $descripcion_troceada[(31*$i)+0], 1, 1, 'C', 0);


                                        //cabeceras indicativo / conjuntivo

                                        $pdf->SetTextColor(TEXT_WHITE);
                                        $pdf->SetFont('','B',10);

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
                                        $pdf->SetFont('','',10);
                                        $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                        //la tabla

                                        $pdf->Cell(20, 5, get_string('S1', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+1], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+2], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+3], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+4], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+5], 1, 1, 'C', 0);

                                        $pdf->Cell(20, 5, get_string('S2', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+6], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+7], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+8], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+9], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+10], 1, 1, 'C', 0);

                                        $pdf->Cell(20, 5, get_string('S3', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+11], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+12], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+13], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+14], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+15], 1, 1, 'C', 0);

                                        $pdf->Cell(20, 5, get_string('P1', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+16], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+17], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+18], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+19], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+20], 1, 1, 'C', 0);

                                        $pdf->Cell(20, 5, get_string('P2', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+21], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+22], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+23], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+24], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+25], 1, 1, 'C', 0);

                                        $pdf->Cell(20, 5, get_string('P3', 'vocabulario'), 1, 0, 'C', 1);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+26], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+27], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+28], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+29], 1, 0, 'C', 0);
                                        $pdf->Cell(34, 5, $descripcion_troceada[(31*$i)+30], 1, 1, 'C', 0);

                                        $pdf->Ln();
                                    }

                                }

                                break;
                            //3.7.1 Konjunktiv I
                            case 33:
                                $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFont('','B',10);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                $pdf->setLeftMargin(MARGIN);

                                //cabecera
                                $pdf->Cell(24, 5, '', 1, 0, 'C', 1);
                                $pdf->Cell(83, 5, get_string('sein', 'vocabulario'), 1, 0, 'C', 1);
                                $pdf->Cell(83, 5, get_string('andere','vocabulario'), 1, 1, 'C', 1);

                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->SetFont('','',10);
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

                                $numtablas = (count($descripcion_troceada)-2)/25;
                                $todovacio = true;
                                for($i=0; $i<$numtablas; $i++){
                                    $pintar = false;

                                    if($i==$numtablas-1 && $todovacio){
                                        $pintar = true;
                                    }

                                    for ($j=0; $j<25 && $pintar==false;$j++) {
                                        if($descripcion_troceada[(25*$i)+$j]) {
                                            $todovacio=false;
                                            $pintar = true;
                                         }
                                    }

                                    if($pintar){

                                        $pdf->SetTextColor(TEXT_WHITE);

                                        $pdf->SetFillColor(59, 89, 152); //#3B5998
                                        $pdf->setLeftMargin(MARGIN);

                                        $pdf->SetFont('','B',12);
                                        //cabecera grande
                                        $pdf->Cell(190,6,get_string('possessiv1','vocabulario'),1,1,'C',1);
                                        //separador
                                        $pdf->Cell(190,3,'',0,1,'C',0);

                                        //cabeceras chicas tabla 1.1

                                        $pdf->SetFont('','B',10);

                                        $pdf->Cell(20,5,'','LTB',0,'C',1);
                                        $pdf->Cell(170,5,get_string('sing','vocabulario'),'TRB',1,'C',1);
                                        $pdf->Cell(20,5,'','LT',0,'C',1);
                                        $pdf->Cell(34,5,'1','TR',0,'C',1);
                                        $pdf->Cell(34,5,'2','LTR',0,'C',1);
                                        $pdf->Cell(102,5,'3','LTR',1,'C',1);

                                        $pdf->Cell(20,5,'','LB',0,'C',1);
                                        $pdf->Cell(34,5,'','BR',0,'C',1);
                                        $pdf->Cell(34,5,'','LBR',0,'C',1);
                                        $pdf->Cell(34,5,'m','LB',0,'C',1);
                                        $pdf->Cell(34,5,'n','B',0,'C',1);
                                        $pdf->Cell(34,5,'f','BR',1,'C',1);

                                        //celdas tabla 1.1

                                        $pdf->setTextColor(TEXT_AUTO);
                                        $pdf->SetFont('','',10);
                                        $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                        $pdf->Cell(20,5,get_string('nominativo','vocabulario'),1,0,'C',1);
                                        $pdf->Cell(34,5,$descripcion_troceada[(25*$i)+0],1,0,'C',0);
                                        $pdf->Cell(34,5,$descripcion_troceada[(25*$i)+1],1,0,'C',0);
                                        $pdf->Cell(34,5,$descripcion_troceada[(25*$i)+2],1,0,'C',0);
                                        $pdf->Cell(34,5,$descripcion_troceada[(25*$i)+3],1,0,'C',0);
                                        $pdf->Cell(34,5,$descripcion_troceada[(25*$i)+4],1,1,'C',0);

                                        $pdf->Ln();

                                        //cabeceras chicas tabla 1.2
                                        $pdf->SetTextColor(TEXT_WHITE);
                                        $pdf->SetFont('','B',10);
                                        $pdf->SetFillColor(59, 89, 152); //#3B5998

                                        $pdf->Cell(20,5,'','LTB',0,'C',1);
                                        $pdf->Cell(126,5,get_string('plural','vocabulario'),'TRB',0,'C',1);
                                        $pdf->Cell(44,5,'','LTR',1,'C',1);

                                        $pdf->Cell(20,5,'','LT',0,'C',1);
                                        $pdf->Cell(42,5,'1','TR',0,'C',1);
                                        $pdf->Cell(42,5,'2','LTR',0,'C',1);
                                        $pdf->Cell(42,5,'3','LTR',0,'C',1);
                                        $pdf->Cell(44,5,get_string('sie','vocabulario'),'LR',1,'C',1);

                                        //celdas tabla 1.2

                                        $pdf->setTextColor(TEXT_AUTO);
                                        $pdf->SetFont('','',10);
                                        $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                        $pdf->Cell(20,5,get_string('nominativo','vocabulario'),1,0,'C',1);
                                        $pdf->Cell(42,5,$descripcion_troceada[(25*$i)+5],1,0,'C',0);
                                        $pdf->Cell(42,5,$descripcion_troceada[(25*$i)+6],1,0,'C',0);
                                        $pdf->Cell(42,5,$descripcion_troceada[(25*$i)+7],1,0,'C',0);
                                        $pdf->Cell(44,5,$descripcion_troceada[(25*$i)+8],1,1,'C',0);

                                        $pdf->Ln();
                                        $pdf->Ln();

                                        //cabecera grande

                                        $pdf->SetTextColor(TEXT_WHITE);
                                        $pdf->SetFillColor(59, 89, 152); //#3B5998
                                        $pdf->SetFont('','B',12);

                                        $pdf->Cell(190,6,get_string('declinacion_siehe','vocabulario'),1,1,'C',1);

                                        //cabeceras chicas tabla 2
                                        $pdf->SetFont('','B',10);

                                        $pdf->Cell(22,5,'','LTB',0,'C',1);
                                        $pdf->Cell(42,5,get_string('masculino','vocabulario'),'TRB',0,'C',1);
                                        $pdf->Cell(42,5,get_string('neutro','vocabulario'),1,0,'C',1);
                                        $pdf->Cell(42,5,get_string('femenino','vocabulario'),1,0,'C',1);
                                        $pdf->Cell(42,5,get_string('plural','vocabulario'),1,1,'C',1);

                                        //celdas tabla 2

                                        $pdf->setTextColor(TEXT_AUTO);
                                        $pdf->SetFont('','',10);
                                        $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                        $pdf->Cell(22,5,get_string('nominativo','vocabulario'),1,0,'C',1);
                                        $pdf->Cell(42,5,$descripcion_troceada[(25*$i)+9],1,0,'C',0);
                                        $pdf->Cell(42,5,$descripcion_troceada[(25*$i)+10],1,0,'C',0);
                                        $pdf->Cell(42,5,$descripcion_troceada[(25*$i)+11],1,0,'C',0);
                                        $pdf->Cell(42,5,$descripcion_troceada[(25*$i)+12],1,1,'C',0);
                                        $pdf->Cell(22,5,get_string('acusativo','vocabulario'),1,0,'C',1);
                                        $pdf->Cell(42,5,$descripcion_troceada[(25*$i)+13],1,0,'C',0);
                                        $pdf->Cell(42,5,$descripcion_troceada[(25*$i)+14],1,0,'C',0);
                                        $pdf->Cell(42,5,$descripcion_troceada[(25*$i)+15],1,0,'C',0);
                                        $pdf->Cell(42,5,$descripcion_troceada[(25*$i)+16],1,1,'C',0);
                                        $pdf->Cell(22,5,get_string('dativo','vocabulario'),1,0,'C',1);
                                        $pdf->Cell(42,5,$descripcion_troceada[(25*$i)+17],1,0,'C',0);
                                        $pdf->Cell(42,5,$descripcion_troceada[(25*$i)+18],1,0,'C',0);
                                        $pdf->Cell(42,5,$descripcion_troceada[(25*$i)+19],1,0,'C',0);
                                        $pdf->Cell(42,5,$descripcion_troceada[(25*$i)+20],1,1,'C',0);
                                        $pdf->Cell(22,5,get_string('genitivo','vocabulario'),1,0,'C',1);
                                        $pdf->Cell(42,5,$descripcion_troceada[(25*$i)+21],1,0,'C',0);
                                        $pdf->Cell(42,5,$descripcion_troceada[(25*$i)+22],1,0,'C',0);
                                        $pdf->Cell(42,5,$descripcion_troceada[(25*$i)+23],1,0,'C',0);
                                        $pdf->Cell(42,5,$descripcion_troceada[(25*$i)+24],1,1,'C',0);

                                        $pdf->Ln();
                                    }
                                }

                                break;

                            //4.3 Possessivartikel
                            case 39:

                                $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998
                                $pdf->setLeftMargin(MARGIN);
                                $pdf->SetFont('','B',12);

                                //cabecera grande
                                $pdf->Cell(190,6,get_string('possessiv2','vocabulario'),1,1,'C',1);
                                //separador
                                $pdf->Cell(190,3,'',0,1,'C',0);

                                //cabeceras chicas tabla 1.1
                                $pdf->SetFont('','B',10);

                                $pdf->Cell(20,5,'','LTB',0,'C',1);
                                $pdf->Cell(170,5,get_string('sing','vocabulario'),'TRB',1,'C',1);
                                $pdf->Cell(20,5,'','LT',0,'C',1);
                                $pdf->Cell(34,5,'1','TR',0,'C',1);
                                $pdf->Cell(34,5,'2','LTR',0,'C',1);
                                $pdf->Cell(102,5,'3','LTR',1,'C',1);

                                $pdf->Cell(20,5,'','LB',0,'C',1);
                                $pdf->Cell(34,5,'','BR',0,'C',1);
                                $pdf->Cell(34,5,'','LBR',0,'C',1);
                                $pdf->Cell(34,5,'m','LB',0,'C',1);
                                $pdf->Cell(34,5,'n','B',0,'C',1);
                                $pdf->Cell(34,5,'f','BR',1,'C',1);

                                //celdas tabla 1.1

                                $pdf->setTextColor(TEXT_AUTO);
                                $pdf->SetFont('','',10);
                                $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                $pdf->Cell(20,5,get_string('nominativo','vocabulario'),1,0,'C',1);
                                $pdf->Cell(34,5,$descripcion_troceada[0],1,0,'C',0);
                                $pdf->Cell(34,5,$descripcion_troceada[1],1,0,'C',0);
                                $pdf->Cell(34,5,$descripcion_troceada[2],1,0,'C',0);
                                $pdf->Cell(34,5,$descripcion_troceada[3],1,0,'C',0);
                                $pdf->Cell(34,5,$descripcion_troceada[4],1,1,'C',0);

                                $pdf->Ln();

                                //cabeceras chicas tabla 1.2
                                $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFont('','B',10);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998

                                $pdf->Cell(20,5,'','LTB',0,'C',1);
                                $pdf->Cell(126,5,get_string('plural','vocabulario'),'TRB',0,'C',1);
                                $pdf->Cell(44,5,'','LTR',1,'C',1);

                                $pdf->Cell(20,5,'','LT',0,'C',1);
                                $pdf->Cell(42,5,'1','TR',0,'C',1);
                                $pdf->Cell(42,5,'2','LTR',0,'C',1);
                                $pdf->Cell(42,5,'3','LTR',0,'C',1);
                                $pdf->Cell(44,5,get_string('sie','vocabulario'),'LR',1,'C',1);

                                //celdas tabla 1.2

                                $pdf->setTextColor(TEXT_AUTO);
                                $pdf->SetFont('','',10);
                                $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                $pdf->Cell(20,5,get_string('nominativo','vocabulario'),1,0,'C',1);
                                $pdf->Cell(42,5,$descripcion_troceada[5],1,0,'C',0);
                                $pdf->Cell(42,5,$descripcion_troceada[6],1,0,'C',0);
                                $pdf->Cell(42,5,$descripcion_troceada[7],1,0,'C',0);
                                $pdf->Cell(44,5,$descripcion_troceada[8],1,1,'C',0);

                                $pdf->Ln();
                                $pdf->Ln();

                                $pdf->SetTextColor(TEXT_WHITE);
                                $pdf->SetFont('','B',12);
                                $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                $pdf->setLineWidth(0.3);

                                //cabecera grande
                                $pdf->Cell(190, 6, get_string('endungen_siehe4', 'vocabulario'), 1, 1, 'C', 1);

                                $pdf->Ln();

                                $pintar=false;

                                for ($j=9; $j<(count($descripcion_troceada)-2) && $pintar==false;$j++) {
                                        if($descripcion_troceada[$j]) {
                                            $pintar = true;
                                         }
                                }

                                if($pintar){
                                    $pdf->SetTextColor(TEXT_WHITE);
    //                                $pdf->SetFont('','B',12);
                                    $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                    $pdf->setLineWidth(0.3);

                                    //cabeceras
                                    $pdf->SetFont('','B',10);

                                    $pdf->Cell(22, 5, '', 'TLB', 0, 'C', 1);
                                    $pdf->Cell(168, 5, get_string('declinacion4', 'vocabulario'), 'TRB', 1, 'C', 1);

                                    $pdf->Cell(22,5,'','LTB',0,'C',1);
                                    $pdf->Cell(42,5,get_string('masculino','vocabulario'),'TRB',0,'C',1);
                                    $pdf->Cell(42,5,get_string('neutro','vocabulario'),1,0,'C',1);
                                    $pdf->Cell(42,5,get_string('femenino','vocabulario'),1,0,'C',1);
                                    $pdf->Cell(42,5,get_string('plural','vocabulario'),1,1,'C',1);

                                    //celdas

                                    $pdf->setTextColor(TEXT_AUTO);
                                    $pdf->SetFont('','',10);
                                    $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                    $pdf->Cell(22,5,get_string('nominativo','vocabulario'),1,0,'C',1);
                                    $pdf->Cell(42,5,$descripcion_troceada[9],1,0,'C',0);
                                    $pdf->Cell(42,5,$descripcion_troceada[10],1,0,'C',0);
                                    $pdf->Cell(42,5,$descripcion_troceada[11],1,0,'C',0);
                                    $pdf->Cell(42,5,$descripcion_troceada[12],1,1,'C',0);
                                    $pdf->Cell(22,5,get_string('acusativo','vocabulario'),1,0,'C',1);
                                    $pdf->Cell(42,5,$descripcion_troceada[13],1,0,'C',0);
                                    $pdf->Cell(42,5,$descripcion_troceada[14],1,0,'C',0);
                                    $pdf->Cell(42,5,$descripcion_troceada[15],1,0,'C',0);
                                    $pdf->Cell(42,5,$descripcion_troceada[16],1,1,'C',0);
                                    $pdf->Cell(22,5,get_string('dativo','vocabulario'),1,0,'C',1);
                                    $pdf->Cell(42,5,$descripcion_troceada[17],1,0,'C',0);
                                    $pdf->Cell(42,5,$descripcion_troceada[18],1,0,'C',0);
                                    $pdf->Cell(42,5,$descripcion_troceada[19],1,0,'C',0);
                                    $pdf->Cell(42,5,$descripcion_troceada[20],1,1,'C',0);
                                    $pdf->Cell(22,5,get_string('genitivo','vocabulario'),1,0,'C',1);
                                    $pdf->Cell(42,5,$descripcion_troceada[21],1,0,'C',0);
                                    $pdf->Cell(42,5,$descripcion_troceada[22],1,0,'C',0);
                                    $pdf->Cell(42,5,$descripcion_troceada[23],1,0,'C',0);
                                    $pdf->Cell(42,5,$descripcion_troceada[24],1,1,'C',0);

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
                                $pdf->SetFont('','B',12);

                                switch ($grid) {
                                    case 40:
                                        $pdf->Cell(190, 6, get_string('endungen_siehe1','vocabulario'), 1, 1, 'C', 1);
                                        $pdf->Ln();
                                        $tablasiempre=false;
                                        break;
                                    case 42:
                                        $pdf->Cell(190, 6, get_string('endungen_siehe3','vocabulario'), 1, 1, 'C', 1);
                                        $pdf->Ln();
                                        $tablasiempre=false;
                                        break;
                                }

                                $numtablas = (count($descripcion_troceada)-2)/16;
                                $todovacio = true;

                                for($i=0; $i<$numtablas; $i++){
                                    $pintar = false;

                                    if($i==$numtablas-1 && $todovacio && $tablasiempre){
                                        $pintar = true;
                                    }

                                    for ($j=0; $j<16 && $pintar==false;$j++) {
                                        if($descripcion_troceada[(16*$i)+$j]) {
                                            $todovacio=false;
                                            $pintar = true;
                                         }
                                    }

                                    if($pintar){

                                        $pdf->SetTextColor(TEXT_WHITE);
                                        $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro

                                        //cabeceras
                                        $pdf->SetFont('','B',10);

                                        $pdf->Cell(22,5,'','LTB',0,'C',1);
                                        $pdf->Cell(42,5,get_string('masculino','vocabulario'),'TRB',0,'C',1);
                                        $pdf->Cell(42,5,get_string('neutro','vocabulario'),1,0,'C',1);
                                        $pdf->Cell(42,5,get_string('femenino','vocabulario'),1,0,'C',1);
                                        $pdf->Cell(42,5,get_string('plural','vocabulario'),1,1,'C',1);

                                        //celdas

                                        $pdf->setTextColor(TEXT_AUTO);
                                        $pdf->SetFont('','',10);
                                        $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                        $pdf->Cell(22,5,get_string('nominativo','vocabulario'),1,0,'C',1);
                                        $pdf->Cell(42,5,$descripcion_troceada[(16*$i)+0],1,0,'C',0);
                                        $pdf->Cell(42,5,$descripcion_troceada[(16*$i)+1],1,0,'C',0);
                                        $pdf->Cell(42,5,$descripcion_troceada[(16*$i)+2],1,0,'C',0);
                                        $pdf->Cell(42,5,$descripcion_troceada[(16*$i)+3],1,1,'C',0);
                                        $pdf->Cell(22,5,get_string('acusativo','vocabulario'),1,0,'C',1);
                                        $pdf->Cell(42,5,$descripcion_troceada[(16*$i)+4],1,0,'C',0);
                                        $pdf->Cell(42,5,$descripcion_troceada[(16*$i)+5],1,0,'C',0);
                                        $pdf->Cell(42,5,$descripcion_troceada[(16*$i)+6],1,0,'C',0);
                                        $pdf->Cell(42,5,$descripcion_troceada[(16*$i)+7],1,1,'C',0);
                                        $pdf->Cell(22,5,get_string('dativo','vocabulario'),1,0,'C',1);
                                        $pdf->Cell(42,5,$descripcion_troceada[(16*$i)+8],1,0,'C',0);
                                        $pdf->Cell(42,5,$descripcion_troceada[(16*$i)+9],1,0,'C',0);
                                        $pdf->Cell(42,5,$descripcion_troceada[(16*$i)+10],1,0,'C',0);
                                        $pdf->Cell(42,5,$descripcion_troceada[(16*$i)+11],1,1,'C',0);
                                        $pdf->Cell(22,5,get_string('genitivo','vocabulario'),1,0,'C',1);
                                        $pdf->Cell(42,5,$descripcion_troceada[(16*$i)+12],1,0,'C',0);
                                        $pdf->Cell(42,5,$descripcion_troceada[(16*$i)+13],1,0,'C',0);
                                        $pdf->Cell(42,5,$descripcion_troceada[(16*$i)+14],1,0,'C',0);
                                        $pdf->Cell(42,5,$descripcion_troceada[(16*$i)+15],1,1,'C',0);

                                        $pdf->Ln();
                                    }
                                }
                                    
                                break;

                            //2.2 Interrogativpronomen
                            case 8:

                                $numtablas = (count($descripcion_troceada)-2)/8;
                                $todovacio = true;

                                for($i=0; $i<$numtablas; $i++){
                                    $pintar = false;

                                    if($i==$numtablas-1 && $todovacio){
                                        $pintar = true;
                                    }

                                    for ($j=0; $j<8 && $pintar==false;$j++) {
                                        if($descripcion_troceada[(8*$i)+$j]) {
                                            $todovacio=false;
                                            $pintar = true;
                                         }
                                    }

                                    if($pintar){
                                        $pdf->setLeftMargin(MARGIN);
                                        $pdf->SetTextColor(TEXT_WHITE);
                                        $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                        $pdf->setLineWidth(0.3);
                                        //cabeceras
                                        $pdf->SetFont('','B',10);

                                        $pdf->Cell(24,5,'','LTB',0,'C',1);
                                        $pdf->Cell(83,5,get_string('person','vocabulario'),'TRB',0,'C',1);
                                        $pdf->Cell(83,5,get_string('nichtperson','vocabulario'),1,1,'C',1);

                                        //celdas

                                        $pdf->setTextColor(TEXT_AUTO);
                                        $pdf->SetFont('','',10);
                                        $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                        $pdf->Cell(24,5,get_string('nominativo','vocabulario'),1,0,'C',1);
                                        $pdf->Cell(83,5,$descripcion_troceada[(8*$i)+0],1,0,'C',0);
                                        $pdf->Cell(83,5,$descripcion_troceada[(8*$i)+1],1,1,'C',0);
                                        $pdf->Cell(24,5,get_string('acusativo','vocabulario'),1,0,'C',1);
                                        $pdf->Cell(83,5,$descripcion_troceada[(8*$i)+2],1,0,'C',0);
                                        $pdf->Cell(83,5,$descripcion_troceada[(8*$i)+3],1,1,'C',0);
                                        $pdf->Cell(24,5,get_string('dativo','vocabulario'),1,0,'C',1);
                                        $pdf->Cell(83,5,$descripcion_troceada[(8*$i)+4],1,0,'C',0);
                                        $pdf->Cell(83,5,$descripcion_troceada[(8*$i)+5],1,1,'C',0);
                                        $pdf->Cell(24,5,get_string('genitivo','vocabulario'),1,0,'C',1);
                                        $pdf->Cell(83,5,$descripcion_troceada[(8*$i)+6],1,0,'C',0);
                                        $pdf->Cell(83,5,$descripcion_troceada[(8*$i)+7],1,1,'C',0);

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
                                $pdf->SetFont('','B',10);

                                $pdf->Cell(47,5,get_string('vorfeld','vocabulario'),1,0,'C',1);
                                $pdf->Cell(48,5,get_string('konjugier','vocabulario'),1,0,'C',1);
                                $pdf->Cell(48,5,get_string('mittelfeld','vocabulario'),1,0,'C',1);
                                $pdf->Cell(47,5,get_string('verb2','vocabulario'),1,1,'C',1);

                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito
                                $pdf->SetFont('','',10);

                                //se calcula el nº de filas totales
                                $totalfilas = ((count($descripcion_troceada)-2)/4);

                                $todovacio = true;
                                
                                for($f = 0; $f < $totalfilas; $f++){
                                    $pintar = false;

                                    if($f==$totalfilas-1 && $todovacio){
                                        $pintar = true;
                                    }

                                    for ($j=0; $j<4 && $pintar==false;$j++) {
                                        if($descripcion_troceada[(4*$f)+$j]) {
                                            $todovacio=false;
                                            $pintar = true;
                                         }
                                    }

                                    if($pintar){

                                        $pdf->Cell(47,5,$descripcion_troceada[($f*4)],1,0,'C',0);
                                        $pdf->Cell(48,5,$descripcion_troceada[($f*4)+1],1,0,'C',1);
                                        $pdf->Cell(48,5,$descripcion_troceada[($f*4)+2],1,0,'C',0);
                                        $pdf->Cell(47,5,$descripcion_troceada[($f*4)+3],1,1,'C',1);
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
                                $pdf->SetFont('','B',10);

                                $pdf->Cell(38,5,get_string('subjunktor','vocabulario'),1,0,'C',1);
                                $pdf->Cell(38,5,get_string('subjekt','vocabulario'),1,0,'C',1);
                                $pdf->Cell(38,5,get_string('konjugier','vocabulario'),1,0,'C',1);
                                $pdf->Cell(38,5,get_string('mittelfeld','vocabulario'),1,0,'C',1);
                                $pdf->Cell(38,5,get_string('verb2','vocabulario'),1,1,'C',1);

                                $pdf->SetTextColor(TEXT_AUTO);
                                $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito
                                $pdf->SetFont('','',10);

                                //se calcula el nº de filas totales
                                $totalfilas = ((count($descripcion_troceada)-2)/5);

                                $todovacio = true;

                                for($f = 0; $f < $totalfilas; $f++){
                                    $pintar = false;

                                    if($f==$totalfilas-1 && $todovacio){
                                        $pintar = true;
                                    }

                                    for ($j=0; $j<5 && $pintar==false;$j++) {
                                        if($descripcion_troceada[(5*$f)+$j]) {
                                            $todovacio=false;
                                            $pintar = true;
                                         }
                                    }

                                    if($pintar){

                                        $pdf->Cell(38,5,$descripcion_troceada[($f*5)],1,0,'C',0);
                                        $pdf->Cell(38,5,$descripcion_troceada[($f*5)+4],1,0,'C',0);
                                        $pdf->Cell(38,5,$descripcion_troceada[($f*5)+1],1,0,'C',1);
                                        $pdf->Cell(38,5,$descripcion_troceada[($f*5)+2],1,0,'C',0);
                                        $pdf->Cell(38,5,$descripcion_troceada[($f*5)+3],1,1,'C',1);
                                    }

                                }
                                $pdf->Ln();
                                break;
                            //2.4.2.1 Pronomina, die nur Personen bezeichnen
                            case 13:
                                $numtablas = (count($descripcion_troceada)-2)/5;
                                $todovacio = true;

                                for($i=0; $i<$numtablas; $i++){
                                    $pintar = false;

                                    if($i==$numtablas-1 && $todovacio){
                                        $pintar = true;
                                    }

                                    for ($j=0; $j<5 && $pintar==false;$j++) {
                                        if($descripcion_troceada[(5*$i)+$j]) {
                                            $todovacio=false;
                                            $pintar = true;
                                         }
                                    }

                                    if($pintar){
                                        $pdf->setLeftMargin(MARGIN_L5);
                                        $pdf->SetTextColor(TEXT_AUTO);
                                        $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                        $pdf->setLineWidth(0.3);
                                        //cabeceras
                                        $pdf->SetFont('','',10);

                                        $pdf->Cell(110,4,'',1,1,'C',1);
                                        $pdf->Cell(110,5,$descripcion_troceada[(5*$i)],1,1,'C',0);

                                        //celdas
                                        $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                        $pdf->Cell(24,5,get_string('nominativo','vocabulario'),1,0,'C',1);
                                        $pdf->Cell(86,5,$descripcion_troceada[(5*$i)+1],1,1,'C',0);
                                        $pdf->Cell(24,5,get_string('acusativo','vocabulario'),1,0,'C',1);
                                        $pdf->Cell(86,5,$descripcion_troceada[(5*$i)+2],1,1,'C',0);
                                        $pdf->Cell(24,5,get_string('dativo','vocabulario'),1,0,'C',1);
                                        $pdf->Cell(86,5,$descripcion_troceada[(5*$i)+3],1,1,'C',0);
                                        $pdf->Cell(24,5,get_string('genitivo','vocabulario'),1,0,'C',1);
                                        $pdf->Cell(86,5,$descripcion_troceada[(5*$i)+4],1,1,'C',0);

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

                                    $pdf->SetFont('','B',10);

                                    $pdf->Cell(20,5,'','LTB',0,'C',1);
                                    $pdf->Cell(170,5,get_string('sing','vocabulario'),'TRB',1,'C',1);
                                    $pdf->Cell(20,5,'','LT',0,'C',1);
                                    $pdf->Cell(34,5,'1','TR',0,'C',1);
                                    $pdf->Cell(34,5,'2','LTR',0,'C',1);
                                    $pdf->Cell(102,5,'3','LTR',1,'C',1);

                                    $pdf->Cell(20,5,'','LB',0,'C',1);
                                    $pdf->Cell(34,5,'','BR',0,'C',1);
                                    $pdf->Cell(34,5,'','LBR',0,'C',1);
                                    $pdf->Cell(34,5,'m','LB',0,'C',1);
                                    $pdf->Cell(34,5,'n','B',0,'C',1);
                                    $pdf->Cell(34,5,'f','BR',1,'C',1);

                                    //celdas tabla 1.1

                                    $pdf->setTextColor(TEXT_AUTO);
                                    $pdf->SetFont('','',10);
                                    $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                    $pdf->Cell(20,5,get_string('nominativo','vocabulario'),1,0,'C',1);
                                    $pdf->Cell(34,5,$descripcion_troceada[0],1,0,'C',0);
                                    $pdf->Cell(34,5,$descripcion_troceada[1],1,0,'C',0);
                                    $pdf->Cell(34,5,$descripcion_troceada[2],1,0,'C',0);
                                    $pdf->Cell(34,5,$descripcion_troceada[3],1,0,'C',0);
                                    $pdf->Cell(34,5,$descripcion_troceada[4],1,1,'C',0);

                                    $pdf->Cell(20,5,get_string('acusativo','vocabulario'),1,0,'C',1);
                                    $pdf->Cell(34,5,$descripcion_troceada[9],1,0,'C',0);
                                    $pdf->Cell(34,5,$descripcion_troceada[10],1,0,'C',0);
                                    $pdf->Cell(34,5,$descripcion_troceada[11],1,0,'C',0);
                                    $pdf->Cell(34,5,$descripcion_troceada[12],1,0,'C',0);
                                    $pdf->Cell(34,5,$descripcion_troceada[13],1,1,'C',0);

                                    $pdf->Cell(20,5,get_string('dativo','vocabulario'),1,0,'C',1);
                                    $pdf->Cell(34,5,$descripcion_troceada[18],1,0,'C',0);
                                    $pdf->Cell(34,5,$descripcion_troceada[19],1,0,'C',0);
                                    $pdf->Cell(34,5,$descripcion_troceada[20],1,0,'C',0);
                                    $pdf->Cell(34,5,$descripcion_troceada[21],1,0,'C',0);
                                    $pdf->Cell(34,5,$descripcion_troceada[22],1,1,'C',0);

                                    $pdf->Cell(20,5,get_string('genitivo','vocabulario'),1,0,'C',1);
                                    $pdf->Cell(34,5,$descripcion_troceada[27],1,0,'C',0);
                                    $pdf->Cell(34,5,$descripcion_troceada[28],1,0,'C',0);
                                    $pdf->Cell(34,5,$descripcion_troceada[29],1,0,'C',0);
                                    $pdf->Cell(34,5,$descripcion_troceada[30],1,0,'C',0);
                                    $pdf->Cell(34,5,$descripcion_troceada[31],1,1,'C',0);

                                    $pdf->Ln();

                                    //cabeceras chicas tabla 1.2
                                    $pdf->SetTextColor(TEXT_WHITE);
                                    $pdf->SetFont('','B',10);
                                    $pdf->SetFillColor(59, 89, 152); //#3B5998

                                    $pdf->Cell(20,5,'','LTB',0,'C',1);
                                    $pdf->Cell(126,5,get_string('plural','vocabulario'),'TRB',0,'C',1);
                                    $pdf->Cell(44,5,'','LTR',1,'C',1);

                                    $pdf->Cell(20,5,'','LT',0,'C',1);
                                    $pdf->Cell(42,5,'1','TR',0,'C',1);
                                    $pdf->Cell(42,5,'2','LTR',0,'C',1);
                                    $pdf->Cell(42,5,'3','LTR',0,'C',1);
                                    $pdf->Cell(44,5,get_string('sie','vocabulario'),'LR',1,'C',1);

                                    //celdas tabla 1.2

                                    $pdf->setTextColor(TEXT_AUTO);
                                    $pdf->SetFont('','',10);
                                    $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                    $pdf->Cell(20,5,get_string('nominativo','vocabulario'),1,0,'C',1);
                                    $pdf->Cell(42,5,$descripcion_troceada[5],1,0,'C',0);
                                    $pdf->Cell(42,5,$descripcion_troceada[6],1,0,'C',0);
                                    $pdf->Cell(42,5,$descripcion_troceada[7],1,0,'C',0);
                                    $pdf->Cell(44,5,$descripcion_troceada[8],1,1,'C',0);

                                    $pdf->Cell(20,5,get_string('acusativo','vocabulario'),1,0,'C',1);
                                    $pdf->Cell(42,5,$descripcion_troceada[14],1,0,'C',0);
                                    $pdf->Cell(42,5,$descripcion_troceada[15],1,0,'C',0);
                                    $pdf->Cell(42,5,$descripcion_troceada[16],1,0,'C',0);
                                    $pdf->Cell(44,5,$descripcion_troceada[17],1,1,'C',0);

                                    $pdf->Cell(20,5,get_string('dativo','vocabulario'),1,0,'C',1);
                                    $pdf->Cell(42,5,$descripcion_troceada[23],1,0,'C',0);
                                    $pdf->Cell(42,5,$descripcion_troceada[24],1,0,'C',0);
                                    $pdf->Cell(42,5,$descripcion_troceada[25],1,0,'C',0);
                                    $pdf->Cell(44,5,$descripcion_troceada[26],1,1,'C',0);

                                    $pdf->Cell(20,5,get_string('genitivo','vocabulario'),1,0,'C',1);
                                    $pdf->Cell(42,5,$descripcion_troceada[32],1,0,'C',0);
                                    $pdf->Cell(42,5,$descripcion_troceada[33],1,0,'C',0);
                                    $pdf->Cell(42,5,$descripcion_troceada[34],1,0,'C',0);
                                    $pdf->Cell(44,5,$descripcion_troceada[35],1,1,'C',0);

                                    $pdf->Ln();
                                    break;
                                //3.8 Imperativ
                                case 35:

                                    $numtablas = (count($descripcion_troceada)-2)/4;
                                    $todovacio = true;

                                    for($i=0; $i<$numtablas; $i++){
                                        $pintar = false;

                                        if($i==$numtablas-1 && $todovacio){
                                            $pintar = true;
                                        }

                                        for ($j=0; $j<4 && $pintar==false;$j++) {
                                            if($descripcion_troceada[(4*$i)+$j]) {
                                                $todovacio=false;
                                                $pintar = true;
                                             }
                                        }

                                        if($pintar){
                                            $pdf->setLeftMargin(MARGIN_L5);
                                            $pdf->SetTextColor(TEXT_WHITE);
                                            $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                            $pdf->setLineWidth(0.3);

                                            //cabeceras
                                            $pdf->SetFont('','B',10);

                                            $pdf->Cell(24,5,get_string('infinitivo','vocabulario'),1,0,'C',1);

                                            $pdf->SetTextColor(TEXT_AUTO);
                                            
                                            $pdf->Cell(86,5,$descripcion_troceada[(4*$i)],1,1,'C',0);

                                            //celdas
                                            $pdf->SetFont('','',10);
                                            $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                            $pdf->Cell(24,5,get_string('S2','vocabulario'),1,0,'C',1);
                                            $pdf->Cell(86,5,$descripcion_troceada[(4*$i)+1],1,1,'C',0);
                                            $pdf->Cell(24,5,get_string('P2','vocabulario'),1,0,'C',1);
                                            $pdf->Cell(86,5,$descripcion_troceada[(4*$i)+2],1,1,'C',0);
                                            $pdf->Cell(24,5,get_string('sie','vocabulario'),1,0,'C',1);
                                            $pdf->Cell(86,5,$descripcion_troceada[(4*$i)+3],1,1,'C',0);

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
                                    $pdf->SetFont('','B',12);

                                    //cabecera grande
                                    $pdf->Cell(190,6,get_string('reflexivo','vocabulario'),1,1,'C',1);
                                    //separador
                                    $pdf->Cell(190,3,'',0,1,'C',0);

                                    //cabeceras chicas tabla 1.1
                                    $pdf->SetFont('','B',10);

                                    $pdf->Cell(22,5,'','LTB',0,'C',1);
                                    $pdf->Cell(168,5,get_string('sing','vocabulario'),'TRB',1,'C',1);
                                    $pdf->Cell(22,5,'','LT',0,'C',1);
                                    $pdf->Cell(56,5,'1','TR',0,'C',1);
                                    $pdf->Cell(56,5,'2','LTR',0,'C',1);
                                    $pdf->Cell(56,5,'3','LTR',1,'C',1);

                                    //celdas tabla 1.1

                                    $pdf->setTextColor(TEXT_AUTO);
                                    $pdf->SetFont('','',10);
                                    $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                    $pdf->Cell(22,5,get_string('acusativo','vocabulario'),1,0,'C',1);
                                    $pdf->Cell(56,5,$descripcion_troceada[0],1,0,'C',0);
                                    $pdf->Cell(56,5,$descripcion_troceada[1],1,0,'C',0);
                                    $pdf->Cell(56,5,$descripcion_troceada[2],1,1,'C',0);

                                    $pdf->Cell(22,5,get_string('dativo','vocabulario'),1,0,'C',1);
                                    $pdf->Cell(56,5,$descripcion_troceada[7],1,0,'C',0);
                                    $pdf->Cell(56,5,$descripcion_troceada[8],1,0,'C',0);
                                    $pdf->Cell(56,5,$descripcion_troceada[9],1,1,'C',0);

                                    $pdf->Ln();

                                    //cabeceras chicas tabla 1.2
                                    $pdf->SetTextColor(TEXT_WHITE);
                                    $pdf->SetFont('','B',10);
                                    $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro

                                    $pdf->Cell(22,5,'','LTB',0,'C',1);
                                    $pdf->Cell(126,5,get_string('plural','vocabulario'),'TRB',0,'C',1);
                                    $pdf->Cell(42,5,'','LTR',1,'C',1);

                                    $pdf->Cell(22,5,'','LT',0,'C',1);
                                    $pdf->Cell(42,5,'1','TR',0,'C',1);
                                    $pdf->Cell(42,5,'2','LTR',0,'C',1);
                                    $pdf->Cell(42,5,'3','LTR',0,'C',1);
                                    $pdf->Cell(42,5,get_string('sie','vocabulario'),'LR',1,'C',1);

                                    //celdas tabla 1.2

                                    $pdf->setTextColor(TEXT_AUTO);
                                    $pdf->SetFont('','',10);
                                    $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito

                                    $pdf->Cell(22,5,get_string('acusativo','vocabulario'),1,0,'C',1);
                                    $pdf->Cell(42,5,$descripcion_troceada[3],1,0,'C',0);
                                    $pdf->Cell(42,5,$descripcion_troceada[4],1,0,'C',0);
                                    $pdf->Cell(42,5,$descripcion_troceada[5],1,0,'C',0);
                                    $pdf->Cell(42,5,$descripcion_troceada[6],1,1,'C',0);

                                    $pdf->Cell(22,5,get_string('dativo','vocabulario'),1,0,'C',1);
                                    $pdf->Cell(42,5,$descripcion_troceada[10],1,0,'C',0);
                                    $pdf->Cell(42,5,$descripcion_troceada[11],1,0,'C',0);
                                    $pdf->Cell(42,5,$descripcion_troceada[12],1,0,'C',0);
                                    $pdf->Cell(42,5,$descripcion_troceada[13],1,1,'C',0);

                                    $pdf->Ln();
                                    break;
                                //4.7 Gebrauch der Artikelwörter
                                case 43:
                                    $titulo='';
                                    $tope = 20;

                                    for($tabla = 0; $tabla<3; ++$tabla) {
                                        
                                        //Según la tabla pongo un indice u otro
                                        switch($tabla) {
                                            case 0:
                                                $titulo = get_string('beispiele_def','vocabulario');
                                                break;
                                            case 1:
                                                $titulo = get_string('beispiele_indef','vocabulario');
                                                break;
                                            case 2:
                                                $titulo = get_string('beispiele_null','vocabulario');
                                                break;
                                        }


                                        //titulillos de la tabla

                                        $pdf->SetTextColor(TEXT_WHITE);
                                        $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                        $pdf->setLeftMargin(MARGIN_L3);
                                        $pdf->SetFont('','B',10);

                                        $pdf->Cell(75,5,$titulo,1,0,'C',1);
                                        $pdf->Cell(75,5,get_string('gebrauch','vocabulario'),1,1,'C',1);
                                        
                                        //A partir de aqui pinto filas según se van necesitando
                                        $pdf->SetTextColor(TEXT_AUTO);
                                        $pdf->SetFont('','',10);


                                        $todovacio = true;
                                        for ($fila=0; $fila<$tope;$fila++) {
                                            
                                            $pintar = false;

                                            if($fila==$tope-1 && $todovacio){
                                                $pintar = true;
                                            }

                                            for ($j=0; $j<2 && $pintar==false;$j++) {
                                                if($descripcion_troceada[($tabla*$tope*2)+((2*$fila)+$j)]) {
                                                    $todovacio=false;
                                                    $pintar = true;
                                                 }
                                            }

                                            if($pintar){

                                                $pdf->Cell(75,5,$descripcion_troceada[($tabla*$tope*2)+((2*$fila)+0)],1,0,'C',0);
                                                $pdf->Cell(75,5,$descripcion_troceada[($tabla*$tope*2)+((2*$fila)+1)],1,1,'C',0);

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
                                    $pdf->SetFont('','B',10);

                                    $pdf->Cell(63,5,get_string('positivo','vocabulario'),1,0,'C',1);
                                    $pdf->Cell(64,5,get_string('comparativo','vocabulario'),1,0,'C',1);
                                    $pdf->Cell(63,5,get_string('superlativo','vocabulario'),1,1,'C',1);

                                    $pdf->SetTextColor(TEXT_AUTO);
                                    $pdf->SetFont('','',10);

                                    //se calcula el nº de filas totales
                                    $totalfilas = ((count($descripcion_troceada)-2)/3);

                                    $todovacio = true;

                                    for($f = 0; $f < $totalfilas; $f++){
                                        $pintar = false;

                                        if($f==$totalfilas-1 && $todovacio){
                                            $pintar = true;
                                        }

                                        for ($j=0; $j<3 && $pintar==false;$j++) {
                                            if($descripcion_troceada[(3*$f)+$j]) {
                                                $todovacio=false;
                                                $pintar = true;
                                             }
                                        }

                                        if($pintar){

                                            $pdf->Cell(63,5,$descripcion_troceada[($f*3)],1,0,'C',0);
                                            $pdf->Cell(64,5,$descripcion_troceada[($f*3)+1],1,0,'C',0);
                                            $pdf->Cell(63,5,$descripcion_troceada[($f*3)+2],1,1,'C',0);
                                        }

                                    }
                                    $pdf->Ln();
                                    break;
                                //6.1
                                //6.2 Preposiciones
                                case 51:

                                    //array para traducir el campo de caso, que al ser un entero se tiene que corresponder con un string
                                    $kasus = array(get_string('acusativo','vocabulario'),get_string('dativo','vocabulario'),get_string('acudat','vocabulario'),get_string('genitivo','vocabulario'));

                                    $arrayAux1 = array();
                                    for($ind=0; $ind<count($descripcion_troceada)-2; $ind+=4){
                                        $arrayAux1[]=$descripcion_troceada[$ind].'&'.$descripcion_troceada[$ind+1].'&'.$descripcion_troceada[$ind+2].'&'.$descripcion_troceada[$ind+3];
                                    }

                                    //se ordena el array
                                    sort($arrayAux1);

                                    $arrayAux = array();
                                    foreach($arrayAux1 as $cosa){
                                        if($cosa[0]!='&'){
                                            $arrayAux[] = $cosa;
                                        }
                                    }

                                    

//                                    $titulillos .='<th>'.get_string('beisp','vocabulario').'</th>';

                                    //si hay filas que mostrar las pinamos, en caso contrario solo se verá la cabecera de la tabla.
                                    $salidor = false;
                                    $anterior='';
                                    for ($j=0;$j<count($arrayAux) && $salidor==false;$j++) {
                                        $desc_aux = explode('&',$arrayAux[$j]);
                                        if(!$desc_aux[0]) {
                                            $salidor = true;
                                        }else{

                                            $pdf->setLeftMargin(MARGIN);
                                            $pdf->SetTextColor(TEXT_WHITE);
                                            $pdf->SetFillColor(59, 89, 152); //#3B5998 Azul oscuro
                                            $pdf->setLineWidth(0.3);
                                            //cabeceras
                                            $pdf->SetFont('','B',10);

                                            //titulillos de la tabla

                                            if($desc_aux[0]!=$anterior){
                                                if($anterior!=''){
                                                    $pdf->Ln();
                                                    $pdf->Ln();
                                                }

                                                $pdf->Cell(25,5,get_string('praposit','vocabulario'),1,0,'C',1);
                                                $pdf->SetTextColor(TEXT_AUTO);
                                                $pdf->Cell(25,5,$desc_aux[0],0,1,'C',0);
                                                $anterior = $desc_aux[0];
                                            }

                                            $pdf->Cell(25,3,'',0,1,'C',0);

                                            $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito
                                            $pdf->SetTextColor(TEXT_AUTO);

                                            
//                                            $pdf->SetTextColor(TEXT_WHITE);
                                            $pdf->SetFont('','B',10);
                                            $pdf->Cell(18,5,get_string('func','vocabulario'),'LT',0,'L',1);
                                            $pdf->SetTextColor(TEXT_AUTO);
                                            $pdf->SetFont('','',10);
                                            $pdf->Cell(172,5,$desc_aux[1],'TR',1,'L',0);

//                                            $pdf->SetTextColor(TEXT_WHITE);
                                            $pdf->SetFont('','B',10);
                                            $pdf->Cell(18,5,get_string('kas','vocabulario'),'L',0,'L',1);
                                            $pdf->SetTextColor(TEXT_AUTO);
                                            $pdf->SetFont('','',10);
                                            $pdf->Cell(172,5,$kasus[$desc_aux[2]],'R',1,'L',0);

//                                            $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito
//                                            $pdf->SetTextColor(TEXT_WHITE);
                                            $pdf->SetFont('','B',10);
                                            $pdf->Cell(18,5,get_string('beisp','vocabulario'),'LB',0,'L',1);
                                            $pdf->SetTextColor(TEXT_AUTO);
                                            $pdf->SetFont('','',10);
                                            $pdf->MultiCell(172, 5, $desc_aux[3], 'BR', 'L', 0);





                                            /*
                                             * Opción estetica 1
                                             *
                                            if($desc_aux[0]!=$anterior){
                                                $pdf->Ln();
                                                $pdf->Cell(25,5,get_string('praposit','vocabulario'),1,0,'C',1);
                                                $pdf->SetTextColor(TEXT_AUTO);
                                                $pdf->Cell(25,5,$desc_aux[0],0,1,'C',0);
                                                $anterior = $desc_aux[0];
                                                
                                                $pdf->SetTextColor(TEXT_WHITE);
//                                                $pdf->Cell(25,3,'',0,1,'C',0);
                                                $pdf->Cell(150,5,get_string('func','vocabulario'),1,0,'C',1);
                                                $pdf->Cell(40,5,get_string('kas','vocabulario'),1,1,'C',1);
                                                $pdf->Cell(25,3,'',0,1,'C',0);

                                            }

                                            

                                            $pdf->SetTextColor(TEXT_AUTO);
                                            //cabeceras
                                            $pdf->SetFont('','',10);
                                            //filas
//                                            $pdf->Cell(25,5,$desc_aux[0],1,0,'C',0);
                                            $pdf->Cell(150,5,$desc_aux[1],1,0,'C',0);
                                            $pdf->Cell(40,5,$kasus[$desc_aux[2]],1,1,'C',0);

                                            $pdf->SetFillColor(189, 199, 216); //#BDC7D8 Azul clarito
                                            $pdf->SetFont('','B',10);
                                            $pdf->Cell(20,5,get_string('beisp','vocabulario'),1,0,'C',1);
                                            $pdf->SetFont('','',10);
                                            $pdf->MultiCell(165, 5, $desc_aux[3], 0, 'L', 0);
                                            $pdf->Cell(40,3,'',0,1,'C',0);
                                            */

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
                        $pdf->SetFont('', 'B', '10');
                        $pdf->Cell(47, 5, get_string('atencion_may', 'vocabulario'), 1, 1, 'C', 1);
                        $pdf->SetTextColor(TEXT_AUTO);
                        $pdf->SetFont('', '', '10');
                        $pdf->MultiCell(170, 5, $descripcion_troceada[count($descripcion_troceada)-2], 1, 'L', 0);
                        $pdf->Ln();
                        $pdf->SetTextColor(TEXT_WHITE);
                        $pdf->SetFont('', 'B', '10');
                        $pdf->Cell(47, 5, get_string('miraren', 'vocabulario'), 1, 1, 'C', 1);
                        $pdf->SetTextColor(TEXT_AUTO);
                        $pdf->SetFont('', '', '10');
                        $pdf->MultiCell(170, 5, $descripcion_troceada[count($descripcion_troceada)-1], 1, 'L',0);

                        $pdf->setLeftMargin(MARGIN);

                        $pdf->Ln();
                    }
                }
            }
        }
    }
}


if($impr_tipol == 1){
    //tipologías textuales
    $tipologias = new Vocabulario_mis_tipologias();
    $todas = $tipologias->obtener_todas($USER->id);
    //nueva pagina para las tipologias
    $pdf->AddPage();
    $pdf->writeHTMLCell(0, 0, 50, 100, '<h1>TIPOLOG&iacute;AS TEXTUALES</h1>', 0, 1, 0);
    $pdf->AddPage();
    
    foreach ($todas as $cosa){
        $descripcion_troceada = explode('&', $cosa->descripcion);
        //imprimo el nombre de la gramatica
        $pdf->AddPage();
        $tt = new Vocabulario_tipologias();
        $tt->leer($cosa->tipoid, $USER->id);
        $mtt = $tt->get('palabra');
        $pdf->SetTextColor(0);
        $pdf->SetFont('', 'B', '12');
        $pdf->Cell(0, 5, $mtt, 0, 1, 'L', 0);

        $pdf->SetFont('', '', '10');
        $pdf->Cell(0, 10, '-' . get_string('quien', 'vocabulario'), 0, 1, 'L', 0);
        $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
        $pdf->Ln();

        $pdf->SetFont('', '', '10');
        $pdf->Cell(0, 10, '-' . get_string('finalidad', 'vocabulario'), 0, 1, 'L', 0);
        $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
        $pdf->Ln();

        $pdf->SetFont('', '', '10');
        $pdf->Cell(0, 10, '-' . get_string('a_quien', 'vocabulario'), 0, 1, 'L', 0);
        $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
        $pdf->Ln();

        $pdf->SetFont('', '', '10');
        $pdf->Cell(0, 10, '-' . get_string('medio', 'vocabulario'), 0, 1, 'L', 0);
        $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
        $pdf->Ln();

        $pdf->SetFont('', '', '10');
        $pdf->Cell(0, 10, '-' . get_string('donde', 'vocabulario'), 0, 1, 'L', 0);
        $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
        $pdf->Ln();

        $pdf->SetFont('', '', '10');
        $pdf->Cell(0, 10, '-' . get_string('cuando', 'vocabulario'), 0, 1, 'L', 0);
        $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
        $pdf->Ln();

        $pdf->SetFont('', '', '10');
        $pdf->Cell(0, 10, '-' . get_string('motivo', 'vocabulario'), 0, 1, 'L', 0);
        $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
        $pdf->Ln();

        $pdf->SetFont('', '', '10');
        $pdf->Cell(0, 10, '-' . get_string('funcion', 'vocabulario'), 0, 1, 'L', 0);
        $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
        $pdf->Ln();

        $pdf->SetFont('', '', '10');
        $pdf->Cell(0, 10, '-' . get_string('sobre_que', 'vocabulario'), 0, 1, 'L', 0);
        $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
        $pdf->Ln();

        $pdf->SetFont('', '', '10');
        $pdf->Cell(0, 10, '-' . get_string('que', 'vocabulario'), 0, 1, 'L', 0);
        $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
        $pdf->Ln();

        $pdf->SetFont('', '', '10');
        $pdf->Cell(0, 10, '-' . get_string('orden', 'vocabulario'), 0, 1, 'L', 0);
        $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
        $pdf->Ln();

        $pdf->SetFont('', '', '10');
        $pdf->Cell(0, 10, '-' . get_string('medios_nonverbales', 'vocabulario'), 0, 1, 'L', 0);
        $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
        $pdf->Ln();

        $pdf->SetFont('', '', '10');
        $pdf->Cell(0, 10, '-' . get_string('que_palabras', 'vocabulario'), 0, 1, 'L', 0);
        $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
        $pdf->Ln();

        $pdf->SetFont('', '', '10');
        $pdf->Cell(0, 10, '-' . get_string('que_frases', 'vocabulario'), 0, 1, 'L', 0);
        $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
        $pdf->Ln();

        $pdf->SetFont('', '', '10');
        $pdf->Cell(0, 10, '-' . get_string('que_tono', 'vocabulario'), 0, 1, 'L', 0);
        $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
        $pdf->Ln();
    }
}
//se imprime el pdf
$pdf->AliasNbPages();
$pdf->Close();
$pdf->Output($USER->firstname . ' ' . $USER->lastname . '.pdf', 'D');
?>
