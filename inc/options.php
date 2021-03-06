<?php

/**
 * Generated by the WordPress Option Page generator
 * at http://jeremyhixon.com/wp-tools/option-page/
 */

class SuperHeroesShortcode {
	private $super_heroes_shortcode_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'super_heroes_shortcode_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'super_heroes_shortcode_page_init' ) );
	}

	public function super_heroes_shortcode_add_plugin_page() {
		add_options_page(
			'Super heroes shortcode', // page_title
			'Super heroes shortcode', // menu_title
			'manage_options', // capability
			'super-heroes-shortcode', // menu_slug
			array( $this, 'super_heroes_shortcode_create_admin_page' ) // function
		);
	}

	public function super_heroes_shortcode_create_admin_page() {
		$this->super_heroes_shortcode_options = get_option( 'super_heroes_shortcode_option_name' ); ?>

		<div class="wrap">
			<h2>Super heroes shortcode</h2>
			<p>Please You need a facebook account to get your access token. You can generate your access token here <a href="https://superheroapi.com/" target="_blank">https://superheroapi.com/</a></p> 
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'super_heroes_shortcode_option_group' );
					do_settings_sections( 'super-heroes-shortcode-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function super_heroes_shortcode_page_init() {
		register_setting(
			'super_heroes_shortcode_option_group', // option_group
			'super_heroes_shortcode_option_name', // option_name
			array( $this, 'super_heroes_shortcode_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'super_heroes_shortcode_setting_section', // id
			'Settings', // title
			array( $this, 'super_heroes_shortcode_section_info' ), // callback
			'super-heroes-shortcode-admin' // page
		);

		add_settings_field(
			'token_0', // id
			'Token', // title
			array( $this, 'token_0_callback' ), // callback
			'super-heroes-shortcode-admin', // page
			'super_heroes_shortcode_setting_section' // section
		);
	}

	public function super_heroes_shortcode_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['token_0'] ) ) {
			$sanitary_values['token_0'] = sanitize_text_field( $input['token_0'] );
		}

		return $sanitary_values;
	}

	public function super_heroes_shortcode_section_info() {
		
	}

	public function token_0_callback() {
		printf(
			'<input class="regular-text" type="text" name="super_heroes_shortcode_option_name[token_0]" id="token_0" value="%s">',
			isset( $this->super_heroes_shortcode_options['token_0'] ) ? esc_attr( $this->super_heroes_shortcode_options['token_0']) : ''
		);
	}

}
if ( is_admin() )
	$super_heroes_shortcode = new SuperHeroesShortcode();

/* 
 * Retrieve this value with:
 * */
$super_heroes_shortcode_options = get_option( 'super_heroes_shortcode_option_name' ); // Array of All Options
$token_0 = $super_heroes_shortcode_options['token_0']; // Token

global $token_0;
