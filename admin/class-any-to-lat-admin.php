<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/tux255
 * @since      1.0.0
 *
 * @package    Any_To_Lat
 * @subpackage Any_To_Lat/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Any_To_Lat
 * @subpackage Any_To_Lat/admin
 * @author     Andrii Haranin <tux255@gmail.com>
 */
class Any_To_Lat_Admin {

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
		 * defined in Any_To_Lat_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Any_To_Lat_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/any-to-lat-admin.css', array(), $this->version, 'all' );

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
		 * defined in Any_To_Lat_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Any_To_Lat_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/any-to-lat-admin.js', array( 'jquery' ), $this->version, false );

	}
  
  /**
   *
   */
  function slug_save_post_callback( $post_ID, $post, $update ) {
    // allow 'publish', 'draft', 'future'
    if ($post->post_type != 'post' || $post->post_status == 'auto-draft')
      return;
    
    // only change slug when the post is created (both dates are equal)
    if ($post->post_date_gmt != $post->post_modified_gmt)
      return;
    
    // use title, since $post->post_name might have unique numbers added
    $new_slug = sanitize_title( $post->post_title, $post_ID );
    $subtitle = sanitize_title( get_field( 'subtitle', $post_ID ), '' );
    if (empty( $subtitle ) || strpos( $new_slug, $subtitle ) !== false)
      return; // No subtitle or already in slug
    
    $new_slug .= '-' . $subtitle;
    if ($new_slug == $post->post_name)
      return; // already set
    
    // unhook this function to prevent infinite looping
    remove_action( 'save_post', 'slug_save_post_callback', 10, 3 );
    // update the post slug (WP handles unique post slug)
    wp_update_post( array(
      'ID' => $post_ID,
      'post_name' => $new_slug
    ));
    // re-hook this function
    add_action( 'save_post', 'slug_save_post_callback', 10, 3 );
  }
}
