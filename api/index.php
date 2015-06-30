<?php
/**
 * Created by PhpStorm.
 * User: Personne
 * Date: 21/06/2015
 * Time: 13:58
 */

    require '../model/core.php';
    require '../vendor/autoload.php';


    // INIT SLIM
    \Slim\Slim::registerAutoloader();

    $app = new \Slim\Slim([
        'debug' => true,
    ]);


    // CALLS

    // CALLS ON QUOTES

    /*
     * Va chercher une citation par son HashID
     */
    $app->get('/quotes/:hashid', function($hashid) use($app) {
        $Quote = new Quote($hashid);
        if($Quote->is_valid){
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo $Quote->toJSON();
        }else{
            $app->response->setStatus(404);
            $json = [];
            $json['error']['type'] = 404;
            $json['error']['text'] = 'No such quote.';
            echo json_encode($json);
        }
    })->name("getQuoteByHashID");

    $app->get('/artists/:query', function($query) use($app){
      $ArtistsFound = Artist::searchArtists($query);
      // var_dump($ArtsitsFound);
      $json = [];
      $json['count'] = count($ArtistsFound);

      foreach($ArtistsFound as $Artist){
          $json['artists'][] = $Artist->toArray();
      }
      echo json_encode($json);
    });

    $app->get('/artists/:idArtist/songs/:query', function($idArtist, $query) use($app){
      $app->response->setStatus(200);
      $app->response()->headers->set('Content-Type', 'application/json');
      $SongsFound = Song::searchSongs($query, $idArtist);
      $json = [];
      $json['count'] = count($SongsFound);

      foreach($SongsFound as $Song){
          $json['songs'][] = $Song->toArray();
      }
      echo json_encode($json);
    });

    $app->get('/songs/:query', function($query) use($app){
      $app->response->setStatus(200);
      $app->response()->headers->set('Content-Type', 'application/json');
      $SongsFound = Song::searchSongs($query);
      $json = [];
      $json['count'] = count($SongsFound);

      $json['songs'] = $SongsFound;
      echo json_encode($json);
    });

    /*
     * Va chercher toutes les citations d'un artist
     */

    /*
     * Post une nouvelle citation
     */
    $app->post('/quotes/create', function() use ($app){
        $allParamsPOST = $app->request->post();
        var_dump($allParamsPOST);

        $idArtistQuote = -1;
        $idAlbumSongQuote = -1;
        $idSongQuote = -1;

        /*
         * QUOTE'S ARTIST
         */
        if($allParamsPOST['song']['artist']['artistIsNew'] == "true"){
            // add new artist in DB
            $name_new_artist = htmlspecialchars($allParamsPOST['song']['artist']['name']);
            $NewArtist = new Artist();
            $NewArtist->name = $name_new_artist;
            $idNewArtist = $NewArtist->addArtist();
            $idArtistQuote = $idNewArtist;
            var_dump("New artist created : #".$idArtistQuote." / ".$NewArtist->name);
        }
        else{
            //not a new artist
            //check if artist exists
            $ArtistQuote = new Artist($allParamsPOST['song']['artist']['existingID']);
            if($ArtistQuote->is_valid){
                $idArtistQuote = $ArtistQuote->id;
                var_dump("Already existing artist : #".$idArtistQuote." / ".$ArtistQuote->name);

            }
        }

        /*
         * QUOTE'S SONG'S ALBUM
         */
        if($allParamsPOST['song']['album']['albumIsNew'] == "true"){
            // new album for the quote's song
            // adding new album
            $album_title_song = $allParamsPOST['song']['album']['title'];
            $NewAlbumSong = new Album();
            $NewAlbumSong->title = $album_title_song;



            //TODO: take care of album who's not made by the quote's artist
            $NewAlbumSong->id_artist = $idArtistQuote;
            $idNewAlbum = $NewAlbumSong->addAlbum();
            $NewAlbumSong->id = $idNewAlbum;
            $idAlbumSongQuote = $idNewAlbum;

            //update cover
            //TODO: make some check {size, type, etc etc}
            if(isset($_FILES['song']['album']['cover_album']['name'])){
                var_dump("Uploading new cover");
                $NewAlbumSong->uploadCover($_FILES['cover_album']);
                var_dump($NewAlbumSong->url_cover);
            }
            var_dump("New album created : #".$idAlbumSongQuote." / ".$NewAlbumSong->title);

        }
        else{
            // album not new
            //check if album exists in DB
            $AlbumSongQuote = new Album($allParamsPOST['song']['album']['existingID']);
            if($AlbumSongQuote->is_valid){
                $idAlbumSongQuote = $AlbumSongQuote->id;
                var_dump("Already existing album : #".$idAlbumSongQuote." / ".$AlbumSongQuote->title);

            }
        }

        /*
         * QUOTE'S SONG
         */
        if($allParamsPOST['song']['songIsNew'] == "true"){
            // ajoutons un nouveau morceau
            $title_new_song = htmlspecialchars($allParamsPOST['song']['title']);
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $allParamsPOST['song']['url_youtube'], $parsedYoutubeSongURL);
            $NewSong = new Song();
            var_dump($parsedYoutubeSongURL);
            $NewSong->title = $title_new_song;
            $NewSong->id_artist = $idArtistQuote;
            $NewSong->id_album = $idAlbumSongQuote;
            //FIXME : check url youtube
            $NewSong->urlYoutube = $allParamsPOST['song']['url_youtube'];
            $idNewSong = $NewSong->addSong();

            $idSongQuote = $idNewSong;
            var_dump("New song created : #".$idSongQuote." / ".$NewSong->title);

        }
        else{
            //song not new
            //check if song exist in DB
            $SongQuote = new Song($allParamsPOST['song']['existingID']);
            if($SongQuote->is_valid){
                $idSongQuote = $SongQuote->id;
                var_dump("Already existing song : #".$idSongQuote." / ".$SongQuote->title);

            }
        }

        /*
         * THE QUOTE
         */
        $NewQuote = new Quote();
        $content_new_quote = "";
        for ($i=0; $i < count($allParamsPOST['content']) ; $i++) {
          $line = htmlspecialchars($allParamsPOST['content'][$i]);
          $content_new_quote .= $line."\\n";
        }
        $NewQuote->content = $content_new_quote;
        $NewQuote->id_artist = $idArtistQuote;
        $NewQuote->id_song = $idSongQuote;

        $idNewQuote = $NewQuote->addQuote();

        var_dump("New quote created : #".$idNewQuote." / HashID : ".$NewQuote->hashid);


    })->name("createQuote");

    $app->run();
