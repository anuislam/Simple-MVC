<?php 


Route()->get('/', 'Maincontroller@index')
	->name('index')
	->exe();

Route()->get('/home', 'Maincontroller@index')
	->name('home')
	->exe();

Route()->get('/post/{id}', 'PostController@single')
	->name('single_post')
	->where('id', 'numeric')
	->exe();

