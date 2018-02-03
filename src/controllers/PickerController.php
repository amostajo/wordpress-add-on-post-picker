<?php

namespace Amostajo\Wordpress\PostPickerAddon\Controllers;

use WPMVC\MVC\Controller;

/**
 * Picker Controller handles all functionality related to picker.
 *
 * @author Alejandro Mostajo
 * @license MIT
 * @package Amostajo\Wordpress\PostPickerAddon
 * @version 2.0.0
 */
class PickerController extends Controller
{
    /**
     * Displayes picker modal.
     * @since 1.0
     * @since 2.0.0 Removed variable assignment.
     */
	public function modal()
	{
        return $this->view->get( 'addons.postpicker.modal', [
			'title'	=> __( 'Post Picker', 'PostPickerAddon' ),
			'types' => get_post_types( [
						'public' => true,
					], 'objects' ),
		] );
	}
}
