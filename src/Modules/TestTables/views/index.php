<div id="main-wrapper">
    <div id="main-left-panel" data-src="">
        <?php $oInclude("panels/left_panel.php") ?>
    </div>
    <iframe
        id="main-right-iframe"
    ></iframe>
</div>

<style>
#main-wrapper {
    display: grid;
    position: fixed;
    grid-template-columns: 500px 1fr;
    top: 0px;
    left: 0px;
    right: 0px;
    bottom: 0px;
}
#main-left-panel {
    height: 100%;
    overflow-y: scroll;
}

#main-right-iframe {
    height: 100%;
    width: 100%;
}
</style>
