<!-- Outer Row -->
<div class="row justify-content-center">

  <div class="col-xl-10 col-lg-12 col-md-9">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
          <div class="col-lg-6">

            <div class="p-5">
              <div class="text-center pb-5">
                  <h1 class="h4 text-gray-900 mb-2">Reset Your Password?</h1>
              </div>
              
                <?php Form::patch(url('reset-password-update'), ['class' => 'user']); ?>
                <?php Form::hidden('email', $email); ?>
                <?php Form::hidden('token', $token); ?>
                  <div class="form-group">
                  <?php
                  $error = get_error('new_password') ? 'is-invalid' : false;
                   Form::password('new_password', [
                      'class' => 'form-control form-control-user '.$error,
                      'placeholder' => 'New password',
                    ]); ?>
                  <?php Form::bootstrap_field_error('new_password'); ?>
                  </div>
                  <div class="form-group">
                  <?php
                  $error = get_error('confirm_password') ? 'is-invalid' : false;
                   Form::password('confirm_password', [
                      'class' => 'form-control form-control-user '.$error,
                      'placeholder' => 'Confirm password',
                    ]); ?>
                  <?php Form::bootstrap_field_error('confirm_password'); ?>
                  </div>

                  <?php Form::button('Reset Password', ['class' => 'btn btn-primary btn-user btn-block']); ?>
              <?php Form::close(); ?>
              <hr>
              <div class="text-center">
                  <a class="small" href="<?php echo url('register'); ?>">Create an Account!</a>
              </div>
              <div class="text-center">
                  <a class="small" href="<?php echo url('login'); ?>">Already have an account? Login!</a>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div>

</div>
