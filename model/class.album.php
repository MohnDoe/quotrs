<?php
    require_once 'core.php';
	Class Album{

		public $id;
		public $title;
		public $date;
		public $urlPochetteBW;
		public $urlPochetteN;
		public $urlAmazone;
		public $urlITunes;
		public $urlOther;

		public $Artist;

		public function __construct($idAlbum = null){
			if(!is_null($idAlbum) AND $idAlbum != 0 AND $idAlbum != '0'){
				$this->id = $idAlbum;
				$this->init();
			}
		}

		public function init(){

			if($this->album_exists()){
				$req = DB::$db->query('SELECT * FROM '.DB::$tableAlbums.' WHERE id_album = '.$this->id.' LIMIT 1');
				$data = $req->fetch();

				$this->title         = $data['title_album'];
				$this->date          = $data['date_album'];
				// $this->urlPochetteBW = '/'.$this->id.'/n.jpg';
				$this->urlPochetteBW = '/'.$this->id.'/bw.jpg';
				$this->urlPochetteN  = '/'.$this->id.'/n.jpg';
				$this->urlAmazone    = $data['url_amazone_album'];
				$this->urlITUnes     = $data['url_itunes_album'];
				$this->urlOther      = $data['url_other_album'];
				$this->Artist        = new Artist($data['id_artist']);
			}

		}

		public function album_exists(){
			$req = DB::$db->query('SELECT * FROM '.DB::$tableAlbums.' WHERE id_album = "'.$this->id.'" LIMIT 1');
			return $req->fetch();
		}

	}

?>