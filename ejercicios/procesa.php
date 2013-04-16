<?php
$fichero = @fopen("log_procesa.txt","w");
$log = "llega\n";
$nombre=$_GET['nombre'];

$log.= "Nombre: ".$nombre . "\n";

    $destino = "./imagenes/";
    $log.="Destino: " . $destino . $nombre . "\n";
    fwrite($fichero,$log,strlen($log)); $log="";
    if(isset($_FILES['image'])){
        $log.="Entra en el if\n";
        $temp   = $_FILES['image']['tmp_name'];
        $log.="tmp name: ".$temp."\n";
        fwrite($fichero,$log,strlen($log)); $log="";

        // subir imagen al servidor
        if(move_uploaded_file($temp, $destino.$nombre))
        {
            //$query = mysql_query("INSERT INTO fotos VALUES('','".$nombre."')" ,$cn);
            $log.="Lo mueve satisfactoriamente de " . $temp . " a " . $destino.$nombre . "\n";
        }
        else {
            $log.="Error moviendo archivo de " . $temp . " a " . $destino.$nombre . "\n";
        }

       
    }
    
    fwrite($fichero,$log,strlen($log));
    fclose($fichero);


?>
