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

require_once($CFG->dirroot . '/course/moodleform_mod.php');
require_once("ejercicios_clases.php");
require_once("ejercicios_clase_general.php");

class mod_ejercicios_mostrar_ejercicio_texto_hueco extends moodleform_mod {

    function mod_ejercicios_mostrar_ejercicio_texto_hueco($id, $id_ejercicio, $tipo_origen, $tipo_respuesta, $tipocreacion) {
        // El fichero que procesa el formulario es gestion.php
        parent::moodleform('ejercicios_modificar_texto_hueco.php?id_curso=' . $id . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $tipo_respuesta . '&tipocreacion=' . $tipocreacion);
    }

    function definition() {
        
    }
    
    //Genera el codigo para almacenar en una variable de javascript las respuestas
    function genera_matriz_respuestas_js($respuestas) {
        $salida = '<script type="text/javascript">';
        $salida .= ' var respuestas = new Array();';
        for ($i=0; $i<sizeof($respuestas); $i++){
            $salida .= 'respuestas['.$i.']=new Array();';
            for ($j=0; $j<sizeof($respuestas[$i]); $j++) {
                $salida .= 'respuestas['.$i.']['.$j.']="' . $respuestas[$i][$j]->get('respuesta') . '";';
            }
        }
        $salida.='</script>';
        return $salida;
    }
    
    /**
     * Genera el codigo html para presentar el texto de la pregunta con los huecos
     * @param string $texto Texto de la pregunta
     * @param integer $numpreg Numero de pregunta
     * @param array $respuestas Array con las respuestas de la pregunta
     * @param {0,1} $mostrar_pistas 1 si se desea mostrar pistas, 0 en otro caso
     */
    function genera_texto_con_huecos($texto,$numpreg,$respuestas,$mostrar_pistas) {
        //$file_log = fopen("log_TH_genera_huecos.txt","a");
        $regexp = "/\[\[(\d)+\]\]/";
        $encontrado = preg_match_all($regexp,$texto,$coincidencias,PREG_OFFSET_CAPTURE);
        //$log = "Numero de pregunta: " . $numpreg . "\n";
        //$log .= "Texto: " . $texto . "\n";
        //$log .= "Respuestas: " . var_export($respuestas,true) . "\n";
        //$log .= "encontrado: " . $encontrado . "\n";
        //$log .= "coincidencias: " . var_export($coincidencias, true) . "\n";
        
        $salida = "";
        $inicio=0;
        $fin=0;
        
        if ($encontrado) {
            foreach ($coincidencias[0] as $coincide) {
                $fin = $coincide[1]-1 - $inicio;
                //$log .= "Inicio: " . $inicio . " Fin: " . $fin . "\n";
                $cad = substr($texto, $inicio, $fin);
                //$log .= "Cad: " . $cad . "\n";
                $salida .= '<span>'.$cad.'</span>';
                $numero = (int)substr($coincide[0],2,strlen($coincide[0])-3);
                //$log .= "Numero: " . $numero . "\n";
                //$log .= "Respuesta numero " . ($numero+1) . " : " . $respuestas[$numero]->get('respuesta') . "\n";
                $inicio = $coincide[1] + strlen($coincide[0]);
                //$log .= "Nuevo inicio: " . $inicio . "\n";
                
                $long = strlen($respuestas[$numero]->get('respuesta'));
                $nombre = "resp" . ($numero+1) . "_" . $numpreg;
                $nombre_help = "help" . ($numero+1) . "_" . $numpreg;
                $salida .= '<textarea style="resize:none;" name="'.$nombre.'" id="' . $nombre . '" rows="1" cols="' . $long . '" ></textarea>';
                $salida .= '<img id="img_' . $nombre . '" />'; 
                if ($mostrar_pistas) {
                    //$salida .= '<div id="'.$nombre_help.'" style="display:none;" >' . get_string('TH_pista_longitud','ejercicios',$long) . '</div>';
                    //$salida .= '<script type="text/javascript" >$("#'.$nombre_help.'").tooltip({track: true,my: "left+15 center", at: "right center"}););</script>';
                    //$salida .= '<img id="'.$nombre_help.'" src="http://localhost/moodle/pix/help.gif" onmouseover="document.getElementById(\''.$nombre_help.'\').style.display=\'block\'" onmouseout="document.getElementById(\''.$nombre_help.'\').style.display=\'none\'" />';
                    $salida .= '<img id="'.$nombre_help.'" src="http://localhost/moodle/pix/help.gif" title="'.get_string('TH_pista_longitud','ejercicios',$long).'"  />';
                }
            }
            if ($inicio<strlen($texto)-1) {
                $cad = substr($texto,$inicio);
                //$log .= "Ultima cadena: " . $cad . "\n";
                $salida .= '<span>'.$cad.'</span>';
            }
        }
        
        
        //fwrite($file_log,$log,strlen($log));
        //fclose($file_log);    
        
        return $salida;
    }

    /**
     * Function that add a table to the forma to show the main menu
     *
     * @author Serafina Molina Soto
     * @param $id id for the course
     * @param $id_ejercicio id del ejercicio a mostrar
     */
    function mostrar_ejercicio_texto_hueco($id, $id_ejercicio, $buscar, $tipo_origen, $tipo_respuesta, $tipocreacion) {



        global $CFG, $COURSE, $USER;
        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);


        //Los iconos están sacados del tema de gnome que viene con ubuntu 11.04
        //inclusion del javascript para las funciones

        $mform = & $this->_form;
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./style.css">');
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./estilo.css">');
        //$mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>');
        //$mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>');
        
        //$mform->addElement('html', '<script type="text/javascript" src="./js/jquery.min.js"></script>');
        
        
          $mform->addElement('html','<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>');
          $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.js"></script>');

          $mform->addElement('html', '<script type="text/javascript" src="./funciones.js"></script>');
        //Cojo el ejercicio  de la bd a partir de su id (id_ejercicio)
        //Obtengo el ejercicio de la bd
        $ejercicios_bd = new Ejercicios_general();
        $ejercicios_leido = $ejercicios_bd->obtener_uno($id_ejercicio);

        $nombre = $ejercicios_leido->get('name');
        $npreg = $ejercicios_leido->get('numpreg');
        $creador = $ejercicios_leido->get('id_creador');

        if ($creador == $USER->id && has_capability('moodle/legacy:editingteacher', $context, $USER->id, false)) {
            $modificable = true;
        } else {
            $modificable = false;
        }

        //Añado el título
        $titulo = '<h1>' . $nombre . '</h1>';
        $mform->addElement('html', $titulo);

        //Añado la descripción

        $divdescripcion = '<div class=descover>';

        $divdescripcion.=nl2br((stripslashes($ejercicios_leido->get('descripcion'))));
        $divdescripcion.=$parte . '<br/>';

        $divdescripcion.='</div>';

        $mform->addElement('html', $divdescripcion);


        $tabla_imagenes = '<table width="100%">';

        $tabla_imagenes .='<td>'; #columna
        
        $mform->addElement('html', $tabla_imagenes);


        //echo "tipo origen.$tipo_origen";
        //compruebo de que tipo es el origen
        switch ($tipo_origen) {

            case 1: //Es de tipo texto la pregunta

                //echo "tipo respuesta.$tipo_respuesta";
                switch ($tipo_respuesta) {
                    case 1: //Es de tipo texto la respuesta
                        //Obtengo la configuracion del ejercicio
                        $cfg_ej = new ejercicios_texto_hueco();
                        $array = $cfg_ej->obtener_todos_id_ejercicio($id_ejercicio);
                        $cfg_ej = $array[0];
                        $mostrar_palabras = $cfg_ej->get('mostrar_palabras');
                        $mostrar_pistas = $cfg_ej->get('mostrar_pistas');
                        $mostrar_soluciones = $cfg_ej->get('mostrar_solucion');
                        
                        //Obtengo las preguntas
                        $mis_preguntas = new Ejercicios_texto_texto_preg();
                        $preguntas = $mis_preguntas->obtener_todas_preguntas_ejercicicio($id_ejercicio);

                        if ($buscar == 1 || $modificable == false) {
                            //Escribir log de registro
                            $fichero = @fopen("log_TH_alumno.txt","w");
                            $log="";
                           
                            //$tabla_imagenes.='<center><table id="tablapreg" name="tablapreg">';
                            //$tabla_imagenes.="<tr>";
                                                        
                            $total_respuestas=0;
                            $respuestas = array();
                            $pregs_indice = array();
                            $resp_indice = array();
                            
                            $tabla_imagenes = "";
                            //Inserto las preguntas con clase "item" es decir dragables(mirar javascript.js)
                            for ($i = 1; $i <= sizeof($preguntas); $i++) {
                                //Pinto la pregunta
                                $tabla_imagenes.= '<div id="tabpregunta' . $i . '" >';
                                $tabla_imagenes.='<br/><br/>';
                                $tabla_imagenes.='<table style="width:100%;">';
                                $tabla_imagenes.=' <td style="width:80%;">';
                                
                                //Obtengo la respuestas
                                $id_pregunta = $preguntas[$i - 1]->get('id');
                                $mis_respuestas = new Ejercicios_texto_texto_resp();
                                $respuestas[] = $mis_respuestas->obtener_todas_respuestas_pregunta($id_pregunta);
                                $total_respuestas += sizeof($respuestas[$i-1]);
                                
                                //-------
                                $log.="Id de ejercicio: " . $id_ejercicio . "\n";
                                $log.="Id de pregunta " . $i . " : " . $id_pregunta . "\n";
                                $log.="Total de respuestas: " . $total_respuestas . "\n";
                                //-------
                                
                                //Genero la pregunta con los huecos
                                $salida = $this->genera_texto_con_huecos($preguntas[$i - 1]->get('pregunta'), $i, $respuestas[$i-1], $mostrar_pistas);
                                //Pinto la pregunta
                                $tabla_imagenes.='<div style="width: 900px;" class="pregunta" name="pregunta' . $i . '" id="pregunta' . $i . '">' . $salida . '</div>';
                                $tabla_imagenes.=' </td>';

                                //Obtengo la pregunta
                                //$tabla_imagenes.='<td id="texto' . $i . '"> <div class="item" id="' . $i . '">';
                                //$tabla_imagenes.='<td id="texto' . $i . '"> <div class="marquito" id="' . $i . '">';
                                
                                $tabla_imagenes.=' <td style="width:5%;">';
                                $tabla_imagenes.='</td> ';
                                $tabla_imagenes.='</br> ';
                                $tabla_imagenes.='</table> ';
                                                               
                                
                                $tabla_imagenes.='</div>';
                                $tabla_imagenes.='</div>';
                                
                                /*$tabla_imagenes.='<div style="margin-top: 10%;">' . $salida . '</div>';

                                $tabla_imagenes.='</div></div></td>';
                                if ($i % 2 == 0) { //Si es impar lo bajo
                                    $tabla_imagenes.="</tr>";
                                }*/
                            }
                            /*$tabla_imagenes.="</tr>";
                            $tabla_imagenes.='</table></center>';
                            $tabla_imagenes.="</br>";
                            $tabla_imagenes.="</br>";
                            $tabla_imagenes.='<input type="hidden" name="tipo_ej" id="tipo_ej" value="AM"/>';
                            $tabla_imagenes.='<table id="tablarespuestas" name="tablarespuestas"><center>';*/
                            
                            //Añadir las respuestas en una variable en javascript
                            $tabla_imagenes .= $this->genera_matriz_respuestas_js($respuestas);
                            
                            
                            //------------------
                            //$aleatorios_generados = array();    
                            $resp_generadas = array();          //Array con todas las respuestas desordenadas.
                            srand(time());                      //Inicializar el generador de numeros aleatorios
                            
                            //Array de aleatorios generados. 
                            //Almacena un orden aleatorio de respuestas para que no aparezcan todas ordenadas
                            if ($total_respuestas>=1) {
                                $aleatorios_generados = range(1,$total_respuestas);
                                shuffle($aleatorios_generados);
                                $i=0;
                                foreach ($aleatorios_generados as $al) {
                                    $log.="".$i.": " . $al . "\n";
                                    $i+=1;
                                }
                            }
                            else {
                                $aleatorios_generados = array();
                                $log.="No hay respuestas\n";
                            }
                            
                            //Guarda todas las respuestas en un array
                            for ($i=1; $i<=sizeof($respuestas); $i++) {
                                for ($j=1; $j<=sizeof($respuestas[$i-1]); $j++) {                                    
                                    
                                    //Se guarda la posicion en la que se pondra la respuesta
                                    //$aleatorios_generados[] = $azar;
                                    $resp_generadas[] = $respuestas[$i-1][$j-1]->get('respuesta');
                                    $pregs_indice[] = $i;
                                    $resp_indice[] = $j;
                                }
                            }
                            
                            
                            
                            //Se van a pintar las respuestas
                            if ($mostrar_palabras) {
                                $tabla_imagenes .= '<h1>'.get_string('TH_pistas','ejercicios').'</h1>';
                                for ($j=0; $j<sizeof($aleatorios_generados); $j++) {
                                    //$tabla_imagenes.='<tr>';

                                    $tabla_imagenes.='<span class=item id="resp_'.$aleatorios_generados[$j].'" >';
                                    $tabla_imagenes.=$resp_generadas[$aleatorios_generados[$j] - 1] . '</span><span>   </span>';

                                    //Le asigno un numero aleatorio a la respuesta
                                    //$hash[$aleatorios_generados[$j]] = $pregs_indice[$aleatorios_generados[$j] - 1] . "_" . $resp_indice[$aleatorios_generados[$j] - 1];
                                    //$log .= "Para la respuesta " . $resp_indice[$aleatorios_generados[$j] - 1] . " de la pregunta " . $pregs_indice[$aleatorios_generados[$j] - 1] 
                                    //        . " se le ha asignado el numero aleatorio " . $aleatorios_generados[$j] . "\n";

                                    //$tabla_imagenes.='<td><div  id="' . $aleatorios_generados[$j] . '" class="marquito"></div></td>';
                                    //$tabla_imagenes.='<td><div  style="width:100px; height:100px;" id="resp_' . $aleatorios_generados[$j] . '" class="item"><p>'.$resp_generadas[$aleatorios_generados[$j] - 1].'</p></div></td>';
                                    //$tabla_imagenes.='<td id="aceptado' . $aleatorios_generados[$j] . '" class="marquitoaceptado"></td>';
                                    //$tabla_imagenes.='</tr>';
                                }
                                //$tabla_imagenes.='</table></center>';
                                //$tabla_imagenes.='<p class="numero" id="' . sizeof($preguntas) . '"></p>';
                                $tabla_imagenes.='<p class="numero" id="' . $total_respuestas . '"></p>';
                            }
                            
                            
                            //Escribir en el archivo
                            fwrite($fichero,$log,strlen($log));
                            fclose($fichero);
                            //------------------
                            

                            

                            //inserto el número de preguntas
                            $tabla_imagenes.='<input type="hidden" name="tipo_ej" id="tipo_ej" value="TH"/>';
                            $tabla_imagenes.='<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
                            for ($l=0; $l<sizeof($preguntas); $l++){
                                $tabla_imagenes.='<input type="hidden" id="num_resp_preg'.($l+1).'" name="num_resp_preg'.($l+1).'" value="'.sizeof($respuestas[$l]).'"/>';
                            }
                            
                            //Insertar el html                            
                            $mform->addElement('html', $tabla_imagenes);
                            
                            
                            
                        } else {
                            //echo "akiiiiiiii";
                            //$tabla_imagenes.='<table id="tablarespuestas" name="tablarespuestas"><center>';
                            

                            for ($i = 1; $i <= sizeof($preguntas); $i++) {
                                
                                //Pinto la pregunta
                                $divpregunta = '<div id="tabpregunta' . $i . '" >';
                                $divpregunta.='<br/><br/>';
                                $divpregunta.='<table style="width:100%;">';
                                $divpregunta.=' <td style="width:80%;">';

                                
                                $divpregunta.='<textarea style="width: 900px;" class="pregunta" name="pregunta' . $i . '" id="pregunta' . $i . '">' . $preguntas[$i - 1]->get('pregunta') . '</textarea>';
                                $divpregunta.=' </td>';
                                
                                $divpregunta.=' <td style="width:5%;">';
                                $divpregunta.='<img id="imgpregborrar' . $i . '" src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="TH_DelPregunta('.$id_ejercicio.",".$i.')" title="Eliminar Pregunta"></img>';
                                $divpregunta.='</br><img id="imgpreganadir' . $i . '" src="./imagenes/añadir.gif" alt="añadir hueco"  height="15px"  width="15px" onClick="TH_addHueco_Modificar('.$id_ejercicio.",".$i.' )" title="Añadir Hueco"></img>';
                                $divpregunta.='</td> ';
                                $divpregunta.='</br> ';
                                $divpregunta.='</table> ';

                                $id_pregunta = $preguntas[$i - 1]->get('id');
                                $mis_respuestas = new Ejercicios_texto_texto_resp();
                                $respuestas = $mis_respuestas->obtener_todas_respuestas_pregunta($id_pregunta);
                                
                                $divpregunta.='</br><div id="respuestas' . $i . '" class=respuesta>';
                                for ($p = 0; $p < sizeof($respuestas); $p++) {
                                    /*$tabla_imagenes.= '<tr><td/><td><textarea name="respuesta' . $i . "_" . ($j+1) . '" id="respuesta' . $i . "_" . ($j+1) . '" class=descripcion style="height: 192px; width: 401px;" >';
                                    $tabla_imagenes.=$respuestas[$j]->get('respuesta') . '</textarea></td>';
                                    $tabla_imagenes .= '<td><img id="imgpregpborrar' . $i . '" src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="EliminarRespuesta_TextoTexto_AM(tabpregunta' . $i . ',' . $i . ')" title="Eliminar Respuesta"></img></td></tr>';
                                     */                                     
                                    $q = $p + 1;
                
                                    if ($q%2==0 || $q==sizeof($respuestas)) {
                                        $divpregunta.='<table  id="tablarespuesta' . $q . '_' . $i . '" style="width:50%;">';
                                    }
                                    else {
                                        $divpregunta.='<table  id="tablarespuesta' . $q . '_' . $i . '" style="width:50%;float:left;">';
                                    }
                                    $divpregunta.='<tr id="trrespuesta' . $q . "_" . $i . '"> ';
                                    $divpregunta.=' <td style="width:80%;">';
                                    $divpregunta.='<textarea style="width: 300px;" readonly="yes" class="resp" name="respuesta' . $q . "_" . $i . '" id="respuesta' . $q . "_" . $i . '" value="' . $respuestas[$p]->get('respuesta') . '">' . $respuestas[$p]->get('respuesta') . '</textarea>';
                                    $divpregunta.=' </td>';
                                    $divpregunta.=' <td style="width:5%;" id="tdcorregir'. $q . "_" . $i .'">';
                                    $divpregunta.='<img id="eliminarrespuesta' . $q . '_' . $i . '" src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="TH_EliminarHueco('.$id_ejercicio.",".$i.",".$q.')" title="Eliminar Hueco"></img>';
                                    
                                    $divpregunta.='</td> ';
                                    $divpregunta.='<tr>';

                                    $divpregunta.='</table> ';
                                    
                                }
                                
                                
                                //$tabla_imagenes.="</tr>";                                
                                //Inserto el numero de respuestas para cada pregunta
                                //$tabla_imagenes.='<input type="hidden" name="numrespuestas_' . $i . '" id="numrespuestas_' . $i . '" value="' . sizeof($respuestas) . '" />';
                                $divpregunta.='</div>';
                                $divpregunta.='</div>';
                                $divpregunta.='<input type="hidden" value=' . sizeof($respuestas) . ' id="num_res_preg' . $i . '" name="num_res_preg' . $i . '" />';
                                $mform->addElement('html', $divpregunta);
                            }
                            //$tabla_imagenes.='</table></center>';

                            //inserto el número de preguntas
                            $divnumpregunta = '<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
                            $mform->addElement('html', $divnumpregunta);
                            //$tabla_imagenes.='<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
                            
                            
                            //Añadir los checkboxes para la configuracion del ejercicio
                            $file_log = fopen("log_mostrar_texto_hueco.txt","w");                            
                            $cfg_ej = new ejercicios_texto_hueco();
                            $array = $cfg_ej->obtener_todos_id_ejercicio($id_ejercicio);
                            $cfg_ej = $array[0];
                            $log = "cfg_ej: " . var_export($array,true);
                            fwrite($file_log,$log,strlen($log));
                            fclose($file_log);
                            
                            $chk = '<div id="conf_chk">';
                            $chk .= '<h1>'.get_string('TH_configuracion_ejercicio','ejercicios').'</h1>';
                            $chk .= '<p><label for="TH_mostrar_pistas">'.get_string('TH_mostrar_pistas','ejercicios').'</label>';
                            $chk .= '<input type="checkbox" name="TH_mostrar_pistas" value="1" id="TH_mostrar_pistas" '. (($cfg_ej->get('mostrar_pistas')==1) ? "checked" : "") . '/></p>';
                            $chk .= '<p><label for="TH_mostrar_palabras">'.get_string('TH_mostrar_palabras','ejercicios').'</label>';
                            $chk .= '<input type="checkbox" name="TH_mostrar_palabras" value="1" id="TH_mostrar_palabras" '. (($cfg_ej->get('mostrar_palabras')==1) ? "checked" : "") . '/></p>';
                            $chk .= '<p><label for="TH_mostrar_solucion">'.get_string('TH_mostrar_soluciones','ejercicios').'</label>';
                            $chk .= '<input type="checkbox" name="TH_mostrar_solucion" value="1" id="TH_mostrar_solucion" '. (($cfg_ej->get('mostrar_solucion')==1) ? "checked" : "") . '/></p>';
                            $chk .= '</div>';
                            $mform->addElement('html',$chk);
                            
                            
                        }
                            


                        //botones
                        //$mform->addElement('html', $tabla_imagenes);


                        if ($buscar != 1 && $modificable == true) {
                            //Si soy el profesor creadors
                            $tabla_imagenes = '<input type="submit" style="height:40px; width:90px; margin-left:90px; margin-top:20px;" id="submitbutton" name="submitbutton" value="' . get_string('BotonGuardar', 'ejercicios') . '">';
                            $tabla_imagenes.='<input type="button" style="height:40px; width:120px;  margin-top:20px;" id="botonNA" name="botonNA" onclick="TH_AddPregunta('.$id_ejercicio.')" value="' . get_string('NuevaAso', 'ejercicios') . '">';
                            $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                        } else {
                            if ($buscar == 1) { //Si estoy buscand
                                $ejercicios_prof = new Ejercicios_prof_actividad();
                                $ejercicios_del_prof = $ejercicios_prof->obtener_uno_idejercicio($id_ejercicio);
                                if (sizeof($ejercicios_del_prof) == 0) {
                                    $noagregado = true;
                                } else {
                                    $noagregado = false;
                                }
                                //si el ejercicio no es mio y soy profesor
                                if (has_capability('moodle/legacy:editingteacher', $context, $USER->id, false) && ($modificable == false || $noagregado == true)) {
                                    //boton añadir a mis ejercicios
                                    $attributes = 'size="40"';
                                    $mform->addElement('text', 'carpeta_ejercicio', get_string('carpeta', 'ejercicios'), $attributes);
                                    $mform->addRule('carpeta_ejercicio', "Carpeta Necesaria", 'required', null, 'client');
                                    $buttonarray = array();
                                    $buttonarray[] = &$mform->createElement('submit', 'submitbutton2', get_string('BotonAñadir', 'ejercicios'));
                                    $mform->addGroup($buttonarray, 'botones2', '', array(' '), false);
                                } else {

                                    if ($modificable == true) { // Si el ejercicio era mio y estoy buscando
                                        $tabla_imagenes = '<center><input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                                    } else { //Si soy alumno
                                        $tabla_imagenes = '<center><input type="button" onclick="TH_Corregir('.$id_ejercicio.','.$mostrar_soluciones.')" style="height:40px; width:60px;" id="botonResultado" value="Corregir">';
                                        $tabla_imagenes.='<input type="button" style="height:40px; width:60px;" id="botonRehacer" value="Rehacer" onClick="location.href=\'./view.php?id=' . $id . '&opcion=8' . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $tipo_respuesta . '&tipocreacion=' . $tipocreacion . '\'">';
                                        $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                                    }
                                }
                            } else {

                                $tabla_imagenes = '<center><input type="button" onclick="TH_Corregir('.$id_ejercicio.','.$mostrar_soluciones.')" style="height:40px; width:60px;" id="botonResultado" value="Corregir">';
                                $tabla_imagenes.='<input type="button" style="height:40px; width:60px;" id="botonRehacer" value="Rehacer" onClick="location.href=\'./view.php?id=' . $id . '&opcion=8' . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $tipo_respuesta . '&tipocreacion=' . $tipocreacion . '\'">';
                                $tabla_imagenes.='<input type="button" style="height:40px; width:90px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                            }
                        }


                        $tabla_imagenes .='</td>';
                        $tabla_imagenes .='<td  width="10%">';
                        //añado la parte de vocabulario para la conexión
                        //Para alumnos
                        if ($modificable==false) {
                            $tabla_imagenes .='<div><a  onclick=JavaScript:sele(' . $id . ')><img src="../vocabulario/imagenes/guardar_palabras.png" id="id_guardar_im" name="guardar_im" title="' . get_string('guardar', 'vocabulario') . '"/></a></div>';
                            $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=5"><img src="../vocabulario/imagenes/administrar_gramaticas.png" id="id_gram_im" name="gram_im" title="' . get_string('admin_gr', 'vocabulario') . '"/></a></div>';
                            $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=7"><img src="../vocabulario/imagenes/intenciones_comunicativas.png" id="id_ic_im" name="ic_im" title="' . get_string('admin_ic', 'vocabulario') . '"/></a></div>';
                            $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=9"><img src="../vocabulario/imagenes/tipologias_textuales.png" id="id_tt_im" name="tt_im" title="' . get_string('admin_tt', 'vocabulario') . '"/> </a></div>';
                            $tabla_imagenes .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=11"><img src="../vocabulario/imagenes/estrategias_icon.png" id="id_ea_im" name="ea_im" title="' . get_string('admin_ea', 'vocabulario') . '"/> </a></div>';
                        }

                        $tabla_imagenes .='</td>';

                        $tabla_imagenes .='</table>';

                        $mform->addElement('html', $tabla_imagenes);

                        break;
                    
                }
                break;
        }
        
        //echo "termino del todo";
    }

}

?>
