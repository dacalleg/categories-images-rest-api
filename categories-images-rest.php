<?php
/**
 * Plugin Name:     Categories Images Rest
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     Add Images Category in API Rest
 * Author:          Daniele Callegaro
 * Author URI:      YOUR SITE HERE
 * Text Domain:     categories-images-rest
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Categories_Images_Rest
 */
new CategoriesImagesRestPlugin();

class CategoriesImagesRestPlugin {
    public function __construct() {
        // Add Custom Data
        add_action('rest_api_init', array( $this, 'add_custom_data' ) );
    }
    function add_custom_data() {
        // Register the category type
        register_rest_field('category', 'img', array(
                'get_callback' => array( $this, 'get_custom_data' ),
                'update_callback' => array( $this, 'update_custom_data' ),
                'schema' => array(
                    'description' => 'Category Image',
                    'type' => 'string',
                    'context' => array('view', 'edit')
                )
            )
        );
    }
    /**
     * Handler for getting custom data.
     *
     */
    function get_custom_data($object, $field_name, $request) {
        $img = z_taxonomy_image_url($object['id']);
        return $img ? $img : "";
    }
    /**
     * Handler for updating custom data.
     */
    function update_custom_data($value, $post, $field_name) {
        if (!$value || !is_string($value)) {
            return;
        }
        return update_post_meta($post->ID, $field_name, strip_tags($value));
    }
}