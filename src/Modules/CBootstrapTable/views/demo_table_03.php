<?php $oTagBootstrapTable(
    [ [1, 2, 3] ], 
    [ 
        [
            'ID',
            [
                "data-field" => "id"
            ]
        ], 
        [ 
            'Item Name',
            [
                "data-field" => "name"
            ]
        ], 
        [
            'Item Price',
            [
                "data-field" => "price"
            ]
        ], 
    ],
    [ 
        "data-height" => "700",
        "data-click-to-select" => "true",
    ]
); ?>

<style>
body, html {
    margin: 0px;
    padding: 0px;
    height: 100%;
}
</style>