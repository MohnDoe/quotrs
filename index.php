<?php
    /**
     * Created by PhpStorm.
     * User: Personne
     * Date: 20/06/2015
     * Time: 16:13
     */

    // require autoload / composer
    require './model/core.php';
    require './vendor/autoload.php';

    // INIT SLIM
    \Slim\Slim::registerAutoloader();

    $app = new \Slim\Slim([
          'debug' => true,
          'templates.path' => './view/'
                          ]);

    //home page
    $app->get('/', function() use ($app){
        $app->render(
            'home/index.php',
            array(
                'app' => $app
                )
            );
    })->name('home');

    //page create quote
    $app->get('/quotes/create', function() use ($app, $ARRAY_META_PAGE){

        $ARRAY_META_PAGE['title'] .= " - Poster une citation";
        $ARRAY_META_PAGE['twitter_card']['card'] = "summary_large_image";
        $ARRAY_META_PAGE['twitter_card']['image'] = "";
        $app->render('assets/head-html.php', $ARRAY_META_PAGE);
        $app->render('base/top.php', array('app'=>$app));
        
        $app->render(
            'quotes/base/index.php',
            array(
                'mode' => 'create',
                'app' => $app
                )
            );
    })->name('createQuoteUrl');

    //page quote
    $app->get('/quotes/:hashID', function($hashID) use($app, $ARRAY_META_PAGE){
        $Quote = new Quote($hashID, array(
            'init_artist' => true,
            'init_song' => true
        ));
        if($Quote->is_valid){
            $ARRAY_META_PAGE['title'] .= " - Citation de ".$Quote->Artist->name;
            $ARRAY_META_PAGE['twitter_card']['card'] = "summary_large_image";
            $ARRAY_META_PAGE['twitter_card']['image'] = $Quote->url_image;
            $app->render('assets/head-html.php', $ARRAY_META_PAGE);
            $app->render('base/top.php', array('app'=>$app));

            $Quote->incrementPopularity();
            $app->render(
                'quotes/base/index.php',
                array(
                    'Quote' => $Quote,
                    'mode' => 'quote',
                    'app' => $app
                )
            );
        }
    })->name('quoteUrl');

    //page artist
    $app->get('/artists/:idArtist', function($idArtist) use($app, $ARRAY_META_PAGE){
        $Artist = new Artist($idArtist);
        if($Artist->is_valid){
            $ARRAY_META_PAGE['title'] .= " - ".$Artist->name;
            $ARRAY_META_PAGE['twitter_card']['card'] = "summary_large_image";
            $ARRAY_META_PAGE['twitter_card']['image'] = $Artist->url_image;
            $app->render('assets/head-html.php', $ARRAY_META_PAGE);
            $app->render('base/top.php', array('app'=>$app));

            $app->render(
                'artists/base/index.php',
                array('Artist' => $Artist, 'app' => $app)
            );
        }
    })->name('artistUrl');

    //page album
    $app->get('/albums/:idAlbum', function($idAlbum) use($app){
        $Album = new Album($idAlbum);
        if($Album->is_valid){
            $ARRAY_META_PAGE['title'] .= " - \"".$Album->title."\" de ".$Album->Artist->name;
            $ARRAY_META_PAGE['twitter_card']['card'] = "summary_large_image";
            $ARRAY_META_PAGE['twitter_card']['image'] = $Album->url_image;
            $app->render('assets/head-html.php', $ARRAY_META_PAGE);
            $app->render('base/top.php', array('app'=>$app));

            $app->render(
                'albums/base/index.php',
                array('Album' => $Album, 'app' => $app)
            );
        }
    })->name('albumUrl');

?>

<?php
    $app->run();
    $app->render('assets/footer-html.php');

?>
