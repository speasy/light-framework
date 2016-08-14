<?php
	/**
	 * 所有数据库操作的基类，都要继承此基类
	 */
	namespace Core\Library;
	defined('TOKEN') || exit();

	class Model {
		protected $db = null;//保存数据库操作单例
		protected $config = array();//合并之后的配置文件（框架配置文件，应用配置文件，模型类配置文件）

		protected $connection = array(//具体模型类中定义的数据库配置文件
			/*
			'DB_TYPE'		=>'Mysqli',					//数据库类型 例如:Mysqli,Memcache,Redis
			'DB_HOST'		=>'localhost',					//数据库地址
			'DB_NAME'		=>'chat',					//数据库名
			'DB_USER'		=>'root',					//用户名
			'DB_PWD'		=>'root888',					//密码
			'DB_PORT'		=>'3306',					//端口
			'DB_CHARSET'	=>'utf8',				//编码
			'DB_PREFIX'		=>'',					//表前缀
			 */
		);
		protected $_map = array(//字段映射规则
			/*
			'name' =>'username', // 把表单中name映射到数据表的username字段
			'mail'  =>'email', // 把表单中的mail映射到数据表的email字段
			 */
		);
		protected $_validate = array(//自动验证规则
			/*
			array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
			array(验证字段2,验证规则,错误提示,[验证条件,附加规则,验证时间]),
			 */
		);

		public function __construct() {
			//数据库配置文件 TODO 工厂模式
			$CName = '\\'.\Core\BaseLib::$M.'\\Conf\\Config';//类名
			$this->config = array_merge(\Core\Config::getConf(),$CName::getConf(),$this->connection);//合并配置文件

			//根据DB_TYPE获取对应的数据库对象单例
			$DName = '\\Core\\Library\\Db\\'.$this->config['DB_TYPE'];
			$this->db = $DName::getIns($this->config);
		}

		/*
		 * 自动验证机制
		 */
		public function autoVerify() {
		}

		/*
		 * 自动字段映射
		 */
		public function autoMap() {
		}

		/*
		 * 自动填充 
		 */
		public function autoCom() {
		}
	}
