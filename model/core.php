<?php
    /*
        ~Quotrap
        Created : 4.6.14
        Core
    */

    ini_set('xdebug.var_display_max_depth', 5);
    ini_set('xdebug.var_display_max_children', 256);
    ini_set('xdebug.var_display_max_data', 1024);
    session_start ();
    header ('Content-Type: text/html; charset=UTF-8');

    DEFINE('RATIO_POP_MULTIPLI', 0.99519804434435373165003884241728);

    // connexion db
    if ($_SERVER["REMOTE_ADDR"] != "127.0.0.1") {
        // on heroku
        // database
        $urlClearDB = parse_url (getenv ("CLEARDB_DATABASE_URL"));
        DEFINE('HOSTNAME', $urlClearDB["host"]);
        DEFINE('DBNAME', substr ($urlClearDB["path"], 1));
        DEFINE('USER_DB', $urlClearDB["user"]);
        DEFINE('PASS_DB', $urlClearDB["pass"]);

        // file + static
        DEFINE('S3_BUCKET_NAME', getenv ('S3_BUCKET_NAME'));
        DEFINE('AWS_ACCESS_KEY_ID', getenv ('AWS_ACCESS_KEY_ID'));
        DEFINE('AWS_SECRET_ACCESS_KEY', getenv ('AWS_SECRET_ACCESS_KEY'));

        DEFINE('DOCUMENT_ROOT', "http://qtrs.s3-website-eu-west-1.amazonaws.com");

    } else {
        // local

        // AWS S3
        DEFINE('S3_BUCKET_NAME', "qtrs");
        DEFINE('AWS_ACCESS_KEY_ID', "AKIAITYA6XFVP7OIETTA");
        DEFINE('AWS_SECRET_ACCESS_KEY', "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");

        // database
        DEFINE('HOSTNAME', 'localhost');
        DEFINE('DBNAME', 'db_quotrap');
        DEFINE('USER_DB', 'root');
        DEFINE('PASS_DB', '');

        DEFINE('DOCUMENT_ROOT', $_SERVER["DOCUMENT_ROOT"]."/quotrs");
    }

    DEFINE('ROOT', "qtrs.s3-website-eu-west-1.amazonaws.com");
    DEFINE('WEBROOT', "http://" . ROOT . "/");
    // FOLDERS
    DEFINE('IMAGES_FOLDER', 'img');
    DEFINE('ALBUMS_COVERS_FOLDER', IMAGES_FOLDER . '/albums_cover');
    DEFINE('ARTISTES_IMAGES_FOLDER', IMAGES_FOLDER . '/artistes_images');
    DEFINE('USERS_UMAGES_FOLDER', IMAGES_FOLDER . '/users_images');

    DEFINE('SALT_HASHIDS', "12309UJQODJ09ZA8ESQDJLQSJDAZEU");

    DEFINE('AWS_S3_REGION', 'eu-west-1');
    require DOCUMENT_ROOT.'/vendor/autoload.php';

    
    $_AWS_S3_CLIENT = Aws\S3\S3Client::factory (
        [
            'key'    => AWS_ACCESS_KEY_ID,
            'secret' => AWS_SECRET_ACCESS_KEY
        ]);


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
