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
  Serafina Molina Soto (finamolinasoto@gmail.com)

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

    //Contructor
    function Ejercicios_general($id = NULL, $id_curso = NULL, $id_creador = NULL, $tipoactividad = NULL, $tipoarchivopregunta = NULL, $tipoarchivorespuesta = NULL, $visible = NULL, $publico = NULL, $carpeta = NULL, $campotematico = NULL, $destreza = NULL, $temagramatical = NULL, $intencioncomunicativa = NULL, $tipologiatextual = NULL, $name = NULL, $descripcion = NULL, $numpreg = NULL) {


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
        }
    }

    function insertar() {

        //insert_record('ejercicios_tipo_puzzledoble',"pepe",true,'id');
        $id = insert_record('ejercicios_general', $this, true);
        //Devuelve el identificador del ejercicios creado
	echo $id;
        return $id;
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


        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE destreza=' . $temagramatical;

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
        echo "cdc vale".$cdc;
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
        
        echo "int".$cic." tt".$ctt;
        
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
        
       // echo "".$ccl
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

        echo "user id" . $userid;
        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE tipoactividad=' . $cta . ' AND destreza=' . $cdc . ' AND (publico=1 OR id_creador=' . $userid . ')';
        echo 'SELECT * FROM  mdl_ejercicios_general WHERE tipoactividad=' . $cta . ' AND destreza=' . $cdc . ' AND (publico=1 OR id_creador=' . $userid . ')';

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_general();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }

        echo "tamano" . sizeof($todos_mis_ejercicios);
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
                echo "id_profesor" . $this->id_profesor;
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

        //  echo "entra".$id_profesor;

        $sql = 'SELECT * FROM  mdl_ejercicios_prof_actividad WHERE id_ejercicio=' . $id_ejercicio;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_prof_actividad();

            $mp->obtener_uno($cosa->id);
            //           echo $cosa->id." aaa";
            $todos_mis_ejercicios[] = $mp;
        }
        //  echo "sale";
        return $todos_mis_ejercicios;
    }

    function obtener_ejercicos_del_profesor($id_profesor) {

          echo "entra".$id_profesor;

        $sql = 'SELECT * FROM  mdl_ejercicios_prof_actividad WHERE id_profesor=' . $id_profesor;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_prof_actividad();

            $mp->obtener_uno($cosa->id);
            //           echo $cosa->id." aaa";
            $todos_mis_ejercicios[] = $mp;
        }
        //  echo "sale";
        return $todos_mis_ejercicios;
    }

    function obtener_ejercicios_del_profesor_carpeta($id_profesor) {

       // echo "entra".$id_profesor;

        $sql = 'SELECT DISTINCT(carpeta) FROM mdl_ejercicios_prof_actividad WHERE id_profesor=' . $id_profesor;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();
	
        foreach ($todos as $cosa) {

            $mp = new Ejercicios_prof_actividad();

            $mp->carpeta = $cosa->carpeta;

            $todos_mis_ejercicios[] = $mp;
        }
        // echo "sale";
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
 * Clase que gestiona la tabla mdl_ejercicios_texto_texto de la bd
 */

class Ejercicios_texto_texto {

    var $id;
    var $id_ejercicio;
    var $numeropregunta;
    var $pregunta;
    var $respuesta;
    var $correcta;

    //Contructor
    function Ejercicios_texto_texto($id = NULL, $id_ejercicio = NULL, $numeropregunta = NULL, $pregunta = NULL, $respuesta = NULL, $correcta = NULL) {

        $this->id = $id;
        $this->id_ejercicio = $id_ejercicio;
        $this->numeropregunta = $numeropregunta;
        $this->pregunta = $pregunta;
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
            case 'id_ejercicio':
                return $this->id_ejercicio;
                break;
            case 'numeropregunta':
                return $this->numeropregunta;
                break;
            case 'pregunta':
                return $this->pregunta;
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

        $id = insert_record('ejercicios_texto_texto', $this, true);
        //Devuelve el identificador del ejercicios creado

        return $id;
    }

    function alterar() {

        //insert_record('ejercicios_tipo_puzzledoble',"pepe",true,'id');
        update_record('ejercicios_texto_texto', $this, false);
    }

    function borrar_id_ejercicio($id_ejercicio) {
        //insert_record('ejercicios_tipo_puzzledoble',"pepe",true,'id');

        delete_records('ejercicios_texto_texto', 'id_ejercicio', $id_ejercicio);
    }

    function obtener_uno($id) {
        $ejer = get_record('ejercicios_texto_texto', 'id', $id);
        $this->id = $ejer->id;
        $this->id_ejercicio = $ejer->id_ejercicio;
        $this->numeropregunta = $ejer->numeropregunta;
        $this->pregunta = $ejer->pregunta;
        $this->respuesta = $ejer->respuesta;
        $this->correcta = $ejer->correcta;

        return $this;
    }

    function obtener_uno_name($name) {

        $ejer = get_record('ejercicios_texto_texto', 'name', $name);
        $this->id = $ejer->id;
        $this->id_ejercicio = $ejer->id_ejercicio;
        $this->numeropregunta = $ejer->numeropregunta;
        $this->pregunta = $ejer->pregunta;
        $this->respuesta = $ejer->respuesta;
        $this->correcta = $ejer->correcta;

        return $this;
    }

    function obtener_todos() {


        $sql = 'SELECT * FROM  mdl_ejercicios_texto_texto';

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_texto_texto();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function obtener_ejercicios_texto_id_ejercicicio($id_ejercicio) {


        $sql = 'SELECT * FROM  mdl_ejercicios_texto_texto WHERE id_ejercicio=' . $id_ejercicio;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_texto_texto();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

    function obtener_ejercicios_texto_id_ejercicicio_numpreguntas($id_ejercicio, $numeropregunta) {



        $sql = 'SELECT * FROM  mdl_ejercicios_texto_texto WHERE id_ejercicio=' . $id_ejercicio . ' and numeropregunta=' . $numeropregunta;

        $todos = get_records_sql($sql);

        $todos_mis_ejercicios = array();

        foreach ($todos as $cosa) {

            $mp = new Ejercicios_texto_texto();

            $mp->obtener_uno($cosa->id);

            $todos_mis_ejercicios[] = $mp;
        }


        return $todos_mis_ejercicios;
    }

}

?>
