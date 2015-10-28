<?php

namespace Amostajo\Wordpress\PostPickerAddon\Controllers;

use Amostajo\LightweightMVC\Controller;

/**
 * Picker Controller handles all functionality related to picker.
 *
 * @author Alejandro Mostajo
 * @license MIT
 * @package Amostajo\Wordpress\PostPickerAddon
 * @version 1.0
 */
class PickerController extends Controller
{
    /**
     * Displayes picker modal.
     * @since 1.0
     */
	public function modal()
	{
        return $this->view->get( 'addons.postpicker.modal', [
			'title'	=> __( 'Post Picker', 'PostPickerAddon' ),
		] );
	}
}
