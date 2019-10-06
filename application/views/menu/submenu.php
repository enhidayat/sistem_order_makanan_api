
<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>



	<div class="row">
		<div class="col-lg-10">

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
			<a href="" class="btn btn-outline-primary mb-3 " data-toggle="modal" data-target="#newAddSubmenu">Add New Submenu</a>
			<table class="table table-hover">			
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Title</th>
						<th scope="col">Menu</th>
						<th scope="col">URL</th>
						<th scope="col">Icon</th>
						<th scope="col">Active</th>
						<th scope="col">Action</th>
					</tr>
				</thead>
				<tbody>
					<!-- <?php $i=1; ?> -->
					<?php 
					$no = 0;
						foreach ($subMenu as $smn ): //$menu didapat dr contioller menu.php
						$no++
						?> 
						<tr>
							<th scope="row"><?= $no; ?></th>
							<td><?= $smn['title']; ?></td>
							<td><?= $smn['menu']; ?></td> <!-- seharusnya menu_id. diganti menu, karna mengambil dari join antar tb user_sub_meu & user_menu pd  menu_model -->
							<td><?= $smn['url']; ?></td>
							<td><?= $smn['icon']; ?></td>
							<td><?= $smn['is_active']; ?></td>
							<td>
								<a class="badge badge-success" href="<?= base_url(); ?>menu/submenuedit/<?=$smn['id']; ?>">Edit</a>
								<a class="badge badge-danger" onclick="return confirm('are you sure delete  <?=$smn['title']; ?> Submenu?');" href="<?= base_url(); ?>menu/deletesubmenu/<?=$smn['id'] ?>">Delete</a>
								

							</td>
						</tr>
						<!-- <?php $i++; ?> -->
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
<div class="modal fade" id="newAddSubmenu" tabindex="-1" role="dialog" aria-labelledby="newSubMenuModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="newSubMenuModalLabel">Add New Submenu</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('menu/submenu'); ?>" method="post">
				
				<div class="modal-body">
					<div class="form-group">
						<input type="text" class="form-control" id="title" name="title" placeholder="Submenu title">
					</div>
					<div class="form-group">
						<select name="menu_id" id="menu_id" class="form-control">
							<option value="" >Select Menu</option>
							<?php foreach ($menuu as $mnu ): ?>
								<option value=" <?= $mnu['id']; ?> " > <?= $mnu['menu']; ?> </option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" id="url" name="url" placeholder="Submenu url">
					</div>
					<div class="form-group">
						<input type="text" class="form-control" id="icon" name="icon" placeholder="Submenu icon">
					</div>
					<div class="form-group">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" checked>
							<label class="form-check-label" for="is_active">
								Active?
							</label>
						</div>
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

