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
  GNU General Public License for more details. */

$id_ejercicio = $_GET['id_ejercicio'];
$num_preg = $_GET['numpreg'];
$totalPregs = $_GET['totalPregs'];
$carpeta = $_GET['directorio'];
$nombre_archivo = $_GET['archivo'];
$extension = $_GET['extension'];

$fichero = @fopen("log_borrapregunta.txt","w");
$log = "Id_Ejercicio: " . $id_ejercicio . "\n";
$log .= "Nueva versionnnnn\n";
$log .= "Num preg: " . $num_preg . "\n";
$log .= "Total Pregs: " . $totalPregs . "\n";
$log .= "Carpeta: " . $carpeta . "\n";
$log .= "Nombre Archivo: " . $nombre_archivo . "\n";
$log .= "Extension: " . $extension . "\n";


/**
 * Descompone el nombre de los archivos de audio con el siguiente formato: "audio_<id-ejercicio>_<num-preg>_<num-resp>.mp3"
 * en un array del siguiente formato [<id-ejercicio>,<num-preg>,<num-resp>]
 * @param String $nombre_archivo Cadena con el nombre del archivo de audio
 * @return array Array con los datos obtenidos a partir del nombre del archivo
 */
function descompone_nombre_archivo($nombre_archivo) {
    if(preg_match("/^([a-zA-Z]+)_([0-9]+)_([0-9]+)_([0-9]+)\.([a-zA-Z0-9]+)$/", $nombre_archivo)) {
        $log.="Cumple la primera expresion regular\n";
        $lista = split("_",$nombre_archivo);
        $retorno = array();
        $retorno[] = $lista[1];
        $retorno[] = $lista[2];
        $lista[3] = str_replace(".mp3","",$lista[3]);
        $lista[3] = str_replace(".jpg","",$lista[3]);
        $retorno[] = $lista[3];
        return $retorno;
    }
    elseif (preg_match("/^([a-zA-Z]+)_([0-9]+)_([0-9]+)\.([a-zA-Z0-9]+)$/", $nombre_archivo)) {
        $log.="Cumple la segunda expresion regular\n";
        $lista = split("_",$nombre_archivo);
        $retorno = array();
        $retorno[] = $lista[1];
        $lista[2] = str_replace(".mp3","",$lista[2]);
        $lista[2] = str_replace(".jpg","",$lista[2]);
        $retorno[] = $lista[2];
        return $retorno;
    }
    else {
        $log.="No cumple ninguna expresion regular\n";
        return array();
    }
}

/**
 * Va listando el directorio del audio y:
 *   - Elimina los archivos de audio de la pregunta que se ha borrado
 *   - Para los archivos de audio de las preguntas cuyo numero de pregunta es mayor al de la pregunta que se ha borrado,
 *   se renombra los archivos para ajustarlos correctamente
 */
if(is_dir($carpeta)) {
    if($dh = opendir($carpeta)){
        while(($file = readdir($dh))!== false) {
            $log .= "Archivo listado: " .$file."\n";
            $l = descompone_nombre_archivo($file);
            if (sizeof($l)==3)      $log.="3.Descomposicion: id_ejercicio: " . $l[0] . " num_preg: " . $l[1] . " num_resp: " . $l[2] . "\n";
            elseif(sizeof($l)==2)   $log.="2.Descomposicion: id_ejercicio: " . $l[0] . " num_preg: " . $l[1] .  "\n"; 
            if(sizeof($l)>0) {
                if ($l[0]==$id_ejercicio) {
                    $log.="Numero de ejercicio correcto.\n";
                    if($l[1]==$num_preg) {
                        $log.="Es el numero de pregunta que se esta borrando.\n";
                        if(unlink($carpeta.$file)) {
                            $log.="Borrado el archivo: " . $carpeta.$file . "\n";
                        }
                        else {
                            $log.="No se ha podido borrar el archivo: " . $carpeta.$file . "\n";
                        }
                    }
                    elseif ($l[1]>$num_preg) {
                        if (sizeof($l)==3)      $nuevo = $nombre_archivo.$id_ejercicio."_".($l[1]-1)."_".$l[2].$extension;
                        elseif(sizeof($l)==2)   $nuevo = $nombre_archivo.$id_ejercicio."_".($l[1]-1).$extension;
                        if(copy($carpeta.$file, $carpeta.$nuevo)) {
                            $log.="Se ha movido de " . $carpeta.$file . " a " . $carpeta.$nuevo . "\n";
                        }
                        else {
                            $log.="Error al mover de " . $carpeta.$file . " a " . $carpeta.$nuevo . "\n";
                        }
                        unlink($carpeta.$file);
                    }
                }
            }
            else {
                $log .= "Fallo la funcion: descompone_nombre_archivo\n";
            }
        }
    }
    else {
        $log.="Fallo en la funcion opendir\n";
    }    
}
else {
    $log.="No es un directorio Ruta: ".$carpeta."\n";
}

fwrite($fichero,$log,strlen($log));
fclose($fichero);

?>
