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
$name_ej = optional_param('name', 0, PARAM_TEXT);

global $CFG;
$mform = new  mod_ejercicios_puzzle_form_paso2($id_curso,$name_ej);
$mform->pintarinterfaz2($id_curso,$name_ej);

/*código con la acción consecuente de eliminar... */
global $CFG;

//vemos que botón hemos pulsado
  if ($mform->is_submitted()) { //Boton aceptar
   
  
        //guardamos el ejercicio en la bd
    
        
        //Obtengo ele ejercicio de la bd
        $ejercicios_bd = new Ejercicios_mis_puzzledoble();
        $ejercicios_leido =$ejercicios_bd->obtener_uno_name($name_ej);
      
  if(required_param('oculto', PARAM_INT)!=3){   #si el ejercicio es de imagenes o video
     //subida de ficheros
    if(count($_FILES)>0) {
     
      $i=1;
            //obtenemos todos los archivos uno por uno
            foreach($_FILES as $name => $values){

                //comprobamos que esten en la carpeta que nosotros queremos
                if( move_uploaded_file($values['tmp_name'],'/var/www/moodle/mod/ejercicios/imagenes/'.$name_ej.'_'.$i) ){

                    echo 'El archivo ha sido subido correctamente.<br/>';
                    echo 'Nombre original del archivo: '.         $values['name'].      '<br/>';
                     $i++;

                } else {
                    //si no estan en la carpeta que nosotros queremos
                    echo 'Ha ocurrido un error.<br/>';

                }
            }

        }
    }
   //leo un ejercicio y lo guardo
        $ejercicio_alterar = new Ejercicios_mis_puzzledoble($ejercicios_leido->get('name'),$ejercicios_leido->get('nrespuestas'),$ejercicios_leido->get('ctipo'),$ejercicios_leido->get('elemaso'),$ejercicios_leido->get('id'));

       if(required_param('oculto', PARAM_INT)==3){ //Si es un ejercicio del tipo Palabra descripcion añado las palabaras
       
          
                for($i=1;$i<=$ejercicios_leido->get('nrespuestas');$i++){
                $ejercicio_alterar->set_palabras(required_param('palabra'.$i, PARAM_TEXT),$i);

                }
       }
       
       
        for($i=1;$i<=$ejercicios_leido->get('nrespuestas');$i++){
          $ejercicio_alterar->set_descripcion(required_param('descripcion'.$i, PARAM_TEXT),$i);

        }
     
        $ejercicio_alterar->alterar();

       if(required_param('oculto', PARAM_INT)==1){
           redirect('./view.php?id=' . $id_curso . '&opcion=2&name_ej='.$name_ej.'&tipo=1');
       }else{
           if(required_param('oculto', PARAM_INT)==2){
           redirect('./view.php?id=' . $id_curso . '&opcion=2&name_ej='.$name_ej.'&tipo=2');
           }else{
             redirect('./view.php?id=' . $id_curso . '&opcion=2&name_ej='.$name_ej.'&tipo=3');
              
           }
       }
       
     //
  //}


}



?>
