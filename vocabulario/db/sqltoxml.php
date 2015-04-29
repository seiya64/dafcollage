<?php
/**
 * SALIM TIEB: 
   Este script accede a moodle19 para obtener los datos ya probados, modificados para ser utilizado como datos xml para versión 2.x.
   Este xml se copiará en los respectivos fichero 'camposlexicos_es' en la carpeta /vocabulario/db/dataxmls si en la query se busca 
   en la tabla mysql 'mdl_vocabulario_camposlexicos_es'

Estas son las distintas tablas con sus respectivos idiomas:

SELECT usuarioid, padre, campo FROM mdl_vocabulario_camposlexicos_es
SELECT usuarioid, padre, intencion, ordenid FROM mdl_vocabulario_intenciones_es
SELECT usuarioid, padre, tipo FROM mdl_vocabulario_tipologias_es
 
*/

// Se conecta al SGBD 
  if(!($iden = mysql_connect("localhost", "ENTER LOGIN", "ENTER PASSWD"))) 
    die("Error: No se pudo conectar");
	
  // Selecciona la base de datos 
  if(!mysql_select_db("moodle19", $iden)) 
    die("Error: No existe la base de datos");
	
  // Sentencia SQL: muestra todo el contenido de la tabla "books" 
  $sentencia = "SELECT usuarioid, padre, gramatica FROM mdl_vocabulario_gramatica"; 
  // Ejecuta la sentencia SQL 
  $result = mysql_query($sentencia, $iden); 
  if(!$result) 
    die("Error: no se pudo realizar la consulta");
	


header("Content-Type: application/xml");
echo sqlToXml($result, "table", "record");

// Libera la memoria del resultado
mysql_free_result($resultado);
  
// Cierra la conexión con la base de datos 
mysql_close($iden);


/**
 * @param mysql_resource - $queryResult - mysql query result
 * @param string - $rootElementName - root element name
 * @param string - $childElementName - child element name
 */
function sqlToXml($queryResult, $rootElementName, $childElementName)
{ 
    $xmlData = "<?xml version=\"1.0\" encoding=\"iso-8859-1\" ?>\n"; 
    $xmlData .= "<" . $rootElementName . ">";
 
    while($record = mysql_fetch_object($queryResult))
    { 
        /* Create the first child element */
        $xmlData .= "<" . $childElementName . ">";
 
        for ($i = 0; $i < mysql_num_fields($queryResult); $i++)
        { 
            $fieldName = mysql_field_name($queryResult, $i); 
 
            /* The child will take the name of the table column */
            $xmlData .= "<" . $fieldName . ">";
 
            /* We set empty columns with NULL, or you could set 
                it to '0' or a blank. */
            if(!empty($record->$fieldName))
                $xmlData .= $record->$fieldName; 
            else
                $xmlData .= "null"; 
 
            $xmlData .= "</" . $fieldName . ">"; 
        } 
        $xmlData .= "</" . $childElementName . ">"; 
    } 
    $xmlData .= "</" . $rootElementName . ">"; 
 
    return $xmlData; 
}

 

?>
