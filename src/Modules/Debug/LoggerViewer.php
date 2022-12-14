<?php

define('ROOT_PATH', dirname(dirname(dirname(__DIR__))));

require_once(ROOT_PATH."/src/Modules/Core/Lib/Config.php");
require_once(ROOT_PATH."/src/Modules/Core/Lib/BaseLogger.php");
require_once(ROOT_PATH."/src/Modules/Core/Lib/BaseProject.php");
require_once(ROOT_PATH."/src/Modules/Core/Lib/BaseModule.php");
require_once(ROOT_PATH."/src/Modules/Core/Helpers/Utils.php");
require_once(ROOT_PATH."/src/Modules/Debug/Module.php");
require_once(ROOT_PATH."/src/Project.php");
require_once(ROOT_PATH."/src/Modules/Debug/Loggers/SimpleJSONLLogger.php");

use \Hightemp\WappFramework\Modules\Core\Lib\Config;
use \Hightemp\WappFramework\Modules\Debug\Loggers\SimpleJSONLLogger;
use \Hightemp\WappFramework\Modules\Debug\Module;
use \Hightemp\WappFramework\Project;

Project::$aModules = [Module::class];
Config::fnInit();
$aLogFiles = SimpleJSONLLogger::fnGetFiles();
$aLogFiles = array_map(function ($sI) { return basename($sI); }, $aLogFiles);
$aLogFiles = array_reverse($aLogFiles);

$aLines = [];

if (isset($_GET['c'])) {
    SimpleJSONLLogger::fnCleanFiles();
    header("Location: ?");
}
if (isset($_GET['f'])) {
    $sFilePath = SimpleJSONLLogger::fnPrepareFilePath($_GET['f']);
    if (!is_file($sFilePath)) {
        header("Location: ?");
    }
    $aLines = file($sFilePath);
    $aLines = array_map(function($sI) { return json_decode($sI, true); }, $aLines);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple logger viewer</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row" style="border-bottom: 2px solid rgba(0,0,0,0.1)">
            <div class="col">
            </div>
            <div class="col-auto">
                <a class="btn btn-danger" href="?c=1" role="button">????????????????</a>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <div class="list-group w-100">
                    <?php foreach ($aLogFiles as $sFilePath): ?>
                    <a 
                        href="?f=<?php echo urlencode($sFilePath); ?>" 
                        class="list-group-item list-group-item-action <?php echo $sFilePath==$_GET['f'] ? 'active' : '' ?>"
                    ><?php echo date("Y-m-d H:i:s", basename($sFilePath, ".jsonl")); ?></a>
                    <?php endforeach ?>
                </div>
            </div>

            <div class="col-10">

                <table class="table table-bordered" style="width:100%;">
                    <thead>
                        <tr>
                            <th scope="col" width="50">#</th>
                            <th scope="col" width="70">????????</th>
                            <th scope="col">??????</th>
                            <th scope="col">??????????????????</th>
                            <th scope="col" width="60%">JSON</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($aLines as $iI => $aRow): ?>
                            <?php if ($iI===0): ?>
                                <tr class="">
                                    <td colspan="5">
                                        <details>
                                            <summary>???????????????????? ?? ??????????????</summary>
                                            <pre><?php echo json_encode($aRow, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?></pre>
                                        </details>
                                    </td>
                                </tr>
                            <?php else: ?>
                            <tr class="table-<?php echo $aRow[0]; ?>">
                                <th scope="row"><?php echo $iI; ?></th>
                                <td><?php echo $aRow[2]; ?></td>
                                <td><?php echo $aRow[0]; ?></td>
                                <td><?php echo $aRow[3]; ?></td>
                                <td style="overflow:auto">
                                    <code class="code">
                                    <pre><?php echo htmlspecialchars(json_encode($aRow[4], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></pre>
                                    </code>
                                </td>
                            </tr>
                            <?php endif ?>
                        <?php endforeach ?>
                    </tbody>
                </table>
            
            </div>
        </div>
    </div>

</body>
</html>

<style>
body, html { font-size: 10px; }
* { border-radius: 0px !important; }
table td {
    text-align: left;
}
pre {
    background: rgba(0,0,0,0.04);
    padding: 5px;
    word-break: break-all;
    font-size: 12px;
}
table {
    table-layout: fixed;
}
.code {
    overflow: auto;
    max-height: 300px;
}
</style>