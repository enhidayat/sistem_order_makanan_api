



<!-- Begin Page Content -->
<div class="container-fluid">
	
	<? 
		// print_r($menu); echo "</br>";
		// echo "id_username sebelum di convertke 1d"; print_r($id_usermenu); echo "</br>";
		// echo "ini dalahh var row "; print_r($row); echo "</br>";

	$id_usermenu = array_column($id_usermenu, 'id');

	echo "id_usermenu " ; print_r($id_usermenu[0]); echo "</br>";

	?> 
	
	<?php 
	// $menu;
	// $id_usermenu;
	// foreach ($menu as $keys => $values) {
	// 	foreach ($values as $key => $data) {

	// 		$a = $data;
	// 		// $b = $id_usermenu[$keys][$data];
	// 		$c = $id_usermenu[$keys];
	// 		print_r($a); echo "="; print_r($c);
	// 		echo "<br>";

	// 		// print_r($c);
	// 		// echo "<br>";

	// 	}
	// }

	
	?>
	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
	<div class="row">
		<div class="col-lg-8">
			<?= form_open_multipart(); //dg ini sudah memimiliki $GLOBAL_FILES[''] ?>

			<input type="hidden" name="id" value="<?= $row['id']; ?>" >			<!-- untuk mengambil id digunakan sebagai where di model -->
			<div class="form-group row">
				<label for="title" class="col-sm-2 col-form-label">Title</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="title" name="title" value="<?= $row['title']; ?>" >
					<?= form_error('title','<small class="text-danger pl-3">','</small>'); ?>
				</div>
			</div>
			<div class="form-group row">
				<!-- <label for="menu" class="col-sm-2 col-form-label">Menu</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="menu" name="menu" value="<?= $row['menu']; ?>"> -->
					<!-- <?= form_error('menu','<small class="text-danger pl-3">','</small>'); ?> -->
					<!-- </div> -->

					<label for="menu" class="col-sm-2 col-form-label">Menu</label>
					<div class="col-sm-10">
						<select class="form-control " id="menu" name="menu">
							<?php $id_usermenu = array_column($id_usermenu, 'id'); ?>
							<?php foreach($menu  as $keys => $values): ?>
								<?php foreach($values as $key  => $menuku): ?>
									<?php 
									$id = $id_usermenu[$keys]; 
									if($menuku == $row['menu'] && $id == $row['menu_id'] ):
										?> <!-- && $id == $row['menu_id']  -->
										<option value="<?=$id;?>" selected><?= $menuku; ?></option>
										<?php else : ?>
											<option value=" <?=$id;?> " ><?= $menuku; ?></option> 
										<?php endif ; ?>
									<?php endforeach ;?>
								<?php endforeach ;?>

							</select>
						</div>

					</div>
					<div class="form-group row">
						<label for="url" class="col-sm-2 col-form-label">URL</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="url" name="url" value="<?= $row['url']; ?>">
							<?= form_error('url','<small class="text-danger pl-3">','</small>'); ?>
						</div>
					</div>
					<div class="form-group row">
						<label for="icon" class="col-sm-2 col-form-label">Icon</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="icon" name="icon" value="<?= $row['icon']; ?>">
							<?= form_error('icon','<small class="text-danger pl-3">','</small>'); ?>
						</div>
					</div>
					<div class="form-group row">
						<label class=" col-sm-2 col-form-label" for="is_active">
							Active?
						</label>
						<div class="form-check ml-3">
							<input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" checked onclick="return false;">
						</div>
					</div>



					<div class="form-group row justify-content-end">
						<div class="col-sm-10">
							<button type="submit" class="btn btn-outline-primary">Edit</button>
						</div>
					</div>

				</form>

			</div>
		</div>

	</div>
	<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

