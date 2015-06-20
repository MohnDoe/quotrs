<?php
    include_once 'core.php';
	Class Quote{
        public $id = "";
        public $hashid = "";

		public $content_fr_FR;
		public $content_en_US;

		public $date;
		public $Artist;
		public $Song;

		public $url_image;

		public $Explain;

		public $nbLikes;

		public $originalLang;

		function __construct($idQuote = null, $isHashID = true){
			if(!is_null($idQuote)){
                if ($isHashID){
                    $this->hashid = $idQuote;
                }else{
                    $this->id = $idQuote;
                }
				/* INITIALISATION */
				$this->init();
			}

		}

		public function quote_exists(){
            if($this->hashid == "" && $this->id != ""){
                $req = DB::$db->query('SELECT * FROM '.DB::$tableQuotes.' WHERE id_quote = '.$this->id.' LIMIT 1');
            }else if ($this->id == "" && $this->hashid != ""){
                $req = DB::$db->query('SELECT * FROM '.DB::$tableQuotes.' WHERE hashid_quote = "'.$this->hashid.'" LIMIT 1');
            }else{
                return false;
            }
			return $req->fetch();
		}

		public function init(){
			if($data = $this->quote_exists()){

                $this->id = $data['id_quote'];
                $this->hashid = $data['hashid_quote'];

                // hashID
                $HASHIDS = new Hashids\Hashids(SALT_HASHIDS, 7);
                if($this->id == ""){
                    var_dump("decoding HashID");
                    $this->id = $HASHIDS->decode($this->hashid);
                }
                if($this->hashid == ""){
                    var_dump("encoding HashID");
                    $this->hashid = $HASHIDS->encode($this->id);
                    $this->saveHashID();
                }
				$this->content_fr_FR = $data['content_quote_fr_FR'];

				$this->date = $data['date_quote'];

				$this->Artist = new Artist($data['id_artist']);
				$this->Song = new Song($data['id_song']);

				//$this->url_image = PREFIX_URL_RELATIF.FOLDER_COVER_ALBUMS.$this->Song->Album->urlPochetteBW;

                if(!$this->Song->Album->id != 0 AND !$this->Song->Album->album_exists()){
					$this->url_image = 'http://img.youtube.com/vi/'.$this->Song->urlYoutube.'/maxresdefault.jpg';
				}

				$this->nbLikes = $this->getNbLikes();
			}
		}

        public function saveHashID(){
            DB::$db->query("UPDATE ".DB::$tableQuotes." SET `hashid_quote`=\"".$this->hashid."\" WHERE id_quote = ".$this->id);
        }
		public function getNbLikes(){
			$req = DB::$db->query('SELECT COUNT(*) AS result FROM '.DB::$tableLikes.' WHERE id_quote = '.$this->id.' LIMIT 1');
			$data = $req->fetch();
			return $data['result'];
		}

		public function translate_to($lang="fr_FR"){
			if(!property_exists(self, "content_".$lang) AND !is_null($this->{"content_".$lang}) AND !$this->{"content_".$lang} == ""){
				return $this->{"content_".$lang};
			}else{
				return false;
			}
		}
	}
?>