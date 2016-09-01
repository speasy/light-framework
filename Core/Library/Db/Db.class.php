<?php
	/**
	 * 数据库抽象类
	 */
	namespace Core\Library\Db;
	defined('TOKEN') || exit();

	abstract class Db {
		static protected $ins = NULL;//保存数据库对象 TODO 子类继承父类，属性方法都可以继承，但是不一定能调用（可见性控制）
		protected $config;//数据库配置文件

		/**
			* @Brief  构造函数为config变量赋值
			*
			* @Param $config
			*
			* @Returns   
		 */
		protected function __construct(array $config = array()) {
			$this->config = $config;
		}

		/**
			* @Brief  获取数据库对象单例 
			*
			* @Param $config
			*
			* @Returns   
		 */
		static public function getIns(array $config = array()) {
			if(empty(static::$ins) || !(static::$ins instanceof static)) {//Late-static-bindings TODO 委托 反射
				static::$ins = new static($config);
			}
			return static::$ins;
		}

		/**
		 * 对获取的数据库对象实例进行reform
		 * param:array $conf_arr 新的数据库配置文件
		 */
		static public function reform(array $config = array()) {
			self::$config = $config;
			return new self();
		}

		abstract public function tableName();

		abstract public function primaryKey();
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
