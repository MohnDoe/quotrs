<?php
    require_once 'core.php';

    Class Quote
    {
        /**
         * @var array
         */
        public $initParams = [
            'isHashID' => true,
            'init_artist' => false,
            'init_song' => false
        ];

        private $delimiter_url_image = "###";
        public $id = "";

        public $hashid = "";

        public $content;

        public $date;
        public $id_artist;

        public $Artist;
        public $id_song;

        public $Song;

        public $url_image;

        public $Explain;

        public $nbLikes;
        public $originalLang;

        public $is_valid = false;

        function __construct ($idQuote = NULL, $initParams = [])
        {

            foreach ($initParams as $nameParam => $value) {
                $this->initParams[$nameParam] = $value;
            }

            if (!is_null ($idQuote)) {
                if ($this->initParams['isHashID']) {
                    $this->hashid = $idQuote;
                } else {
                    $this->id = $idQuote;
                }
                /* INITIALISATION */
                $this->init ();
            }
        }

        public function quote_exists ()
        {
            if ($this->id != "") {
                $req = DB::$db->query ('SELECT * FROM ' . DB::$tableQuotes . ' WHERE id_quote = ' . $this->id . ' LIMIT 1');
            } else if ($this->hashid != "") {
                $req = DB::$db->query ('SELECT * FROM ' . DB::$tableQuotes . ' WHERE hashid_quote = "' . $this->hashid . '" LIMIT 1');
            } else {
                return false;
            }
            return $req->fetch ();
        }

        public function init ()
        {
            if ($data = $this->quote_exists ()) {
                $this->is_valid = true;

                $this->id = $data['id_quote'];
                $this->hashid = $data['hashid_quote'];

                // hashID
                $HASHIDS = new Hashids\Hashids(SALT_HASHIDS, 7);
                if ($this->id == "") {
                    $this->id = $HASHIDS->decode($this->hashid);
                }
                if ($this->hashid == "") {
                    $this->hashid = $HASHIDS->encode ($this->id);
                    $this->saveHashID ();
                }
                $this->content = $data['content_quote_fr_FR'];

                $this->date = $data['date_quote'];

                $this->id_artist = $data['id_artist'];
                if($this->initParams['init_artist']){
                    $this->Artist = new Artist($this->id_artist);
                }

                $this->id_song = $data['id_song'];
                if($this->initParams['init_song']){
                    $this->Song = new Song($this->id_song);
                }
                if($data['url_image'] != "" && $data['url_image'] != null){
                    //une image existe dans la base de donnée
                    $url_image_array = explode($this->delimiter_url_image, $data['url_image']);
                    $url_image = $url_image_array[0];
                    $timestamp_last_check = $url_image_array[1];
                    if(time()+(24 * 60 * 60) > (int)$timestamp_last_check){
                        // si la derniere check est inférieur à 1 journée
                        $this->url_image = $url_image;
                    }else{
                        $this->url_image = $this->getURLImage();
                    }
                }else{
                    $this->url_image = $this->getURLImage();
                }

                $this->nbLikes = $this->getNbLikes ();
            }
        }

        public function getURLImage ()
        {

            $url_image_result = false;

            // first let's check if the album have an image
            if(!$this->initParams['init_song']){
                $this->Song = new Song($this->id_song, ['init_artist'=>false, 'init_album'=>true]);
            }

            if (!is_null($this->Song->Album->url_cover)) {
                // album cover exists
                $url_image_result = $this->Song->Album->url_cover;
            }else{
                // pas de cover trouvé,
                // cherchant dans les artistes
                if(!$this->initParams['init_artist']){
                    $this->Artist = new Artist($this->id_artist);
                }
                if (!is_null($this->Artist->urlPicture)) {
                    // image artist exist
                    $url_image_result = $this->Artist->urlPicture;
                }
            }



            if(!is_null($url_image_result)){
                $this->saveURLImage($url_image_result);
            }

            //TODO: if no image put an placeholder image

            return $url_image_result;
        }

        public function saveHashID ()
        {
            DB::$db->query ("UPDATE " . DB::$tableQuotes . " SET `hashid_quote`=\"" . $this->hashid . "\" WHERE id_quote = " . $this->id);
        }

        public function saveURLImage ($url_image)
        {
            DB::$db->query ("UPDATE " . DB::$tableQuotes . " SET `url_image`=\"" . $url_image . $this->delimiter_url_image . time() . "\" WHERE id_quote = " . $this->id);
        }

        public function getNbLikes ()
        {
            $req = DB::$db->query ('SELECT COUNT(*) AS result FROM ' . DB::$tableLikes . ' WHERE id_quote = ' . $this->id . ' LIMIT 1');
            $data = $req->fetch ();
            return $data['result'];
        }

        public function toJSON () {
            $json = $this->toArray();
            return json_encode($json);

        }

        public function toArray () {
            $array = [];

            $array['id'] = $this->id;
            $array['hashid'] = $this->hashid;
            $array['content'] = $this->content;
            $array['created_at'] = $this->date;
            $array['url_image'] = $this->url_image;

            $array['artist']['id'] = $this->id_artist;
            if($this->initParams['init_artist']){
                $array['artist']['name'] = $this->Artist->name;
            }


            $array['song']['id'] = $this->id_song;
            if($this->initParams['init_song']){
                $array['song']['title'] = $this->Song->title;
                $array['song']['album']['id'] = $this->Song->Album->id;
                $array['song']['album']['name'] = $this->Song->Album->title;
            }

            return $array;

        }
    }

?>