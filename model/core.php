<?php
/*
	~Quotrap
	Created : 4.6.14
	Core
*/
    require 'vendor/autoload.php';

session_start();
header('Content-Type: text/html; charset=UTF-8');

DEFINE('RATIO_POP_MULTIPLI', 0.99519804434435373165003884241728);

// connexion db
if($_SERVER["REMOTE_ADDR"] != "127.0.0.1"){
	// on heroku
    $urlClearDB = parse_url(getenv("CLEARDB_DATABASE_URL"));
	DEFINE('HOSTNAME', $urlClearDB["host"]);
	DEFINE('DBNAME', substr($urlClearDB["path"], 1));
	DEFINE('USER_DB', $urlClearDB["user"]);
	DEFINE('PASS_DB',$urlClearDB["pass"]);
	DEFINE('ROOT', '/kunden/homepages/45/d399347765/htdocs/quotrs/');
}else{
	// local
	$root = $_SERVER["DOCUMENT_ROOT"];
	if($root[strlen($root)-1] == "/"){
		$root = substr($root, 0, strlen($root)-1);
	}
	DEFINE('ROOT', $root);
	DEFINE('PROJECT_FOLDER', "/quotrs");
	DEFINE('HOSTNAME', 'localhost');
	DEFINE('DBNAME', 'db_quotrap');
	DEFINE('USER_DB', 'root');
	DEFINE('PASS_DB','');
}

    DEFINE('WEBROOT', ROOT.PROJECT_FOLDER);
    DEFINE('SALT_HASHIDS', "12309UJQODJ09ZA8ESQDJLQSJDAZEU");
    //DEFINE('FOLDER_IMGS', STATIC_URL.'/img');
    ////DEFINE('FOLDER_COVER_ALBUMS', FOLDER_IMGS.'/albums');



    /*
     * REQUIRING ALL CLASSES
     */
    require_once 'class.album.php';
    require_once 'class.artist.php';
    require_once 'class.db.php';
    require_once 'class.like.php';
    require_once 'class.quote.php';
    require_once 'class.song.php';
    require_once 'class.user.php';
?>
