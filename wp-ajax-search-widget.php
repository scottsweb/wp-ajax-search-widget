<?php
/*	
Plugin Name: WP Ajax Search Widget
Plugin URI: https://github.com/cftp/wp-ajax-search-widget
Description: Search your WordPress site using this inline ajax search widget
Version: 1.0
Author: Code For The People
Author URI: http://codeforthepeople.com
Text Domain: wpasw
Domain Path: /assets/languages/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Copyright © 2013 Code for the People ltd

                _____________
               /      ____   \
         _____/       \   \   \
        /\    \        \___\   \
       /  \    \                \
      /   /    /          _______\
     /   /    /          \       /
    /   /    /            \     /
    \   \    \ _____    ___\   /
     \   \    /\    \  /       \
      \   \  /  \____\/    _____\
       \   \/        /    /    / \
        \           /____/    /___\
         \                        /
          \______________________/


This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

*/
	
/**
 * wpasw_widget
 *
 * Register the widget
 * 
 * @return void
 */
function wpasw_widget() {
	register_widget('wpasw_widget');
}
add_action('widgets_init', 'wpasw_widget');

class wpasw_widget extends WP_Widget {
	
	static $load_script;

	function wpasw_widget() {
		$widget_ops = array( 'classname' => 'wpasw-widget', 'description' => __('Search form with AJAX results', 'wpasw') );
		$this->WP_Widget( 'wpasw-widget', __('AJAX Search', 'wpasw'), $widget_ops );	

		add_action( 'init', array( $this, 'wpasw_register_script' ) ) ;
		add_action( 'wp_footer', array( $this, 'wpasw_print_script' ) );

		add_action('wp_ajax_wpasw', array( $this, 'ajax') );
		add_action('wp_ajax_nopriv_wpasw', array( $this, 'ajax') );

	}

	function widget($args, $instance) {
		
		extract($args, EXTR_SKIP);
		
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);	
		$username = empty($instance['username']) ? '' : $instance['username'];
		$limit = empty($instance['number']) ? 10 : $instance['number'];

		self::$load_script = true;

		echo $before_widget;
		if (!empty($title)) { echo $before_title . $title . $after_title; };
		
			get_search_form( true );
			?><div class="wpasw-results"></div><?php

		echo $after_widget; 
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => __('Search', 'wpasw'), 'number' => 10 ) );
		$title = esc_attr($instance['title']);
		$number = absint($instance['number']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'wpasw'); ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Results Limit', 'wpasw'); ?>:</label>
			<select id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" class="widefat">
				<option value="-1" <?php selected('-1', $number) ?>><?php _e('All', 'wpasw'); ?></option>
				<option value="5" <?php selected('5', $number) ?>><?php _e('5', 'wpasw'); ?></option>
				<option value="10" <?php selected('10', $number) ?>><?php _e('10', 'wpasw'); ?></option>
				<option value="15" <?php selected('15', $number) ?>><?php _e('15', 'wpasw'); ?></option>
				<option value="20" <?php selected('20', $number) ?>><?php _e('20', 'wpasw'); ?></option>
			</select>
		</p>
		<?php

	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = !absint($new_instance['number']) ? 9 : $new_instance['number'];
		return $instance;
	}

	/**
	 * wpasw_register_script
	 *
	 * Register the JS for ajax request
	 * 
	 * @return void
	 */
	function wpasw_register_script() {
		wp_register_script( 'wpasw', plugins_url('/assets/js/wpasw.js', __FILE__), array('jquery'), '1.0', true);

		wp_localize_script('wpasw','wpasw', array(
			'ajax_url' => add_query_arg(array('action' => 'wpasw','_wpnonce' => wp_create_nonce( 'wpasw' )), untrailingslashit(admin_url('admin-ajax.php'))),  
		));
	}

	/**
	 * wpasw_print_script
	 *
	 * Output JS only when widget in use on page
	 * 
	 * @return void
	 */
	function wpasw_print_script() {
		
		// only load the script if widget is in use
		if ( ! self::$load_script )
			return;

		wp_print_scripts( 'wpasw' );
	}

	/**
	 * ajax
	 *
	 * Handle the search request
	 * 
	 * @return string
	 */
	function ajax() {
				
		// verify the nonce
		if (wp_verify_nonce($_REQUEST['_wpnonce'], 'wpasw')) {
			
			// clean up the query
			$s = trim(stripslashes($_POST['s']));

			// get the settings for this widget instance
			$instance = $this->get_settings();
			if ( array_key_exists( $this->number, $instance ) ) {
				$instance = $instance[$this->number];
			}

			// set the query limit
			$limit = empty($instance['number']) ? 10: $instance['number'];
		
			$query_args = array('s' => $s, 'post_status' => 'publish', 'posts_per_page' => $limit );

			$query = new WP_Query($query_args);

			if ( $query->have_posts() ) : 
				?><ul><?php
				while ( $query->have_posts() ) : $query->the_post();
					// should check for template part here
					?>
					<li <?php post_class(); ?>>
						<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
						<span class="entry-date"><?php the_date(); ?></span>
					</li>
					<?php
				endwhile;
				?></ul><?php
			endif;

			wp_reset_postdata();
		}

		die();		
	}
}

?>