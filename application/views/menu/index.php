



<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>



	<div class="row">
		<div class="col-lg-6">
			<?= form_error('menu','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Error ! </strong> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>' , '</div>'); ?>

				<?= $this->session->flashdata('message'); ?>
				<a href="" class="btn btn-outline-primary mb-3 " data-toggle="modal" data-target="#newAddMenu">Add New Menu</a>
				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Menu</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php foreach ($menu as $mn ): ?> <!-- $menu didapat dr contioller menu.php -->
						<tr>
							<th scope="row"><?= $i; ?></th>
							<td><?= $mn['menu']; ?></td>
							<td>
								<a class="badge badge-success" href="<?= base_url() ?>menu/edit/<?=$mn['id']; ?>">Edit</a>
								<a class="badge badge-danger" onclick="return confirm('are you sure delete  <?=$mn['menu']; ?> Menu?')" href="<?= base_url(); ?>menu/delete/<?= $mn['id']; ?>">Delete</a>
							</td>
						</tr>
						<?php $i++; ?>
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
			<form action="<?= base_url('menu'); ?>" method="post">
				
				<div class="modal-body">
					<div class="form-group">
						<input type="text" class="form-control" id="menu" name="menu" placeholder="Menu Name">
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

