<?php

$nombre=$_GET['nombre'];

echo "procesandoooo".$nombre;

    $destino = "./imagenes/actividades/";
    if(isset($_FILES['image'])){

        $temp   = $_FILES['image']['tmp_name'];

        // subir imagen al servidor
        if(move_uploaded_file($temp, $destino.$nombre))
        {
            //$query = mysql_query("INSERT INTO fotos VALUES('','".$nombre."')" ,$cn);
        }

       
    }


?>
