<?php
include_once 'core.php';


Class Song
{
    public $id;
    public $title;
    public $url_youtube;

    public $id_artist;
    public $Artist;

    public $id_album;
    public $Album;

    public $url_rg;

    public $initParams = [
        'init_artist' => false,
        'init_album' => false,
        'init_album_artist' => false
    ];

    public $is_valid = false;
    public function __construct ($idSong = NULL, $initParams = [])
    {

        foreach ($initParams as $nameParam => $value) {
            $this->initParams[$nameParam] = $value;
        }

        if (!is_null ($idSong)) {
            $this->id = $idSong;
            $this->init ();

            if($idSong == -1){
                $this->title = "Morceau inconnu";
                $this->is_valid = false;
            }
        }

        $this->initParams = $initParams;
    }

    public function song_exists ()
    {
        $req = DB::$db->query ('SELECT * FROM ' . DB::$tableSongs . ' WHERE id_song = ' . $this->id . ' LIMIT 1');
        return $req->fetch ();
    }

    public function init ()
    {
        if ($data = $this->song_exists ()) {
            $this->is_valid = true;

            $this->title = $data['title_song'];
            $this->url_youtube = trim ($data['url_youtube_song']);

            if($this->url_youtube == ""){
              //let's get it from Genius
              if($dataGeniusSong = CallAPI('GET', "http://api.genius.com/songs/".$this->id."?access_token=".ACCESS_TOKEN_GENIUS_API)){
                $dataGeniusSong = json_decode($dataGeniusSong);
                $response = $dataGeniusSong->response;
                $song = $response->song;
                $media = $song->media;
                if(count($media)>0){
                  if($media[0]->type == "video" AND $media[0]->provider == "youtube"){
                    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $media[0]->url, $this->url_youtube);
                    $this->url_youtube = $this->url_youtube[1];
                    $this->saveURLYoutube();
                  }
                }
              }
              
            }
            $this->id_artist = $data['id_artist'];
            if($this->initParams['init_artist']){
                $this->Artist = new Artist($this->id_artist);
            }

            $this->id_album = $data['id_album'];
            if($this->initParams['init_album']){
                $this->Album = new Album($this->id_album, [
                    'init_artist' => $this->initParams['init_album_artist']
                ]);
            }
        }
    }
    public function addSong ($comeFromRG = true) {
    /*
        $NewSong->title = $title_new_song;
        $NewSong->id_artist = $idArtistQuote;
        $NewSong->id_album = $idAlbumSongQuote;
        $NewSong->urlYoutube = $parsedYoutubeSongURL['v'];

     */
        if($comeFromRG){
            $this->title = htmlspecialchars($this->title);
            $req = "INSERT INTO ".DB::$tableSongs."
                    (id_song, title_song, url_other_song, id_artist, id_album)
                    VALUES (:id_song,:title_song,:url_other_song,:id_artist,:id_album)";

            $query = DB::$db->prepare($req);
            $query->bindParam(':id_song', $this->id);
            $query->bindParam(':title_song', $this->title);
            $query->bindParam(':url_other_song', $this->url_rg);
            $query->bindParam(':id_artist', $this->id_artist);
            $query->bindParam(':id_album', $this->id_album);

            $query->execute();
        }else{
            $this->title = htmlspecialchars($this->title);
            $req = "INSERT INTO ".DB::$tableSongs."
                    (title_song, url_youtube_song, id_artist, id_album)
                    VALUES (:title_song, :url_yt_song,:id_artist,:id_album)";

            $query = DB::$db->prepare($req);
            $query->bindParam(':title_song', $this->title);
            $query->bindParam(':url_yt_song', $this->urlYoutube);
            $query->bindParam(':id_artist', $this->id_artist);
            $query->bindParam(':id_album', $this->id_album);

            $query->execute();

            $id_new_song = DB::$db->lastInsertId();

            return (int)$id_new_song;
        }
    }
    static function searchSongs($search, $idArtist = null){
      //TODO : secure that
      $search = "%".$search."%";
      $req = "SELECT *
              FROM  ".DB::$tableSongs."
              WHERE  `title_song` LIKE  :query ";
      if(!is_null($idArtist)){
        $req .= "AND id_artist = :idArtist ";
      }
      $req .= "LIMIT 0 , 7";
      $query = DB::$db->prepare($req);
      $query->bindParam(':query', $search, PDO::PARAM_STR);
      if(!is_null($idArtist)){
        $query->bindParam(':idArtist', $idArtist);
      }
      $query->execute();
      $result = [];
      while($data = $query->fetch()){
        $Song = new Song($data['id_song'], ['init_artist' => true, 'init_album' => true]);

        $result[] = $Song;
      }
      return $result;
    }
    public function toArray(){
      $array = [];

      $array['id'] = $this->id;
      $array['title'] = $this->title;
      $array['url_youtube'] = $this->url_youtube;
      $array['album']['id'] = $this->id_album;
      $array['album']['title'] = $this->Album->title;
      $array['album']['artist']['id'] = $this->Album->id_artist;

      return $array;
    }
    public function saveURLYoutube(){
      $request = "UPDATE `".DB::$tableSongs."` SET url_youtube_song = :url_youtube WHERE id_song = ".$this->id;
      $query = DB::$db->prepare($request);
      $query->bindParam(':url_youtube', $this->url_youtube);
      $query->execute();
    }
    public function toJSON(){
      return json_encode($this->toArray());
    }
}

?>
