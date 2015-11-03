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
        add_action( 'admin_footer', [ &$this, 'footer' ], 10 );
        wp_enqueue_style(
            'post-picker',
            plugins_url( 'build/post-picker.min.css' , __FILE__ ),
            [],
            '1.0.0'
        );
        wp_enqueue_style(
            'font-awesome',
            plugins_url( '../vendor/bower_components/font-awesome/css/font-awesome.min.css' , __FILE__ ),
            [],
            '4.4.0'
        );
        wp_enqueue_script(
            'vue',
            plugins_url( '../vendor/bower_components/vue/dist/vue.min.js' , __FILE__ ),
            [],
            '1.0.1',
            true
        );
        wp_enqueue_script(
            'vue-resource',
            plugins_url( '../vendor/bower_components/vue-resource/dist/vue-resource.min.js' , __FILE__ ),
            [ 'vue' ],
            '0.1.16',
            true
        );
        wp_enqueue_script(
            'post-picker',
            plugins_url( 'build/post-picker.min.js' , __FILE__ ),
            [ 'vue-resource', 'jquery' ],
            '1.0.0',
            true
        );
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
