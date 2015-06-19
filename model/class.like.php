<?php
	include_once 'class.db.php';
	include_once 'class.quote.php';
	include_once 'class.song.php';
	include_once 'class.compile.php';
	include_once 'class.user.php';
	Class Like{
		public $id;
		public $date;
		public $User;
		public $Quote;
		public $Song;
		public $Compile;

		public function __construct($idLike=null){
			if(!is_null($idLike)){
				$this->id = $idLike;
			}
		}

		public function like_exists(){
			$req = DB::$db->query('SELECT * FROM '.DB::$tableLikes.' WHERE id_like = '.$this->id.' LIMIT 1');
			return $req->fetch();
		}

		public function init(){
			if($this->like_exists()){
				$req = DB::$db->query('SELECT * FROM '.DB::$tableLikes.' WHERE id_like = '.$this->id.' LIMIT 1');
				$data = $req->fetch();

				$this->date = $data['date_like'];
				$this->User   = new User($data['id_user'], 2);
				if(!is_null($data['id_quote'])){
					$this->Quote = new Quote($data['id_quote']);
				}
				if(!is_null($data['id_song'])){
					$this->Song = new Song($data['id_song']);
				}
				if(!is_null($data['id_comp'])){
					$this->Compile = new Compile($data['id_comp']);
				}
			}
		}

		static function like_quote_exists_by_id($id, $idQuote){
			$req = DB::$db->query('SELECT * FROM '.DB::$tableLikes.' WHERE id_user = "'.$id.'" AND id_quote = "'.$idQuote.'" LIMIT 1');
			return $req->fetch();
		}

		static function delete_like($idLike){
			DB::$db->query('DELETE FROM `'.DB::$tableLikes.'` WHERE id_like = '.$idLike);
		}

		static function get_id_like_by_quote_and_id($id, $idQuote){
			$req = DB::$db->query('SELECT id_like AS result FROM '.DB::$tableLikes.' WHERE id_user = "'.$id.'" AND id_quote = "'.$idQuote.'" LIMIT 1');
			$data = $req->fetch();
			return $data['result'];
		}
	}

?>