<?php
define('SERVER_ROOT' , '/var/www/procedural');
define('SITE_ROOT' , 'http://procedural.dev');

/**
 * Fetch the router
 */
ob_start();
require_once(SERVER_ROOT . '/controllers/' . 'router.php');
ob_end_flush();