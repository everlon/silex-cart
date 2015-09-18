<?php
/**
* Author: Everlon Passos (dev@everlon.com.br)
* Date: update 11/08/2015 10:48:36
*
**/
    require_once __DIR__.'../src/vendor/autoload.php';
    require_once __DIR__.'../config/config.php';
    require_once __DIR__.'../config/routes.php';



    # Redirecionamento em caso de ERRO
    $app->error(function(\Exception $e, $code) use ($app) {
        if ($app['debug']) { return '<h1>'.$code.'</h1>'; }
    });



    //$app['http_cache']->run();
    $app->run();