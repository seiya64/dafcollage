<?php
  


    global $CFG, $OUTPUT, $DB;
    $registros = array();
    // Your add data code here.
        $data = file_get_contents('camposlexicos_es.xml');
     
        $xml = xmlize($data); # where $data is the xml in the above section.

	$records = $xml["table"]["#"]["record"];
      
        foreach ($records as $record) {
            $fields = $record['#'];
            $row = new stdClass();
            foreach ($fields as $fieldname => $fieldvalue) {
                $row->$fieldname = $fieldvalue[0]['#'];
            }
            $registros[] = $row;
        }
var_dump($registros);

	/*for($i = 0; $i < sizeof($records); $i++) {
		$record = $records[$i];

                $row = new stdClass();
		$row->usuariod 	= $record["#"]["usuarioid"][0]["#"];
		$row->campo	= $record["#"]["campo"][0]["#"];
		$row->padre	= $record["#"]["padre"][0]["#"];		
                $registros[] = $row;              
	}
        var_dump($registros);

         */

foreach ($fields as $fieldname => $fieldvalue) {
                $row->$fieldname = $fieldvalue[0]['#'];
            }
       
     


    
/**
 * Converts XML text into an array of stdclass objects.
 *
 * @param type $text - xmltext
 * @param type $elementnames - plural name of elements
 * @param type $elementname - name of element
 * @return array|boolean - array of record objects
 */
function parse_xml($text, $elementnames, $elementname) {
    // Seems that xmlize needs a lot of memory.
    ini_set('memory_limit', '256M');

    // Ensure content is UTF-8.
    $content = xmlize($text, 1, 'UTF-8');

    $records = array();
    if (!empty($content[$elementnames]['#'][$elementname])) {
        $rows = $content[$elementnames]['#'][$elementname];
        foreach ($rows as $row) {
            $fields = $row['#'];
            $row = new stdClass();
            foreach ($fields as $fieldname => $fieldvalue) {
                $row->$fieldname = $fieldvalue[0]['#'];
            }
            $records[] = $row;
        }
        return $records;
    }

    return false;
}





/* xmlize() is by Hans Anderson, www.hansanderson.com/contact/
 *
 * Ye Ole "Feel Free To Use it However" License [PHP, BSD, GPL].
 * some code in xml_depth is based on code written by other PHPers
 * as well as one Perl script.  Poor programming practice and organization
 * on my part is to blame for the credit these people aren't receiving.
 * None of the code was copyrighted, though.
 *
 * This is a stable release, 1.0.  I don't foresee any changes, but you
 * might check http://www.hansanderson.com/php/xml/ to see
 *
 * usage: $xml = xmlize($xml_data);
 *
 * See the function traverse_xmlize() for information about the
 * structure of the array, it's much easier to explain by showing you.
 * Be aware that the array is very complex.  I use xmlize all the time,
 * but still need to use traverse_xmlize or print_r() quite often to
 * show me the structure!
 *
 */

function xmlize($data, $WHITE=1) {

    $data = trim($data);
    $vals = $index = $array = array();
    $parser = xml_parser_create();
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, $WHITE);
    if ( !xml_parse_into_struct($parser, $data, $vals, $index) )
    {
	die(sprintf("XML error: %s at line %d",
                    xml_error_string(xml_get_error_code($parser)),
                    xml_get_current_line_number($parser)));

    }
    xml_parser_free($parser);

    $i = 0; 

    $tagname = $vals[$i]['tag'];
    if ( isset ($vals[$i]['attributes'] ) )
    {
        $array[$tagname]['@'] = $vals[$i]['attributes'];
    } else {
        $array[$tagname]['@'] = array();
    }

    $array[$tagname]["#"] = xml_depth($vals, $i);

    return $array;
}

/* 
 *
 * You don't need to do anything with this function, it's called by
 * xmlize.  It's a recursive function, calling itself as it goes deeper
 * into the xml levels.  If you make any improvements, please let me know.
 *
 *
 */

function xml_depth($vals, &$i) { 
    $children = array(); 

    if ( isset($vals[$i]['value']) )
    {
        array_push($children, $vals[$i]['value']);
    }

    while (++$i < count($vals)) { 

        switch ($vals[$i]['type']) { 

           case 'open': 

                if ( isset ( $vals[$i]['tag'] ) )
                {
                    $tagname = $vals[$i]['tag'];
                } else {
                    $tagname = '';
                }

                if ( isset ( $children[$tagname] ) )
                {
                    $size = sizeof($children[$tagname]);
                } else {
                    $size = 0;
                }

                if ( isset ( $vals[$i]['attributes'] ) ) {
                    $children[$tagname][$size]['@'] = $vals[$i]["attributes"];
                }

                $children[$tagname][$size]['#'] = xml_depth($vals, $i);

            break; 


            case 'cdata':
                array_push($children, $vals[$i]['value']); 
            break; 

            case 'complete': 
                $tagname = $vals[$i]['tag'];

                if( isset ($children[$tagname]) )
                {
                    $size = sizeof($children[$tagname]);
                } else {
                    $size = 0;
                }

                if( isset ( $vals[$i]['value'] ) )
                {
                    $children[$tagname][$size]["#"] = $vals[$i]['value'];
                } else {
                    $children[$tagname][$size]["#"] = '';
                }

                if ( isset ($vals[$i]['attributes']) ) {
                    $children[$tagname][$size]['@']
                                             = $vals[$i]['attributes'];
                }			

            break; 

            case 'close':
                return $children; 
            break;
        } 

    } 

	return $children;

}


/* function by acebone@f2s.com, a HUGE help!
 *
 * this helps you understand the structure of the array xmlize() outputs
 *
 * usage:
 * traverse_xmlize($xml, 'xml_');
 * print '<pre>' . implode("", $traverse_array . '</pre>';
 *
 *
 */ 

function traverse_xmlize($array, $arrName = "array", $level = 0) {

    foreach($array as $key=>$val)
    {
        if ( is_array($val) )
        {
            traverse_xmlize($val, $arrName . "[" . $key . "]", $level + 1);
        } else {
            $GLOBALS['traverse_array'][] = '$' . $arrName . '[' . $key . '] = "' . $val . "\"\n";
        }
    }

    return 1;

}

   
