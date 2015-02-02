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

global $DB;

class Vocabulario_sustantivo {

    //atributos
    var $id;
    var $palabra;
    var $genero;
    var $plural;
    var $significado;
    var $observaciones;
    var $gramaticaid;
    var $intencionid;
    var $tipologiaid;
    var $ejemplo;

    //constructor de sustantivo por defecto gramaticaid = 1 porque es un sustantivo
    /**
     * Constructor por defecto de la clase
     * @param type $pal
     * @param type $gen
     * @param type $plu
     * @param type $sig
     * @param type $obs
     * @param type $grid
     * @param type $inid
     * @param type $tipid
     * @param type $ejemplo
     * @param type $id
     */
    function Vocabulario_sustantivo($pal = ' ', $gen = 3, $plu = '', $sig = '', $obs = '', $grid = 1, $inid = 1, $tipid = 1, $ejemplo = '', $id = 1) {
        $this->palabra = $pal;
        $this->genero = $gen;
        $this->plural = $plu;
        $this->significado = $sig;
        $this->observaciones = $obs;
        $this->gramaticaid = $grid;
        $this->intencionid = $inid;
        $this->tipologiaid = $tipid;
        $this->ejemplo = $ejemplo;
        $this->id = $id;
    }

    //set cambia uno o varios de los atributos del sustantivo
    /**
     * Establece el valor de uno o varios atributos del sustantivo
     *
     * @param type $pal
     * @param type $gen
     * @param type $plu
     * @param type $sig
     * @param type $obs
     * @param type $grid
     * @param type $inid
     * @param type $tipid
     * @param type $ejemplo
     * @param type $id
     */
    function set($pal = null, $gen = null, $plu = null, $sig = null, $obs = null, $grid = null, $inid = null, $tipid = null, $ejemplo = null, $id = null) {
        if ($pal != null && $pal != $this->palabra) {
            $this->palabra = $pal;
        }
        if ($gen != null && $gen != $this->genero) {
            $this->genero = $gen;
        }
        if ($plu != null && $plu != $this->plural) {
            $this->plural = $plu;
        }
        if ($sig != null && $sig != $this->significado) {
            $this->significado = $sig;
        }
        if ($obs != null && $obs != $this->observaciones) {
            $this->observaciones = $obs;
        }
        if ($grid != null && $grid != $this->gramaticaid) {
            $this->gramaticaid = $grid;
        }
        if ($inid != null && $inid != $this->intencionid) {
            $this->intencionid = $inid;
        }
        if ($tipid != null && $tipid != $this->tipologiaid) {
            $this->tipologiaid = $tipid;
        }
        if ($ejemplo != null && $ejemplo != $this->ejemplo) {
            $this->ejemplo = $ejemplo;
        }
        if ($id != null && $id != $this->id) {
            $this->id = $id;
        }
    }

    /**
     * Obtiene el valor de un parámetro indicado
     *
     * @param type $param Nombre del parámetro del que se desea conocer su valor
     * @return type Valor del parámetro indicado
     */
    function get($param) {
        global $DB;
        $param = strtolower($param);
        switch ($param) {
            default:
            case 'id':
                return $this->id;
                break;
            case 'palabra':
                return $this->palabra;
                break;
            case 'genero':
                return $this->genero;
                break;
            case 'plural':
                return $this->plural;
                break;
            case 'significado':
                return $this->significado;
                break;
            case 'observaciones':
                return $this->observaciones;
                break;
            case 'gramaticaid':
                return $this->gramaticaid;
                break;
            case 'intencionid':
                return $this->intencionid;
                break;
            case 'ejemplo':
                return $this->ejemplo;
                break;
            case 'tipologiaid':
                return $this->tipologiaid;
                break;
        }
    }

    /**
     * Extraer un sustantivo de la base de datos
     *
     * @param type $sustantivoid Id del sustantivo deseado en la base de datos
     */
    function leer($sustantivoid) {
     global $DB;
        $sus = $DB->get_record('vocabulario_sustantivos', array("id" => $sustantivoid));
        $this->palabra = $sus->palabra;
        $this->genero = $sus->genero;
        $this->plural = $sus->plural;
        $this->significado = $sus->significado;
        $this->observaciones = $sus->observaciones;
        $this->gramaticaid = $sus->gramaticaid;
        $this->intencionid = $sus->intencionid;
        $this->tipologiaid = $sus->tipologiaid;
        $this->ejemplo = $sus->ejemplo;
        $this->id = $sus->id;
    }

}

class Vocabulario_verbo {

    //atributos
    var $id;
    var $infinitivo;
    var $ter_pers_sing;
    var $preterito;
    var $participio;
    var $significado;
    var $observaciones;
    var $gramaticaid;
    var $intencionid;
    var $tipologiaid;

    //constructor del verbo por defecto gramaticaid = 20 porque es un verbo
    /**
     * Constructor por defecto de la clase verbo
     * @param type $infi
     * @param type $ter
     * @param type $pre
     * @param type $par
     * @param type $sig
     * @param type $obs
     * @param type $grid
     * @param type $inid
     * @param type $tipid
     * @param type $id
     */
    function Vocabulario_verbo($infi = ' ', $ter = '', $pre = '', $par = '', $sig = '', $obs = '', $grid = 1, $inid = 1, $tipid = 1, $id = 1) {
        $this->infinitivo = $infi;
        $this->ter_pers_sing = $ter;
        $this->preterito = $pre;
        $this->participio = $par;
        $this->significado = $sig;
        $this->observaciones = $obs;
        $this->gramaticaid = $grid;
        $this->intencionid = $inid;
        $this->tipologiaid = $tipid;
        $this->id = $id;
    }

    /**
     * Establece el valor de uno o varios atributos del verbo
     *
     * @param type $infi
     * @param type $ter
     * @param type $pre
     * @param type $par
     * @param type $sig
     * @param type $obs
     * @param type $grid
     * @param type $inid
     * @param type $tipid
     * @param type $id
     */
    function set($infi = null, $ter = null, $pre = null, $par = null, $sig = null, $obs = null, $grid = null, $inid = null, $tipid = null, $id = null) {
        if ($infi != null && $infi != $this->infinitivo) {
            $this->infinitivo = $infi;
        }
        if ($ter != null && $ter != $this->ter_pers_sing) {
            $this->ter_pers_sing = $ter;
        }
        if ($pre != null && $pre != $this->preterito) {
            $this->preterito = $pre;
        }
        if ($par != null && $par != $this->participio) {
            $this->participio = $par;
        }
        if ($sig != null && $sig != $this->significado) {
            $this->significado = $sig;
        }
        if ($obs != null && $obs != $this->observaciones) {
            $this->observaciones = $obs;
        }
        if ($grid != null && $grid != $this->gramaticaid) {
            $this->gramaticaid = $grid;
        }
        if ($inid != null && $inid != $this->intencionid) {
            $this->intencionid = $inid;
        }
        if ($tipid != null && $tipid != $this->tipologiaid) {
            $this->tipologiaid = $tipid;
        }
        if ($id != null && $id != $this->id) {
            $this->id = $id;
        }
    }

    /**
     * Obtiene el valor de un parámetro indicado
     *
     * @param type $param Nombre del parámetro del que se desea conocer su valor
     * @return type Valor del parámetro indicado
     */
    function get($param) {
        $param = strtolower($param);
        switch ($param) {
            default:
            case 'id':
                return $this->id;
                break;
            case 'infinitivo':
            case 'palabra':
                return $this->infinitivo;
                break;
            case 'ter_pers_sing':
                return $this->ter_pers_sing;
                break;
            case 'preterito':
                return $this->preterito;
                break;
            case 'participio':
                return $this->participio;
                break;
            case 'significado':
                return $this->significado;
                break;
            case 'observaciones':
                return $this->observaciones;
                break;
            case 'gramaticaid':
                return $this->gramaticaid;
                break;
            case 'intencionid':
                return $this->intencionid;
                break;
            case 'tipologiaid':
                return $this->tipologiaid;
                break;
        }
    }

    /**
     * Extraer un verbo de la base de datos
     *
     * @param type $verboid Id del verbo deseado en la base de datos
     */
    function leer($verboid) {
        global $DB;
   
        $vrb = $DB->get_record('vocabulario_verbos', array("id" => $verboid));
        $this->infinitivo = $vrb->infinitivo;
        $this->ter_pers_sing = $vrb->ter_pers_sing;
        $this->preterito = $vrb->preterito;
        $this->participio = $vrb->participio;
        $this->infinitivo = $vrb->infinitivo;
        $this->significado = $vrb->significado;
        $this->observaciones = $vrb->observaciones;
        $this->gramaticaid = $vrb->gramaticaid;
        $this->intencionid = $vrb->intencionid;
        $this->tipologiaid = $vrb->tipologiaid;
        $this->id = $vrb->id;
    }

}

class Vocabulario_adjetivo {

    //atributos
    var $id;
    var $sin_declinar;
    var $significado;
    var $observaciones;
    var $gramaticaid;
    var $intencionid;
    var $tipologiaid;

    //constructor de adjetivo por defecto gramaticaid = 48 porque es un adjetivo
    /**
     * Constructor por defecto de la clase adjetivo
     *
     * @param type $sin
     * @param type $sig
     * @param type $obs
     * @param type $grid
     * @param type $inid
     * @param type $tipid
     * @param type $id
     */
    function Vocabulario_adjetivo($sin = ' ', $sig = '', $obs = '', $grid = 1, $inid = 1, $tipid = 1, $id = 1) {
        $this->sin_declinar = $sin;
        $this->significado = $sig;
        $this->observaciones = $obs;
        $this->gramaticaid = $grid;
        $this->intencionid = $inid;
        $this->tipologiaid = $tipid;
        $this->id = $id;
    }

    //set cambia uno o varios de los atributos del sustantivo
    /**
     *
     * @param type $sin
     * @param type $sig
     * @param type $obs
     * @param type $grid
     * @param type $inid
     * @param type $tipid
     * @param type $id
     */
    function set($sin = null, $sig = null, $obs = null, $grid = null, $inid = null, $tipid = null, $id = null) {
        if ($sin != null && $sin != $this->sin_declinar) {
            $this->sin_declinar = $sin;
        }
        if ($sig != null && $sig != $this->significado) {
            $this->significado = $sig;
        }
        if ($obs != null && $obs != $this->observaciones) {
            $this->observaciones = $obs;
        }
        if ($grid != null && $grid != $this->gramaticaid) {
            $this->gramaticaid = $grid;
        }
        if ($inid != null && $inid != $this->intencionid) {
            $this->intencionid = $inid;
        }
        if ($tipid != null && $tipid != $this->tipologiaid) {
            $this->tipologiaid = $tipid;
        }
        if ($id != null && $id != $this->id) {
            $this->id = $id;
        }
    }

    //devuelve el valor del parametro pasado
    /**
     * Obtiene el valor de un parametro indicado
     *
     * @param type $param Nombre del parámetro del que se desea conocer su valor
     * @return type Valor del parámetro indicado
     */
    function get($param) {
        $param = strtolower($param);
        switch ($param) {
            default:
            case 'id':
                return $this->id;
                break;
            case 'sin_declinar':
            case 'palabra':
                return $this->sin_declinar;
                break;
            case 'significado':
                return $this->significado;
                break;
            case 'observaciones':
                return $this->observaciones;
                break;
            case 'gramaticaid':
                return $this->gramaticaid;
                break;
            case 'intencionid':
                return $this->intencionid;
                break;
            case 'tipologiaid':
                return $this->tipologiaid;
                break;
        }
    }

    /**
     * Extraer un adjetivo de la base de datos
     *
     * @param type $adjetivoid Id del adjetivo deseado en la base de datos
     */
    function leer($adjetivoid) {
        global $DB;
   
        $adj = $DB->get_record('vocabulario_adjetivos', array("id" => $adjetivoid));
       
        $this->sin_declinar = $adj->sin_declinar;
        $this->significado = $adj->significado;
        $this->observaciones = $adj->observaciones;
        $this->gramaticaid = $adj->gramaticaid;
        $this->intencionid = $adj->intencionid;
        $this->tipologiaid = $adj->tipologiaid;
        $this->id = $adj->id;
    }

}

class Vocabulario_otro {

    //atributos
    var $id;
    var $palabra;
    var $significado;
    var $observaciones;
    var $gramaticaid;
    var $intencionid;
    var $tipologiaid;

    //constructor de otro por defecto gramaticaid = 1 porque supongo que sera un nombre
    /**
     * Constructor por defecto de la clase otro
     *
     * @param type $
     */
    function Vocabulario_otro($pal = ' ', $sig = '', $obs = '', $grid = 1, $inid = 1, $tipid = 1, $id = 1) {
        $this->palabra = $pal;
        $this->significado = $sig;
        $this->observaciones = $obs;
        $this->gramaticaid = $grid;
        $this->intencionid = $inid;
        $this->tipologiaid = $tipid;
        $this->id = $id;
    }

    //set cambia uno o varios de los atributos del sustantivo
    function set($pal = null, $sig = null, $obs = null, $grid = null, $inid = null, $tipid = null, $id = null) {
        if ($pal != null && $pal != $this->palabra) {
            $this->palabra = $pal;
        }
        if ($sig != null && $sig != $this->significado) {
            $this->significado = $sig;
        }
        if ($obs != null && $obs != $this->observaciones) {
            $this->observaciones = $obs;
        }
        if ($grid != null && $grid != $this->gramaticaid) {
            $this->gramaticaid = $grid;
        }
        if ($inid != null && $inid != $this->intencionid) {
            $this->intencionid = $inid;
        }
        if ($tipid != null && $tipid != $this->tipologiaid) {
            $this->tipologiaid = $tipid;
        }
        if ($id != null && $id != $this->id) {
            $this->id = $id;
        }
    }

    //devuelve el valor del parametro pasado
    function get($param) {
        $param = strtolower($param);
        switch ($param) {
            default:
            case 'id':
                return $this->id;
                break;
            case 'palabra':
                return $this->palabra;
                break;
            case 'significado':
                return $this->significado;
                break;
            case 'observaciones':
                return $this->observaciones;
                break;
            case 'gramaticaid':
                return $this->gramaticaid;
                break;
            case 'intencionid':
                return $this->intencionid;
                break;
            case 'tipologiaid':
                return $this->tipologiaid;
                break;
        }
    }

    function leer($otroid) {
        global $DB;
   
        $otr = $DB->get_record('vocabulario_otros', array("id" => $otroid));
        
        $this->palabra = $otr->palabra;
        $this->significado = $otr->significado;
        $this->observaciones = $otr->observaciones;
        $this->gramaticaid = $otr->gramaticaid;
        $this->intencionid = $otr->intencionid;
        $this->tipologiaid = $otr->tipologiaid;
        $this->id = $otr->id;
    }

}

class Vocabulario_campo_lexico {

    var $id;
    var $usuarioid;
    var $padre;
    var $campo;

    function Vocabulario_campo_lexico($id = null, $usuarioid = null, $padre = null, $campo = null) {
        $this->id = $id;
        $this->usuarioid = $usuarioid;
        $this->padre = $padre;
        $this->campo = $campo;
    }

    function set($id = null, $usuarioid = null, $padre = null, $campo = null) {
        if ($id != null && $id != $this->id) {
            $this->id = $id;
        }
        if ($usuarioid != null && $usuarioid != $this->usuarioid) {
            $this->usuarioid = $usuarioid;
        }
        if ($padre != null && $padre != $this->padre) {
            $this->padre = $padre;
        }
        if ($campo != null && $campo != $this->campo) {
            $this->campo = $campo;
        }
    }

    function get($param) {
        $param = strtolower($param);
        switch ($param) {
            default:
            case 'id':
                return $this->id;
                break;
            case 'usuarioid':
                return $this->usuarioid;
                break;
            case 'padre':
                return $this->padre;
                break;
            case 'campo':
            case 'palabra':
                return $this->campo;
                break;
        }
    }

    function leer($campoid) {
        global $DB;
        $sufijotabla = get_sufijo_lenguaje_tabla();
        $cl = $DB->get_record('vocabulario_camposlexicos_'.$sufijotabla, array("id" => $campoid));

        $this->usuarioid = $cl->usuarioid;
        $this->padre = $cl->padre;
        $this->campo = $cl->campo;
        $this->id = $cl->id;
    }

    function obtener_todos($usuarioid) {
        global $DB;

        $sufijotabla = get_sufijo_lenguaje_tabla();
        $campos_lexicos = $DB->get_records_select('vocabulario_camposlexicos_'.$sufijotabla, 'usuarioid=' . $usuarioid . ' or usuarioid=0');
        $clex = array();
        $orden = $this->ordena($campos_lexicos);
        foreach ($orden as $i) {
            $clex[$campos_lexicos[$i]->id] = $campos_lexicos[$i]->campo;
        }
        return $clex;
    }


    function obtener_hijos($usuarioid, $padreid, $insertar=false) {
        global $DB;

        $sufijotabla = get_sufijo_lenguaje_tabla();
        $campos_lexicos = $DB->get_records_select('vocabulario_camposlexicos_'.$sufijotabla, '(usuarioid=' . $usuarioid . ' or usuarioid=0) and padre=' . $padreid);
        $clex = array();
        if($padreid != 0 || $insertar){
         $clex[$padreid] = get_string('seleccionar','vocabulario');
        }
        $orden = $this->ordena($campos_lexicos, $padreid);
        foreach ($orden as $i) {
            $clex[$campos_lexicos[$i]->id] = $campos_lexicos[$i]->campo;
        }
        return $clex;
    }

    function obtener_padres($usuarioid, $hijoid) {
        $clex = array();

        $clex[] = $hijoid;
        $padre = $hijoid;

        while ($padre != 0) {
            $cl = new Vocabulario_campo_lexico();
            $cl->leer($padre);
            $padre = $cl->get('padre');
            $clex[] = $padre;
        }
        $clex = array_reverse($clex);
        return $clex;
    }

    function ordena($lista, $padre = '0', $salida = '') {
        $milista = array();
        foreach ($lista as $cosa) {
            $milista[$cosa->id] = $cosa->padre;
        }
        $encontrados = array_keys($milista, $padre);
        foreach ($encontrados as $cosa) {
            $salida[] = $cosa;
            $salida = $this->ordena($lista, $cosa, $salida);
        }
        return $salida;
    }

}

class Vocabulario_mis_palabras {

    var $id;
    var $usuarioid;
    var $sustantivoid;
    var $adjetivoid;
    var $verboid;
    var $otroid;
    var $campoid;
    var $sustantivo;
    var $adjetivo;
    var $verbo;
    var $otro;
    var $campo;

    function Vocabulario_mis_palabras($usuarioid = null, $sustantivo = null, $verbo = null, $adjetivo = null, $otro = null, $campoid = 1, $id = null) {
        $this->usuarioid = $usuarioid;
        $this->sustantivo = $sustantivo;
        //$this->sustantivoid = $sustantivo->id;
        $this->adjetivo = $adjetivo;
        //$this->adjetivoid = $adjetivo->id;
        $this->verbo = $verbo;
        //$this->verboid = $verbo->id;
        $this->otro = $otro;
        //$this->otroid = $otro->id;
        $this->campoid = $campoid;
        $camp = new Vocabulario_campo_lexico();
        $camp->leer($campoid);
        $this->campo = $camp;
        $this->id = $id;
    }

    function set($sustantivo = null, $verbo = null, $adjetivo = null, $otro = null, $campoid = null) {
        if ($sustantivo != null && $sustantivo != $this->sustantivo) {
            $this->sustantivo = $sustantivo;
        }
        if ($verbo != null && $verbo != $this->verbo) {
            $this->verbo = $verbo;
        }
        if ($adjetivo != null && $adjetivo != $this->adjetivo) {
            $this->adjetivo = $adjetivo;
        }
        if ($otro != null && $otro != $this->otro) {
            $this->otro = $otro;
        }
        if($campoid != null) {
            $camp = new Vocabulario_campo_lexico();
            $camp->leer($campoid);
            $this->campo = $camp;
        }
    }
    
    function set_ids($sustantivoid = null, $verboid = null, $adjetivoid = null, $otroid = null, $campoid = null) {
        $this->sustantivoid = $sustantivoid;
        $this->adjetivoid = $adjetivoid;
        $this->verboid = $verboid;
        $this->otroid = $otroid;
        $this->campoid = $campoid;
    }

    function get($param) {
        $param = strtolower($param);
        switch ($param) {
            default:
            case 'id':
                return $this->id;
                break;
            case 'usuarioid':
                return $this->usuarioid;
                break;
            case 'sustantivoid':
                return $this->sustantivoid;
                break;
            case 'adjetivoid':
                return $this->adjetivoid;
                break;
            case 'verboid':
                return $this->verboid;
                break;
            case 'otroid':
                return $this->otroid;
                break;
            case 'campoid':
                return $this->campoid;
                break;
            case 'sustantivo':
                return $this->sustantivo;
                break;
            case 'adjetivo':
                return $this->adjetivo;
                break;
            case 'verbo':
                return $this->verbo;
                break;
            case 'otro':
                return $this->otro;
                break;
            case 'campo':
                return $this->campo;
                break;
        }
    }

    function leer($id) {
        global $DB;
        
        $mp = $DB->get_record('vocabulario_mis_palabras', array("id" => $id));
    
        $sustantivo = new Vocabulario_sustantivo();
        $sustantivo->leer($mp->sustantivoid);
        $this->sustantivo = $sustantivo;
        $this->sustantivoid = $sustantivo->id;

        $verbo = new Vocabulario_verbo();
        $verbo->leer($mp->verboid);
        $this->verbo = $verbo;
        $this->verboid = $verbo->id;

        $adjetivo = new Vocabulario_adjetivo();
        $adjetivo->leer($mp->adjetivoid);
        $this->adjetivo = $adjetivo;
        $this->adjetivoid = $adjetivo->id;

        $otro = new Vocabulario_otro();
        $otro->leer($mp->otroid);
        $this->otro = $otro;
        $this->otroid = $otro->id;

        $campolexico = new Vocabulario_campo_lexico();
        $campolexico->leer($mp->campoid);
        $this->campo = $campolexico;
        $this->campoid = $campolexico->id;

        $this->usuarioid = $mp->usuarioid;
        $this->id = $mp->id;
    }

    function obtener_todas($usuarioid, $campo = null, $letra = null) {
        global $DB;        
        
        if ($campo) {
            $todas = $DB->get_records('vocabulario_mis_palabras', array('usuarioid'=>$usuarioid,'campoid'=>$campo), null, 'id');
        } else if ($letra) {
            $todas = array();
            //$todas_aux = get_records('vocabulario_mis_palabras', 'usuarioid', $usuarioid, 'campoid');
            $todas_aux = $DB->get_records('vocabulario_mis_palabras',array('usuarioid'=>$usuarioid),null,'campoid');
            foreach ($todas_aux as $cosa) {
                $mp = new Vocabulario_mis_palabras();
                $mp->leer($cosa->id);
                $letra_aux = $mp->get('sustantivo')->get('palabra');
                $letra_aux = $letra_aux[0];
                if (strtolower($letra_aux) == strtolower($letra)) {
                    $todas[] = $cosa;
                }
            }
        } else {
            $todas = $DB->get_records('vocabulario_mis_palabras',array('usuarioid'=>$usuarioid),null,'campoid');
        }

        $todas_mis_palabras = array();

        foreach ($todas as $cosa) {
            $mp = new Vocabulario_mis_palabras();
            $mp->leer($cosa->id);
            $todas_mis_palabras[] = $mp;
        }
        return $todas_mis_palabras;
    }

    function eliminar($id) {

        global $DB;        

        $this->leer($id);

        $params = array('sustantivoid' => $this->sustantivoid);
        $sql = "SELECT count(*) num FROM {vocabulario_mis_palabras} WHERE sustantivoid = :sustantivoid";
        $numsustantivos = $DB->get_records_sql($sql, $params);
        if ($numsustantivos->num == 1) {
            $DB->delete_records('vocabulario_sustantivos', array('id'=>$this->sustantivoid));
        }

        $params = array('adjetivoid' => $this->adjetivoid);
        $sql = "SELECT count(*) num FROM {vocabulario_mis_palabras} WHERE adjetivoid = :adjetivoid";
        $numadjetivos = $DB->get_records_sql($sql, $params);
        if ($numadjetivos->num == 1) {
            $DB->delete_records('vocabulario_adjetivos', array('id'=>$this->adjetivoid));
        }

        $params = array('verboid' => $this->verboid);
        $sql = "SELECT count(*) num FROM {vocabulario_mis_palabras} WHERE verboid = :verboid";
        $numverbos = $DB->get_records_sql($sql, $params);
        if ($numverbos->num == 1) {
            $DB->delete_records('vocabulario_verbos', array('id'=>$this->verboid));
        }

        $params = array('otroid' => $this->otroid);
        $sql = "SELECT count(*) num FROM {vocabulario_mis_palabras} WHERE otroid = :otroid";
        $numotros = $DB->get_records_sql($sql, $params);
        if ($numotros->num == 1) {
            $DB->delete_records('vocabulario_otros', array('id'=>$this->otroid));
        }

        $DB->delete_records('vocabulario_mis_palabras', array('id'=>$this->id));
    }

    function guardar() {
        global $DB;
        $todas = $this->obtener_todas($this->usuarioid);

        $insertar_sustantivo = true;
        $insertar_adjetivo = true;
        $insertar_verbo = true;
        $insertar_otro = true;

        $insertar_combinacion = true;

        $id_actualizable = 0;

        //inserto nuevas las que tenga que insertar
        if ($insertar_sustantivo && $this->get('sustantivo')->get('palabra')) {
            $record = new object();
            
            $record= $this->get('sustantivo'); 
            $record->id=null;                    
            $id = $DB->insert_record('vocabulario_sustantivos', $record, true);
            $this->sustantivo->set(null, null, null, null, null, null, null, null, null, $id);
            
        }
        if ($insertar_adjetivo && $this->get('adjetivo')->get('sin_declinar')) {
            $record = new object();
            $record= $this->get('adjetivo');
            $record->id=null; 
            $id = $DB->insert_record('vocabulario_adjetivos', $record, true);
            $this->adjetivo->set(null, null, null, null, null, null, $id);
        }
        if ($insertar_verbo && $this->get('verbo')->get('infinitivo')) {         
            $record = new object();
            $record= $this->get('verbo'); 
            $record->id=null; 
            $id = $DB->insert_record('vocabulario_verbos', $record, true);
            $this->verbo->set(null, null, null, null, null, null, null, null, null, $id);
        }
        if ($insertar_otro && $this->get('otro')->get('palabra')) {
            $record = new object();
            $record= $this->get('otro');
            $record->id=null; 
            $id = $DB->insert_record('vocabulario_otros', $record, true);
            $this->otro->set(null, null, null, null, null, null, $id);
        }

        foreach ($todas as $cosa) {
            $actualizable1 = false;
            $actualizable2 = false;
            $actualizable3 = false;
            $actualizable4 = false;

            if ($cosa->get('sustantivo')->get('id') == $this->get('sustantivo')->get('id')) {
                $actualizable1 = true;
            }
            if ($cosa->get('adjetivo')->get('id') == $this->get('adjetivo')->get('id') || $cosa->get('adjetivo')->get('id') == 1 || $this->get('adjetivo')->get('id') == 1) {
                $actualizable2 = true;
            }
            if ($cosa->get('verbo')->get('id') == $this->get('verbo')->get('id') || $cosa->get('verbo')->get('id') == 1 || $this->get('verbo')->get('id') == 1) {
                $actualizable3 = true;
            }
            if ($cosa->get('otro')->get('id') == $this->get('otro')->get('id') || $cosa->get('otro')->get('id') == 1 || $this->get('otro')->get('id') == 1) {
                $actualizable4 = true;
            }

            if ($actualizable1 && $actualizable2 && $actualizable3 && $actualizable4 && !$id_actualizable) {
                $id_actualizable = $cosa->get('id');
                if ($this->get('adjetivo')->get('id') == 1) {
                    $this->set(null, null, $cosa->get('adjetivo'), null);
                }
                if ($this->get('verbo')->get('id') == 1) {
                    $this->set(null, $cosa->get('verbo'), null, null);
                }
                if ($this->get('otro')->get('id') == 1) {
                    $this->set(null, null, null, $this->get('otro'));
                }
            }
        }

        $this->sustantivoid = $this->sustantivo->id;
        $this->adjetivoid = $this->adjetivo->id;
        $this->verboid = $this->verbo->id;
        $this->otroid = $this->otro->id;

        if ($id_actualizable) {
            $this->id = $id_actualizable;
            $DB->update_record('vocabulario_mis_palabras', $this, true);
        } else {
            $id_actualizable = $DB->insert_record('vocabulario_mis_palabras', $this, true);
            $this->id = $id_actualizable;
            echo "palabra insertada ". $id_actualizable;
        }
    }

    function actualizar($sus, $ver, $adj, $otr, $cam) {
        //Borja Arroba: Cambio de la funcion completa, antes se actualizaba cualquier campo de los 4 
        //machacando la primera ocurrencia de dicho campo de la base de datos. Por lo tanto si se modificaba
        //cualquier campo de una tupla mis palabras se cambiaba la primera ocurrencia que encontraba no la que queremos
        //El cambio permite modificar una tupla de "mis_palabras" o bien añadir cualquier campo en caso de que no estuviera,
        //es decir, si dentro de la tupla de mis palabras no exisita el campo previamente, lo inserta como uno nuevo (nuevo id), 
        //si ya existia lo modifica (hace un update con el id que tenia)

        global $DB;
        
        if($this->get("sustantivoid")==1) { //Si hay un uno es que queremos añadir, no modificar
            if($sus->get("palabra")!="") { //Si este campo es null no se añade ni se modifica
                $sus->leer($DB->insert_record('vocabulario_sustantivos', $sus, true));
            }
        } else { //Si no, modificamos
            $sus->set(null, null, null, null, null, null, null, null, null, $this->get("sustantivoid"));
            $DB->update_record('vocabulario_sustantivos', $sus, true);
        }
        
        if($this->get("verboid")==1) { //Si hay un uno es que queremos añadir, no modificar
            if($ver->get("palabra")!="") { //Si este campo es null no se añade ni se modifica
                $ver->leer($DB->insert_record('vocabulario_verbos', $ver, true));
            }
        } else { //Si no, modificamos
            $ver->set(null, null, null, null, null, null, null, null, null, $this->get("verboid"));
            $DB->update_record('vocabulario_verbos', $ver, true);
        }
        
        if($this->get("adjetivoid")==1) { //Si hay un uno es que queremos añadir, no modificar
            if($adj->get("palabra")!="") { //Si este campo es null no se añade ni se modifica
                $adj->leer($DB->insert_record('vocabulario_adjetivos', $adj, true));
            }
        } else { //Si no, modificamos
            $adj->set(null, null, null, null, null, null, $this->get("adjetivoid"));
            $DB->update_record('vocabulario_adjetivos', $adj, true);
        }
        
        if($this->get("otroid")==1) { //Si hay un uno es que queremos añadir, no modificar
            if($otr->get("palabra")!="") { //Si este campo es null no se añade ni se modifica
                $otr->leer($DB->insert_record('vocabulario_otros', $otr, true));
            }
        } else { //Si no, modificamos
            $otr->set(null, null, null, null, null, null, $this->get("otroid"));
            $DB->update_record('vocabulario_otros', $otr, true);
        }
        
        $this->set_ids($sus->get("id"), $ver->get("id"), $adj->get("id"), $otr->get("id"), $cam);
        $DB->update_record('vocabulario_mis_palabras', $this, true);
    }

    function combinaciones_completas($usuarioid) {
        global $DB;
        $combinaciones = $DB->get_records_sql('call todas_palabras(:usuarioid)', array('usuarioid'=>$usuarioid));
        return $combinaciones;
    }

}

class Vocabulario_gramatica {

    var $id;
    var $usuarioid;
    var $padre;
    var $gramatica;
    var $descripcion;

    function Vocabulario_gramatica($usuarioid = null, $padre = null, $gramatica = null, $descripcion = null, $id = null) {
        $this->id = $id;
        $this->usuarioid = $usuarioid;
        $this->padre = $padre;
        $this->gramatica = $gramatica;
        $this->descripcion = $descripcion;
    }

    function set($id = null, $usuarioid = null, $padre = null, $gramatica = null, $descripcion = null) {
        if ($id != null && $id != $this->id) {
            $this->id = $id;
        }
        if ($usuarioid != null && $usuarioid != $this->usuarioid) {
            $this->usuarioid = $usuarioid;
        }
        if ($padre != null && $padre != $this->padre) {
            $this->padre = $padre;
        }
        if ($gramatica != null && $gramatica != $this->gramatica) {
            $this->gramatica = $gramatica;
        }
        if ($descripcion != null && $descripcion != $this->descripcion) {
            $this->descripcion = $descripcion;
        }
    }

    function get($param) {
        $param = strtolower($param);
        switch ($param) {
            default:
            case 'id':
                return $this->id;
                break;
            case 'usuarioid':
                return $this->usuarioid;
                break;
            case 'padre':
                return $this->padre;
                break;
            case 'gramatica':
            case 'palabra':
                return $this->gramatica;
                break;
            case 'descripcion':
                //return 'aqui va una descripcion de '.$this->gramatica;
                return $this->descripcion;
                break;
        }
    }

    function leer($gramaticaid, $usuarioid) {
        global $DB;       

        $gr = $DB->get_record('vocabulario_gramatica', array('id'=>$gramaticaid));
        $this->usuarioid = $gr->usuarioid;
        $this->padre = $gr->padre;
        $this->gramatica = $gr->gramatica;
        $this->descripcion = $gr->descripcion;
        $this->id = $gr->id;
    }

    function obtener_hijos($usuarioid, $padreid, $insertar=false) {
        global $DB;        

        $gramaticas = $DB->get_records_select('vocabulario_gramatica', '(usuarioid=:usuarioid or usuarioid=0) and padre=:padreid', array('usuarioid'=>$usuarioid, 'padreid'=>$padreid));
      
        $gr = array();
        if($padreid!=0 || $insertar){

            $gr[$padreid] = get_string('seleccionar','vocabulario');
        }
        $orden = $this->ordena($gramaticas, $padreid);
        foreach ($orden as $i) {
            $gr[$gramaticas[$i]->id] = $gramaticas[$i]->gramatica;
        }
        return $gr;
    }

    function obtener_padres($usuarioid, $hijoid) {
        $graux = array();

        $graux[] = $hijoid;
        $padre = $hijoid;

        while ($padre != 0) {
            $gr = new Vocabulario_gramatica();
            $gr->leer($padre);
            $padre = $gr->get('padre');
            $graux[] = $padre;
        }
        $graux = array_reverse($graux);
        return $graux;
    }

    function obtener_todos($usuarioid) {
        global $DB;

        $gramaticas = $DB->get_records_select('vocabulario_gramatica', 'usuarioid=:usuarioid or usuarioid=0', array('usuarioid'=>$usuarioid));
        $gr = array();
        $orden = $this->ordena($gramaticas);
        foreach ($orden as $i) {
            $gr[$gramaticas[$i]->id] = $gramaticas[$i]->gramatica;
        }
        return $gr;
    }

    function obtener_todos_ids($usuarioid) {
        global $DB;
        $gramaticas = $DB->get_records_select('vocabulario_gramatica', 'usuarioid=:usuarioid or usuarioid=0', array('usuarioid'=>$usuarioid));
        $gr = array();
        $orden = $this->ordena($gramaticas);
        foreach ($orden as $i) {
            $gr[$gramaticas[$i]->id] = $gramaticas[$i]->id;
        }
        return $gr;
    }

    function ordena($lista, $padre = '0', $salida = '') {
        $milista = array();
        foreach ($lista as $cosa) {
            $milista[$cosa->id] = $cosa->padre;
        }
        $encontrados = array_keys($milista, $padre);
        foreach ($encontrados as $cosa) {
            $salida[] = $cosa;
            $salida = $this->ordena($lista, $cosa, $salida);
        }
        return $salida;
    }

}

class Vocabulario_mis_gramaticas {

    var $id;
    var $usuarioid;
    var $gramaticaid;
    var $descripcion;
    var $tipo_palabra;
    var $palabra_id;

    function Vocabulario_mis_gramaticas($usuarioid = null, $gramaticaid = null, $descripcion = null, $tipo_palabra = null, $palabraid = null, $id = null) {
        $this->id = $id;
        $this->usuarioid = $usuarioid;
        $this->gramaticaid = $gramaticaid;
        $this->descripcion = $descripcion;
        $this->tipo_palabra = $tipo_palabra;
        $this->palabra_id = $palabraid;
    }

    function set($usuarioid = null, $gramaticaid = null, $descripcion = null, $tipo_palabra = null, $palabraid = null, $id = null) {
        if ($id != null && $id != $this->id) {
            $this->id = $id;
        }
        if ($usuarioid != null && $usuarioid != $this->usuarioid) {
            $this->usuarioid = $usuarioid;
        }
        if ($gramaticaid != null && $gramaticaid != $this->gramaticaid) {
            $this->gramaticaid = $gramaticaid;
        }
        if ($tipo_palabra != null && $tipo_palabra != $this->tipo_palabra) {
            $this->tipo_palabra = $tipo_palabra;
        }
        if ($palabraid != null && $palabraid != $this->palabraid) {
            $this->palabra_id = $palabraid;
        }
        if ($descripcion != null && $descripcion != $this->descripcion) {
            $this->descripcion = $descripcion;
        }
    }

    function get($param) {
        $param = strtolower($param);
        switch ($param) {
            default:
            case 'id':
                return $this->id;
                break;
            case 'usuarioid':
                return $this->usuarioid;
                break;
            case 'gramaticaid':
                return $this->gramaticaid;
                break;
            case 'tipo_palabra':
                return $this->tipo_palabra;
                break;
            case 'palabraid':
                return $this->palabra_id;
                break;
            case 'descripcion':
                return $this->descripcion;
                break;
        }
    }

    function guardar() {
        global $DB;

        $table = 'vocabulario_mis_gramaticas';
        $select = "usuarioid =" . $this->usuarioid . " AND gramaticaid = '" . $this->gramaticaid . "'";
         
        $gr = $DB->get_record_select($table, $select);
        if ($gr->id == null) {
            $this->id = $DB->insert_record('vocabulario_mis_gramaticas', $this, true);
        } else {
            $this->id = $gr->id;
            $DB->update_record('vocabulario_mis_gramaticas', $this, true);
        }
    }

    function actualizar() {
        global $DB;
        $DB->update_record('vocabulario_mis_gramaticas', $this, true);
    }

    function leer($grid, $usuarioid = null) {
        global $DB;
    
        $table = 'vocabulario_mis_gramaticas';
        $conditions = array('gramaticaid'=>$grid, 'usuarioid'=>$usuarioid);      

        $gr = $DB->get_record($table, $conditions);
        $this->usuarioid = $gr->usuarioid;
        $this->descripcion = $gr->descripcion;
        $this->gramaticaid = $gr->gramaticaid;
        $this->id = $gr->id;
        $this->tipo_palabra = $gr->tipo_palabra;
        $this->palabra_id = $gr->palabra_id;
    }

    function relacionadas($usuarioid, $gramaticaid) {
        global $DB;
    
        $table = 'vocabulario_mis_gramaticas';
        $select = "usuarioid =" . $usuarioid . " AND gramaticaid = " . $gramaticaid;        

        $palabras = $DB->get_records_select($table, $select);
        return $palabras;
    }

}

class Vocabulario_intenciones {

    var $id;
    var $usuarioid;
    var $padre;
    var $intencion;
    var $ordenid;

    function Vocabulario_intenciones($usuarioid = null, $padre = null, $intencion = null, $ordenid = null, $id = null) {
        $this->id = $id;
        $this->usuarioid = $usuarioid;
        $this->padre = $padre;
        $this->intencion = $intencion;
        $this->ordenid = $ordenid;
    }

    function set($id = null, $usuarioid = null, $padre = null, $intencion = null) {
        if ($id != null && $id != $this->id) {
            $this->id = $id;
        }
        if ($usuarioid != null && $usuarioid != $this->usuarioid) {
            $this->usuarioid = $usuarioid;
        }
        if ($padre != null && $padre != $this->padre) {
            $this->padre = $padre;
        }
        if ($intencion != null && $intencion != $this->intencion) {
            $this->intencion = $intencion;
        }
        if ($ordenid != null && $ordenid != $this->ordenid) {
            $this->ordenid = $ordenid;
        }
    }

    function get($param) {
        $param = strtolower($param);
        switch ($param) {
            default:
            case 'id':
                return $this->id;
                break;
            case 'usuarioid':
                return $this->usuarioid;
                break;
            case 'padre':
                return $this->padre;
                break;
            case 'ordenid':
                return $this->ordenid;
                break;
            case 'intencion':
            case 'palabra':
                return $this->intencion;
                break;
        }
    }

    function leer($intencionid, $usuarioid) {
        global $DB;

        $sufijotabla = get_sufijo_lenguaje_tabla();
        $table = 'vocabulario_intenciones_'. $sufijotabla;
        $conditions = array('id'=>$intencionid); 
 
        $ic = $DB->get_record($table, $conditions);
        $this->usuarioid = $ic->usuarioid;
        $this->padre = $ic->padre;
        $this->intencion = $ic->intencion;
        $this->ordenid = $ic->ordenid;
        $this->id = $ic->id;
    }

    

    
     /*
    Autor: Salim Tieb Mohamedi
    Fecha: 15-nov-2014
    Las dos funciones obtener_todos y obtener_todos_subnumerados resuelve el problema del desorden de
    en las intenciones que se muestran en el formulario a través del SELECT. 
    */
    function obtener_todos($usuarioid) {
        global $orden;
        global $ic; 
        global $DB;
     
        $sufijotabla = get_sufijo_lenguaje_tabla();
        $table = 'vocabulario_intenciones_'.$sufijotabla;
        $select = 'padre= 0';
        $sort = 'ordenid';
         
       
        $gr = $DB->get_records_select($table, $select, null, $sort);
             
          
            $contador = 0;
            foreach ($gr as $i) {   
                $ic[$orden] = $contador . "." . "&nbsp;&nbsp;&nbsp;&nbsp;" .$i->intencion;               
                 
                $orden++;               
                $this->obtener_todos_subnumerados($usuarioid, $i->id, $contador); 
                $contador++;
                
            }
        
        return $ic;
    }   
    
    function obtener_todos_subnumerados($usuarioid, $id_padre, $contador_padre) {
        global $orden;
        global $ic;
        global $DB;
         
        $sufijotabla = get_sufijo_lenguaje_tabla();
        $table = 'vocabulario_intenciones_'.$sufijotabla;
        $select = 'padre=' . $id_padre. ' AND (usuarioid= 0 OR usuarioid=' . $usuarioid . ')' ;
        $sort = 'id';         
       
        $gr = $DB->get_records_select($table, $select, null, $sort);
         
             
            $contador = 1;
            foreach ($gr as $i) {   
                $contador_padre_padre = $contador_padre . "." . $contador;
                $ic[$orden] = $contador_padre . "." . $contador . "." . "&nbsp;&nbsp;&nbsp;&nbsp;" .$i->intencion;
                $orden++;
                $contador++;
                $padre = $i->id;
                
                $this->obtener_todos_subnumerados($usuarioid, $padre, $contador_padre_padre);              
            }
            return;
      
    }
    
    function obtener_orden($usuarioid, $hijoid) {
        global $ordinal;
        global $DB;
         
        $sufijotabla = get_sufijo_lenguaje_tabla();
        $table = 'vocabulario_intenciones_'.$sufijotabla;
        $select = 'padre= 0';
        $sort = 'ordenid';
         
       
        $gr = $DB->get_records_select($table, $select, null, $sort);
                  
            $contador = 0;
            foreach ($gr as $i) { 
                if($hijoid==$i->id)
                {    $ordinal = $contador;
                     //echo "la posición ordinal de " . $hijoid . " es " . $ordinal;
                     break;    
                
                }
                             
                $this->obtener_suborden($usuarioid,$hijoid, $i->id, $contador); 
                $contador++;
                
            }
        
        
        return $ordinal;
    }  
    
    function obtener_suborden($usuarioid, $hijoid, $id_padre, $contador_padre) {
     
        global $ordinal;
        global $DB;
         
        $sufijotabla = get_sufijo_lenguaje_tabla();
        $table = 'vocabulario_intenciones_'.$sufijotabla;
        $select = 'padre=' . $id_padre. ' AND (usuarioid= 0 OR usuarioid=' . $usuarioid . ')' ;
        $sort = 'id';
         
       
        $gr = $DB->get_records_select($table, $select, null, $sort);
        
                
            $contador = 1;
            foreach ($gr as $i) {   
                $contador_padre_padre = $contador_padre . "." . $contador;
                
                if($hijoid==$i->id)
                {    $ordinal = $contador_padre_padre;
                     //echo "la posición ordinal de " . $hijoid . " es " . $ordinal;
                     break;
                }
              
                $contador++;
                $padre = $i->id;
                
                $this->obtener_suborden($usuarioid, $hijoid, $padre, $contador_padre_padre);              
            }
            return;
      
      
    }

    function obtener_todos_ids($usuarioid) {
        global $DB;
         
        $sufijotabla = get_sufijo_lenguaje_tabla();
        $table = 'vocabulario_intenciones_'.$sufijotabla;
        $select = 'usuarioid= 0 OR usuarioid=' . $usuarioid ;
                 
       
        $intenciones  = $DB->get_records_select($table, $select);
        $ic = array();
        $orden = $this->ordena($intenciones);
        foreach ($orden as $i) {
            $ic[$intenciones[$i]->id] = $intenciones[$i]->id;
        }
        return $ic;
    }
    /*
    Autor: Salim Tieb Mohamedi
    Fecha: 4-dic-2014
    Las dos funciones obtener_todos y obtener_todos_subnumerados resuelve el problema del desorden de
    en las intenciones que se muestran en el formulario a través del SELECT. No depende del usuarioid por eso no 
    recibe parámetros, más bien el id.
    Para ver una demostración usar la función /test/testintenciones.php
    */
    function obtener_hijos($usuarioid, $padreid, $insertar=false) 
    {
        global $DB;
        $orden = '';
         
        $sufijotabla = get_sufijo_lenguaje_tabla();
        $table = 'vocabulario_intenciones_'.$sufijotabla;
        $select = 'padre=' . $padreid. ' AND (usuarioid= 0 OR usuarioid=' . $usuarioid . ')' ;
        $sort = '';        
        
        if($padreid == 0)
                $sort = 'ordenid';                     
        
         
        $gr = $DB->get_records_select($table, $select, null, $sort);
        $ic = array();
        if($padreid!=0 || $insertar){
           $ic[$padreid] = get_string('seleccionar','vocabulario');
        }
                
        
         
        foreach ($gr as $i) { 
            $orden = $this->obtener_orden($usuarioid, $i->id);
            $ic[$i->id] = $orden . "." . "&nbsp;&nbsp;&nbsp;&nbsp;" .$i->intencion;  
        }
    return $ic;
    }
    
    
  
    
    
    function obtener_padres($hijoid) {
        $clex = array();

        $clex[] = $hijoid;
        $padre = $hijoid;

        while ($padre != 0) {
            $cl = new Vocabulario_intenciones();
            //pongo 0 porque el usarioid no es necesario, ya que no se usa en la funcion
            $cl->leer($padre, 0);
            $padre = $cl->get('padre');
            $clex[] = $padre;
        }
        $clex = array_reverse($clex);
        return $clex;
    }

    function ordena($lista, $padre = '0', $salida = '') {
        $milista = array();
        foreach ($lista as $cosa) {
            $milista[$cosa->id] = $cosa->padre;
        }
//        echo " </br>milista </br>"; var_dump($lista);
        $encontrados = array_keys($milista, $padre);
        //echo " </br>encontrados </br>"; var_dump($encontrados);
        foreach ($encontrados as $cosa) {
            $salida[] = $cosa;
            $salida = $this->ordena($lista, $cosa, $salida);
        }
        return $salida;
    }

}

class Vocabulario_mis_intenciones {

    var $id;
    var $usuarioid;
    var $intencionesid;
    var $descripcion;
    var $tipo_palabra;
    var $palabra_id;

    function Vocabulario_mis_intenciones($usuarioid = null, $intencionesid = null, $descripcion = null, $tipo_palabra = null, $palabraid = null, $id = null) {
        $this->id = $id;
        $this->usuarioid = $usuarioid;
        $this->intencionesid = $intencionesid;
        $this->descripcion = $descripcion;
        $this->tipo_palabra = $tipo_palabra;
        $this->palabra_id = $palabraid;
    }

    function set($usuarioid = null, $intencionesid = null, $descripcion = null, $tipo_palabra = null, $palabraid = null, $id = null) {
        if ($id != null && $id != $this->id) {
            $this->id = $id;
        }
        if ($usuarioid != null && $usuarioid != $this->usuarioid) {
            $this->usuarioid = $usuarioid;
        }
        if ($intencionesid != null && $intencionesid != $this->intencionesid) {
            $this->intencionesid = $intencionesid;
        }
        if ($tipo_palabra != null && $tipo_palabra != $this->tipo_palabra) {
            $this->tipo_palabra = $tipo_palabra;
        }
        if ($palabraid != null && $palabraid != $this->palabraid) {
            $this->palabra_id = $palabraid;
        }
        if ($descripcion != null && $descripcion != $this->descripcion) {
            $this->descripcion = $descripcion;
        }
    }

    function get($param) {
        $param = strtolower($param);
        switch ($param) {
            default:
            case 'id':
                return $this->id;
                break;
            case 'usuarioid':
                return $this->usuarioid;
                break;
            case 'intencionesid':
                return $this->intencionesid;
                break;
            case 'tipo_palabra':
                return $this->tipo_palabra;
                break;
            case 'palabraid':
                return $this->palabra_id;
                break;
            case 'descripcion':
                return $this->descripcion;
                break;
        }
    }

    function guardar() {
        global $DB;
        
        $table = 'vocabulario_mis_intenciones';
        $select = "usuarioid =" . $this->usuarioid . " AND intencionesid = '" . $this->intencionesid . "'";
       
        $ic = $DB->get_record_select($table, $select);

     
        if ($ic->id == null) {
            $this->id = $DB->insert_record('vocabulario_mis_intenciones', $this, true);

        } else {
            $this->id = $ic->id;
            $DB->update_record('vocabulario_mis_intenciones', $this, true);
        }
    }

    function actualizar() {
        global $DB;
        $DB->update_record('vocabulario_mis_intenciones', $this, true);
    }

    function leer($icid, $usuarioid = null) {
        global $DB;
        
        if ($usuarioid == null) {

            $table = 'vocabulario_mis_intenciones';
            $conditions = array('id'=>$icid); 
            $gr = $DB->get_record($table, $conditions);
            $this->usuarioid = $gr->usuarioid;
            $this->descripcion = $gr->descripcion;
            $this->intencionesid = $gr->intencionesid;
            $this->id = $gr->id;
            $this->tipo_palabra = $gr->tipo_palabra;
            $this->palabra_id = $gr->palabra_id;
        } else {

            $table = 'vocabulario_mis_intenciones';
            $select = 'usuarioid =' . $usuarioid . ' AND intencionesid = ' . $icid;
            $gr = $DB->get_record_select($table, $select);
            $this->usuarioid = $gr->usuarioid;
            $this->descripcion = $gr->descripcion;
            $this->intencionesid = $gr->intencionesid;
            $this->id = $gr->id;
            $this->tipo_palabra = $gr->tipo_palabra;
            $this->palabra_id = $gr->palabra_id;
        }
    }
   

    function relacionadas($usuarioid, $intencionid) {
        global $DB;
        $table = 'vocabulario_mis_intenciones';
        $select = 'usuarioid =' . $usuarioid . ' AND intencionesid = ' . $intencionid;           
        $palabras = $DB->get_record_select($table, $select);
        return $palabras;
    }

    function obtener_todas($usuarioid) {
        global $DB;
        $table = 'vocabulario_mis_intenciones';
        $select = 'usuarioid =' . $usuarioid;       
        $ic = $DB->get_records_select($table, $select);
        return $ic;
    }
    
     function recuperar_middles($usuarioid,$middle){
             global $DB;   
           
            $table = 'vocabulario_mis_intenciones';
            $select = "usuarioid =$usuarioid AND descripcion LIKE '%$middle%'";           
            $gr = $DB->get_record_select($table, $select);
            $todos=array();
          
            foreach ($gr as $i) {
                $todo = null;
                $todo->usuarioid = $i->usuarioid;
                $auxtodo = $i->descripcion;
                $var=explode("\$FIELD\$",$auxtodo);
                $descripcion="\$FIELD\$";
               
                for ($k=1;$k<count($var)-1;$k+=4) {
                         
                    if(strpos($var[$k],$middle)!== FALSE){
                        for($j=$k;$j<$k+4;$j++){
                        $descripcion.=$var[$j]."\$FIELD\$";
                        }
                    }
                   
                
                }
                $todo->descripcion=$descripcion;
                $todo->intencionesid = $i->intencionesid;
                $todo->id = $i->id;
                $todo->tipo_palabra = $i->tipo_palabra;
                $todo->palabra_id = $i->palabra_id;
                $todos[]=$todo;
            }
          
            return $todos;
        
    }

}

class Vocabulario_tipologias {

    var $id;
    var $usuarioid;
    var $padre;
    var $tipo;
    var $descripcion;

    function Vocabulario_tipologias($usuarioid = null, $padre = null, $tipo = null, $descripcion = null, $id = null) {
        $this->id = $id;
        $this->usuarioid = $usuarioid;
        $this->padre = $padre;
        $this->tipo = $tipo;
        $this->descripcion = $descripcion;
    }

    function set($id = null, $usuarioid = null, $padre = null, $tipo = null, $descripcion = null) {
        if ($id != null && $id != $this->id) {
            $this->id = $id;
        }
        if ($usuarioid != null && $usuarioid != $this->usuarioid) {
            $this->usuarioid = $usuarioid;
        }
        if ($padre != null && $padre != $this->padre) {
            $this->padre = $padre;
        }
        if ($tipo != null && $tipo != $this->tipo) {
            $this->tipo = $tipo;
        }
        if ($descripcion != null && $descripcion != $this->descripcion) {
            $this->descripcion = $descripcion;
        }
    }

    function get($param) {
        $param = strtolower($param);
        switch ($param) {
            default:
            case 'id':
                return $this->id;
                break;
            case 'usuarioid':
                return $this->usuarioid;
                break;
            case 'padre':
                return $this->padre;
                break;
            case 'tipo':
            case 'palabra':
                return $this->tipo;
                break;
            case 'descripcion':
                return $this->descripcion;
                break;
        }
    }

    function leer($tipoid, $usuarioid) {
        global $DB;        
             
        $sufijotabla = get_sufijo_lenguaje_tabla();
        $table = 'vocabulario_tipologias_'.$sufijotabla;
        $conditions = array('id'=>$tipoid);       
        $ic = $DB->get_record($table, $conditions);
        $this->usuarioid = $ic->usuarioid;
        $this->padre = $ic->padre;
        $this->tipo = $ic->tipo;
        $this->id = $ic->id;
        $this->descripcion = $ic->descripcion;
    }

    function obtener_todos($usuarioid) {

        global $DB;
         
        $sufijotabla = get_sufijo_lenguaje_tabla();
        $table = 'vocabulario_tipologias_'.$sufijotabla;
        $select = 'usuarioid= 0 OR usuarioid=' . $usuarioid ;
        $sort = 'tipo';         
       
        $tipo = $DB->get_records_select($table, $select, null, $sort);
         
        $ic = array();
        $orden = $this->ordena($tipo);
        foreach ($orden as $i) {
            $ic[$tipo[$i]->id] = $tipo[$i]->tipo;
        }
        

        return $ic;
    }

    function obtener_todos_ids($usuarioid) {
        global $DB;
         
        $sufijotabla = get_sufijo_lenguaje_tabla();
        $table = 'vocabulario_tipologias_'.$sufijotabla;
        $select = 'usuarioid= 0 OR usuarioid=' . $usuarioid ;
        $sort = 'tipo';         
       
        $tipo = $DB->get_records_select($table, $select, null, $sort);
         
       
        $ic = array();
        $orden = $this->ordena($tipo);
        foreach ($orden as $i) {
            $ic[$tipo[$i]->id] = $tipo[$i]->id;
        }
        return $ic;
    }

    function ordena($lista, $padre = '0', $salida = '') {
        $milista = array();
        foreach ($lista as $cosa) {
            $milista[$cosa->id] = $cosa->padre;
        }
        $encontrados = array_keys($milista, $padre);
        foreach ($encontrados as $cosa) {
            $salida[] = $cosa;
            $salida = $this->ordena($lista, $cosa, $salida);
        }
        return $salida;
    }

}

class Vocabulario_mis_tipologias {

    var $id;
    var $usuarioid;
    var $tipoid;
    var $descripcion;
    var $tipo_palabra;
    var $palabra_id;

    function Vocabulario_mis_tipologias($usuarioid = null, $tipoid = null, $descripcion = null, $tipo_palabra = null, $palabraid = null, $id = null) {
        $this->id = $id;
        $this->usuarioid = $usuarioid;
        $this->tipoid = $tipoid;
        $this->descripcion = $descripcion;
        $this->tipo_palabra = $tipo_palabra;
        $this->palabra_id = $palabraid;
    }

    function set($usuarioid = null, $tipoid = null, $descripcion = null, $tipo_palabra = null, $palabraid = null, $id = null) {
        if ($id != null && $id != $this->id) {
            $this->id = $id;
        }
        if ($usuarioid != null && $usuarioid != $this->usuarioid) {
            $this->usuarioid = $usuarioid;
        }
        if ($tipoid != null && $tipoid != $this->tipoid) {
            $this->tipoid = $tipoid;
        }
        if ($tipo_palabra != null && $tipo_palabra != $this->tipo_palabra) {
            $this->tipo_palabra = $tipo_palabra;
        }
        if ($palabraid != null && $palabraid != $this->palabraid) {
            $this->palabra_id = $palabraid;
        }
        if ($descripcion != null && $descripcion != $this->descripcion) {
            $this->descripcion = $descripcion;
        }
    }

    function get($param) {
        $param = strtolower($param);
        switch ($param) {
            default:
            case 'id':
                return $this->id;
                break;
            case 'usuarioid':
                return $this->usuarioid;
                break;
            case 'tipoid':
                return $this->tipoid;
                break;
            case 'tipo_palabra':
                return $this->tipo_palabra;
                break;
            case 'palabraid':
                return $this->palabra_id;
                break;
            case 'descripcion':
                return $this->descripcion;
                break;
        }
    }

    function guardar() {

        global $DB;
       
        $this->id = $DB->insert_record('vocabulario_mis_tipologias', $this, true);
        if (!$this->id) { 
            $table = 'vocabulario_mis_tipologias';
	    $select = 'usuarioid=' . $this->usuarioid . ' AND tipoid=' . $this->tipoid;     
	    $ic = $DB->get_records_select($table, $select);	   
            $this->id = $ic->id;
            //if ($this->tipoid != $ic->tipoid) {
            //$this->descripcion = $ic->descripcion;
            $DB->update_record('vocabulario_mis_tipologias', $this, true);
            //}
        }
    }

    function actualizar() {
        global $DB;
        $DB->update_record('vocabulario_mis_tipologias', $this, true);
    }

    function leer($icid, $usrid = null) {
        global $DB;
        if($usrid == null){
            $table = 'vocabulario_mis_tipologias';
            $conditions = array('tipoid'=>$icid);       
            $gr = $DB->get_record($table, $conditions);
            $this->usuarioid = $gr->usuarioid;
            $this->descripcion = $gr->descripcion;
            $this->tipoid = $gr->tipoid;
            $this->id = $gr->id;
            $this->tipo_palabra = $gr->tipo_palabra;
            $this->palabra_id = $gr->palabra_id;
        }else{
            $table = 'vocabulario_mis_tipologias';
	    $select = 'usuarioid=' . $usrid . ' AND tipoid=' . $icid;     
	    $gr = $DB->get_records_select($table, $select);
            $this->usuarioid = $gr->usuarioid;
            $this->descripcion = $gr->descripcion;
            $this->tipoid = $gr->tipoid;
            $this->id = $gr->id;
            $this->tipo_palabra = $gr->tipo_palabra;
            $this->palabra_id = $gr->palabra_id;
        }
    }

    function relacionadas($usuarioid, $tipologiaid) {
        global $DB;
        $table = 'vocabulario_mis_tipologias';
	$select = 'usuarioid=' . $usuarioid . ' AND tipoid=' . $tipologiaid;     
	$palabras = $DB->get_records_select($table, $select);
        return $palabras;
    }

    function obtener_todas($usuarioid) {
        global $DB;
        $table = 'vocabulario_mis_tipologias';
	$select = 'usuarioid=' . $usuarioid;     
	$tt = $DB->get_records_select($table, $select);
        return $tt;
    }

}

class Vocabulario_estrategias {

    var $id;
    var $usuarioid;
    var $padre;
    var $estrategia;
    var $descripcion;

    function Vocabulario_estrategias($usuarioid = null, $padre = null, $estrategia = null, $descripcion = null, $id = null) {
        $this->id = $id;
        $this->usuarioid = $usuarioid;
        $this->padre = $padre;
        $this->estrategia = $estrategia;
        $this->descripcion = $descripcion;
    }

    function set($id = null, $usuarioid = null, $padre = null, $estrategia = null, $descripcion = null) {
        if ($id != null && $id != $this->id) {
            $this->id = $id;
        }
        if ($usuarioid != null && $usuarioid != $this->usuarioid) {
            $this->usuarioid = $usuarioid;
        }
        if ($padre != null && $padre != $this->padre) {
            $this->padre = $padre;
        }
        if ($estrategia != null && $estrategia != $this->estrategia) {
            $this->estrategia = $estrategia;
        }
        if ($descripcion != null && $descripcion != $this->descripcion) {
            $this->descripcion = $descripcion;
        }
    }

    function get($param) {
        $param = strtolower($param);
        switch ($param) {
            default:
            case 'id':
                return $this->id;
                break;
            case 'usuarioid':
                return $this->usuarioid;
                break;
            case 'padre':
                return $this->padre;
                break;
            case 'estrategia':
            case 'palabra':
                return $this->estrategia;
                break;
            case 'descripcion':
                return $this->descripcion;
                break;
        }
    }

    function leer($estrategiaid, $usuarioid) {
        global $DB;
        $table = 'vocabulario_estrategias';
        $conditions = array('id'=>$estrategiaid);       
        $est = $DB->get_record($table, $conditions);
        $this->usuarioid = $est->usuarioid;
        $this->padre = $est->padre;
        $this->estrategia = $est->estrategia;
        $this->id = $est->id;
        $this->descripcion = $est->descripcion;
    }

    function obtener_todos($usuarioid) {
        global $DB;
        $table = 'vocabulario_estrategias';
	$select = 'usuarioid=' . $usuarioid . ' OR usuarioid=0';     
	$estrategia= $DB->get_records_select($table, $select);
        $ea = array();
        $orden = $this->ordena($estrategia);
        foreach ($orden as $e) {
            $ea[$estrategia[$e]->id] = $estrategia[$e]->estrategia;
        }
        return $ea;
    }

    function obtener_todos_ids($usuarioid) {
        global $DB;
        $table = 'vocabulario_estrategias';
	$select = 'usuarioid=' . $usuarioid . ' OR usuarioid=0';     
	$estrategia= $DB->get_records_select($table, $select);
        $ea = array();
        $orden = $this->ordena($estrategia);
        foreach ($orden as $e) {
            $ea[$estrategia[$e]->id] = $estrategia[$e]->id;
        }
        return $ea;
    }

    function ordena($lista, $padre = '0', $salida = '') {
        $milista = array();
        foreach ($lista as $cosa) {
            $milista[$cosa->id] = $cosa->padre;
        }
        $encontrados = array_keys($milista, $padre);
        foreach ($encontrados as $cosa) {
            $salida[] = $cosa;
            $salida = $this->ordena($lista, $cosa, $salida);
        }
        return $salida;
    }

}

class Vocabulario_mis_estrategias {

    var $id;
    var $usuarioid;
    var $estrategiaid;
    var $descripcion;
    var $tipo_palabra;
    var $palabra_id;

    function Vocabulario_mis_estrategias($usuarioid = null, $estrategiaid = null, $descripcion = null, $tipo_palabra = null, $palabraid = null, $id = null) {
        $this->id = $id;
        $this->usuarioid = $usuarioid;
        $this->estrategiaid = $estrategiaid;
        $this->descripcion = $descripcion;
        $this->tipo_palabra = $tipo_palabra;
        $this->palabra_id = $palabraid;
    }

    function set($usuarioid = null, $estrategiaid = null, $descripcion = null, $tipo_palabra = null, $palabraid = null, $id = null) {
        if ($id != null && $id != $this->id) {
            $this->id = $id;
        }
        if ($usuarioid != null && $usuarioid != $this->usuarioid) {
            $this->usuarioid = $usuarioid;
        }
        if ($estrategiaid != null && $estrategiaid != $this->estrategiaid) {
            $this->estrategiaid = $estrategiaid;
        }
        if ($tipo_palabra != null && $tipo_palabra != $this->tipo_palabra) {
            $this->tipo_palabra = $tipo_palabra;
        }
        if ($palabraid != null && $palabraid != $this->palabraid) {
            $this->palabra_id = $palabraid;
        }
        if ($descripcion != null && $descripcion != $this->descripcion) {
            $this->descripcion = $descripcion;
        }
    }

    function get($param) {
        $param = strtolower($param);
        switch ($param) {
            default:
            case 'id':
                return $this->id;
                break;
            case 'usuarioid':
                return $this->usuarioid;
                break;
            case 'estrategiaid':
                return $this->estrategiaid;
                break;
            case 'tipo_palabra':
                return $this->tipo_palabra;
                break;
            case 'palabraid':
                return $this->palabra_id;
                break;
            case 'descripcion':
                return $this->descripcion;
                break;
        }
    }

    function guardar() {
        global $DB;
        

        $this->id = $DB->insert_record('vocabulario_mis_estrategias', $this, true);
        if (!$this->id) {
            $table = 'vocabulario_mis_estrategias';
	    $select = 'usuarioid=' . $this->usuarioid . ' AND estrategiaid=' . $this->estrategiaid;     
	    $ic = $DB->get_records_select($table, $select);
            $this->id = $ic->id;
            $DB->update_record('vocabulario_mis_estrategias', $this, true);
        }
    }

    function actualizar() {
        global $DB;
        $DB->update_record('vocabulario_mis_estrategias', $this, true);
    }

    function leer($eaid) {
        global $DB;
        $table = 'vocabulario_mis_estrategias';
        $conditions = array('estrategiaid'=>$eaid);       
        $gr = $DB->get_record($table, $conditions);
        $this->usuarioid = $gr->usuarioid;
        $this->descripcion = $gr->descripcion;
        $this->estrategiaid = $gr->estrategiaid;
        $this->id = $gr->id;
        $this->tipo_palabra = $gr->tipo_palabra;
        $this->palabra_id = $gr->palabra_id;
    }

    function relacionadas($usuarioid, $estrategiaid) {
        global $DB;
        $table = 'vocabulario_mis_estrategias';
	$select = 'usuarioid=' . $usuarioid . ' AND estrategiaid=' . $estrategiaid;     
	$palabras = $DB->get_records_select($table, $select);
        return $palabras;
    }

    function obtener_todas($usuarioid) {
        global $DB;
        $table = 'vocabulario_mis_estrategias';
	$select = 'usuarioid=' . $usuarioid; 	
        $tt = $DB->get_records_select($table, $select);
        return $tt;
    }

}

?>
