<?php
/*
	~Quotrap
	Created : 4.6.14
	Core
*/

session_start();
header('Content-Type: text/html; charset=UTF-8');

DEFINE('RATIO_POP_MULTIPLI', 0.99519804434435373165003884241728);

// connexion db
if($_SERVER["REMOTE_ADDR"] != "127.0.0.1"){
	// online
	DEFINE('PREFIX_URL_RELATIF', '');
	DEFINE('DOMAINE_COOKIE', 'quotrs.fr');
	DEFINE('PROJECT_FOLDER', "");
	DEFINE('HOSTNAME', 'db531335009.db.1and1.com');
	DEFINE('DBNAME', 'db531335009');
	DEFINE('USER_DB', 'dbo531335009');
	DEFINE('PASS_DB','PhEP8("QVX@=dM+');
	DEFINE('ROOT', '/kunden/homepages/45/d399347765/htdocs/quotrs/');

	DEFINE('STATIC_URL', '/static');
}else{
	// local
	$root = $_SERVER["DOCUMENT_ROOT"];
	if($root[strlen($root)-1] == "/"){
		$root = substr($root, 0, strlen($root)-1);
	}
	DEFINE('DOMAINE_COOKIE', null);
	DEFINE('DOMAINE_COOKIE_JOHTO', null);
	DEFINE('ROOT', $root);
	DEFINE('PROJECT_FOLDER', "/rap-site");
	DEFINE('HOSTNAME', 'localhost');
	DEFINE('DBNAME', 'db_quotrap');
	DEFINE('USER_DB', 'root');
	DEFINE('PASS_DB','');
	DEFINE('STATIC_URL', '');
	DEFINE('PREFIX_URL_RELATIF', '.');
}
DEFINE('WEBROOT', ROOT.PROJECT_FOLDER);
DEFINE('FOLDER_IMGS', STATIC_URL.'/img');
DEFINE('FOLDER_COVER_ALBUMS', FOLDER_IMGS.'/albums');

// mailChimp
DEFINE('MC_API_KEY', '30a308783a9b275034918218453a741a-us7');
DEFINE('MC_IDLIST_NEWSLETTER', 'c7700bbae7');

$arrayWordsExplain = Array("Intéressant, dis-m'en plus !", "Continuez Jackson, vous m'intéressez !", "Continuez Jackson, vous m'intéressez !");


$arrayCorrespondLang = Array("fr_FR" => "Français", "en_US" => "English");
$arrayCorrespondTranslateText = Array("fr_FR" => "Traduire en", "en_US" => "Translate to");

$availableLangs = Array("fr_FR", "en_US");
?>