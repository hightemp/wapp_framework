<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Exceptions;

class MethodNotDefinedException extends \Exception {
    function __construct() { $this->message = 'Метод не объявлен'; }
}