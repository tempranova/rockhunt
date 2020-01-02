<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://victortemprano.com
 * @since      1.0.0
 *
 * @package    Rockhunt
 * @subpackage Rockhunt/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Rockhunt
 * @subpackage Rockhunt/public
 * @author     Victor Temprano <victor@mapster.me>
 */
class Rockhunt_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		 $my_page = get_option('rockhunt-page');
		 if($my_page && is_page($my_page)) {

		 	$isLocalIp = substr( $_SERVER['REMOTE_ADDR'], 0, 7 ) === '192.168';
		 	if (!in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1')) && !$isLocalIp) {
		 		$CSSfiles = scandir(dirname(__FILE__) . '/rockhunt/build/static/css/');
		 		foreach($CSSfiles as $filename) {
		 			if(strpos($filename,'.css')&&!strpos($filename,'.css.map')) {
		 				wp_enqueue_style( 'rockhunt_react_css', plugin_dir_url( __FILE__ ) . 'rockhunt/build/static/css/' . $filename, array(), mt_rand(10,1000), 'all' );
		 			}
		 		}
		 	}
		 	wp_enqueue_style('mapbox_gl_css', 'https://api.tiles.mapbox.com/mapbox-gl-js/v1.5.0/mapbox-gl.css');
		 	wp_enqueue_style('mapbox_gl_geocoder', 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.4.2/mapbox-gl-geocoder.css');
		 } else {
			 // wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rockhunt-public.css', array(), $this->version, 'all' );
		 }

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		 $my_page = get_option('rockhunt-page');
		 if($my_page && is_page($my_page)) {

		 	$isLocalIp = substr( $_SERVER['REMOTE_ADDR'], 0, 7 ) === '192.168';
		 	if (!in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1')) && !$isLocalIp) {
		 		// code for localhost here
		 		// PROD
		 		$JSfiles = scandir(dirname(__FILE__) . '/rockhunt/build/static/js/');
		 		$react_js_to_load = '';
		 		foreach($JSfiles as $filename) {
		 			if(strpos($filename,'.js')&&!strpos($filename,'.js.map')) {
		 				$react_js_to_load = plugin_dir_url( __FILE__ ) . 'rockhunt/build/static/js/' . $filename;
		 			}
		 		}
		 		wp_register_script('rockhunt_react', $react_js_to_load, '', mt_rand(10,1000), true);
		 		wp_localize_script('rockhunt_react', 'params', array(
		 				'nonce' => wp_create_nonce('wp_rest'),
		 				'nonce_verify' => wp_verify_nonce($_REQUEST['X-WP-Nonce'], 'wp_rest'),
		 				'plugins_url' => plugins_url()
		 		));
		 		wp_enqueue_script( 'rockhunt_react' );
		 	} else {
		 		$react_js_to_load1 = 'http://' . $_SERVER['SERVER_NAME'] . ':3000/static/js/bundle.js';
		 		$react_js_to_load2 = 'http://' . $_SERVER['SERVER_NAME'] . ':3000/static/js/0.chunk.js';
		 		$react_js_to_load3 = 'http://' . $_SERVER['SERVER_NAME'] . ':3000/static/js/main.chunk.js';
		 		wp_register_script('rockhunt_react', $react_js_to_load1, '', mt_rand(10,1000), true);
		 		wp_register_script('rockhunt_react2', $react_js_to_load2, '', mt_rand(10,1000), true);
		 		wp_register_script('rockhunt_react3', $react_js_to_load3, '', mt_rand(10,1000), true);;

		 		wp_localize_script('rockhunt_react', 'params', array(
		 				'nonce' => wp_create_nonce('wp_rest'),
		 				'nonce_verify' => wp_verify_nonce($_REQUEST['X-WP-Nonce'], 'wp_rest'),
		 				'plugins_url' => plugins_url()
		 		));
		 		wp_enqueue_script( 'rockhunt_react' );
		 		wp_enqueue_script( 'rockhunt_react2' );
		 		wp_enqueue_script( 'rockhunt_react3' );
		 	}
		 	// DEV
		 	// React dynamic loading
		 	// wp_enqueue_script('learn_a_language_react', $react_js_to_load, '', '', true)
		 	// wp_enqueue_script( 'ertcu_map_react' );
		 } else {
			 wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rockhunt-public.js', array( 'jquery' ), $this->version, false );
		 }

	}

	/**
	 * Creating Rockhunt map page template
	 *
	 * @since    1.0.0
	 */
	public function rockhunt_template( $template ) {
		$my_page = get_option('rockhunt-page');
		$file_name = 'rockhunt-page.php';

    if ( $my_page && is_page( $my_page ) ) {
        if ( locate_template( $file_name ) ) {
            $template = locate_template( $file_name );
        } else {
            // Template not found in theme's folder, use plugin's template as a fallback
            $template = plugin_dir_path( __FILE__ ) . $file_name;
        }
    }

    return $template;
	}

}
