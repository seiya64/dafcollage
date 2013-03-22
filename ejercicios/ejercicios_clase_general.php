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

class Ejercicios_general {

    var $id;
    var $id_curso;
    var $id_creador;
    var $tipoactividad;
    var $tipoarchivopregunta;
    var $tipoarchivorespuesta;
    var $visible;
    var $publico;
    var $carpeta;
    var $campotematico;
    var $destreza;
    var $temagramatical;
    var $intencioncomunicativa;
    var $tipologiatextual;
    var $name;
    var $descripcion;
    var $numpreg;
    var $copyrightpreg;
    var $copyrightresp;

    //Contructor
    function Ejercicios_general($id = NULL, $id_curso = NULL, $id_creador = NULL, $tipoactividad = NULL, $tipoarchivopregunta = NULL, $tipoarchivorespuesta = NULL, $visible = NULL, $publico = NULL, $carpeta = NULL, $campotematico = NULL, $destreza = NULL, $temagramatical = NULL, $intencioncomunicativa = NULL, $tipologiatextual = NULL, $name = NULL, $descripcion = NULL, $numpreg = NULL,$copyrightpreg=NULL,$copyrightresp=NULL) {


        $this->id = $id;
        $this->id_curso = $id_curso;
        $this->id_creador = $id_creador;
        $this->tipoactividad = $tipoactividad;
        $this->tipoarchivopregunta = $tipoarchivopregunta;
        $this->tipoarchivorespuesta = $tipoarchivorespuesta;
        $this->visible = $visible;
        $this->publico = $publico;
        $this->carpeta = $carpeta;
        $this->campotematico = $campotematico;
        $this->destreza = $destreza;
        $this->temagramatical = $temagramatical;
        $this->intencioncomunicativa = $intencioncomunicativa;
        $this->tipologiatextual = $tipologiatextual;
        $this->name = $name;
        $this->descripcion = $descripcion;
        $this->numpreg = $numpreg;
        $this->copyrightpreg=$copyrightpreg;
        $this->copyrightresp=$copyrightresp;
       
    }

    function get($param) {

        // $param = strtolower($param);
        switch ($param) {
            default:
            case 'id':
                return $this->id;
                break;
            case 'id_curso':
                return $this->id_curso;
                break;
            case 'id_creador':
                return $this->id_creador;
                break;
            case 'tipoactividad':
                return $this->tipoactividad;
                break;
            case 'tipoarchivopregunta':
                return $this->tipoarchivopregunta;
                break;
             case 'tipoarchivorespuesta':
                return $this->tipoarchivorespuesta;
                break;
            case 'visible':
                return $this->visible;
                break;
            case 'campotematico':
                return $this->campotematico;
                break;
            case 'destreza':
                return $this->destreza;
                break;
            case 'temagramatical':
                return $this->temagramatical;
                break;
            case 'intencioncomunicativa':
                return $this->intencioncomunicativa;
                break;
            case 'tipologiatextual':
                return $this->tipologiatextual;
                break;
            case 'name':
                return $this->name;
                break;
            case 'descripcion':
                return $this->descripcion;
                break;
            case 'numpreg':
                return $this->numpreg;
                break;
            case 'copyrightresp':
                return $this->copyrightresp;
                break;
            case 'copyrightpreg':
                return $this->copyrightpreg;
                break;
        }
    }

     function set_numpregunta($param) {
         $this->numpreg=$param;
     }

    function insertar() {
        
      // nl2br
        
        //insert_record('ejercicios_tipo_puzzledoble',"pepe",true,'id');
        $this->id = insert_record('ejercicios_general', $this, true);
        //Devuelve el identificador del ejercicios creado
	
        return $this->id;
    }

    function borrar($id) {
        //insert_record('ejercicios_tipo_puzzledoble',"pepe",true,'id');

        delete_records('ejercicios_general', 'id', $id);
    }

    function alterar() {

        //insert_record('ejercicios_tipo_puzzledoble',"pepe",true,'id');
        update_record('ejercicios_general', $this, false);
    }

    function obtener_uno($id) {
        $ejer = get_record('ejercicios_general', 'id', $id);
        $this->id = $ejer->id;
        $this->id_curso = $ejer->id_curso;
        $this->id_creador = $ejer->id_creador;
        $this->tipoactividad = $ejer->tipoactividad;
        $this->tipoarchivopregunta = $ejer->tipoarchivopregunta;
        $this->tipoarchivorespuesta = $ejer->tipoarchivorespuesta;
        $this->visible = $ejer->visible;
        $this->publico = $ejer->publico;
        $this->carpeta = $ejer->carpeta;
        $this->campotematico = $ejer->campotematico;
        $this->destreza = $ejer->destreza;
        $this->temagramatical = $ejer->temagramatical;
        $this->intencioncomunicativa = $ejer->intencioncomunicativa;
        $this->tipologiatextual = $ejer->tipologiatextual;
        $this->name = $ejer->name;
        $this->descripcion = $ejer->descripcion;
        $this->numpreg = $ejer->numpreg;
         $this->copyrightpreg = $ejer->copyrightpreg;
        $this->copyrightresp = $ejer->copyrightresp;
        return $this;
    }

    function obtener_uno_name($name) {

        $ejer = get_record('ejercicios_general', 'name', $name);
        $this->id = $ejer->id;
        $this->id_curso = $ejer->id_curso;
        $this->id_creador = $ejer->id_creador;
        $this->tipoactividad = $ejer->tipoactividad;
        $this->tipoarchivopregunta = $ejer->tipoarchivopregunta;
        $this->tipoarchivorespuesta = $ejer->tipoarchivorespuesta;
        $this->visible = $ejer->visible;
        $this->publico = $ejer->publico;
        $this->carpeta = $ejer->carpeta;
        $this->campotematico = $ejer->campotematico;
        $this->destreza = $ejer->destreza;
        $this->temagramatical = $ejer->temagramatical;
        $this->intencioncomunicativa = $ejer->intencioncomunicativa;
        $this->tipologiatextual = $ejer->tipologiatextual;
        $this->name = $ejer->name;
        $this->descripcion = $ejer->descripcion;
        $this->numpreg = $ejer->numpreg;
        $this->copyrightpreg = $ejer->copyrightpreg;
        $this->copyrightresp = $ejer->copyrightresp;
        return $this;
    }

    function obtener_ejercicios_curso($id) {

        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  id_curso=' . $id;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }
    
       function obtener_ejercicios_tipo_publicos($tipoactividad) {

        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  tipoactividad=' . $tipoactividad . ' AND publico=1';

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }


    function buscar_campotematico($campotematico) {


        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE campotematico=' . $campotematico;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_destreza($destreza) {


        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE destreza=' . $destreza;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_temagramatical($temagramatical) {


        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE temagramatical=' . $temagramatical;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_intencioncomunicativa($intencioncomunicativa) {


        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE intencioncomunicativa=' . $intencioncomunicativa;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_tipologiatextual($tipologiatextual) {


        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE tipologiatextual=' . $tipologiatextual;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_todas_clasificaciones($ccl, $cta, $cdc, $cgr, $cic, $ctt, $userid) {


        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND tipoactividad=' . $cta . ' AND destreza=' . $cdc . ' AND temagramatical=' . $cgr . ' AND intencioncomunicativa=' . $cic . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_sin_ta($ccl, $cdc, $cgr, $cic, $ctt) {

        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND destreza=' . $cdc . ' AND temagramatical=' . $cgr . ' AND intencioncomunicativa=' . $cic . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }
    
    function clasif_sin_ta_dc($ccl,$cgr,$cic,$ctt){
        
         $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND temagramatical=' . $cgr . ' AND intencioncomunicativa=' . $cic . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
        
    }
    
    function buscar_sin_ta_dc_gr($ccl,$cic,$ctt){
        
             $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND intencioncomunicativa=' . $cic . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
        
    }
    
    
    function buscar_clasif_sin_ta_dc_gr_tt($ccl,$cic){
        
               $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND intencioncomunicativa=' . $cic;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
        
    }
    
    function buscar_clasif_sin_ta_dc_gr_ic($ccl,$ctt){
         $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }
    
    function buscar_clasif_sin_ta_dc_gr_ic_tt($ccl){
        
        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }
    
    function buscar_clasif_sin_ta_cl($cdc,$cgr,$cic,$ctt){
        
        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE ' . 'destreza=' . $cdc . ' AND temagramatical=' . $cgr . ' AND intencioncomunicativa=' . $cic . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }
    
    function buscar_clasif_sin_ta_cl_tt($cdc,$cgr,$cic){
        
        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE ' . 'destreza=' . $cdc . ' AND temagramatical=' . $cgr . ' AND intencioncomunicativa=' . $cic;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }
    
    
    function buscar_clasif_sin_ta_cl_ic($cdc,$cgr,$ctt){
         $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE ' . 'destreza=' . $cdc . ' AND temagramatical=' . $cgr . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }
    
     function buscar_clasif_sin_ta_cl_ic_tt($cdc,$cgr){
         $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE ' . 'destreza=' . $cdc . ' AND temagramatical=' . $cgr;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }
    
    function buscar_sin_ta_cl_gr($cdc,$cic,$ctt){
         $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE ' . 'destreza=' . $cdc . ' AND intencioncomunicativa=' . $cic . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }
    
    
    function buscar_clasif_sin_ta_cl_gr_tt($cdc,$cic){
         $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE ' . 'destreza=' . $cdc . ' AND intencioncomunicativa=' . $cic;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }
    
    function buscar_clasif_sin_ta_cl_gr_ic($cdc,$ctt){
         $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE ' . 'destreza=' . $cdc . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }
    function buscar_clasif_sin_ta_cl_gr_ic_tt($cdc){
       
         $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE ' . 'destreza=' . $cdc;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
        
    }
    
    function buscar_clasif_sin_ta_cl_dc($cgr,$cic,$ctt){
        
          $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE ' .'temagramatical=' . $cgr . ' AND intencioncomunicativa=' . $cic . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }
    
    function buscar_clasif_sin_ta_cl_dc_tt($cgr,$cic){
        
               $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE ' .'temagramatical=' . $cgr . ' AND intencioncomunicativa=' . $cic;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
        
    }
    
    function buscar_clasif_sin_ta_cl_dc_ic($cgr,$ctt){
        
        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE ' .'temagramatical=' . $cgr . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }
    
    function buscar_clasif_sin_ta_cl_dc_ic_tt($cgr){
        
         $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE ' .'temagramatical=' . $cgr;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }
    
    function buscar_sin_ta_cl_dc_gr($cic,$ctt){
        
     
        
        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE ' .'intencioncomunicativa=' . $cic . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }
    
    
    function buscar_clasif_sin_ta_cl_dc_gr_tt($cic){
        
          $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE ' .'intencioncomunicativa=' . $cic;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
        
    }
    
    function buscar_clasif_sin_ta_cl_dc_gr_ic($ctt){
        
           $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE ' . 'tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
        
    }
    function buscar_clasif_sin_ta_dc_ic($ccl,$cgr,$ctt){
        
        
         $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND temagramatical=' . $cgr .' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
        
    }
    
    function buscar_clasif_sin_ta_dc_ic_tt($ccl,$cgr){
        
                
         $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND temagramatical=' . $cgr;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
        
    }
    
    function buscar_clasif_sin_ta_dc_tt($ccl,$cgr,$cic){
        
          $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND temagramatical=' . $cgr . ' AND intencioncomunicativa=' . $cic;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
        
    }
    
    function buscar_clasif_sin_ta_ic($ccl,$cdc,$cgr,$ctt){
        
        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND destreza=' . $cdc . ' AND temagramatical=' . $cgr . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_clasif_sin_ta_ic_tt($ccl,$cdc,$cgr){
        
         $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND destreza=' . $cdc . ' AND temagramatical=' . $cgr ;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
        
    }
    
    function buscar_sin_ta_gr($ccl,$cdc,$cic,$ctt){
         $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND destreza=' . $cdc . ' AND intencioncomunicativa=' . $cic . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }
    
    function buscar_clasif_sin_ta_gr_tt($ccl,$cdc,$cic){
        
             $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND destreza=' . $cdc . ' AND intencioncomunicativa=' . $cic;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }
    
    function buscar_clasif_sin_ta_gr_ic($ccl,$cdc,$ctt){
        
      $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND destreza=' . $cdc . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }
    
    function buscar_clasif_sin_ta_gr_ic_tt($ccl,$cdc){
        
                
      $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND destreza=' . $cdc;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
        
    }
    
    
    function buscar_clasif_sin_ta_tt($ccl,$cdc,$cgr,$cic){
       
          $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND destreza=' . $cdc . ' AND temagramatical=' . $cgr . ' AND intencioncomunicativa=' . $cic;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }
    
    function buscar_clasif_sin_tt($ccl, $cta, $cdc, $cgr, $cic) {


        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND tipoactividad=' . $cta . ' AND destreza=' . $cdc . ' AND temagramatical=' . $cgr . ' AND intencioncomunicativa=' . $cic;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_clasif_sin_ic($ccl, $cta, $cdc, $cgr, $ctt) {


        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND tipoactividad=' . $cta . ' AND destreza=' . $cdc . ' AND temagramatical=' . $cgr . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_clasif_sin_ic_tt($ccl, $cta, $cdc, $cgr) {


        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND tipoactividad=' . $cta . ' AND destreza=' . $cdc . ' AND temagramatical=' . $cgr;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_sin_gr($ccl, $cta, $cdc, $cic, $ctt) {


        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND tipoactividad=' . $cta . ' AND destreza=' . $cdc . ' AND intencioncomunicativa=' . $cic . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_clasif_sin_gr_tt($ccl, $cta, $cdc, $cic) {

        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND tipoactividad=' . $cta . ' AND destreza=' . $cdc . ' AND intencioncomunicativa=' . $cic;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_clasif_sin_gr_ic($ccl, $cta, $cdc, $ctt) {

        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND tipoactividad=' . $cta . ' AND destreza=' . $cdc . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_clasif_sin_gr_ic_tt($ccl, $cta, $cdc) {

        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND tipoactividad=' . $cta . ' AND destreza=' . $cdc;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function clasif_sin_dc($ccl, $cta, $cgr, $cic, $ctt) {

        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND tipoactividad=' . $cta . ' AND temagramatical=' . $cgr . ' AND intencioncomunicativa=' . $cic . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_clasif_sin_dc_tt($ccl, $cta, $cgr, $cic) {

    
        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND tipoactividad=' . $cta . ' AND temagramatical=' . $cgr . ' AND intencioncomunicativa=' . $cic;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_clasif_sin_dc_ic($ccl, $cta, $cgr, $ctt) {
        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND tipoactividad=' . $cta . ' AND temagramatical=' . $cgr . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_clasif_sin_dc_ic_tt($ccl, $cta, $cgr) {

        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND tipoactividad=' . $cta . ' AND temagramatical=' . $cgr;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_sin_dc_gr($ccl, $cta, $cic, $ctt) {
        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND tipoactividad=' . $cta . ' AND intencioncomunicativa=' . $cic . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_clasif_sin_dc_gr_tt($ccl, $cta, $cic) {

        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND tipoactividad=' . $cta . ' AND intencioncomunicativa=' . $cic;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_clasif_sin_dc_gr_ic($ccl, $cta, $ctt) {
        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND tipoactividad=' . $cta . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_clasif_sin_dc_gr_ic_tt($ccl, $cta) {

        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  campotematico=' . $ccl . ' AND tipoactividad=' . $cta;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_clasif_sin_cl($cta, $cdc, $cgr, $cic, $ctt) {

        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  tipoactividad=' . $cta . ' AND destreza=' . $cdc . ' AND temagramatical=' . $cgr . ' AND intencioncomunicativa=' . $cic . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_clasif_sin_cl_tt($cta, $cdc, $cgr, $cic) {

        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  tipoactividad=' . $cta . ' AND destreza=' . $cdc . ' AND temagramatical=' . $cgr . ' AND intencioncomunicativa=' . $cic;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_clasif_sin_cl_ic($cta, $cdc, $cgr, $ctt) {
        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  tipoactividad=' . $cta . ' AND destreza=' . $cdc . ' AND temagramatical=' . $cgr . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_clasif_sin_cl_ic_tt($cta, $cdc, $cgr) {

        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  tipoactividad=' . $cta . ' AND destreza=' . $cdc . ' AND temagramatical=' . $cgr;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_sin_cl_gr($cta, $cdc, $cic, $ctt) {
        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE tipoactividad=' . $cta . ' AND destreza=' . $cdc . ' AND intencioncomunicativa=' . $cic . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_clasif_sin_cl_gr_tt($cta, $cdc, $cic) {

        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE tipoactividad=' . $cta . ' AND destreza=' . $cdc . ' AND intencioncomunicativa=' . $cic;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_clasif_sin_cl_gr_ic($cta, $cdc, $ctt) {

        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE tipoactividad=' . $cta . ' AND destreza=' . $cdc . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_clasif_sin_cl_gr_ic_tt($cta, $cdc, $userid) {

       
        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE tipoactividad=' . $cta . ' AND destreza=' . $cdc . ' AND (publico=1 OR id_creador=' . $userid . ')';
       
        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }

    
        return $todos_mis_ejercicios;
    }

    function buscar_clasif_sin_cl_dc($cta, $cgr, $cic, $ctt) {

        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  tipoactividad=' . $cta . ' AND temagramatical=' . $cgr . ' AND intencioncomunicativa=' . $cic . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_clasif_sin_cl_dc_tt($cta, $cgr, $cic) {

        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  tipoactividad=' . $cta . ' AND temagramatical=' . $cgr . ' AND intencioncomunicativa=' . $cic;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_clasif_sin_cl_dc_ic($cta, $cgr, $ctt) {

        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  tipoactividad=' . $cta . ' AND temagramatical=' . $cgr . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_clasif_sin_cl_dc_ic_tt($cta, $cgr) {

        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  tipoactividad=' . $cta . ' AND temagramatical=' . $cgr;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_sin_cl_dc_gr($cta, $cic, $ctt) {

        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  tipoactividad=' . $cta . ' AND intencioncomunicativa=' . $cic . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_clasif_sin_cl_dc_gr_tt($cta, $cic) {

        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  tipoactividad=' . $cta . ' AND intencioncomunicativa=' . $cic;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_clasif_sin_cl_dc_gr_ic($cta, $ctt) {


        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  tipoactividad=' . $cta . ' AND tipologiatextual=' . $ctt;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function buscar_clasif_sin_cl_dc_gr_ic_tt($cta) {

        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  tipoactividad=' . $cta;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function obtener_todos() {


        $sql = 'SELECT * FROM  mdl_ejercicios_general';

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

}

/**
 * Clase que gestiona la tabla de la base de datos mdl_ejercicios_prof_actividad
 */
class Ejercicios_prof_actividad {

    var $id;
    var $id_profesor;
    var $id_ejercicio;
    var $carpeta;

    //Contructor
    function Ejercicios_prof_actividad($id = NULL, $id_profesor = NULL, $id_ejercicio = NULL, $carpeta = NULL) {

        $this->id = $id;
        $this->id_profesor = $id_profesor;
        $this->id_ejercicio = $id_ejercicio;
        $this->carpeta = $carpeta;
        // return $this;
    }

    function get($param) {

        // $param = strtolower($param);
        switch ($param) {
            default:
            case 'id':
                return $this->id;
                break;
            case 'id_profesor':
              
                return $this->id_profesor;
                break;
            case 'id_ejercicio':

                return $this->id_ejercicio;
                break;
            case 'carpeta':

                return $this->carpeta;
                break;
        }
    }

    function insertar() {
        //insert_record('ejercicios_tipo_puzzledoble',"pepe",true,'id');
        insert_record('ejercicios_prof_actividad', $this, true);
    }

    function borrar() {
        //insert_record('ejercicios_tipo_puzzledoble',"pepe",true,'id');
        delete_record('ejercicios_prof_actividad', $this, true);
    }

    function borrar_id_ejercicio($id_ejercicio, $id_profesor) {
        //insert_record('ejercicios_tipo_puzzledoble',"pepe",true,'id');

        delete_records('ejercicios_prof_actividad', 'id_profesor', $id_profesor, 'id_ejercicio', $id_ejercicio);
    }

    function alterar() {

        //insert_record('ejercicios_tipo_puzzledoble',"pepe",true,'id');
        update_record('ejercicios_prof_actividad', $this, false);
    }

    function obtener_uno($id) {
        $ejer = get_record('ejercicios_prof_actividad', 'id', $id);
        $this->id = $ejer->id;
        $this->id_profesor = $ejer->id_profesor;
        $this->id_ejercicio = $ejer->id_ejercicio;

        $this->carpeta = $ejer->carpeta;

        return $this;
    }

    function obtener_uno_idejercicio($id_ejercicio) {

        $ejer = get_record('ejercicios_prof_actividad', 'id_ejercicio', $id_ejercicio);
        $this->id = $ejer->id;
        $this->id_profesor = $ejer->id_profesor;
        $this->id_ejercicio = $ejer->id_ejericio;
        $this->carpeta = $ejer->carpeta;

        return $this;
    }

    function obtener_todos_idejercicio($id_ejercicio) {

       

        $sql = 'SELECT * FROM  mdl_ejercicios_prof_actividad WHERE id_ejercicio=' . $id_ejercicio;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_prof_actividad();

            $mp->obtener_uno($cosa->id);
           
            $todos_mis_ejercicios[] = $mp;
        }
       
        return $todos_mis_ejercicios;
    }

    function obtener_ejercicos_del_profesor($id_profesor) {

        

        $sql = 'SELECT * FROM  mdl_ejercicios_prof_actividad WHERE id_profesor=' . $id_profesor;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_prof_actividad();

            $mp->obtener_uno($cosa->id);
           
            $todos_mis_ejercicios[] = $mp;
        }
       
        return $todos_mis_ejercicios;
    }

    function obtener_ejercicios_del_profesor_carpeta($id_profesor) {

     

        $sql = 'SELECT DISTINCT(carpeta) FROM mdl_ejercicios_prof_actividad WHERE id_profesor=' . $id_profesor;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();
	
        foreach ($todos as $cosa) {

            $mp = new Ejercicios_prof_actividad();

            $mp->carpeta = $cosa->carpeta;

            $todos_mis_ejercicios[] = $mp;
        }
        
        return $todos_mis_ejercicios;
    }

    function obtener_ejercicos_del_profesor_por_carpetas($id_profesor, $carpeta) {




        $sql = 'SELECT * FROM  mdl_ejercicios_prof_actividad WHERE id_profesor=' . $id_profesor . ' and carpeta="' . $carpeta . '"';

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_prof_actividad();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

}

/*
 * Clase que gestiona la tabla mdl_ejercicios_texto_texto_resp de la bd
 */

class Ejercicios_texto_texto_resp{

    var $id;
    var $id_pregunta;
    var $respuesta;
    var $correcta;

    //Contructor
    function Ejercicios_texto_texto_resp($id = NULL, $id_pregunta = NULL, $respuesta = NULL, $correcta = NULL) {

        $this->id = $id;
        $this->id_pregunta = $id_pregunta;
        $this->respuesta = $respuesta;
        $this->correcta = $correcta;
   
    }

    function get($param) {

        // $param = strtolower($param);
        switch ($param) {
            default:
            case 'id':
                return $this->id;
                break;
            case 'id_respuesta':
                return $this->id_respuesta;
                break;
            case 'respuesta':
                return $this->respuesta;
                break;
            case 'correcta':
                return $this->correcta;
                break;
          
        }
    }

    function insertar() {

        $id = insert_record('ejercicios_texto_texto_resp', $this, true);
        //Devuelve el identificador del ejercicios creado

        return $id;
    }

    function alterar() {

        //insert_record('ejercicios_tipo_puzzledoble',"pepe",true,'id');
        update_record('ejercicios_texto_texto_resp', $this, false);
    }

    function borrar_id_pregunta($id_pregunta) {
        //insert_record('ejercicios_tipo_puzzledoble',"pepe",true,'id');

        delete_records('ejercicios_texto_texto_resp', 'id_pregunta', $id_pregunta);
    }

    function obtener_uno($id) {
        
        $ejer = get_record('ejercicios_texto_texto_resp', 'id', $id);
        $this->id = $ejer->id;
        $this->id_respuesta = $ejer->id_respuesta;
        $this->respuesta = $ejer->respuesta;
        $this->correcta = $ejer->correcta;
     

        return $this;
    }



    function obtener_todas_respuestas_pregunta($id_pregunta) {


        $sql = 'SELECT * FROM  mdl_ejercicios_texto_texto_resp WHERE id_pregunta=' . $id_pregunta;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_texto_texto_resp();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

  
}












/*
 * Clase que gestiona la tabla mdl_ejercicios_textos de la BD, es decir si el arichivo origen
 * es texto en el formulario de creación estará almacenado en esta tabla.
 */

class Ejercicios_textos {

    var $id;
    var $id_ejercicio;
    var $texto;


    //Contructor por defecto y con parametros
    function Ejercicios_textos($id = NULL,$id_ejercicio=NULL,$texto = NULL) {

        $this->id = $id;
        $this->id_ejercicio = $id_ejercicio;
        $this->texto = $texto;
       
    }

    //Obtener cada uno de los atributos de la tabla
    function get($param) {

        // $param = strtolower($param);
        switch ($param) {
            default:
            case 'id':
                return $this->id;
                break;

            case 'id_ejercicio':
                return $this->id_ejercicio;
                break;
            
            case 'texto':
                return $this->texto;
                break;
        }
    }

    //Inserta en la bd la instancia correspondiente a la clase y devuelve el identificador
    //de la nueva instancia creada
    function insertar() {

        $id = insert_record('ejercicios_textos', $this, true);
        //Devuelve el identificador del ejercicios creado

        return $id;
    }

    //Modifica una instacia
    function alterar() {

        update_record('ejercicios_textos', $this, false);
    }

    //Borra la fila que tiene como id_ejercicio el que se le pasa como parametro
    function borrar_id_ejercicio($id_ejercicio) {
        delete_records('ejercicios_textos', 'id_ejercicio', $id_ejercicio);
    }

    //Obtiene el texto por id
    function obtener_uno($id) {
        $ejer = get_record('ejercicios_textos', 'id', $id);
        $this->id = $ejer->id;
        $this->id_ejercicio = $ejer->id_ejercicio;
        $this->texto = $ejer->$texto;
     
        return $this;
    }

    function obtener_uno_id_ejercicio($id_ejercicio) {

        $ejer = get_record('ejercicios_textos', 'id_ejercicio', $id_ejercicio);
        $this->id = $ejer->id;
        $this->id_ejercicio = $ejer->id_ejercicio;
        $this->texto=$ejer->texto;
      

        return $this;
    }

   


}














/*
 * Clase que gestiona la tabla mdl_ejercicios_textos de la BD, es decir si el arichivo origen
 * es texto en el formulario de creación estará almacenado en esta tabla.
 */

class Ejercicios_videos {

    var $id;
    var $id_ejercicio;
    var $video;


    //Contructor por defecto y con parametros
    function Ejercicios_videos($id = NULL,$id_ejercicio=NULL,$video = NULL) {

        $this->id = $id;
        $this->id_ejercicio = $id_ejercicio;
        $this->video = $video;

    }

    //Obtener cada uno de los atributos de la tabla
    function get($param) {

        // $param = strtolower($param);
        switch ($param) {
            default:
            case 'id':
                return $this->id;
                break;

            case 'id_ejercicio':
                return $this->id_ejercicio;
                break;

            case 'video':
                return $this->video;
                break;
        }
    }

    //Inserta en la bd la instancia correspondiente a la clase y devuelve el identificador
    //de la nueva instancia creada
    function insertar() {

        $id = insert_record('ejercicios_videos', $this, true);
        //Devuelve el identificador del ejercicios creado

        return $id;
    }

    //Modifica una instacia
    function alterar() {

        update_record('ejercicios_videos', $this, false);
    }

    //Borra la fila que tiene como id_ejercicio el que se le pasa como parametro
    function borrar_id_ejercicio($id_ejercicio) {
        delete_records('ejercicios_videos', 'id_ejercicio', $id_ejercicio);
    }

    //Obtiene el texto por id
    function obtener_uno($id) {
        $ejer = get_record('ejercicios_videos', 'id', $id);
        $this->id = $ejer->id;
        $this->id_ejercicio = $ejer->id_ejercicio;
        $this->video = $ejer->video;

        return $this;
    }

    function obtener_uno_id_ejercicio($id_ejercicio) {

        $ejer = get_record('ejercicios_videos', 'id_ejercicio', $id_ejercicio);
        $this->id = $ejer->id;
        $this->id_ejercicio = $ejer->id_ejercicio;
        $this->video=$ejer->video;


        return $this;
    }




}

/*
 * Clase que gestiona la tabla mdl_ejercicios_texto_texto de la bd
 */

class Ejercicios_texto_texto_preg{

    var $id;
    var $id_ejercicio;
    var $pregunta;
 

    //Contructor
    function Ejercicios_texto_texto_preg($id = NULL, $id_ejercicio = NULL, $pregunta = NULL) {

        $this->id = $id;
        $this->id_ejercicio = $id_ejercicio;
        $this->pregunta = $pregunta;
       
    }

    function get($param) {

        // $param = strtolower($param);
        switch ($param) {
            default:
            case 'id':
                return $this->id;
                break;
            case 'id_ejercicio':
                return $this->id_ejercicio;
                break;
            case 'pregunta':
                return $this->pregunta;
                break;
          
        }
    }

    function insertar() {

        $id = insert_record('ejercicios_texto_texto_preg', $this, true);
        //Devuelve el identificador del ejercicios creado

        return $id;
    }

    function alterar() {

        //insert_record('ejercicios_tipo_puzzledoble',"pepe",true,'id');
        update_record('ejercicios_texto_texto_preg', $this, false);
    }

    function borrar_id_ejercicio($id_ejercicio) {
        //insert_record('ejercicios_tipo_puzzledoble',"pepe",true,'id');

        delete_records('ejercicios_texto_texto_preg', 'id_ejercicio', $id_ejercicio);
    }

    function obtener_uno($id) {
        $ejer = get_record('ejercicios_texto_texto_preg', 'id', $id);
        $this->id = $ejer->id;
        $this->id_ejercicio = $ejer->id_ejercicio;
        $this->pregunta = $ejer->pregunta;
       
        return $this;
    }

  

    function obtener_todas_preguntas_ejercicicio($id_ejercicio) {


        $sql = 'SELECT * FROM  mdl_ejercicios_texto_texto_preg WHERE id_ejercicio=' . $id_ejercicio;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_texto_texto_preg();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

}


//Clase para gestionar las imagenes asociadas de los ejercicios




/*
 * Clase que gestiona la tabla mdl_ejercicios_textos de la BD, es decir si el arichivo origen
 * es texto en el formulario de creación estará almacenado en esta tabla.
 */

class Ejercicios_imagenes_asociadas{

    var $id;
    var $id_ejercicio;
    var $id_pregunta;
    var $nombre_imagen;


    //Contructor por defecto y con parametros
    function Ejercicios_imagenes_asociadas($id = NULL,$id_ejercicio=NULL,$id_preg = NULL,$nombre_img=NULL) {
    
        $this->id = $id;
        $this->id_ejercicio = $id_ejercicio;
        $this->id_pregunta = $id_preg;
        $this->nombre_imagen = $nombre_img;

    }

    //Obtener cada uno de los atributos de la tabla
    function get($param) {

        // $param = strtolower($param);
        switch ($param) {
            default:
            case 'id':
                return $this->id;
                break;
            case 'id_ejercicio':
                return $this->id_ejercicio;
                break;
            case 'id_pregunta':
                return $this->id_pregunta;
                break;
             case 'nombre_imagen':
                return $this->nombre_imagen;
                break;
        }
    }

    //Inserta en la bd la instancia correspondiente a la clase y devuelve el identificador
    //de la nueva instancia creada
    function insertar() {

        $id = insert_record('ejercicios_imagenes_asociadas', $this, true);
        //Devuelve el identificador del ejercicios creado

        return $id;
    }

    //Modifica una instacia
    function alterar() {

        update_record('ejercicios_imagenes_asociadas', $this, false);
    }

    //Borra la fila que tiene como id_ejercicio el que se le pasa como parametro
    function borrar_id_ejercicio($id_ejercicio) {
        delete_records('ejercicios_imagenes_asociadas', 'id_ejercicio', $id_ejercicio);
    }

    //Obtiene el texto por id
    function obtener_uno($id) {
        $ejer = get_record('ejercicios_imagenes_asociadas', 'id', $id);
        $this->id = $ejer->id;
        $this->id_ejercicio = $ejer->id_ejercicio;
        $this->id_pregunta = $ejer->id_pregunta;
        $this->nombre_imagen =$ejer->nombre_imagen;

        return $this;
    }

    function obtener_todos_id_ejercicio($id_ejercicio) {

       
        $ejer = get_records('ejercicios_imagenes_asociadas', 'id_ejercicio',$id_ejercicio);
          $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {
           
            $mp = new Ejercicios_imagenes_asociadas();

            $mp->obtener_uno($cosa->id);
               
            $todos_mis_ejercicios[] = $mp;

         
        }


        return $todos_mis_ejercicios;
       
    }

      function obtener_todas_respuestas_pregunta($id_pregunta){

     
        
        $sql = 'SELECT * FROM  mdl_ejercicios_imagenes_asociadas WHERE id_pregunta=' . $id_pregunta;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {
            
            $mp = new Ejercicios_imagenes_asociadas();

            $mp->obtener_uno($cosa->id);
               
            $todos_mis_ejercicios[] = $mp;

        }


        return $todos_mis_ejercicios;
    }






}






























/*
 * Clase que gestiona la tabla mdl_ejercicios_textos de la BD, es decir si el arichivo origen
 * es texto en el formulario de creación estará almacenado en esta tabla.
 */

class Ejercicios_audios_asociados{

    var $id;
    var $id_ejercicio;
    var $id_pregunta;
    var $nombre_audio;


    //Contructor por defecto y con parametros
    function Ejercicios_audios_asociados($id = NULL,$id_ejercicio=NULL,$id_preg = NULL,$nombre_audio=NULL) {

        $this->id = $id;
        $this->id_ejercicio = $id_ejercicio;
        $this->id_pregunta = $id_preg;
        $this->nombre_audio = $nombre_audio;

    }

    //Obtener cada uno de los atributos de la tabla
    function get($param) {

        // $param = strtolower($param);
        switch ($param) {
            default:
            case 'id':
                return $this->id;
                break;
            case 'id_ejercicio':
                return $this->id_ejercicio;
                break;
            case 'id_pregunta':
                return $this->id_pregunta;
                break;
             case 'nombre_audio':
                return $this->nombre_audio;
                break;
        }
    }

    //Inserta en la bd la instancia correspondiente a la clase y devuelve el identificador
    //de la nueva instancia creada
    function insertar() {

        $id = insert_record('ejercicios_audios_asociados', $this, true);
        //Devuelve el identificador del ejercicios creado

        return $id;
    }

    //Modifica una instacia
    function alterar() {

        update_record('ejercicios_audios_asociados', $this, false);
    }

    //Borra la fila que tiene como id_ejercicio el que se le pasa como parametro
    function borrar_id_ejercicio($id_ejercicio) {
        delete_records('ejercicios_audios_asociados', 'id_ejercicio', $id_ejercicio);
    }

    //Obtiene el texto por id
    function obtener_uno($id) {
        $ejer = get_record('ejercicios_audios_asociados', 'id', $id);
        $this->id = $ejer->id;
        $this->id_ejercicio = $ejer->id_ejercicio;
        $this->id_pregunta = $ejer->id_pregunta;
        $this->nombre_audio =$ejer->nombre_audio;

        return $this;
    }

    function obtener_todos_id_ejercicio($id_ejercicio) {


        $ejer = get_records('ejercicios_audios_asociados', 'id_ejercicio',$id_ejercicio);
          $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_audios_asociados();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;


        }


        return $todos_mis_ejercicios;

    }

      function obtener_todas_respuestas_pregunta($id_pregunta){



        $sql = 'SELECT * FROM  mdl_ejercicios_audios_asociados WHERE id_pregunta=' . $id_pregunta;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_audios_asociados();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;

        }


        return $todos_mis_ejercicios;
    }

}

/*
 * Clase que gestiona la tabla mdl_ejercicios_videos asociados de la BD, es decir si el arichivo origen
 * es texto en el formulario de creación estará almacenado en esta tabla.
 */

class Ejercicios_videos_asociados{

    var $id;
    var $id_ejercicio;
    var $id_pregunta;
    var $nombre_video;


    //Contructor por defecto y con parametros
    function Ejercicios_videos_asociados($id = NULL,$id_ejercicio=NULL,$id_preg = NULL,$nombre_video=NULL) {

        $this->id = $id;
        $this->id_ejercicio = $id_ejercicio;
        $this->id_pregunta = $id_preg;
        $this->nombre_video = $nombre_video;
    }

    //Obtener cada uno de los atributos de la tabla
    function get($param) {

        // $param = strtolower($param);
        switch ($param) {
            default:
            case 'id':
                return $this->id;
                break;
            case 'id_ejercicio':
                return $this->id_ejercicio;
                break;
            case 'id_pregunta':
                return $this->id_pregunta;
                break;
             case 'nombre_video':
                return $this->nombre_video;
                break;
        }
    }

    //Inserta en la bd la instancia correspondiente a la clase y devuelve el identificador
    //de la nueva instancia creada
    function insertar() {
        if ($this->nombre_video != null){
            $id = insert_record('ejercicios_videos_asociados', $this, true);
            return $id;
        }
        else{
            return null;
        }
        //Devuelve el identificador del ejercicios creado
        
    }

    //Modifica una instacia
    function alterar() {

        update_record('ejercicios_videos_asociados', $this, false);
    }

    //Borra la fila que tiene como id_ejercicio el que se le pasa como parametro
    function borrar_id_ejercicio($id_ejercicio) {
        delete_records('ejercicios_videos_asociados', 'id_ejercicio', $id_ejercicio);
    }

    //Obtiene el texto por id
    function obtener_uno($id) {
        $ejer = get_record('ejercicios_videos_asociados', 'id', $id);
        $this->id = $ejer->id;
        $this->id_ejercicio = $ejer->id_ejercicio;
        $this->id_pregunta = $ejer->id_pregunta;
        $this->nombre_video =$ejer->nombre_video;

        return $this;
    }

    //Obtiene el texto por id
    function obtener_uno_ejpreg($id_ej,$id_preg) {
        print_r('obteneruno');
        print_r($id_ej);
        print_r($id_preg);
        $ejer = get_record('ejercicios_videos_asociados', 'id_ejercicio', $id_ej,'id_pregunta',$id_preg);
        print_r($ejer);
        print_r('otroo');
        $this->id = $ejer->id;
        $this->id_ejercicio = $ejer->id_ejercicio;
        $this->id_pregunta = $ejer->id_pregunta;
        $this->nombre_video =$ejer->nombre_video;
        print_r($this);
        return $this;
    }
    
    function obtener_todos_id_ejercicio($id_ejercicio) {


        $ejer = get_records('ejercicios_videos_asociados', 'id_ejercicio',$id_ejercicio);
          $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_videos_asociados();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;


        }


        return $todos_mis_ejercicios;

    }

      function obtener_todas_respuestas_pregunta($id_pregunta){



        $sql = 'SELECT * FROM  mdl_ejercicios_videos_asociados WHERE id_pregunta=' . $id_pregunta;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_videos_asociados();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;

        }


        return $todos_mis_ejercicios;
    }

}



//tabla para gestionar asociacion simple (Videos asociados a textos)

//------- Tablas para ejercicios Identificar Elementos ------------------
class ejercicios_ie_respuestas {

    var $id;
    var $id_ejercicio;
    var $id_pregunta;
    var $respuesta;


    //Contructor por defecto y con parametros
    function ejercicios_ie_respuestas($id = NULL,$id_ejercicio=NULL,$id_pregunta=NULL,$respuesta = NULL) {

        $this->id = $id;
        $this->id_ejercicio = $id_ejercicio;
        $this->id_pregunta = $id_pregunta;
        $this->respuesta = $respuesta;
       
    }

    //Obtener cada uno de los atributos de la tabla
    function get($param) {

        // $param = strtolower($param);
        switch ($param) {
            default:
            case 'id':
                return $this->id;
                break;

            case 'id_ejercicio':
                return $this->id_ejercicio;
                break;
            
            case 'id_pregunta':
                return $this->id_pregunta;
                break;
            case 'respuesta':
                return $this->respuesta;
                break;
        }
    }

    //Inserta en la bd la instancia correspondiente a la clase y devuelve el identificador
    //de la nueva instancia creada
    function insertar() {

        $id = insert_record('ejercicios_ie_respuestas', $this, true);
        //Devuelve el identificador del ejercicios creado

        return $id;
    }

    //Modifica una instacia
    function alterar() {

        update_record('ejercicios_ie_respuestas', $this, false);
    }

    //Borra todas las respuestas asociadas a un ejercicio
    function borrar_id_ejercicio($id_ejercicio) {
        delete_records('ejercicios_ie_respuestas', 'id_ejercicio', $id_ejercicio);
    }
    
    //Borra todas las respuestas asociadas a una pregunta
    function borrar_id_pregunta($id_pregunta) {
        delete_records('ejercicios_ie_respuestas', 'id_pregunta', $id_pregunta);
    }
    
    //Borra una respuesta dada por su id
    function borrar_id_respuesta($id_respuesta) {
        delete_record('ejercicios_ie_respuestas', 'id', $id_respuesta);
    }

    //Obtiene el texto por id
    function obtener_uno($id) {
        $ejer = get_record('ejercicios_ie_respuestas', 'id', $id);
        $this->id = $ejer->id;
        $this->id_ejercicio = $ejer->id_ejercicio;
        $this->id_pregunta = $ejer->id_pregunta;
        $this->respuesta = $ejer->respuesta;
        
     
        return $this;
    }

    function obtener_todos_id_ejercicio($id_ejercicio) {
        $sql = 'SELECT * FROM  mdl_ejercicios_ie_respuestas WHERE id_ejercicio=' . $id_ejercicio;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new ejercicios_ie_respuestas();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;

        }


        return $todos_mis_ejercicios;
    }
    
    function obtener_todos_id_pregunta($id_pregunta) {
        $sql = 'SELECT * FROM  mdl_ejercicios_ie_respuestas WHERE id_pregunta=' . $id_pregunta;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new ejercicios_ie_respuestas();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;

        }


        return $todos_mis_ejercicios;
    }

   


}

?>
