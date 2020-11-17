<?php
namespace Src\route;
/**
 * url management
 */
class Route{

	private $routes;
	private $name;
	private $routeexp;
	private $controller;
	private $where;
	private $method;
	private $middleware;
	
	function __construct(){
		$this->routes = [];
		$this->controller = [];
		$this->routeexp = '';
		$this->name = '';
		$this->where = [];
		$this->method = '';
		$this->middleware = false;
	}

	public function url($name, $data = []){
		$routeConf = config('routes');
		$check = ltrim($routeConf[$name]['route_name'], '/');
		if (count($data) > 0) {
			foreach ($data as $key => $value) {
				$check = str_replace('{'.$key.'}', $value, $check);
			}
		}
		return $check;
	}

	public function get($routeexp, $controller){
		$this->controller 	= explode('@', $controller);
		$this->routeexp 	= $routeexp;
		$this->method 		= 'get';
		return $this;
	}

	public function post($routeexp, $controller){
		$this->controller 	= explode('@', $controller);
		$this->routeexp 	= $routeexp;
		$this->method 		= 'post';
		return $this;
	}

	public function put($routeexp, $controller){
		$this->controller 	= explode('@', $controller);
		$this->routeexp 	= $routeexp;
		$this->method 		= 'put';
		return $this;
	}
	public function patch($routeexp, $controller){
		$this->controller 	= explode('@', $controller);
		$this->routeexp 	= $routeexp;
		$this->method 		= 'patch';
		return $this;
	}
	public function delete($routeexp, $controller){
		$this->controller 	= explode('@', $controller);
		$this->routeexp 	= $routeexp;
		$this->method 		= 'delete';
		return $this;
	}

	public function name($name){
		$this->name = $name;
		return $this;
	}

	public function where($where, $val){
		$this->where[$where] = $val;
		return $this;
	}

	public function exe(){
		$routeConf = config('routes');
		$routeConf[$this->name] = [
			'controller' 	=> $this->controller,
			'route_name' 	=> $this->routeexp,
			'name' 			=> $this->name,
			'where' 		=> $this->where,
			'method' 		=> $this->method,
			'regex' 		=> $this->makeRegex(),
			'middleware' 		=> $this->middleware,
		];
		configSet('routes', $routeConf);
		return false;
	}

	private function makeRegex(){
		$ret 		= '';
		$expession 	= $this->routeexp;
		$where 		= $this->where;
		if (empty($where) === false) {
			foreach ($where as $key => $value) {
				if ($value == 'numeric') {
					$value = '([0-9]*)';
				}else if ($value == 'alpha'){
					$value = '([a-z]*)';
				}else if ($value == 'alpha_num'){
					$value = '([0-9a-z]*)';
				}
				if (empty($ret) === false) {
					$ret = str_replace('{'.$key.'}', $value, $ret);
				}else{
					$ret = str_replace('{'.$key.'}', $value, $expession);
				}
			}
		}
		return $ret;
	}

	public function middleware($data){
		$this->middleware = $data;
		return $this;
	}

}