<?php
/**
 * Created by PhpStorm.
 * User: Personne
 * Date: 18/07/2015
 * Time: 20:32
 */

?>
<div id="container-artist" class="container-artist container-artist-big">
    <div class="container-informations-artist">
        <div class="container-image-artist">
            <div class="border-cover-album box-border-white"></div>
            <div class="image-artist" style="background-image: url('<?= $Artist->url_image;?>');"></div>
        </div>
        <div class="container-informations">
            <span class="information-artist name-artist"><?= $Artist->name;?></span>
            <span class="information-artist information-artist-part nb-quotes">
                <span class="information-title">Citations</span>
                <span class="information-content">2,304</span>
            </span>
            <span class="information-artist information-artist-part nb-quotes">
                <span class="information-title">Fans</span>
                <span class="information-content">13,290,304</span>
            </span>
        </div>
        <div class="image-artist" style="background-image: url('<?= $Artist->url_image;?>');"></div>
        <div class="gradient-image-artist"></div>
    </div>
</div>