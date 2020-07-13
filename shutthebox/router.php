<?php
use ArmoredCore\Facades\Router;

/****************************************************************************
 *  URLEncoder/HTTPRouter Routing Rules
 *  Use convention: controllerName@methodActionName
 ****************************************************************************/

Router::get('/','MainController/indexhead');
Router::get('home/','MainController/indexhead');
Router::get('home/menu','MainController/index');

Router::get('game/menu','GameController/menu');
Router::get('game/game','GameController/game');

Router::resource('user', 'UserController');

/************** End of URLEncoder Routing Rules ************************************/