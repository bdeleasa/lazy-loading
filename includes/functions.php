<?php

/**
 * Custom functions that are used throughout this plugin
 *
 * @link       https://github.com/bdeleasa/lazy-loading
 * @since      1.0.0
 *
 * @package    Lazy_Loading
 * @subpackage Lazy_Loading/public
 */


if ( !function_exists('lazy_loading_images_modify_img_tags') ):
/**
 * Takes an HTML string and modifies any <img> tags within it by:
 * - Adding the class 'lazy'
 * - Removing the 'src' attribute
 * - Adding the 'data-original' attribute using the original 'src' value
 *
 * @param $content
 * @return string
 */
function lazy_loading_images_modify_img_tags( $content ) {

	$content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");

	// Get out if we don't have any content
	if ( empty($content) )
		return $content;

	$document = new DOMDocument();
	libxml_use_internal_errors(true);
	$document->loadHTML(utf8_decode($content));

	// Grab all image tags
	$imgs = $document->getElementsByTagName('img');

	// Loop through all image tags
	foreach ($imgs as $img) {

		$existing_class = $img->getAttribute('class');  // Store existing class (if the image has one applied)
		$src = $img->getAttribute('src');               // Store src attribute value
		$data_original = $img->getAttribute('data-original');

		// Add 'lazy' class and the existing class(es) to the image
		if ( ! stristr($existing_class, 'lazy') ) {
			$img->setAttribute( 'class', "lazy $existing_class" );
		}

		// Add a 'data-original' attribute with our 'src' attribute value
		if ( empty($data_original) ){
			$img->setAttribute( 'data-original', $src );
		}

		// Replace our src attribute with the placeholder image
		$img->setAttribute( 'src', LLI_PLUGIN_DIR_URL . 'public/images/placeholder.png' );

	}

	// This removes the <doctype>, <body>, and <html> tags that are automatically inserted.  We don't need them.
	$html = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $document->saveHTML()));
	return $html;

}
endif;


/**
 * Modifies the array of HTML attributes passed in to enable lazy loading
 * @param $attr
 * @return mixed
 */
function lazy_loading_images_modify_array_attributes( $attr ) {

	$placeholder = LLI_PLUGIN_DIR_URL . 'public/images/placeholder.png';

	// Either append a new class or set the class attribute
	if ( !empty($attr['class']) ) {
		// If the class hasn't been added already
		if ( !stristr($attr['class'], 'lazy') ) {
			$attr['class'] .= ' lazy';
		}
	}
	else {
		// If the class hasn't been added already
		if ( !stristr($attr['class'], 'lazy') ) {
			$attr['class'] = 'lazy';
		}
	}

	// Set a data-original attribute
	if ( empty($attr['data-original']) ) {
		$attr['data-original'] = $attr['src'];
		$attr['src'] = $placeholder;
	}

	// Return our new attributes
	return $attr;

}


/**
 * Enable Lazy Loading
 */
function lazy_loading_images_enable() {
	Lazy_Loading_Public::enable_lazy_loading();
}

/**
 * Enable Lazy Loading
 */
function lazy_loading_images_disable() {
	Lazy_Loading_Public::disable_lazy_loading();
}