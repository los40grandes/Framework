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


