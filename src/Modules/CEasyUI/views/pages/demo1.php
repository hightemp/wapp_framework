<?php $oTagCEPanelBegin() ?>
    <h1>Формы и элементы ввода</h1>

    <?php $oTagForm(
        [],
        [],
        [
            [ $oTagCEDatebox ],
            [ $oTagCESelect, [
                '1' => 'test 1',
                '2' => 'test 2',
                '3' => 'test 3',
            ]],
            [ $oTagCETextBox ],
            [ $oTagCETextarea ],
        ]
    ) ?>

<?php $oTagCEPanelEnd() ?>
