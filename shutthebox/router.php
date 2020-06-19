<?php
/**
 * Created by PhpStorm.
 * User: smendes
 * Date: 02-05-2016
 * Time: 11:18
 */
use ArmoredCore\Facades\Router;

/****************************************************************************
 *  URLEncoder/HTTPRouter Routing Rules
 *  Use convention: controllerName@methodActionName
 ****************************************************************************/

Router::get('/','MainController/indexhead');
Router::get('home/','MainController/indexhead');
Router::get('home/inicio','MainController/index');

Router::get('home/login','MainController/login');
Router::post('home/login','MainController/authenticate');

Router::get('home/perfil','MainController/perfil');
Router::post('home/perfil','MainController/update');

Router::get('home/logout','MainController/logout');

Router::get('game/menu','GameController/menu');
Router::get('game/game','GameController/game');

Router::resource('backoffice', 'UserController');

/*
Router::resource('book', 'BookController');
*/

/************** End of URLEncoder Routing Rules ************************************/