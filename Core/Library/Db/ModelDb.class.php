<?php
	namespace Core\Library\Db;
	defined('TOKEN') || exit();
	
	class ModelDb {
		protected $tablePrefix = NULL;//定义模型对应数据表的前缀，如果未定义则获取配置文件中的DB_PREFIX参数
		protected $tableName = NULL;//不包含表前缀的数据表名称，一般情况下默认和模型名称相同，只有当你的表名和当前的模型类的名称不同的时候才需要定义
		protected $dbName = NULL;//定义模型当前对应的数据库名称，只有当你当前的模型类对应的数据库名称和配置文件不同的时候才需要定义
		protected $connection = [//具体模型类中定义的数据库配置文件
			/*
			'ACTUAL_NAME'		=>'Mysql',					//数据库类型 例如:MySQL,Memcache,Redis
			//各种数据库配置文件
			'Mysql' => [ //NOTE：此时选定Mysql
				//数据库配置
				'DB_HOST'		=>'localhost',					//数据库地址
				'DB_NAME'		=>'chat',					//数据库名
				'DB_USER'		=>'root',					//用户名
				'DB_PWD'		=>'root888',					//密码
				'DB_PORT'		=>'3306',					//端口
				'DB_CHARSET'	=>'utf8',				//编码
				'DB_PREFIX'		=>'',					//表前缀
			],
			'Redis' => [
			],
			 */
		];
		private $ins = NULL;//委托人（对象）

		public function __construct(\Core\Library\Db\Db $dbInstance) {
			$this->ins = $dbInstance;
		}

		public function __call($methodName,$args) {
			if(method_exists($this->ins,$methodName)) {
				$this->ins->$methodName($args);
			}
		}
	}
