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
        
       
        
         for($i=0;$i<$numeroencontrados;$i++){
   
     
           $carpeta.='<ul id="classul">';

            $nombre_ejercicio= $todos_ejer_curso[$i]->get('name');
            //Añado un enlace por cada ejercicio dentro de la carpeta
            $id_ejercicio=$todos_ejer_curso[$i]->get('id');
            
            //Propuesta de codigo por Angel Biedma
            $tipo_creacion = $todos_ejer_curso[$i]->get('tipoactividad');
            switch($tipo_creacion) {
                case 0: //Multiple Choice
                case 4: //Identificar elementos
                    $carpeta.='<li style="width:750px;"><a id="classa" href="./view.php?opcion=8&id='.$id.'&id_ejercicio='.$id_ejercicio.'&buscar=1&tipocreacion='.$tipo_creacion.'">'. $nombre_ejercicio.'</a></li>';
                    break;
                case 1: // Asociacion simple
                case 2: // Asociacion multiple
                case 3: // Texto Hueco
                case 7: // Ordenar Elementos
                    $carpeta.='<li style="width:750px;"><a id="classa" href="./view.php?opcion=8&id='.$id.'&id_ejercicio='.$id_ejercicio.'&buscar=1&tipo_origen='.$todos_ejer_curso[$i]->get('tipoarchivopregunta').'&tr='.$todos_ejer_curso[$i]->get('tipoarchivorespuesta').'&tipocreacion='.$todos_ejer_curso[$i]->get('tipoactividad').'">'. $nombre_ejercicio.'</a></li>';
                    break;
            }

            /*if($todos_ejer_curso[$i]->get('tipoactividad')==0){ //multichoice

                $carpeta.='<li style="width:750px;"><a id="classa" href="./view.php?opcion=8&id='.$id.'&id_ejercicio='.$id_ejercicio.'">'. $nombre_ejercicio.'</a></li>';

            }else{

                 if($todos_ejer_curso[$i]->get('tipoactividad')==1){ //asociacion simple


                     //comprubo que tipo tiene archivorespuesta
                     if($todos_ejer_curso[$i]->get('tipoarchivopregunta')==1){ //La pregunta es un texto
                          if($todos_ejer_curso[$i]->get('tipoarchivorespuesta')==1){ //La respuesta es un texto
                                 $carpeta.='<li style="width:750px;"><a id="classa" href="./view.php?opcion=8&id='.$id.'&id_ejercicio='.$id_ejercicio.'&buscar=1&tipo_origen='.$todos_ejer_curso[$i]->get('tipoarchivopregunta').'&tr='.$todos_ejer_curso[$i]->get('tipoarchivorespuesta').'&tipocreacion='.$todos_ejer_curso[$i]->get('tipoactividad').'">'. $nombre_ejercicio.'</a></li>';

                          }else{

                               if($todos_ejer_curso[$i]->get('tipoarchivorespuesta')==2){ //La respuesta es un audio
                                 $carpeta.='<li style="width:750px;"><a id="classa" href="./view.php?opcion=8&id='.$id.'&id_ejercicio='.$id_ejercicio.'&buscar=1&tipo_origen='.$todos_ejer_curso[$i]->get('tipoarchivopregunta').'&tr='.$todos_ejer_curso[$i]->get('tipoarchivorespuesta').'&tipocreacion='.$todos_ejer_curso[$i]->get('tipoactividad').'">'. $nombre_ejercicio.'</a></li>';

                               }else{

                                   if($todos_ejer_curso[$i]->get('tipoarchivorespuesta')==3){ //La respuesta es una imagen
                                     $carpeta.='<li style="width:750px;"><a id="classa" href="./view.php?opcion=8&id='.$id.'&id_ejercicio='.$id_ejercicio.'&buscar=1&tipo_origen='.$todos_ejer_curso[$i]->get('tipoarchivopregunta').'&tr='.$todos_ejer_curso[$i]->get('tipoarchivorespuesta').'&tipocreacion='.$todos_ejer_curso[$i]->get('tipoactividad').'">'. $nombre_ejercicio.'</a></li>';
                                   }else{
                                      if($todos_ejer_curso[$i]->get('tipoarchivorespuesta')==4){ //La respuesta es una foto
                                         $carpeta.='<li style="width:750px;"><a id="classa" href="./view.php?opcion=8&id='.$id.'&id_ejercicio='.$id_ejercicio.'&buscar=1&tipo_origen='.$todos_ejer_curso[$i]->get('tipoarchivopregunta').'&tr='.$todos_ejer_curso[$i]->get('tipoarchivorespuesta').'&tipocreacion='.$todos_ejer_curso[$i]->get('tipoactividad').'">'. $nombre_ejercicio.'</a></li>';

                                      }
                                   }
                               }

                          }

                     }else{
                        if($todos_ejer_curso[$i]->get('tipoarchivopregunta')==2){ //La pregunta es un audio
                          if($todos_ejer_curso[$i]->get('tipoarchivorespuesta')==1){ //La respuesta es un texto
                                 $carpeta.='<li style="width:750px;"><a id="classa" href="./view.php?opcion=8&id='.$id.'&id_ejercicio='.$id_ejercicio.'&buscar=1&tipo_origen='.$todos_ejer_curso[$i]->get('tipoarchivopregunta').'&tr='.$todos_ejer_curso[$i]->get('tipoarchivorespuesta').'&tipocreacion='.$todos_ejer_curso[$i]->get('tipoactividad').'">'. $nombre_ejercicio.'</a></li>';

                          }
                        }else{
                            if($todos_ejer_curso[$i]->get('tipoarchivopregunta')==3){ //La pregunta es un video
                              if($todos_ejer_curso[$i]->get('tipoarchivorespuesta')==1){ //La respuesta es un texto
                                     $carpeta.='<li style="width:750px;"><a id="classa" href="./view.php?opcion=8&id='.$id.'&id_ejercicio='.$id_ejercicio.'&buscar=1&tipo_origen='.$todos_ejer_curso[$i]->get('tipoarchivopregunta').'&tr='.$todos_ejer_curso[$i]->get('tipoarchivorespuesta').'&tipocreacion='.$todos_ejer_curso[$i]->get('tipoactividad').'">'. $nombre_ejercicio.'</a></li>';

                              }
                             }else{
                                 if($todos_ejer_curso[$i]->get('tipoarchivopregunta')==4){ //La pregunta es un IMAGEN
                                  if($todos_ejer_curso[$i]->get('tipoarchivorespuesta')==1){ //La respuesta es un texto
                                     $carpeta.='<li style="width:750px;"><a id="classa" href="./view.php?opcion=8&id='.$id.'&id_ejercicio='.$id_ejercicio.'&buscar=1&tipo_origen='.$todos_ejer_curso[$i]->get('tipoarchivopregunta').'&tr='.$todos_ejer_curso[$i]->get('tipoarchivorespuesta').'&tipocreacion='.$todos_ejer_curso[$i]->get('tipoactividad').'">'. $nombre_ejercicio.'</a></li>';
                                  }
                                }
                             }
                        }




                     }
                 }


            }*/




            
            
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

