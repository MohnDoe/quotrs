<?php
    require_once 'core.php';

    Class Quote
    {
        public $id = "";
        public $hashid = "";

        public $content;

        public $date;
        public $Artist;
        public $Song;

        public $url_image;

        public $Explain;

        public $nbLikes;

        public $originalLang;

        function __construct ($idQuote = NULL, $isHashID = true)
        {
            if (!is_null ($idQuote)) {
                if ($isHashID) {
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

                $this->id = $data['id_quote'];
                $this->hashid = $data['hashid_quote'];

                // hashID
                $HASHIDS = new Hashids\Hashids(SALT_HASHIDS, 7);
                if ($this->id == "") {
                    $this->id = $HASHIDS->decode ($this->hashid);
                }
                if ($this->hashid == "") {
                    $this->hashid = $HASHIDS->encode ($this->id);
                    $this->saveHashID ();
                }
                $this->content = $data['content_quote_fr_FR'];

                $this->date = $data['date_quote'];

                $this->Artist = new Artist($data['id_artist']);
                $this->Song = new Song($data['id_song']);

                $this->url_image = $this->getURLImage ();

                if (!$this->Song->Album->id != 0 AND !$this->Song->Album->album_exists ()) {
                    $this->url_image = 'http://img.youtube.com/vi/' . $this->Song->urlYoutube . '/maxresdefault.jpg';
                }

                $this->nbLikes = $this->getNbLikes ();
            }
        }

        public function getURLImage ()
        {

            $url_image_result = false;

            // INIT AWS S3 CLIENT
            $_AWS_S3_CLIENT = Aws\S3\S3Client::factory (
                [
                    'key'    => AWS_ACCESS_KEY_ID,
                    'secret' => AWS_SECRET_ACCESS_KEY,
                    'region' => AWS_S3_REGION
                ]);
            // first let's check if the album have an image
            //TODO: Make auto image search for Album object
            $key_album_cover = ALBUMS_COVERS_FOLDER . '/' . $this->Song->Album->id . '/original_cover.jpg';
            if ($this->Song->Album->album_exists () && $_AWS_S3_CLIENT->doesObjectExist (S3_BUCKET_NAME, $key_album_cover)) {
                // album cover exists
                $url_image_result = WEBROOT . $key_album_cover;
            } else {
                // no album, let check the artist picture
                //TODO: Make auto image search for Artist object

                $key_artist_image = ARTISTES_IMAGES_FOLDER . '/' . $this->Artist->id . '/original_image.jpg';
                if ($this->Artist->artist_exists () && $_AWS_S3_CLIENT->doesObjectExist (S3_BUCKET_NAME, $key_artist_image)) {
                    // artist image exists
                    $url_image_result = WEBROOT . $key_artist_image;
                } else {
                    // no artist image, let check the youtube cover
                    if ($this->Song->urlYoutube != "") {
                        // cover youtube exists
                        $url_image_result = 'http://img.youtube.com/vi/' . $this->Song->urlYoutube . '/maxresdefault.jpg';
                    }
                }
            }
            //TODO: if no image put an placeholder image

            return $url_image_result;
        }

        public function saveHashID ()
        {
            DB::$db->query ("UPDATE " . DB::$tableQuotes . " SET `hashid_quote`=\"" . $this->hashid . "\" WHERE id_quote = " . $this->id);
        }

        public function getNbLikes ()
        {
            $req = DB::$db->query ('SELECT COUNT(*) AS result FROM ' . DB::$tableLikes . ' WHERE id_quote = ' . $this->id . ' LIMIT 1');
            $data = $req->fetch ();
            return $data['result'];
        }

        public function translate_to ($lang = "fr_FR")
        {
            if (!property_exists (self, "content_" . $lang) AND !is_null ($this->{"content_" . $lang}) AND !$this->{"content_" . $lang} == "") {
                return $this->{"content_" . $lang};
            } else {
                return false;
            }
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

            $array['artist']['id'] = $this->Artist->id;
            $array['artist']['name'] = $this->Artist->name;

            $array['song']['id'] = $this->Song->id;
            $array['song']['title'] = $this->Song->title;
            $array['song']['album']['id'] = $this->Song->Album->id;
            $array['song']['album']['name'] = $this->Song->Album->title;

            return $array;

        }
    }

?>