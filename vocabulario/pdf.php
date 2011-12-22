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

$pdf->SetTitle('Cuaderno Digital');
$pdf->SetSubject('-Todas mis palabras guardadas');

//para que no diga lo del undefined font grrrrr
$pdf->SetMargins(10, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


//Portada
$pdf->AddPage();

$pdf->writeHTMLCell(0, 0, 50, 100, '<h1>CUADERNO DIGITAL</h1>', 0, 1, 0, true);
$pdf->writeHTMLCell(0, 0, 20, 200, $USER->firstname . ' ' . $USER->lastname, 0, 1, 0, true);
$pdf->writeHTMLCell(0, 0, 20, 205, $USER->email, 0, 1, 0, true);

if($impr_vocab == 1){
    //Portada
    $pdf->AddPage();
    $pdf->writeHTMLCell(0, 0, 50, 100, '<h1>VOCABULARIO</h1>', 0, 1, 0, true);

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
            $pdf->SetTextColor(0);
            $pdf->SetFont('', 'B', '14');
            $pdf->Cell(0, 7, $mi_campo, 0, 1, 'L', 0);
            $pdf->Ln();

            //titulillos
            $pdf->SetFillColor(59, 89, 152); //#3B5998
            $pdf->SetTextColor(255);
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

    //gramaticas
    $gramaticas = new Vocabulario_gramatica();
    $gramaticas_usadas = array();
    //sacar un vector en el que cada posicion sean numero y nombre
    $gr_pal = $gramaticas->obtener_todos($usuario);
    $gr_num = $gramaticas->obtener_todos_ids($usuario);

    for ($i = 0; $i < count($gr_pal); $i++) {
        $gramaticas_usadas[$i] = array($gr_pal[$i], $gr_num[$i]);
    }
}

if($impr_gram == 1){
    //nueva pagina para las gramaticas
    $pdf->AddPage();
    $pdf->writeHTMLCell(0, 0, 50, 100, '<h1>GRAM&Aacute;TICA</h1>', 0, 1, 0, true);

    foreach ($gramaticas_usadas as $cosa) {
        $mgr = new Vocabulario_mis_gramaticas();
        $palabras = $mgr->relacionadas($USER->id, $cosa[1]);
        if ($palabras) {
            //imprimo el nombre de la gramatica
            $pdf->AddPage();
            $mi_gram = $cosa[0];
            $pdf->SetTextColor(0);
            $pdf->SetFont('', 'B', '12');
            $pdf->Cell(0, 5, $mi_gram, 0, 1, 'L', 0);
            foreach ($palabras as $palabra) {
                $descripcion_troceada = explode('&', $palabra->descripcion);
                if ($descripcion_troceada) {
                    switch ($palabra->tipo_palabra) {
                        case 'sustantivo':
                            $pal_aux = new Vocabulario_sustantivo();
                            $pal_aux->leer($palabra->palabra_id);
                            break;
                        case 'adjetivo':
                            $pal_aux = new Vocabulario_adjetivo();
                            $pal_aux->leer($palabra->palabra_id);
                            break;
                        case 'verbo':
                            $pal_aux = new Vocabulario_verbo();
                            $pal_aux->leer($palabra->palabra_id);
                            break;
                        case 'otro':
                            $pal_aux = new Vocabulario_otro();
                            $pal_aux->leer($palabra->palabra_id);
                            break;
                    }
                    $pdf->SetFillColor(255, 255, 255);
                    $pdf->SetTextColor(0);
                    $pdf->SetFont('', 'B', '10');
                    $pdf->Ln();
                    switch ($palabra->gramaticaid) {
                        //normal
                        default:
                            $pdf->SetFont('', '', '10');
                            $pdf->Cell(0, 10, '-' . get_string('beachten', 'vocabulario'), 0, 1, 'L', 0);
                            $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                            $pdf->Ln();
                            break;
                        //allgemaines
                        case 2:
                        case 7:
                        case 21:
                        case 35:
                        case 45:
                        case 53:
                        case 57:
                        case 60:
                        case 72:
                            $pdf->SetFont('', '', '10');
                            $pdf->Cell(0, 10, '-' . get_string('generales', 'vocabulario'), 0, 1, 'L', 0);
                            $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                            $pdf->Ln();
                            $pdf->Cell(0, 10, '-' . get_string('particulares', 'vocabulario'), 0, 1, 'L', 0);
                            $pdf->MultiCell(0, 5, $descripcion_troceada[1], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                            $pdf->Ln();
                            break;
                        //1.2
                        case 3:
                            $pdf->SetFont('', '', '10');
                            $pdf->Cell(0, 10, '-' . get_string('clasificacionsemantica', 'vocabulario'), 0, 1, 'L', 0);
                            $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                            $pdf->Ln();
                            $pdf->Cell(0, 10, '-' . get_string('clasificacionformal', 'vocabulario'), 0, 1, 'L', 0);
                            $pdf->MultiCell(0, 5, $descripcion_troceada[1], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                            $pdf->Ln();
                            $pdf->Cell(0, 10, '-' . get_string('clasificacionsemantica', 'vocabulario'), 0, 1, 'L', 0);
                            $pdf->MultiCell(0, 5, $descripcion_troceada[2], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                            $pdf->Ln();
                            $pdf->Cell(0, 10, '-' . get_string('clasificacionformal', 'vocabulario'), 0, 1, 'L', 0);
                            $pdf->MultiCell(0, 5, $descripcion_troceada[3], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                            $pdf->Ln();
                            $pdf->Cell(0, 10, '-' . get_string('clasificacionsemantica', 'vocabulario'), 0, 1, 'L', 0);
                            $pdf->MultiCell(0, 5, $descripcion_troceada[4], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                            $pdf->Ln();
                            $pdf->Cell(0, 10, '-' . get_string('clasificacionformal', 'vocabulario'), 0, 1, 'L', 0);
                            $pdf->MultiCell(0, 5, $descripcion_troceada[5], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                            $pdf->Ln();
                            break;
                        //1.3
                        case 4:
                            //hacer la tabla!
                            $pdf->SetFont('', '', '10');
                            $pdf->Cell(0, 10, '-' . 'Creación de la plantilla para impresión endesarrollo', 0, 1, 'L', 0);
                            $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                            $pdf->Ln();
                            break;
                        //5.3.1
                        case 48:
                            //dec1
                            $pdf->SetFont('', '', '10');
                            $pdf->SetTextColor(0);
                            $pdf->Cell(0, 10, '-' . get_string("declinacion1", "vocabulario"), 0, 1, 'L', 0);
                            //titulillos
                            $pdf->SetFillColor(59, 89, 152); //#3B5998
                            $pdf->SetTextColor(255);
                            $pdf->SetLineWidth(0.3);
                            $pdf->SetFont('', 'B', '10');
                            $pdf->Cell(47, 5, get_string('masculino', 'vocabulario'), 1, 0, 'C', 1);
                            $pdf->Cell(47, 5, get_string('femenino', 'vocabulario'), 1, 0, 'C', 1);
                            $pdf->Cell(47, 5, get_string('neutro', 'vocabulario'), 1, 0, 'C', 1);
                            $pdf->Cell(47, 5, get_string('plural', 'vocabulario'), 1, 0, 'C', 1);
                            $pdf->Ln();
                            $color = 1;
                            //tabla
                            $pdf->SetFillColor(255, 255, 255);
                            $pdf->SetTextColor(0);
                            $pdf->SetFont('', '', '8');
                            $pdf->Cell(47, 5, $descripcion_troceada[0], 'LTR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[1], 'TR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[2], 'RT', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[3], 'RT', 0, 'C', 1);
                            $pdf->Ln();
                            $pdf->SetFillColor(189, 199, 216);
                            $pdf->SetTextColor(0);
                            $pdf->SetFont('', '', '8');
                            $pdf->Cell(47, 5, $descripcion_troceada[4], 'LTR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[5], 'TR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[6], 'RT', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[7], 'RT', 0, 'C', 1);
                            $pdf->Ln();
                            $pdf->SetFillColor(255, 255, 255);
                            $pdf->SetFont('', '', '8');
                            $pdf->Cell(47, 5, $descripcion_troceada[8], 'LTR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[9], 'TR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[10], 'RT', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[11], 'RT', 0, 'C', 1);
                            $pdf->Ln();
                            $pdf->SetFillColor(189, 199, 216);
                            $pdf->SetFont('', '', '8');
                            $pdf->Cell(47, 5, $descripcion_troceada[12], 'LTRB', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[13], 'TRB', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[14], 'RTB', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[15], 'RTB', 0, 'C', 1);
                            $pdf->Ln();
                            //dec2
                            $pdf->SetFont('', '', '10');
                            $pdf->SetTextColor(0);
                            $pdf->Cell(0, 12, '-' . get_string("declinacion2", "vocabulario"), 0, 1, 'L', 0);
                            //titulillos
                            $pdf->SetFillColor(59, 89, 152); //#3B5998
                            $pdf->SetTextColor(255);
                            $pdf->SetLineWidth(0.3);
                            $pdf->SetFont('', 'B', '10');
                            $pdf->Cell(47, 5, get_string('masculino', 'vocabulario'), 1, 0, 'C', 1);
                            $pdf->Cell(47, 5, get_string('femenino', 'vocabulario'), 1, 0, 'C', 1);
                            $pdf->Cell(47, 5, get_string('neutro', 'vocabulario'), 1, 0, 'C', 1);
                            $pdf->Cell(47, 5, get_string('plural', 'vocabulario'), 1, 0, 'C', 1);
                            $pdf->Ln();
                            $color = 1;
                            //tabla
                            $pdf->SetFillColor(255, 255, 255);
                            $pdf->SetTextColor(0);
                            $pdf->SetFont('', '', '8');
                            $pdf->Cell(47, 5, $descripcion_troceada[16], 'LTR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[17], 'TR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[18], 'RT', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[19], 'RT', 0, 'C', 1);
                            $pdf->Ln();
                            $pdf->SetFillColor(189, 199, 216);
                            $pdf->SetTextColor(0);
                            $pdf->SetFont('', '', '8');
                            $pdf->Cell(47, 5, $descripcion_troceada[20], 'LTR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[21], 'TR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[22], 'RT', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[23], 'RT', 0, 'C', 1);
                            $pdf->Ln();
                            $pdf->SetFillColor(255, 255, 255);
                            $pdf->SetFont('', '', '8');
                            $pdf->Cell(47, 5, $descripcion_troceada[24], 'LTR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[25], 'TR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[26], 'RT', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[27], 'RT', 0, 'C', 1);
                            $pdf->Ln();
                            $pdf->SetFillColor(189, 199, 216);
                            $pdf->SetFont('', '', '8');
                            $pdf->Cell(47, 5, $descripcion_troceada[28], 'LTRB', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[29], 'TRB', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[30], 'RTB', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[31], 'RTB', 0, 'C', 1);
                            $pdf->Ln();
                            //dec3
                            $pdf->SetFont('', '', '10');
                            $pdf->SetTextColor(0);
                            $pdf->Cell(0, 12, '-' . get_string("declinacion3", "vocabulario"), 0, 1, 'L', 0);
                            //titulillos
                            $pdf->SetFillColor(59, 89, 152); //#3B5998
                            $pdf->SetTextColor(255);
                            $pdf->SetLineWidth(0.3);
                            $pdf->SetFont('', 'B', '10');
                            $pdf->Cell(47, 5, get_string('masculino', 'vocabulario'), 1, 0, 'C', 1);
                            $pdf->Cell(47, 5, get_string('femenino', 'vocabulario'), 1, 0, 'C', 1);
                            $pdf->Cell(47, 5, get_string('neutro', 'vocabulario'), 1, 0, 'C', 1);
                            $pdf->Cell(47, 5, get_string('plural', 'vocabulario'), 1, 0, 'C', 1);
                            $pdf->Ln();
                            $color = 1;
                            //tabla
                            $pdf->SetFillColor(255, 255, 255);
                            $pdf->SetTextColor(0);
                            $pdf->SetFont('', '', '8');
                            $pdf->Cell(47, 5, $descripcion_troceada[32], 'LTR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[33], 'TR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[34], 'RT', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[35], 'RT', 0, 'C', 1);
                            $pdf->Ln();
                            $pdf->SetFillColor(189, 199, 216);
                            $pdf->SetTextColor(0);
                            $pdf->SetFont('', '', '8');
                            $pdf->Cell(47, 5, $descripcion_troceada[36], 'LTR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[37], 'TR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[38], 'RT', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[39], 'RT', 0, 'C', 1);
                            $pdf->Ln();
                            $pdf->SetFillColor(255, 255, 255);
                            $pdf->SetFont('', '', '8');
                            $pdf->Cell(47, 5, $descripcion_troceada[40], 'LTR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[41], 'TR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[42], 'RT', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[43], 'RT', 0, 'C', 1);
                            $pdf->Ln();
                            $pdf->SetFillColor(189, 199, 216);
                            $pdf->SetFont('', '', '8');
                            $pdf->Cell(47, 5, $descripcion_troceada[44], 'LTRB', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[45], 'TRB', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[46], 'RTB', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[47], 'RTB', 0, 'C', 1);
                            $pdf->Ln();
                            break;
                        //tablas verbos
                        case 23:
                        case 24:
                        case 27:
                        case 28:
                        case 29:
                        case 30:
                        case 31:
                            //titulillos
                            $pdf->SetFillColor(59, 89, 152); //#3B5998
                            $pdf->SetTextColor(255);
                            $pdf->SetLineWidth(0.3);
                            $pdf->SetFont('', 'B', '10');
                            $pdf->Cell(47, 5, '', 1, 0, 'C', 1);
                            $pdf->Cell(47, 5, get_string('indicativo', 'vocabulario'), 1, 0, 'C', 1);
                            $pdf->Cell(47, 5, get_string('conjuntivo1', 'vocabulario'), 1, 0, 'C', 1);
                            $pdf->Ln();
                            $color = 1;
                            //tabla
                            $pdf->SetFillColor(255, 255, 255);
                            $pdf->SetTextColor(0);
                            $pdf->SetFont('', '', '8');
                            $pdf->Cell(47, 5, get_string('S1', 'vocabulario'), 'LTR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[0], 'TR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[1], 'RT', 0, 'C', 1);
                            $pdf->Ln();
                            $pdf->SetFillColor(255, 255, 255);
                            $pdf->SetTextColor(0);
                            $pdf->SetFont('', '', '8');
                            $pdf->Cell(47, 5, get_string('S2', 'vocabulario'), 'LTR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[2], 'TR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[3], 'RT', 0, 'C', 1);
                            $pdf->Ln();
                            $pdf->SetFillColor(255, 255, 255);
                            $pdf->SetTextColor(0);
                            $pdf->SetFont('', '', '8');
                            $pdf->Cell(47, 5, get_string('S3', 'vocabulario'), 'LTR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[4], 'TR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[5], 'RT', 0, 'C', 1);
                            $pdf->Ln();
                            $pdf->SetFillColor(255, 255, 255);
                            $pdf->SetTextColor(0);
                            $pdf->SetFont('', '', '8');
                            $pdf->Cell(47, 5, get_string('P1', 'vocabulario'), 'LTR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[6], 'TR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[7], 'RT', 0, 'C', 1);
                            $pdf->Ln();
                            $pdf->SetFillColor(255, 255, 255);
                            $pdf->SetTextColor(0);
                            $pdf->SetFont('', '', '8');
                            $pdf->Cell(47, 5, get_string('P2', 'vocabulario'), 'LTR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[8], 'TR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[8], 'RT', 0, 'C', 1);
                            $pdf->Ln();
                            $pdf->SetFillColor(255, 255, 255);
                            $pdf->SetTextColor(0);
                            $pdf->SetFont('', '', '8');
                            $pdf->Cell(47, 5, get_string('P3', 'vocabulario'), 'LTRB', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[10], 'TRB', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[11], 'RTB', 0, 'C', 1);
                            $pdf->Ln();
                            break;
                        //participio2
                        case 25:
                            $pdf->SetFont('', '', '10');
                            $pdf->Cell(0, 10, '-' . get_string('participio2', 'vocabulario'), 0, 1, 'L', 0);
                            $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                            $pdf->Ln();
                            $pdf->Cell(0, 10, '-' . get_string('hilfsverbs', 'vocabulario'), 0, 1, 'L', 0);
                            $pdf->MultiCell(0, 5, $descripcion_troceada[1], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                            $pdf->Ln();
                            break;
                        //participio1
                        case 26:
                            $pdf->SetFont('', '', '10');
                            $pdf->Cell(0, 10, '-' . get_string('participio1', 'vocabulario'), 0, 1, 'L', 0);
                            $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                            $pdf->Ln();
                            break;
                        //passiv
                        case 33:
                            $pdf->SetFont('', '', '10');
                            $pdf->Cell(0, 10, '-' . get_string('zustandspassiv', 'vocabulario'), 0, 1, 'L', 0);
                            $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                            $pdf->Ln();
                            $pdf->Cell(0, 10, '-' . get_string('vorganspassiv', 'vocabulario'), 0, 1, 'L', 0);
                            $pdf->MultiCell(0, 5, $descripcion_troceada[1], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                            $pdf->Ln();
                            break;
                        //articulos
                        case 36:
                        case 37:
                        case 38:
                        case 39:
                        case 40:
                        case 41:
                        //pronombres
                        case 8:
                        case 10:
                        case 16:
                        //y tambien el 1.4
                        case 5:
                            //titulillos
                            $pdf->SetFillColor(59, 89, 152); //#3B5998
                            $pdf->SetTextColor(255);
                            $pdf->SetLineWidth(0.3);
                            $pdf->SetFont('', 'B', '10');
                            $pdf->Cell(47, 5, get_string('masculino', 'vocabulario'), 1, 0, 'C', 1);
                            $pdf->Cell(47, 5, get_string('femenino', 'vocabulario'), 1, 0, 'C', 1);
                            $pdf->Cell(47, 5, get_string('neutro', 'vocabulario'), 1, 0, 'C', 1);
                            $pdf->Cell(47, 5, get_string('plural', 'vocabulario'), 1, 0, 'C', 1);
                            $pdf->Ln();
                            $color = 1;
                            //tabla
                            $pdf->SetFillColor(255, 255, 255);
                            $pdf->SetTextColor(0);
                            $pdf->SetFont('', '', '8');
                            $pdf->Cell(47, 5, $descripcion_troceada[0], 'LTR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[1], 'TR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[2], 'RT', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[3], 'RT', 0, 'C', 1);
                            $pdf->Ln();
                            $pdf->SetFillColor(189, 199, 216);
                            $pdf->SetTextColor(0);
                            $pdf->SetFont('', '', '8');
                            $pdf->Cell(47, 5, $descripcion_troceada[4], 'LTR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[5], 'TR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[6], 'RT', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[7], 'RT', 0, 'C', 1);
                            $pdf->Ln();
                            $pdf->SetFillColor(255, 255, 255);
                            $pdf->SetFont('', '', '8');
                            $pdf->Cell(47, 5, $descripcion_troceada[8], 'LTR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[9], 'TR', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[10], 'RT', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[11], 'RT', 0, 'C', 1);
                            $pdf->Ln();
                            $pdf->SetFillColor(189, 199, 216);
                            $pdf->SetFont('', '', '8');
                            $pdf->Cell(47, 5, $descripcion_troceada[12], 'LTRB', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[13], 'TRB', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[14], 'RTB', 0, 'C', 1);
                            $pdf->Cell(47, 5, $descripcion_troceada[15], 'RTB', 0, 'C', 1);
                            $pdf->Ln();
                            $pdf->SetFont('', '', '10');
                            $pdf->Cell(0, 10, '-' . get_string('beachten', 'vocabulario'), 0, 1, 'L', 0);
                            $pdf->MultiCell(0, 5, $descripcion_troceada[16], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                            $pdf->Ln();
                            break;
                        //4.8
                        case 42:
                            $pdf->SetFont('', '', '10');
                            $pdf->Cell(0, 10, '-' . get_string('lista', 'vocabulario'), 0, 1, 'L', 0);
                            $pdf->MultiCell(0, 5, $descripcion_troceada[0], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                            $pdf->Ln();
                            $pdf->Cell(0, 10, '-' . get_string('scheinbare', 'vocabulario'), 0, 1, 'L', 0);
                            $pdf->MultiCell(0, 5, $descripcion_troceada[1], 0, 'J', false, 1, '', '', true, 0, false, true, 0, '', false);
                            $pdf->Ln();
                            break;
                    }
                }
            }
        }
    }

    //tipologías textuales
    $tipologias = new Vocabulario_mis_tipologias();
    $todas = $tipologias->obtener_todas($USER->id);
}

if($impr_tipol == 1){
    //nueva pagina para las tipologias
    $pdf->AddPage();
    $pdf->writeHTMLCell(0, 0, 50, 100, '<h1>TIPOLOG&iacute;AS TEXTUALES</h1>', 0, 1, 0, true);
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
