<?php
/**
 * Plugin Name: Super Hero
 * Plugin URI: https://github.com/heimer79/superheroes
 * Description: include cards from https://superheroapi.com/
 * Version: 0.2.0
 * Author: Heimer Martinez
 * Author URI: https://github.com/heimer79/
 * Text Domain: superhero
 */

/*  Copyright 2021

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


 
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

        $plugin_dir = plugin_dir_url(__FILE__);
        $url_site = site_url().'/';
        $path_plugin_relative = str_replace ($url_site, '',$plugin_dir);


        include ( ABSPATH . $path_plugin_relative.'inc/options.php');


if (is_plugin_active('superhero/superhero.php')) {
	
    if (! function_exists('call_superhero')) {        
        /**
         * assets
         *
         * @return void
         */
        function assets()
        {
            global $post;
            //verify if the shortcode exist in post or page.
            if (is_a($post, 'WP_Post') && has_shortcode( $post->post_content, 'superheroes')) {
                wp_enqueue_style('fonts-super-heroes', 'https://fonts.googleapis.com/css2?family=Roboto&family=Sriracha&display=swap', '', '0.1.0', 'all');
                wp_enqueue_style('super-heroes', plugin_dir_url(__FILE__).'assets/css/style-hero.css', '', '0.1.0', 'all');
            }
        }
    }

		add_action('wp_enqueue_scripts', 'assets');

		if (! function_exists('preconnect')) {				
				/**
				 * preconnect
				 *
				 * @return void
				 */
				function preconnect()
				{
					global $post;
            //verify if the shortcode exist in post or page.
            if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'superheroes')) {
                echo '<link rel="preconnect" href="https://fonts.gstatic.com">';
            }
				}
		}
			
		add_action('wp_head', 'preconnect', 1 ,0);		
		 

}

if (! function_exists('call_superhero')) {
    // Add Shortcode    
    /**
     * call_superhero
     *
     * @param  mixed $idhero
     * @return void
     */
    function call_superhero($idhero)
    {

       global $token_0;

        if (is_singular() && !is_admin()) {
            // Attributes
            $idhero = shortcode_atts(
                array(
                       'heroid' => '',
								),
                $idhero
            );
                                    
            $idhero = $idhero['heroid'];

						//call API with token 

            $data = file_get_contents("https://superheroapi.com/api/$token_0/$idhero");
            $content = json_decode($data, true);

						//extract every field from json format 
            $name = $content['name'];
            $image_url = $content['image']['url'];
            $physical_strength = $content['powerstats']['strength'];
            $special_powers = $content['powerstats']['power'];
            $weapons = $content['powerstats']['combat'];
            $full_name = $content['biography']['full-name'];
            $alter_egos = $content['biography']['alter-egos'];
            $aliases = $content['biography']['aliases'];
            $place_of_birth = $content['biography']['place-of-birth'];
            $first_appearance = $content['biography']['first-appearance'];
            $publisher = $content['biography']['publisher'];
            $alignment = $content['biography']['alignment'];
                                            
            foreach ($aliases as $aliases) {
                $aliases;
            } ?>
							<section class="super-hero-cards">
									<h1><?php echo $name; ?></h1>
									<figure>
										<img src="<?php echo $image_url; ?>" alt="">
									</figure>
									<div class="skills">
									<table>
										<tr>
											<td>PHYSICAL STRENGTH:</td>
											<td><?php echo $physical_strength; ?></td>
										</tr>
										<tr>
											<td>SPECIAL POWERS:</td>
											<td><?php echo $special_powers; ?></td>
										</tr>
										<tr>
											<td>WEAPONS:</td>
											<td><?php echo $weapons; ?></td>
										</tr>
									</table>
									</div>
									<div class="biography">
										<p><?php
                           echo $full_name.', '.$alter_egos.', '.$aliases.', '.$place_of_birth.', '.$first_appearance.', '.$publisher.'.'; ?></p>
									</div>

							</section>


						<?php
        }
    }
}

add_shortcode( 'superheroes', 'call_superhero' );


add_action( 'admin_print_footer_scripts', 'quicktags_so_42200158' );

function quicktags_so_42200158() {
    if ( wp_script_is( 'quicktags' ) ) {
        wp_enqueue_script('jquery');
        ?>
        <script>
        /* Button name and callback will be replaced */
        QTags.addButton( 'dummy_button', 'Dummy button', function(){} );

        jQuery(window).load( function() {
            jQ = jQuery;

         
            var data = {
                '-': 'Select shortcode',
                'superheroes': 'Superheroes',
            }
            var s = jQ('<select />');
            s.attr('id','my-shortcodes');
            for(var val in data) {
                jQ('<option />', {value: val, text: data[val]}).appendTo(s);
            }

            
            jQ('#qt_content_dummy_button')[0].outerHTML = s[0].outerHTML;

            /* What will be inserted on HTML editor */
            jQ('#my-shortcodes').on('change', function(){
                var sc = '[' + jQ(this).val() + ' heroid="" '+']';
                QTags.insertContent(sc);
            });
        });
        </script>
        <?php
    }
}


// Load the auto-update class
add_action( 'init', 'activate_au' );
function activate_au()
{
	require_once ( 'inc/wp_autoupdate.php' );
	$plugin_current_version = '0.2.0';
	$plugin_remote_path = plugin_dir_url( __FILE__ ) . '/inc/update.php';
	$plugin_slug = plugin_basename( __FILE__ );
	new WP_AutoUpdate ( $plugin_current_version, $plugin_remote_path, $plugin_slug);
}
