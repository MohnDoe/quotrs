<?php
/**
 * Created by PhpStorm.
 * User: Personne
 * Date: 21/06/2015
 * Time: 13:58
 */

    require '../model/core.php';

    // INIT SLIM
    \Slim\Slim::registerAutoloader();

    $app = new \Slim\Slim([
        'debug' => true,
    ]);


    // CALLS

    // CALLS ON QUOTES

    /*
     * Va chercher une citation par son HashID
     */
    $app->get('/quotes/:hashid', function($hashid) use($app) {
        $Quote = new Quote($hashid);
        if($Quote->quote_exists()){
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo $Quote->toJSON();
        }else{
            $app->response->setStatus(404);
            $json = [];
            $json['error']['type'] = 404;
            $json['error']['text'] = 'No such quote.';
            echo json_encode($json);
        }
    });
    $app->get('/quotes/artist/:idArtist', function ($idArtist) use($app){
        $Artist = new Artist($idArtist);
        if($Artist->artist_exists()){
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');

            $QuotesArtist = $Artist->getQuotes();


            $json = [];
            $json['count'] = count($QuotesArtist);

            foreach($QuotesArtist as $Quote){
                $json['quotes'][] = $Quote->toArray();
            }
            echo json_encode($json);
        }else{
            $app->response->setStatus(404);
            $json = [];
            $json['error']['type'] = 404;
            $json['error']['text'] = 'No such artist.';
            echo json_encode($json);
        }
    });

    $app->run();