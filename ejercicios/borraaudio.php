<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$id_ejercicio = $_GET['id_ejercicio'];
$num_preg = $_GET['numpreg'];
$num_resp = $_GET['numresp'];
$total_resp = $_GET['totalResp'];

$fichero = @fopen("log.txt","w");
$log = "Id_Ejercicio: " . $id_ejercicio . "\n";
$log .= "Num preg: " . $num_preg . "\n";
$log .= "Num resp: " . $num_resp . "\n";
$log .= "Total Resp: " . $total_resp . "\n";
fwrite($fichero,$log,strlen($log));



for ($i=$num_resp; $i<=$total_resp-1; $i++) {
    $carpeta = "./mediaplayer/audios/";
    $source = "audio_" . $id_ejercicio . "_" . $num_preg . "_" . ($i+1) . ".mp3";
    $dest = "audio_" . $id_ejercicio . "_" . $num_preg . "_" . $i . ".mp3";
    $log = "";
    $log.="Iteracion: " .$i . "\n";
    $log.="Source: " . $carpeta.$source . "\n";
    $log.="Dest: " . $carpeta.$dest . "\n";
    if(copy($carpeta.$source,$carpeta.$dest)) {
        $log .= "Movido archivo de: " . $carpeta.$source . " a " . $carpeta.$dest + "\n";
    }
    else {
        $log .= "Fallo el Movido archivo de: " . $carpeta.$source . " a " . $carpeta.$dest . "\n";
    }
}

fwrite($fichero,$log,strlen($log));
fclose($fichero);
?>
