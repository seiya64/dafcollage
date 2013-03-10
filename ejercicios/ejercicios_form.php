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
/*Para poder acceder a los tipos de gramatica*/
require_once("../vocabulario/vocabulario_classes.php");
require_once("../vocabulario/lib.php");
class mod_ejercicios_hacer_puzzle_form extends moodleform_mod {

     function definition() {
     }
     
         function mod_ejercicios_hacer_puzzle_form($id,$name,$tipo)
        {
         // El fichero que procesa el formulario es gestion.php
         parent::moodleform('mostrar_ejercicio.php?id_curso='.$id."&name=".$name."&tipo=".$tipo);
       }
     /**
     * Function that add a table to the forma to show the main menu
     *
     * @author Serafina Molina Soto
     * @param $id id for the course
     * @param $id_ej id del ejercicio a pinar
     */
     function pintarejercicio($id,$nombre,$tipo){
         
      
        global $CFG, $COURSE, $USER;
        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);

    
        //Los iconos están sacados del tema de gnome que viene con ubuntu 11.04
       
       //inclusion del javascript para las funciones
    
          
        $mform =& $this->_form;
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./style.css">');
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>');
    	$mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="funciones.js"></script>');
        

         //Visualizando el ejericio
         $titulo= '<h1>' .  $nombre . '</h1>';
         $mform->addElement('html',$titulo);

         //Cojo el ejercicio de la be
         
       
         $ejercicios_bd = new Ejercicios_mis_puzzledoble();
         $ejercicios_leido =$ejercicios_bd->obtener_uno_name($nombre);

          $tabla_imagenes = '<table width="100%">'  ;
          $mform = & $this->_form;
            //$mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./style.css">');
          $tabla_imagenes .='<td>'; #columna
            
         
          $tabla_imagenes.='<center><table>';
         
            switch($tipo){
                default;
                case 1:
                      for($i=1;$i<=$ejercicios_leido->get('nrespuestas');$i++)
                    $tabla_imagenes.='<td><div class="item" id="'.$i.'"><img src="./imagenes/'.$nombre.'_'.$i.'" alt="foto'.$i.'"  height="100px"  width="100px"/></div></td>';
                      break;
                case 2:
                    for($i=1;$i<=$ejercicios_leido->get('nrespuestas');$i++)
                    $tabla_imagenes.='<td><div  class="item" id="'.$i.'"><embed="./imagenes/'.$nombre.'_'.$i.' HEIGHT=300 WIDTH=400 AUTOSTART=false LOOP=false> </div></td>';
                    break;
            
                case 3: 
                      for($i=1;$i<=$ejercicios_leido->get('nrespuestas');$i++){
                          $palabra="texto".$i;
                          $tabla_imagenes.='<td><div  class="item" id="'.$i.'">'.$ejercicios_leido->get($palabra).'</div></td>';
                      }
                     
                      
                    break;
            }
          
	$tabla_imagenes.='</table></center>';
	
        
        $tabla_imagenes.='<center><table>';
        $i=1;
        $aleatorios_generados=array();
            while($i<=$ejercicios_leido->get('nrespuestas')){
                 //alimentamos el generador de aleatorios
                  srand (time());
                   //generamos un número aleatorio
                   $numero_aleatorio = rand(1,$ejercicios_leido->get('nrespuestas'));
                 
                   //buscamos si aleatorios contine
                   $esta=false;
                   for($j=0;$j< sizeof($aleatorios_generados);$j++){
                       if($aleatorios_generados[$j]==$numero_aleatorio){
                           $esta=true;
                       }
                   }
                   if($esta == false ){
                       $descripcion="des".$numero_aleatorio;
                      
                            
                            $tabla_imagenes.='<tr>';
                            $tabla_imagenes.='<td><div  id="'.$numero_aleatorio.'" class="marquito"></div></td>';
                            $tabla_imagenes.='<td><div class=descripcion>';
                            
                           
                            for($l=0;$l<strlen($ejercicios_leido->get($descripcion));$l=$l+50){
                                $parte=substr($ejercicios_leido->get($descripcion),$l,50);
                                 $tabla_imagenes.=$parte.'<br/>';
                            }
                             $tabla_imagenes.'</div></td>';
                            $tabla_imagenes.='<td id="aceptado'.$numero_aleatorio.'" class="marquitoaceptado"></td>';
                            $tabla_imagenes.='</tr>';
                        
                         $aleatorios_generados[]=$numero_aleatorio;
                         $i++;
                        
                   }
            }
            
        $tabla_imagenes.='</table></center>';
        
        $tabla_imagenes.='<p class="numero" id="'.$ejercicios_leido->get('nrespuestas').'"></p>';
          //botones
        $tabla_imagenes.='<center><input type="button" style="height:40px; width:60px;" id="botonResultado" value="Corregir">';
        $tabla_imagenes.='<input type="submit" style="height:40px; width:60px;" id="submitbutton" value="Rehacer"></center>';

        $tabla_imagenes .='</td>';
        $tabla_imagenes .='<td  width="10%">';
            //Mis palabras
        $tabla_imagenes .='<div><a  onclick=JavaScript:sele('.$id.')><img src="../vocabulario/imagenes/guardar_palabras.png" id="id_guardar_im" name="guardar_im" title="'.get_string('guardar', 'vocabulario').'"/></a></div>';
        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=5"><img src="../vocabulario/imagenes/administrar_gramaticas.png" id="id_gram_im" name="gram_im" title="'. get_string('admin_gr', 'vocabulario') . '"/></a></div>';
        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=7"><img src="../vocabulario/imagenes/intenciones_comunicativas.png" id="id_ic_im" name="ic_im" title="'. get_string('admin_ic', 'vocabulario') . '"/></a></div>';
        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=9"><img src="../vocabulario/imagenes/tipologias_textuales.png" id="id_tt_im" name="tt_im" title="'. get_string('admin_tt', 'vocabulario') .'"/> </a></div>';
        $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=11"><img src="../vocabulario/imagenes/estrategias_icon.png" id="id_ea_im" name="ea_im" title="'. get_string('admin_ea', 'vocabulario') .'"/> </a></div>';
            
        $tabla_imagenes .='</td>'; 

        $tabla_imagenes .='</table>'; 
     
        $mform->addElement('html',$tabla_imagenes);
        
        
       
    }
    
  
 
}




/**
*  Interfaz Principal para el alumno y el profesor
*
* @author Serafina Molina Soto
* @param $id id for the course

*/


class mod_ejercicios_mod_form extends moodleform_mod {
    
    function mod_ejercicios_mod_form($id)
        {
         // El fichero que procesa el formulario es gestion.php
         parent::moodleform('hacer_ejercicio_inicio.php?id_curso='.$id);
       }

     function definition() {
     }
     /**
     * Function that add a table to the forma to show the main menu
     *
     * @author Serafina Molina Soto
     * @param $id id for the course
     *
     */
     function pintaropciones($id){
         global $CFG, $COURSE, $USER;
        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);
        $mform = & $this->_form;
  
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./estilo.css">');
     //compruebo si soy profesor
       if (has_capability('moodle/legacy:editingteacher', $context, $USER->id, false)){
            
            $tabla_menu .=  '<h1><center>'.get_string('Actividades', 'ejercicios').'</center></h1>';
          
            
            $tabla_menu .=  '<div id="divflotanteizq">';
            $tabla_menu .=  '<h2 class="titulo">'.get_string('Buscar', 'ejercicios').'</h2>';
        
            $tabla_menu.='<ul class="ullista" id="menubuscar">';
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">'.get_string('Tema','ejercicios').'</a></li>';
            
              //inclusion del javascript para las funciones
           $mform->addElement('html', '<script type="text/javascript" src="./funciones.js"></script>');

            #incluyo la parte de vocabulario
           
            #buscando por tema de palabras
            
           $mform->addElement('html', $tabla_menu);
                    
           $aux = new Vocabulario_campo_lexico();
           $clex = $aux->obtener_hijos($USER->id, 0);
  
        
            //campo lexico
           $mform->addElement('select', 'campoid', null, $clex, "onChange='javascript: if( this.options[this.selectedIndex].text == \"--\" || this.options[this.selectedIndex].text == \"Seleccionar\" ) { this.selectedIndex == 0; this.options[0].selected = true; document.getElementById(\"clgeneraldinamico\").style.display=\"none\";} else { cargaContenido(this.id,\"clgeneraldinamico\",0); document.getElementById(\"clgeneraldinamico\").style.display=\"\";}' style=\"min-height: 0;\"");
           //probar los campos dinamicos
           $campodinamico = "<div id=\"clgeneraldinamico\"></div>";
           $mform->addElement('html', $campodinamico);
          
                    
             //Buscando por tema
            $tabla_menu='<ul class="ullista">';
             
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">'.get_string('Tipo de Actividad','ejercicios').'</a></li>';
          
            $clasificaciontipo=array();
            
            for($i=0;$i<14;$i++){
            $clasificaciontipo[]=get_string('Tipo'.$i,'ejercicios');
       
            }
           
             
            $tabla_menu.='<select id="TipoActividad" style="width: 380px;" class="selectbuscar">';
             
             for($i=0;$i<sizeof($clasificaciontipo);$i++){
                 $tabla_menu.='<option value="'.$i.'">'.$clasificaciontipo[$i].'</option>';
             }
            $tabla_menu.='</select>';
           
            $tabla_menu.='</ul>';
            
             $mform->addElement('html', $tabla_menu);
             
             //Buscando por Destreza comunicativa
        
            $tabla_menu='<ul class="ullista">';
             
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">'.get_string('Destreza comunicativa','ejercicios').'</a></li>';
          
            
               
            $clasificaciondestreza=array();
            
            for($i=0;$i<7;$i++){
            $clasificaciondestreza[]=get_string('Destreza'.$i,'ejercicios');
       
            }
           
            
          
            $tabla_menu.='<select id="DestrezaComunicativa" style="width: 380px;" class="selectbuscar">';
             
             for($i=0;$i<sizeof($clasificaciondestreza);$i++){
                 $tabla_menu.='<option value="'.$i.'">'.$clasificaciondestreza[$i].'</option>';
             }
            $tabla_menu.='</select>';
           
            $tabla_menu.='</ul>';
            
             $mform->addElement('html', $tabla_menu);
         
             //Buscando por Gramática
             $tabla_menu='<ul class="ullista">';
             
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">'.get_string('Gramatica','ejercicios').'</a></li>';
            $mform->addElement('html', $tabla_menu);
            $grid = optional_param('grid', 0, PARAM_INT);
             

            $aux = new Vocabulario_gramatica();
            $gramaticas = $aux->obtener_hijos($USER->id, 0);
            $lista_padres = $aux->obtener_padres($USER->id, $grid);
            
            $mform->addElement('select', 'campogr', null, $gramaticas, "onChange='javascript:cargaContenido(this.id,\"grgeneraldinamico\",1)' style=\"min-height: 0;\"");
            $mform->setDefault('campogr', $lista_padres[1]);
            //probar los campos dinamicos
            $i = 1;
            $divparacerrar = 0;
            $campodinamico = "<div class=\"fitem\" id=\"grgeneraldinamico\"  style=\"min-height: 0;\">";
            while ($lista_padres[$i + 1]) {
                $aux = new Vocabulario_gramatica();
                $graux = $aux->obtener_hijos($USER->id, $lista_padres[$i]);
                $campodinamico .= '<div class="fitemtitle"></div>';
                $campodinamico .= '<div class="felement fselect">';
                $elselect = new MoodleQuickForm_select('campogr', 'Subcampo', $graux, "id=\"id_campogr" . $lista_padres[$i] . "\" onChange='javascript:cargaContenido(this.id,\"" . 'campogr' . "grgeneraldinamico" . $lista_padres[$i] . "\",1)'");
                $elselect->setSelected($lista_padres[$i + 1]);
                $campodinamico .= $elselect->toHtml();
                $campodinamico .= '</div>';
                $campodinamico .= "<div class=\"fitem\" id=\"" . 'campogr' . "grgeneraldinamico" . $lista_padres[$i] . "\" style=\"min-height: 0;\">";
                $i = $i + 1;
                $divparacerrar++;
            }
            for ($i = 0; $i < $divparacerrar; $i++) {
                $campodinamico .= "</div>";
            }
            $campodinamico .= "</div>";
            $mform->addElement('html', $campodinamico);

     
            $tabla_menu='</ul>';
            
            //Buscando por Intencion comunicativa
             $tabla_menu.='<ul class="ullista">';
             
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">'.get_string('Intencion','ejercicios').'</a></li>';
            $mform->addElement('html', $tabla_menu);
           // $grid = optional_param('grid', 0, PARAM_INT);
             

             
            $aux = new Vocabulario_intenciones();
            $icom = $aux->obtener_hijos($USER->id, 0);
            $lista_padres = $aux->obtener_padres($icid);
            
            $mform->addElement('select', 'campoic',"", $icom, "onChange='javascript:cargaContenido(this.id,\"icgeneraldinamico\",2)' style=\"min-height: 0;\"");
            $mform->setDefault('campoic', $lista_padres[1]);
            //probar los campos dinamicos
            $i = 1;
            $divparacerrar = 0;
            $campodinamico = "<div class=\"fitem\" id=\"icgeneraldinamico\"  style=\"min-height: 0;\">";
            while ($lista_padres[$i + 1]) {
                $aux = new Vocabulario_intenciones();
                $icaux = $aux->obtener_hijos($USER->id, $lista_padres[$i]);
                $campodinamico .= '<div class="fitemtitle"></div>';
                $campodinamico .= '<div class="felement fselect">';
                $elselect = new MoodleQuickForm_select('campoic', 'Subcampo', $icaux, "id=\"id_campoic" . $lista_padres[$i] . "\" onChange='javascript:cargaContenido(this.id,\"" . 'campoic' . "icgeneraldinamico" . $lista_padres[$i] . "\",2)'");
                $elselect->setSelected($lista_padres[$i + 1]);
                $campodinamico .= $elselect->toHtml();
                $campodinamico .= '</div>';
                $campodinamico .= "<div class=\"fitem\" id=\"" . 'campoic' . "icgeneraldinamico" . $lista_padres[$i] . "\" style=\"min-height: 0;\">";
                $i = $i + 1;
                $divparacerrar++;
            }
            for ($i = 0; $i < $divparacerrar; $i++) {
                $campodinamico .= "</div>";
            }
            $campodinamico .= "</div>";
            $mform->addElement('html', $campodinamico);

     
            $tabla_menu='</ul>';
          
            //Buscando por Tipologia textual
            $tabla_menu.='<ul class="ullista">';
             
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">'.get_string("campo_tipologia", "vocabulario").'</a></li>';
            $mform->addElement('html', $tabla_menu);
           // $grid = optional_param('grid', 0, PARAM_INT);
             
            $aux = new Vocabulario_tipologias();
            $tipologias = $aux->obtener_todos($USER->id);
            $mform->addElement('select', 'campott', "", $tipologias);
           
            $mform->addElement('html', $campodinamico);

     
            $tabla_menu='</ul>';
            
            $tabla_menu.='</ul>';
                 
            $tabla_menu.='<center><input id="id_buscando" type="button" style="height:30px; width:60px; margin-left:175px;" value="'.get_string('Boton_Buscar', 'ejercicios').'" onclick="botonBuscar('.$id.');"></center>';
            

            $tabla_menu.='<div style="height:20px"></div>';
            $tabla_menu .=  '<h2 class="titulo">'.get_string('Crear', 'ejercicios').'</h2>';
          
             //Creando por tipo de actividad
            $tabla_menu.='<ul class="ullista">';
             
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">'.get_string('Tipo de Actividad','ejercicios').'</a></li>';
          
            $clasificaciontipo=array();
            
            for($i=0;$i<14;$i++){
            $clasificaciontipo[]=get_string('Tipo'.$i,'ejercicios');
       
            }
           
             
            $tabla_menu.='<select id="TipoActividadCrear" style="width: 380px;" class="selectbuscar">';
             
             for($i=0;$i<sizeof($clasificaciontipo);$i++){
                 $tabla_menu.='<option value="'.$i.'">'.$clasificaciontipo[$i].'</option>';
             }
            $tabla_menu.='</select>';
           
         
            
            $tabla_menu.='</ul>';
            
            
            $tabla_menu.='<center><input id="id_creando" type="button" style="height:30px; width:60px; margin-left:175px;" value="'.get_string('Boton_Crear','ejercicios').'" onclick="botonCrear('.$id.');"></center>';
            $tabla_menu.='</div>';
            
         
            //parte del ejercicio
         
            $tabla_menu .='<div id="parteejercicio">';
           
            $tipo1= new Ejercicios_mis_puzzledoble();
            #selecciono los ejercicios para generar uno aleatorio a mostrar
            $ej_tipo1= $tipo1->obtener_todos();
            $tam1=sizeof($ej_tipo1);
            //alimentamos el generador de aleatorios
            srand (time());
            //generamos un número aleatorio
             $numero_aleatorio = rand(1,$tam1);
             
            if($tam1!=0){
               $nombre=$ej_tipo1[$numero_aleatorio-1];
               $nombre=$nombre->get('name');
               
               $tabla_menu.= '<h2 id="name">'.$nombre.'</h2>';
               $mform->addElement('hidden', 'oculto1',$nombre);
             
               //$mform->addElement('hidden', 'oculto2',$ctipo);
               $tabla_menu.='<center><img src="./imagenes/'.$nombre.'_1" alt="imagen de un ejercicio"  height="70%"  width="70%px"/></center>';
               $tabla_menu.='<center><input type="submit" style="height:30px; width:60px;" id="botonRealizar" value="'.get_string('Realizar','ejercicios').'"/></center>';
            }
            $tabla_menu .='</div>';
            
            $tabla_menu .='<div id="partevocabulario">';
                        //Mis palabras
            $tabla_menu .='<div style="margin-top:100px;"><a href="../vocabulario/view.php?id=' . $id . '&opcion=1"><img src="../vocabulario/imagenes/guardar_palabras.png" id="id_guardar_im" name="guardar_im" title="'.get_string('guardar', 'vocabulario').'"/></a></div>';
            $tabla_menu .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=5"><img src="../vocabulario/imagenes/administrar_gramaticas.png" id="id_gram_im" name="gram_im" title="'. get_string('admin_gr', 'vocabulario') . '"/></a></div>';
            $tabla_menu .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=7"><img src="../vocabulario/imagenes/intenciones_comunicativas.png" id="id_ic_im" name="ic_im" title="'. get_string('admin_ic', 'vocabulario') . '"/></a></div>';
            $tabla_menu .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=9"><img src="../vocabulario/imagenes/tipologias_textuales.png" id="id_tt_im" name="tt_im" title="'. get_string('admin_tt', 'vocabulario') .'"/> </a></div>';
            $tabla_menu .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=11"><img src="../vocabulario/imagenes/estrategias_icon.png" id="id_ea_im" name="ea_im" title="'. get_string('admin_ea', 'vocabulario') .'"/> </a></div>';

            $tabla_menu .='</div>';
            
            $tabla_menu.=  '<h2 class="titulomisactividades">'.get_string('MisActividades', 'ejercicios').'</h2>';

            $tabla_menu.='<center><a href="./view.php?id=' . $id . '&opcion=9"><img  class="misactividades" src="./imagenes/activ.svg" id="id_MisActividades" name="MisActividades" title="'. get_string('MisActividades', 'ejercicios') . '"/></a></center>';
            
            
              $tabla_menu.=  '<h2 class="componeractividades">'.get_string('componerActividades', 'ejercicios').'</h2>';

            $tabla_menu.='<center><a href="./view.php?id=' . $id . '&opcion=9"><img  class="misactividades" src="./imagenes/componer.png" id="id_MisActividades" name="MisActividades" title="'. get_string('MisActividades', 'ejercicios') . '"/></a></center>';
            /*$tabla_menu .=  '<div id="divflotantederecha">';
            $tabla_menu .=  '<h2 class="titulo">'.get_string('Crear', 'ejercicios').'</h2>';
            $tabla_menu .=  '<div style="height:20px"></div>';
            $tabla_menu.='<ul class="ullista" id="menubuscar">';
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">'.get_string('Tema','ejercicios').'</a>';
            $tabla_menu.='<ul class="ullista">';
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">Submenu 1</a></li>';
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">Submenu 2</a></li>';
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">Submenu 3</a></li>';
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">Submenu 4</a></li>';
            $tabla_menu.='</ul>';
            $tabla_menu.='</li>';
            $tabla_menu.='<li class="lilista"><a  id="enlacemenu" href="#">'.get_string('Tipo de Actividad','ejercicios').'</a>';
            $tabla_menu.='<ul class="ullista">';
            $tabla_menu.='<li class="lilista"><a  id="enlacemenu" href="#">Submenu 1</a></li>';
            $tabla_menu.='<li class="lilista"><a  id="enlacemenu" href="#">Submenu 2</a></li>';
            $tabla_menu.='<li class="lilista"><a  id="enlacemenu" href="#">Submenu 3</a></li>';
            $tabla_menu.='<li class="lilista"><a  id="enlacemenu" href="#">Submenu 4</a></li>';
            $tabla_menu.='</ul>';
            $tabla_menu.='</li>';
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">'.get_string('Destreza comunicativa','ejercicios').'</a>';
            $tabla_menu.='<ul class="ullista">';
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">Submenu 1</a></li>';
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">Submenu 2</a></li>';
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">Submenu 3</a></li>';
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">Submenu 4</a></li>';
            $tabla_menu.='</ul class="ullista">';
            $tabla_menu.='</li>';
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">'.get_string('Gramatica','ejercicios').'</a>';
            $tabla_menu.='<ul class="ullista">';
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">Submenu 1</a></li>';
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">Submenu 2</a></li>';
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">Submenu 3</a></li>';
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">Submenu 4</a></li>';
            $tabla_menu.='</ul class="ullista">';
            $tabla_menu.='</li>';
            $tabla_menu.='</ul>';
            $tabla_menu.='</div>';*/
            
            $mform->addElement('html', $tabla_menu);

        //Los iconos están sacados del tema de gnome que viene con ubuntu 11.04
    
        
   /*     $tabla_menu = '<div id="viewcanvas" class="boxaligncenter"><div class="menu left flexible generaltable cajagranancho" style="text-align:center;">';
  
  
        $tabla_menu .='<div class="menurow"><div class="menuitem left" style="text-align:left"><a href="view.php?id=' . $id . '&opcion=1"><img src="./imagenes/ej1" id="id_guardar_im" name="guardar_im"/><div class="texto">' . get_string('Puzzledoble', 'ejercicios') . '</div></a></div>';
       
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
        */
       
      }else{ #si soy alumno
            
       $tabla_menu .=  '<h1><center>'.get_string('Actividades', 'ejercicios').'</center></h1>';
          
            
            $tabla_menu .=  '<div id="divflotanteizq">';
            $tabla_menu .=  '<h2 class="titulo">'.get_string('Buscar', 'ejercicios').'</h2>';
        
            $tabla_menu.='<ul class="ullista" id="menubuscar">';
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">'.get_string('Tema','ejercicios').'</a></li>';
            
              //inclusion del javascript para las funciones
           $mform->addElement('html', '<script type="text/javascript" src="./funciones.js"></script>');

            #incluyo la parte de vocabulario
           
            #buscando por tema de palbras
            
           $mform->addElement('html', $tabla_menu);
                    
           $aux = new Vocabulario_campo_lexico();
           $clex = $aux->obtener_hijos($USER->id, 0);
     
      /*     echo sizeof($clex);
          $tabla_menu='<select id="id_campoid"  onChange="javascript: subgram(this.id)">';
            foreach ($clex as $opcion) {
                 $tabla_menu.='<option value="'.$opcion.'">'.$opcion.'</option>';
             }
           $tabla_menu.='</select>';
           $mform->addElement('html', $tabla_menu);*/
        
            //campo lexico
           $mform->addElement('select', 'campoid', null, $clex, "onChange='javascript: if( this.options[this.selectedIndex].text == \"--\" || this.options[this.selectedIndex].text == \"Seleccionar\" ) { this.selectedIndex == 0; this.options[0].selected = true; document.getElementById(\"clgeneraldinamico\").style.display=\"none\";} else { cargaContenido(this.id,\"clgeneraldinamico\",0); document.getElementById(\"clgeneraldinamico\").style.display=\"\";}' style=\"min-height: 0;\"");
           //probar los campos dinamicos
           $campodinamico = "<div id=\"clgeneraldinamico\"></div>";
           $mform->addElement('html', $campodinamico);
          
                    
             //Buscando por tema
            $tabla_menu='<ul class="ullista">';
             
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">'.get_string('Tipo de Actividad','ejercicios').'</a></li>';
          
            $clasificaciontipo=array();
            $clasificaciontipo[]="--";
            $clasificaciontipo[]="ELECCIÓN MÚLTIPLE con sus diversas variantes";
            $clasificaciontipo[]="ASOCIACIÓN SIMPLE";
            $clasificaciontipo[]="ASOCIACIÓN COMPLEJA";
            $clasificaciontipo[]="TEXTO HUECO";
            $clasificaciontipo[]="IDENTIFICAR ELEMENTOS";
            $clasificaciontipo[]="RESPUESTA ABIERTA";
            $clasificaciontipo[]="CRUCIGRAMA";
            $clasificaciontipo[]="ORDENAR ELEMENTOS";
            $clasificaciontipo[]="IDENTIFICAR ELEMENTOS MÁS RESPUESTA CORTA";
            $clasificaciontipo[]="IDENTIFICAR ELEMENOS CON ASOCIACIÓN SIMPLE";
            $clasificaciontipo[]="IDENTIFICAR ELEMENOS CON  RESPUESTA MÚLTIPLE";
            $clasificaciontipo[]="PRACTICAR PRONUNCIACIÓN";
        
           
             
            $tabla_menu.='<select id="TipoActividad" style="width: 380px;" class="selectbuscar">';
             
             for($i=0;$i<sizeof($clasificaciontipo);$i++){
                 $tabla_menu.='<option value="'.$i.'">'.$clasificaciontipo[$i].'</option>';
             }
            $tabla_menu.='</select>';
           
            $tabla_menu.='</ul>';
            
             $mform->addElement('html', $tabla_menu);
             
             //Buscando por Destreza comunicativa
        
            $tabla_menu='<ul class="ullista">';
             
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">'.get_string('Destreza comunicativa','ejercicios').'</a></li>';
          
            $clasificaciondestreza=array();
            $clasificaciondestreza[]="--";
            $clasificaciondestreza[]="COMPRENSIÓN LECTORA";
            $clasificaciondestreza[]="COMPRENSIÓN ORAL";
            $clasificaciondestreza[]="EXPRESIÓN ESCRITA";
            $clasificaciondestreza[]="EXPRESIÓN ORAL";
            $clasificaciondestreza[]="TRADUCCIÓN";
                
             
            $tabla_menu.='<select id="DestrezaComunicativa" style="width: 380px;" class="selectbuscar">';
             
             for($i=0;$i<sizeof($clasificaciondestreza);$i++){
                 $tabla_menu.='<option value="'.$i.'">'.$clasificaciondestreza[$i].'</option>';
             }
            $tabla_menu.='</select>';
           
            $tabla_menu.='</ul>';
            
             $mform->addElement('html', $tabla_menu);
         
             //Buscando por Gramática
             $tabla_menu='<ul class="ullista">';
             
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">'.get_string('Gramatica','ejercicios').'</a></li>';
            $mform->addElement('html', $tabla_menu);
             $grid = optional_param('grid', 0, PARAM_INT);
             

             $aux = new Vocabulario_gramatica();
            $gramaticas = $aux->obtener_hijos($USER->id, 0);
            $lista_padres = $aux->obtener_padres($USER->id, $grid);
            
            $mform->addElement('select', 'campogr', null, $gramaticas, "onChange='javascript:cargaContenido(this.id,\"grgeneraldinamico\",1)' style=\"min-height: 0;\"");
            $mform->setDefault('campogr', $lista_padres[1]);
            //probar los campos dinamicos
            $i = 1;
            $divparacerrar = 0;
            $campodinamico = "<div class=\"fitem\" id=\"grgeneraldinamico\"  style=\"min-height: 0;\">";
            while ($lista_padres[$i + 1]) {
                $aux = new Vocabulario_gramatica();
                $graux = $aux->obtener_hijos($USER->id, $lista_padres[$i]);
                $campodinamico .= '<div class="fitemtitle"></div>';
                $campodinamico .= '<div class="felement fselect">';
                $elselect = new MoodleQuickForm_select('campogr', 'Subcampo', $graux, "id=\"id_campogr" . $lista_padres[$i] . "\" onChange='javascript:cargaContenido(this.id,\"" . 'campogr' . "grgeneraldinamico" . $lista_padres[$i] . "\",1)'");
                $elselect->setSelected($lista_padres[$i + 1]);
                $campodinamico .= $elselect->toHtml();
                $campodinamico .= '</div>';
                $campodinamico .= "<div class=\"fitem\" id=\"" . 'campogr' . "grgeneraldinamico" . $lista_padres[$i] . "\" style=\"min-height: 0;\">";
                $i = $i + 1;
                $divparacerrar++;
            }
            for ($i = 0; $i < $divparacerrar; $i++) {
                $campodinamico .= "</div>";
            }
            $campodinamico .= "</div>";
            $mform->addElement('html', $campodinamico);

     
            $tabla_menu='</ul>';
          
            $tabla_menu.='</ul>';
            $tabla_menu.='<center><input type="button" style="height:30px; width:60px; margin-left:175px;" id="botonBuscar" value="Buscar"></center>';
            $tabla_menu.='</div>';
            
     
            //parte del ejercicio
         
            $tabla_menu .='<div id="parteejercicioalumno">';
           
            $tipo1= new Ejercicios_mis_puzzledoble();
            #selecciono los ejercicios para generar uno aleatorio a mostrar
            $ej_tipo1= $tipo1->obtener_todos();
            $tam1=sizeof($ej_tipo1);
            //alimentamos el generador de aleatorios
            srand (time());
            //generamos un número aleatorio
             $numero_aleatorio = rand(1,$tam1);
             
            if($tam1!=0){
               $nombre=$ej_tipo1[$numero_aleatorio-1];
               $nombre=$nombre->get('name');
               
               $tabla_menu.= '<h2 id="name">'.$nombre.'</h2>';
               $mform->addElement('hidden', 'oculto1',$nombre);
             
               //$mform->addElement('hidden', 'oculto2',$ctipo);
               $tabla_menu.='<center><img src="./imagenes/'.$nombre.'_1" alt="imagen de un ejercicio"  height="70%"  width="70%px"/></center>';
               $tabla_menu.='<center><input type="submit" style="height:30px; width:60px;" id="botonRealizar" value="'.get_string('Realizar','ejercicios').'"></center>';
            }
            $tabla_menu .='</div>';
            
            $tabla_menu .='<div id="partevocabulario">';
                        //Mis palabras
            $tabla_menu .='<div style="margin-top:100px;"><a href="../vocabulario/view.php?id=' . $id . '&opcion=1"><img src="../vocabulario/imagenes/guardar_palabras.png" id="id_guardar_im" name="guardar_im" title="'.get_string('guardar', 'vocabulario').'"/></a></div>';
            $tabla_menu .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=5"><img src="../vocabulario/imagenes/administrar_gramaticas.png" id="id_gram_im" name="gram_im" title="'. get_string('admin_gr', 'vocabulario') . '"/></a></div>';
            $tabla_menu .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=7"><img src="../vocabulario/imagenes/intenciones_comunicativas.png" id="id_ic_im" name="ic_im" title="'. get_string('admin_ic', 'vocabulario') . '"/></a></div>';
            $tabla_menu .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=9"><img src="../vocabulario/imagenes/tipologias_textuales.png" id="id_tt_im" name="tt_im" title="'. get_string('admin_tt', 'vocabulario') .'"/> </a></div>';
            $tabla_menu .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=11"><img src="../vocabulario/imagenes/estrategias_icon.png" id="id_ea_im" name="ea_im" title="'. get_string('admin_ea', 'vocabulario') .'"/> </a></div>';

            $tabla_menu .='</div>';
            
       
            
            $mform->addElement('html', $tabla_menu);
      }
    }

  
 
}

class mod_ejercicios_puzzle_form extends moodleform_mod {

    function mod_ejercicios_puzzle_form($id)
        {
         // El fichero que procesa el formulario es gestion_form1.php
         parent::moodleform('gestion_asociacion1.php?id_curso='.$id);
       }
     function definition() {
        
         
     }

     function pintarinterfaz($id,$error){
         
        global $CFG, $COURSE, $USER;
        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);
        
        $tipo1= new Ejercicios_mis_puzzledoble();
        $aux = $tipo1->obtener_todos();
        $tamaño = sizeof($aux);

        
        $mform = $this->_form;
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./style.css">');

         
        $tabla_menu = '<table>';
        //esto puedo quitarlo
        $cosa = -1;
         if (has_capability('moodle/legacy:admin', $context, $USER->id, false)){
             $cosa = optional_param("cosa",0,PARAM_INT);

         }
         
         //compruebo si soy profesor
         if (has_capability('moodle/legacy:editingteacher', $context, $USER->id, false) || $cosa == 0){
            
              
             //Creando el ejercicio
             $titulo= '<h1>' . get_string('CrearEjercicioPuzzle', 'ejercicios') . '</h1>';
             $mform->addElement('html',$titulo);
             //gestion de errores anteriores
            switch ($error) {
               
                case 0:  //Todo ha ido bien
                    $mensaje_error= '<center><font color=blue>El ejercicio ha sido creado correctamente</font></center>';
                    break;
                case 1: //error en nombre
                     $mensaje_error= '<center><font color=red>El Ejercicio ya existe: Debe especificar otro nombre</font></center>';
                    break;
                default: //Inicialmente
                case -1:
                     $mensaje_error="";
                    break;

            }
               $mform->addElement('html',$mensaje_error);
            
             //Nombre del ejercicio
             $attributes='size="20"';
             $mform->addElement('text', 'nombre_ejercicio', get_string('Nombre', 'ejercicios'), $attributes);
             //Tiene que tener un nombre
             $mform->addRule('nombre_ejercicio', "Nombre", 'required', null, 'client');
             $numimagenes=array();
                //para permitir de 1 a 10 imagenes
             for($i=0;$i<9;$i++){
              $numimagenes[] = $i+1;
             }
             $mform->addElement('select', 'numeroimagenes', "Numero de elementos", $numimagenes);

            //para seleccionar la combinación

              $tipo=array (NULL=>"-------","Asociacion Simple"=> "Asociacion Simple","Asociacion Compleja"=>"Asociacion Compleja");
           

             $mform->addElement('select', 'ClasificacionTipo', "Clasificación por Tipo",$tipo );


             $radioarray=array();
             $radioarray[] = &MoodleQuickForm::createElement('radio', 'comb', '', "Imagen-Descripcion","Imagen-Descripcion", null);
             $radioarray[] = &MoodleQuickForm::createElement('radio', 'comb', '', "Video-Descripcion", "Video-Descripcion", null);
             $radioarray[] = &MoodleQuickForm::createElement('radio', 'comb', '', "Palabra-Descripcion", "Palabra-Descripcion", null);
             $mform->addGroup($radioarray, 'radioar', '', array(' '), false);
             $mform->setDefault('comb',"Imagen-Descripcion");

              
             //botones
             $buttonarray = array();
             $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('Aceptar','ejercicios'));
             $mform->addGroup($buttonarray, 'botones', '', array(' '), false);
            
            

               //Modificando el ejercicio
             if($tamaño>0){
                    $titulo= '<h1>' . get_string('tituloeliminar', 'ejercicios') . '</h1>';
                    $mform->addElement('html',$titulo);


                    $listaejercicios .= '<div align="center">';
                    $textomodificar=  '<h3>'. get_string('TextoEliminar', 'ejercicios') . '</h3>';
                    $mform->addElement('html',$textomodificar);

                    $listaejercicios .= '<select name="puzzle_creados" id="Select1" size="4">';

                    for($i=0;$i<$tamaño;$i++){

                    $listaejercicios .= '<option value="'.$aux[$i]->get('id').'">'.$aux[$i]->get('name').'</option>';


                    }
                    $listaejercicios .= '</select>';

                    $listaejercicios .= '</div>';

                    $mform->addElement('html',$listaejercicios);
                        //botones
              
                $buttonarray = array();
               
                $buttonarray[] = &$mform->createElement('cancel', 'cancelbutton', get_string('Borrar', 'ejercicios'));
   
                $buttonarray[] = &$mform->createElement('cancel', 'menuprincipal', get_string('Reset', 'ejercicios'));
                $mform->addGroup($buttonarray, 'botones', '', array(' '), false);
             
               
             }

        

        }else {
                $titulo= '<h1>' . get_string('Opcionespuzzlealum', 'ejercicios') . '</h1>';
                $mform->addElement('html',$titulo);
             
           //     $tabla_menu .= '<td><div class = "imagen"><div id="imagen3" ><img src="./imagenes/3.jpg" alt="foto3"/></div></div></td>';
        }
        
        $tabla_menu .= '</table>';
        
         $mform->addElement('html', $tabla_menu);
        

      
        
        
    }
        
       
        

 
}


//Una vez rellenado el primer paso en el que se indica
//Nombre, número de imagenes y combinación
//pasamos a rellenar las imagenes
class mod_ejercicios_puzzle_form_paso2 extends moodleform_mod {

    function mod_ejercicios_puzzle_form_paso2($id,$name)
        {
         // El fichero que procesa el formulario es gestion.php
         parent::moodleform('gestion.php?id_curso='.$id."&name=".$name);
       }
     function definition() {


     }

     function pintarinterfaz2($id,$name){

         global $CFG, $COURSE, $USER;
        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);
        
        $tipo1= new Ejercicios_mis_puzzledoble();
       
        $aux = $tipo1->obtener_uno_name($name);

        $nombre=$aux->get('name');
        $numero=$aux->get('nrespuestas');
        $tasociacion=$aux->get('elemaso');
       
        $mform = $this->_form;
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./style.css">');


        $tabla_menu = '<table>';
        //esto puedo quitarlo
        $cosa = -1;
         if (has_capability('moodle/legacy:admin', $context, $USER->id, false)){
             $cosa = optional_param("cosa",0,PARAM_INT);

         }

         //compruebo si soy profesor
         if (has_capability('moodle/legacy:editingteacher', $context, $USER->id, false) || $cosa == 0){


             //Creando el ejercicio
             $titulo= '<h1>' . "Creando ejercicio: " . $nombre.'</h1>';
             $mform->addElement('html',$titulo);
             //gestion de tipo de asociacion
            switch ($tasociacion) {
                default: 
                case "Imagen-Descripcion":  //Imagenes-Descripcion
                
                        //Seleccion de imagenes
                        for($i=1;$i<=$numero;$i++){
                            $mform->addElement('file', 'archivo'.$i,"Imagen".$i);
                            $mform->addRule('archivo'.$i, "Imagen Necesaria", 'required', null, 'client');
                            $mform->addElement('textarea', 'descripcion'.$i,"Descripcion Imagen".$i, 'wrap="virtual" rows="5" cols="50"');
                            $mform->addRule('descripcion'.$i, "Descripcion Necesaria", 'required', null, 'client');

                        }
                        $mform->addElement('hidden', 'oculto',1);

                    break;
                case "Video-Descripcion":  //Imagenes-Descripcion
                        
                        //Seleccion de imagenes
                        for($i=1;$i<=$numero;$i++){
                            $mform->addElement('file', 'archivo'.$i,"Video".$i);
                            $mform->addRule('archivo'.$i, "Video Necesaria", 'required', null, 'client');
                            $mform->addElement('textarea', 'descripcion'.$i,"Descripcion Video".$i, 'wrap="virtual" rows="5" cols="50"');
                            $mform->addRule('descripcion'.$i, "Descripcion Necesaria", 'required', null, 'client');

                        }
                         $mform->addElement('hidden','oculto',2);

               break;
               
              case "Palabra-Descripcion":  //Imagenes-Descripcion
                        
                        //Seleccion de imagenes
                        for($i=1;$i<=$numero;$i++){
                             $attributes='size="20"';
                            $mform->addElement('text', 'palabra'.$i, 'Palabra'.$i, $attributes);
                            $mform->addRule('palabra'.$i, "Palabra Necesaria", 'required', null, 'client');
                            $mform->addElement('textarea', 'descripcion'.$i,"Descripcion Palabra".$i, 'wrap="virtual" rows="5" cols="50"');
                            $mform->addRule('descripcion'.$i, "Descripcion Necesaria", 'required', null, 'client');

                        }
                         $mform->addElement('hidden','oculto',3);

               break;
           
           

            }


             //botones
             $buttonarray = array();
             $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('Aceptar','ejercicios'));
             $mform->addGroup($buttonarray, 'botones', '', array(' '), false);




         }

    }





}




?>
