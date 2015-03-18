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
function obtenerTablasVocabulario($nombreFichero)
{
    $fp = fopen("/home/dafcollage/Escritorio/salida/".$nombreFichero.".txt","a+");
    $res = fopen("/home/dafcollage/Escritorio/salida/prueba.txt","w");
    $busca = "INTO `mdl_vocabulario_intenciones_de` VALUES ";
    $i = strlen($busca) + strlen("INSERT ");

    while (!feof($fp))
    {
        $linea = fgets($fp);
        $tope = strlen($linea);
        $encontrado = strpos($linea,$busca);
     //   fwrite($res, "bah\n");
        if ($encontrado == true)
        {
            //fwrite($res, "caca\n");
            while($i < $tope)
            {
                $cad = substr($linea,$i,2);
                if($cad == '),')
                {
                    fwrite($res,"\n");
                }
                else {
                    if($cad[0] != '(' && $cad[0] != ')' && $cad[0] != ',' && $cad[0] != "'")
                    {
                        fwrite($res,$cad[0]);
                    }
                    if ($cad[0] == ',')
                    {
                        fwrite($res,"\t");
                    }
                }
                $i++;
                //$car = fgetc($linea);
//                fwrite($res,$linea);
            }
            
        }
    }
}

//Función que separa las tablas de moodle 1.9 del resto de las tablas.
function obtenerTablasMoodle19($nombreFichero)
{
    
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
obtenerTablasVocabulario("copia7");