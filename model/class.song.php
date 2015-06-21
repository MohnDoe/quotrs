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
        public $Artist;
        public $Album;

        public function __construct ($idSong = NULL)
        {
            if (!is_null ($idSong)) {
                $this->id = $idSong;
                $this->init ();
            }

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
                $this->Artist = new Artist($data['id_artist']);
                $this->Album = new Album($data['id_album']);
            }
        }
    }

?>