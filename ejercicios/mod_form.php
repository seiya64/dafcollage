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
require_once($CFG->dirroot.'/mod/vocabulario/vocabulario_classes.php');
require_once($CFG->dirroot.'/mod/vocabulario/lib.php');

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



/**
*  Interfaz Principal para el alumno y el profesor
*
* @author Serafina Molina Soto
* @param $id id for the course

*/


class mod_ejercicios_mod_formulario extends moodleform_mod {
    
  /*  function mod_ejercicios_mod_form($id)
       {
         // El fichero que procesa el formulario es gestion.php
        parent::moodleform('hacer_ejercicio_inicio.php?id_curso='.$id);
       }
*/
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
            $tabla_menu.= '<h2 class="titulo">'.get_string('Crear', 'ejercicios').'</h2>';
          
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
     /*    
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
            */
            $tabla_menu.=  '<h2 class="titulomisactividades">'.get_string('MisActividades', 'ejercicios').'</h2>';

            $tabla_menu.='<center><a href="./view.php?id=' . $id . '&opcion=9"><img  class="misactividades" src="./imagenes/activ.svg" id="id_MisActividades" name="MisActividades" title="'. get_string('MisActividades', 'ejercicios') . '"/></a></center>';
            
            
              $tabla_menu.=  '<h2 class="componeractividades">'.get_string('componerActividades', 'ejercicios').'</h2>';

            $tabla_menu.='<center><a href="./view.php?id=' . $id . '&opcion=9"><img  class="misactividades" src="./imagenes/componer.png" id="id_MisActividades" name="MisActividades" title="'. get_string('MisActividades', 'ejercicios') . '"/></a></center>';
          
            
            $mform->addElement('html', $tabla_menu);

        //Los iconos están sacados del tema de gnome que viene con ubuntu 11.04
    
        
   
       
      }else{ #si soy alumno
	
            


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
       
            $tabla_menu.='</div>';

	    $tabla_menu.=  '<h2 class="titulomisactividades">'.get_string('ActividadesCurso', 'ejercicios').'</h2>';

            $tabla_menu.='<center><a href="./view.php?id=' . $id . '&opcion=10"><img  class="misactividades" src="./imagenes/activ.svg" id="id_Actividades_curso" name="Actividades_curso" title="'. get_string('ActividadesCurso', 'ejercicios') . '"/></a></center>';
            
            #incluyo la parte de vocabulario
           
            #buscando por tema de palbras
            
      /*     $mform->addElement('html', $tabla_menu);
                    
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
*/
            $tabla_menu .='</div>';
            
       
            
            $mform->addElement('html', $tabla_menu);

      } //fin alumno
    } //fin pintar opciones

  
 
}//fin clase
?>
