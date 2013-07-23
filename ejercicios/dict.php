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


/**
 * @author Angel Biedma Mesa
 * 
 * La finalidad de este script es ser llamado desde Javascript y actuara como
 * diccionario de idiomas, como una interfaz de los archivos que se encuentran en la carpeta lang
 * Entonces desde Javascript se le pedira una determinada cadena de idioma pasandole el codigo
 * de la cadena como parametro GET (parametro codlang) y segun el idioma actual le devolvera 
 * en JSON la cadena de idioma determinada.
 * Para ser llamado desde Javascript se ha incluido en el archivo funciones.js la funcion getCadLang que recibe
 * un codigo de cadena de idiomas y un manejador que actuara cuando se reciba la cadena.
 */

/**
* Parametros a pasar a dict
* num (Entero) Indica el numero de ids a pasar
* id<N> (Cadena) Son los distintos codigos de cadena de idioma
*/

/**
* Lo que se recibe de dict es un objeto JSON con el siguiente formato
* codigoIdioma => (Cadena) cadenaIdioma
* donde codigoIdioma es el codigo de la cadena de idioma y 
* la cadenaIdioma es la cadena de idioma
*/

require_once("../../config.php");
require_once("lib.php");
require_once("clase_log.php");

header('Content-type: application/json');

$log = new Log("log_dict.txt","a");


$num = $_POST['num'];
$ids=array();
for($k=1; $k<=$num; $k++) {
    $id = $_POST['id'.$k]; 
    $ids[$id]=get_string($id,'ejercicios');
}

$resp = json_encode($ids);
$log->write("cod: " . $id . "\t response: " . $resp);
$log->close();

echo json_encode($resp);
?>
