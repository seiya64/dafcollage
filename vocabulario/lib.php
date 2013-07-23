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
  Francisco Javier Rodr�guez L�pez (seiyadesagitario@gmail.com)
  Sime�n Ruiz Romero (simeonruiz@gmail.com)
  Serafina Molina Soto(finamolinasoto@gmail.com)

  Original idea:
  Ruth Burbat

  Content design:
  Ruth Burbat
  AInmaculada Almahano G�eto
  Andrea Bies
  Julia M�ller Runge
  Blanca Rodr�guez G�mez
  Antonio Salmer�n Matilla
  Mar�a Jos� Varela Salinas
  Karin Vilar S�nchez

  This program is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License
  as published by the Free Software Foundation; either version 2
  of the License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details. */
require_once("$CFG->libdir/formslib.php");
require_once("vocabulario_formularios.php");

define('__SEPARADORCAMPOS__', '$FIELD$');

/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod.html) this function
 * will create a new instance and return the id number
 * of the new instance.
 *
 * @param object $instance An object from the form in mod.html
 * @return int The id of the newly inserted vocabulario record
 * */
function vocabulario_add_instance($vocabulario) {

    // temp added for debugging
    echo "ADD INSTANCE CALLED";
    // print_object($vocabulario);

    $vocabulario->timemodified = time();

    # May have to add extra stuff in here #

    return insert_record("vocabulario", $vocabulario);
}

/**
 * Return a suffix depending on current user language
 *
 * @return string The suffix for tables according to the current language
 * */
function get_sufijo_lenguaje_tabla() {

    $lenguaje = current_language();
    //$lenguaje = "de_utf8";
    if ($lenguaje == "es_utf8") {
        $sufijotabla = "es";
    } else if ($lenguaje == "en_utf8") {
        $sufijotabla = "en";
    } else if ($lenguaje == "pl_utf8") {
        $sufijotabla = "pl";
    } else if ($lenguaje == "de_utf8") {
        $sufijotabla = "de";
    }else if ($lenguaje == "fr_utf8") {
        $sufijotabla = "fr";
    }else {
        $sufijotabla = "es";
    }

    return $sufijotabla;
}

/**
 * Return all suffix for tables in database that depends on language
 *
 * @return array All suffix for tables in database
 */
function get_todos_sufijos_lenguaje() {
    $sufijos = array('es', 'en', 'pl', 'de');

    return $sufijos;
}

/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod.html) this function
 * will update an existing instance with new data.
 *
 * @param object $instance An object from the form in mod.html
 * @return boolean Success/Fail
 * */
function vocabulario_update_instance($vocabulario) {

    $vocabulario->timemodified = time();
    $vocabulario->id = $vocabulario->instance;

    # May have to add extra stuff in here #

    return update_record("vocabulario", $vocabulario);
}

/**
 * Given an ID of an instance of this module,
 * this function will permanently delete the instance
 * and any data that depends on it.
 *
 * @param int $id Id of the module instance
 * @return boolean Success/Failure
 * */
function vocabulario_delete_instance($id) {

    if (!$vocabulario = get_record("vocabulario", "id", "$id")) {
        return false;
    }

    $result = true;

    # Delete any dependent records here #

    if (!delete_records("vocabulario", "id", "$vocabulario->id")) {
        $result = false;
    }

    return $result;
}

/**
 * Return a small object with summary information about what a
 * user has done with a given particular instance of this module
 * Used for user activity reports.
 * $return->time = the time they did it
 * $return->info = a short text description
 *
 * @return null
 * @todo Finish documenting this function
 * */
function vocabulario_user_outline($course, $user, $mod, $vocabulario) {
    return $return;
}

/**
 * Print a detailed representation of what a user has done with
 * a given particular instance of this module, for user activity reports.
 *
 * @return boolean
 * @todo Finish documenting this function
 * */
function vocabulario_user_complete($course, $user, $mod, $vocabulario) {
    return true;
}

/**
 * Given a course and a time, this module should find recent activity
 * that has occurred in vocabulario activities and print it out.
 * Return true if there was output, or false is there was none.
 *
 * @uses $CFG
 * @return boolean
 * @todo Finish documenting this function
 * */
function vocabulario_print_recent_activity($course, $isteacher, $timestart) {
    global $CFG;

    return false;  //  True if anything was printed, otherwise false
}

/**
 * Function to be run periodically according to the moodle cron
 * This function searches for things that need to be done, such
 * as sending out mail, toggling flags etc ...
 *
 * @uses $CFG
 * @return boolean
 * @todo Finish documenting this function
 * */
function vocabulario_cron() {
    global $CFG;

    return true;
}

/**
 * Must return an array of grades for a given instance of this module,
 * indexed by user.  It also returns a maximum allowed grade.
 *
 * Example:
 *    $return->grades = array of grades;
 *    $return->maxgrade = maximum allowed grade;
 *
 *    return $return;
 *
 * @param int $vocabularioid ID of an instance of this module
 * @return mixed Null or object with an array of grades and with the maximum grade
 * */
function vocabulario_grades($vocabularioid) {
    return NULL;
}

/**
 * Must return an array of user records (all data) who are participants
 * for a given instance of vocabulario. Must include every user involved
 * in the instance, independient of his role (student, teacher, admin...)
 * See other modules as example.
 *
 * @param int $vocabularioid ID of an instance of this module
 * @return mixed boolean/array of students
 * */
function vocabulario_get_participants($vocabularioid) {
    return false;
}

/**
 * This function returns if a scale is being used by one vocabulario
 * it it has support for grading and scales. Commented code should be
 * modified if necessary. See forum, glossary or journal modules
 * as reference.
 *
 * @param int $vocabularioid ID of an instance of this module
 * @return mixed
 * @todo Finish documenting this function
 * */
function vocabulario_scale_used($vocabularioid, $scaleid) {
    $return = false;

    //$rec = get_record("vocabulario","id","$vocabularioid","scale","-$scaleid");
    //
    //if (!empty($rec)  && !empty($scaleid)) {
    //    $return = true;
    //}

    return $return;
}

function vocabulario_view($id, $opcion = 0, $id_mp = null,$palabra="",$viene=0) {
    global $CFG, $COURSE, $USER;

    $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);

    switch ($opcion) {
        default:
        case 0: //ver las opciones
            $mform = new mod_vocabulario_opciones_form();
            $mform->aniadircosas($id);
            break;
        case 1: //rellenar el formulario
            $mform = new mod_vocabulario_rellenar_form('guardar.php?id_tocho=' . $id.'?'.$palabra);
            break;
        case 2: //ver las palabras
            $mform = new mod_vocabulario_ver_form('ver.php?id_tocho=' . $id);
            break;
        case 3: //guardar campo lexico
            $mform = new mod_vocabulario_nuevo_cl_form('guardar_cl.php?id_tocho=' . $id);
            break;
        case 4: //actualizar el formulario
            $mform = new mod_vocabulario_rellenar_form('guardar.php?id_tocho=' . $id . '&act=1&viene='.$viene);
            break;
        case 5: //guardar gramatica
            $mform = new mod_vocabulario_nuevo_gr_form('guardar_gr.php?id_tocho=' . $id);
            break;
        case 6: //guardar gramatica particular
            $mform = new mod_vocabulario_gramatica_desc_form('guardar_gr_desc.php?id_tocho=' . $id, '&id_mp=' . $id_mp);
            break;
        case 7: //guardar intencion comunicativa
            $mform = new mod_vocabulario_nuevo_ic_form('guardar_ic.php?id_tocho=' . $id);
            break;
        case 8: //guardar intencion comunicativa particular
            $mform = new mod_vocabulario_intencion_desc_form('guardar_ic_desc.php?id_tocho=' . $id, '&id_mp=' . $id_mp);
            break;
        case 9: //guardar tipologia textual
            $mform = new mod_vocabulario_nuevo_tipologia_form('guardar_tt.php?id_tocho=' . $id);
            break;
        case 10: //guardar tipologia textual particular
            $mform = new mod_vocabulario_tipologia_desc_form('guardar_tt_desc.php?id_tocho=' . $id, '&id_mp=' . $id_mp);
            break;
        case 11: //ver estrategias de aprendizaje
            $mform = new mod_vocabulario_nuevo_estrategia_form('guardar_ea.php?id_tocho=' . $id);
            break;
        case 12: //guardar estrategia nueva
            $mform = new mod_vocabulario_estrategia_desc_form('guardar_ea_desc.php?id_tocho=' . $id, '&id_mp=' . $id_mp);
            break;
        case 13:
            $mform = new mod_vocabulario_listado_form('listado.php?id_tocho=' . $id);
            break;
        case 14: //imprimir apuntes en pdf
            $mform = new mod_vocabulario_pdf_form('pdf.php?id_tocho=' . $id);
            break;
        case 15: //a�adir gramatica
            $mform = new mod_vocabulario_aniadir_gr_form('guardar_gr_desc.php?id_tocho=' . $id);
            break;
        case 16: // colaboradores
            $mform = new mod_vocabulario_colaboradores_form('listado.php?id_tocho=' . $id);
            break;
        case 17: //Buscar por intenciones comunicativas
            $mform = new mod_vocabulario_buscar_intenciones_form('buscarintenciones.php?id_tocho='.$id);
            break;
    }

    $mform->display();
}

//////////////////////////////////////////////////////////////////////////////////////
/// Any other vocabulario functions go here.  Each of them must have a name that 
/// starts with Vocabulario_

function vocabulario_obtener_alumnos($cursoid) {
    global $CFG;
    $sql = 'SELECT u.id usuario, u.firstname nombre, u.lastname apellidos ';
    $sql .= 'FROM ';
    $sql .= '`' . $CFG->prefix . 'groups_members` gm, ';
    $sql .= '`' . $CFG->prefix . 'groups` g, ';
    $sql .= '`' . $CFG->prefix . 'user` u ';
    $sql .= 'WHERE ';
    $sql .= 'g.id = gm.groupid ';
    $sql .= 'AND u.id = gm.userid ';
    $sql .= 'AND g.courseid = ' . $cursoid;

    $mis_alumnos = get_records_sql($sql);

    return $mis_alumnos;
}

function vocabulario_todas_palabras($usuarioid, $cl = null, $gram = null, $inten = null, $tipo = null, $letra = null) {
    global $CFG;
    
    $sql = 'SET @a:=0;';
    
    get_records_sql($sql);
    
    $sql = '';
    if ($letra) {
        $sql .= 'SELECT * FROM (';
    }
   
    $sql .= 'SELECT @a:=@a+1, todas.pal, todas.sig, cl.campo, gr.gramatica, ic.intencion, tt.tipo, todas.mpid, todas.icid,gr.id gramaticaid,ic.id intencionid,tt.id tiptexid ';
    
    $sql .= 'FROM (';
    $sql .= '(SELECT  mp.id mpid,`sustantivoid` sid,`palabra` pal,`campoid` clid,`gramaticaid` grid,`intencionid` icid,`tipologiaid` ttid, `significado` sig ';
    $sql .= 'FROM ';
    if ($cl) {
        $sql .= '(SELECT * FROM `mdl_vocabulario_mis_palabras` WHERE campoid = ' . $cl . ') mp,';
    } else {
        $sql .= '`mdl_vocabulario_mis_palabras` mp,';
    }
    if ($gram || $inten || $tipo) {
        $sql .= '(SELECT  * FROM `mdl_vocabulario_sustantivos` WHERE ';
        if ($gram) {
            $sql .= 'gramaticaid = ' . $gram . ' and ';
        }
        if ($inten) {
            $sql .= 'intencionid = ' . $inten . ' and ';
        }
        if ($tipo) {
            $sql .= 'tipologiaid = ' . $tipo . ' and ';
        }
        $sql .= '1) s ';
    } else {
        $sql .= '`mdl_vocabulario_sustantivos` s ';
    }
    $sql .= 'WHERE `usuarioid` = ' . $usuarioid . ' and mp.`sustantivoid` = s.`id`) ';
    $sql .= 'UNION ALL ';
    $sql .= '(SELECT mp.id mpid, `adjetivoid` aid, `sin_declinar` pal, `campoid` clid, `gramaticaid` grid, `intencionid` icid, `tipologiaid` ttid, `significado` sig ';
    $sql .= 'FROM ';
    if ($cl) {
        $sql .= '(SELECT * FROM `mdl_vocabulario_mis_palabras` WHERE campoid = ' . $cl . ') mp,';
    } else {
        $sql .= '`mdl_vocabulario_mis_palabras` mp,';
    }
    if ($gram || $inten || $tipo) {
        $sql .= '(SELECT * FROM `mdl_vocabulario_adjetivos` WHERE ';
        if ($gram) {
            $sql .= 'gramaticaid = ' . $gram . ' and ';
        }
        if ($inten) {
            $sql .= 'intencionid = ' . $inten . ' and ';
        }
        if ($tipo) {
            $sql .= 'tipologiaid = ' . $tipo . ' and ';
        }
        $sql .= '1) a ';
    } else {
        $sql .= '`mdl_vocabulario_adjetivos` a ';
    }
    $sql .= 'WHERE `usuarioid` = ' . $usuarioid . ' and mp.`adjetivoid` = a.`id` and a.`id` <> 1) ';
    $sql .= 'UNION ALL ';
    $sql .= '(SELECT mp.id mpid, `verboid` vid, `infinitivo` pal, `campoid` clid, `gramaticaid` grid, `intencionid` icid, `tipologiaid` ttid, `significado` sig ';
    $sql .= 'FROM ';
    if ($cl) {
        $sql .= '(SELECT * FROM `mdl_vocabulario_mis_palabras` WHERE campoid = ' . $cl . ') mp,';
    } else {
        $sql .= '`mdl_vocabulario_mis_palabras` mp,';
    }
    if ($gram || $inten || $tipo) {
        $sql .= '(SELECT * FROM `mdl_vocabulario_verbos` WHERE ';
        if ($gram) {
            $sql .= 'gramaticaid = ' . $gram . ' and ';
        }
        if ($inten) {
            $sql .= 'intencionid = ' . $inten . ' and ';
        }
        if ($tipo) {
            $sql .= 'tipologiaid = ' . $tipo . ' and ';
        }
        $sql .= '1) a ';
    } else {
        $sql .= '`mdl_vocabulario_verbos` a ';
    }
    $sql .= 'WHERE `usuarioid` = ' . $usuarioid . ' and mp.`verboid` = a.`id` and a.`id` <> 1) ';
    $sql .= 'UNION ALL ';
    $sql .= '(SELECT mp.id mpid, `otroid` oid, `palabra` pal, `campoid` clid, `gramaticaid` grid, `intencionid` icid, `tipologiaid` ttid, `significado` sig ';
    $sql .= 'FROM ';
    if ($cl) {
        $sql .= '(SELECT * FROM `mdl_vocabulario_mis_palabras` WHERE campoid = ' . $cl . ') mp,';
    } else {
        $sql .= '`mdl_vocabulario_mis_palabras` mp,';
    }
    if ($gram || $inten || $tipo) {
        $sql .= '(SELECT * FROM `mdl_vocabulario_otros` WHERE ';
        if ($gram) {
            $sql .= 'gramaticaid = ' . $gram . ' and ';
        }
        if ($inten) {
            $sql .= 'intencionid = ' . $inten . ' and ';
        }
        if ($tipo) {
            $sql .= 'tipologiaid = ' . $tipo . ' and ';
        }
        $sql .= '1) a ';
    } else {
        $sql .= '`mdl_vocabulario_otros` a ';
    }
    $sufijotabla = get_sufijo_lenguaje_tabla();
    $sql .= 'WHERE `usuarioid` = ' . $usuarioid . ' and mp.`otroid` = a.`id` and a.`id` <> 1) ';
    $sql .= 'ORDER BY pal) todas,';
    $sql .= '`mdl_vocabulario_camposlexicos_' . $sufijotabla . '` cl, `mdl_vocabulario_gramatica` gr, `mdl_vocabulario_intenciones_' . $sufijotabla . '` ic, `mdl_vocabulario_tipologias_' . $sufijotabla . '` tt ';
    //$sql .= ', `mdl_vocabulario_sustantivos` sust, `mdl_vocabulario_adjetivos` adj, `mdl_vocabulario_verbos` verb, `mdl_vocabulario_otros` otros, `mdl_vocabulario_mis_palabras` mp ';
    $sql .= 'WHERE todas.clid = cl.id and todas.grid = gr.id and todas.icid = ic.id and todas.ttid = tt.id';
    //$sql .= ' and todas.mpid=mp.id and sust.id=mp.`sustantivoid` and adj.id=mp.`adjetivoid` and verb.id=mp.`verboid` and otros.id=mp.`otroid` ';

    if ($letra) {
        $sql .= ') p WHERE p.pal like \'' . $letra . '%\'';
    }
   
   
    $todas = get_records_sql($sql);
    $file_log = fopen("log_sql.txt", "w");
    $cad = "SQL: " . $sql . "\n\n\n";
    $cad.= "Error: " . mysql_error() . "\n\n";
    fwrite($file_log, $cad, strlen($cad));
    fclose($file_log);
    return $todas;
}


function todas_palabras_nube($usrid) {
    $sufijotabla = get_sufijo_lenguaje_tabla();
    $sql = "SELECT
        frase.id as mpid,
	sus.palabra as sus_lex,
	adj.sin_declinar as adj_lex,
	ver.infinitivo as ver_lex,
	otros.palabra as otros_lex,
        campos.campo as campo_lex

        FROM
        `mdl_vocabulario_mis_palabras`	as frase ,
	`mdl_vocabulario_sustantivos`	as sus,
	`mdl_vocabulario_adjetivos`	as adj,
	`mdl_vocabulario_verbos`	as ver,
	`mdl_vocabulario_otros`		as otros,
        `mdl_vocabulario_camposlexicos_".$sufijotabla."` as campos

        WHERE
            frase.`usuarioid` = " . $usrid . " AND 
            frase.`sustantivoid` = sus.`id`
            AND
            frase.`adjetivoid` = adj.`id`
            AND
            frase.`verboid` = ver.`id`
            AND
            frase.`otroid` = otros.`id`
            AND
            frase.`campoid` = campos.`id`
	";

    $todas = get_records_sql($sql);
    return $todas;
}

function obtener_superpadre($id){
    $sufijotabla = get_sufijo_lenguaje_tabla();
    $sql = 'SELECT `padre` FROM `mdl_vocabulario_intenciones_'.$sufijotabla.'` ';
    $sql .= 'WHERE `id`='.$id;
    
    $padre = get_records_sql($sql);
    
    foreach($padre as $papi){
        $numerico = $papi->padre;
    }
    if($numerico==0){
        return -1;          //devuelvo -1 si ya es un superpadre
    }else{
       return obtener_superpadre_bis($numerico); //en caso contrario buscamos el superpadre y devolvemos su nombre
    }
    
    
}

function obtener_superpadre_bis($id){
    $sufijotabla = get_sufijo_lenguaje_tabla();
    $sql = 'SELECT `padre`, `intencion` FROM `mdl_vocabulario_intenciones_'.$sufijotabla.'` ';
    $sql .= 'WHERE `id`='.$id;
    
    $padre = get_records_sql($sql);
    
    foreach ($padre as $pad){
        $padreid=$pad->padre;
        $padrenom=$pad->intencion;
    }
    if($padreid>0){
        $padrenom = obtener_superpadre_bis($padreid);
    }
    return $padrenom;
    
}

function vocabulario_rellenar_alumnos($cursoid) {
    //lectura de los campos lexicos disponibles
    $alumnos = vocabulario_obtener_alumnos($cursoid);
    $alum = array();

    foreach ($alumnos as $cosa) {
        $alum[$cosa->usuario] = $cosa->nombre . ' ' . $cosa->apellidos;
    }

    return $alum;
}

?>
