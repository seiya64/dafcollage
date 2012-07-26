<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once($CFG->dirroot.'/course/moodleform_mod.php');
require_once("ejercicios_clases.php");
/*Para poder acceder a los tipos de gramatica*/
require_once("../vocabulario/vocabulario_classes.php");
require_once("../vocabulario/lib.php");


class mod_ejercicios_mis_ejercicios extends moodleform_mod {

     function definition() {
     }
     
     function mod_ejercicios_mis_ejercicios($id)
      {
         // El fichero que procesa el formulario es gestion.php
         parent::moodleform('eliminar_carpetas_ejercicios.php?id_curso='.$id);
       }
     /**
     * Function that add a table to the forma to show the main menu
     *
     * @author Serafina Molina Soto
     * @param $id id for the course
     */
     function pintaropciones($id){
      
         
            global $CFG, $COURSE, $USER;
        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);
    
        $mform =& $this->_form;
       
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./estilos2.css">');
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>');
    	$mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="./funciones.js"></script>');
        //titulo
        $titulo= '<h2>' . get_string('MisEjercicios', 'ejercicios') . '</h2>';
        $mform->addElement('html',$titulo);
        
        //Obtengo mis ejercicios a partir de la tabla ejercicios_profesor_actividad 
        
        $ejercicios_prof = new Ejercicios_profesor_actividad();
     //   $mis_ej=$ejercicios_prof->obtener_ejercicos_del_profesor($USER->id);
        
       
        
        $mis_ej_car=$ejercicios_prof->obtener_ejercicos_del_profesor_carpeta($USER->id);
        $numcarpetas=sizeof($mis_ej_car);
        
        
     
         $carpeta='<ul id="menuaux">';
         for($i=0;$i<$numcarpetas;$i++){
        
        //imprimo la carpeta
        $carpeta.='<li><a id="classa" href="#">'.$mis_ej_car[$i]->get('carpeta').'</a><a></a>';
        $carpeta.='<ul id="classul">';
       
        
        //Para cada carpeta obtengo los ejercicios del profesor por carpetas
        
        $ejercicios_prof_carp=$ejercicios_prof->obtener_ejercicos_del_profesor_por_carpetas($USER->id,$mis_ej_car[$i]->get('carpeta'));
        $numejercicios_prof_carp=sizeof($ejercicios_prof_carp);
       
         for($j=0;$j<$numejercicios_prof_carp;$j++){
        
            $general = new Ejercicios_general();
            $id_ejercicio=$ejercicios_prof_carp[$j]->get('id_ejercicio');
         
            $mi_ejercicio=$general->obtener_uno($id_ejercicio);
            
            $nombre_ejercicio=$mi_ejercicio->get('name');
            //Añado un enlace por cada ejercicio dentro de la carpeta
           
            $carpeta.='<li><a id="classa" href="./view.php?opcion=8&id='.$id.'&id_ejercicio='.$id_ejercicio.'">'. $nombre_ejercicio.'</a><a href="eliminar_carpetas_ejercicios.php?id_curso='.$id.'&id_ejercicio='.$id_ejercicio.'""><img src="./imagenes/delete.gif"/></a></li>';
                
            
            
         }
        $carpeta.='</ul>';
        $carpeta.='</li>';
     
  
      
        
         }
         
           $carpeta.='</ul>';
           
           
        $mform->addElement('html',$carpeta);
        
           
          //Pinto los botones
           $buttonarray = array();
           $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('Reset','ejercicios'));
          // $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('BotonCorregir','ejercicios'));
           $mform->addGroup($buttonarray, 'botones', '', array(' '), false);
        
     }
}
?>
