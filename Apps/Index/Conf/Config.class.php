<?php
	/**
	 * 应用的配置文件
	 * 格式:数组
	 */
	namespace Index\Conf;
	defined('TOKEN') || exit();

	class Config {
		static public function getConf() {
			return array(
				/*
				usage:
				'DB_TYPE'		=>'',					//数据库类型 例如:Mysqli,Memcache,Redis
				'DB_HOST'		=>'',					//数据库地址
				'DB_NAME'		=>'',					//数据库名
				'DB_USER'		=>'',					//用户名
				'DB_PWD'		=>'',					//密码
				'DB_PORT'		=>'',					//端口
				'DB_CHARSET'	=>'utf8',				//编码
				'DB_PREFIX'		=>'',					//表前缀
				*/
			);
		}
	}