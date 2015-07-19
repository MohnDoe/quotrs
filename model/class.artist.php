<?php
    require_once 'core.php';

    Class Artist
    {
        public $id;
        public $name;
        public $description;
        public $url_image;
        public $urlFacebook;
        public $urlTwitter;
        public $urlSite;
        public $urlOther;
        public $delimiter_url_image = "?";

        public $is_valid = false;

        function __construct ($idArtist = NULL, $initParams = [])
        {

            foreach ($initParams as $nameParam => $value) {
                $this->initParams[$nameParam] = $value;
            }

            if (!is_null ($idArtist)) {
                $this->id = $idArtist;
                /* INITIALISATION */
                $this->init ();
                if($idArtist == -1){
                    $this->name = "Artiste inconnu(e)";
                    $this->is_valid = false;
                }
            }
        }

        public function init ()
        {
            if ($data = $this->artist_exists ()) {
                $this->is_valid = true;

                $this->name = $data['nom_artist'];
                $this->description = $data['description_artist'];

                $this->url_image = $data['url_picture_artist'];
                if($data['url_picture_artist'] != "" && $data['url_picture_artist'] != null){
                    //une image existe dans la base de donnée
                    $url_image_array = explode($this->delimiter_url_image, $data['url_picture_artist']);
                    $url_image = $url_image_array[0];
                    $timestamp_last_check = $url_image_array[1];
                    if(time()+(24 * 60 * 60) > (int)$timestamp_last_check){
                        // si la derniere check est inférieur à 1 journée
                        $this->url_image = $url_image;
                    }else{
                        $this->url_image = $this->getURLPicture();
                    }
                }else{
                    $this->url_image = $this->getURLPicture();
                }
                $this->urlFacebook = $data['url_facebook_artist'];
                $this->urlTwitter = $data['url_twitter_artist'];
                $this->urlSite = $data['url_site_artist'];
                $this->urlOther = $data['url_other_artist'];
            }
        }

        public function artist_exists ()
        {
            $req = DB::$db->query ('SELECT * FROM ' . DB::$tableArtists . ' WHERE id_artist = ' . $this->id . ' LIMIT 1');
            return $req->fetch ();
        }

        public function getQuotes(){
            $req = DB::$db->query('SELECT * FROM ' . DB::$tableQuotes . ' WHERE id_artist = '.$this->id);
            $result = [];
            while($data = $req->fetch()){
                $result[] = new Quote($data['id_quote'], ['isHashID'=>false]);
            }
            return $result;
        }

        public function getAlbums(){
            $req = DB::$db->query('SELECT * FROM ' . DB::$tableAlbums . ' WHERE id_artist = '.$this->id);
            $result = [];
            while($data = $req->fetch()){
                $result[] = new Album($data['id_album'], ['isHashID'=>false]);
            }
            return $result;
        }

        public function getNbQuotes(){
            $req = DB::$db->query('SELECT COUNT(*) AS result FROM ' . DB::$tableQuotes . ' WHERE id_artist = '.$this->id);
            $data = $req->fetch();

            return $data['result'];
        }

        private function getURLPicture () {
            $url_picture_result = null;

            // INIT AWS S3 CLIENT
            $_AWS_S3_CLIENT = Aws\S3\S3Client::factory (
                [
                    'key'    => AWS_ACCESS_KEY_ID,
                    'secret' => AWS_SECRET_ACCESS_KEY,
                    'region' => AWS_S3_REGION
                ]);

            $key_artist_image = ARTISTES_IMAGES_FOLDER . '/' . $this->id . '/original_image.jpg';
            if ($_AWS_S3_CLIENT->doesObjectExist (S3_BUCKET_NAME, $key_artist_image)) {
                // artist image exists
                $url_picture_result = WEBROOT . $key_artist_image;
            }

            if(!is_null($url_picture_result)){
                $this->saveURLPicture($url_picture_result);
            }
            return $url_picture_result;
        }

        private function saveURLPicture ($url_picture_result) {
            DB::$db->query ("UPDATE " . DB::$tableArtists . " SET `url_picture_artist`=\"" . $url_picture_result . $this->delimiter_url_image . time() . "\" WHERE id_artist = " . $this->id);

        }

        /**
         * @return int
         */
        public function addArtist () {
            $this->name = htmlspecialchars($this->name);
            $req = "INSERT INTO ".DB::$tableArtists."
                        (nom_artist)
                        VALUES
                        (:nom_artist)";

            $query = DB::$db->prepare($req);
            $query->bindParam(':nom_artist', $this->name);

            $query->execute();

            $id_new_artist = DB::$db->lastInsertId();

            return (int)$id_new_artist;
        }

        static function searchArtists($search){
          //TODO : secure that
          $search = "%".$search."%";
          $req = "SELECT *
                  FROM  ".DB::$tableArtists."
                  WHERE  `nom_artist` LIKE  :query
                  LIMIT 0 , 7";
          $query = DB::$db->prepare($req);
          $query->bindParam(':query', $search, PDO::PARAM_STR);
          $query->execute();
          $result = [];
          while($data = $query->fetch()){
            $Artist = new Artist();
            $Artist->id = $data['id_artist'];
            $Artist->name = $data['nom_artist'];

            $result[] = $Artist;
          }
          return $result;
        }

        public function toArray(){
          $array = [];

          $array['id'] = $this->id;
          $array['name'] = $this->name;

          return $array;
        }

        public function toJSON(){
          return json_encode($this->toArray());
        }
    }

?>
