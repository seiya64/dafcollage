<?php

//$Id: mod_form.php,v 1.2.2.3 2009/03/19 12:23:11 mudrd8mz Exp $

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
  Ángel Biedma Mesa (tekeiro@gmail.com)
  Javier Castro Fernández (havidarou@gmail.com)

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

require_once($CFG->dirroot . '/course/moodleform_mod.php');
require_once("ejercicios_clases.php");
require_once("ejercicios_clase_general.php");
require_once("clase_log.php");
require_once("ejercicios_partes_comunes.php");


/* Formulario para el primer paso de creación de los ejercicios
 * @author Serafina Molina Soto; Modificado Javier Castro Fernández
 */

class mod_ejercicios_creando_ejercicio extends moodleform_mod {

    function mod_ejercicios_creando_ejercicio($id, $tipocreacion) {
        /* // Comentarios añadidos por Javier Castro Fernández //
         * Constructor de clase
         * LLama al archivo ejercicios_gestion_creacion.php
         * Se encarga de guardar el esqueleto del ejercicio en el primer paso de creación
         */
        parent::moodleform('ejercicios_gestion_creacion.php?id_curso=' . $id . '&tipocreacion=' . $tipocreacion);
    }

    function definition() {
        
    }

    /**
     * Function that add a table to the forma to show the main menu
     *
     * @author Serafina Molina Soto
     * @param $id id for the course
     * @param $id_ej id del ejercicio a pinar
     */
    function pintarformulario($id, $tipocreacion) {


        global $CFG, $COURSE, $USER;
        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);

        $mform = &$this->_form;

        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./estilo.css">');
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="./funciones.js"></script>');
        //titulo
        switch ($tipocreacion) {
            case 2: //Multiple Choices
                $title = get_string('MC_title', 'ejercicios');
                break;
            case 3: //Asociacion Simple
                $title = get_string('AS_title', 'ejercicios');
                break;
            case 4: //Asociacion Compleja
                $title = get_string('AC_title', 'ejercicios');
                break;
            case 5: //Texto Hueco
                $title = get_string('TH_title', 'ejercicios');
                break;
            case 6: //Identificar Elementos
                $title = get_string('IE_title', 'ejercicios');
                break;
            case 9: //Ordenar Elementos
                $title = get_string('OE_title', 'ejercicios');
                break;
            case 10: //Identificar Elementos mas Respuesta Corta
                $title = get_string('IERC_title', 'ejercicios');
                break;
            default:
                $title = get_string('FormularioCreacion', 'ejercicios');
                break;
        }
        $creacion = get_string('Creacion', 'ejercicios');
        $titulo = genera_titulos($creacion, $title, $id);
        $mform->addElement('html', $titulo);

        $oculto = '<input type="hidden" name="tipocreacion" id="tipocreacion" value="' . $tipocreacion . '"/>';
        $mform->addElement('html', $oculto);

        $tabla = '<div id="formulario">';
        $mform->addElement('html', $tabla);
        //Seleccione el tipo de archivo pregunta (texto/ audio/ vÃ­deo/ foto)
        //TODO Cambiar estos if por un switch
        switch ($tipocreacion) {
            case 2: //Multiple Choices
                $radioarray = array();
                $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiopregunta', '', "Texto", "Texto", null);
                $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiopregunta', '', "Audio", "Audio", null);
                $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiopregunta', '', "Video", "Video", null);
                break;
            case 3: //Asociacion Simple
            case 4: //Asociacion Compleja
                $radioarray = array();
                $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiopregunta', '', "Texto", "Texto", "onClick=\"muestra('textoseleccionado'); oculta('otroseleccionado')\"");
                $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiopregunta', '', "Audio", "Audio", "onClick=\"muestra('otroseleccionado'); oculta('textoseleccionado')\"");
                $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiopregunta', '', "Video", "Video", "onClick=\"muestra('otroseleccionado'); oculta('textoseleccionado')\"");
                $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiopregunta', '', "Foto", "Foto", "onClick=\"muestra('otroseleccionado'); oculta('textoseleccionado')\"");
                break;
            case 5: //Texto Hueco
            case 9: //Ordenar Elementos
                $radioarray = array();
                $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiopregunta', '', "Texto", "Texto", "onClick=\"muestra('textoseleccionado'); oculta('otroseleccionado')\"");

                break;
            case 6: //Identificar elementos
            case 10: //Identificar Elementos mas Respuesta Corta
                $radioarray = array();
                $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiopregunta', '', "Texto", "Texto", null);
                $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiopregunta', '', "Audio", "Audio", null);
                $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiopregunta', '', "Video", "Video", null);
        }
        $mform->addGroup($radioarray, 'radiopregunta', get_string('tipoorigen', 'ejercicios'), array(' '), false);
        $mform->setDefault('radiopregunta', "Texto");
        
        // comentamos las lineas de abajo porque hacer lo mismo
//        if ($tipocreacion == 2) { //Multichoice es archivo origen
//            $mform->addGroup($radioarray, 'radiopregunta', get_string('tipoorigen', 'ejercicios'), array(' '), false);
//            $mform->setDefault('radiopregunta', "Texto");
//        } else { //El resto
//            $mform->addGroup($radioarray, 'radiopregunta', get_string('tipoorigen', 'ejercicios'), array(' '), false);
//            $mform->setDefault('radiopregunta', "Texto");
//        }


        //Seleccione el número total de archivos pregunta (solo para texto hueco)
//        if ($tipocreacion == 5) {
//            $numimagenes = array();
//            $CONST_MAX_PREGUNTAS = 12;    //Cambio Angel Biedma: Incremento del Maximo de preguntas a 12
//            for ($i = 0; $i < $CONST_MAX_PREGUNTAS; $i++) {
//                $numimagenes[] = $i + 1;
//            }
//            $mform->addElement('select', 'numeropreguntas', get_string('numeropreguntas', 'ejercicios'), $numimagenes);
//        }

        //Seleccione el tipo de archivo respuesta (texto/ audio/ vídeo/ foto)

        $radioarray = array();

        //volver a añadir estos 3
        // $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiorespuesta', '', "Audio", "Audio", null);

        switch ($tipocreacion) {
            case 5: //Texto Hueco. Solo tipo Texto
            case 2: //Multiplechoice solo tipo texto
            case 6: //Identificar elementos
            case 10: //Identificar Elementos mas Respuesta Corta
                break;
            case 9: //Ordenar Elementos, Solo tipo Texto
            //TODO ESTO ESTA COMENTADO PORQUE EL PRIMER PASO TIENE QUE SER COMUN A TODOS LOS EJERCICIOS, ADEMAS LOS TIPOS DE ORDENACION SE SELECCIONARAN EN EL SIGUIENTE PASO
//                $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiotipoorden', '', get_string("OE_tipoorden_frase", "ejercicios"), "Frase", null);
//                $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiotipoorden', '', get_string("OE_tipoorden_parrafos", "ejercicios"), "Parrafo", null);
//                $mform->addGroup($radioarray, 'radiotipoorden', get_string('OE_tipoorden', 'ejercicios'), array(' '), false);
//                $mform->setDefault('radiotipoorden', "Frase");
                //DEJAMOS EL BREAK PARA QUE NO ENTRE EN EL SIGUIENTE CASE!
                break;

            /* $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiorespuesta', '', "Texto", "Texto", null);
              $mform->addGroup($radioarray, 'radiorespuesta', get_string('tiporespuesta', 'ejercicios'), array(' '), false);
              $mform->setDefault('radiorespuesta', "Texto");
              break; */
            case 3: //Asociacion Simple
            case 4: //Asociacion Compleja

                $divoculto = '<div id="textoseleccionado">';
                $mform->addElement('html', $divoculto);



                $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiorespuesta', '', "Texto", "Texto", null);

                $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiorespuesta', '', "Audio", "Audio", null);
                $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiorespuesta', '', "Video", "Video", null);
                $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiorespuesta', '', "Foto", "Foto", null);
                $mform->addGroup($radioarray, 'radiorespuesta', get_string('tiporespuesta', 'ejercicios'), array(' '), false);
                $mform->setDefault('radiorespuesta', "Texto");

                $divoculto = '</div>';
                $mform->addElement('html', $divoculto);

                $divoculto = '<div id="otroseleccionado" style="display: none;">';
                $mform->addElement('html', $divoculto);



                $radioarray1[] = &MoodleQuickForm::createElement('radio', 'radiorespuesta', '', "Texto", "Texto", null);

                $mform->addGroup($radioarray1, 'radiorespuesta', get_string('tiporespuesta', 'ejercicios'), array(' '), false);
                $mform->setDefault('radiorespuesta', "Texto");

                $divoculto = '</div>';
                $mform->addElement('html', $divoculto);
                break;

            /* $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiorespuesta', '', "Texto", "Texto", null);
              $mform->addGroup($radioarray, 'radiorespuesta', get_string('tiporespuesta', 'ejercicios'), array(' '), false);
              $mform->setDefault('radiorespuesta', "Texto");
              break; */
        }



        /*
          //Seleccione el número total de archivos respuesta
          $numimagenes=array();
          for($i=0;$i<9;$i++){
          $numimagenes[] = $i+1;
          }
          $mform->addElement('select', 'numerorespuestas',  get_string('numerorespuestas', 'ejercicios'), $numimagenes);


          //Seleccione el número total de archivos respuesta
          $numimagenes=array();
          for($i=0;$i<9;$i++){
          $numimagenes[] = $i+1;
          }
          $mform->addElement('select', 'numerorespuestascorrectas',get_string('numerorespuestascorrectas', 'ejercicios'), $numimagenes,"onchange=JavaScript:Comprobacionesform()");
         */
        //Clasificacion

        $clasi = '</br><div"></br></center>' . get_string('textoclasej', 'ejercicios') . '</center></br></br>';
        $mform->addElement('html', $clasi);
        //Campo tematico


        $aux = new Vocabulario_campo_lexico();
        $clex = $aux->obtener_hijos($USER->id, 0);


        //campo lexico
        $mform->addElement('select', 'campoid', get_string('Tema', 'ejercicios'), $clex, "onChange='javascript: if( this.options[this.selectedIndex].text == \"--\" || this.options[this.selectedIndex].text == \"Seleccionar\" ) { this.selectedIndex == 0; this.options[0].selected = true; document.getElementById(\"clgeneraldinamico\").style.display=\"none\";} else { cargaContenido(this.id,\"clgeneraldinamico\",0); document.getElementById(\"clgeneraldinamico\").style.display=\"\";}' style=\"min-height: 0;\"");
        //probar los campos dinamicos
        $campodinamico = "<div id=\"clgeneraldinamico\"></div>";
        $mform->addElement('html', $campodinamico);


        //Destreza   
        $clasificaciondestreza = array();

        for ($i = 0; $i < 7; $i++) {
            $clasificaciondestreza[] = get_string('Destreza' . $i, 'ejercicios');
        }

        $mform->addElement('select', 'DestrezaComunicativa', get_string("Destreza comunicativa", "ejercicios"), $clasificaciondestreza);

        //Tema Gramatical

        $aux = new Vocabulario_gramatica();
        $gramaticas = $aux->obtener_hijos($USER->id, 0);
        $lista_padres = $aux->obtener_padres($USER->id, $grid);

        $mform->addElement('select', 'campogr', get_string('Gramatica', 'ejercicios'), $gramaticas, "onChange='javascript:cargaContenido(this.id,\"grgeneraldinamico\",1)' style=\"min-height: 0;\"");
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

        //Intencion comunicativa


        $aux = new Vocabulario_intenciones();
        $icom = $aux->obtener_hijos($USER->id, 0);
        $lista_padres = $aux->obtener_padres($icid);

        $mform->addElement('select', 'campoic', get_string("Intencion", "ejercicios"), $icom, "onChange='javascript:cargaContenido(this.id,\"icgeneraldinamico\",2)' style=\"min-height: 0;\"");
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



        //Tipo de texto (Tipologías textuales)

        $aux = new Vocabulario_tipologias();
        $tipologias = $aux->obtener_todos($USER->id);
        $mform->addElement('select', 'campott', get_string("campo_tipologia", "vocabulario"), $tipologias);

        $mform->addElement('html', '</br></div></br>');

        //marco teorico

        $marcoteorico = array();
        $marcoteorico[] = "--";
        $marcoteorico[] = "A1";
        $marcoteorico[] = "A2";
        $marcoteorico[] = "B1";
        $marcoteorico[] = "B2";
        $marcoteorico[] = "C1";
        $marcoteorico[] = "C2";
        $mform->addElement('select', 'marcoteorico', get_string("marcoteorico", "ejercicios"), $marcoteorico);


        //Titule su ejercicio para facilitar la identificación o búsqueda
        $attributes = 'size="40"';
        $mform->addElement('text', 'nombre_ejercicio', get_string('nombre', 'ejercicios'), $attributes);
        $mform->addRule('nombre_ejercicio', get_string('tituloNecesario', 'ejercicios'), 'required', null, 'client');

        //Añade una breve introducción al ejercicio
        //$desc2 = ($tipocreacion==10) ? '<br/><br/>' . get_string('IERC_descripcion2','ejercicios') : "";  //Si el ejercicio es IE mas RC, añadimos una pequeña descripcion
        $mform->addElement('textarea', 'descripcion', get_string('descripcion', 'ejercicios'), 'wrap="virtual" rows="7" cols="50"');
        $mform->addRule('descripcion', get_string('descripcionNecesaria', 'ejercicios'), 'required', null, 'client');
        //botones




        switch ($tipocreacion) {
            // Identificar elementos más respuesta corta
            case 10:
                // Se pregunta por el elemento
                $mform->addElement('textarea', 'elemento', get_string('IERC_elemento', 'ejercicios'), 'wrap="virtual" rows="1" cols="30"');
                $mform->addRule('elemento', get_string('elementoNecesario', 'ejercicios'), 'required', null, 'client');
                // Input auxiliar
                $mform->addElement('hidden', 'IERC_aux', "0");
                // ¿Cuántas preguntas quiere hacer de cada elemento?
                $mform->addElement('select', 'numPreguntas', get_string('IERC_numPreguntas', 'ejercicios'), array(0 => "-", 1 => 1, 2 => 2, 3 => 3, 4 => 4), 'onChange="IERC_actualizaTitulos()"');
                $div = '<div style="display:none" id="divPregunta" class="fitem"> <div class="fitemtitle"> <label for="tituloPregunta1"> ' . get_string('IERC_tituloPregunta', 'ejercicios') . '</label></div><div class="felement ftextarea" id="divIntroducir"> </div></div>';
                $mform->addElement('html', $div);

                break;
        }



        $attributes = 'onchange="form_creacion_nueva_carpeta(this)"';
        //Coger las carpetas
        $log = new Log("log_form_creacion.txt");
        $prof_actividad = new Ejercicios_prof_actividad();
        $log->write("Id del profesor: " . $USER->id);
        $prof_carpetas = $prof_actividad->obtener_ejercicios_del_profesor_carpeta($USER->id);
        $carpetas = array();
        foreach ($prof_carpetas as $carp)
            $carpetas[$carp->get('carpeta')] = $carp->get('carpeta');
        $log->write("longitud " . count($carpetas));
        $crearcarpetas = false;
        if (count($carpetas) == 0) { // Si no hay carpetas creadas, arrancamos con el input
            $crearcarpetas = true;
        }
        $carpetas['-1'] = "Crear nueva carpeta";
        $log->write("Carpetas: " . var_export($carpetas, true));
        if ($crearcarpetas) {
            $mform->addElement('select', 'carpeta_ejercicio_no', get_string('carpeta', 'ejercicios'), $carpetas, $attributes);
            $mform->addElement('html', '<div class="fitem"><div class="fitemtitle"></div><div class="felement ftextarea"><input type="text" name="carpeta_ejercicio" id="input_carpeta" value="" style="display:block;"/></div></div>');
        } else {
            $mform->addElement('select', 'carpeta_ejercicio', get_string('carpeta', 'ejercicios'), $carpetas, $attributes);
            $mform->addElement('html', '<div class="fitem"><div class="fitemtitle"></div><div class="felement ftextarea"><input type="text" id="input_carpeta" value="" style="display:none;"/></div></div>');
        }
        //$mform->addElement('text', 'carpeta_ejercicio',get_string('carpeta', 'ejercicios') , $attributes);
        //$mform->addRule('carpeta_ejercicio', "Carpeta Necesaria", 'required', null, 'client');
        //Copyright

        $cright = array();
        $cright[] = "--";
        $cright[] = "Reconocimiento (CC-BY)";
        $cright[] = "Reconocimiento-CompartirIgual (CC-BY-SA)";
        $cright[] = "Reconocimiento-NoDerivadas (CC-BY-ND)";
        $cright[] = "Reconocimiento-NoComercial (CC-BY-NC)";
        $cright[] = "Reconocimiento-NoComercial-CompartirIgual (CC-BY-NC-SA)";
        $cright[] = "Reconocimiento-NoComercial-NoDerivadas (CC-BY-NC-ND)";

        $mform->addElement('select', 'copyright', get_string("copyright", "ejercicios"), $cright, "onChange='javascript:cargaDescripcion(1);'");
        $mform->addRule('copyright', "Copyright Necesario", 'required', null, 'client');

        if ($tipocreacion != 5 && $tipocreacion != 9) {
            $cright = array();
            $cright[] = "--";
            $cright[] = "Reconocimiento (CC-BY)";
            $cright[] = "Reconocimiento-CompartirIgual (CC-BY-SA)";
            $cright[] = "Reconocimiento-NoDerivadas (CC-BY-ND)";
            $cright[] = "Reconocimiento-NoComercial (CC-BY-NC)";
            $cright[] = "Reconocimiento-NoComercial-CompartirIgual (CC-BY-NC-SA)";
            $cright[] = "Reconocimiento-NoComercial-NoDerivadas (CC-BY-NC-ND)";

            //$mform->addElement('select', 'copyrightresp', get_string("copyrightresp", "ejercicios"), $cright,"onChange='javascript:cargaDescripcion(2);'");
            //$mform->addRule('copyrightresp', "Copyright Necesario", 'required', null, 'client');
        }


        $buttonarray = array();
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('Aceptar', 'ejercicios'), "onClick='javascript:compruebaCopyright(" . $id . "," . $tipocreacion . ")'");
        $mform->addGroup($buttonarray, 'botones', '', array(' '), false);


        $tabla = '</div>';
        $mform->addElement('html', $tabla);
    }

}

/* * ****************************************************************************************************
 * *****************************************************************************************************
 * *****************************************************************************************************
 * *****************************************************************************************************
 * *****************************************************************************************************
 * *****************************************************************************************************
 * *****************************************************************************************************
 * *****************************************************************************************************
 * *****************************************************************************************************
 * *****************************************************************************************************
 * *****************************************************************************************************
 * ********************************** CÓDIGO EN VÍAS DE ELIMINACIÓN ************************************
 * *****************************************************************************************************
 * *****************************************************************************************************
 * ********************************ELIMINACIÓN 2OS PASOS DE CREACIÓN************************************
 * *****************************************************************************************************
 * *****************************************************************************************************
 * *****************************************************************************************************
 * *****************************************************************************************************
 * *****************************************************************************************************
 * *****************************************************************************************************
 * *****************************************************************************************************
 * *****************************************************************************************************
 * *****************************************************************************************************
 * *****************************************************************************************************
 */

//Formulario de creación actividades de tipo: "MULTIPLECHOICE"
class mod_ejercicios_creando_ejercicio_texto extends moodleform_mod {

    function mod_ejercicios_creando_ejercicio_texto($id, $p, $id_ejercicio, $tipo_origen, $tipocreacion) {
        // El fichero que procesa el formulario es gestion.php
        parent::moodleform('ejercicios_creacion_texto_texto.php?id_curso=' . $id . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tipocreacion=' . $tipocreacion);
    }

    function definition() {
        
    }

    /**
     * Function that add a table to the forma to show the main menu
     *
     * @author Serafina Molina Soto
     * @param $id id for the course
     * @param $p numero de preguntas
     * @param $r numero de respuetas
     * @param $c numero de respuestas correctas
     * @param $id_ejercicio id del ejercicio que estamos creando
     */
    function pintarformulariotexto($id, $p, $id_ejercicio, $tipoorigen, $tipocreacion) {

        global $CFG, $COURSE, $USER;
        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);

        $mform = & $this->_form;

        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./estilo.css">');
        $mform->addElement('html', '<script type="text/javascript" src="./funciones.js"></script>');
        //titulo
        //$titulo= '<h1 class="instrucciones" >' . get_string('FormularioCreacionTextos', 'ejercicios') . '</h1>';
        $titulo = genera_titulos(get_string('FormularioCreacionTextos', 'ejercicios'), get_string('MC_title', 'ejercicios'), $id);
        $mform->addElement('html', $titulo);

        $ejercicioGeneral = unserialize($_SESSION['ejercicioGeneral']);
        $titulo = '<div style="font-size:1.2em" >' . nl2br(get_string('IERC_descripcion', 'ejercicios')) . ' <br/><i><u>' . nl2br($ejercicioGeneral->get('descripcion')) . '</u></i></div>';
        $mform->addElement('html', $titulo);

        $oculto = '<input type="hidden" name="tipocreacion" id="tipocreacion" value="' . $tipocreacion . '"/>';
        $mform->addElement('html', $oculto);

        switch ($tipoorigen) {
            case 1: //El archivo de origen es un texto
                //Añade una breve introducción al ejercicio

                $mform->addElement('textarea', 'archivoorigen', get_string('textoorigen', 'ejercicios'), 'wrap="virtual" rows="10" cols="50"');
                $mform->addRule('archivoorigen', "Texto Origen Necesario", 'required', null, 'client');

                break;
            case 2: //El archivo de origen es un audio
                $mform->addElement('file', 'archivoaudio', "Audio");
                $mform->addRule('archivoaudio', "Archivo Necesario", 'required', null, 'client');
                // "el archivo origen es un audio";

                break;

            case 3: //El archivo de origen es un video
                //Titule su ejercicio para facilitar la identificación o búsqueda
                $attributes = 'size="100"';
                $mform->addElement('text', 'archivovideo', get_string('Video', 'ejercicios'), $attributes);
                $mform->addRule('archivovideo', "Dirección Web Necesaria", 'required', null, 'client');

                // "el archivo origen es un audio";

                break;
        }


        //Para cada pregunta
        for ($i = 0; $i < $p; $i++) {

            $aux = $i + 1;
            $titulo = '</br><h3> Pregunta ' . $aux . " " . get_string('aContinuacion', 'ejercicios') . '</h3>';
            $mform->addElement('html', $titulo);

            $mform->addElement('textarea', 'pregunta' . $aux, get_string('pregunta', 'ejercicios') . $aux, 'wrap="virtual" rows="5" cols="50"');


            $textarea = '</br><div id="titulorespuestas" style="margin-left:130px;">Respuestas:</div>';
            $textarea.='<div style="margin-left:310px;" id="respuestas_pregunta"' . $aux . '"> ';
            $textarea.='<textarea name="respuesta1_' . $aux . '" id="respuesta1_' . $aux . '" rows="5" cols="50"></textarea>';
            $textarea.='</br><div id="correctarespuesta">' . get_string('Correcta', 'ejercicios');
            $textarea.='<input type="radio"  name="correcta1_' . $aux . '" id="correcta1_' . $aux . '" value="Si" checked> Si </input>';
            $textarea.='<input type="radio" name="correcta1_' . $aux . '"  id="correcta1_' . $aux . '" value="No"> No </input>';
            $textarea.='</br>';
            $textarea.='</div>';


            $textarea.='<input type="hidden" name="numerorespuestas_' . $aux . '" id="numerorespuestas_' . $aux . '" value="1"/>';
            $textarea.='</div>';
            $mform->addElement('html', $textarea);

            // $mform->addElement('text', 'numerorespuestas_'.$aux,"hola");
            $botonañadir = '<left><input type="button" style="height:30px; width:140px;" value="' . get_string('BotonAñadirRespuesta', 'ejercicios') . '" onclick="botonMasRespuestas(' . $aux . ');"></left>';

            $mform->addElement('html', $botonañadir);
        }

        $mform->addElement('hidden', 'numeropreguntas', $p);


        $fuentes = genera_fuentes();
        $mform->addElement('html', $fuentes);
        $buttonarray = array();
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('Aceptar', 'ejercicios'), "style='margin-left:30%;' onclick=obtenernumeroRespuestas('$p');");
        $mform->addGroup($buttonarray, 'botones', '', array(' '), false);
    }

}

/*
 * Formulario para la creación de actividades de tipo Asociación simple
 */

class mod_ejercicios_creando_ejercicio_asociacion_simple extends moodleform_mod {

    function mod_ejercicios_creando_ejercicio_asociacion_simple($id, $p, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion) {
        // El fichero que procesa el formulario es gestion.php
        parent::moodleform('ejercicios_creacion_asociacion_simple.php?id_curso=' . $id . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $trespuesta . '&tipocreacion=' . $tipocreacion);
    }

    function definition() {
        
    }

    /**
     * Function that add a table to the forma to show the main menu
     *
     * @author Serafina Molina Soto
     * @param $id id for the course
     * @param $p numero de preguntas
     * @param $id_ejercicio id del ejercicio que estamos creando
     * @param $tipoorigen: tipo de archivo origen( 1: Texto, 2: Audio, 3: Video, 4: Imagen)
     * @param $tiporespuesta: tipo de archivo origen( 1: Texto, 2: Audio, 3: Video, 4: Imagen)
     */
    function pintarformularioasociacionsimple($id, $p, $id_ejercicio, $tipoorigen, $tiporespuesta, $tipocreacion) {

        global $CFG, $COURSE, $USER;
        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);

        $mform = & $this->_form;

        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./estilo.css">');
        //$mform->addElement('html', '<script type="text/javascript" src="./funciones.js"></script>');
        //titulo
        //$titulo= '<h1 class="instrucciones" >' . get_string('FormularioCreacionTextos', 'ejercicios') . '</h1>';
        $titulo = genera_titulos(get_string('FormularioCreacionTextos', 'ejercicios'), get_string('AS_title', 'ejercicios'), $id);
        $mform->addElement('html', $titulo);

        $ejercicioGeneral = unserialize($_SESSION['ejercicioGeneral']);
        $titulo = '<div style="font-size:1.2em">' . nl2br(get_string('IERC_descripcion', 'ejercicios')) . ' <br/><i><u>' . nl2br($ejercicioGeneral->get('descripcion')) . '</u></i></div>';
        $mform->addElement('html', $titulo);

        $oculto = '<input type="hidden" name="tipocreacion" id="tipocreacion" value="' . $tipocreacion . '"/>';
        $mform->addElement('html', $oculto);

        switch ($tipoorigen) {
            case 1: //El archivo de origen es un texto

                switch ($tiporespuesta) {

                    case 1: //El archivo respuesta es un texto
                        //echo "texto-texto";
                        //Para cada pregunta
                        for ($i = 0; $i < $p; $i++) {

                            $aux = $i + 1;
                            $titulo = '</br><h3>' . get_string('asociacion', 'ejercicios') . $aux . " " . get_string('aContinuacion', 'ejercicios') . '</h3>';
                            $mform->addElement('html', $titulo);

                            //Archivo Asociacion
                            $mform->addElement('textarea', 'pregunta' . $aux, get_string('Asociacion_Texto', 'ejercicios') . $aux, 'wrap="virtual" rows="5" cols="50"');
                            //Archivo Asociado
                            $mform->addElement('textarea', 'respuesta' . $aux, get_string('Asociacion_Texto_Asociado', 'ejercicios') . $aux, 'wrap="virtual" rows="5" cols="50"');
                        }

                        $mform->addElement('hidden', 'numeropreguntas', $p);


                        break;
                    case 2: //El archivo respuesta es un audio
                        //echo "texto-audio";

                        for ($i = 0; $i < $p; $i++) {

                            $aux = $i + 1;
                            $titulo = '</br><h3> ' . get_string('asociacion', 'ejercicios') . $aux . " " . get_string('aContinuacion', 'ejercicios') . '</h3>';
                            $mform->addElement('html', $titulo);

                            //Archivo Asociacion
                            $mform->addElement('textarea', 'pregunta' . $aux, get_string('Asociacion_Texto', 'ejercicios') . $aux, 'wrap="virtual" rows="5" cols="50"');
                            //Archivo Asociado
                            $mform->addElement('file', 'archivoaudio' . $aux, get_string('audio', 'ejercicios'));
                            $mform->addRule('archivoaudio' . $aux, "Archivo Necesario", 'required', null, 'client');
                        }

                        $mform->addElement('hidden', 'numeropreguntas', $p);


                        break;
                    case 3: //El archivo respuesta es un video
                        for ($i = 0; $i < $p; $i++) {

                            $aux = $i + 1;
                            $titulo = '</br><h3> ' . get_string('asociacion', 'ejercicios') . $aux . " " . get_string('aContinuacion', 'ejercicios') . '</h3>';
                            $mform->addElement('html', $titulo);

                            //Archivo Asociacion
                            $mform->addElement('textarea', 'pregunta' . $aux, get_string('Asociacion_Texto', 'ejercicios') . $aux, 'wrap="virtual" rows="5" cols="50"');
                            //Archivo Asociado
                            $attributes = 'size="100"';
                            $mform->addElement('text', 'archivovideo' . $aux, get_string('Video', 'ejercicios'), $attributes);
                            $mform->addRule('archivovideo' . $aux, "Dirección Web Necesaria", 'required', null, 'client');
                        }

                        $mform->addElement('hidden', 'numeropreguntas', $p);



                        break;
                    case 4: //El archivo respuesta es una imagen
                        //echo "texto-imagen";

                        for ($i = 0; $i < $p; $i++) {

                            $aux = $i + 1;
                            $titulo = '</br><h3>' . get_string('asociacion', 'ejercicios') . $aux . " " . get_string('aContinuacion', 'ejercicios') . '</h3>';
                            $mform->addElement('html', $titulo);
                            //Archivo Asociacion
                            $mform->addElement('textarea', 'pregunta' . $aux, get_string('Asociacion_Texto', 'ejercicios') . $aux, 'wrap="virtual" rows="5" cols="50"');
                            //Archivo Asociado
                            $mform->addElement('file', 'archivofoto' . $aux, get_string('foto', 'ejercicios'));
                            $mform->addRule('archivofoto' . $aux, "Archivo Necesario", 'required', null, 'client');
                        }

                        $mform->addElement('hidden', 'numeropreguntas', $p);


                        break;
                }

                break;

            case 2: //El archivo de origen es un audio

                switch ($tiporespuesta) {

                    case 1: //El archivo respuesta es un texto

                        for ($i = 0; $i < $p; $i++) {

                            $aux = $i + 1;
                            $titulo = '</br><h3> ' . get_string('asociacion', 'ejercicios') . $aux . " " . get_string('aContinuacion', 'ejercicios') . '</h3>';
                            $mform->addElement('html', $titulo);

                            //Archivo Asociado
                            $mform->addElement('file', 'archivoaudio' . $aux, get_string('audio', 'ejercicios'));
                            $mform->addRule('archivoaudio' . $aux, "Archivo Necesario", 'required', null, 'client');

                            //Archivo Asociacion
                            $mform->addElement('textarea', 'pregunta' . $aux, get_string('Asociacion_Texto', 'ejercicios') . $aux, 'wrap="virtual" rows="5" cols="50"');
                        }

                        $mform->addElement('hidden', 'numeropreguntas', $p);

                        break;
                }
                // "el archivo origen es un audio";

                break;

            case 3: //El archivo de origen es un video


                switch ($tiporespuesta) {

                    case 1: //El archivo respuesta es un texto
                        for ($i = 0; $i < $p; $i++) {

                            $aux = $i + 1;
                            $titulo = '</br><h3>' . get_string('asociacion', 'ejercicios') . $aux . " " . get_string('aContinuacion', 'ejercicios') . '</h3>';
                            $mform->addElement('html', $titulo);

                            //Archivo Asociado
                            $attributes = 'size="100"';
                            $mform->addElement('text', 'archivovideo' . $aux, get_string('Video', 'ejercicios'), $attributes);
                            $mform->addRule('archivovideo' . $aux, "Dirección Web Necesaria", 'required', null, 'client');
                            //Archivo Asociacion
                            $mform->addElement('textarea', 'pregunta' . $aux, get_string('Asociacion_Texto', 'ejercicios') . $aux, 'wrap="virtual" rows="5" cols="50"');
                        }

                        $mform->addElement('hidden', 'numeropreguntas', $p);
                        break;
                }

                break;

            case 4: //El archivo de origen es una imagen

                if ($tiporespuesta == 1) {//La respuesta es un texto (la unica posibilidad)
                    for ($i = 0; $i < $p; $i++) {

                        $aux = $i + 1;
                        $titulo = '</br><h3> ' . get_string('asociacion', 'ejercicios') . $aux . " " . get_string('aContinuacion', 'ejercicios') . '</h3>';
                        $mform->addElement('html', $titulo);

                        //Archivo Asociado
                        $mform->addElement('file', 'archivofoto' . $aux, get_string('foto', 'ejercicios'));
                        $mform->addRule('archivofoto' . $aux, "Archivo Necesario", 'required', null, 'client');
                        //Archivo Asociacion
                        $mform->addElement('textarea', 'pregunta' . $aux, get_string('Asociacion_Texto', 'ejercicios') . $aux, 'wrap="virtual" rows="5" cols="50"');
                    }

                    $mform->addElement('hidden', 'numeropreguntas', $p);
                }
        }

        $mform->addElement('html', '<br></br>');
        $fuentes = genera_fuentes();
        $mform->addElement('html', $fuentes);

        $buttonarray = array();
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('Aceptar', 'ejercicios'), "style='margin-left:30%;' onclick=obtenernumeroRespuestas('$p');");
        $mform->addGroup($buttonarray, 'botones', '', array(' '), false);
    }

}

/*
 * Formulario para la creacion de actividades de tipo Asociacion Multiple
 */

class mod_ejercicios_creando_ejercicio_asociacion_multiple extends moodleform_mod {

    function mod_ejercicios_creando_ejercicio_asociacion_multiple($id, $p, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion) {
        // El fichero que procesa el formulario es gestion.php
        parent::moodleform('ejercicios_creacion_asociacion_multiple.php?id_curso=' . $id . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $trespuesta . '&tipocreacion=' . $tipocreacion);
    }

    function definition() {
        
    }

    /**
     * Function that add a table to the forma to show the main menu
     *
     * @author Serafina Molina Soto
     * @param $id id for the course
     * @param $p numero de preguntas
     * @param $id_ejercicio id del ejercicio que estamos creando
     * @param $tipoorigen: tipo de archivo origen( 1: Texto, 2: Audio, 3: Video, 4: Imagen)
     * @param $tiporespuesta: tipo de archivo origen( 1: Texto, 2: Audio, 3: Video, 4: Imagen)
     */
    function pintarformularioasociacionmultiple($id, $p, $id_ejercicio, $tipoorigen, $tiporespuesta, $tipocreacion) {

        global $CFG, $COURSE, $USER;
        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);

        $mform = & $this->_form;

        $mform->addElement('html', '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.js"></script>');
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./estilo.css">');
        $mform->addElement('html', '<script type="text/javascript" src="./funciones.js"></script>');

        //titulo
        //$titulo= '<h1 class="instrucciones" >' . get_string('FormularioCreacionTextos', 'ejercicios') . '</h1>';
        $titulo = genera_titulos(get_string('FormularioCreacionTextos', 'ejercicios'), get_string('AC_title', 'ejercicios'), $id);
        $mform->addElement('html', $titulo);

        $ejercicioGeneral = unserialize($_SESSION['ejercicioGeneral']);
        $titulo = '<div style="font-size:1.2em">' . nl2br(get_string('IERC_descripcion', 'ejercicios')) . ' <br/><i><u>' . nl2br($ejercicioGeneral->get('descripcion')) . '</u></i></div>';
        $mform->addElement('html', $titulo);

        $oculto = '<input type="hidden" name="tipocreacion" id="tipocreacion" value="' . $tipocreacion . '"/>';
        $mform->addElement('html', $oculto);

        switch ($tipoorigen) {
            case 1: //El archivo de origen es un texto

                switch ($tiporespuesta) {

                    case 1: //El archivo respuesta es un texto
                        //echo "texto-texto";
                        //Para cada pregunta
                        for ($i = 0; $i < $p; $i++) {

                            $aux = $i + 1;
                            $titulo = '</br><h3>' . get_string('asociacion', 'ejercicios') . $aux . " " . get_string('aContinuacion', 'ejercicios') . '</h3>';
                            $mform->addElement('html', $titulo);

                            //Archivo Asociacion
                            $mform->addElement('textarea', 'pregunta' . $aux, get_string('Asociacion_Texto', 'ejercicios') . $aux, 'wrap="virtual" rows="5" cols="50"');
                            //Archivo Asociado
                            //$mform->addElement('textarea', 'respuesta'.$aux, get_string('Asociacion_Texto_Asociado', 'ejercicios').$aux, 'wrap="virtual" rows="5" cols="50"');
                            $textarea = '</br><div id="titulorespuestas" style="margin-left:130px;">Respuestas:</div>';
                            $textarea.='<div style="margin-left:310px;" id="respuestas_pregunta"' . $aux . '"> ';
                            $textarea.='<textarea name="respuesta1_' . $aux . '" id="respuesta1_' . $aux . '" rows="1" cols="50"></textarea>';

                            $textarea.='<input type="hidden" name="numerorespuestas_' . $aux . '" id="numerorespuestas_' . $aux . '" value="1"/>';
                            $textarea.='</div>';
                            $mform->addElement('html', $textarea);

                            // TODO COMPROBAR SI FUNCIONA LA FUNCION DE JAVASCRIPT DE MAS RESPUESTAS DE IE PARA ESTOS EJERCICIOS
                            $botonañadir = '<left><input type="button" style="height:30px; width:140px;" value="' . get_string('BotonAñadirRespuesta', 'ejercicios') . '" onclick="botonMasRespuestas_IE(' . $aux . ');"></left>';
                            $mform->addElement('html', $botonañadir);
                        }

                        $mform->addElement('hidden', 'numeropreguntas', $p);


                        break;
                    case 2: //El archivo respuesta es un audio
                        //echo "texto-audio";

                        $script = '<script type="text/javascript"> $(document).ready(function(){ arreglar_texto_audio_AM(); }); </script>';
                        $mform->addElement('html', $script);

                        for ($i = 0; $i < $p; $i++) {

                            $aux = $i + 1;
                            $titulo = '</br><h3>' . get_string('asociacion', 'ejercicios') . $aux . " " . get_string('aContinuacion', 'ejercicios') . '</h3>';
                            $mform->addElement('html', $titulo);

                            //Archivo Asociacion
                            $mform->addElement('textarea', 'pregunta' . $aux, get_string('Asociacion_Texto', 'ejercicios') . $aux, 'wrap="virtual" rows="5" cols="50"');
                            //Archivo Asociado 
                            //Intentar encerrar los archivos de audio en un div
                            $mform->addElement('html', '<div  id="respuestas_pregunta' . $aux . '"> ');
                            $mform->addElement('file', 'archivoaudio' . $aux, "Audio");
                            $mform->addRule('archivoaudio' . $aux, "Archivo Necesario", 'required', null, 'client');
                            $mform->addElement('html', '<input type="hidden" name="numerorespuestas_' . $aux . '" id="numerorespuestas_' . $aux . '" value="1"/>');
                            $mform->addElement('html', '</div>');

                            $botonañadir = '<left><input type="button" style="height:30px; width:140px;" value="' . get_string('BotonAñadirRespuesta', 'ejercicios') . '" onclick="botonMasRespuestasAudio_AM(' . $aux . ');"></left>';
                            $mform->addElement('html', $botonañadir);
                        }

                        $mform->addElement('hidden', 'numeropreguntas', $p);


                        break;
                    case 3: //El archivo respuesta es un video
                        $script = '<script type="text/javascript"> $(document).ready(function(){ arreglar_texto_video_AM(); }); </script>';
                        $mform->addElement('html', $script);

                        for ($i = 0; $i < $p; $i++) {

                            $aux = $i + 1;
                            $titulo = '</br><h3>' . get_string('asociacion', 'ejercicios') . $aux . " " . get_string('aContinuacion', 'ejercicios') . '</h3>';
                            $mform->addElement('html', $titulo);

                            //Archivo Asociacion
                            $mform->addElement('textarea', 'pregunta' . $aux, get_string('Asociacion_Texto', 'ejercicios') . $aux, 'wrap="virtual" rows="5" cols="50"');
                            //Archivo Asociado
                            $mform->addElement('html', '<div id="respuestas_pregunta' . $aux . '"> ');
                            $attributes = 'size="100"';
                            $mform->addElement('text', 'archivovideo' . $aux, get_string('Video', 'ejercicios'), $attributes);
                            $mform->addRule('archivovideo' . $aux, "Dirección Web Necesaria", 'required', null, 'client');
                            $mform->addElement('html', '<input type="hidden" name="numerorespuestas_' . $aux . '" id="numerorespuestas_' . $aux . '" value="1"/>');
                            $mform->addElement('html', '</div>');

                            $botonañadir = '<left><input type="button" style="height:30px; width:140px;" value="' . get_string('BotonAñadirRespuesta', 'ejercicios') . '" onclick="botonMasRespuestasVideo_AM(' . $aux . ');"></left>';
                            $mform->addElement('html', $botonañadir);
                        }



                        $mform->addElement('hidden', 'numeropreguntas', $p);



                        break;
                    case 4: //El archivo respuesta es una imagen
                        //echo "texto-imagen";

                        $script = '<script type="text/javascript"> $(document).ready(function(){ arreglar_texto_foto_AM(); }); </script>';
                        $mform->addElement('html', $script);

                        for ($i = 0; $i < $p; $i++) {

                            $aux = $i + 1;
                            $titulo = '</br><h3>' . get_string('asociacion', 'ejercicios') . $aux . " " . get_string('aContinuacion', 'ejercicios') . '</h3>';
                            $mform->addElement('html', $titulo);
                            //echo "aki si llega";
                            //Archivo Asociacion
                            $mform->addElement('textarea', 'pregunta' . $aux, get_string('Asociacion_Texto', 'ejercicios') . $aux, 'wrap="virtual" rows="5" cols="50"');
                            //Archivo Asociado
                            $mform->addElement('html', '<div id="respuestas_pregunta' . $aux . '"> ');
                            $mform->addElement('file', 'archivofoto' . $aux, get_string('foto', 'ejercicios'));
                            $mform->addRule('archivofoto' . $aux, "Archivo Necesario", 'required', null, 'client');
                            $mform->addElement('html', '<input type="hidden" name="numerorespuestas_' . $aux . '" id="numerorespuestas_' . $aux . '" value="1"/>');
                            $mform->addElement('html', '</div>');

                            $botonañadir = '<left><input type="button" style="height:30px; width:140px;" value="' . get_string('BotonAñadirRespuesta', 'ejercicios') . '" onclick="botonMasRespuestasFoto_AM(' . $aux . ');"></left>';
                            $mform->addElement('html', $botonañadir);
                        }

                        $mform->addElement('hidden', 'numeropreguntas', $p);
                        //echo "aki llega con angel";


                        break;
                }

                break;

            case 2: //El archivo de origen es un audio

                switch ($tiporespuesta) {

                    case 1: //El archivo respuesta es un texto
                        //echo "audio-texto aaaa";

                        for ($i = 0; $i < $p; $i++) {

                            $aux = $i + 1;
                            $titulo = '</br><h3>' . get_string('asociacion', 'ejercicios') . $aux . " " . get_string('aContinuacion', 'ejercicios') . '</h3>';
                            $mform->addElement('html', $titulo);

                            //Archivo Asociacion
                            $mform->addElement('file', 'archivoaudio' . $aux, "Audio");
                            $mform->addRule('archivoaudio' . $aux, "Archivo Necesario", 'required', null, 'client');

                            //Archivo Asociado
                            $mform->addElement('html', '<div id="respuestas_pregunta' . $aux . '"> ');
                            $mform->addElement('textarea', 'respuesta' . $aux . '_1', get_string('Asociacion_Texto', 'ejercicios'), 'wrap="virtual" rows="5" cols="50"');
                            $mform->addElement('html', '<input type="hidden" name="numerorespuestas_' . $aux . '" id="numerorespuestas_' . $aux . '" value="1"/>');
                            $mform->addElement('html', '</div>');

                            $botonañadir = '<left><input type="button" style="height:30px; width:140px;" value="' . get_string('BotonAñadirRespuesta', 'ejercicios') . '" onclick="botonMasRespuestasAFV_Texto_AM(' . $aux . ');"></left>';
                            $mform->addElement('html', $botonañadir);
                        }

                        $mform->addElement('hidden', 'numeropreguntas', $p);

                        break;
                }
                // "el archivo origen es un audio";

                break;

            case 3: //El archivo de origen es un video


                switch ($tiporespuesta) {

                    case 1: //El archivo respuesta es un texto
                        for ($i = 0; $i < $p; $i++) {

                            $aux = $i + 1;
                            $titulo = '</br><h3>' . get_string('asociacion', 'ejercicios') . $aux . " " . get_string('aContinuacion', 'ejercicios') . '</h3>';
                            $mform->addElement('html', $titulo);

                            //Archivo Asociacion
                            $attributes = 'size="100"';
                            $mform->addElement('text', 'archivovideo' . $aux, get_string('Video', 'ejercicios'), $attributes);
                            $mform->addRule('archivovideo' . $aux, "Dirección Web Necesaria", 'required', null, 'client');


                            //Archivo Asociado
                            $mform->addElement('html', '<div id="respuestas_pregunta' . $aux . '"> ');
                            $mform->addElement('textarea', 'respuesta' . $aux . '_1', get_string('Asociacion_Texto', 'ejercicios'), 'wrap="virtual" rows="5" cols="50"');
                            $mform->addElement('html', '<input type="hidden" name="numerorespuestas_' . $aux . '" id="numerorespuestas_' . $aux . '" value="1"/>');
                            $mform->addElement('html', '</div>');

                            $botonañadir = '<left><input type="button" style="height:30px; width:140px;" value="' . get_string('BotonAñadirRespuesta', 'ejercicios') . '" onclick="botonMasRespuestasAFV_Texto_AM(' . $aux . ');"></left>';
                            $mform->addElement('html', $botonañadir);
                        }

                        $mform->addElement('hidden', 'numeropreguntas', $p);
                        break;
                }

                // "el archivo origen es un audio";

                break;

            case 4: //El archivo de origen es una imagen

                if ($tiporespuesta == 1) {//La respuesta es un texto (la unica posibilidad)
                    for ($i = 0; $i < $p; $i++) {

                        $aux = $i + 1;
                        $titulo = '</br><h3>' . get_string('asociacion', 'ejercicios') . $aux . " " . get_string('aContinuacion', 'ejercicios') . '</h3>';
                        $mform->addElement('html', $titulo);

                        //Archivo Asociacion
                        $mform->addElement('file', 'archivofoto' . $aux, get_string('foto', 'ejercicios'));
                        $mform->addRule('archivofoto' . $aux, "Archivo Necesario", 'required', null, 'client');


                        //Archivo Asociado
                        $mform->addElement('html', '<div id="respuestas_pregunta' . $aux . '"> ');
                        $mform->addElement('textarea', 'respuesta' . $aux . '_1', get_string('Asociacion_Texto', 'ejercicios'), 'wrap="virtual" rows="5" cols="50"');
                        $mform->addElement('html', '<input type="hidden" name="numerorespuestas_' . $aux . '" id="numerorespuestas_' . $aux . '" value="1"/>');
                        $mform->addElement('html', '</div>');

                        $botonañadir = '<left><input type="button" style="height:30px; width:140px;" value="' . get_string('BotonAñadirRespuesta', 'ejercicios') . '" onclick="botonMasRespuestasAFV_Texto_AM(' . $aux . ');"></left>';
                        $mform->addElement('html', $botonañadir);
                    }

                    $mform->addElement('hidden', 'numeropreguntas', $p);
                }
        }



        $fuentes = genera_fuentes();
        $mform->addElement('html', $fuentes);

        $buttonarray = array();
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('Aceptar', 'ejercicios'), "style='margin-left:30%;' onclick=obtenernumeroRespuestas('$p');");
        $mform->addGroup($buttonarray, 'botones', '', array(' '), false);
    }

}

/*
 * Formulario para la creacion de actividades de tipo Texto Hueco
 */

class mod_ejercicios_creando_ejercicio_texto_hueco extends moodleform_mod {

    function mod_ejercicios_creando_ejercicio_texto_hueco($id, $p, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion) {
        // El fichero que procesa el formulario es gestion.php
        parent::moodleform('ejercicios_creacion_texto_hueco.php?id_curso=' . $id . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $trespuesta . '&tipocreacion=' . $tipocreacion);
    }

    function definition() {
        
    }

    /**
     * Function that add a table to the forma to show the main menu
     *
     * @author Serafina Molina Soto
     * @param $id id for the course
     * @param $p numero de preguntas
     * @param $id_ejercicio id del ejercicio que estamos creando
     * @param $tipoorigen: tipo de archivo origen( 1: Texto, 2: Audio, 3: Video, 4: Imagen)
     * @param $tiporespuesta: tipo de archivo origen( 1: Texto, 2: Audio, 3: Video, 4: Imagen)
     */
    function pintarformulariotextohueco($id, $p, $id_ejercicio, $tipoorigen, $tiporespuesta, $tipocreacion) {

        global $CFG, $COURSE, $USER;
        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);

        $mform = & $this->_form;

        $mform->addElement('html', '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.js"></script>');
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./estilo.css">');
        $mform->addElement('html', '<script type="text/javascript" src="./funciones.js"></script>');

        //titulo
        //$titulo= '<h1 class="instrucciones" >' . get_string('FormularioCreacionTextos', 'ejercicios') . '</h1>';
        $titulo = genera_titulos(get_string('FormularioCreacionTextos', 'ejercicios'), get_string('TH_title', 'ejercicios'), $id);
        $mform->addElement('html', $titulo);

        $ejercicioGeneral = unserialize($_SESSION['ejercicioGeneral']);
        $titulo = '<div style="font-size:1.2em">' . nl2br(get_string('IERC_descripcion', 'ejercicios')) . ' <br/><i><u>' . nl2br($ejercicioGeneral->get('descripcion')) . '</u></i></div>';
        $mform->addElement('html', $titulo);

        $oculto = '<input type="hidden" name="tipocreacion" id="tipocreacion" value="' . $tipocreacion . '"/>';
        $mform->addElement('html', $oculto);



        switch ($tipoorigen) {
            case 1: //El archivo de origen es un texto

                switch ($tiporespuesta) {

                    case 1: //El archivo respuesta es un texto
                        //echo "texto-texto";
                        //Para cada pregunta
                        for ($i = 0; $i < $p; $i++) {

                            $aux = $i + 1;
                            $titulo = '</br><h3>' . get_string('TH_texto', 'ejercicios') . $aux . '</h3>';
                            $mform->addElement('html', $titulo);

                            //Cuadro de texto donde se introducira el texto del cual se sacaran los huecos                          
                            $mform->addElement('textarea', 'pregunta' . $aux, get_string("TH_introduzca_texto", 'ejercicios'), 'wrap="virtual" rows="5" cols="50"');


                            //Se añade un boton para que se cree un nuevo hueco. 
                            $boton = '<center><input type="button" name="add_hueco' . $aux . '" id="add_hueco' . $aux . '" value="' . get_string('TH_add_hueco', 'ejercicios') . '" onclick="TH_addHueco_Creacion(' . $id_ejercicio . "," . $aux . ')" /></center>';
                            $mform->addElement('html', $boton);


                            //Archivo Asociado
                            //$mform->addElement('textarea', 'respuesta'.$aux, get_string('Asociacion_Texto_Asociado', 'ejercicios').$aux, 'wrap="virtual" rows="5" cols="50"');
                            $textarea = '</br><div id="titulorespuestas" style="margin-left:130px;">' . get_string('TH_huecos', 'ejercicios') . '</div>';
                            $textarea.='<div style="margin-left:310px;" id="respuestas_pregunta' . $aux . '"> ';
                            //$textarea.='<textarea name="respuesta1_'.$aux.'" id="respuesta1_'.$aux.'" rows="1" cols="50"></textarea>';

                            $textarea.='<input type="hidden" name="numerorespuestas_' . $aux . '" id="numerorespuestas_' . $aux . '" value="0"/>';
                            $textarea.='</div>';
                            $mform->addElement('html', $textarea);

                            // TODO COMPROBAR SI FUNCIONA LA FUNCION DE JAVASCRIPT DE MAS RESPUESTAS DE IE PARA ESTOS EJERCICIOS
                            //$botonañadir='<center><input type="button" style="height:30px; width:140px; margin-left:175px;" value="'.get_string('BotonAñadirRespuesta','ejercicios').'" onclick="botonMasRespuestas_IE('.$aux.');"></center>';
                            //$mform->addElement('html', $botonañadir);
                        }

                        $mform->addElement('hidden', 'numeropreguntas', $p);

                        //Añadir las opciones de configuracion:
                        //   - Si desea que aparezcan pistas sobre la longitud de las respuestas
                        //   - Si desea que aparezcan las palabras que van en los huecos en la parte inferior de la pagina
                        //   - Si desea que al darle a corregir se le mostrara cuales son las respuestas correctas o solo indicar si es correcta o no
                        $mform->addElement('html', '<br/><br/><br/>');
                        $mform->addElement('advcheckbox', 'TH_mostrar_pistas', get_string('TH_mostrar_pistas', 'ejercicios'));
                        $mform->addElement('advcheckbox', 'TH_mostrar_palabras', get_string('TH_mostrar_palabras', 'ejercicios'));
                        $mform->addElement('advcheckbox', 'TH_mostrar_soluciones', get_string('TH_mostrar_soluciones', 'ejercicios'));


                        break;
                }

                break;
        }
        $mform->addElement('html', '<br></br>');

        $fuentes = genera_fuentes();
        $mform->addElement('html', $fuentes);

        $buttonarray = array();
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('Aceptar', 'ejercicios'), "style='margin-left:30%;' onclick=obtenernumeroRespuestas('$p');");
        $mform->addGroup($buttonarray, 'botones', '', array(' '), false);
    }

}

/*
 * Formulario para la creacion de actividades de tipo Ordenar Elementos
 */

class mod_ejercicios_creando_ejercicio_ordenar_elementos extends moodleform_mod {

    function mod_ejercicios_creando_ejercicio_ordenar_elementos($id, $p, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion) {
        // El fichero que procesa el formulario es gestion.php
        parent::moodleform('ejercicios_creacion_ordenar_elementos.php?id_curso=' . $id . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $trespuesta . '&tipocreacion=' . $tipocreacion);
    }

    function definition() {
        
    }

    /**
     * Function that add a table to the forma to show the main menu
     *
     * @author Serafina Molina Soto
     * @param $id id for the course
     * @param $p numero de preguntas
     * @param $id_ejercicio id del ejercicio que estamos creando
     * @param $tipoorigen: tipo de archivo origen( 1: Texto, 2: Audio, 3: Video, 4: Imagen)
     * @param $tiporespuesta: tipo de archivo origen( 1: Texto, 2: Audio, 3: Video, 4: Imagen)
     */
    function pintarformularioordenarelementos($id, $p, $id_ejercicio, $tipoorigen, $tiporespuesta, $tipocreacion) {

        global $CFG, $COURSE, $USER;
        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);

        $mform = & $this->_form;

        $mform->addElement('html', '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.js"></script>');
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./estilo.css">');
        $mform->addElement('html', '<script type="text/javascript" src="./funciones.js"></script>');

        $tipoorden = $_SESSION['tipoorden'];


        //titulo
        //$titulo= '<h1>' . get_string('OE_FormularioCreacionTextos', 'ejercicios') . '</h1>';
        $titulo = genera_titulos(get_string('OE_FormularioCreacionTextos', 'ejercicios'), get_string('OE_title', 'ejercicios'), $id);
        $mform->addElement('html', $titulo);

        $oculto = '<input type="hidden" name="tipocreacion" id="tipocreacion" value="' . $tipocreacion . '"/>';
        $mform->addElement('html', $oculto);


        $ejercicioGeneral = unserialize($_SESSION['ejercicioGeneral']);
        $titulo = '<div style="font-size:1.2em">' . nl2br(get_string('IERC_descripcion', 'ejercicios')) . ' <br/><i><u>' . nl2br($ejercicioGeneral->get('descripcion')) . '</u></i></div>';
        $mform->addElement('html', $titulo);


        $html = '<h2>' . get_string('OE_config', 'ejercicios') . '</h2>';
        $mform->addElement('html', $html);
        $radioarray = array();
        $radioarray[] = &$mform->createElement('radio', 'orden_unico', '', get_string('OE_orden_unico', 'ejercicios'), 0, 'onchange="ocultarH4()"');
        if ($tipoorden == "Frase") {
            $radioarray[] = &$mform->createElement('radio', 'orden_unico', '', get_string('OE_orden_multiple', 'ejercicios'), 1, 'onchange="mostrarH4()"');
        }
        $mform->addGroup($radioarray, 'group_orden_unico', '', array(' '), false);
        //$mform->addElement('advcheckbox','OE_orden_unico',get_string('OE_orden_unico','ejercicios'));
        $html = '<br/><h4 id="h4_p" style="visibility:hidden;">' . get_string('OE_help_orden_multiple', 'ejercicios') . '</h4>';
        $mform->addElement('html', $html);
        $mform->addElement('html', '<br/>');

        $html = '<h2>' . get_string('OE_list_preguntas', 'ejercicios') . '</h2>';
        $mform->addElement('html', $html);

        $help = '<h3>' . get_string('OE_help_add_palabra', 'ejercicios') . '</h3>';
        $help.='<h3 id="h4_p2" style="visibility:hidden">' . get_string('OE_help_add_more_palabra', 'ejercicios') . '</h3>';
        $mform->addElement('html', $help);

        //Para cada pregunta
        for ($i = 0; $i < $p; $i++) {

            $aux = $i + 1;
            $titulo = '</br><h3>' . get_string("OE_pregunta", 'ejercicios', $aux) . ' </h3>';
            $mform->addElement('html', $titulo);


            //Cuadro de texto donde se introducira el texto del cual se sacaran los huecos                          
            //get_string("OE_seleccione", 'ejercicios')
            $textarea = '<textarea style="resize:none;" wrap="virtual" rows="5" cols="120" name="pregunta' . $aux . '" id="id_pregunta' . $aux . '" ></textarea>';
            $mform->addElement('html', $textarea);
            //$mform->addElement('textarea', 'pregunta' . $aux, '', 'style="resize:none;" wrap="virtual" rows="5" cols="78"');
            //Se añade un boton para que se cree un nuevo hueco. 
            //$boton = '<center><input type="button" name="add_orden' . $aux . '" id="add_orden' . $aux . '" value="' . get_string('OE_add_orden', 'ejercicios') . '" onclick="OE_addOrden_Creacion(' . $id_ejercicio . "," . $aux . ')" /></center>';
            //$mform->addElement('html', $boton);
            //$textarea='<input type="hidden" name="num_orden_' . $aux . '" id="num_orden_' . $aux . '" value="1" />';
            //Archivo Asociado
            //$mform->addElement('textarea', 'respuesta'.$aux, get_string('Asociacion_Texto_Asociado', 'ejercicios').$aux, 'wrap="virtual" rows="5" cols="50"');
            $textarea = '</br><div id="titulorespuestas_' . $aux . '" >';
            //$textarea.='<div id="orden'.$aux.'" style="margin-left:130px;">Elementos a ordenar';
            $textarea.='<br/><center><input type="button" name="add_palabra" onclick="OE_AddPalabra_Creacion(' . $id_ejercicio . "," . $aux . ')" id="add_palabra" value="' . get_string('OE_add_palabra', 'ejercicios') . '" /></center>';
            $textarea.='<table id="resp_orden_' . $aux . '"> ';
            //$textarea.='<textarea name="respuesta1_'.$aux.'" id="respuesta1_'.$aux.'" rows="1" cols="50"></textarea>';

            $textarea.='<input type="hidden" name="num_resp_' . $aux . '" id="num_resp_' . $aux . '" value="0"/>';
            $textarea.='<tbody id="tbody_' . $aux . '" ></tbody>';
            $textarea.='</table>';
            //$textarea.='</div>';
            $textarea.='</div>';
            $mform->addElement('html', $textarea);

            // TODO COMPROBAR SI FUNCIONA LA FUNCION DE JAVASCRIPT DE MAS RESPUESTAS DE IE PARA ESTOS EJERCICIOS
            //$botonañadir='<center><input type="button" style="height:30px; width:140px; margin-left:175px;" value="'.get_string('BotonAñadirRespuesta','ejercicios').'" onclick="botonMasRespuestas_IE('.$aux.');"></center>';
            //$mform->addElement('html', $botonañadir);
        }

        $html = '<input type="hidden" name="numeropreguntas" id="numeropreguntas" value="' . $p . '" />';
        $mform->addElement('html', $html);

        $fuentes = genera_fuentes();
        $mform->addElement('html', $fuentes);


        //$buttonarray = array();
        //$buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('Aceptar','ejercicios'),"onclick=obtenernumeroRespuestas('$p');");
        $html = '<br/><br/><center><input onclick="obtenernumeroRespuestas(' . $p . ');" name="submitbutton" value="' . get_string('Aceptar', 'ejercicios') . '" type="submit" id="id_submitbutton"></center>';
        $mform->addElement('html', $html);
        //$buttonarray[] = &$mform->createElement('button', 'add_frase', get_string('OE_add_frase','ejercicios'),'onclick=OE_Add_Frase('.$id_ejercicio.');');
        //$mform->addGroup($buttonarray, 'botones', '', array(' '), false);
    }

}

/*
 * Formulario para la creación de actividades de tipo Asociación simple
 */

class mod_ejercicios_creando_ejercicio_identificar_elementos extends moodleform_mod {

    function mod_ejercicios_creando_ejercicio_identificar_elementos($id, $p, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion) {
        // El fichero que procesa el formulario es gestion.php
        parent::moodleform('ejercicios_form_creacion_identificar_elementos.php?id_curso=' . $id . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $trespuesta . '&tipocreacion=' . $tipocreacion);
    }

    function definition() {
        
    }

    /**
     * Function that add a table to the forma to show the main menu
     *
     * @author Serafina Molina Soto
     * @param $id id for the course
     * @param $p numero de preguntas
     * @param $id_ejercicio id del ejercicio que estamos creando
     * @param $tipoorigen: tipo de archivo origen( 1: Texto, 2: Audio, 3: Video)
     * @param $tiporespuesta: tipo de archivo origen( 1: Texto, )
     */
    function pintarformulario_identificarelementos($id, $p, $id_ejercicio, $tipoorigen, $tiporespuesta, $tipocreacion) {
        global $CFG, $COURSE, $USER;
        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);

        $mform = & $this->_form;

        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./estilo.css">');
        $mform->addElement('html', '<script type="text/javascript" src="./funciones.js"></script>');
        //titulo
        //$titulo= '<h1 class="instrucciones" >' . get_string('FormularioCreacionTextos', 'ejercicios') . '</h1>';
        $titulo = genera_titulos(get_string('FormularioCreacionTextos', 'ejercicios'), get_string('IE_title', 'ejercicios'), $id);
        $mform->addElement('html', $titulo);

        $ejercicioGeneral = unserialize($_SESSION['ejercicioGeneral']);
        $titulo = '<div style="font-size:1.2em">' . nl2br(get_string('IERC_descripcion', 'ejercicios')) . ' <br/><i><u>' . nl2br($ejercicioGeneral->get('descripcion')) . '</u></i></div>';
        $mform->addElement('html', $titulo);

        $oculto = '<input type="hidden" name="tipocreacion" id="tipocreacion" value="' . $tipocreacion . '"/>';
        $mform->addElement('html', $oculto);
        //echo "tipo origen es: " . $tipoorigen;

        switch ($tipoorigen) {
            case 1: //El archivo de origen es un texto
                //Añade una breve introducción al ejercicio
                //echo "entra para el cuadro general";
                $mform->addElement('textarea', 'archivoorigen', get_string('textoorigen', 'ejercicios'), 'wrap="virtual" rows="10" cols="50"');
                $mform->addRule('archivoorigen', "Texto Origen Necesario", 'required', null, 'client');

                break;
            case 2: //El archivo de origen es un audio
                $mform->addElement('file', 'archivoaudio', "Audio");
                $mform->addRule('archivoaudio', "Archivo Necesario", 'required', null, 'client');
                // "el archivo origen es un audio";

                break;

            case 3: //El archivo de origen es un video
                //Titule su ejercicio para facilitar la identificación o búsqueda
                $attributes = 'size="100"';
                $mform->addElement('text', 'archivovideo', get_string('Video', 'ejercicios'), $attributes);
                $mform->addRule('archivovideo', "Dirección Web Necesaria", 'required', null, 'client');

                // "el archivo origen es un audio";

                break;
        }


        //Para cada pregunta
        for ($i = 0; $i < $p; $i++) {

            $aux = $i + 1;
            $titulo = '</br><h3> Pregunta ' . $aux . '</h3>';
            $mform->addElement('html', $titulo);

            $mform->addElement('textarea', 'pregunta' . $aux, get_string('pregunta', 'ejercicios') . $aux, 'wrap="virtual" rows="5" cols="50"');


            $textarea = '</br><div id="titulorespuestas" style="margin-left:130px;">Respuestas:</div>';
            $textarea.='<div style="margin-left:310px;" id="respuestas_pregunta"' . $aux . '"> ';
            $textarea.='<textarea name="respuesta1_' . $aux . '" id="respuesta1_' . $aux . '" rows="1" cols="50"></textarea>';
            //$textarea.='</br><div id="correctarespuesta">'.get_string('Correcta', 'ejercicios');
            //$textarea.='<input type="radio"  name="correcta1_'.$aux.'" id="correcta1_'.$aux.'" value="Si" checked> Si </input>';
            //$textarea.='<input type="radio" name="correcta1_'.$aux.'"  id="correcta1_'.$aux.'" value="No"> No </input>';
            //$textarea.='</br>';
            //$textarea.='</div>';


            $textarea.='<input type="hidden" name="numerorespuestas_' . $aux . '" id="numerorespuestas_' . $aux . '" value="1"/>';
            $textarea.='</div>';
            $mform->addElement('html', $textarea);

            // $mform->addElement('text', 'numerorespuestas_'.$aux,"hola");
            $botonañadir = '<center><input type="button" style="height:30px; width:140px; margin-left:175px;" value="' . get_string('BotonAñadirRespuesta', 'ejercicios') . '" onclick="botonMasRespuestas_IE(' . $aux . ');"></center>';

            $mform->addElement('html', $botonañadir);
        }

        $mform->addElement('hidden', 'numeropreguntas', $p);


        $buttonarray = array();
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('Aceptar', 'ejercicios'), "style='margin-left:30%;' onclick=obtenernumeroRespuestas('$p');");
        $mform->addGroup($buttonarray, 'botones', '', array(' '), false);
    }

}

/*
 * Formulario para la creación de actividades de tipo Identificar Elementos más Respuesta(s) Corta(s)
 */

class mod_ejercicios_creando_ejercicio_ierc extends moodleform_mod {

    function mod_ejercicios_creando_ejercicio_ierc($id, $p, $id_ejercicio, $tipo_origen, $trespuesta, $tipocreacion) {
        // El fichero que procesa el formulario es ejercicios_form_creacion_ierc.php
        parent::moodleform('ejercicios_form_creacion_ierc.php?id_curso=' . $id . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $trespuesta . '&tipocreacion=' . $tipocreacion);
    }

    function definition() {
        
    }

    /**
     * Dibuja el formulario del ejercicio
     *
     * @author Ángel Biedma Mesa y Javier Castro Fernández
     * @param $id id for the course
     * @param $p numero de preguntas
     * @param $id_ejercicio id del ejercicio que estamos creando
     * @param $tipoorigen: tipo de archivo origen( 1: Texto, 2: Audio, 3: Video)
     * @param $tiporespuesta: tipo de archivo origen( 1: Texto, )
     */
    function pintarformulario_identificarelementos($id, $p, $id_ejercicio, $tipoorigen, $tiporespuesta, $tipocreacion) {

        global $CFG, $COURSE, $USER;
        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);

        $mform = & $this->_form;

        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./style.css">');
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./estilo.css">');
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="./funciones.js"></script>');

        //Título
        $titulo = genera_titulos(get_string('FormularioCreacionTextos', 'ejercicios'), get_string('IERC_title', 'ejercicios'), $id);
        $mform->addElement('html', $titulo);

        $oculto = '<input type="hidden" name="tipocreacion" id="tipocreacion" value="' . $tipocreacion . '"/>';
        $oculto.='<input type="hidden" id="IERC_click" value="' . get_string('IERC_click', 'ejercicios') . '" />';
        $oculto.='<input type="hidden" id="IERC_eliminar" value="' . get_string('IERC_eliminar', 'ejercicios') . '" />';
        $mform->addElement('html', $oculto);

        //Instrucciones para el profesor
        $ejercicioGeneral = unserialize($_SESSION['ejercicioGeneral']);
        $instrucciones = '<div style="font-size:1.2em">' . nl2br(get_string('IERC_instruccionesProfesor', 'ejercicios')) . '</div>';
        $mform->addElement('html', $instrucciones);

        $mform->addElement('hidden', 'IERC_aux', $_SESSION['IERC']['numPreguntas']);

        //Para cada pregunta
        for ($i = 0; $i < $p; $i++) {

            $aux = $i + 1;
            $titulo = '</br><h3>' . get_string('IERC_pregunta', 'ejercicios', $aux) . '</h3>';
            $mform->addElement('html', $titulo);

            switch ($tipoorigen) {
                case 1: //El archivo origen es un texto
                    $textarea = '<textarea style="width:100%;" id="pregunta' . $aux . '" name="pregunta' . $aux . '" wrap="virtual" rows="5" cols="80"></textarea>';
                    $mform->addElement('html', $textarea);
                    $botonañadir = '<center><input type="button" style="height:30px; width:140px;" value="' . get_string('IERC_seleccionarPalabra', 'ejercicios') . '" onclick="IERC_addFila(' . $aux . ', true);"></center>';
                    $mform->addElement('html', $botonañadir);
                    break;
                case 2: //El archivo origen es un audio
                    $mform->addElement('file', 'pregunta' . $aux, "Audio");
                    $mform->addRule('pregunta' . $aux, "Archivo Necesario", 'required', null, 'client');
                    break;
                case 3: //El archivo origen es un video
                    $attributes = 'size="80"';
                    $mform->addElement('text', 'pregunta' . $aux, get_string('Video', 'ejercicios'), $attributes);
                    $mform->addRule('pregunta' . $aux, "Dirección Web Necesaria", 'required', null, 'client');
                    break;
            }

            $textarea = '</br><div id="titulorespuestas" >';

            $textarea.='<table style="width:100%; margin-bottom:15px;" id="tbl_resp_' . $aux . '" name="tbl_resp_' . $aux . '" /><thead>';
            $textarea.='<tr id="fila_0">';

            for ($l = 1; $l <= (integer) $_SESSION['IERC']['numPreguntas'] + 2; $l++) {
                if ($l == 1) { // Si es la primera columna
                    $textarea.='<th id="celda_' . $aux . '_0_' . $l . '" ><input type="text"  id="cab_' . $aux . '_0_' . $l . '" name="cab_' . $aux . '_0_' . $l . '" value="' . $_SESSION['IERC']['elemento'] . '" /></th>';
                }
                if ($l == 2) { // Si es la segunda columna
                    $textarea.='<th> &nbsp;&nbsp;&nbsp; </th>';
                }
                if ($l > 2) { // Si es la tercera columna en adelante
                    $titulo = "titulo" . ($l - 2);
                    $textarea.='<th id="celda_' . $aux . '_0_' . ($l - 1) . '" ><input type="text"  id="cab_' . $aux . '_0_' . ($l - 1) . '" name="cab_' . $aux . '_0_' . ($l - 1) . '" value="' . $_SESSION['IERC'][$titulo] . '" /></th>';
                }
            }

            $textarea.='<th>Acciones</th>';
            $textarea.='</tr></thead>';
            $textarea.='<tbody><tr id="fila_1">';
            for ($l = 1; $l <= (integer) $_SESSION['IERC']['numPreguntas'] + 2; $l++) {
                if ($l == 1) { // Si es la primera columna  
                    $textarea.='<td id="celda_' . $aux . '_1_' . $l . '" ><center><input type="text" name="resp_' . $aux . '_1_' . $l . '" value="" /></center></td>';
                }
                if ($l == 2) { // Si es la segunda columna
                    $textarea.='<td></td>';
                }
                if ($l > 2) { // Si es la tercera columna en adelante
                    $textarea.='<td id="celda_' . $aux . '_1_' . ($l - 1) . '" ><center><input type="text" name="resp_' . $aux . '_1_' . ($l - 1) . '" value="" /></center></td>';
                }
            }
            $textarea.='<td id="celda_' . $aux . '_1_img"><center><img id="del_resp_' . $aux . '_1" name="del_resp_' . $aux . '_1" src="./imagenes/delete.gif" onclick="IERC_delFila(' . $aux . ',' . 1 . ')" >Eliminar</img></center></td>';
            $textarea.='</tr></tbody>';
            $textarea.='</table>';
            $textarea.='</div>';


            $textarea.='<input type="hidden" name="numerorespuestas_' . $aux . '" id="numerorespuestas_' . $aux . '" value="1"/>';

            $mform->addElement('html', $textarea);

            // $mform->addElement('text', 'numerorespuestas_'.$aux,"hola");
            $botonañadir = '<center><input type="button" style="height:30px; width:140px;" value="' . get_string('BotonAñadirRespuesta', 'ejercicios') . '" onclick="IERC_addFila(' . $aux . ', false);"></center>';

            $mform->addElement('html', $botonañadir);
        }

        $mform->addElement('hidden', 'numeropreguntas', $p);

        $fuentes = genera_fuentes();
        $mform->addElement('html', $fuentes);

        $botonAceptar = '<center><input type="submit" style="" id="submitbutton" name="submitbutton" value="' . get_string('Aceptar', 'ejercicios') . '" onclick=obtenernumeroRespuestas(' . $p . ')></center>';
        $mform->addElement('html', $botonAceptar);

        //$mform->addElement('submit', 'submitbutton', get_string('Aceptar','ejercicios'),"onclick=obtenernumeroRespuestas('$p');");
        //$mform->addGroup($buttonarray, 'botones', '', array(' '), false);      
    }

}

?>
