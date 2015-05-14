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
  Luis Redondo Expósito (luis.redondo.exposito@gmail.com)
  Ramón Rueda Delgado (ramonruedadelgado@gmail.com)

  Original idea:
  Ruth Burbat

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
require_once("vocabulario_classes.php");
require_once("vocabulario_formularios.php");

session_start();

$_SESSION["ELEGIRIDIOMA"] = $_POST["elegirIdioma"];
$_SESSION["TEMATICA"] = $_POST["tematica"];
$_SESSION["NUMPALABRAS"] = $_POST["numPalabras"];


redirect('./view.php?id=2&opcion=19');

?>

 