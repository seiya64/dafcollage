<?php //$Id: mod_form.php,v 1.2.2.3 2009/03/19 12:23:11 mudrd8mz Exp $

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
  Serafina Molina Soto (finamolinasoto@gmail.com)
 
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
  GNU General Public License for more details. */

require_once($CFG->dirroot.'/course/moodleform_mod.php');

class mod_ejercicios_mod_form extends moodleform_mod {

    function definition() {

        global $COURSE;
        $mform =& $this->_form;

//-------------------------------------------------------------------------------
    /// Adding the "general" fieldset, where all the common settings are showed
        $mform->addElement('header', 'general', get_string('general', 'form'));

    /// Adding the standard "name" field
        $mform->addElement('text', 'name', get_string('ejerciciosname', 'ejercicios'), array('size'=>'64'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');

    /// Adding the required "intro" field to hold the description of the instance
        $mform->addElement('htmleditor', 'intro', get_string('ejerciciosintro', 'ejercicios'));
        $mform->setType('intro', PARAM_RAW);
        $mform->addRule('intro', get_string('required'), 'required', null, 'client');
        $mform->setHelpButton('intro', array('writing', 'richtext'), false, 'editorhelpbutton');

    /// Adding "introformat" field
        $mform->addElement('format', 'introformat', get_string('format'));

//-------------------------------------------------------------------------------
    /// Adding the rest of ejercicios settings, spreeading all them into this fieldset
    /// or adding more fieldsets ('header' elements) if needed for better logic
        $mform->addElement('static', 'label1', 'ejerciciossetting1', 'Your ejercicios fields go here. Replace me!');

        $mform->addElement('header', 'ejerciciosfieldset', get_string('ejerciciosfieldset', 'ejercicios'));
        $mform->addElement('static', 'label2', 'ejerciciossetting2', 'Your ejercicios fields go here. Replace me!');

//-------------------------------------------------------------------------------
        // add standard elements, common to all modules
        $this->standard_coursemodule_elements();
//-------------------------------------------------------------------------------
        // add standard buttons, common to all modules
        $this->add_action_buttons();

    }
}

class COSA extends moodleform_mod {
    function  definition(){
        echo 'hola';
        $mform = & $this->_form;
        $mform -> addElement("html","<p>pepe</p>");
    }
}



/**
 * Class to create a form that is the GUI for the main menu.
 *
 * @author Fco. Javier Rodríguez López
 *
 */
class mod_ejercicios_opciones_form extends moodleform {

    function definition() {
        
    }

    /**
     * Function that add a table to the forma to show the main menu
     *
     * @author Serafina Molina Soto
     * @param $id id for the course
     *
     */
    function aniadircosas($id) {
        global $CFG, $COURSE, $USER;
        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);

        //Los iconos están sacados del tema de gnome que viene con ubuntu 11.04
    
        $mform = & $this->_form;
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./estilo.css">');
        $tabla_menu = '<div id="viewcanvas" class="boxaligncenter"><div class="menu left flexible generaltable cajagranancho" style="text-align:center;">';
  
  
        $tabla_menu .='<div class="menurow"><div class="menuitem left" style="text-align:left"><a href="view.php?id=' . $id . '&opcion=1"><img src="./imagenes/ej1.png" id="id_guardar_im" name="guardar_im"/><div class="texto">' . get_string('Puzzledoble', 'ejercicios') . '</div></a></div>';
       
        $tabla_menu .='</div>';
        
        $Mitwitter = "<script charset=\"utf-8\" src=\"http://widgets.twimg.com/j/2/widget.js\"></script><script>
            new TWTR.Widget({
              version: 2,
              type: 'profile',
              rpp: 6,
              interval: 30000,
              width: 250,
              height: 300,
              theme: {
                shell: {
                  background: '#3b5898',
                  color: '#ffffff'
                },
                tweets: {
                  background: '#ffffff',
                  color: '#000000',
                  links: '#3b5898'
                }
              },
              features: {
                scrollbar: false,
                loop: false,
                live: false,
                behavior: 'all'
              }
            }).render().setUser('dafcollage').start();
            </script>";
        $tabla_menu .='<div class="right twitter">'.$Mitwitter.'</div>';

        $tabla_menu .='</div>';

        
        $mform->addElement('html', $tabla_menu);
        
     
    }

}

class  mod_ejercicios_hacer_ej1 extends moodleform {

    function definition() {

        
    }
    
    /**
     * Function that add a table to the forma to show the main menu
     *
     * @author Serafina Molina Soto
     * @param $id id for the course
     *
     */
    function pintarcosas() {
        
        global $USER;

        $mform = & $this->_form;

      
        //botones
        $buttonarray = array();
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('Aceptar','ejercicios'));
        $buttonarray[] = &$mform->createElement('cancel', 'cancelbutton', get_string('Cancelar', 'ejercicios'));
        $mform->addGroup($buttonarray, 'botones', '', array(' '), false);
        
        
    }

}

?>
