<?php
/**
 * This file contains the icon creation scripts function for the icons plugin
 *
 * @since 1.0.0
 *
 * @package    MP Easy Icons
 * @subpackage Functions
 *
 * @copyright  Copyright (c) 2015, Mint Plugins
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author     Philip Johnston
 */
 
/**
* Shortcode which is used to display the icon
*/
function mp_easy_icons_shortcode( $atts ) {
	global $mp_easy_icons_meta_box;
	$vars =  shortcode_atts( array(
		'icon' => NULL,
		'size' => NULL,
		'color' => NULL,
		'left_space' => NULL,
		'right_space' => NULL,
		'align' => NULL
	), $atts );	
	
	$style_output = NULL;
	
	//Set the size of the icon
	if ( !empty( $vars['size'] ) ){
		$style_output .= 'font-size: ' . $vars['size'] . 'px; ';	
	}
	
	//Set the color of the icon
	if ( !empty( $vars['color'] ) ){
		$style_output .= ' color: ' . $vars['color'] . '; ';	
	}
	
	//Set the space to the left of the icon
	if ( !empty( $vars['left_space'] ) ){
		$style_output .= ' padding-left: ' . $vars['left_space'] . 'px; ';	
	}
	
	//Set the space to the left of the icon
	if ( !empty( $vars['left_space'] ) ){
		$style_output .= ' padding-right: ' . $vars['right_space'] . 'px; ';	
	}
	
	//Set the vertical alignment of the icon
	if ( !empty( $vars['align'] ) ){
		$style_output .= ' vertical-align: ' . $vars['align'] . '; ';	
	}
			
	$icon_html = '<span class="' . $vars['icon'] . '" style="' . $style_output . '"></span>';
		
	//Return the stack HTML output - pass the function the stack id
	return $icon_html;
}
add_shortcode( 'mp_easy_icon', 'mp_easy_icons_shortcode' );

/**
 * Show "Insert Shortcode" above posts
 */
function mp_easy_icons_show_insert_shortcode(){
	
	//Get current page
	$current_page = get_current_screen();
	
	//Only load if we are on an mp_brick page
	if ( $current_page->base != 'post' ){
		return;	
	}
	
	$args = array(
		'shortcode_id' => 'mp_easy_icon',
		'shortcode_title' => __('Icon', 'mp_easy_icons'),
		'shortcode_description' => __( 'Use the form below to insert the shortcode for your Icon:', 'mp_easy_icons' ),
		'shortcode_icon_spot' => true,
		'shortcode_icon_dashicon_class' => 'dashicons-info', //Grab this from https://developer.wordpress.org/resource/dashicons/#info
		'shortcode_options' => array(
			array(
				'option_id' => 'icon',
				'option_title' => __('Icon', 'mp_easy_icons'),
				'option_description' => __( 'Choose the icon', 'mp_easy_icons' ),
				'option_type' => 'iconfontpicker',
				'option_value' => mp_easy_icons_get_font_awesome_icons(),
			),
			array(
				'option_id' => 'size',
				'option_title' => __('Icon Size', 'mp_easy_icons'),
				'option_description' => __( 'Set the size of the icon in Pixels (Leave blank to have it match the font-size of this text area).', 'mp_easy_icons' ),
				'option_type' => 'number',
				'option_value' => ''
			),
			array(
				'option_id' => 'color',
				'option_title' => __( 'Icon Color', 'mp_easy_icons' ),
				'option_description' => __( 'Pick a color for this icon', 'mp_easy_icons' ),
				'option_type' => 'colorpicker',
				'option_value' => '',
			),
			array(
				'option_id' => 'left_space',
				'option_title' => __( 'Space on Left', 'mp_easy_icons' ),
				'option_description' => __( 'How much blank space should there be to the left of the icon?', 'mp_easy_icons' ),
				'option_type' => 'number',
				'option_value' => '',
			),
			array(
				'option_id' => 'right_space',
				'option_title' => __( 'Space on Right', 'mp_easy_icons' ),
				'option_description' => __( 'How much blank space should there be to the right of the icon?', 'mp_easy_icons' ),
				'option_type' => 'number',
				'option_value' => '',
			),
			array(
				'option_id' => 'align',
				'option_title' => __( 'Alignment', 'mp_easy_icons' ),
				'option_description' => __( 'How should this icon align with text on the same line?', 'mp_easy_icons' ),
				'option_type' => 'select',
				'option_value' => array( 
					'bottom' => __( 'Bottom', 'mp_easy_icons' ),
					'middle' => __( 'Middle', 'mp_easy_icons' ),
				),
				
			),
		)
	); 
		
	//Shortcode args filter
	$args = has_filter('mp_easy_icons_insert_shortcode_args') ? apply_filters('mp_easy_icons_insert_shortcode_args', $args) : $args;
	
	new MP_CORE_Shortcode_Insert($args);	
}
add_action('current_screen', 'mp_easy_icons_show_insert_shortcode');