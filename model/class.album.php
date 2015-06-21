<?php
    require_once 'core.php';

    Class Album
    {

        public $initParams = array('init_artist'=>false);

        public $id;
        public $title;
        public $date;
        public $urlPochetteBW;
        public $urlPochetteN;
        public $urlAmazone;
        public $urlITunes;

        public $urlOther;
        public $id_artist;

        public $Artist;

        public function __construct ($idAlbum = NULL, $initParams = [])
        {

            foreach ($initParams as $nameParam => $value) {
                $this->initParams[$nameParam] = $value;
            }
            if (!is_null ($idAlbum) AND $idAlbum != 0 AND $idAlbum != '0') {
                $this->id = $idAlbum;
                $this->init ();
            }
        }

        public function init ()
        {

            if ($this->album_exists ()) {
                $req = DB::$db->query ('SELECT * FROM ' . DB::$tableAlbums . ' WHERE id_album = ' . $this->id . ' LIMIT 1');
                $data = $req->fetch ();

                $this->title = $data['title_album'];
                $this->date = $data['date_album'];
                // $this->urlPochetteBW = '/'.$this->id.'/n.jpg';
                $this->urlPochetteBW = '/' . $this->id . '/bw.jpg';
                $this->urlPochetteN = '/' . $this->id . '/n.jpg';
                $this->urlAmazone = $data['url_amazone_album'];
                $this->urlITUnes = $data['url_itunes_album'];
                $this->urlOther = $data['url_other_album'];

                $this->id_artist = $data['id_artist'];
                if($this->initParams['init_artist']){
                    $this->Artist = new Artist($this->id_artist);
                }
            }

        }

        public function album_exists ()
        {
            $req = DB::$db->query ('SELECT * FROM ' . DB::$tableAlbums . ' WHERE id_album = "' . $this->id . '" LIMIT 1');
            return $req->fetch ();
        }

    }

?>