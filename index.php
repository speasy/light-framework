<?php
	/**
	 * 前台入口文件
	 */
	define('TOKEN',true);
	//定义应用目录，以小驼峰法命名，最有以‘/’结尾
	define('APP_ROOT','./Apps/Index/');
	//开启调试
	define('APP_DEBUG',true);
	//加载框架入口文件
	require './Core/Init.php';
