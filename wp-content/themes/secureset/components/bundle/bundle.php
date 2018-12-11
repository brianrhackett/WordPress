<?php
if ( isset( $fields ) && is_array( $fields ) ) : 
	$product = get_post($fields['bundle']);
	$attributes = get_post_meta( $product->ID , '_product_attributes' );
	$product_img = wp_get_attachment_url( get_post_thumbnail_id($product->ID) ); 
?>
	<section class="featured-bundle alternator <?php echo $fields['mode']; ?>">
		<div class="container">
			<div class="row">
				<div class="col-md-6 pull-right">
					<?php if($product_img) :?>
						<img src="<?php echo $product_img;?>" height="inherent" width="540">
					<?php endif;?>
				</div>
				<div class="col-md-6">
					<h3><?php echo ($attributes[0]['tagline']) ? $attributes[0]['tagline']['value'] : $product->post_title;?></h3><br>
					<p>
						<?php echo ($attributes[0]['pitch']) ? $attributes[0]['pitch']['value'] : $product->post_excerpt;?>
					</p>
					<br>
					<a class="btn btn-hg btn-primary" href="<?php echo $product->guid;?>">MORE INFO</a>
				</div>
			</div>
		</div>
	</section>
<?php endif;?>