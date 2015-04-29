<?php

// nos conectamos a localhost
$enlace = mysql_connect('localhost', 'root',  'profesor21');
if (!$enlace) {
    die('No pudo conectarse: ' . mysql_error());
}

mysql_select_db("moodle19", $enlace);


echo "salim";


// Padres de nivel superior 
$padre= 0;


// Formular la consulta
$consulta_int = sprintf("SELECT id, intencion FROM mdl_vocabulario_intenciones_es
    WHERE padre=". $padre . " order by id");  

// Ejecutar la consulta
$resultado = mysql_query($consulta_int);

// Comprobar el resultado
if (!$resultado) {
    $mensaje  = 'Consulta no válida: ' . mysql_error() . "<br/>";
    $mensaje .= 'Consulta completa: ' . $consulta_int;
    die($mensaje);
}

//determina el número de subintenciones
$numero_int = mysql_num_rows($resultado);
//si no hay comentarios mostramos un texto:  
if ($numero_int==0){ 
    echo '<p>No hay intenciones</p>';  
}
else{ 
   $contador = 0;
    while ($fila = mysql_fetch_assoc($resultado)) {
            
            echo $contador . "." . "&nbsp;&nbsp;&nbsp;&nbsp;" .$fila['intencion'] . "<br/>";
            $contador++;
            $padre = $fila['id'];
            
            $consulta_sub_int = sprintf("SELECT id FROM mdl_vocabulario_intenciones_es
            WHERE padre=".$padre. " order by id");
            
            // Ejecutar la consulta
            $resultado_sub_int = mysql_query($consulta_sub_int);

            if (!$resultado_sub_int) {
                $mensaje  = 'Consulta no válida: ' . mysql_error() . "<br/>";
                $mensaje .= 'Consulta completa: ' . $consulta_sub_int;
                die($mensaje);
            }


            $numero_sub_int = mysql_num_rows($resultado_sub_int); 
            if ($numero_sub_int > 0){  
                mostrar_subintenciones($fila['id'], $contador-1);  
            } 
    }  
}  

// Liberar los recursos asociados con el conjunto de resultados
// Esto se ejecutado automáticamente al finalizar el script.
mysql_free_result($resultado);
mysql_free_result($resultado_sub_int);
mysql_close($enlace);

function mostrar_subintenciones($id_padre, $contador_padre)
{
    
    
    $consulta_int = sprintf("SELECT id, intencion FROM mdl_vocabulario_intenciones_es
    WHERE padre=". $id_padre . " order by id");  

    // Ejecutar la consulta
    $resultado = mysql_query($consulta_int);

    // Comprobar el resultado
    // Lo siguiente muestra la consulta real enviada a MySQL, y el error ocurrido. Útil para depuración.
    if (!$resultado) {
        $mensaje  = 'Consulta no válida: ' . mysql_error() . "<br/>";
        $mensaje .= 'Consulta completa: ' . $consulta_int;
        die($mensaje);
    }
    
    $contador=1;
   
    while ($fila = mysql_fetch_assoc($resultado)) {
                $contador_padre_padre = $contador_padre . "." . $contador;
                echo $contador_padre . "." . $contador . "." . "&nbsp;&nbsp;&nbsp;&nbsp;" . $fila['intencion'] . "<br/>";
                $contador++;
                $padre = $fila['id'];

                $consulta_sub_int = sprintf("SELECT id FROM mdl_vocabulario_intenciones_es
                WHERE padre=".$padre);

                // Ejecutar la consulta
                $resultado_sub_int = mysql_query($consulta_sub_int);

                if (!$resultado_sub_int) {
                    $mensaje  = 'Consulta no válida: ' . mysql_error() . "<br/>";
                    $mensaje .= 'Consulta completa: ' . $consulta_sub_int;
                    die($mensaje);
                }


                $numero_sub_int = mysql_num_rows($resultado_sub_int);
                //Llamada recursiva a la función para ver si hay sub-subintenciones.
                if ($numero_sub_int > 0){  
                    
                    mostrar_subintenciones($fila['id'], $contador_padre_padre);  
                } 
    }  
    
    mysql_free_result($resultado);
    mysql_free_result($resultado_sub_int);
          

}
