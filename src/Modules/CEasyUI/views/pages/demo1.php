<?php $oTagCEPanelBegin() ?>
    <h1>Формы и элементы ввода</h1>

    <?php $oTagForm(
        [],
        [],
        [
            [ $oTagCETabs, 
                [],
                [],
                [
                    ['test 1', '<h2>Test header 1</h2>'],
                    ['test 2', '<h2>Test header 2</h2>'],
                ] 
            ],
            [ $oTagCENumberBox ],
            [ $oTagCEFileBox ],
            [ $oTagCETree, [
                '1' => 'test 1',
                '2' => 'test 2',
                '3' => 'test 3',
                '4' => [
                    'test 4', 
                    [
                        '1' => 'test 1',
                        '2' => 'test 2',
                        '3' => 'test 3',    
                    ],
                ],
            ] ],
            [ $oTagCESwitchButton ],
            [ $oTagCEPasswordBox ],
            [ $oTagCEMaskedBoxPhone ],
            [ $oTagCESearchBox ],
            [ $oTagCEButton, 'test button' ],
            [ $oTagCEComboTree ],
            [ $oTagCECheckbox ],
            [ $oTagCEDatebox ],
            [ $oTagCECombobox, [
                '1' => 'test 1',
                '2' => 'test 2',
                '3' => 'test 3',
            ]],
            [ $oTagCETextBox ],
            [ $oTagCETextarea ],
        ]
    ) ?>

<?php $oTagCEPanelEnd() ?>
