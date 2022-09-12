<?php

namespace Hightemp\WappFramework\Modules\Core\Lib;

use RedBeanPHP\Logger as Logger;

class MigrationLogger implements Logger {

    private $file;

    public function __construct( $file ) {
        $this->file = $file;
    }

    public function log() {
        $query = func_get_arg(0);
        if (preg_match( '/^(CREATE|ALTER)/', $query )) {
            file_put_contents( $this->file, "{$query};\n",  FILE_APPEND );
        }
    }
}