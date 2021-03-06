<?php

namespace framework\core;

final class loader{

	private static $namespace = array();

	private function __construct(){

	}

	public static function registerAutoload(){
		spl_autoload_register(array('\framework\core\loader','autoload'));
	}

	public static function autoload($class){
		self::loadClass($class);
	}

	public static function loadClass($class){
		foreach (self::$namespace as $key => $value) {
			if(strpos($class,$key) === 0){
				// echo $key.'<br>'.$value.'<br>'.$class.'<br>';
				$f=str_replace('\\', DIRECTORY_SEPARATOR,$class);
				// echo $f;
				$f=substr_replace($f, $value, 0, strlen($key)).'.php';
				// echo $f;
				$f=realpath($f);
				if ($f && is_readable($f)) {
					include $f;
				}
				else{
					throw new Exception('File cannot be included: '.$f);
				}
				break;
			}
		}
	}

	public static function registerNamespace($namespace, $path) {
		$namespace = trim($namespace);
		if (strlen($namespace)>0) {
			if(!$path){
				throw new Exception("Invalid path");
			}
			$_path = realpath($path);
			if($_path && is_dir($_path) && is_readable($_path)) {
				self::$namespace[$namespace.'\\'] = $_path.DIRECTORY_SEPARATOR;
			}
			else {
				//TODO
				throw new Exception("Namespace directory read error:".$path);
			}
		}
		else{
			//TODO
			throw new Exception("Invalid namespace:".$namespace);
			
		}
	}
}