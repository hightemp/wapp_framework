<div class="container">
    <div class="row">
        <div class="col">
            <h1>Easyui demo index</h1>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <ul>
            <?php foreach ($aAliases as $aAlias): ?>
                <li><?php $oTagA($aAlias[1], $aAlias[0]); ?>
            <?php endforeach ?>
            </ul>
        </div>
    </div>
</div>
