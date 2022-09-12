<?php

namespace Hightemp\WappFramework\Modules\CBootstrapTable\Lib\Tags\HTML;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;
use Hightemp\WappFramework\Modules\Core\Lib\Tags\TagTable;
use Hightemp\WappFramework\Modules\CBootstrapTable\Lib\Tags\TagBootstrapTable;

class BootstrapTableAJAX extends BaseHTMLHelper
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