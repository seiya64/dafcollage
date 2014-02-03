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
  Javier Castro Fernández (havidarou@gmail.com)
  Angel Biedma Mesa (tekeiro@gmail.com)

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
  GNU General Public License for more details. 
 */



 function genera_titulos($titulo, $tipo_creacion, $id_curso) {
    
    $cabecera = '<h1 id="h1" class="instrucciones"><span style="float:right;"><a style="font-size: 1.1em" id="id_cancellink" href="/moodle/mod/ejercicios/view.php?id='.$id_curso.'">'.get_string('Reset','ejercicios').'</a></span><div style="font-size:0.7em; height: 13px;"><i>'.$tipo_creacion.'</i></div><u style="
                font-size: 0.9em;">'.$titulo.'</u></h1>';
    return $cabecera;
 }
 
 /**
  * 
  * Genera un textarea para la introducción de fuentes en la creación de un ejercicio
  * @author Javier Castro Fernández
  * @param type $fuentes Texto a rellenar en el textarea
  * @param type $readonly Tag para añadir la propiedad readonly al textarea
  * @return string -
  */
 function genera_fuentes($fuentes, $readonly) {
    if ($readonly == "readonly"){
        $label = '<h4>'.get_string('fuentes', 'ejercicios').'</h4> <textarea readonly style="width:100%;" id="fuentes" name="fuentes" wrap="virtual" rows="5" cols="80">'. $fuentes.'</textarea>';      
    }
    else {
        $label = '<h4>'.get_string('fuentes', 'ejercicios').'</h4> <textarea style="width:100%;" id="fuentes" name="fuentes" wrap="virtual" rows="5" cols="80">'. $fuentes.'</textarea>';      
    }
    return $label;  
 }
 
  /**
  * 
  * Genera una descripción para los ejercicios (un tag <i> dentro de uno <div>)
  * @author Javier Castro Fernández
  * @param type $descripcion Texto con la descripción
  * @return string -
  */
 function genera_descripcion($descripcion) {
    $label = '<div style="font-size:1.2em" class=descover><i>' . nl2br((stripslashes($descripcion))) . '<br/></i></div>';
    return $label;  
 }
 
 /**
  * 
  * Genera una descripción para la autoría de los ejercicios con el nombre del profesor
  * @author Javier Castro Fernández
  * @param type $autor Nombre del autor del ejercicio
  * @return string -
  */
 function genera_autoria($autor) {
    $label = '<div style="font-size:1.2em" class=descover><i><br/><b>'.get_string("autoria", "ejercicios"). " ". $autor->firstname . " " . $autor->lastname . '<b><br/></i></div>';
    return $label;  
 }
 
  /**
  * 
  * Imagen y referencia a la licencia
  * @author Javier Castro Fernández
  * @param type $tipoLicencia Nombre del autor del ejercicio
  * @return string -
  */
 function genera_licencia($tipoLicencia) {
     
     switch ($tipoLicencia) {
         case 1: //"cc-by"
             $ref = "http://creativecommons.org/licenses/by/4.0";
             $licenciaConLetra = "cc-by";
             break;
         case 2: //"cc-by-sa"
             $ref = "http://creativecommons.org/licenses/by-sa/4.0";
             $licenciaConLetra = "cc-by-sa";
             break;
         case 3: //"cc-by-nd"
             $ref = "http://creativecommons.org/licenses/by-nd/4.0";
             $licenciaConLetra = "cc-by-nd";
             break;
         case 4: //"cc-by-nc"
             $ref = "http://creativecommons.org/licenses/by-nc/4.0";
             $licenciaConLetra = "cc-by-nc";
             break;
         case 5: //"cc-by-nc-sa"
             $ref = "http://creativecommons.org/licenses/by-nc-sa/4.0";
             $licenciaConLetra = "cc-by-nc-sa";
             break;
         case 6: //"cc-by-nc-nd"
             $ref = "http://creativecommons.org/licenses/by-nc-nd/4.0";
             $licenciaConLetra = "cc-by-nc-nd";
             break;
         default:
             $ref = get_string("licenciaGenerada", "ejercicios");
     }
    $label = '<a href="'.$ref.'" target="_blank"><img id="imglicencia" src="./imagenes/'.$licenciaConLetra.'.png"   alt="'.get_string("altLicencia", "ejercicios").'"></img></a><br/>';
    return $label;  
 }
?>
