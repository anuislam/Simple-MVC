<!-- DataTales Example -->
<div class="card shadow mb-4">
<div class="card-header py-3">
  <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
</div>
<div class="card-body">
  <div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" csrf="<?php echo csrf_token('csrf_token'); ?>">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Mobile</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>

      	<?php 
      		  $emple_count = count($emple_get);

      		  if ($emple_count > 1) {
      		  	foreach ($emple_get as $key => $value) {
		?>


		        <tr>
		          <td><?php echo $value->fname .' '. $value->lname; ?></td>
		          <td><?php echo $value->email; ?></td>
		          <td><?php echo $value->mobile; ?></td>
		          <th>
                <?php Html::a(url('edit-profile-other', ['id' => $value->ID]), 'View', [
                  'class' => 'btn btn-primary'
                ]); ?>
		          	<a href="javascript:void(0)" delete_user="alluser_delete" class="btn btn-danger">Delete
                  <form class="d-none" action="<?php echo url('delete-profile-other', ['id' => $value->ID]); ?>" method="post">
                    <input type="hidden" name="request_method" value="delete" >
                  </form>
                </a>
		          </th>
		        </tr>


		<?php
      		  	}
      		  }

      	?>


      </tbody>
    </table>
  </div>
</div>
</div>
