<?php
/**
 * Created by PhpStorm.
 * User: Personne
 * Date: 20/06/2015
 * Time: 16:13
 */

    // require autoload / composer
    require 'vendor/autoload.php';

    // test HashID
    $hashids = new Hashids\Hashids('SuperSaltQuotrs.LOL', 7);
    $id = $hashids->encode(1);
    echo $id;