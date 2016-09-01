<?php
	/**
	 * 所有数据库操作的基类，都要继承此基类
	 */
	namespace Core\Library;
	defined('TOKEN') || exit();

	/**
	 * 定义Model为抽象类，用于具体模型类继承，其本身不能被实例化
	 **/
	abstract class Model {
		private $rule = [
			'MySQL' => 'Mysqli',
			'Memcache' => 'Memcache',
			'Redis' => 'Redis',

		];
		protected $db = null;//保存数据库操作单例
		protected $config = array();//合并之后的配置文件（框架配置文件，应用配置文件，模型类配置文件）

		//TODO 如何知道哪些可以再子类中重写 是否有设计模式？
		protected $tablePrefix = NULL;//定义模型对应数据表的前缀，如果未定义则获取配置文件中的DB_PREFIX参数
		protected $tableName = NULL;//不包含表前缀的数据表名称，一般情况下默认和模型名称相同，只有当你的表名和当前的模型类的名称不同的时候才需要定义
		protected $dbName = NULL;//定义模型当前对应的数据库名称，只有当你当前的模型类对应的数据库名称和配置文件不同的时候才需要定义
		protected $connection = array(//具体模型类中定义的数据库配置文件
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
		protected $_pad = array();//自动填充规则

		public function __construct() {
			//数据库配置文件 TODO 工厂模式
			$CName = '\\'.\Core\BaseLib::$M.'\\Conf\\Config';//类名
			$this->config = array_merge(\Core\Config::getConf(),$CName::getConf(),$this->connection);//合并配置文件

			//用具体模型类中的信息对配置文件进行修改
			isset($this->tablePrefix) && $this->config['DB_PREFIX'] = $this->tablePrefix;
			isset($this->dbName) && $this->config['DB_NAME'] = $this->dbName;

			//根据DB_TYPE获取对应的数据库对象单例
			$DName = '\\Core\\Library\\Db\\'.$this->rule[$this->config['DB_TYPE']];
			$this->db = $DName::getIns($this->config);
		}

		/**
			* @Brief  获取数据库相应表全部字段
			*
			* @Returns   array
		 */
		private function getAllFields() {
			return $this->db->getAllFields();
		}

		/**
			* @Brief 自动字段映射
			*
			* @Param $data array origin_data
			* @Param $_map array array('form_input_name1'=>'table_field1','form_input_name2'=>'table_field2',...)
			*
			* @Returns
		 */
		public function autoMap(&$data = array(),$_map = array()) {
			//TODO 注释
			//$data = $_GET; 需要什么字段？？
			//autoMap
			//autoVerity
			//autoCom
			//三个函数失败的退出机制
			//D方法和M方法都要实现
			$_map = array_merge($this->_map,$_map);//合并字段映射规则
			if(!$msg = $this->fieldCheck(array_keys($_map))) {//给出提示消息
				//new \Core\Library\Controller;
			}
		}

		/*
		 * 自动验证机制
		 */
		public function autoValidate(&$data = array(),$_validate = array()) {
			//TODO 验证字段是存在的？
			$_validate = array_merge($this->_validate,$_validate);//合并字段验证规则
		}

		/*
		 * 自动填充 
		 */
		public function autoPad(&$data = array(),$_pad = array()) {
			$_pad = array_merge($this->_pad,$_pad);//合并字段填充规则
		}

		/**
		 * 自动处理
		 **/
		public function autoPro(&$data = array(),$_map = array(),$_validate = array(),$_pad = array()) {
			$this->autoMap($data,$_map);
			$this->autoValidate($data,$_validate);
			$this->autoPad($data,$_pad);
		}

		/**
			* @Brief  对字段进行检查
			*
			* @Param $fields array array('field1','field2',...) 需要验证该数组中的字段是否存在于相应表中
			*
			* @Returns   
		 */
		private function fieldCheck($fields = array()) {
			//TODO 异常处理类
			$existed_fields = $this->db->getAllFields();//获取相应表中的全部字段
			$msg = array();//错误返回信息
			$flag = 1;
			/*
			array_walk($fields,function($v,$k,$existed_fields) {
				if(!in_array($v,$existed_fields)) {
					return false;//TODO
					break;
				}
			},$existed_fields);
			 */
			foreach($fields as $v) {
				if(!in_array($v,$existed_fields)) {
					$flag = 0;
					array_push($msg,"字段$v不存在");
				}
			}
			return ($flag == 1) ? true : $msg;
		}

		public function add() {
		}

		public function del() {
		}
	}
