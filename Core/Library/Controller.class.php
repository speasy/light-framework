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
			$this->CName = $this->getCName();//todo 用到时 才调用 最好
			//todo 是否可以通过后期静态绑定获取子类的名称和正在执行的方法名称
		}

		//获取控制器的名称
		private function getCName() {
			return ucfirst(substr(get_class($this),0,-10));
		}

		private function getAName() {
		}

		//调用模板
		protected function display($views = array()) {
			//若$viewName为空，则直接调用对应控制器相应操作下的同名模板
			if(empty($views)) {
				require APP_ROOT.$this->CName.'/'.$this->AName.'html';//todo
				return;
			}
			//若非空则调用//todo
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
			trigger_error('The method '.$className.'() is not defined,Please check your controller script!',E_USER_ERROR);
		}	
	}
