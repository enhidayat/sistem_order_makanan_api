 <? 
 // $id_rolelist = array_column($id_rolelist, 'id'); 
 // echo "ini var user_role_data "; print_r($user_role_data); echo "<br>";
 // print_r($rolelist); echo "<br>";
 // print_r($id_rolelist); echo "<br>";
 // foreach ($rolelist as $keys => $values) {
 	// foreach ($values as $key => $roles) {
 	// 	$a = $roles;
 	// 	$c = $id_rolelist[$keys];
 	// 	print_r($a); echo "="; print_r($c);
 	// }
 	# code...
 // }

 ?> 
 <!-- begin page content -->
 <div class="container-fluid">

 	<!-- Page Heading -->
 	<h1 class="h3 mb-4 text-gray-800"><?=$title; ?></h1>
 	<div class="row">
 		<div class="col-lg-8">
 			<?= form_open_multipart(); //dg ini sudah memimiliki $GLOBAL_FILES[''] ?>

 			<input type="hidden" name="id" value="<?= $user_role_data['id']; ?>" >			<!-- untuk mengambil id digunakan sebagai where di model -->
 			<div class="form-group row">
 				<label for="name" class="col-sm-2 col-form-label">name</label>
 				<div class="col-sm-10">
 					<input type="text" class="form-control" id="name" name="name" value="<?= $user_role_data['name']; ?>" >
 					<?= form_error('name','<small class="text-danger pl-3">','</small>'); ?>
 				</div>
 			</div>
 			<div class="form-group row">
 				<label for="email" class="col-sm-2 col-form-label">email</label>
 				<div class="col-sm-10">
 					<input type="text" class="form-control" id="email" name="email" value="<?= $user_role_data['email']; ?>" readonly>
 					<?= form_error('email','<small class="text-danger pl-3">','</small>'); ?>
 				</div>
 			</div>
 			
 			<div class="form-group row">
 				<label for="role" class="col-sm-2 col-form-label">Role</label>
 				<div class="col-sm-10">
 					<select class="form-control " id="role" name="role">
 						<?php $id_rolelist = array_column($id_rolelist, 'id'); ?>
 						<?php foreach($rolelist  as $keys => $values): ?>
 							<?php foreach($values as $key  => $roles): ?>
 								<?php 
 								$id = $id_rolelist[$keys]; 
 								if($roles == $user_role_data['role'] && $id == $user_role_data['role_id'] ):
 									?> <!-- && $id == $row['menu_id']  -->
 									<option value="<?=$id;?>" selected><?= $roles; ?></option>
 									<?php else : ?>
 										<option value=" <?=$id;?> " ><?= $roles; ?></option> 
 									<?php endif ; ?>
 								<?php endforeach ;?>
 							<?php endforeach ;?>

 						</select>
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



 	<!-- /.container fluid -->
 </div>

 <!-- end of main content -->
</div>

