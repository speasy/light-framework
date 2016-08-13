<?php
	/**
	 * 控制器基类 抽象类
	 */
	namespace Core\Library;
	defined('TOKEN') || exit();

	abstract class Controller {
		private $CName = '';		//控制器名称
		private $AName = '';		//操作名称

		public function __construct() {
			$this->CName = \Core\BaseLib::$C;
			$this->AName = \Core\BaseLib::$A;
			//$this->CName = $this->getCName();//todo 用到时 才调用 最好
			//todo 是否可以通过后期静态绑定获取子类的名称和正在执行的方法名称
		}

		/*
		//获取控制器名称
		private function getCName() {
			return ucfirst(substr(get_class($this),0,-10));
		}

		//获取操作名称
		private function getAName() {
		}
		*/

		/** 
		* display  
		* 调用视图文件 
		*
		* @access protected 
		* @param array $params 为空或者array('控制器名称','操作名称')
		* @since 1.0 
		* @return null 
		*/
		protected function display($params = array()) {
			//若$params为空，则直接调用对应控制器相应操作下的同名模板
			if(empty($params)) {
				require APP_ROOT.'View/'.$this->CName.'/'.$this->AName.'.html';
				return;
			}
			//若$params非空，则调用
			require APP_ROOT.'View/'.$params[0].'/'.$params[1].'.html';
		}

		protected function assign() {
		}

		protected function error() {
		}

		protected function success() {
		}

		protected function redirect() {
		}

		public function __call($className,$args) {
			trigger_error('控制器'.$this->CName.'中'.$className.'操作不存在',E_USER_ERROR);
		}	
	}
