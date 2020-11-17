<div class="row">
<div class="col-md-8">
	<div class="card shadow mb-4">
	    <div class="card-header py-3">
	      <h6 class="m-0 font-weight-bold text-primary">first name last name</h6>
	    </div>
	    <div class="card-body">

				<?php Form::put(url('add_new_user_update')); ?>

				<?php if (field_data('profile_picture')): ?>
					
				<div class="form_froup">
					<?php Html::img(field_data('profile_picture'), [
						'alt' 	=> 'Add new user',
						'class' => 'img-thumbnail',
						'style' => 'max-width: 200px;max-height: 200px;',
					]); ?>
				</div>

				<?php endif ?>

				<div class="form-group">						
						
					<?php Form::label('profile_picture', 'Profile picture'); ?>
					<?php $error = get_error('profile_picture') ? 'is-invalid' : false;
                   	Form::text('profile_picture', field_data('profile_picture'), [
                      'class' => 'form-control form-control-user '.$error,
                      'placeholder' => 'Profile picture',
                    ]); 
                    Form::bootstrap_field_error('profile_picture'); ?>

				</div>

				<div class="form-group">
					<?php Form::label('first_name', 'First name'); ?>
					<?php $error = get_error('first_name') ? 'is-invalid' : false;
                   	Form::text('first_name', field_data('first_name'), [
                      'class' => 'form-control form-control-user '.$error,
                      'placeholder' => 'First name',
                    ]); 
                    Form::bootstrap_field_error('first_name'); ?>
				</div>

				<div class="form-group">
					<?php Form::label('last_name', 'Last name'); ?>
					<?php $error = get_error('last_name') ? 'is-invalid' : false;
                   	Form::text('last_name', field_data('last_name'), [
                      'class' => 'form-control form-control-user '.$error,
                      'placeholder' => 'Last name',
                    ]); 
                    Form::bootstrap_field_error('last_name'); ?>
				</div>

				<div class="form-group">
					<?php Form::label('email', 'Email address'); ?>
					<?php $error = get_error('email') ? 'is-invalid' : false;
                   	Form::email('email', field_data('email'), [
                      'class' => 'form-control form-control-user '.$error,
                      'placeholder' => 'Email address',
                    ]); 
                    Form::bootstrap_field_error('email'); ?>
				</div>

				<div class="form-group">
					<?php Form::label('password', 'Password'); ?>
					<?php $error = get_error('password') ? 'is-invalid' : false;
                   	Form::password('password', [
                      'class' => 'form-control form-control-user '.$error,
                      'placeholder' => 'Password',
                    ]); 
                    Form::bootstrap_field_error('password'); ?>
				</div>

				<div class="form-group">
					<?php Form::label('confirm_password', 'Confirm Password'); ?>
					<?php $error = get_error('confirm_password') ? 'is-invalid' : false;
                   	Form::password('confirm_password', [
                      'class' => 'form-control form-control-user '.$error,
                      'placeholder' => 'Confirm Password',
                    ]); 
                    Form::bootstrap_field_error('confirm_password'); ?>
				</div>

				<div class="form-group">
					<?php Form::label('mobile_number', 'Mobile number'); ?>
					<?php $error = get_error('mobile_number') ? 'is-invalid' : false;
                   	Form::text('mobile_number', field_data('mobile_number'), [
                      'class' => 'form-control form-control-user '.$error,
                      'placeholder' => 'Mobile number',
                    ]); 
                    Form::bootstrap_field_error('mobile_number'); ?>
				</div>
				<?php Form::button('Submit', ['class' => 'btn btn-primary']); ?>
			<?php Form::close(); ?>
	    </div>
	  </div>
  </div>
</div>
