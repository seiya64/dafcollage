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
  GNU General Public License for more details. */


//lo que aqui aparece en aleman es porque tiene que ser asi
//traducir esas partes al idioma que se quiere enseñar para que sirva para cualquiera
$string['pluginname'] = 'Vocabulaire';
$string['pluginadministration'] = 'Vocabulaire Admin';
$string['vocabulario:addinstance'] = 'Add a new Module Vocabulary';
$string['vocabulario'] = 'vocabulaire';
$string['vocabulario_may'] = 'VOCABULAIRE';
$string['impr_vocab_corto'] = 'Carte d`apprentissage';
$string['impr_vocab'] = 'Vocabulaire';
$string['impr_gram'] = 'Grammaire';
$string['impr_tipol'] = 'Typologies textuelles';
$string['impr_inten'] = 'Intentions de communication';
$string['impr_estra'] = 'Stratégies pour l’apprentissage';
$string['add_gram'] = 'Grammatical';
$string['modulenameplural'] = 'vocabulaires';
$string['modulename'] = 'vocabulaire';
$string['modulename_help'] = 'Use the vocabulario module for... | The vocabulario module allows...';
$string['buttonlabel'] = 'Sauvegarder';
$string['seleccionar'] = 'Sélectionner';
$string['campo_lex'] = 'Domaines du sujet';
$string['colaboradores'] = 'Collaborateurs';
$string['pal_campo_lex'] = 'Mots rangés selon les domaines du sujet';
$string['campo_gram'] = 'Aspect spécifique grammatical'; //$string['campo_gram'] = 'Grammaire';
$string['gramatica_may'] = 'GRAMMAIRE';
$string['tipologias_may'] = 'TYPOLOGIES TEXTUELLES';
$string['estrategias_may'] = 'STRATÉGIES POUR L’APPRENTISSAGE';
$string['intenciones_may'] = ' INTENTIONS DE COMMUNICATION';
$string['campo_intencion'] = 'Intention communicative spécifique'; //$string['campo_intencion'] = 'Intention de communication';
$string['campo_intencion_nuevo'] = 'Nom de la nouvelle intention de communication';
$string['campo_gramatica_nueva'] = 'Nom du nouveau point grammatical';
$string['campo_lexico_nuevo'] = 'Nom du nouveau domaine du sujet';
$string['campo_tipologia'] = 'Type de texte spécifique'; //$string['campo_tipologia'] = 'Typologie textuelle';
$string['campo_tipologia_nuevo'] = 'Nom du nouveau type textuel';
$string['campo_estrategia_nuevo'] = 'Nom de la nouvelle activité';
$string['campo_estrategia'] = 'Sélectionner l’activité';
$string['miestrategia'] = 'Stratégie pour l’apprentissage';
$string['ejem'] = 'Exemple';
$string['pal'] = 'Mot';
$string['Tpal'] = 'Signification/Collocation';
$string['gen'] = 'Genre';
$string['masc'] = 'Masculin';
$string['fem'] = 'Féminin';
$string['neu'] = 'Neutre';
$string['masc_corto'] = 'M';
$string['fem_corto'] = 'F';
$string['neu_corto'] = 'N';
$string['plural'] = 'Pluriel';
$string['sing'] = 'Singulier';
$string['sust'] = 'Substantif';
$string['adj'] = 'Adjectif';
$string['vrb'] = 'Verbe';
$string['otr'] = 'D’autres mots';
$string['comen'] = 'Remarques';
$string['per3'] = 'Troisième personne du singulier';
$string['perAv3'] = '3ème Pers. sing.';           //Esto tiene que ser la abreviatura de la anterior
$string['infi'] = 'Infinitif';
$string['pret'] = 'Passé';
$string['part'] = 'Participe';
$string['pretAv'] = 'Pas.';            //Abreviación de la palabra Pretérito
$string['partAv'] = 'Part.';            //Abreviación de la palabra Participio
$string['sindec'] = 'Sans déclinaison';
$string['otr_sus'] = 'Autre';
$string['desc'] = 'Description';
$string['opciones'] = 'Options';
$string['advrb'] = 'Ajouter un verbe';
$string['adadj'] = 'Ajouter un adjectif';
$string['adotr'] = 'Ajouter une autre';
$string['adgr'] = 'Ajouter une description';
$string['error_sus'] = 'Il n’y a aucun mot à sauvegarder';
$string['ver'] = 'Mes Mots';
$string['add_palabra'] = 'Nouveau mot';
$string['buscar'] = 'Rechercher';
$string['verintenciones'] = 'Chercher pour intentions de communication';
$string['buscintenciones']='Ressource: ';
$string['botbuscintenciones']='Rechercher';
$string['guardar'] = 'Mes mots';
$string['modificar'] = 'Modifier';
$string['eliminar'] = 'Supprimer';
$string['anadir'] = 'Ajouter';
$string['anadirNuevo'] = 'Ajouter Nouveau';
$string['atras'] = 'Aller en arrière';
$string['id'] = 'Nom d’utilisateur';
$string['todo'] = 'Lien avec d\'autres domaines'; //$string['todo'] = 'Tous les mots';
$string['alfabetico'] = 'Classement alphabétique'; //$string['alfabetico'] = 'Mots suivant l’ordre alphabétique';
$string['nube'] = 'Combinaison avec d\'autres termes (interactive)'; //$string['nube'] = 'Tableau intéractif';
$string['pdf'] = 'Copie pdf';
$string['revert'] = 'Effacer';
$string['vease_pdf'] = '*Remarques';
$string['anotar'] = 'Vérifier et compléter';
$string['busc'] = 'Chercher et organiser';
$string['buscintenciones']='Ressource: ';
$string['nuevos'] = 'Créer de nouveaux domaines';
//$string['admin_cl'] = 'Nouveau domaine léxique';
//$string['admin_cl'] = 'Nouveau domaine du sujet';
$string['admin_cl'] = 'Lexique';
$string['admin_gr'] = 'Ma grammaire';
$string['admin_ic'] = 'Mes intentions de communication';
$string['nueva_ic'] = 'Intention de communication';
$string['nueva_tt'] = 'Typologie textuelle';
$string['nueva_ea'] = 'Stratégie pour l’apprentissage';
$string['admin_tt'] = 'Mes typologies textuelles';
$string['admin_ea'] = 'Mes stratégies pour l’apprentissage';
$string['seccion'] = 'Section';
$string['nivel'] = 'Sélectionner un domaine: ';
$string['nivel_estrategia'] = 'Effacer une activité: ';
$string['alumnos'] = 'Élèves du cours';
$string['pal_gr'] = 'Mots liés à ce point grammatical';
$string['pal_ic'] = 'Mots liés à cette intention de communication';
$string['pal_tt'] = 'Mots liés à cette typologie textuelle';
$string['especificar_gr'] = 'Préciser la grammaire';
$string['especificar_inten'] = 'Préciser l’intention de communication';
$string['especificar_tipo'] = 'Préciser la typologie textuelle';
$string['referencias'] = 'Références';
$string['ref'] = 'Réf.';          //Abreviatura de la palabra Referencia
$string['diccionario'] = 'Dictionnaire';
$string['emisor'] = 'Émetteur';
$string['ref_em'] = 'Référence à l’émetteur';
$string['ex_em'] = 'Exclusion de l’émetteur';
$string['ref_des'] = 'Réference au destinataire';
$string['ex_des'] = 'Exclusion du destinataire';
$string['elem'] = 'Notifier un élément du discours';
$string['resu'] = 'Notifier le résumé du discours';
$string['verdesc'] = 'Voir patron';
$string['guardesc'] = 'Sauvegarder les modifications';
$string['ayuda'] = 'Aide';
$string['cancel'] = 'Menu principal';
$string['mascampos'] = 'D’autres domaines';
$string['listado'] = 'Menus déroulant: Afficher la liste';
//preguntas tipologías textuales
$string['quien'] = 'Qui est-ce qu’est l’émmeteur?';
$string['finalidad'] = 'Dans quel but?';
$string['a_quien'] = 'À qui est-ce que cela est dirigé?';
$string['medio'] = 'À travers quel moyen?';
$string['donde'] = 'Où?';
$string['cuando'] = 'Quand?';
$string['motivo'] = 'Pourquoi?';
$string['funcion'] = 'Avec quelle fonction?';
$string['sobre_que'] = 'Sur quoi?';
$string['que'] = 'Quoi?';
$string['orden'] = 'Dans quel ordre?';
$string['medios_nonverbales'] = 'À travers quel moyens non verbaux?';
$string['que_palabras'] = 'À travers quels mots?';
$string['que_frases'] = 'À travers quelles phrases?';
$string['que_tono'] = 'Dans quel registre?';
$string['mastablas'] = 'Ajouter une nouvelle table';
$string['masfilas'] = 'Ajouter un nouveau rang';
$string['muestra_tabla'] = 'Modifier la table';
$string['nopermisos'] = 'Vous n’avez pas le droit';
$string['imprcuaderno'] = 'Copie PDF//Exportar cuaderno en PDF';
$string['imprimir'] = 'Imprimer';
$string['cuad_digital_min'] = 'Cahier numérique Cuaderno digital';
$string['cuad_digital_may'] = 'CAHIER NUMÉRIQUE CUADERNO DIGITAL';
//descripciones de las intenciones
$string['desc_inten3.2'] = 'Contrairement à la condition réalisable, la condition suposée ne fait pas référence au fait réel mais bien à l’éventuelle situation contraire.';
$string['desc_inten3.3'] = 'Il s’agit d’une condition non réalisable car elle fait référence au passé.';
$string['desc_inten4.1'] = 'Il s’agit d’une action effectuée par un être humain / une institution dans le but d’atteindre un objectif. ';
$string['desc_inten4.2'] = 'Il s’agit des ressources / instruments utilisés dans un but concret.';
$string['desc_inten5.1'] = 'Il s’agit d’une conséquence attendue et qui finalement a eu lieu.';
$string['desc_inten5.2'] = 'Il s’agit d’une conséquence attendue et qui finalement n’a pas eu lieu.';
// instrucciones de uso de la Tabla Interactiva(nube)
$string['instr_nube1'] = 'Veuillez cliquer sur un mot pour connaître ses relations. Vous pouvez également le chercher en l’écrivant sur "Search"';
$string['instr_nube2'] = 'Pour que tous les mots soient montrés à nouveau, veuillez effacer ce que vous avez écrit sur "Search"';

///////////////////////////////////////////////////////////
//a partir de aquí cosas en alemán que NO SE DEBEN TRADUCIR
///////////////////////////////////////////////////////////

$string['definido'] = 'Definitiv';
$string['indefinido'] = 'Indefinitiv';
$string['generales'] = 'Allgemeines';
$string['particulares'] = 'Lerntipps';
$string['particular'] = 'Lerntipp';
$string['declinacion1'] = 'Deklination Typ 1';
$string['declinacion2'] = 'Deklination Typ 2';
$string['declinacion3'] = 'Deklination Typ 3';
$string['declinacion4'] = 'Deklinationsendungen';
$string['declinacion_siehe'] = 'Deklinationsendungen (siehe auch 2.4 Indefinitpronomen)';
$string['masculino'] = 'Maskulin';
$string['neutro'] = 'Neutrum';
$string['femenino'] = 'Feminin';
$string['pluralAl'] = 'Plural';
$string['singAl'] = 'Singular';
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
//seguimos con más cosas
$string['beachten'] = 'Beachten';
$string['atencion_may'] = 'BEACHTEN!!';
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
$string['siehe'] = 'Voir Aussi';
$string['satzstruktur'] = 'SATZSTRUKTUR';
$string['vorfeld'] = 'Vorfeld';
$string['konjugier'] = 'Konjugiertes Verb';
$string['konjugier_resumen'] = 'Konj. Verb';
$string['mittelfeld'] = 'Mittelfeld';
$string['mittel'] = 'Ressource';
$string['wortklase'] = 'Description Théorique';
$string['verb2'] = 'Verb 2';
$string['verb1'] = 'Verb 1';
$string['miraren'] = 'Voir Aussi';
$string['schwache'] = 'Schwache Verben';
$string['schwache_siehe'] = 'Schwache Verben (siehe auch 3.2.2 PrÃ¤teritum)';
$string['starke'] = 'Starke Verben';
$string['gemischte'] = 'Gemischte Verben';
$string['possessiv1'] = 'Possessivpronomina ohne Deklination';
$string['possessiv2'] = 'Possessivartikel ohne Deklination';
$string['irregulares'] = 'Unregelmäβige Verben';
$string['gebrauch'] = 'Gebrauch';
$string['reflexivo'] = 'Reflexivpronomen';
$string['positivo'] = 'Positiv';
$string['infinitivo'] = 'Infinitiv';
$string['comparativo'] = 'Komparativ';
$string['superlativo'] = 'Superlativ';
$string['despuesde'] = 'Steht nach';
$string['endungen_siehe1'] = 'Endungen siehe auch 4.2 Indefinitartikel auβer Pluralformen';
$string['endungen_siehe2'] = 'Endungen siehe auch 4.1 Definitartikel + vorangestelltem e';
$string['endungen_siehe3'] = 'Endungen siehe auch 4.1 Definitartikel + teilweise vorangestelltem e, sowie 4.5 Interrogativartikel';
$string['endungen_siehe4'] = 'Endungen siehe auch 4.2 Indefinitartikel auβer Pluralformen, sowie 4.4 Negationsartikel';
$string['praposit'] = 'Präposition';
$string['beisp'] = 'Exemple';
$string['par_schwac'] = '(= Regelmäβige Verben)';
$string['par_star'] = '(= Verben mit bestimmten gemeinsamen Unregelmäβigkeiten)';
$string['par_gemis'] = '(= Unregelmäβige Verben)';
$string['kas'] = 'Kasus';
$string['preposiciones'] = 'Präpositionen';
$string['prafix'] = 'Präfix';
$string['suffix'] = 'Suffix';
$string['bedeutung'] = 'Bedeutung';

// Añadido Javier Castro, cuaderno digital, intenciones comunicativas
$string['ic_categoria'] = 'par Catégorie';
$string['ic_recurso'] = 'par Ressource';
$string['intencioncomunicativa']='Intention de communication';
// Añadido Borja Arroba, cuaderno digital, intenciones comunicativas
$string['titlesignificado']='Signification sans contexte';
$string['titlecolocacion']='Significaction en contexte';
$string['sin_genero']='sans genre';

// Añadido Ramón Rueda y Luis Redondo, cuaderno digital, nueva palabra
$string['ayuda_sus']='En caso de no introducir un sustantivo, introduzca un guión.
    Si la palabra no tuviera equivalencia directa en la lengua materna '
   .'(como en el caso de las colocaciones o expresiones complejas) se escribe el '
   .'significado completo sólo en uno de los posibles campos,introduciendo un guión en los demás.';
$string['ayuda_adj'] = 'Se recomienda usar el campo del ejemplo para que quede reflejado también '
   .'el uso del adjetivo/adverbio en la ficha de estudio.';
$string['ayuda_vrb'] = 'Si el verbo rige una determinada preposición, se recomienda'
.' usar el campo del ejemplo para que quede reflejado el uso de la preposición de forma contextualizada.';
$string['ayuda_otr'] = 'Campo para apuntar cualquier otra palabra relacionada con el sustantivo'
    .' y/o las demás  palabras. Se recomienda recurrir al ejemplo para que aparezca en la ficha de estudio.';

?>
