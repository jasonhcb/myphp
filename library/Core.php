<?php
/* My spring 核心框架 */
// namespace library;
// use application\controllers;

class Core
{
	/**
	 * 执行应用程序
	 * @return Response 
	 */		
	public static function run()
	{
		//自动加载类
		spl_autoload_register('self::loadClass');
		self::setReporting();
		self::removeMagicQuotes();
		self::unregisterGlobals();
		self::Route();
	}

	/**
	 * 路由处理
	 * @return Route
	 */
	public static function Route()
	{
		$controllerName = 'Index';
		$action = 'index';

		if (!empty($_GET['url'])) {
			$url = $_GET['url'];
			$urlArray = explode('/',$url);

			//获得控制器名称
			$controllerName = ucfirst($urlArray[0]);

			//获取动作名
			array_shift($urlArray);//删除第一个元素并且返回
			$action = empty($urlArray[0]) ? 'index' : $urlArray[0];

			//获取url参数
			array_shift($urlArray);//删除第一个元素并且返回
			$queryString = empty($urlArray) ? array() : $urlArray;

		}

		//数据为空时候的处理
		$queryString = empty($queryString) ? array() : $queryString;

		//实例化控制器
		$controller = $controllerName . 'Controller';
		$dispatch   = new $controller($controllerName,$action);

		//如果控制器和动作存在执行调用并传入URL参数
		if ((int)method_exists($controller,$action)) {
			call_user_func_array(array($dispatch,$action),$queryString);
		}else{
			exit($controller . '控制器不存在');
		}
	}

	/**
	 * 检测开发环境
	 * @return setReporting
	 */
	public static function setReporting()
	{
		if (APP_DEBUG === true) {
			error_reporting(E_ALL);//所有警告和错误提醒
			ini_set('display_errors','On');
		} else {
			ini_set('display_errors','Off');
			ini_set('log_errors','On');
			ini_set('error_log',RUNTIME_PATH . 'logs/error.log');
		}
	}

	/**
	 * 递归删除敏感字符
	 * @param  array $value 字符串
	 * @return array        处理的字符串
	 */	
	public static function stripslashesDeep($value)
	{
		//这里只对value进行了处理，有BUG
		$value = is_array($value) ? array_map('stripslashesDeep', $value) : stripslashes($value);
		return $value;
	}

	/**
	 * 检测敏感字符并且删除
	 */
	public static function removeMagicQuotes()
	{
		if (get_magic_quotes_gpc()) {
			$_GET = stripslashesDeep($_GET);
			$_POST = stripslashesDeep($_POST);
			$_COOKIE = stripslashesDeep($_COOKIE);
			$_SESSION = stripslashesDeep($_SESSION);
		}
	}

	/**
	 * 检测自定义全局变量并且移除
	 */		
	public static function unregisterGlobals()
	{
		if (ini_get('register_globals')) {
			$array = array('_SESSION','_POST','_GET','_REQUEST','_SERVER','_ENV','_FILES');
			foreach ($array as $value) {
				foreach ($GLOBALS[$value] as $key => $val) {
					if ($val === $GLOBALS[$key]) {
						unset($GLOBALS[$key]);
					}
				}
			}

		}
	}

	/**
	 * 自动加载控制器和模型类
	 * @param class 类名
	 */
	static function loadClass($class)
	{
		$frameworks =  FRAME_PATH . $class .'.class.php';
		$controllers = APP_PATH .'/controllers/'. $class .'.class.php';
		$models = APP_PATH.'/models/' . $class.'.class.php';
		if (file_exists($frameworks)) {
			//加载框架类
			include $frameworks;
		}elseif(file_exists($controllers)){
			//加载控制器
			include $controllers;
		}elseif(file_exists($models)){
			//加载模型
			include $models;
		}else{
			exit('没有框架，加载错误，请新建。');
		}
	}



}