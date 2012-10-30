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

  Original idea and content design:
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




class Ejercicios_mis_puzzledoble {

    var $id;
    var $name;
    var $nrespuestas;
    var $ctipo;
    var $elemaso;
    var $des1;
    var $des2;
    var $des3;
    var $des4;
    var $des5;
    var $des6;
    var $des7;
    var $des8;
    var $des9;
    var $texto1;
    var $texto2;
    var $texto3;
    var $texto4;
    var $texto5;
    var $texto6;
    var $texto7;
    var $texto8;
    var $texto9;
//    Consturctor por defecto
    function Ejercicios_mis_puzzledoble($name = null,$nrespuestas=NULL,$ctipo=NULL,$elemaso=NULL,$id = NULL) {
        $this->id = $id;
        $this->name = $name;
        $this->nrespuestas=$nrespuestas;
        $this->ctipo=$ctipo;
        $this->elemaso=$elemaso;
    }
    
 

    function set($id = null,$name = null,$nrespuestas=null,$elemaso=null) {
        if ($id != null && $id != $this->id) {
            $this->id = $id;
        }
        if ($name != null && $name != $this->name) {
            $this->name = $id;
        }
          if ($nrespuestas != null && $nrespuetas != $this->nrespuestas) {
            $this->nrespuetas = $nrespuestas;
        }
          if ($ctipo != null && $ctipo != $this->ctipo) {
            $this->nrespuetas = $ctipo;
        }

         if ($elemaso != null && $elemaso != $this->elemaso) {
            $this->nrespuetas = $elemaso;
        }

       
    }

    function set_descripcion($descr,$i) {
           switch ($i) {
            default:
            case '1':
               $this->des1=$descr;
                break;
            case '2':
                $this->des2=$descr;
                break;
            case '3':
                $this->des3=$descr;
                break;
             case '4':
                $this->des4=$descr;
                break;
             case '5':
                $this->des5=$descr;
                break;
              case '6':
                $this->des6=$descr;
                break;
            case '7':
                $this->des7=$descr;
                break;
            case '8':
                $this->des8=$descr;
                break;
             case '9':
                $this->des9=$descr;
                break;

        }

    }

    
        function set_palabras($texto,$i) {
           switch ($i) {
            default:
            case '1':
               $this->texto1=$texto;
                break;
            case '2':
                $this->texto2=$texto;
                break;
            case '3':
                $this->texto3=$texto;
                break;
             case '4':
                $this->texto4=$texto;
                break;
             case '5':
                $this->texto5=$texto;
                break;
              case '6':
                $this->texto6=$texto;
                break;
            case '7':
                $this->texto7=$texto;
                break;
            case '8':
                $this->texto8=$texto;
                break;
             case '9':
                $this->texto9=$texto;
                break;

        }

    }
    function get($param) {
     
       // $param = strtolower($param);
        switch ($param) {
            default:
            case 'id':
                return $this->id;
                break;
            case 'name':
                return $this->name;
                break;
            case 'nrespuestas':
                return $this->nrespuestas;
                break;
             case 'ctipo':
                return $this->ctipo;
                break;
             case 'elemaso':
              
                return $this->elemaso;
                break;
            case 'des1':
                return $this->des1;
                break;
            case 'des2':
                return $this->des2;
                break;
            case 'des3':
                return $this->des3;
                break;
             case 'des4':
                return $this->des4;
                break;
             case 'des5':
                return $this->des5;
                break;
              case 'des6':
                return $this->des6;
                break;
            case 'des7':
               return $this->des7;
                break;
            case 'des8':
                return $this->des8;
                break;
             case 'des9':
               return $this->des9;
                break;
               case 'texto1':
                return $this->texto1;
                break;
            case 'texto2':
                return $this->texto2;
                break;
            case 'texto3':
                return $this->texto3;
                break;
             case 'texto4':
                return $this->texto4;
                break;
             case 'texto5':
                return $this->texto5;
                break;
              case 'texto6':
                return $this->texto6;
                break;
            case 'texto7':
               return $this->texto7;
                break;
            case 'texto8':
                return $this->texto8;
                break;
             case 'texto9':
               return $this->texto9;
                break;
          
     
        }
    }
    

    function insertar(){
       
        //insert_record('ejercicios_tipo_puzzledoble',"pepe",true,'id');
         insert_record('ejercicios_tipo_puzzle', $this, true);
      
       
       
    }
     function alterar(){
     
        
        //insert_record('ejercicios_tipo_puzzledoble',"pepe",true,'id');
        update_record('ejercicios_tipo_puzzle', $this, false);


    }
    
    function obtener_uno($id){
         $ejer = get_record('ejercicios_tipo_puzzle', 'id', $id);
         $this->id = $ejer->id;
         $this->name = $ejer->name;
         $this->nrespuestas=$ejer->nrespuestas;
         $this->ctipo=$ejer->ctipo;
         $this->elemaso=$ejer->elemaso;
         $this->des1=$ejer->des1;
         $this->des2=$ejer->des2;
         $this->des3=$ejer->des3;
         $this->des4=$ejer->des4;
         $this->des5=$ejer->des5;
         $this->des6=$ejer->des6;
         $this->des7=$ejer->des7;
         $this->des8=$ejer->des8;
         $this->des9=$ejer->des9;
         $this->texto1=$ejer->texto1;
         $this->texto2=$ejer->texto2;
         $this->texto3=$ejer->texto3;
         $this->texto4=$ejer->texto4;
         $this->texto5=$ejer->texto5;
         $this->texto6=$ejer->texto6;
         $this->texto7=$ejer->texto7;
         $this->texto8=$ejer->texto8;
         $this->texto9=$ejer->texto9;
          return $this;

    }
    function obtener_uno_name($name){
        
         $ejer = get_record('ejercicios_tipo_puzzle', 'name', $name);
         $this->id = $ejer->id;
         $this->name = $ejer->name;
         $this->nrespuestas=$ejer->nrespuestas;
         $this->ctipo=$ejer->ctipo;
         $this->elemaso=$ejer->elemaso;
               $this->des1=$ejer->des1;
         $this->des2=$ejer->des2;
         $this->des3=$ejer->des3;
         $this->des4=$ejer->des4;
         $this->des5=$ejer->des5;
         $this->des6=$ejer->des6;
         $this->des7=$ejer->des7;
         $this->des8=$ejer->des8;
         $this->des9=$ejer->des9;
           $this->texto1=$ejer->texto1;
         $this->texto2=$ejer->texto2;
         $this->texto3=$ejer->texto3;
         $this->texto4=$ejer->texto4;
         $this->texto5=$ejer->texto5;
         $this->texto6=$ejer->texto6;
         $this->texto7=$ejer->texto7;
         $this->texto8=$ejer->texto8;
         $this->texto9=$ejer->texto9;
         return $this;
         
    }

    function obtener_todos() {
        
      
        $sql = 'SELECT * FROM  mdl_ejercicios_tipo_puzzle';
      
        $todos = get_records_sql($sql);
        
         $todos_mis_ejercicios = array();

               foreach ($todos as $cosa) {
                    
                     $mp = new Ejercicios_mis_puzzledoble();
                     
                     $mp->obtener_uno($cosa->id);
                     
                    $todos_mis_ejercicios[] = $mp;
                    
                  
                }
              
                
        return $todos_mis_ejercicios;
               
              
 
    }
    
    
}




?>