<?php

define('ROOT_PATH', __DIR__);
define('DEBUG', getenv('DEBUG'));

if (defined('DEBUG') && DEBUG) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

require_once("vendor/autoload.php");
require_once("src/index.php");