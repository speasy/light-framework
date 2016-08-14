<?php
	/**
	* 默认控制器
	*/
	namespace Index\Controller;
	use \Core\Library\Controller as Controller;
	defined('TOKEN') || exit();

	class IndexController extends Controller {
		//默认操作
		public function index() {
			//echo 'Install successfully!';
			var_dump(new \Index\Model\IndexModel);
		}
	} 
