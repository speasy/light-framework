<?php
	/**
	 * 所有数据库操作的基类，都要继承此基类
	 */
	namespace Core\Library;
	defined('TOKEN') || exit();

	class Model {
		protected $db = null;//保存数据库操作单例
		protected $config = array();//合并之后的配置文件（框架配置文件，应用配置文件，模型类配置文件）
		protected $connection = array();//具体模型类中定义的数据库配置文件

		public function __construct() {
			//数据库配置文件 TODO 工厂模式
			$CName = '\\'.\Core\BaseLib::$M.'\\Conf\\Config';//类名
			$this->config = array_merge(\Core\Config::getConf(),$CName::getConf(),$this->connection);//合并配置文件

			//根据DB_TYPE获取对应的数据库对象单例
			$DName = '\\Core\\Library\\Db\\'.$this->config['DB_TYPE'];
			$this->db = $DName::getIns($this->config);
		}
	}
