<?php
	/**
	 * 初始化文件Init.php
	 */
	//定义TOKEN常量
	defined('TOKEN') || exit('Access refused!');
	//开启session
	session_start();
	header('Content-Type:text/html;charset=utf-8');
	//设置时区（中国）
	date_default_timezone_set("PRC");
	
	//定义网站根目录,最后面有 '/'
	define('ROOT',str_replace('\\','/',dirname(dirname(__FILE__))).'/');//todo 何时绝对路径 何时相对路径??
	//定义框架目录,最后面有 '/'
	define('CORE_ROOT',ROOT.'Core/');
	//定义应用(模块)名称
	define('APP_NAME',ucfirst(substr(strrchr(substr(APP_ROOT,0,-1),'/'),1)));

	//DEBUG设置
	error_reporting(E_ALL | E_STRICT);
	if(!defined('APP_DEBUG') || (constant('APP_DEBUG') != true)) {//如果设置APP_DEBUG常量，则判断APP_DEBUG常量的值
		ini_set('display_errors',0);
		ini_set('log_errors',1);
		ini_set('error_log','./test.txt');//TODO
	}
	
	//自动记载框架类文件，模块控制器，模型类文件  Lazy Loading
	spl_autoload_extensions('.class.php');//注册并返回spl_autoload函数使用的默认文件扩展名
	spl_autoload_register(function($className) {//把匿名函数注册到__autoload队列
		/**
		* All namespace:
		* Core
		* Core\Library
		* Core\Library\Plugin
		* Core\Library\Db
		*
		* todo 使用 namespace关键字修改
		* todo 根据加载顺序 对下列else 进行微调
		* todo require带有命名空间的file，使用三种中的那种效率比较高？？
		*/
		//对命名空间进行解析
		$flag = array_slice(explode('\\',$className),-2,1)[0];
		echo '统计的标记:',$flag,"&nbsp;&nbsp;文件名:",$className,'.class.php','<br />';

		$proCN = array_slice(explode('\\',$className),-1,1)[0];//由非限定，限定，完全限定命名文件获取文件名
		if($flag === 'Controller') {		//应用目录的Controller下
			spl_autoload(APP_ROOT.'Controller/'.$proCN);//todo APP_ROOT为相对路径 CORE_ROOT为绝对路径，那个效率高些？？ sql_autoload加载时include的顺序
		} else if($flag === 'Model') {		//应用目录的Model下
			spl_autoload(APP_ROOT.'Model/'.$proCN);	
		} else if($flag === 'Conf') {		//应用Conf目录下
			spl_autoload(APP_ROOT.'Conf/'.$proCN);
		} else if($flag === 'Core') {		//框架Core目录下
			spl_autoload(CORE_ROOT.$proCN);
		} else if($flag === 'Library') {	//框架Core/Library目录下
			spl_autoload(CORE_ROOT.'Library/'.$proCN);
		} else if($flag === 'Db') {			//框架Core/Library/Db目录下
			spl_autoload(CORE_ROOT.'Library/Db/'.$proCN);
		} else if($flag === 'Plugin') {		//框架Core/Library/Plugin目录下
			spl_autoload(CORE_ROOT.'Library/Plugin/'.$proCN);
		}
	},true,false);


	try {
		//第一次访问入口文件时创建目录及文件
		\Core\BaseLib::init_dir();//TODO 完全限定名称 限定名称？

		//定义REWRITE模式 SCHEMA://hostname/index.php（或者其他应用入口文件）/模块/控制器/操作/[参数名/参数值...]
		/**
		* eg:localhost/chat/index.php 转入 localhost/chat/index.php/index/index/index
		*/
		\Core\BaseLib::dispatch();
	} catch (ConfException $e) {//配置文件异常
	} catch (Exception $e) {//后备捕捉器，正常情况下不会被条用
	}
