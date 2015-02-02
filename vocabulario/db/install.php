<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This file replaces the legacy STATEMENTS section in db/install.xml,
 * lib.php/modulename_install() post installation hook and partially defaults.php
 *
 * @package    mod_vocabulario
 * @copyright  2011 Your Name <your@email.adress>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Post installation procedure
 *
 * @see upgrade_plugins_modules()
 */
defined('MOODLE_INTERNAL') || die;



function xmldb_vocabulario_install() {

        global $CFG, $OUTPUT, $DB;

        $filenames = array(
		'camposlexicos_de', 
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
		'gramatica'
		);

        foreach ($filenames as $filename) {
        
		$records = vocabulario_xml_to_array($filename);
		
		foreach ($records as $record) {
		        $DB->insert_record('vocabulario_'.$filename, $record);
		}
	}
}


function vocabulario_xml_to_array($xml_filename) {

        global $CFG, $OUTPUT, $DB;

        $registros = array();
    
        $data = file_get_contents($CFG->dirroot.'/mod/vocabulario/db/dataxmls/'. $xml_filename .'.xml');
     
        $xml = xmlize($data, 1, 'UTF-8'); 

	$records = $xml["table"]["#"]["record"];

	foreach ($records as $record) {
            $fields = $record['#'];
            $row = new stdClass();
            foreach ($fields as $fieldname => $fieldvalue) {
                $row->$fieldname = $fieldvalue[0]['#'];
            }
            $registros[] = $row;
        }   
        
        return $registros;
}





/**
 * Post installation recovery procedure
 *
 * @see upgrade_plugins_modules()
 */
function xmldb_vocabulario_install_recovery() {
}


  


