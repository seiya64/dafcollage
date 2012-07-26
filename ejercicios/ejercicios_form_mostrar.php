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


class mod_ejercicios_mostrar_ejercicio extends moodleform_mod {

    function mod_ejercicios_mostrar_ejercicio($id,$id_ejercicio)
        {
         // El fichero que procesa el formulario es gestion.php
         parent::moodleform('ejercicios_modificar_texto_texto.php?id_curso='.$id.'&id_ejercicio='.$id_ejercicio);
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
     function mostrar_ejercicio($id,$id_ejercicio,$buscar){
         
         
        global $CFG, $COURSE, $USER;
        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);

        
        //Los iconos están sacados del tema de gnome que viene con ubuntu 11.04
       
       //inclusion del javascript para las funciones
    
        $mform = & $this->_form;
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./style.css">');
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./estilo.css">');
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>');
    	$mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="funciones.js"></script>');
        
         //Cojo el ejercicio  de la bd a partir de su id (id_ejercicio)
      
       
         $ejercicios_bd = new Ejercicios_general();
         $ejercicios_leido =$ejercicios_bd->obtener_uno($id_ejercicio);
   
         $nombre=$ejercicios_leido->get('name');
         $npreg=$ejercicios_leido->get('numpreg');
         $creador=$ejercicios_leido->get('id_creador');
         
         if($creador==$USER->id){
             $modificable=true;
         }else{
             $modificable=false;
         }
         
          $titulo= '<h1>' . $nombre . '</h1>';
          $mform->addElement('html',$titulo);
          
        
          
          $divdescripcion='<div class=descover>';
                            
          //Lo separo en partes por si es muy larga
        
          $divdescripcion.=$ejercicios_leido->get('descripcion');
          $divdescripcion.=$parte.'<br/>';
          
         $divdescripcion.='</div>';
         
         $mform->addElement('html',$divdescripcion);
         //Veo que clasificación TipoActividad tiene
         $tipoactividad=$ejercicios_leido->get('TipoActividad');
         
       
         switch ($tipoactividad) {
             case 0: //es multichoice

              
                 $ejercicios_texto = new Ejercicios_texto_texto();
                 $todos_mis_texto_id_ejercicio= array();
                 $todos_mis_texto_id_ejercicio=$ejercicios_texto->obtener_ejercicios_texto_id_ejercicicio($id_ejercicio);
                 $numero = sizeof($todos_mis_texto_id_ejercicio);
                
                 if($numero != 0){ //Si es de tipo texto-texto
                          
                            //lo pinto+
                       
                            
                             for($i=1;$i<=$npreg;$i++){
                               
                                $preguntas= array();
                                
                                $preguntas=$ejercicios_texto->obtener_ejercicios_texto_id_ejercicicio_numpreguntas($id_ejercicio,$i);
                                $numero_respuestas= sizeof($preguntas);
                        
                                     
                                      //Obtengo la pregunta
                                               $divpregunta='<div id="tabpregunta'.$i.'" >';
                                               $divpregunta.='<br/><br/>';
                                               $divpregunta.='<table style="width:100%;">';
                                               $divpregunta.=' <td style="width:80%;">';
                                            //   $divpregunta.='<div id="id_pregunta1" name="pregunta1">';
                                               if($buscar==1 || $modificable==false){ //Para que no pueda editarlo
                                                    $divpregunta.='<div style="width: 900px;" class="pregunta" name="pregunta'.$i.'" id="pregunta'.$i.'">'.$preguntas[0]->get('Pregunta').'</div>';
                                               }else{
                                                     $divpregunta.='<textarea style="width: 900px;" class="pregunta" name="pregunta'.$i.'" id="pregunta'.$i.'">'.$preguntas[0]->get('Pregunta').'</textarea>';
                                               }
                                           // $divpregunta.='<input name="pregunta1" type="text" style="width:80%; height:100%; margin:1%;">ssss</input>';
                                           //  $divpregunta.=$preguntas[0]->get('Pregunta');
                                           //$divpregunta.='</div>';
                                               
                                               $divpregunta.=' </td>';
                                               
                                               if($buscar!=1 && $modificable==true){
                                               $divpregunta.=' <td style="width:5%;">';
                                               $divpregunta.='<img src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="EliminarRespuesta(tabpregunta'.$i.','.$i.')" title="Eliminar Pregunta"></img>';
                                               $divpregunta.='</br><img src="./imagenes/añadir.gif" alt="eliminar respuesta"  height="15px"  width="15px" onClick="anadirRespuesta(respuestas'.$i.')" title="Añadir Respuesta"></img>';
                                               $divpregunta.='</td> ';
                                               $divpregunta.='</br> ';
                                               }
                                               $divpregunta.='</table> ';
                                         
                                           // $divpregunta.='</div>';
                                            //$mform->addElement('html',$divpregunta);
                                            //Obtengo las respuestas
                                            $divpregunta.='</br><div id="respuestas'.$i.'" class=respuesta>';
                                            for($p=0;$p<$numero_respuestas;$p++){
                                                    $q=$p+1;
                                             
                                               $divpregunta.='<table  id="tablarespuesta'.$q.'_'.$i.'" style="width:100%;">';
                                               $divpregunta.='<tr id="trrespuesta'.$q."_".$i.'"> ';
                                               $divpregunta.=' <td style="width:80%;">';
                                               
                                               $correc=$preguntas[$p]->get('Correcta');
                                               
                                               if($correc){
                                                   $divpregunta.='<input class=over type="radio" name="crespuesta'.$q.'_'.$i.'" value="1" onclick="BotonRadio(crespuesta'.$q.'_'.$i.')" checked="true"/>';
                                               }else{
                                                    $divpregunta.='<input class=over type="radio" name="crespuesta'.$q.'_'.$i.'" value="0" onclick="BotonRadio(crespuesta'.$q.'_'.$i.')"/>';
                                               }
                                               
                                            //   $divpregunta.='<div class="resp" name="respuesta'.$q."_".$i.'" id="respuesta'.$q."_".$i.'" contentEditable=true>';
                                            //   $divpregunta.=$preguntas[$p]->get('Respuesta');
                                            //   $divpregunta.='</div>';
                                                if($buscar==1 || $modificable==false){ 
                                                  $divpregunta.='<div style="width: 700px;" class="resp" name="respuesta'.$q."_".$i.'" id="respuesta'.$q."_".$i.'" value="'.$preguntas[$p]->get('Respuesta').'">'.$preguntas[$p]->get('Respuesta').'</div>'; 
                                                }else{
                                                 $divpregunta.='<textarea style="width: 700px;" class="resp" name="respuesta'.$q."_".$i.'" id="respuesta'.$q."_".$i.'" value="'.$preguntas[$p]->get('Respuesta').'">'.$preguntas[$p]->get('Respuesta').'</textarea>'; 
                                                }
                                               $divpregunta.=' </td>';
                                               $divpregunta.=' <td style="width:5%;">';
                                              
                                               if($buscar!=1 && $modificable==true){ 
                                               //La imagen para eliminar las respuestas
                                               $divpregunta.='<img src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="EliminarRespuesta(tablarespuesta'.$q.'_'.$i.','.$i.')" title="Eliminar Respuesta"></img>';
                                               
                                               
                                               //La imagen para cambiar las respuestas
                                                
                                                    if($correc){
                                                        $divpregunta.='<img src="./imagenes/correcto.png" id="correcta'.$q.'_'.$i.'" alt="respuesta correcta"  height="15px"  width="15px" onClick="InvertirRespuesta(correcta'.$q.'_'.$i.',1)" title="Cambiar a Incorrecta"></img>';
                                                        $divpregunta.='<input type="hidden" value="1"  id="valorcorrecta'.$q.'_'.$i.'" name="valorcorrecta'.$q.'_'.$i.'" />';
                                                        }else{
                                                            $divpregunta.='<img src="./imagenes/incorrecto.png" id="correcta'.$q.'_'.$i.'" alt="respuesta correcta"  height="15px"  width="15px" onClick="InvertirRespuesta(correcta'.$q.'_'.$i.',0)" title="Cambiar a Correcta"></img>';
                                                            $divpregunta.='<input type="hidden" value="0"  id="valorcorrecta'.$q.'_'.$i.'" name="valorcorrecta'.$q.'_'.$i.'" />';
                                                        }
                                                }
                                               
                                               $divpregunta.='</td> ';
                                               $divpregunta.='<tr>';
                             
                                               $divpregunta.='</table> ';
                                               
                                             
                                            }
                                           
                                         
                                            $divpregunta.='</div>';
                                         
                                            $divpregunta.='</div>';
                                            
                                            $divpregunta.='<input type="hidden" value='.$numero_respuestas.' id="num_res_preg'.$i.'" name="num_res_preg'.$i.'" />';
                                            $mform->addElement('html',$divpregunta);
                                            //Introduzco el número de respuestas de la pregunta
                                            //$mform->addElement('hidden', 'num_res_preg'.$i,$numero_respuestas);

                                  
                                  
                               
                             }
                             
                              if($buscar!=1 && $modificable==true){ 
                             //Pinto los botones
                              $buttonarray = array();
                              $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('BotonGuardar','ejercicios'));
                             // $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('BotonCorregir','ejercicios'));
                              $mform->addGroup($buttonarray, 'botones', '', array(' '), false);
                              
                              
                              }else{
                                  if($buscar==1){
                                    $buttonarray = array();
                                    $buttonarray[] = &$mform->createElement('reset', 'resetbutton', get_string('BotonAñadir','ejercicios'));
                                    // $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('BotonCorregir','ejercicios'));
                                    $mform->addGroup($buttonarray, 'botones', '', array(' '), false);
                                  }else{
                                      
                                    $boton='<center></br><input type="button" style="height:20px; width:120px; margin-left:175px;" id="id_botonMenuPrincipal" value="'.get_string("Misejercicios","ejercicios").'" onClick="botonMenuPrincipal('.$id.');"></center>';
                                    $mform->addElement('html',$boton);
                                    
                                  }
                              }
                       
                     
                 }
                 break;

             default:
                 break;
         }
         
      
        
     }
}


?>
