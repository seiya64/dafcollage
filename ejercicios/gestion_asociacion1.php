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
  Serafina Molina Soto(finamolina@gmail.com)

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

require_once("../../config.php");
require_once("lib.php");
require_once("ejercicios_clases.php");
require_once("ejercicios_form.php");

$id_curso = optional_param('id_curso', 0, PARAM_INT);
$name_ej=required_param('nombre_ejercicio', PARAM_TEXT);
global $CFG;
$mform = new  mod_ejercicios_puzzle_form();
$mform->pintarinterfaz($id_curso);

/*código con la acción consecuente de eliminar... */
global $CFG;
if ($mform->is_cancelled()) { //Elimino el ejercicio

     if (optional_param('menuprincipal')) {

        redirect('./view.php?id=' . $id_curso . '&opcion=0');

     }else{
        $datos = optional_param('puzzle_creados',0,PARAM_INT);
        
        $ejercicios_bd = new Ejercicios_mis_puzzledoble();
        $ejercicio_mio =$ejercicios_bd->obtener_uno($datos);
        
        #borramos las imagenes o videos
        $name_ej=$ejercicio_mio->get('name');
       
        for($i=1;$i<=$ejercicio_mio->get('nrespuestas');$i++ ){ //Cuantas fotos tengo
                   
                if(file_exists('/var/www/moodle/mod/ejercicios/imagenes/'.$name_ej.'_'.$i)) 
                { 
                if(unlink('/var/www/moodle/mod/ejercicios/imagenes/'.$name_ej.'_'.$i)) 
                print "El archivo fue borrado"; 
                } 
                else 
                print "Este archivo no existe"; 


        }
      
        #borramos el ejrcicio de la bd
        delete_records('ejercicios_tipo_puzzle', 'id', $datos);
        redirect('./view.php?id=' . $id_curso . '&opcion=1');
       
       
        
        
     }
     
}else{ //Código de aceptar

  if ($mform->is_submitted()) { //Boton aceptar
        $error=0;
        //guardamos el ejercicio en la bd
        //para ello recuperamos el nombre
        $ej=required_param('nombre_ejercicio', PARAM_TEXT);
        //Comprobamos que el nombre no existe ya en la bd
        $ejercicios_bd = new Ejercicios_mis_puzzledoble();
         $ejercicios_todos =$ejercicios_bd->obtener_todos();
        foreach( $ejercicios_todos as $ej_bd){
            if($ej_bd->get('name')==$ej){ //Si el ejercico ya existe muestro un error en el nombre
                   //volvemos a la pagina principal
                  $error=1;
                  redirect('./view.php?id=' . $id_curso . '&opcion=1&error=1');
            }
        }

        if($error!=1){ //Si no ha habido error
             $nelem=required_param('numeroimagenes', PARAM_INT);
             $Classtipo=required_param('ClasificacionTipo', PARAM_TEXT);
             $elemAsociacion=required_param('comb', PARAM_TEXT);
             echo $nelem+1;
             echo $Classtipo;
             echo $elemAsociacion;
           
        
        //leo un ejercicio y lo guardo
        $ejercicio_leido = new Ejercicios_mis_puzzledoble(required_param('nombre_ejercicio', PARAM_TEXT),$nelem+1,$Classtipo,$elemAsociacion);

        $ejercicio_leido->insertar();


        //mostramos el ejercicio creado
        redirect('./view.php?id=' . $id_curso . '&opcion=3&name_ej='.required_param('nombre_ejercicio', PARAM_TEXT));
        }
  }


}



?>
