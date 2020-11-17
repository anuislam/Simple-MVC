<?php 


Route()->get('/', 'Maincontroller@index')
	->name('index')
	->middleware('Auth')
	->exe();

Route()->get('/add-new-user', 'newUserController@addNew')
	->name('add_new_user')
	->middleware('Auth')
	->exe();

Route()->put('/add-new-user', 'newUserController@addNewInsert')
	->name('add_new_user_update')
	->middleware(['Auth', 'Csrf'])
	->exe();

Route()->get('/login', 'LoginController@login')
	->name('login')
	->middleware('Guest')
	->exe();

Route()->post('/login', 'LoginController@loginValidation')
	->name('login_create')
	->middleware(['Guest', 'Csrf'])
	->exe();

Route()->delete('/logout', 'LoginController@logout')
	->name('logout')
	->middleware(['Auth', 'Csrf'])
	->exe();

Route()->get('/register', 'LoginController@register')
	->name('register')
	->middleware('Guest')
	->exe();

Route()->put('/register', 'LoginController@registerValidation')
	->name('registerValidation')
	->middleware(['Guest', 'Csrf'])
	->exe();


Route()->get('/reset-password', 'LoginController@resetPassword')
	->name('reset-password')
	->middleware(['Guest'])
	->exe();

Route()->patch('/reset-password', 'LoginController@resetPasswordUpdate')
	->name('reset-password-update')
	->middleware(['Guest', 'Csrf'])
	->exe();

Route()->get('/forgot-password', 'LoginController@forgotPassword')
	->name('forgot-password')
	->middleware(['Guest'])
	->exe();

Route()->patch('/forgot-password', 'LoginController@forgotPasswordUpdate')
	->name('forgot-password-update')
	->middleware(['Guest', 'Csrf'])
	->exe();

Route()->get('/edit-profile', 'ProfileController@edithProfile')
	->name('edit-profile')
	->middleware('Auth')
	->exe();

Route()->patch('/edit-profile', 'ProfileController@updateProfile')
	->name('update-profile')
	->middleware(['Auth', 'Csrf'])
	->exe();

Route()->get('/edit-profile/{id}', 'ProfileController@edithProfileOther')
	->name('edit-profile-other')
	->where('id', 'numeric')
	->middleware('Auth')
	->exe();

Route()->patch('/edit-profile/{id}', 'ProfileController@updateProfileOther')
	->name('update-profile-other')
	->where('id', 'numeric')
	->middleware(['Auth', 'Csrf'])
	->exe();

Route()->delete('/edit-profile/{id}', 'ProfileController@deleteProfileOther')
	->name('delete-profile-other')
	->where('id', 'numeric')
	->middleware(['Auth', 'Csrf'])
	->exe();

Route()->get('/all-users', 'AllUsersController@allUsers')
	->name('all_users')
	->middleware('Auth')
	->exe();

Route()->get('/change-password', 'ChangePasswordController@ChangePassword')
	->name('change_password')
	->middleware('Auth')
	->exe();

Route()->patch('/change-password', 'ChangePasswordController@ChangePasswordUpdate')
	->name('change_password_update')
	->middleware(['Auth', 'Csrf'])
	->exe();


