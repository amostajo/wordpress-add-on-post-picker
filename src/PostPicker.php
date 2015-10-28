<?php

namespace Amostajo\Wordpress\PostPickerAddon;

use ReflectionClass;
use Amostajo\WPPluginCore\Abstracts\Addon;

/**
 * Post Picker add-on.
 * For Wordpress Plugin or Wordpress Theme templates.
 *
 * @author Alejandro Mostajo
 * @license MIT
 * @package Amostajo\Wordpress\PostPickerAddon
 * @version 1.0
 */
class PostPicker extends Addon
{
    /**
     * Called by Main Plugin/Theme class to include post picker.
     * @since 1.0
     */
    public function post_picker()
    {
        wp_enqueue_style(
            'post-picker',
            plugins_url( 'css/post-picker.css' , __FILE__ ),
            [],
            '1.0.0'
        );
        add_action( 'admin_footer', [ &$this, 'footer' ], 50 );
    }

    /**
     * Admin dashboard HOOKS.
     * @since 1.0
     */
    public function on_admin()
    {
        add_action( 'wp_ajax_addon_post_picker', [ &$this, 'post_picker_json' ] );
    }

    /**
     * Displayes queried POSTS in JSON format.
     * @since 1.0
     */
    public function post_picker_json()
    {
        $this->mvc->call( 'PostController@json' );
    }

    /**
     * Injects modal in footer.
     * @since 1.0
     */
    public function footer()
    {
        $this->mvc->call( 'PickerController@modal' );
    }
}
