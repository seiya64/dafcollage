<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of YoutubeVideoHelper
 *
 * @author finamolina
 */
class YoutubeVideoHelper {

    static public function getVideoId($url) {

        $sujeto = $url;
        echo $url;
        $patron = '/v=((\w|-|_)*)/';
        preg_match($patron, $sujeto, $coincidencias);
        print_r($coincidencias);
        $idVideo = $coincidencias[1];

        return $idVideo;
    }

    static public function generarVideoUrl($id) {

        $url = 'http://www.youtube.com/watch?v=' . $id;
        return $url;
    }

}

?>
