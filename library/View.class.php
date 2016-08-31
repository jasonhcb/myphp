<?php
/**
*视图基类						 
*/

class View
{	
	protected $variables = array();
	protected $_controller;
	protected $_action;

	function __construct($controller,$action)
	{
		$this->_controller = $controller;
		$this->_action = $action;
	}

	/**
	 * 变量分配
	 * @param  string $name  变量名
	 * @param  array $value 变量值
	 * @return array        array
	 */			
	public function assign($name,$value)
	{
		$this->variables[$name] = $value;
	}

	/**
	 * 视图渲染
	 * @return [type] [description]
	 */
	public function render()
	{
		extract($this->variables);
		$defaultHeader = APP_PATH . '/views/header.php';
		$defaultFooter = APP_PATH . '/views/footer.php';

		$controllerHeader = APP_PATH . '/views/' . $this->_controller . '/header.php';
		$controllerFooter = APP_PATH . '/views/' . $this->_controller . '/footer.php';

		//包含页头文件
		if (file_exists($controllerHeader)) {
			include ($controllerHeader);
		}else{
			include ($defaultHeader);
		}

		//包含内容文件
		$controllerContent = APP_PATH . '/views/' . $this->_controller . '/' . $this->_action . '.php';
		// echo $controllerContent;

		//包含页脚文件
		if (file_exists($controllerFooter)) {
			include ($controllerFooter);
		}else{
			include ($defaultFooter);
		}
	}
}	