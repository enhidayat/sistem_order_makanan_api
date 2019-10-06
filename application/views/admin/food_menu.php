



<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>



	<div class="row">
		<div class="col-lg-6">

			<?php if (validation_errors()) : ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>Error ! </strong> 
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<?= validation_errors(); ?>
				</div>
			<?php endif; ?>

			<?= $this->session->flashdata('message'); ?> 
			<a href="" class="btn btn-outline-primary mb-3 " data-toggle="modal" data-target="#newAddMenu">Add New Menu</a>
			<table class="table table-hover">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Menu</th>
						<th scope="col">Status</th>
						<th scope="col">Price</th>
						<th scope="col">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $no=0; 
					foreach ($food_menu as $mn ):   
						$no++
						?>
						<tr>
							<th scope="row"><?= $no; ?></th>
							<td><?= $mn['foods_and_drinks']; ?></td>  <!-- //sampaisiniiii -->
							<td><?= $mn['status']; ?></td>  <!-- //sampaisiniiii -->
							<td><?= $mn['price']; ?></td>  <!-- //sampaisiniiii -->
							<td>
								<a class="badge badge-success" href="<?= base_url() ?>admin/foodmenuedit/<?=$mn['id']; ?>">Edit</a>
								<a class="badge badge-danger" onclick="return confirm('are you sure delete  <?=$mn['foods_and_drinks']; ?> Menu?')" href="<?= base_url(); ?>admin/deletefoodmenu/<?= $mn['id']; ?>">Delete</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal -->
<div class="modal fade" id="newAddMenu" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="newModalLabel">Add New Menu</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('admin/createfoodmenu'); ?>" method="post">
				
				<div class="modal-body">
					<div class="form-group">
						<input type="text" class="form-control" id="foods_and_drinks" name="foods_and_drinks" placeholder="Foods or drinks Name">
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="status" id="status" value="ready" checked>
						<label class="form-check-label" for="status">
							Ready
						</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="status" id="status" value="out of stock">
						<label class="form-check-label" for="status">
							Out of stock
						</label>
					</div><br>
					<div class="form-group">
						<input type="text" class="form-control" id="price" name="price" placeholder="price">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Add</button>
				</div>
			</form>
		</div>
	</div>
</div>

