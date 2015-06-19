<?php
	include_once 'class.quote.php';
	Class Compile{

		public $id;
		public $date;
		public $title;
		public $slug;
		public $view;
		public $num;
		public $resume;
		public $description;
		public $code_type_comp;
		public $lien;

		public $text_type_comp;
		public $part_lien_type_comp;

		public $quotes;
		public $date_formated;

		public $url_image;

		public function __construct($idCompile = null){
			if(!is_null($idCompile)){
				$this->id = $idCompile;
				$this->init();
			}

		}

		public function compile_exists(){
			$req = DB::$db->query('SELECT * FROM '.DB::$tableCompiles.' WHERE id_comp = '.$this->id.' LIMIT 1');
			return $req->fetch();
		}

		public function init(){
			if($this->compile_exists()){
				$req = DB::$db->query('SELECT * FROM '.DB::$tableCompiles.' WHERE id_comp = '.$this->id.' LIMIT 1');
				
				$data = $req->fetch();

				$this->date           = $data['date_comp'];
				$this->title          = $data['title_comp'];
				$this->slug           = $data['slug_comp'];
				$this->view           = $data['view_comp'];
				$this->num            = $data['num_comp'];
				$this->description    = $data['description_comp'];
				$this->resume         = $data['resume_comp'];
				$this->code_type_comp = $data['type_comp'];

				switch ($this->code_type_comp) {
					case 2:
						$this->text_type_comp = "Chronique";
						$this->part_lien_type_comp = "chronique";
						break;
					
					default:
						$this->text_type_comp = "Sélection";
						$this->part_lien_type_comp = "selection";
						break;
				}

				$this->lien = $this->part_lien_type_comp.'/'.$this->num.'-'.$this->slug;

				$this->date_formated = DB::formate_sql_date($this->date);
				
				$this->quotes = $this->getQuotes();

				$this->url_image = $this->quotes[rand(0, count($this->quotes)-1)]->url_image;
			}
		}

		public function getQuotes(){
			$req = DB::$db->query('SELECT * FROM '.DB::$tableIsInCompile.' WHERE id_comp = '.$this->id);
			$data = $req->fetchAll();
			$d = Array();
			for ($i=0; $i < count($data) ; $i++) {
				$d[] = new Quote($data[$i]['id_quote']);
			}
			return $d;

		}

		public function initLast(){
			$req = DB::$db->query('SELECT id_comp AS result FROM '.DB::$tableCompiles.' WHERE is_public_comp = 1 ORDER BY date_comp DESC LIMIT 1');
			$data = $req->fetch();
			$this->id = $data['result'];
			$this->init();
		}

		public function is_valid(){
			return (!is_null($this->title) AND !is_null($this->date));
		}

		public function add_view(){
			DB::$db->query('UPDATE `compile_quotes` SET `view_comp`=view_comp+1 WHERE id_comp = '.$this->id);
		}

		static function get_all_compiles(){
			$req = DB::$db->query('SELECT id_comp FROM '.DB::$tableCompiles.' WHERE is_public_comp = 1 ORDER BY date_comp DESC');
			$d = [];
			while($data = $req->fetch()){
				$d[] = new Compile($data['id_comp']);
			}
			return $d;
		}

		static function get_lasts_selections(){
			$req = DB::$db->query('SELECT id_comp FROM '.DB::$tableCompiles.' WHERE is_public_comp = 1 AND type_comp = 1 ORDER BY date_comp DESC LIMIT 3');
			$d = [];
			while($data = $req->fetch()){
				$d[] = new Compile($data['id_comp']);
			}
			return $d;
		}

		static function get_nb_selections(){
			$req = DB::$db->query('SELECT COUNT(*) AS result FROM '.DB::$tableCompiles.' WHERE is_public_comp = 1 AND type_comp = 1');
			$data = $req->fetch();
			return $data['result'];

		}

		static function get_compile_by_type($type, $num){
			switch ($type) {
				case 'chronique':
					$typeCode = 2;
					break;
				
				default:
					$typeCode = 1;
					break;
			}

			$req = DB::$db->query('SELECT id_comp FROM '.DB::$tableCompiles.' WHERE is_public_comp = 1 AND type_comp = '.$typeCode.' AND num_comp = '.$num.' ORDER BY date_comp DESC');
			$data = $req->fetch();

			return new Compile($data['id_comp']);
		}

	}

?>