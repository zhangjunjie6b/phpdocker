<?php
    define('FOLDER_NAME', 'app_script');

    require_once(dirname(__FILE__) . "/" . FOLDER_NAME . "/Core.php");
    // 命令行应用初始化执行
    Cmd::i()->run($argv);


