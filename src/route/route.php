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
	
	function __construct(){
		$this->routes = [];
		$this->controller = [];
		$this->routeexp = '';
		$this->name = '';
		$this->where = [];
		$this->method = '';
	}

	public function get($routeexp, $controller){
		$this->controller 	= explode('@', $controller);
		$this->routeexp 	= $routeexp;
		$this->method 		= 'get';
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

}