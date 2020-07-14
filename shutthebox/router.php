<?php
use ArmoredCore\Facades\Router;

/****************************************************************************
 *  URLEncoder/HTTPRouter Routing Rules
 *  Use convention: controllerName@methodActionName
 ****************************************************************************/

Router::get('/','MainController/indexhead');
Router::get('home/','MainController/indexhead');
Router::get('home/menu','MainController/index');
Router::get('home/top','MainController/top');

Router::get('game/menu','GameController/menu');
Router::get('game/game','GameController/game');

Router::resource('user', 'UserController');

Router::resource('backoffice', 'BackofficeController');

/************** End of URLEncoder Routing Rules ************************************/