
<?php 
// print_r($list_of_user);
?>


<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

	<div class="row">
		<div class="col-lg-10">
			<?php if (validation_errors()): ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert" >
					<strong>Error ! </strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close" >
						<span aria-hidden>&times;</span>
					</button>
					<?=validation_errors(); ?>
				</div>
			<?php endif; ?>
			<?= $this->session->flashdata('message'); ?>
			<table class="table table-hover">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Name</th>
						<th scope="col">Email</th>
						<th scope="col">Role</th>
						<th scope="col">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$no=0;
					foreach ($list_of_user as $lu) :
						$no++
						?>
						<tr>
							<th scope="row"><?= $no; ?></th>
							<td><?= $lu['name']; ?></td>
							<td><?= $lu['email']; ?></td>
							<td><?= $lu['role']; ?></td>
							<td>
								<a href="<?=base_url() ?>admin/userlistedit/<?=$lu['id']; ?>" class="badge badge-success">Edit</a>
								<a href="<?=base_url() ?>admin/deleteuser/<?=$lu['id']; ?>" onclick="return confirm('Are you sure delete this item')" class="badge badge-danger"  >Delete</a>
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

