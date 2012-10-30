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

  Original idea and content design:
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

class mod_ejercicios_mostrar_ejercicio_asociacion_simple extends moodleform_mod {

    function mod_ejercicios_mostrar_ejercicio_asociacion_simple($id,$id_ejercicio,$tipo_origen,$tipo_respuesta,$tipocreacion)
        {
         // El fichero que procesa el formulario es gestion.php
         parent::moodleform('ejercicios_modificar_asociacion_simple.php?id_curso='.$id.'&id_ejercicio='.$id_ejercicio.'&tipo_origen='.$tipo_origen);
       }

     function definition() {
     }


     /**
     * Function that add a table to the forma to show the main menu
     *
     * @author Serafina Molina Soto
     * @param $id id for the course
     * @param $id_ejercicio id del ejercicio a mostrar
     */
     function mostrar_ejercicio_asociacion_simple($id,$id_ejercicio,$buscar,$tipo_origen,$tipo_respuesta,$tipocreacion){


        
        global $CFG, $COURSE, $USER;
        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);

       
        //Los iconos están sacados del tema de gnome que viene con ubuntu 11.04

       //inclusion del javascript para las funciones

        $mform = & $this->_form;
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./style.css">');
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./estilo.css">');
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>');
    	$mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="./funciones.js"></script>');
         //Cojo el ejercicio  de la bd a partir de su id (id_ejercicio)

      
         //Obtengo el ejercicio de la bd
         $ejercicios_bd = new Ejercicios_general();
         $ejercicios_leido =$ejercicios_bd->obtener_uno($id_ejercicio);
       
         $nombre=$ejercicios_leido->get('name');
         $npreg=$ejercicios_leido->get('numpreg');
         $creador=$ejercicios_leido->get('id_creador');

         if($creador==$USER->id && has_capability('moodle/legacy:editingteacher', $context, $USER->id, false)){
             $modificable=true;
         }else{
             $modificable=false;
         }
        
          //Añado el título
          $titulo= '<h1>' . $nombre . '</h1>';
          $mform->addElement('html',$titulo);

          //Añado la descripción
         
          $divdescripcion='<div class=descover>';

          $divdescripcion.=nl2br((stripslashes($ejercicios_leido->get('descripcion'))));
          $divdescripcion.=$parte.'<br/>';

          $divdescripcion.='</div>';

          $mform->addElement('html',$divdescripcion);

         
          $tabla_imagenes = '<table width="100%">'  ;

          $tabla_imagenes .='<td>'; #columna


        
          echo "tipo origen.$tipo_origen";
          //compruebo de que tipo es el origen
            switch($tipo_origen){
                default;
                case 1: //Es de tipo texto

                 echo "tipo respuesta.$tipo_respuesta";
                      switch($tipo_respuesta){
                            case 1: //Es de tipo texto
                              $tabla_imagenes.='<center><table>';
                                  //Obtengo las preguntas
                                 $mis_preguntas = new Ejercicios_texto_texto_preg();
                                 $preguntas=$mis_preguntas->obtener_todas_preguntas_ejercicicio($id_ejercicio);
                                 $tabla_imagenes.="<tr>";
                               
                                 //Inserto las preguntas con clase "item" es decir dragables(mirar javascript.js)
                                 for($i=1;$i<=sizeof($preguntas);$i++){

                                      //Obtengo la pregunta
                                      $tabla_imagenes.='<td> <div class="item" id="'.$i.'">';
                                           if($buscar==1 || $modificable==false){
                                       
                                                $tabla_imagenes.='<p style="margin-top: 10%;">'.$preguntas[$i-1]->get('pregunta').'</p>';

                                           }else{
                                                $tabla_imagenes.='<textarea style="height: 197px; width: 396px;">'.$preguntas[$i-1]->get('pregunta').'</textarea>';

                                           }
                                       $tabla_imagenes.='</div></div></td>';
                                      if($i % 2 == 0){ //Si es impar lo bajo
                                          $tabla_imagenes.="</tr>";
                                      }
                                 }
                                  $tabla_imagenes.="</tr>";
                                 $tabla_imagenes.='</table></center>';
                                  $tabla_imagenes.="</br>";
                                   $tabla_imagenes.="</br>";
                                 $tabla_imagenes.='<table><center>';

                                 $k=1;
                                 $las_respuestas[sizeof($preguntas)+1];
                                 $aleatorios_generados=array();
                                 while($k<=sizeof($preguntas)){
                                  //Obtengo la respuestas (En este caso sólo habrá 1, ya que es "simple")
                                   
                                   $id_pregunta=$preguntas[$k-1]->get('id');
                                   $mis_respuestas = new Ejercicios_texto_texto_resp();

                                   $respuestas=$mis_respuestas->obtener_todas_respuestas_pregunta($id_pregunta);
                                   
                                    //Para cada respuesta

                                                   srand (time());
                                                   //generamos un número aleatorio entre 1 y el número de pregutnas
                                                   $numero_aleatorio = rand(1,sizeof($preguntas));
                                                   
                                                   //buscamos si aleatorios contine
                                                   $esta='0';

                                                  
                                                   for($j=0;$j< sizeof($aleatorios_generados);$j++){
                                                     
                                                       if($aleatorios_generados[$j]==$numero_aleatorio){
                                                        
                                                           $esta='1';
                                                       }
                                                   }
                                                 
                                                   if($esta == '0'){ //Si no esta lo inserto
                                                          
                                                          $las_respuestas[]=$respuestas[0]->get('respuesta');
                                                          $aleatorios_generados[]=$numero_aleatorio;
                                                          $k++;
                                                   }
                                     
                                        
                                       }

                                      

                                         for($j=0;$j< sizeof($aleatorios_generados);$j++){
                                               $tabla_imagenes.='<tr>';
                                               $tabla_imagenes.='<td><div  id="'.$aleatorios_generados[$j].'" class="marquito"></div></td>';
                                              if($buscar==1 || $modificable==false){ //Para que no pueda editarlo
                                               $tabla_imagenes.='<td><div class=descripcion>';
                                               $tabla_imagenes.=$las_respuestas[$aleatorios_generados[$j]-1].'</div></td>';
                                              }else{
                                                  $tabla_imagenes.='<td><textarea class=descripcion style="height: 192px; width: 401px;" >';
                                                  $tabla_imagenes.=$las_respuestas[$aleatorios_generados[$j]-1].'</textarea></td>';
                                              }
                                               $tabla_imagenes.='<td id="aceptado'.$aleatorios_generados[$j].'" class="marquitoaceptado"></td>';
                                               $tabla_imagenes.='</tr>';
                                         }

                                        $tabla_imagenes.='</table></center>';
                                        $tabla_imagenes.='<p class="numero" id="'.sizeof($preguntas).'"></p>';
                                        //botones
                                         $mform->addElement('html',$tabla_imagenes);


                                          if($buscar!=1 && $modificable==true){
                                              //Si soy el profesor creadors
                                             $tabla_imagenes='<input type="submit" style="height:30px; width:100px; margin-left:90px; margin-top:20px;" id="submitbutton" name="submitbutton" value="'.get_string('BotonGuardar','ejercicios').'">';
                                             $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id .'\'"></center>';

                                          }else{
                                                 if($buscar==1){ //Si estoy buscand
                                                        $ejercicios_prof = new Ejercicios_prof_actividad();
                                                         $ejercicios_del_prof =$ejercicios_prof->obtener_uno_idejercicio($id_ejercicio);
                                                         if(sizeof( $ejercicios_del_prof)==0){
                                                             $noagregado=true;
                                                         }else{
                                                              $noagregado=false;
                                                         }
                                                        //si el ejercicio no es mio y soy profesor
                                                         if (has_capability('moodle/legacy:editingteacher', $context, $USER->id, false) && ($modificable==false ||$noagregado==true) ){
                                                        //boton añadir a mis ejercicios
                                                          $attributes='size="40"';
                                                          $mform->addElement('text', 'carpeta_ejercicio',get_string('carpeta', 'ejercicios') , $attributes);
                                                          $mform->addRule('carpeta_ejercicio', "Carpeta Necesaria", 'required', null, 'client');
                                                          $buttonarray = array();
                                                          $buttonarray[] = &$mform->createElement('submit', 'submitbutton2', get_string('BotonAñadir','ejercicios'));
                                                          $mform->addGroup($buttonarray, 'botones2', '', array(' '), false);

                                                         }

                                                         else{

                                                             if($modificable==true){ // Si el ejercicio era mio y estoy buscando
                                                                $tabla_imagenes='<center><input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id .'\'"></center>';
                                                             }else{ //Si soy alumno
                                                                  $tabla_imagenes='<center><input type="button" style="height:40px; width:60px;" id="botonResultado" value="Corregir">';
                                                                  $tabla_imagenes.='<input type="button" style="height:40px; width:60px;" id="botonRehacer" value="Rehacer" onClick="location.href=\'./view.php?id=' . $id . '&opcion=8'. '&id_ejercicio='.$id_ejercicio. '&tipo_origen='.$tipo_origen.'&tr='.$tipo_respuesta.'&tipocreacion='.$tipocreacion.'\'">';
                                                                  $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id .'\'"></center>';

                                                             }
                                                         }
                                                 }else{

                                                       $tabla_imagenes='<center><input type="button" style="height:40px; width:60px;" id="botonResultado" value="Corregir">';
                                                       $tabla_imagenes.='<input type="button" style="height:40px; width:60px;" id="botonRehacer" value="Rehacer" onClick="location.href=\'./view.php?id=' . $id . '&opcion=8'. '&id_ejercicio='.$id_ejercicio. '&tipo_origen='.$tipo_origen.'&tr='.$tipo_respuesta.'&tipocreacion='.$tipocreacion.'\'">';
                                                       $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id .'\'"></center>';

                                                 }
                                          }
                                        

                                        $tabla_imagenes .='</td>';
                                        $tabla_imagenes .='<td  width="10%">';
                                            //añado la parte de vocabulario para la conexión
                                        $tabla_imagenes .='<div><a  onclick=JavaScript:sele('.$id.')><img src="../vocabulario/imagenes/guardar_palabras.png" id="id_guardar_im" name="guardar_im" title="'.get_string('guardar', 'vocabulario').'"/></a></div>';
                                        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=5"><img src="../vocabulario/imagenes/administrar_gramaticas.png" id="id_gram_im" name="gram_im" title="'. get_string('admin_gr', 'vocabulario') . '"/></a></div>';
                                        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=7"><img src="../vocabulario/imagenes/intenciones_comunicativas.png" id="id_ic_im" name="ic_im" title="'. get_string('admin_ic', 'vocabulario') . '"/></a></div>';
                                        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=9"><img src="../vocabulario/imagenes/tipologias_textuales.png" id="id_tt_im" name="tt_im" title="'. get_string('admin_tt', 'vocabulario') .'"/> </a></div>';
                                        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=11"><img src="../vocabulario/imagenes/estrategias_icon.png" id="id_ea_im" name="ea_im" title="'. get_string('admin_ea', 'vocabulario') .'"/> </a></div>';

                                        $tabla_imagenes .='</td>';

                                        $tabla_imagenes .='</table>';

                                        $mform->addElement('html',$tabla_imagenes);



                                                          
                            
                              
                                

                               break;
                             case 2: //Es de tipo audio
                             break;
                             case 3: //Es de tipo video
                             break;
                             case 4: //Es una imagen
                             break;
                case 2: //Es de tipo audio
                        break;

                case 3: //Es de tipo video
                     
                    break;
               case 4: //Es una imagen


                    break;
            }

        
        
       }
    }
}
?>
