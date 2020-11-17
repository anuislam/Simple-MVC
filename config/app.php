<?php 
return [
	'aliases' 			=> [
		'Validation' 	=> Src\request\formvalidation\Validation::class,
		'Route' 		=> Src\route\Route::class,
		'Dispatch' 	 	=> Src\route\Dispatch::class,
		'Config' 	 	=> Src\Config::class,
		'Dbconnect' 	=> Model\db\Dbconnect::class,
		'DB' 			=> Model\db\DB::class,
		'User' 			=> Model\user\User::class,
		'Controller' 	=> Controller\Controller::class,
		'Redirect' 	    => Src\request\Redirect::class,
		'Role' 			=> Model\user\Role::class,
		'FormRule' 		=> Src\request\formvalidation\formRule\FormRule::class,
		'ErrorPage' 	=> Controller\Page404Controller::class,
		'Form' 			=> Src\html\Form::class,
		'Html' 			=> Src\html\Html::class,
		'Event' 		=> Src\event\Event::class,
		'PHPMailer' 	=> PHPMailer\PHPMailer\PHPMailer::class,
		'EmailSMTP' 	=> PHPMailer\PHPMailer\SMTP::class,
		'EmailException'=> PHPMailer\PHPMailer\Exception::class,
		'Email'			=> Src\email\Email::class,
	],





	'middleware' 		=>[
		'Auth'			=> Src\middleware\loginCheckMiddleware::class,
		'Guest'			=> Src\middleware\GuestMiddleware::class,
		'Csrf'			=> Src\middleware\CsrftMiddleware::class,
	]
];