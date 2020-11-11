<?php 
function Route(){
	return new Src\route\Route();
}
function config($option, $file = 'config'){
	return Src\Config::get($option, $file);
}

function configSet($option, $value, $file = 'config'){
	return Src\Config::set($option, $value, $file);
}