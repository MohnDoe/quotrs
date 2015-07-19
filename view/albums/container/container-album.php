<?php
/**
 * Created by PhpStorm.
 * User: Personne
 * Date: 19/07/2015
 * Time: 14:34
 */

?>
<div class="container-album container-album-<?= $mode; ?>">
    <?php if($mode == 'info'):?>
    <h3 class="small-title">L'album</h3>
    <?php endif;?>
    <div class="container-cover-album">
        <div class="container-informations-album">
            <span class="title-album">
                <?php if($mode == 'info' || $mode == 'small'):?>
                <a href = "<?= $app->urlFor ('albumUrl', ['idAlbum' => $Album->id]);?>">
                <?php endif;?>
                    <?= $Album->title;?>
                <?php if($mode == 'info'):?>
                </a>
                <?php endif;?>
            </span>
            <?php if($mode == 'info'):?>
            <span class="artist-album"><?= $Artist->name;?></span>
            <?php endif;?>
            <span class="release-album"><?= $Album->date;?></span>
        </div>
        <div class="gradient-cover-album"></div>
        <div class="border-cover-album box-border-white"></div>
        <div class="cover-album" style="background-image: url('<?= $Album->url_cover;?>');"></div>
    </div>
</div>