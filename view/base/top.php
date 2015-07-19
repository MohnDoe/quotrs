<?php
/**
 * Created by PhpStorm.
 * User: Personne
 * Date: 18/07/2015
 * Time: 19:52
 */

?>

<div id="logo">
    <a href = "./">
        <img src = "./img/logo.png" alt = "Quotrs."/>
    </a>
</div>
<div id="links-top">
    <span class="link">
        <a href = "./login">
            Se connecter
        </a>
    </span>
    <span class="link link-primary">
        <a href = "<?= $app->urlFor ("createQuoteUrl"); ?>">
            Poster une citation
        </a>
    </span>
</div>