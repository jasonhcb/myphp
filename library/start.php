<?php

//路径
define('DS', DIRECTORY_SEPARATOR);
//初始化常量
defined('FRAME_PATH') or define('FRAME_PATH', __DIR__.DS);
defined('APP_PATH') or define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']).DS);
defined('APP_DEBUG') or define('APP_DEBUG',false);
defined('CONFIG_PATH') or define('CONFIG_PATH',APP_PATH.'config'.DS);
defined('RUNTIME_PATH') or define('RUNTIME_PATH', APP_PATH.'/temp'.DS);
defined('VENDOR_PATH') or define('VENDOR_PATH',APP_PATH.'vendor'.DS);

//包含配置文件
require APP_PATH . './../config/config.php';

//包含核心框架类
require FRAME_PATH . 'Core.php';

//实例化核心类
$app = new Core;
$app->run();

