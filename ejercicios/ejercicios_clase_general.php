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
       var $TipoActividad;
       var $TipoArchivoPregunta;
       var $TipoArchivoRespuesta;
       var $visible;
       var $publico;
       var $carpeta;
       var $CampoTematico;
       var $Destreza;
       var $TemaGramatical;
       var $IntencionComunicativa;
       var $TipologiaTextual;
       var $name;
       var $descripcion;
       var $numpreg;
       //Contructor
       function Ejercicios_general($id=NULL,$id_curso=NULL,$id_creador=NULL,$TipoActividad=NULL,$TipoArchivoPregunta=NULL,$TipoArchivoRespuesta=NULL,$visible=NULL,$publico=NULL,$carpeta=NULL,$CampoTematico=NULL,$Destreza=NULL,$TemaGramatical=NULL,$IntencionComunicativa=NULL,$TipologiaTextual=NULL,$name=NULL,$descripcion=NULL,$numpreg=NULL){
               
           
                $this->id=$id;
                $this->id_curso=$id_curso;
                $this->id_creador=$id_creador;
                $this->TipoActividad=$TipoActividad;
                $this->TipoArchivoPregunta=$TipoArchivoPregunta;
                $this->TipoArchivoRespuesta=$TipoArchivoRespuesta;
                $this->visible=$visible;
                $this->publico=$publico;
                $this->carpeta=$carpeta;
                $this->CampoTematico=$CampoTematico;
                $this->Destreza=$Destreza;
                $this->TemaGramatical=$TemaGramatical;
                $this->IntencionComunicativa=$IntencionComunicativa;
                $this->TipologiaTextual=$TipologiaTextual;
                $this->name=$name;
                $this->descripcion=$descripcion;
                $this->numpreg=$numpreg;
                  
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
             case 'TipoActividad':
                return $this->TipoActividad;
                break;
             case 'TipoArchivoPregunta':
                return $this->TipoArchivoPregunta;
                break;
            case 'visible':
                return $this->visible;
                break;
            case 'CampoTematico':
                return $this->CampoTematico;
                break;
            case 'Destreza':
                return $this->Destreza;
                break;
             case 'TemaGramatical':
                return $this->TemaGramatical;
                break;
             case 'IntencionComunicativa':
                return $this->IntencionComunicativa;
                break;
              case 'TipologiaTextual':
                return $this->TipologiaTextual;
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
    
     function insertar(){
       
        //insert_record('ejercicios_tipo_puzzledoble',"pepe",true,'id');
         $id=insert_record('ejercicios_general', $this, true);
         //Devuelve el identificador del ejercicios creado
         return $id;
    }
    
        
     function borrar($id){   
            //insert_record('ejercicios_tipo_puzzledoble',"pepe",true,'id');
        
            delete_records('ejercicios_general','id', $id);
          
     }
    
      function alterar(){
        
        //insert_record('ejercicios_tipo_puzzledoble',"pepe",true,'id');
        update_record('ejercicios_general', $this, false);

 
     }
    
       function obtener_uno($id){
         $ejer = get_record('ejercicios_general', 'id', $id);
         $this->id=$ejer->id;
         $this->id_curso=$ejer->id_curso;
         $this->id_creador=$ejer->id_creador;
         $this->TipoActividad=$ejer->TipoActividad;
         $this->TipoArchivoPregunta=$ejer->TipoArchivoPregunta;
         $this->TipoArchivoRespuesta=$ejer->TipoArchivoRespuesta;
         $this->visible=$ejer->visible;
         $this->publico=$ejer->publico;
         $this->carpeta=$ejer->carpeta;
         $this->CampoTematico=$ejer->CampoTematico;
         $this->Destreza=$ejer->Destreza;
         $this->TemaGramatical=$ejer->TemaGramatical;
         $this->IntencionComunicativa=$ejer->IntencionComunicativa;
         $this->TipologiaTextual=$ejer->TipologiaTextual;
         $this->name=$ejer->name;
         $this->descripcion=$ejer->descripcion;
         $this->numpreg=$ejer->numpreg;
          return $this;

    }
    
     function obtener_uno_name($name){
        
         $ejer = get_record('ejercicios_general', 'name', $name);
         $this->id=$ejer->id;
         $this->id_curso=$ejer->id_curso;
         $this->id_creador=$ejer->id_creador;
         $this->TipoActividad=$ejer->TipoActividad;
         $this->TipoArchivoPregunta=$ejer->TipoArchivoPregunta;
         $this->TipoArchivoRespuesta=$ejer->TipoArchivoRespuesta;
         $this->visible=$ejer->visible;
         $this->publico=$ejer->publico;
         $this->carpeta=$ejer->carpeta;
         $this->CampoTematico=$ejer->CampoTematico;
         $this->Destreza=$ejer->Destreza;
         $this->TemaGramatical=$ejer->TemaGramatical;
         $this->IntencionComunicativa=$ejer->IntencionComunicativa;
         $this->TipologiaTextual=$ejer->TipologiaTextual;
         $this->name=$ejer->name;
         $this->descripcion=$ejer->descripcion;
         $this->numpreg=$ejer->numpreg;
         return $this;
          
    }
    
        function buscar_campotematico($campotematico){
        
     
        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE CampoTematico='.$campotematico;
      
        $todos = get_records_sql($sql);
        
         $todos_mis_ejercicios = array();

               foreach ($todos as $cosa) {
                    
                     $mp = new Ejercicios_general();
                     
                     $mp->obtener_uno($cosa->id);
                     
                    $todos_mis_ejercicios[] = $mp;
                    
                  
                }
              
                
        return $todos_mis_ejercicios;
               
          
    }
    
       function buscar_Destreza($Destreza){
        
     
        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE Destreza='.$Destreza;
      
        $todos = get_records_sql($sql);
        
         $todos_mis_ejercicios = array();

               foreach ($todos as $cosa) {
                    
                     $mp = new Ejercicios_general();
                     
                     $mp->obtener_uno($cosa->id);
                     
                    $todos_mis_ejercicios[] = $mp;
                    
                  
                }
              
                
        return $todos_mis_ejercicios;
               
          
    }
    
         function buscar_TemaGramatical($TemaGramatical){


            $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE Destreza='.$TemaGramatical;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;


      }
      
        function buscar_IntencionComunicativa($IntencionComunicativa){


            $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE IntencionComunicativa='.$IntencionComunicativa;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;


      }
      
        function buscar_TipologiaTextual($TipologiaTextual){


            $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE TipologiaTextual='.$TipologiaTextual;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;


      }
      
       function buscar_todas_clasificaciones($ccl,$cta ,$cdc,$cgr,$cic,$ctt,$userid){
          

            $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  CampoTematico='.$ccl.' AND TipoActividad='.$cta.' AND Destreza='.$cdc.' AND TemaGramatical='.$cgr.' AND IntencionComunicativa='.$cic.' AND TipologiaTextual='.$ctt;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;


      }
      
         function buscar_clasif_sin_tt($ccl,$cta ,$cdc,$cgr,$cic){


            $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  CampoTematico='.$ccl.' AND TipoActividad='.$cta.' AND Destreza='.$cdc.' AND TemaGramatical='.$cgr.' AND IntencionComunicativa='.$cic;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;


      }
      
      function buscar_clasif_sin_ic($ccl,$cta ,$cdc,$cgr,$ctt){


            $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  CampoTematico='.$ccl.' AND TipoActividad='.$cta.' AND Destreza='.$cdc.' AND TemaGramatical='.$cgr.' AND TipologiaTextual='.$ctt;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;


      }
      
       function buscar_clasif_sin_ic_tt($ccl,$cta ,$cdc,$cgr){


            $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  CampoTematico='.$ccl.' AND TipoActividad='.$cta.' AND Destreza='.$cdc.' AND TemaGramatical='.$cgr;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;


      }
      
      
     
      
       function buscar_sin_gr($ccl,$cta ,$cdc,$cic,$ctt){


             $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  CampoTematico='.$ccl.' AND TipoActividad='.$cta.' AND Destreza='.$cdc.' AND IntencionComunicativa='.$cic.' AND TipologiaTextual='.$ctt;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;


      }
      
        function buscar_clasif_sin_gr_tt($ccl,$cta ,$cdc,$cic){
            
            $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  CampoTematico='.$ccl.' AND TipoActividad='.$cta.' AND Destreza='.$cdc.' AND IntencionComunicativa='.$cic;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;
            
        }
        
        function buscar_clasif_sin_gr_ic($ccl,$cta ,$cdc,$ctt){
        
           $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  CampoTematico='.$ccl.' AND TipoActividad='.$cta.' AND Destreza='.$cdc.' AND TipologiaTextual='.$ctt;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;
        }
            
        
      function buscar_clasif_sin_gr_ic_tt($ccl,$cta ,$cdc){
          
            $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  CampoTematico='.$ccl.' AND TipoActividad='.$cta.' AND Destreza='.$cdc;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;
          
      }
      
      
      
      function clasif_sin_dc($ccl,$cta,$cgr,$cic,$ctt){
          
            $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  CampoTematico='.$ccl.' AND TipoActividad='.$cta.' AND TemaGramatical='.$cgr.' AND IntencionComunicativa='.$cic.' AND TipologiaTextual='.$ctt;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;
      }
      
      function buscar_clasif_sin_dc_tt($ccl,$cta,$cgr,$cic){
          
            $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  CampoTematico='.$ccl.' AND TipoActividad='.$cta.' AND TemaGramatical='.$cgr.' AND IntencionComunicativa='.$cic;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;
      }
      
      function buscar_clasif_sin_dc_ic($ccl,$cta,$cgr,$ctt){
           $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  CampoTematico='.$ccl.' AND TipoActividad='.$cta.' AND TemaGramatical='.$cgr.' AND TipologiaTextual='.$ctt;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;
      }
      
      function buscar_clasif_sin_dc_ic_tt($ccl,$cta,$cgr){
          
               $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  CampoTematico='.$ccl.' AND TipoActividad='.$cta.' AND TemaGramatical='.$cgr;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;
          
      }
      
      function buscar_sin_dc_gr($ccl,$cta,$cic,$ctt){
            $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  CampoTematico='.$ccl.' AND TipoActividad='.$cta.' AND IntencionComunicativa='.$cic.' AND TipologiaTextual='.$ctt;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;
      }
      
     function buscar_clasif_sin_dc_gr_tt($ccl,$cta,$cic){
         
              $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  CampoTematico='.$ccl.' AND TipoActividad='.$cta.' AND IntencionComunicativa='.$cic;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;
         
     }
     
     function buscar_clasif_sin_dc_gr_ic($ccl,$cta,$ctt){
                   $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  CampoTematico='.$ccl.' AND TipoActividad='.$cta.' AND TipologiaTextual='.$ctt;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;
     }
     
     function buscar_clasif_sin_dc_gr_ic_tt($ccl,$cta){
         
            $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  CampoTematico='.$ccl.' AND TipoActividad='.$cta;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;
         
     }
     
     function buscar_clasif_sin_cl($cta,$cdc,$cgr,$cic,$ctt){
         
            $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  TipoActividad='.$cta.' AND Destreza='.$cdc.' AND TemaGramatical='.$cgr.' AND IntencionComunicativa='.$cic.' AND TipologiaTextual='.$ctt;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;
     }
     
     
     function buscar_clasif_sin_cl_tt($cta ,$cdc,$cgr,$cic){
         
                   $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  TipoActividad='.$cta.' AND Destreza='.$cdc.' AND TemaGramatical='.$cgr.' AND IntencionComunicativa='.$cic;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;
         
     }
     
     function buscar_clasif_sin_cl_ic($cta ,$cdc,$cgr,$ctt){
                $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  TipoActividad='.$cta.' AND Destreza='.$cdc.' AND TemaGramatical='.$cgr.' AND TipologiaTextual='.$ctt;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;
     }
     
     function buscar_clasif_sin_cl_ic_tt($cta,$cdc,$cgr){
         
                  $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  TipoActividad='.$cta.' AND Destreza='.$cdc.' AND TemaGramatical='.$cgr;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;
         
     }
     
   function buscar_sin_cl_gr($cta,$cdc,$cic,$ctt){
       $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE TipoActividad='.$cta.' AND Destreza='.$cdc.' AND IntencionComunicativa='.$cic.' AND TipologiaTextual='.$ctt;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;
  }
  
  function buscar_clasif_sin_cl_gr_tt($cta,$cdc,$cic){
      
        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE TipoActividad='.$cta.' AND Destreza='.$cdc.' AND IntencionComunicativa='.$cic;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;
      
  }
    
  function buscar_clasif_sin_cl_gr_ic($cta,$cdc,$ctt){
      
       $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE TipoActividad='.$cta.' AND Destreza='.$cdc.' AND TipologiaTextual='.$ctt;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;
  }
  
  function buscar_clasif_sin_cl_gr_ic_tt($cta,$cdc,$userid){
         
      echo "user id".$userid;
       $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE TipoActividad='.$cta.' AND Destreza='.$cdc. ' AND (publico=1 OR id_creador='.$userid.')';
       echo 'SELECT * FROM  mdl_ejercicios_general WHERE TipoActividad='.$cta.' AND Destreza='.$cdc. ' AND (publico=1 OR id_creador='.$userid.')';

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }

            echo "tamano".sizeof($todos_mis_ejercicios);
            return $todos_mis_ejercicios;
  }
  
    function buscar_clasif_sin_cl_dc($cta,$cgr,$cic,$ctt){
        
           $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  TipoActividad='.$cta.' AND TemaGramatical='.$cgr.' AND IntencionComunicativa='.$cic.' AND TipologiaTextual='.$ctt;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;
  }
  
  function buscar_clasif_sin_cl_dc_tt($cta,$cgr,$cic){
      
          $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  TipoActividad='.$cta.' AND TemaGramatical='.$cgr.' AND IntencionComunicativa='.$cic;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;
  }
  
  function buscar_clasif_sin_cl_dc_ic($cta,$cgr,$ctt){
       
           $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  TipoActividad='.$cta.' AND TemaGramatical='.$cgr.' AND TipologiaTextual='.$ctt;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;
  }
  
  function buscar_clasif_sin_cl_dc_ic_tt($cta,$cgr){
      
        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  TipoActividad='.$cta.' AND TemaGramatical='.$cgr;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;
      
  }
  
  function buscar_sin_cl_dc_gr($cta,$cic,$ctt){
      
        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  TipoActividad='.$cta.' AND IntencionComunicativa='.$cic.' AND TipologiaTextual='.$ctt;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;
      
  }
  
  function buscar_clasif_sin_cl_dc_gr_tt($cta,$cic){
      
    $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  TipoActividad='.$cta.' AND IntencionComunicativa='.$cic;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;
      
  }
  
  function buscar_clasif_sin_cl_dc_gr_ic($cta,$ctt){
      
      
        $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  TipoActividad='.$cta.' AND TipologiaTextual='.$ctt;

            $todos = get_records_sql($sql);

            $todos_mis_ejercicios = array();

                foreach ($todos as $cosa) {

                        $mp = new Ejercicios_general();

                        $mp->obtener_uno($cosa->id);

                        $todos_mis_ejercicios[] = $mp;


                    }


            return $todos_mis_ejercicios;
      
  }
  
  function buscar_clasif_sin_cl_dc_gr_ic_tt($cta){
      
       $sql = 'SELECT * FROM  mdl_ejercicios_general WHERE  TipoActividad='.$cta;

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
 *Clase que gestiona la tabla de la base de datos mdl_ejercicios_profesor_actividad
 */
class Ejercicios_profesor_actividad{
    
       var $id;
       var $id_profesor;
       var $id_ejercicio;
       var $carpeta;
      
       //Contructor
       function Ejercicios_profesor_actividad($id=NULL,$id_profesor=NULL,$id_ejercicio=NULL,$carpeta=NULL){
           
                $this->id=$id;
                $this->id_profesor=$id_profesor;
                $this->id_ejercicio=$id_ejercicio;
                $this->carpeta=$carpeta;
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
                echo "id_profesor".$this->id_profesor;
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
    
    
     function insertar(){   
        //insert_record('ejercicios_tipo_puzzledoble',"pepe",true,'id');
         insert_record('ejercicios_profesor_actividad', $this, true);
      
     }
     
     function borrar(){   
            //insert_record('ejercicios_tipo_puzzledoble',"pepe",true,'id');
            delete_record('ejercicios_profesor_actividad', $this, true);

     }
      function borrar_id_ejercicio($id_ejercicio,$id_profesor){   
            //insert_record('ejercicios_tipo_puzzledoble',"pepe",true,'id');
        
           delete_records('ejercicios_profesor_actividad', 'id_profesor',$id_profesor,'id_ejercicio', $id_ejercicio);
     }
      function alterar(){
        
        //insert_record('ejercicios_tipo_puzzledoble',"pepe",true,'id');
        update_record('ejercicios_profesor_actividad', $this, false);

 
     }
    
     function obtener_uno($id){
         $ejer = get_record('ejercicios_profesor_actividad', 'id', $id);
         $this->id=$ejer->id;
         $this->id_profesor=$ejer->id_profesor;
         $this->id_ejercicio=$ejer->id_ejercicio;
   
         $this->carpeta=$ejer->carpeta;
         
          return $this;

    }
    
     function obtener_uno_idejercicio($id_ejercicio){
        
         $ejer = get_record('ejercicios_profesor_actividad', 'id_ejrecicio', $id_ejercicio);
         $this->id=$ejer->id;
         $this->id_profesor=$ejer->id_profesor;
         $this->id_ejercicio=$ejer->id_ejericio;
         $this->carpeta=$ejer->carpeta;
         
         return $this;
          
    }
    
       function obtener_todos_idejercicio($id_ejercicio){
        
              //  echo "entra".$id_profesor;

                $sql = 'SELECT * FROM  mdl_ejercicios_profesor_actividad WHERE id_ejercicio='.$id_ejercicio;

                $todos = get_records_sql($sql);

                $todos_mis_ejercicios = array();

                    foreach ($todos as $cosa) {

                            $mp = new Ejercicios_profesor_actividad();

                            $mp->obtener_uno($cosa->id);
                 //           echo $cosa->id." aaa";
                            $todos_mis_ejercicios[] = $mp;


                        }
              //  echo "sale";
                return $todos_mis_ejercicios;
               
      }
    
      function obtener_ejercicos_del_profesor($id_profesor) {
        
              //  echo "entra".$id_profesor;

                $sql = 'SELECT * FROM  mdl_ejercicios_profesor_actividad WHERE id_profesor='.$id_profesor;

                $todos = get_records_sql($sql);

                $todos_mis_ejercicios = array();

                    foreach ($todos as $cosa) {

                            $mp = new Ejercicios_profesor_actividad();

                            $mp->obtener_uno($cosa->id);
                 //           echo $cosa->id." aaa";
                            $todos_mis_ejercicios[] = $mp;


                        }
              //  echo "sale";
                return $todos_mis_ejercicios;
               
      }
      
          function obtener_ejercicos_del_profesor_carpeta($id_profesor) {
        
                //echo "entra".$id_profesor;

                $sql = 'SELECT DISTINCT(carpeta) FROM mdl_ejercicios_profesor_actividad WHERE id_profesor='.$id_profesor;

                $todos = get_records_sql($sql);

                $todos_mis_ejercicios = array();

                    foreach ($todos as $cosa) {

                            $mp = new Ejercicios_profesor_actividad();

                            $mp->carpeta=$cosa->carpeta;
                  
                            $todos_mis_ejercicios[] = $mp;



                        }
              //  echo "sale";
                return $todos_mis_ejercicios;
               
      }
      
           function obtener_ejercicos_del_profesor_por_carpetas($id_profesor,$carpeta) {
        
          
               

                $sql = 'SELECT * FROM  mdl_ejercicios_profesor_actividad WHERE id_profesor='.$id_profesor.' and carpeta="'.$carpeta.'"';

                $todos = get_records_sql($sql);

                $todos_mis_ejercicios = array();

                    foreach ($todos as $cosa) {
                        
                            $mp = new Ejercicios_profesor_actividad();

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
       var $Pregunta;
       var $Respuesta;
       var $Correcta;
    
       //Contructor
       function Ejercicios_texto_texto($id=NULL,$id_ejercicio=NULL,$numeropregunta=NULL,$Pregunta=NULL,$Respuesta=NULL,$Correcta=NULL){
           
                $this->id=$id;
                $this->id_ejercicio=$id_ejercicio;
                $this->numeropregunta=$numeropregunta;
                $this->Pregunta=$Pregunta;
                $this->Respuesta=$Respuesta;
                $this->Correcta=$Correcta;
                
                    
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
             case 'Pregunta':
                return $this->Pregunta;
                break;
             case 'Respuesta':
                return $this->Respuesta;
                break;
            case 'Correcta':
                return $this->Correcta;
                break;

     
        }
    }
    
     function insertar(){
       
         $id=insert_record('ejercicios_texto_texto', $this, true);
         //Devuelve el identificador del ejercicios creado
 
         return $id;
    }
    
      function alterar(){
        
        //insert_record('ejercicios_tipo_puzzledoble',"pepe",true,'id');
        update_record('ejercicios_texto_texto', $this, false);

 
     }
     
        function borrar_id_ejercicio($id_ejercicio){   
                //insert_record('ejercicios_tipo_puzzledoble',"pepe",true,'id');

            delete_records('ejercicios_texto_texto', 'id_ejercicio', $id_ejercicio);
        }
    
       function obtener_uno($id){
         $ejer = get_record('ejercicios_texto_texto', 'id', $id);
         $this->id=$ejer->id;
         $this->id_ejercicio=$ejer->id_ejercicio;
         $this->numeropregunta=$ejer->numeropregunta;
         $this->Pregunta=$ejer->Pregunta;
         $this->Respuesta=$ejer->Respuesta;
         $this->Correcta=$ejer->Correcta;
        
          return $this;

    }
    
     function obtener_uno_name($name){
        
         $ejer = get_record('ejercicios_texto_texto', 'name', $name);
         $this->id=$ejer->id;
         $this->id_ejercicio=$ejer->id_ejercicio;
         $this->numeropregunta=$ejer->numeropregunta;
         $this->Pregunta=$ejer->Pregunta;
         $this->Respuesta=$ejer->Respuesta;
         $this->Correcta=$ejer->Correcta;
         
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
        
      
        $sql = 'SELECT * FROM  mdl_ejercicios_texto_texto WHERE id_ejercicio='.$id_ejercicio;
      
        $todos = get_records_sql($sql);
        
         $todos_mis_ejercicios = array();

               foreach ($todos as $cosa) {
                    
                     $mp = new Ejercicios_texto_texto();
                     
                     $mp->obtener_uno($cosa->id);
                     
                    $todos_mis_ejercicios[] = $mp;
                    
                  
                }
              
                
        return $todos_mis_ejercicios;
               
              
 
    }

       function obtener_ejercicios_texto_id_ejercicicio_numpreguntas($id_ejercicio,$numeropregunta) {
        
          
      
         $sql = 'SELECT * FROM  mdl_ejercicios_texto_texto WHERE id_ejercicio='.$id_ejercicio.' and numeropregunta='.$numeropregunta;
      
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
