<?php
add_action( 'admin_menu', 'dew_add_insta_menu' );
function dew_add_insta_menu() {
	add_options_page( 'Dew Instagram Feed', 'Dew Instagram Feed', 'manage_options', 'dew-insta-feed', 'dew_options_insta' );
}

add_action( 'admin_init', 'dew_insta_init' );
function dew_insta_init() {
	register_setting( 'dewInsta', 'dew_insta_feed' );
	add_settings_section(
		'dew_dewInsta_section',
		__( '', 'dew-insta-feed' ),
		'dew_insta_section_callback',
		'dewInsta'
	);

	add_settings_field(
		'dew_text_field_1',
		__( 'Instagram Username ', 'dew-instagram-feed' ),
		'dew_text_field_1_render',
		'dewInsta',
		'dew_dewInsta_section',
		array( 'label_for' => 'dew_text_field_1', 'class' => 'dew-text' )
	);

	add_settings_field(
		'dew_text_field_0',
		__( 'Instagram Token ', 'dew-instagram-feed' ),
		'dew_text_field_0_render',
		'dewInsta',
		'dew_dewInsta_section',
		array( 'label_for' => 'dew_text_field_0', 'class' => 'dew-text' )
	);

	add_settings_field(
		'dew_select_field_0',
		__( 'Display Number of Post ', 'dew-instagram-feed' ),
		'dew_select_insta_render',
		'dewInsta',
		'dew_dewInsta_section',
		array( 'label_for' => 'dew_select_field_0', 'class' => 'dew-select' )
	);
}

function dew_text_field_0_render() {
	$options = get_option( 'dew_insta_feed' );
	$dew_text_field_0 = isset($options['dew_text_field_0']) ? $options['dew_text_field_0'] : '';
	?>
	<input type="text" name="dew_insta_feed[dew_text_field_0]" value="<?php echo $dew_text_field_0; ?>">
	<?php
}

function dew_text_field_1_render() {
	$options = get_option( 'dew_insta_feed' );
	$dew_text_field_1 = isset($options['dew_text_field_1']) ? $options['dew_text_field_1'] : '';
	?>
	<input type="text" name="dew_insta_feed[dew_text_field_1]" value="<?php echo $dew_text_field_1; ?>">
	<?php
}

function dew_select_insta_render() {
	$options = get_option( 'dew_insta_feed' );
	$dew_select_field_0 = isset($options['dew_select_field_0']) ? $options['dew_select_field_0'] : '';
	?>
	<select name="dew_insta_feed[dew_select_field_0]">
		<option value=''>Select Page</option>
		<option value="1" <?php selected( $dew_select_field_0, 1 ); ?>>1</option>
		<option value="2" <?php selected( $dew_select_field_0, 2 ); ?>>2</option>
		<option value="3" <?php selected( $dew_select_field_0, 3 ); ?>>3</option>
		<option value="4" <?php selected( $dew_select_field_0, 4 ); ?>>4</option>
		<option value="5" <?php selected( $dew_select_field_0, 5 ); ?>>5</option>
		<option value="6" <?php selected( $dew_select_field_0, 6 ); ?>>6</option>
		<option value="7" <?php selected( $dew_select_field_0, 7 ); ?>>7</option>
		<option value="8" <?php selected( $dew_select_field_0, 8 ); ?>>8</option>
		<option value="9" <?php selected( $dew_select_field_0, 9 ); ?>>9</option>
		<option value="10" <?php selected( $dew_select_field_0, 10 ); ?>>10</option>
	</select>
	<?php
}

function dew_insta_section_callback() {
	echo __( '', 'dew-instagram-feed' );
}

function dew_options_insta() {
	$tabs = array( 'general' => 'General', 'shortcodes' => 'Shortcodes' );
	$current = isset($_GET['tab']) ? $_GET['tab'] : 'general';
	?>
	<h1>Dew Instagram Feed Setting</h1>
	<form action='options.php' method='post'>
		<nav class="nav-tab-wrapper ur-nav-tab-wrapper">
			<?php foreach( $tabs as $tab => $name ){
		        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
		        echo '<a class="nav-tab'.$class.'" href="' . admin_url( 'options-general.php?page=dew-insta-feed&tab='.$tab).'">'.$name.'</a>';
		    } ?>
		</nav>
		<h2><?php echo esc_html( $tabs[ $current ] ); ?></h2>
		<?php
		switch ( $current ){
      		case 'general' :
				settings_fields( 'dewInsta' );
				do_settings_sections( 'dewInsta' );
				submit_button();
			break;
      		case 'shortcodes' :
      			echo '<table class="form-table" role="presentation"><tbody><tr class="dew-text"><th scope="row"><label for="registration_shortcode">Registration Shortcode</label></th><td><input type="text" name="registration_shortcode" id="registration_shortcode" value="[dew_instagram_feed]" readonly></td></tr></tbody></table>';
			break;
		}
		?>
	</form>
	<?php
}