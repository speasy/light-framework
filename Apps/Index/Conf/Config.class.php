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
				'DB_TYPE'		=>'MySQL',					//数据库类型 例如:MySQL,Memcache,Redis
				//各种数据库配置文件
				'MYSQL' => [
					//数据库配置
					'DB_HOST'		=>'localhost',					//数据库地址
					'DB_NAME'		=>'chat',					//数据库名
					'DB_USER'		=>'root',					//用户名
					'DB_PWD'		=>'root888',					//密码
					'DB_PORT'		=>'3306',					//端口
					'DB_CHARSET'	=>'utf8',				//编码
					'DB_PREFIX'		=>'',					//表前缀
				],
				'REDIS' => [
				],
				'MEMCACHE' => [
				],
			);
		}
	}