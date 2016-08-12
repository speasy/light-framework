<?php
	/**
	 * 基础函数库类
	 * usage:require/include
	 */
	namespace Core;
	defined('TOKEN') || exit('Access refused!');
	class BaseLib {
		//对数组进行递归转义
		static public function _addslashes($arr = array()) {
			if(get_magic_quotes_gpc()) {
				return $arr;
			}
			if(is_array($arr)) {
				foreach($arr as $k=>$v) {
					if(is_array($v)) {
						$arr[$k] = self::_addslashes($v);//递归调用
					} else {
						$arr[$k] = addslashes($v);
					}
				}
			}
			return $arr;
		}

		//递归创建目录 注意当前目录
		static public function mk_dir($dirName = '',$mode = 0777) {
			if(is_dir($dirName)) {
				return true;
			}
			if(is_dir(dirname($dirName))) {
				return mkdir($dirName,$mode);
			}
			self::mk_dir(dirname($dirName));
			return mkdir($dirName,$mode);
		}

		//第一次访问入口文件时创建目录及文件
		static public function init_dir() {//使用函数可以避免创建一些不必要的变量，执行完毕就变量就销毁
			//创建对应应用下的目录
			if(!file_exists(APP_ROOT.'Lock.txt')) {
				$core_config = \Core\Config::getConf();
				self::mk_dir(APP_ROOT);
				touch(APP_ROOT.'Lock.txt');//创建Lock.txt文件，表示应用目录以及创建完毕，不需要每次创建
				touch(APP_ROOT.'index.html');//创建空白index.html，目录安全文件
				foreach($core_config['DEFAULT_CREATE_DIRS'] as $v) {
					self::mk_dir(APP_ROOT.$v);
					touch(APP_ROOT.$v.'/index.html');//创建空白index.html
				}

				$ns = APP_NAME.'\\'.'Controller';//TODO heredoc nowdoc 搞明白
				//创建controller目录下的IndexController.class.php文件
				$content = <<<EOF
<?php
	/**
	* 默认控制器
	*/
	namespace $ns;
	use \Core\Library\Controller as Controller;
	defined('TOKEN') || exit();
	class IndexController extends Controller {
		//默认操作
		public function index() {
			echo 'Install successfully!';
		}
	} 
EOF;
				self::initFile(APP_ROOT.'Controller/'.'IndexController.class.php',$content);

				//创建模块配置文件
				$ns = APP_NAME.'\\'.'Conf';

				$content = <<<EOF
<?php
	/**
	 * 应用的配置文件
	 * 格式:数组
	 */
	namespace $ns;
	defined('TOKEN') || exit();
	class Config {
		static public function getConf() {
			return array(
				/*
				usage:
				'DB_TYPE'		=>'',				//数据库类型
				'DB_HOST'		=>'',				//数据库地址
				'DB_NAME'		=>'',				//数据库名
				'DB_USER'		=>'',				//用户名
				'DB_PWD'		=>'',				//密码
				'DB_PORT'		=>'3306',			//端口
				'DB_CHARSET'	=>'utf8',			//编码
				'DB_PREFIX'		=>'',				//表前缀
				*/
			);
		}
	}
EOF;
				self::initFile(APP_ROOT.'Conf/'.'Config.class.php',$content);
			}
		}

		//框架初始化时创建脚本
		static public function initFile($url = '',$cont = '') {
			if(is_file($url)) {
				return true;
			}
			$rs = fopen($url,'w');
			fwrite($rs,$cont);
			fclose($rs);
		}

		//REWRITE 路由分发
		static public function dispatch() {//todo
			//todo rewrite这块要注意安全问题，防止被调用其他文件,并且逻辑要简化
			empty($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] = '/Index/Index/index';
			$rw = explode('/',substr($_SERVER['PATH_INFO'],1));
			//如果最后一个为空字符串，则直接删掉
			if(empty($rw[count($rw)-1])) {
				array_pop($rw);
			}
			//对MCA以及参数进行补全
			if(($n = count($rw)) < 3) {
				switch($n) {
					case 1:
						array_push($rw,'Index');
						array_push($rw,'index');
						break;
					case 2:
						array_push($rw,'index');
						break;
				}
			}

			//获取模块M，控制器C，操作A
			$M = ucfirst(array_shift($rw));
			$C = ucfirst(array_shift($rw));
			$A = array_shift($rw);

			//获取GET参数
			$args = array();
			if(!empty($rw)) {//todo 有问题 name和value没有在一起
				$args = array_column(array_chunk($rw,2,false),1,0);// 1->value 0->key
				//array_combine();//todo 框架改进 多用系统函数
			}

			//重写$_GET,$_POST,$_COOKIE
			$_GET = $args;
			//$_REQUEST = array_merge($_POST,$_GET,$_COOKIE);

			//对GPC超全局数组进行转义
			$_GET = self::_addslashes($_GET);
			$_POST = self::_addslashes($_POST);
			$_COOKIE = self::_addslashes($_COOKIE);//todo spl_autoload() 和require() 效率对比

			//执行对应控制器下的方法(最后调用)
			$cn = $M.'\\Controller\\'.$C.'Controller';//使用限定名称
			$obj = new $cn;//todo this writing type is so rubbish
			$obj->$A();
			/*
			(new $M.'\\Controller\\'.$C.'Controller')->$A();//TODO
			*/
		}
	}
