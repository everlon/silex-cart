<?php
/**
 * Author: Everlon Passos (dev@everlon.com.br)
 * Date update: 11/08/2015 10:09:03
 */
    # Fun��es b�sicas da Aplica��o
    $base = $app['controllers_factory'];



    # Tela de entrada
    $base->get('/', function() use ($app) {
        // if(!$app['session']->get('is_user')) { return $app['twig']->render('login.twig'); }
        return $app['twig']->render('home.twig');
    })
        ->bind('home');



    return $base;