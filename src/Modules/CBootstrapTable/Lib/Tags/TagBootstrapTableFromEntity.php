<?php

namespace Hightemp\WappTestSnotes\Modules\CBootstrapTable\Lib\Tags;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Tags\TagTable;
use Hightemp\WappTestSnotes\Modules\CBootstrapTable\Lib\Tags\TagBootstrapTable;

class TagBootstrapTableFromEntity extends BaseTag
{
    public function __invoke($aEntity)
    {
        return (new TagBootstrapTable())(
            $aEntity["aData"],
            $aEntity["aHeaders"],
            $aEntity["aAttrs"]
        );
    }
}