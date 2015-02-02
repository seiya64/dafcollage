<?php

/* 
implode — Une elementos de un array en un string
 */

//ejemplo1
    $a1 = array("1","2","3");
    $a2 = array("a");
    $a3 = array();
   
    echo "a1 is: '".implode("','",$a1)."'<br/>";
    echo "a2 is: '".implode("','",$a2)."'<br/>";
    echo "a3 is: '".implode("','",$a3)."'<br/>";
    
  //ejemplo2  
    $elements = array('a', 'b', 'c');

    echo "<ul><li>" . implode("</li><li>", $elements) . "</li></ul>";
   
  //ejemplo3
    // array containing data
   $array = array(
      "name" => "John",
      "surname" => "Doe",
      "email" => "j.doe@intelligence.gov"
   );

   // build query...
   $sql  = "INSERT INTO table";

   
   //ejemplo4
   // implode keys of $array...
   $sql .= " (`".implode("`, `", array_keys($array))."`)";

   // implode values of $array...
   $sql .= " VALUES ('".implode("', '", $array)."') ";

   echo $sql . "<br/>";   
  
   
   //ejemplo5
   $id_nums = array(1,6,12,18,24);

   $id_nums = implode(", ", $id_nums);
               
   $sqlquery = "Select name,email,phone from usertable where user_id IN ($id_nums)"; 
   
   echo $sqlquery;


?>

