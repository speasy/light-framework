<?php
	namespace Core\Library;
	defined('TOKEN') || exit();

	/**
	 * 定义Model为抽象类，用于具体模型类继承，其本身不能被实例化
	 **/
	abstract class Model {
		private $delegate = NULL;
		private $rule = [
			'Db' => [
				'MySQL',
				'MySQLi',//ect..
			],
			'Cache' => [
				'File',
				'Memcache',
				'Redis',//etc..
			],
		];
		private $connection = [//具体模型类中定义的数据库配置文件
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

		public function __construct(array $config = array()) {
			//框架配置文件，应用配置文件，具体类配置文件合并
			$CName = '\\'.\Core\BaseLib::$M.'\\Conf\\Config';//类名
			$this->config = array_merge(\Core\Config::getConf(),$CName::getConf(),$this->connection);//合并配置文件

			$type = '';//数据库类别
			$actual_name = $this->config['ACTUAL_NAME'];
			array_walk($this->rule,function($rule_type,$rule_actual_name,$actual_name) use ($type) {
				if(strtolower($actual_name) === strtolower($rule_actual_name)) {
					$type = $rule_type;//TODO
					break;
				}
			},$actual_name);

			//具体映射到类别
			$MName = '\\Core\\Library\\'.$type.'\\Model'.$type;
			$this->delegate = new $MName();
		}

		public function __call($methodName,$args) {
			if(method_exists($this->delegate,$methodName)) {
				$this->delegate->ins->$methodName($args);//二次委托 TODO
			}
		}

		public function __set($n,$v) {//TODO 设置为具体类中的属性？？
			$this->delegate->$n = $v;
		}
	}
