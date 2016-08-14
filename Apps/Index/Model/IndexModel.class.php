<?php
	/**
	* 示例模型类 
	*/
	namespace Index\Model;
	use \Core\Library\Model as Model;
	defined('TOKEN') || exit();

	class IndexModel extends Model {
		protected $connect = array('DB_PORT'=>'111');
	} 
