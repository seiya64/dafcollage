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

class mod_ejercicios_curso extends moodleform_mod {

    function mod_ejercicios_curso($id) {
        // El fichero que procesa el formulario es gestion.php
        parent::moodleform('ejercicios_buscar.php?id_curso=' . $id);
    }

    function definition() {
        
    }

    /**
     * Function that add a table to the forma to show the main menu
     *
     * @author Serafina Molina Soto
     * @param $id id for the course
     */
    function pintarejercicios($id) {

        echo 'Modificado por Borja Arroba: codigo obsoleto'
        . ' Esta funcion pertenece a una clase que solo tiene esta funcion, si aparece este mensaje es que se esta usando en otra parte del programa que no he detectado'
        . ' paso este metodo al archivo: ejercicios_form_buscar.php metodo: mostrar_ejercicios_alumno($id)';
                    
        die();
        global $CFG, $COURSE, $USER;

        $mform = & $this->_form;

        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./estilos2.css">');
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="./funciones.js"></script>');

        //titulo
        $titulo = '<h2>' . get_string('EjerciciosCurso', 'ejercicios') . '</h2>';
        $mform->addElement('html', $titulo);


        $ejercicios_curso = new Ejercicios_general();
        
        $camposBusqueda=array();
        $camposBusqueda["id_curso"]=$id;
        
        $todos_ejer_curso = $ejercicios_curso->buscar_ejercicios($camposBusqueda);
        $numeroencontrados = sizeof($todos_ejer_curso);



        for ($i = 0; $i < $numeroencontrados; $i++) {


            $carpeta.='<ul id="classul">';

            $nombre_ejercicio = $todos_ejer_curso[$i]->get('name');
            //Añado un enlace por cada ejercicio dentro de la carpeta
            $id_ejercicio = $todos_ejer_curso[$i]->get('id');

            //Propuesta de codigo por Angel Biedma
            $tipo_creacion = $todos_ejer_curso[$i]->get('tipoactividad');
            switch ($tipo_creacion) {
                case 0: //Multiple Choice
                case 4: //Identificar elementos

                    $carpeta.='<li style="width:750px;"><a id="classa" href="./view.php?opcion=8&id=' . $id . '&id_ejercicio=' . $id_ejercicio . '&buscar=1&tipocreacion=' . $tipo_creacion . '">' . $nombre_ejercicio . '</a></li>';
                    break;
                case 1: // Asociacion simple
                case 2: // Asociacion multiple
                case 3: // Texto Hueco
                case 7: // Ordenar Elementos
                case 8: // IE mas RC
                    $carpeta.='<li style="width:750px;"><a id="classa" href="./view.php?opcion=8&id=' . $id . '&id_ejercicio=' . $id_ejercicio . '&buscar=1&tipo_origen=' . $todos_ejer_curso[$i]->get('tipoarchivopregunta') . '&tr=' . $todos_ejer_curso[$i]->get('tipoarchivorespuesta') . '&tipocreacion=' . $todos_ejer_curso[$i]->get('tipoactividad') . '">' . $nombre_ejercicio . '</a></li>';
                    break;
            }
        }
        $carpeta.='</ul>';
        $carpeta.='</li>';

        $carpeta.='</ul>';


        $mform->addElement('html', $carpeta);

        //boton para irme al menú principal
        //Pinto los botones
        $buttonarray = array();
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('Reset', 'ejercicios'));

        $mform->addGroup($buttonarray, 'botones', '', array(' '), false);
    }

}
