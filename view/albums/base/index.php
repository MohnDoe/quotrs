<?php
/**
 * Created by PhpStorm.
 * User: Personne
 * Date: 18/07/2015
 * Time: 20:32
 */

    if($Album->is_valid){
        $app->render('albums/container/container-album.php',
                     array(
                         'Album' => $Album,
                         'mode' => 'big'
                     ));
    }
?>