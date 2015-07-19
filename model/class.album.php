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

        public $delimiter_url_cover = "?";

        public $is_valid = false;
        public $last_version_cover;

        public function __construct ($idAlbum = NULL, $initParams = [])
        {

            foreach ($initParams as $nameParam => $value) {
                $this->initParams[$nameParam] = $value;
            }
            if (!is_null ($idAlbum) AND $idAlbum != 0 AND $idAlbum != '0') {
                $this->id = $idAlbum;
                $this->init ();
                if($idAlbum == -1){
                    $this->title = "Album inconnu";
                    $this->is_valid = false;
                }
            }
        }

        public function init ()
        {

            if ($data = $this->album_exists ()) {
                $this->is_valid = true;

                $this->title = $data['title_album'];
                $this->date = $data['date_album'];

                $this->last_version_cover = $data['last_version_cover'];
                if($data['url_cover'] != "" && $data['url_cover'] != null){
                    //une image existe dans la base de donnée
                    $url_image_array = explode($this->delimiter_url_cover, $data['url_cover']);
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

            $url_cover_result = null;

            // INIT AWS S3 CLIENT
            $_AWS_S3_CLIENT = Aws\S3\S3Client::factory (
                [
                    'key'    => AWS_ACCESS_KEY_ID,
                    'secret' => AWS_SECRET_ACCESS_KEY,
                    'region' => AWS_S3_REGION
                ]);
            // first let's check if the album have an image
            $key_album_cover = ALBUMS_COVERS_FOLDER . '/' . $this->id . '/'.$this->last_version_cover.'/original_cover.jpg';
            if ($_AWS_S3_CLIENT->doesObjectExist (S3_BUCKET_NAME, $key_album_cover)) {
                // album cover exists
                $url_cover_result = WEBROOT . $key_album_cover;
            }

            if(!is_null($url_cover_result)){
                $this->saveURLCover($url_cover_result, $this->last_version_cover);
            }

            return $url_cover_result;
        }

        public function album_exists ()
        {
            $req = DB::$db->query ('SELECT * FROM ' . DB::$tableAlbums . ' WHERE id_album = "' . $this->id . '" LIMIT 1');
            return $req->fetch ();
        }

        public function saveURLCover ($url_cover_result, $date_version) {
            $url_cover = $url_cover_result . $this->delimiter_url_cover . time();
            $req = "UPDATE " . DB::$tableAlbums . " SET `url_cover`=:url_cover, last_version_cover = :last_version_cover WHERE id_album = :id_album";
            $query = DB::$db->prepare($req);
            $query->bindParam(':url_cover', $url_cover);
            $query->bindParam(':last_version_cover', $date_version);
            $query->bindParam(':id_album', $this->id);

            $query->execute();
        }

        public function addAlbum () {
            $this->title = htmlspecialchars($this->title);
            $req = "INSERT INTO ".DB::$tableAlbums."
                    (title_album, id_artist)
                    VALUES (:title_album,:id_artist)";

            $query = DB::$db->prepare($req);
            $query->bindParam(':title_album', $this->title);
            $query->bindParam(':id_artist', $this->id_artist);

            $query->execute();

            $id_new_album = DB::$db->lastInsertId();

            return (int)$id_new_album;
        }

        public function uploadCover ($cover_album) {
            $dateVersion = new DateTime();
            $dateVersion = $dateVersion->getTimestamp();

            $key_album_cover = ALBUMS_COVERS_FOLDER . '/' . $this->id . '/'.$dateVersion.'/original_cover.jpg';

            var_dump($key_album_cover);
            // Upload to S3
            $_AWS_S3_CLIENT = Aws\S3\S3Client::factory (
            [
                'key'    => AWS_ACCESS_KEY_ID,
                'secret' => AWS_SECRET_ACCESS_KEY,
                'region' => AWS_S3_REGION
            ]);

            //File details
            $name = $cover_album['name'];
            $tmp_name = $cover_album['tmp_name'];

            $_AWS_S3_CLIENT->putObject(array(
               'Bucket'       => S3_BUCKET_NAME,
               'Key'          => $key_album_cover,
               'SourceFile'   => $tmp_name,
               'ACL'          => 'public-read'
                                       ));


            $this->url_cover = WEBROOT.$key_album_cover;
            $this->last_version_cover = $dateVersion;
            $this->saveURLCover($this->url_cover, $this->last_version_cover);
        }

    }

?>