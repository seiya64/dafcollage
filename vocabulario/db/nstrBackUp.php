<?php

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


/******************************************************************************
 * Función que se conecta a la bse de datos moodle19pro y realiza una copia de todos
 * los datos pertenecientes a las tablas mdl_vocabulario_*
 ******************************************************************************/

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'Daf-Collage*';
//Nos conectamos a la base de datos
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
//Comprobamos que la conexión se ha realizado correctamente
if(! $conn )
{
        die('No se ha podido conectar con la base de datos: ' . mysql_error());
}
//Seleccionamos la base de datos a la que queremos acceder...
mysql_select_db('moodle19des');

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


function eliminaNumeros($filename){

    //necesitamos renombrar el fichero, porque con la función fopen no podemos leer
    $copia = $filename;
    $filename = $filename . ".sql";

    $fp = fopen("/tmp/".$filename, "a+");	
    $res = fopen("/home/dafcollage/Escritorio/salida".$filename,"w");

    while(!feof($fp)){
            $linea = fgets($fp);
            $columnas = explode("\t", $linea);
            //Con esta expresión regular lo que hacemos es eliminar de la última columna
            //los números seguidos o no de puntos
            $aux = preg_replace('/[0-9]+./', '', $columnas[3]);
            //Una vez hemos modificado la columna, escribimos el resultado en un fichero 
            //de salida, y ya estaría listo para instalarlo.
            fwrite($res,$columnas[0]."\t".$columnas[1]."\t".$columnas[2]."\t".$aux);		
    }	

    rename("/home/dafcollage/Escritorio/salida".$filename, "/tmp/".$filename);
   // copy("/home/dafcollage/Escritorio/salida".$filename, "/tmp/".$filename);
    fclose($res);
    fclose($fp);    
	
    return $copia;
}


//Recorremos todas las tablas a las que queremos hacer la copia
foreach ($filenames as $filename) {
    
        $table_name = "mdl_vocabulario_".$filename;
        $backup_file  = "/tmp/".$filename.".sql";
        //Para cada tabla realizamos una copia y la almacenamos en /tmp
        $sql = "SELECT * INTO OUTFILE '$backup_file' FROM $table_name";

        $retval = mysql_query( $sql, $conn );
        //Comprobamos si se ha realizado la operación correctamente
        if(! $retval )
        {
                die('No ha sido posible realizar la copia de seguridad: ' . mysql_error());
        }
        if ($filename == 'camposlexicos_de' || $filename == 'camposlexicos_en'
                || $filename == 'camposlexicos_es' || $filename == 'camposlexicos_fr'
                || $filename == 'camposlexicos_pl' || $filename == 'gramatica'){
            
            $filename = eliminaNumeros($filename);
        } 

}
//Si todo ha salido OK, mostramos un mensaje y cerramos la conexión con 
//la base de datos.
echo "La copia de la base de datos se ha realizado correctamente. \n";
mysql_close($conn);
?>
