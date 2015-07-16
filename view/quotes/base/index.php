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

<section id="container-quote" class="container-quote">
    <div id="the-quote" class="the-quote">
        <span class="line-quote">Hello</span>
        <span class="line-quote">Hello</span>
        <div class="author-quote">Médine</div>
    </div>
    <div class="gradient-background-quote"></div>
    <div class="background-quote" style="background-image: url('<?= $Quote->url_image;?>')"></div>
</section>
<section id="container-informations-quote" class="container-informations-quote">
    <div class="container-informations-quote-left">
        <div class="container-share-buttons-quote">
            <ul class="share-buttons">
                <li class="share-button share-facebook"></li>
                <li class="share-button share-twitter"></li>
                <li class="share-button share-link"></li>
            </ul>
        </div>
        <div class="container-comments">

        </div>
    </div>
    <div class="container-informations-quote-right">
        <?php if($Quote->Song->is_valid):?>

        <?php endif;?>

        <?php if($Quote->Song->Album->is_valid):?>
        <div class="container-album">
            <h3 class="small-title">L'album</h3>
            <div class="container-cover-album">
                <div class="container-informations-album">
                    <span class="title-album"><?= $Quote->Song->Album->title;?></span>
                    <span class="artist-album"><?= $Quote->Song->Album->Artist->name;?></span>
                    <span class="release-album"><?= $Quote->Song->Album->date;?></span>
                </div>
                <div class="gradient-cover-album"></div>
                <div class="border-cover-album box-border-white"></div>
                <div class="cover-album" style="background-image: url('<?= $Quote->Song->Album->url_cover;?>');"></div>
            </div>
        </div>
        <?php endif;?>
    </div>
</section>