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
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">Welcome to our website!</h1>
                </div>
                <?php Form::put(url('registerValidation'), ['class' => 'user']); ?>


                  <div class="form-group">

                  <?php
                  $error = get_error('email') ? 'is-invalid' : false;
                   Form::email('email', field_data('email'), [
                      'class' => 'form-control form-control-user '.$error,
                      'placeholder' => 'Enter Email Address...',
                    ]); ?>

                  <?php Form::bootstrap_field_error('email'); ?>

                  </div>

                  <div class="form-group">

                  <?php  $error = get_error('password') ? 'is-invalid' : false;
                   Form::password('password',[
                      'class' => 'form-control form-control-user '.$error,
                      'placeholder' => 'Password',
                    ]); ?>

                  <?php Form::bootstrap_field_error('password'); ?>
                    

                  </div>

                  <div class="form-group">
                  <?php  $error = get_error('confirm_password') ? 'is-invalid' : false;
                   Form::password('confirm_password',[
                      'class' => 'form-control form-control-user '.$error,
                      'placeholder' => 'Confirm Password',
                    ]); ?>

                  <?php Form::bootstrap_field_error('confirm_password'); ?>

                  </div>

                  <?php Form::button('Register', ['class' => 'btn btn-primary btn-user btn-block']); ?>
                
                <?php Form::close(); ?>

                <hr>
                <div class="text-center">
                  <a class="small" href="<?php echo url('forgot-password'); ?>">Forgot Password?</a>
                </div>
                <div class="text-center">
                  <a class="small" href="<?php echo url('login'); ?>">Login here</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>