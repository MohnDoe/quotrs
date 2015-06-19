<?php
	include_once 'class.db.php';
	include_once 'class.song.php';
	include_once 'class.artist.php';
	include_once 'class.explain.php';
	Class Quote{
		public $id;

		public $content_fr_FR;
		public $content_en_US;

		public $date;
		public $Artist;
		public $Song;

		public $url_image;

		public $Explain;

		public $nbLikes;

		public $originalLang;

		function __construct($idQuote = null){
			if(!is_null($idQuote)){
				$this->id = $idQuote;
				/* INITIALISATION */
				$this->init();
			}

		}

		public function quote_exists(){
			$req = DB::$db->query('SELECT * FROM '.DB::$tableQuotes.' WHERE id_quote = '.$this->id.' LIMIT 1');
			return $req->fetch();
		}

		public function init(){
			if($this->quote_exists()){
				$req = DB::$db->query('SELECT * FROM '.DB::$tableQuotes.' WHERE id_quote = '.$this->id.' LIMIT 1');
				$data = $req->fetch();

				$this->content_fr_FR = $data['content_quote_fr_FR'];
				$this->content_en_US = $data['content_quote_en_US'];

				$this->date = $data['date_quote'];
				$this->Artist = new Artist($data['id_artist']);
				$this->Song = new Song($data['id_song']);
				$this->url_image = PREFIX_URL_RELATIF.FOLDER_COVER_ALBUMS.$this->Song->Album->urlPochetteBW;
				if(!$this->Song->Album->id != 0 AND !$this->Song->Album->album_exists()){
					$this->url_image = 'http://img.youtube.com/vi/'.$this->Song->urlYoutube.'/maxresdefault.jpg';
				}

				$this->Explain = new Explain($this->id, 2);

				$this->nbLikes = $this->getNbLikes();

				$this->originalLang = $data['original_lang_quote'];
			}
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