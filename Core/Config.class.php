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
				//数据库配置
				'DB_TYPE'		=>'Mysqli',					//数据库类型 例如:Mysqli,Memcache,Redis
				'DB_HOST'		=>'localhost',					//数据库地址
				'DB_NAME'		=>'chat',					//数据库名
				'DB_USER'		=>'root',					//用户名
				'DB_PWD'		=>'root888',					//密码
				'DB_PORT'		=>'3306',					//端口
				'DB_CHARSET'	=>'utf8',				//编码
				'DB_PREFIX'		=>'',					//表前缀
			);
		}
	}
