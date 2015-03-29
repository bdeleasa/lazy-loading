# Lazy Loading - Wordpress Plugin

Uses the [`Lazy Load Plugin`] (http://www.appelsiini.net/projects/lazyload) by Mika Tuupola to enable lazy loading for most images displayed on your website. It'll lazy load any images inserted via the WYSIWYG editor as well as any featured images on standard posts, pages, and custom post types.  No configuration is necessary.  Just install, activate, and go!

This plugin automatically adds the necessary HTML attributes and classes to images outputted using the any of the following functions:

* get_the_content/the_content
* get_the_post_thumbnail/the_post_thumbnail
* wp_get_attachment_image