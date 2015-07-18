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

    $app->get('/quote/:hashID', function($hashID) use($app){
        $Quote = new Quote($hashID, array(
            'init_artist' => true,
            'init_song' => true
        ));
        if($Quote->is_valid){
            //$app->array_meta_page['titlePage'] .= " - ".$Quote->Artist->name;
            $app->render(
                'quotes/base/index.php',
                array( 'Quote' => $Quote)
                );
        }

    });
    $app->get('/artist/:idArtist', function($idArtist) use($app){
        $Artist = new Artist($idArtist);
        if($Artist->is_valid){
            $app->render(
                'artists/base/index.php',
                array('Artist' => $Artist)
            );
        }
    });

?>

<?php
    $app->render('assets/head-html.php', $app->array_meta_page);
    $app->render('base/top.php');
    $app->run();
    $app->render('assets/footer-html.php');

?>
