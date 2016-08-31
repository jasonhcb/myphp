<?php 
// error_reporting(E_ALL);//所有警告和错误提醒
// ini_set('display_errors','On');
//定义应用目录
define('APP_PATH', __DIR__.'/../application');

//开启调试模式
define('APP_DEBUG',true);

//网站根目录
define('APP_URL', 'http://localhost/myspring/');

//加载框架
require  __DIR__.'/../library/start.php';

