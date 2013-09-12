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
 
  Original idea and content design:
  Ruth Burbat
  Inmaculada Almahano Güeto
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

$string['ejercicios'] = 'ejercicios';

$string['modulename'] = 'ejercicios';
$string['modulenameplural'] = 'ejerciciosS';

$string['ejerciciosfieldset'] = 'Custom example fieldset';
$string['ejerciciosintro'] = 'ejercicios Intro';
$string['ejerciciosname'] = 'ejercicios Name';


$string['Puzzledoble'] = 'Asociación';
$string['CrearEjercicioPuzzle'] = 'Crear Ejercicio Asociación';
$string['tituloeliminar'] = 'Crear Ejercicio Puzzle Doble';


$string['Opcionespuzzlealum'] = 'Ejercicios Asociación';
$string['Nombre']='Nombre';
$string['Imagen']='Numero de imagenes';
$string['Aceptar']='Aceptar';
$string['Reset']='Menú Principal';
$string['Borrar']='Borrar';
$string['TextoEliminar']='Seleccione el ejercicio a eliminar';
$string['Creacion']='Creación de ejercicios';


//Interfaz Alumno

$string['Buscar']='Buscar actividades:';
$string['Boton_Buscar']='Buscar';
$string['Actividades']='Actividades';
$string['Tema']='Campo Temático';
$string['Tipo de Actividad']='Tipo de Actividad';
$string['Destreza comunicativa']='Destreza comunicativa';
$string['Gramatica']='Tema Gramatical';
$string['Realizar']='Realizar';
$string['Crear']='Crear Actividades:';
$string['creando']='Creando ejercicio por Tema:';
$string['Boton_Crear']='Crear';
$string['MisActividades']='Mis Actividades';
$string['ActividadesCurso']='Actividades de mi Curso';
$string['EjerciciosCurso']='Ejercicios propuestos';

$string['Volver']='Atrás';
$string['Intencion']='Intención Comunicativa';


//CLASIFICACION TIPO DE ACTIVIDAD
$string['TotalEjercicios']="15";
$string['Tipo0']="Seleccionar";
$string['Tipo1']="--";
$string['Tipo2']="ELECCIÓN MÚLTIPLE con sus diversas variantes";
$string['Tipo3']="ASOCIACIÓN SIMPLE";
$string['Tipo4']="ASOCIACIÓN COMPLEJA";
$string['Tipo5']="TEXTO HUECO";
$string['Tipo6']="IDENTIFICAR ELEMENTOS";
$string['Tipo7']="RESPUESTA ABIERTA";
$string['Tipo8']="CRUCIGRAMA";
$string['Tipo9']="ORDENAR ELEMENTOS";
$string['Tipo10']="IDENTIFICAR ELEMENTOS MÁS RESPUESTA CORTA";
$string['Tipo11']="IDENTIFICAR ELEMENOS CON ASOCIACIÓN SIMPLE";
$string['Tipo12']="IDENTIFICAR ELEMENOS CON  RESPUESTA MÚLTIPLE";
$string['Tipo13']="PRACTICAR PRONUNCIACIÓN";
//(* Angel Biedma *) Añadido Tipo Ejercicio Entrenador de Vocabulario
$string['Tipo14']="ENTRENADOR DE VOCABULARIO";
//DESCRIPCION DE EJERCICIOS
$string['desc_Tipo0']="Seleccionar";
$string['desc_Tipo1']="--";
$string['desc_Tipo2']="Seleccionar entre varias opciones una solución correcta relacionada con preguntas acerca de un texto, vídeo, o audio. Por ejemplo para practicar la comprensión lectora, comprensión oral, o realizar actividades de gramática y/ o de léxico, etc.";
$string['desc_Tipo3']="Coordinar un determinado número de archivos de texto, vídeo, audio o imagen con el mismo número de archivos de texto, vídeo, audio o imagen. Con este ejercicio se puede practicar la comprensión lectora, comprensión oral o elaborar reglas gramaticales, etc.";
$string['desc_Tipo4']="Seleccionar archivos de texto, vídeo, audio o imagen para coordinarlos con una cantidad inferior o superior de archivos de texto, vídeo, audio o imagen. Al no coincidir el número de archivos de origen y solución es más difícil que los ejercicios de ASOCIACIÓN SIMPLE.";
$string['desc_Tipo5']="Rellenar los huecos de un texto para practicar la gramática o el léxico, la ortografía, elaborar una regla gramatical, etc. El hueco puede tener entre una o varias letras, palabras, etc.";
$string['desc_Tipo6']="IDENTIFICAR ELEMENTOS";
$string['desc_Tipo7']="RESPUESTA ABIERTA";
$string['desc_Tipo8']="CRUCIGRAMA";
$string['desc_Tipo9']="ORDENAR ELEMENTOS";
$string['desc_Tipo10']="IDENTIFICAR ELEMENTOS MÁS RESPUESTA CORTA";
$string['desc_Tipo11']="IDENTIFICAR ELEMENOS CON ASOCIACIÓN SIMPLE";
$string['desc_Tipo12']="IDENTIFICAR ELEMENOS CON  RESPUESTA MÚLTIPLE";
$string['desc_Tipo13']="PRACTICAR PRONUNCIACIÓN";
//(* Angel Biedma *) Añadido Tipo Ejercicio Entrenador de Vocabulario
$string['desc_Tipo14']="ENTRENADOR DE VOCABULARIO";




//CLASIFICACION DESTREZA
$string['Destreza0']="Seleccionar";
$string['Destreza1']="--";
$string['Destreza2']="COMPRENSIÓN LECTORA";
$string['Destreza3']="COMPRENSIÓN ORAL";
$string['Destreza4']="EXPRESIÓN ESCRITA";
$string['Destreza5']="EXPRESIÓN ORAL";
$string['Destreza6']="TRADUCCIÓN";


$string['componerActividades']="Crear Conjunto de Actividades";

//CREANDO EJERICIO FORMULARIO GENERICO

$string["FormularioCreacion"]= "Formulario de Creación";
$string["tipopregunta"]='Tipo de archivo pregunta:';
$string["tipoorigen"]='Tipo de archivo origen/pregunta:';
$string["numeropreguntas"]="Número de archivos/preguntas en total:";
$string["tiporespuesta"]='Tipo de archivo solución:';
$string["numerorespuestas"]="Número de archivos respuesta por pregunta:";
$string["numerorespuestascorrectas"]="Número de archivos respuesta correctos:";
$string["nombre"]="Titule su ejercicio para facilitar la identificación o búsqueda:";
$string["descripcion"]="Añade unas breves instrucciones del ejercicio para el alumno:";
$string["visible"]="Visible (accesible por sus alumnos)";
$string["publico"]="Público (accesible por otros profesores y alumnos)";
//$string["carpeta"]="Introduzca la ruta del ejercicio";
$string["carpeta"]="Seleccione la carpeta donde quiera guardar el ejercicio";
$string["copyright"]="Seleccione el copyright de sus archivos pregunta";
$string["copyrightresp"]="Seleccione el copyright de sus archivos respuesta";
$string["textoclasej"]="Asigne una o varias categorías de búsqueda de los siguientes menús desplegables(Obligatorio Campo Temático o Tema gramatical):";
//Formulario de creacion texto-texto

$string["FormularioCreacionTextos"]="Introduzca las preguntas y respuestas del ejercicio";
$string["pregunta"]="Pregunta ";
$string["respuesta"]="Respuesta ";
$string["Correcta"]="Correcta ";
$string["BotonAñadirRespuesta"]="Añadir otra Respuesta";

$string["BotonCorregir"]="Corregir";
$string["BotonGuardar"]="Guardar";



//Mis ejercicios(Ejercicios profesor)
$string["MisEjercicios"]="Mis Ejercicios";
$string["Ejercicios"]="Ejercicios";
$string["MiBusqueda"]="Mi Busqueda";


//Buscando
$string["BotonAñadir"]="Añadir a mis ejercicios";
$string['Misejercicios']='Mis Actividades';
$string["marcoteorico"]="Seleccionar el nivel según el marco europeo de referecia(OPCIONAL)";


//A partir de aqui hay que traducir a ingles
$string["textoorigen"]="Introduzca texto origen";
$string["Asociacion_Texto"]= "Texto ";
$string["Asociacion_Texto_Asociado"]= "Texto Asociado  ";
$string['Video']='Introduzca la dirección del video';
$string['NuevaAso']='Añadir Aso';
$string['tipopregunta1']='Tipo de archivo pregunta';

//Generador de Ejercicios -- Texto Hueco -- Etiqueta TH
$string["TH_texto"]="Texto ";
$string["TH_huecos"]="Palabras ocultadas ";
$string["TH_add_hueco"]="Añadir Hueco";
$string["TH_mostrar_pistas"]="¿Desea que se muestren pistas sobre la longitud de las palabras que se colocan en los huecos?";
$string["TH_mostrar_palabras"]="¿Desea que aparezcan las soluciones de los huecos en la parte inferior del ejercicio?";
$string["TH_mostrar_soluciones"]="¿Desea que aparezcan las soluciones al pulsar el boton de Corregir los ejercicios?";
$string["TH_introduzca_texto"]="Introduzca el texto en el cual se seleccionaran los huecos";
$string['TH_configuracion_ejercicio']="Configuraci&oacute;n del Ejercicio";
$string['TH_pistas']="Pistas";
$string['TH_pista_longitud']='Ocupa {$a} simbolos';

//Titulos de Ejercicios
$string['MC_title']="Multiple Choice";
$string['AS_title']="Asociacion Simple";
$string['AC_title']="Asociacion Compleja";
$string['TH_title']="Texto Hueco";
$string['OE_title']="Ordenar Elementos";
$string['IE_title']="Identificar Elementos";
$string['IERC_title']="Identificar Elementos mas Respuesta Corta";

//Generador de Ejercicios -- Ordenar Elementos -- Etiqueta OE
$string['OE_seleccione']="Escriba la frase que quiera desordenar.";
$string['OE_add_orden']="Añadir Orden";
$string['OE_add_palabra']="Insertar Elemento";
$string['OE_add_frase']="Añadir Frase o Parrafo";
$string['OE_pregunta']='Texto';
$string['OE_orden']='Orden {$a} :';
$string['OE_introduzca_texto']='En esta area de texto puede escribir, y despues puede seleccionar texto y añadir nuevas palabras a los ordenes';
$string['OE_add_pregunta']='Añadir Oración o Parrafo Nueva';
$string['OE_orden_unico']="Seleccione la casilla para activar que haya multiples ordenes correctos. Si se deja desactivada solo se permitira un orden correcto.";
$string['OE_help_add_palabra']='Primero introduzca las frases/los párrafos. <br/><br/> Después seleccione con el ratón los elementos que quiera desordenar. Éstos aparecerán enumerados segun el orden en el que se han seleccionado. A continuación pulse en <i>Insertar Elemento</i> para confirmar.<br/><br/>';
$string['OE_help_add_more_palabra']="Podra añadir mas opciones correctas al pulsar en Aceptar.";
$string['OE_config']="¿Quiere que en este ejercicio haya sólo una opción correcta o varias?";
$string['OE_list_preguntas']="Lista de Oraciones o Parrafos";
$string['OE_help_orden_multiple']="Se guardara todo en mayuscula. Es recomendable seleccionar lo signos de puntuacion como elementos independientes.";
$string["OE_FormularioCreacionTextos"]="Introduzca las frases y determine los elementos";
$string["OE_orden_unico"]="Solo un orden correcto.";
$string["OE_orden_multiple"]="Varios ordenes correctos.";
$string["OE_help_flechas"]="Puede cambiar el orden de los elementos con la ayuda de las flechas a al derecha.";
$string["OE_tipoorden"]="Se ordenarán: ";
$string["OE_tipoorden_frase"]="Elementos de una frase";
$string["OE_tipoorden_parrafos"]="Frases de un Párrafo o párrafos de un texto";


//Generador de Ejercicios -- IE mas RC -----
$string['IERC_num_subresp']="Numero de subrespuestas para cada respuesta";
$string['IERC_enunciado']="Texto: ";
$string['IERC_pregunta']='Texto {$a}';
$string['IERC_cabecera']='Cabecera {$a}';
$string['IERC_click']="Pulse para editar";
$string['IERC_eliminar']="Eliminar";
$string['IERC_instr_prof']='Introduce el texto y las soluciones';
$string['IERC_descripcion']='Instrucciones del ejercicio como se le muestran al alumno';
$string['IERC_descripcion2']='Si tiene más de una pregunta relacionada con el elemento a identificar es recomendable que las redacte siguiendo el orden a), b), c), etc... (Hay hasta 5 opciones)';
$string['IERC_addPregunta']='Añadir Pregunta';
?>
