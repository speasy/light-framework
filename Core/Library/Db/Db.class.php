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
		protected $component = array();//保存待拼接的SQL语句元素
		protected $exeQueue = array();//方法执行队列
		protected $config;//数据库配置文件

		protected function __construct(array $config = array()) {
			$this->config = $config;
		}

		static public function getIns(array $config = array()) {
			if(empty(static::$ins) || !(static::$ins instanceof static)) {//Late-static-bindings
				static::$ins = new static($config);
			}
			return static::$ins;
		}

		abstract protected function connect($host,$user,$password,$database);

		abstract public function insert(array $data = array());
		abstract public function deleteAll(array $cond);
		abstract public function updateAll(array $data = array(),$cond);

		/**
		* 返回结果集中包含$fields数组中字段的全部数据
		*/
		abstract public function findAll(array $fields = array(),$cond);

		/**
		* 返回结果集中的包含$fields数组中字段的一行数据
		*/
		abstract public function findOne(array $fields = array(),$cond);

		/*
		abstract public function update();

		abstract public function delete();

		/* TODO 防止SQL注入 链式调用
		abstract public function sort();//条件排序
		abstract public function from();
		abstract public function on();
		abstract public function select();
		abstract public function where();
		abstract public function andWhere();
		abstract public function group();
		abstract public function order();
		abstract public function limit();
		abstract public function innerJoin();
		abstract public function leftJoin();
		abstract public function rightJoin();
		abstract public function gt();
		abstract public function lt();
		abstract public function eq();
		abstract public function in();
		abstract public function between();
		*/
		public function from($tableName = '') {
			$this->component['from'] = $tableName;
			return $this;
		}

		public function innerJoin($tableName = '',$on = '') {//TODO 多表连接
			array_push($this->component['innerJoin']) = array($tableName,$on);
			return $this;
		}

		//innerJoin的别名
		public function join($talbeName = '',$on = '') {
			call_user_func(array($this,$tableName),$on);
		}

		public function leftJoin($tableName = '',$on = '') {
			array_push($this->component['leftJoin']) = array($tableName,$on);
			return $this;
		}

		public function rigthJoin($tableName = '',$on = '') {
			array_push($this->component['rightJoin']) = array($tableName,$on);
			return $this;
		}

		public function having($cond = '') {
			$this->component['having'] = $cond;
			return $this;
		}


		public function group($field = '') {
			$this->component['gruop'] = $field;
			return $this;
		}

		public function order($field = '') {
			$this->component['order'] = $field;
			return $this;
		}

		public function select(array $fields = array()) {
			$this->component['select'] = $fields;
			return $this;
		}


		public function where($cond = '') {
			$this->component['where'] = $cond;
			return $this;
		}

		public function andWhere($cond = '') {
			$this->component['where'] .= ' AND '.$cond;
			return $this;
		}

		//TODO add del update return $this chain call

		//$user->reset()->select()->from()->where()->queryAll();
		
		protected function sort() {
			//$this->select();
		}

		//清空SQL
		protected function reset() {
			$this->component = array();
			return $this;
		}

		//执行原生SQL 返回一行数据
		abstract public function query($sql = '');


		//执行原生SQL 返回全部数据
		abstract public function queryAll($sql = '');

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

		public function __call($methodName,$args) {
			if(in_array($methodName,['from','innerJoin','leftJoin','rightJoin','where','andWhere','group','having','select','distinct','order','limit'],true)) {
				$this->exeQueue[] = $methodName;//加入执行队列
				call_user_func_array(array($this,$methodName),$args);
			}
		}
	}
