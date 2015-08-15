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

    $app->array_meta_page = $array_meta_page;

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
    $app->get('/quotes/create', function() use ($app){
        $app->render(
            'quotes/base/index.php',
            array(
                'mode' => 'create',
                'app' => $app
                )
            );
    })->name('createQuoteUrl');

    //page quote
    $app->get('/quotes/:hashID', function($hashID) use($app){
        $Quote = new Quote($hashID, array(
            'init_artist' => true,
            'init_song' => true
        ));
        if($Quote->is_valid){
            //$app->array_meta_page['titlePage'] .= " - ".$Quote->Artist->name;
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
    $app->get('/artists/:idArtist', function($idArtist) use($app){
        $Artist = new Artist($idArtist);
        if($Artist->is_valid){
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
            $app->render(
                'albums/base/index.php',
                array('Album' => $Album, 'app' => $app)
            );
        }
    })->name('albumUrl');

?>

<?php
    $app->render('assets/head-html.php');
    $app->render('base/top.php', array('app'=>$app));
    $app->run();
    $app->render('assets/footer-html.php');

?>
