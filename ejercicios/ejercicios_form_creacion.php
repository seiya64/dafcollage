<?php //$Id: mod_form.php,v 1.2.2.3 2009/03/19 12:23:11 mudrd8mz Exp $

/**
 * This file defines the main ejercicios configuration form
 * It uses the standard core Moodle (>1.8) formslib. For
 * more info about them, please visit:
 *
 * http://docs.moodle.org/en/Development:lib/formslib.php
 *
 * The form must provide support for, at least these fields:
 *   - name: text element of 64cc max
 *
 * Also, it's usual to use these fields:
 *   - intro: one htmlarea element to describe the activity
 *            (will be showed in the list of activities of
 *             ejercicios type (index.php) and in the header
 *             of the ejercicios main page (view.php).
 *   - introformat: The format used to write the contents
 *             of the intro field. It automatically defaults
 *             to HTML when the htmleditor is used and can be
 *             manually selected if the htmleditor is not used
 *             (standard formats are: MOODLE, HTML, PLAIN, MARKDOWN)
 *             See lib/weblib.php Constants and the format_text()
 *             function for more info
 */

require_once($CFG->dirroot.'/course/moodleform_mod.php');
require_once("ejercicios_clases.php");


/* Formulario generico de ejercicos de cualquier tipo de actidad
 * @author Serafina Molina Soto
 * Multichoice con sus variantes 1
 * Asocicacion simple 2
 * Asociacion complejo 3
 */


class mod_ejercicios_creando_ejercicio extends moodleform_mod {

    function mod_ejercicios_creando_ejercicio($id,$tipocreacion)
        {
         // El fichero que procesa el formulario es gestion.php
         parent::moodleform('ejercicios_gestion_creacion.php?id_curso='.$id.'&tipocreacion='.$tipocreacion);
       }
       
     function definition() {
     }
     
   
     /**
     * Function that add a table to the forma to show the main menu
     *
     * @author Serafina Molina Soto
     * @param $id id for the course
     * @param $id_ej id del ejercicio a pinar
     */
     function pintarformulario($id,$tipocreacion){
         
      
        global $CFG, $COURSE, $USER;
        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);
    
        $mform = &$this->_form;
       
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./estilo.css">');
        $mform->addElement('html', '<script type="text/javascript" src="./funciones.js"></script>');
        //titulo
         $titulo= '<h2>' . get_string('FormularioCreacion', 'ejercicios') . '</h2>';
         $mform->addElement('html',$titulo);
         
            
            $tabla='<div id="formulario">';
            $mform->addElement('html',$tabla);
           //Seleccione el tipo de archivo pregunta (texto/ audio/ vídeo/ foto)
         
           $radioarray=array();
           $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiopregunta', '', "Texto","Texto", null);
           $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiopregunta', '', "Audio", "Audio", null);
           $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiopregunta', '', "Video", "Video", null);
           $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiopregunta', '', "Foto", "Video", null);
           
           $titulo= '</br>';
           $mform->addElement('html',$titulo);
           
           $mform->addGroup($radioarray, 'radiopregunta', get_string('tipopregunta', 'ejercicios') , array(' '), false);
           $mform->setDefault('radiopregunta',"Texto");
           
           
           //Seleccione el número total de archivos pregunta
            $numimagenes=array();
            for($i=0;$i<9;$i++){
              $numimagenes[] = $i+1;
             }
           $mform->addElement('select', 'numeropreguntas', get_string('numeropreguntas', 'ejercicios'), $numimagenes);
           
           //Seleccione el tipo de archivo respuesta (texto/ audio/ vídeo/ foto)
       
           $radioarray=array();
           $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiorespuesta', '', "Texto","Texto", null);
           $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiorespuesta', '', "Audio", "Audio", null);
           $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiorespuesta', '', "Video", "Video", null);
           $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiorespuesta', '', "Foto", "Video", null);
           
           $mform->addGroup($radioarray, 'radiorespuesta',  get_string('tiporespuesta', 'ejercicios'), array(' '), false);
           $mform->setDefault('radiorespuesta',"Texto");
           
          /* 
            //Seleccione el número total de archivos respuesta
            $numimagenes=array();
            for($i=0;$i<9;$i++){
              $numimagenes[] = $i+1;
             }
           $mform->addElement('select', 'numerorespuestas',  get_string('numerorespuestas', 'ejercicios'), $numimagenes);
           
            
              //Seleccione el número total de archivos respuesta
            $numimagenes=array();
            for($i=0;$i<9;$i++){
              $numimagenes[] = $i+1;
             }
           $mform->addElement('select', 'numerorespuestascorrectas',get_string('numerorespuestascorrectas', 'ejercicios'), $numimagenes,"onchange=JavaScript:Comprobacionesform()");
           */
           //Clasificacion
           
           $clasi='</br><div"></br></center>Asigne una o varias categorías de búsqueda de los siguientes menús desplegables:</center></br></br>';
           $mform->addElement('html',$clasi);
           //Campo tematico
           
                        
           $aux = new Vocabulario_campo_lexico();
           $clex = $aux->obtener_hijos($USER->id, 0);
 
        
            //campo lexico
           $mform->addElement('select', 'campoid',get_string('Tema', 'ejercicios'), $clex, "onChange='javascript: if( this.options[this.selectedIndex].text == \"--\" || this.options[this.selectedIndex].text == \"Seleccionar\" ) { this.selectedIndex == 0; this.options[0].selected = true; document.getElementById(\"clgeneraldinamico\").style.display=\"none\";} else { cargaContenido(this.id,\"clgeneraldinamico\",0); document.getElementById(\"clgeneraldinamico\").style.display=\"\";}' style=\"min-height: 0;\"");
           //probar los campos dinamicos
           $campodinamico = "<div id=\"clgeneraldinamico\"></div>";
           $mform->addElement('html', $campodinamico);
          
           
            //Destreza   
            $clasificaciondestreza=array();
            
            for($i=0;$i<7;$i++){
            $clasificaciondestreza[]=get_string('Destreza'.$i,'ejercicios');
       
            }
            
            $mform->addElement('select', 'DestrezaComunicativa', get_string("Destreza comunicativa", "ejercicios"), $clasificaciondestreza);
           
            //Tema Gramatical
            
              $aux = new Vocabulario_gramatica();
            $gramaticas = $aux->obtener_hijos($USER->id, 0);
            $lista_padres = $aux->obtener_padres($USER->id, $grid);
            
            $mform->addElement('select', 'campogr', get_string('Gramatica', 'ejercicios'), $gramaticas, "onChange='javascript:cargaContenido(this.id,\"grgeneraldinamico\",1)' style=\"min-height: 0;\"");
            $mform->setDefault('campogr', $lista_padres[1]);
            //probar los campos dinamicos
            $i = 1;
            $divparacerrar = 0;
            $campodinamico = "<div class=\"fitem\" id=\"grgeneraldinamico\"  style=\"min-height: 0;\">";
            while ($lista_padres[$i + 1]) {
                $aux = new Vocabulario_gramatica();
                $graux = $aux->obtener_hijos($USER->id, $lista_padres[$i]);
                $campodinamico .= '<div class="fitemtitle"></div>';
                $campodinamico .= '<div class="felement fselect">';
                $elselect = new MoodleQuickForm_select('campogr', 'Subcampo', $graux, "id=\"id_campogr" . $lista_padres[$i] . "\" onChange='javascript:cargaContenido(this.id,\"" . 'campogr' . "grgeneraldinamico" . $lista_padres[$i] . "\",1)'");
                $elselect->setSelected($lista_padres[$i + 1]);
                $campodinamico .= $elselect->toHtml();
                $campodinamico .= '</div>';
                $campodinamico .= "<div class=\"fitem\" id=\"" . 'campogr' . "grgeneraldinamico" . $lista_padres[$i] . "\" style=\"min-height: 0;\">";
                $i = $i + 1;
                $divparacerrar++;
            }
            for ($i = 0; $i < $divparacerrar; $i++) {
                $campodinamico .= "</div>";
            }
            $campodinamico .= "</div>";
            $mform->addElement('html', $campodinamico);

            //Intencion comunicativa
            
            
             $aux = new Vocabulario_intenciones();
             $icom = $aux->obtener_hijos($USER->id, 0);
             $lista_padres = $aux->obtener_padres($icid);
            
            $mform->addElement('select', 'campoic', get_string("Intencion", "ejercicios"), $icom, "onChange='javascript:cargaContenido(this.id,\"icgeneraldinamico\",2)' style=\"min-height: 0;\"");
            $mform->setDefault('campoic', $lista_padres[1]);
            //probar los campos dinamicos
            $i = 1;
            $divparacerrar = 0;
            $campodinamico = "<div class=\"fitem\" id=\"icgeneraldinamico\"  style=\"min-height: 0;\">";
            while ($lista_padres[$i + 1]) {
                $aux = new Vocabulario_intenciones();
                $icaux = $aux->obtener_hijos($USER->id, $lista_padres[$i]);
                $campodinamico .= '<div class="fitemtitle"></div>';
                $campodinamico .= '<div class="felement fselect">';
                $elselect = new MoodleQuickForm_select('campoic', 'Subcampo', $icaux, "id=\"id_campoic" . $lista_padres[$i] . "\" onChange='javascript:cargaContenido(this.id,\"" . 'campoic' . "icgeneraldinamico" . $lista_padres[$i] . "\",2)'");
                $elselect->setSelected($lista_padres[$i + 1]);
                $campodinamico .= $elselect->toHtml();
                $campodinamico .= '</div>';
                $campodinamico .= "<div class=\"fitem\" id=\"" . 'campoic' . "icgeneraldinamico" . $lista_padres[$i] . "\" style=\"min-height: 0;\">";
                $i = $i + 1;
                $divparacerrar++;
            }
            for ($i = 0; $i < $divparacerrar; $i++) {
                $campodinamico .= "</div>";
            }
            $campodinamico .= "</div>";
            $mform->addElement('html', $campodinamico);
            
   
           
            //Tipo de texto (Tipologías textuales)
            
            $aux = new Vocabulario_tipologias();
            $tipologias = $aux->obtener_todos($USER->id);
            $mform->addElement('select', 'campott', get_string("campo_tipologia", "vocabulario"), $tipologias);
           
             $mform->addElement('html','</br></div></br>');
           
             //marco teorico
             
            $marcoteorico=array();
            $marcoteorico[]="--";
            $marcoteorico[]="A1";
            $marcoteorico[]="A2";
            $marcoteorico[]="B1";
            $marcoteorico[]="B2";
            $marcoteorico[]="C1";
            $marcoteorico[]="C2";
            $mform->addElement('select', 'marcoteorico', get_string("marcoteorico", "ejercicios"), $marcoteorico);


            //Titule su ejercicio para facilitar la identificación o búsqueda
            $attributes='size="40"';
            $mform->addElement('text', 'nombre_ejercicio',get_string('nombre', 'ejercicios') , $attributes);
            $mform->addRule('nombre_ejercicio', "Titulo Necesario", 'required', null, 'client');
             
            //Añade una breve introducción al ejercicio

            $mform->addElement('textarea', 'descripcion', get_string('descripcion', 'ejercicios'), 'wrap="virtual" rows="10" cols="50"');
            $mform->addRule('descripcion', "Descripción Necesaria", 'required', null, 'client');
            //botones
            
           $radioarray=array();
           $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiovisible', '', "Si","Si", null);
           $radioarray[] = &MoodleQuickForm::createElement('radio', 'radiovisible', '', "No", "No", null);
              
           $mform->addGroup($radioarray, 'radiovisible',  get_string('visible', 'ejercicios'), array(' '), false);
           $mform->setDefault('radiovisible',"Si");
           
           $radioarray=array();
           $radioarray[] = &MoodleQuickForm::createElement('radio', 'radioprivado', '', "Si","Si", null);
           $radioarray[] = &MoodleQuickForm::createElement('radio', 'radioprivado', '', "No", "No", null);
              
           $mform->addGroup($radioarray, 'radioprivado',  get_string('publico', 'ejercicios'), array(' '), false);
           $mform->setDefault('radioprivado',"Si");
           
           
            $attributes='size="40"';
            $mform->addElement('text', 'carpeta_ejercicio',get_string('carpeta', 'ejercicios') , $attributes);
            $mform->addRule('carpeta_ejercicio', "Carpeta Necesaria", 'required', null, 'client');
                 //Copyright
            
            $cright=array();
            $cright[]="--";
            $cright[]="Reconocimiento (CC-BY)";
            $cright[]="Reconocimiento-CompartirIgual (CC-BY-SA)";
            $cright[]="Reconocimiento-NoDerivadas (CC-BY-ND)";
            $cright[]="Reconocimiento-NoComercial (CC-BY-NC)";
            $cright[]="Reconocimiento-NoComercial-CompartirIgual (CC-BY-NC-SA)";
            $cright[]="Reconocimiento-NoComercial-NoDerivadas (CC-BY-NC-ND)";
            
            $mform->addElement('select', 'copyright', get_string("copyright", "ejercicios"), $cright,"onChange='javascript:cargaDescripcion(1)'");

            $cright=array();
            $cright[]="--";
            $cright[]="Reconocimiento (CC-BY)";
            $cright[]="Reconocimiento-CompartirIgual (CC-BY-SA)";
            $cright[]="Reconocimiento-NoDerivadas (CC-BY-ND)";
            $cright[]="Reconocimiento-NoComercial (CC-BY-NC)";
            $cright[]="Reconocimiento-NoComercial-CompartirIgual (CC-BY-NC-SA)";
            $cright[]="Reconocimiento-NoComercial-NoDerivadas (CC-BY-NC-ND)";
            
            $mform->addElement('select', 'copyrightresp', get_string("copyrightresp", "ejercicios"), $cright,"onChange='javascript:cargaDescripcion(2)'");

            
            $buttonarray = array();
            $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('Aceptar','ejercicios'),"onClick='javascript:compruebaCopyright(".$id.",".$tipocreacion.")'");
            $mform->addGroup($buttonarray, 'botones', '', array(' '), false);
        
             
            $tabla='</div>';
            $mform->addElement('html',$tabla);
        
    }
}


class mod_ejercicios_creando_ejercicio_texto extends moodleform_mod {

    function mod_ejercicios_creando_ejercicio_texto($id,$p,$id_ejercicio)
        {
         // El fichero que procesa el formulario es gestion.php
         parent::moodleform('ejercicios_creacion_texto_texto.php?id_curso='.$id.'&id_ejercicio='.$id_ejercicio);
       }
       
     function definition() {
     }
     
   
     /**
     * Function that add a table to the forma to show the main menu
     *
     * @author Serafina Molina Soto
     * @param $id id for the course
     * @param $p numero de preguntas
     * @param $r numero de respuetas
     * @param $c numero de respuestas correctas
     * @param $id_ejercicio id del ejercicio que estamos creando 
     */
     function pintarformulariotexto($id,$p,$id_ejercicio){
         
         global $CFG, $COURSE, $USER;
        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);
  
        $mform =& $this->_form;
       
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="./estilo.css">');
        $mform->addElement('html', '<script type="text/javascript" src="./funciones.js"></script>');
        //titulo
        $titulo= '<h1>' . get_string('FormularioCreacionTextos', 'ejercicios') . '</h1>';
        $mform->addElement('html',$titulo);
       
        //Para cada pregunta
        for($i=0;$i<$p;$i++){
             $aux=$i+1;
             $titulo= '<h3> Pregunta ' .$aux. '</h3>';
             $mform->addElement('html',$titulo);
           
            $mform->addElement('textarea', 'pregunta'.$aux, get_string('pregunta', 'ejercicios').$aux, 'wrap="virtual" rows="5" cols="50"');
            $mform->addRule('descripcion', "Pregunta Necesaria", 'required', null, 'client');
         
           // $mform->addElement('hidden','numerorespuestas_'.$aux,3);
           
            $textarea='</br><div id="titulorespuestas" style="margin-left:130px;">Respuestas:</div>'; 
            $textarea.='<div style="margin-left:310px;" id="respuestas_pregunta"'.$aux.'"> ';
            $textarea.='<textarea name="respuesta1_'.$aux.'" id="respuesta1_'.$aux.'" rows="5" cols="50"></textarea>';
            $textarea.='</br><div id="correctarespuesta">'.get_string('Correcta', 'ejercicios'); 
            $textarea.='<input type="radio"  name="correcta1_'.$aux.'" id="correcta1_'.$aux.'" value="Si" checked> Si </input>';
            $textarea.='<input type="radio" name="correcta1_'.$aux.'"  id="correcta1_'.$aux.'" value="No"> No </input>';
            $textarea.='</br>';
            $textarea.='</div>';
            
          
            $textarea.='<input type="hidden" name="numerorespuestas_'.$aux.'" id="numerorespuestas_'.$aux.'" value="1"/>';
            $textarea.='</div>';
            $mform->addElement('html',$textarea);
   
           // $mform->addElement('text', 'numerorespuestas_'.$aux,"hola");
            $botonañadir='<center><input type="button" style="height:30px; width:140px; margin-left:175px;" value="'.get_string('BotonAñadirRespuesta','ejercicios').'" onclick="botonMasRespuestas('.$aux.');"></center>';
         
            $mform->addElement('html', $botonañadir);
            
                      
        }
        
           $mform->addElement('hidden','numeropreguntas',$p);
          
            $buttonarray = array();
            $buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('Aceptar','ejercicios'),"onclick=obtenernumeroRespuestas('$p');");
            $mform->addGroup($buttonarray, 'botones', '', array(' '), false);
        
     }
}



?>

