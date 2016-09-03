<?php
	/**
	 * 数据库抽象类
	 */
	namespace Core\Library\Db;
	defined("TOKEN") || exit('Access refused!');

	abstract class Db {
		static protected $ins = NULL;//保存数据库对象 TODO 子类继承父类，属性方法都可以继承，但是不一定能调用（可见性控制）
		protected $tableName = NULL;//要操作的表名
		protected $primaryKey = NULL;//主键
		protected $config;//数据库配置文件

		public function __construct(array $config = array()) {
			$this->config = $config;
		}

		static public function getIns(array $config = array()) {
			if(empty(static::$ins) || !(static::$ins instanceof static)) {//Late-static-bindings TODO 委托 反射
				static::$ins = new static($config);
			}
			return static::$ins;
		}

		abstract protected function connect($host,$user,$password,$database);

		/**
		* 返回结果集中包含$fields数组中字段的全部数据
		*/
		abstract public function findAll(array $fields = array(),$cond);

		/**
		* 返回结果集中的包含$fields数组中字段的一行数据
		*/
		abstract public function findOne(array $fields = array(),$cond);

		abstract public function deleteAll($cond);
		abstract public function updateAll(array $data = array(),$cond);

		abstract public function insert($data = array());

		abstract public function update();

		abstract public function delete();


		//TODO add del update return $this chain call

		/**
		 *关闭链接
		 */
		abstract protected function close();

		/**
		 * 防止克隆数据库对象
		 */
		public function __clone() {
			trigger_error('禁止克隆数据库对象');
		}
	}
