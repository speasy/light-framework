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
			//todo 用到时 才调用 最好
			//todo 是否可以通过后期静态绑定获取子类的名称和正在执行的方法名称
		}

		/**
		 * 输出模板并渲染变量
		 * param boolean/array $view usage:array($controllerName,$actionName)
		 * param array $data		 usage:array(k1=>v1,k2=>v2,...)
		 * return NULL
		 **/
		protected function render($view = NULL,$data = array()) {//TODO
			extract($data, EXTR_PREFIX_SAME,'data');
			ob_start();
			ob_implicit_flush(0);
			if(empty($params)) {
				require APP_ROOT.'View/'.$this->CName.'/'.$this->AName.'.html';
			} else { //若$params非空，则调用
				require APP_ROOT.'View/'.$view[0].'/'.$view[1].'.html';
			}
			echo ob_get_clean();
		}

		protected function error() {
			require APP_ROOT.'View/'.$this->CName.'/'.$this->AName.'.html';
		}

		protected function success() {
			require APP_ROOT.'View/'.$this->CName.'/'.$this->AName.'.html';
		}

		protected function redirect() {
		}

		public function __call($className,$args) {//其他魔术方法使用 TODO
			trigger_error('控制器'.$this->CName.'中'.$className.'操作不存在',E_USER_ERROR);
		}	
	}
