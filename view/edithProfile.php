<div class="row">
<div class="col-md-8">
	<div class="card shadow mb-4">
	    <div class="card-header py-3">
	      <h6 class="m-0 font-weight-bold text-primary">first name last name</h6>
	    </div>
	    <div class="card-body">

				<?php Form::patch(url('update-profile').@$editbleUser); ?>
				
				<?php if ($edithUserData->profile_pic): ?>
					
				<div class="form_froup">
					<?php Html::img($edithUserData->profile_pic, [
						'alt' 	=> $edithUserData->fname.' '.$edithUserData->lname,
						'class' => 'img-thumbnail',
						'style' => 'max-width: 200px;max-height: 200px;',
					]); ?>
				</div>

				<?php endif ?>

				<div class="form-group">						
						
					<?php Form::label('profile_picture', 'Profile picture'); ?>
					<?php $error = get_error('profile_picture') ? 'is-invalid' : false;
                   	Form::text('profile_picture', $edithUserData->profile_pic, [
                      'class' => 'form-control form-control-user '.$error,
                      'placeholder' => 'Profile picture',
                    ]); 
                    Form::bootstrap_field_error('profile_picture'); ?>

				</div>

				<div class="form-group">
					<?php Form::label('first_name', 'First name'); ?>
					<?php $error = get_error('first_name') ? 'is-invalid' : false;
                   	Form::text('first_name', $edithUserData->fname, [
                      'class' => 'form-control form-control-user '.$error,
                      'placeholder' => 'First name',
                    ]); 
                    Form::bootstrap_field_error('first_name'); ?>
				</div>

				<div class="form-group">
					<?php Form::label('last_name', 'Last name'); ?>
					<?php $error = get_error('last_name') ? 'is-invalid' : false;
                   	Form::text('last_name', $edithUserData->lname, [
                      'class' => 'form-control form-control-user '.$error,
                      'placeholder' => 'Last name',
                    ]); 
                    Form::bootstrap_field_error('last_name'); ?>
				</div>

				<div class="form-group">
					<?php Form::label('email', 'Email address'); ?>
					<?php $error = get_error('email') ? 'is-invalid' : false;
                   	Form::email('email', $edithUserData->email, [
                      'class' => 'form-control form-control-user '.$error,
                      'placeholder' => 'Email address',
                    ]); 
                    Form::bootstrap_field_error('email'); ?>
				</div>

				<div class="form-group">
					<?php Form::label('mobile_number', 'Mobile number'); ?>
					<?php $error = get_error('mobile_number') ? 'is-invalid' : false;
                   	Form::text('mobile_number', $edithUserData->mobile, [
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
