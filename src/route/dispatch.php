<?php
namespace Src\route;
use Src\Config;
/**
 * route dispatch
 */
class Dispatch extends Route{
	
	private $controller_namespace;

	function __construct(){
		$this->controller_namespace = 'Controller\\';
	}
	public function run(){
		$parsed_url = parse_url($_SERVER['REQUEST_URI']);
	    if(isset($parsed_url['path'])){
	      $path = $parsed_url['path'];
	    }else{
	      $path = '/';
	    }

	    $route_match_found 	= false;
	    $match_route 		= [];

	    $routes    = config('routes');
	    $datamatch = [];

	    foreach($routes as $key => $route){

		    $route['regex'] = '^'.$route['regex'];
		    $route['regex'] =  $route['regex'].'$';

		    if ($route['route_name'] == $path) {
				if($this->checkMethod($route['method']) ===  true){
					$route_match_found = true;
					$match_route = $route;
					break;	    		
				}
		    }

	    	if(preg_match('#'.$route['regex'].'#',$path,$matches)){   		

	    		if($this->checkMethod($route['method']) ===  true){
					array_shift($matches);
	    			$route_match_found = true;
	    			$match_route = $route;
	    			$datamatch = $matches;
	    			break;	    		
	    		}
	    	}
	    }
	    if ($route_match_found === true) {
	  
	    	$this->loadController($match_route, $datamatch);

	    }else{
	    	header("HTTP/1.0 404 Not Found");
	    }
		//return $routes;
	}

	public function loadController($route, $perameter){

		$controller = $route['controller'];
		$method = $controller[1];
		$load = $this->controller_namespace.$controller[0];
		$load = new $load();
		$load->$method($route, $perameter);
		die();
	}

	public function checkMethod($method){		
	    $server_method 	= strtolower($_SERVER['REQUEST_METHOD']);
	    $method 		= strtolower($method);
	    if ($server_method == 'post') {
	    	if ($method == 'post') {
	    		return true;
	    	}else if($method == 'patch'){
	    		return true;
	    	}else if($method == 'delete'){
	    		return true;
	    	}else if($method == 'put'){
	    		return true;
	    	}
	    }else if ($server_method == 'get') {
	    	if ($method == 'get') {
	    		return true;
	    	}
	    }

	    return false;
	}
}