<?php
    require_once 'core.php';

    Class Album
    {

        public $initParams = ['init_artist'=>false];

        public $id;
        public $title;
        public $date;

        public $url_cover;

        public $urlAmazone;
        public $urlITunes;

        public $urlOther;
        public $id_artist;

        public $Artist;

        public $delimiter_url_cover = "###";

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

                if($data['url_cover'] != "" && $data['url_cover'] != null){
                    //une image existe dans la base de donnée
                    $url_image_array = explode($this->delimiter_url_image, $data['url_cover']);
                    $url_image = $url_image_array[0];
                    $timestamp_last_check = $url_image_array[1];
                    if(time()+(24 * 60 * 60) > (int)$timestamp_last_check){
                        // si la derniere check est inférieur à 1 journée
                        $this->url_cover = $url_image;
                    }else{
                        $this->url_cover = $this->getURLCover();
                    }
                }else{
                    $this->url_cover = $this->getURLCover();
                }

                $this->urlAmazone = $data['url_amazone_album'];
                $this->urlITUnes = $data['url_itunes_album'];
                $this->urlOther = $data['url_other_album'];

                $this->id_artist = $data['id_artist'];
                if($this->initParams['init_artist']){
                    $this->Artist = new Artist($this->id_artist);
                }
            }

        }

        public function getURLCover ()
        {

            $url_cover_result = false;

            // INIT AWS S3 CLIENT
            $_AWS_S3_CLIENT = Aws\S3\S3Client::factory (
                [
                    'key'    => AWS_ACCESS_KEY_ID,
                    'secret' => AWS_SECRET_ACCESS_KEY,
                    'region' => AWS_S3_REGION
                ]);
            // first let's check if the album have an image
            //TODO: Make auto image search for Album object
            $key_album_cover = ALBUMS_COVERS_FOLDER . '/' . $this->id . '/original_cover.jpg';
            if ($_AWS_S3_CLIENT->doesObjectExist (S3_BUCKET_NAME, $key_album_cover)) {
                // album cover exists
                $url_cover_result = WEBROOT . $key_album_cover;
            } else {
                // no album, let check the artist picture
                //TODO: Make auto image search for Artist object

                $key_artist_image = ARTISTES_IMAGES_FOLDER . '/' . $this->id_artist . '/original_image.jpg';
                if ($_AWS_S3_CLIENT->doesObjectExist (S3_BUCKET_NAME, $key_artist_image)) {
                    // artist image exists
                    $url_cover_result = WEBROOT . $key_artist_image;
                }
            }
            if(!!$url_cover_result){
                $this->saveURLCover($url_cover_result);
            }
            //TODO: if no image put an placeholder image

            return $url_cover_result;
        }

        public function album_exists ()
        {
            $req = DB::$db->query ('SELECT * FROM ' . DB::$tableAlbums . ' WHERE id_album = "' . $this->id . '" LIMIT 1');
            return $req->fetch ();
        }

        public function saveURLCover ($url_cover_result) {
            DB::$db->query ("UPDATE " . DB::$tableAlbums . " SET `url_cover`=\"" . $url_cover_result . $this->delimiter_url_cover . time() . "\" WHERE id_artist = " . $this->id);
        }

    }

?>