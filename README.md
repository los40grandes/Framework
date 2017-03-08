# Framework
Testing OOP and design patters by building a framework

1. Creating a structure for the framework. At this point we set the base of folder strucuture - we can edit it later on :).
<ul>
<li>public > index.php (bootstrap file), assets > css, js</li>
<li>controllers</li>
<li>views</li>
<li>routes</li>
<li>models</li>
<li>core</li>
</ul>

2. Create the App building class that builds all the framework. We make it as a singleton in order to run only once as no we don't need it to run more times right?
<ul>
<li>set the namespace of the file.</li>
<li>build the getInstance method.
<li>build the run method.</li>
<li> include the file in the bootstrap index.php -- <i>include realpath(__DIR__.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'app.php')</i> --</li>
<?php
namespace framework\core;

class app {

	private static $_instance = null;
	
	private function __construct(){

	}

	public function run(){
		echo 'ok';
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

We build the namespace to use build the autoloading fuctionality.

<h3><strong> Autoloading</strong></h3>
1. We create the loader class in the core directory of our app.
2. spl_autoload_register - accepts either a function and returns a class name via a variable $class or accepts array when working with classes (first argument is the location of the class or namespace/$className, method_of_the_class)
3. we echo to see if we load get the class name as a return of the autoload function.
4. Create the method <strong>registerNamespace</strong> which allows us to register the namespaces and directories of the php files.
	4.1 This allows us to save the namespace as the "key" of the array and the path as the "value" of the array which we later on use to check and load the class (php file).
5. Create the method <strong>autoload</strong> which acts as a callback function to the __construct.
6. Create method <strong>loadClass</strong> which checks if the class we have received from spl_autoload_register has been register trough <strong>registerAutoload</strong>.
	6.1 if the namespace has been registered then we have the path as per "4." and "4.1", so we substitute the namespace with the full path to the file and we add ".php" extension.
	6.2 else we throw an exception.

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
