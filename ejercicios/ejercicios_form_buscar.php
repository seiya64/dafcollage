<?php

//$Id: mod_form.php,v 1.2.2.3 2009/03/19 12:23:11 mudrd8mz Exp $

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
  Javier Castro Fernández (havidarou@gmail.com)
  Borja Arroba Hernández (b.arroba.h@gmail.com)
  Carlos Aguilar Miguel (cagmiteleco@gmail.com)

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
require_once($CFG->dirroot . '/course/moodleform_mod.php');
require_once("ejercicios_clases.php");
require_once("ejercicios_clase_general.php");

/* Formulario generico de ejercicos de cualquier tipo de actidad
 * @author Serafina Molina Soto
 * Multichoice con sus variantes 1
 * Asocicacion simple 2
 * Asociacion complejo 3
 */

class mod_ejercicios_mostrar_ejercicios_buscados extends moodleform_mod {

    function mod_ejercicios_mostrar_ejercicios_buscados($id) {
        // El fichero que procesa el formulario es gestion.php
        parent::moodleform('ejercicios_buscar.php?id_curso=' . $id);
    }

    function definition() {
        
    }

    /**
     * Muestra los ejercicios segun los criterios de busqueda pasados por parametro que sean publicos
     * @author Serafina Molina Soto, Borja Arroba, Carlos Aguilar
     * @param int $id id de la instancia del curso
     *        int $ccl Campo Tematico
     *        int $cta Tipo de Actividad
     *        int $cdc Destreza Comunicativa
     *        int $cgr Tema Gramatical
     *        int $cic Intencion Comunicativa
     *        int $ctt Tipologia Textual
     */
    function mostrar_ejercicios_buscados($id, $ccl, $cta, $cdc, $cgr, $cic, $ctt) {
        $mform = & $this->_form;
        global $COURSE, $USER;

        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./estilos2.css">');
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="./funciones.js"></script>');

        //titulo
        $titulo = '<h2>' . get_string('MiBusqueda', 'ejercicios') . '</h2>';
        $mform->addElement('html', $titulo);

        //clasificación por tipo de ejercicio
        //le resto 2 ya que el primero es -- y select
        $cta = $cta - 2;

        //clasificación por destreza comunicativa
        //le resto 2 ya que el primero es -- y select
        $cdc = $cdc - 2;

        //clasificación por tipologia textual
        //le sumo 1 puesto que en la tabla los id comienzan por 1 y el primero es --
        $ctt = $ctt + 1;

        $ejercicios_general = new Ejercicios_general();

        //Borja Arroba: Este if-else es una autentica brutalidad para cada posibilidad 
        //llama a un metodo distinto en la clase Ejercicios_general del archivo ejercicios_clase_general.php
        //lo sustituyo por un metodo (buscar_ejercicio(array)) que pasandole un array crea una 
        //consulta sql dinamicamente en funcion de los campos que le llega del array

        /**
          if ($cta >= 0) {//Si he seleccionado el tipo de actividad
          if ($ccl > 1) { //Si he seleccionado alguna opcion de campo temático
          if ($cdc >= 0) { //Si he seleccionado alguna opción de destreza
          if ($cgr > 1) {//Si he seleccionado alguna opción de tema gramatical
          if ($cic > 1) {//Si he seleccionado alguna opción intencion comunicativa
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_todas_clasificaciones($ccl, $cta, $cdc, $cgr, $cic, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_tt($ccl, $cta, $cdc, $cgr, $cic);
          }
          } else {
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_clasif_sin_ic($ccl, $cta, $cdc, $cgr, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_ic_tt($ccl, $cta, $cdc, $cgr);
          }
          }
          } else {

          if ($cic > 1) {//Si he seleccionado alguna opción intencion comunicativa
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_sin_gr($ccl, $cta, $cdc, $cic, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_gr_tt($ccl, $cta, $cdc, $cic);
          }
          } else {
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_clasif_sin_gr_ic($ccl, $cta, $cdc, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_gr_ic_tt($ccl, $cta, $cdc);
          }
          }
          }
          } else {

          if ($cgr > 1) {//Si he seleccionado alguna opción de tema gramatical
          if ($cic > 1) {//Si he seleccionado alguna opción intencion comunicativa
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->clasif_sin_dc($ccl, $cta, $cgr, $cic, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_dc_tt($ccl, $cta, $cgr, $cic);
          }
          } else {
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_clasif_sin_dc_ic($ccl, $cta, $cgr, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_dc_ic_tt($ccl, $cta, $cgr);
          }
          }
          } else {

          if ($cic > 1) {//Si he seleccionado alguna opción intencion comunicativa
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_sin_dc_gr($ccl, $cta, $cic, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_dc_gr_tt($ccl, $cta, $cic);
          }
          } else {
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_clasif_sin_dc_gr_ic($ccl, $cta, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_dc_gr_ic_tt($ccl, $cta);
          }
          }
          }
          }
          } else {
          if ($cdc >= 0) { //Si he seleccionado alguna opción de destreza
          if ($cgr > 1) {//Si he seleccionado alguna opción de tema gramatical
          if ($cic > 1) {//Si he seleccionado alguna opción intencion comunicativa
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_clasif_sin_cl($cta, $cdc, $cgr, $cic, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_cl_tt($cta, $cdc, $cgr, $cic);
          }
          } else {
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_clasif_sin_cl_ic($cta, $cdc, $cgr, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_cl_ic_tt($cta, $cdc, $cgr);
          }
          }
          } else {

          if ($cic > 1) {//Si he seleccionado alguna opción intencion comunicativa
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_sin_cl_gr($cta, $cdc, $cic, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_cl_gr_tt($cta, $cdc, $cic);
          }
          } else {
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_clasif_sin_cl_gr_ic($cta, $cdc, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_cl_gr_ic_tt($cta, $cdc, $USER->id);
          }
          }
          }
          } else {

          if ($cgr > 1) {//Si he seleccionado alguna opción de tema gramatical
          if ($cic > 1) {//Si he seleccionado alguna opción intencion comunicativa
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_clasif_sin_cl_dc($cta, $cgr, $cic, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_cl_dc_tt($cta, $cgr, $cic);
          }
          } else {
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_clasif_sin_cl_dc_ic($cta, $cgr, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_cl_dc_ic_tt($cta, $cgr);
          }
          }
          } else {

          if ($cic > 1) {//Si he seleccionado alguna opción intencion comunicativa
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_sin_cl_dc_gr($cta, $cic, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_cl_dc_gr_tt($cta, $cic);
          }
          } else {
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_clasif_sin_cl_dc_gr_ic($cta, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_cl_dc_gr_ic_tt($cta);
          }
          }
          }
          }
          }
          } else {

          if ($ccl > 1) { //Si he seleccionado alguna opcion de campo temático
          if ($cdc >= 0) { //Si he seleccionado alguna opción de destreza
          if ($cgr > 1) {//Si he seleccionado alguna opción de tema gramatical
          if ($cic > 1) {//Si he seleccionado alguna opción intencion comunicativa
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_sin_ta($ccl, $cdc, $cgr, $cic, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_ta_tt($ccl, $cdc, $cgr, $cic);
          }
          } else {
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_clasif_sin_ta_ic($ccl, $cdc, $cgr, $ctt);
          } else {

          $buscados = $ejercicios_general->buscar_clasif_sin_ta_ic_tt($ccl, $cdc, $cgr);
          }
          }
          } else {

          if ($cic > 1) {//Si he seleccionado alguna opción intencion comunicativa
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_sin_ta_gr($ccl, $cdc, $cic, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_ta_gr_tt($ccl, $cdc, $cic);
          }
          } else {
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_clasif_sin_ta_gr_ic($ccl, $cdc, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_ta_gr_ic_tt($ccl, $cdc);
          }
          }
          }
          } else {

          if ($cgr > 1) {//Si he seleccionado alguna opción de tema gramatical
          if ($cic > 1) {//Si he seleccionado alguna opción intencion comunicativa
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->clasif_sin_ta_dc($ccl, $cgr, $cic, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_ta_dc_tt($ccl, $cgr, $cic);
          }
          } else {
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_clasif_sin_ta_dc_ic($ccl, $cgr, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_ta_dc_ic_tt($ccl, $cgr);
          }
          }
          } else {

          if ($cic > 1) {//Si he seleccionado alguna opción intencion comunicativa
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_sin_ta_dc_gr($ccl, $cic, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_ta_dc_gr_tt($ccl, $cic);
          }
          } else {
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_clasif_sin_ta_dc_gr_ic($ccl, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_ta_dc_gr_ic_tt($ccl);
          }
          }
          }
          }
          } else {

          if ($cdc >= 0) { //Si he seleccionado alguna opción de destreza
          if ($cgr > 1) {//Si he seleccionado alguna opción de tema gramatical
          if ($cic > 1) {//Si he seleccionado alguna opción intencion comunicativa
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_clasif_sin_ta_cl($cdc, $cgr, $cic, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_ta_cl_tt($cdc, $cgr, $cic);
          }
          } else {

          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_clasif_sin_ta_cl_ic($cdc, $cgr, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_ta_cl_ic_tt($cdc, $cgr);
          }
          }
          } else {

          if ($cic > 1) {//Si he seleccionado alguna opción intencion comunicativa
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_sin_ta_cl_gr($cdc, $cic, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_ta_cl_gr_tt($cdc, $cic);
          }
          } else {
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_clasif_sin_ta_cl_gr_ic($cdc, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_ta_cl_gr_ic_tt($cdc, $USER->id);
          }
          }
          }
          } else {

          if ($cgr > 1) {//Si he seleccionado alguna opción de tema gramatical
          if ($cic > 1) {//Si he seleccionado alguna opción intencion comunicativa
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_clasif_sin_ta_cl_dc($cgr, $cic, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_ta_cl_dc_tt($cgr, $cic);
          }
          } else {
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_clasif_sin_ta_cl_dc_ic($cgr, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_ta_cl_dc_ic_tt($cgr);
          }
          }
          } else {

          if ($cic > 1) {//Si he seleccionado alguna opción intencion comunicativa
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_sin_ta_cl_dc_gr($cic, $ctt);
          } else {
          $buscados = $ejercicios_general->buscar_clasif_sin_ta_cl_dc_gr_tt($cic);
          }
          } else {
          if ($ctt > 1) {//Si he seleccionado alguna opción de tipologia textual
          $buscados = $ejercicios_general->buscar_clasif_sin_ta_cl_dc_gr_ic($ctt);
          } else {
          //no hay criterio de busqueda
          }
          }
          }
          }
          }
          }
         * 
         * 
         */
        //Tengo que añadir los campos de la busqueda asi por que cada uno empieza por donde le da la gana
        $camposBusqueda = array();
        if ($ccl >= 2) {
            $camposBusqueda["campotematico"] = $ccl;
        }
        if ($cta >= 0) {
            $camposBusqueda["tipoactividad"] = $cta;
        }
        if ($cdc >= 0) {
            $camposBusqueda["destreza"] = $cdc;
        }
        if ($cgr >= 2) {
            $camposBusqueda["temagramatical"] = $cgr;
        }
        if ($cic >= 2) {
            $camposBusqueda["intencioncomunicativa"] = $cic;
        }
        if ($ctt >= 2) {
            $camposBusqueda["tipologiatextual"] = $ctt;
        }
        
        //Obtengo el rol del usuario que esta buscando, si es estudiante añado a los campos de busqueda visible=1 y curso=curso del alumno
        $context = get_context_instance(CONTEXT_COURSE,$COURSE->id);

        if (has_capability('moodle/legacy:student', $context, $USER->id, false) ) {
            $camposBusqueda["visible"] = 1;
            $camposBusqueda["id_curso"] = $id;
        }
        
        //Añado este campo por que desde aqui unicamente pueden verse los ejercicios que sean publicos
        $camposBusqueda["publico"] = 1;
        $buscados = $ejercicios_general->buscar_ejercicios($camposBusqueda);

        $lista = $this->listar_ejercicios($id, $buscados);

        $mform->addElement('html', $lista);

        //boton para irme al menú principal
        //Pinto los botones
        $buttonarray = array();
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('Reset', 'ejercicios'));

        $mform->addGroup($buttonarray, 'botones', '', array(' '), false);
    }

    /**
     * Muestra los ejercicios del curso donde esta inscrito el alumno
     * @author Serafina Molina Soto, Borja Arroba, Carlos Aguilar
     * @param int $id id de la instancia del curso
     */
    function mostrar_ejercicios_alumno($id) {
        $mform = & $this->_form;

        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./estilos2.css">');
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="./funciones.js"></script>');

        //titulo
        $titulo = '<h2>' . get_string('EjerciciosCurso', 'ejercicios') . '</h2>';
        $mform->addElement('html', $titulo);

        $ejercicios_curso = new Ejercicios_general();
        //Creo el array para la busqueda de ejercicios. Desde aqui se muestran los ejercicios que son del curso al que pertenece el alumno y que sean visibles
        $camposBusqueda["id_curso"] = $id;
        $camposBusqueda["visible"] = 1;

        $todos_ejer_curso = $ejercicios_curso->buscar_ejercicios($camposBusqueda);
        $lista = $this->listar_ejercicios($id, $todos_ejer_curso);

        $mform->addElement('html', $lista);

        //boton para irme al menú principal
        $buttonarray = array();
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('Reset', 'ejercicios'));

        $mform->addGroup($buttonarray, 'botones', '', array(' '), false);
    }

    /**
     * Muestra los ejercicios que ha creado el profesor
     * @author Serafina Molina Soto, Borja Arroba, Carlos Aguilar
     * @param   $id id de la instancia del curso
     */
    function mostrar_ejercicios_profesor($id) {
        global $USER;
        $mform = & $this->_form;

        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./estilos2.css">');
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="./funciones.js"></script>');

        //titulo
        $titulo = '<h2>' . get_string('MisEjercicios', 'ejercicios') . '</h2>';
        $mform->addElement('html', $titulo);

        //Obtengo mis ejercicios a partir de la tabla ejercicios_profesor_actividad 
        $ejercicios_prof = new Ejercicios_prof_actividad();
        $mis_ej_car = $ejercicios_prof->obtener_ejercicios_del_profesor_carpeta($USER->id);
        $numcarpetas = sizeof($mis_ej_car);

        $carpeta = '<ul id="menuaux">';
        for ($i = 0; $i < $numcarpetas; $i++) {
            //imprimo la carpeta
            $carpeta.='<li><a id="classa" href="#">' . $mis_ej_car[$i]->get('carpeta') . '</a><a></a>';
            //Para cada carpeta obtengo los ejercicios del profesor por carpetas
            $ejercicios_prof_carp = $ejercicios_prof->obtener_ejercicos_del_profesor_por_carpetas($USER->id, $mis_ej_car[$i]->get('carpeta'));

            //creo la lista de ejercicios para mostrar
            $listaEjercicios = array();
            for ($j = 0; $j < sizeof($ejercicios_prof_carp); $j++) {
                $general = new Ejercicios_general();
                $listaEjercicios[] = $general->obtener_uno($ejercicios_prof_carp[$j]->get('id_ejercicio'));
            }
            //Se añade la lista de los ejercicios a mostrar
            $lista = $this->listar_ejercicios($id, $listaEjercicios);
            $carpeta.=$lista;
            $carpeta.='</li>';
        }
        $carpeta.='</ul>';
        $mform->addElement('html', $carpeta);

        //Pinto los botones
        $buttonarray = array();
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('Reset', 'ejercicios'));
        $mform->addGroup($buttonarray, 'botones', '', array(' '), false);
    }

    /**
     * Crea la lista de los ejercicios que se van a mostrar como una lista no ordenada
     * @author Borja Arroba Hernández
     * @param array $ejercicios Lista de los ejercicios a mostrar
     *        int   $id id de la instancia del curso
     * @return string Código html con una lista sin ordenar con los ejercicios a mostrar
     */
    function listar_ejercicios($id, $ejercicios) {
        $numeroencontrados = sizeof($ejercicios);
        $html.='<ul id="classul">';

        for ($i = 0; $i < $numeroencontrados; $i++) {
            $nombre_ejercicio = $ejercicios[$i]->get('name');
            $id_ejercicio = $ejercicios[$i]->get('id');
            $tipo_creacion = $ejercicios[$i]->get('tipoactividad');
            $id_creador = $ejercicios[$i]->get('id_creador');
            
            //Añado un enlace por cada ejercicio
            switch ($tipo_creacion) {
                case 0: //Multiple Choice
                case 4: //Identificar elementos
                    $html.='<li style="width:750px;">'
                            . '<a id="classa" '
                            . 'href="./view.php?opcion=8&id=' . $id . '&id_ejercicio=' . $id_ejercicio . '&buscar=1&tipocreacion=' . $tipo_creacion . '">' . $nombre_ejercicio;
                    break;
                case 1: // Asociacion simple
                case 2: // Asociacion multiple
                case 3: // Texto Hueco
                case 7: // Ordenar Elementos
                case 8: // IE mas RC
                    $html.='<li style="width:750px;">'
                            . '<a id="classa" '
                            . 'href="./view.php?opcion=8&id=' . $id . '&id_ejercicio=' . $id_ejercicio . '&buscar=1&tipo_origen=' . $ejercicios[$i]->get('tipoarchivopregunta') . '&tr=' . $ejercicios[$i]->get('tipoarchivorespuesta') . '&tipocreacion=' . $ejercicios[$i]->get('tipoactividad') . '">' . $nombre_ejercicio;
                    break;
            }
            $autor = get_record('user', 'id', $id_creador);
            $html.='<div>Autor: ' .$autor->firstname. ' ' .$autor->lastname. '</div>'
                    . '</a></li>';
        }
        $html.='</ul>';

        return $html;
    }

}

?>
