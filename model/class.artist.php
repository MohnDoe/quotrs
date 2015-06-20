<?php
    require_once 'core.php';

Class Artist{
	public $id;
	public $name;
	public $description;
	public $urlPicture;
	public $urlFacebook;
	public $urlTwitter;
	public $urlSite;
	public $urlOther;

	function __construct($idArtist = null){
		if(!is_null($idArtist)){
			$this->id = $idArtist;
			/* INITIALISATION */
			$this->init();
		}
	}

	public function init(){
		if($this->artist_exists()){
			$req = DB::$db->query('SELECT * FROM '.DB::$tableArtists.' WHERE id_artist = '.$this->id.' LIMIT 1');
			$data = $req->fetch();

			$this->name        = $data['nom_artist'];
			$this->description = $data['description_artist'];
			$this->urlPicture  = $data['url_picture_artist'];
			$this->urlFacebook = $data['url_facebook_artist'];
			$this->urlTwitter  = $data['url_twitter_artist'];
			$this->urlSite     = $data['url_site_artist'];
			$this->urlOther    = $data['url_other_artist'];
		}
	}

	public function artist_exists(){
		$req = DB::$db->query('SELECT * FROM '.DB::$tableArtists.' WHERE id_artist = '.$this->id.' LIMIT 1');
		return $req->fetch();
	}

}

?>