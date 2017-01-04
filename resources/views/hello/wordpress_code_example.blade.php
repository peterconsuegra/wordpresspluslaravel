<html>
    <body>
        <h1>Wordpress code example:</h1>
		
		<?php
		$blogusers = get_users( array( 'fields' => array( 'display_name' ) ) );
		// Array of stdClass objects.
		foreach ( $blogusers as $user ) {
		    echo '<span>' . esc_html( $user->display_name ) . '</span>';
		}
		?>
		
    </body>
</html>