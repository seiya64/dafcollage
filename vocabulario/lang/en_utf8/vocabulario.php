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

Original idea and content design:
    Ruth Burbat
    Andrea Bies
    Julia Möller Runge
    Antonio Salmerón Matilla
    Karin Vilar Sánchez
    Inmaculada Almahano Güeto
    Blanca Rodríguez Gómez
    María José Varela Salinas

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.*/


//lo que aqui aparece en aleman es porque tiene que ser asi
//traducir esas partes al idioma que se quiere enseñar para que sirva para cualquiera
$string['vocabulario'] = 'Wordbook';
$string['modulenameplural'] = 'Wordbooks';
$string['modulename'] = 'Wordbook';
$string['buttonlabel'] = 'Save';
$string['campo_lex'] = 'Lexical field';
$string['campo_gram'] = 'Grammar';
$string['campo_intencion'] = 'Communicativa intent';
$string['campo_tipologia'] = 'Text types';
$string['pal'] = 'Word';
$string['Tpal'] = 'Meaning';
$string['gen'] = 'Gender';
$string['masc'] = 'Masculine';
$string['fem'] = 'Feminine';
$string['neu'] = 'Neutral';
$string['plural'] = 'Plural';
$string['sust'] = 'Substantive';
$string['adj'] = 'Adjetive';
$string['vrb'] = 'Verb';
$string['otr'] = 'Other words';
$string['comen'] = 'Observations';
$string['3per'] = 'Third person singular';
$string['infi'] = 'Infinitive';
$string['pret'] = 'Preterite';
$string['part'] = 'Participle';
$string['sindec'] = 'No decline';
$string['otr_sus'] = 'Other sustantive';
$string['desc'] = 'Description';
$string['opciones'] = 'Options';
$string['advrb'] = 'Add verb';
$string['adadj'] = 'Add adjetive';
$string['adotr'] = 'Add other word';
$string['adgr'] = 'Add description';
$string['error_sus'] = 'Write any word';
$string['ver'] = 'My words';
$string['guardar'] = 'Save new word';
$string['editar'] = 'Edit';
$string['eliminar'] = 'Delete';
$string['atras'] = 'Back';
$string['id'] = 'Id';
$string['todo'] = 'All combinations';
$string['alfabetico'] = 'Alphabetical';
$string['pdf'] = 'Print pdf';
$string['revert'] = 'Clean';
$string['vease_pdf'] = '*Observations';
$string['admin_cl'] = 'My lexical fields';
$string['admin_gr'] = 'My gramars';
$string['admin_ic'] = 'My communicative intents';
$string['admin_tt'] = 'My text types';
$string['admin_ea'] = 'My learning strategies';
$string['seccion'] = 'Section';
$string['nivel'] = 'Save subsection';
$string['alumnos'] = 'Students';
$string['pal_gr'] = 'Words relates to this grammar';
$string['pal_ic'] = 'Words relates to this communicative intent';
$string['pal_tt'] = 'Words relates to this text type';
$string['especificar_gr'] = 'Grammar specifying';
$string['especificar_inten'] = 'Communicative intent specifying';
$string['especificar_tipo'] = 'Test type specifying';
$string['referencia'] = 'Ref';
$string['diccionario'] = 'Dictionary';
$string['emisor'] = 'Issuer';
$string['ref_em'] = 'Reference to the issuer';
$string['ex_em'] = 'Exclusion to the issuer';
$string['ref_des'] = 'Reference to the receiver';
$string['ex_des'] = 'Excusion to the receiver';
$string['elem'] = 'Announce element of speech';
$string['resu'] = 'Announce sumary of speech';
$string['verdesc'] = 'Show description';
$string['guardesc'] = 'Save description';
$string['ayuda'] = 'Help';
//preguntas tipologias textuales
$string['quien'] = '¿Quién transmite?';
$string['finalidad'] = '¿Con qué finalidad?';
$string['a_quien'] = '¿A quién?';
$string['medio'] = '¿A través de qué medio?';
$string['donde'] = '¿Dónde?';
$string['cuando'] = '¿Cuándo?';
$string['motivo'] = '¿Con qué motivo?';
$string['funcion'] = '¿Con qué función?';
$string['sobre_que'] = '¿Sobre qué?';
$string['que'] = '¿Qué?';
$string['orden'] = '¿En qué orden?';
$string['medios_nonverbales'] = '¿Con qué medios no verbales?';
$string['que_palabras'] = '¿Con qué palabras?';
$string['que_frases'] = '¿Con qué frases?';
$string['que_tono'] = '¿En qué tono?';
//a partir de aqui cosas en aleman
$string['generales'] = 'Allgemeines';
$string['particulares'] = 'Lerntipps';
$string['declinacion1'] = 'Deklination mit dem Nullartikel';
$string['declinacion2'] = 'Deklination mit bestimmtem Artikel';
$string['declinacion3'] = 'Deklination mit unbestimmtem Artikel';
$string['masculino'] = 'Maskulin';
$string['neutro'] = 'Neutrum';
$string['femenino'] = 'Feminin';
$string['plural'] = 'Plural';
$string['nominativo'] = 'Nominativ';
$string['acusativo'] = 'Akkusativ';
$string['dativo'] = 'Dativ';
$string['genitivo'] = 'Genitiv';
$string['indicativo'] = 'Indikativ';
$string['conjuntivo1'] = 'Konjunktiv I';
//personas
$string['S1'] = 'ich';
$string['S2'] = 'du';
$string['S3'] = 'er/sie/es';
$string['P1'] = 'wir';
$string['P2'] = 'ihr';
$string['P3'] = 'sie/ Sie';
//seguimos con mas cosas
$string['beachten'] = 'Beachten';
$string['participio1'] = 'Regeln zur Bildung des Partizip I';
$string['participio2'] = 'Regeln zur Bildung des Partizip II';
$string['hilfsverbs'] = 'Regeln zum Gebrauch des Hilfsverbs';
$string['zustandspassiv'] = 'Zustandspassiv';
$string['vorganspassiv'] = 'Vorganspassiv';
$string['lista'] = 'Liste der Artikelwörter';
$string['scheinbare'] = 'Scheinbare Artikelwörter';
?>
