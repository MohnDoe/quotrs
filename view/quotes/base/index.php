<?php
    /**
     * Created by PhpStorm.
     * User: Personne
     * Date: 23/06/2015
     * Time: 19:47
     */
?>

<?php if ($mode == "create"): ?>
<form action = "./api/quotes/create" ng-submit = "createQuote($event)" method = "POST"
      ng-controller = "formQuoteController" class = "form-create-quote">
    <?php endif; ?>
    <section id = "container-quote" class = "container-quote container-quote-<?= $mode; ?>">
        <div id = "the-quote" class = "the-quote">
            <span class = "line-quote line-quote-<?= $mode; ?>"
                  contenteditable = "<?= ($mode == "create" ? "true" : "false"); ?>"
                  ng-model = "quote.content"
                  placeholder = "Rédigez votre citation.."
                    ng-keyup="updateRelatedSongs(quote.content)" ><?php
                    if ($mode == "quote") {
                        echo str_replace ("\\n", "<br/>", $Quote->content);
                    }
                ?></span>

            <div style = "clear: both; display: table;"></div>
            <?php if($mode == "quote"):?>
            <span class = "author-quote author-quote-<?= $mode; ?>"
                  ng-model = "quote.song.artist.name"><?= $Quote->Artist->name;?></span>
            <div style = "clear: both; display: table;"></div>
            <?php endif;?>
        </div>
        <?php if ($mode == "create"): ?>
            <div class = "related-songs-rg" ng-show="quote.related_songs_rg.length">
                <span class="title">Mmmhhh, peut être dans l'un de ces sons, non ?</span>
                <ul class = "related-songs">
                    <li class = "related-song"
                        ng-repeat = "song in quote.related_songs_rg | limitTo:5"
                        ng-click = "onSelectRelatedSong(song.result, $event)">
                            <span class = "title-song">
                            {{song.result.title}}
                            </span>
                            <span class = "artist-name">
                                {{song.result.primary_artist.name}}
                            </span>
                        <div class = "gradient-related-song"></div>
                        <div class = "border-related-song box-border-white"></div>
                        <div class = "background-related-song"
                             back-img="{{song.result.header_image_url}}"></div>
                    </li>
                </ul>
                <span class="title">Non ? Chercher le morceau associé</span>
                <input type="text" ng-model="quote.searchSongsInput" ng-keyup="updateRelatedSongs(quote.searchSongsInput)" placeholder="Titre du morceau"/>
            </div>
            <input type = "button" class = "btn btn-primary btn-submit btn-submit-quote"
                   ng-click = "createQuote($event)" value = "Poster la citation" ng-disabled="quote.content == '' || quote.song.id_rg == -1"/>

        <?php endif; ?>

        <?php if($mode == "quote" AND $Quote->Song->url_youtube != '' AND FALSE):?>
            <div class="container-youtube-player-quote">
                <iframe id="ytplayer" class="youtube-player-quote" type="text/html" width="100%" height="auto"
      src="http://www.youtube.com/embed/<?= $Quote->Song->url_youtube;?>?iv_load_policy=3&controls=0&autoplay=1&modestbranding=1&rel=0&origin=http://quotrs.com"
      frameborder="0"></iframe>
            </div>
        <?php endif;?>
        <div class = "gradient-background-quote" ng-show = "quote.url_background != ''"></div>

        <?php
            if ($mode == "quote") {
                $url_background_quote = $Quote->url_image;
            } else if ($mode == "create") {
                $url_background_quote = "";
            }
        ?>
        <div class = "background-quote"
            <?php if ($mode != "create"): ?>
                style = "background-image: url('<?= $url_background_quote; ?>')"
            <?php endif; ?>
            <?php if ($mode == "create"): ?>
                style = "background-image: url('{{quote.url_background}}')"
            <?php endif; ?>
            ></div>
    </section>
    <?php if ($mode == "create"): ?>
</form>
<?php endif; ?>
<?php if ($mode == 'quote'): ?>
    <section id = "container-informations-quote" class = "container-informations-quote">
        <div class = "container-informations-quote-left">
            <div class = "container-share-buttons-quote">
                <ul class = "share-buttons">
                    <li class = "share-button share-facebook"></li>
                    <li class = "share-button share-twitter"></li>
                    <li class = "share-button share-link"></li>
                </ul>
            </div>
            <div class="section-quote-song">
                <h3 class="small-title">Le morceau</h3>
                <?php if($Quote->Song->url_youtube != ''):?>
                <div class="container-quote-song">
                    <iframe id="ytplayer" class="youtube-player-quote" type="text/html" width="100%" height="auto"
      src="http://www.youtube.com/embed/<?= $Quote->Song->url_youtube;?>?iv_load_policy=3&controls=1&autoplay=0&modestbranding=1&rel=0&origin=http://quotrs.com"
      frameborder="0"></iframe>
                </div>
                <?php endif;?>
            </div>  
            <?php if(false):?>
            <div class = "section-comments">
                <h3 class = "small-title">12 commentaires</h3>

                <div class = "container-comments">
                    <span class = "load-more-comments">Afficher plus de commentaires (+90)</span>

                    <div class = "comment">
                        <div class = "picture-user-comment">
                            <img src = "" alt = "" />
                        </div>
                        <div class = "content-comment">
                            <div class = "top-comment">
                                <span class = "author-comment">John Doe</span>
                                <span class = "date-comment">Hier</span>
                                <span class = "comment">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam aspernatur deserunt eveniet laudantium molestiae neque quo ratione suscipit veritatis voluptatem? Distinctio eius ipsum praesentium repudiandae veniam! Harum id quis unde!</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif;?>
        </div>
        <div class = "container-informations-quote-right">
            <?php if ($Quote->Song->is_valid): ?>

            <?php endif; ?>
            <?php
                if ($Quote->Artist->is_valid) {
                    $app->render (
                        'artists/container/container-artist.php',
                        [
                            'Artist' => $Quote->Artist,
                            'mode'   => 'info'
                        ]);
                }

                if ($Quote->Song->Album->is_valid) {
                    $app->render (
                        'albums/container/container-album.php',
                        [
                            'Album' => $Quote->Song->Album,
                            'mode'  => 'info'
                        ]);
                }
            ?>
        </div>
    </section>
<?php endif; ?>
