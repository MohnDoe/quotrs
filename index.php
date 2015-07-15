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

    $app->get('/quote/:hashID', function($hashID) use($app){
        $Quote = new Quote($hashID, array(
            'init_artist' => true,
            'init_song' => true
        ));
        if($Quote->is_valid){
            $app->render(
                'quotes/base/index.php',
                array( 'Quote' => $Quote)
                );
        }

    });

?>

<?php
    $app->render('assets/head-html.php', array(
        'titlePage' => "Poster une citation"
    ));
    $app->run();
    $app->render('assets/footer-html.php');

?>
