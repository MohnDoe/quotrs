<?php
    include_once 'core.php';

    Class User
    {
        public $id;
        public $date_firstseen;
        public $type;
        public $ip;
        public $guestid;


        public function __construct ($id = NULL, $type = 1)
        {
            if (!is_null ($id)) {
                if ($type == 1) {
                    $this->guestid = $id;
                } else if ($type == 2) {
                    $this->id = $id;
                }
                $this->type = $type;
                $this->init ();
            }
        }

        public function init ()
        {
            if ($this->type == 1) {
                $req = DB::$db->query ('SELECT * FROM ' . DB::$tableUsers . ' WHERE guestid_user = "' . $this->guestid . '" LIMIT 1');
                if ($data = $req->fetch ()) {
                    $this->id = $data['id_user'];
                    $this->date_firstseen = $data['date_firstseen_user'];
                    $this->ip = $data['ip_user'];
                } else {
                    self::create_guest ($this->guestid);
                    $req = DB::$db->query ('SELECT * FROM ' . DB::$tableUsers . ' WHERE guestid_user = "' . $this->guestid . '" LIMIT 1');
                    if ($data = $req->fetch ()) {
                        $this->id = $data['id_user'];
                        $this->date_firstseen = $data['date_firstseen_user'];
                        $this->ip = $data['ip_user'];
                    }
                }
            } else if ($this->type == 2) {
                $req = DB::$db->query ('SELECT * FROM ' . DB::$tableUsers . ' WHERE id_user = "' . $this->id . '" LIMIT 1');
                if ($data = $req->fetch ()) {
                    $this->guestid = $data['guestid_user'];
                    $this->date_firstseen = $data['date_firstseen_user'];
                    $this->ip = $data['ip_user'];
                }
            }
        }

        static function create_guest ($id)
        {
            DB::$db->query ('INSERT INTO `' . DB::$tableUsers . '`(`date_firstseen_user`, `type_user`, `ip_user`, `guestid_user`) VALUES (NOW(), 1, "' . $_SERVER["REMOTE_ADDR"] . '","' . $id . '")');
        }

        public function setLoveQuote ($idQuote)
        {
            $Quote = new Quote($idQuote);
            if ($Quote->quote_exists ()) {
                if (!Like::like_quote_exists_by_id ($this->id, $idQuote)) {
                    DB::$db->query ('INSERT INTO `' . DB::$tableLikes . '`(`date_like`, `id_user`, `id_quote`) VALUES (NOW(),"' . $this->id . '",' . $idQuote . ')');
                    return $Quote->getNbLikes ();
                } else {
                    $idLike = Like::get_id_like_by_quote_and_id ($this->id, $idQuote);
                    Like::delete_like ($idLike);
                    return $Quote->getNbLikes ();
                }
            } else {
                return -1;
            }
        }

        public function likes_quote ($idQuote)
        {
            $Quote = new Quote($idQuote);
            if ($Quote->quote_exists ()) {
                $req = DB::$db->query ('SELECT * FROM ' . DB::$tableLikes . ' WHERE id_quote = ' . $idQuote . ' AND id_user = "' . $this->id . '" LIMIT 1');
                return $req->fetch ();
            } else {
                return false;
            }
        }
    }

?>