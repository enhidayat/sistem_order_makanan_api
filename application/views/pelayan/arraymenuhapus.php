<?php
$total = 0;
$items = [];
$info  = 'Select something to order.';

	// form submitted
if( !empty( $_POST['choice'] ) && is_array( $_POST['choice'] ) )
{
	    // loop all item choices
	foreach( $_POST['choice'] as $item )
	{
	        // filter item info
		$name     = trim( $item['name'] );
		$price    = floatval( $item['price'] );
		$quantity = intval( $item['quantity'] );

	        // only add if item was checked and quantity is more than 0
		if( isset( $item['checked'] ) && $quantity > 0 )
		{
			$items[] = $quantity .' '. $name;
			$total  += $price * $quantity;
		}
	}
	    // update info if items were selected
		// print_r($items[2]);
	if( count( $items ) )
	{
					//untuk insert
		$info = 'You selected ('.implode( ', ', $items ).'), total: '.$total;
			// $info = 'You selected (' .$items .'), total: '.$total;

					//untuk edit
		print_r($items[0]);
		$kata = $items[0];

		$PecahStr = explode(" ", $items[0], 2);
		print_r($PecahStr);

	}
}
?>

<form id="order-form" action="" method="post">
	<div class="form-item">
		<input type="checkbox" name="choice[0][checked]" />
		<span>Chicken, Price: 8</span>
		<input type="number" name="choice[0][quantity]" value="1" />
		<input type="hidden" name="choice[0][price]" value="8" />
		<input type="hidden" name="<?php echo trim("choice". "[0]"."[name]");?>" value="Chicken" />
	</div>
	<div class="form-item">
		<input type="checkbox" name="choice[1][checked]" />
		<span>Meat, Price: 3</span>
		<input type="number" name="choice[1][quantity]" value="1" />
		<input type="hidden" name="choice[1][price]" value="3" />
		<input type="hidden" name="choice[1][name]" value="Meat" />
	</div>
	<div class="form-item">
		<input type="checkbox" name="choice[2][checked]" />
		<span>Souvlaki, Price: 2.50</span>
		<input type="number" name="choice[2][quantity]" value="1" />
		<input type="hidden" name="choice[2][price]" value="2.50" />
		<input type="hidden" name="choice[2][name]" value="Souvlaki" />
	</div>
	<div class="form-item">
		<input type="checkbox" name="choice[3][checked]" />
		<span>Pizza, Price: 12</span>
		<input type="number" name="choice[3][quantity]" value="1" />
		<input type="hidden" name="choice[3][price]" value="12" />
		<input type="hidden" name="choice[3][name]" value="Pizza" />
	</div>
	<input type="submit" value="Order"/>
</form>

<hr />
<p><?= $info ?></p>