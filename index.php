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
          'templates.path' => './view'
                          ]);

    $app->group('/', function() use($app){
        $app->render('assets/head-html.php', array(
            'titlePage' => "Coucou"
        ));
        $app->get('/', function() use($app){
            $app->render('post-quote-form.php');
        });
        $app->render('assets/footer-html.php');
    });

?>

<?php
    $app->run();
?>

