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
require_once($CFG->dirroot.'/mod/vocabulario/vocabulario_classes.php');
require_once($CFG->dirroot.'/mod/vocabulario/lib.php');
require_once('clase_log.php');

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
    
    function mod_ejercicios_mod_formulario($id)
       {
         // El fichero que procesa el formulario es gestion.php
        parent::moodleform('hacer_ejercicio_inicio.php?id='.$id);
       }
       
       /**
      * Generara un codigo javascript que se incrustara en la pagina
      * en la que se almacenara para cada tipo de ejercicio (se guardara su indice en el control select de la pagina)
      * una breve descripcion del ejercicio que despues al seleccionarlo en el select
      * aparecera en un textarea
      */
     function pintarDescripcionEjercicios() {
        $salida = '<script type="text/javascript">';
        $salida .= ' var descripciones = new Array();';
        $numEjercicios = (int) get_string('TotalEjercicios','ejercicios');
        for ($i=0; $i<$numEjercicios; $i++){
            if ($i != 6){
            $salida .= 'descripciones['.$i.']="'.get_string('desc_Tipo'.$i,'ejercicios').'";';
            }
        }
        $salida.='</script>';
        return $salida;
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
     
        //Añade una breve descripcion para cada tipo de ejercicio
        $script = $this->pintarDescripcionEjercicios();
        $log = new Log("log_mod_form.txt");
        $log->write("Script: " . $script);
        $log->close();
        $mform->addElement('html',$script);
        


            $tabla_menu =  '<h1><center>'.get_string('Actividades', 'ejercicios').'</center></h1>';
          
            
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
            
            //Añadido tipo ejercicio ENTRENADOR DE VOCABULARIO:  (* Codigo de antes *) for($i=0;$i<14;$i++){
            for($i=0;$i<15;$i++){
                $clasificaciontipo[]=get_string('Tipo'.$i,'ejercicios');       
            }
           
             
            $tabla_menu.='<select id="TipoActividad" style="width: 380px;" class="selectbuscar">';
             
             for($i=0;$i<sizeof($clasificaciontipo);$i++){
                 if ($i != 6){
                 $tabla_menu.='<option value="'.$i.'">'.$clasificaciontipo[$i].'</option>';
                 }
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
            

       
          
           


        //compruebo si soy profesor
        
           if (has_capability('moodle/legacy:editingteacher', $context, $USER->id, false)){
	
              //Creando por tipo de actividad
	    $tabla_menu.='<div style="height:20px"></div>';
            $tabla_menu.= '<h2 class="titulo">'.get_string('Crear', 'ejercicios').'</h2>';
            $tabla_menu.='<ul class="ullista">';
             
            $tabla_menu.='<li class="lilista"><a id="enlacemenu" href="#">'.get_string('Tipo de Actividad','ejercicios').'</a></li>';
          
            $clasificaciontipo=array();
            
            //Añadido tipo ejercicio ENTRENADOR DE VOCABULARIO:  (* Codigo de antes *) for($i=0;$i<14;$i++){
            for($i=0;$i<15;$i++){
                $clasificaciontipo[]=get_string('Tipo'.$i,'ejercicios');       
            }
           
             
            $tabla_menu.='<select id="TipoActividadCrear" style="width: 380px;" class="selectbuscar" onchange="cargaResumenEjercicio()" >';
             
             for($i=0;$i<sizeof($clasificaciontipo);$i++){
                 if ($i != 6){
                 $tabla_menu.='<option value="'.$i.'">'.$clasificaciontipo[$i].'</option>';
                 }
             }
            $tabla_menu.='</select>';
            $tabla_menu.='<textarea id="desc_TipoActividadCrear" rows="5" cols="50" style="visibility:hidden;width:380px;resize:none;" readonly="yes">aaaa</textarea>';
           
         
            
            $tabla_menu.='</ul>';
            
            
            $tabla_menu.='<center><input id="id_creando" type="button" style="height:30px; width:60px; margin-left:175px;" value="'.get_string('Boton_Crear','ejercicios').'" onclick="botonCrear('.$id.');"></center>';
            $tabla_menu.='</div>';
            
         
            //parte del ejercicio
         
            $tabla_menu .='<div id="parteejercicio">';
           
           // $tipo1= new Ejercicios_mis_puzzledoble();
            #selecciono los ejercicios para generar uno aleatorio a mostrar
           // $ej_tipo1= $tipo1->obtener_todos();
           // $tam1=sizeof($ej_tipo1);
            //alimentamos el generador de aleatorios
            srand (time());
            $numero_aleatorio = rand(0,2);
            $tipoej=$numero_aleatorio; //variable que indica el tipo de ejercicio a mostrar 0 Multichoice
                 
             
            //echo "tipoejercicio".$tipoej;
            $ej_tipo= new Ejercicios_general();
            $todos_ej_tipo=$ej_tipo->obtener_ejercicios_tipo_publicos($tipoej);
            $tam1=sizeof($todos_ej_tipo);
            srand (time());
            //generamos un número aleatorio
            $numero_aleatorio = rand(1,$tam1);


            //echo "tam vale".$tam1;
            if($tam1!=0){
               $seleccionado=$todos_ej_tipo[$numero_aleatorio-1];
               $nombre=$seleccionado->get('name');
               
               $tabla_menu.= '<h2 id="name">'.$nombre.'</h2>';
               $mform->addElement('hidden', 'oculto1',$seleccionado->get('id'));
             
               //$mform->addElement('hidden', 'oculto2',$ctipo);
               $tabla_menu.='<center><img src="./imagenes/fotosgenericas/'.$tipoej.'.png" alt="imagen de un ejercicio"  height="70%"  width="70%px"/></center>';
               $tabla_menu.='<center><input type="submit" style="height:30px; width:60px;" id="botonRealizar" value="'.get_string('Realizar','ejercicios').'"/></center>';
            }
            $tabla_menu .='</div>';
            //fin parte ejercicio
            $tabla_menu .='<div id="partevocabulario">';
                        //Mis palabras
            $tabla_menu .='<div style="margin-top:100px;"><a href="../vocabulario/view.php?id=' . $id . '&opcion=1"><img src="../vocabulario/imagenes/guardar_palabras.png" id="id_guardar_im" name="guardar_im" title="'.get_string('guardar', 'vocabulario').'"/></a></div>';
            $tabla_menu .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=5" target="_blank"><img src="../vocabulario/imagenes/administrar_gramaticas.png" id="id_gram_im" name="gram_im" title="'. get_string('admin_gr', 'vocabulario') . '"/></a></div>';
            $tabla_menu .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=7" target="_blank"><img src="../vocabulario/imagenes/intenciones_comunicativas.png" id="id_ic_im" name="ic_im" title="'. get_string('admin_ic', 'vocabulario') . '"/></a></div>';
            $tabla_menu .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=9" target="_blank"><img src="../vocabulario/imagenes/tipologias_textuales.png" id="id_tt_im" name="tt_im" title="'. get_string('admin_tt', 'vocabulario') .'"/> </a></div>';
            $tabla_menu .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=11" target="_blank"><img src="../vocabulario/imagenes/estrategias_icon.png" id="id_ea_im" name="ea_im" title="'. get_string('admin_ea', 'vocabulario') .'"/> </a></div>';

            $tabla_menu .='</div>';
            
            //fin ejercicios
            $tabla_menu.=  '<h2 class="titulomisactividades">'.get_string('MisActividades', 'ejercicios').'</h2>';

            $tabla_menu.='<center><a href="./view.php?id=' . $id . '&opcion=9"><img  class="misactividades" src="./imagenes/activ.svg" id="id_MisActividades" name="MisActividades" title="'. get_string('MisActividades', 'ejercicios') . '"/></a></center>';
            
            
              $tabla_menu.=  '<h2 class="componeractividades">'.get_string('componerActividades', 'ejercicios').'</h2>';

            $tabla_menu.='<center><a href="./view.php?id=' . $id . '&opcion=9"><img  class="misactividades" src="./imagenes/componer.png" id="id_MisActividades" name="MisActividades" title="'. get_string('MisActividades', 'ejercicios') . '"/></a></center>';
          
            
            $mform->addElement('html', $tabla_menu);

        //Los iconos están sacados del tema de gnome que viene con ubuntu 11.04
    
        
   
       
      }else{ #si soy alumno
            
	
            
          $tabla_menu.='</div>'; //cierro el div de buscar porque no hay nada mas en esa columna
            //parte del ejercicio
         
            $tabla_menu .='<div id="parteejercicioalumno">';
           
           // $tipo1= new Ejercicios_mis_puzzledoble();
            #selecciono los ejercicios para generar uno aleatorio a mostrar
           // $ej_tipo1= $tipo1->obtener_todos();
           // $tam1=sizeof($ej_tipo1);
            //alimentamos el generador de aleatorios
            
           // $tipoej=0; //variable que indica el tipo de ejercicio a mostrar 0 Multichoice
            srand (time());
            $numero_aleatorio = rand(0,2);
            $tipoej=$numero_aleatorio; //variable que indica el tipo de ejercicio a mostrar 0 Multichoice

            //echo "tipoejercicio".$tipoej;
            $ej_tipo= new Ejercicios_general();
            $todos_ej_tipo=$ej_tipo->obtener_ejercicios_tipo_publicos($tipoej);
            $tam1=sizeof($todos_ej_tipo);
            srand (time());
            //generamos un número aleatorio
            $numero_aleatorio = rand(1,$tam1);
            
          
            //echo "tam vale".$tam1;
            if($tam1!=0){
                //echo "entra";
               $seleccionado=$todos_ej_tipo[$numero_aleatorio-1];
               $nombre=$seleccionado->get('name');
               
               $tabla_menu.= '<h2 id="name">'.$nombre.'</h2>';
               $mform->addElement('hidden', 'oculto1',$seleccionado->get('id'));
             
               //$mform->addElement('hidden', 'oculto2',$ctipo);
               $tabla_menu.='<center><img src="./imagenes/fotosgenericas/'.$tipoej.'.png" alt="imagen de un ejercicio"  height="70%"  width="70%px"/></center>';
               $tabla_menu.='<center><input type="submit" style="height:30px; width:60px;" id="botonRealizar" value="'.get_string('Realizar','ejercicios').'"/></center>';
            }
            $tabla_menu .='</div>';
            //fin parte ejercicio
            $tabla_menu .='<div id="partevocabulario">';
                        //Mis palabras
            $tabla_menu .='<div style="margin-top:100px;"><a href="../vocabulario/view.php?id=' . $id . '&opcion=1"><img src="../vocabulario/imagenes/guardar_palabras.png" id="id_guardar_im" name="guardar_im" title="'.get_string('guardar', 'vocabulario').'"/></a></div>';
            $tabla_menu .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=5" target="_blank"><img src="../vocabulario/imagenes/administrar_gramaticas.png" id="id_gram_im" name="gram_im" title="'. get_string('admin_gr', 'vocabulario') . '"/></a></div>';
            $tabla_menu .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=7" target="_blank"><img src="../vocabulario/imagenes/intenciones_comunicativas.png" id="id_ic_im" name="ic_im" title="'. get_string('admin_ic', 'vocabulario') . '"/></a></div>';
            $tabla_menu .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=9" target="_blank"><img src="../vocabulario/imagenes/tipologias_textuales.png" id="id_tt_im" name="tt_im" title="'. get_string('admin_tt', 'vocabulario') .'"/> </a></div>';
            $tabla_menu .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=11" target="_blank"><img src="../vocabulario/imagenes/estrategias_icon.png" id="id_ea_im" name="ea_im" title="'. get_string('admin_ea', 'vocabulario') .'"/> </a></div>';

            $tabla_menu .='</div>';
            
            //fin ejercicios
	
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
