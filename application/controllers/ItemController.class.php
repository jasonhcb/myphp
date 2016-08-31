<?php
/**
* item方法
*/

class ItemController extends Controller
{
	public function index()
	{
		$items = (new ItemModel)->index();
		// $this->assign('items', '1');
		// $this->_view->render();
	}
}