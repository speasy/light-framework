<?php
	/**
	 * 数据库抽象类
	 */
	namespace Core\Library\Db;
	defined('TOKEN') || exit();

	abstract class Db {
		static protected $ins = null;//保存数据库对象 TODO 子类继承父类，属性方法都可以继承，但是不一定能调用（可见性控制）
		protected $config;//数据库配置文件

		protected function __construct($config = array()) {
			$this->config = $config;
		}

		/**
		 * 获取数据库对象单例 
		 */
		static public function getIns($config = array()) {
			if(empty(static::$ins) || !(static::$ins instanceof static)) {//Late-static-bindings
				static::$ins = new static($config);
			}
			return static::$ins;
		}

		/**
		 * 对获取的数据库对象实例进行reform
		 * param:array $conf_arr 新的数据库配置文件
		 */
		static public function reform($config = array()) {
			self::$config = $config;
			return new self();
		}

		abstract public function add($data = array());
		abstract public function del($data = array());
		abstract public function update($data = array(),$cond);

		/**
		* 返回结果集中全部数据
		*/
		abstract public function select($fields = array(),$cond);

		/**
		* 返回结果集中的一行数据
		*/
		abstract public function find($fields = array(),$cond);

		/**
		 *关闭链接
		 */
		abstract private function close();

		/**
		 * 防止克隆数据库对象
		 */
		public function __clone() {
			trigger_error('禁止克隆数据库对象');
		}
	}
