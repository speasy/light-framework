<?php
	/**
	 * 所有数据库操作的基类，都要继承此基类
	 */
	namespace Core\Library;
	defined('TOKEN') || exit();

	class Model {
		protected $db = null;//保存数据库操作单例
		protected $config = array();//数据库配置文件
		protected $connection = array();//具体模型类中定义的数据库配置文件

		public function __construct() {
			//数据库配置文件 TODO 工厂模式
			$fw_config = \Core\Config::getConf();//框架中的配置文件
			$CName = '\\'.\Core\BaseLib::$M.'\\Conf\\Config';//类名
			$app_config = $CName::getConf();//应用中的配置文件
			$this->config = array_merge($fw_config,$app_config,$this->connection);//合并配置文件

			//根据配置文件获取数据库对象
			$DName = '\\Core\\Library\\Db\\'.$this->config['DB_TYPE'];
			$this->db = $DName::getIns($this->config);
		}
	}
