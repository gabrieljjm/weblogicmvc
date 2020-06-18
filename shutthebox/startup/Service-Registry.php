<?php
/**
 * Created by PhpStorm.
 * User: smendes
 * Date: 11-04-2017
 * Time: 11:31
 */

use ArmoredCore\WebObjects\Asset;
use ArmoredCore\WebKernel\Services;

// Asset manager configuration and loading

$assetBundles = [
    'base' => [
        Asset::js ( 'bootstrap.min.js' ),
        Asset::css ( 'bootstrap.min.css' ) ,
        Asset::css ( 'stickyfooter.css' ) ,
        Asset::css ( 'signin.css' )
    ],
    'form-controls'	=> Asset::css('form.css'),
];


$config = [
    'collections' => $assetBundles,
    'autoload' => ['base'],
    'pipeline' => false,
    'public_dir' => WL_PUBLIC_FOLDER_URL
];

$assetManager = new Stolz\Assets\Manager($config);

/**
 * Debugger configuration and loading
 */

Services::set('Assetmanager', $assetManager);
Services::set('ErrorManager', 'ArmoredCore\ErrorManager');

Services::run();




