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
        DEFINE('URL_BASE_HREF', '/');
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

        DEFINE('DOCUMENT_ROOT', "");

    } else {
        // local
        DEFINE('URL_BASE_HREF', '/quotrs/');

        // AWS S3
        DEFINE('S3_BUCKET_NAME', "qtrs");
        DEFINE('AWS_ACCESS_KEY_ID', "AKIAITYA6XFVP7OIETTA");
        DEFINE('AWS_SECRET_ACCESS_KEY', "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");

        // database
        // DEFINE('HOSTNAME', 'localhost');
        // DEFINE('DBNAME', 'db_quotrap');
        // DEFINE('USER_DB', 'root');
        // DEFINE('PASS_DB', '');

        //try heroku connection on local
        

        $urlClearDB = parse_url ("mysql://bfbb2438dbe800:2471445f@us-cdbr-iron-east-02.cleardb.net/heroku_3e806d4b32c7bff?reconnect=true");
        DEFINE('HOSTNAME', $urlClearDB["host"]);
        DEFINE('DBNAME', substr ($urlClearDB["path"], 1));
        DEFINE('USER_DB', $urlClearDB["user"]);
        DEFINE('PASS_DB', $urlClearDB["pass"]);


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
    
    DEFINE('ACCESS_TOKEN_GENIUS_API', "uWibAg6C7pcdQpvynsw8zk-fqo7crN5-bckfL0rJ1_SOTRM5BOTKygD4Q-e_ppDz");
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


    $array_meta_page = array(
        'titlePage' => "Quotrs."
    );

    function CallAPI($method, $url, $data = false)
    {
        $curl = curl_init();

        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }
