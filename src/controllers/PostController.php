<?php

namespace Amostajo\Wordpress\PostPickerAddon\Controllers;

use WP_Query;
use Exception;
use Amostajo\WPPluginCore\Cache;
use Amostajo\WPPluginCore\Log;
use Amostajo\Wordpress\PostPickerAddon\Models\Post;
use Amostajo\LightweightMVC\Collection;
use Amostajo\LightweightMVC\Controller;
use Amostajo\LightweightMVC\Request;

/**
 * Post Controller handles all functionality related to posts.
 *
 * @author Alejandro Mostajo
 * @license MIT
 * @package Amostajo\Wordpress\PostPickerAddon
 * @version 1.1
 */
class PostController extends Controller
{
	/**
	 * Displayes queried POSTS in JSON format.
	 * @since 1.0
	 * @since 1.1 Added try/catch and log.
	 */
	public function json()
	{
		$posts = array();
		try {
			$filter = [
				'post_type'      => Request::input( 'type', 'post' ),
				'post_status'    => Request::input( 'status', 'publish' ),
				'posts_per_page' => Request::input( 'limit', 16 ),
			];
			// Check for additional filter options
			// Categories
			$input = Request::input( 'categories', false );
			if ( $input ) $filter['category_name'] = $input;
			// Tags
			$input = Request::input( 'tags', false );
			if ( $input ) $filter['tag'] = $input;
			// Tags
			$input = Request::input( 'search', false );
			if ( $input ) $filter['s'] = $input;

			// Query
			$query = new WP_Query( $filter );
			while ( $query->have_posts() ) {
				$query->the_post();
				$posts[] = Cache::remember(
					'addon_postpicker_post_' . get_the_ID(),
					15,
					function() {
						$model = new Post();
						return $model->from_post( get_post() )->to_array();
					}
				);
			}
		} catch ( Exception $e ) {
			Log::error( $e );
		}
		// Display
		header( 'Content-Type: application/json' );
		echo json_encode( $posts );
		die;
	}
}