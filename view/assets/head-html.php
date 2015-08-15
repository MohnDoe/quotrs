<?php
/**
 * Created by PhpStorm.
 * User: Personne
 * Date: 23/06/2015
 * Time: 19:33
 */
?>
<!DOCTYPE html>
<html lang="fr" ng-app="appQuotrs">
    <head>
        <meta charset = "UTF-8">
        <base href = "<?= URL_BASE_HREF; ?>" />
        <title><?= $title; ?></title>
        <link href="./stylesheets/angucomplete-alt.css" media="screen, projection" rel="stylesheet" type="text/css" />
        <link href="./stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
        <link href="./stylesheets/print.css" media="print" rel="stylesheet" type="text/css" />
        <!--[if IE]>
        <link href="./stylesheets/ie.css" media="screen, projection" rel="stylesheet" type="text/css" />
        <![endif]-->
        <?php if($twitter_card != null):?>
            <meta name="twitter:card" content="<?= $twitter_card['card'];?>">
            <meta name="twitter:site" content="@quotrsHQ">
            <meta name="twitter:creator" content="@quotrsHQ">
            <meta name="twitter:title" content="<?= $title;?>">
            <meta name="twitter:description" content="<?= $description;?>">
            <meta name="twitter:image" content="<?= $twitter_card['image'];?>">
        <?php endif;?>
