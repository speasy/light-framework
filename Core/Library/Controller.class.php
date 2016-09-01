<?php
	/**
	 * 控制器基类 抽象类
	 */
	namespace Core\Library;
	defined('TOKEN') || exit();

	/**
	 * 定义Controller为抽象类，用于继承，其本身不能被实例化
	 **/
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
		public function render($view = NULL,array $data = array()) {//TODO
			!empty($data) && extract($data, EXTR_PREFIX_SAME,'data');
			ob_start();
			ob_implicit_flush(0);
			if(empty($view)) {
				require APP_ROOT.'View/'.$this->CName.'/'.$this->AName.'.html';
			} else { //若$params非空，则调用
				require APP_ROOT.'View/'.$view[0].'/'.$view[1].'.html';
			}
			echo ob_get_clean();
		}

		//部分渲染，加载共同模板 TODO	

		private function dispatchJump($view = '',array $data = array()) {
			!empty($data) && extract($data,EXTR_PREFIX_SAME,'data');
			ob_start();
			ob_implicit_flush(0);
			require CORE_ROOT.'Template/'.$view.'.html';
			echo ob_get_clean();
		}

		/*
		 * 操作失败，页面跳转
		 */
		protected function error($mess = '操作失败',$url = '',$timeout = 3) {
			$this->dispatchJump('error',[
			]);
		}

		/*
		 * 操作成功，页面跳转
		 */
		protected function success($mess = '操作成功',$url = '',$timeout = 1) {
			$this->dispatchJump('error',[
			]);
		}

		/*
		 * 页面重定向
		 */
		protected function redirect() {
		}

		/**
			* @Brief  对数组进行json编码
			*
			* @Param $data
			*
			* @Returns   
		 */
		public function toJson(array $data) {
			if (is_string($data)) {
				return $data;
			}
			return json_encode($data);
		}

		/**
			* @Brief  控制器中不存在相应操作时提示
			*
			* @Param $className
			* @Param $args
			*
			* @Returns   
		 */
		public function __call($className,$args) {//其他魔术方法使用 TODO  魔术方法在框架中的使用
			trigger_error('控制器'.$this->CName.'中'.$className.'操作不存在',E_USER_ERROR);
		}	
	}
