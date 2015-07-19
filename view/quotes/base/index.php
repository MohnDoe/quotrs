<?php
/**
 * Created by PhpStorm.
 * User: Personne
 * Date: 23/06/2015
 * Time: 19:47
 */
/*
<!--
<div class="container">
    <form action = "./api/quotes/create" ng-submit="create($event)" method="POST" ng-controller="formController">
        <div class="quote-part-form">
            <h3>La citation <span class="label label-success">+25</span></h3>
            <p>Chaque input représente une ligne.</p>
            <div class="form-group">
                <input type = "text" class="form-control" name="quote-line-1" ng-model="quote.content[0]" required placeholder="Ligne #1"/>
            </div>
            <div class = "form-group">
                <input type = "text" class="form-control" name="quote-line-2" ng-model="quote.content[1]" placeholder="Ligne #2" ng-disabled="quote.content[0] == '' || quote.content[0] === undefined"/>
            </div>
            <div class = "form-group">
                <input type = "text" class="form-control" name="quote-line-3" ng-model="quote.content[2]" placeholder="Ligne #3" ng-disabled="quote.content[1] == '' || quote.content[1] === undefined"/>
            </div>
            <div class = "form-group">
                <input type = "text" class="form-control" name="quote-line-4" ng-model="quote.content[3]" placeholder="Ligne #4" ng-disabled="quote.content[2] == '' || quote.content[2] === undefined"/>
            </div>
            <p>
              <small>Nb. mots : {{quote.words}}</small>
            </p>
        </div>
        <div class="song-part-form col-md-6">
            <h3>Le morceau <span class="label label-success">+20</span> <small><span class="label label-info" ng-show="quote.song.songIsNew">NEW</span></small></h3>
            <div class="form-group">
                <label for = "artist-name-song-quote">Artist</label>
                <div class="input-group">
                  <input type = "text"
                  required
                  typeahead-on-select='onSelectArtistSong($item, $model, $label)'
                  typeahead="artist.name for artist in getArtists($viewValue)"
                  aria-describedby ="addon-is-new-artist-song"
                  class="form-control"
                  name="artist-name-song-quote"
                  placeholder="Nom artist"
                  ng-model="quote.song.artist.name"/>
                  <span class="input-group-addon" id="addon-is-new-artist-song"><input type="checkbox" id="is-new-artist-song-quote" ng-model="quote.song.artist.artistIsNew" ng-checked="quote.song.artist.artistIsNew"> New</span>

                </div>
            </div>
            <div class="form-group">
                <label for = "title-song-quote">Titre</label>
                  <input type = "text"
                  required
                  typeahead-on-select='onSelectSong($item, $model, $label)'
                  typeahead="song.title for song in getSongs($viewValue)"
                  aria-describedby = "addon-is-new-song"
                  class="form-control"
                  name="title-song-quote"
                  placeholder="Titre du morceau"
                  ng-model="quote.song.title"/>
            </div>
            <div class="input-group">
                <span class="input-group-addon" id="addon-youtube">http://youtube.com/watch?v=</span>
                <input type="text"
                class="form-control"
                name="link-yt-song-quote"
                placeholder="Lien Youtube du morceau"
                aria-describedby="addon-youtube"
                ng-model="quote.song.url_youtube">

            </div>
        </div>
        <div class="album-part-form col-md-6">
            <h3>L'album <span class="label label-success">+15</span> <small><span class="label label-info" ng-show="quote.song.album.albumIsNew">NEW</span></small></h3>
            <div class="form-group">
                <label for = "album-name-song-quote">Titre album</label>
                <input id = "album-name-song-quote" class="form-control" type = "text" placeholder="Titre album" ng-model="quote.song.album.title" />
            </div>
            <div class="form-group">
                <label for = "artist-album-name-song-quote">Artiste album</label>
                <input type = "text"
                id="artist-album-name-song-quote"
                class="form-control"
                placeholder="Artist de l'album"
                typeahead-on-select='onSelectArtistAlbum($item, $model, $label)'
                typeahead="artist.name for artist in getArtists($viewValue)"
                ng-model="quote.song.album.artist.name"/>
            </div>
            <div class="row">
            <div class="col-xs-6 col-md-3">
              <a href="#" class="thumbnail">
                <img src="{{quote.song.album.url_cover}}" alt="...">
              </a>
            </div>
            <div class="col-xs-6 col-md-9">
              <div class="form-group">
                  <label for = "cover-album-song-quote">Cover de l'album</label>
                  <input id = "cover-album-song-quote" type = "file" />
                  <p class="help-block">Meilleure qualité possible bébé</p>
              </div>
            </div>
          </div>
        </div>
        <div class="submit-part-form col-md-12">
            <button class="btn btn-primary btn-lg btn-block">Envoyer la citation</button>
        </div>
    </form>
</div>
-->*/
?>

<?php if($mode == "create"):?>
<form action = "./api/quotes/create" ng-submit="createQuote($event)" method="POST" ng-controller="formQuoteController" class="form-create-quote">
<?php endif;?>
    <section id="container-quote" class="container-quote container-quote-<?= $mode; ?>">
            <div id="the-quote" class="the-quote">
            <span class="line-quote line-quote-<?= $mode; ?>"
                  contenteditable="<?= ($mode == "create" ? "true" : "false"); ?>"
                  ng-model="quote.content"
                  placeholder="Rédigez votre citation.."><?php
                    if($mode == "quote"){
                        echo str_replace("\\n", "<br/>", $Quote->content);
                    }
                ?></span>
            <div style="clear: both; display: table;"></div>
            <span class="author-quote author-quote-<?= $mode; ?>"
                 contenteditable="<?= ($mode == "create" ? "true" : "false"); ?>"
                 typeahead-on-select='onSelectArtistSong($item, $model, $label)'
                 typeahead="artist.name for artist in getArtists($viewValue)"
                 ng-model="quote.song.artist.name"
                 placeholder="— Nom de l'artiste..."><?php
                    if($mode == "quote"){
                        echo $Quote->Artist->name;
                    }
                ?></span>
                <div style="clear: both; display: table;"></div>
            </div>
        <?php if($mode == "create"):?>
        <div class="song-form-quote">
            <span class="info-text">Veuillez préciser le titre du morceau dans lequel cette citation apparaît.</span>
            <br />
            <input type = "text"
               required
               typeahead-on-select='onSelectSong($item, $model, $label)'
               typeahead="song.title for song in getSongs($viewValue)"
               name="title-song-quote"
               placeholder="Titre du morceau"
               ng-model="quote.song.title"/>
            <input type = "text"
                   name="youtube-song-quote"
                   placeholder="Lien YouTube"
                   ng-model="quote.song.url_youtube"/>
        </div>
        <input type = "button" class="btn btn-primary btn-submit btn-submit-quote" ng-click="createQuote($event)" value="Poster la citation" />
        <span class="info-text">Vous pourrez ajouter l'album ainsi que d'autres détails plus tard.</span>
        <?php endif;?>
        <div class="gradient-background-quote"></div>

        <?php
            if($mode == "quote"){
                $url_background_quote = $Quote->url_image;
            }else if($mode == "create"){
                $url_background_quote = "";
            }
        ?>
        <div class="background-quote" style="background-image: url('<?= $url_background_quote;?>')"></div>
    </section>
<?php if($mode == "create"):?>
</form>
<?php endif;?>
<section id="container-informations-quote" class="container-informations-quote">
    <div class="container-informations-quote-left">
        <?php if($mode == 'quote'):?>
        <div class="container-share-buttons-quote">
            <ul class="share-buttons">
                <li class="share-button share-facebook"></li>
                <li class="share-button share-twitter"></li>
                <li class="share-button share-link"></li>
            </ul>
        </div>
        <?php endif;?>

        <?php if($mode == 'quote'):?>
        <div class="section-comments">
            <h3 class="small-title">12 commentaires</h3>
            <div class="container-comments">
                <span class="load-more-comments">Afficher plus de commentaires (+90)</span>
                <div class="comment">
                    <div class="picture-user-comment">
                        <img src = "" alt = "" />
                    </div>
                    <div class="content-comment">
                        <div class="top-comment">
                            <span class="author-comment">John Doe</span>
                            <span class="date-comment">Hier</span>
                            <span class="comment">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam aspernatur deserunt eveniet laudantium molestiae neque quo ratione suscipit veritatis voluptatem? Distinctio eius ipsum praesentium repudiandae veniam! Harum id quis unde!</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif;?>

    </div>
    <div class="container-informations-quote-right">
        <?php if($mode == 'quote'):?>
            <?php if($Quote->Song->is_valid):?>

            <?php endif;?>
            <?php
                if($Quote->Artist->is_valid){
                    $app->render('artists/container/container-artist.php',
                                 array(
                                     'Artist' => $Quote->Artist,
                                     'mode' => 'info'
                                 ));
                }

                if($Quote->Song->Album->is_valid){
                    $app->render('albums/container/container-album.php',
                                 array(
                                     'Album' => $Quote->Song->Album,
                                     'mode' => 'info'
                                 ));
                }
            ?>
        <?php endif;?>
    </div>
</section>