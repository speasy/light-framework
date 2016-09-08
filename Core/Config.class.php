<?php
	/**
	 * 框架默认配置文件参数
	 * usage:require/include
	 */
	namespace Core;
	defined('TOKEN') || exit();
	class Config {
		/**
			* @Brief  通用配置
			*
			* @Returns   
		 */
		static public function getGeneralConf() {
			return [
				//框架配置
				'DEFAULT_CREATE_DIRS' => ['Common','Conf','Controller','Model','View','Runtime','Public','Upload'],//默认在每个应用下面创建的目录名
				'CONFIRM_RESOURCE_DIR' => ['Public',['Js','Css','Images']],//确定DEFAULT_CREATE_DIRS中那个目录存放静态资源文件
				'DIR_SECURE_FILENAME' => 'index.html',//目录安全文件,TODO 可以在入口文件中通过define('DIR_SECURE_FILENAME', 'default.html');修改
				//具体数据库到数据库类别映射
				'TYPE_MAP' => [
					'Db' => ['MySQL','MySQLi'],
					'Cache' => ['File','Memcache','Redis'],
				],
				//数据库驱动容错映射
				'DRIVER_MAP' => [
					'Mysqli'=> ['mysql','mysqli'],
					'File' => ['file'],
					'Memcache' => ['memcache'],
					'Redis' => ['redis'],
				],
			];
		}


		static public function getDbConf() {
			return [
				'Db_TYPE' => 'MySQL',					//数据库类型 TODO 暂时只支持MySQL
				'RW_SEPARATE' => false,                 //读写分离
				//各种数据库配置文件
				'MYSQL_POOL' => [//MySQL连接池
					//数据库配置
					'DEFAULT_SERVER' =>1,//默认使用第一台服务器
					[//MySQL Server ID.1
						'DB_ID'			=>1,
						'DB_HOST'		=>'localhost',					//数据库地址
						'DB_USER'		=>'root',					//用户名
						'DB_PWD'		=>'root888',					//密码
						'DB_PORT'		=>'3306',					//端口
						'DB_NAME'		=>'chat',					//数据库名
						'DB_CHARSET'	=>'utf8',				//编码
						'DB_PREFIX'		=>'',					//表前缀
					],
					//etc.
				],
			];
		}

		static public function getCacheConf() {
			return [
				'Db_TYPE' => 'Redis', 			//缓存类型
				'REDIS_POOL' => [//Redis连接池
				],
				'MEMCACHE' => [//Memcache连接池
				],
			];
		}
	}
