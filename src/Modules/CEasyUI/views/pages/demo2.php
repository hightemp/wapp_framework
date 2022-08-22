<h1><?php echo $sTitle ?></h1>
<h2>demo 2</h2>

<?php $oTagCEDatagrid(
    [
        [ "id" => 1, "date" => date("now"), "data" => str_repeat("dsfs dfsg fdg ", 5), "data2" => str_repeat("sdfsadf dasf ", 5) ],
        [ "id" => 2, "date" => date("now"), "data" => str_repeat("dsfs dfsg fdg ", 5), "data2" => str_repeat("sdfsadf dasf ", 5) ],
        [ "id" => 3, "date" => date("now"), "data" => str_repeat("dsfs dfsg fdg ", 5), "data2" => str_repeat("sdfsadf dasf ", 5) ],
        [ "id" => 4, "date" => date("now"), "data" => str_repeat("dsfs dfsg fdg ", 5), "data2" => str_repeat("sdfsadf dasf ", 5) ],
        [ "id" => 5, "date" => date("now"), "data" => str_repeat("dsfs dfsg fdg ", 5), "data2" => str_repeat("sdfsadf dasf ", 5) ],
        [ "id" => 6, "date" => date("now"), "data" => str_repeat("dsfs dfsg fdg ", 5), "data2" => str_repeat("sdfsadf dasf ", 5) ],
        [ "id" => 7, "date" => date("now"), "data" => str_repeat("dsfs dfsg fdg ", 5), "data2" => str_repeat("sdfsadf dasf ", 5) ],
        [ "id" => 8, "date" => date("now"), "data" => str_repeat("dsfs dfsg fdg ", 5), "data2" => str_repeat("sdfsadf dasf ", 5) ],
        [ "id" => 9, "date" => date("now"), "data" => str_repeat("dsfs dfsg fdg ", 5), "data2" => str_repeat("sdfsadf dasf ", 5) ],
        [ "id" => 10, "date" => date("now"), "data" => str_repeat("dsfs dfsg fdg ", 5), "data2" => str_repeat("sdfsadf dasf ", 5) ],
        [ "id" => 11, "date" => date("now"), "data" => str_repeat("dsfs dfsg fdg ", 5), "data2" => str_repeat("sdfsadf dasf ", 5) ],
        [ "id" => 12, "date" => date("now"), "data" => str_repeat("dsfs dfsg fdg ", 5), "data2" => str_repeat("sdfsadf dasf ", 5) ],
    ], 
    [
        "id", "data", "data2"
    ], 
    []
); ?>