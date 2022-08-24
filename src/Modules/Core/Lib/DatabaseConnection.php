<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib;

use Hightemp\WappTestSnotes\Modules\Core\Lib\Database\Adapters\BaseAdapter;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Database\Adapters\RedBeans;

class DatabaseConnection
{
    public $sDeafultAdapterClass = RedBeans::class;
    public $sAdapterClass = null;
    /** @var BaseAdapter|RedBeans $oAdapter */
    public $oAdapter = null;

    public function __construct(DatabaseConnectionOptions $oDBOptions, $sAdapterClass=null)
    {
        $this->sAdapterClass = $sAdapterClass ?: $this->sDeafultAdapterClass;
        $this->oAdapter = new $this->sAdapterClass($oDBOptions);
    }
}
