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


class mod_ejercicios_mostrar_ejercicios_buscados extends moodleform_mod{

    function mod_ejercicios_mostrar_ejercicios_buscados($id)
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
     function mostrar_ejercicios_buscados($id,$ccl,$cta ,$cdc,$cgr,$cic,$ctt){
       
        
        global $CFG, $COURSE, $USER;
          
        $mform = & $this->_form;
       
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./estilos2.css">');
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>');
    	$mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="./funciones.js"></script>');
 
        //titulo
        $titulo= '<h2>' . get_string('Tipo'.$cta, 'ejercicios') . '</h2>';
        $mform->addElement('html',$titulo);
        
       //clasificación por campo temático.
       //Si es 1 es -- y 0 Select
       echo "Clasificacion por campo tematico".$ccl.'</br>';

       //clasificación por tipo de ejercicio
       //le resto 2 ya que el primero es -- y select
        
        $cta=$cta-2;
        echo "Clasificacion por tipo".$cta.'</br>';
        
       //clasificación por destreza comunicativa
       //le resto 2 ya que el primero es -- y select
        $cdc=$cdc-2;
        echo "Clasificacion por destreza".$cdc.'</br>';
        
        //clasificación por tema gramatical
            
        echo "Clasificacion por tema gramatical".$cgr.'</br>';
        
        
           //clasificación por tema gramatical
            
        echo "Clasificacion por intencion comunicativa".$cic.'</br>';
        //
        //clasificación por tipologia textual
        //le sumo 1 puesto que en la tabla los id comienzan por 1 y el primero es --
        $ctt=$ctt+1;
        echo "Clasificacion por tipologia textual".$ctt.'</br>';
        $ejercicios_general = new Ejercicios_general();
      
        //Busco todos los ejercicios que son públicos(visibles tambien por los profesores)
        if($cta>=0){//Si he seleccionado el tipo de actividad
        if($ccl>0){ //Si he seleccionado alguna opcion de campo temático
            if($cdc>=0){ //Si he seleccionado alguna opción de destreza
                if($cgr>0){//Si he seleccionado alguna opción de tema gramatical
                    if($cic>0){//Si he seleccionado alguna opción intencion comunicativa
                        if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_todas_clasificaciones($ccl,$cta ,$cdc,$cgr,$cic,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_tt($ccl,$cta ,$cdc,$cgr,$cic);
                        }
                    }else{
                       if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_clasif_sin_ic($ccl,$cta ,$cdc,$cgr,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_ic_tt($ccl,$cta ,$cdc,$cgr);
                        } 
                    }
                }else{
                    
                    if($cic>0){//Si he seleccionado alguna opción intencion comunicativa
                        if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_sin_gr($ccl,$cta ,$cdc,$cic,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_gr_tt($ccl,$cta ,$cdc,$cic);
                        }
                    }else{
                       if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_clasif_sin_gr_ic($ccl,$cta ,$cdc,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_gr_ic_tt($ccl,$cta ,$cdc);
                        } 
                    }
                    
                }
                
            }else{
                
                if($cgr>0){//Si he seleccionado alguna opción de tema gramatical
                    if($cic>0){//Si he seleccionado alguna opción intencion comunicativa
                        if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->clasif_sin_dc($ccl,$cta,$cgr,$cic,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_dc_tt($ccl,$cta,$cgr,$cic);
                        }
                    }else{
                       if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_clasif_sin_dc_ic($ccl,$cta,$cgr,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_dc_ic_tt($ccl,$cta,$cgr);
                        } 
                    }
                }else{
                    
                    if($cic>0){//Si he seleccionado alguna opción intencion comunicativa
                        if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_sin_dc_gr($ccl,$cta,$cic,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_dc_gr_tt($ccl,$cta,$cic);
                        }
                    }else{
                       if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_clasif_sin_dc_gr_ic($ccl,$cta,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_dc_gr_ic_tt($ccl,$cta);
                        } 
                    }
                    
                }
                
            }
        }else{
               if($cdc>=0){ //Si he seleccionado alguna opción de destreza
                if($cgr>0){//Si he seleccionado alguna opción de tema gramatical
                    if($cic>0){//Si he seleccionado alguna opción intencion comunicativa
                        if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_clasif_sin_cl($cta,$cdc,$cgr,$cic,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_cl_tt($cta,$cdc,$cgr,$cic);
                        }
                    }else{
                       if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_clasif_sin_cl_ic($cta,$cdc,$cgr,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_cl_ic_tt($cta,$cdc,$cgr);
                        } 
                    }
                }else{
                    
                    if($cic>0){//Si he seleccionado alguna opción intencion comunicativa
                        if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_sin_cl_gr($cta,$cdc,$cic,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_cl_gr_tt($cta,$cdc,$cic);
                        }
                    }else{
                       if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_clasif_sin_cl_gr_ic($cta,$cdc,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_cl_gr_ic_tt($cta,$cdc,$USER->id);
                        } 
                    }
                    
                }
                
            }else{
                
                if($cgr>0){//Si he seleccionado alguna opción de tema gramatical
                    if($cic>0){//Si he seleccionado alguna opción intencion comunicativa
                        if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_clasif_sin_cl_dc($cta,$cgr,$cic,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_cl_dc_tt($cta,$cgr,$cic);
                        }
                    }else{
                       if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_clasif_sin_cl_dc_ic($cta,$cgr,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_cl_dc_ic_tt($cta,$cgr);
                        } 
                    }
                }else{
                    
                    if($cic>0){//Si he seleccionado alguna opción intencion comunicativa
                        if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_sin_cl_dc_gr($cta,$cic,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_cl_dc_gr_tt($cta,$cic);
                        }
                    }else{
                       if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_clasif_sin_cl_dc_gr_ic($cta,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_cl_dc_gr_ic_tt($cta);
                        } 
                    }
                    
                }
                
            }
        }
        
        
        
        
        
        
        
        
        
        
        
        
        
        }else{
             if($ccl>0){ //Si he seleccionado alguna opcion de campo temático
            if($cdc>=0){ //Si he seleccionado alguna opción de destreza
                if($cgr>0){//Si he seleccionado alguna opción de tema gramatical
                    if($cic>0){//Si he seleccionado alguna opción intencion comunicativa
                        if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_sin_ta($ccl,$cdc,$cgr,$cic,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_ta_tt($ccl,$cdc,$cgr,$cic);
                        }
                    }else{
                       if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_clasif_sin_ta_ic($ccl,$cdc,$cgr,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_ta_ic_tt($ccl,$cdc,$cgr);
                        } 
                    }
                }else{
                    
                    if($cic>0){//Si he seleccionado alguna opción intencion comunicativa
                        if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_sin_ta_gr($ccl,$cdc,$cic,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_ta_gr_tt($ccl,$cdc,$cic);
                        }
                    }else{
                       if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_clasif_sin_ta_gr_ic($ccl,$cdc,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_ta_gr_ic_tt($ccl,$cdc);
                        } 
                    }
                    
                }
                
            }else{
                
                if($cgr>0){//Si he seleccionado alguna opción de tema gramatical
                    if($cic>0){//Si he seleccionado alguna opción intencion comunicativa
                        if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->clasif_sin_ta_dc($ccl,$cgr,$cic,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_ta_dc_tt($ccl,$cgr,$cic);
                        }
                    }else{
                       if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_clasif_sin_ta_dc_ic($ccl,$cgr,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_ta_dc_ic_tt($ccl,$cgr);
                        } 
                    }
                }else{
                    
                    if($cic>0){//Si he seleccionado alguna opción intencion comunicativa
                        if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_sin_ta_dc_gr($ccl,$cic,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_ta_dc_gr_tt($ccl,$cic);
                        }
                    }else{
                       if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_clasif_sin_ta_dc_gr_ic($ccl,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_ta_dc_gr_ic_tt($ccl);
                        } 
                    }
                    
                }
                
            }
        }else{
               if($cdc>=0){ //Si he seleccionado alguna opción de destreza
                if($cgr>0){//Si he seleccionado alguna opción de tema gramatical
                    if($cic>0){//Si he seleccionado alguna opción intencion comunicativa
                        if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_clasif_sin_ta_cl($cdc,$cgr,$cic,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_ta_cl_tt($cdc,$cgr,$cic);
                        }
                    }else{
                       if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_clasif_sin_ta_cl_ic($cdc,$cgr,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_ta_cl_ic_tt($cdc,$cgr);
                        } 
                    }
                }else{
                    
                    if($cic>0){//Si he seleccionado alguna opción intencion comunicativa
                        if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_sin_ta_cl_gr($cdc,$cic,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_ta_cl_gr_tt($cdc,$cic);
                        }
                    }else{
                       if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_clasif_sin_ta_cl_gr_ic($cdc,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_ta_cl_gr_ic_tt($cdc,$USER->id);
                        } 
                    }
                    
                }
                
            }else{
                
                if($cgr>0){//Si he seleccionado alguna opción de tema gramatical
                    if($cic>0){//Si he seleccionado alguna opción intencion comunicativa
                        if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_clasif_sin_ta_cl_dc($cgr,$cic,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_ta_cl_dc_tt($cgr,$cic);
                        }
                    }else{
                       if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_clasif_sin_ta_cl_dc_ic($cgr,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_ta_cl_dc_ic_tt($cgr);
                        } 
                    }
                }else{
                    
                    if($cic>0){//Si he seleccionado alguna opción intencion comunicativa
                        if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_sin_ta_cl_dc_gr($cic,$ctt);
                        }else{
                             $buscados=$ejercicios_general->buscar_clasif_sin_ta_cl_dc_gr_tt($cic);
                        }
                    }else{
                       if($ctt>1){//Si he seleccionado alguna opción de tipologia textual
                             $buscados=$ejercicios_general->buscar_clasif_sin_ta_cl_dc_gr_ic($ctt);
                        }else{
                             //no hay criterio de busqueda
                        } 
                    }
                    
                }
                
            }
            
        }
        }

      
        $numencontrados=sizeof($buscados);
        
          $carpeta='<ul id="menuaux">';
         for($i=0;$i<$numencontrados;$i++){
    
     
           $carpeta.='<ul id="classul">';

            $nombre_ejercicio= $buscados[$i]->get('name');
            //Añado un enlace por cada ejercicio dentro de la carpeta
            $id_ejercicio=$buscados[$i]->get('id');
            $carpeta.='<li style="width:750px;"><a id="classa" href="./view.php?opcion=8&id='.$id.'&id_ejercicio='.$id_ejercicio.'&buscar=1">'. $nombre_ejercicio.'</a></li>';
                
            
            
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


?>
