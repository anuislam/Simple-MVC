<?php
namespace Src\route;
use Dbconnect;
use ErrorPage;
/**
 * route dispatch
 */
class Dispatch extends Route{
	
	private $controller_namespace;

	function __construct(){
		$this->controller_namespace = 'Controller\\';
		if (empty($_REQUEST) === false) {
			$_SESSION['form']['data'] = $_REQUEST;
		}
	}

	public function path(){
		$parsed_url = parse_url($_SERVER['REQUEST_URI']);
	    if(isset($parsed_url['path'])){
	      $path = $parsed_url['path'];
	    }else{
	      $path = '/';
	    }
	    return $path;
	}

	public function run(){

	    $path = $this->path();

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

	    $conn = new Dbconnect();
	    $conn->db();
	    $errorPage = new ErrorPage();
	    
	    if ($route_match_found === true) {
	    	middleware($match_route['middleware']);
	    	$this->loadController($match_route, $datamatch);
	    }else{
	    	header("HTTP/1.0 404 Not Found");
	    	$errorPage->Page404();
	    }

	    $conn->close();    
		
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
	    	$request_method = strtolower($_POST['request_method']);
	    	if ($method == 'post') {
	    		return true;
	    	}else if($method == 'patch'){
	    		if ($request_method == 'patch') {
	    			return true;
	    		}
	    	}else if($method == 'delete'){
	    		if ($request_method == 'delete') {
	    			return true;
	    		}
	    	}else if($method == 'put'){
	    		if ($request_method == 'put') {
	    			return true;
	    		}
	    	}
	    }else if ($server_method == 'get') {
	    	if ($method == 'get') {
	    		return true;
	    	}
	    }

	    return false;
	}
}