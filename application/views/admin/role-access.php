



<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>



	<div class="row">
		<div class="col-lg-6">
			<?= $this->session->flashdata('message'); ?>
			<h5>Role : <?= $role['role']; ?></h5>
			<table class="table table-hover">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Menu</th>
						<th scope="col">Access</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=1; ?>
					<?php foreach ($menu as $mn ): ?> <!-- $menu didapat dr contioller menu.php -->
					<tr>
						<th scope="row"><?= $i; ?></th>
						<td><?= $mn['menu']; ?></td>
						<td>
							<div class="form-check">
								<input class="form-check-input" type="checkbox" <?= check_access($role['id'], $mn['id']); ?> data-role="<?= $role['id']; ?>" data-menu="<?= $mn['id']; ?>"	> 
								<!-- data-role akan diproses di helper kemudian nilai akan di input ke tb role_access_menu -->
								<!-- data-menu akan diproses di helper kemudian nilai akan di input ke tb user_menu -->
								<!-- //membuat fungsi helper check_access untuk membuat ceklis sesuai data pd tb user_access_menu ($role['id'] di dapat dr queri sebelumnya dr controller Admin yg mengarah ke tb user_role, $mn['id'] di dapat dr queri sebelumnya dr controller Admin yg mengarah ke tb user_menu) -->
							</div>
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



