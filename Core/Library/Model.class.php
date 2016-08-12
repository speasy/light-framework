<?php
	/**
	 * 所有数据库操作的基类，都要继承此基类
	 */
	namespace Core\Library;
	defined('TOKEN') || exit();
	class Model {
		protected $db = null;//保持数据库操作单例

		public function __construct() {
			$this->db = \Core\Library\Db\Mysqli::getIns();//todo Mysqli应该用常量替换
			//todo 入口文件定义常量应该替换掉 配置文件
		}

		public function db() {
		}
	}
