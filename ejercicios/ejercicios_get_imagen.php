<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once("../../config.php");
global $CFG;
$path = $CFG->dataroot.'/temp/'.$_GET['name']; // upload directory
$fp = fopen($name, 'rb');

header("Content-Type: image/png");
readfile($path);
exit;

?>