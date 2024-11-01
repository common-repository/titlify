<div class="titlify-metabox">
	<label for="tf-color">
		<strong class="pickcolor-label">Pick a color for this post's title : </strong>
		<input type="text" class="pickcolor" name="tf-color" id="tf-color" value="<?php echo ( get_post_meta( $post->ID, 'tf-color', true ) )? get_post_meta( $post->ID, 'tf-color', true ) : '' ?>">
	</label>
</div>