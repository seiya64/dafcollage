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
  Javier Castro Fernández (havidarou@gmail.com)
  Carlos Aguilar Miguel (cagmiteleco@gmail.com)
  Borja Arroba Hernández (b.arroba.h@gmail.com)

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
global $CFG;
global $USER;

$valid_exts = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
$max_size = 200 * 1024; // max file size
$path = $CFG->dataroot . '/temp/' . $USER->id . '/'; // upload directory

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_FILES['image'])) {
        // get uploaded file extension
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        // looking for format and size validity
        if (in_array($ext, $valid_exts) AND $_FILES['image']['size'] < $max_size) {
            //$image_unique_name = uniqid();
            $image_unique_name = substr( md5( $USER->id ), 0, 10 );
            //$path = $path . $image_unique_name . '.' . $ext;
            $path = $path . $image_unique_name;
            // move uploaded file from temp to uploads directory
            //echo 'otra evz '.$path;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
                echo './ejercicios_get_imagen.php?userPath='.$USER->id.'&name='.$image_unique_name.'&ubicacion=1';
            }
        } else {
            echo 'Invalid file!';
        }
    } else {
        echo 'File not uploaded!';
    }
} else {
    echo 'Bad request!';
}

?>