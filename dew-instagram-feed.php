<?php
/*
* Plugin Name: Insta Social Feed
* Plugin URI: http://dewtechnolab.com/portfolio/
* Description: Insta Social Feed diplay instagram post
* Author: Dew Technolab
* Version: 1.0.0
* Requires at least: 4.5
* Author URI: http://dewtechnolab.com/
* Text Domain: dew-instagram-feed
*/
class dew_social_feed {
	//private
	private $plugin_url = '';
	private $plugin_dir = '';
	private $plugin_path = '';
	/**
	* __construct()
	* 
	* Class constructor
	*
	*/
	function __construct(){
		//* Localization Code */
		load_plugin_textdomain( 'dew-instagram-feed', false, dirname( plugin_basename( __FILE__ ) ));
		$this->plugin_path = plugin_basename( __FILE__ );
		$this->plugin_url = rtrim( plugin_dir_url(__FILE__), '/' );
		$this->plugin_dir = rtrim( plugin_dir_path(__FILE__), '/' );
		// Execute the action
		add_action( 'init', array( $this, 'dew_register_css' ) );
		// Load our css
		add_action( 'wp_footer', array( $this, 'dew_print_css' ) );
		// Load our js
		add_action( 'wp_footer', array( $this, 'dew_footer_script') );
	}

	// user registration login form
	public function dew_social_feed_shortcode() {

		global $dew_load_css;

		// set this to true so the CSS is loaded
		$dew_load_css = true;

		$output = '<div id="dew-instafeed-id" class="dew-instafeed-main"></div>';
		return $output;
	}

	// register our form css
	function dew_register_css() {
		wp_register_style('dew-form-css', plugin_dir_url( __FILE__ ) . '/css/dew-instagram-feed.css');
	}

	function dew_footer_script(){
		global $dew_load_css;

		// this variable is set to TRUE if the short code is used on a page/post
		if ( ! $dew_load_css )
			return; // this means that neither short code is present, so we get out of here

		$options = get_option( 'dew_insta_feed' );
		$dew_insta_token = isset($options['dew_text_field_0']) ? $options['dew_text_field_0'] : '';
		$dew_insta_numbr = isset($options['dew_select_field_0']) ? $options['dew_select_field_0'] : 5;
	  	?>
	  	<script>
	  		var token = '<?php echo $dew_insta_token; ?>',
			num_photos = <?php echo $dew_insta_numbr; ?>;
			jQuery.ajax({
				url:'https://api.instagram.com/v1/users/self/media/recent',
				dataType: 'jsonp',
				type: 'GET',
				data: {access_token: token, count: num_photos},
				success: function(data){
					console.log(data);
					for( x in data.data ){
						jQuery('#dew-instafeed-id').append('<div class="dew-inta-img"><img src="'+data.data[x].images.low_resolution.url+'"></div>');
					}
				},
				error: function(data){
					console.log(data);
				}
			});
	  	</script>
		<?php
	}

	// load our form css
	function dew_print_css() {
		global $dew_load_css;

		// this variable is set to TRUE if the short code is used on a page/post
		if ( ! $dew_load_css )
			return; // this means that neither short code is present, so we get out of here

		wp_print_styles('dew-form-css');
	}
}

$dew_social_feed_obj = new dew_social_feed;

add_shortcode('dew_instagram_feed', array($dew_social_feed_obj, 'dew_social_feed_shortcode'));
include( plugin_dir_path( __FILE__ ) . 'inc/dew-settings.php');