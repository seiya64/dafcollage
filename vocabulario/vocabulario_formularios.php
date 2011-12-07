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

Original idea and content design:
    Ruth Burbat
    Andrea Bies
    Julia Möller Runge
    Antonio Salmerón Matilla
    Karin Vilar Sánchez
    Inmaculada Almahano Güeto
    Blanca Rodríguez Gómez
    María José Varela Salinas

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.*/

require_once("$CFG->libdir/formslib.php");
require_once("vocabulario_classes.php");


/**
 * Class to create a form that is the GUI to save a combination of sustantive, adjetive,
 * verb and other word.
 *
 * @author Fco. Javier Rodríguez López
 *
 */
class mod_vocabulario_rellenar_form extends moodleform {

    function definition() {

        global $USER;
        $add = optional_param('add', PARAM_ALPHA);

        //creo los objetos
        $sustantivo = new Vocabulario_sustantivo();
        $adjetivo = new Vocabulario_adjetivo();
        $verbo = new Vocabulario_verbo();
        $otro = new Vocabulario_otro();

        //palabra que se va a editar
        //¡¡Cuidado!! esto sí es una asignación no una comparación
        if ($leido = optional_param('id_mp', 0, PARAM_INT)) {
            $cosa = new Vocabulario_mis_palabras();
            $cosa->leer($leido);
            $sustantivo = $cosa->get('sustantivo');
            //si se va añadir un verbo a la combinacion existente no se rellena
            if ($add != 'v') {
                $verbo = $cosa->get('verbo');
            }
            //si se va añadir un adjetivo a la combinacion existente no se rellena
            if ($add != 'a') {
                $adjetivo = $cosa->get('adjetivo');
            }
            //si se va añadir un otro a la combinacion existente no se rellena
            if ($add != 'o') {
                $otro = $cosa->get('otro');
            }
        }

        $mform = & $this->_form;

        $aux = new Vocabulario_campo_lexico();
        $clex = $aux->obtener_hijos($USER->id,0);

        $aux = new Vocabulario_gramatica();
        $cgra = $aux->obtener_hijos($USER->id,0);

        $aux = new Vocabulario_intenciones();
        $cintencion = $aux->obtener_todos($USER->id);

        $aux = new Vocabulario_tipologias();
        $ctipologia = $aux->obtener_todos($USER->id);

        //inclusion del css para que salga en columnitas
        //$mform->addElement('html','<link rel="stylesheet" type="text/css" href="./estilo.css">');

        //inclusion del javascript para las funciones
        $mform->addElement('html', '<script type="text/javascript" src="funciones.js"></script>');

        //inclusion del css para que se vean en dos columnas
        //$mform->addElement('html', '<script type="text/javascript" src="funciones.js"></script>');

        //titulo de la seccion
        $mform->addElement('html','<h1>'.get_string('guardar','vocabulario').'</h1>');

        if ($leido) {
            //$mform->addElement('text', 'idleido', '', 'value=' . $leido . ' hidden');
        }

        //campo lexico
        $mform->addElement('select', 'campoid', get_string("campo_lex", "vocabulario"), $clex,"onChange='javascript:cargaContenido(this.id,\"clgeneraldinamico\",0)'");
        $mform->setDefault('campoid', 1);
        if ($leido) {
            $aux = new Vocabulario_campo_lexico();
            $i = 1;
            $clex = $aux->obtener_padres($USER->id,$cosa->get('campoid'));
            $mform->setDefault('campoid', $clex[$i]);
        }

        //probar los campos dinamicos
        $campodinamico = "<div class=\"fitem\" id=\"clgeneraldinamico\"  style=\"min-height: 0;\">";
        while($leido && $clex[$i+1]) {
            $aux = new Vocabulario_campo_lexico();
            $claux = $aux->obtener_hijos($USER->id, $clex[$i]);
            $campodinamico .= '<div class="fitemtitle"></div>';
            $campodinamico .= '<div class="felement fselect">';
            $elselect = new MoodleQuickForm_select('campoid','Subcampo',$claux,"id=\"id_campoid".$clex[$i]."\" onChange='javascript:cargaContenido(this.id,\"".'campoid'."clgeneraldinamico".$clex[$i]."\",0)'");
            $elselect->setSelected($clex[$i+1]);
            $campodinamico .= $elselect->toHtml();
            $campodinamico .= '</div>';
            $campodinamico .= "<div class=\"fitem\" id=\"".'campoid'."clgeneraldinamico".$clex[$i]."\" style=\"min-height: 0;\"></div>";
            $i = $i+1;
        }
        $campodinamico .= "</div>";
        $mform->addElement('html', $campodinamico);

        //diccionario
        $dic = Array();
        $dic[0] = "DWDS";
        $dic[1] = "Leo";
        $dic[2] = "Pons";
        $dic[3] = "OThesaurus";
        $dic[4] = "Duden";
        $mform->addElement('select', 'diccionario', get_string("diccionario", "vocabulario"), $dic);
        $mform->setDefault('diccionario', 0);

        //------ sustantivo
        $mform->addElement('header', 'sus', get_string('sust', 'vocabulario'));

        $mform->addElement('text', 'palabra_sus', get_string("pal", "vocabulario"), 'value=' . $sustantivo->get('palabra'));
        //tiene que estar relleno
        $mform->addRule('palabra_sus', get_string('error_sus', 'vocabulario'), 'required', null, 'client');

        //genero
        $radioarray = array();
        $radioarray[] = &MoodleQuickForm::createElement('radio', 'genero', '', get_string("masc_corto", "vocabulario"), '0');
        $radioarray[] = &MoodleQuickForm::createElement('radio', 'genero', '', get_string("fem_corto", "vocabulario"), '1');
        $radioarray[] = &MoodleQuickForm::createElement('radio', 'genero', '', get_string("neu_corto", "vocabulario"), '2');
        $mform->addGroup($radioarray, 'Genero', get_string("gen", "vocabulario"), '', false);
        $mform->setDefault('genero', $sustantivo->get('genero'));

        //plural
        $mform->addElement('text', 'plural', get_string("plural", "vocabulario"), 'value="' . $sustantivo->get('plural') . '"');

        //traduccion
        $enlace_diccionario = '<a href="javascript:traducir(1)">[' . get_string("Tpal", "vocabulario") . ']</a>';
        $mform->addElement('text', 'significado_sus', $enlace_diccionario, 'value="' . $sustantivo->get('significado') . '"');

        //Comentarios
        $ocultador = "<div id=\"ocultador_sus\" style=\"display:none\">";
        $mform->addElement('html',$ocultador);
        $mform->addElement('text', 'observaciones_sus', get_string("comen", "vocabulario"), 'value="' . $sustantivo->get('observaciones') . '"');

        //ejemplo
        $mform->addElement('text', 'ejemplo_sus', get_string("ejem", "vocabulario"), 'value="' . $sustantivo->get('ejemplo') . '"');

        //campo gramatical
        $mform->addElement('select', 'gramatica_sus', get_string("campo_gram", "vocabulario"), $cgra,"onChange='javascript:cargaContenido(this.id,\"grgeneraldinamico\",1)'");
        //probar los campos dinamicos
        $campodinamico = "<div class=\"fitem\" id=\"grgeneraldinamico\"  style=\"min-height: 0;\"></div>";
        $mform->addElement('html', $campodinamico);
        $mform->setDefault('gramatica_sus', $sustantivo->get('gramaticaid'));
        $mform->addElement('hidden', 'descripcion_grsus');

        //intencion comunicativa
        $mform->addElement('select', 'intencion_sus', get_string("campo_intencion", "vocabulario"), $cintencion);
        $mform->setDefault('intencion_sus', $sustantivo->get('intencionid'));
        $mform->addElement('hidden', 'descripcion_intensus');

        //tipologia textual
        $mform->addElement('select', 'tipologia_sus', get_string("campo_tipologia", "vocabulario"), $ctipologia);
        $mform->setDefault('tipologia_sus', $sustantivo->get('tipologiaid'));
        $mform->addElement('hidden', 'descripcion_tiposus');
        $ocultador = "</div>";
        $mform->addElement('html',$ocultador);
        $ops = '<a href=\'javascript:desocultar("sus")\' id="mcsus">[' . get_string('mascampos', 'vocabulario') . ']</a>';
        $mform->addElement('static', 'opciones_adj', get_string("opciones", "vocabulario"), $ops);

        $mform->addElement('submit', 'submitbutton', get_string('savechanges'));
        $mform->closeHeaderBefore('vrb');
        ////------ sustantivo
        //------ verbo
        $mform->addElement('header', 'vrb', get_string('vrb', 'vocabulario'));

        //infinitivo
        $mform->addElement('text', 'infinitivo', get_string("infi", "vocabulario"), 'value="' . $verbo->get('infinitivo') . '"');

        //tercera persona
        $mform->addElement('text', 'ter_pers_sing', get_string("3per", "vocabulario"), 'value="' . $verbo->get('ter_pers_sing') . '"');

        //preterito
        $mform->addElement('text', 'preterito', get_string("pret", "vocabulario"), 'value="' . $verbo->get('preterito') . '"');

        //participio
        $mform->addElement('text', 'participio', get_string("part", "vocabulario"), 'value="' . $verbo->get('participio') . '"');

        //traduccion
        $enlace_diccionario = '<a href="javascript:traducir(2)">[' . get_string("Tpal", "vocabulario") . ']</a>';
        $mform->addElement('text', 'significado_vrb', $enlace_diccionario, 'value="' . $verbo->get('significado') . '"');

        //Comentarios
        $ocultador = "<div id=\"ocultador_verb\" style=\"display:none\">";
        $mform->addElement('html',$ocultador);
        $mform->addElement('text', 'observaciones_vrb', get_string("comen", "vocabulario"), 'value="' . $verbo->get('observaciones') . '"');

        //campo gramatical
        $mform->addElement('select', 'gramatica_vrb', get_string("campo_gram", "vocabulario"), $cgra,"onChange='javascript:cargaContenido(this.id,\"grgeneraldinamico_vrb\",1)'");
        //probar los campos dinamicos
        $campodinamico = "<div class=\"fitem\" id=\"grgeneraldinamico_vrb\" style=\"min-height: 0;\"></div>";
        $mform->addElement('html', $campodinamico);
        $mform->setDefault('gramatica_vrb', $verbo->get('gramaticaid'));
        $mform->addElement('hidden', 'descripcion_grvrb');

        //intencion comunicativa
        $mform->addElement('select', 'intencion_vrb', get_string("campo_intencion", "vocabulario"), $cintencion);
        $mform->setDefault('intencion_vrb', $verbo->get('intencionid'));
        $mform->addElement('hidden', 'descripcion_intenvrb');

        //tipologia textual
        $mform->addElement('select', 'tipologia_vrb', get_string("campo_tipologia", "vocabulario"), $ctipologia);
        $mform->setDefault('tipologia_vrb', $verbo->get('tipologiaid'));
        $mform->addElement('hidden', 'descripcion_tipovrb');

        //opciones
        $ocultador = "</div>";
        $mform->addElement('html',$ocultador);
        $ops = '<a href="view?id=' . optional_param('id', 0, PARAM_INT) . '&opcion=1&add=v&id_mp=' . $leido . '">[' . get_string('advrb', 'vocabulario') . ']</a>';
        $ops .= '<a href=\'javascript:desocultar("verb")\' id="mcverb">[' . get_string('mascampos', 'vocabulario') . ']</a>';
        $mform->addElement('static', 'opciones_vrb', get_string("opciones", "vocabulario"), $ops);

        $mform->addElement('submit', 'submitbutton', get_string('savechanges'));
        $mform->closeHeaderBefore('adj');
        ////------ verbo
        //------ adjetivo
        $mform->addElement('header', 'adj', get_string('adj', 'vocabulario'));

        //sin declinacion
        $mform->addElement('text', 'sindeclinar', get_string("sindec", "vocabulario"), 'value="' . $adjetivo->get('sin_declinar') . '"');

        //traduccion
        $enlace_diccionario = '<a href="javascript:traducir(3)">[' . get_string("Tpal", "vocabulario") . ']</a>';
        $mform->addElement('text', 'significado_adj', $enlace_diccionario, 'value="' . $adjetivo->get('significado') . '"');

        //Comentarios
        $ocultador = "<div id=\"ocultador_adj\" style=\"display:none\">";
        $mform->addElement('html',$ocultador);
        $mform->addElement('text', 'observaciones_adj', get_string("comen", "vocabulario"), 'value="' . $adjetivo->get('observaciones') . '"');

        //campo gramatical
        $mform->addElement('select', 'gramatica_adj', get_string("campo_gram", "vocabulario"), $cgra,"onChange='javascript:cargaContenido(this.id,\"grgeneraldinamico_adj\",1)'");
        //probar los campos dinamicos
        $campodinamico = "<div class=\"fitem\" id=\"grgeneraldinamico_adj\" style=\"min-height: 0;\"></div>";
        $mform->addElement('html', $campodinamico);
        $mform->setDefault('gramatica_adj', $adjetivo->get('gramaticaid'));
        $mform->addElement('hidden', 'descripcion_gradj');

        //intencion comunicativa
        $mform->addElement('select', 'intencion_adj', get_string("campo_intencion", "vocabulario"), $cintencion);
        $mform->setDefault('intencion_adj', $adjetivo->get('intencionid'));
        $mform->addElement('hidden', 'descripcion_intenadj');

        //tipologia textual
        $mform->addElement('select', 'tipologia_adj', get_string("campo_tipologia", "vocabulario"), $ctipologia);
        $mform->setDefault('tipologia_adj', $adjetivo->get('tipologiaid'));
        $mform->addElement('hidden', 'descripcion_tipoadj');

        //opciones
        $ocultador = "</div>";
        $mform->addElement('html',$ocultador);
        $ops = '<a href="view?id=' . optional_param('id', 0, PARAM_INT) . '&opcion=1&add=a&id_mp=' . $leido . '">[' . get_string('adadj', 'vocabulario') . ']</a>';
        $ops .= '<a href=\'javascript:desocultar("adj")\' id="mcadj">[' . get_string('mascampos', 'vocabulario') . ']</a>';
        $mform->addElement('static', 'opciones_adj', get_string("opciones", "vocabulario"), $ops);

        $mform->addElement('submit', 'submitbutton', get_string('savechanges'));
        $mform->closeHeaderBefore('otr');
        ////------ adjetivo
        //------ otros
        $mform->addElement('header', 'otr', get_string('otr', 'vocabulario'));

        //sustantivo
        $mform->addElement('text', 'palabra_otr', get_string("otr_sus", "vocabulario"), 'value="' . $otro->get('palabra') . '"');

        //traduccion
        $enlace_diccionario = '<a href="javascript:traducir(4)">[' . get_string("Tpal", "vocabulario") . ']</a>';
        $mform->addElement('text', 'significado_otr', $enlace_diccionario, 'value="' . $otro->get('significado') . '"');

        //Comentarios
        $ocultador = "<div id=\"ocultador_otr\" style=\"display:none\">";
        $mform->addElement('html',$ocultador);
        $mform->addElement('text', 'observaciones_otr', get_string("comen", "vocabulario"), 'value="' . $otro->get('observaciones') . '"');

        //campo gramatical
        $mform->addElement('select', 'gramatica_otr', get_string("campo_gram", "vocabulario"), $cgra,"onChange='javascript:cargaContenido(this.id,\"grgeneraldinamico_otr\",1)'");
        //probar los campos dinamicos
        $campodinamico = "<div class=\"fitem\" id=\"grgeneraldinamico_otr\" style=\"min-height: 0;\"></div>";
        $mform->addElement('html', $campodinamico);
        $mform->setDefault('gramatica_otr', $otro->get('gramaticaid'));
        $mform->addElement('hidden', 'descripcion_grotr');

        //intencion comunicativa
        $mform->addElement('select', 'intencion_otr', get_string("campo_intencion", "vocabulario"), $cintencion);
        $mform->setDefault('intencion_otr', $otro->get('intencionid'));
        $mform->addElement('hidden', 'descripcion_intenotr');

        //tipologia textual
        $mform->addElement('select', 'tipologia_otr', get_string("campo_tipologia", "vocabulario"), $ctipologia);
        $mform->setDefault('tipologia_otr', $otro->get('tipologiaid'));
        $mform->addElement('hidden', 'descripcion_tipootr');

        //opciones
        $ocultador = "</div>";
        $mform->addElement('html',$ocultador);
        $ops = '<a href="view?id=' . optional_param('id', 0, PARAM_INT) . '&opcion=1&add=o&id_mp=' . $leido . '">[' . get_string('adotr', 'vocabulario') . ']</a>';
        $ops .= '<a href=\'javascript:desocultar("otr")\' id="mcotr">[' . get_string('mascampos', 'vocabulario') . ']</a>';
        $mform->addElement('static', 'opciones_otr', get_string("opciones", "vocabulario"), $ops);


        $mform->addElement('submit', 'submitbutton', get_string('savechanges'));
        $mform->closeHeaderBefore('botones');
        ////------ otros
        //botones
        $buttonarray = array();
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('savechanges'));
        //$buttonarray[] = &$mform->createElement('reset', 'resetbutton', get_string('revert', 'vocabulario'));
        $buttonarray[] = &$mform->createElement('cancel', 'cancelbutton', get_string('cancel','vocabulario'));
        $mform->addGroup($buttonarray, 'botones', '', array(' '), false);
    }

}

/**
 * Class to create a form that is the GUI to show a empty form when the user don't hace
 * privileges
 *
 * @author Fco. Javier Rodríguez López
 *
 */
class mod_vocabulario_niguno_form extends moodleform {

    function definition() {
        echo get_string('nopermisos','vocabulario');
    }
}

/**
 * Class to create a form that is the GUI for the main menu.
 *
 * @author Fco. Javier Rodríguez López
 *
 */
class mod_vocabulario_opciones_form extends moodleform {

    function definition() {

    }

    /**
     * Function that add a table to the forma to show the main menu
     *
     * @author Fco. Javier Rodríguez López
     * @param $id id for the course
     *
     */
    function aniadircosas($id) {
        global $CFG, $COURSE, $USER;
        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);

        //Los iconos están sacados del tema de gnome que viene con ubuntu 11.04
        //No se si habrá que poner alguna referencia o algo raro por el tema de licencias
        $mform = & $this->_form;
        $tabla_menu = '<br><table class="flexible generaltable boxaligncenter boxwidthwide" style="text-align:center;"><tr>';
        //if (has_capability('moodle/legacy:editingteacher', $context, $USER->id, false)) {
        //no ve la opcion de guardar palabras
        //} else {
        //1,1
        $tabla_menu .='<td style="text-align:left"><p><a href="view?id=' . $id . '&opcion=1"><img src="./imagenes/guardar_palabras.png" id="id_guardar_im" name="guardar_im"/></br>' . get_string('guardar', 'vocabulario') . '</a></p></td>';
        //}
        //1,2
        $tabla_menu .='<td><p><a href="view?id=' . $id . '&opcion=2"><img src="./imagenes/ver_palabras.png" id="id_ver_im" name="ver_im"/></br>' . get_string('ver', 'vocabulario') . '</a></p></td>';
        //1,3
        $tabla_menu .='<td style="text-align:right"><p><a href="view?id=' . $id . '&opcion=3"><img src="./imagenes/campos_lexicos.png" id="id_campos_im" name="campos_im"/></br>' . get_string('admin_cl', 'vocabulario') . '</a></p></td></tr>';

        //2,1
        $tabla_menu .='<tr><td style="text-align:left"><p><a href="view?id=' . $id . '&opcion=5"><img src="./imagenes/administrar_gramaticas.png" id="id_gram_im" name="gram_im"/></br>' . get_string('admin_gr', 'vocabulario') . '</a></p></td>';
        //2,2
        $tabla_menu .='<td><p><a href="view?id=' . $id . '&opcion=13"><img src="./imagenes/listado.png" id="id_listado" name="listado"/></br>' . get_string('listado', 'vocabulario') . '</a></p></td>';
        //2,3
        $tabla_menu .='<td style="text-align:right"><p><a href="view?id=' . $id . '&opcion=8"><img src="./imagenes/nueva_ic.png" id="id_nueva_ic" name="nueva_ic"/></br>' . get_string('nueva_ic', 'vocabulario') . '</a></p></td></tr>';

        //3,1
        $tabla_menu .='<tr><td style="text-align:left"><p><a href="view?id=' . $id . '&opcion=7"><img src="./imagenes/intenciones_comunicativas.png" id="id_ic_im" name="ic_im"/></br>' . get_string('admin_ic', 'vocabulario') . '</a></p></td>';
        //3,2
        $tabla_menu .='<td><p><a href="./pdf?id=' . $id . '&us=' . $USER->id . '"><img src="./imagenes/pdf.png" id="id_pdf" name="pdf"/></br>' . get_string('pdf', 'vocabulario') . '</a></p></td>';
        //3,3
        $tabla_menu .='<td></td></tr>';

        //4,1
        $tabla_menu .='<tr><td style="text-align:left"><p><a href="view?id=' . $id . '&opcion=9"><img src="./imagenes/tipologias_textuales.png" id="id_tt_im" name="tt_im"/></br>' . get_string('admin_tt', 'vocabulario') . '</a></p></td>';
        //4,2
        $tabla_menu .='<td><p><a href="./manual.pdf"><img src="./imagenes/ayuda.png" id="id_ayuda" name="ayuda"/></br>' . get_string('ayuda', 'vocabulario') . '</a></p></td>';
        //4,3
        $tabla_menu .='<td></td></tr>';
        $tabla_menu .='</table>';
        $mform->addElement('html', $tabla_menu);
    }

}

/**
 * Class to create a form that is the GUI to show combinations save.
 *
 * @author Fco. Javier Rodríguez López
 *
 */
class mod_vocabulario_ver_form extends moodleform {

    var $id_tocho;

    function definition() {
        global $CFG, $COURSE, $USER;
        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);
        $mform = & $this->_form;
        //inclusion del javascript para las funciones
        $mform->addElement('html', '<script type="text/javascript" src="funciones.js"></script>');
        $this->id_tocho = required_param('id', PARAM_INT);
        $alfa = optional_param('alfa', '0', PARAM_INT);
        $cl = optional_param('cl', '0', PARAM_INT);
        $gr = optional_param('gr', '0', PARAM_INT);
        $ic = optional_param('ic', '0', PARAM_INT);
        $tt = optional_param('tt', '0', PARAM_INT);
        $valor_campoid = optional_param('campo', '0', PARAM_INT);
        $usuarioid = $USER->id;
        $mp = new Vocabulario_mis_palabras();

        //titulo de la seccion
        $mform->addElement('html','<h1>'.get_string('ver','vocabulario').'</h1>');

        $this->menu_opciones_visualizacion($mform, $usuarioid);

        if (!$alfa && !$cl && !$gr && !$ic && !$tt ) {
            $mis_palabras = vocabulario_todas_palabras($usuarioid);
        } else if ($cl) {

            $aux = new Vocabulario_campo_lexico();
            $clex = $aux->obtener_hijos($usuarioid,0);

            $mform->addElement('hidden','tipo','cl');
            $mform->addElement('select', 'campoid', get_string("campo_lex", "vocabulario"), $clex,"onChange='javascript:cargaContenido(this.id,\"clgeneraldinamico\",0)' style=\"min-height: 0;\"");
            if ($valor_campoid) {
                $mform->setDefault('campoid', $valor_campoid);
                $mis_palabras = vocabulario_todas_palabras($usuarioid, $valor_campoid);
            }

            //probar los campos dinamicos
            $campodinamico = "<div class=\"fitem\" id=\"clgeneraldinamico\"></div>";
            $mform->addElement('html', $campodinamico);

            //botones
            $buttonarray = array();
            $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('ver', 'vocabulario'));
            $mform->addGroup($buttonarray, 'botones', '', array(' '), false);

            $mform->addElement('html', '</br>');
        } else if ($gr) {

            $aux = new Vocabulario_gramatica();
            $clex = $aux->obtener_hijos($usuarioid,0);
            $mform->addElement('hidden','tipo','gr');
            $mform->addElement('select', 'campoid', get_string("campo_gram", "vocabulario"), $clex,"onChange='javascript:cargaContenido(this.id,\"clgeneraldinamico\",1)' style=\"min-height: 0;\"");
            if ($valor_campoid) {
                $mform->setDefault('campoid', $valor_campoid);
                $mis_palabras = vocabulario_todas_palabras($usuarioid, null, $valor_campoid);
            }

            //probar los campos dinamicos
            $campodinamico = "<div class=\"fitem\" id=\"clgeneraldinamico\"></div>";
            $mform->addElement('html', $campodinamico);

            //botones
            $buttonarray = array();
            $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('ver', 'vocabulario'));
            $mform->addGroup($buttonarray, 'botones', '', array(' '), false);

            $mform->addElement('html', '</br>');

        } else if ($tt) {

            $aux = new Vocabulario_tipologias();
            $clex = $aux->obtener_todos($usuarioid);
            $mform->addElement('hidden','tipo','tt');
            $mform->addElement('select', 'campoid', get_string("campo_tipologia", "vocabulario"), $clex,"style=\"min-height: 0;\"");
            if ($valor_campoid) {
                $mform->setDefault('campoid', $valor_campoid);
                $mis_palabras = vocabulario_todas_palabras($usuarioid, null, null, $valor_campoid);
            }

            //probar los campos dinamicos
            $campodinamico = "<div class=\"fitem\" id=\"clgeneraldinamico\"></div>";
            $mform->addElement('html', $campodinamico);

            //botones
            $buttonarray = array();
            $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('ver', 'vocabulario'));
            $mform->addGroup($buttonarray, 'botones', '', array(' '), false);

            $mform->addElement('html', '</br>');

        } else if ($ic) {

            $aux = new Vocabulario_intenciones();
            $clex = $aux->obtener_todos($usuarioid);
            $mform->addElement('hidden','tipo','ic');
            $mform->addElement('select', 'campoid', get_string("campo_intencion", "vocabulario"), $clex,"style=\"min-height: 0;\"");
            if ($valor_campoid) {
                $mform->setDefault('campoid', $valor_campoid);
                $mis_palabras = vocabulario_todas_palabras($usuarioid, null, null, null, $valor_campoid);
            }

            //probar los campos dinamicos
            $campodinamico = "<div class=\"fitem\" id=\"clgeneraldinamico\"></div>";
            $mform->addElement('html', $campodinamico);

            //botones
            $buttonarray = array();
            $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('ver', 'vocabulario'));
            $mform->addGroup($buttonarray, 'botones', '', array(' '), false);

            $mform->addElement('html', '</br>');

        } else if ($alfa) {

            $letra = optional_param('letra', 'a', PARAM_ALPHA);
            $abecedario = '<h1 style="text-align:center;">';
            $l = 'a';
            for ($i = 1; $i < 27; $i++) {
                $abecedario .= '<a href="./view?id=' . $this->id_tocho . '&opcion=2&alfa=1&letra=' . $l . '">[' . $l . ']</a>';
                $l++;
            }
            $abecedario .= '</h1>';
            $mform->addElement('html', $abecedario);
            //$mis_palabras = $mp->obtener_todas($usuarioid, $valor_campoid, $letra);
            $mis_palabras = vocabulario_todas_palabras($usuarioid, null, null, null, null, $letra);
        }

        $mform->addElement('html', '<p>');
        $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter boxwidthwide">');

        //titulillos de la tabla
        $titulillos = '<tr class="header">';
        $titulillos .= '<th>' . get_string('pal', 'vocabulario') . '</th>';
        $titulillos .= '<th>' . get_string('campo_lex', 'vocabulario') . '</th>';
        $titulillos .= '<th>' . get_string('campo_gram', 'vocabulario') . '</th>';
        $titulillos .= '<th>' . get_string('campo_intencion', 'vocabulario') . '</th>';
        $titulillos .= '<th>' . get_string('campo_tipologia', 'vocabulario') . '</th>';
        $titulillos .= '<th colspan=2>' . get_string('opciones', 'vocabulario') . '</th>';
        $titulillos .= '</tr>';

        $mform->addElement('html', $titulillos);

        //filas de la tabla
        $color = 0;
        //$mis_palabras = $mp->combinaciones_completas($USER->id);
        foreach ($mis_palabras as $cosa) {
            $fila = '<tr class="cell" style="text-align:center;';
            if ($color % 2 == 0) {
                $fila .= '">';
                $color = 0;
            } else {
                $fila .= 'background:#BDC7D8;">';
            }
            $fila .= '<td> ' . $cosa->pal . ' </td>';
            $fila .= '<td> ' . $cosa->campo . ' </td>';
            $fila .= '<td> ' . $cosa->gramatica . ' </td>';
            $fila .= '<td> ' . $cosa->intencion . ' </td>';
            $fila .= '<td> ' . $cosa->tipo . ' </td>';
            $acciones = '<a href="./view?id=' . $this->id_tocho . '&opcion=4&id_mp=' . $cosa->mpid . '">[' . get_string('editar', 'vocabulario') . ']</a></td>';
            $acciones .= '<td><a href="./guardar?id_tocho=' . $this->id_tocho . '&borrar=' . $cosa->mpid . '">[' . get_string('eliminar', 'vocabulario') . ']</a>';
            $fila .= '<td> ' . $acciones . ' </td>';
            $fila .= '</tr>';
            $mform->addElement('html', $fila);
            $color++;
        }

        $mform->addElement('html', '</table>');
        $mform->addElement('html', '<p>');
    }

    /**
     * Function to add the options of visualization to the GUI.
     *
     * @author Fco. Javier Rodríguez López
     * @param $mform form in wich it add options
     * @param $alid
     *
     */
    function menu_opciones_visualizacion($mform, $userid=0) {
        global $USER;
        //elegir la visualizacion
        if ($userid) {
            $atras = '<h1 class="main">';
            $atras .= '<a href="./view?id=' . $this->id_tocho . '&opcion=2&alid=' . $userid . '">[' . get_string('todo', 'vocabulario') . ']</a>';
            $atras .= '<a href="./view?id=' . $this->id_tocho . '&opcion=2&alfa=1&alid=' . $userid . '">[' . get_string('alfabetico', 'vocabulario') . ']</a>';
            $atras .= '<a href="./view?id=' . $this->id_tocho . '&opcion=2&cl=1&alid=' . $userid . '">[' . get_string('campo_lex', 'vocabulario') . ']</a>';
            $atras .= '<a href="./view?id=' . $this->id_tocho . '&opcion=2&gr=1&alid=' . $userid . '">[' . get_string('campo_gram', 'vocabulario') . ']</a></br>';
            $atras .= '<a href="./view?id=' . $this->id_tocho . '&opcion=2&ic=1&alid=' . $userid . '">[' . get_string('campo_intencion', 'vocabulario') . ']</a>';
            $atras .= '<a href="./view?id=' . $this->id_tocho . '&opcion=2&tt=1&alid=' . $userid . '">[' . get_string('campo_tipologia', 'vocabulario') . ']</a>';
            //$atras .= '<a href="./pdf?id=' . $this->id_tocho . '&us=' . $userid . '">[' . get_string('pdf', 'vocabulario') . ']</a>';
            $atras .= '<a href="./view?id=' . $this->id_tocho . '">[' . get_string('atras', 'vocabulario') . ']</a>';
            $atras .= '</h1>';
            $mform->addElement('html', $atras);
            $mform->addElement('html', '</br>');
        } else {
            $atras = '<h1 class="main">';
            $atras .= '<a href="./view?id=' . $this->id_tocho . '&opcion=2">[' . get_string('todo', 'vocabulario') . ']</a>';
            $atras .= '<a href="./view?id=' . $this->id_tocho . '&opcion=2&alfa=1">[' . get_string('alfabetico', 'vocabulario') . ']</a>';
            $atras .= '<a href="./view?id=' . $this->id_tocho . '&opcion=2&cl=1">[' . get_string('campo_lex', 'vocabulario') . ']</a>';
            $atras .= '<a href="./pdf?id=' . $this->id_tocho . '&us=' . $userid . '">[' . get_string('pdf', 'vocabulario') . ']</a>';
            $atras .= '<a href="./view?id=' . $this->id_tocho . '">[' . get_string('atras', 'vocabulario') . ']</a>';
            $atras .= '</h1>';
            $mform->addElement('html', $atras);
            $mform->addElement('html', '</br>');
        }
    }

}


class mod_vocabulario_nuevo_cl_form extends moodleform {

    function definition() {
        global $USER;
        $mform = & $this->_form;
        //inclusion del javascript para las funciones
        $mform->addElement('html', '<script type="text/javascript" src="funciones.js"></script>');

        $aux = new Vocabulario_campo_lexico();
        $clex = $aux->obtener_hijos($USER->id,0);

        //titulo de la seccion
        $mform->addElement('html','<h1>'.get_string('admin_cl','vocabulario').'</h1>');

        //campo lexico
        $mform->addElement('select', 'campoid', get_string("campo_lex", "vocabulario"), $clex,"onChange='javascript:cargaContenido(this.id,\"clgeneraldinamico\",0)' style=\"min-height: 0;\"");
        //probar los campos dinamicos
        $campodinamico = "<div class=\"fitem\" id=\"clgeneraldinamico\"></div>";
        $mform->addElement('html', $campodinamico);
        $mform->addElement('text', 'campo', get_string("campo_lex", "vocabulario"));

        //opcion de eliminar un campo
        $mform->addElement('checkbox', 'eliminar', get_string("eliminar", "vocabulario"));
        $mform->setDefault('eliminar', 0);

        //botones
        $buttonarray = array();
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('savechanges'));
        //$buttonarray[] = &$mform->createElement('reset', 'resetbutton', get_string('revert', 'vocabulario'));
        $buttonarray[] = &$mform->createElement('cancel', 'cancelbutton', get_string('cancel','vocabulario'));
        $mform->addGroup($buttonarray, 'botones', '', array(' '), false);
    }

}

class mod_vocabulario_nuevo_gr_form extends moodleform {

    function definition() {
        global $USER;
        $mform = & $this->_form;
        //inclusion del javascript para las funciones
        $mform->addElement('html', '<script type="text/javascript" src="funciones.js"></script>');

        $grid = optional_param('grid', 0, PARAM_INT);
        $id_tocho = optional_param('id', 0, PARAM_INT);

        $aux = new Vocabulario_gramatica();
        $gramaticas = $aux->obtener_hijos($USER->id, 0);
        $lista_padres = $aux->obtener_padres($USER->id, $grid);

        //titulo de la seccion
        $mform->addElement('html','<h1>'.get_string('admin_gr','vocabulario').'</h1>');

        //campo gramatical
        $mform->addElement('select', 'campogr', get_string("campo_gram", "vocabulario"), $gramaticas,"onChange='javascript:cargaContenido(this.id,\"grgeneraldinamico\",1)' style=\"min-height: 0;\"");
        $mform->setDefault('campogr', $lista_padres[1]);
        //probar los campos dinamicos
        $i = 1;
        $divparacerrar = 0;
        $campodinamico = "<div class=\"fitem\" id=\"grgeneraldinamico\"  style=\"min-height: 0;\">";
        while($lista_padres[$i+1]) {
            $aux = new Vocabulario_gramatica();
            $graux = $aux->obtener_hijos($USER->id, $lista_padres[$i]);
            $campodinamico .= '<div class="fitemtitle"></div>';
            $campodinamico .= '<div class="felement fselect">';
            $elselect = new MoodleQuickForm_select('campogr','Subcampo',$graux,"id=\"id_campogr".$lista_padres[$i]."\" onChange='javascript:cargaContenido(this.id,\"".'campogr'."grgeneraldinamico".$lista_padres[$i]."\",1)'");
            $elselect->setSelected($lista_padres[$i+1]);
            $campodinamico .= $elselect->toHtml();
            $campodinamico .= '</div>';
            $campodinamico .= "<div class=\"fitem\" id=\"".'campogr'."grgeneraldinamico".$lista_padres[$i]."\" style=\"min-height: 0;\">";
            $i = $i+1;
            $divparacerrar++;
        }
        for ($i = 0; $i < $divparacerrar; $i++) {
            $campodinamico .= "</div>";
        }
        $campodinamico .= "</div>";
        $mform->addElement('html', $campodinamico);

        $gr = new Vocabulario_mis_gramaticas();
        $gr->leer($grid,$USER->id);
        $descripcion_troceada = explode('&', $gr->get('descripcion'));
        switch ($grid) {
            //cuando no hay ninguno
            default:
            case 0:
                break;
            //1.1 Genus
            case 2:
            //masculino
                $mform->addElement('header', 'masculino', get_string('masculino', 'vocabulario'));
                $mform->addElement('textarea', 'mascsemantico', get_string('clasificacionsemantica', 'vocabulario'), 'rows="5" cols="30"');
                $mform->setDefault('mascsemantico', $descripcion_troceada[0]);
                $mform->addElement('textarea', 'mascformal', get_string('clasificacionformal', 'vocabulario'), 'rows="5" cols="30"');
                $mform->setDefault('mascformal', $descripcion_troceada[1]);
                $mform->closeHeaderBefore('femenino');
                //femenino
                $mform->addElement('header', 'femenino', get_string('femenino', 'vocabulario'));
                $mform->addElement('textarea', 'femsemantico', get_string('clasificacionsemantica', 'vocabulario'), 'rows="5" cols="30"');
                $mform->setDefault('femsemantico', $descripcion_troceada[2]);
                $mform->addElement('textarea', 'femformal', get_string('clasificacionformal', 'vocabulario'), 'rows="5" cols="30"');
                $mform->setDefault('femformal', $descripcion_troceada[3]);
                $mform->closeHeaderBefore('neutro');
                //neutro
                $mform->addElement('header', 'neutro', get_string('neutro', 'vocabulario'));
                $mform->addElement('textarea', 'neutrosemantico', get_string('clasificacionsemantica', 'vocabulario'), 'rows="5" cols="30"');
                $mform->setDefault('neutrosemantico', $descripcion_troceada[4]);
                $mform->addElement('textarea', 'neutroformal', get_string('clasificacionformal', 'vocabulario'), 'rows="5" cols="30"');
                $mform->setDefault('neutroformal', $descripcion_troceada[5]);
                $mform->closeHeaderBefore('botones');
                break;
            //1.2 Numerus
            case 3:
                $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter boxwidthwide">');
                //titulillos de la tabla
                $titulillos = '<tr class="header">';
                $titulillos .= '<th>' . get_string('endungs', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('genero', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('endungp', 'vocabulario') . '</th>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $titulillos = '<tr class="cell">';
                $titulillos .= '<td><textarea rows="7" id="id_endungs" name="endungs" value="' . $descripcion_troceada[0] . '"></textarea></td>';
                $titulillos .= '<td><textarea rows="7" id="id_genero" name="genero" value="' . $descripcion_troceada[1] . '"></textarea></td>';
                $titulillos .= '<td><textarea rows="7" id="id_endungp" name="endungp" value="' . $descripcion_troceada[2] . '"></textarea></td>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $mform->addElement('html', '</table>');

                $mform->addElement('textarea', 'reinesf', get_string('reinesf', 'vocabulario'), 'rows="5" cols="30"');
                $mform->setDefault('reinesf', $descripcion_troceada[0]);
                $mform->addElement('textarea', 'reinepf', get_string('reinepf', 'vocabulario'), 'rows="5" cols="30"');
                $mform->setDefault('reinepf', $descripcion_troceada[1]);

                break;
            //5.2.1 Deklination
            case 46:

            //TABLA 1
            //tabla
                $mform->addElement('html', '<p>');
                $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter boxwidthwide">');
                //titulillos de la tabla
                $titulillos = '<tr class="header">';
                $titulillos .= '<th colspan="5">' . get_string('declinacion1', 'vocabulario') . '</th>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="header">';
                $titulillos .= '<th colspan="5">&nbsp;</th>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="header">';
                $titulillos .= '<th>&nbsp;</th>';
                $titulillos .= '<th>' . get_string('masculino', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('neutro', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('femenino', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('plural', 'vocabulario') . '</th>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $titulillos = '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('nominativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_NM1" name="NM1" value="' . $descripcion_troceada[0] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_NN1" name="NN1" value="' . $descripcion_troceada[1] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_NF1" name="NF1" value="' . $descripcion_troceada[2] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_NP1" name="NP1" value="' . $descripcion_troceada[3] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('acusativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_AM1" name="AM1" value="' . $descripcion_troceada[4] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_AN1" name="AN1" value="' . $descripcion_troceada[5] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_AF1" name="AF1" value="' . $descripcion_troceada[6] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_AP1" name="AP1" value="' . $descripcion_troceada[7] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('dativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_DM1" name="DM1" value="' . $descripcion_troceada[8] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_DN1" name="DN1" value="' . $descripcion_troceada[9] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_DF1" name="DF1" value="' . $descripcion_troceada[10] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_DP1" name="DP1" value="' . $descripcion_troceada[11] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('genitivo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_GM1" name="GM1" value="' . $descripcion_troceada[12] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_GN1" name="GN1" value="' . $descripcion_troceada[13] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_GF1" name="GF1" value="' . $descripcion_troceada[14] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_GP1" name="GP1" value="' . $descripcion_troceada[15] . '"></td>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $mform->addElement('html', '</table>');
                $mform->addElement('html', '<p>');

                //añadir las dos textareas, uno para la idea(bombillita y otro para un listado de palabras
                $mform->addElement('html', '<p>');
                $mform->addElement('html', '<table class="flexible generaltable boxwidthwide">');

                $titulillos = '<tr>';
                //bombillita
                $titulillos .= '<td>';
                $mform->addElement('html', $titulillos);

                $mform->addElement('textarea', 'idea1', '<img src="./imagenes/idea.png" id="id_idea_im" name="idea_im"/>', 'rows="5" cols="30"');
                $mform->setDefault('idea1', $descripcion_troceada[16]);

                $titulillos = '</td>';
                $titulillos = '<td width="100px"></td>';
                //lista palabras
                $titulillos .= '<td>';
                $mform->addElement('html', $titulillos);

                $mform->addElement('textarea', 'despuesde1', get_string('despuesde','vocabulario'), 'rows="5" cols="30"');
                $mform->setDefault('despuesde1', $descripcion_troceada[17]);

                $titulillos = '</td>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);

                $mform->addElement('html', '</table>');
                $mform->addElement('html', '<p>');

                //TABLA 2
                //tabla
                $mform->addElement('html', '<p>');
                $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter boxwidthwide">');
                //titulillos de la tabla
                $titulillos = '<tr class="header">';
                $titulillos .= '<th colspan="5">' . get_string('declinacion2', 'vocabulario') . '</th>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="header">';
                $titulillos .= '<th colspan="5">&nbsp;</th>';
                $titulillos .= '</tr>';

                $titulillos .= '<tr class="header">';
                $titulillos .= '<th>&nbsp;</th>';
                $titulillos .= '<th>' . get_string('masculino', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('neutro', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('femenino', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('plural', 'vocabulario') . '</th>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $titulillos = '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('nominativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_NM2" name="NM2" value="' . $descripcion_troceada[18] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_NN2" name="NN2" value="' . $descripcion_troceada[19] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_NF2" name="NF2" value="' . $descripcion_troceada[20] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_NP2" name="NP2" value="' . $descripcion_troceada[21] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('acusativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_AM2" name="AM2" value="' . $descripcion_troceada[22] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_AN2" name="AN2" value="' . $descripcion_troceada[23] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_AF2" name="AF2" value="' . $descripcion_troceada[24] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_AP2" name="AP2" value="' . $descripcion_troceada[25] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('dativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_DM2" name="DM2" value="' . $descripcion_troceada[26] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_DN2" name="DN2" value="' . $descripcion_troceada[27] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_DF2" name="DF2" value="' . $descripcion_troceada[28] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_DP2" name="DP2" value="' . $descripcion_troceada[29] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('genitivo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_GM2" name="GM2" value="' . $descripcion_troceada[30] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_GN2" name="GN2" value="' . $descripcion_troceada[31] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_GF2" name="GF2" value="' . $descripcion_troceada[32] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_GP2" name="GP2" value="' . $descripcion_troceada[33] . '"></td>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $mform->addElement('html', '</table>');
                $mform->addElement('html', '<p>');

                //añadir las dos textareas, uno para la idea(bombillita y otro para un listado de palabras
                $mform->addElement('html', '<p>');
                $mform->addElement('html', '<table class="flexible generaltable boxwidthwide">');

                $titulillos = '<tr>';
                //bombillita
                $titulillos .= '<td>';
                $mform->addElement('html', $titulillos);

                $mform->addElement('textarea', 'idea2', '<img src="./imagenes/idea.png" id="id_idea_im" name="idea_im"/>', 'rows="5" cols="30"');
                $mform->setDefault('idea2', $descripcion_troceada[34]);

                $titulillos = '</td>';
                $titulillos = '<td width="100px"></td>';
                //lista palabras
                $titulillos .= '<td>';
                $mform->addElement('html', $titulillos);

                $mform->addElement('textarea', 'despuesde2',  get_string('despuesde','vocabulario'), 'rows="5" cols="30"');
                $mform->setDefault('despuesde2', $descripcion_troceada[35]);

                $titulillos = '</td>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);

                $mform->addElement('html', '</table>');
                $mform->addElement('html', '<p>');

                //TABLA 3
                //tabla
                $mform->addElement('html', '<p>');
                $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter boxwidthwide">');
                //titulillos de la tabla

                $titulillos = '<tr class="header">';
                $titulillos .= '<th colspan="5">' . get_string('declinacion3', 'vocabulario') . '</th>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="header">';
                $titulillos .= '<th colspan="5">&nbsp;</th>';
                $titulillos .= '</tr>';

                $titulillos .= '<tr class="header">';
                $titulillos .= '<th>&nbsp;</th>';
                $titulillos .= '<th>' . get_string('masculino', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('neutro', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('femenino', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('plural', 'vocabulario') . '</th>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $titulillos = '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('nominativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_NM3" name="NM3" value="' . $descripcion_troceada[36] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_NN3" name="NN3" value="' . $descripcion_troceada[37] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_NF3" name="NF3" value="' . $descripcion_troceada[38] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_NP3" name="NP3" value="' . $descripcion_troceada[39] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('acusativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_AM3" name="AM3" value="' . $descripcion_troceada[40] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_AN3" name="AN3" value="' . $descripcion_troceada[41] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_AF3" name="AF3" value="' . $descripcion_troceada[42] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_AP3" name="AP3" value="' . $descripcion_troceada[43] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('dativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_DM3" name="DM3" value="' . $descripcion_troceada[44] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_DN3" name="DN3" value="' . $descripcion_troceada[45] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_DF3" name="DF3" value="' . $descripcion_troceada[46] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_DP3" name="DP3" value="' . $descripcion_troceada[47] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('genitivo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_GM3" name="GM3" value="' . $descripcion_troceada[48] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_GN3" name="GN3" value="' . $descripcion_troceada[49] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_GF3" name="GF3" value="' . $descripcion_troceada[50] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_GP3" name="GP3" value="' . $descripcion_troceada[51] . '"></td>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $mform->addElement('html', '</table>');
                $mform->addElement('html', '<p>');

                //añadir las dos textareas, uno para la idea(bombillita y otro para un listado de palabras
                $mform->addElement('html', '<p>');
                $mform->addElement('html', '<table class="flexible generaltable boxwidthwide">');

                $titulillos = '<tr>';
                //bombillita
                $titulillos .= '<td>';
                $mform->addElement('html', $titulillos);

                $mform->addElement('textarea', 'idea3', '<img src="./imagenes/idea.png" id="id_idea_im" name="idea_im"/>', 'rows="5" cols="30"');
                $mform->setDefault('idea3', $descripcion_troceada[52]);

                $titulillos = '</td>';
                $titulillos = '<td width="100px"></td>';
                //lista palabras
                $titulillos .= '<td>';
                $mform->addElement('html', $titulillos);

                $mform->addElement('textarea', 'despuesde3', get_string('despuesde','vocabulario'), 'rows="5" cols="30"');
                $mform->setDefault('despuesde3', $descripcion_troceada[53]);

                $titulillos = '</td>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);

                $mform->addElement('html', '</table>');
                $mform->addElement('html', '<p>');

                break;
            //tablas verbos
            //3.1.1 Präsens
            case 20:
            //3.1.2 Präteritum
            case 21:
            //tabla
                $tope = 20;
                $ultimo = -1;
                for ($i=0; $i<$tope;$i++) {
                    $ocultador = '<div id="ocultador_tabla'.$i;
                    $salidor = false;
                    for ($j=0; $j<18 && $salidor==false;$j++) {
                        if($descripcion_troceada[(18*$i)+$j]) {
                            $salidor = true;
                            $ocultador .= '">';
                            $ultimo = $i;
                        }
                    }

                    if ($salidor == false && $i==0) {
                        $ocultador .= '">';
                    }

                    if ($salidor == false && $i!=0) {
                        $ocultador .= '" style="display:none">';
                    }

                    $mform->addElement('html', $ocultador);
                    //tabla schwache verben
                    $mform->addElement('html', '<p>');
                    $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter">');
                    //titulillos de la tabla
                    $titulillos = '<tr class="header">';
                    $titulillos .= '<th></th>';
                    $titulillos .= '<th>' . get_string('schwache', 'vocabulario') . '</th>';
                    $titulillos .= '<th></th>';
                    $titulillos .= '<th>' . get_string('starke', 'vocabulario') . '</th>';
                    $titulillos .= '<th></th>';
                    $titulillos .= '<th>' . get_string('gemischte', 'vocabulario') . '</th>';
                    $titulillos .= '</tr>';
                    $mform->addElement('html', $titulillos);
                    $titulillos = '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('S1', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_S1SC'.$i.'" name="S1SC'.$i.'" value="' . $descripcion_troceada[(18*$i)+0] . '"></td>';
                    $titulillos .= '<td class="cell">' . get_string('S1', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_S1ST'.$i.'" name="S1ST'.$i.'" value="' . $descripcion_troceada[(18*$i)+6] . '"></td>';
                    $titulillos .= '<td class="cell">' . get_string('S1', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_S1GE'.$i.'" name="S1GE'.$i.'" value="' . $descripcion_troceada[(18*$i)+12] . '"></td>';
                    $titulillos .= '</tr>';
                    $titulillos .= '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('S2', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_S2SC'.$i.'" name="S2SC'.$i.'" value="' . $descripcion_troceada[(18*$i)+1] . '"></td>';
                    $titulillos .= '<td class="cell">' . get_string('S2', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_S2ST'.$i.'" name="S2ST'.$i.'" value="' . $descripcion_troceada[(18*$i)+7] . '"></td>';
                    $titulillos .= '<td class="cell">' . get_string('S2', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_S2GE'.$i.'" name="S2GE'.$i.'" value="' . $descripcion_troceada[(18*$i)+13] . '"></td>';
                    $titulillos .= '</tr>';
                    $titulillos .= '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('S3', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_S3SC'.$i.'" name="S3SC'.$i.'" value="' . $descripcion_troceada[(18*$i)+2] . '"></td>';
                    $titulillos .= '<td class="cell">' . get_string('S3', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_S3ST'.$i.'" name="S3ST'.$i.'" value="' . $descripcion_troceada[(18*$i)+8] . '"></td>';
                    $titulillos .= '<td class="cell">' . get_string('S3', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_S3GE'.$i.'" name="S3GE'.$i.'" value="' . $descripcion_troceada[(18*$i)+14] . '"></td>';
                    $titulillos .= '</tr>';
                    $titulillos .= '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('P1', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_P1SC'.$i.'" name="P1SC'.$i.'" value="' . $descripcion_troceada[(18*$i)+3] . '"></td>';
                    $titulillos .= '<td class="cell">' . get_string('P1', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_P1ST'.$i.'" name="P1ST'.$i.'" value="' . $descripcion_troceada[(18*$i)+9] . '"></td>';
                    $titulillos .= '<td class="cell">' . get_string('P1', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_P1GE'.$i.'" name="P1GE'.$i.'" value="' . $descripcion_troceada[(18*$i)+15] . '"></td>';
                    $titulillos .= '</tr>';
                    $titulillos .= '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('P2', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_P2SC'.$i.'" name="P2SC'.$i.'" value="' . $descripcion_troceada[(18*$i)+4] . '"></td>';
                    $titulillos .= '<td class="cell">' . get_string('P2', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_P2ST'.$i.'" name="P2ST'.$i.'" value="' . $descripcion_troceada[(18*$i)+10] . '"></td>';
                    $titulillos .= '<td class="cell">' . get_string('P2', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_P2GE'.$i.'" name="P2GE'.$i.'" value="' . $descripcion_troceada[(18*$i)+16] . '"></td>';
                    $titulillos .= '</tr>';
                    $titulillos .= '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('P3', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_P3SC'.$i.'" name="P3SC'.$i.'" value="' . $descripcion_troceada[(18*$i)+5] . '"></td>';
                    $titulillos .= '<td class="cell">' . get_string('P3', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_P3ST'.$i.'" name="P3ST'.$i.'" value="' . $descripcion_troceada[(18*$i)+11] . '"></td>';
                    $titulillos .= '<td class="cell">' . get_string('P3', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_P3GE'.$i.'" name="P3GE'.$i.'" value="' . $descripcion_troceada[(18*$i)+17] . '"></td>';
                    $titulillos .= '</tr>';
                    $mform->addElement('html', $titulillos);
                    $mform->addElement('html', '</table>');
                    $mform->addElement('html', '<p>');

                    $mform->addElement('html', '</div>');

                }
                if ($ultimo+1 < $tope && $tope > 1) {
                    $ops = '<a href=\'javascript:desocultar("tabla'.($ultimo+1).'")\' id="mt">'.get_string("mastablas", "vocabulario").'</a>';
                    $mform->addElement('static', 'mas_tablas', '', $ops);
                }

                break;
            //3.1.5 Futur I
            case 24:
                $mform->addElement('textarea', 'futuro1', get_string("futuro1", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('futuro1', $descripcion_troceada[0]);
                break;
            //3.1.6 Futur II
            case 25:
                $mform->addElement('textarea', 'futuro2', get_string("futuro2", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('futuro2', $descripcion_troceada[0]);
                break;
            //3.7.2 Konjunktiv II
            case 33:
                $mform->addElement('html', '<p>');
                $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter">');
                //titulillos de la tabla
                $titulillos = '<tr class="header">';
                $titulillos .= '<th colspan="2">' . get_string('schwache_siehe', 'vocabulario') . '</th>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $titulillos = '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('S1', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_S1SC" name="S1SC" value="' . $descripcion_troceada[0] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('S2', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_S2SC" name="S2SC" value="' . $descripcion_troceada[1] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('S3', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_S3SC" name="S3SC" value="' . $descripcion_troceada[2] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('P1', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_P1SC" name="P1SC" value="' . $descripcion_troceada[3] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('P2', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_P2SC" name="P2SC" value="' . $descripcion_troceada[4] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('P3', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_P3SC" name="P3SC" value="' . $descripcion_troceada[5] . '"></td>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $mform->addElement('html', '</table>');
                $mform->addElement('html', '<p>');

                //siguiente tabla
                $mform->addElement('html', '<p>');
                $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter">');
                //titulillos de la tabla
                $titulillos = '<tr class="header">';
                $titulillos .= '<th></th>';
                $titulillos .= '<th colspan="2">' . get_string('starke','vocabulario') . '</th>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="header">';
                $titulillos .= '<th></th>';
                $titulillos .= '<th>' . get_string('preterito','vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('conjuntivo2','vocabulario') . '</th>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $titulillos = '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('S1', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_S1P" name="S1P" value="' . $descripcion_troceada[6] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_S1K" name="S1K" value="' . $descripcion_troceada[7] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('S2', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_S2P" name="S2P" value="' . $descripcion_troceada[8] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_S2K" name="S2K" value="' . $descripcion_troceada[9] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('S3', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_S3P" name="S3P" value="' . $descripcion_troceada[10] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_S3K" name="S3K" value="' . $descripcion_troceada[11] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('P1', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_P1P" name="P1P" value="' . $descripcion_troceada[12] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_P1K" name="P1K" value="' . $descripcion_troceada[13] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('P2', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_P2P" name="P2P" value="' . $descripcion_troceada[14] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_P2K" name="P2K" value="' . $descripcion_troceada[15] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('P3', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_P3P" name="P3P" value="' . $descripcion_troceada[16] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_P3K" name="P3K" value="' . $descripcion_troceada[17] . '"></td>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $mform->addElement('html', '</table>');
                $mform->addElement('html', '<p>');
                break;
            //3.3 Trennbare Verben
            case 27:
                $mform->addElement('textarea', 'trennbaren', get_string("trennbaren", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('trennbaren', $descripcion_troceada[0]);
                break;

            //3.2 Modalverben
            case 26:
            //3.4 Besondere Verben
            case 28:
            //tabla
                if ($grid == 26) {
                    $tope = 6;
                }
                elseif ($grid ==28) {
                    $tope = 10;
                }
                $ultimo = -1;
                for ($i=0; $i<$tope;$i++) {
                    $ocultador = '<div id="ocultador_tabla'.$i;
                    $salidor = false;
                    for ($j=0; $j<30 && $salidor==false;$j++) {
                        if($descripcion_troceada[(30*$i)+$j]) {
                            $salidor = true;
                            $ocultador .= '">';
                            $ultimo = $i;
                        }
                    }

                    if ($salidor == false && $i==0) {
                        $ocultador .= '">';
                    }

                    if ($salidor == false && $i!=0) {
                        $ocultador .= '" style="display:none">';
                    }

                    $mform->addElement('html', $ocultador);
                    $mform->addElement('html', '<p>');
                    $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter">');
                    //titulillos de la tabla
                    $titulillos = '<tr class="header">';
                    $titulillos .= '<th></th>';
                    $titulillos .= '<th colspan=3>' . get_string('indicativo','vocabulario') . '</th>';
                    $titulillos .= '<th colspan=2>' . get_string('conjuntivo','vocabulario') . '</th>';
                    $titulillos .= '</tr>';
                    $titulillos .= '<tr class="header">';
                    $titulillos .= '<th></th>';
                    $titulillos .= '<th>' . get_string('prasens','vocabulario') . '</th>';
                    $titulillos .= '<th>' . get_string('preterito','vocabulario') . '</th>';
                    $titulillos .= '<th>' . get_string('perfecto','vocabulario') . '</th>';
                    $titulillos .= '<th>' . get_string('conjuntivo1','vocabulario') . '</th>';
                    $titulillos .= '<th>' . get_string('conjuntivo2','vocabulario') . '</th>';
                    $titulillos .= '</tr>';
                    $mform->addElement('html', $titulillos);
                    $titulillos = '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('S1', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_S1PRA'.$i.'" name="S1PRA'.$i.'" value="' . $descripcion_troceada[30*$i+0] . '"></td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_S1PRE'.$i.'" name="S1PRE'.$i.'" value="' . $descripcion_troceada[30*$i+1] . '"></td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_S1PER'.$i.'" name="S1PER'.$i.'" value="' . $descripcion_troceada[30*$i+2] . '"></td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_S1PC1'.$i.'" name="S1PC1'.$i.'" value="' . $descripcion_troceada[30*$i+3] . '"></td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_S1PC2'.$i.'" name="S1PC2'.$i.'" value="' . $descripcion_troceada[30*$i+4] . '"></td>';
                    $titulillos .= '</tr>';
                    $titulillos .= '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('S2', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_S2PRA'.$i.'" name="S2PRA'.$i.'" value="' . $descripcion_troceada[30*$i+5] . '"></td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_S2PRE'.$i.'" name="S2PRE'.$i.'" value="' . $descripcion_troceada[30*$i+6] . '"></td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_S2PER'.$i.'" name="S2PER'.$i.'" value="' . $descripcion_troceada[30*$i+7] . '"></td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_S2PC1'.$i.'" name="S2PC1'.$i.'" value="' . $descripcion_troceada[30*$i+8] . '"></td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_S2PC2'.$i.'" name="S2PC2'.$i.'" value="' . $descripcion_troceada[30*$i+9] . '"></td>';
                    $titulillos .= '</tr>';
                    $titulillos .= '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('S3', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_S3PRA'.$i.'" name="S3PRA'.$i.'" value="' . $descripcion_troceada[30*$i+10] . '"></td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_S3PRE'.$i.'" name="S3PRE'.$i.'" value="' . $descripcion_troceada[30*$i+11] . '"></td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_S3PER'.$i.'" name="S3PER'.$i.'" value="' . $descripcion_troceada[30*$i+12] . '"></td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_S3PC1'.$i.'" name="S3PC1'.$i.'" value="' . $descripcion_troceada[30*$i+13] . '"></td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_S3PC2'.$i.'" name="S3PC2'.$i.'" value="' . $descripcion_troceada[30*$i+14] . '"></td>';
                    $titulillos .= '</tr>';
                    $titulillos .= '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('P1', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_P1PRA'.$i.'" name="P1PRA'.$i.'" value="' . $descripcion_troceada[30*$i+15] . '"></td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_P1PRE'.$i.'" name="P1PRE'.$i.'" value="' . $descripcion_troceada[30*$i+16] . '"></td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_P1PER'.$i.'" name="P1PER'.$i.'" value="' . $descripcion_troceada[30*$i+17] . '"></td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_P1PC1'.$i.'" name="P1PC1'.$i.'" value="' . $descripcion_troceada[30*$i+18] . '"></td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_P1PC2'.$i.'" name="P1PC2'.$i.'" value="' . $descripcion_troceada[30*$i+19] . '"></td>';
                    $titulillos .= '</tr>';
                    $titulillos .= '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('P2', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_P2PRA'.$i.'" name="P2PRA'.$i.'" value="' . $descripcion_troceada[30*$i+20] . '"></td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_P2PRE'.$i.'" name="P2PRE'.$i.'" value="' . $descripcion_troceada[30*$i+21] . '"></td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_P2PER'.$i.'" name="P2PER'.$i.'" value="' . $descripcion_troceada[30*$i+22] . '"></td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_P2PC1'.$i.'" name="P2PC1'.$i.'" value="' . $descripcion_troceada[30*$i+23] . '"></td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_P2PC2'.$i.'" name="P2PC2'.$i.'" value="' . $descripcion_troceada[30*$i+24] . '"></td>';
                    $titulillos .= '</tr>';
                    $titulillos .= '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('P3', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_P3PRA'.$i.'" name="P3PRA'.$i.'" value="' . $descripcion_troceada[30*$i+25] . '"></td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_P3PRE'.$i.'" name="P3PRE'.$i.'" value="' . $descripcion_troceada[30*$i+26] . '"></td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_P3PER'.$i.'" name="P3PER'.$i.'" value="' . $descripcion_troceada[30*$i+27] . '"></td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_P3PC1'.$i.'" name="P3PC1'.$i.'" value="' . $descripcion_troceada[30*$i+28] . '"></td>';
                    $titulillos .= '<td><input type="text" size=10 id="id_P3PC2'.$i.'" name="P3PC2'.$i.'" value="' . $descripcion_troceada[30*$i+29] . '"></td>';
                    $titulillos .= '</tr>';
                    $mform->addElement('html', $titulillos);
                    $mform->addElement('html', '</table>');
                    $mform->addElement('html', '<p>');

                    $mform->addElement('html', '</div>');
                }
                if ($ultimo+1 < $tope && $tope > 1) {
                    $ops = '<a href=\'javascript:desocultar("tabla'.($ultimo+1).'")\' id="mt">'.get_string("mastablas", "vocabulario").'</a>';
                    $mform->addElement('static', 'mas_tablas', '', $ops);
                }
                break;
            //3.7.1 Konjunktiv I
            case 32:
                $cabecera1 = get_string('sein', 'vocabulario');
                $cabecera2 = get_string('andere', 'vocabulario');

                //tabla
                $mform->addElement('html', '<p>');
                $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter">');
                //titulillos de la tabla
                $titulillos = '<tr class="header">';
                $titulillos .= '<th></th>';
                $titulillos .= '<th>' . $cabecera1 . '</th>';
                $titulillos .= '<th>' . $cabecera2 . '</th>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $titulillos = '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('S1', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_S1I" name="S1I" value="' . $descripcion_troceada[0] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_S1C" name="S1C" value="' . $descripcion_troceada[1] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('S2', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_S2I" name="S2I" value="' . $descripcion_troceada[2] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_S2C" name="S2C" value="' . $descripcion_troceada[3] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('S3', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_S3I" name="S3I" value="' . $descripcion_troceada[4] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_S3C" name="S3C" value="' . $descripcion_troceada[5] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('P1', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_P1I" name="P1I" value="' . $descripcion_troceada[6] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_P1C" name="P1C" value="' . $descripcion_troceada[7] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('P2', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_P2I" name="P2I" value="' . $descripcion_troceada[8] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_P2C" name="P2C" value="' . $descripcion_troceada[9] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('P3', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_P3I" name="P3I" value="' . $descripcion_troceada[10] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_P3C" name="P3C" value="' . $descripcion_troceada[11] . '"></td>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $mform->addElement('html', '</table>');
                $mform->addElement('html', '<p>');
                break;
            //3.1.3 Perfekt/Partizip II
            case 22:
                $mform->addElement('textarea', 'participio2', get_string("participio2", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('participio2', $descripcion_troceada[0]);
                $mform->addElement('textarea', 'hilfsverbs', get_string("hilfsverbs", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('hilfsverbs', $descripcion_troceada[1]);
                break;
            //3.1.4 Partizip I
            case 23:
                $mform->addElement('textarea', 'participio1', get_string("participio1", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('participio1', $descripcion_troceada[0]);
                break;
            //3.6 Passiv
            case 30:
                $mform->addElement('textarea', 'zustandspassiv', get_string("zustandspassiv", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('zustandspassiv', $descripcion_troceada[0]);
                $mform->addElement('textarea', 'vorganspassiv', get_string("vorganspassiv", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('vorganspassiv', $descripcion_troceada[1]);
                break;
            //2.5 Possessivpronomen
            case 14:
                $tope = 1;
                $ultimo = -1;

                //tabla
                for ($i=0; $i<$tope;$i++) {
                    $ocultador = '<div id="ocultador_tabla'.$i;
                    $salidor = false;
                    for ($j=0; $j<25 && $salidor==false;$j++) {
                        if($descripcion_troceada[(25*$i)+$j]) {
                            $salidor = true;
                            $ocultador .= '">';
                            $ultimo = $i;
                        }
                    }

                    if ($salidor == false && $i==0) {
                        $ocultador .= '">';
                    }

                    if ($salidor == false && $i!=0) {
                        $ocultador .= '" style="display:none">';
                    }
                    $mform->addElement('html', $ocultador);

                    // primera tabla de la plantilla
                    $mform->addElement('html', '<p>');
                    $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter boxwidthwide">');
                    //titulillos de la tabla

                    $titulillos = '<tr class="header">';
                    $titulillos .= '<th colspan = "10">' . get_string('possessiv1','vocabulario') . '</th>';
                    $titulillos .= '</tr>';

                    $titulillos .= '<tr class="header">';
                    $titulillos .= '<th>&nbsp;</th>';
                    $titulillos .= '<th colspan=5>'.get_string('sing','vocabulario').'</th>';
                    $titulillos .= '<th colspan=3>'.get_string('plural','vocabulario').'</th>';
                    $titulillos .= '<th rowspan=3>'.get_string('sie','vocabulario').'</th>';
                    $titulillos .= '</tr>';
                    $titulillos .= '<tr class="header">';
                    $titulillos .= '<th>&nbsp;</th>';
                    $titulillos .= '<th rowspan=2>1</th>';
                    $titulillos .= '<th rowspan=2>2</th>';
                    $titulillos .= '<th colspan=3>3</th>';
                    $titulillos .= '<th rowspan=2>1</th>';
                    $titulillos .= '<th rowspan=2>2</th>';
                    $titulillos .= '<th rowspan=2>3</th>';
                    $titulillos .= '</tr>';
                    $titulillos .= '<tr class="header">';
                    $titulillos .= '<th>&nbsp;</th>';
                    $titulillos .= '<th>m</th>';
                    $titulillos .= '<th>n</th>';
                    $titulillos .= '<th>f</th>';
                    $titulillos .= '</tr>';
                    $mform->addElement('html', $titulillos);
                    $titulillos = '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('snominativo', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" size="8" id="id_NS1'.$i.'" name="NS1'.$i.'" value="' . $descripcion_troceada[(25*$i)+0] . '"></td>';
                    $titulillos .= '<td><input type="text" size="8" id="id_NS2'.$i.'" name="NS2'.$i.'" value="' . $descripcion_troceada[(25*$i)+1] . '"></td>';
                    $titulillos .= '<td><input type="text" size="8" id="id_NS3M'.$i.'" name="NS3M'.$i.'" value="' . $descripcion_troceada[(25*$i)+2] . '"></td>';
                    $titulillos .= '<td><input type="text" size="8" id="id_NS3N'.$i.'" name="NS3N'.$i.'" value="' . $descripcion_troceada[(25*$i)+3] . '"></td>';
                    $titulillos .= '<td><input type="text" size="8" id="id_NS3F'.$i.'" name="NS3F'.$i.'" value="' . $descripcion_troceada[(25*$i)+4] . '"></td>';
                    $titulillos .= '<td><input type="text" size="8" id="id_NP1'.$i.'" name="NP1'.$i.'" value="' . $descripcion_troceada[(25*$i)+5] . '"></td>';
                    $titulillos .= '<td><input type="text" size="8" id="id_NP2'.$i.'" name="NP2'.$i.'" value="' . $descripcion_troceada[(25*$i)+6] . '"></td>';
                    $titulillos .= '<td><input type="text" size="8" id="id_NP3'.$i.'" name="NP3'.$i.'" value="' . $descripcion_troceada[(25*$i)+7] . '"></td>';
                    $titulillos .= '<td><input type="text" size="8" id="id_NSIE'.$i.'" name="NSIE'.$i.'" value="' . $descripcion_troceada[(25*$i)+8] . '"></td>';
                    $titulillos .= '</tr>';
                    $mform->addElement('html', $titulillos);
                    $mform->addElement('html', '</table>');
                    $mform->addElement('html', '<p>');

                    //siguiente tabla

                    $mform->addElement('html', '<p>');
                    $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter boxwidthwide">');
                    //titulillos de la tabla
                    $titulillos = '<tr class="header">';
                    $titulillos .= '<th colspan = "5">' . get_string('declinacion_siehe','vocabulario') . '</th>';
                    $titulillos .= '</tr>';
                    $titulillos .= '<tr class="header">';
                    $titulillos .= '<th></th>';
                    $titulillos .= '<th>' . get_string('masculino', 'vocabulario') . '</th>';
                    $titulillos .= '<th>' . get_string('neutro', 'vocabulario') . '</th>';
                    $titulillos .= '<th>' . get_string('femenino', 'vocabulario') . '</th>';
                    $titulillos .= '<th>' . get_string('plural', 'vocabulario') . '</th>';
                    $titulillos .= '</tr>';
                    $mform->addElement('html', $titulillos);
                    $titulillos = '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('nominativo', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_NM'.$i.'" name="NM'.$i.'" value="' . $descripcion_troceada[(25*$i)+9] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_NN'.$i.'" name="NN'.$i.'" value="' . $descripcion_troceada[(25*$i)+10] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_NF'.$i.'" name="NF'.$i.'" value="' . $descripcion_troceada[(25*$i)+11] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_NP'.$i.'" name="NP'.$i.'" value="' . $descripcion_troceada[(25*$i)+12] . '"></td>';
                    $titulillos .= '</tr>';
                    $titulillos .= '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('acusativo', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_AM'.$i.'" name="AM'.$i.'" value="' . $descripcion_troceada[(25*$i)+13] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_AN'.$i.'" name="AN'.$i.'" value="' . $descripcion_troceada[(25*$i)+14] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_AF'.$i.'" name="AF'.$i.'" value="' . $descripcion_troceada[(25*$i)+15] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_AP'.$i.'" name="AP'.$i.'" value="' . $descripcion_troceada[(25*$i)+16] . '"></td>';
                    $titulillos .= '</tr>';
                    $titulillos .= '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('dativo', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_DM'.$i.'" name="DM'.$i.'" value="' . $descripcion_troceada[(25*$i)+17] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_DN'.$i.'" name="DN'.$i.'" value="' . $descripcion_troceada[(25*$i)+18] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_DF'.$i.'" name="DF'.$i.'" value="' . $descripcion_troceada[(25*$i)+19] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_DP'.$i.'" name="DP'.$i.'" value="' . $descripcion_troceada[(25*$i)+20] . '"></td>';
                    $titulillos .= '</tr>';
                    $titulillos .= '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('genitivo', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_GM'.$i.'" name="GM'.$i.'" value="' . $descripcion_troceada[(25*$i)+21] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_GN'.$i.'" name="GN'.$i.'" value="' . $descripcion_troceada[(25*$i)+22] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_GF'.$i.'" name="GF'.$i.'" value="' . $descripcion_troceada[(25*$i)+23] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_GP'.$i.'" name="GP'.$i.'" value="' . $descripcion_troceada[(25*$i)+24] . '"></td>';
                    $titulillos .= '</tr>';
                    $mform->addElement('html', $titulillos);
                    $mform->addElement('html', '</table>');
                    $mform->addElement('html', '<p>');
                    $mform->addElement('html', '</div>');
                }
                if ($ultimo+1 < $tope && $tope > 1) {
                    $ops = '<a href=\'javascript:desocultar("tabla'.($ultimo+1).'")\' id="mt">'.get_string("mastablas", "vocabulario").'</a>';
                    $mform->addElement('static', 'mas_tablas', '', $ops);
                }
                break;
            //4.3 Possessivartikel
            case 38:
                $mform->addElement('html', '<p>');
                $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter boxwidthwide">');
                //titulillos de la tabla
                $titulillos = '<tr class="header">';
                $titulillos .= '<th colspan="6">'.get_string('possessiv2','vocabulario').'</th>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr>';
                $titulillos .= '<td colspan="6">&nbsp;</td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="header">';
                $titulillos .= '<th>&nbsp;</th>';
                $titulillos .= '<th colspan=5>'.get_string('sing','vocabulario').'</th>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="header">';
                $titulillos .= '<th>&nbsp;</th>';
                $titulillos .= '<th rowspan=2>1</th>';
                $titulillos .= '<th rowspan=2>2</th>';
                $titulillos .= '<th colspan=3>3</th>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="header">';
                $titulillos .= '<th>&nbsp;</th>';
                $titulillos .= '<th>m</th>';
                $titulillos .= '<th>n</th>';
                $titulillos .= '<th>f</th>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $titulillos = '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('nominativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" size="10" id="id_NS1" name="NS1" value="' . $descripcion_troceada[0] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_NS2" name="NS2" value="' . $descripcion_troceada[1] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_NS3M" name="NS3M" value="' . $descripcion_troceada[2] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_NS3N" name="NS3N" value="' . $descripcion_troceada[3] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_NS3F" name="NS3F" value="' . $descripcion_troceada[4] . '"></td>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $mform->addElement('html', '</table>');
                $mform->addElement('html', '<p>');

                $mform->addElement('html', '<p>');
                $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter">');
                //titulillos de la tabla
                $titulillos = '<tr class="header">';
                $titulillos .= '<th>&nbsp;</th>';
                $titulillos .= '<th colspan=3>'.get_string('plural','vocabulario').'</th>';
                $titulillos .= '<th rowspan=2>'.get_string('sie','vocabulario').'</th>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="header">';
                $titulillos .= '<th>&nbsp;</th>';
                $titulillos .= '<th>1</th>';
                $titulillos .= '<th>2</th>';
                $titulillos .= '<th>3</th>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $titulillos = '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('nominativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" size="10" id="id_NP1" name="NP1" value="' . $descripcion_troceada[5] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_NP2" name="NP2" value="' . $descripcion_troceada[6] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_NP3" name="NP3" value="' . $descripcion_troceada[7] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_NSIE" name="NSIE" value="' . $descripcion_troceada[8] . '"></td>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $mform->addElement('html', '</table>');
                $mform->addElement('html', '<p>');

                //la tabla que se muestra de forma opcional al pulsar un boton

                $mform->addElement('html','<br/><p>');
                $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter boxwidthwide">' );
                $titulillos = '<tr class="header">';
                $titulillos .= '<th>'.get_string('endungen_siehe4','vocabulario').'</th>';
                $mform->addElement('html',$titulillos);
                $mform->addElement('html','</table>');
                $mform->addElement('html','<p>');

                $ocultador = '<div id="ocultador_tabla';
                $salidor = false;
                for ($i=0; $i<16 && $salidor==false;$i++) {
                    if($descripcion_troceada[$i+9]) {
                        $salidor = true;
                        $ocultador .= '">';
                    }
                }

                if($salidor == false) {
                    $ops = '<a id="mctabla" href=\'javascript:desocultar("tabla")\'>'.get_string("muestra_tabla", "vocabulario").'</a>';
                    $mform->addElement('static', 'pon_tabla', '', $ops);
                    $ocultador .= '" style="display:none">';
                }

                $mform->addElement('html', $ocultador);
                $mform->addElement('html', '<p>');
                $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter boxwidthwide">');
                //titulillos de la tabla
                $titulillos = '<tr class="header">';
                $titulillos .= '<th></th>';
                $titulillos .= '<th colspan="5">' . get_string('declinacion4', 'vocabulario') . '</th>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="header">';
                $titulillos .= '<th></th>';
                $titulillos .= '<th>' . get_string('masculino', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('neutro', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('femenino', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('plural', 'vocabulario') . '</th>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $titulillos = '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('nominativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_NM" name="NM" value="' . $descripcion_troceada[9] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_NN" name="NN" value="' . $descripcion_troceada[10] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_NF" name="NF" value="' . $descripcion_troceada[11] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_NP" name="NP" value="' . $descripcion_troceada[12] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('acusativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_AM" name="AM" value="' . $descripcion_troceada[13] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_AN" name="AN" value="' . $descripcion_troceada[14] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_AF" name="AF" value="' . $descripcion_troceada[15] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_AP" name="AP" value="' . $descripcion_troceada[16] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('dativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_DM" name="DM" value="' . $descripcion_troceada[17] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_DN" name="DN" value="' . $descripcion_troceada[18] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_DF" name="DF" value="' . $descripcion_troceada[19] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_DP" name="DP" value="' . $descripcion_troceada[20] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('genitivo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_GM" name="GM" value="' . $descripcion_troceada[21] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_GN" name="GN" value="' . $descripcion_troceada[22] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_GF" name="GF" value="' . $descripcion_troceada[23] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_GP" name="GP" value="' . $descripcion_troceada[24] . '"></td>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $mform->addElement('html', '</table>');
                $mform->addElement('html', '<p>');
                $mform->addElement('html', '</div>');
                break;
            //4.1 Definitartikel
            case 36:
                if($grid == 36) {
                    $tabopcional = false;
                }
            //4.2 Indefinitartikel
            case 37:
                if($grid == 37) {
                    $tabopcional = false;
                }
            //4.4 Negationsartikel
            case 39:
                if($grid == 39) {
                    $titulo=get_string('endungen_siehe1','vocabulario');
                    $tabopcional = true;
                }
            //4.5 Interrogativartikel
            case 40:
                if($grid == 40) {
                    $titulo=get_string('endungen_siehe2','vocabulario');
                    $tabopcional = true;
                }
            //4.6 Demonstrativartikel
            case 41:
                if($grid == 41) {
                    $titulo=get_string('endungen_siehe3','vocabulario');
                    $tabopcional = true;
                }
            //2.3 Demonstrativpronomen
            case 8:
                if($grid == 8) {
                    $tabopcional = false;
                }
            //2.6 Relativpronomen
            case 15:
                if($grid == 15) {
                    $tabopcional = false;
                }
            //2.4.1 Als Artikelwörter gebrauche Indefinitpronomina
            case 10:
                if($grid == 10) {
                    $tabopcional = false;
                }
            //1.3 Deklination
            case 4:
                if($grid == 4) {
                    $tabopcional = false;
                }
                //para restrngir según la categoria
                $tope = 1;
                $ultimo = -1;
                switch ($grid) {
                    default:
                        $tope = 1;
                        break;
                    case 8:
                        $tope = 4;
                        break;
                    case 4:
                        $tope = 10;
                        break;
                }
                //tabla
                for ($i=0; $i<$tope;$i++) {
                    $ocultador = '<div id="ocultador_tabla'.$i;
                    $salidor = false;
                    for ($j=0; $j<16 && $salidor==false;$j++) {
                        if($descripcion_troceada[(16*$i)+$j]) {
                            $salidor = true;
                            $ocultador .= '">';
                            $ultimo = $i;
                        }
                    }
                    //para los casos 4.4, 4.5 y 4.6 decidimos el nuevo ocultador y la manera de hacerlo
                    if ($tabopcional == true) {

                        $mform->addElement('html','<p>');
                        $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter boxwidthwide">' );
                        $titulillos = '<tr class="header">';
                        $titulillos .= '<th>'.$titulo.'</th>';
                        $mform->addElement('html',$titulillos);
                        $mform->addElement('html','</table>');
                        $mform->addElement('html','<p>');

                        if($salidor == false) {
                            $ops = '<a id="mctabla'.($ultimo+1).'" href=\'javascript:desocultar("tabla'.($ultimo+1).'")\'>'.get_string("muestra_tabla", "vocabulario").'</a>';
                            $mform->addElement('static', 'pon_tabla', '', $ops);
                            $ocultador .= '" style="display:none">';
                        }

                    }else {//fin de para los casos 4.4, 4.5 y 4.6
                        if ($salidor == false && $i==0) {
                            $ocultador .= '">';
                        }

                        if ($salidor == false && $i!=0) {
                            $ocultador .= '" style="display:none">';
                        }
                    }

                    $mform->addElement('html', $ocultador);
                    $mform->addElement('html', '<p>');
                    $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter boxwidthwide">');
                    //titulillos de la tabla
                    $titulillos = '<tr class="header">';
                    $titulillos .= '<th></th>';
                    $titulillos .= '<th>' . get_string('masculino', 'vocabulario') . '</th>';
                    $titulillos .= '<th>' . get_string('neutro', 'vocabulario') . '</th>';
                    $titulillos .= '<th>' . get_string('femenino', 'vocabulario') . '</th>';
                    $titulillos .= '<th>' . get_string('plural', 'vocabulario') . '</th>';
                    $titulillos .= '</tr>';
                    $mform->addElement('html', $titulillos);
                    $titulillos = '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('nominativo', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_NM1'.$i.'" name="NM1'.$i.'" value="' . $descripcion_troceada[(16*$i)+0] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_NN1'.$i.'" name="NN1'.$i.'" value="' . $descripcion_troceada[(16*$i)+1] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_NF1'.$i.'" name="NF1'.$i.'" value="' . $descripcion_troceada[(16*$i)+2] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_NP1'.$i.'" name="NP1'.$i.'" value="' . $descripcion_troceada[(16*$i)+3] . '"></td>';
                    $titulillos .= '</tr>';
                    $titulillos .= '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('acusativo', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_AM1'.$i.'" name="AM1'.$i.'" value="' . $descripcion_troceada[(16*$i)+4] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_AN1'.$i.'" name="AN1'.$i.'" value="' . $descripcion_troceada[(16*$i)+5] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_AF1'.$i.'" name="AF1'.$i.'" value="' . $descripcion_troceada[(16*$i)+6] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_AP1'.$i.'" name="AP1'.$i.'" value="' . $descripcion_troceada[(16*$i)+7] . '"></td>';
                    $titulillos .= '</tr>';
                    $titulillos .= '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('dativo', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_DM1'.$i.'" name="DM1'.$i.'" value="' . $descripcion_troceada[(16*$i)+8] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_DN1'.$i.'" name="DN1'.$i.'" value="' . $descripcion_troceada[(16*$i)+9] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_DF1'.$i.'" name="DF1'.$i.'" value="' . $descripcion_troceada[(16*$i)+10] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_DP1'.$i.'" name="DP1'.$i.'" value="' . $descripcion_troceada[(16*$i)+11] . '"></td>';
                    $titulillos .= '</tr>';
                    $titulillos .= '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('genitivo', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_GM1'.$i.'" name="GM1'.$i.'" value="' . $descripcion_troceada[(16*$i)+12] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_GN1'.$i.'" name="GN1'.$i.'" value="' . $descripcion_troceada[(16*$i)+13] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_GF1'.$i.'" name="GF1'.$i.'" value="' . $descripcion_troceada[(16*$i)+14] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_GP1'.$i.'" name="GP1'.$i.'" value="' . $descripcion_troceada[(16*$i)+15] . '"></td>';
                    $titulillos .= '</tr>';
                    $mform->addElement('html', $titulillos);
                    $mform->addElement('html', '</table>');
                    $mform->addElement('html', '<p>');
                    $mform->addElement('html', '</div>');
                }
                if(!$tabopcional) {  //casos que no son 4.4, 4.5 y 4.6
                    if ($ultimo+1 < $tope && $tope > 1) {
                        $ops = '<a href=\'javascript:desocultar("tabla'.($ultimo+1).'")\' id="mt">'.get_string("mastablas", "vocabulario").'</a>';
                        $mform->addElement('static', 'mas_tablas', '', $ops);
                    }
                }
                break;
            //4.7 Gebrauch der Artikelwörter
            /*case 42:
                $mform->addElement('textarea', 'lista', get_string("lista", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('lista', $descripcion_troceada[0]);
                $mform->addElement('textarea', 'scheinbare', get_string("scheinbare", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('scheinbare', $descripcion_troceada[1]);
                break;
            */
            //7.1 Beispiele und Funktionen
            case 53:
                $mform->addElement('textarea', 'beispielsatz', get_string("beispielsatz", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('beispielsatz', $descripcion_troceada[0]);
                $mform->addElement('textarea', 'satzart', get_string("satzart", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('satzart', $descripcion_troceada[1]);
                $mform->addElement('textarea', 'komfun', get_string("komfun", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('komfun', $descripcion_troceada[1]);
                break;
            //2.2 Interrogativpronomen
            case 7:
            //tabla
                for ($i=0; $i<3;$i++) {
                    $mform->addElement('html', '<p>');
                    $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter">');
                    //titulillos de la tabla
                    $titulillos = '<tr class="header">';
                    $titulillos .= '<th></th>';
                    $titulillos .= '<th>' . get_string('person', 'vocabulario') . '</th>';
                    $titulillos .= '<th>' . get_string('nichtperson', 'vocabulario') . '</th>';
                    $titulillos .= '</tr>';
                    $mform->addElement('html', $titulillos);
                    $titulillos = '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('nominativo', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_NP" name="NP" value="' . $descripcion_troceada[0] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_NNP" name="NNP" value="' . $descripcion_troceada[1] . '"></td>';
                    $titulillos .= '</tr>';
                    $titulillos .= '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('acusativo', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_AP" name="AP" value="' . $descripcion_troceada[2] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_ANP" name="ANP" value="' . $descripcion_troceada[3] . '"></td>';
                    $titulillos .= '</tr>';
                    $titulillos .= '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('dativo', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_DP" name="DP" value="' . $descripcion_troceada[4] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_DNP" name="DNP" value="' . $descripcion_troceada[5] . '"></td>';
                    $titulillos .= '</tr>';
                    $titulillos .= '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('genitivo', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_GP" name="GP" value="' . $descripcion_troceada[6] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_GNP" name="GNP" value="' . $descripcion_troceada[7] . '"></td>';
                    $titulillos .= '</tr>';
                    $mform->addElement('html', $titulillos);
                    $mform->addElement('html', '</table>');
                }
                break;
            //8.3.1 Ergänzungen
            case 58:
                $mform->addElement('textarea', 'definido', get_string("definido", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('definido', $descripcion_troceada[0]);
                $mform->addElement('textarea', 'indefinido', get_string("indefinido", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('indefinido', $descripcion_troceada[1]);
                break;
            //8.3.2 Angaben
            case 59:
                $mform->addElement('textarea', 'temporal', get_string("temporal", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('temporal', $descripcion_troceada[0]);
                $mform->addElement('textarea', 'causal', get_string("causal", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('causal', $descripcion_troceada[1]);
                $mform->addElement('textarea', 'modal', get_string("modal", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('modal', $descripcion_troceada[2]);
                $mform->addElement('textarea', 'local', get_string("local", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('local', $descripcion_troceada[3]);
                break;
            //8.4.1 Konjunktoren
            case 62:
            //8.4.2 Subjunktoren
            case 63:
            //8.4.3 Konjunktionaladverbien
            case 64:
                $mform->addElement('textarea', 'func', get_string("func", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('func', $descripcion_troceada[0]);
                break;
            //8.1 Hauptsatz
            case 55:
            //tabla
                $mform->addElement('html', '<p>');
                $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter boxwidthwide">');
                //titulillos de la tabla
                $titulillos = '<tr class="header">';
                $titulillos .= '<th>' . get_string('vorfeld', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('konjugier', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('mittelfeld', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('verb2', 'vocabulario') . '</th>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                for ($i = 0; $i < count($descripcion_troceada); $i = $i+4) {
                    $titulillos = '<tr class="cell">';
                    $titulillos .= '<td><input type="text" id="id_vor'.$i.'" name="vor'.$i.'" value="' . $descripcion_troceada[$i] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_kon'.$i.'" name="kon'.$i.'" value="' . $descripcion_troceada[$i+1] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_mit'.$i.'" name="mit'.$i.'" value="' . $descripcion_troceada[$i+2] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_ver2'.$i.'" name="ver2'.$i.'" value="' . $descripcion_troceada[$i+3] . '"></td>';
                    $titulillos .= '</tr>';
                    $mform->addElement('html', $titulillos);
                }
                $mform->addElement('html', '</table>');
                break;
            //2.4.2.1 Pronomina, die nur Personen bezeichnen
            case 12:
            //tabla
                $mform->addElement('html', '<p>');
                $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter">');
                //titulillos de la tabla
                $titulillos = '<tr class="header">';
                $titulillos .= '<th>&nbsp;</th>';
                $titulillos .= '<th>&nbsp;</th>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $titulillos = '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('nominativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_NOM" name="NOM" value="' . $descripcion_troceada[0] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('acusativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_AKK" name="AKK" value="' . $descripcion_troceada[1] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('dativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_DAT" name="DAT" value="' . $descripcion_troceada[2] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('genitivo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_GEN" name="GEN" value="' . $descripcion_troceada[3] . '"></td>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $mform->addElement('html', '</table>');
                $mform->addElement('html', '<p>');
                break;
            //2.1 Personalpronomen
            case 6:
            //tabla para singular
                $mform->addElement('html', '<p>');
                $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter">');
                //titulillos de la tabla
                $titulillos = '<tr class="header">';
                $titulillos .= '<th>&nbsp;</th>';
                $titulillos .= '<th colspan=5>'.get_string('sing','vocabulario').'</th>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="header">';
                $titulillos .= '<th>&nbsp;</th>';
                $titulillos .= '<th>1</th>';
                $titulillos .= '<th>2</th>';
                $titulillos .= '<th colspan=3>3</th>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="header">';
                $titulillos .= '<th>&nbsp;</th>';
                $titulillos .= '<th>&nbsp;</th>';
                $titulillos .= '<th>&nbsp;</th>';
                $titulillos .= '<th>m</th>';
                $titulillos .= '<th>n</th>';
                $titulillos .= '<th>f</th>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $titulillos = '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('nominativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" size="10" id="id_NS1" name="NS1" value="' . $descripcion_troceada[0] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_NS2" name="NS2" value="' . $descripcion_troceada[1] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_NS3M" name="NS3M" value="' . $descripcion_troceada[2] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_NS3N" name="NS3N" value="' . $descripcion_troceada[3] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_NS3F" name="NS3F" value="' . $descripcion_troceada[4] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('acusativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" size="10" id="id_AS1" name="AS1" value="' . $descripcion_troceada[9] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_AS2" name="AS2" value="' . $descripcion_troceada[10] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_AS3M" name="AS3M" value="' . $descripcion_troceada[11] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_AS3N" name="AS3N" value="' . $descripcion_troceada[12] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_AS3F" name="AS3F" value="' . $descripcion_troceada[13] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('dativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" size="10" id="id_DS1" name="DS1" value="' . $descripcion_troceada[18] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_DS2" name="DS2" value="' . $descripcion_troceada[19] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_DS3M" name="DS3M" value="' . $descripcion_troceada[20] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_DS3N" name="DS3N" value="' . $descripcion_troceada[21] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_DS3F" name="DS3F" value="' . $descripcion_troceada[22] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('genitivo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" size="10" id="id_GS1" name="GS1" value="' . $descripcion_troceada[27] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_GS2" name="GS2" value="' . $descripcion_troceada[28] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_GS3M" name="GS3M" value="' . $descripcion_troceada[29] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_GS3N" name="GS3N" value="' . $descripcion_troceada[30] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_GS3F" name="GS3F" value="' . $descripcion_troceada[31] . '"></td>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $mform->addElement('html', '</table>');
                $mform->addElement('html', '<p>');
                //tabla para plural y sei
                $mform->addElement('html', '<p>');
                $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter">');
                //titulillos de la tabla
                $titulillos = '<tr class="header">';
                $titulillos .= '<th>&nbsp;</th>';
                $titulillos .= '<th colspan=4>'.get_string('plural','vocabulario').'</th>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="header">';
                $titulillos .= '<th>&nbsp;</th>';
                $titulillos .= '<th>1</th>';
                $titulillos .= '<th>2</th>';
                $titulillos .= '<th>3</th>';
                $titulillos .= '<th>'.get_string('sie','vocabulario').'</th>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $titulillos = '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('nominativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" size="10" id="id_NP1" name="NP1" value="' . $descripcion_troceada[5] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_NP2" name="NP2" value="' . $descripcion_troceada[6] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_NP3" name="NP3" value="' . $descripcion_troceada[7] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_NSIE" name="NSIE" value="' . $descripcion_troceada[8] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('acusativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" size="10" id="id_AP1" name="AP1" value="' . $descripcion_troceada[14] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_AP2" name="AP2" value="' . $descripcion_troceada[15] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_AP3" name="AP3" value="' . $descripcion_troceada[16] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_ASIE" name="ASIE" value="' . $descripcion_troceada[17] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('dativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" size="10" id="id_DP1" name="DP1" value="' . $descripcion_troceada[23] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_DP2" name="DP2" value="' . $descripcion_troceada[24] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_DP3" name="DP3" value="' . $descripcion_troceada[25] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_DSIE" name="DSIE" value="' . $descripcion_troceada[26] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('genitivo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" size="10" id="id_GP1" name="GP1" value="' . $descripcion_troceada[32] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_GP2" name="GP2" value="' . $descripcion_troceada[33] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_GP3" name="GP3" value="' . $descripcion_troceada[34] . '"></td>';
                $titulillos .= '<td><input type="text" size="10" id="id_GSIE" name="GSIE" value="' . $descripcion_troceada[35] . '"></td>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $mform->addElement('html', '</table>');
                $mform->addElement('html', '<p>');
                break;
            //8.2 Nebensatz
            case 56:

                $mform->addElement('html', '<p>');
                $mform->addElement('html','<table class="flexible generaltable generalbox boxaligncenter">');

                //titulillos de la tabla
                $titulillos = '<tr class="head">';
                $titulillos .='<th>'.get_string('subjunktor','vocabulario').'</th>';
                $titulillos .='<th>'.get_string('mittelfeld','vocabulario').'</th>';
                $titulillos .='<th>'.get_string('verb2','vocabulario').'</th>';
                $titulillos .='<th>'.get_string('konjugier','vocabulario').'</th>';
                $titulillos .= '</tr>';
                $mform->addElement('html',$titulillos);

                //A partir de aqui pinto filas según se van necesitando
                $tope = 20;
                $ultima = -1;

                for ($fila=0; $fila<$tope;$fila++) {
                    $ocultador = '<tr class="cell" id="ocultador_filaT'.$fila;
                    $salidor = false;
                    for ($j=0; $j<3 && $salidor==false;$j++) {
                        if($descripcion_troceada[((4*$fila)+$j)]) {
                            $salidor = true;
                            $ocultador .= '">';
                            $ultima = $fila;
                        }
                    }

                    if ($salidor == false && $fila==0) {
                        $ocultador .= '">';
                    }

                    if ($salidor == false && $fila!=0) {
                        $ocultador .= '" style="display:none">';
                    }

                    $mform->addElement('html', $ocultador);
                    $titulillos = '<td><input type="text" id="id_SUB'.$fila.'" name="SUB'.$fila.'" value="' . $descripcion_troceada[((4*$fila)+0)] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_MIT'.$fila.'" name="MIT'.$fila.'" value="' . $descripcion_troceada[((4*$fila)+1)] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_VER'.$fila.'" name="VER'.$fila.'" value="' . $descripcion_troceada[((4*$fila)+2)] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_KON'.$fila.'" name="KON'.$fila.'" value="' . $descripcion_troceada[((4*$fila)+3)] . '"></td>';
                    $titulillos .= '</tr>';
                    $mform->addElement('html', $titulillos);

                }
                $mform->addElement('html', '</table>');
                $mform->addElement('html', '<p>');

                if ($ultima+1 < $tope && $tope > 1) {
                    $ops = '<a href=\'javascript:desocultar("filaT'.($ultima+1).'")\' id="mf">'.get_string("masfilas", "vocabulario").'</a>';
                    $mform->addElement('static', 'mas_filas', '', $ops);
                }
                break;
            //3.8 Imperativ
            case 34:
                $tope = 10;
                $ultimo = -1;

                //tabla
                for ($i=0; $i<$tope;$i++) {
                    $ocultador = '<div id="ocultador_tabla'.$i;
                    $salidor = false;
                    for ($j=0; $j<3 && $salidor==false;$j++) {
                        if($descripcion_troceada[(3*$i)+$j]) {
                            $salidor = true;
                            $ocultador .= '">';
                            $ultimo = $i;
                        }
                    }

                    if ($salidor == false && $i==0) {
                        $ocultador .= '">';
                    }

                    if ($salidor == false && $i!=0) {
                        $ocultador .= '" style="display:none">';
                    }

                    $mform->addElement('html', $ocultador);
                    $mform->addElement('html', '<p>');
                    $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter">');
                    //titulillos de la tabla
                    $titulillos = '<tr class="header">';
                    $titulillos .= '<th colspan = "2">&nbsp;</th>';
                    $titulillos .= '</tr>';
                    $mform->addElement('html', $titulillos);
                    $titulillos = '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('S2', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_S2'.$i.'" name="S2'.$i.'" value="' . $descripcion_troceada[(3*$i)+0] . '"></td>';
                    $titulillos .= '</tr>';
                    $titulillos .= '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('P2', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_P2'.$i.'" name="P2'.$i.'" value="' . $descripcion_troceada[(3*$i)+1] . '"></td>';
                    $titulillos .= '</tr>';
                    $titulillos .= '<tr class="cell">';
                    $titulillos .= '<td class="cell">' . get_string('sie', 'vocabulario') . '</td>';
                    $titulillos .= '<td><input type="text" id="id_SIE'.$i.'" name="SIE'.$i.'" value="' . $descripcion_troceada[(3*$i)+2] . '"></td>';
                    $titulillos .= '</tr>';
                    $mform->addElement('html', $titulillos);
                    $mform->addElement('html', '</table>');
                    $mform->addElement('html', '<p>');
                    $mform->addElement('html', '</div>');
                }
                if ($ultimo+1 < $tope && $tope > 1) {
                    $ops = '<a href=\'javascript:desocultar("tabla'.($ultimo+1).'")\' id="mt">'.get_string("mastablas", "vocabulario").'</a>';
                    $mform->addElement('static', 'mas_tablas', '', $ops);
                }

                break;
            //3.5 Reflexive und reziproke Verben
            case 29:
                $mform->addElement('html', '<p>');
                $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter">');
                //titulillos de la tabla
                $titulillos = '<tr class="header">';
                $titulillos .= '<th colspan="8">'.get_string('reflexivo','vocabulario').'</th>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="header">';
                $titulillos .= '<th></th>';
                $titulillos .='<th colspan="3">'.get_string('sing','vocabulario').'</th>';
                $titulillos .='<th colspan="3">'.get_string('plural','vocabulario').'</th>';
                $titulillos .='<th>&nbsp;</th>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="header">';
                $titulillos .= '<th></th><th>1</th><th>2</th><th>3</th><th>1</th><th>2</th><th>3</th><th>'.get_string('sie','vocabulario').'</th>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $titulillos = '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('acusativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input size="10" type="text" id="id_AS1" name="AS1" value="' . $descripcion_troceada[0] . '"></td>';
                $titulillos .= '<td><input size="10" type="text" id="id_AS2" name="AS2" value="' . $descripcion_troceada[1] . '"></td>';
                $titulillos .= '<td><input size="10" type="text" id="id_AS3" name="AS3" value="' . $descripcion_troceada[2] . '"></td>';
                $titulillos .= '<td><input size="10" type="text" id="id_AP1" name="AP1" value="' . $descripcion_troceada[3] . '"></td>';
                $titulillos .= '<td><input size="10" type="text" id="id_AP2" name="AP2" value="' . $descripcion_troceada[4] . '"></td>';
                $titulillos .= '<td><input size="10" type="text" id="id_AP3" name="AP3" value="' . $descripcion_troceada[5] . '"></td>';
                $titulillos .= '<td><input size="8" type="text" id="id_ASIE" name="ASIE" value="' . $descripcion_troceada[6] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('dativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input size="10" type="text" id="id_DS1" name="DS1" value="' . $descripcion_troceada[7] . '"></td>';
                $titulillos .= '<td><input size="10" type="text" id="id_DS2" name="DS2" value="' . $descripcion_troceada[8] . '"></td>';
                $titulillos .= '<td><input size="10" type="text" id="id_DS3" name="DS3" value="' . $descripcion_troceada[9] . '"></td>';
                $titulillos .= '<td><input size="10" type="text" id="id_DP1" name="DP1" value="' . $descripcion_troceada[10] . '"></td>';
                $titulillos .= '<td><input size="10" type="text" id="id_DP2" name="DP2" value="' . $descripcion_troceada[11] . '"></td>';
                $titulillos .= '<td><input size="10" type="text" id="id_DP3" name="DP3" value="' . $descripcion_troceada[12] . '"></td>';
                $titulillos .= '<td><input size="8" type="text" id="id_SIE" name="DSIE" value="' . $descripcion_troceada[13] . '"></td>';
                $titulillos .= '</tr>';

                $mform->addElement('html', $titulillos);
                $mform->addElement('html', '</table>');
                $mform->addElement('html', '<p>');
                break;
            //4.7 Gebrauch der Artikelwörter
            case 42:
                $titulo='';
                $tope = 20;

                for($tabla = 0; $tabla<3; ++$tabla) {
                    $mform->addElement('html', '<p>');
                    $mform->addElement('html','<table class="flexible generaltable generalbox boxaligncenter">');

                    //Según la tabla pongo un indice u otro
                    switch($tabla) {
                        case 0:
                            $titulo = get_string('beispiele_def','vocabulario');
                            break;
                        case 1:
                            $titulo = get_string('beispiele_indef','vocabulario');
                            break;
                        case 2:
                            $titulo = get_string('beispiele_null','vocabulario');
                            break;
                    }


                    //titulillos de la tabla
                    $titulillos = '<tr class="head">';
                    $titulillos .='<th>'.$titulo.'</th>';
                    $titulillos .='<th>'.get_string('gebrauch','vocabulario').'</th>';
                    $titulillos .= '</tr>';
                    $mform->addElement('html',$titulillos);

                    //A partir de aqui pinto filas según se van necesitando

                    $ultima = -1;

                    for ($fila=0; $fila<$tope;$fila++) {
                        $ocultador = '<tr class="cell" id="ocultador_filaT'.$tabla.'_'.$fila;
                        $salidor = false;
                        for ($j=0; $j<2 && $salidor==false;$j++) {
                            if($descripcion_troceada[($tabla*$tope*2)+((2*$fila)+$j)]) {
                                $salidor = true;
                                $ocultador .= '">';
                                $ultima = $fila;
                            }
                        }

                        if ($salidor == false && $fila==0) {
                            $ocultador .= '">';
                        }

                        if ($salidor == false && $fila!=0) {
                            $ocultador .= '" style="display:none">';
                        }

                        $mform->addElement('html', $ocultador);
                        $titulillos = '<td><input type="text" id="id_BE'.$tabla.'_'.$fila.'" name="BE'.$tabla.'_'.$fila.'" value="' . $descripcion_troceada[($tabla*$tope*2)+((2*$fila)+0)] . '"></td>';
                        $titulillos .= '<td><input type="text" id="id_GE'.$tabla.'_'.$fila.'" name="GE'.$tabla.'_'.$fila.'" value="' . $descripcion_troceada[($tabla*$tope*2)+((2*$fila)+1)] . '"></td>';
                        $titulillos .= '</tr>';
                        $mform->addElement('html', $titulillos);

                    }
                    $mform->addElement('html', '</table>');
                    $mform->addElement('html', '<p>');

                    if ($ultima+1 < $tope && $tope > 1) {
                        $ops = '<a href=\'javascript:desocultar("filaT'.$tabla.'_'.($ultima+1).'")\' id="mf">'.get_string("masfilas", "vocabulario").'</a>';
                        $mform->addElement('static', 'mas_filas', '', $ops);
                    }
                }

                break;
            //5.2.2
            case 47:
                $mform->addElement('html', '<p>');
                $mform->addElement('html','<table class="flexible generaltable generalbox boxaligncenter">');

                //titulillos de la tabla
                $titulillos = '<tr class="head">';
                $titulillos .='<th>'.get_string('positivo','vocabulario').'</th>';
                $titulillos .='<th>'.get_string('comparativo','vocabulario').'</th>';
                $titulillos .='<th>'.get_string('superlativo','vocabulario').'</th>';
                $titulillos .= '</tr>';
                $mform->addElement('html',$titulillos);

                //A partir de aqui pinto filas según se van necesitando
                $tope = 10;
                $ultima = -1;

                for ($fila=0; $fila<$tope;$fila++) {
                    $ocultador = '<tr class="cell" id="ocultador_filaT'.$fila;
                    $salidor = false;
                    for ($j=0; $j<3 && $salidor==false;$j++) {
                        if($descripcion_troceada[((3*$fila)+$j)]) {
                            $salidor = true;
                            $ocultador .= '">';
                            $ultima = $fila;
                        }
                    }

                    if ($salidor == false && $fila==0) {
                        $ocultador .= '">';
                    }

                    if ($salidor == false && $fila!=0) {
                        $ocultador .= '" style="display:none">';
                    }

                    $mform->addElement('html', $ocultador);
                    $titulillos = '<td><input type="text" id="id_PO'.$fila.'" name="PO'.$fila.'" value="' . $descripcion_troceada[((3*$fila)+0)] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_KO'.$fila.'" name="KO'.$fila.'" value="' . $descripcion_troceada[((3*$fila)+1)] . '"></td>';
                    $titulillos .= '<td><input type="text" id="id_SU'.$fila.'" name="SU'.$fila.'" value="' . $descripcion_troceada[((3*$fila)+2)] . '"></td>';
                    $titulillos .= '</tr>';
                    $mform->addElement('html', $titulillos);

                }
                $mform->addElement('html', '</table>');
                $mform->addElement('html', '<p>');

                if ($ultima+1 < $tope && $tope > 1) {
                    $ops = '<a href=\'javascript:desocultar("filaT'.($ultima+1).'")\' id="mf">'.get_string("masfilas", "vocabulario").'</a>';
                    $mform->addElement('static', 'mas_filas', '', $ops);
                }
                break;

        }

        if ($grid) {
            //exclamacion de todos las categorias
            $mform->addElement('textarea', 'descripcion', '<img src="./imagenes/alerta.png" id="id_alerta_im" name="alerta_im"/>', 'rows="5" cols="30"');
            $mform->setDefault('descripcion', $descripcion_troceada[count($descripcion_troceada)-2]);

            //solucion de enlazar todo con todo
            $mform->addElement('textarea', 'miraren', get_string('miraren','vocabulario'), 'rows="5" cols="30"');
            $mform->setDefault('miraren', $descripcion_troceada[count($descripcion_troceada)-1]);
        }

        //botones
        $buttonarray = array();
        $buttonarray[] = &$mform->createElement('submit', 'desc_btn', get_string('guardesc','vocabulario'));
        $mform->registerNoSubmitButton('desc_btn');
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('verdesc','vocabulario'));
        $buttonarray[] = &$mform->createElement('cancel', 'cancelbutton', get_string('cancel','vocabulario'));

        $mform->addGroup($buttonarray, 'botones', '', array(' '), false);
    }

}

/*
class mod_vocabulario_gramatica_desc_form extends moodleform {

    function definition() {
        global $USER;
        $mform = & $this->_form;
        //inclusion del javascript para las funciones
        $mform->addElement('html', '<script type="text/javascript" src="funciones.js"></script>');
        $grid = optional_param('grid', 0, PARAM_INT);
        $gr = new Vocabulario_mis_gramaticas();
        $gr->leer($grid);
        $mgr = new Vocabulario_gramatica();
        $mgr->leer($gr->get('gramaticaid'), $USER->id);
        $descripcion_troceada = explode('&', $gr->get('descripcion'));
        $palabra = 0;
        switch ($gr->get('tipo_palabra')) {
            case 'sustantivo':
                $palabra = new Vocabulario_sustantivo();
                $palabra->leer($gr->get('palabraid'));
                break;
            case 'adjetivo':
                $palabra = new Vocabulario_adjetivo();
                $palabra->leer($gr->get('palabraid'));
                break;
            case 'verbo':
                $palabra = new Vocabulario_verbo();
                $palabra->leer($gr->get('palabraid'));
                break;
            case 'otro':
                $palabra = new Vocabulario_otro();
                $palabra->leer($gr->get('palabraid'));
                break;
        }

        $mform->addElement('html', '<p>' . get_string("pal", "vocabulario") . ': ' . $palabra->get('palabra') . '</p>');
        $mform->addElement('html', '<p>' . get_string("campo_gram", "vocabulario") . ': ' . $mgr->get('palabra') . '</p>');
        switch ($mgr->get('id')) {
            //normal
            default:
                $mform->addElement('textarea', 'descripcion', get_string("beachten", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('descripcion', $descripcion_troceada[0]);
                break;
            //allgemaines
            case 2:
            case 7:
            case 21:
            case 34:
            case 44:
            case 52:
            case 56:
            case 59:
            case 72:
                $mform->addElement('textarea', 'generales', get_string('generales', 'vocabulario'), 'rows="5" cols="30"');
                $mform->setDefault('generales', $descripcion_troceada[0]);
                $mform->addElement('textarea', 'particulares', get_string('particulares', 'vocabulario'), 'rows="5" cols="30"');
                $mform->setDefault('particulares', $descripcion_troceada[1]);
                break;
            //5.3.1
            case 47:
                $mform->addElement('html', '<p>' . get_string("declinacion1", "vocabulario") . '</p>');
                //tabla
                $mform->addElement('html', '<p>');
                $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter boxwidthwide">');
                //titulillos de la tabla
                $titulillos = '<tr class="header">';
                $titulillos .= '<th></th>';
                $titulillos .= '<th>' . get_string('masculino', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('neutro', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('femenino', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('plural', 'vocabulario') . '</th>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $titulillos = '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('nominativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_NM1" name="NM1" value="' . $descripcion_troceada[0] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_NN1" name="NN1" value="' . $descripcion_troceada[1] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_NF1" name="NF1" value="' . $descripcion_troceada[2] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_NP1" name="NP1" value="' . $descripcion_troceada[3] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('acusativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_AM1" name="AM1" value="' . $descripcion_troceada[4] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_AN1" name="AN1" value="' . $descripcion_troceada[5] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_AF1" name="AF1" value="' . $descripcion_troceada[6] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_AP1" name="AP1" value="' . $descripcion_troceada[7] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('dativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_DM1" name="DM1" value="' . $descripcion_troceada[8] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_DN1" name="DN1" value="' . $descripcion_troceada[9] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_DF1" name="DF1" value="' . $descripcion_troceada[10] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_DP1" name="DP1" value="' . $descripcion_troceada[11] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('genitivo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_GM1" name="GM1" value="' . $descripcion_troceada[12] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_GN1" name="GN1" value="' . $descripcion_troceada[13] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_GF1" name="GF1" value="' . $descripcion_troceada[14] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_GP1" name="GP1" value="' . $descripcion_troceada[15] . '"></td>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $mform->addElement('html', '</table>');
                $mform->addElement('html', '<p>');

                $mform->addElement('html', '<p>' . get_string("declinacion2", "vocabulario") . '</p>');
                //tabla
                $mform->addElement('html', '<p>');
                $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter boxwidthwide">');
                //titulillos de la tabla
                $titulillos = '<tr class="header">';
                $titulillos .= '<th></th>';
                $titulillos .= '<th>' . get_string('masculino', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('neutro', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('femenino', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('plural', 'vocabulario') . '</th>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $titulillos = '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('nominativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_NM2" name="NM2" value="' . $descripcion_troceada[16] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_NN2" name="NN2" value="' . $descripcion_troceada[17] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_NF2" name="NF2" value="' . $descripcion_troceada[18] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_NP2" name="NP2" value="' . $descripcion_troceada[19] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('acusativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_AM2" name="AM2" value="' . $descripcion_troceada[20] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_AN2" name="AN2" value="' . $descripcion_troceada[21] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_AF2" name="AF2" value="' . $descripcion_troceada[22] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_AP2" name="AP2" value="' . $descripcion_troceada[23] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('dativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_DM2" name="DM2" value="' . $descripcion_troceada[24] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_DN2" name="DN2" value="' . $descripcion_troceada[25] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_DF2" name="DF2" value="' . $descripcion_troceada[26] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_DP2" name="DP2" value="' . $descripcion_troceada[27] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('genitivo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_GM2" name="GM2" value="' . $descripcion_troceada[28] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_GN2" name="GN2" value="' . $descripcion_troceada[29] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_GF2" name="GF2" value="' . $descripcion_troceada[30] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_GP2" name="GP2" value="' . $descripcion_troceada[31] . '"></td>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $mform->addElement('html', '</table>');
                $mform->addElement('html', '<p>');

                $mform->addElement('html', '<p>' . get_string("declinacion3", "vocabulario") . '</p>'); //tabla
                $mform->addElement('html', '<p>');
                $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter boxwidthwide">');
                //titulillos de la tabla
                $titulillos = '<tr class="header">';
                $titulillos .= '<th></th>';
                $titulillos .= '<th>' . get_string('masculino', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('neutro', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('femenino', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('plural', 'vocabulario') . '</th>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $titulillos = '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('nominativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_NM3" name="NM3" value="' . $descripcion_troceada[32] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_NN3" name="NN3" value="' . $descripcion_troceada[33] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_NF3" name="NF3" value="' . $descripcion_troceada[34] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_NP3" name="NP3" value="' . $descripcion_troceada[35] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('acusativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_AM3" name="AM3" value="' . $descripcion_troceada[36] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_AN3" name="AN3" value="' . $descripcion_troceada[37] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_AF3" name="AF3" value="' . $descripcion_troceada[38] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_AP3" name="AP3" value="' . $descripcion_troceada[39] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('dativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_DM3" name="DM3" value="' . $descripcion_troceada[40] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_DN3" name="DN3" value="' . $descripcion_troceada[41] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_DF3" name="DF3" value="' . $descripcion_troceada[42] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_DP3" name="DP3" value="' . $descripcion_troceada[43] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('genitivo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_GM3" name="GM3" value="' . $descripcion_troceada[44] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_GN3" name="GN3" value="' . $descripcion_troceada[45] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_GF3" name="GF3" value="' . $descripcion_troceada[46] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_GP3" name="GP3" value="' . $descripcion_troceada[47] . '"></td>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $mform->addElement('html', '</table>');
                $mform->addElement('html', '<p>');
                break;
            //tablas verbos
            case 23:
            case 24:
            case 27:
            case 28:
            case 29:
            case 30:
            case 31:
                //tabla
                $mform->addElement('html', '<p>');
                $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter boxwidthwide">');
                //titulillos de la tabla
                $titulillos = '<tr class="header">';
                $titulillos .= '<th></th>';
                $titulillos .= '<th>' . get_string('indicativo', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('conjuntivo1', 'vocabulario') . '</th>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $titulillos = '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('S1', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_S1I" name="S1I" value="' . $descripcion_troceada[0] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_S1C" name="S1C" value="' . $descripcion_troceada[1] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('S2', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_S2I" name="S2I" value="' . $descripcion_troceada[2] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_S2C" name="S2C" value="' . $descripcion_troceada[3] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('S3', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_S3I" name="S3I" value="' . $descripcion_troceada[4] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_S3C" name="S3C" value="' . $descripcion_troceada[5] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('P1', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_P1I" name="P1I" value="' . $descripcion_troceada[6] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_P1C" name="P1C" value="' . $descripcion_troceada[7] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('P2', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_P2I" name="P2I" value="' . $descripcion_troceada[8] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_P2C" name="P2C" value="' . $descripcion_troceada[9] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('P3', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_P3I" name="P3I" value="' . $descripcion_troceada[10] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_P3C" name="P3C" value="' . $descripcion_troceada[11] . '"></td>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $mform->addElement('html', '</table>');
                $mform->addElement('html', '<p>');
                $mform->addElement('textarea', 'descripcion', get_string("beachten", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('descripcion', $descripcion_troceada[12]);
                break;
            //participio2
            case 25:
                $mform->addElement('textarea', 'participio2', get_string("participio2", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('participio2', $descripcion_troceada[0]);
                $mform->addElement('textarea', 'hilfsverbs', get_string("hilfsverbs", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('hilfsverbs', $descripcion_troceada[1]);
                break;
            //participio1
            case 26:
                $mform->addElement('textarea', 'participio1', get_string("participio1", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('participio1', $descripcion_troceada);
                break;
            //passiv
            case 32:
                $mform->addElement('textarea', 'zustandspassiv', get_string("zustandspassiv", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('zustandspassiv', $descripcion_troceada[0]);
                $mform->addElement('textarea', 'vorganspassiv', get_string("vorganspassiv", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('vorganspassiv', $descripcion_troceada[1]);
                break;
            //articulos
            case 35:
            case 36:
            case 37:
            case 38:
            case 39:
            case 40:
            //pronombres
            case 8:
            case 9:
            case 10:
            case 16:
                //tabla
                $mform->addElement('html', '<p>');
                $mform->addElement('html', '<table class="flexible generaltable generalbox boxaligncenter boxwidthwide">');
                //titulillos de la tabla
                $titulillos = '<tr class="header">';
                $titulillos .= '<th></th>';
                $titulillos .= '<th>' . get_string('masculino', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('neutro', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('femenino', 'vocabulario') . '</th>';
                $titulillos .= '<th>' . get_string('plural', 'vocabulario') . '</th>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $titulillos = '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('nominativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_NM1" name="NM1" value="' . $descripcion_troceada[0] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_NN1" name="NN1" value="' . $descripcion_troceada[1] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_NF1" name="NF1" value="' . $descripcion_troceada[2] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_NP1" name="NP1" value="' . $descripcion_troceada[3] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('acusativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_AM1" name="AM1" value="' . $descripcion_troceada[4] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_AN1" name="AN1" value="' . $descripcion_troceada[5] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_AF1" name="AF1" value="' . $descripcion_troceada[6] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_AP1" name="AP1" value="' . $descripcion_troceada[7] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('dativo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_DM1" name="DM1" value="' . $descripcion_troceada[8] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_DN1" name="DN1" value="' . $descripcion_troceada[9] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_DF1" name="DF1" value="' . $descripcion_troceada[10] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_DP1" name="DP1" value="' . $descripcion_troceada[11] . '"></td>';
                $titulillos .= '</tr>';
                $titulillos .= '<tr class="cell">';
                $titulillos .= '<td class="cell">' . get_string('genitivo', 'vocabulario') . '</td>';
                $titulillos .= '<td><input type="text" id="id_GM1" name="GM1" value="' . $descripcion_troceada[12] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_GN1" name="GN1" value="' . $descripcion_troceada[13] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_GF1" name="GF1" value="' . $descripcion_troceada[14] . '"></td>';
                $titulillos .= '<td><input type="text" id="id_GP1" name="GP1" value="' . $descripcion_troceada[15] . '"></td>';
                $titulillos .= '</tr>';
                $mform->addElement('html', $titulillos);
                $mform->addElement('html', '</table>');
                $mform->addElement('html', '<p>');
                $mform->addElement('textarea', 'descripcion', get_string("beachten", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('descripcion', $descripcion_troceada[16]);
                break;
            //4.8
            case 41:
                $mform->addElement('textarea', 'lista', get_string("lista", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('lista', $descripcion_troceada[0]);
                $mform->addElement('textarea', 'scheinbare', get_string("scheinbare", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('scheinbare', $descripcion_troceada[1]);
                break;
        }
        //botones
        $buttonarray = array();
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('savechanges'));
        $buttonarray[] = &$mform->createElement('reset', 'resetbutton', get_string('revert', 'vocabulario'));
        $buttonarray[] = &$mform->createElement('cancel', 'cancelbutton', get_string('cancel','vocabulario'));
        $mform->addGroup($buttonarray, 'botones', '', array(' '), false);

        $mform->addElement('hidden', 'grid', $grid);
        $mform->addElement('hidden', 'id_mp', optional_param('id_mp',null,PARAM_INT));
    }

}
*/
class mod_vocabulario_nuevo_ic_form extends moodleform {

    function definition() {
        global $USER;
        $mform = & $this->_form;
        //inclusion del javascript para las funciones
        $mform->addElement('html', '<script type="text/javascript" src="funciones.js"></script>');

        $icid = optional_param('icid', 0, PARAM_INT);
        $id_tocho = optional_param('id', 0, PARAM_INT);

        //titulo de la seccion
        $mform->addElement('html','<h1>'.get_string('admin_ic','vocabulario').'</h1>');

        $aux = new Vocabulario_intenciones();
        $intenciones = $aux->obtener_todos($USER->id);
        $mform->addElement('select', 'campoic', get_string("nivel", "vocabulario"), $intenciones);
        if ($icid) {
            $mform->setDefault('campoic', $icid);
        }
        //$mform->addElement('text', 'intencion', get_string("campo_intencion_nuevo", "vocabulario"));

        //opcion de eliminar un campo
        //$mform->addElement('checkbox', 'eliminar', get_string("eliminar", "vocabulario"));
        //$mform->setDefault('eliminar', 0);

        $intencion = new Vocabulario_mis_intenciones();
        $intencion->leer($icid, $USER->id);
        $mform->addElement('textarea', 'descripcion', get_string("desc", "vocabulario"), 'rows="5" cols="30"');
        $mform->setDefault('descripcion', $intencion->get('descripcion'));

        //botones
        $buttonarray = array();
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('guardesc','vocabulario'));
        $buttonarray[] = &$mform->createElement('submit', 'desc_btn', get_string('verdesc','vocabulario'));
        $mform->registerNoSubmitButton('desc_btn');
        $buttonarray[] = &$mform->createElement('cancel', 'cancelbutton', get_string('cancel','vocabulario'));
        $mform->addGroup($buttonarray, 'botones', '', array(' '), false);
    }

}

class mod_vocabulario_intencion_desc_form extends moodleform {

    function definition() {
        global $USER;
        $mform = & $this->_form;

        $icid = optional_param('icid', 0, PARAM_INT);
        $id_tocho = optional_param('id', 0, PARAM_INT);

        //titulo de la seccion
        $mform->addElement('html','<h1>'.get_string('nueva_ic','vocabulario').'</h1>');

        $aux = new Vocabulario_intenciones();
        $intenciones = $aux->obtener_todos($USER->id);
        $mform->addElement('select', 'campoic', get_string("nivel", "vocabulario"), $intenciones);
        if ($icid) {
            $mform->setDefault('campoic', $icid);
        }

        $mform->addElement('text', 'intencion', get_string("campo_intencion_nuevo", "vocabulario"));

        //opcion de eliminar un campo
        $mform->addElement('checkbox', 'eliminar', get_string("eliminar", "vocabulario"));
        $mform->setDefault('eliminar', 0);

        $buttonarray = array();
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('guardesc','vocabulario'));
        $buttonarray[] = &$mform->createElement('cancel', 'cancelbutton', get_string('cancel','vocabulario'));
        $mform->addGroup($buttonarray, 'botones', '', array(' '), false);

    }

    /* function definition() {
        global $USER;
        $mform = & $this->_form;
        //inclusion del javascript para las funciones
        $mform->addElement('html', '<script type="text/javascript" src="funciones.js"></script>');
        $icid = optional_param('icid', 0, PARAM_INT);
        $ic = new Vocabulario_mis_intenciones();
        $ic->leer($icid);
        $mic = new Vocabulario_intenciones();
        $mic->leer($ic->get('intencionesid'), $USER->id);
        $descripcion_troceada = explode('&', $ic->get('descripcion'));
        $palabra = 0;
        switch ($ic->get('tipo_palabra')) {
            case 'sustantivo':
                $palabra = new Vocabulario_sustantivo();
                $palabra->leer($ic->get('palabraid'));
                break;
            case 'adjetivo':
                $palabra = new Vocabulario_adjetivo();
                $palabra->leer($ic->get('palabraid'));
                break;
            case 'verbo':
                $palabra = new Vocabulario_verbo();
                $palabra->leer($ic->get('palabraid'));
                break;
            case 'otro':
                $palabra = new Vocabulario_otro();
                $palabra->leer($ic->get('palabraid'));
                break;
        }

        $mform->addElement('html', '<p>' . get_string("pal", "vocabulario") . ': ' . $palabra->get('palabra') . '</p>');
        $mform->addElement('html', '<p>' . get_string("campo_intencion", "vocabulario") . ': ' . $mic->get('palabra') . '</p>');
        switch ($mic->get('id')) {
            //normal
            default:
                $mform->addElement('textarea', 'descripcion', get_string("beachten", "vocabulario"), 'rows="5" cols="30"');
                $mform->setDefault('descripcion', $descripcion_troceada[0]);
                break;
        }
        //botones
        $buttonarray = array();
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('savechanges'));
        $buttonarray[] = &$mform->createElement('reset', 'resetbutton', get_string('revert', 'vocabulario'));
        $buttonarray[] = &$mform->createElement('cancel', 'cancelbutton', get_string('cancel','vocabulario'));
        $mform->addGroup($buttonarray, 'botones', '', array(' '), false);

        $mform->addElement('hidden', 'icid', $icid);
        $mform->addElement('hidden', 'id_mp', optional_param('id_mp',null,PARAM_INT));
    }*/

}

class mod_vocabulario_nuevo_tipologia_form extends moodleform {

    function definition() {
        global $USER;
        $mform = & $this->_form;
        //inclusion del javascript para las funciones
        $mform->addElement('html', '<script type="text/javascript" src="funciones.js"></script>');

        $ttid = optional_param('ttid', 1, PARAM_INT);
        $id_tocho = optional_param('id', 0, PARAM_INT);

        //titulo de la seccion
        $mform->addElement('html','<h1>'.get_string('admin_tt','vocabulario').'</h1>');

        $aux = new Vocabulario_tipologias();
        $tipologias = $aux->obtener_todos($USER->id);
        $mform->addElement('select', 'campott', get_string("campo_tipologia", "vocabulario"), $tipologias);
        if ($ttid) {
            $mform->setDefault('campott', $ttid);
        }

        $tt = new Vocabulario_mis_tipologias();
        $tt->leer($ttid);
        $descripcion_troceada = explode('&', $tt->get('descripcion'));

        for ($i = 1; $i < 6; $i++) {
            if($i-1) {
                $mform->addElement('html','</br><a href="javascript:desocultar(\'tabla'.$i.'\')" id="mctabla'.$i.'">'.get_string("ejem","vocabulario").' '.$i.'</a>');
                $mform->addElement('html','<div id="ocultador_tabla'.$i.'" style="display:none">');
            }
            else {
                $mform->addElement('html','</br><a href="javascript:ocultar(\'tabla'.$i.'\')" id="mctabla'.$i.'">'.get_string("ejem","vocabulario").' '.$i.'</a>');
                $mform->addElement('html','<div id="ocultador_tabla'.$i.'">');
            }
            $mform->addElement('text', 'quien'.$i, get_string('quien', 'vocabulario'));
            $mform->setDefault('quien'.$i, $descripcion_troceada[15*($i-1)+0]);
            $mform->addElement('text', 'finalidad'.$i, get_string('finalidad', 'vocabulario'));
            $mform->setDefault('finalidad'.$i, $descripcion_troceada[15*($i-1)+1]);
            $mform->addElement('text', 'a_quien'.$i, get_string('a_quien', 'vocabulario'));
            $mform->setDefault('a_quien'.$i, $descripcion_troceada[15*($i-1)+2]);
            $mform->addElement('text', 'medio'.$i, get_string('medio', 'vocabulario'));
            $mform->setDefault('medio'.$i, $descripcion_troceada[15*($i-1)+3]);
            $mform->addElement('text', 'donde'.$i, get_string('donde', 'vocabulario'));
            $mform->setDefault('donde'.$i, $descripcion_troceada[15*($i-1)+4]);
            $mform->addElement('text', 'cuando'.$i, get_string('cuando', 'vocabulario'));
            $mform->setDefault('cuando'.$i, $descripcion_troceada[15*($i-1)+5]);
            $mform->addElement('text', 'motivo'.$i, get_string('motivo', 'vocabulario'));
            $mform->setDefault('motivo'.$i, $descripcion_troceada[15*($i-1)+6]);
            $mform->addElement('text', 'funcion'.$i, get_string('funcion', 'vocabulario'));
            $mform->setDefault('funcion'.$i, $descripcion_troceada[15*($i-1)+7]);
            $mform->addElement('text', 'sobre_que'.$i, get_string('sobre_que', 'vocabulario'));
            $mform->setDefault('sobre_que'.$i, $descripcion_troceada[15*($i-1)+8]);
            $mform->addElement('text', 'que'.$i, get_string('que', 'vocabulario'));
            $mform->setDefault('que'.$i, $descripcion_troceada[15*($i-1)+9]);
            $mform->addElement('text', 'orden'.$i, get_string('orden', 'vocabulario'));
            $mform->setDefault('orden'.$i, $descripcion_troceada[15*($i-1)+10]);
            $mform->addElement('text', 'medios_nonverbales'.$i, get_string('medios_nonverbales', 'vocabulario'));
            $mform->setDefault('medios_nonverbales'.$i, $descripcion_troceada[15*($i-1)+11]);
            $mform->addElement('text', 'que_palabras'.$i, get_string('que_palabras', 'vocabulario'));
            $mform->setDefault('que_palabras'.$i, $descripcion_troceada[15*($i-1)+12]);
            $mform->addElement('text', 'que_frases'.$i, get_string('que_frases', 'vocabulario'));
            $mform->setDefault('que_frases'.$i, $descripcion_troceada[15*($i-1)+13]);
            $mform->addElement('text', 'que_tono'.$i, get_string('que_tono', 'vocabulario'));
            $mform->setDefault('que_tono'.$i, $descripcion_troceada[15*($i-1)+14]);
            $mform->addElement('html','</div>');
        }

        //solucion de enlazar todo con todo
        $mform->addElement('textarea', 'miraren', get_string('miraren','vocabulario'), 'rows="5" cols="30"');
        $mform->setDefault('miraren', $descripcion_troceada[count($descripcion_troceada)-1]);

        //botones
        $buttonarray = array();
        $buttonarray[] = &$mform->createElement('submit', 'desc_btn', get_string('guardesc','vocabulario'));
        $mform->registerNoSubmitButton('desc_btn');
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('verdesc','vocabulario'));
        $buttonarray[] = &$mform->createElement('cancel', 'cancelbutton', get_string('cancel','vocabulario'));
        $mform->addGroup($buttonarray, 'botones', '', array(' '), false);
    }

}

class mod_vocabulario_tipologia_desc_form extends moodleform {

    function definition() {
        global $USER;
        $mform = & $this->_form;
        //inclusion del javascript para las funciones
        $mform->addElement('html', '<script type="text/javascript" src="funciones.js"></script>');
        $ttid = optional_param('ttid', 0, PARAM_INT);
        $tipologias = new Vocabulario_mis_tipologias();
        $tipologias->leer($ttid);
        $mtipologias = new Vocabulario_tipologias();
        $mtipologias->leer($tipologias->get('tipoid'), $USER->id);
        $descripcion_troceada = explode('&', $tipologias->get('descripcion'));
        $palabra = 0;
        switch ($tipologias->get('tipo_palabra')) {
            case 'sustantivo':
                $palabra = new Vocabulario_sustantivo();
                $palabra->leer($tipologias->get('palabraid'));
                break;
            case 'adjetivo':
                $palabra = new Vocabulario_adjetivo();
                $palabra->leer($tipologias->get('palabraid'));
                break;
            case 'verbo':
                $palabra = new Vocabulario_verbo();
                $palabra->leer($tipologias->get('palabraid'));
                break;
            case 'otro':
                $palabra = new Vocabulario_otro();
                $palabra->leer($tipologias->get('palabraid'));
                break;
        }

        $mform->addElement('html', '<p>' . get_string("pal", "vocabulario") . ': ' . $palabra->get('palabra') . '</p>');
        $mform->addElement('html', '<p>' . get_string("campo_tipologia", "vocabulario") . ': ' . $mtipologias->get('palabra') . '</p>');

        $mform->addElement('text', 'quien', get_string('quien', 'vocabulario'));
        $mform->setDefault('quien', $descripcion_troceada[0]);
        $mform->addElement('text', 'finalidad', get_string('finalidad', 'vocabulario'));
        $mform->setDefault('finalidad', $descripcion_troceada[1]);
        $mform->addElement('text', 'a_quien', get_string('a_quien', 'vocabulario'));
        $mform->setDefault('a_quien', $descripcion_troceada[2]);
        $mform->addElement('text', 'medio', get_string('medio', 'vocabulario'));
        $mform->setDefault('medio', $descripcion_troceada[3]);
        $mform->addElement('text', 'donde', get_string('donde', 'vocabulario'));
        $mform->setDefault('donde', $descripcion_troceada[4]);
        $mform->addElement('text', 'cuando', get_string('cuando', 'vocabulario'));
        $mform->setDefault('cuando', $descripcion_troceada[5]);
        $mform->addElement('text', 'motivo', get_string('motivo', 'vocabulario'));
        $mform->setDefault('motivo', $descripcion_troceada[6]);
        $mform->addElement('text', 'funcion', get_string('funcion', 'vocabulario'));
        $mform->setDefault('funcion', $descripcion_troceada[7]);
        $mform->addElement('text', 'sobre_que', get_string('sobre_que', 'vocabulario'));
        $mform->setDefault('sobre_que', $descripcion_troceada[8]);
        $mform->addElement('text', 'que', get_string('que', 'vocabulario'));
        $mform->setDefault('que', $descripcion_troceada[9]);
        $mform->addElement('text', 'orden', get_string('orden', 'vocabulario'));
        $mform->setDefault('orden', $descripcion_troceada[10]);
        $mform->addElement('text', 'medios_nonverbales', get_string('medios_nonverbales', 'vocabulario'));
        $mform->setDefault('medios_nonverbales', $descripcion_troceada[11]);
        $mform->addElement('text', 'que_palabras', get_string('que_palabras', 'vocabulario'));
        $mform->setDefault('que_palabras', $descripcion_troceada[12]);
        $mform->addElement('text', 'que_frases', get_string('que_frases', 'vocabulario'));
        $mform->setDefault('que_frases', $descripcion_troceada[13]);
        $mform->addElement('text', 'que_tono', get_string('que_tono', 'vocabulario'));
        $mform->setDefault('que_tono', $descripcion_troceada[14]);



        //botones
        $buttonarray = array();
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('savechanges'));
        $buttonarray[] = &$mform->createElement('reset', 'resetbutton', get_string('revert', 'vocabulario'));
        $buttonarray[] = &$mform->createElement('cancel', 'cancelbutton', get_string('cancel','vocabulario'));
        $mform->addGroup($buttonarray, 'botones', '', array(' '), false);

        $mform->addElement('hidden', 'ttid', $ttid);
        $mform->addElement('hidden', 'id_mp', optional_param('id_mp',null,PARAM_INT));
    }

}

class mod_vocabulario_listado_form extends moodleform {
    function definition() {
        global $USER;
        $mform = & $this->_form;
        $mform->addElement('html','<p>hola</p>');
        //botones
        $buttonarray = array();
        $buttonarray[] = &$mform->createElement('submit', 'cancelbutton', get_string('cancel'));
        //$buttonarray[] = &$mform->createElement('reset', 'resetbutton', get_string('revert', 'vocabulario'));
        //$buttonarray[] = &$mform->createElement('cancel', 'cancelbutton', get_string('cancel','vocabulario'));
        $mform->addGroup($buttonarray, 'botones', '', array(' '), false);
    }
}

?>
