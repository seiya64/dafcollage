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
$num_resp = $_GET['numresp'];
$total_resp = $_GET['totalResp'];
$carpeta = $_GET['directorio'];
$nombre_archivo = $_GET['archivo'];
$extension = $_GET['extension'];

$fichero = @fopen("log_borrarespuesta.txt","w");
$log = "Id_Ejercicio: " . $id_ejercicio . "\n";
$log .= "Num preg: " . $num_preg . "\n";
$log .= "Num resp: " . $num_resp . "\n";
$log .= "Total Resp: " . $total_resp . "\n";
$log .= "Directorio: " . $carpeta . "\n";
$log .= "Nombre Archivo: " . $nombre_archivo . "\n";
$log .= "Extension: " . $extension . "\n";
fwrite($fichero,$log,strlen($log));


/**
 * Para un ejercicio con id I, cuyo numero de pregunta es P, y el numero de respuesta que queremos borrar es K
 * Cambia los archivos de audio tales que cumplen que su nombre es: "audio_I_P_X" y X>K, se renombra a: "audio_I_P_(X-1)"
 * Se borra el archivo de audio con la ultima respuesta para el numero de pregunta dado.
 */
for ($i=$num_resp; $i<=$total_resp-1; $i++) {
    //$carpeta = "./mediaplayer/audios/";
    $source = $nombre_archivo . $id_ejercicio . "_" . $num_preg . "_" . ($i+1) . $extension;
    $dest = $nombre_archivo . $id_ejercicio . "_" . $num_preg . "_" . $i . $extension;
    $log = "";
    $log.="Iteracion: " .$i . "\n";
    $log.="Source: " . $carpeta.$source . "\n";
    $log.="Dest: " . $carpeta.$dest . "\n";
    if(copy($carpeta.$source,$carpeta.$dest)) {
        $log .= "Movido archivo de: " . $carpeta.$source . " a " . $carpeta.$dest . "\n";
    }
    else {
        $log .= "Fallo el Movido archivo de: " . $carpeta.$source . " a " . $carpeta.$dest . "\n";
    }
}
$ultimo = $nombre_archivo . $id_ejercicio . "_" . $num_preg . "_" . $total_resp . $extension;
if(unlink($carpeta.$ultimo)) {
    $log .= "Borrado con exito el archivo: " . $carpeta.$ultimo . "\n";
}
else {
    $log .= "Error al borrar el archivo: " . $carpeta.$ultimo . "\n";
}

fwrite($fichero,$log,strlen($log));
fclose($fichero);
?>
