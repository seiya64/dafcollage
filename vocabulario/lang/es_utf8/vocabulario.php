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
GNU General Public License for more details.*/


//lo que aqui aparece en aleman es porque tiene que ser asi
//traducir esas partes al idioma que se quiere enseñar para que sirva para cualquiera
$string['vocabulario'] = 'vocabulario';
$string['modulenameplural'] = 'vocabularios';
$string['modulename'] = 'vocabulario';
$string['buttonlabel'] = 'Guardar';
//$string['campo_lex'] = 'Campo l&eacute;xico';
$string['campo_lex'] = 'Campos temáticos';
$string['campo_gram'] = 'Gramática';
$string['campo_intencion'] = 'Intención Comunicativa';
$string['campo_intencion_nuevo'] = 'Nombre nueva int. comunicativa';
$string['campo_tipologia'] = 'Tipología textual';
$string['ejem'] = 'Ejemplo';
$string['pal'] = 'Palabra';
$string['Tpal'] = 'Significado';
$string['gen'] = 'Género';
$string['masc'] = 'Masculino';
$string['fem'] = 'Femenino';
$string['neu'] = 'Neutro';
$string['masc_corto'] = 'M';
$string['fem_corto'] = 'F';
$string['neu_corto'] = 'N';
$string['plural'] = 'Plural';
$string['sing'] = 'Singular';
$string['sust'] = 'Sustantivo';
$string['adj'] = 'Adjetivo';
$string['vrb'] = 'Verbo';
$string['otr'] = 'Otras palabras';
$string['comen'] = 'Observaciones';
$string['3per'] = 'Tercera persona del singular';
$string['infi'] = 'Infinitivo';
$string['pret'] = 'Pretérito';
$string['part'] = 'Participio';
$string['sindec'] = 'Sin declinación';
$string['otr_sus'] = 'Otro';
$string['desc'] = 'Descripción';
$string['opciones'] = 'Opciones';
$string['advrb'] = 'Añadir verbo';
$string['adadj'] = 'Añadir adjetivo';
$string['adotr'] = 'Añadir otra';
$string['adgr'] = 'Añadir descripción';
$string['error_sus'] = 'No has escrito ninguna palabra para guardarla';
$string['ver'] = 'Buscar';
$string['guardar'] = 'Mis palabras';
$string['editar'] = 'Editar';
$string['eliminar'] = 'Eliminar';
$string['atras'] = 'Atrás';
$string['id'] = 'Identificador';
$string['todo'] = 'Todas las palabras';
$string['alfabetico'] = 'Alfabético';
$string['pdf'] = 'Copia en pdf';
$string['revert'] = 'Limpiar';
$string['vease_pdf'] = '*Observaciones';
$string['anotar'] = 'Anotar';
$string['busc'] = 'Buscar y organizar';
$string['nuevos'] = 'Crear nuevos campos';
//$string['admin_cl'] = 'Nuevo campo léxico';
//$string['admin_cl'] = 'Nuevo campo temático';
$string['admin_cl'] = 'Léxico';
$string['admin_gr'] = 'Mi gramática';
$string['admin_ic'] = 'Mis intenciones comunicativas';
$string['nueva_ic'] = 'Intención comunicativa';
$string['admin_tt'] = 'Mis tipologías textuales';
$string['admin_ea'] = 'Mis estrategias de aprendizaje';
$string['seccion'] = 'Sección';
$string['nivel'] = 'Seleccionar un campo: ';
$string['alumnos'] = 'Alumnos del curso';
$string['pal_gr'] = 'Palabras relacionadas con esta gramática';
$string['pal_ic'] = 'Palabras relacionadas con esta intención comunicativa';
$string['pal_tt'] = 'Palabras relacionadas con esta tipología textual';
$string['especificar_gr'] = 'Especificar la gramática';
$string['especificar_inten'] = 'Especificar la intención comunicativa';
$string['especificar_tipo'] = 'Especificar la tipología textual';
$string['referencia'] = 'Ref';
$string['diccionario'] = 'Diccionario';
$string['emisor'] = 'Emisor';
$string['ref_em'] = 'Referencia al emisor';
$string['ex_em'] = 'Exclusión del emisor';
$string['ref_des'] = 'Referencia al destinatario';
$string['ex_des'] = 'Excusión del destinatario';
$string['elem'] = 'Anunciar elemento del discurso';
$string['resu'] = 'Anunciar resumen del discurso';
$string['verdesc'] = 'Ver plantilla';
$string['guardesc'] = 'Guardar cambios';
$string['ayuda'] = 'Ayuda';
$string['cancel'] = 'Menú principal';
$string['mascampos'] = 'Otros campos';
$string['listado'] = 'Mostrar listado';
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
$string['mastablas'] = 'Añadir nueva tabla';
$string['masfilas'] = 'Añadir nueva fila';
$string['muestra_tabla'] = 'Editar tabla';
$string['nopermisos'] = 'No tienes permisos';
//descripciones de las intenciones
$string['desc_inten3.3'] = 'Se refiere a una condición que ya no se puede realizar al referirse ésta al pasado.';
$string['desc_inten4.1'] = 'Se refiere a acciones realizadas por seres vivos / instituciones etc. para conseguir un determinado fin.';
$string['desc_inten4.2'] = 'Se refiere a recursos / instrumentos que se utilizan con un determinado fin.';
$string['desc_inten5.1'] = 'Se refiere a una consecuencia que se ha esperado y que finalmente se ha realizado.';
$string['desc_inten5.2'] = 'Se refiere a una consecuencia que se ha esperado pero que no se ha realizado.';
//a partir de aqui cosas en aleman que en principio no se cambian
$string['definido'] = 'Definitiv';
$string['indefinido'] = 'Indefinitiv';
$string['generales'] = 'Allgemeines';
$string['particulares'] = 'Lerntipps';
$string['declinacion1'] = 'Deklination Typ 1';
$string['declinacion2'] = 'Deklination Typ 2';
$string['declinacion3'] = 'Deklination Typ 3';
$string['declinacion4'] = 'Deklinationsendungen';
$string['declinacion_siehe'] = 'Deklinationsendungen (siehe auch 2.4 Indefinitpronomen)';
$string['masculino'] = 'Maskulin';
$string['neutro'] = 'Neutrum';
$string['femenino'] = 'Feminin';
$string['plural'] = 'Plural';
$string['nominativo'] = 'Nominativ';
$string['acusativo'] = 'Akkusativ';
$string['dativo'] = 'Dativ';
$string['acudat'] = 'Akkusativ + Dativ';
$string['genitivo'] = 'Genitiv';
$string['indicativo'] = 'Indikativ';
$string['conjuntivo'] = 'Konjunktiv';
$string['conjuntivo1'] = 'Konjunktiv I';
$string['conjuntivo2'] = 'Konjunktiv II';
$string['preterito'] = 'Präteritum';
$string['prasens'] = 'Präsens';
$string['perfecto'] = 'Perfekt';
$string['clasificacionsemantica'] = 'Klassifizierung nach semantischen Aspekten';
$string['clasificacionformal'] = 'Klassifizierung nach formalen Aspekten';
$string['endungs'] = 'Endung Singular';
$string['endungp'] = 'Endung Plural';
$string['genero'] = 'Genus';
$string['reinesf'] = 'Reine Singularformen';
$string['reinepf'] = 'Reine Pluralformen';
$string['beispielsatz'] = 'Beispielsatz';
$string['beispiele_def'] = 'Beispiele Definitartikel';
$string['beispiele_indef'] = 'Beispiele Indefinitartikel';
$string['beispiele_null'] = 'Beispiele Nullartikel';
$string['satzart'] = 'Satzart';
$string['komfun'] = 'Kommunikative Funktion';
$string['person'] = 'Person';
$string['nichtperson'] = 'Nicht-Person';
$string['satztr'] = 'Satzstruktur';
$string['subjunktor'] = 'Subjunktor';
$string['subjekt'] = 'Subjekt';
//abreviaturas con una s (de small) delante
$string['snominativo'] = 'N';
$string['sacusativo'] = 'A';
$string['sdativo'] = 'D';
$string['sgenitivo'] = 'G';
//personas
$string['S1'] = 'ich';
$string['S2'] = 'du';
$string['S3'] = 'er/sie/es';
$string['P1'] = 'wir';
$string['P2'] = 'ihr';
$string['P3'] = 'sie/Sie';
$string['sie'] = 'Sie';
//seguimos con mas cosas
$string['beachten'] = 'Beachten';
$string['participio1'] = 'Regeln zur Bildung des Partizip I';
$string['participio2'] = 'Regeln zur Bildung des Partizip II';
$string['futuro1'] = 'Regeln zur Bildung des Futur I';
$string['futuro2'] = 'Regeln zur Bildung des Futur II';
$string['hilfsverbs'] = 'Regeln zum Gebrauch des Hilfsverbs';
$string['trennbaren'] = 'Regeln zur Bildung der trennbaren Verben';
$string['zustandspassiv'] = 'Zustandspassiv (sein-Passiv)';
$string['vorganspassiv'] = 'Vorganspassiv (werden-Passiv)';
$string['sein'] = 'Sein';
$string['andere'] = 'Andere Verben';
$string['lista'] = 'Liste der Artikelwörter';
$string['scheinbare'] = 'Scheinbare Artikelwörter';
$string['temporal'] = 'Temporal';
$string['causal'] = 'Kausal';
$string['modal'] = 'Modal';
$string['local'] = 'Lokal';
$string['func'] = 'Funktion';
$string['siehe'] = 'Siehe auch';
$string['satzstruktur'] = 'SATZSTRUKTUR';
$string['vorfeld'] = 'Vorfeld';
$string['konjugier'] = 'Konjugiertes Verb';
$string['mittelfeld'] = 'Mittelfeld';
$string['mittel'] = 'Mittel';
$string['wortklase'] = 'Wortklase';
$string['verb2'] = 'Verb 2';
$string['verb1'] = 'Verb 1';
$string['miraren'] = 'Siehe auch';
$string['schwache'] = 'Schwache Verben';
$string['schwache_siehe'] = 'Schwache Verben (siehe auch 3.2.2 Präteritum)';
$string['starke'] = 'Starke Verben';
$string['gemischte'] = 'Gemischte Verben';
$string['possessiv1'] = 'Possessivpronomina ohne Deklination';
$string['possessiv2'] = 'Possessivartikel ohne Deklination';
$string['gebrauch'] = 'Gebrauch';
$string['reflexivo'] = 'Reflexivpronomen';
$string['positivo'] = 'Positiv';
$string['comparativo'] = 'Komparativ';
$string['superlativo'] = 'Superlativ';
$string['despuesde'] = 'Steht nach';
$string['endungen_siehe1'] = 'Endungen siehe auch 4.2 Indefinitartikel auβer Pluralformen';
$string['endungen_siehe2'] = 'Endungen siehe auch 4.1 Definitartikel + vorangestelltem e';
$string['endungen_siehe3'] = 'Endungen siehe auch 4.1 Definitartikel + vorangestelltem e, sowie 4.5 Interrogativartikel';
$string['endungen_siehe4'] = 'Endungen siehe auch 4.2 Indefinitartikel auβer Pluralformen, sowie 4.4 Negationsartikel';
$string['praposit'] = 'Präposition';
$string['beisp'] = 'Beispiel';
$string['kas'] = 'Kasus';
?>
