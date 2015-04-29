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

/**
 * Clase que permite trabajar comodamente con un archivo de log
 * 
 * @author Angel Biedma Mesa
 */
class Logi 
{
    private $file;
    
    /**
     * Constructor
     * @param String $namefile Nombre del archivo de Log
     * @param String $atributos Atributos para fopen
     */
    public function Logi($namefile,$atributos="w") {
        $this->file = fopen($namefile,$atributos);
    }
    
    /**
     * Escribe una cadena en el archivo de log
     * @param String $cadena Cadena a escribir
     */
    public function write($cadena) {
        fwrite($this->file,$cadena."\n",strlen($cadena)+1);
    }
    
    /**
     * Cierra el archivo
     */
    public function close() {
        fclose($this->file);
    }
}

?>
