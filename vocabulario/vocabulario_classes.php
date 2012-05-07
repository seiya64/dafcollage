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
  Inmaculada Almahano Güeto
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
    function Vocabulario_sustantivo($pal = ' ', $gen = 2, $plu = '', $sig = '', $obs = '', $grid = 1, $inid = 1, $tipid = 1, $ejemplo = '', $id = 1) {
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
        $sus = get_record('vocabulario_sustantivos', 'id', $sustantivoid);
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
        $vrb = get_record('vocabulario_verbos', 'id', $verboid);
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
        $adj = get_record('vocabulario_adjetivos', 'id', $adjetivoid);
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
        $otr = get_record('vocabulario_otros', 'id', $otroid);
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
        $sufijotabla = get_sufijo_lenguaje_tabla();
        $cl = get_record('vocabulario_camposlexicos_'.$sufijotabla, 'id', $campoid);
        $this->usuarioid = $cl->usuarioid;
        $this->padre = $cl->padre;
        $this->campo = $cl->campo;
        $this->id = $cl->id;
    }

    function obtener_todos($usuarioid) {
        $sufijotabla = get_sufijo_lenguaje_tabla();
        $campos_lexicos = get_records_select('vocabulario_camposlexicos_'.$sufijotabla, 'usuarioid=' . $usuarioid . ' or usuarioid=0');
        $clex = array();
        $orden = $this->ordena($campos_lexicos);
        foreach ($orden as $i) {
            $clex[$campos_lexicos[$i]->id] = $campos_lexicos[$i]->campo;
        }
        return $clex;
    }

    function obtener_hijos($usuarioid, $padreid) {
        $sufijotabla = get_sufijo_lenguaje_tabla();
        $campos_lexicos = get_records_select('vocabulario_camposlexicos_'.$sufijotabla, '(usuarioid=' . $usuarioid . ' or usuarioid=0) and padre=' . $padreid);
        $clex = array();
        $clex[$padreid] = get_string('seleccionar','vocabulario');
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

    function Vocabulario_mis_palabras($usuarioid, $sustantivo, $verbo, $adjetivo, $otro, $campoid = 1, $id = null) {
        $this->usuarioid = $usuarioid;
        $this->sustantivo = $sustantivo;
        $this->sustantivoid = $sustantivo->id;
        $this->adjetivo = $adjetivo;
        $this->adjetivoid = $adjetivo->id;
        $this->verbo = $verbo;
        $this->verboid = $verbo->id;
        $this->otro = $otro;
        $this->otroid = $otro->id;
        $this->campoid = $campoid;
        $camp = new Vocabulario_campo_lexico();
        $camp->leer($campoid);
        $this->campo = $camp;
        $this->id = $id;
    }

    function set($sustantivo = null, $verbo = null, $adjetivo = null, $otro = null) {
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
        $mp = get_record('vocabulario_mis_palabras', 'id', $id);

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
        if ($campo) {
            $todas = get_records_select('vocabulario_mis_palabras', 'usuarioid=' . $usuarioid . ' and campoid=' . $campo, '', 'id');
        } else if ($letra) {
            $todas = array();
            $todas_aux = get_records('vocabulario_mis_palabras', 'usuarioid', $usuarioid, 'campoid');
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
            $todas = get_records('vocabulario_mis_palabras', 'usuarioid', $usuarioid, 'campoid');
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
        $this->leer($id);

        $sql = 'SELECT count(*) num FROM ' . $CFG->prefix . 'vocabulario_mis_palabras WHERE sustantivoid = ' . $this->sustantivoid;
        $numsustantivos = get_records_sql($sql);
        if ($numsustantivos->num == 1) {
            delete_records('vocabulario_sustantivos', 'id', $this->sustantivoid);
        }

        $sql = 'SELECT count(*) num FROM ' . $CFG->prefix . 'vocabulario_mis_palabras WHERE adjetivoid = ' . $this->adjetivoid;
        $numadjetivos = get_records_sql($sql);
        if ($numadjetivos->num == 1) {
            delete_records('vocabulario_adjetivos', 'id', $this->adjetivoid);
        }

        $sql = 'SELECT count(*) num FROM ' . $CFG->prefix . 'vocabulario_mis_palabras WHERE verboid = ' . $this->verboid;
        $numverbos = get_records_sql($sql);
        if ($numverbos->num == 1) {
            delete_records('vocabulario_adjetivos', 'id', $this->verboid);
        }

        $sql = 'SELECT count(*) num FROM ' . $CFG->prefix . 'vocabulario_mis_palabras WHERE otroid = ' . $this->otroid;
        $numotros = get_records_sql($sql);
        if ($numotros->num == 1) {
            delete_records('vocabulario_otros', 'id', $this->otroid);
        }

        delete_records('vocabulario_mis_palabras', 'id', $this->id);
    }

    function guardar() {
        $todas = $this->obtener_todas($this->usuarioid);

        $insertar_sustantivo = true;
        $insertar_adjetivo = true;
        $insertar_verbo = true;
        $insertar_otro = true;

        $insertar_combinacion = true;

        $id_actualizable = 0;

        //de las palabras que tengo guardadas miro a ver cual esta de antes
//        foreach ($todas as $cosa) {
//            if ($cosa->get('sustantivo')->get('palabra') == $this->sustantivo->get('palabra') && $insertar_sustantivo) {
//                $this->sustantivo->set(null, null, null, null, null, null, null, null, null, $cosa->get('sustantivo')->get('id'));
//                update_record('vocabulario_sustantivos', $this->sustantivo, true);
//                $insertar_sustantivo = false;
//            }
//            if ($cosa->get('adjetivo')->get('sin_declinar') == $this->adjetivo->get('sin_declinar') && $insertar_adjetivo) {
//                $this->adjetivo->set(null, null, null, null, null, null, $cosa->get('adjetivo')->get('id'));
//                update_record('vocabulario_adjetivos', $this->adjetivo, true);
//                $insertar_adjetivo = false;
//            }
//            if ($cosa->get('verbo')->get('infinitivo') == $this->verbo->get('infinitivo') && $insertar_verbo) {
//                $this->verbo->set(null, null, null, null, null, null, null, null, null, $cosa->get('verbo')->get('id'));
//                update_record('vocabulario_verbos', $this->verbo, true);
//                $insertar_verbo = false;
//            }
//            if ($cosa->get('otro')->get('palabra') == $this->otro->get('palabra') && $insertar_otro) {
//                $this->otro->set(null, null, null, null, null, null, $cosa->get('otro')->get('id'));
//                update_record('vocabulario_otros', $this->otro, true);
//                $insertar_otro = false;
//            }
//        }

        //inserto nuevas las que tenga que insertar
        if ($insertar_sustantivo && $this->get('sustantivo')->get('palabra')) {
            $id = insert_record('vocabulario_sustantivos', $this->get('sustantivo'), true);
            $this->sustantivo->set(null, null, null, null, null, null, null, null, null, $id);
        }
        if ($insertar_adjetivo && $this->get('adjetivo')->get('sin_declinar')) {
            $id = insert_record('vocabulario_adjetivos', $this->get('adjetivo'), true);
            $this->adjetivo->set(null, null, null, null, null, null, $id);
        }
        if ($insertar_verbo && $this->get('verbo')->get('infinitivo')) {
            $id = insert_record('vocabulario_verbos', $this->get('verbo'), true);
            $this->verbo->set(null, null, null, null, null, null, null, null, null, $id);
        }
        if ($insertar_otro && $this->get('otro')->get('palabra')) {
            $id = insert_record('vocabulario_otros', $this->get('otro'), true);
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
            update_record('vocabulario_mis_palabras', $this, true);
        } else {
            $id_actualizable = insert_record('vocabulario_mis_palabras', $this, true);
            $this->id = $id_actualizable;
        }
    }

    function actualizar() {
        $todas = $this->obtener_todas($this->usuarioid);

        $insertar_sustantivo = true;
        $insertar_adjetivo = true;
        $insertar_verbo = true;
        $insertar_otro = true;

        $insertar_combinacion = true;

        $id_actualizable = 0;

        //de las palabras que tengo guardadas miro a ver cual esta de antes
        foreach ($todas as $cosa) {
            if ($cosa->get('sustantivo')->get('palabra') == $this->sustantivo->get('palabra') && $insertar_sustantivo) {
                $this->sustantivo->set(null, null, null, null, null, null, null, null, null, $cosa->get('sustantivo')->get('id'));
                update_record('vocabulario_sustantivos', $this->sustantivo, true);
                $insertar_sustantivo = false;
            }
            if ($cosa->get('adjetivo')->get('sin_declinar') == $this->adjetivo->get('sin_declinar') && $insertar_adjetivo) {
                $this->adjetivo->set(null, null, null, null, null, null, $cosa->get('adjetivo')->get('id'));
                update_record('vocabulario_adjetivos', $this->adjetivo, true);
                $insertar_adjetivo = false;
            }
            if ($cosa->get('verbo')->get('infinitivo') == $this->verbo->get('infinitivo') && $insertar_verbo) {
                $this->verbo->set(null, null, null, null, null, null, null, null, null, $cosa->get('verbo')->get('id'));
                update_record('vocabulario_verbos', $this->verbo, true);
                $insertar_verbo = false;
            }
            if ($cosa->get('otro')->get('palabra') == $this->otro->get('palabra') && $insertar_otro) {
                $this->otro->set(null, null, null, null, null, null, $cosa->get('otro')->get('id'));
                update_record('vocabulario_otros', $this->otro, true);
                $insertar_otro = false;
            }
        }

        //inserto nuevas las que tenga que insertar
        if ($insertar_sustantivo && $this->get('sustantivo')->get('palabra')) {
            $id = insert_record('vocabulario_sustantivos', $this->get('sustantivo'), true);
            $this->sustantivo->set(null, null, null, null, null, null, null, null, null, $id);
        }
        if ($insertar_adjetivo && $this->get('adjetivo')->get('sin_declinar')) {
            $id = insert_record('vocabulario_adjetivos', $this->get('adjetivo'), true);
            $this->adjetivo->set(null, null, null, null, null, null, $id);
        }
        if ($insertar_verbo && $this->get('verbo')->get('infinitivo')) {
            $id = insert_record('vocabulario_verbos', $this->get('verbo'), true);
            $this->verbo->set(null, null, null, null, null, null, null, null, null, $id);
        }
        if ($insertar_otro && $this->get('otro')->get('palabra')) {
            $id = insert_record('vocabulario_otros', $this->get('otro'), true);
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
            if ($cosa->get('adjetivo')->get('id') == $this->get('adjetivo')->get('id') || $cosa->get('adjetivo')->get('id') == 1) {
                $actualizable2 = true;
            }
            if ($cosa->get('verbo')->get('id') == $this->get('verbo')->get('id') || $cosa->get('verbo')->get('id') == 1) {
                $actualizable3 = true;
            }
            if ($cosa->get('otro')->get('id') == $this->get('otro')->get('id') || $cosa->get('otro')->get('id') == 1) {
                $actualizable4 = true;
            }

            if ($actualizable1 && $actualizable2 && $actualizable3 && $actualizable4 && !$id_actualizable) {
                $id_actualizable = $cosa->get('id');
            }
        }

        $this->sustantivoid = $this->sustantivo->id;
        $this->adjetivoid = $this->adjetivo->id;
        $this->verboid = $this->verbo->id;
        $this->otroid = $this->otro->id;

        update_record('vocabulario_mis_palabras', $this, true);
    }

    function combinaciones_completas($usuarioid) {
        $combinaciones = get_records_sql('call todas_palabras(' . $usuarioid . ')');
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
        $gr = get_record('vocabulario_gramatica', 'id', $gramaticaid);
        $this->usuarioid = $gr->usuarioid;
        $this->padre = $gr->padre;
        $this->gramatica = $gr->gramatica;
        $this->descripcion = $gr->descripcion;
        $this->id = $gr->id;
    }

    function obtener_hijos($usuarioid, $padreid) {
        $gramaticas = get_records_select('vocabulario_gramatica', '(usuarioid=' . $usuarioid . ' or usuarioid=0) and padre=' . $padreid);
        $gr = array();
        $gr[$padreid] = get_string('seleccionar','vocabulario');
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
        $gramaticas = get_records_select('vocabulario_gramatica', 'usuarioid=' . $usuarioid . ' or usuarioid=0');
        $gr = array();
        $orden = $this->ordena($gramaticas);
        foreach ($orden as $i) {
            $gr[$gramaticas[$i]->id] = $gramaticas[$i]->gramatica;
        }
        return $gr;
    }

    function obtener_todos_ids($usuarioid) {
        $gramaticas = get_records_select('vocabulario_gramatica', 'usuarioid=' . $usuarioid . ' or usuarioid=0');
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
        $gr = get_record_select('vocabulario_mis_gramaticas', 'usuarioid=' . $this->usuarioid . ' and gramaticaid=\'' . $this->gramaticaid . '\'');
        if ($gr->id == null) {
            $this->id = insert_record('vocabulario_mis_gramaticas', $this, true);
        } else {
            $this->id = $gr->id;
            update_record('vocabulario_mis_gramaticas', $this, true);
        }
    }

    function actualizar() {
        update_record('vocabulario_mis_gramaticas', $this, true);
    }

    function leer($grid, $usuarioid = null) {
        $gr = get_record('vocabulario_mis_gramaticas', 'gramaticaid', $grid, 'usuarioid', $usuarioid);
        $this->usuarioid = $gr->usuarioid;
        $this->descripcion = $gr->descripcion;
        $this->gramaticaid = $gr->gramaticaid;
        $this->id = $gr->id;
        $this->tipo_palabra = $gr->tipo_palabra;
        $this->palabra_id = $gr->palabra_id;
    }

    function relacionadas($usuarioid, $gramaticaid) {
        $palabras = get_records_select('vocabulario_mis_gramaticas', 'usuarioid=' . $usuarioid . ' and gramaticaid=' . $gramaticaid);
        return $palabras;
    }

}

class Vocabulario_intenciones {

    var $id;
    var $usuarioid;
    var $padre;
    var $intencion;

    function Vocabulario_intenciones($usuarioid = null, $padre = null, $intencion = null, $id = null) {
        $this->id = $id;
        $this->usuarioid = $usuarioid;
        $this->padre = $padre;
        $this->intencion = $intencion;
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
            case 'intencion':
            case 'palabra':
                return $this->intencion;
                break;
        }
    }

    function leer($intencionid, $usuarioid) {
        $sufijotabla = get_sufijo_lenguaje_tabla();
        $ic = get_record('vocabulario_intenciones_'.$sufijotabla, 'id', $intencionid);
        $this->usuarioid = $ic->usuarioid;
        $this->padre = $ic->padre;
        $this->intencion = $ic->intencion;
        $this->id = $ic->id;
    }

    function obtener_todos($usuarioid) {
        $sufijotabla = get_sufijo_lenguaje_tabla();
        $intenciones = get_records_select('vocabulario_intenciones_'.$sufijotabla, 'usuarioid=' . $usuarioid . ' or usuarioid=0');
        $ic = array();
        $orden = $this->ordena($intenciones);
        foreach ($orden as $i) {
            $ic[$intenciones[$i]->id] = $intenciones[$i]->intencion;
        }
        return $ic;
    }

    function obtener_todos_ids($usuarioid) {
        $sufijotabla = get_sufijo_lenguaje_tabla();
        $intenciones = get_records_select('vocabulario_intenciones_'.$sufijotabla, 'usuarioid=' . $usuarioid . ' or usuarioid=0');
        $ic = array();
        $orden = $this->ordena($intenciones);
        foreach ($orden as $i) {
            $ic[$intenciones[$i]->id] = $intenciones[$i]->id;
        }
        return $ic;
    }

    function obtener_hijos($usuarioid, $padreid) {
        $sufijotabla = get_sufijo_lenguaje_tabla();
        $intenciones = get_records_select('vocabulario_intenciones_'.$sufijotabla, '(usuarioid=' . $usuarioid . ' or usuarioid=0) and padre=' . $padreid);
        $ic = array();
        $ic[$padreid] = get_string('seleccionar','vocabulario');
        $orden = $this->ordena($intenciones, $padreid);
        foreach ($orden as $i) {
            $ic[$intenciones[$i]->id] = $intenciones[$i]->intencion;
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
        $encontrados = array_keys($milista, $padre);
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
        $ic = get_record_select('vocabulario_mis_intenciones', 'usuarioid=' . $this->usuarioid . ' and intencionesid=\'' . $this->intencionesid . '\'');
        if ($ic->id == null) {
            $this->id = insert_record('vocabulario_mis_intenciones', $this, true);
        } else {
            $this->id = $ic->id;
            update_record('vocabulario_mis_intenciones', $this, true);
        }
    }

    function actualizar() {
        update_record('vocabulario_mis_intenciones', $this, true);
    }

    function leer($icid, $usuarioid = null) {
        if ($usuarioid == null) {
            $gr = get_record('vocabulario_mis_intenciones', 'id', $icid);
            $this->usuarioid = $gr->usuarioid;
            $this->descripcion = $gr->descripcion;
            $this->intencionesid = $gr->intencionesid;
            $this->id = $gr->id;
            $this->tipo_palabra = $gr->tipo_palabra;
            $this->palabra_id = $gr->palabra_id;
        } else {
            $gr = get_record_select('vocabulario_mis_intenciones', 'usuarioid=' . $usuarioid . ' and intencionesid=' . $icid);
            $this->usuarioid = $gr->usuarioid;
            $this->descripcion = $gr->descripcion;
            $this->intencionesid = $gr->intencionesid;
            $this->id = $gr->id;
            $this->tipo_palabra = $gr->tipo_palabra;
            $this->palabra_id = $gr->palabra_id;
        }
    }

    function relacionadas($usuarioid, $intencionid) {
        $palabras = get_records_select('vocabulario_mis_intenciones', 'usuarioid=' . $usuarioid . ' and intencionesid=' . $intencionid);
        return $palabras;
    }

    function obtener_todas($usuarioid) {
        $ic = get_records_select('vocabulario_mis_intenciones', 'usuarioid=' . $usuarioid);
        return $ic;
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
        $sufijotabla = get_sufijo_lenguaje_tabla();
        $ic = get_record('vocabulario_tipologias_'.$sufijotabla, 'id', $tipoid);
        $this->usuarioid = $ic->usuarioid;
        $this->padre = $ic->padre;
        $this->tipo = $ic->tipo;
        $this->id = $ic->id;
        $this->descripcion = $ic->descripcion;
    }

    function obtener_todos($usuarioid) {
        $sufijotabla = get_sufijo_lenguaje_tabla();
        $tipo = get_records_select('vocabulario_tipologias_'.$sufijotabla, 'usuarioid=' . $usuarioid . ' or usuarioid=0');
        $ic = array();
        $orden = $this->ordena($tipo);
        foreach ($orden as $i) {
            $ic[$tipo[$i]->id] = $tipo[$i]->tipo;
        }
        return $ic;
    }

    function obtener_todos_ids($usuarioid) {
        $sufijotabla = get_sufijo_lenguaje_tabla();
        $tipo = get_records_select('vocabulario_tipologias_'.$sufijotabla, 'usuarioid=' . $usuarioid . ' or usuarioid=0');
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
        /* $this->id = insert_record('vocabulario_mis_tipologias', $this, true);
          if (!$this->id) {
          $ic = get_record_select('vocabulario_mis_tipologias', 'usuarioid=' . $this->usuarioid . ' and tipo_palabra=\'' . $this->tipo_palabra . '\' and palabra_id=' . $this->palabra_id);
          $this->id = $ic->id;
          if ($this->tipoid != $ic->tipoid) {
          $this->descripcion = $ic->descripcion;
          update_record('vocabulario_mis_tipologias', $this, true);
          }
          } */
        $this->id = insert_record('vocabulario_mis_tipologias', $this, true);
        if (!$this->id) {
            $ic = get_record_select('vocabulario_mis_tipologias', 'usuarioid=' . $this->usuarioid . ' and tipoid=' . $this->tipoid);
            $this->id = $ic->id;
            //if ($this->tipoid != $ic->tipoid) {
            //$this->descripcion = $ic->descripcion;
            update_record('vocabulario_mis_tipologias', $this, true);
            //}
        }
    }

    function actualizar() {
        update_record('vocabulario_mis_tipologias', $this, true);
    }

    function leer($icid, $usrid = null) {
        if($usrid == null){
            $gr = get_record('vocabulario_mis_tipologias', 'tipoid', $icid);
            $this->usuarioid = $gr->usuarioid;
            $this->descripcion = $gr->descripcion;
            $this->tipoid = $gr->tipoid;
            $this->id = $gr->id;
            $this->tipo_palabra = $gr->tipo_palabra;
            $this->palabra_id = $gr->palabra_id;
        }else{
            $gr = get_record_select('vocabulario_mis_tipologias', 'usuarioid=' . $usrid . ' and tipoid=' . $icid);
            $this->usuarioid = $gr->usuarioid;
            $this->descripcion = $gr->descripcion;
            $this->tipoid = $gr->tipoid;
            $this->id = $gr->id;
            $this->tipo_palabra = $gr->tipo_palabra;
            $this->palabra_id = $gr->palabra_id;
        }
    }

    function relacionadas($usuarioid, $tipologiaid) {
        $palabras = get_records_select('vocabulario_mis_tipologias', 'usuarioid=' . $usuarioid . ' and tipoid=' . $tipologiaid);
        return $palabras;
    }

    function obtener_todas($usuarioid) {
        $tt = get_records_select('vocabulario_mis_tipologias', 'usuarioid=' . $usuarioid);
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
        $est = get_record('vocabulario_estrategias', 'id', $estrategiaid);
        $this->usuarioid = $est->usuarioid;
        $this->padre = $est->padre;
        $this->estrategia = $est->estrategia;
        $this->id = $est->id;
        $this->descripcion = $est->descripcion;
    }

    function obtener_todos($usuarioid) {
        $estrategia = get_records_select('vocabulario_estrategias', 'usuarioid=' . $usuarioid . ' or usuarioid=0');
        $ea = array();
        $orden = $this->ordena($estrategia);
        foreach ($orden as $e) {
            $ea[$estrategia[$e]->id] = $estrategia[$e]->estrategia;
        }
        return $ea;
    }

    function obtener_todos_ids($usuarioid) {
        $estrategia = get_records_select('vocabulario_estrategias', 'usuarioid=' . $usuarioid . ' or usuarioid=0');
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

        $this->id = insert_record('vocabulario_mis_estrategias', $this, true);
        if (!$this->id) {
            $ic = get_record_select('vocabulario_mis_estrategias', 'usuarioid=' . $this->usuarioid . ' and estrategiaid=' . $this->estrategiaid);
            $this->id = $ic->id;
            update_record('vocabulario_mis_estrategias', $this, true);
        }
    }

    function actualizar() {
        update_record('vocabulario_mis_estrategias', $this, true);
    }

    function leer($eaid) {
        $gr = get_record('vocabulario_mis_estrategias', 'estrategiaid', $eaid);
        $this->usuarioid = $gr->usuarioid;
        $this->descripcion = $gr->descripcion;
        $this->estrategiaid = $gr->estrategiaid;
        $this->id = $gr->id;
        $this->tipo_palabra = $gr->tipo_palabra;
        $this->palabra_id = $gr->palabra_id;
    }

    function relacionadas($usuarioid, $estrategiaid) {
        $palabras = get_records_select('vocabulario_mis_estrategias', 'usuarioid=' . $usuarioid . ' and estrategiaid=' . $estrategiaid);
        return $palabras;
    }

    function obtener_todas($usuarioid) {
        $tt = get_records_select('vocabulario_mis_estrategias', 'usuarioid=' . $usuarioid);
        return $tt;
    }

}

?>
