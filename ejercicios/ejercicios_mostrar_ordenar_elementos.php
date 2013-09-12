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
  GNU General Public License for more details. 
 */

require_once($CFG->dirroot . '/course/moodleform_mod.php');
require_once("ejercicios_clases.php");
require_once("ejercicios_clase_general.php");

require_once('clase_log.php');

class mod_ejercicios_mostrar_ejercicio_ordenar_elementos extends moodleform_mod {

    function mod_ejercicios_mostrar_ejercicio_ordenar_elementos($id, $id_ejercicio, $tipo_origen, $tipo_respuesta, $tipocreacion) {
        // El fichero que procesa el formulario es gestion.php
        parent::moodleform('ejercicios_modificar_ordenar_elementos.php?id_curso=' . $id . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $tipo_respuesta . '&tipocreacion=' . $tipocreacion);
    }

    function definition() {
        
    }
    
    //Genera el codigo para almacenar en una variable de javascript las respuestas
    function genera_matriz_respuestas_js($respuestas) {
        $salida = '<script type="text/javascript">';
        $salida .= ' var respuestas = new Array();';
        for ($i=0; $i<sizeof($respuestas); $i++){
            $salida .= 'respuestas['.$i.']=new Array();';
            for ($j=1; $j<=sizeof($respuestas[$i]); $j++) {
                $salida .= 'respuestas['.$i.']['.$j.']=new Array();';
                for ($k=1; $k<=sizeof($respuestas[$i][$j]); $k++) {
                    $salida .= 'respuestas['.$i.']['.$j.']['.$k.']="' . $respuestas[$i][$j][$k]->get('respuesta') . '";';
                }
            }
        }
        $salida.='</script>';
        return $salida;
    }
    
    

    /**
     * Function that add a table to the forma to show the main menu
     *
     * @author Serafina Molina Soto
     * @param $id id for the course
     * @param $id_ejercicio id del ejercicio a mostrar
     */
    function mostrar_ejercicio_ordenar_elementos($id, $id_ejercicio, $buscar, $tipo_origen, $tipo_respuesta, $tipocreacion) {

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
        if($modificable) {
            $titulo = '<h1 id="h1" class="instrucciones" ><u>' . $nombre . '</u><span style="font-size:0.7em;float:right;"><i>' . ucwords(strtolower(htmlentities(get_string('Tipo9','ejercicios')))) . '</i></span></h1>';
            $mform->addElement('html', $titulo);
        }

        //Añado la descripción

        $divdescripcion = '<div style="font-size:1.2em" class=descover>';

        $divdescripcion.='<i>'.nl2br((stripslashes($ejercicios_leido->get('descripcion'))));
        $divdescripcion.=$parte . '<br/></i>';

        $divdescripcion.='</div>';

        $mform->addElement('html', $divdescripcion);


        $tabla_imagenes = '<table width="100%">';

        $tabla_imagenes .='<td>'; #columna
        
        $mform->addElement('html', $tabla_imagenes);
        
        //Obtener la configuracion del ejercicio
        $ej_ordenar_elementos = new ejercicios_ordenar_elementos();
        $matriz = $ej_ordenar_elementos->obtener_todos_id_ejercicio($id_ejercicio);
        $cfg_ej = $matriz[0]->get('orden_unico');
        $tipoorden = $matriz[0]->get('frase');


        //echo "tipo origen.$tipo_origen";
        //compruebo de que tipo es el origen
        switch ($tipo_origen) {

            case 1: //Es de tipo texto la pregunta

                //echo "tipo respuesta.$tipo_respuesta";
                switch ($tipo_respuesta) {
                    case 1: //Es de tipo texto la respuesta
                        //Obtengo las preguntas
                        $mis_preguntas = new Ejercicios_texto_texto_preg();
                        $preguntas = $mis_preguntas->obtener_todas_preguntas_ejercicicio($id_ejercicio);

                        if ($buscar == 1 || $modificable == false) {
                            //Escribir log de registro
                            $fichero = @fopen("log_TH_alumno.txt","w");
                            $log="";
                           
                            //$tabla_imagenes.='<center><table id="tablapreg" name="tablapreg">';
                            //$tabla_imagenes.="<tr>";
                                                        
                            
                            
                            
                            $array_todas_respuestas = array();
                            $tabla_imagenes = "";
                            $tabla_imagenes.='<span id="temp" style="visibility:hidden;"></span>';
                            //Inserto las preguntas con clase "item" es decir dragables(mirar javascript.js)
                            for ($i = 1; $i <= sizeof($preguntas); $i++) {
                                //Pinto la pregunta
                                
                                $tabla_imagenes.= '<div id="tabpregunta' . $i . '" >';
                                $tabla_imagenes.='<br/><br/>';
                                $tabla_imagenes.='<table style="width:100%;">';
                                $tabla_imagenes.=' <td style="width:80%;">';
                                
                                //Variable para comprobar si se ha introducido respuestas muy largas y hay que ajustar la interfaz
                                $parrafos_largos = ($tipoorden==0);
                                
                                //Obtengo la respuestas
                                $id_pregunta = $preguntas[$i - 1]->get('id');
                                $mis_respuestas = new ejercicios_ordenar_elementos_resp();
                                $respuestas = $mis_respuestas->obtener_todos_id_pregunta($id_pregunta);
                                $matriz_respuestas = array();
                                for ($k=0; $k<sizeof($respuestas); $k++) {
                                    if($matriz_respuestas[$respuestas[$k]->get('orden')]==NULL) {
                                        $matriz_respuestas[$respuestas[$k]->get('orden')]=array();
                                    }
                                    $matriz_respuestas[$respuestas[$k]->get('orden')][$respuestas[$k]->get('suborden')] = $respuestas[$k];
                                    
                                }
                                $array_todas_respuestas[] = $matriz_respuestas;
                                
                                //-------
                                $log.="Id de ejercicio: " . $id_ejercicio . "\n";
                                $log.="Id de pregunta " . $i . " : " . $id_pregunta . "\n";
                                $log.="Respuestas Export: " . var_export($matriz_respuestas, true) . "\n";
                                //-------
                                
                                //Genero la pregunta con los huecos
                                //$salida = $this->genera_texto_con_huecos($preguntas[$i - 1]->get('pregunta'), $i, $respuestas[$i-1], $mostrar_pistas);
                                //Pinto la pregunta
                                $long_palabras = sizeof($matriz_respuestas[1]);
                                $tabla_imagenes.='<div style="width: 900px;" class="pregunta" name="pregunta' . $i . '" id="pregunta' . $i . '">';
                                $tabla_imagenes.='<h3 style="display:inline;" >Pregunta '.$i.':</h3>';
                                $tabla_imagenes.='<img id="img_preg'.$i.'" />';
                                   $tabla_imagenes.='<div>';
                                for ($l=0; $l<$long_palabras; $l++) {
                                    //$long_pal = strlen($matriz_respuestas[1][$l+1]->get('respuesta'));
                                    if ($parrafos_largos) {
                                        $float='';
                                        $ancho='850px';
                                        $alto='150px';
                                    }
                                    else {
                                        $float="float:left;";
                                        $ancho="150px";
                                        $alto="30px";
                                    }
                                    $tabla_imagenes.='<div  style="'.$float.';width:'.$ancho.';height:'.$alto.';"  class="marquito" preg="'.$i.'" id="preg'.$i."_".($l+1).'" ></div>';
                                }
                                   $tabla_imagenes.='</div>';
                                $tabla_imagenes.='<div style="clear:both">';
                                $tabla_imagenes.='<input type="hidden" name="num_res_preg'.$i.'" id="num_res_preg'.$i.'" value="'.sizeof($respuestas).'" />';
                                
                                //------------------
                                //$aleatorios_generados = array();    
                                $resp_generadas = array();          //Array con todas las respuestas desordenadas.
                                srand(time());                      //Inicializar el generador de numeros aleatorios

                                //Array de aleatorios generados. 
                                //Almacena un orden aleatorio de respuestas para que no aparezcan todas ordenadas
                                if ($long_palabras>=1) {
                                    $aleatorios_generados = range(1,$long_palabras);
                                    shuffle($aleatorios_generados);
                                    $z=0;
                                    foreach ($aleatorios_generados as $al) {
                                        $log.="".$z.": " . $al . "\n";
                                        $z+=1;
                                    }
                                }
                                else {
                                    $aleatorios_generados = array();
                                    $log.="No hay respuestas\n";
                                }
                                
                                $pregs_indice = array();
                                $resp_indice = array();
                                //Guarda todas las respuestas en un array
                                for ($m=1; $m<=sizeof($matriz_respuestas[1]); $m++) {
                                    //Se guarda la posicion en la que se pondra la respuesta
                                    //$aleatorios_generados[] = $azar;
                                    $resp_generadas[] = $matriz_respuestas[1][$m]->get('respuesta');
                                    $pregs_indice[] = $i;
                                    $resp_indice[] = $m;
                                }



                                //Se van a pintar las respuestas                                
                                
                                for ($j=0; $j<sizeof($aleatorios_generados); $j++) {
                                    //$tabla_imagenes.='<tr>';
                                    $resp = $resp_generadas[$aleatorios_generados[$j] - 1];
                                    $long = strlen($resp);
                                    if ($parrafos_largos) {
                                        $float = '';
                                        $ancho = '850px';
                                        $alto = '300px';
                                    }
                                    else {
                                        $float='float:left;';
                                        $ancho = ($long*10).'px';
                                        $alto='30px';
                                    }
                                    $tabla_imagenes.='<div preg="'.$i.'"  style="'.$float.'width:'.$ancho.';height:'.$alto.';" class="item resp" id="resp_'.$aleatorios_generados[$j].'_'.$i.'" >';
                                    $tabla_imagenes.=$resp_generadas[$aleatorios_generados[$j] - 1] . '</div>';

                                    //Le asigno un numero aleatorio a la respuesta
                                    //$hash[$aleatorios_generados[$j]] = $pregs_indice[$aleatorios_generados[$j] - 1] . "_" . $resp_indice[$aleatorios_generados[$j] - 1];
                                    //$log .= "Para la respuesta " . $resp_indice[$aleatorios_generados[$j] - 1] . " de la pregunta " . $pregs_indice[$aleatorios_generados[$j] - 1] 
                                    //        . " se le ha asignado el numero aleatorio " . $aleatorios_generados[$j] . "\n";

                                    //$tabla_imagenes.='<td><div  id="' . $aleatorios_generados[$j] . '" class="marquito"></div></td>';
                                    //$tabla_imagenes.='<td><div  style="width:100px; height:100px;" id="resp_' . $aleatorios_generados[$j] . '" class="item"><p>'.$resp_generadas[$aleatorios_generados[$j] - 1].'</p></div></td>';
                                    //$tabla_imagenes.='<td id="aceptado' . $aleatorios_generados[$j] . '" class="marquitoaceptado"></td>';
                                    //$tabla_imagenes.='</tr>';
                                }
                                $tabla_imagenes.="</div>";
                                //$tabla_imagenes.='</table></center>';
                                //$tabla_imagenes.='<p class="numero" id="' . sizeof($preguntas) . '"></p>';
                                $tabla_imagenes.='<p class="numero" id="' . $long_palabras . '"></p>';
                                
                                
                                $tabla_imagenes.='</div>';
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
                            //$tabla_imagenes .= $this->genera_matriz_respuestas_js($respuestas);
                            
                            
                            //Meter todas las respuestas en el codigo javascript
                            $salida = $this->genera_matriz_respuestas_js($array_todas_respuestas);
                            $tabla_imagenes.=$salida;
                            
                            
                            //Escribir en el archivo
                            fwrite($fichero,$log,strlen($log));
                            fclose($fichero);
                            //------------------
                            

                            

                            //inserto el número de preguntas
                            $tabla_imagenes.='<input type="hidden" name="tipo_ej" id="tipo_ej" value="OE"/>';
                            $tabla_imagenes.='<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
                            
                            
                            //Insertar el html                            
                            $mform->addElement('html', $tabla_imagenes);
                            
                            
                            
                        } else {
                            //echo "akiiiiiiii";
                            //$tabla_imagenes.='<table id="tablarespuestas" name="tablarespuestas"><center>';
                            
                            $log = new Log("log_OE_mostrar.txt");
                            
                            $html = '<input type=hidden name="orden_unico" id="orden_unico" value="'.$cfg_ej.'" />';
                            $mform->addElement('html',$html);        
                            

                            for ($i = 1; $i <= sizeof($preguntas); $i++) {
                                $log->write("i: " . $i . "\n");
                                
                                $log->write("Numero de oraciones: " . sizeof($preguntas) . "\n");
                                //Pinto la pregunta
                                $divpregunta = '<div id="tabpregunta' . $i . '" >';
                                $divpregunta.='<br/><br/>';
                                $divpregunta.='<table id="table_pregunta'.$i.'" style="width:100%;">';
                                $divpregunta.=' <tr><td style="width:70%;">';

                                $divpregunta.='<h2 id="h2_pregunta'.$i.'" >'.get_string('OE_pregunta','ejercicios',$i).'</h2>';
                                $divpregunta.='<textarea readonly="yes" style="width: 900px;" class="pregunta" name="pregunta' . $i . '" id="pregunta' . $i . '">'.$preguntas[$i-1]->get('pregunta').'</textarea>';
                                
                                $divpregunta.='<img id="imgpregborrar' . $i . '" src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="OE_DelPregunta('.$id_ejercicio.",".$i.')" title="Eliminar Oracion">&nbsp;&nbsp;Eliminar Oracion&nbsp;&nbsp;</img>';
                                if($cfg_ej==1) $divpregunta.='<img id="imgpreganadir' . $i . '" src="./imagenes/añadir.gif" alt="añadir hueco"  height="15px"  width="15px" onClick="OE_addOrden_Modificar('.$id_ejercicio.",".$i.' )" title="Añadir Orden Nuevo">&nbsp;&nbsp;Añadir Orden Nuevo&nbsp;&nbsp;</img>';
                                
                                $divpregunta.=' </td>';
                                
                                $divpregunta.=' <td style="width:15%;">';
                                //$divpregunta.='<img id="imgpregborrar' . $i . '" src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="OE_DelPregunta('.$id_ejercicio.",".$i.')" title="Eliminar Pregunta">Eliminar Pregunta</img>';
                                //$divpregunta.='</br><img id="imgpreganadir' . $i . '" src="./imagenes/añadir.gif" alt="añadir hueco"  height="15px"  width="15px" onClick="OE_addOrden_Modificar('.$id_ejercicio.",".$i.' )" title="Añadir Orden">Añadir Orden</img>';
                                $divpregunta.='</td></tr>';
                                $flechas =  ($cfg_ej==1) ? '<h4>'.get_string("OE_help_flechas","ejercicios").'</h4>' : "";
                                $divpregunta.='</br><tr><td>'.$flechas.'</td></tr>';
                                $divpregunta.='</table> ';
                                
                                $id_pregunta = $preguntas[$i - 1]->get('id');
                                $mis_respuestas = new ejercicios_ordenar_elementos_resp();
                                $respuestas = $mis_respuestas->obtener_todos_id_pregunta($id_pregunta);
                                
                                $matriz_respuestas = array();
                                for ($k=0; $k<sizeof($respuestas); $k++) {
                                    if($matriz_respuestas[$respuestas[$k]->get('orden')]==NULL) {
                                        $matriz_respuestas[$respuestas[$k]->get('orden')]=array();
                                    }
                                    $matriz_respuestas[$respuestas[$k]->get('orden')][$respuestas[$k]->get('suborden')] = $respuestas[$k];
                                }
                                $log->write("matriz_respuestas: " . var_export($matriz_respuestas,true));
                                
                                
                                
                                for ($k=1; $k<=sizeof($matriz_respuestas); $k++) {
                                    $log->write("k: ".$k."\n");
                                    $divpregunta.='</br><table id="table_h3_orden_'.$i."_".$k.'" ><tbody><tr><td><h3 id="h3_orden_'.$i."_".$k.'" >'.get_string('OE_orden','ejercicios',$k).'</h3></td>';
                                    //$divpregunta.='<td><img id="add_palabra_'.$i."_".$k.'" src="./imagenes/añadir.gif" alt="añadir palabra"  height="15px"  width="15px" onClick="OE_addPalabra_Modificar('.$id_ejercicio.",".$i.",".$k.' )" title="Añadir Palabra">&nbsp;&nbsp;Añadir Palabra&nbsp;&nbsp;&nbsp;&nbsp;</img>';
                                    if($cfg_ej==1) $divpregunta.='<td><img id="del_orden_'.$i."_".$k.'" src="./imagenes/delete.gif" alt="delete orden"  height="15px"  width="15px" onClick="OE_delOrden_Modificar('.$id_ejercicio.",".$i.",".$k.' )" title="Eliminar Orden">&nbsp;&nbsp;Eliminar Orden</img></td></tr></tbody></table>';
                                    else           $divpregunta.='</tr></tbody></table>';
                                    $divpregunta.='<div id="orden' . $i . "_" . $k . '" class=respuesta>';
                                    $log->write("size of matriz_respuestas: " . sizeof($matriz_respuestas));
                                    for ($p = 0; $p < sizeof($matriz_respuestas[$k]); $p++) {
                                        $log->write("p:" . $p. "\n");
                                        /*$tabla_imagenes.= '<tr><td/><td><textarea name="respuesta' . $i . "_" . ($j+1) . '" id="respuesta' . $i . "_" . ($j+1) . '" class=descripcion style="height: 192px; width: 401px;" >';
                                        $tabla_imagenes.=$respuestas[$j]->get('respuesta') . '</textarea></td>';
                                        $tabla_imagenes .= '<td><img id="imgpregpborrar' . $i . '" src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="EliminarRespuesta_TextoTexto_AM(tabpregunta' . $i . ',' . $i . ')" title="Eliminar Respuesta"></img></td></tr>';
                                         */                                     
                                        $q = $p + 1;
                                        $log->write("\nsize of matriz_respuestas de k: " . sizeof($matriz_respuestas[$k]));
                                        $log->write("Respuesta: " . $matriz_respuestas[$k][$q]->get('respuesta')."\n");

                                        if ($q%2==0 || $q==sizeof($matriz_respuestas[$k])) {
                                            $divpregunta.='<table  id="tablarespuesta' . $q . '_' . $k . '_' . $i . '" style="width:50%;">';
                                        }
                                        else {
                                            $divpregunta.='<table  id="tablarespuesta' . $q . '_' . $k . '_' . $i . '" style="width:50%;float:left;">';
                                        }
                                        $divpregunta.='<tr id="trrespuesta' . $q . "_" . $k . '_' . $i . '"> ';
                                        $divpregunta.=' <td style="width:80%;">';
                                        $divpregunta.='<div id="enum_resp_'.$q. '_'. $k . '_' . $i .'" >'.$q.'.</div><textarea style="width: 300px;" readonly="yes" class="resp" name="respuesta' . $q . "_" . $k . '_' . $i . '" id="respuesta' . $q . "_" . $k . '_' . $i . '" value="' . $matriz_respuestas[$k][$q]->get('respuesta') . '">' . $matriz_respuestas[$k][$q]->get('respuesta') . '</textarea>';
                                        $divpregunta.=' </td>';
                                        $divpregunta.=' <td style="width:5%;" id="tdcorregir'. $q . "_" . $k . '_' . $i .'">';
                                        if($cfg_ej==1) {
                                        //$divpregunta.='<img id="eliminarrespuesta' . $q . '_' . $k . '_' . $i . '" src="./imagenes/delete.gif" alt="eliminar respuesta"  height="10px"  width="10px" onClick="OE_EliminarResp('.$id_ejercicio.",".$i.",".$k.",".$q.')" title="Eliminar Respuesta"></img>';
                                            $divpregunta.='<img id="up_'.$q.'_'. $k . '_' . $i . '" src="./imagenes/up.svg" alt="Subir Orden" height="20px"  width="20px" title="Subir Orden" onclick="OE_BajarOrden('.$id_ejercicio.','.$i.','.$k.','.$q.')" ></img>';
                                            $divpregunta.='<img id="down_'.$q.'_'. $k . '_' . $i . '" src="./imagenes/down.svg" alt="Bajar Orden" height="20px"  width="20px" title="Bajar Orden" onclick="OE_SubirOrden('.$id_ejercicio.','.$i.','.$k.','.$q.')" ></img>';
                                        }

                                        $divpregunta.='</td> ';
                                        $divpregunta.='</tr>';

                                        $divpregunta.='</table> ';
                                    }


                                    //$tabla_imagenes.="</tr>";                                
                                    //Inserto el numero de respuestas para cada pregunta
                                    //$tabla_imagenes.='<input type="hidden" name="numrespuestas_' . $i . '" id="numrespuestas_' . $i . '" value="' . sizeof($respuestas) . '" />';
                                    $divpregunta.='</div>';
                                    
                                    $divpregunta.='<input type="hidden" value=' . sizeof($matriz_respuestas[$k]) . ' id="num_res_preg' . $i . "_" . $k . '" name="num_res_preg' . $i . "_" . $k. '" />';
                                    $mform->addElement('html', $divpregunta);
                                    $divpregunta="";
                                }
                                //Insertar el numero de ordenes
                                $divpregunta .= '<input type="hidden" value=' . sizeof($matriz_respuestas) . ' id="num_orden_'.$i.'" name="num_orden_'.$i.'" />';                            
                                $divpregunta.='</div>';                                
                                $mform->addElement('html', $divpregunta);
                                
                            }
                            //$tabla_imagenes.='</table></center>';

                            //inserto el número de preguntas
                            $divnumpregunta = '<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';                            
                            $mform->addElement('html', $divnumpregunta);
                            //$tabla_imagenes.='<input type="hidden" value=' . sizeof($preguntas) . ' id="num_preg" name="num_preg" />';
                            
                        }
                            


                        //botones
                        //$mform->addElement('html', $tabla_imagenes);


                        if ($buscar != 1 && $modificable == true) {
                            //Si soy el profesor creadors
                            $tabla_imagenes='<center><input type="button" style="margin-top:20px;" id="botonNA" name="botonNA" onclick="OE_AddPregunta('.$id_ejercicio.')" value="' . get_string('OE_add_pregunta', 'ejercicios') . '"><br/>';
                            $tabla_imagenes.= '<input type="submit" onclick="return OE_Guardar('.$id_ejercicio.');" style="" id="submitbutton" name="submitbutton" value="' . get_string('BotonGuardar', 'ejercicios') . '">';
                            
                            $tabla_imagenes.='<input type="button" style="" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
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
                                        $tabla_imagenes = '<center><input type="button" style="margin-top:20px;" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                                    } else { //Si soy alumno
                                        $tabla_imagenes = '<center><input type="button" onclick="OE_Corregir('.$id_ejercicio.')" style="margin-top:20px;" id="botonResultado" value="Corregir">';
                                        $tabla_imagenes.='<input type="button" style="" id="botonRehacer" value="Rehacer" onClick="location.href=\'./view.php?id=' . $id . '&opcion=8' . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $tipo_respuesta . '&tipocreacion=' . $tipocreacion . '\'">';
                                        $tabla_imagenes.='<input type="button" style="" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                                    }
                                }
                            } else {

                                $tabla_imagenes = '<center><input type="button" onclick="OE_Corregir('.$id_ejercicio.')" style="margin-top:20px;" id="botonResultado" value="Corregir">';
                                $tabla_imagenes.='<input type="button" style="" id="botonRehacer" value="Rehacer" onClick="location.href=\'./view.php?id=' . $id . '&opcion=8' . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $tipo_respuesta . '&tipocreacion=' . $tipocreacion . '\'">';
                                $tabla_imagenes.='<input type="button" style="" id="botonMPrincipal" value="Menu Principal" onClick="location.href=\'./view.php?id=' . $id . '\'"></center>';
                            }
                        }


                        $tabla_imagenes .='</td>';
                        $tabla_imagenes .='<td  width="10%">';
                        //Para alumnos
                        if ($modificable==false) {
                            //añado la parte de vocabulario para la conexión
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
