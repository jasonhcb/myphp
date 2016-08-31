<?php
/**
 * 控制器基层类
 */

class Controller
{

	//控制器实例类
	protected $_controller;
	//视图实例类
	protected $_view;
	//方法实例类
	protected $_action;

	/**
	 * 构造函数，初始化属性，并且实例化对应模型
	 * @param string $controller 控制器
	 * @param string $action     方法
	 */
	public function __construct($controller,$action)
	{
		$this->_controller = $controller;
		$this->_action = $action;
		$this->_view = new View($controller,$action);
	}

	/**
	 * 分配变量给视图
	 * @param  string $name  变量名
	 * @param  array/string/obj $value 变量值
	 */
	public function assign($name,$value)
	{
		$this->_view->assign($name,$value);
	}

	/**
	 * 析构函数，渲染视图
	 */
	public function __destruct()
	{
		$this->_view->render();
	}
}