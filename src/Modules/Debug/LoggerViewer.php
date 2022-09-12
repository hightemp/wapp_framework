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
    <div class="">
        <div class="row" style="border-bottom: 2px solid rgba(0,0,0,0.1)">
            <div class="col">
            </div>
            <div class="col-auto">
                <a class="btn btn-danger" href="?c=1" role="button">Очистить</a>
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

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Дата</th>
                            <th scope="col">Тип</th>
                            <th scope="col">JSON</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($aLines as $iI => $aRow): ?>
                        <tr class="table-<?php echo $aRow[0]; ?>">
                            <th scope="row"><?php echo $iI; ?></th>
                            <td><?php echo $aRow[2]; ?></td>
                            <td><?php echo $aRow[0]; ?></td>
                            <td><?php echo $aRow[3]; ?></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            
            </div>
        </div>
    </div>

</body>
</html>

<style>
* { border-radius: 0px !important; }
</style>