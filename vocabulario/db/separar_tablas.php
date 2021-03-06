<?php
header("Content-Type:text/html; charset=utf-8"); 
/*
  Daf-collage is made up of two Moodle modules which help in the process of
  German language learning. It facilitates the content organization like
  vocabulary or the main grammar features and gives the chance to create
  exercises in order to consolidate knowledge.

  Copyright (C) 2011

  Coordination:
  Ruth Burbat

  Source code:
  Ramon Rueda Delgado (ramonruedadelgado@gmail.com)
  Luis Redondo Exposito (luis.redondo.exposito@gmail.com)

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

//Función que se encarga de separar las tablas de una copia de seguridad de 
//moodle 1.9, con el objetivo de poder migrar la base de datos de moodle 1.9 a 
//moodle 2.8.

//Función que separa las tablas de vocabulario moodle 1.9 del resto de las tablas.
function obtenerTablasVocabulario($nombreFichero, $cadenaBuscar, $destino)
{
    $fp = fopen("/home/dafcollage/Escritorio/salida/".$nombreFichero.".sql","a+");
    $res = fopen("/home/dafcollage/Escritorio/salida/".$destino.".sql","w");
    $busca = "INTO `mdl_vocabulario_".$cadenaBuscar."` VALUES ";
    $i = strlen($busca) + strlen("INSERT ");

    while (!feof($fp))
    {
        $linea = fgets($fp);
        $tope = strlen($linea);
        $encontrado = strpos($linea,$busca);
        $aux = false;
        if ($encontrado == true)
        {
            while($i < $tope)
            {
                $cad = substr($linea,$i,2);
                if($cad == '),')
                {
                    fwrite($res,"\n");
                    $aux = true;
                }
                else {
                    if($cad[0] != '(' && $cad[0] != ')' && $cad[0] != ',' && $cad[0] != "'")
                    {
                        fwrite($res,$cad[0]);
                    }
                    if ($cad[0] == ',')
                    {
                        if ($aux == false)
                        {
                            fwrite($res,"\t");
                        }
                        else
                        {
                            $aux = false;
                        }
                    }
                }
                $i++;
            }
            
        }
    }
    fclose($fp);
    fclose($res);
}

function sustituir()
{
    $cadena="m1añana1Ó";
    echo "antes ".$cadena."\n";
    $res = preg_replace('/[0-9]+/', '', $cadena);
    echo "despues ".$res."\n";

}

function eliminaNumeros($filename){
    
    $filename = $filename . ".sql";

    $fp = fopen("/home/dafcollage/Escritorio/salida/".$filename, "a+");	
    $res = fopen("/home/dafcollage/Escritorio/res/".$filename,"w");

    while(!feof($fp)){
            $linea = fgets($fp);
           
          // $columnas = explode("\t", $linea);
            //Con esta expresión regular lo que hacemos es eliminar de la última columna
            //los números seguidos o no de puntos
         //   $aux = preg_replace('/[0-9]/', '', $columnas[3]);
            

           
           fputs($res,$linea);		

    }	

    //rename("/home/dafcollage/Escritorio/salida".$filename, "/tmp/".$filename);
   // copy("/home/dafcollage/Escritorio/salida".$filename, "/tmp/".$filename);
    fclose($res);
    fclose($fp);    
}

function obtenerTablaUsuarios($nombreFichero)
{
    //OJO! Cambiar path de los fichero.
    $fp = fopen("/home/luisre/Escritorio/".$nombreFichero.".sql","a+");
    $res = fopen("/home/luisre/Escritorio/salida/mdl_user.sql","w");
    $busca = "INTO `mdl_user` VALUES ";
    $i = strlen($busca) + strlen("INSERT ");

    while (!feof($fp))
    {
        $linea = fgets($fp);
        $tope = strlen($linea);
        $encontrado = strpos($linea,$busca);
        $aux = false;
        if ($encontrado == true)
        {
            while($i < $tope)
            {
                $cad = substr($linea,$i,2);
                if($cad == '),')
                {
                    fwrite($res,"\n");
                    $aux = true;
                }
                else {
                    if($cad[0] != '(' && $cad[0] != ')' && $cad[0] != ',' && $cad[0] != "'")
                    {
                        fwrite($res,$cad[0]);
                    }
                    if ($cad[0] == ',')
                    {
                        if ($aux == false)
                        {
                            fwrite($res,"\t");
                        }
                        else
                        {
                            $aux = false;
                        }
                    }
                }
                $i++;
            }
            
        }
    }
    fclose($fp);
    fclose($res);
}

//Función que transforma las tablas pertenecientes a moodle 1.9 a tablas con la
//estructura de moodle 2.8
function transformarTablas19To28($nombreFichero)
{
    
}

//Función que devuelve un fichero más pequeño. Inicialmente el fichero de la 
//copia de seguridad era muy grande y muy costoso de abrir.
function partirFichero($nombreFichero)
{
    $fp = fopen("/home/dafcollage/Escritorio/".$nombreFichero. ".sql", "a+");
    $res1 = fopen("/home/dafcollage/Escritorio/salida/copia1.txt","w");
    $res2 = fopen("/home/dafcollage/Escritorio/salida/copia2.txt","w");
    $res3 = fopen("/home/dafcollage/Escritorio/salida/copia3.txt","w");
    $res4 = fopen("/home/dafcollage/Escritorio/salida/copia4.txt","w");
    $res5 = fopen("/home/dafcollage/Escritorio/salida/copia5.txt","w");
    $res6 = fopen("/home/dafcollage/Escritorio/salida/copia6.txt","w");
    $res7 = fopen("/home/dafcollage/Escritorio/salida/copia7.txt","w");
    //Leemos hasta el final del fichero
    $n = 0;
    while (!feof($fp))
    {
        $linea = fgets($fp);
        $n++;
        if ($n < 991)
        {
            fwrite($res1,$linea);
        }
        elseif ($n > 991 && $n < 2006)
        {
            fwrite($res2,$linea);
        }
        elseif ($n > 2006 && $n < 2985)
        {
            fwrite($res3,$linea);
        }
        elseif ($n > 2985 && $n < 3990)
        {
            fwrite($res4,$linea);
        }
        elseif ($n > 3990 && $n < 5002)
        {
            fwrite($res5,$linea);
        }
        elseif ($n > 5002 && $n < 5985)
        {
            fwrite($res6,$linea);
        }
        elseif ($n > 5985)
        {
            fwrite($res7,$linea);
        }
    }
}

//partirFichero("copiaSeguridad");

$filenames = array(
           /* 'camposlexicos_de', 
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
            'gramatica'*/
             'mis_intenciones',
             'mis_gramaticas',
             'mis_estrategias',
             'mis_palabras',
             'mis_tipologias'
            );

foreach ($filenames as $filename)
{
    obtenerTablasVocabulario("copiaSeguridad",$filename, $filename);

}
//eliminaNumeros("intenciones_de");
//eliminaNumeros("intenciones_es");

//obtenerTablaUsuarios("copiaSeguridad");