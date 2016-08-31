<?php
/**
* 测试模型
*/
class ItemModel extends Model
{
	public function index()
	{
		$this->selectAll();
	}
}