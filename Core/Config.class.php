<?php
	/**
	 * 框架默认配置文件参数
	 * usage:require/include
	 */
	namespace Core;
	defined('TOKEN') || exit();
	class Config {
		static public function getConf() {
			return array(
				'DEFAULT_CREATE_DIRS' => array('Common','Conf','Controller','Model','View','Runtime'),//默认在每个应用下面创建的目录名
				'DIR_SECURE_FILENAME' => 'index.html',//目录安全文件,TODO 可以在入口文件中通过define('DIR_SECURE_FILENAME', 'default.html');修改
			);
		}
	}
