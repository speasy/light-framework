<?php
	/**
	* @Brief  缓存接口
	*/
	namespace Core\Library\Cache;
	defined("TOKEN") || exit('Access refused!');

	abstract class Cache {
		static protected $ins = NULL;

		static public function getIns(array $config = array()) {
			if(empty(static::$ins) || !(static::$ins instanceof static)) {//Late-static-bindings TODO 委托 反射
				static::$ins = new static($config);
			}
			return static::$ins;
		}
	}
