<div class="container">
    <div class="row">
        <div class="col">
            <h1>Index page of Core module</h1>

            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla laudantium omnis amet non eaque iste expedita eveniet distinctio dolorum laborum asperiores doloribus eum, ad, repellendus aspernatur rem. Accusantium, dolor odio?</p>
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
