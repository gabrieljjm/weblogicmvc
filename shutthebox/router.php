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

Router::get('account/menu','AccountController/menu');
Router::get('account/saldo','AccountController/insertRechargeBalance');


Router::get('account/movimentos','AccountController/movimentos');
Router::post('account/saldo','AccountController/insertRechargeBalance');
Router::post('game/menu','GameController/menu');
Router::post('game/game','GameController/game');

Router::resource('user', 'UserController');
Router::resource('backoffice', 'BackofficeController');

/************** End of URLEncoder Routing Rules ************************************/