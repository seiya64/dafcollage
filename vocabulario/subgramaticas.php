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

require_once("../../config.php");
require_once("$CFG->libdir/form/select.php");
require_once("lib.php");
require_once("vocabulario_classes.php");

$id = $_GET["id"];
$nombre = $_GET["nombre"];
$finalgramatica = $_GET["aux"];

//echo "estoy aquí con ".$id." y ".$nombre;
$graux = new Vocabulario_gramatica();
$graux = $graux->obtener_hijos($USER->id, $id);
if (count($graux) > 1) {
    echo '<div class="fitemtitle"></div>';
    echo '<div class="felement fselect">';
    $elselect = new MoodleQuickForm_select($nombre, 'Subgramatica', $graux, "id=\"id_grid" . $id . "\" onChange='javascript:cargaContenido(this.id,\"" . $nombre . "grgeneraldinamico" . $id . "\",1,\"".$finalgramatica."\")'");
    echo $elselect->toHtml();
    echo '</div>';
    echo "<div class=\"fitem\" id=\"" . $nombre . "grgeneraldinamico" . $id . "\" style=\"min-height: 0;\"></div>";
}
?>
