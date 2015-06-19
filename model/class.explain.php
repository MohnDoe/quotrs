<?php

include_once 'class.db.php';

Class Explain{
	public $id;
	public $content;
	public $id_quote;

	public function __construct($id = null, $typeInit = 2){
		if(!is_null($id)){
			if($typeInit == 1){
				$this->id = $id;
			}else if($typeInit == 2){
				$this->id_quote = $id;
			}
			$this->init($typeInit);
		}
	}

	public function init($typeInit){
		if($typeInit == 1){
			if($data = $this->explain_exists()){
				$this->content = $data['content_explain'];
				$this->id_quote = $data['id_quote'];
			}
		}else if ($typeInit == 2){
			if($data = $this->explain_exists_by_quote()){
				$this->id = $data['id_explain'];
				$this->content = $data['content_explain'];
			}
		}
	}
	public function explain_exists(){
		$req = DB::$db->query('SELECT * FROM '.DB::$tableExplains.' WHERE id_explain = '.$this->id.' LIMIT 1');
		return $req->fetch();
	}

	public function explain_exists_by_quote(){
		$req = DB::$db->query('SELECT * FROM '.DB::$tableExplains.' WHERE id_quote = '.$this->id_quote.' LIMIT 1');
		return $req->fetch();
	}
}

?>