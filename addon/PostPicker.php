<?php

namespace Amostajo\Wordpress\PostPickerAddon;

use WPMVC\Addon;

/**
 * Post Picker add-on.
 * For Wordpress Plugin or Wordpress Theme templates.
 *
 * @author Alejandro Mostajo
 * @license MIT
 * @package Amostajo\Wordpress\PostPickerAddon
 * @version 2.1.0
 */
class PostPicker extends Addon
{
    /**
     * Called by Main Plugin/Theme class to include post picker.
     * @since 1.0
     * @since 2.0.0 Fixes assets url call.
     * @since 2.1.0 New addon template support.
     */
    public function post_picker()
    {
        add_action( 'admin_footer', [ &$this, 'footer' ], 10 );
        wp_enqueue_style( 
            'post-picker',
            addon_assets_url( 'build/post-picker.min.css' , __FILE__ ),
            [ 'font-awesome' ],
            '2.1.0'
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
     * @since 2.0.0 Fixes assets url call.
     * @since 2.1.0 New addon template support.
     */
    public function register_dependencies()
    {
        wp_register_style(
            'font-awesome',
            addon_assets_url( 'build/font-awesome.min.css' , __FILE__ ),
            [],
            '4.4.0'
        );
        wp_register_style(
            'post-picker',
            addon_assets_url( 'build/post-picker.min.css' , __FILE__ ),
            [ 'font-awesome' ],
            '2.1.0'
        );
        wp_register_script(
            'vue-post-picker',
            addon_assets_url( 'build/vue-post-picker.min.js' , __FILE__ ),
            [],
            '1.0.1',
            true
        );
        wp_register_script(
            'post-picker',
            addon_assets_url( 'build/post-picker.min.js' , __FILE__ ),
            [ 'vue-post-picker', 'jquery' ],
            '2.1.0',
            true
        );
    }
}
