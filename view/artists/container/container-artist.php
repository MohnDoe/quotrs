<?php
/**
 * Created by PhpStorm.
 * User: Personne
 * Date: 19/07/2015
 * Time: 13:38
 */

?>

<div class="container-artist container-artist-<?= $mode;?>">
    <?php if($mode == 'info'):?>
        <h3 class="small-title">L'artist</h3>
    <?php endif;?>
    <div class="container-informations-artist">
        <div class="container-image-artist">
            <div class="border-cover-album box-border-white"></div>
            <div class="image-artist" style="background-image: url('<?= $Artist->url_image;?>');"></div>
        </div>
        <div class="container-informations">
            <span class="information-artist name-artist">
                <?php if($mode == 'info'):?>
                <a href = "<?= $app->urlFor ('artistUrl', ['idArtist' => $Artist->id]);?>">
                <?php endif;?>
                    <?= $Artist->name;?>
                <?php if($mode == 'info'):?>
                </a>
                <?php endif;?>
            </span>

            <span class="information-artist information-artist-part nb-quotes">
                <span class="information-title">Citations</span>
                <span class="information-content"><?= $Artist->getNbQuotes();?></span>
            </span>
            <span class="information-artist information-artist-part nb-fans">
                <span class="information-title">Fans</span>
                <span class="information-content">13,290,304</span>
            </span>
            <?php if($mode == 'big'):?>
            <span class="information-artist information-artist-part albums-artist">
                <span class="information-title">Albums</span>
                <span class="information-content">
                    <?php
                        $AlbumsArtist = $Artist->getAlbums();
                        foreach ($AlbumsArtist as $Album) {
                          if($Album->is_valid){
                              $app->render('albums/container/container-album.php',
                                           array(
                                               'Album' => $Album,
                                               'mode' => 'small'
                                           ));
                          }
                        }

                    ?>
                </span>
            </span>
            <?php endif;?>

        </div>
        <?php if($mode == 'info'):?>
        <div class="border-informations-artist box-border-white"></div>
        <?php endif;?>
        <div class="gradient-image-artist"></div>
        <div class="image-artist" style="background-image: url('<?= $Artist->url_image;?>');"></div>
    </div>
</div>