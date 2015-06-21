<?php
    include_once 'core.php';

    Class Song
    {
        public $id;
        public $title;
        public $urlYoutube;
        public $urlSoundcloud;
        public $urlVimeo;
        public $urlOther;

        public $id_artist;
        public $Artist;

        public $id_album;
        public $Album;


        public $initParams = array(
            'init_artist' => false,
            'init_album' => false
        );
        public function __construct ($idSong = NULL, $initParams = [])
        {

            foreach ($initParams as $nameParam => $value) {
                $this->initParams[$nameParam] = $value;
            }

            if (!is_null ($idSong)) {
                $this->id = $idSong;
                $this->init ();
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
            if ($this->song_exists ()) {
                $req = DB::$db->query ('SELECT * FROM ' . DB::$tableSongs . ' WHERE id_song = ' . $this->id . ' LIMIT 1');
                $data = $req->fetch ();

                $this->title = $data['title_song'];
                $this->urlYoutube = trim ($data['url_youtube_song']);
                $this->urlSoundcloud = trim ($data['url_soundcloud_song']);
                $this->urlVimeo = trim ($data['url_vimeo_song']);
                $this->urlOther = trim ($data['url_other_song']);

                $this->id_artist = $data['id_artist'];
                if($this->initParams['init_artist']){
                    $this->Artist = new Artist($this->id_artist);
                }

                $this->id_album = $data['id_album'];
                if($this->initParams['init_album']){
                    $this->Album = new Album($this->id_artist);
                }
            }
        }
    }

?>