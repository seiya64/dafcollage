<?php

//
// Coordination:
// Ruth Burbat
//
// Source code:
// Ramón Rueda Delgado (ramonruedadelgado@gmail.com)
// Luis Redondo Expósito (luis.redondo.exposito@gmail.com)
// 
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This file replaces the legacy STATEMENTS section in db/install.xml,
 * lib.php/modulename_install() post installation hook and partially defaults.php
 *
 * @package    mod_vocabulario
 * @copyright  2011 Your Name <your@email.adress>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Post installation procedure
 *
 * @see upgrade_plugins_modules()
 */

defined('MOODLE_INTERNAL') || die;

function xmldb_vocabulario_install() {

    //En primer lugar, nos conectamos con nuestra base de datos en phpmyadmin para
    //importar los datos.
    global $CFG;
    //Con la llamada a esta función, podemos conectarnos a nuestra base de datos.
    $conn = mysql_connect($CFG->dbhost, $CFG->dbuser, $CFG->dbpass);
    //Comprobamos si la conexión se ha realizado correctamente
    if(! $conn )
    {
        die('No se ha podido conectar con la base de datos: ' . mysql_error());
    }
    //A continuación, seleccionamos la base de datos donde queremos realizar la inserción
    //de datos
    mysql_select_db('moodle26');
    //Creamos un array con el nombre de todas las tablas que deseamos importar.
    $filenames = array(
            'camposlexicos_de', 
            'camposlexicos_en', 
            'camposlexicos_es', 
            'camposlexicos_fr',
            'camposlexicos_pl',
            'intenciones_de', 
            'intenciones_en', 
            'intenciones_es', 
            'intenciones_fr',
            'intenciones_pl',
            'tipologias_de', 
            'tipologias_en', 
            'tipologias_es', 
            'tipologias_fr',
            'tipologias_pl',
            'adjetivos',
            'estrategias',
            'otros',
            'sustantivos',
            'verbos',
            'gramatica'
            );
    //En el fichero vocabulariobackupvacio.sql se encuentran las instrucciones necesarias
    //para crear las tablas oportunas en la base de datos moodle.
    $crear='/home/dafcollage/cuaderno_digital/vocabulario/db/dataxmls/vocabulariobackupvacio.sql';
    $sql = "LOAD DATA INFILE '$crear' INTO DATABASE moodle26";
    //Recorremos todos los ficheros *.sql
    foreach ($filenames as $filename) {

            $table_name = "mdl_vocabulario_".$filename;
            //Para poder cargar cada fichero *.sql, debemos darle permisos a la ruta
            //que especifica abajo.
            $backup_file  = '/var/lib/mysql/moodle28des/'.$filename.'.sql';
            //para cada tabla, insertamos sus datos correspondientes.
            $sql = "LOAD DATA INFILE '$backup_file' INTO TABLE $table_name";
            $retval = mysql_query( $sql, $conn );
            //Comprobamos si la inserción se ha realizado correctamente.
            if(! $retval )
            {
                    die('Los datos no han podido ser cargados: ' .mysql_error());
            }
    }
    

    //Si todo ha salido bien, mostramos un mensaje diciendo que todo está OK y cerramos
    //la conexión con la base de datos.
    echo "Los datos se han cargado correctamente. \n";
    mysql_close($conn);

   
}

/**
 * Post installation recovery procedure
 *
 * @see upgrade_plugins_modules()
 */
function xmldb_vocabulario_install_recovery() {
}
