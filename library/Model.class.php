<?php
class Model extends Db 
{
	protected $_model;
	protected $_table;

	/**
	 * 构造函数
	 */
	public function __construct()
	{
		//连接数据库
		$this->connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

		//获取模型名称
		$this->_model = get_class($this);//获得继承类的class小写
		$this->_model = rtrim($this->_model,'Model');

		//数据库名称与表名称一样
		$this->_table = strtolower($this->_model);//首字母大写
	}

	public function __destruct()
	{
		
	}
}