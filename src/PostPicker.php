<?php

namespace Amostajo\Wordpress\PostPickerAddon;

use Amostajo\WPPluginCore\Addon;

/**
 * Post Picker add-on.
 * For Wordpress Plugin or Wordpress Theme templates.
 *
 * @author Alejandro Mostajo
 * @license MIT
 * @package Amostajo\Wordpress\PostPickerAddon
 * @version 1.1
 */
class PostPicker extends Addon
{
    /**
     * Called by Main Plugin/Theme class to include post picker.
     * @since 1.0
     */
    public function post_picker()
    {
        add_action( 'admin_footer', [ &$this, 'footer' ], 10 );
        wp_enqueue_style( 
            'post-picker',
            asset_url( 'build/post-picker.min.css' , __FILE__ ),
            [ 'font-awesome' ],
            '1.0.0'
        );
        wp_enqueue_script( 'post-picker' );
    }

    /**
     * Admin dashboard HOOKS.
     * @since 1.0
     */
    public function on_admin()
    {
        add_action( 'wp_ajax_addon_post_picker', [ &$this, 'post_picker_json' ] );
        add_action( 'admin_init', [ &$this, 'register_dependencies' ] );
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

    /**
     * Registers styles and scripts.
     * @since 1.1
     */
    public function register_dependencies()
    {
        wp_register_style(
            'font-awesome',
            asset_url( 'build/font-awesome.min.css' , __FILE__ ),
            [],
            '4.4.0'
        );
        wp_register_style(
            'post-picker',
            asset_url( 'build/post-picker.min.css' , __FILE__ ),
            [ 'font-awesome' ],
            '1.0.0'
        );
        wp_register_script(
            'vue-post-picker',
            asset_url( 'build/vue-post-picker.min.js' , __FILE__ ),
            [],
            '1.0.0',
            true
        );
        wp_register_script(
            'post-picker',
            asset_url( 'build/post-picker.min.js' , __FILE__ ),
            [ 'vue-post-picker', 'jquery' ],
            '1.0.0',
            true
        );
    }
}
