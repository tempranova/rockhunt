<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://victortemprano.com
 * @since      1.0.0
 *
 * @package    Rockhunt
 * @subpackage Rockhunt/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rockhunt
 * @subpackage Rockhunt/admin
 * @author     Victor Temprano <victor@mapster.me>
 */
class Rockhunt_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rockhunt_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rockhunt_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rockhunt-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rockhunt_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rockhunt_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rockhunt-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Create Rocks custom post type
	 *
	 * @since    1.0.0
	 */
	public function create_rockhunt_custom_post_types()
	{
			register_post_type('rock',
					array(
							'labels' => array(
									'name' => 'Rocks',
									'menu_name' => 'Rocks',
									'singular_name' => 'Rock',
									'add_new' => 'Add New',
									'add_new_item' => 'Add New Location',
									'edit' => 'Edit',
									'edit_item' => 'Edit Rock',
									'new_item' => 'New Rock',
									'view' => 'View',
									'view_item' => 'View Rock',
									'search_items' => 'Search Rock',
									'not_found' => 'No Rock found',
									'not_found_in_trash' => 'No Rock found in Trash',
									'parent' => 'Parent Location',
							),
							'public' => true,
							'show_in_rest' => true,
							'menu_position' => 15,
							'supports' => array('title', 'custom-fields'),
							'taxonomies' => array(''),
							'menu_icon' => 'dashicons-location-alt',
							'has_archive' => true,
					)
			);
			register_post_type('mineral',
					array(
							'labels' => array(
									'name' => 'Minerals',
									'menu_name' => 'Minerals',
									'singular_name' => 'Mineral',
									'add_new' => 'Add New',
									'add_new_item' => 'Add New Location',
									'edit' => 'Edit',
									'edit_item' => 'Edit Mineral',
									'new_item' => 'New Mineral',
									'view' => 'View',
									'view_item' => 'View Mineral',
									'search_items' => 'Search Mineral',
									'not_found' => 'No Mineral found',
									'not_found_in_trash' => 'No Mineral found in Trash',
									'parent' => 'Parent Location',
							),
							'public' => true,
							'show_in_rest' => true,
							'menu_position' => 15,
							'supports' => array('title', 'custom-fields'),
							'taxonomies' => array(''),
							'menu_icon' => 'dashicons-location-alt',
							'has_archive' => true,
					)
			);
	}

	/**
		* use classic editor for post types
	*/
	public function rockhunt_post_types_use_block_editor( $use_block_editor, $post_type ) {
			if ( 'rock' == $post_type || 'mineral' == $post_type ) {
					return false;
			}

			return $use_block_editor;
	}

	/**
	 * Create rockhunt page if not exists
	 *
	 * @since    1.0.0
	 */
	public function create_rockhunt_page() {
			$my_page = get_option('rockhunt-page');
			if (!$my_page || false === get_post_status($my_page)) {
					// Create post/page object
					$my_new_page = array(
							'post_title' => 'RockHunt',
							'post_content' => '',
							'post_status' => 'publish',
							'post_type' => 'page',
					);
					// Insert the post into the database
					$my_page = wp_insert_post($my_new_page);
					update_option('rockhunt-page', $my_page);
			}
	}

	/**
	 * Add post type to rest
	 *
	 * @since    1.0.0
	 */
	public function rockhunt_add_post_type_to_rest()
	{
			// Add support for all existing custom post types
			// This should be optionally enabled?
			global $wp_post_types;
			$wp_post_types['rock']->show_in_rest = true;
			$wp_post_types['mineral']->show_in_rest = true;
	}

	/**
   * Add custom fields and user meta to rest
   *
   * @since    1.0.0
   */
  public function rockhunt_show_custom_fields_in_rest()
  {
      global $wp_post_types;
      $post_types = array_keys($wp_post_types);
      //Loop through each one
      foreach ($post_types as $post_type) {

          $untouched_types = array('custom_css', 'gl_js_maps', 'customize_changeset', 'nav_menu_item', 'oembed_cache', 'revision');
          if (!in_array($post_type->name, $untouched_types)) {
              add_filter('rest_prepare_' . $post_type, function ($data, $post, $request) {
                  //Get the response data
                  $response_data = $data->get_data();
                  //Bail early if there's an error
                  if ($request['context'] !== 'view' || is_wp_error($data)) {
                      return $data;
                  }
                  //Get all fields
                  $fields = get_fields($post->ID);
                  //If we have fields...
                  if ($fields) {
                      //Loop through them...
                      foreach ($fields as $field_name => $value) {
                          //Set the meta
                          $response_data[$field_name] = $value;
                      }

                  }
                  //Commit the API result var to the API endpoint
                  $data->set_data($response_data);
                  return $data;
              }, 10, 3);
          }
      }
  }

	/**
	 * Admin hide front end
	 *
	 * @since    1.0.0
	 */
	public function rockhunt_hide_admin_bar($prepared_args)
	{
		show_admin_bar( false );
	}

}
