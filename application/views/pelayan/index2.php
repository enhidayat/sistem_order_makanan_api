<!-- percobaan ^^ -->


<?php

print_r($food_menu);
$total = 0;
$items = [];
$info  = 'Select something to order.';



// form submitted
if( !empty( $_POST['choice'] ) && is_array( $_POST['choice'] ) )
// if( !empty( $_POST[$food_menu['foods_and_drinks']] ) && is_array( $_POST[$food_menu['foods_and_drinks']] ) )
{
	
	// foreach( $_POST['choice'] as $item ){

	foreach ($food_menu as $_POST['choice'] =>$item ) {
		$name = trim($item['foods_and_drinks']);
		$price = trim($item['price']);
		$quantity = intval( $_POST['quantity'] );
		
		if( isset( $item['checked'] ) && $quantity > 0 )
		{
					// $quantity = intval( $_POST['quantity'] );
			
			$items[] = $quantity .' '. $name;
			$total  += $price * $quantity;
		}
// }
	}
	
	if( count( $items ) )
	{
						//untuk insert
		$info = 'You selected ('.implode( ', ', $items ).'), total: '.$total;
		

	}

}
?>



<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
	<h3>List of Food Order</h3>

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
			<p><?
			echo $info;
			// var_dump ($items);
			// die();

			?></p>

			<!-- <a href="" class="btn btn-outline-primary mb-3 " data-toggle="modal" data-target="#exampleModalScrollable">Add New Order</a> -->
			<a href="" class="btn btn-outline-primary mb-3 " data-toggle="modal" data-target="#exampleModalLong">Add New Order</a>

			<!-- //disisni bantuan formny-->

		</div>
	</div>

	<!-- </body>
		</html> -->

	</div>
	<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Add Order</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('pelayan'); ?>" method="post"> 
				<!-- <?= form_open_multipart('pelayan') ?>  -->
				<div class="modal-body">


					<?php 
					if ($fn > 0 ) {
						$no=0;
						foreach ($food_menu as $fm) {
							?>

							<div class="form-group">
								<div class="form-check">
									<input <?php if ($fm['status']=='ready'){  echo '' ; }else{ echo 'disabled';}  ?>  class="form-check-input" type="checkbox" name="choice<?php echo"[".$no."][checked]"; ?>">

									<label class="form-check-label" for="is_active">
										<?= $fm['foods_and_drinks'] ?> @ <span>Rp . <?= number_format($fm['price']) ?></span> <span> <?= $fm['status']; ?></span>||| choice<?php echo"[".$no."][checked]"; ?> || choice<?php echo"[".$no."][".$fm['price']."]"; ?> ||choice<?php echo"[".$no."][".$fm['foods_and_drinks']."]"; ?> || choice<?php echo"[".$no."][quantity]"; ?>
										</label> echo trim("choice". "[0]"."[name]")|||| choice[]<?php  echo "[".$no."]"."[".$fm['price']."]"; ?>

										<input type="hidden" name="choice<?php echo "[".$no."]"."[".$fm['price']."]"; ?>" value="<?= $fm['price']; ?>" />

										<input type="hidden" name="<?php echo trim("choice[".$no."][".$fm['foods_and_drinks']."]"); ?>" value="<?php echo $fm['foods_and_drinks']; ?>" />
										<span>
											<input type="number" class="form-control ml-2" id="quantity" name="choice<?php echo"[".$no."][quantity]"; ?>" value="1" <?php if ($fm['status']=='ready'){  echo '' ; }else{ echo 'readonly';} ?> >
										</span>
									</div>
								</div>

								<?php  $no++;
							}
						}
						?>


					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Order</button>
					</div>
				</form> <!-- <?php form_close(); ?> -->
			</div>
		</div>
	</div>



	

	<form action="<?= base_url('pelayan'); ?>" method="post"> 
		<!-- <?= form_open_multipart('pelayan') ?>  -->
		<div class="modal-body">


			<?php 
			if ($fn > 0 ) {
				$no=0;
				foreach ($food_menu as $fm) {
					?>
					<div class="form-group">
						<div class="form-check">
							<input <?php if ($fm['status']=='ready'){  echo '' ; }else{ echo 'disabled';}  ?>  class="form-check-input" type="checkbox" name="<?php echo 'choice['.$no.'][checked]'; ?>">
							<label class="form-check-label" for="is_active">
								<?= $fm['foods_and_drinks'] ?> @ <span>Rp . <?= number_format($fm['price']) ?></span> <span> <?= $fm['status']; ?></span>

								||| choice<?php echo"[".$no."][checked]"; ?> || choice<?php echo"[".$no."][".$fm['price']."]"; ?> ||choice<?php echo"[".$no."][".$fm['foods_and_drinks']."]"; ?> || choice<?php echo"[".$no."][quantity]"; ?>
								</label> echo trim("choice". "[0]"."[name]")|||| choice[]<?php  echo "[".$no."]"."[".$fm['price']."]"; ?>

								<input type="hidden" name="choice<?php echo '['.$no.']['.$fm["price"].']'; ?>" value="<?= $fm['price']; ?>" />

								<input type="hidden" name="<?php echo trim("choice[".$no."][".$fm['foods_and_drinks']."]"); ?>" value="<?php echo $fm['foods_and_drinks']; ?>" />
								<span>
									<input type="number" class="form-control ml-2" id="quantity" name="choice<?php echo"[".$no."][quantity]"; ?>" value="1" <?php if ($fm['status']=='ready'){  echo '' ; }else{ echo 'readonly';} ?> >
								</span>
							</div>
						</div>

						<?php  $no++;
					}
				}
				?>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Order</button>
			</div>
		</form> 