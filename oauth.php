<?php
namespace oauth;
require_once(dirname(__FILE__).'/src/OAuth2/Autoloader.php');

//echo dirname(__FILE__).'/src/OAuth2/Autoloader.php';
//require_once(dirname(__FILE__).'/config.php');
\OAuth2\Autoloader::register();

// register test classes
\OAuth2\Autoloader::register(dirname(__FILE__).'/lib');

// register vendors if possible
if (file_exists(__DIR__.'/../vendor/autoload.php')) {
    require_once(__DIR__.'/../vendor/autoload.php');
}
class server{
	public $storage,$server;
	public function __construct($db){
		$storage = new \OAuth2\Storage\Pdo($db);
		$server = new \OAuth2\Server($storage);
		$server->addGrantType(new \OAuth2\GrantType\ClientCredentials($storage));
		$server->addGrantType(new \OAuth2\GrantType\AuthorizationCode($storage)); // or any grant type you like!
		$this->storage=$storage;
		$this->server=$server;
	}
	public function rtToken(){
		$this->server->handleTokenRequest(\OAuth2\Request::createFromGlobals())->send();
	}
	public function TreSource(){
		
		if(!$this->server->verifyResourceRequest(\OAuth2\Request::createFromGlobals())){
			$this->server->getResponse()->send();
			die;
		}
		echo json_encode(array('success'=>true,'message'=>'you API'));exit;
	}
	
}

//$server = new server($db);

