<?php
	/**
	 * sql语句记录类
	 **/
	namespace Core\Library\Plugin;
	defined('TOKEN') || exit();

	/**
	 * 调用方式:
	 * $ins = LogTool::getIns();
	 * $ins->log($data);
	 **/
	final class LogTool {
		private $rs = null;//文件资源
		const FNAME = '/log/tmp.log';//TODO  被包含脚本中还包含文件时,注意其basedir永远为当前工作目录
		static private $ins = null;//保持对象实例

		//封死__construct
		final private function __construct() {
		}

		//打开文件
		private function open() {
			$this->rs = fopen(ROOT.self::FNAME,'a+');
		}

		//写入数据
		private function write($str = '') {
			fwrite($this->rs,$str);
		}

		//判断文件大小，是否要备份
		private function isbak() {
			$fname = ROOT.self::FNAME;//文件名
			if(!is_dir($dir = dirname($fname))) {
				mkdir($dir,0777,true);
			}
			if(!is_file($fname)) {
				touch($fname);
			}
			$size = filesize($fname);//单位:bytes
			//大于1M就备份 1024*1024
			if($size >= 1024*1024) {
				//TODO 如何生成唯一的文件名
				$nurl = substr($fname,0,-4).'&'.mt_rand(1,100000).'&'.date('Ymdhis',time()).'&'.mt_rand(1,10000).'&'.'.log.bak';
				copy($fname,$nurl);
				unlink($fname);
			}
			//如果小于1M什么都不做
		}

		//log()可以外部调用
		public function log($str = '') {
			$this->isbak();
			$this->open();
			$str .= "\r\n";
			$this->write($str);
			$this->close();
		}

		//获取单例
		static public function getIns() {
			if(empty(self::$ins) || !(self::$ins instanceof self)) {
				self::$ins = new self();
			}
			return self::$ins;
		}

		//关闭文件资源
		private function close() {
			fclose($this->rs);
		}

		//禁止克隆对象
		public function __clone() {
			trigger_error('Inhibit clone this LogTool Object!');
		}
	}
