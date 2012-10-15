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

    function mod_ejercicios_mostrar_ejercicio($id,$id_ejercicio,$tipo_origen)
        {
         // El fichero que procesa el formulario es gestion.php
         parent::moodleform('ejercicios_modificar_texto_texto.php?id_curso='.$id.'&id_ejercicio='.$id_ejercicio.'&tipo_origen='.$tipo_origen);
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
     function mostrar_ejercicio($id,$id_ejercicio,$buscar,$tipo_origen){
         
         
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
         
          $titulo= '<h1>' . $nombre . '</h1>';
          $mform->addElement('html',$titulo);
          
        
          
          $divdescripcion='<div class=descover>';
                            
          
        
          $divdescripcion.=nl2br((stripslashes($ejercicios_leido->get('descripcion'))));
          $divdescripcion.=$parte.'<br/>';
          
         $divdescripcion.='</div>';

         $mform->addElement('html',$divdescripcion);
         if($tipo_origen==1){ //Si es texto
        
             //Añado el texto de origen

               $el_texto_origen = new Ejercicios_textos();
               $el_texto_origen->obtener_uno_id_ejercicio($id_ejercicio);

               if($buscar==1 || $modificable==false){ //Para que no pueda editarlo
                         $divtexto='<div class="desctexto" name="texto" id="texto"><div class="margenes">'.nl2br((stripslashes($el_texto_origen->get('texto')))).'</div></div>';
               }else{
                         $divtexto='<textarea class="adaptHeightInput" name="texto" id="texto">'.$el_texto_origen->get('texto').'</textarea>';
                }
               
                $mform->addElement('html',$divtexto);

             
         }else{
             if($tipo_origen==2){ //Es audio
            //Añado el texto de origen
                    
                    $mform->addElement('html', '<script type="text/javascript" src="./mediaplayer/swfobject.js"></script>');
                    $divaudio='<div class="claseaudio" id="player1"></div>';
                    $mform->addElement('html',$divaudio);
                    $mform->addElement('html','<script type="text/javascript"> var so = new SWFObject("./mediaplayer/mediaplayer.swf","mpl","290","20","7");
                        so.addParam("allowfullscreen","true");
                        so.addVariable("file","./mediaplayer/audios/audio'.$id_ejercicio.'.mp3");
                        so.addVariable("height","20");
                        so.addVariable("width","320");
                        so.write("player1");
                        </script>');
               
             }
         }
         
         //Añado el archivo para el audio
        /* $mform->addElement('html', '<script type="text/javascript" src="./mediaplayer/swfobject.js"></script>');

        $divaudio='<div id="player1">Miaudio</div>';
        $mform->addElement('html',$divaudio);
        $mform->addElement('html','<script type="text/javascript"> var so = new SWFObject("./mediaplayer/mediaplayer.swf","mpl","320","20","7");
            so.addParam("allowfullscreen","true");
            so.addVariable("file","./mediaplayer/audios/danzahungara.mp3");
            so.addVariable("height","20");
            so.addVariable("width","320");
            so.write("player1");
            </script>');
         $mform->addElement('html',$divdescripcion);
         
         */


         //Veo que clasificación TipoActividad tiene
         $tipoactividad=$ejercicios_leido->get('tipoactividad');
         
        
         switch ($tipoactividad) {
             case 0: //es multichoice

                   //Compruebo el tipo que tiene
                  $tipo_respuesta=$ejercicios_leido->get('tipoarchivorespuesta');

                 if($tipo_respuesta == 1){ //Si es de tipo texto-texto sera 2 en caso de audio y 3 video
                          
                            //lo pinto+
                       
                                 $tabla_imagenes = '<table width="100%">'  ;

                                 $tabla_imagenes .='<td>'; #columna
                                
                                $mform->addElement('html',$tabla_imagenes);

                                  //Obtengo las respuestas
                                 $mis_preguntas = new Ejercicios_texto_texto_preg();
                                 $preguntas=$mis_preguntas->obtener_todas_preguntas_ejercicicio($id_ejercicio);
                               
                             for($i=1;$i<=sizeof($preguntas);$i++){

                                         
					  //Pinto la pregunta
                                               $divpregunta='<div id="tabpregunta'.$i.'" >';
                                               $divpregunta.='<br/><br/>';
                                               $divpregunta.='<table style="width:100%;">';
                                               $divpregunta.=' <td style="width:80%;">';
                                            //   $divpregunta.='<div id="id_pregunta1" name="pregunta1">';
                                               if($buscar==1 || $modificable==false){ //Para que no pueda editarlo
                                                    $divpregunta.='<div style="width: 900px;" class="pregunta" name="pregunta'.$i.'" id="pregunta'.$i.'">'.$preguntas[$i-1]->get('pregunta').'</div>';
                                               }else{
                                                     $divpregunta.='<textarea style="width: 900px;" class="pregunta" name="pregunta'.$i.'" id="pregunta'.$i.'">'.$preguntas[$i-1]->get('pregunta').'</textarea>';
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
                                         
                                           
                                            //Obtengo las respuestas a la pregunta

                                               $id_pregunta=$preguntas[$i-1]->get('id');
                                               $mis_respuestas = new Ejercicios_texto_texto_resp();
                                               $respuestas=$mis_respuestas->obtener_todas_respuestas_pregunta($id_pregunta);

                                               $divpregunta.='</br><div id="respuestas'.$i.'" class=respuesta>';
                                            for($p=0;$p<sizeof($respuestas);$p++){
                                                    $q=$p+1;
                                             
                                               $divpregunta.='<table  id="tablarespuesta'.$q.'_'.$i.'" style="width:100%;">';
                                               $divpregunta.='<tr id="trrespuesta'.$q."_".$i.'"> ';
                                               $divpregunta.=' <td style="width:80%;">';
                                               
                                               $correc=$respuestas[$p]->get('correcta');
                                               
                                             /*  if($correc){
                                                   $divpregunta.='<input type="hidden" value=1 id="res'.$q."_".$i.'" name="num_res_preg'.$i.'" />';
                                               }else{
                                                   $divpregunta.='<input type="hidden" value=0 id="res'.$q."_".$i.'" name="num_res_preg'.$i.'" />';
                                             
                                               }*/
                                               $divpregunta.='<input class=over type="radio" name="crespuesta'.$q.'_'.$i.'" id="id_crespuesta'.$q.'_'.$i.'" value="0" onclick="BotonRadio(crespuesta'.$q.'_'.$i.')"/>';
                                              
                                               
                                            //   $divpregunta.='<div class="resp" name="respuesta'.$q."_".$i.'" id="respuesta'.$q."_".$i.'" contentEditable=true>';
                                            //   $divpregunta.=$preguntas[$p]->get('Respuesta');
                                            //   $divpregunta.='</div>';
                                                if($buscar==1 || $modificable==false){ 
                                                  $divpregunta.='<div style="width: 700px;" class="resp" name="respuesta'.$q."_".$i.'" id="respuesta'.$q."_".$i.'" value="'.$respuestas[$p]->get('respuesta').'">'.$respuestas[$p]->get('respuesta').'</div>';
                                                }else{
                                                 $divpregunta.='<textarea style="width: 700px;" class="resp" name="respuesta'.$q."_".$i.'" id="respuesta'.$q."_".$i.'" value="'.$respuestas[$p]->get('respuesta').'">'.$respuestas[$p]->get('respuesta').'</textarea>';
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
                                            
                                            $divpregunta.='<input type="hidden" value='.sizeof($respuestas).' id="num_res_preg'.$i.'" name="num_res_preg'.$i.'" />';
                                            $mform->addElement('html',$divpregunta);
                                            //Introduzco el número de respuestas de la pregunta
                                            //$mform->addElement('hidden', 'num_res_preg'.$i,$numero_respuestas);

                                  
                                  
                               
                             }
                             
                             
                             //Si soy el dueño del ejercicio y no estoy buscando boton guardar
                              if($buscar!=1 && $modificable==true){ 
                             //Pinto los botones
                              $buttonarray = array();
                              $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('BotonGuardar','ejercicios'));
                               $mform->addGroup($buttonarray, 'botones', '', array(' '), false);
                              
                              
                              }else{
                                  if($buscar==1){ //Si estoy buscand
                                                                            
                                        //compruebo si soy profesor
                                        if (has_capability('moodle/legacy:editingteacher', $context, $USER->id, false) && $modificable==false){
                                        //boton añadir a mis ejercicios
					  $attributes='size="40"';
					  $mform->addElement('text', 'carpeta_ejercicio',get_string('carpeta', 'ejercicios') , $attributes);
					  $mform->addRule('carpeta_ejercicio', "Carpeta Necesaria", 'required', null, 'client');                                     
                                          $buttonarray = array();
					  $buttonarray[] = &$mform->createElement('submit', 'submitbutton2', get_string('BotonAñadir','ejercicios'));
					  $mform->addGroup($buttonarray, 'botones2', '', array(' '), false);
                                          //boton menu principal
                                            $tabla_menu='<center><input type="button" style="height:30px; width:100px; margin-left:30px; margin-top:20px;"  id="id_Menu" value="Menu Principal" onClick="javascript:botonPrincipal('.$id.')" /></center>';
				
                                            $mform->addElement('html',$tabla_menu);
                                        }else{
                                            
                                            if($modificable==true){ // Si el ejercicio era mio y estoy buscando
                                                  $tabla_menu='<center><input type="button" style="height:30px; width:100px; margin-left:30px; margin-top:20px;"  id="id_Menu" value="Menu Principal" onClick="javascript:botonPrincipal('.$id.')" /></center>';
				
                                                  $mform->addElement('html',$tabla_menu);
                                            }else{//soy alumno
                                                 $tabla_menu='<center><input type="button" style="height:30px; width:100px; margin-left:175px;"  value="Corregir" onClick="javascript:botonCorregirMultiChoice('.$id.','.$npreg.')"/> <input type="button" style="height:30px; width:100px; margin-left:30px; margin-top:20px;"  id="id_Menu" value="Menu Principal" onClick="javascript:botonPrincipal('.$id.')" /></center>';
				
                                                 $mform->addElement('html',$tabla_menu);
                                            }
                                        }
                                  }else{ //Estoy buscando o no
                                      // compruebo si soy profesor
					if (has_capability('moodle/legacy:editingteacher', $context, $USER->id, false)){
					     
					}else{
					      $tabla_menu='<center><input type="button" style="height:30px; width:100px; margin-left:175px;"  value="Corregir" onClick="javascript:botonCorregirMultiChoice('.$id.','.$npreg.')"/> <input type="button" style="height:30px; width:100px; margin-left:30px; margin-top:20px;"  id="id_Atras" value="Atrás" onClick="javascript:botonAtras('.$id.')" /><input type="button" style="height:30px; width:100px; margin-left:30px; margin-top:20px;"  id="id_Menu" value="Menu Principal" onClick="javascript:botonPrincipal('.$id.')" /></center>';
				
					      $mform->addElement('html',$tabla_menu);
					}
                                  }
                    
                                  
                              }
                              
                               $tabla_imagenes ='</td>';
                                      $tabla_imagenes .='<td  width="10%">';
                                    //Mis palabras
                                    $tabla_imagenes .='<div><a  onclick=JavaScript:sele('.$id.')><img src="../vocabulario/imagenes/guardar_palabras.png" id="id_guardar_im" name="guardar_im" title="'.get_string('guardar', 'vocabulario').'"/></a></div>';
                                    $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=5" target="_blank"><img src="../vocabulario/imagenes/administrar_gramaticas.png" id="id_gram_im" name="gram_im" title="'. get_string('admin_gr', 'vocabulario') . '"/></a></div>';
                                    $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=7" target="_blank"><img src="../vocabulario/imagenes/intenciones_comunicativas.png" id="id_ic_im" name="ic_im" title="'. get_string('admin_ic', 'vocabulario') . '"/></a></div>';
                                    $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=9" target="_blank"><img src="../vocabulario/imagenes/tipologias_textuales.png" id="id_tt_im" name="tt_im" title="'. get_string('admin_tt', 'vocabulario') .'"/> </a></div>';
                                    $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=11" target="_blank"><img src="../vocabulario/imagenes/estrategias_icon.png" id="id_ea_im" name="ea_im" title="'. get_string('admin_ea', 'vocabulario') .'"/> </a></div>';

                                    $tabla_imagenes .='</td>'; 
                     
                                    $tabla_imagenes .='</table>'; 
                                        $mform->addElement('html',$tabla_imagenes);
                 }
                 break;

             default:
                 break;
         }
         
      
        
     }
}


?>
