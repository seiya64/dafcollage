<?php

header('Content-Type: text/html; charset=utf-8');
require_once("../../config.php");
require_once("$CFG->libdir/form/select.php");
require_once("lib.php");
require_once("vocabulario_classes.php");

$id = $_GET["id"];
$nombre = $_GET["nombre"];

$icaux = new Vocabulario_intenciones();
//$icaux->test();

//$icaux = $icaux->obtener_todos($USER->id);52
$icaux =  $icaux->obtener_orden($USER->id, 68);
//$icaux = $icaux->obtener_todos_numerados($USER->id);
//$icaux = $icaux->obtener_todos_subnumerados($USER->id, 2, "1");
//$icaux = $icaux->obtener_padres(68);
echo " </br>milista </br>"; var_dump($icaux);
if (count($icaux) > 1) {
    echo '<div class="fitemtitle"></div>';
    echo '<div class="felement fselect">';
    $elselect = new MoodleQuickForm_select($nombre, 'Subcampo', $icaux, "id=\"id_campoid" . $id . "\" onChange='javascript:cargaContenido(this.id,\"" . $nombre . "icgeneraldinamico" . $id . "\",2)'");
    echo $elselect->toHtml();
    echo '</div>';
    echo "<div class=\"fitem\" id=\"" . $nombre . "icgeneraldinamico" . $id . "\" style=\"min-height: 0;\"></div>";
}
?>
