



<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>



	<div class="row">
		<div class="col-lg-6">
			<?= form_error('role','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Error ! </strong> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>' , '</div>'); ?>
				
				<!-- menerima pesan menampilkanya saat gagal atau success update -->
				<?= $this->session->flashdata('message'); ?>
				<a href="" class="btn btn-outline-primary mb-3 " data-toggle="modal" data-target="#newAddRole">Add New Role</a>
				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Role</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php foreach ($role as $rl ): ?> <!-- $menu didapat dr contioller menu.php -->
						<tr>
							<th scope="row"><?= $i; ?></th>
							<td><?= $rl['role']; ?></td>
							<td>
								<a class="badge badge-warning" href="<?= base_url('admin/roleaccess/'). $rl['id']; ?>">Access</a> <!-- berpindah ke halaman access yg sesui id -->
								<a class="badge badge-success" href="<?= base_url(); ?>admin/roleedit/<?= $rl['id']; ?>">Edit</a>
								<a class="badge badge-danger" href="<?= base_url(); ?>admin/deleteRole/<?= $rl['id']; ?>" onclick="return confirm('Are you sure delete <?=$rl['role']; ?> role ?') "  >Delete</a>
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
<div class="modal fade" id="newAddRole" tabindex="-1" role="dialog" aria-labelledby="newRoleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="newRoleModalLabel">Add New Role</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('admin/role'); ?>" method="post">
				
				<div class="modal-body">
					<div class="form-group">
						<input type="text" class="form-control" id="role" name="role" placeholder="Role Name">
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

