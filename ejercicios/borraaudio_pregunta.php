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

$fichero = @fopen("log_borraaudio_pregunta.txt","w");
$log = "Id_Ejercicio: " . $id_ejercicio . "\n";
$log .= "Num preg: " . $num_preg . "\n";
$log .= "Total Pregs: " . $totalPregs . "\n";


/**
 * Descompone el nombre de los archivos de audio con el siguiente formato: "audio_<id-ejercicio>_<num-preg>_<num-resp>.mp3"
 * en un array del siguiente formato [<id-ejercicio>,<num-preg>,<num-resp>]
 * @param String $nombre_archivo Cadena con el nombre del archivo de audio
 * @return array Array con los datos obtenidos a partir del nombre del archivo
 */
function descompone_nombre_archivo($nombre_archivo) {
    if(preg_match("/^audio_([0-9]+)_([0-9]+)_([0-9]+)\.mp3$/", $nombre_archivo)) {
        $lista = split("_",$nombre_archivo);
        $retorno = array();
        $retorno[] = $lista[1];
        $retorno[] = $lista[2];
        $lista[3] = str_replace(".mp3","",$lista[3]);
        $retorno[] = $lista[3];
        return $retorno;
    }
    else {
        return array();
    }
}


$carpeta = "./mediaplayer/audios/";
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
            $log.="Descomposicion: id_ejercicio: " . $l[0] . " num_preg: " . $l[1] . " num_resp: " . $l[2] . "\n";
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
                        $nuevo = "audio_".$id_ejercicio."_".($l[1]-1)."_".$l[2].".mp3";
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
