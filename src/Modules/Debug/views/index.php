<div id="main-wrapper">
    <div id="main-left-panel">
        <?php echo $sList ?>
    </div>
    <iframe id="main-right-iframe" name="main-right-iframe"></iframe>
</div>

<style>
#main-wrapper {
    display: grid;
    position: fixed;
    grid-template-columns: 200px 1fr;
    top: 0px;
    left: 0px;
    right: 0px;
    bottom: 0px;
}
#main-left-panel {
    height: 100%;
}

#main-right-iframe {
    height: 100%;
    width: 100%;
    border: 1px solid rgba(0,0,0,0.1);
}
</style>
