<?php
/**
 * Created by PhpStorm.
 * User: Personne
 * Date: 18/07/2015
 * Time: 20:32
 */

    if($Artist->is_valid){
        $app->render('artists/container/container-artist.php',
                     array(
                         'Artist' => $Artist,
                         'mode' => 'big'
                     ));
    }
?>