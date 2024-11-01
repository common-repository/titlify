<div class="wrap">
	<div id="icon-tools" class="icon32"></div>
	<h2>Titlify Settings</h2>
	<?php 

		if ( wp_verify_nonce( $_POST['_wpnonce'], 'titlify-options' )  ) {
			// taking in considation a new cool update :) leave options as an array
			$tfOptions['post_types'] = $_POST['post_types'];

			if( update_option( 'titlify-options', $tfOptions ) )
				echo '<div class="updated"><p>Success! Your changes were successfully saved!</p></div>';
			else
				echo '<div class="error"><p>Whoops! There was a problem with the data you tried to save. Please try again.</p></div>';
		}

		$tfOptions = get_option( 'titlify-options' );
	?>
	<form class="form form-aligned" enctype="multipart/form-data" method="post">
		<?php 
			wp_nonce_field('titlify-options'); 
		?>	
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Enable for those post types : </th>

				<td>
					<fieldset>
						<legend class="screen-reader-text"><span>Formatting</span></legend>

						<?php 
							$tftypes = ( is_array( $tfOptions['post_types'] ) )? $tfOptions['post_types'] : array();
							$typeArgs = array(
							);
							$types = get_post_types($typeArgs);
							foreach( $types as $type ) :
								if (in_array($type, array('attachment', 'revision', 'nav_menu_item')))
									continue;
								printf('<label for="%s"><input %s type="checkbox" value="%s" id="%s" name="post_types[]" /> %s</label><br />', $type, ( in_array( $type, $tftypes ) )? 'checked="checked"' : '',  $type, $type, strtoupper($type));
							endforeach;
						?>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th></th>
				<td>
					<button class="button button-primary button-large" type="submit">save</button>
				</td>
			</tr>
		</table>
	</form>
</div>