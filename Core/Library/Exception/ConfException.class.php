<?php
	namespace Core\Library\Exception;

	/**
		* @Brief  配置文件异常处理类
	 */
	class ConfException extends BaseException {
		public function __toString() {
			return parent::__toString();
		}
	}
