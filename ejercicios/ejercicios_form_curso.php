<?php //$Id: mod_form.php,v 1.2.2.3 2009/03/19 12:23:11 mudrd8mz Exp $

/**
 * This file defines the main ejercicios configuration form
 * It uses the standard core Moodle (>1.8) formslib. For
 * more info about them, please visit:
 *
 * http://docs.moodle.org/en/Development:lib/formslib.php
 *
 * The form must provide support for, at least these fields:
 *   - name: text element of 64cc max
 *
 * Also, it's usual to use these fields:
 *   - intro: one htmlarea element to describe the activity
 *            (will be showed in the list of activities of
 *             ejercicios type (index.php) and in the header
 *             of the ejercicios main page (view.php).
 *   - introformat: The format used to write the contents
 *             of the intro field. It automatically defaults
 *             to HTML when the htmleditor is used and can be
 *             manually selected if the htmleditor is not used
 *             (standard formats are: MOODLE, HTML, PLAIN, MARKDOWN)
 *             See lib/weblib.php Constants and the format_text()
 *             function for more info
 */

require_once($CFG->dirroot.'/course/moodleform_mod.php');
require_once("ejercicios_clases.php");
require_once("ejercicios_clase_general.php");

/* Formulario generico de ejercicos de cualquier tipo de actidad
 * @author Serafina Molina Soto
 * Multichoice con sus variantes 1
 * Asocicacion simple 2
 * Asociacion complejo 3
 */


class mod_ejercicios_curso extends moodleform_mod{

    function mod_ejercicios_curso($id)
        {
         // El fichero que procesa el formulario es gestion.php
         parent::moodleform('ejercicios_buscar.php?id_curso='.$id);
       }
       
     function definition() {
        
     }
     
   
     /**
     * Function that add a table to the forma to show the main menu
     *
     * @author Serafina Molina Soto
     * @param $id id for the course
     */
     function pintarejercicios($id){
       
        
        global $CFG, $COURSE, $USER;
          
        $mform = & $this->_form;
       
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./estilos2.css">');
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>');
    	$mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="./funciones.js"></script>');
 
        //titulo
        $titulo= '<h2>' . get_string('EjerciciosCurso', 'ejercicios') . '</h2>';
        $mform->addElement('html',$titulo);
   

         $ejercicios_curso = new Ejercicios_general();
         $todos_ejer_curso= array();
         $todos_ejer_curso=$ejercicios_curso->obtener_ejercicios_curso($id);
         $numeroencontrados= sizeof($todos_ejer_curso);
        
         echo $numeroencontrados;
        
         for($i=0;$i<$numeroencontrados;$i++){
   
     
           $carpeta.='<ul id="classul">';

            $nombre_ejercicio= $todos_ejer_curso[$i]->get('name');
            //Añado un enlace por cada ejercicio dentro de la carpeta
            $id_ejercicio=$todos_ejer_curso[$i]->get('id');
            $carpeta.='<li style="width:750px;"><a id="classa" href="./view.php?opcion=8&id='.$id.'&id_ejercicio='.$id_ejercicio.'">'. $nombre_ejercicio.'</a></li>';
                
            
            
         }
        $carpeta.='</ul>';
        $carpeta.='</li>';

        $carpeta.='</ul>';
           
           
        $mform->addElement('html',$carpeta);
        
           //boton para irme al menú principal
          //Pinto los botones
           $buttonarray = array();
           $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('Reset','ejercicios'));
       
           $mform->addGroup($buttonarray, 'botones', '', array(' '), false);
     }
}

