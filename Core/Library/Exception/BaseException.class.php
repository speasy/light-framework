<?php
	namespace Core\Library\Exception;
	use Exception;// aliase: use \Exceptin as Exception
	use ReflectionClass;
	use Reflection;

	/**
		* @Brief  所有自定义异常处理类的基类
	 */
	class BaseException extends Exception {
		public function __construct($message = null,$code = 0,Exception $previous = null) {
			//make sure everything is assigned properly
			parent::__construct($message, $code, $previous);
		}

		/**
			* @Brief  自定义的子异常处理类调用时返回一个字符串
			*
			* @Returns   string
		 */
		public function __toString() {//TODO 重写__toString 利用反射机制
			//获取文件名 利用反射类 获取类内容 对于特定行高亮显示
			return '<pre>'.file_get_contents($this->file).'</pre>';
		}
	}
