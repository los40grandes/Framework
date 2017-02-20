<?php
namespace framework\core;
include 'loader.php';
class app {

	private static $_instance = null;
	
	private function __construct(){
		\framework\core\loader::registerNamespace('framework\core', dirname(__FILE__).DIRECTORY_SEPARATOR);
		\framework\core\loader::registerAutoload();
	}

	public function run(){

	}
	/**
	*
	* @return \framework\core\app
	*/
	public static function getInstance(){
		if(self::$_instance==null){
			self::$_instance= new \framework\core\app();
		}
		return self::$_instance;
	}
}