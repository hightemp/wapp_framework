<?php

namespace Hightemp\WappTestSnotes\Modules\CBootstrapTable\Lib\Tags;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Tags\TagTable;
use Hightemp\WappTestSnotes\Modules\CBootstrapTable\Lib\Tags\TagBootstrapTable;

class TagBootstrapTableAJAX extends BaseTag
{
    public function __invoke($aEntity)
    {
        $sID = $aEntity["sID"];
        $sHeaders = json_encode($aEntity["aHeaders"]);
        $sAttrs = json_encode($aEntity["aAttrs"]);
        $aURLs = json_encode($aEntity["aURLs"]);

        echo <<<HTML
<script>
window.oTables || (window.oTables = {});
window.oTables['{$sID}'] = {
    "aAttrs": $sAttrs,
    "aHeaders": $sHeaders,
    "aURLs": $aURLs,
}
BootstrapAjaxTable.fnBuild('{$sID}');
</script>
<table id="{$sID}"></table>
HTML;
    }
}