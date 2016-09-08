<?php
	namespace Core\Library;
	defined('TOKEN') || exit();

	/**
	 * 定义Model为抽象类，用于具体模型类继承，其本身不能被实例化
	 **/
	abstract class Model {
		private $delegate = NULL;



		public function __construct(array $config = array()) {//TODO 配置文件 或者 DSN（data source name）
			/*
			//框架配置文件，应用配置文件，具体类配置文件合并 TODO 逻辑有问题
			$CName = '\\'.\Core\BaseLib::$M.'\\Conf\\Config';//类名
			$this->connection = array_merge(\Core\Config::getConf(),$CName::getConf(),$this->connection,$config);//合并配置文件

			//具体映射到类别
			$type = '';//数据库类别
			$actual_name = $this->connection['ACTUAL_NAME'];
			array_walk($this->ruleMap,function($sub_type_name,$type_name,$actual_name) use (&$type) {
				foreach($sub_type_name as $v) {
					if(strtolower($v) === strtolower($actual_name)) {
						$type = $type_name;
						break;
					}
				}
			},$actual_name);

			$MName = '\\Core\\Library\\'.$type.'\\Model'.$type;
			$IName = '\\Core\\Library\\'.$type.'\\'.$actual_name;

			$this->delegate = new $MName($IName::getIns($this->connection));//TODO
			 */
		}

		public function __call($methodName,$args) {
			if(method_exists($this->delegate,$methodName)) {
				$this->delegate->ins->$methodName($args);//二次委托 TODO
			}
		}

		public function __set($n,$v) {//TODO 设置为具体类中的属性？？
			$this->delegate->$n = $v;
		}

		public function __get($n) {
			return $this->delegate->$n;
		}
	}
