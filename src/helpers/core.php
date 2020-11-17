<?php 

function load_aliases(){
	$aliases = config('aliases', 'app');
	foreach ($aliases as $key => $value) {
		class_alias($value, $key);
	}
}

function middleware($name){
	$middleware = config('middleware', 'app');
	if (!$name === false) {
		if (is_array($name) === true) {
			foreach ($name as $key => $value) {
				(new $middleware[$value])->handle();			
			}
		}else{
			(new $middleware[$name])->handle();
		}
	}
}