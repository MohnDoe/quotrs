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
        'init_song' => false,
        'init_song_album' => true,
        'init_song_album_artist' => true
    ];

    private $delimiter_url_image = "?";
    public $id = "";

    public $hashid = "";

    public $content;

    public $date;

    public $id_artist;
    public $Artist;

    public $id_song;
    public $Song;

    public $url_image;

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
        $this->is_valid = true;
        return $req->fetch();
    }

    public function init ()
    {
        if ($data = $this->quote_exists ()) {

            $this->id = $data['id_quote'];
            $this->hashid = $data['hashid_quote'];

            // hashID
            $HASHIDS = new Hashids\Hashids(SALT_HASHIDS, 12,'abcdefghijklmnopqrstuvwxyz1234567890');
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
                $this->Song = new Song($this->id_song,
                                       array(
                                           'init_album' => $this->initParams['init_song_album'],
                                           'init_album_artist' => $this->initParams['init_song_album_artist']
                                       )
                );
            }
            $this->url_image = $data['url_image'];
            /*
            if(false && $data['url_image'] != "" && $data['url_image'] != null){
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
            */

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
            if (!is_null($this->Artist->url_image)) {
                // image artist exist
                $url_image_result = $this->Artist->url_image;
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
        $req = 'UPDATE ' . DB::$tableQuotes . ' SET `hashid_quote`= :hashid WHERE id_quote = :id_quote';
        $query = DB::$db->prepare($req);
        $query->bindParam(':hashid', $this->hashid);
        $query->bindParam(':id_quote', $this->id);

        $query->execute();
    }

    public function saveURLImage ($url_image)
    {
        $req = 'UPDATE ' . DB::$tableQuotes . ' SET `url_image`= :url_image WHERE id_quote = :id_quote';
        $query = DB::$db->prepare($req);
        $formatted_url_image = $url_image. $this->delimiter_url_image . time();
        $query->bindParam(':url_image', $formatted_url_image);
        $query->bindParam(':id_quote', $this->id);

        $query->execute();
    }

    public function incrementPopularity($amount = 1)
    {
        $req = 'UPDATE ' . DB::$tableQuotes . ' SET `popularity_quote`= popularity_quote+:amount WHERE id_quote = :id_quote';
        $query = DB::$db->prepare($req);
        $query->bindParam(':amount', $amount);
        $query->bindParam(':id_quote', $this->id);

        $query->execute();
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

    public function addQuote () {

        $req = "INSERT INTO ".DB::$tableQuotes."
                    (content_quote_fr_FR, date_quote, id_artist, id_song, hashid_quote, url_image)
                    VALUES (:content, NOW(),:id_artist,:id_song, :hashid_quote, :url_image)";

        $query = DB::$db->prepare($req);
        $query->bindParam(':content', $this->content);
        $query->bindParam(':id_artist', $this->id_artist);
        $query->bindParam(':id_song', $this->id_song);
        $query->bindParam(':hashid_quote', $this->hashid);
        $query->bindParam(':url_image', $this->url_image);

        $query->execute();

        $id_new_quote = DB::$db->lastInsertId();
        $this->id = $id_new_quote;

        $HASHIDS = new Hashids\Hashids(SALT_HASHIDS, 12, 'abcdefghij1234567890');
        $this->hashid = $HASHIDS->encode($id_new_quote);
        //var_dump($this->hashid);
        $this->saveHashID();

        return (int)$id_new_quote;
    }

    static function getTrendingQuotes(){
        $query = "SELECT id_quote FROM ".DB::$tableQuotes." WHERE 1 ORDER BY popularity_quote DESC LIMIT 7";

        $req = DB::$db->query($query);

        $d = [];

        while ($data = $req->fetch()) {
            $d[] = new Quote($data['id_quote'], array(
                    'isHashID' => false,
                    'init_artist' => true
                ));
        }
        return $d;
    }
}

?>