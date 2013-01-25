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

require_once($CFG->dirroot.'/course/moodleform_mod.php');
require_once("ejercicios_clases.php");
require_once("ejercicios_clase_general.php");
/*Para poder acceder a los tipos de gramatica*/
require_once($CFG->dirroot.'/mod/vocabulario/vocabulario_classes.php');
require_once($CFG->dirroot.'/mod/vocabulario/lib.php');


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
       
        $ejercicios_prof = new Ejercicios_prof_actividad();
     //   $mis_ej=$ejercicios_prof->obtener_ejercicos_del_profesor($USER->id);
        
  
        
        $mis_ej_car=$ejercicios_prof->obtener_ejercicios_del_profesor_carpeta($USER->id);

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
           
               echo "akiiiiiiiiiiiiiiiiiiiiiii".$mi_ejercicio->get('tipoactividad');
            if($mi_ejercicio->get('tipoactividad')==0){ //multichoice
              $carpeta.='<li><a id="classa" href="./view.php?opcion=8&id='.$id.'&id_ejercicio='.$id_ejercicio.'&tipo_origen='.$mi_ejercicio->get('tipoarchivopregunta').'">'. $nombre_ejercicio.'</a><a href="eliminar_carpetas_ejercicios.php?id_curso='.$id.'&id_ejercicio='.$id_ejercicio.'""><img src="./imagenes/delete.gif"/></a></li>';

            }else{

                 if($mi_ejercicio->get('tipoactividad')==1){ //asociacion simple
                     echo "asociaciónnnnnn simpñeeee";

                     //comprubo que tipo tiene archivorespuesta
                     if($mi_ejercicio->get('tipoarchivopregunta')==1){ //La pregunta es un texto
                          if($mi_ejercicio->get('tipoarchivorespuesta')==1){ //La respuesta es un texto
                                 $carpeta.='<li style="width:750px;"><a id="classa" href="./view.php?opcion=8&id='.$id.'&id_ejercicio='.$id_ejercicio.'&tipo_origen='.$mi_ejercicio->get('tipoarchivopregunta').'&tr='.$mi_ejercicio->get('tipoarchivorespuesta').'&tipocreacion='.$mi_ejercicio->get('tipoactividad').'">'. $nombre_ejercicio.'</a><a href="eliminar_carpetas_ejercicios.php?id_curso='.$id.'&id_ejercicio='.$id_ejercicio.'""><img src="./imagenes/delete.gif"/></a></li>';

                          }else{

                              if($mi_ejercicio->get('tipoarchivorespuesta')==2){ //La respuesta es una audio
                                 $carpeta.='<li style="width:750px;"><a id="classa" href="./view.php?opcion=8&id='.$id.'&id_ejercicio='.$id_ejercicio.'&tipo_origen='.$mi_ejercicio->get('tipoarchivopregunta').'&tr='.$mi_ejercicio->get('tipoarchivorespuesta').'&tipocreacion='.$mi_ejercicio->get('tipoactividad').'">'. $nombre_ejercicio.'</a><a href="eliminar_carpetas_ejercicios.php?id_curso='.$id.'&id_ejercicio='.$id_ejercicio.'""><img src="./imagenes/delete.gif"/></a></li>';

                                }else{
                                     if($mi_ejercicio->get('tipoarchivorespuesta')==3){ //La respuesta es un video
                                     $carpeta.='<li style="width:750px;"><a id="classa" href="./view.php?opcion=8&id='.$id.'&id_ejercicio='.$id_ejercicio.'&tipo_origen='.$mi_ejercicio->get('tipoarchivopregunta').'&tr='.$mi_ejercicio->get('tipoarchivorespuesta').'&tipocreacion='.$mi_ejercicio->get('tipoactividad').'">'. $nombre_ejercicio.'</a><a href="eliminar_carpetas_ejercicios.php?id_curso='.$id.'&id_ejercicio='.$id_ejercicio.'""><img src="./imagenes/delete.gif"/></a></li>';

                                    }else{
                                       if($mi_ejercicio->get('tipoarchivorespuesta')==4){ //La respuesta es una imagen
                                         $carpeta.='<li style="width:750px;"><a id="classa" href="./view.php?opcion=8&id='.$id.'&id_ejercicio='.$id_ejercicio.'&tipo_origen='.$mi_ejercicio->get('tipoarchivopregunta').'&tr='.$mi_ejercicio->get('tipoarchivorespuesta').'&tipocreacion='.$mi_ejercicio->get('tipoactividad').'">'. $nombre_ejercicio.'</a><a href="eliminar_carpetas_ejercicios.php?id_curso='.$id.'&id_ejercicio='.$id_ejercicio.'""><img src="./imagenes/delete.gif"/></a></li>';

                                        }

                                    }
                                }
                          }

                     }
                 }


            }
            
            
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
