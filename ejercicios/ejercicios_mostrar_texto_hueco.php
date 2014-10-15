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
require_once('ejercicios_partes_comunes.php');

class mod_ejercicios_mostrar_ejercicio_texto_hueco extends moodleform_mod {

    function mod_ejercicios_mostrar_ejercicio_texto_hueco($id, $id_ejercicio, $tipo_origen, $tipo_respuesta, $tipocreacion) {
        // El fichero que procesa el formulario es gestion.php
        parent::moodleform('ejercicios_modificar_texto_hueco.php?id_curso=' . $id . '&id_ejercicio=' . $id_ejercicio . '&tipo_origen=' . $tipo_origen . '&tr=' . $tipo_respuesta . '&tipocreacion=' . $tipocreacion);
    }

    function definition() {
        
    }
    
    
    /**
     * Muestra el ejercicio texto hueco con vistas separadas para alumno y profesor
     *
     * @author Serafina Molina Soto, y modificado por Borja Arroba Hernández y Carlos Aguilar Miguel
     * @param $id id de la instancia del curso
     * @param $id_ejercicio id del ejercicio a mostrar
     */
    function mostrar_ejercicio($id, $id_ejercicio, $tipo_origen, $buscar) {
        
        global $CFG, $COURSE, $USER;
        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);

        $mform = & $this->_form;
        
        //Estilos y javascript concretos de texto hueco
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./th_style.css">');
        $mform->addElement('html', '<script type="text/javascript" src="./TH_JavaScript.js"></script>');
        
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="./funciones.js"></script>');
        $mform->addElement('html', '<script type="text/javascript" src="./js/jquery.form.js"></script>');
        $mform->addElement('html', '<script src="./js/ajaxupload.js" type="text/javascript"></script>');
        
        // Se añade en sesión la variable $buscar 
        $_SESSION['buscar'] = $buscar;
        $_SESSION['id_curso'] = $id;

        if ($buscar == 0) { // Se está creando el ejercicio
            $this->creando_ejercicio($mform, $id);
        } else {
            // Se determina si el usuario es el creador
            $ejercicios_bd = new Ejercicios_general();
            $ejercicios_leido = $ejercicios_bd->obtener_uno($id_ejercicio);
            $creador = $ejercicios_leido->get('id_creador');
            
            if ($creador == $USER->id && has_capability('moodle/legacy:editingteacher', $context, $USER->id, false)) {
                $modificable = true; // En ese caso el ejercicio se puede modificar
            } else { // En caso contrario no se puede
                $modificable = false;
            }

            $_SESSION['id_ejercicio'] = $id_ejercicio;
            $_SESSION['modificable'] = $modificable;
            if ($modificable) {
                $this->mostrar_con_permisos($mform, $id, $ejercicios_leido);
            } else {
                $this->mostrar_sin_permisos($mform, $id, $ejercicios_leido);
            }
        }
    }

    //funcion para crear ejercicio texto hueco
    function creando_ejercicio(&$mform, $id) {
        $mform = & $this->_form;

        $ejercicioGeneral = unserialize($_SESSION['ejercicioGeneral']);
        // Se obtienen los datos del ejercicio a partir de los datos almacenados en sesión (gestionados por ejercicios_gestion_creacion)
        // Hay que tener en cuenta que parte de los datos del ejercicioGeneral se van a rellenar en este paso
        // debido a añadidos posteriores (las fuentes y la imagen asociada)
        // para la posterior creación (manejada por ejercicio_modificar_texto_texto.php)
        $nombre = $ejercicioGeneral->get('name');
        $creador = $ejercicioGeneral->get('id_creador');
        $licencia = $ejercicioGeneral->get("copyrightpreg");
        $visible = $ejercicioGeneral->get("visible");
        $publico = $ejercicioGeneral->get("publico");
        
        // Se imprime el título del ejercicio
        $titulo = genera_titulos($nombre, get_string('TH_title', 'ejercicios'), $id);
        $mform->addElement('html', $titulo);

        // Se imprime la descripción del ejercicio
        $descripcion = genera_descripcion($ejercicioGeneral->get('descripcion'));
        $mform->addElement('html', $descripcion);

        //Campo de la imagen del ejercicio
        $tabla_imagenesHTML = '<div id="capa1">';
        $tabla_imagenesHTML.= '<a id="botonFoto" class="up">Cambiar Foto</a>';
        $tabla_imagenesHTML.= '</div>';
        $tabla_imagenesHTML.= '<div id="capa2" style="min-height: 100px;"> ';
        $tabla_imagenesHTML.= '<img  name="fotoAsociada" id="fotoAsociada" src="./ejercicios_get_imagen.php?ubicacion=0" style="height: 300px;"/>';
        $tabla_imagenesHTML.= '</div>';
        $mform->addElement('html', $tabla_imagenesHTML);

        //En el ejercicio texto hueco, no hace falta poner un switch para los tipos de pregunta y respuesta ya que solo es de tipo texto.
        //Tipo origen = tipo respuesta = texto
        $divEjercicio = '<div name="divEjercicio" id="divEjercicio" class="divEjercicio">';
        $mform->addElement('html', $divEjercicio);
        //para saber el número de la pregunta que estamos tratando
        $numText = '<input type="hidden" value="1" id="numText" name="numText" />';
        $mform->addElement('html', $numText);
        
        //div para cada uno de los textos
        $divTexto = '<div name="divTexto1" id="divTexto1" class="divTexto">';
        $mform->addElement('html', $divTexto);
        
        //Abro el primer div estara alineado a la izq
        $divIzq = '<div name="divIzq1" id="divIzq1" class="divIzq">';
        $mform->addElement('html', $divIzq);
        //Titulo del texto
        $titulo = '<h3>'.get_string('TH_titulo', 'ejercicios').' 1'.'</h3>';
        $mform->addElement('html', $titulo);
        //Boton para crear texto huecos 
        $opciones = '<center><span>Crear hueco cada <select id="distanciaHueco1" name="distanciaHueco1"> <option>--</option> <option value="5">5ª</option> <option value="6">6ª</option> <option value="7">7ª</option> <option value="8">8ª</option> <option value="9">9ª</option></select> palabra</span></center>';
        $mform->addElement('html', $opciones);
        $boton = '<center><input type="button" class="button" name="textoHueco1" id="textoHueco1" value="Crear" onclick="ocultarPalabras(this.id)" /> <input type="button" class="button" name="borrarTextos1" id="borrarTextos1" value="Limpiar" onclick="limpiarContenidosBoton(this.id)" /> </center>';
        $mform->addElement('html', $boton);
        //TextArea para visualizar los textos
        $mform->addElement("textarea", "id_original1", get_string("TH_texto", "ejercicios"), 'wrap="virtual" rows="8"');
        $mform->addElement("textarea", "id_pregunta1", get_string("TH_anadir", "ejercicios"), 'wrap="virtual" rows="8" readonly"');
        $mform->addElement("html", "</fieldset>");
        //Se añade un boton para que se cree un nuevo hueco. 
        $divBoton = '<div name="divBoton" id="divBoton" class="divBoton">';
        $divBoton.= '<center><input type="button" class="button" name="add_hueco1" id="add_hueco1" value="' . get_string('TH_add_hueco', 'ejercicios') . '" onclick="TH_addHueco(this.id)" /> </center>';
        $divBoton.= '</div>';
        $mform->addElement('html', $divBoton);
        //Campo hidden para contabilizar el numero de palabras
        $divnumpalabras = '<input type="hidden" value="0" id="num_palabras1" name="num_palabras1" />';
        $mform->addElement('html', $divnumpalabras);
        //Div guardar los datos de las palabras que oculto
        $divPalabras = '<div name="divPalabrasN1" id="divPalabrasN1"></div>';
        $mform->addElement('html', $divPalabras);
        //Cierro el div alineado a la iz
        $divIzqCierre = '</div>';
        $mform->addElement('html', $divIzqCierre);
        
        //Abro el div que estara alineado a la derecha
        $divDer = '<div name="divDer1" id="divDer1" class="divDer">';
        $mform->addElement('html', $divDer);
        //Cierro el div alineado a la derecha
        $divDerCierre = '</div>';
        $mform->addElement('html', $divDerCierre);
        
        $divTextoCierre = '</div>';
        $mform->addElement('html', $divTextoCierre);
        
        $divEjercicioCierre = '</div>';
        $mform->addElement('html', $divEjercicioCierre);
        
        //Botón para añadir más preguntas
        $masPreguntas = '<br><center><input type="button" class="button" name="masPreguntas" id="masPreguntas" value="Añadir pregunta" onclick="clonar()" /></center></br>';
        $mform->addElement('html', $masPreguntas);

        // Autoría del ejercicio
        $userid = get_record('user', 'id', $creador);
        $autoria = genera_autoria($userid);
        $mform->addElement('html', $autoria);

        $imagenLicencia = genera_licencia($licencia);
        $mform->addElement('html', $imagenLicencia);

        $radioarrayVisib = array();
        $radioarrayVisib[] = &MoodleQuickForm::createElement('radio', 'radiovisible', '', "Si", "Si", null);
        $radioarrayVisib[] = &MoodleQuickForm::createElement('radio', 'radiovisible', '', "No", "No", null);

        $mform->addGroup($radioarrayVisib, 'radiovisible', get_string('visible', 'ejercicios'), array(' '), false);
        if ($visible == 1) {
            $mform->setDefault('radiovisible', "Si");
        } else {
            $mform->setDefault('radiovisible', "No");
        }

        $radioarrayPriv = array();
        $radioarrayPriv[] = &MoodleQuickForm::createElement('radio', 'radioprivado', '', "Si", "Si", null);
        $radioarrayPriv[] = &MoodleQuickForm::createElement('radio', 'radioprivado', '', "No", "No", null);

        $mform->addGroup($radioarrayPriv, 'radioprivado', get_string('publico', 'ejercicios'), array(' '), false);
        if ($publico == 1) {
            $mform->setDefault('radioprivado', "Si");
        } else {
            $mform->setDefault('radioprivado', "No");
        }

        // Se añade el botón guardar y el texto para las fuentes editable si es modificable
        // Text area para reflejar las fuentes empleadas en el ejercicio
        $fuentes_aux = "";
        $fuentes = genera_fuentes($fuentes_aux, "");
        $mform->addElement('html', $fuentes);
        
        // Botón guardar
        $guardar = '<div name="divBoton" id="divBoton" class="divBoton">';
        $guardar.=  '<center><input type="submit" class="button" id="submitbutton" name="submitbutton" value="'.get_string('BotonGuardar', 'ejercicios').'"></center>';
        $guardar.= '</div>';
        $mform->addElement('html', $guardar);
    }

    //mostrar ejercicio con permisos (creador)
    function mostrar_con_permisos(&$mform, $id, $ejercicios_leido) {
        // Y se cargan sus datos en algunas variables
        $nombre = $ejercicios_leido->get('name');
        $idEjercicio = $ejercicios_leido->get('id');
        $creador = $ejercicios_leido->get('id_creador');
        $licencia = $ejercicios_leido->get('copyrightpreg');
        $visible = $ejercicios_leido->get('visible');
        $publico = $ejercicios_leido->get('publico');
        $foto_asociada = $ejercicios_leido->get('foto_asociada');

        // Se imprime el título del ejercicio
        $titulo = genera_titulos($nombre, get_string('TH_title', 'ejercicios'), $id);
        $mform->addElement('html', $titulo);

        // Se imprime la descripción del ejercicio
        $descripcion = genera_descripcion($ejercicios_leido->get('descripcion'));
        $mform->addElement('html', $descripcion);

        if ($foto_asociada == 1) {
            // src para la foto cuando existe
            $srcImage='./ejercicios_get_imagen.php?userPath='.$creador.'&name='.substr(md5($idEjercicio), 0, 10).'&ubicacion=1';
        } else {
            // src para la foto por defecto
            $srcImage="./ejercicios_get_imagen.php?ubicacion=0";
        }
        //Campo de la imagen del ejercicio
        //el nombre que se le da a la foto es el los 10 primero caracteres del md5 del id del ejercicio para que este sea unico
        $tabla_imagenesHTML = '<div id="capa1">';
        $tabla_imagenesHTML.= '<a id="botonFoto" class="up">Cambiar Foto</a>';
        $tabla_imagenesHTML.= '</div>';
        $tabla_imagenesHTML.= '<div id="capa2"> ';
        $tabla_imagenesHTML.= '<img  name="fotoAsociada" id="fotoAsociada" src="'.$srcImage.'" style="height: 300px;"/>';
        $tabla_imagenesHTML.= '</div>';
        $mform->addElement('html', $tabla_imagenesHTML);
        
         //cargamos los datos de la BD
        $textosEjercicio = new Ejercicios_textos();
        $textos = $textosEjercicio->obtener_todos_textos_ejercicicio($idEjercicio);
        
        //En el ejercicio texto hueco, no hace falta poner un switch para los tipos de pregunta y respuesta ya que solo es de tipo texto.
        //Tipo origen = tipo respuesta = texto
        $divEjercicio = '<div name="divEjercicio" id="divEjercicio" class="divEjercicio">';
        $mform->addElement('html', $divEjercicio);
        //para saber el número de la pregunta que estamos tratando
        $numText = '<input type="hidden" value='.sizeof($textos).' id="numText" name="numText" />';
        $mform->addElement('html', $numText);
        
        for($i=1; $i<=sizeof($textos); $i++) {
            //Cargo todas las palabras del texto i-esimo de BBDD
            $ejercicioth = new Ejercicios_texto_hueco();
            $palabras=$ejercicioth->obtener_todos_id_texto($textos[$i-1]->get('id'));
            
            //div para cada uno de los textos
            $divTexto = '<div name="divTexto'.$i.'" id="divTexto'.$i.'" class="divTexto">';
            $mform->addElement('html', $divTexto);

            //Abro el primer div estara alineado a la izq
            $divIzq = '<div name="divIzq'.$i.'" id="divIzq'.$i.'" class="divIzq">';
            $mform->addElement('html', $divIzq);
            //Titulo del texto
            $titulo = '<h3>'.get_string('TH_titulo', 'ejercicios').' '.$i.'</h3>';
            $mform->addElement('html', $titulo);
            //Boton para crear texto huecos 
            $opciones = '<center><span>Crear hueco cada <select id="distanciaHueco'.$i.'" name="distanciaHueco'.$i.'"> <option>--</option> <option value="5">5ª</option> <option value="6">6ª</option> <option value="7">7ª</option> <option value="8">8ª</option> <option value="9">9ª</option></select> palabra</span></center>';
            $mform->addElement('html', $opciones);
            $boton = '<center><input type="button" class="button" name="textoHueco'.$i.'" id="textoHueco'.$i.'" value="Crear" onclick="ocultarPalabras(this.id)" /> <input type="button" class="button" name="borrarTextos'.$i.'" id="borrarTextos'.$i.'" value="Limpiar" onclick="limpiarContenidosBoton(this.id)" /> </center>';
            $mform->addElement('html', $boton);
            //TextArea para visualizar los textos
            $mform->addElement("textarea", "id_original$i", get_string("TH_texto", "ejercicios"), 'wrap="virtual" rows="8" ');
            $mform->addElement("textarea", "id_pregunta$i", get_string("TH_anadir", "ejercicios"), 'wrap="virtual" rows="8" readonly"');
            $mform->setDefault("id_original$i", $textos[$i-1]->get('texto'));
            $mform->setDefault("id_pregunta$i", $textos[$i-1]->get('textoauxiliar'));
            //lo siguiente por que creo que falla el addElement textarea y no cierra bien el fieldset...lo añado a pelo
            $mform->addElement('html', "</fieldset>");
            //Se añade un boton para que se cree un nuevo hueco. 
            $divBoton = '<div name="divBoton" id="divBoton" class="divBoton">';
            $divBoton.= '<center><input type="button" class="button" name="add_hueco'.$i.'" id="add_hueco'.$i.'" value="' . get_string('TH_add_hueco', 'ejercicios') . '" onclick="TH_addHueco(this.id)" /> </center>';
            $divBoton.= '</div>';
            $mform->addElement('html', $divBoton);
            //Campo hidden para contabilizar el numero de palabras
            $divnumpalabras = '<input type="hidden" value='.sizeof($palabras).' id="num_palabras'.$i.'" name="num_palabras'.$i.'" />';
            $mform->addElement('html', $divnumpalabras);
            //Div para guardar los datos de las palabras que oculto
            $divPalabras = '<div name="divPalabrasN'.$i.'" id="divPalabrasN'.$i.'">';
            $mform->addElement('html', $divPalabras);
            //Cierro el div que guarda los datos de las palabras que oculto
            $divPalabrasCierre = '</div>';
            $mform->addElement('html', $divPalabrasCierre);
            //Cierro el div alineado a la iz
            $divIzqCierre = '</div>';
            $mform->addElement('html', $divIzqCierre);

            //Abro el div que estara alineado a la derecha
            $divDer = '<div name="divDer'.$i.'" id="divDer'.$i.'" class="divDer">';
            $mform->addElement('html', $divDer);
            //Menu para las palabras ocultadas
            $pistas='<div class="pistas"><img id="pista" src="./imagenes/pista_descripcion.png" title="Seleccionar todo" onclick="selectAll('.$i.', this.id)"> '
                                .'<img style="margin-left:6px" id="longitud" src="./imagenes/pista_longitud.png" title="Seleccionar todo" onclick="selectAll('.$i.', this.id)"> '
                                .'<img style="margin-left:6px" id="solucion" src="./imagenes/pista_palabra.png" title="Seleccionar todo" onclick="selectAll('.$i.', this.id)"></div>';
            $mform->addElement("html", $pistas);
            
            for($j=1; $j<=sizeof($palabras); $j++) {
                //Palabras ocultadas
                $pal='<div id="oculta'.$i.$j.'">'
                        . '<input type="text" name="palabra'.$i.$j.'" id="palabra'.$i.$j.'" value="'.$palabras[$j-1]->get("palabra").'" readonly>'
                        . '<input type="hidden" name="start'.$i.$j.'" id="start'.$i.$j.'" value="'.$i.$j.'">'
                        . ' <img id="borrarOculta'.$i.$j.'" src="./imagenes/delete.gif" onclick=replaceHuecoTH("borrarOculta'.$i.$j.'") alt="eliminarOculta"  height="13px"  width="13px">  '
                        . '<input value="o" name="pista'.$i.$j.'" id="pista'.$i.$j.'" type="checkbox" checked="1"> '
                        . '<input value="o" name="longitud'.$i.$j.'" id="longitud'.$i.$j.'" type="checkbox" checked="1"> '
                        . '<input value="o" name="solucion'.$i.$j.'" id="solucion'.$i.$j.'" type="checkbox" checked="1"> '
                        . '<input type="text" name="campo'.$i.$j.'" id="campo'.$i.$j.'" value="'.$palabras[$j-1]->get('pista').'">'
                      . '</div>';
                $mform->addElement("html", $pal);
                
            }
            //Cierro el div alineado a la derecha
            $divDerCierre = '</div>';
            $mform->addElement('html', $divDerCierre);

            $divTextoCierre = '</div>';
            $mform->addElement('html', $divTextoCierre);
        }
        
        $divEjercicioCierre = '</div>';
        $mform->addElement('html', $divEjercicioCierre);
        
        //Botón para añadir más preguntas
        $masPreguntas = '<br><center><input type="button" class="button" name="masPreguntas" id="masPreguntas" value="Añadir pregunta" onclick="clonar()" /></center></br>';
        $mform->addElement('html', $masPreguntas);

        // Autoría del ejercicio
        $userid = get_record('user', 'id', $creador);
        $autoria = genera_autoria($userid);
        $mform->addElement('html', $autoria);

        $imagenLicencia = genera_licencia($licencia);
        $mform->addElement('html', $imagenLicencia);

        $radioarrayVisib = array();
        $radioarrayVisib[] = &MoodleQuickForm::createElement('radio', 'radiovisible', '', "Si", "Si", null);
        $radioarrayVisib[] = &MoodleQuickForm::createElement('radio', 'radiovisible', '', "No", "No", null);

        $mform->addGroup($radioarrayVisib, 'radiovisible', get_string('visible', 'ejercicios'), array(' '), false);
        if ($visible == 1) {
            $mform->setDefault('radiovisible', "Si");
        } else {
            $mform->setDefault('radiovisible', "No");
        }

        $radioarrayPriv = array();
        $radioarrayPriv[] = &MoodleQuickForm::createElement('radio', 'radioprivado', '', "Si", "Si", null);
        $radioarrayPriv[] = &MoodleQuickForm::createElement('radio', 'radioprivado', '', "No", "No", null);

        $mform->addGroup($radioarrayPriv, 'radioprivado', get_string('publico', 'ejercicios'), array(' '), false);
        if ($publico == 1) {
            $mform->setDefault('radioprivado', "Si");
        } else {
            $mform->setDefault('radioprivado', "No");
        }

        // Se añade el botón guardar y el texto para las fuentes editable si es modificable
        $fuentes_aux = $ejercicios_leido->get('fuentes');
        $fuentes = genera_fuentes($fuentes_aux, "");
        $mform->addElement('html', $fuentes);
        
        $guardar = '<div name="divBoton" id="divBoton" class="divBoton">';
        $guardar.=  '<center><input type="submit" class="button" id="submitbutton" name="submitbutton" value="'.get_string('BotonGuardar', 'ejercicios').'"></center>';
        $guardar.= '</div>';
        $mform->addElement('html', $guardar);
    }

    //buscando ejercico sin permisos (alumno y profesores no creadores)
    function mostrar_sin_permisos(&$mform, $id, $ejercicios_leido) {
        $nombre = $ejercicios_leido->get('name');
        $idEjercicio =  $ejercicios_leido->get('id');
        $creador = $ejercicios_leido->get('id_creador');
        $licencia = $ejercicios_leido->get("copyrightpreg");
        $foto_asociada = $ejercicios_leido->get("foto_asociada");

        // Se imprime el título del ejercicio
        $titulo = genera_titulos($nombre, get_string('TH_title', 'ejercicios'), $id);
        $mform->addElement('html', $titulo);

        // Se imprime la descripción del ejercicio
        $descripcion = genera_descripcion($ejercicios_leido->get('descripcion'));
        $mform->addElement('html', $descripcion);
        
        if ($foto_asociada == 1) {
            // src para la foto cuando existe
            $srcImage='./ejercicios_get_imagen.php?userPath='.$creador.'&name='.substr(md5($idEjercicio), 0, 10).'&ubicacion=1';
        } else {
            // src para la foto por defecto
            $srcImage="./ejercicios_get_imagen.php?ubicacion=0";
        }
        //Campo de la imagen del ejercicio
        //el nombre que se le da a la foto es el los 10 primero caracteres del md5 del id del ejercicio para que este sea unico
        $imagen = '<div id="capa2"> ';
        $imagen.= '<img  name="fotoAsociada" id="fotoAsociada" src="' . $srcImage . '" style="height: 300px;"/>';

        //Para alumnos
        //Mis palabras
        $imagen .= '<div class="herramientas">';
        $imagen .= '<div><a  onclick=JavaScript:sele(' . $id . ')><img src="../vocabulario/imagenes/guardar_palabras.png" id="id_guardar_im" name="guardar_im" title="' . get_string('guardar', 'vocabulario') . '"/></a></div>';
        $imagen .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=5" target="_blank"><img src="../vocabulario/imagenes/administrar_gramaticas.png" id="id_gram_im" name="gram_im" title="' . get_string('admin_gr', 'vocabulario') . '"/></a></div>';
        $imagen .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=7" target="_blank"><img src="../vocabulario/imagenes/intenciones_comunicativas.png" id="id_ic_im" name="ic_im" title="' . get_string('admin_ic', 'vocabulario') . '"/></a></div>';
        $imagen .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=9" target="_blank"><img src="../vocabulario/imagenes/tipologias_textuales.png" id="id_tt_im" name="tt_im" title="' . get_string('admin_tt', 'vocabulario') . '"/> </a></div>';
        $imagen .='<div><a href="../vocabulario/view.php?id=' . $id . '&opcion=11" target="_blank"><img src="../vocabulario/imagenes/estrategias_icon.png" id="id_ea_im" name="ea_im" title="' . get_string('admin_ea', 'vocabulario') . '"/> </a></div>';
        $imagen .="</div>";
        $imagen.= '</div>';
        $mform->addElement('html', $imagen);
        
         //cargamos los datos del ejercicio
        $textosEjercicio = new Ejercicios_textos();
        $textos = $textosEjercicio->obtener_todos_textos_ejercicicio($idEjercicio);
        $n_textos = '<input type="hidden" value="'.sizeof($textos).'" id="n_textos" name="n_textos">';
        $mform->addElement('html', $n_textos);
        
        //Para mostrar los textos
        for($i=1; $i<=sizeof($textos); $i++) {
            //Cargo todas las palabras del texto i-esimo de BBDD
            $ejercicioth = new Ejercicios_texto_hueco();
            $palabras=$ejercicioth->obtener_todos_id_texto($textos[$i-1]->get('id'));
            
            $divtexto = '<div class="texto" id="texto'.$i.'" name="texto'.$i.'">'.$textos[$i-1]->get('textoauxiliar');
            $divtexto .= '<input type="hidden" value="'.sizeof($palabras).'" id="n_palabras" name="n_palabras">';
            $divtexto .= '<input type="hidden" value="" id="guardapalabras" name="guardapalabras">';
            $mform->addElement("html", $divtexto);
            $divtextocierre = '</div>';
            $mform->addElement("html", $divtextocierre);
            
            //Para mostrar las palabras si el campo solucion esta activo
            for($j=1; $j<=sizeof($palabras); $j++) {
                if($palabras[$j-1]->get('mostrar_solucion')==0){
                    $arrayPalabras[]=$palabras[$j-1]->get('palabra');
                }
            }
            shuffle($arrayPalabras);
            $divpalabras="";
            for ($j=1; $j<=sizeof($arrayPalabras); $j++){
                if(($j-1)%6==0){
                    $divpalabras.='<div class="flex" name="palabras'.$j.'" id="palabras'.$j.'">';
                }
                $divpalabras.='<div class="palabra" "name="palabra'.$i.$j.'" id="palabra'.$i.$j.'" value="'.$arrayPalabras[$j-1].'" onclick="seleccionapalabra(this.id)">'.$arrayPalabras[$j-1].'</div>';
                if(($j-1)%6==5) {
                    $divpalabras.="</div>";
                }
            }
            $divpalabras.="</div>";
            $mform->addElement("html", $divpalabras);
            
            $soluciones = '<div class="flex opciones">';
            $soluciones .= '<div class="divnumero">Numero</div>';
            $soluciones .= '<div class="inputrespuestas">Palabra</div>';
            $soluciones .= '<div class="borrarpalabra">Borrar</div>';
            $soluciones .= '<div class="divpista">Pista</div>';
            $soluciones .= '<div class="divlongitud">Longitud</div>';
            $soluciones .= "</div>";
            $mform->addElement("html", $soluciones);
            
            //Muestro los campos donde se van a insertar las soluciones
            for($j=1; $j<=sizeof($palabras); $j++) {
                if($palabras[$j-1]->get("mostrar_pistas")==0) {
                    $pista=$palabras[$j-1]->get("pista");
                }
                if($palabras[$j-1]->get("mostrar_longitud")==0) {
                    $longitud=strlen($palabras[$j-1]->get("palabra"));
                }
                $divrespuesta='<div class="flex">';
                $mform->addElement("html", $divrespuesta);
                
                $numero='<div class="divnumero">'.$j.'</div>';
                $inputrespuesta='<div class="inputrespuestas"><input type="text" onclick="copiarrespuesta(this.id)" value="" id="respuesta'.$i.$j.'" name="respuesta'.$i.$j.'" ></div>';
                $botonborrar='<div class="borrarpalabra"><img onClick="borrarpalabra(this.id)" id="'.$i.$j.'" src="./imagenes/delete.gif" alt="borrar palabra" height="15px"  width="15px" title="Borrar palabra"/></div>';
                $inputpista='<div class="divpista" id="pista'.$i.$j.'" name="pista'.$i.$j.'">'.$pista.'</div>';
                $inputlongitud='<div class="divlongitud" id="longitud'.$i.$j.'" name="longitud'.$i.$j.'">'.$longitud.'</div>';
                
                $mform->addElement("html", $numero);
                $mform->addElement("html", $inputrespuesta);
                $mform->addElement("html", $botonborrar);
                $mform->addElement("html", $inputpista);
                $mform->addElement("html", $inputlongitud);
                
                $divrespuestacierre="</div>";
                $mform->addElement("html", $divrespuestacierre);
            }
            unset($arrayPalabras);
        }
        
        // Autoría del ejercicio
        $userid = get_record('user', 'id', $creador);
        $autoria = genera_autoria($userid);
        $mform->addElement('html', $autoria);

        $imagenLicencia = genera_licencia($licencia);
        $mform->addElement('html', $imagenLicencia);

        $ejercicios_prof = new Ejercicios_prof_actividad();
        $ejercicios_del_prof = $ejercicios_prof->obtener_uno_idejercicio($idEjercicio);
        if (sizeof($ejercicios_del_prof) == 0) {
            $noagregado = true;
        } else {
            $noagregado = false;
        }

        $fuentes_aux = $ejercicios_leido->get('fuentes');
        $fuentes = genera_fuentes($fuentes_aux, "readonly");
        $mform->addElement('html', $fuentes);

        $tabla_menu = '<center><input type="button" class="button" value="Corregir" onClick=""/> <input type="button" class="button" id="id_Menu" value="Menu Principal" onClick="javascript:botonPrincipal('.$id.')" /></center>';
        $mform->addElement('html', $tabla_menu);
    }
}

?>
