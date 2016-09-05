<?php
	namespace Core\Library\Exception;

	/**
		* @Brief  数据库异常处理类
	 */
	class DbException extends BaseException {
		public function __toString() {
			return parent::__toString();
		}
	}
