<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/bdeleasa/lazy-loading
 * @since      1.0.0
 *
 * @package    Lazy_Loading
 * @subpackage Lazy_Loading/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Lazy_Loading
 * @subpackage Lazy_Loading/public
 * @author     Brianna Deleasa <me@briannadeleasa.com>
 */
class Lazy_Loading_Public {

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
	public function enqueue_scripts() {

		wp_enqueue_script( 'jquery.lazyload' , plugin_dir_url( __FILE__ ) . 'js/jquery.lazyload.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'lazy-loading' , plugin_dir_url( __FILE__ ) . 'js/scripts.min.js', array( 'jquery' ), $this->version, true );

	}


	/**
	 * Add all of the actions and filters that enable the lazyloading
	 *
	 * @param none
	 * @return none
	 */
	public static function enable_lazy_loading() {

		add_filter( 'the_content', 'Lazy_Loading_Public::enable_lazyloading_the_content' );
		add_filter( 'post_thumbnail_html', 'Lazy_Loading_Public::enable_lazyloading_post_thumbnail_html', 10, 999 );
		add_filter( 'wp_get_attachment_image_attributes',  'Lazy_Loading_Public::alter_attachment_image_attributes', 99 );
		add_filter( 'widget_text',  'Lazy_Loading_Public::alter_widget_text' );

	}


	/**
	 * Remove all of the actions and filters that enable lazy loading
	 *
	 * @param none
	 * @return none
	 */
	public static function disable_lazy_loading() {

		remove_filter( 'the_content', 'Lazy_Loading_Public::enable_lazyloading_the_content' );
		remove_filter( 'post_thumbnail_html',  'Lazy_Loading_Public::enable_lazyloading_post_thumbnail_html', 10, 999 );
		remove_filter( 'wp_get_attachment_image_attributes',   'Lazy_Loading_Public::alter_attachment_image_attributes', 99 );
		remove_filter( 'widget_text', 'Lazy_Loading_Public::alter_widget_text' );

	}


	/**
	 * Modifies the content to enable lazy loading for <img> tags.
	 *
	 * @uses lazy_loading_images_modify_img_tags()
	 * @param $content
	 * @return string
	 */
	function enable_lazyloading_the_content( $content ) {
		return lazy_loading_images_modify_img_tags($content);
	}

	/**
	 * Modifies the post thumbnail html to enable lazy loading for <img> tags.
	 *
	 * @uses lazy_loading_images_modify_img_tags()
	 * @param $html
	 * @param $post_id
	 * @param $post_image_id &nbsp;
	 * @return string
	 */
	function enable_lazyloading_post_thumbnail_html( $html, $post_id, $post_image_id ) {
		return lazy_loading_images_modify_img_tags($html);
	}

	/**
	 * Filters the wp_get_attachment_image function to enable lazy loading on
	 * images.
	 *
	 * @param $attr
	 * @return mixed
	 */
	function alter_attachment_image_attributes($attr) {
		return lazy_loading_images_modify_array_attributes($attr);
	}

	/**
	 * Filters any widget content to enable lazy loading for <img> tags.
	 *
	 * @param $content
	 * @return string
	 */
	function alter_widget_text($content) {
		return lazy_loading_images_modify_img_tags($content);
	}

}
